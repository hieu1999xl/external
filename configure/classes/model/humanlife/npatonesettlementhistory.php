<?php

/**
 * atone情報テーブルのモデルクラス
 */
class Model_HumanLife_NpAtoneSettlementHistory extends Model_CrudAbstract {

    /**
     * 登録する
     *
     * @param array $insert_params
     * @return number
     */
    public function insert($insert_params) {

        // insert
        $query = <<<SQL
        INSERT INTO
            np_atone_settlement_history
SQL;

        $bind_params = [];
        $set = '(';
        $val = ') VALUES (';
        $is_first = true;
        foreach ($insert_params as $column => $value) {
            if (!$is_first) {
                $set .= ', ';
                $val .= ', ';
            }

            $set .= $column;
            $val .= ':' . $column;
            $bind_params[$column] = $value;
            $is_first = false;
        }
        $val .= ')';

        $query = $query . $set . $val;
        return DB::query($query)->parameters($bind_params)->execute()[0];
    }

    /**
     * transaction_idをキーにnpatone_settlement_history情報を取得する
     *
     * @param  int   $transaction_id 取引ID
     * @return array
     */
    public function get_npatone_settlement_history_by_transaction_id($transaction_id) {
        $sql = <<<SQL
        SELECT
            *
        FROM
            np_atone_settlement_history
        WHERE
            transaction_id = :transaction_id
        AND
            business_id = :business_id
SQL;

        $bind_params = [
            'transaction_id' => $transaction_id,
            'business_id' => BUSINESS_ID,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($bind_params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 指定されたパラメータでatone決済履歴を登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_np_atone_settlement_history(array $param) {
        $query = <<<SQL
INSERT INTO
    np_atone_settlement_history
(
    business_id,
    user_id,
    entry_id,
    order_id,
    invoice_id,
    api_type,
    status,
    token,
    transaction_id,
    authorization_result_ng_reason,
    amount,
    message,
    order_date,
    create_user,
    update_user
)
VALUES
(
    :business_id,
    :user_id,
    :entry_id,
    :order_id,
    :invoice_id,
    :api_type,
    :status,
    :token,
    :transaction_id,
    :authorization_result_ng_reason,
    :amount,
    :message,
    :order_date,
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
     * 一番最新の認証時のトークンを取得する
     *
     * @param  int $user_id
     * @return array
     */
    public function get_the_latest_token_by_user_id($user_id) {
        $sql = <<<SQL
SELECT token
FROM np_atone_settlement_history
WHERE user_id = :user_id AND
      business_id = :business_id AND
      (token IS NOT NULL AND token != '') AND
      status = :status AND
      transaction_id IS NULL AND
      amount IS NULL
ORDER BY id DESC
SQL;

        $bind_params = [
            'user_id'     => $user_id,
            'business_id' => BUSINESS_ID,
            'status'      => ATONE_STATUS_OK,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($bind_params)->execute()->current();
        return parent::post_find($result);
    }

    /**
     * オーダーIDを元にレコードを取得する
     *
     * @param  int   $order_id
     * @param  int   $invoice_id
     * @return array 取得結果
     */
    public function get_by_order_id($order_id, $invoice_id)
    {
        $query = <<<SQL
        SELECT
          *
        FROM
            np_atone_settlement_history
        WHERE
            order_id = :order_id AND
            invoice_id = :invoice_id
SQL;

        $bind_params = [];
        $bind_params['order_id'] = $order_id;
        $bind_params['invoice_id'] = $invoice_id;

        $result = DB::query($query)->parameters($bind_params)
                ->execute()
                ->as_array();

        return $result;
    }

}
