<?php

/**
 * 契約ーキャンペーンテーブルのモデルクラス
 *
 * @author kunita@liz-inc.co.jp
 */
class Model_HumanLife_ContractCampaign extends Model_CrudAbstract
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
     * @var string テーブル名
     */
    protected static $_table_name = 'contract_campaign';

    /**
     * 指定年月から適用済の契約-キャンペーン情報を取得する
     *
     * @param int $contract_id 契約ID
     * @param int $plan_id プランID
     * @param date $target_date 指定日付
     * @return array
     */
    public function get_apply_contract_campaign_by_year_month($contract_id, $plan_id, $target_year_month)
    {
        $query = <<<SQL
SELECT
    cc.contract_campaign_id
    , cc.contract_id
    , cc.campaign_id
    , cc.apply_start_year_month
    , cc.apply_end_year_month
    , cc.discount_amount
    , cc.option_discount_amount
    , cc.active_flg
    , mc.plan_id
    , mc.name AS campaign_name
    , mc.campaign_start_datetime
    , mc.campaign_end_datetime
    , mc.apply_start_month_count
    , mc.apply_end_month_count
    , mc.discount_amount AS campaign_discount_amount
    , mc.adjustment_money_id AS campaign_adjustment_money_id
    , mc.adjustment_discount_amount AS campaign_adjustment_discount_amount
    , mc.active_flg AS campaign_active_flg
FROM
    contract_campaign AS cc
INNER JOIN
    mst_campaign AS mc
ON
    cc.campaign_id = mc.campaign_id
WHERE
    cc.contract_id = :contract_id
    AND cc.active_flg = :active_flg
    AND cc.apply_start_year_month <= :target_year_month
    AND (
        cc.apply_end_year_month is null
        OR cc.apply_end_year_month >= :target_year_month
    )
    AND mc.plan_id = :plan_id
SQL;

        $bind_params = [];
        $bind_params['contract_id'] = $contract_id;
        $bind_params['active_flg'] = FLG_ON;
        $bind_params['target_year_month'] = $target_year_month;
        $bind_params['plan_id'] = $plan_id;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 契約IDから契約-キャンペーン情報を取得する
     *
     * @param int $business_id 事業者ID
     * @param int $contract_id 契約ID
     * @param int $external_service_set_id セット販売ID
     * @return array 取得結果
     */
    public function get_contract_campaign_by_contract_id($business_id, $contract_id, $external_service_set_id = null)
    {
        $query = <<<SQL
SELECT
    contract_campaign.contract_campaign_id
    ,contract_campaign.contract_id
    ,contract_campaign.campaign_id
    ,contract_campaign.apply_start_year_month
    ,contract_campaign.apply_end_year_month
    ,contract_campaign.discount_amount
    ,contract_campaign.active_flg
    ,mst_campaign.plan_id
    ,mst_campaign.name AS campaign_name
    ,mst_campaign.campaign_start_datetime
    ,mst_campaign.campaign_end_datetime
    ,mst_campaign.apply_start_month_count
    ,mst_campaign.apply_end_month_count
    ,mst_campaign.discount_amount AS campaign_discount_amount
    ,mst_campaign.active_flg AS campaign_active_flg
FROM
    contract_campaign
INNER JOIN
    mst_campaign
ON contract_campaign.campaign_id = mst_campaign.campaign_id
WHERE
    contract_campaign.contract_id = :contract_id
    AND contract_campaign.active_flg = :active_flg
SQL;

        $bind_params = [];
        $bind_params['contract_id'] = $contract_id;
        $bind_params['active_flg'] = FLG_ON;

        // セット販売IDがnullだったら、セット販売に向けたキャンペーンを取得しない条件を追加
        if($external_service_set_id === null) {
            $query .= <<<SQL
    AND mst_campaign.external_service_set_id IS NULL 
SQL;
        } else {
            $query .= <<<SQL
    AND mst_campaign.external_service_set_id = :external_service_set_id
SQL;

            $bind_params['external_service_set_id'] = $external_service_set_id;
        }

        $query .= <<<SQL
ORDER BY
    contract_campaign.campaign_id DESC
SQL;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * contract_idをキーにキャンペーン情報を取得する
     * @param int   $contract_id
     * @param array $select      取得するカラム名の配列
     * @return array
     */
    public function get_campaign_info_by_contract_id($contract_id, array $select = ['*']){
        
        $query = DB::select_array($select)->from(self::$_table_name)
                                          ->join('mst_campaign', 'INNER')
                                          ->on(self::$_table_name.'.campaign_id', '=', 'mst_campaign.campaign_id')
                                          ->where('contract_id', $contract_id);
        return $query->execute()->as_array();
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
            contract_campaign
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
     * 契約キャンペーンIDから更新する
     *
     * @param int $contract_campaign_id 契約キャンペーンID
     * @param array $update_params 更新パラメータ
     * @return void
     */
    public function update_by_contract_campaign_id($contract_campaign_id, $update_params)
    {
        $set_phrase = $this->get_set_phrase($update_params);
        $query = <<<SQL
UPDATE
    contract_campaign
SET
    $set_phrase
WHERE
    contract_campaign_id = :contract_campaign_id
SQL;

        $params = [
            'contract_campaign_id' => $contract_campaign_id,
        ];
        $param = array_merge($params, $update_params);

        parent::pre_update($query);
        $result = DB::query($query)->parameters($param)->execute();
        return parent::post_update($result);
    }

    /**
     * contract_idとcampaign_idにひもづいたレコードを更新する
     * @param String $contract_id
     * @param Array  $campaign_ids
     * @param Array  $set_params  'カラム名'=>'更新値'の連想配列
     * @return number
     */
    public function update_by_contract_id_and_campaign_ids($contract_id, $campaign_ids, $set_params){
        return  DB::update(self::$_table_name)->set($set_params)
                                              ->where('contract_id', '=', $contract_id)
                                              ->where('campaign_id', 'in', $campaign_ids)
                                              ->execute();
    }

    /**
     * キャンペーン適用終了年月をオプション契約終了年月に更新する
     * @param String $contract_id
     * @param Array  $campaign_ids
     * @param Array  $set_params  'カラム名'=>'更新値'の連想配列
     * @return number
     */
    public function update_apply_end_with_option_end($contract_id, $campaign_ids, $set_params){

        // オプション契約終了年月
        $apply_end_year_month = $set_params['apply_end_year_month'];
        // キャンペーン適用終了年月を更新
        $query = DB::update(self::$_table_name)->set($set_params)
                                               ->where('contract_id', '=', $contract_id)
                                               ->where('campaign_id', 'in', $campaign_ids);
        $query->and_where(function($query) use ($apply_end_year_month) {
            $query->where('apply_end_year_month', '=', null)
                  ->or_where('apply_end_year_month', '>', $apply_end_year_month);
        });
        return $query->execute();

    }

    /**
     * 更新SQLのSET句を取得する
     *
     * @param array $params
     * @return string
     */
    private function get_set_phrase($params) {
        $res = '';

        foreach ($params as $key => $param) {
            if ($res !== '') {
                $res .= ', ';
            }

            $res .= $key . ' = :' . $key;
        }

        return $res;
    }
}
