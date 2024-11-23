<?php

/**
 * ユーザーデータ使用量管理テーブルのモデルクラス
 *
 * @author m.ishikawa@humaninvestment.jp
 */
class Model_HumanLife_UserUclDataManagement  extends Model_CrudAbstract
{

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string user_ucl_data_management
     */
    protected static $_table_name = 'user_ucl_data_management';

    /**
     * レコードをINSERTする
     *
     * @param array $params
     *            ['カラム名' => '値']形式の連想配列
     * @return number レコード数
     */
    public function insert($params) {
        $params['create_user'] = $params['create_user'] ?? SYSTEM_USER_NAME;
        $params['update_user'] = $params['update_user'] ?? SYSTEM_USER_NAME;
        return DB::insert(self::$_table_name)->set($params)->execute();
    }

    /**
     * レコードを取得する
     *
     * @param  array $select
     * @param  array $where_columns
     * @return array 取得結果
     */
    public function select($select, $where_columns) {
        $query = DB::select_array($select)->from(self::$_table_name);
        foreach ($where_columns as $key=>$val) {
            $query->where($key, $val);
        }

        return $query->execute()->current();
    }

    /**
     * レコードを更新する
     *
     * @param  array  $update_columns
     * @param  array  $where_columns
     * @return number レコード数
     */
    public function update($update_columns, $where_columns) {
        $query = DB::update(self::$_table_name);
        foreach ($update_columns as $key=>$val) {
            $query->value($key, $val);
        }
        foreach ($where_columns as $key2=>$val2) {
            $query->where($key2, $val2);
        }

        return $query->execute();
    }

