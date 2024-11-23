<?php

/**
 * 契約－プランテーブルのモデルクラス
 */
class Model_HumanLife_RelContractPlan extends Model_CrudAbstract {

    /**
     * テーブル名
     *
     * @var string テーブル名
     */
    protected static $_table_name = 'rel_contract_plan';

    /**
     * プライマリキー
     */
    protected static $_primary_key = 'contract_plan_id';

    /**
     * 契約中の国内プランの利用終了日を更新する
     *
     * @param int    $contract_id
     * @param int    $business_id
     * @param string $plan_end_date
     * @return void
     */
    public function update_contract_domestic_plan_end_date($contract_id, $business_id, $plan_end_date) {
        $sql = <<<SQL
UPDATE
    rel_contract_plan AS rcp
INNER JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
SET
    rcp.plan_end_date = :plan_end_date,
    rcp.cancel_application_datetime = NOW()
WHERE
    rcp.contract_id = :contract_id
AND rcp.business_id = :business_id
AND mp.plan_type IN :plan_type
SQL;

        $param = [
            'contract_id'   => $contract_id,
            'business_id'   => $business_id,
            'plan_type'     => [
                PLAN_TYPE_LIST['DOMESTIC'],
                PLAN_TYPE_LIST['INTERNATIONAL_BASE']
            ],
            'plan_end_date' => $plan_end_date,
        ];

        parent::pre_find($query);
        DB::query($sql)->parameters($param)->execute();
    }

