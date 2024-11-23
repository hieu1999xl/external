<?php

/**
 * プラン変更操作履歴テーブルのモデルクラス
 */
class Model_HumanLife_ContractPlanChangeApplication extends Model_CrudAbstract {
    private static $_table_name = 'contract_plan_change_application';

    /**
     * 契約-プランIDからプラン変更操作履歴情報を取得する
     *
     * @param $rel_contract_plan_id
     * @return array
     */
    public function get_by_rel_contract_plan_id($rel_contract_plan_id)
    {
        $query = <<<SQL
        SELECT
             contract_plan_change_application.*,
             imei.imei,
             GREATEST(IFNULL(contract_plan_change_application.cancel_datetime, 0), IFNULL(contract_plan_change_application.change_datetime, 0)) AS compare_time
        FROM
            contract_plan_change_application
        LEFT JOIN rel_contract_plan
            ON contract_plan_change_application.rel_contract_plan_id = rel_contract_plan.contract_plan_id
        LEFT JOIN contract
            ON rel_contract_plan.contract_id = contract.contract_id
        LEFT JOIN imei
            ON imei.contract_id = contract.contract_id
        WHERE
            contract_plan_change_application.rel_contract_plan_id = :rel_contract_plan_id
        ORDER BY
            compare_time DESC
        SQL;

        $bind_params = [];
        $bind_params['rel_contract_plan_id'] = $rel_contract_plan_id;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    //TODO:get_by_rel_contract_plan_idとget_by_rel_contract_plan_idsの統一検討
    /**
     * 複数の契約-プランIDからプラン変更操作履歴情報を取得する(法人向け)
     *
     * @param $rel_contract_plan_ids
     * @return array
     */
    public function get_by_rel_contract_plan_ids($rel_contract_plan_ids)
    {
        $query = <<<SQL
        SELECT
             contract_plan_change_application.*,
             imei.imei,
             GREATEST(IFNULL(contract_plan_change_application.cancel_datetime, 0), IFNULL(contract_plan_change_application.change_datetime, 0)) AS compare_time
        FROM
            contract_plan_change_application
        LEFT JOIN rel_contract_plan
            ON contract_plan_change_application.rel_contract_plan_id = rel_contract_plan.contract_plan_id
        LEFT JOIN contract
            ON rel_contract_plan.contract_id = contract.contract_id
        LEFT JOIN imei
            ON imei.contract_id = contract.contract_id
        WHERE
            contract_plan_change_application.rel_contract_plan_id IN :rel_contract_plan_ids
        ORDER BY
            compare_time DESC,
            contract_plan_change_application.rel_contract_plan_id ASC
        SQL;

        $bind_params = [];
        $bind_params['rel_contract_plan_ids'] = $rel_contract_plan_ids;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 複数の契約-プランIDそれぞれに紐づく最新の変更操作履歴を取得する(法人向け)
     *
     * @param $rel_contract_plan_ids
     * @return array
     */
    public function get_by_latest_rel_contract_plan_ids($rel_contract_plan_ids)
    {
        $query = <<<SQL
        SELECT
             *
        FROM
             (
                 SELECT *, IFNULL(cancel_datetime, change_datetime) AS compare_time
                 FROM contract_plan_change_application
                 WHERE rel_contract_plan_id in :rel_contract_plan_ids
             ) AS t1
        INNER JOIN
             (
                 SELECT rel_contract_plan_id, MAX(IFNULL(cancel_datetime, change_datetime))
                 AS compare_time
                 FROM contract_plan_change_application
                 WHERE rel_contract_plan_id in :rel_contract_plan_ids
                 GROUP BY rel_contract_plan_id
             ) AS t2
        ON
             t1.rel_contract_plan_id = t2.rel_contract_plan_id
        AND
             t1.compare_time = t2.compare_time
        SQL;

        $bind_params = [];
        $bind_params['rel_contract_plan_ids'] = $rel_contract_plan_ids;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * レコードをINSERTする
     *
     * @param $pairs
     * @return Database_Result_Cached|object
     */
    public function insert($pairs)
    {
        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }

    /**
     * プラン変更操作履歴IDから更新する
     *
     * @param $update_params
     * @param $contract_plan_change_application_id
     * @return Database_Result_Cached|object
     */
    public function update_by_contract_plan_change_application_id($update_params, $contract_plan_change_application_id)
    {
        $query = <<<SQL
        UPDATE
            contract_plan_change_application
        SET
            %s
        WHERE
            contract_plan_change_application_id = :contract_plan_change_application_id
        SQL;

        $bind_params = [];
        $bind_params['contract_plan_change_application_id'] = $contract_plan_change_application_id;

        $update_queries = [];
        foreach ($update_params as $key => $value) {
            $update_queries[] = $key . ' = :' . $key . PHP_EOL;
            $bind_params[$key] = $value;
        }

        $query = sprintf($query, implode(',',  $update_queries));

        return DB::query($query)->parameters($bind_params)->execute();
    }

    public function can_user_cancel_plan_change_application($user_id, $plan_change_application_id) {
        $sql = <<<SQL
SELECT
    COUNT(*) AS count
FROM
    contract_plan_change_application AS cpac
INNER JOIN rel_contract_plan rcp
    ON cpac.rel_contract_plan_id = rcp.contract_plan_id
INNER JOIN contract con
    ON rcp.contract_id = con.contract_id
WHERE
    con.user_id = :user_id
AND cpac.contract_plan_change_application_id = :application_id
AND cpac.status = :application_status
AND cpac.cancel_limit_date > now()
SQL;

        $params = [
            'user_id'     => $user_id,
            'application_id'      => $plan_change_application_id,
            'application_status' => PLAN_CHANGE_APPLICATION,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    public function cancel_contract_plan_change_application ($plan_change_application_id, $user_id) {

        // update
        $query = <<<SQL
UPDATE
    contract_plan_change_application
SET
    status = :cancel_status
  , cancel_datetime = now()
  , update_datetime = now()
  , update_user = :user_id
  , cancel_operator_side = :cancel_operator_side
WHERE
    contract_plan_change_application_id = :plan_change_application_id
SQL;

        $params = [
            'plan_change_application_id'  => $plan_change_application_id,
            'user_id'      => $user_id,
            'cancel_operator_side' => CHARGE_OPERATOR_SIDE_MY_PAGE,
            'cancel_status' => PLAN_CHANGE_CANCEL,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }
}
