<?php

/**
 * インボイス対応トランザクション生成関連のヘルパークラス
 *
 * @author a.kurabayashi@humanlife.co.jp
 */
class Helper_Transaction {

    /**
     * transaction_idを発行
     *
     * @return int トランザクションID
     */
    public static function publish_transaction_id() {
        $logic_transaction_id_management = new Logic_HumanLife_TransactionIdManagement();
        // transaction_id_managementでtransaction_idを発行
        return $logic_transaction_id_management->publish_id(BUSINESS_ID);
    }

    /**
     * インボイス対応のトランザクションを生成しトランザクションのIDを返す
     *
     * @param string   $action             請求内容
     * @param int      $transaction_id     トランザクションID
     * @param array    $invoice_id_list    請求番号
     * @param int      $invoice_status     請求ステータス
     * @param int      $settlement_type    支払方法
     * @param array    $detail             請求詳細
     * @param datetime $cancel_datetime    請求キャンセル日時
     */
    public static function regist_invoice_transaction($action, $transaction_id, $invoice_id_list, $invoice_status, $settlement_type, $detail=null, $cancel_datetime=null) {

        $logic_transaction = new Logic_HumanLife_Transaction();
        $logic_transaction_history = new Logic_HumanLife_TransactionHistory();
        $logic_transaction_invoice = new Logic_HumanLife_TransactionInvoice();

        // 請求情報から決済合計金額を計算して取得
        $transaction_price_info = self::get_transaction_price($invoice_id_list);

        $now_timestamp = time();
        $current_datetime = date('Y-m-d H:i:s', $now_timestamp);
        try {
            // transaction登録
            $transaction_params = [
                'transaction_id'    => $transaction_id,
                'user_id'           => $transaction_price_info['user_id'],
                'status'            => $invoice_status,
                'cancel_datetime'   => $cancel_datetime,
                'settlement_type'   => $settlement_type,
                'price_without_tax' => $transaction_price_info['price_without_tax'],
                'price_with_tax'    => $transaction_price_info['price_with_tax'],
                'tax_detail'        => $transaction_price_info['price_with_tax_detail'] ? json_encode($transaction_price_info['price_with_tax_detail']) : '{}',
                'detail'            => json_encode($detail),
                'create_datetime'   => $current_datetime,
                'create_user'       => SYSTEM_USER_NAME,
                'update_datetime'   => $current_datetime,
                'update_user'       => SYSTEM_USER_NAME,
            ];
            $logic_transaction->insert($transaction_params);

            // transaction_history登録
            $transaction_history_params = [
                'transaction_id'    => $transaction_id,
                'action'            => $action,
                'action_datetime'   => $current_datetime,
                'status'            => $invoice_status,
                'action_user'       => SYSTEM_USER_NAME,
                'cancel_datetime'   => $cancel_datetime,
                'settlement_type'   => $settlement_type,
                'price_without_tax' => $transaction_price_info['price_without_tax'],
                'price_with_tax'    => $transaction_price_info['price_with_tax'],
                'tax_detail'        => $transaction_price_info['price_with_tax_detail'] ? json_encode($transaction_price_info['price_with_tax_detail']) : '{}',
                'create_datetime'   => $current_datetime,
                'create_user'       => SYSTEM_USER_NAME,
                'update_datetime'   => $current_datetime,
                'update_user'       => SYSTEM_USER_NAME,
            ];
            $logic_transaction_history->insert($transaction_history_params);

            // invoice_idの分だけtransaction_invoiceを登録
            foreach ($invoice_id_list as $invoice_id) {
                $transaction_invoice_params = [
                    'transaction_id'  => $transaction_id,
                    'invoice_id'      => $invoice_id,
                    'create_datetime' => $current_datetime,
                    'create_user'     => SYSTEM_USER_NAME,
                    'update_datetime' => $current_datetime,
                    'update_user'     => SYSTEM_USER_NAME,
                ];
                $logic_transaction_invoice->insert($transaction_invoice_params);
            }
        } catch (Exception $e) {
            // 登録処理に失敗した場合
            Log::application()->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * インボイス対応のトランザクションを生成しトランザクションのIDを返す
     *
     * @param string   $action             請求内容
     * @param int      $transaction_id     トランザクションID
     * @param int      $invoice_status     請求ステータス
     * @param int      $settlement_type    支払方法
     * @param datetime $cancel_datetime    請求キャンセル日時
     */
    public static function update_cancel_invoice_transaction($action, $transaction_id, $invoice_status, $settlement_type, $cancel_datetime) {

        $logic_transaction = new Logic_HumanLife_Transaction();
        $logic_transaction_history = new Logic_HumanLife_TransactionHistory();
        $logic_transaction_invoice = new Logic_HumanLife_TransactionInvoice();

        // 請求情報から決済合計金額を計算して取得
        $invoice_id_list = $logic_transaction_invoice->get_transaction_invoice_id_by_transaction_id($transaction_id);
        $transaction_price_info = self::get_transaction_price($invoice_id_list);

        $now_timestamp = time();
        $current_datetime = date('Y-m-d H:i:s', $now_timestamp);
        try {
            // transaction情報取得
            $transaction_info = $logic_transaction->get_transaction_info_by_transaction_id($transaction_id);

            // transaction更新情報設定
            $update_transaction_params = [
                'transaction_id'    => $transaction_id,
                'status'            => INVOICE_STATUS_VALUE_LIST['CANCEL_COMP'],
                'settlement_type'   => $settlement_type,
                'cancel_datetime'   => $cancel_datetime,
                'price_without_tax' => $transaction_price_info['price_without_tax'],
                'price_with_tax'    => $transaction_price_info['price_with_tax'],
                'tax_detail'        => json_encode($transaction_price_info['price_with_tax_detail']),
            ];

            // transaction情報更新
            $logic_transaction->update_transaction_info($update_transaction_params);

            // transaction_history登録
            $transaction_history_params = [
                'transaction_id'         => $transaction_id,
                'action'                 => $action,
                'action_datetime'        => $current_datetime,
                'status'                 => $invoice_status,
                'action_user'            => SYSTEM_USER_NAME,
                'cancel_datetime'        => $cancel_datetime,
                'settlement_type'        => $settlement_type,
                'price_without_tax'      => $transaction_price_info['price_without_tax'],
                'price_with_tax'         => $transaction_price_info['price_with_tax'],
                'price_without_tax_diff' => $transaction_info['price_without_tax'] - $transaction_price_info['price_without_tax'],
                'price_with_tax_diff'    => $transaction_info['price_with_tax'] - $transaction_price_info['price_with_tax'],
                'tax_detail'             => $transaction_price_info['price_with_tax_detail'] ? json_encode($transaction_price_info['price_with_tax_detail']) : '{}',
                'create_datetime'        => $current_datetime,
                'create_user'            => SYSTEM_USER_NAME,
                'update_datetime'        => $current_datetime,
                'update_user'            => SYSTEM_USER_NAME,
            ];
            $logic_transaction_history->insert($transaction_history_params);
        } catch (Exception $e) {
            // 登録処理に失敗した場合
            Log::application()->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * 請求番号の配列から課税非課税の決済合計金額と各税率毎の消費税を集計して取得する
     *
     * @param array  $invoice_id_list 請求番号
     * @return array
     */
    public static function get_transaction_price($invoice_id_list) {
        $logic_invoice_result = new Logic_HumanLife_InvoiceResult();

        $price_info_list = [];        // 請求実績取得
        $invoice_result_list = $logic_invoice_result->get_invoice_data_by_invoice_id_list(BUSINESS_ID, $invoice_id_list);

        foreach ($invoice_result_list as $invoice_result_info) {
            if ($invoice_result_info['invoice_status'] != INVOICE_STATUS_VALUE_LIST['CANCEL_COMP']) {
                $tax_price = $invoice_result_info['tax_type'] === (string)TAX_TYPE_EXEMPT ?  0 : $invoice_result_info['tax_price'];
                $price_info_list[] = [
                    'price_without_tax' => $invoice_result_info['amount'] - $tax_price,
                    'tax_rate'          => $invoice_result_info['tax_rate'],
                ];
            }
        }
        $tax_sums = [];
        foreach ($price_info_list as $price_info) {
            $price_without_tax = $price_info['price_without_tax'];
            $tax_rate = (int)$price_info['tax_rate'];
            if (!isset($tax_sums[$tax_rate])) {
                $tax_sums[$tax_rate] = 0;
            }
            $tax_sums[$tax_rate] += $price_without_tax;
        }
        $price_with_tax_detail = [];
        $transaction_price_without_tax = 0; //決済合計金額(税抜き)
        $transaction_price_with_tax = 0;    //決済合計金額(税込み)
        foreach ($tax_sums as $tax_rate => $total_price_without_tax) {
            $transaction_price_without_tax += $total_price_without_tax;
            $tax_amount = $total_price_without_tax * ($tax_rate / 100);
        
            $rounded_tax_amount = floor($tax_amount);
        
            $price_with_tax = $total_price_without_tax + $rounded_tax_amount;
        
            $transaction_price_with_tax += $price_with_tax;
            if ($tax_rate > 0) {
                $price_with_tax_detail[$tax_rate] = $rounded_tax_amount;
            }
        }

        return [
            'user_id'               => $invoice_result_list[0]['user_id'], // 請求の顧客ID
            'price_without_tax'     => $transaction_price_without_tax,     // 決済合計金額(課税)
            'price_with_tax'        => $transaction_price_with_tax,        // 金決済合計金額(非課税)
            'price_with_tax_detail' => $price_with_tax_detail,             // 消費税率毎の消費税の合計
        ];
    }
}
