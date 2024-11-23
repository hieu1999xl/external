<?php

/**
 * 申し込み－オプションテーブルのモデルクラス
 */
class Model_HumanLife_EntryOption extends Model_CrudAbstract {

    /**
     * 申込IDを条件に申し込み－オプション情報を取得する
     *
     * @param int $business_id
     * @param int $entry_id
     * @return array
     */
    public function get_entry_option_info_list_by_entry_id($business_id, $entry_id) {
        $sql = <<<SQL
SELECT
    eo.entry_option_id
  , mo.option_id
  , mo.name
  , mo.option_type
  , mo.price
  , mo.billing_type
  , mo.tax_type
FROM
    entry_option AS eo
        INNER JOIN
            mst_option AS mo
        ON
            mo.option_id = eo.option_id
        AND mo.business_id = eo.business_id
WHERE
    eo.entry_id = :entry_id
AND eo.business_id = :business_id
ORDER BY
    eo.entry_option_id ASC
SQL;

        $params = [
            'entry_id'    => $entry_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 申込IDを条件に申し込み－オプション情報を取得する
     *
     * @param int $business_id
     * @param int $entry_id
     * @return array
     */
    public function get_entry_option_by_entry_id($entry_id, $business_id) {
        $sql = <<<SQL
SELECT
    *
FROM
    entry_option AS eo
WHERE
    eo.entry_id = :entry_id
AND eo.business_id = :business_id
ORDER BY
    eo.entry_option_id ASC
SQL;

        $params = [
            'entry_id'    => $entry_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 契約IDを条件に申し込み－オプション情報を取得する
     *
     * @param int $contract_id
     * @param int $option_id
     * @param int $business_id
     * @param int $user_id
     * @return array
     */
    public function get_entry_option_by_contract_id($contract_id, $option_id, $business_id, $user_id) {
        $sql = <<<SQL
SELECT
    eo.*
FROM
    entry_option AS eo
INNER JOIN
    mst_option AS mo
ON
    mo.option_id = eo.option_id
AND mo.business_id = eo.business_id
INNER JOIN
    contract AS c
ON
    c.business_id = eo.business_id
AND c.entry_id = eo.entry_id
AND c.contract_id = :contract_id
AND c.user_id = :user_id
WHERE
    eo.option_id = :option_id
AND eo.business_id = :business_id
SQL;

        $params = [
            'contract_id' => $contract_id,
            'user_id'     => $user_id,
            'option_id'   => $option_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 登録する
     *
     * @param array $insert_params
     * @return number
     */
    public function insert($insert_params) {

        $query = <<<SQL
        INSERT INTO
            entry_option
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
     * 申し込み情報を更新する
     *
     * @param int   $user_id
     * @param int   $business_id
     * @param array $update_params
     */
    public function delete_entry_option($entry_id, $business_id) {
        $sql = <<<SQL
DELETE FROM
    entry_option
WHERE
    entry_id = :entry_id
AND
    business_id = :business_id
SQL;

        $params = [
            'entry_id'     => $entry_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        DB::query($sql)->parameters($params)->execute();
    }
}
