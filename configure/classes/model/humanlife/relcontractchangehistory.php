<?php

/**
 * プラン変更履歴テーブルのモデルクラス
 *
 */
class Model_HumanLife_RelContractChangeHistory extends Model_CrudAbstract
{

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string 契約－プランテーブル名
     */
    protected static $_table_name = 'rel_contract_change_history';

    /**
     * 登録する
     *
     * @param array $params
     * @return array 登録結果
     */
    public function insert_rel_contract_change_history($param) {
        $query = <<<SQL
INSERT INTO
    rel_contract_change_history
(
    rel_contract_id,
    exec_datetime,
    contract_type,
    change_type,
    before_id,
    after_id,
    before_order_sn,
    after_order_sn,
    before_order_id,
    after_order_id,
    before_start_datetime,
    after_start_datetime,
    before_end_datetime,
    after_end_datetime,
    status,
    invoice_id,
    create_user,
    update_user
)
VALUES
(
    :rel_contract_id,
    :exec_datetime,
    :contract_type,
    :change_type,
    :before_id,
    :after_id,
    :before_order_sn,
    :after_order_sn,
    :before_order_id,
    :after_order_id,
    :before_start_datetime,
    :after_start_datetime,
    :before_end_datetime,
    :after_end_datetime,
    :status,
    :invoice_id,
    :create_user,
    :update_user
)
SQL;

        $param['create_user'] = SYSTEM_USER_NAME;
        $param['update_user'] = SYSTEM_USER_NAME;

        $result = DB::query($query)->parameters($param)->execute();
        return $result[0] ?? [];
    }

    /**
     * invoice_idを元に変更履歴を取得する
     *
     * @param  int $invoice_id
     * @return array
     */
    public function get_rel_contract_change_history_by_invoice_id($invoice_id) {
        $query = <<<SQL
SELECT *
FROM rel_contract_change_history
WHERE invoice_id = :invoice_id
SQL;

        $param = [
            'invoice_id' => $invoice_id,
        ];
        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * プラン又はオプションのrel_contract_idをキーにプラン変更履歴情報を取得
     *
     * @param int $rel_contract_id
     * @param int $change_type
     * @return array
     */
    public function get_change_history_by_rel_contract_id($rel_contract_id, $change_type) {
        $sql = <<<SQL
SELECT
    *
FROM
    rel_contract_change_history
WHERE
    rel_contract_id = :rel_contract_id
AND status = :status
AND change_type = :change_type
SQL;
        $param = [
            'rel_contract_id' => $rel_contract_id,
            'status'          => INTERNATIONAL_RENTAL_CHANGE_STATUS_SUCCESS,
            'change_type'     => $change_type
        ];

        parent::pre_find($query);
        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * プラン又はオプションのrel_contract_idをキーに引数の変更履歴より小さいIDを持つ変更履歴情報を取得する
     *
     * @param int $rel_contract_id
     * @param int $rel_contract_change_history_id
     * @return array
     */
    public function get_change_history_list_by_rel_contract_id($rel_contract_id, $rel_contract_change_history_id) {
        $sql = <<<SQL
SELECT
    *
FROM
    rel_contract_change_history
WHERE
    rel_contract_id = :rel_contract_id
AND status = :status
AND rel_contract_change_history_id < :rel_contract_change_history_id
SQL;
        $param = [
            'rel_contract_id'                   => $rel_contract_id,
            'status'                            => INTERNATIONAL_RENTAL_CHANGE_STATUS_SUCCESS,
            'rel_contract_change_history_id'    => $rel_contract_change_history_id,
        ];

        parent::pre_find($query);
        return DB::query($sql)->parameters($param)->execute()->as_array();
    }
}
