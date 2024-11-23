<?php

/**
 * 請求実績テーブルのモデルクラス
 *
 * @author sakairi@liz-inc.co.jp
 */

class Model_HumanLife_InvoiceResult extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string  請求予定テーブル名
     */
    protected static $_table_name = 'invoice_result';

    /**
     * レコードをINSERTする
     *
     * @param array $pairs
     * @return number レコード数
     */
    public function insert($pairs) {
        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }

    /**
     * 指定されたパラメータで請求実績を登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_invoice_result(array $param) {
        $query = <<<SQL
INSERT INTO
    invoice_result
(
    `business_id`,
    `invoice_id`,
    `user_id`,
    `company_id`,
    `user_name`,
    `user_type`,
    `invoice_type`,
    `contract_id`,
    `contract_child_id`,
    `result_child_id`,
    `service_use_date`,
    `invoice_result_datetime`,
    `amount`,
    `tax_price`,
    `tax_type`,
    `tax_rate`,
    `settlement_type`,
    `invoice_status`,
    `create_user`,
    `update_user`,
    `entry_id`,
    `entry_child_id`
)
VALUES
(
    :business_id,
    :invoice_id,
    :user_id,
    :company_id,
    :user_name,
    :user_type,
    :invoice_type,
    :contract_id,
    :contract_child_id,
    :schedule_child_id,
    :service_use_date,
    :invoice_schedule_datetime,
    :amount,
    :tax_price,
    :tax_type,
    :tax_rate,
    :settlement_type,
    :invoice_status,
    :create_user,
    :update_user,
    :entry_id,
    :entry_child_id
)
SQL;

        $param['create_user'] = SYSTEM_USER_NAME;
        $param['update_user'] = SYSTEM_USER_NAME;

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * 指定されたパラメータでGMOオーダーID・請求実績リレーションを登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_rel_invoice_gmo_order(array $param) {
        $query = <<<SQL
INSERT INTO
    rel_gmo_order_id_management_invoice_result
(
    `order_id`,
    `business_id`,
    `invoice_id`,
    `create_user`,
    `update_user`
)
VALUES
(
    :order_id,
    :business_id,
    :invoice_id,
    :create_user,
    :update_user
)
SQL;

        $param['create_user'] = SYSTEM_USER_NAME;
        $param['update_user'] = SYSTEM_USER_NAME;

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * 指定されたパラメータで請求書・請求実績リレーションを登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_rel_bill_invoice_result(array $param) {
        $query = <<<SQL
INSERT INTO
    rel_bill_invoice_result
(
    `bill_id`,
    `business_id`,
    `invoice_id`,
    `create_user`,
    `update_user`
)
VALUES
(
    :bill_id,
    :business_id,
    :invoice_id,
    :create_user,
    :update_user
)
SQL;

        $param['create_user'] = SYSTEM_USER_NAME;
        $param['update_user'] = SYSTEM_USER_NAME;

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * 指定された請求予定プランを請求実績プランに登録する
     *
     * @param integer $business_id 事業者ID
     * @param integer $invoice_id  請求明細番号
     * @return integer
     */
    public function regist_invoice_result_plan($business_id, $invoice_id) {
        $query = <<<SQL
INSERT INTO
    invoice_result_plan
(
    `business_id`,
    `invoice_id`,
    `plan_id`,
    `name`,
    `price`,
    `tax_type`,
    `billing_type`,
    `create_user`,
    `update_user`
)
SELECT
    business_id,
    invoice_id,
    plan_id,
    name,
    price,
    tax_type,
    billing_type,
    :create_user,
    :update_user
FROM
    invoice_schedule_plan
WHERE
    business_id = :business_id
AND
    invoice_id = :invoice_id
SQL;

        $param = [
            'business_id' => $business_id,
            'invoice_id'  => $invoice_id,
            'create_user' => SYSTEM_USER_NAME,
            'update_user' => SYSTEM_USER_NAME,
        ];

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * 指定された請求予定オプションを請求実績オプションに登録する
     *
     * @param integer $business_id 事業者ID
     * @param integer $invoice_id  請求明細番号
     * @return integer
     */
    public function regist_invoice_result_option($business_id, $invoice_id) {
        $query = <<<SQL
INSERT INTO
    invoice_result_option
(
    `business_id`,
    `invoice_id`,
    `option_id`,
    `name`,
    `price`,
    `tax_type`,
    `billing_type`,
    `option_type`,
    `create_user`,
    `update_user`
)
SELECT
    business_id,
    invoice_id,
    option_id,
    name,
    price,
    tax_type,
    billing_type,
    option_type,
    :create_user,
    :update_user
FROM
    invoice_schedule_option
WHERE
    business_id = :business_id
AND
    invoice_id = :invoice_id
SQL;

        $param = [
            'business_id' => $business_id,
            'invoice_id'  => $invoice_id,
            'create_user' => SYSTEM_USER_NAME,
            'update_user' => SYSTEM_USER_NAME,
        ];

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * 指定された請求予定プラン初期費用を請求実績プラン初期費用に登録する
     *
     * @param integer $business_id 事業者ID
     * @param integer $invoice_id  請求明細番号
     * @return integer
     */
    public function regist_invoice_result_plan_init($business_id, $invoice_id) {
        $query = <<<SQL
INSERT INTO
    invoice_result_plan_init
(
    `business_id`,
    `invoice_id`,
    `plan_init_id`,
    `name`,
    `price`,
    `tax_type`,
    `create_user`,
    `update_user`
)
SELECT
    business_id,
    invoice_id,
    plan_init_id,
    name,
    price,
    tax_type,
    :create_user,
    :update_user
FROM
    invoice_schedule_plan_init
WHERE
    business_id = :business_id
AND
    invoice_id = :invoice_id
SQL;

        $param = [
            'business_id' => $business_id,
            'invoice_id'  => $invoice_id,
            'create_user' => SYSTEM_USER_NAME,
            'update_user' => SYSTEM_USER_NAME,
        ];

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * 指定された請求予定端末初期費用を請求実績端末初期費用に登録する
     *
     * @param integer $business_id 事業者ID
     * @param integer $invoice_id  請求明細番号
     * @return integer
     */
    public function regist_invoice_result_device_init($business_id, $invoice_id) {
        $query = <<<SQL
INSERT INTO
    invoice_result_device_init
(
    `business_id`,
    `invoice_id`,
    `device_init_id`,
    `name`,
    `price`,
    `tax_type`,
    `create_user`,
    `update_user`
)
SELECT
    business_id,
    invoice_id,
    device_init_id,
    name,
    price,
    tax_type,
    :create_user,
    :update_user
FROM
    invoice_schedule_device_init
WHERE
    business_id = :business_id
AND
    invoice_id = :invoice_id
SQL;

        $param = [
            'business_id' => $business_id,
            'invoice_id'  => $invoice_id,
            'create_user' => SYSTEM_USER_NAME,
            'update_user' => SYSTEM_USER_NAME,
        ];

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * 指定された請求予定調整金を請求実績調整金に登録する
     *
     * @param integer $business_id 事業者ID
     * @param integer $invoice_id  請求明細番号
     * @return integer
     */
    public function regist_invoice_result_adjustment_money($business_id, $invoice_id) {
        $query = <<<SQL
INSERT INTO
    invoice_result_adjustment_money
(
    `business_id`,
    `invoice_id`,
    `adjustment_money_id`,
    `type`,
    `name`,
    `price`,
    `tax_type`,
    `bill_datetime`,
    `create_user`,
    `update_user`
)
SELECT
    business_id,
    invoice_id,
    adjustment_money_id,
    type,
    name,
    price,
    tax_type,
    bill_datetime,
    :create_user,
    :update_user
FROM
    invoice_schedule_adjustment_money
WHERE
    business_id = :business_id
AND
    invoice_id = :invoice_id
SQL;

        $param = [
            'business_id' => $business_id,
            'invoice_id'  => $invoice_id,
            'create_user' => SYSTEM_USER_NAME,
            'update_user' => SYSTEM_USER_NAME,
        ];

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * 指定された請求予定端末を請求実績端末テーブルに登録する
     * @param integer $business_id 事業者ID
     * @param integer $invoice_id 請求明細番号
     * @return integer
     */
    public function regist_invoice_result_device_fee($business_id , $invoice_id) {
        $query = <<<SQL
INSERT INTO
    invoice_result_device_fee
(
    `business_id`,
    `invoice_id`,
    `device_id`,
    `name`,
    `price`,
    `tax_type`,
    `billing_type`,
    `create_user`,
    `update_user`
)
SELECT
    business_id,
    invoice_id,
    device_id,
    name,
    price,
    tax_type,
    billing_type,
    :create_user,
    :update_user
FROM
    invoice_schedule_device_fee
WHERE
    business_id = :business_id
AND
    invoice_id = :invoice_id
SQL;

        $param = [
            'business_id'   => $business_id,
            'invoice_id'    => $invoice_id,
            'create_user'   => SYSTEM_USER_NAME,
            'update_user'   => SYSTEM_USER_NAME,
        ];

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }



    /**
     * 指定された請求ステータスで請求実績を更新する
     *
     * @param integer $invoice_id 請求明細番号
     * @param integer $business_id 事業者ID
     * @param integer $invoice_status 請求ステータス
     * @param integer $service_use_date サービス利用年月
     * @param datetime $invoice_result_datetime 請求実績日時
     * @return integer
     */
    public function update_invoice_result_status($business_id, $invoice_id, $invoice_status, $service_use_date, $invoice_result_datetime) {
    $query = <<<SQL
UPDATE
    invoice_result
SET
    `service_use_date` = :service_use_date,
    `invoice_result_datetime` = :invoice_result_datetime,
    `invoice_status` = :invoice_status,
    `update_user` = :update_user
WHERE
    `invoice_id` = :invoice_id
AND
    `business_id` = :business_id
SQL;

        $param['invoice_id'] = $invoice_id;
        $param['business_id'] = $business_id;
        $param['invoice_status'] = $invoice_status;
        $param['service_use_date'] = $service_use_date;
        $param['invoice_result_datetime'] = $invoice_result_datetime;
        $param['update_user'] = SYSTEM_USER_NAME;

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * 請求実績のステータスのみを更新する
     *
     * @param integer $invoice_id 請求明細番号
     * @param integer $business_id 事業者ID
     * @param integer $invoice_status 請求ステータス
     *
     * @return integer 更新されたレコード数
     */
    public function update_invoice_result_only_status($business_id, $invoice_id, $invoice_status) {
        $query = <<<SQL
UPDATE
    invoice_result
SET
    `invoice_status` = :invoice_status,
    `update_user` = :update_user
WHERE
    `business_id` = :business_id
AND
    `invoice_id` = :invoice_id
SQL;

            $param['invoice_status'] = $invoice_status;
            $param['update_user'] = SYSTEM_USER_NAME;
            $param['business_id'] = $business_id;
            $param['invoice_id'] = $invoice_id;

            $result = DB::query($query)->parameters($param)->execute();
            return $result;
    }

    /**
     * invoice_idを元にレコードを更新する
     *
     * @param int $invoice_id
     * @param array $update_columns
     *            ['カラム名' => '値']形式の連想配列
     * @return number レコード数
     */
    public function update_by_invoice_id($invoice_id, $update_columns)
    {
        return DB::update(self::$_table_name)->set($update_columns)
            ->where('invoice_id', $invoice_id)
            ->where('business_id', BUSINESS_ID)
            ->execute();
    }

    /**
     * invoice_idを元にレコードを更新する（複数invoice_id対応）
     *
     * @param int $business_id
     * @param array $invoice_id_list invoice_idの1次元配列
     * @param array $update_columns [{カラム名} => {値}, ...]
     * @return number 更新を行ったレコード数
     */
    public function update_by_invoice_id_multiple($business_id, $invoice_id_list, $update_columns)
    {
        return DB::update(self::$_table_name)->set($update_columns)
            ->where('business_id', $business_id)
            ->where('invoice_id', 'IN', $invoice_id_list)
            ->execute();
    }

    /**
     * user_idを元に、請求ステータスが請求失敗もしくは再請求予定の情報を取得する
     *
     * @param int $business_id サイトのビジネスID
     * @param int $user_id ユーザーID
     * @param array $invoice_status 請求ステータスのリスト
     * @return array 請求情報
     */
    public function get_invoice_list_by_invoice_status($business_id, $user_id, array $invoice_status = INVOICE_STATUS_VALUE_LIST, array $select = ['*'])
    {

        // GMOに正常に請求できていない、もしくはキャンセル済みの情報は含まない
        $not_in_list = [
            GMO_CONDO_PAY_STATUS_LIST['FAIL'],
            GMO_CONDO_PAY_STATUS_LIST['CANCEL'],
            GMO_CONDO_PAY_STATUS_LIST['ERROR'],
            GMO_CONDO_PAY_STATUS_LIST['BILL_CANCEL'],
        ];
        $query = DB::select_array($select)
                   ->from(self::$_table_name . ' AS inv')
                   ->join('gmo_condo_pay AS gmo', 'inner')
                   ->on('inv.invoice_id', '=', 'gmo.invoice_id')
                   ->where('gmo.status', 'NOT IN ', $not_in_list)
                   ->where('inv.business_id', $business_id)
                   ->where('inv.user_id', $user_id)
                   ->where('inv.invoice_status', 'IN', $invoice_status);
        return $query->execute()->current();
    }

    /**
     * 解約の時、国内プラン終了日以降の利用の国内プランの請求を取得する
     * @param $contract_id
     * @param $plan_end_date_ym_string
     * @param $business_id
     * @return array|null
     */
    public function get_bank_transfer_domestic_plan_invoice_result_after_plan_end_date($contract_id, $plan_end_date_ym_string, $business_id)
    {
        $sql = <<<SQL
SELECT
    inr.invoice_id
FROM
    invoice_result AS inr
INNER JOIN
    invoice_result_plan AS inrp
    ON inr.invoice_id = inrp.invoice_id
    AND inr.business_id = inrp.business_id
INNER JOIN
    mst_plan AS mp
    ON  mp.plan_id = inrp.plan_id
    AND mp.business_id = inrp.business_id
    AND mp.plan_type = :domestic_plan_type
WHERE
    inr.contract_id = :contract_id
AND inr.business_id = :business_id
AND inr.service_use_date > :plan_end_date_ym_string
AND inr.invoice_status IN :invoice_status
AND inr.invoice_type = :invoice_type
SQL;

        $param = [
            'contract_id'    => $contract_id,
            'business_id'    => $business_id,
            'domestic_plan_type' => PLAN_TYPE_LIST['DOMESTIC'],
            'plan_end_date_ym_string' => (int)$plan_end_date_ym_string,
            'invoice_status' => [INVOICE_STATUS_VALUE_LIST['BILL_COMP'], INVOICE_STATUS_VALUE_LIST['BILLING']],
            'invoice_type' => INVOICE_TYPE_PLAN,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 解約の時、オプション終了日以降の利用の該当オプションの請求を取得する
     * @param $contract_option_id_list
     * @param $option_end_date_ym_string
     * @param $business_id
     * @return array|null
     */
    public function get_bank_transfer_option_invoice_result_after_option_end_date($contract_option_id_list, $option_end_date_ym_string, $business_id)
    {
        $sql = <<<SQL
SELECT
    inr.invoice_id
FROM
    invoice_result AS inr
INNER JOIN
    invoice_result_option AS inro
    ON inr.invoice_id = inro.invoice_id
    AND inr.business_id = inro.business_id
WHERE
    inr.contract_child_id IN :contract_option_id_list
AND inr.business_id = :business_id
AND inr.service_use_date > :option_end_date_ym_string
AND inr.invoice_status IN :invoice_status
AND inr.invoice_type = :invoice_type
SQL;

        $param = [
            'contract_option_id_list'    => $contract_option_id_list,
            'business_id'    => $business_id,
            'option_end_date_ym_string' => (int)$option_end_date_ym_string,
            'invoice_status' => [INVOICE_STATUS_VALUE_LIST['BILL_COMP'], INVOICE_STATUS_VALUE_LIST['BILLING']],
            'invoice_type' => INVOICE_TYPE_OPTION,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 銀行振込の請求を返金待ちや請求キャンセルを変更する
     * @param $invoice_id_list
     * @param $business_id
     * @return void
     */
    public function refund_bank_transfer_invoice_by_invoice_id($invoice_id_list, $business_id)
    {
        $sql = <<<SQL
UPDATE
    invoice_result
SET
    invoice_status = IF(invoice_status = :invoice_status_bill_complete, :invoice_status_waiting_refund, :invoice_status_cancel),
    cancel_invoice_datetime = NOW()
WHERE
    invoice_id IN :invoice_id_list
AND business_id = :business_id
SQL;

        $param = [
            'invoice_status_bill_complete' => INVOICE_STATUS_VALUE_LIST['BILL_COMP'],
            'invoice_status_waiting_refund'=> INVOICE_STATUS_VALUE_LIST['WAITING_REFUND'],
            'invoice_status_cancel' => INVOICE_STATUS_VALUE_LIST['CANCEL_COMP'],
            'business_id'   => $business_id,
            'invoice_id_list'    => $invoice_id_list,
        ];

        parent::pre_find($query);
        DB::query($sql)->parameters($param)->execute();
    }

    /**
     * 支払方法と請求ステータスを更新する
     *
     * @param int $business_id
     * @param int $invoice_id
     * @param int $settlement_type
     * @param int $invoice_status
     * @param int $login_user_id
     * @return number レコード数
     */
    public function update_settlement_type_and_invoice_status($business_id, $invoice_id, $settlement_type, $invoice_status, $login_user_id) {
        $query = <<<SQL
UPDATE invoice_result
SET
  settlement_type = :settlement_type
  , invoice_status = :invoice_status
SQL;

        if ((int)$invoice_status === INVOICE_STATUS_VALUE_LIST['CANCEL_COMP']) {
            $query .= <<<SQL
  , cancel_invoice_datetime = :cancel_invoice_datetime
SQL;
        }

        $query .= <<<SQL
  , update_datetime = :update_datetime
  , update_user = :update_user
WHERE
  business_id = :business_id
  AND invoice_id = :invoice_id

SQL;

        $bind_params = [];
        $bind_params['settlement_type'] = $settlement_type;
        $bind_params['invoice_id'] = $invoice_id;
        $bind_params['invoice_status'] = $invoice_status;
        $bind_params['cancel_invoice_datetime'] = Helper_Time::getCurrentDateTime();
        $bind_params['update_datetime'] = Helper_Time::getCurrentDateTime();
        $bind_params['update_user'] = $login_user_id;
        $bind_params['business_id'] = $business_id;

        return DB::query($query)->parameters($bind_params)->execute();
    }

    /**
     * 申込IDを条件に請求済の請求情報を取得する
     *
     * @param int $entry_id ユーザーID
     * @param int $business_id サイトのビジネスID
     * @return array 請求情報
     */
    public function get_invoice_list_by_entry_id_for_entry_cancel($entry_id, $business_id) {
        $sql = <<<SQL
SELECT
    invoice_id
  , settlement_type
  , invoice_status
FROM
    invoice_result
WHERE
    entry_id = :entry_id
AND business_id = :business_id
AND amount > 0
AND invoice_status = :status
SQL;

        $params = [
            'entry_id'    => $entry_id,
            'business_id' => $business_id,
            'status'      => INVOICE_STATUS_VALUE_LIST['BILL_COMP'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * invoice_idを元に請求ステータスを取得する
     *
     * @param  int $invoice_id
     * @param  int $business_id
     * @return array
     */
    public function get_invoice_status($invoice_id, $business_id) {
        $sql = <<<SQL
SELECT invoice_status
FROM invoice_result
WHERE invoice_id = :invoice_id AND
      business_id = :business_id
SQL;

        $params = [
            'invoice_id'  => $invoice_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->current();
    }

    /**
     * 指定の期間に存在する指定のステータスの延滞金の請求を取得する
     * @param int    $entry_id
     * @param int    $business_id
     * @param int    $adjustment_money_id
     * @param int    $invoice_status
     * @param string $start_date
     * @param string $end_date
     * @return array|null
     */
    public function get_expire_fee_invoice_result_by_start_date_end_date($entry_id, $business_id, $adjustment_money_id, $invoice_status, $start_date, $end_date) {
        $sql = <<<SQL
SELECT
    inr.invoice_id,
    inam.bill_datetime
FROM
    invoice_result AS inr
INNER JOIN
    invoice_result_adjustment_money AS inam
    ON  inr.invoice_id = inam.invoice_id
    AND inr.business_id = inam.business_id
WHERE
    inr.business_id = :business_id
AND inr.entry_id = :entry_id
AND inr.invoice_status = :invoice_status
AND inam.adjustment_money_id = :adjustment_money_id
AND inam.bill_datetime >= :start_date
AND inam.bill_datetime < :end_date
SQL;

        $param = [
            'adjustment_money_id' => $adjustment_money_id,
            'entry_id'            => $entry_id,
            'business_id'         => $business_id,
            'invoice_status'      => $invoice_status,
            'start_date'          => $start_date,
            'end_date'            => $end_date,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 請求IDを指定して請求実績データを取得する
     *
     * @param int $business_id
     * @param array $select 取得カラム
     * @param array $invoice_id_list 検索対象のinvoice_id
     *
     * @return array 抽出結果
     */
    public function get_record_by_invoice_id_list($business_id, $select, $invoice_id_list) {
        return DB::select_array($select)->from(self::$_table_name)
            ->where('business_id', $business_id)
            ->where('invoice_id', 'IN', $invoice_id_list);
    }

    /**
     * 請求区分ごとの請求実績の詳細情報を取得する
     *
     * @param int $business_id
     * @param int $invoice_id
     * @param int $invoice_type
     * @return array 請求実績の詳細情報（1行のみ）
     */
    public function get_invoice_result_detail_by_invoice_type($business_id, $invoice_id, $invoice_type) {
        $result = [];
        switch ($invoice_type) {
            case INVOICE_TYPE_PLAN:
                $table = 'invoice_result_plan';
                $join = 'mst_plan';
                $on = 'plan_id';
                break;
            case INVOICE_TYPE_OPTION:
                $table = 'invoice_result_option';
                $join = 'mst_option';
                $on = 'option_id';
                break;
            case INVOICE_TYPE_FIX:
                $table = 'invoice_result_adjustment_money';
                $join = 'mst_adjustment_money';
                $on = 'adjustment_money_id';
                break;
            default:
                return $result;
        }

        $query = DB::select_array(['i.name','m.price'])
            ->from([$table, 'i'])
            ->join([$join, 'm'])
            ->on('i.business_id', '=', 'm.business_id')
            ->on('i.' . $on, '=', 'm.' . $on)
            ->where('i.business_id', $business_id)
            ->where('i.invoice_id', $invoice_id);

        return $query->execute()->current();
    }

    /**
     * ユーザーIDを元に請求実績を取得する
     *
     * @param  int   $user_id
     * @param  array $select
     * @param  int   $business_id
     * @param  array $invoice_status
     * @return array
     */
    public function get_invoice_data_by_user_id($user_id, $select, $business_id, $invoice_status) {
        $query = DB::select_array($select)
            ->from(self::$_table_name)
            ->where('business_id', $business_id)
            ->where('user_id', $user_id);

        if (!empty($invoice_status)) {
            $query = $query->where('invoice_status', 'IN', $invoice_status);
        }
        $result = $query->execute()->as_array();
        return $result;
    }

    /**
     * 複数条件を指定して簡単なSELECTを行う
     * @param array $select 取得カラム
     * @param array $conditions WHEREに使用する条件 [{カラム} => {値}, ...]
     * @return array PKをキーとしたSELECT結果の配列
     */
    public function get_records($select = ['*'], $conditions) {
        if (empty($conditions)) return [];
        $query = DB::select_array($select)->from(self::$_table_name);
        foreach ($conditions as $key => $value) {
            $query->where($key, $value);
        }
        return $query->execute()->as_array();
    }

    /**
     * 複数条件を指定してSELECTしGROUP BYする
     * @param array $select 取得カラム
     * @param array $op_conditions クエリビルダの$op(!= や IN などの指定)付きの条件 [[{カラム名}, {!=やINなど}, {値}]... ]
     * @param array $group GROUP BY対象のカラム
     * @return array PKをキーとしたSELECT結果の配列
     */
    public function get_records_group($select = ['*'], $op_conditions, $group) {
        if (empty($op_conditions)) return [];
        $query = DB::select_array($select)->from(self::$_table_name);
        foreach ($op_conditions as $row) {
            $query->where($row[0], $row[1], $row[2]);
        }
        foreach ($group as $value) {
            $query->group_by($value);
        }
        return $query->execute()->as_array();
    }

    /**
     * 請求実績とそれに紐づくユーザー情報も取得する
     * 
     * @param array $select 取得カラム
     * @param array $op_conditions クエリビルダの$op(!= や IN などの指定)付きの条件 [[{カラム名}, {!=やINなど}, {値}]... ]
     * @param array $order ORDER BY対象
     * @return array SELECT結果の配列
     */
    public function get_record_join_user($select = ['ir.*'], $op_conditions, $order = []) {
        if (empty($op_conditions)) return [];
        $query = DB::select_array($select)->from(self::$_table_name . ' ir');
        $query->join('user u','INNER')->on('ir.user_id', '=', 'u.user_id');
        foreach ($op_conditions as $row) {
            $query->where($row[0], $row[1], $row[2]);
        }
        foreach ($order as $column => $sort) {
            $query->order_by($column, $sort);
        }
        return $query->execute()->as_array();
    }

    /**
     * invoice_idを元に請求情報を取得する
     *
     * @param   int $business_id
     * @param array $invoice_id_list 取得対象のinvoice_id
     * @return array
     */
    public function get_invoice_data_by_invoice_id_list($business_id, $invoice_id_list) {
        $sql = <<<SQL
SELECT 
   *
FROM
    invoice_result
WHERE
    invoice_id IN :invoice_id_list
AND
    business_id = :business_id
SQL;

        $params = [
            'business_id'      => $business_id,
            'invoice_id_list'  => $invoice_id_list,
        ];

        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }
}
