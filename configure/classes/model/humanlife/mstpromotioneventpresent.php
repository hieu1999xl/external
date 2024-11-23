<?php

/**
 * キャンペーンイベントプレゼントマスタテーブルのモデルクラス
 */
class Model_HumanLife_MstPromotionEventPresent extends Model_CrudAbstract {
    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * キャンペーンイベントプレゼントプラン一覧を取得する
     *
     * @param $event_id
     * @param int $business_id
     * @return array
     */
    public function get_promotion_event_present_info_list($event_id, $business_id) {
        $sql = <<<SQL
SELECT
    *
FROM
    mst_promotion_event_present
WHERE
    business_id = :business_id
AND active_flg = :flag_on
AND promotion_event_id = :event_id
AND apply_start_datetime <= NOW()
AND (apply_end_datetime >= NOW() OR apply_end_datetime IS NULL)
ORDER BY
    display_order
SQL;

        $param = [
            'business_id' => $business_id,
            'event_id' => $event_id,
            'flag_on' => FLG_ON,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * キャンペーンイベントプレゼント情報を取得する
     *
     * @param $present_id
     * @param int $business_id
     * @return array
     */
    public function get_promotion_event_present_info($present_id, $business_id) {

        $sql = <<<SQL
SELECT
    *
FROM
    mst_promotion_event_present
WHERE
    business_id = :business_id
AND active_flg = :flag_on
AND promotion_event_present_id = :promtion_event_present_id
AND apply_start_datetime <= NOW()
AND (apply_end_datetime >= NOW() OR apply_end_datetime IS NULL)
ORDER BY
    display_order
SQL;

        $param = [
            'promtion_event_present_id'     => $present_id,
            'business_id' => $business_id,
            'flag_on' => FLG_ON,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

}
