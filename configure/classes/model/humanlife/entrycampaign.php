<?php

/**
 * 申し込みーキャンペーンテーブルのモデルクラス
 */
class Model_HumanLife_EntryCampaign extends Model_CrudAbstract {
    /**
     * テーブル名
     *
     * @var string  請求書番号管理テーブル名
     */
    protected static $_table_name = 'entry_campaign';
    
    /**
     * プライマリキー
     * @var String
     */
    protected static $_primary_key = 'entry_campaign_id';
    
    /**
     * プライマリキーを条件に複数レコード取得する
     * @param String $id
     * @param array  $select 取得カラム名の配列
     * @return array|null 取得結果
     */
    public function get_record_by_entry_id($entry_id, $select = ['*']) {
        $query = DB::select_array($select)->from(self::$_table_name)
                                          ->join('mst_campaign', 'inner')
                                          ->on(self::$_table_name.'.campaign_id', '=', 'mst_campaign.campaign_id')
                                          ->where('entry_id','=', $entry_id);
                                          
        return $query->execute()->as_array();
    }

/**
 * 申込ID、プランIDからキャンペーン情報を取得する
 *
 * @param int $business_id
 * @param int $entry_id
 * @param int $plan_id
 * @return array
 */
    public function get_campaign_by_entry_id_plan_id($business_id, $entry_id, $plan_id)
    {
        $query = <<<SQL
SELECT
    entry_campaign.entry_campaign_id
    ,entry_campaign.entry_id
    ,mst_campaign.*
FROM
    entry_campaign
INNER JOIN
    mst_campaign
ON entry_campaign.campaign_id = mst_campaign.campaign_id
WHERE
    entry_campaign.entry_id = :entry_id
    AND entry_campaign.active_flg = :active_flg
    AND mst_campaign.business_id = :business_id
    AND mst_campaign.plan_id = :plan_id
ORDER BY
    entry_campaign.campaign_id DESC
SQL;

        $bind_params = [];
        $bind_params['entry_id'] = $entry_id;
        $bind_params['active_flg'] = FLG_ON;
        $bind_params['business_id'] = $business_id;
        $bind_params['plan_id'] = $plan_id;

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
            entry_campaign
        SQL;

        $bind_params = [];
        $set = '(';
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
    public function delete_entry_campaign($entry_id, $business_id) {
        $sql = <<<SQL
DELETE FROM
    entry_campaign
WHERE
    entry_id = :entry_id
SQL;

        $params = [
            'entry_id'     => $entry_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        DB::query($sql)->parameters($params)->execute();
    }

    /**
     * 申込IDからキャンペーン情報を取得する
     *
     * @param int $entry_id 申込ID
     * @return array 取得結果
     */
    public function get_campaign_by_entry_id($entry_id)
    {
        $query = <<<SQL
SELECT
    ec.entry_campaign_id
    , ec.entry_id
    , mc.campaign_id
    , mc.plan_id
    , mc.name
    , mc.discount_amount
    , mc.option_discount_amount
    , mc.device_discount_amount
    , mc.adjustment_money_id
    , mc.adjustment_discount_amount
FROM
    entry_campaign ec
    INNER JOIN mst_campaign mc
        ON ec.campaign_id = mc.campaign_id
WHERE
    ec.entry_id = :entry_id
    AND mc.active_flg = :active_flg
SQL;

        $bind_params = [
            'entry_id' => $entry_id,
            'active_flg' => FLG_ON,
        ];

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

}
