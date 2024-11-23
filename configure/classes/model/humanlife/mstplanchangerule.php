<?php

/**
 * プラン変更ルールマスタテーブルのモデルクラス
 */
class Model_HumanLife_MstPlanChangeRule extends Model_CrudAbstract {
    /**
     * 当該変更前プラン、変更操作日時から選択可能なプランを取得する
     *
     * @param $from_plan_id
     * @param $select_date_time
     * @param null $to_plan_id
     * @return array
     */
    public function get_available_change_to_plan_with_from_plan($from_plan_id, $select_date_time, $to_plan_id = null)
    {
        $query = <<<SQL
        SELECT
            mst_plan_change_rule_id,
            name,
            old_plan_id,
            new_plan_id,
            adjustment_money_id,
            is_closed,
            is_first_month_free,
            rule_start_date,
            rule_end_date,
            disp_order,
            create_datetime,
            create_user,
            update_datetime,
            update_user
        FROM
            mst_plan_change_rule
        WHERE
            old_plan_id = :old_plan_id
        AND rule_start_date <= :select_date_time
        AND
            (
                rule_end_date >= :select_date_time
                OR
                rule_end_date is NULL
            )

        SQL;
        if (!is_null($to_plan_id)) {
            $query .= 'AND new_plan_id= :new_plan_id' . PHP_EOL;
        }
        $query .= <<<SQL
        ORDER BY
            disp_order ASC
        SQL;

        $bind_params = [];
        $bind_params['old_plan_id'] = $from_plan_id;
        $bind_params['select_date_time'] = $select_date_time;
        if (!is_null($to_plan_id)) {
            $bind_params['new_plan_id'] = $to_plan_id;
        }
        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 当該選択前プラン、選択日時から選択可能なプランを取得する
     *
     * @param $select_date_time
     * @return array
     */
    public function get_available_change_to_plan($select_date_time)
    {
        $query = <<<SQL
        SELECT
            mst_plan_change_rule_id,
            name,
            old_plan_id,
            new_plan_id,
            adjustment_money_id,
            is_closed,
            rule_start_date,
            rule_end_date,
            disp_order,
            create_datetime,
            create_user,
            update_datetime,
            update_user
        FROM
            mst_plan_change_rule
        WHERE
            rule_start_date <= :select_date_time
        AND
            (
                rule_end_date >= :select_date_time
                OR
                rule_end_date is NULL
            )
        ORDER BY
            disp_order ASC
        SQL;

        $bind_params = [];
        $bind_params['select_date_time'] = $select_date_time;
        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 選択日時から選択可能なブランド変更プランを取得する
     *
     * @param $select_date_time
     * @return array
     */
    public function get_available_rebrand_plan($select_date_time)
    {
        $query = <<<SQL
        SELECT
            mst_plan_change_rule_id,
            name,
            old_plan_id,
            new_plan_id,
            adjustment_money_id,
            is_closed,
            is_first_month_free,
            rule_start_date,
            rule_end_date,
            disp_order,
            create_datetime,
            create_user,
            update_datetime,
            update_user
        FROM
            mst_plan_change_rule
        WHERE
            rule_start_date <= :select_date_time
        AND
            (
                rule_end_date >= :select_date_time
                OR
                rule_end_date is NULL
            )
        AND old_plan_id = :rebrand_plan
        ORDER BY
            disp_order ASC
        SQL;

        $bind_params = [];
        $bind_params['select_date_time'] = $select_date_time;
        $bind_params['rebrand_plan'] = FLG_OFF;
        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

}
