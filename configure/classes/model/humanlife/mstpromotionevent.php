<?php

/**
 * キャンペーンイベントマスタテーブルのモデルクラス
 */
class Model_HumanLife_MstPromotionEvent extends Model_CrudAbstract {
    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * キャンペーンイベントプラン一覧を取得する
     *
     * @param int $business_id
     * @return array
     */
    public function get_promotion_event_info_list($business_id) {
        $sql = <<<SQL
SELECT
    *
FROM
    mst_promotion_event
WHERE
    business_id = :business_id
AND active_flg = :flag_on
SQL;

        $param = [
            'business_id' => $business_id,
            'flag_on' => FLG_ON,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * キャンペーンイベント情報を取得する
     *
     * @param $event_code
     * @param int $business_id
     * @return array
     */
    public function get_promotion_event_info($event_code, $business_id) {
        $sql = <<<SQL
SELECT
    *
FROM
    mst_promotion_event
WHERE
    code = :code
AND
    business_id = :business_id
AND event_start_datetime <= NOW()
AND (event_end_datetime >= NOW() OR event_end_datetime IS NULL)
SQL;

        $param = [
            'code'     => $event_code,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

}
