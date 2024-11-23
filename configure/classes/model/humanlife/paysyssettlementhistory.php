<?php
/**
 * Paysys決済履歴テーブルのモデルクラス
 * @author m.ishikawa@humanlife.co.jp
 */

class Model_HumanLife_PaysysSettlementHistory extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string  Paysys決済テーブル名
     */
    protected static $_table_name = 'paysys_settlement_history';

    /**
     * Paysysのステータスを更新する
     *
     * @param string $paysys_id
     * @param int    $payment_status
     * @param int    $login_user_id
     *               ['カラム名' => '値']形式の連想配列
     * @return number レコード数
     */
    public function update_payment_status($paysys_id, $payment_status, $login_user_id)
    {
        $update_columns = [
            'payment_status' => $payment_status,
            'update_user'    => $login_user_id,
        ];
        $result = DB::update(self::$_table_name)->set($update_columns)
            ->where('paysys_id', $paysys_id)
            ->execute();
        return $result;
    }


    /**
     * 指定されたパラメータでPaysys決済履歴を登録する
     *
     * @param  array $param 各カラムをキーに持つ連想配列型の登録データ
     * @param  int   $login_user_id ログインユーザーID
     * @return int
     */
    public function regist_paysys_settlement_history(array $param, $login_user_id) {
        $query = <<<SQL
INSERT INTO
    paysys_settlement_history
(
    business_id,
    user_id,
    bill_id,
    invoice_id,
    order_id,
    paysys_order_id,
    order_datetime,
    amount,
    delivery_type,
    url,
    url_date_of_expiry,
    payment_deadline,
    api_status,
    payment_status,
    settlement_type,
    message,
    create_user,
    update_user
)
VALUES
(
    :business_id,
    :user_id,
    :bill_id,
    :invoice_id,
    :order_id,
    :paysys_order_id,
    :order_datetime,
    :amount,
    :delivery_type,
    :url,
    :url_date_of_expiry,
    :payment_deadline,
    :api_status,
    :payment_status,
    :settlement_type,
    :message,
    :create_user,
    :update_user
)
SQL;

        $param['create_user'] = $login_user_id;
        $param['update_user'] = $login_user_id;
        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * オーダーIDを元にレコードを取得する
     *
     * @param  int   $order_id
     * @return array 取得結果
     */
    public function get_by_order_id($order_id)
    {
        $query = <<<SQL
        SELECT *
        FROM paysys_settlement_history
        WHERE order_id = :order_id
SQL;

        $bind_params = [];
        $bind_params['order_id'] = $order_id;
        $result = DB::query($query)->parameters($bind_params)
                ->execute()
                ->as_array();

        return $result;
    }

    /**
     * 請求書番号を元にレコードを取得する
     *
     * @param  int   $bill_id
     * @return array 取得結果
     */
    public function get_by_bill_id($bill_id)
    {
        $query = <<<SQL
        SELECT *
        FROM paysys_settlement_history
        WHERE bill_id = :bill_id
        ORDER BY order_datetime DESC
SQL;

        $bind_params = [];
        $bind_params['bill_id'] = $bill_id;
        $result = DB::query($query)->parameters($bind_params)
                ->execute()
                ->as_array();

        return $result;
    }

    /**
     * 請求書番号と支払いステータスを元に最新のレコードを1件取得する
     *
     * @param  int   $bill_id
     * @param  int   $payment_status
     * @return array 取得結果
     */
    public function get_latest_record_by_bill_id($bill_id, $payment_status)
    {
        $query = <<<SQL
        SELECT *
        FROM paysys_settlement_history
        WHERE bill_id = :bill_id AND
              payment_status =:payment_status
        ORDER BY order_datetime DESC
SQL;

        $bind_params = [];
        $bind_params['bill_id'] = $bill_id;
        $bind_params['payment_status'] = $payment_status;
        $result = DB::query($query)->parameters($bind_params)
                ->execute()
                ->current();

        return $result;
    }
}
