<?php

/**
 * 確定契約-プラン変更履歴テーブルのモデルクラス
 *
 */
class Model_HumanLife_RelContractPlanHistory extends Model_CrudAbstract
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
     * @var string 契約－プランテーブル名
     */
    protected static $_table_name = 'rel_contract_plan_history';

    /**
     * 該当契約ID、月初プラン変更処理完了有無でレコードを取得
     *
     * @param $user_id
     * @param null $contract_id
     * @param null $is_plan_change_process_done
     * @return array
     */
    public function get_record($user_id, $contract_id = null, $is_plan_change_process_done = null)
    {
        $query = <<<SQL
        SELECT
               *
        FROM
             rel_contract_plan_history
        WHERE
              user_id = :user_id
        SQL;

        $bind_params = [];
        $bind_params['user_id'] = $user_id;
        if ($contract_id !== null) {
            $bind_params['contract_id'] = $contract_id;
            $query .= ' AND contract_id = :contract_id';
        }
        if ($is_plan_change_process_done !== null) {
            $bind_params['is_plan_change_process_done'] = $is_plan_change_process_done;
            $query .= ' AND is_plan_change_process_done = :is_plan_change_process_done';
        }

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 該当契約ID、月初プラン変更処理完了有無でレコードを取得(契約IDの昇順に)
     *
     * @param $user_id
     * @param null $contract_id
     * @param null $is_plan_change_process_done
     * @return array
     */
    public function get_record_with_rel_contract_plan_ids_and_is_plan_change_process_done($rel_contract_plan_ids, $is_plan_change_process_done = null)
    {
        $query = <<<SQL
        SELECT
            *
        FROM
            rel_contract_plan_history
        WHERE
            rel_contract_plan_id in :rel_contract_plan_ids
        SQL;

        $bind_params = [];
        $bind_params['rel_contract_plan_ids'] = $rel_contract_plan_ids;
        if ($is_plan_change_process_done !== null) {
            $bind_params['is_plan_change_process_done'] = $is_plan_change_process_done;
            $query .= ' AND is_plan_change_process_done = :is_plan_change_process_done' . PHP_EOL;
        }
        $query .= <<<SQL
        ORDER BY
            contract_id ASC,
            plan_start_date DESC
        SQL;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }
}
