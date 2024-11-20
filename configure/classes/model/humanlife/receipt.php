<?php

/**
 * 領収書テーブルのモデルクラス
 *
 * @author ako.endo
 */
class Model_HumanLife_Receipt extends Model_CrudAbstract
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
    protected static $_table_name = 'receipt';

    /**
     * プライマリキー
     * @var string カラム名
     */
    protected static $_primary_key = 'receipt_id';

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
     * 有効な領収書情報を取得する（ダウンロードボタン表示用）
     * 
     * @param int $user_id
     * @return array 検索結果
     */
    public function get_available_receipt($user_id) {
        // 領収書に紐づいた請求実績情報のうち1つでも請求済みのものがあればダウンロード可とする
        $sql = <<<SQL
SELECT DISTINCT
    r.receipt_id
    , r.entry_id
    , r.create_datetime
FROM
    receipt r
    INNER JOIN rel_receipt_invoice_result ri
        ON r.receipt_id = ri.receipt_id
    INNER JOIN invoice_result ir
        ON ri.invoice_id = ir.invoice_id
WHERE
    r.user_id = :user_id
    and ir.invoice_status = :invoice_status
ORDER BY
    r.entry_id
    , r.receipt_id
SQL;

        $params = [
            'user_id' => $user_id,
            'invoice_status' => INVOICE_STATUS_VALUE_LIST['BILL_COMP'],
        ];

        return DB::query($sql)->parameters($params)->execute()->as_array();
    }
}
