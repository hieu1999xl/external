<?php

/**
 * キャンペーンURLパラメータテーブルのモデルクラス
 */
class Model_HumanLife_LimitedUrlCampaignCode extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string  キャンペーン対象者向け限定URLパラメータテーブル名
     */
    protected static $_table_name = 'limited_url_campaign_code';

    /**
     * 対象キャンペーンとURL内のコードを条件に有効なURLを取得する
     *
     * @param $params
     * @param $business_id
     * @return array
     */
    public function get_campaign_by_campaign_code($params, $business_id) {

        $query = <<<SQL
SELECT
    campaign_code,
    used_flag
FROM
    limited_url_campaign_code 
WHERE
    business_id = :business_id 
    AND campaign_group_id = :campaign_group_id 
    AND campaign_code = :campaign_code 
SQL;

        $bind_params = [
            'business_id'       => $business_id,
            'campaign_group_id' => $params['campaign_group_id'],
            'campaign_code'     => $params['campaign_code'],
        ];

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * キャンペーン対象者向け限定URLパラメータを使用済みにする
     *
     * @param $params
     * @param $business_id
     * @return array
     */
    public function update_used_flag_by_campaign_code($params, $business_id) {

        $query = <<<SQL
UPDATE limited_url_campaign_code 
SET
    used_flag = :used_flag
WHERE
    business_id = :business_id 
    AND campaign_group_id = :campaign_group_id 
    AND campaign_code = :campaign_code
SQL;

        $bind_params = [
            'business_id'       => $business_id,
            'campaign_group_id' => $params['campaign_group_id'],
            'campaign_code'     => $params['campaign_code'],
            'used_flag'         => $params['used_flag'],
        ];

        return DB::query($query)->parameters($bind_params)->execute();
    }
}
