<?php

/**
 * アイマスクのロジッククラス
 *
 * @author chan-chipong@humanlife.co.jp
 */
class Model_HumanLife_EntryEyemask extends Model_CrudAbstract
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
     * @var string 申込-アイマスクテーブル名
     */
    protected static $_table_name = 'entry_eyemask';

    /**
     * プライマリキー
     * @var string カラム名
     */
    protected static $_primary_key = 'entry_id';

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
     * 有効なアイマスクの件数を取得する
     *
     * @return int 結果
     */
    public function get_current_active_count() {

        $sql = <<<SQL
SELECT count(entry_id) as cnt
FROM
    entry_eyemask
WHERE
    is_cancelled = :flg_off
SQL;

        $params = [
            'flg_off' => FLG_OFF,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result)[0]['cnt'];
    }
}
