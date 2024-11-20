<?php

/**
 * ユーザー決済テーブルのモデルクラス
 */
class Model_HumanLife_SettlementInfoHistory extends Model_CrudAbstract {

    /**
     * テーブル名
     *
     * @var string  settlement_info履歴
     */
    protected static $_table_name = 'settlement_info_history';

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
            settlement_info_history
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
     * 更新する
     *
     * @param array $update_params
     * @return int 更新件数
     */
    public function update($update_params) {

        // update
        $query = <<<SQL
UPDATE
    settlement_info_history
SET
    user_id = :user_id
  , email = :email
  , tel1_1 = :tel1_1
  , tel1_2 = :tel1_2
  , tel1_3 = :tel1_3
  , gmo_request_id = :gmo_request_id
  , gmo_member_id = :gmo_member_id
  , gmo_recurring_id = :gmo_recurring_id
  , update_datetime = :update_datetime
  , update_user = :update_user
WHERE
    gmo_request_id = :gmo_request_id

SQL;

        $params = [
            'user_id'     => $update_params["user_id"],
            'email' => $update_params["email"],
            'tel1_1' => $update_params["tel1_1"],
            'tel1_2'  => $update_params["tel1_2"],
            'tel1_3'  => $update_params["tel1_3"],
            'gmo_request_id'    => $update_params["gmo_request_id"],
            'gmo_member_id'      => $update_params["gmo_member_id"],
            'gmo_recurring_id' => $update_params["gmo_recurring_id"],
            'update_datetime'  => $update_params["update_datetime"],
            'update_user'      => $update_params["update_user"] ?? SYSTEM_USER_NAME,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * gmo_member_idをキーにsettlementinfo情報を取得する
     * @param int   $gmo_member_id
     * @param array $select      取得するカラム名の配列
     * @return array
     */
    public function get_gmo_settlement_history_by_gmo_member_id($gmo_member_id ,  array $select = ['*']){
        $query = DB::select_array($select)
                   ->from(self::$_table_name)
                   ->where('gmo_member_id', $gmo_member_id);
        return $query->execute()->current();
    }

}
