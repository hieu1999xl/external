<?php

/**
 * プラン市価マスタテーブルのモデルクラス
 *
 * @author m.ishikawa@humanlife.co.jp
 */
class Model_HumanLife_MstPlanMarketPrice extends Model_CrudAbstract
{
    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string プラン市価マスタテーブル名
     */
    protected static $_table_name = 'mst_plan_market_price';

    /**
     * plan_idを元にマスター情報を取得
     *
     * @param  int    $plan_id
     * @param  int    $market_id
     * @param  int    $version
     * @return array
     */
    public function get_mst_data_by_plan_id($plan_id, $market_id, $version) {

        $query = <<<SQL
SELECT *
FROM mst_plan_market_price
WHERE plan_id = :plan_id

SQL;
        $params = [
            'plan_id' => $plan_id
        ];

        // マーケットID
        if (!empty($market_id)) {
            $params['market_id'] = $market_id;
            $query .= <<<SQL
AND market_id = :market_id

SQL;
        }

        // バージョン
        if (!empty($version)) {
            $params['version'] = $version;
            $query .= <<<SQL
AND version = :version

SQL;
        }

        $result = DB::query($query)->parameters($params)->execute()->as_array();
        return $result;
    }

    /**
     * market_price_idに紐づく情報を返す
     *
     * @param $market_price_id
     * @param $business_id
     * @return array
     */
    public function get_plan_market_price_info($market_price_id, $business_id) {
        $query = <<<SQL
SELECT
    *
FROM
    mst_plan_market_price
WHERE
    business_id = :business_id
    AND market_price_id = :market_price_id

SQL;

        $param = [
            'business_id' => $business_id,
            'market_price_id' => $market_price_id
        ];

        parent::pre_find($query);
        return DB::query($query)->parameters($param)->execute()->current();
    }
}
