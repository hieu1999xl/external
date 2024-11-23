<?php

/**
 * GMOこんど払い履歴テーブルのモデルクラス
 *
 */

class Model_HumanLife_GmoCondoPayHistory extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string  GMOこんど払いテーブル名
     */
    protected static $_table_name = 'gmo_condo_pay_history';

    /**
     * 指定されたパラメータでGMOこんど払い履歴を登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_gmo_condo_pay_history(array $param) {
        $query = <<<SQL
INSERT INTO
    gmo_condo_pay_history
(
    `business_id`,
    `invoice_id`,
    `user_id`,
    `member_id`,
    `trace_id`,
    `order_id`,
    `status`,
    `amount`,
    `tax`,
    `currency`,
    `capture_on_auth`,
    `is_regist_recurring`,
    `url`,
    `expiration`,
    `tran_date`,
    `tran_result`,
    `auth_result`,
    `command`,
    `err_status`,
    `err_code`,
    `err_messages`,
    `pay_type`,
    `create_user`,
    `update_user`
)
VALUES
(
    :business_id,
    :invoice_id,
    :user_id,
    :member_id,
    :trace_id,
    :order_id,
    :status,
    :amount,
    :tax,
    :currency,
    :capture_on_auth,
    :is_regist_recurring,
    :url,
    :expiration,
    :tran_date,
    :tran_result,
    :auth_result,
    :command,
    :err_status,
    :err_code,
    :err_messages,
    :pay_type,
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
     * 取引IDとオーダーIDを元にレコードを更新する
     *
     * @param string $trace_id
     * @param int $order_id
     * @param array $update_columns
     *            ['カラム名' => '値']形式の連想配列
     * @return number レコード数
     */
    public function update_by_trace_id_order_id($trace_id, $order_id, $update_columns)
    {
        return DB::update(self::$_table_name)->set($update_columns)
            ->where('trace_id', $trace_id)
            ->where('order_id', $order_id)
            ->execute();
    }
}
