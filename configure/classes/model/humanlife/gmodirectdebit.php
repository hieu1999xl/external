<?php

/**
 * GMO口座振替テーブルのモデルクラス
 *
 * @author sakairi@liz-inc.co.jp
 */

class Model_HumanLife_GmoDirectDebit extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string  GMO口座振替テーブル名
     */
    protected static $_table_name = 'gmo_direct_debit';

    /**
     * 指定されたパラメータでGMO口座振替を登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_gmo_direct_debit(array $param) {
        $query = <<<SQL
INSERT INTO
    gmo_direct_debit
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
    `ba_target_date`,
    `ba_request_accept_end_date`,
    `ba_transfer_return_date`,
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
    :ba_target_date,
    :ba_request_accept_end_date,
    :ba_transfer_return_date,
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