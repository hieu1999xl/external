<?php

/**
 * キャンペーンマスタテーブルのモデルクラス
 */
class Model_HumanLife_MstSalesPartner extends Model_CrudAbstract {
    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * プランIDから期間内で有効なキャンペーンを取得する
     *
     * @param int $business_id 事業者ID
     * @param int $plan_id プランID
     * @return array キャンペーンマスタ情報
     */
    public static function get_mst_sales_partner_by_inflow_source($business_id, $source, $medium) {
        $sql = <<<SQL
SELECT
    *
FROM
    mst_sales_partner
WHERE
    business_id = :business_id
AND source = :source
AND medium = :medium
AND active_flg = :active_flg

SQL;

        $param = [
            'business_id'  => $business_id,
            'source' => $source,
            'medium' => $medium,
            'active_flg' => FLG_ON,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }


}
