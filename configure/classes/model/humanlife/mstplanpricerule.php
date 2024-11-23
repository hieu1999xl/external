<?php

/**
 * プランプライスルールマスタテーブルのモデルクラス
 *
 * @author t.nagaoka@humanlife.co.jp
 */
class Model_HumanLife_MstPlanPriceRule extends Model_CrudAbstract
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
     * @var string 法人テーブル名
     */
    protected static $_table_name = 'mst_plan_price_rule';

    /**
     * プランIDに紐づくレコード一覧を返す
     *
     * @param $plan_id
     * @param $business_id
     * @return array
     */
    public function get_list_by_plan_id($plan_id, $business_id) {
        $select = [
            'price_rule_id',
            'plan_id',
            'name',
            'minimum_usage_gb',
            'maximum_usage_gb',
            'price',
        ];

        $query = DB::select_array($select)->from(self::$_table_name)
            ->where('plan_id', $plan_id)
            ->where('business_id', $business_id);

        return $query->execute()->as_array();
    }
}
