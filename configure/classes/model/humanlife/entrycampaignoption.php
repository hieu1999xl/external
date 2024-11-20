<?php

/**
 * 申し込みーキャンペーンテーブルのモデルクラス
 */
class Model_HumanLife_EntryCampaignOption extends Model_CrudAbstract {

/**
 * 申込ID、オプションIDからオプションキャンペーン情報を取得する
 *
 * @param int $business_id
 * @param int $entry_id
 * @param int $option_id
 * @return array
 */
    public function get_campaign_by_entry_id_option_id($business_id, $entry_id, $option_id) {

        $query = <<<SQL
SELECT
    e.entry_campaign_option_id
    , e.entry_id
    , m.campaign_option_id
    , m.option_id
    , m.name
    , m.confirm_display_name
    , m.mng_display_name
    , m.campaign_start_datetime
    , m.campaign_start_datetime
    , m.campaign_end_datetime
    , m.apply_start_month_count
    , m.apply_end_month_count
    , m.discount_amount
    , m.campaign_type
    , m.campaign_introduction
    , m.external_service_set_id 
FROM
    entry_campaign_option e 
    INNER JOIN mst_campaign_option m 
        ON e.campaign_option_id = m.campaign_option_id 
WHERE
    e.entry_id = :entry_id 
    AND e.active_flg = :active_flg 
    AND m.business_id = :business_id 
    AND m.option_id = :option_id 
ORDER BY
    e.entry_campaign_option_id DESC
SQL;

        $bind_params = [];
        $bind_params['entry_id'] = $entry_id;
        $bind_params['active_flg'] = FLG_ON;
        $bind_params['business_id'] = $business_id;
        $bind_params['option_id'] = $option_id;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 登録する
     *
     * @param array $insert_params
     * @return number
     */
    public function insert($insert_params) {

        $query = <<<SQL
INSERT INTO
    entry_campaign_option
SQL;

        $bind_params = [];
        $set = ' (';
        $val = ') VALUES (';
        $is_first = true;
        foreach ($insert_params as $column => $value) {
            if (!$is_first) {
                $set .= ', ';
                $val .= ', ';
            }

            $set .= $column;
            $val .= ':' . $column;
            $bind_params[$column] = $value;
            $is_first = false;
        }
        $val .= ')';

        $query = $query . $set . $val;
        return DB::query($query)->parameters($bind_params)->execute()[0];
    }

    /**
     * 削除する
     *
     * @param $entry_id
     * @param $business_id
     * @return void
     */
    public function delete_entry_campaign_option($entry_id, $business_id) {

        $sql = <<<SQL
DELETE 
FROM
    entry_campaign_option 
WHERE
    entry_id = :entry_id
SQL;

        $params = [
            'entry_id'     => $entry_id,
            'business_id' => $business_id,
        ];

        DB::query($sql)->parameters($params)->execute();
    }

    /**
     * 申込IDからキャンペーン情報を取得する
     *
     * @param int $business_id 事業者ID
     * @param int $entry_id 申込ID
     * @return array 取得結果
     */
    public function get_campaign_option_by_entry_id($business_id, $entry_id)
    {

        $query = <<<SQL
SELECT
    e.entry_campaign_option_id
    , e.entry_id
    , m.campaign_option_id
    , m.option_id
    , m.apply_condition_type
    , m.conditions
    , m.name
    , m.confirm_display_name
    , m.mng_display_name
    , m.campaign_start_datetime
    , m.campaign_end_datetime
    , m.apply_start_month_count
    , m.apply_end_month_count
    , m.discount_amount
    , m.campaign_type
    , m.campaign_introduction
    , m.external_service_set_id 
FROM
    entry_campaign_option e 
    INNER JOIN mst_campaign_option m 
        ON e.campaign_option_id = m.campaign_option_id 
WHERE
    e.entry_id = :entry_id 
    AND m.business_id = :business_id 
    AND m.active_flg = :active_flg 
ORDER BY
    e.entry_campaign_option_id DESC
SQL;

        $bind_params = [];
        $bind_params['entry_id'] = $entry_id;
        $bind_params['business_id'] = $business_id;
        $bind_params['active_flg'] = FLG_ON;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }
    
}
