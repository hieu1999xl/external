<?php

/**
 * トランザクションテーブルのモデルクラス
 *
 * @author a.kurabayashi@humanlife.co.jp
 */
class Model_HumanLife_Transaction extends Model_CrudAbstract {

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
    protected static $_table_name = 'transaction';

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
     * トランザクションIDを条件にトランザクション情報を取得する
     *
     * @param int   $transaction_id
     * @param array $select
     * @return array
     */
    public function get_transaction_info_by_transaction_id($transaction_id, array $select = ['*']) {
        $query = DB::select_array($select)
                    ->from(self::$_table_name)
                    ->where('transaction_id', $transaction_id);
        return $query->execute()->current();
    }

    /**
     * トランザクション情報を更新する
     *
     * @param array $update_params
     */
    public function update_transaction_info($update_params) {
        // 更新SQLのSET句を取得する
        $sql = <<<SQL
UPDATE
    transaction
SET
    status = :status
  , settlement_type = :settlement_type
  , cancel_datetime = :cancel_datetime
  , price_without_tax = :price_without_tax
  , price_with_tax = :price_with_tax
  , tax_detail = :tax_detail
  , update_user = :system_user
WHERE
    transaction_id = :transaction_id
SQL;

        $params = [
            'transaction_id'    => $update_params['transaction_id'],
            'status'            => $update_params['status'],
            'settlement_type'   => $update_params['settlement_type'],
            'cancel_datetime'   => $update_params['cancel_datetime'],
            'price_without_tax' => $update_params['price_without_tax'],
            'price_with_tax'    => $update_params['price_with_tax'],
            'tax_detail'        => $update_params['tax_detail'],
            'system_user'       => SYSTEM_USER_NAME,
        ];

        parent::pre_find($query);
        DB::query($sql)->parameters($params)->execute();
    }
}
