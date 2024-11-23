<?php

/**
 * 申込ヤマト配送情報テーブルのモデルクラス
 *
 * @author kor.miyamoto
 */
class Model_HumanLife_EntryYamatoDeliveryInfo extends Model_CrudAbstract
{
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
    protected static $_table_name = 'entry_yamato_delivery_info';

    /**
     * プライマリキー
     * @var string カラム名
     */
    protected static $_primary_key = 'entry_yamato_delivery_id';

    /**
     * レコードをINSERTする
     *
     * @param array $params [{カラム名} => {値}]形式の連想配列
     * @return array [{プライマリキー}, {INSERTされたレコード数}]
     */
    public function insert($params)
    {
        return DB::insert(self::$_table_name)->set($params)->execute();
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

    /**
     * プライマリキーを指定して削除を行う
     * 
     * @param int $id プライマリキー
     */
    public function delete_record($id) {
        if (empty($id)) return 0;
        DB::delete(self::$_table_name)->where(self::$_primary_key, $id)->execute();
    }
}
