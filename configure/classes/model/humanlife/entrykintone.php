<?php

/**
 * 申し込みーKintoneテーブルのモデルクラス
 */
class Model_HumanLife_EntryKintone extends Model_CrudAbstract {
    /**
     * 登録する
     *
     * @param array $insert_params
     * @return int 登録件数
     */
    public function insert($insert_params) {
        
        // insert
        $query = <<<SQL
        INSERT INTO
            entry_kintone
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
        return DB::query($query)->parameters($bind_params)->execute();
    }
}