<?php

/**
 * Paidy決済情報履歴テーブルのモデルクラス
 * 
 * @author ako.endo
 */
class Model_HumanLife_PaidyPaymentHistory extends Model_CrudAbstract {

    /**
     * データソース名
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     * @var string テーブル名
     */
    protected static $_table_name = 'paidy_payment_history';

    /**
     * プライマリキー
     * @var string カラム名
     */
    protected static $_primary_key = 'paidy_payment_history_id';

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
     * バルクインサートを行う
     *
     * @param array $pairs_list [0=>['カラム名' => '値'], 1=>...] 複数行分のINSERTデータ
     * @return int レコード数
     */
    public function bulk_insert($pairs_list) {
        $columns = array_keys($pairs_list[0]);
        $query = DB::insert(self::$_table_name)->columns($columns);
        foreach ($pairs_list as $row) {
            $values = [];
            foreach ($columns as $col) {
                $values[] = $row[$col] ?? null;
            }
            $query->values($values);
        }

        return $query->execute();
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
