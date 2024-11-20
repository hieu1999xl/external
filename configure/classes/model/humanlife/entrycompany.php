<?php

/**
 * 申し込みテーブルのモデルクラス
 */
class Model_HumanLife_EntryCompany extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string
     */
    protected static $_table_name = 'entry_company';

    /**
     * プライマリキー
     * @var string
     */
    protected static $_primary_key = 'entry_company_id';

    /**
     * 登録する
     *
     * @param array $insert_params
     * @return int 登録件数
     */
    public function insert($insert_params) {
        
        // insert
        $query = <<<SQL
        INSERT INTO
            entry_company
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
        return DB::query($query)->parameters($bind_params)->execute();
    }

    /**
     * 更新する
     *
     * @param array $params 更新用のパラメータ[0 => [{カラム名} => {値}], 1 => ...]
     * @param array $wheres 更新対象の条件[0 => [{カラム名} => {値}], 1 => ...]
     * @return int 更新されたレコード数
     */
    public function update($params, $wheres)
    {
        if (empty($wheres)) return 0;
        return DB::update(self::$_table_name)->set($params)->where($wheres)->execute();
    }

    /**
     * 申込IDを条件に端末初期費用マスタを取得する
     *
     * @param int $business_id
     * @param int $entry_id
     * @return array 抽出結果の1次元配列 ※テーブル内にentry_idが同じ行は存在しない想定
     */
    public function get_mst_device_init_by_entry_id($business_id, $entry_id) {
        $sql = <<<SQL
SELECT
    m.device_init_id
    , m.device_id
    , m.name
    , m.price
    , m.tax_type 
FROM
    entry_company AS e 
    INNER JOIN mst_device_init AS m 
        ON m.device_id = e.device_id 
        AND m.business_id = e.business_id 
WHERE
    e.entry_id = :entry_id
    AND e.business_id = :business_id
SQL;

        $params = [
            'entry_id'    => $entry_id,
            'business_id' => $business_id,
        ];

        return DB::query($sql)->parameters($params)->execute()->current();
    }

    /**
     * 複数条件を指定して簡単なSELECTを行う
     * @param array $select 取得カラム
     * @param array $wheres 検索条件[0 => [{カラム名} => {値}], 1 => ...]
     * @return array 抽出結果
     */
    public function get_record($select, $wheres) {
        if (empty($wheres)) return [];
        $query = DB::select_array($select)->from(self::$_table_name);
        foreach ($wheres as $key => $value) {
            $query->where($key, $value);
        }
        return $query->execute()->as_array();
    }
}
