<?php

/**
 * ユーザーに紐づくプラン変更ルールテーブルのモデルクラス
 * mst_plan_change_rule.is_closed=1の場合はclosedでプラン変更施策を行う。
 * closed対象のユーザー・プラン変更ルールを管理する
 */
class Model_HumanLife_RelPlanChangeRule extends Model_CrudAbstract
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
     * @var string closedプラン変更ルール
     */
    protected static $_table_name = 'rel_plan_change_rule';

    /**
     * 該当user_id、プラン変更ルールIDでレコードを取得
     *
     * @param int $user_id
     * @param int $mst_plan_change_rule_id
     * @param string $rule_start_date
     * @param string $rule_end_date
     * @return array
     */
    public function get_record($user_id, $mst_plan_change_rule_id, $rule_start_date, $rule_end_date=null)
    {
        $query = <<<SQL
        SELECT
               *
        FROM
             rel_plan_change_rule
        WHERE
            user_id = :user_id
        AND mst_plan_change_rule_id = :mst_plan_change_rule_id
        AND rule_start_date <= :rule_start_date
        AND (rule_end_date IS NULL OR rule_end_date >= :rule_end_date)
        SQL;

        $bind_params = [];
        $bind_params['user_id'] = $user_id;
        $bind_params['mst_plan_change_rule_id'] = $mst_plan_change_rule_id;
        $bind_params['rule_start_date'] = $rule_start_date;
        $bind_params['rule_end_date'] = empty($rule_end_date) ? $rule_start_date : $rule_end_date;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

}
