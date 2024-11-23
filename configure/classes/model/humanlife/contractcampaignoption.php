<?php

/**
 * 契約－オプションキャンペーンテーブルのモデルクラス
 *
 * @author ako.endo
 */
class Model_HumanLife_ContractCampaignOption extends Model_CrudAbstract
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
    protected static $_table_name = 'contract_campaign_option';

    /**
     * プライマリキー
     * @var string カラム名
     */
    protected static $_primary_key = 'contract_campaign_option_id';

    /**
     * 指定年月から適用済の契約-キャンペーン情報を取得する
     *
     * @param int $contract_id 契約ID
     * @param int $option_id オプションID
     * @param date $target_date 指定日付
     * @return array
     */
    public function get_apply_contract_campaign_option_by_year_month($contract_id, $option_id, $target_year_month)
    {
        $query = <<<SQL
SELECT
    c.contract_campaign_option_id
    , c.contract_id
    , c.campaign_option_id
    , c.apply_start_year_month
    , c.apply_end_year_month
    , c.discount_amount
    , c.active_flg
    , m.option_id
    , m.name AS campaign_name
    , m.campaign_start_datetime
    , m.campaign_end_datetime
    , m.apply_start_month_count
    , m.apply_end_month_count
    , m.discount_amount AS campaign_discount_amount
    , m.active_flg AS campaign_active_flg
FROM
    contract_campaign_option AS c
    INNER JOIN mst_campaign_option AS m
        ON c.campaign_option_id = m.campaign_option_id
WHERE
    c.contract_id = :contract_id
    AND c.active_flg = :active_flg
    AND c.apply_start_year_month <= :target_year_month
    AND (
        c.apply_end_year_month is null
        OR c.apply_end_year_month >= :target_year_month
    )
    AND m.option_id = :option_id
SQL;

        $bind_params = [];
        $bind_params['contract_id'] = $contract_id;
        $bind_params['active_flg'] = FLG_ON;
        $bind_params['target_year_month'] = $target_year_month;
        $bind_params['option_id'] = $option_id;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 登録する
     *
     * @param array $pairs
     */
    public function insert($pairs)
    {
        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }

    /**
     * 契約IDとオプションIDで契約オプションキャンペーンを取得する
     *
     * @param int $contract_id
     * @param mixed $option_id
     *
     * @return array
     */
    public function get_contract_campaign_option_by_contract_id_and_option_id($contract_id, $option_id)
    {
        $query = DB::select('cco.*')
        ->from([self::$_table_name, 'cco'])
        ->join(['mst_campaign_option', 'mco'])
            ->on('cco.campaign_option_id', '=', 'mco.campaign_option_id')
        ->where('cco.contract_id', $contract_id)
        ->where('cco.active_flg', FLG_ON);

        if (is_array($option_id)) {
            $query->where('mco.option_id', 'in', $option_id);
        } else {
            $query->where('mco.option_id', $option_id);
        }

        return $query->execute()->as_array();
    }

    /**
     * 更新する
     *
     * @param array $params
     * @param array $wheres
     */
    public function update($params, $wheres)
    {
        return DB::update(self::$_table_name)->set($params)->where($wheres)->execute();
    }
}
