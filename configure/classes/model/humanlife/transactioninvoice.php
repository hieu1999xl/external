<?php

/**
 * トランザクションリレーション情報テーブルのロジッククラス
 *
 * @author a.kurabayashi@humanlife.co.jp
 */
class Model_HumanLife_TransactionInvoice extends Model_CrudAbstract {

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
    protected static $_table_name = 'transaction_invoice';

    /**
     * レコードをINSERTする
     *
     * @param array $insert_params
     * @return number レコード数
     */
    public function insert($insert_params) {
        return DB::insert(self::$_table_name)->set($insert_params)->execute();
    }

    /**
     * 請求明細番号で探して、トランザクションのIDを取得する
     * @param int $invoice_id
     * @return array|null
     */
    public function get_transaction_id_by_invoice_id($invoice_id) {
        $sql = <<<SQL
SELECT
    transaction_id
FROM
    transaction_invoice
WHERE
    invoice_id = :invoice_id
SQL;

        $params = [
            'invoice_id' => $invoice_id,
        ];
        return DB::query($sql)->parameters($params)->execute()->as_array();
    }

    /**
     * 請求明細番号で探して、トランザクションのIDを取得する
     * @param int $transaction_id
     * @return array|null
     */
    public function get_transaction_invoice_id_by_transaction_id($transaction_id) {
        $sql = <<<SQL
SELECT
    invoice_id
FROM
    transaction_invoice
WHERE
    transaction_id = :transaction_id
SQL;

        $params = [
            'transaction_id' => $transaction_id,
        ];
        return DB::query($sql)->parameters($params)->execute()->as_array();
    }
}
