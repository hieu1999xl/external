<?php

/**
 * GMO口座振替履歴テーブルのモデルクラス
 *
 * @author sakairi@liz-inc.co.jp
 */

class Model_HumanLife_GmoDirectDebitHistory extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string  GMO口座振替履歴テーブル名
     */
    protected static $_table_name = 'gmo_direct_debit_history';

    /**
     * 指定されたパラメータでGMO口座振替履歴を登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_gmo_direct_debit_history(array $param) {
        $query = <<<SQL
INSERT INTO
    gmo_direct_debit_history
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
    `tran_date`,
    `ba_siteId`,
    `ba_member_id`,
    `ba_target_date`,
    `ba_request_accept_end_date`,
    `ba_transfer_return_date`,
    `err_code`,
    `err_info`,
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
    :access_id,
    :access_pass,
    :order_id,
    :status,
    :job_cd,
    :amount,
    :tax,
    :tran_date,
    :ba_siteId,
    :ba_member_id,
    :ba_target_date,
    :ba_request_accept_end_date,
    :ba_transfer_return_date,
    :err_code,
    :err_info,
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
}