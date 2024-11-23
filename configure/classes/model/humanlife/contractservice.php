<?php

/**
 * 利用規約テーブルのモデルクラス
 */
class Model_HumanLife_ContractService extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string テーブル名
     */
    protected static $_table_name = 'contract_service';

    /**
     * 利用規約のPDFデータの一覧を検索条件で返す
     *
     * @param int   $business_id
     * @param array $condition
     * @param array $select_array
     * @param array $set_order_bys 例：[ contract_service_id => DESC] の連想配列
     * @return array
     */
    public function get_by_condition(int $business_id, array $condition = [], array $select_array = ['contract_service_id'], array $set_order_bys = []) {
        $query = DB::select_array($select_array)
            ->from(self::$_table_name)
            ->where("business_id", $business_id);

        if (!empty($condition['user_id'])) {
            $query->where('user_id', $condition['user_id']);
        }

        if (!empty($condition['company_id'])) {
            $query->where('company_id', $condition['company_id']);
        }

        if (!empty($condition['pdf_type'])) {
            $query->where('pdf_type', $condition['pdf_type']);
        }

        foreach ($set_order_bys as $column => $direction) {
            $query->order_by($column, $direction);
        }

        return $query->execute()->as_array();
    }
}
