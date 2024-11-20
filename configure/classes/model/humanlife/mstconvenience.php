<?php

/**
 * コンビニマスタのモデルクラス
 *
 * @author ako.endo
 */
class Model_HumanLife_MstConvenience extends Model_CrudAbstract
{
    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string
     */
    protected static $_table_name = 'mst_convenience';

    /**
     * プライマリキー
     *
     * @var string カラム名
     */
    protected static $_primary_key = 'convenience_id';

    /**
     * 複数条件を指定して簡単なSELECTを行う
     * @param array $conditions 抽出条件
     * @param array $select 取得カラム
     * @return array 抽出結果
     */
    public function get_records($conditions, $select = ['*']) {
        $query = DB::select_array($select)->from(self::$_table_name);
        foreach ($conditions as $key => $value) {
            $query->where($key, $value);
        }
        return $query->execute()->as_array();
    }

    /**
     * entry_idを条件にコンビニ情報を取得する
     * 
     * @param array $entry_id
     * @return array 検索結果・単一レコード
     */
    public function get_records_by_entry_id($entry_id) {
        $query = <<<SQL
SELECT
    r.entry_id
    , m.airport_name
    , m.store_name
    , m.zipcode1
    , m.zipcode2
    , m.prefecture
    , m.city
    , m.town
    , m.block
    , m.building
FROM
    mst_convenience m
    INNER JOIN rel_entry_convenience r
        on m.convenience_id = r.convenience_id
WHERE
    r.entry_id = :entry_id
SQL;

        $bind_params = [
            'entry_id' => $entry_id,
        ];

        return DB::query($query)->parameters($bind_params)->execute()->current();
    }

    /**
     * コンビニ情報に追加情報を併せて取得する
     * 
     * @param array $conditions 抽出条件（mst_convenienceのカラム）
     * @param array $select 取得カラム（mst_convenienceのカラム）
     * @return array 抽出結果
     */
    public function get_records_with_additional_column($conditions, $select = ['*']) {
        // カラム名の編集・テーブルの指定
        $mc_conditions = $mc_select = [];
        foreach ($conditions as $key => $value) {
            $mc_conditions['mc.' . $key] = $value;
        }
        foreach ($select as $value) {
            $mc_select[] = 'mc.'.$value;
        }
        $mc_select[] = 'md.delivery_days';

        $query = DB::select_array($mc_select)->from(self::$_table_name . ' AS mc');
        $query->join('mst_delivery_info AS md', 'INNER')->on('mc.zipcode1', '=', 'md.zipcode1')->and_on('mc.zipcode2', '=', 'md.zipcode2');
        foreach ($mc_conditions as $key => $value) {
            $query->where($key, $value);
        }

        return $query->execute()->as_array();
    }
}
