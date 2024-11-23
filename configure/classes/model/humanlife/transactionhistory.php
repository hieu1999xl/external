<?php

/**
 * トランザクション履歴テーブルのロジッククラス
 *
 * @author a.kurabayashi@humanlife.co.jp
 */
class Model_HumanLife_TransactionHistory extends Model_CrudAbstract {

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
    protected static $_table_name = 'transaction_history';

    /**
     * レコードをINSERTする
     *
     * @param array $insert_params
     * @return number レコード数
     */
    public function insert($insert_params) {
        return DB::insert(self::$_table_name)->set($insert_params)->execute();
    }
}
