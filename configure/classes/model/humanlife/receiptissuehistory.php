<?php

/**
 * 領収書履歴テーブルのモデルクラス
 *
 * @author ako.endo
 */
class Model_HumanLife_ReceiptIssueHistory extends Model_CrudAbstract
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
     * @var string 契約－プランテーブル名
     */
    protected static $_table_name = 'receipt_issue_history';

    /**
     * プライマリキー
     * @var string カラム名
     */
    protected static $_primary_key = 'receipt_issue_history_id';

    /**
     * レコードをINSERTする
     * 
     * @param array $params [{カラム名} => {値}]形式の連想配列
     * @return int プライマリキー
     */
    public function insert($pairs)
    {
        return DB::insert(self::$_table_name)->set($pairs)->execute();
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
}
