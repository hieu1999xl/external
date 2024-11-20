<?php

/**
 * キャンペーンマスタテーブルのモデルクラス
 */
class Model_HumanLife_MstCampaignOption extends Model_CrudAbstract {
    /**
     * データソース名
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     * @var string テーブル名
     */
    protected static $_table_name = 'mst_campaign_option';

    /**
     * プライマリキー
     * @var string カラム名
     */
    protected static $_primary_key = 'campaign_option_id';

    /**
     * オプションのキャンペーン情報を取得する
     *
     * @param integer $business_id 事業者ID
     * @param array   $campaign_type キャンペーンタイプ
     * @return array キャンペーンマスタの連想配列 ※プライマリキーを配列のキーとする
     */
    public static function get_mst_campaign_option_list_by_type($campaign_type) {
        // キャンペーンマスタを取得
        $query = <<<SQL
SELECT
    campaign_option_id
    , option_id
    , name
    , confirm_display_name
    , mng_display_name
    , campaign_start_datetime
    , campaign_end_datetime
    , apply_start_month_count
    , apply_end_month_count
    , discount_amount
    , campaign_introduction
FROM
    mst_campaign_option
WHERE
    business_id = :business_id
    AND active_flg = :active_flg
    AND campaign_start_datetime <= NOW()
    AND (
        campaign_end_datetime > NOW()
        OR campaign_end_datetime IS NULL
    )
    AND external_service_set_id IS NULL
    AND campaign_type IN :campaign_type
ORDER BY
    campaign_option_id
SQL;

        $param = [
            'business_id' => BUSINESS_ID,
            'active_flg' => FLG_ON,
            'campaign_type' => $campaign_type,
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array(self::$_primary_key);
        return parent::post_find($result);
    }

}
