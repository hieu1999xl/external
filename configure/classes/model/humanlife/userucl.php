<?php

/**
 * ユーザUclテーブルのモデルクラス
 */
class Model_HumanLife_UserUcl extends Model_CrudAbstract {

    /**
     * テーブル名
     *
     * @var string IMEI
     */
    protected static $_table_name = 'user_ucl';

    /**
     * User IDを元に、data_usage_infoを取得する
     *
     * @param string $user_id
     * @return array 取得結果
     */
    public function get_data_usage_info($user_id)
    {
        $query = <<<SQL
        SELECT
            uu.contract_id,
            uu.first_day_hour_ident,
            uu.last_month_total_data_usage,
            uu.early_month_total_data_usage,
            uu.middle_month_total_data_usage,
            uu.late_month_total_data_usage,
            uu.data_usage_updated_at,
            uu.daily_data_usage_kb,
            mp.plan_type,
            mp.pay_as_you_go_type
        FROM
            user_ucl uu
        INNER JOIN
            rel_contract_plan rcp
        ON
            uu.contract_id = rcp.contract_id
        AND
            rcp.delete_flag = :delete_flag
        INNER JOIN
            mst_plan mp
        ON
            rcp.plan_id = mp.plan_id
        AND
            mp.delete_flag = :delete_flag
        WHERE
            uu.user_id = :user_id
        ORDER BY
            uu.data_usage_updated_at DESC
        SQL;

        $bind_params = [];
        $bind_params['user_id'] = $user_id;
        $bind_params['delete_flag'] = FLG_OFF;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    /**
     * User IDを元に、data_usage_infを取得する
     *
     * @param string $user_id
     * @return array 取得結果
     */
    public function get_corp_user_data_usage_info($user_id)
    {
        $query = <<<SQL
SELECT
    uu.contract_id,
    uu.first_day_hour_ident,
    uu.last_month_total_data_usage,
    uu.early_month_total_data_usage,
    uu.middle_month_total_data_usage,
    uu.late_month_total_data_usage,
    uu.data_usage_updated_at,
    uu.daily_data_usage_kb,
    mp.plan_type,
    mp.pay_as_you_go_type
FROM
    user_ucl uu
INNER JOIN
    rel_contract_plan rcp
ON
    uu.contract_id = rcp.contract_id
AND
    rcp.delete_flag = :delete_flag
INNER JOIN
    mst_plan mp
ON
    rcp.plan_id = mp.plan_id
AND
    mp.delete_flag = :delete_flag
WHERE
    uu.user_id = :user_id
ORDER BY
    uu.data_usage_updated_at DESC
SQL;

        $bind_params = [];
        $bind_params['user_id'] = $user_id;
        $bind_params['delete_flag'] = FLG_OFF;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    /**
     * 従量課金のプランで契約しているuser_ucl一覧をuser_idで取得する
     * @param $user_id
     * @param $business_id
     * @return array
     */
    public function get_pay_as_you_go_list_by_user_id($user_id, $business_id) {
        $query = <<<SQL
SELECT
    uu.daily_data_usage_kb
    , uu.contract_id
    , mp.plan_id
    , mp.name AS plan_name
    , mp.pay_as_you_go_daily_price
    , mp.pay_as_you_go_type
    , i.imei
FROM
    user_ucl uu
INNER JOIN
    rel_contract_plan rcp
ON
    uu.contract_id = rcp.contract_id
AND
    rcp.delete_flag = :delete_flg
INNER JOIN
    mst_plan mp
ON
    rcp.plan_id = mp.plan_id
AND
    mp.delete_flag = :delete_flg
LEFT JOIN
    imei i
ON
    uu.contract_id = i.contract_id
AND
    i.delete_flag = :delete_flg
WHERE
    uu.user_id = :user_id
AND
    rcp.business_id = :business_id
AND
    mp.pay_as_you_go_type IS NOT NULL
ORDER BY
    mp.pay_as_you_go_type, mp.plan_id, uu.contract_id
SQL;
        $bind_params = [];
        $bind_params['user_id'] = $user_id;
        $bind_params['business_id'] = $business_id;
        $bind_params['delete_flg'] = FLG_OFF;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    /**
     * レコードをINSERTする
     *
     * @param array $pairs
     *            ['カラム名' => '値']形式の連想配列
     * @return number レコード数
     */
    public function insert($pairs)
    {
        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }

    /**
     * 契約IDを元に、user_codeを取得する
     *
     * @param string $contract_id
     * @return array 取得結果
     */
    public function get_user_code($contract_id)
    {
        $query = <<<SQL
        SELECT
            user_code
        FROM
            user_ucl
        WHERE
            contract_id = :contract_id
        SQL;

        $bind_params = [];
        $bind_params['contract_id'] = $contract_id;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

}