    /**
     * UCLへデータを確認するための対象データを取得する(マイページ向け/国内)
     * @param int $user_id
     * @param int $business_id
     * @return $result 取得結果
     */
    public function get_user_data_usage_data_domestic_list($user_id, $business_id) {
        $query = <<<SQL
SELECT
    CASE WHEN uudm.plan_id IS NULL THEN rcp.plan_id
        ELSE uudm.plan_id
    END AS plan_id,
    mp.name AS name,
    mp.billing_type AS billing_type,
    CASE WHEN uudm.contract_plan_id IS NULL THEN rcp.contract_plan_id
        ELSE uudm.contract_plan_id
    END AS contract_plan_id,
    CASE WHEN uudm.plan_type IS NULL THEN mp.plan_type
        ELSE uudm.plan_type
    END AS plan_type,
    uudm.status,
    uudm.flow_byte,
    uudm.surplus_flow_byte,
    uudm.effective_time,
    uudm.expiry_time,
    rcp.plan_start_date,
    rcp.plan_end_date,
    rcp.create_datetime AS buy_date,
    uudm.update_datetime AS data_usage_updated_at
FROM
    rel_contract_plan AS rcp
INNER JOIN
    contract AS c ON c.contract_id = rcp.contract_id
INNER JOIN
    entry_plan AS ep ON c.entry_id = ep.entry_id
LEFT JOIN
    user_ucl_data_management AS uudm ON uudm.contract_plan_id = rcp.contract_plan_id AND uudm.plan_id = rcp.plan_id
INNER JOIN
    mst_plan AS mp ON mp.plan_id = rcp.plan_id
WHERE
    mp.plan_type IN :target_plan_types AND
    c.user_id = :user_id AND
    c.business_id = :business_id AND
    mp.plan_id != :no_data_plan_id
ORDER BY rcp.contract_plan_id ASC
SQL;

        $param['target_plan_types'] = DATA_CHARGE_PREPAID_PLAN_TYPE_LIST;
        $param['user_id'] = $user_id;
        $param['business_id'] = $business_id;
        $param['no_data_plan_id'] = PREPAID_PLAN_NO_CAPACITY_ENTRY_ID;
        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * UCLへデータを確認するための対象データを取得する(マイページ向け/海外)
     * @param int $user_id
     * @param int $business_id
     * @return $result 取得結果
     */
    public function get_user_data_usage_data_overseas_list($user_id, $business_id) {
        $query = <<<SQL
SELECT
    CASE WHEN uudm.plan_id IS NULL THEN rcp.plan_id
        ELSE uudm.plan_id
    END AS plan_id,
    mp.name AS name,
    mp.billing_type AS billing_type,
    CASE WHEN uudm.contract_plan_id IS NULL THEN rcp.contract_plan_id
        ELSE uudm.contract_plan_id
    END AS contract_plan_id,
    CASE WHEN uudm.plan_type IS NULL THEN mp.plan_type
        ELSE uudm.plan_type
    END AS plan_type,
    uudm.status,
    uudm.flow_byte,
    uudm.surplus_flow_byte,
    uudm.effective_time,
    uudm.expiry_time,
    uudm.management_id,
    rcp.plan_start_date,
    rcp.plan_end_date,
    rcp.create_datetime AS buy_date,
    uudm.update_datetime AS data_usage_updated_at,
    rcch.change_type,
    rcch.after_id,
    rcch.after_start_datetime,
    rcch.after_end_datetime,
    rcch.exec_datetime
FROM
    rel_contract_change_history AS rcch
INNER JOIN
    user_ucl_data_management AS uudm
    ON rcch.after_id = uudm.plan_id
    AND rcch.after_order_id = uudm.order_id
INNER JOIN
    rel_contract_plan AS rcp
    ON uudm.contract_plan_id = rcp.contract_plan_id
    AND uudm.contract_plan_id = rcp.contract_plan_id
INNER JOIN
    mst_plan AS mp
    ON mp.plan_id = rcp.plan_id
WHERE
    mp.plan_type IN :target_plan_types
    AND uudm.user_id = :user_id
ORDER BY
    rcch.exec_datetime DESC
SQL;

        $param['target_plan_types'] = INTERNATIONAL_PREPAID_PLAN_TYPE_LIST;
        $param['user_id'] = $user_id;
        $param['business_id'] = $business_id;
        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /*
     * UCLへデータを確認するための対象データを取得する(マイページ海外レンタル向け)
     * @param int $user_id
     * @param int $business_id
     * @return $result 取得結果
     */
    public function get_user_data_usage_data_list_for_rental($user_id, $business_id) {
        $query = <<<SQL
SELECT
    CASE WHEN uudm.plan_id IS NULL THEN rcp.plan_id
        ELSE uudm.plan_id
    END AS plan_id,
    mp.name AS name,
    mp.data_usage_limit,
    CASE WHEN uudm.contract_plan_id IS NULL THEN rcp.contract_plan_id
        ELSE uudm.contract_plan_id
    END AS contract_plan_id,
    CASE WHEN uudm.plan_type IS NULL THEN mp.plan_type
        ELSE uudm.plan_type
    END AS plan_type,
    uudm.status,
    uudm.flow_byte,
    uudm.surplus_flow_byte,
    uudm.effective_time,
    uudm.expiry_time,
    rcp.plan_start_date,
    rcp.plan_end_date,
    rcp.create_datetime AS buy_date,
    uudm.update_datetime AS data_usage_updated_at
FROM
    rel_contract_plan AS rcp
INNER JOIN
    contract AS c ON c.contract_id = rcp.contract_id
INNER JOIN
    entry_plan AS ep ON c.entry_id = ep.entry_id
LEFT JOIN
    user_ucl_data_management AS uudm ON uudm.contract_plan_id = rcp.contract_plan_id
INNER JOIN
    mst_plan AS mp ON mp.plan_id = rcp.plan_id
WHERE
    mp.plan_type = :target_plan_type AND
    c.user_id = :user_id AND
    c.business_id = :business_id
ORDER BY contract_plan_id ASC
SQL;

        $param['target_plan_type'] = PLAN_TYPE_INTERNATIONAL_RENTAL;
        $param['user_id'] = $user_id;
        $param['business_id'] = $business_id;
        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * ユーザUCL通信容量管理テーブルに登録する
     *
     * @param array   $param
     */
    public function insert_user_data_usage_data($param) {
        $query = <<<SQL
INSERT INTO
    user_ucl_data_management
(
    `user_id`,
    `user_entry_plan_id`,
    `plan_id`,
    `contract_plan_id`,
    `order_id`,
    `plan_type`,
    `status`,
    `flow_byte`,
    `surplus_flow_byte`,
    `effective_time`,
    `expiry_time`,
    `create_datetime`,
    `create_user`,
    `update_datetime`,
    `update_user`
)
VALUES
(
    :user_id,
    :user_entry_plan_id,
    :plan_id,
    :contract_plan_id,
    :order_id,
    :plan_type,
    :status,
    :flow_byte,
    :surplus_flow_byte,
    :effective_time,
    :expiry_time,
    :create_datetime,
    :create_user,
    :update_datetime,
    :update_user
)
SQL;

        $param['create_datetime'] = Helper_Time::getCurrentDateTime();
        $param['create_user'] = SYSTEM_USER_NAME;
        $param['update_datetime'] = Helper_Time::getCurrentDateTime();
        $param['update_user'] = SYSTEM_USER_NAME;

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }
}