    /**
     * 契約プランを登録する
     *
     * @param int    $contract_id
     * @param int    $plan_id
     * @param int    $business_id
     * @param string $order_sn
     * @param string $order_id
     * @param string $plan_start_date
     * @param string $plan_end_date
     * @param int    $ucl_account_type
     * @return array
     */
    public function insert_contract_plan($contract_id, $plan_id, $business_id, $order_sn, $order_id, $plan_start_date, $plan_end_date, $ucl_account_type) {
        $sql = <<<SQL
INSERT INTO
    rel_contract_plan (
        contract_id,
        plan_id,
        ucl_account_type,
        business_id,
        order_sn,
        order_id,
        plan_start_date,
        plan_end_date,
        delete_flag,
        create_datetime,
        create_user,
        update_datetime,
        update_user
    )
VALUE (
    :contract_id,
    :plan_id,
    :ucl_account_type,
    :business_id,
    :order_sn,
    :order_id,
    :plan_start_date,
    :plan_end_date,
    :delete_flag,
    NOW(),
    :create_user,
    NOW(),
    :update_user
)
SQL;

        $param = [
            'contract_id'      => $contract_id,
            'plan_id'          => $plan_id,
            'ucl_account_type' => $ucl_account_type,
            'business_id'      => $business_id,
            'order_sn'         => $order_sn,
            'order_id'         => $order_id,
            'plan_start_date'  => $plan_start_date,
            'plan_end_date'    => $plan_end_date !== '' ? $plan_end_date : null,
            'delete_flag'      => FLG_OFF,
            'create_user'      => SYSTEM_USER_NAME,
            'update_user'      => SYSTEM_USER_NAME,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute();
        return parent::post_find($result);
    }

    /**
     * ユーザIDを条件に月額課金プランのプラン利用終了日を更新する
     *
     * @param int    $business_id
     * @param int    $user_id
     * @param string $plan_end_date
     * @return int
     */
    public function update_plan_end_date_of_monthly_plan_by_user_id($business_id, $user_id, $plan_end_date) {
        $sql = <<<SQL
UPDATE
    rel_contract_plan AS rcp
SET
    plan_end_date = :plan_end_date
  , update_datetime = :current_datetime
  , update_user = :system_user
WHERE
    rcp.business_id = :business_id
AND rcp.plan_end_date IS NULL
AND rcp.delete_flag = :delete_flag
AND rcp.contract_id IN (
        SELECT
            c.contract_id
        FROM
            contract AS c
        WHERE
            c.business_id = rcp.business_id
        AND c.user_id = :user_id
    )
AND rcp.plan_id IN (
        SELECT
            mp.plan_id
        FROM
            mst_plan AS mp
        WHERE
            mp.business_id = rcp.business_id
        AND mp.billing_type = :billing_type
    )
SQL;

        $params = [
            'plan_end_date'    => $plan_end_date,
            'current_datetime' => Helper_Time::getCurrentDateTime(),
            'system_user'      => SYSTEM_USER_NAME,
            'business_id'      => $business_id,
            'delete_flag'      => FLG_OFF,
            'user_id'          => $user_id,
            'billing_type'     => BILLING‗TYPE_VALUE_LIST['MONTHLY'],
        ];

        parent::pre_update($sql);
        $result = DB::query($sql)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * プラン情報一覧を取得する
     *
     * @param int   $contract_id
     * @param int   $business_id
     * @param array $target_plan_type_list
     * @return array
     */
    public function get_contract_plan_info_list($contract_id, $business_id, $target_plan_type_list) {
        $sql = <<<SQL
SELECT
    rcp.contract_plan_id,
    rcp.order_id,
    rcp.order_sn,
    rcp.plan_start_date,
    rcp.plan_end_date,
    mp.plan_id,
    mp.name AS plan_name,
    mp.plan_type,
    mp.price AS plan_price,
    mp.billing_type AS plan_billing_type,
    mp.tax_type AS plan_tax_type,
    mp.sale_end_date AS plan_sale_end_date
FROM
    rel_contract_plan AS rcp
INNER JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
    AND mp.plan_type IN :plan_type_list
WHERE
    rcp.contract_id = :contract_id
AND rcp.business_id = :business_id
AND (rcp.plan_end_date > NOW() OR DATE_FORMAT(rcp.plan_end_date, '%Y%m') = DATE_FORMAT(NOW(), '%Y%m') OR rcp.plan_end_date IS NULL)
SQL;

        $param = [
            'contract_id'    => $contract_id,
            'business_id'    => $business_id,
            'plan_type_list' => $target_plan_type_list,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute();
        return parent::post_find($result);
    }

    /**
     * プラン情報一覧を取得する
     *
     * @param int   $contract_id
     * @param int   $business_id
     * @return array
     */
    public function get_rel_contract_plan_info_by_contract_id($contract_id, $business_id) {

        $sql = <<<SQL
SELECT
    rcp.contract_plan_id,
    rcp.order_id,
    rcp.order_sn,
    rcp.plan_start_date,
    rcp.plan_end_date,
    mp.plan_id,
    mp.name AS plan_name,
    mp.auto_renewal,
    mp.contract_duration_month,
    mp.is_cancel_fee_required,
    mp.plan_type,
    mp.price AS plan_price,
    mp.billing_type AS plan_billing_type,
    mp.tax_type AS plan_tax_type,
    mp.sale_end_date AS plan_sale_end_date
FROM
    rel_contract_plan AS rcp
INNER JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
WHERE
    rcp.contract_id = :contract_id
AND rcp.business_id = :business_id
AND mp.plan_type IN :plan_type
AND (rcp.plan_end_date > NOW() OR DATE_FORMAT(rcp.plan_end_date, '%Y%m') = DATE_FORMAT(NOW(), '%Y%m') OR rcp.plan_end_date IS NULL)
SQL;

        $param = [
            'contract_id'    => $contract_id,
            'business_id'    => $business_id,
            'plan_type'      => [
                PLAN_TYPE_LIST['DOMESTIC'],
                PLAN_TYPE_LIST['INTERNATIONAL_BASE']
            ],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute();
        return parent::post_find($result[0]);
    }

    /**
     * プラン情報一覧を取得する
     *
     * @param int   $contract_id
     * @param int   $business_id
     * @return array
     */
    public function get_rel_contract_plan_info_by_contract_id_and_business_id($contract_id, $business_id) {
        $sql = <<<SQL
SELECT
    rcp.contract_plan_id,
    rcp.order_id,
    rcp.order_sn,
    rcp.plan_start_date,
    rcp.plan_end_date,
    mp.plan_id,
    mp.name AS plan_name,
    mp.auto_renewal,
    mp.contract_duration_month,
    mp.is_cancel_fee_required,
    mp.plan_type,
    mp.price AS plan_price,
    mp.billing_type AS plan_billing_type,
    mp.tax_type AS plan_tax_type,
    mp.sale_end_date AS plan_sale_end_date
FROM
    rel_contract_plan AS rcp
INNER JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
WHERE
    rcp.contract_id = :contract_id
AND rcp.business_id = :business_id
AND mp.plan_type = :plan_type
SQL;

        $param = [
            'contract_id'    => $contract_id,
            'business_id'    => $business_id,
            'plan_type'      => PLAN_TYPE_LIST['DOMESTIC'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute();
        return parent::post_find($result[0]);
    }

    public function get_plan_start_date_by_contract_id($contract_id, $business_id)
    {

        $sql = <<<SQL
SELECT
    rcp.plan_start_date
FROM
    rel_contract_plan AS rcp
INNER JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
WHERE
    rcp.contract_id = :contract_id
AND rcp.business_id = :business_id
AND mp.plan_type IN :plan_type
SQL;
        $param = [
            'contract_id'    => $contract_id,
            'business_id'    => $business_id,
            'plan_type'      => [PLAN_TYPE_DOMESTIC, PLAN_TYPE_INTERNATIONAL_PREPAID],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result[0]);
    }

    /**
     *　契約データあるかどうか
     */
    public function is_contract_withdraw($contract_id, $business_id)
    {
        $sql = <<<SQL
SELECT
    count(rcp.contract_id) as count
FROM
    rel_contract_plan AS rcp
INNER JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
WHERE
    rcp.contract_id = :contract_id
AND rcp.business_id = :business_id
AND mp.plan_type = :plan_type
AND rcp.plan_end_date < :first_day_of_current_month
SQL;

        $param = [
            'contract_id'    => $contract_id,
            'business_id'    => $business_id,
            'plan_type'      =>PLAN_TYPE_LIST['DOMESTIC'],
            'first_day_of_current_month'=> FIRST_DAY_OF_CURRENT_MONTH,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute();
        return parent::post_find($result[0]['count']);
    }

    /**
     *
     * 受け取り済みのキャンペーンチャージ回数を返す
     * @param int $contract_id  契約ID
     * @param string $target_month 対象月(YYYY-MM)
     * @return array
     */
    public function get_accepted_charge_count($contract_id, $target_month){

        $target_date_time = new DateTimeImmutable($target_month);
        $this_month = $target_date_time->format('Y-m-01 00:00:00');
        $next_month = $target_date_time->modify('first day of next month')->format('Y-m-01 00:00:00');

        $sql =
<<<SQL
SELECT
  contract_id,
  rcp.plan_id,
  COUNT(rcp.contract_id) cnt
FROM rel_contract_plan rcp
INNER JOIN mst_plan mp
        ON rcp.plan_id = mp.plan_id
WHERE rcp.contract_id = :contract_id
  AND rcp.plan_start_date >= :this_month
  AND rcp.plan_start_date < :next_month
GROUP BY rcp.plan_id
SQL;
        $bind_params = [
            'contract_id' => $contract_id,
            'this_month'  => $this_month,
            'next_month' => $next_month,
        ];

        return DB::query($sql)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * contract_idをキーに無料チャージの履歴を取得する
     * @param int   $contract_id
     * @param array $select
     * @param string $target_month 対象月(YYYY-MM) nullの場合全期間
     */
    public function get_free_charge_history_by_contract_id($contract_id, $select, $target_month = null){

        $query = DB::select_array($select)->from(self::$_table_name)
                                          ->join('mst_plan', 'INNER')
                                          ->on(self::$_table_name.'.plan_id', '=', 'mst_plan.plan_id')
                                          ->and_on('mst_plan.plan_type', '=', PLAN_TYPE_LIST['DOMESTIC_DATA_CHARGE'])
                                          ->and_on('mst_plan.price', '=', 0)
                                          ->where('contract_id', $contract_id)
                                          ->order_by('plan_start_date', 'DESC');
        if(!is_null($target_month)){
            $target_date_time = new DateTimeImmutable($target_month);
            $this_month = $target_date_time->format('Y-m-01 00:00:00');
            $next_month = $target_date_time->modify('first day of next month')->format('Y-m-01 00:00:00');

            $query->and_where('plan_start_date', '>=', $this_month);
            $query->and_where('plan_start_date', '<', $next_month);
        }

        return $query->execute()->as_array();
    }

    /**
     * contract_idに紐づく国内プランを取得
     * @param int   $contract_id 契約ID
     * @param array $select      取得するカラム名の配列
     * @return array
     */
    public function get_domestic_plan_info_by_contract_id($contract_id, array $select){
        $query = DB::select_array($select)->from(self::$_table_name)
                                          ->join('mst_plan', 'INNER')
                                          ->on(self::$_table_name.'.plan_id', '=', 'mst_plan.plan_id')
                                          ->and_on('mst_plan.plan_type', '=', PLAN_TYPE_LIST['DOMESTIC'])
                                          ->where('contract_id', $contract_id);
        return $query->execute()->as_array();
    }

    /**
     * 複数の契約IDにおける国内プランが紐づくレコードを取得(法人向け)
     *
     * @param $contract_ids
     * @return array
     */
    public function get_domestic_plan_by_contract_ids($contract_ids)
    {
        $sql = <<<SQL
        SELECT
            rcp.*
        FROM
            rel_contract_plan AS rcp
        LEFT JOIN
            mst_plan AS mp
        ON
            rcp.plan_id = mp.plan_id
        WHERE
            rcp.contract_id IN :contract_ids
        AND
            mp.plan_type = :plan_type
        SQL;

        $param = [
            'contract_ids'  => $contract_ids,
            // 'business_id'    => $business_id,    // TODO: business_idをいれる
            'plan_type'     => PLAN_TYPE_LIST['DOMESTIC'],
        ];

        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * ユーザIDに紐づいたプラン情報を一覧で取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_plan_list_by_user_id(int $user_id, int $business_id)
    {
        $sql = <<<SQL
SELECT
    con.contract_id,
    rcp.plan_id,
    mp.is_hotel_plan
FROM
    contract AS con
INNER JOIN
    rel_contract_plan AS rcp
    ON con.contract_id = rcp.contract_id
    AND con.business_id = rcp.business_id
INNER JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
WHERE
    con.user_id = :user_id
AND con.business_id = :business_id
SQL;

        $param = [
            'user_id'    => $user_id,
            'business_id'    => $business_id,
        ];

        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * contract_idから購入済みのMAYAプリペイド海外プラン関連の情報を取得する(海外)
     *
     * @param  int   $contract_id
     * @return array 取得結果
     */
    public function get_purchased_prepaid_overseas_plan_by_contract_id($contract_id) {
        $sql = <<<SQL
SELECT
    rcp.contract_plan_id,
    rcp.plan_id,
    rcp.plan_start_date,
    rcp.plan_end_date,
    rcp.create_datetime AS plan_entry_datetime,
    mp.name,
    mp.price,
    mp.tax_type,
    mp.plan_type,
    mcp.continent_name,
    mcp.country_name,
    rcch.rel_contract_change_history_id,
    rcch.change_type,
    rcch.before_id,
    rcch.after_id,
    rcch.after_start_datetime,
    rcch.before_start_datetime,
    rcch.after_start_datetime,
    rcch.before_end_datetime,
    rcch.after_end_datetime,
    rcch.exec_datetime,
    mpb.plan_type AS before_plan_type,
    mpb.price AS before_price,
    mpa.plan_type AS after_plan_type,
    mpa.price AS after_price,
    iss.invoice_id
FROM rel_contract_plan AS rcp
INNER JOIN
    mst_plan AS mp
    ON rcp.plan_id = mp.plan_id
    AND rcp.business_id = mp.business_id
LEFT JOIN
    mst_continent_plan AS mcp
    ON mp.plan_id = mcp.plan_id
    AND mp.business_id = mcp.business_id
INNER JOIN
    rel_contract_change_history AS rcch
    ON rcch.rel_contract_id = rcp.contract_plan_id
LEFT JOIN
    mst_plan AS mpb
    ON mpb.plan_id = rcch.before_id
LEFT JOIN
    mst_plan AS mpa
    ON mpa.plan_id = rcch.after_id
INNER JOIN
    invoice_schedule AS iss
    ON rcch.invoice_id = iss.invoice_id
WHERE
    rcp.contract_id = :contract_id AND
    rcp.business_id = :business_id AND
    mp.business_id = :business_id AND
    mp.plan_type IN :plan_type
GROUP BY rcch.rel_contract_change_history_id, rcp.contract_plan_id, mcp.continent_name, mcp.country_name, iss.invoice_id
ORDER BY rcp.contract_plan_id DESC
SQL;

        $param = [
            'contract_id' => $contract_id,
            'business_id' => BUSINESS_ID,
            'plan_type'   => MAYA_CONTINUOUS_PURCHASE_PLAN_TYPE_LIST,
        ];

        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * contract_idから購入済みのMAYAプリペイド海外プラン関連の情報を取得する(国内プラン)
     *
     * @param  int   $contract_id
     * @return array 取得結果
     */
    public function get_purchased_prepaid_domestic_plan_by_contract_id($contract_id) {
        $sql = <<<SQL
SELECT
    rcp.contract_plan_id,
    rcp.plan_id,
    rcp.plan_start_date,
    rcp.plan_end_date,
    rcp.create_datetime AS plan_entry_datetime,
    mp.name,
    mp.price,
    mp.tax_type,
    mp.plan_type,
    null AS country_name,
    null AS rel_contract_change_history_id,
    null AS change_type,
    null AS before_id,
    null AS after_id,
    null AS after_start_datetime,
    null AS before_start_datetime,
    null AS after_start_datetime,
    null AS before_end_datetime,
    null AS exec_datetime,
    null AS before_plan_type,
    null AS before_price,
    null AS after_plan_type,
    null AS after_price,
    iss.invoice_id
FROM rel_contract_plan AS rcp
INNER JOIN
    mst_plan AS mp
    ON rcp.plan_id = mp.plan_id
    AND rcp.business_id = mp.business_id
INNER JOIN
    invoice_schedule AS iss
    ON rcp.contract_plan_id = iss.contract_child_id
WHERE
    rcp.contract_id = :contract_id AND
    rcp.business_id = :business_id AND
    mp.business_id = :business_id AND
    mp.plan_type IN :plan_type AND
    mp.plan_id != :plan_id AND
    iss.amount != 0
ORDER BY rcp.contract_plan_id DESC
SQL;

        $param = [
            'contract_id' => $contract_id,
            'business_id' => BUSINESS_ID,
            'plan_type'   => INTERNATIONAL_CHANGE_PREPAID_PLAN_DOMESTIC_TYPE_LIST,
            'plan_id'     => PREPAID_PLAN_NO_CAPACITY_ENTRY_ID,
        ];

        return DB::query($sql)->parameters($param)->execute()->as_array();
    }


    /**
     * レコードを更新する
     *
     * @param array $pairs [{カラム名} => {値}, ...]
     * @param array $wheres [{カラム名} => {値}, ...]
     * @return number 更新レコード数
     */
    public function update($pairs, $wheres) {
        if (empty($wheres)) {
            return;
        }
        return DB::update(self::$_table_name)->set($pairs)->where($wheres)->execute();
    }

    /**
     * 契約中のプランの利用終了日を更新する
     *
     * @param int    $contract_id
     * @param int    $business_id
     * @param string $plan_end_date
     * @param int $plan_type PLAN_TYPE_LIST
     * @return void
     */
    public function update_contract_plan_end_date($contract_id, $business_id, $plan_end_date, $plan_type) {
        $sql = <<<SQL
UPDATE
    rel_contract_plan AS rcp
INNER JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
SET
    rcp.plan_end_date = :plan_end_date,
    rcp.cancel_application_datetime = NOW()
WHERE
    rcp.contract_id = :contract_id
AND rcp.business_id = :business_id
AND rcp.plan_end_date IS NULL
AND mp.plan_type = :plan_type
SQL;

        $param = [
            'contract_id'   => $contract_id,
            'business_id'   => $business_id,
            'plan_type'     => $plan_type,
            'plan_end_date' => $plan_end_date,
        ];

        parent::pre_find($query);
        DB::query($sql)->parameters($param)->execute();
    }

    /**
     * PKを条件としてプラン情報を取得
     *
     * @param array $contract_plan_id_list
     * @param int   $business_id
     * @return array
     */
    public function get_plan_list_by_rel_contract_plan_id($contract_plan_id_list, $business_id) {
        $sql = <<<SQL
SELECT
    rcp.contract_plan_id,
    rcp.plan_id,
    rcp.plan_start_date,
    rcp.plan_end_date,
    rcp.order_sn,
    rcp.order_id,
    mp.name as plan_name,
    mp.price,
    mp.data_usage_limit,
    mp.plan_type,
    mcp.country_name
FROM
    rel_contract_plan AS rcp
INNER JOIN
    mst_plan as mp
ON  mp.plan_id = rcp.plan_id
AND mp.business_id = rcp.business_id
LEFT JOIN
    mst_continent_plan as mcp
ON  mcp.plan_id = mp.plan_id
AND mcp.business_id = mp.business_id
WHERE
    rcp.contract_plan_id IN :contract_plan_id_list
AND rcp.business_id = :business_id
SQL;
        $param = [
            'contract_plan_id_list' => $contract_plan_id_list,
            'business_id'           => $business_id,
        ];

        parent::pre_find($query);
        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * PKを条件としてプラン情報を取得
     *
     * @param array $contract_plan_id_list
     * @param int   $business_id
     * @param int   $market_id
     * @param int   $version
     * @return array
     */
    public function get_plan_list_by_rel_contract_plan_id_and_market_id($contract_plan_id_list, $business_id, $market_id, $version) {
        $sql = <<<SQL
SELECT
    rcp.contract_plan_id,
    rcp.plan_id,
    rcp.plan_start_date,
    rcp.plan_end_date,
    rcp.order_sn,
    rcp.order_id,
    mpmp.name as plan_name,
    mpmp.price,
    mp.data_usage_limit,
    mp.plan_type,
    mcp.country_name
FROM
    rel_contract_plan AS rcp
INNER JOIN
    mst_plan as mp
ON  mp.plan_id = rcp.plan_id
AND mp.business_id = rcp.business_id
LEFT JOIN
    mst_continent_plan as mcp
ON  mcp.plan_id = mp.plan_id
AND mcp.business_id = mp.business_id
LEFT JOIN
    mst_plan_market_price as mpmp
ON  mpmp.plan_id = mp.plan_id
AND mpmp.business_id = mp.business_id
WHERE
    rcp.contract_plan_id IN :contract_plan_id_list
AND rcp.business_id = :business_id
AND mpmp.market_id = :market_id
AND mpmp.version = :version
SQL;
        $param = [
            'contract_plan_id_list' => $contract_plan_id_list,
            'business_id'           => $business_id,
            'market_id'             => $market_id,
            'version'               => $version,
        ];

        parent::pre_find($query);
        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * 削除する
     *
     * @param int $rel_contract_plan_id
     * @param int $business_id
     */
    public function delete_rel_contract_plan($rel_contract_plan_id, $business_id) {
        $sql = <<<SQL
DELETE FROM
    rel_contract_plan
WHERE
    contract_plan_id = :contract_plan_id
AND
    business_id = :business_id
SQL;

        $params = [
            'contract_plan_id' => $rel_contract_plan_id,
            'business_id'          => $business_id,
        ];

        parent::pre_find($query);
        DB::query($sql)->parameters($params)->execute();
    }

    /**
     * 汎用的に使用するSELECT（IN句非対応）
     *
     * @param array $select SELECT対象のカラム
     * @param array $wheres WHERE用の条件
     */
    public function get_records($select, $wheres) {
        $query = DB::select_array($select)->from(self::$_table_name);
        foreach($wheres as $key => $value){
            $query->where($key, $value);
        }
        $query->order_by(self::$_primary_key, 'DESC');

        return $query->execute()->as_array();
    }
}
