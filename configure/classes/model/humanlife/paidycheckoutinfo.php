<?php

/**
 * PaidyCheckout情報テーブルのモデルクラス
 * 
 * @author ako.endo
 */
class Model_HumanLife_PaidyCheckoutInfo extends Model_CrudAbstract {

    /**
     * データソース名
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     * @var string テーブル名
     */
    protected static $_table_name = 'paidy_checkout_info';

    /**
     * プライマリキー
     * @var string カラム名
     */
    protected static $_primary_key = 'paidy_checkout_info_id';

    /**
     * レコードをINSERTする
     *
     * @param array $params [{カラム名} => {値}]形式の連想配列
     * @return array [{プライマリキー}, {INSERTされたレコード数}]
     */
    public function insert($params) {
        return DB::insert(self::$_table_name)->set($params)->execute();
    }

    /**
     * 複数条件を指定して簡単なSELECTを行う
     * @param array $select 取得カラム
     * @param array $wheres 検索条件[0 => [{カラム名} => {値}], 1 => ...]
     * @param array $order ソート条件 [0 => [{カラム名} => {昇順/降順}]]
     * @return array 抽出結果
     */
    public function get_record($select, $wheres, $order = []) {
        if (empty($wheres)) return [];
        $query = DB::select_array($select)->from(self::$_table_name);
        foreach ($wheres as $key => $value) {
            $query->where($key, $value);
        }
        foreach ($order as $key => $value) {
            $query->order_by($key, $value);
        }
        return $query->execute()->as_array();
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
}
