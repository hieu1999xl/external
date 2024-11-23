<?php

/**
 * 請求予定テーブルのモデルクラス
 *
 * @author sakairi@liz-inc.co.jp
 */

class Model_HumanLife_InvoiceSchedule extends Model_CrudAbstract {

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
    protected static $_table_name = 'invoice_schedule';

    /**
     * 指定されたパラメータで請求予定を登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return array [0]: pk値, [1]: insert数
     */
    public function regist_invoice_schedule(array $param) {
        $query = <<<SQL
INSERT INTO
    invoice_schedule
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
    `schedule_child_id`,
    `service_use_date`,
    `invoice_schedule_datetime`,
    `amount`,
    `tax_price`,
    `tax_type`,
    `tax_rate`,
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
     * 指定されたパラメータで請求予定プランを登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_invoice_schedule_plan(array $param) {
        $query = <<<SQL
INSERT INTO
    invoice_schedule_plan
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
VALUES
(
    :business_id,
    :invoice_id,
    :plan_id,
    :name,
    :price,
    :tax_type,
    :billing_type,
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
     * 指定されたパラメータで請求予定オプションを登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_invoice_schedule_option(array $param) {
        $query = <<<SQL
INSERT INTO
    invoice_schedule_option
(
    `business_id`,
    `invoice_id`,
    `option_id`,
    `name`,
    `price`,
    `tax_type`,
    `option_type`,
    `billing_type`,
    `create_user`,
    `update_user`
)
VALUES
(
    :business_id,
    :invoice_id,
    :option_id,
    :name,
    :price,
    :tax_type,
    :option_type,
    :billing_type,
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
     * 指定されたパラメータで請求予定端末初期費用を登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_invoice_schedule_device_init(array $param) {
        $query = <<<SQL
INSERT INTO
    invoice_schedule_device_init
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
VALUES
(
    :business_id,
    :invoice_id,
    :device_init_id,
    :name,
    :price,
    :tax_type,
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
     * 指定されたパラメータで請求予定端末(wimax)分割テーブルを登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_invoice_schedule_device_fee(array $param) {
        $query = <<<SQL
INSERT INTO
    invoice_schedule_device_fee
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
VALUES
(
    :business_id,
    :invoice_id,
    :device_id,
    :name,
    :price,
    :tax_type,
    :billing_type,
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
     * 請求予定テーブルから請求実績登録対象の情報を抽出する
     *
     * @param integer   $service_use_date     サービス利用年月（YYYYMM形式のINT値）
     * @param integer[] $settlement_type_list 取得対象の決済種別
     * @return integer[]string[]string[] 請求実績に登録する情報の連想配列。対象が存在しないときは空配列を返却する。
     */
    public function get_result_target_invoice_by_settlement_type($service_use_date, array $settlement_type_list) {
        $query = <<<SQL
SELECT
    ins.business_id,
    ins.invoice_id,
    ins.user_id,
    ins.company_id,
    ins.user_name,
    ins.user_type,
    ins.invoice_type,
    ins.contract_id,
    ins.contract_child_id,
    ins.schedule_child_id,
    ins.service_use_date,
    ins.invoice_schedule_datetime,
    ins.amount,
    ins.tax_price,
    ins.tax_type,
    ins.tax_rate,
    u.user_type,
    si.settlement_type,
    si.gmo_member_id,
    si.gmo_card_id,
    si.gmo_bank_tran_id
FROM
    invoice_schedule As ins
INNER JOIN
    user As u
ON
    ins.user_id = u.user_id
AND
    ins.business_id = u.business_id
INNER JOIN
    settlement_info As si
ON
    u.user_id = si.user_id
AND
    u.business_id = si.business_id
LEFT JOIN
    invoice_result As inr
ON
    ins.business_id = inr.business_id
AND
    ins.invoice_id = inr.invoice_id
AND
    inr.service_use_date = :service_use_date
WHERE
    inr.invoice_id IS NULL
AND
    ins.service_use_date = :service_use_date
AND
    si.settlement_type IN :settlement_type_list
ORDER BY
    business_id ASC,
    user_id ASC,
    contract_id ASC
SQL;

        $param = [
            'service_use_date'     => $service_use_date,
            'settlement_type_list' => $settlement_type_list,
        ];

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * 請求予定IDを条件に請求予定情報を取得する
     *
     * @param int $invoice_id
     * @param int $business_id
     * @return mixed
     */
    public function get_invoice_schedule_info_by_invoice_id($invoice_id, $business_id) {
        $query = <<<SQL
SELECT
    ins.business_id,
    ins.invoice_id,
    ins.user_id,
    ins.company_id,
    ins.user_name,
    ins.user_type,
    ins.invoice_type,
    ins.contract_id,
    ins.contract_child_id,
    ins.schedule_child_id,
    ins.service_use_date,
    ins.invoice_schedule_datetime,
    ins.amount,
    ins.tax_price,
    ins.tax_type,
    ins.tax_rate,
    inr.invoice_status AS invoice_result_invoice_status,
    ins.entry_id,
    ins.entry_child_id,
    u.user_type,
    si.settlement_type,
    si.gmo_member_id,
    si.gmo_card_id,
    si.gmo_bank_tran_id,
    si.gmo_recurring_id
FROM
    invoice_schedule As ins
INNER JOIN
    user As u
ON
    ins.user_id = u.user_id
AND
    ins.business_id = u.business_id
INNER JOIN
    settlement_info As si
ON
    u.user_id = si.user_id
AND
    u.business_id = si.business_id
LEFT JOIN
    invoice_result As inr
ON
    ins.business_id = inr.business_id
AND
    ins.invoice_id = inr.invoice_id
AND
    ins.service_use_date = inr.service_use_date
WHERE
    ins.invoice_id = :invoice_id
AND ins.business_id = :business_id
SQL;

        $param = [
            'invoice_id'  => $invoice_id,
            'business_id' => $business_id,
        ];

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * 請求予定IDを条件に請求予定情報を取得する
     *
     * @param int $invoice_id
     * @param int $business_id
     * @return mixed
     */
    public function get_no_settlement_invoice_schedule_info_by_invoice_id($invoice_id, $business_id) {
        $query = <<<SQL
SELECT
    ins.business_id,
    ins.invoice_id,
    ins.user_id,
    ins.company_id,
    ins.user_name,
    ins.user_type,
    ins.invoice_type,
    ins.contract_id,
    ins.contract_child_id,
    ins.schedule_child_id,
    ins.service_use_date,
    ins.invoice_schedule_datetime,
    ins.amount,
    ins.tax_price,
    ins.tax_type,
    ins.tax_rate,
    ins.entry_id,
    ins.entry_child_id,
    u.user_type
FROM
    invoice_schedule As ins
INNER JOIN
    user As u
ON
    ins.user_id = u.user_id
AND
    ins.business_id = u.business_id
WHERE
    ins.invoice_id = :invoice_id
AND ins.business_id = :business_id
SQL;

        $param = [
            'invoice_id'  => $invoice_id,
            'business_id' => $business_id,
        ];

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * 請求ステータスが申込時請求失敗の端末初期費用請求予定を取得する
     *
     * @param integer $business_id
     * @param integer $user_id
     * @param integer $user_type
     * @return array 取得結果
     */
    public function get_device_init_by_invoice_status_bill_fail_entry($business_id, $user_id, $user_type) {
        $query = <<<SQL
SELECT
    ins.*,
    e.entry_id
FROM
    invoice_schedule As ins
LEFT JOIN
    invoice_result As inr
ON
    ins.business_id = inr.business_id
AND
    ins.invoice_id = inr.invoice_id
AND
    ins.service_use_date = inr.service_use_date
LEFT JOIN
    entry AS e
ON
    ins.user_id = e.user_id
AND
    ins.business_id = e.business_id
WHERE
    ins.business_id = :business_id
AND ins.user_id  = :user_id
AND ins.user_type  = :user_type
AND ins.invoice_type  = :invoice_type
AND inr.invoice_status = :invoice_status
SQL;

        $param = [
            'business_id'    => $business_id,
            'user_id'        => $user_id,
            'user_type'      => $user_type,
            'invoice_type'   => INVOICE_TYPE_LIST['INIT'],
            'invoice_status' => INVOICE_STATUS_VALUE_LIST['BILL_FAIL_ENTRY'],
        ];

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * 初期費用のサービス利用年月を変更
     *
     * @param integer  $business_id               事業者ID
     * @param integer  $invoice_id                請求明細番号
     * @param integer  $service_use_date          サービス利用年月
     * @param datetime $invoice_schedule_datetime 請求予定日時
     * @return integer
     */
    public function update_invoice_schedule_service_use_date($business_id, $invoice_id, $service_use_date, $invoice_schedule_datetime) {
        $query = <<<SQL
UPDATE
    invoice_schedule
SET
    `service_use_date` = :service_use_date,
    `invoice_schedule_datetime` = :invoice_schedule_datetime,
    `update_user` = :update_user
WHERE
    `invoice_id` = :invoice_id
AND
    `business_id` = :business_id
SQL;

        $param['business_id'] = $business_id;
        $param['invoice_id'] = $invoice_id;
        $param['service_use_date'] = $service_use_date;
        $param['invoice_schedule_datetime'] = $invoice_schedule_datetime;
        $param['update_user'] = SYSTEM_USER_NAME;

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * 対象月の未払い情報を取得する
     *
     * @param int    $user_id
     * @param string $target_month
     * @return array
     */
    public function get_paid_target_month($user_id, $target_month) {

        $target_date_time = new DateTimeImmutable($target_month);
        $this_month = $target_date_time->format('Y-m-01 00:00:00');
        $next_month = $target_date_time->modify('first day of next month')->format('Y-m-01 00:00:00');

        $sql =
            <<<SQL
SELECT
  COUNT(*) cnt
FROM invoice_schedule ins
INNER JOIN settlement_info si
        ON ins.user_id = si.user_id
       AND si.settlement_type = :settlement_type
LEFT JOIN invoice_result inr
       ON ins.invoice_id = inr.invoice_id
WHERE ins.business_id = :business_id
  AND ins.user_id = :user_id
  AND ins.invoice_schedule_datetime >= :this_month
  AND ins.invoice_schedule_datetime < :next_month
  AND inr.invoice_id IS NOT NULL
  AND invoice_status IN :paid_status
SQL;
        $param = [
            'business_id'     => BUSINESS_ID,
            'user_id'         => $user_id,
            'settlement_type' => SETTLEMENT_TYPE_VALUE_LIST['INVOICE'],
            'this_month'      => $this_month,
            'next_month'      => $next_month,
            'paid_status'     => INVOICE_STATUS_UNPAID_LIST,
        ];
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * ユーザIDと申込IDから請求明細番号を取得
     *
     * @param integer $user_id
     * @param integer $entry_id
     * @param string  $trace_id
     * @return mixed
     */
    public function get_invoice_schedule_for_update_condo_pay($user_id, $entry_id, $order_id) {
        $query = <<<SQL
SELECT
    ins.*
FROM
    invoice_schedule As ins
INNER JOIN
    gmo_condo_pay As gcp
ON
    ins.user_id = gcp.user_id
AND
    ins.invoice_id = gcp.invoice_id
AND
    ins.business_id = gcp.business_id
WHERE
    ins.user_id = :user_id
AND ins.entry_id = :entry_id
AND ins.business_id = :business_id
AND gcp.order_id = :order_id
SQL;

        $param = [
            'user_id'     => $user_id,
            'entry_id'    => $entry_id,
            'business_id' => BUSINESS_ID,
            'order_id'    => $order_id,
        ];

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * 対象ユーザーの請求予定日時を取得する
     *
     * @param int $user_id
     *
     * @return array $result
     */
    public function get_invoice_schedule_datetime_init($user_id) {
        $query = <<<SQL
SELECT
    service_use_date
    , invoice_schedule_datetime
FROM
    invoice_schedule
WHERE
    business_id = :business_id
    AND user_id = :user_id
    AND invoice_type = :invoice_type
SQL;

        $param = [
            'business_id'  => BUSINESS_ID,
            'user_id'      => $user_id,
            'invoice_type' => INVOICE_TYPE_LIST['INIT'],
        ];

        $result = DB::query($query)->parameters($param)->execute()->current();
        return $result;
    }

    /**
     * invoice_scheduleに登録されている対象ユーザと対象調整金IDで取得
     *
     * @param int   $user_id
     * @param int   $adjustment_money_id
     * @param array $select
     */
    public function get_invoice_schedule_adjustment_money_info($user_id, $adjustment_money_id, array $select = ['*']) {
        $query = DB::select_array($select)
            ->from(self::$_table_name)
            ->where('user_id', $user_id)
            ->where('invoice_type', INVOICE_TYPE_LIST['FIX'])
            ->where('business_id', BUSINESS_ID)
            ->where('schedule_child_id', $adjustment_money_id);
        return $query->execute()->current();
    }

    /**
     * 従量課金の請求データをユーザIDと利用月で取得する
     *
     * @param int $user_id
     * @param int $service_use_date
     * @return array
     */
    public function get_pay_as_you_go_list_by_user_id_and_service_use_date(int $user_id, int $service_use_date) {
        $query = <<<SQL
SELECT
    invoice_id,
    contract_id,
    amount,
    tax_price,
    use_day_count,
    use_flow_gb
FROM
    invoice_schedule
WHERE
    business_id = :business_id
    AND user_id = :user_id
    AND service_use_date = :service_use_date
    AND contract_pay_as_you_go_child_id IS NOT NULL
SQL;

        $param = [
            'business_id'      => BUSINESS_ID,
            'user_id'          => $user_id,
            'service_use_date' => $service_use_date,
        ];

        return DB::query($query)->parameters($param)->execute()->as_array('contract_id');
    }

    /**
     * 対象ユーザーの決済がされていない(予定・失敗・再請求待ち)のコンビニ払い手数料を取得する
     *
     * @param  int $user_id
     * @return array 検索結果
     */
    public function get_gmo_condopay_commission_invoice($user_id) {
        $query = <<<SQL
        SELECT s.*, r.invoice_status, r.settlement_type
        FROM invoice_schedule AS s
        LEFT JOIN invoice_result AS r ON
            s.user_id = r.user_id AND
            s.invoice_id = r.invoice_id AND
            s.business_id = r.business_id
        WHERE
            s.business_id = :business_id AND
            s.user_id = :user_id AND
            s.invoice_type = :invoice_type AND
            s.schedule_child_id = :schedule_child_id AND
            (r.invoice_status IN :invoice_status OR r.invoice_status IS NULL) AND
            (r.settlement_type = :settlement_type OR r.settlement_type IS NULL)
SQL;
        $bind_params['user_id'] = $user_id;
        $bind_params['invoice_type'] = INVOICE_TYPE_FIX;
        $bind_params['schedule_child_id'] = ADJUSTMENT_MONEY_ID_CONDO_FEE;
        $bind_params['invoice_status'] = [
            INVOICE_STATUS_VALUE_LIST['BILL_BEF'],
            INVOICE_STATUS_VALUE_LIST['BILL_FAIL'],
            INVOICE_STATUS_VALUE_LIST['RECHARGE'],
        ];
        $bind_params['business_id'] = BUSINESS_ID;
        $bind_params['settlement_type'] = SETTLEMENT_TYPE_VALUE_LIST['CONDO_PAY'];

        return DB::query($query)->parameters($bind_params)
        ->execute()
        ->as_array();
    }

    /**
     * 請求予定テーブルLEFTJOIN請求実績テーブルから条件に従ってレコードを取得する
     * +ユーザ決済.決済種別も取得する
     *
     * @param int $business_id
     * @param array $where_params
     * @return array 取得結果
     */
    public function get_invoice_schedule_left_join_result($business_id, $where_params) {
        $query = <<<SQL
        SELECT
        CASE invoice_result.business_id IS NULL WHEN 1
            THEN 0
            ELSE 1
        END AS exitst_invoice_result,
        CASE invoice_schedule.business_id IS NULL WHEN 1
            THEN invoice_result.business_id
            ELSE invoice_schedule.business_id
        END AS business_id,
        CASE invoice_schedule.invoice_id IS NULL WHEN 1
            THEN invoice_result.invoice_id
            ELSE invoice_schedule.invoice_id
        END AS invoice_id,
        CASE invoice_schedule.user_id IS NULL WHEN 1
            THEN invoice_result.user_id
            ELSE invoice_schedule.user_id
        END AS user_id,
        CASE invoice_schedule.company_id IS NULL WHEN 1
            THEN invoice_result.company_id
            ELSE invoice_schedule.company_id
        END AS company_id,
        CASE invoice_schedule.user_name IS NULL WHEN 1
            THEN invoice_result.user_name
            ELSE invoice_schedule.user_name
        END AS user_name,
        CASE invoice_schedule.user_type IS NULL WHEN 1
            THEN invoice_result.user_type
            ELSE invoice_schedule.user_type
        END AS user_type,
        CASE invoice_schedule.invoice_type IS NULL WHEN 1
            THEN invoice_result.invoice_type
            ELSE invoice_schedule.invoice_type
        END AS invoice_type,
        CASE invoice_schedule.contract_id IS NULL WHEN 1
            THEN invoice_result.contract_id
            ELSE invoice_schedule.contract_id
        END AS contract_id,
        CASE invoice_schedule.contract_child_id IS NULL WHEN 1
            THEN invoice_result.contract_child_id
            ELSE invoice_schedule.contract_child_id
        END AS contract_child_id,
        invoice_schedule.schedule_child_id AS schedule_child_id,
        CASE invoice_result.result_child_id IS NULL WHEN 1
            THEN NULL
            ELSE invoice_result.result_child_id
        END AS result_child_id,
        CASE invoice_schedule.service_use_date IS NULL WHEN 1
            THEN invoice_result.service_use_date
            ELSE invoice_schedule.service_use_date
        END AS service_use_date,
        invoice_schedule.invoice_schedule_datetime AS invoice_schedule_datetime,
        invoice_result.cancel_invoice_datetime AS cancel_invoice_datetime,
        invoice_result.invoice_result_datetime AS invoice_result_datetime,
        CASE invoice_schedule.amount IS NULL WHEN 1
            THEN invoice_result.amount
            ELSE invoice_schedule.amount
        END AS amount,
        CASE invoice_schedule.tax_price IS NULL WHEN 1
            THEN invoice_result.tax_price
            ELSE invoice_schedule.tax_price
        END AS tax_price,
        CASE invoice_schedule.tax_type IS NULL WHEN 1
            THEN invoice_result.tax_type
            ELSE invoice_schedule.tax_type
        END AS tax_type,
        CASE invoice_schedule.tax_rate IS NULL WHEN 1
            THEN invoice_result.tax_rate
            ELSE invoice_schedule.tax_rate
        END AS tax_rate,
        CASE invoice_result.settlement_type IS NULL WHEN 1
            THEN settlement_info.settlement_type
            ELSE invoice_result.settlement_type
        END AS settlement_type,
        CASE invoice_result.invoice_status IS NULL WHEN 1
            THEN 1
            ELSE invoice_result.invoice_status
        END AS invoice_status,
        CASE invoice_schedule.create_datetime IS NULL WHEN 1
            THEN invoice_result.create_datetime
            ELSE invoice_schedule.create_datetime
        END AS create_datetime,
        CASE invoice_schedule.create_user IS NULL WHEN 1
            THEN invoice_result.create_user
            ELSE invoice_schedule.create_user
        END AS create_user,
        CASE invoice_schedule.update_datetime IS NULL WHEN 1
            THEN invoice_result.update_datetime
            ELSE invoice_schedule.update_datetime
        END AS update_datetime,
        CASE invoice_schedule.update_user IS NULL WHEN 1
            THEN invoice_result.update_user
            ELSE invoice_schedule.update_user
        END AS update_user,
        CASE invoice_schedule.entry_id IS NULL WHEN 1
            THEN invoice_result.entry_id
            ELSE invoice_schedule.entry_id
        END AS entry_id,
        CASE invoice_schedule.entry_child_id IS NULL WHEN 1
            THEN invoice_result.entry_child_id
            ELSE invoice_schedule.entry_child_id
        END AS entry_child_id,
        c_plan.plan_start_date AS plan_start_date,
        rel_contract_option.option_start_date AS option_start_date,
        e_plan.device_type AS entry_device_type,
        c_plan.device_type AS contract_device_type
        FROM
            invoice_schedule
        LEFT JOIN invoice_result
            ON invoice_schedule.business_id = invoice_result.business_id
            AND invoice_schedule.invoice_id = invoice_result.invoice_id
        INNER JOIN settlement_info
            ON invoice_schedule.business_id = settlement_info.business_id
            AND invoice_schedule.user_id = settlement_info.user_id
        LEFT JOIN (
                    SELECT
                        entry_plan.business_id
                        , entry_plan.entry_id
                        , mp.device_type
                    FROM entry_plan
                    INNER JOIN mst_plan AS mp
                    ON entry_plan.plan_id = mp.plan_id
            ) AS e_plan
            ON invoice_schedule.business_id = e_plan.business_id
            AND invoice_schedule.entry_id = e_plan.entry_id
        LEFT JOIN (
                    SELECT
                        rel_contract_plan.contract_plan_id
                        , rel_contract_plan.plan_start_date
                        , mp.device_type
                    FROM rel_contract_plan
                    INNER JOIN mst_plan AS mp
                    ON rel_contract_plan.plan_id = mp.plan_id
            ) AS c_plan
            ON invoice_schedule.contract_child_id = c_plan.contract_plan_id
            AND invoice_schedule.invoice_type = :invoice_type_plan
        LEFT JOIN
            rel_contract_option
            ON invoice_schedule.contract_child_id = rel_contract_option.contract_option_id
            AND invoice_schedule.invoice_type = :invoice_type_option
        WHERE
            invoice_schedule.business_id = :business_id

SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['invoice_type_plan'] = INVOICE_TYPE_PLAN;
        $bind_params['invoice_type_option'] = INVOICE_TYPE_OPTION;

        foreach ($where_params as $key => $value)
        {
            switch (true)
            {
                case $key === 'invoice_id':
                    if (is_array($value)) {
                        $query .= 'AND invoice_schedule.invoice_id IN :invoice_id'."\n";
                    } else {
                        $query .= 'AND invoice_schedule.invoice_id = :invoice_id'."\n";
                    }
                    $bind_params['invoice_id'] = $value;
                    break;
                case $key === 'user_id':
                    if (is_array($value)) {
                        $query .= 'AND invoice_schedule.user_id IN :user_id'."\n";
                    } else {
                        $query .= 'AND invoice_schedule.user_id = :user_id'."\n";
                    }
                    $bind_params['user_id'] = $value;
                    break;
                case $key === 'user_type':
                    $query .= 'AND invoice_schedule.user_type = :user_type'."\n";
                    $bind_params['user_type'] = $value;
                    break;
                case $key === 'user_name':
                    $query .= 'AND invoice_schedule.user_name LIKE :user_name'."\n";
                    $bind_params['user_name'] = '%' . $value . '%';
                    break;
                case $key === 'service_use_date':
                    $query .= 'AND invoice_schedule.service_use_date = :service_use_date'."\n";
                    $bind_params['service_use_date'] = $value;
                    break;
                case $key === 'settlement_type':
                    // ※※※左辺で関数使っちゃってますが、遅かったらチューニングで※※※
                    if (is_array($value)) {
                        $query .= 'AND IFNULL(invoice_result.settlement_type, settlement_info.settlement_type) IN :settlement_type ' . "\n";
                    } else {
                        $query .= 'AND IFNULL(invoice_result.settlement_type, settlement_info.settlement_type) = :settlement_type ' . "\n";
                    }
                    $bind_params['settlement_type'] = $value;
                    break;
                case $key === 'invoice_status':
                    // 請求ステータスで「請求予定」が選択されていた場合は、請求予定レコードも抽出
                    if (in_array(INVOICE_STATUS_VALUE_LIST['BILL_BEF'], $value)) {
                        $query .= 'AND (invoice_result.invoice_status IN :invoice_status OR invoice_result.invoice_id IS NULL)'."\n";
                    } else {
                        $query .= 'AND invoice_result.invoice_status IN :invoice_status '."\n";
                    }
                    $bind_params['invoice_status'] = $value;
                    break;
                case $key === 'invoice_schedule_date_from':
                    $query .= 'AND invoice_schedule.invoice_schedule_datetime >= :invoice_schedule_date_from'."\n";
                    $bind_params['invoice_schedule_date_from'] = $value . ' 00:00:00';
                    break;
                case $key === 'invoice_schedule_date_to':
                    $query .= 'AND invoice_schedule.invoice_schedule_datetime <= :invoice_schedule_date_to'."\n";
                    $bind_params['invoice_schedule_date_to'] = $value . ' 23:59:59';
                    break;
                case $key === 'invoice_type':
                    $query .= 'AND invoice_schedule.invoice_type IN :invoice_type '."\n";
                    $bind_params['invoice_type'] = $value;
                    break;
                case $key === 'settlement_info_settlement_type':
                    $query .= 'AND settlement_info.settlement_type = :settlement_info_settlement_type '."\n";
                    $bind_params['settlement_info_settlement_type'] = $value;
                    break;
                case $key === 'invoice_result_settlement_type':
                    $query .= 'AND invoice_result.settlement_type = :invoice_result_settlement_type '."\n";
                    $bind_params['invoice_result_settlement_type'] = $value;
                    break;
                case $key === 'schedule_child_id':
                    if (is_array($value)) {
                        $query .= 'AND invoice_schedule.schedule_child_id IN :schedule_child_id ' . "\n";
                    } else {
                        $query .= 'AND invoice_schedule.schedule_child_id = :schedule_child_id ' . "\n";
                    }
                    $bind_params['schedule_child_id'] = $value;
                    break;
                default:
                    break;
            }

        }

        // order by
        $query .= 'ORDER BY invoice_schedule.invoice_id DESC'."\n";
        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 初期費用を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_invoice_schedule_init_amount_info ($user_id, $business_id) {
        $query = <<<SQL
SELECT
    amount,
    tax_price
FROM
    invoice_schedule
WHERE
    business_id = :business_id
    AND user_id = :user_id
    AND invoice_type = :invoice_type
SQL;

        $param = [
            'business_id'      => $business_id,
            'user_id'          => $user_id,
            'invoice_type' => INVOICE_TYPE_LIST['INIT'],
        ];

        return DB::query($query)->parameters($param)->execute()->as_array();
    }

    /**
     * 請求予定に対する請求実績のステータスを取得する
     *
     * @param int $business_id
     * @param int $user_id
     * @return array
     */
    public function get_invoice_status_list($business_id, $user_id) {
        $query = <<<SQL
SELECT
    ins.invoice_id
    , inr.invoice_status
FROM
    invoice_schedule ins
    LEFT JOIN invoice_result inr
        ON ins.business_id = inr.business_id
        AND ins.invoice_id = inr.invoice_id
WHERE
    ins.business_id = :business_id
    AND ins.user_id = :user_id
SQL;

        $param = [
            'business_id'    => $business_id,
            'user_id'        => $user_id,
        ];

        return DB::query($query)->parameters($param)->execute()->as_array();
    }

    /**
     * invoice_idを元にレコードを更新する
     *
     * @param int $invoice_id
     * @param array $update_columns
     *            ['カラム名' => '値']形式の連想配列
     * @return number レコード数
     */
    public function update_by_invoice_id($invoice_id, $update_columns) {
        return DB::update(self::$_table_name)->set($update_columns)
            ->where('invoice_id', $invoice_id)
            ->where('business_id', BUSINESS_ID)
            ->execute();
    }
}
