<?php

/**
 * 請求実績調整金テーブルのモデルクラス
 *
 * @author m.ishikawa@humaninvestment.jp
 */
class Model_HumanLife_InvoiceResultAdjustmentMoney extends Model_CrudAbstract {

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
    protected static $_table_name = 'invoice_result_adjustment_money';

    /**
     * 請求明細番号を元に、レコードを取得する
     *
     * @param integer $business_id
     * @param integer $invoice_id
     * @param integer $adjustment_money_id
     * @return array 取得結果
     */
    public function get_by_invoice_id($business_id, $invoice_id, $adjustment_money_id) {
        $query = <<<SQL
        SELECT
            *
        FROM
            invoice_result_adjustment_money
        WHERE
            business_id = :business_id
            AND invoice_id = :invoice_id
            AND adjustment_money_id = :adjustment_money_id

SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['invoice_id'] = $invoice_id;
        $bind_params['adjustment_money_id'] = $adjustment_money_id;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    /**
     * レコードをINSERTする
     *
     * @param array $pairs
     * @return number レコード数
     */
    public function insert($pairs) {
        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }
}
