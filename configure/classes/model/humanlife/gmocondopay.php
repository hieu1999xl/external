<?php

/**
 * GMOこんど払いテーブルのモデルクラス
 *
 */

class Model_HumanLife_GmoCondoPay extends Model_CrudAbstract {

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
    protected static $_table_name = 'gmo_condo_pay';

    /**
     * 請求明細番号の最新オーダーIDに紐づくGMOこんど払いとGMOこんど払い履歴の最新レコードを取得する
     *
     * @param integer $order_id
     * @return array 取得結果
     */
    public function get_each_latest_data_by_order_id_inner_join_history($order_id)
    {
        $query = <<<SQL
        SELECT
            gmo_condo_pay.order_id
            , gmo_condo_pay.business_id
            , gmo_condo_pay.invoice_id
            , gmo_condo_pay.user_id
            , gmo_condo_pay.member_id
            , gmo_condo_pay.amount
            , gmo_condo_pay.trace_id
            , gmo_condo_pay.status
            , gmo_condo_pay.latest_trace_id
            , gmo_condo_pay.create_datetime
            , gmo_condo_pay.create_user
            , gmo_condo_pay.update_datetime
            , gmo_condo_pay.update_user
            , gmo_condo_pay_history.gmo_condo_pay_history_id
            , gmo_condo_pay_history.tax
            , gmo_condo_pay_history.currency
            , gmo_condo_pay_history.capture_on_auth
            , gmo_condo_pay_history.is_regist_recurring
            , gmo_condo_pay_history.url
            , gmo_condo_pay_history.expiration
            , gmo_condo_pay_history.tran_result
            , gmo_condo_pay_history.auth_result
            , gmo_condo_pay_history.command
            , gmo_condo_pay_history.err_status
            , gmo_condo_pay_history.err_code
            , gmo_condo_pay_history.err_messages
            , gmo_condo_pay_history.pay_type
            , gmo_condo_pay_history.create_datetime AS history_create_datetime
            , gmo_condo_pay_history.create_user AS history_create_user
            , gmo_condo_pay_history.update_datetime AS history_update_datetime
            , gmo_condo_pay_history.update_user AS history_update_user
        FROM
            gmo_condo_pay
            INNER JOIN gmo_condo_pay_history
            ON gmo_condo_pay.order_id = gmo_condo_pay_history.order_id
        WHERE
            gmo_condo_pay.business_id = :business_id
            AND gmo_condo_pay.order_id = :order_id
        ORDER BY
            gmo_condo_pay.order_id DESC
            , gmo_condo_pay_history.update_datetime DESC
            , gmo_condo_pay_history.gmo_condo_pay_history_id DESC
SQL;

        $bind_params = [];
        $bind_params['business_id'] = BUSINESS_ID;
        $bind_params['order_id'] = $order_id;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    /**
     * 指定されたパラメータでGMOこんど払いを登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_gmo_condo_pay(array $param) {
        $query = <<<SQL
INSERT INTO
    gmo_condo_pay
(
    `order_id`,
    `business_id`,
    `invoice_id`,
    `user_id`,
    `member_id`,
    `amount`,
    `trace_id`,
    `status`,
    `latest_trace_id`,
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
    :amount,
    :trace_id,
    :status,
    :latest_trace_id,
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
     * merchantOrderId をキーにして、こんど払い手数料の取引を行った顧客と申し込みの情報を取得する
     * 
     * @param string $order_id
     */
    public function get_gmo_condo_pay_invoice_condo_fee($order_id)
    {

        $query = <<<SQL
SELECT
    g.order_id
    , g.user_id
    , e.entry_id 
    , i.invoice_type
    , ia.adjustment_money_id
FROM
    gmo_condo_pay g 
    INNER JOIN invoice_schedule i 
        ON g.invoice_id = i.invoice_id 
    LEFT JOIN invoice_schedule_adjustment_money ia 
        ON g.invoice_id = ia.invoice_id 
    INNER JOIN entry e 
        ON g.user_id = e.user_id 
WHERE
    g.business_id = :business_id
    AND g.order_id = :order_id
SQL;

        $bind_params = [
            'business_id' => BUSINESS_ID,
            'order_id'    => $order_id,
        ];

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    /**
     * merchantOrderId をキーにして、メール送信に必要なユーザー情報を取得する
     * 
     * @param string $order_id
     * @return array 取得結果
     */
    public function get_user_by_order_id($order_id) {

        $query = <<<SQL
SELECT
    u.email
    , u.last_name
    , u.first_name 
FROM
    gmo_condo_pay g 
    INNER JOIN user u 
        ON g.user_id = u.user_id 
WHERE
    g.business_id = :business_id 
    AND g.order_id = :order_id
SQL;

        $bind_params = [
            'business_id' => BUSINESS_ID,
            'order_id'    => $order_id,
        ];

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }
}
