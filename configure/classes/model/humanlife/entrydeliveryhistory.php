<?php

/**
 * 申し込みー配送情報履歴テーブルのモデルクラス
 */
class Model_HumanLife_EntryDeliveryHistory extends Model_CrudAbstract {

    /**
     * 登録する
     *
     * @param array $insert_params
     * @return number
     */
    public function insert($insert_params) {

        $query = <<<SQL
        INSERT INTO
            entry_delivery_history
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

    public function delete_by_entry_id($entry_id, $business_id) {
        $sql = <<<SQL
DELETE FROM
    entry_delivery_history
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

    /**
     * entry_idを元に配達先情報を取得する
     *
     * @param  int $entry_id
     * @param  int $business_id
     * @return array
     */
    public function get_by_entry_id($entry_id, $business_id) {
        $sql = <<<SQL
SELECT
    *
FROM
    entry_delivery_history
WHERE
    entry_id = :entry_id
AND
    business_id = :business_id
ORDER BY id DESC
LIMIT 1
SQL;

        $params = [
            'entry_id'    => $entry_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        return DB::query($sql)->parameters($params)->execute()->current();
    }
}
