<?php

/**
 * 領収書・請求の中間テーブルのモデルクラス
 *
 * @author ako.endo
 */
class Model_HumanLife_RelReceiptInvoiceResult extends Model_CrudAbstract
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
    protected static $_table_name = 'rel_receipt_invoice_result';

    /**
     * プライマリキー
     *
     * @var string カラム名
     */
    protected static $_primary_key = 'receipt_invoice_id';

    /**
     * レコードをINSERTする
     *
     * @param array $pairs [{カラム名} => {値}] 形式の連想配列
     * @return number レコード数
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
     *
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
     * バルクインサートを行う
     *
     * @param array $pairs_list [0=>['カラム名' => '値'], 1=>...]
     * @return int レコード数
     */
    public function bulk_insert($pairs_list) {
        $columns = [
            'receipt_id',
            'invoice_id',
            'create_user',
            'update_user',
        ];

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
     * 領収書に紐づく請求実績情報を取得する（領収書ダウンロード用）
     * 
     * @param int $receipt_id
     * @param int $user_id
     * @return array 請求実績情報
     */
    public function get_receipt_invoice_data($receipt_id, $user_id) {
        // 請求済みのもののみ領収書に出力する
        $sql = <<<SQL
SELECT
    r.invoice_id
    , ir.invoice_type
    , ir.contract_id
    , ir.contract_child_id
    , ir.result_child_id
    , ir.invoice_result_datetime
    , ir.amount
    , ir.tax_price
    , ir.tax_type
    , ir.tax_rate
    , ir.settlement_type
    , ir.invoice_status 
    , ir.entry_id
FROM
    rel_receipt_invoice_result r 
    INNER JOIN invoice_result ir 
        ON r.invoice_id = ir.invoice_id 
WHERE
    r.receipt_id = :receipt_id
    AND ir.user_id = :user_id
    and ir.invoice_status = :invoice_status
ORDER BY
    ir.invoice_type
    , ir.result_child_id
SQL;

        $params = [
            'receipt_id' => $receipt_id,
            'user_id' => $user_id,
            'invoice_status' => INVOICE_STATUS_VALUE_LIST['BILL_COMP'],
        ];

        return DB::query($sql)->parameters($params)->execute()->as_array();
    }
}
