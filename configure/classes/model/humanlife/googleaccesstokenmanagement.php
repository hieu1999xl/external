<?php

/**
 * Googleアクセストークン管理テーブルのモデルクラス
 *
 * @author
 */

class Model_HumanLife_GoogleAccessTokenManagement extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string Googleアクセストークン管理テーブル名
     */
    protected static $_table_name = 'google_access_token_management';

    /**
     * Googleメールを元にGoogleアクセストークン管理テーブルを取得する（排他ロックをかけて取得する）
     *
     * @param string $email
     * @param int $business_id
     * @return array 取得結果
     */
    public function get_by_google_user_id_for_update($email, $business_id)
    {
        $query = <<<SQL
        SELECT
            *
        FROM
            google_access_token_management
        WHERE
            email = :email
            AND business_id = :business_id
        FOR UPDATE

        SQL;

        $bind_params = [];
        $bind_params['email'] = $email;
        $bind_params['business_id'] = $business_id;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    /**
     * レコードをINSERTする
     *
     * @param array $pairs
     *            ['カラム名' => '値']形式の連想配列
     * @return Database_Result_Cached|object 実行結果
     */
    public function insert($pairs)
    {
        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }

    /**
     * Google Client IDを元にアクセストークンを更新する
     *
     * @param string $access_token
     * @param string $client_id
     * @param int $business_id
     * @param string $token_expire_datetime
     * @return Database_Result_Cached|object 取得結果
     */
    public function update_access_token($access_token, $client_id, $business_id, $token_expire_datetime)
    {
        $query = <<<SQL
        UPDATE
            google_access_token_management
        SET
            access_token = :access_token
          , token_expire_datetime = :token_expire_datetime
          , update_datetime = :update_datetime
          , update_user = :update_user
        WHERE
            client_id = :client_id
          AND business_id = :business_id

        SQL;

        $bind_params = [];
        $bind_params['access_token'] = $access_token;
        $bind_params['token_expire_datetime'] = $token_expire_datetime;
        $bind_params['update_datetime'] = Helper_Time::getCurrentDateTime();
        $bind_params['update_user'] = SYSTEM_USER_NAME;
        $bind_params['business_id'] = $business_id;
        $bind_params['client_id'] = $client_id;

        return DB::query($query)->parameters($bind_params)->execute();
    }

}
