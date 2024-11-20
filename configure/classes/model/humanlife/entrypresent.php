<?php

/**
 * 申し込み－プレゼントテーブルのモデルクラス
 */
class Model_HumanLife_EntryPresent extends Model_CrudAbstract {

    /**
     * 登録する
     *
     * @param array $insert_params
     * @return number
     */
    public function insert($insert_params) {

        $query = <<<SQL
        INSERT INTO
            entry_present
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
     * 削除する
     *
     * @param array $insert_params
     * @return number
     */
    public function delete_entry_present($entry_id, $business_id) {
        $sql = <<<SQL
DELETE FROM
    entry_present
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
