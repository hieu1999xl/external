<?php

/**
 * UCLアクセストークン管理テーブルのモデルクラス
 *
 * @author
 */

class Model_HumanLife_UclAccessTokenManagement extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string UCLアクセストークン管理テーブル名
     */
    protected static $_table_name = 'ucl_access_token_management';

    /**
     * UCLユーザIDを元にUCLアクセストークン管理テーブルを取得する（排他ロックをかけて取得する）
     *
     * @param integer $ucl_user_id
     * @param string $ucl_account_type
     * @return array 取得結果
     */
    public function get_by_ucl_user_id_for_update($ucl_user_id, $ucl_account_type)
    {
        $query = <<<SQL
        SELECT
            *
        FROM
            ucl_access_token_management
        WHERE
            ucl_user_id = :ucl_user_id
            AND ucl_account_type = :ucl_account_type
        FOR UPDATE

        SQL;

        $bind_params = [];
        $bind_params['ucl_user_id'] = $ucl_user_id;
        $bind_params['ucl_account_type'] = $ucl_account_type;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    /**
     * レコードをINSERTする
     *
     * @param array $pairs
     *            ['カラム名' => '値']形式の連想配列
     * @return array 実行結果
     */
    public function insert($pairs)
    {
        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }

    /**
     * UCLユーザIDを元にアクセストークンを更新する
     *
     * @param string $ucl_user_id
     * @param string $access_token
     * @param datetime $token_get_datetime
     * @return array 取得結果
     */
    public function update_access_token($ucl_user_id, $access_token, $token_get_datetime)
    {
        $query = <<<SQL
        UPDATE
            ucl_access_token_management
        SET
            access_token = :access_token
          , token_get_datetime = :token_get_datetime
          , update_datetime = :update_datetime
          , update_user = :update_user
        WHERE
            ucl_user_id = :ucl_user_id

        SQL;

        $bind_params = [];
        $bind_params['access_token'] = $access_token;
        $bind_params['token_get_datetime'] = $token_get_datetime;
        $bind_params['update_datetime'] = Helper_Time::getCurrentDateTime();
        $bind_params['update_user'] = SYSTEM_USER_NAME;
        $bind_params['ucl_user_id'] = $ucl_user_id;

        return DB::query($query)->parameters($bind_params)->execute();
    }

}
