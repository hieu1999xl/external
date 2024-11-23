<?php

/**
 * ユーザ連絡先テーブルのモデルクラス
 */
class Model_HumanLife_UserContactInfo extends Model_CrudAbstract {

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
    protected static $_table_name = 'user_contact_info';

    /**
     * ユーザー連絡先情報を更新する
     *
     * @param int   $user_id
     * @param int   $business_id
     * @param array $update_params
     * @param int   $contact_type
     */
    public function update_user_contact_info($user_id, $business_id, $update_params, $contact_type) {
        // 更新SQLのSET句を取得する
        $set_phrase = $this->get_set_phrase($update_params);
        $sql = <<<SQL
UPDATE
    user_contact_info
SET
    $set_phrase
WHERE
    user_id = :user_id
AND business_id = :business_id
AND contact_type = :contact_type

SQL;

        $params = [
            'user_id'      => $user_id,
            'business_id'  => $business_id,
            'contact_type' => $contact_type,
        ];

        $params = array_merge($params, $update_params);

        parent::pre_find($query);
        DB::query($sql)->parameters($params)->execute();
    }

    /**
     * Corp会社ー連絡先情報を更新する
     *
     * @param int   $company_id
     * @param array $update_params
     */

    public function update_company_telephone_info($company_id, $update_params) {

        // 更新SQLのSET句を取得する
        $set_phrase = $this->get_set_phrase($update_params);
        $sql = <<<SQL
UPDATE
    company
SET
    $set_phrase
WHERE
    company_id = :company_id
SQL;
    $params = [
        'company_id'      => $company_id,
    ];

    $params = array_merge($params, $update_params);

    parent::pre_find($query);
    DB::query($sql)->parameters($params)->execute();
    }

    /**
     * ユーザIDを条件にユーザ連絡先情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_user_contact_info_list_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    uci.contact_type
  , uci.zipcode1
  , uci.zipcode2
  , uci.prefecture
  , uci.city
  , uci.town
  , uci.block
  , uci.building
  , uci.last_name
  , uci.last_name_kana
  , uci.first_name
  , uci.first_name_kana
  , uci.tel1_1
  , uci.tel1_2
  , uci.tel1_3
  , uci.tel2_1
  , uci.tel2_2
  , uci.tel2_3
FROM
    user_contact_info AS uci
WHERE
    uci.user_id = :user_id
AND uci.business_id = :business_id
ORDER BY
    uci.contact_type ASC
SQL;

        $params = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザIDを条件にユーザ連絡先情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_corp_user_contact_info_list_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    uci.contact_type
  , uci.zipcode1
  , uci.zipcode2
  , uci.prefecture
  , uci.city
  , uci.town
  , uci.block
  , uci.building
  , uci.last_name
  , uci.last_name_kana
  , uci.first_name
  , uci.first_name_kana
  , uci.tel1_1
  , uci.tel1_2
  , uci.tel1_3
FROM
    user_contact_info AS uci
WHERE
    uci.user_id = :user_id
AND uci.business_id = :business_id
ORDER BY
    uci.contact_type ASC
SQL;

        $params = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }


    /**
     * 更新SQLのSET句を取得する
     *
     * @param array $params
     * @return string
     */
    private function get_set_phrase($params) {
        $res = '';

        foreach ($params as $key => $param) {
            if ($res !== '') {
                $res .= ', ';
            }

            $res .= $key . ' = :' . $key;
        }

        return $res;
    }

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
            user_contact_info
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
    user_contact_info
SET
    zipcode1 = :zipcode1
  , zipcode2 = :zipcode2
  , prefecture = :prefecture
  , city = :city
  , town = :town
  , block = :block
  , building = :building
  , last_name = :last_name
  , last_name_kana = :last_name_kana
  , first_name = :first_name
  , first_name_kana = :first_name_kana
  , tel1_1 = :tel1_1
  , tel1_2 = :tel1_2
  , tel1_3 = :tel1_3
  , tel2_1 = :tel2_1
  , tel2_2 = :tel2_2
  , tel2_3 = :tel2_3
  , update_datetime = :update_datetime
  , update_user = :update_user
WHERE
    user_id = :user_id
AND business_id = :business_id
AND contact_type = :contact_type
SQL;

