<?php

/**
 * ユーザ連絡先テーブルのモデルクラス
 */
class Model_HumanLife_Delivery extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string
     */
    protected static $_table_name = 'delivery';

    /**
     * プライマリキー
     * @var string
     */
    protected static $_primary_key = 'delivery_id';

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
            delivery
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
    
    /**
     * 顧客に紐づく配送先情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array 取得結果
     */
    public function get_delivery_list($user_id, $business_id) {
        
        $query = <<<SQL
        SELECT
            *
        FROM
            delivery
        WHERE
            user_id = :user_id
        AND business_id = :business_id
        AND delete_flag = :flg_off
        SQL;
        
        $bind_params = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
            'flg_off'     => FLG_OFF,
        ];
        
        return DB::query($query)->parameters($bind_params)
        ->execute()
        ->as_array();
    }

    /**
     * 更新する
     *
     * @param array $params 更新用のパラメータ[0 => [{カラム名} => {値}], 1 => ...]
     * @param array $wheres 更新対象の条件[0 => [{カラム名} => {値}], 1 => ...]
     * @return int 更新されたレコード数
     */
    public function update($params, $wheres)
    {
        if (empty($wheres)) return 0;
        return DB::update(self::$_table_name)->set($params)->where($wheres)->execute();
    }
}
