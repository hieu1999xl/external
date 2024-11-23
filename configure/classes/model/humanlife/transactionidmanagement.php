<?php

/**
 * トランザクションID管理テーブルのモデルクラス
 *
 * @author a.kurabayashi@humanlife.co.jp
 */
class Model_HumanLife_TransactionIdManagement extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string  トランザクションID管理テーブル名
     */
    protected static $_table_name = 'transaction_id_management';

    /**
     * トランザクションIDを取得する
     *
     * @return array 最新のトランザクションID
     */
    public function get_latest_transaction_id() {
        $query = <<<SQL
SELECT
    transaction_id
FROM
    transaction_id_management
WHERE
    business_id = :business_id
ORDER BY
    transaction_id DESC
LIMIT
    1
SQL;

        $param = [
            'business_id' => BUSINESS_ID,
        ];

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * 更新直後のトランザクションID番号を取得する
     *
     * @return array 最新のトランザクションID
     */
    public function get_newest_transaction_id() {
        $query = <<<SQL
SELECT
    LAST_INSERT_ID()
SQL;

        $result = DB::query($query)->execute()->as_array();
        return $result;
    }

    /**
     * テーブルの書き込みロックを取得する
     *
     * @return array ロック結果
     */
    public function lock_table() {
        $query = <<<SQL
LOCK TABLES
    transaction_id_management
WRITE
SQL;

        $result = DB::query($query)->execute();
        return $result;
    }

    /**
     * テーブルの書き込みロックを解放する
     *
     * @return array アンロック結果
     */
    public function unlock_table() {
        $query = <<<SQL
UNLOCK TABLES
SQL;

        $result = DB::query($query)->execute();
        return $result;
    }

    /**
     * トランザクションIDを初期登録する
     *
     */
    public function regist_transaction_id() {
        $query = <<<SQL
INSERT INTO
    transaction_id_management
(
    `business_id`,
    `transaction_id`,
    `create_user`,
    `update_user`
)
VALUES
(
    :business_id,
    :transaction_id,
    :create_user,
    :update_user
)
SQL;

        $param = [
            'business_id'     => BUSINESS_ID,
            'transaction_id'  => 1,
            'create_user'     => SYSTEM_USER_NAME,
            'update_user'     => SYSTEM_USER_NAME,
        ];

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * トランザクションIDを更新する
     *
     * @param int $transaction_id  更新後のトランザクションID
     * @return int
     */
    public function update_transaction_id($transaction_id) {
        $query = <<<SQL
UPDATE
    transaction_id_management
SET
    `transaction_id` = :transaction_id,
    `update_datetime` = NOW(),
    `update_user` = :update_user
WHERE
    `business_id` = :business_id
SQL;

        $param = [
            'business_id'     => BUSINESS_ID,
            'transaction_id'  => $transaction_id,
            'update_user'     => SYSTEM_USER_NAME,
        ];

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

}