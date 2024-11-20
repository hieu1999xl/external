<?php

/**
 * 請求書番号管理テーブルのモデルクラス
 *
 * @author sakairi@liz-inc.co.jp
 */

class Model_HumanLife_BillIdManagement extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string  請求書番号管理テーブル名
     */
    protected static $_table_name = 'bill_id_management';

    /**
     * 最新の事業者IDの登録請求書番号を取得する
     *
     * @param integer $business_id 事業者ID
     * @return array 最新の請求書番号
     */
    public function get_latest_bill_id($business_id) {
        $query = <<<SQL
SELECT
    bill_id
FROM
    bill_id_management
WHERE
    business_id = :business_id
ORDER BY
    bill_id DESC
LIMIT
    1
SQL;

        $param = [
            'business_id' => $business_id,
        ];

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * 更新直後の事業者IDの登録請求書番号を取得する
     *
     * @return array 最新の請求書番号
     */
    public function get_newest_bill_id() {
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
    bill_id_management
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
     * 指定された事業者IDの登録請求書番号を初期登録する
     *
     * @param integer $business_id 事業者ID
     * @return integer
     */
    public function regist_bill_id($business_id) {
        $query = <<<SQL
INSERT INTO
    bill_id_management
(
    `business_id`,
    `bill_id`,
    `create_user`,
    `update_user`
)
VALUES
(
    :business_id,
    :bill_id,
    :create_user,
    :update_user
)
SQL;

        $param = [
            'business_id' => $business_id,
            'bill_id'     => 1,
            'create_user' => SYSTEM_USER_NAME,
            'update_user' => SYSTEM_USER_NAME,
        ];

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * 指定された事業者IDの登録請求書番号を更新する
     *
     * @param integer $business_id 事業者ID
     * @param integer $bill_id     更新後の登録請求書番号
     * @return integer
     */
    public function update_bill_id($business_id, $bill_id) {
        $query = <<<SQL
UPDATE
    bill_id_management
SET
    `bill_id` = :bill_id,
    `update_datetime` = NOW(),
    `update_user` = :update_user
WHERE
    `business_id` = :business_id
SQL;

        $param = [
            'business_id' => $business_id,
            'bill_id'     => $bill_id,
            'create_user' => SYSTEM_USER_NAME,
            'update_user' => SYSTEM_USER_NAME,
        ];

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

}