        $params = [
            'business_id'  => $update_params["business_id"],
            'user_id'      => $update_params["user_id"],
            'contact_type' => $update_params["contact_type"],

            'zipcode1'        => $update_params["zipcode1"],
            'zipcode2'        => $update_params["zipcode2"],
            'prefecture'      => $update_params["prefecture"],
            'city'            => $update_params["city"],
            'town'            => $update_params["town"],
            'block'           => $update_params["block"],
            'building'        => $update_params["building"],
            'last_name'       => $update_params["last_name"],
            'last_name_kana'  => $update_params["last_name_kana"],
            'first_name'      => $update_params["first_name"],
            'first_name_kana' => $update_params["first_name_kana"],
            'tel1_1'          => $update_params["tel1_1"],
            'tel1_2'          => $update_params["tel1_2"],
            'tel1_3'          => $update_params["tel1_3"],
            'tel2_1'          => $update_params["tel2_1"],
            'tel2_2'          => $update_params["tel2_2"],
            'tel2_3'          => $update_params["tel2_3"],
            'update_datetime' => $update_params["update_datetime"],
            'update_user'     => $update_params["update_user"],
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * ユーザー連絡先情報を削除する
     *
     * @param int $user_id
     * @param int $business_id
     * @param int $contact_type
     */
    public function delete_contact_info($user_id, $business_id, $contact_type) {
        $query = <<<SQL
DELETE FROM
    user_contact_info
WHERE
    user_id = :user_id
AND business_id = :business_id
AND contact_type = :contact_type
SQL;

        $bind_params = [
            'user_id'      => $user_id,
            'business_id'  => $business_id,
            'contact_type' => $contact_type,
        ];

        DB::query($query)->parameters($bind_params)->execute();
    }

    //get corp_entry_key

    public function get_corp_entry_key_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    contact_entry_key
  , upload_entry_key
 FROM
    user_contact_info
WHERE
    user_id = :user_id
AND business_id = :business_id
SQL;
        $param = [
            'user_id'        => $user_id,
            'business_id'  => $business_id,
            'verified_contact_mail' => FLG_OFF,
        ];
        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    //update_verified_contact_mail

    public function update_verified_contact_mail($entry_contact_key) {
        $query = <<<SQL
UPDATE
    user_contact_info
SET
     verified_contact_mail = :verified_contact_status
WHERE
     contact_entry_key = :contact_entry_key
SQL;
        $params = [
            'contact_entry_key'  => $entry_contact_key,
            'verified_contact_status' => FLG_ON,
        ];
        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    public function update_verified_contact_mail_by_user_id($user_id) {
        $query = <<<SQL
UPDATE
    user_contact_info
SET
     verified_contact_mail = :verified_contact_status
WHERE
     user_id = :user_id
SQL;
        $params = [
            'user_id'  => $user_id,
            'verified_contact_status' => FLG_ON,
        ];
        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    public function update_contact_user($user_id,$email_address,$business_id){
        $query = <<<SQL
UPDATE
    user_contact_info
SET
    email = :email_address,
    contact_entry_key = :entry_key
WHERE
    user_id = :user_id
AND business_id = :business_id
SQL;
 $params = [
     'email_address' => $email_address,
     'user_id'       => $user_id,
     'entry_key'     => Str::random('alnum', 100) . time(),
     'business_id'   => $business_id,
    ];

    parent::pre_update($query);
    $result = DB::query($query)->parameters($params)->execute();
    return parent::post_update($result);
    }

    public function update_contact_user_info($user_id, $business_id, $update_params) {
        $set_phrase = $this->get_set_phrase($update_params);
        $query = <<<SQL
UPDATE
    user_contact_info
SET
     $set_phrase
WHERE
    user_id = :user_id
AND business_id = :business_id
SQL;

     $params = [
         'user_id'     => $user_id,
         'business_id' => $business_id,

     ];
     $param = array_merge($params, $update_params);
    parent::pre_update($query);
    $result = DB::query($query)->parameters($param)->execute();
    return parent::post_update($result);
    }

    public function update_user_status($user_id) {

        $query = <<<SQL
UPDATE
    user
SET
     status = :status
WHERE
    user_id = :user_id
AND business_id = :business_id
SQL;
        $params = [
            'user_id'       => $user_id,
            'business_id'   => BUSINESS_ID,
            'status'        => CORP_USER_STATUS_VALUE_LIST['ACTIVE'],
        ];
        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }


    //get corp_user_id
    public function get_corp_user_id_by_upload_file_entry_key($entry_key) {
        $sql = <<<SQL
SELECT
    user_id
    , upload_entry_key
 FROM
    user_contact_info
WHERE
    upload_entry_key = :upload_entry_key
SQL;
        $param = [
            'upload_entry_key'    => $entry_key,
        ];
        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
}
    /**
     * search contact entry key
     */
    public function search_contact_entry_key($entry_key) {

        $sql = <<<SQL
SELECT
   uci.user_id,
   uci.contact_entry_key,
   uci.expiry_date
FROM
    user_contact_info AS uci
WHERE
    uci.contact_entry_key = :entry_key
SQL;
        $params = [
            'entry_key'     => $entry_key,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * get user email, invoice_mail
     *
     * @param int $user_id
     * @param int $business_id
     */

    public function get_user_info($user_id, $business_id){
        $sql = <<<SQL
SELECT
    u.email
    , uci.email as invoice_mail
 FROM
    user AS u
INNER JOIN
    user_contact_info AS uci
ON  u.user_id = uci.user_id
    AND u.business_id = uci.business_id
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
SQL;
        $param = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
        ];
        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * update_registered_entry_corpb
     */
    public function update_registered_entry_corpb_edit_mail($user_id) {

        $query = <<<SQL
UPDATE
    user_contact_info
SET
     registered_entry_corpb = :registered_entry_corpb
WHERE
     user_id = :user_id
SQL;
        $params = [
            'user_id'  => $user_id['user_id'],
            'registered_entry_corpb' => USER_CONTACT_INFO_REGISTERED_ENTRY_CORPB_EDITING_EMAIL,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * search contact entry key
     */
    public function get_registered_entry_corpb($user_id) {

        $sql = <<<SQL
SELECT
   uci.registered_entry_corpb
FROM
    user_contact_info AS uci
WHERE
    uci.user_id = :user_id
SQL;
        $params = [
            'user_id'     => $user_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * user_contact_infoテーブルの1レコードを取得する
     *
     * @param array $column 取得するカラム名の配列
     * @param int   $user_id      ユーザID
     * @param int   $business_id  事業者ID
     * @param int   $contact_type 連絡先種別
     * @return array 取得結果(レコードが存在しない場合null)
     */
    public function get_data_one($column, $user_id, $business_id, $contact_type)
    {
        $result = DB::select_array($column)->from('user_contact_info')
            ->where('user_id', $user_id)
            ->where('business_id', $business_id)
            ->where('contact_type', $contact_type)
            ->execute()->as_array();

        return count($result) === 0 ? null : current($result);
    }

    /**
     * get_cc_email
     *
     * @param int    $business_id
     * @param int    $user_id
     */
    public function get_cc_email_by_user_id($business_id, $user_id)
    {
        $query = <<<SQL
        SELECT
             cc_email
        FROM
            user_contact_info
        WHERE
            user_id = :user_id
           AND business_id = :business_id
           AND contact_type = :contact_type_contractor
SQL;

        $bind_params = [];
        $bind_params['user_id'] = $user_id;
        $bind_params['business_id'] = $business_id;
        $bind_params['contact_type_contractor'] = USER_CONTACT_TYPE_CONTRACT;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 汎用的な更新処理（updateメソッドは既にあったのでこの名前で）
     *
     * @param array $params 更新用のパラメータ[0 => [{カラム名} => {値}], 1 => ...]
     * @param array $wheres 更新対象の条件[0 => [{カラム名} => {値}], 1 => ...]
     * @return int 更新されたレコード数
     */
    public function update_record($params, $wheres)
    {
        // TODO：上のほうにたくさんある「update_...」みたいなやつも全部ここのメソッドに統合する
        if (empty($wheres)) return 0;
        return DB::update(self::$_table_name)->set($params)->where($wheres)->execute();
    }
}
