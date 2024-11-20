<?php

/**
 * GMOクレカ決済履歴テーブルのモデルクラス
 *
 * @author sakairi@liz-inc.co.jp
 */

class Model_HumanLife_GmoCreditSettlementHistory extends Model_CrudAbstract {

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
    protected static $_table_name = 'gmo_credit_settlement_history';

    /**
     * 指定されたパラメータでGMOクレカ決済履歴を登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_gmo_credit_settlement_history(array $param) {
        $query = <<<SQL
INSERT INTO
    gmo_credit_settlement_history
(
    `business_id`,
    `invoice_id`,
    `user_id`,
    `member_id`,
    `access_id`,
    `access_pass`,
    `order_id`,
    `status`,
    `job_cd`,
    `amount`,
    `tax`,
    `currency`,
    `forward`,
    `method`,
    `pay_times`,
    `tran_id`,
    `approve`,
    `tran_date`,
    `err_code`,
    `err_info`,
    `pay_type`,
    `invoice_transaction_type`,
    `invoice_transaction_id`,
    `create_user`,
    `update_user`
)
VALUES
(
    :business_id,
    :invoice_id,
    :user_id,
    :member_id,
    :access_id,
    :access_pass,
    :order_id,
    :status,
    :job_cd,
    :amount,
    :tax,
    :currency,
    :forward,
    :method,
    :pay_times,
    :tran_id,
    :approve,
    :tran_date,
    :err_code,
    :err_info,
    :pay_type,
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
}