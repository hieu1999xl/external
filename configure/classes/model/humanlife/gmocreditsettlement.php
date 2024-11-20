<?php

/**
 * GMOクレカ決済テーブルのモデルクラス
 *
 * @author sakairi@liz-inc.co.jp
 */

class Model_HumanLife_GmoCreditSettlement extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string  GMOクレカ決済テーブル名
     */
    protected static $_table_name = 'gmo_credit_settlement';

    /**
     * 指定されたパラメータでGMOクレカ決済を登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_gmo_credit_settlement(array $param) {
        $query = <<<SQL
INSERT INTO
    gmo_credit_settlement
(
    `order_id`,
    `business_id`,
    `invoice_id`,
    `user_id`,
    `member_id`,
    `access_id`,
    `access_pass`,
    `amount`,
    `status`,
    `latest_tran_id`,
    `invoice_transaction_type`,
    `invoice_transaction_id`,
    `create_user`,
    `update_user`
)
VALUES
(
    :order_id,
    :business_id,
    :invoice_id,
    :user_id,
    :member_id,
    :access_id,
    :access_pass,
    :amount,
    :status,
    :latest_tran_id,
    :invoice_transaction_type,
    :invoice_transaction_id,
    :create_user,
    :update_user
)
SQL;

        $param['create_user'] = SYSTEM_USER_NAME;
        $param['update_user'] = SYSTEM_USER_NAME;

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * オーダーIDを元にレコードを取得する
     *
     * @param string $order_id
     * @return array 取得結果
     */
    public function get_by_order_id($order_id)
    {
        $query = <<<SQL
SELECT
    *
FROM
    gmo_credit_settlement
WHERE
    order_id = :order_id
SQL;

        $bind_params = [];
        $bind_params['order_id'] = $order_id;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->current();
    }

    /**
     * オーダーIDを元にレコードを更新する
     *
     * @param int $order_id
     * @param array $update_columns
     *            ['カラム名' => '値']形式の連想配列
     * @return number レコード数
     */
    public function update_by_order_id($order_id, $update_columns)
    {
        return DB::update(self::$_table_name)->set($update_columns)
            ->where('order_id', $order_id)
            ->execute();
    }

    /**
     * アクセスIDを元にレコードを取得する（PKではないが一意）
     *
     * @param string $access_id
     * @return array 取得結果
     */
    public function get_by_access_id($access_id)
    {
        //一意のはずだが、念のためリミット1
        $query = <<<SQL
SELECT
    *
FROM
    gmo_credit_settlement
WHERE
    access_id = :access_id
ORDER BY
    order_id DESC 
LIMIT
    1
SQL;

        $bind_params = [];
        $bind_params['access_id'] = $access_id;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->current();
    }
}