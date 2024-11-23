<?php

/**
 * ユーザテーブルのモデルクラス
 */
class Model_HumanLife_User extends Model_CrudAbstract {

    /**
     * テーブル名
     *
     * @var string テーブル名
     */
    protected static $_table_name = 'user';

    /**
     * ユーザーIDを条件にユーザー情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_user_info_by_user_id($user_id, $business_id, $login_allow_user_status_list) {
        $sql = <<<SQL
SELECT
    u.last_name,
    u.first_name,
    u.user_id,
    u.business_id,
    u.user_type,
    u.password,
    u.salt,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    u.join_datetime,
    u.withdraw_datetime,
    u.company_id,
    e.entry_id
FROM
    user AS u
INNER JOIN
    entry AS e
ON  e.user_id = u.user_id
AND e.status != :entry_status
AND e.business_id = u.business_id
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
AND u.status IN :user_status
SQL;

        $param = [
            'user_id'      => $user_id,
            'business_id'  => $business_id,
            'user_status'  => $login_allow_user_status_list,
            'entry_status' => ENTRY_STATUS_LIST['rejection'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザーIDを条件にユーザー情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_draft_user_info_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    u.last_name,
    u.first_name,
    u.user_id,
    u.business_id,
    u.user_type,
    u.password,
    u.salt,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    u.join_datetime,
    u.withdraw_datetime,
    u.company_id,
    u.create_datetime,
    e.is_changed_password,
    e.telephone_entry_hash,
    e.entry_id
FROM
    user AS u
INNER JOIN
    entry AS e
ON  e.user_id = u.user_id
AND e.status != :entry_status
AND e.business_id = u.business_id
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
AND u.status IN :user_status
SQL;

        $param = [
            'user_id' => $user_id,
            'business_id' => $business_id,
            'user_status' => [USER_STATUS_LIST['draft'], USER_STATUS_LIST['repeat_rental']],
            'entry_status' => ENTRY_STATUS_LIST['rejection'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /*
     * entry_idとフリープラン初期契約解除を除外して後のフラグでuserを取得する
     *
     * @param $entry_id
     * @param int $business_id
     */
    public function is_user_entry_after_free_plan_initial_contract_cancellation_excluded($entry_id, $business_id) {
        $query = <<<SQL
        SELECT
          user.user_id
        FROM
          user
        INNER JOIN entry
            ON entry.user_id = user.user_id
        WHERE
          entry.entry_id = :entry_id
          AND user.business_id = :business_id
          AND entry.business_id = :business_id
          AND user.user_type = :user_type
          AND user.is_free_plan_initial_cancel_excluded = :is_free_plan_initial_cancel_excluded

        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['entry_id'] = $entry_id;
        $bind_params['user_type'] = USER_TYPE_LIST['PRIVATE'];
        $bind_params['is_free_plan_initial_cancel_excluded'] = FLG_ON;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    //get user mail
    public function get_user_email_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    u.email as user_email

FROM
    user AS u
WHERE
     u.user_id = :user_id
AND  u.business_id = :business_id
AND  u.status = :status

SQL;
        $param = [
            'user_id'      => $user_id,
            'business_id'  => $business_id,
            'status'    => CORP_USER_STATUS_VALUE_LIST['WAIT_CONTRACT_DOC'],

        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * メールアドレスを条件にユーザー情報を取得する
     *
     * @param string $email
     * @param int    $business_id
     * @return array
     */
    public function get_user_info_by_email($email, $business_id) {
        $sql = <<<SQL
SELECT
    u.user_id,
    u.business_id,
    u.user_type,
    u.password,
    u.salt,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    u.join_datetime,
    u.withdraw_datetime,
    u.company_id,
    uci.email as contact_email,
    uci.contact_entry_key,
    uci.company_name as contact_company_name,
    uci.last_name as contact_last_name,
    uci.first_name as contact_first_name,
    rcp.plan_end_date
FROM
    user AS u
INNER JOIN
    entry AS e
ON  e.user_id = u.user_id
AND e.status != :entry_status
AND e.status != :draft_entry_status
AND e.business_id = u.business_id
LEFT JOIN
    user_contact_info as uci
    ON u.user_id = uci.user_id
    AND uci.contact_type = :contact_type
LEFT JOIN
    contract as c
    ON c.user_id = u.user_id
    AND c.business_id = :business_id
LEFT JOIN
    rel_contract_plan AS rcp
    ON rcp.contract_id = c.contract_id
    AND rcp.business_id = :business_id
LEFT JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
    AND mp.plan_type = :plan_type
WHERE
    u.email = :email
AND u.business_id = :business_id
AND u.status IN :user_status

SQL;

        $param = [
            'email'        => $email,
            'business_id'  => $business_id,
            'user_status'  => LOGIN_ALLOW_USER_STATUS_LIST,
            'entry_status' => ENTRY_STATUS_LIST['rejection'],
            'draft_entry_status' => ENTRY_STATUS_LIST['draft'],
            'contact_type' => CONTACT_TYPE_VALUE_LIST['CONTRACTOR'],
            'plan_type'    => PLAN_TYPE_LIST['DOMESTIC'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ハッシュを条件にユーザー情報を取得する
     *
     * @param string $telephone_entry_hash
     * @param int $user_id
     * @param int $entry_id
     * @return array
     */
    public function get_user_info_by_telephone_entry_hash($telephone_entry_hash) {
        $sql = <<<SQL
SELECT
    u.user_id,
    u.business_id,
    u.user_type,
    u.password,
    u.salt,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    u.join_datetime,
    u.withdraw_datetime,
    u.company_id,
    e.is_changed_password,
    e.affiliate_order_number
FROM
    user AS u
INNER JOIN
    entry AS e
ON  e.user_id = u.user_id
AND u.status = :user_status
AND e.status = :entry_status
WHERE
    e.telephone_entry_hash = :telephone_entry_hash
AND e.inflow_source LIKE :inflow_source
AND u.status = :user_status
AND e.status = :entry_status

SQL;

        $param = [
            'telephone_entry_hash' => $telephone_entry_hash,
            'inflow_source' => INFLOW_SOURCE_TELEPHONE_INFLOW_SOURCE_NAME . '%',
            'user_status'   => USER_STATUS_LIST['draft'],
            'entry_status'  => USER_STATUS_LIST['draft'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * メールアドレスを条件にユーザー情報を取得する(重複チェック専用)
     *
     * @param string $email
     * @param int    $business_id
     * @return array
     */
    public function get_user_info_by_email_for_duplicate_check($email, $business_id) {
        $sql = <<<SQL
SELECT
    u.user_id,
    u.user_type,
    u.business_id,
    u.user_type,
    u.password,
    u.salt,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    u.join_datetime,
    u.withdraw_datetime,
    u.company_id,
    rcp.plan_end_date
FROM
    user AS u
INNER JOIN
    entry AS e
ON  e.user_id = u.user_id
AND e.status != :entry_status
AND e.status != :draft_entry_status
AND e.business_id = u.business_id
LEFT JOIN
    user_contact_info as uci
    ON u.user_id = uci.user_id
    AND uci.contact_type = :contact_type
LEFT JOIN
    contract as c
    ON c.user_id = u.user_id
    AND c.business_id = :business_id
LEFT JOIN
    rel_contract_plan AS rcp
    ON rcp.contract_id = c.contract_id
    AND rcp.business_id = :business_id
LEFT JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
    AND mp.plan_type = :plan_type
WHERE
    u.email = :email
AND u.business_id = :business_id
ORDER BY u.join_datetime DESC
SQL;

        $param = [
            'email'        => $email,
            'business_id'  => $business_id,
            'entry_status' => ENTRY_STATUS_LIST['rejection'],
            'draft_entry_status' => ENTRY_STATUS_LIST['draft'],
            'contact_type' => CONTACT_TYPE_VALUE_LIST['CONTRACTOR'],
            'plan_type'    => PLAN_TYPE_LIST['DOMESTIC'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * メールアドレスを条件にユーザー情報を取得する
     *
     * @param string $email
     * @param int    $business_id
     * @return array
     */
    public function get_user_info_by_name_and_email($email, $last_name, $first_name, $last_name_kana, $first_name_kana, $business_id) {
        $sql = <<<SQL
SELECT
    u.user_id,
    u.business_id,
    u.user_type,
    u.password,
    u.salt,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    u.join_datetime,
    u.withdraw_datetime,
    u.company_id,
    uci.email as contact_email,
    uci.contact_entry_key,
    uci.company_name as contact_company_name,
    uci.last_name as contact_last_name,
    uci.first_name as contact_first_name,
    e.entry_id
FROM
    user AS u
INNER JOIN
    entry AS e
ON  e.user_id = u.user_id
AND e.status != :entry_status
AND e.business_id = u.business_id
LEFT JOIN
    user_contact_info as uci
    ON u.user_id = uci.user_id
    AND uci.contact_type = :contact_type
WHERE
    u.email = :email
AND u.last_name = :last_name
AND u.first_name = :first_name
AND u.last_name_kana = :last_name_kana
AND u.first_name_kana = :first_name_kana
AND u.user_type = :user_type
AND u.business_id = :business_id
AND u.status IN :user_status

SQL;

        $param = [
            'email'        => $email,
            'last_name'    => $last_name,
            'first_name'   => $first_name,
            'last_name_kana' => $last_name_kana,
            'first_name_kana' => $first_name_kana,
            'business_id'  => $business_id,
            'user_type'    => USER_TYPE_LIST['PRIVATE'],
            'user_status'  => LOGIN_ALLOW_USER_STATUS_LIST,
            'entry_status' => ENTRY_STATUS_LIST['rejection'],
            'contact_type' => CONTACT_TYPE_VALUE_LIST['CONTRACTOR'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * メールアドレスを条件にユーザー情報を取得する
     *
     * @param string $email
     * @param int    $business_id
     * @return array
     */
    public function get_user_info_with_set_entry($email, $last_name, $first_name, $last_name_kana, $first_name_kana, $business_id, $external_service_set_id = 1) {
        $sql = <<<SQL
SELECT
    u.user_id,
    u.business_id,
    u.user_type,
    u.password,
    u.salt,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    u.join_datetime,
    u.withdraw_datetime,
    u.company_id,
    uci.email as contact_email,
    uci.contact_entry_key,
    uci.company_name as contact_company_name,
    uci.last_name as contact_last_name,
    uci.first_name as contact_first_name,
    e.entry_id,
    e.status as entry_status,
    ep.plan_id,
    c.contract_id
FROM
    user AS u
INNER JOIN
    entry AS e
ON  e.user_id = u.user_id
    AND e.status != :entry_status
    AND e.business_id = u.business_id
LEFT JOIN
    entry_plan AS ep
ON  ep.entry_id = e.entry_id
    AND ep.business_id = e.business_id
LEFT JOIN
    entry_external_service_set AS eess
ON  e.entry_id = eess.entry_id
LEFT JOIN
    user_contact_info AS uci
ON u.user_id = uci.user_id
    AND uci.contact_type = :contact_type
LEFT JOIN
    contract AS c
ON c.user_id = e.user_id
    AND c.entry_id = e.entry_id
    AND c.business_id = e.business_id
    AND c.delete_flag = :delete_flag
WHERE
    u.email = :email
AND u.last_name = :last_name
AND u.first_name = :first_name
AND u.last_name_kana = :last_name_kana
AND u.first_name_kana = :first_name_kana
AND u.user_type = :user_type
AND u.business_id = :business_id
AND u.status IN :user_status
AND (
    eess.entry_id IS NULL
    OR eess.external_service_set_id <> :external_service_set_id
)
SQL;

        $param = [
            'email'        => $email,
            'last_name'    => $last_name,
            'first_name'   => $first_name,
            'last_name_kana' => $last_name_kana,
            'first_name_kana' => $first_name_kana,
            'business_id'  => $business_id,
            'user_type'    => USER_TYPE_LIST['PRIVATE'],
            'user_status'  => LOGIN_ALLOW_USER_STATUS_LIST,
            'entry_status' => ENTRY_STATUS_LIST['rejection'],
            'contact_type' => CONTACT_TYPE_VALUE_LIST['CONTRACTOR'],
            'delete_flag'  => FLG_OFF,
            'external_service_set_id' => $external_service_set_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    public function get_user_contact_info_by_email($email, $business_id) {

        $sql = <<<SQL
SELECT
    u.user_id,
    u.business_id,
    u.user_type,
    u.password,
    u.salt,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    u.join_datetime,
    u.withdraw_datetime,
    u.company_id,
    uci.email as contact_email,
    uci.contact_entry_key,
    uci.company_name as contact_company_name,
    uci.last_name as contact_last_name,
    uci.first_name as contact_first_name
FROM
    user AS u
INNER JOIN
    entry AS e
ON  e.user_id = u.user_id
AND e.status != :entry_status
AND e.business_id = u.business_id
LEFT JOIN
    user_contact_info as uci
    ON u.user_id = uci.user_id
    AND uci.contact_type = :contact_type
WHERE
    u.email = :email
AND u.business_id = :business_id
AND u.status = :user_status
SQL;
        $param = [
            'email'        => $email,
            'business_id'  => $business_id,
            'user_status'  => CORP_USER_STATUS_VALUE_LIST['WAIT_CONTRACT_DOC'],
            'entry_status' => ENTRY_STATUS_LIST['rejection'],
            'contact_type' => CONTACT_TYPE_VALUE_LIST['CONTRACTOR'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    public function get_user_contact_info_by_user_id($user_id, $business_id) {

        $sql = <<<SQL
SELECT
    *
FROM
    user_contact_info AS uci
WHERE
    uci.user_id = :user_id
AND uci.business_id = :business_id

SQL;
        $param = [
            'user_id'        => $user_id,
            'business_id'  => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    public function get_user_info_by_invoice_email($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    uci.email as contact_email,
    uci.contact_entry_key,
    uci.company_name as contact_company_name,
    uci.last_name as contact_last_name,
    uci.first_name as contact_first_name
FROM
    user_contact_info as uci
WHERE
    uci.user_id = :user_id
AND uci.business_id = :business_id
SQL;

        $param = [
            'user_id'        => $user_id,
            'business_id'  => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 名前、住所、電話番号を条件にユーザー情報を取得する
     * @param string $last_name
     * @param string $first_name
     * @param string $last_name_kana
     * @param string $first_name_kana
     * @param string $tel1_1
     * @param string $tel1_2
     * @param string $tel1_3
     * @param string $prefecture
     * @param string $city
     * @param $town
     * @param int $business_id
     * @return array
     */
    public function get_user_entry_count($last_name,$first_name,$last_name_kana,$first_name_kana,$tel1_1,$tel1_2,$tel1_3,$prefecture,$city,$town,$business_id) {

        $sql = <<<SQL
SELECT
u.user_id
FROM
    user AS u
INNER JOIN
    entry AS e
ON  e.user_id = u.user_id
AND e.business_id = u.business_id
WHERE
     u.last_name = :last_name
AND u.first_name = :first_name
AND u.last_name_kana = :last_name_kana
AND u.first_name_kana = :first_name_kana
AND e.tel1_1 = :tel1_1
AND e.tel1_2 = :tel1_2
AND e.tel1_3 = :tel1_3
AND e.prefecture = :prefecture
AND e.city = :city
AND e.town = :town
AND u.business_id = :business_id
SQL;

        $param = [
            'last_name'         => $last_name,
            'first_name'        => $first_name,
            'last_name_kana'    => $last_name_kana,
            'first_name_kana'   => $first_name_kana,
            'tel1_1'            => $tel1_1,
            'tel1_2'            => $tel1_2,
            'tel1_3'            => $tel1_3,
            'prefecture'        => $prefecture,
            'city'              => $city,
            'town'              => $town,
            'business_id'       => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
}

/**
 * 住所、電話番号を条件にユーザー情報を取得する

 * @param string $tel1_1
 * @param string $tel1_2
 * @param string $tel1_3
 * @param string $prefecture
 * @param string $city
 * @param $town
 * @param int $business_id
 * @return array
 */
public function get_user_entry_is_suspected($tel1_1,$tel1_2,$tel1_3,$prefecture,$city,$town,$block,$business_id) {

    $sql = <<<SQL
SELECT
u.user_id
FROM
    user AS u
INNER JOIN
    entry AS e
ON  e.user_id = u.user_id
AND e.business_id = u.business_id
WHERE
    u.business_id = :business_id
AND (
    (e.tel1_1 = :tel1_1 AND e.tel1_2 = :tel1_2 AND e.tel1_3 = :tel1_3)
    OR (e.prefecture = :prefecture AND e.city = :city AND e.town = :town AND e.block = :block)
    )
AND e.status <> :entry_draft_status
AND e.status <> :entry_draft_cancel_status
SQL;

    $param = [
        'tel1_1'            => $tel1_1,
        'tel1_2'            => $tel1_2,
        'tel1_3'            => $tel1_3,
        'prefecture'        => $prefecture,
        'city'              => $city,
        'town'              => $town,
        'block'             => $block,
        'entry_draft_status'=> ENTRY_STATUS_LIST['draft'],
        'entry_draft_cancel_status'=>ENTRY_STATUS_LIST['draft_cancel'],
        'business_id'       => $business_id,
    ];

    parent::pre_find($query);
    $result = DB::query($sql)->parameters($param)->execute()->as_array();
    return parent::post_find($result);
}

    /**
     * ユーザIDと契約IDを条件に契約データの件数を返す
     * IMEI情報も取り込まれていること
     *
     * @param int $user_id
     * @param int $contract_id
     * @param int $business_id
     * @return int
     */
    public function get_user_contract_count($user_id, $contract_id, $business_id) {
        $sql = <<<SQL
SELECT
    count(u.user_id) AS count
FROM
    user AS u
INNER JOIN contract AS c
    ON  c.user_id = u.user_id
    AND c.contract_id = :contract_id
    AND c.business_id = u.business_id
INNER JOIN entry AS e
    ON  e.entry_id = c.entry_id
    AND e.status != :entry_status
INNER JOIN imei AS i
    ON  i.contract_id = c.contract_id
    AND i.business_id = c.business_id
    AND i.delete_flag = :delete_flag
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
AND u.status IN :user_status
SQL;

        $param = [
            'user_id'      => $user_id,
            'contract_id'  => $contract_id,
            'business_id'  => $business_id,
            'entry_status' => ENTRY_STATUS_LIST['rejection'],
            'user_status'  => LOGIN_ALLOW_USER_STATUS_LIST,
            'delete_flag'  => FLG_OFF,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result)[0]['count'];
    }

    /**
     * ユーザーIDと契約IDを条件に契約情報を取得する
     *
     * @param int $user_id
     * @param int $contract_id
     * @param int $business_id
     * @return array
     */
    public function get_user_contract_info($user_id, $contract_id, $business_id) {
        $sql = <<<SQL
SELECT
    u.user_id,
    uc.user_code,
    uc.user_password,
    c.contract_id,
    c.zipcode1 AS contract_zipcode1,
    c.zipcode2  AS contract_zipcode2,
    c.prefecture AS contract_prefecture,
    c.city AS contract_city,
    c.town AS contract_town,
    c.block AS contract_block,
    c.building AS contract_building,
    rcp.plan_id,
    rcp.order_id,
    group_concat(rco.option_id) AS option_id_list
FROM
    user AS u
INNER JOIN
    contract c ON c.user_id = u.user_id AND c.contract_id = :contract_id AND c.business_id = :business_id
LEFT JOIN
    rel_contract_plan AS rcp on rcp.contract_id = c.contract_id AND rcp.business_id = :business_id
        AND (rcp.plan_end_date > NOW() OR rcp.plan_end_date IS NULL) AND rcp.delete_flag = :delete_flag
LEFT JOIN
    rel_contract_option AS rco on rco.contract_id = c.contract_id AND rco.business_id = :business_id
INNER JOIN
    user_ucl AS uc ON uc.user_id = u.user_id AND uc.contract_id = c.contract_id
WHERE
    u.user_id = :user_id
AND
    u.business_id = :business_id
GROUP BY
    u.user_id, uc.user_code, uc.user_password, c.contract_id, rcp.plan_id
SQL;

        $param = [
            'user_id'     => $user_id,
            'contract_id' => $contract_id,
            'business_id' => $business_id,
            'delete_flag' => FLG_OFF,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザーに紐づく契約プラン情報を取得する
     *
     * @param int $user_id
     * @param int $contract_plan_id
     * @param int $business_id
     *
     * @return array
     */
    public function get_user_contract_plan_info($user_id, $contract_plan_id, $business_id) {
        $sql = <<<SQL
SELECT
    u.user_id
FROM
    user AS u
INNER JOIN
    contract c ON c.user_id = u.user_id
AND
    c.business_id = u.business_id
INNER JOIN
    rel_contract_plan AS rcp on rcp.contract_id = c.contract_id
AND
    rcp.contract_plan_id = :contract_plan_id
AND
    rcp.business_id = u.business_id
AND
    (rcp.plan_end_date > NOW() OR rcp.plan_end_date IS NULL)
AND
    rcp.delete_flag = :delete_flag
WHERE
    u.user_id = :user_id
SQL;

        $param = [
            'user_id'          => $user_id,
            'contract_plan_id' => $contract_plan_id,
            'business_id'      => $business_id,
            'delete_flag'      => FLG_OFF,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザーIDを条件にユーザーの詳細情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_user_detail_info_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    u.user_id,
    u.user_type,
    u.password,
    u.salt,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    u.company_id,
    u.create_datetime,
    si.settlement_type,
    si.gmo_member_id,
    si.gmo_card_id,
    si.gmo_bank_tran_id,
    GROUP_CONCAT(CONCAT_WS('_', uci.contact_type, uci.zipcode1, uci.zipcode2, uci.prefecture, uci.city, uci.town, uci.block, uci.building, uci.last_name
        , uci.last_name_kana, uci.first_name, uci.first_name_kana, uci.tel1_1, uci.tel1_2, uci.tel1_3, uci.tel2_1, uci.tel2_2, uci.tel2_3)) AS contact_info_list_str,
    c.name AS company_name,
    c.name_kana AS company_name_kana,
    c.representative_last_name,
    c.representative_last_name_kana,
    c.representative_first_name,
    c.representative_first_name_kana,
    c.hp_url,
    c.tel1_1 as representative_tel1_1,
    c.tel1_2 as representative_tel1_2,
    c.tel1_3 as representative_tel1_3
FROM
    user AS u
INNER JOIN
    user_contact_info AS uci
    ON  u.user_id = uci.user_id
    AND uci.business_id = u.business_id
INNER JOIN
    settlement_info AS si
    ON  si.user_id = u.user_id
    AND si.business_id = u.business_id
    AND u.business_id = uci.business_id
LEFT JOIN
    company AS c
    ON  c.company_id = u.company_id
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
GROUP BY
    u.user_id, u.user_type, u.password, u.salt, u.email, u.birthday, u.last_name, u.last_name_kana, u.first_name, u.first_name_kana, u.status, u.sex, si.settlement_type, si.gmo_member_id, si.gmo_card_id, si.gmo_bank_tran_id
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
     * CorpユーザーIDを条件にユーザーの詳細情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_corp_user_detail_info_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    u.user_id,
    u.user_type,
    u.password,
    u.salt,
    u.email,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    si.settlement_type,
    si.gmo_member_id,
    si.gmo_card_id,
    si.gmo_bank_tran_id,
    GROUP_CONCAT(CONCAT_WS('_',c.zipcode1, c.zipcode2, c.prefecture, c.city, c.town, c.block, IFNULL(c.building, ''), c.tel1_1, c.tel1_2, c.tel1_3, IFNULL(c.tel2_1, ''), IFNULL(c.tel2_2, ''), IFNULL(c.tel2_3, ''))) AS company_info_list_str,
    c.name AS company_name,
    c.name_kana AS company_name_kana,
    c.representative_last_name,
    c.representative_last_name_kana,
    c.representative_first_name,
    c.representative_first_name_kana,
    c.hp_url
FROM
    user AS u
INNER JOIN
    company AS c
    ON  c.company_id = u.company_id
INNER JOIN
    settlement_info AS si
    ON  si.user_id = u.user_id
    AND si.business_id = u.business_id
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
GROUP BY
    u.user_id, u.user_type, u.password, u.salt, u.email, u.birthday, u.last_name, u.last_name_kana, u.first_name, u.first_name_kana, u.status, u.sex, si.settlement_type, si.gmo_member_id, si.gmo_card_id, si.gmo_bank_tran_id
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
     * ユーザーに紐づくUCL情報を取得する
     *
     * @param int $user_id
     * @param int $contract_id
     * @param int $business_id
     * @return array
     */
    public function get_user_ucl_info($user_id, $contract_id, $business_id) {
        $sql = <<<SQL
SELECT
    u.user_id,
    uc.user_code,
    uc.user_password
FROM
    user AS u
INNER JOIN
    contract c ON c.user_id = u.user_id
AND
    c.contract_id = :contract_id
AND
    c.business_id = u.business_id
INNER JOIN
    user_ucl AS uc ON uc.user_id = u.user_id
AND
    uc.contract_id = c.contract_id
WHERE
    u.user_id = :user_id
AND
    u.business_id = :business_id
SQL;

        $param = [
            'user_id'     => $user_id,
            'contract_id' => $contract_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザー情報を更新する
     *
     * @param int   $user_id
     * @param int   $business_id
     * @param array $update_params
     */
    public function update_user_info($user_id, $business_id, $update_params) {
        // 更新SQLのSET句を取得する
        $set_phrase = $this->get_set_phrase($update_params);

        $sql = <<<SQL
UPDATE
    user
SET
    $set_phrase
WHERE
    user_id = :user_id
AND
    business_id = :business_id
SQL;

    $param = [
        'user_id'     => $user_id,
        'business_id' => $business_id,
    ];

    $param = array_merge($param, $update_params);

    parent::pre_find($query);
    DB::query($sql)->parameters($param)->execute();
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
     * ユーザIDを条件にユーザ情報を無効(退会)状態に更新する
     *
     * @param int $business_id
     * @param int $user_id
     * @return int
     */
    public function update_invalid_status_by_user_id($business_id, $user_id) {
        $sql = <<<SQL
UPDATE
    user AS u
SET
    status = :status
  , withdraw_datetime = :current_datetime
  , update_datetime = :current_datetime
  , update_user = :system_user
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
SQL;

        $params = [
            'status'           => USER_STATUS_VALUE_LIST['INVALID'],
            'current_datetime' => Helper_Time::getCurrentDateTime(),
            'system_user'      => SYSTEM_USER_NAME,
            'user_id'          => $user_id,
            'business_id'      => $business_id,
        ];

        parent::pre_update($sql);
        $result = DB::query($sql)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * パスワード変更
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param string $password
     * @return int
     */
    public function update_user_password($user_id, $business_id, $password) {
        $sql = <<<SQL
UPDATE
    user AS u
SET
    u.password = :password
  , u.update_user = :update_user
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
SQL;

        $params = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
            'password'    => $password,
            'update_user' => SYSTEM_USER_NAME,
        ];

        parent::pre_update($query);
        $result = DB::query($sql)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * 仮申込パスワード変更
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param string $password
     * @return int
     */
    public function update_draft_user_password($user_id, $business_id, $password) {
        $sql = <<<SQL
UPDATE
    user AS u
INNER JOIN
    entry AS e
ON
    u.user_id = e.user_id
AND u.business_id = e.business_id
SET
    u.password = :password
  , u.update_user = :update_user
  , e.is_changed_password = :is_changed_password_1
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
AND e.is_changed_password = :is_changed_password_0
AND u.status = :status

SQL;

        $params = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
            'password'    => $password,
            'update_user' => SYSTEM_USER_NAME,
            'is_changed_password_1' => FLG_ON,
            'is_changed_password_0' => FLG_OFF,
            'status' => USER_STATUS_LIST['draft']
        ];

        parent::pre_update($query);
        $result = DB::query($sql)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * 法人ID変更
     *
     * @param int    $business_id
     * @param string $user_id
     * @param int    $company_id
     * @return number
     */
    public function update_company_id($business_id, $user_id, $company_id) {
        $sql = <<<SQL
UPDATE
    user AS u
SET
    company_id = :company_id
  , update_datetime = :current_datetime
  , update_user = :system_user
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
SQL;

        $params = [
            'company_id'       => $company_id,
            'current_datetime' => Helper_Time::getCurrentDateTime(),
            'system_user'      => SYSTEM_USER_NAME,
            'user_id'          => $user_id,
            'business_id'      => $business_id,
        ];

        parent::pre_update($sql);
        $result = DB::query($sql)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * メールアドレスを条件に現時点で有効なユーザー情報を取得する
     *
     * @param string $email
     * @param int    $business_id
     * @return array
     */
    public function get_valid_user_list_by_email($email, $business_id) {

        // TODO:申し込みステータスも条件にしないといけないNGのものは省かないと。ログインのロジックができたらそれにあわせる。
        $query = <<<SQL
SELECT
    *
FROM
    user
WHERE
    email = :email
AND
    business_id = :business_id
AND
    join_datetime <= NOW()
AND
    (
        withdraw_datetime IS NULL
      OR
        withdraw_datetime >= NOW()
    )
SQL;

        $param = [
            'email'       => $email,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 登録する
     *
     * @param array $insert_params
     * @return int ユーザID
     */
    public function insert($insert_params) {

        // insert
        $query = <<<SQL
        INSERT INTO
            user
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
        $ret = DB::query($query)->parameters($bind_params)->execute();
        $user_id = $ret[0];

        return $user_id;
    }

    /**
     * ユーザIDを条件にユーザ情報と法人情報を取得する
     *
     * @param int $business_id
     * @param int $user_id
     * @return array
     */
    public function get_user_corp_info_by_user_id($business_id, $user_id) {
        $sql = <<<SQL
SELECT
    u.*
  , si.*
  , c.*
  , IfNull(e.waiting_billing_count, 0) waiting_billing_count
FROM
    user AS u
    LEFT JOIN settlement_info AS si
        ON  si.business_id = u.business_id
        AND si.user_id = u.user_id
    LEFT JOIN company AS c
        ON  c.company_id = u.company_id
    LEFT JOIN (
        SELECT
            business_id
            ,user_id
            ,SUM(CASE WHEN status = :status THEN 1 ELSE 0 END) waiting_billing_count
        FROM
            entry
        WHERE
            user_id = :user_id
            AND business_id = :business_id
        GROUP BY
            business_id
            ,user_id
    ) AS e
        ON  e.business_id = u.business_id
        AND e.user_id = u.user_id
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
SQL;

        $params = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
            'status'      => ENTRY_STATUS_VALUE_LIST["WAITING_BILLING"],
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    public function cancel_draft_user_with_same_email($business_id, $email, $user_id) {
        $query = <<<SQL
UPDATE
    user u
SET
    u.status = :status
  , u.update_datetime = :update_datetime
  , u.update_user = :update_user
WHERE
    u.user_id <> :user_id
AND u.email = :email
AND u.business_id = :business_id
AND u.status = :draft_status
SQL;

        $params = [
            'business_id' => $business_id,
            'user_id'    => $user_id,
            'email'       => $email,
            'status'          => ENTRY_STATUS_LIST['draft_cancel'],
            'draft_status'    => ENTRY_STATUS_LIST['draft'],
            'update_datetime' => Helper_Time::getCurrentDateTime(),
            'update_user'     => SYSTEM_USER_NAME,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    public function cancel_draft_user_by_user_id($business_id, $user_id) {
        $query = <<<SQL
UPDATE
    user u
SET
    u.status = :status
  , u.update_datetime = :update_datetime
  , u.update_user = :update_user
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
AND u.status = :draft_status
SQL;

        $params = [
            'business_id' => $business_id,
            'user_id'    => $user_id,
            'status'          => ENTRY_STATUS_LIST['draft_cancel'],
            'draft_status'    => ENTRY_STATUS_LIST['draft'],
            'update_datetime' => Helper_Time::getCurrentDateTime(),
            'update_user'     => SYSTEM_USER_NAME,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * 利用日が指定された範囲内の契約プラン情報を取得する
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function get_rel_contract_info_list_by_target_range_date($user_id, $business_id, $start_date, $end_date) {
        $sql = <<<SQL
SELECT
    c.contract_id
    , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rcp.contract_plan_id, ''), IFNULL(mp.price, ''))) contract_plan_info_list_str
    , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rco.contract_option_id, ''), IFNULL(mo.price, ''))) contract_option_info_list_str
FROM
    user AS u
LEFT JOIN contract AS c
    ON  u.user_id = c.user_id
    AND u.business_id = c.business_id
    AND c.delete_flag = :delete_flag
LEFT JOIN rel_contract_plan AS rcp
    ON  rcp.contract_id = c.contract_id
    AND rcp.business_id = c.business_id
    AND rcp.plan_start_date BETWEEN :start_date AND :end_date
    AND rcp.delete_flag = :delete_flag
LEFT JOIN mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
LEFT JOIN rel_contract_option AS rco
    ON  rco.contract_id = c.contract_id
    AND rco.business_id = c.business_id
    AND rco.option_start_date BETWEEN :start_date AND :end_date
    AND rco.delete_flag = :delete_flag
LEFT JOIN mst_option AS mo
    ON  mo.option_id = rco.option_id
    AND mo.business_id = rco.business_id
WHERE
    u.user_id = :user_id
AND u.business_id = :business_id
AND u.status = :status
GROUP BY c.contract_id
SQL;

        $params = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
            'status'      => USER_STATUS_LIST['available'],
            'start_date'  => $start_date,
            'end_date'    => $end_date,
            'delete_flag' => FLG_OFF,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /*
     * get_user_info and contract_id
     * @param int    $user_id
     * @param int    $business_id
     * @return array
     */
    public function get_user_info_and_contract_id_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    u.user_id,
    u.business_id,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.email,
    u.status,
    CONCAT(uci.tel1_1,'-',uci.tel1_2,'-',uci.tel1_3) as telephone,
    CONCAT(uci.prefecture, uci.city, uci.town, uci.block, uci.building) as address,
    c.contract_id,
    c.entry_id
FROM
    user AS u
INNER JOIN
    user_contact_info AS uci
    ON  u.user_id = uci.user_id
    AND uci.business_id = u.business_id
    AND uci.contact_type = :contact_type
INNER JOIN
    contract c
    ON c.user_id = u.user_id
    AND c.business_id = :business_id
where
  u.user_id = :user_id
SQL;
        $params = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
            'contact_type' => CONTACT_TYPE_VALUE_LIST['CONTRACTOR'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * メールアドレスを条件にユーザログインー情報を取得する
     *
     * @param string $email
     * @param int    $business_id
     * @param int    $plan_type
     * @return array
     */
    public function get_user_login_info_by_email($email, $business_id, $plan_type) {
        $sql = <<<SQL
SELECT DISTINCT
    u.user_id,
    u.business_id,
    u.user_type,
    u.password,
    u.salt,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    u.join_datetime,
    u.withdraw_datetime,
    u.company_id,
    u.expansion_type,
    uci.email as contact_email,
    uci.contact_entry_key,
    uci.company_name as contact_company_name,
    uci.last_name as contact_last_name,
    uci.first_name as contact_first_name,
    rcp.contract_id,
    rcp.plan_end_date,
    e.status AS entry_status,
    e.entry_id,
    mp.plan_type,
    epmp.plan_type as entry_plan_type,
    ecmp.plan_type as entry_company_plan_type,
    epmp.billing_type as entry_plan_billing_type
FROM
    user AS u
INNER JOIN
    entry AS e
ON  e.user_id = u.user_id
AND e.status != :entry_status
AND e.status != :draft_entry_status
AND e.business_id = u.business_id
LEFT JOIN
    entry_plan AS ep
    ON ep.entry_id = e.entry_id
    AND ep.business_id = e.business_id
LEFT JOIN
    mst_plan AS epmp
    ON  epmp.plan_id = ep.plan_id
    AND epmp.business_id = ep.business_id
LEFT JOIN
    entry_company AS ec
    ON ec.entry_id = e.entry_id
    AND ec.business_id = e.business_id
LEFT JOIN
    mst_plan AS ecmp
    ON  ecmp.plan_id = ec.plan_id
    AND ecmp.business_id = ec.business_id
LEFT JOIN
    user_contact_info as uci
    ON u.user_id = uci.user_id
    AND uci.contact_type = :contact_type
LEFT JOIN
    contract as c
    ON c.user_id = u.user_id
    AND c.business_id = :business_id
LEFT JOIN
    rel_contract_plan AS rcp
    ON rcp.contract_id = c.contract_id
    AND rcp.business_id = :business_id
LEFT JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
WHERE
    u.email = :email
AND u.business_id = :business_id
AND u.status IN :allow_login_status
AND (mp.plan_type = :plan_type OR c.contract_id is null)
ORDER BY e.entry_id DESC
SQL;

        $param = [
            'email'        => $email,
            'business_id'  => $business_id,
            'entry_status' => ENTRY_STATUS_LIST['rejection'],
            'draft_entry_status' => ENTRY_STATUS_LIST['draft'],
            'contact_type' => CONTACT_TYPE_VALUE_LIST['CONTRACTOR'],
            'draft_cancel_status' => USER_STATUS_VALUE_LIST['DRAFT_CANCEL'],
            'plan_type'    => $plan_type,
            'allow_login_status' => MYPAGE_LOGIN_ALLOW_USER_STATUS_LIST,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザIDを条件に必要なuser情報を取得
     *
     * @param int    $user_id
     * @return array
     */
    public function get_user_info_by_only_user_id($user_id ,  array $select = ['*']){
        $query = DB::select_array($select)
                    ->from('user')
                    ->where('business_id', BUSINESS_ID)
                    ->where('user_id', $user_id)
        ;
        return $query->execute()->current();
    }

    /**
     * 申込フォームに必要なuser情報をユーザID条件に取得
     *
     * @param int   $user_id
     * @return array
     */
    public function get_form_user_info_by_user_id($user_id) {

        $select = [
            'u.user_id'
            ,'u.business_id'
            ,'u.user_type'
            ,'u.email'
            ,'u.birthday'
            ,'u.last_name'
            ,'u.last_name_kana'
            ,'u.first_name'
            ,'u.first_name_kana'
            ,'u.sex'
            ,'e.zipcode1 AS zipcode_1'
            ,'e.zipcode2 AS zipcode_2'
            ,'e.prefecture'
            ,'e.city'
            ,'e.town'
            ,'e.block'
            ,'e.building'
            ,'e.tel1_1'
            ,'e.tel1_2'
            ,'e.tel1_3'
            ,'e.tel2_1'
            ,'e.tel2_2'
            ,'e.tel2_3'
            ,'e.delivery_order_time'
        ];

        $query = DB::select_array($select)
                    ->from(['user','u'])
                    ->join(['entry','e'])
                    ->on('u.user_id', '=', 'e.user_id')
                    ->where('u.user_id', $user_id)
                    ->where('u.business_id', BUSINESS_ID)
        ;

        return $query->execute()->current();
    }

    /**
     * ユーザIDを元に、ユーザレコードを取得する
     * internal_mngより移植
     *
     * @param integer $business_id
     * @param integer $user_id
     * @return array 取得結果
     */
    public function get_user_data_by_user_id($business_id, $user_id)
    {
        $query = <<<SQL
        SELECT
            user.user_id
          , user.business_id
          , user.status
          , user_ucl.user_code
          , user_ucl.user_password
          , company.company_id
          , company.name AS company_name
          , company.tel1_1 AS company_tel1_1
          , company.tel1_2 AS company_tel1_2
          , company.tel1_3 AS company_tel1_3
          , company.tel2_1 AS company_tel2_1
          , company.tel2_2 AS company_tel2_2
          , company.tel2_3 AS company_tel2_3
          , company.prefecture AS company_prefecture
          , company.city AS company_city
          , company.town AS company_town
          , company.block AS company_block
          , company.building AS company_building
          , user.last_name AS contractor_last_name
          , user.last_name_kana AS contractor_last_name_kana
          , user.first_name AS contractor_first_name
          , user.first_name_kana AS contractor_first_name_kana
          , user.user_type AS contractor_user_type
          , user.birthday AS contractor_birthday
          , user.sex AS contractor_sex
          , contactor_contact_info.tel1_1 AS contractor_tel1_1
          , contactor_contact_info.tel1_2 AS contractor_tel1_2
          , contactor_contact_info.tel1_3 AS contractor_tel1_3
          , contactor_contact_info.tel2_1 AS contractor_tel2_1
          , contactor_contact_info.tel2_2 AS contractor_tel2_2
          , contactor_contact_info.tel2_3 AS contractor_tel2_3
          , user.email AS contractor_email
          , contactor_contact_info.zipcode1 AS contractor_zipcode1
          , contactor_contact_info.zipcode2 AS contractor_zipcode2
          , contactor_contact_info.prefecture AS contractor_prefecture
          , contactor_contact_info.city AS contractor_city
          , contactor_contact_info.town AS contractor_town
          , contactor_contact_info.block AS contractor_block
          , contactor_contact_info.building AS contractor_building
          , settlement_info.settlement_type AS contractor_settlement_type
          , user_contact_info.last_name AS last_name
          , user_contact_info.last_name_kana AS last_name_kana
          , user_contact_info.first_name AS first_name
          , user_contact_info.first_name_kana AS first_name_kana
          , user_contact_info.tel1_1 AS user_tel1_1
          , user_contact_info.tel1_2 AS user_tel1_2
          , user_contact_info.tel1_3 AS user_tel1_3
          , user_contact_info.tel2_1 AS user_tel2_1
          , user_contact_info.tel2_2 AS user_tel2_2
          , user_contact_info.tel2_3 AS user_tel2_3
          , user_contact_info.prefecture AS user_prefecture
          , user_contact_info.city AS user_city
          , user_contact_info.town AS user_town
          , user_contact_info.block AS user_block
          , user_contact_info.building AS user_building
          , e.entry_id
          , c.contract_id
          , mp.device_type
        FROM
          user
        INNER JOIN
          entry AS e
          ON  e.user_id = user.user_id
          AND e.business_id = user.business_id
        INNER JOIN
          settlement_info
          ON settlement_info.business_id = user.business_id
          AND settlement_info.user_id = user.user_id
        INNER JOIN
          user_contact_info contactor_contact_info
          ON contactor_contact_info.business_id = user.business_id
          AND contactor_contact_info.user_id = user.user_id
          AND contactor_contact_info.contact_type = :contact_type_contractor
        LEFT JOIN
          user_contact_info user_contact_info
          ON user_contact_info.business_id = user.business_id
          AND user_contact_info.user_id = user.user_id
          AND user_contact_info.contact_type = :contact_type_user
        LEFT JOIN
          company
          ON company.company_id = user.company_id
        LEFT JOIN
          contract AS c
          ON  c.user_id = user.user_id
          AND c.entry_id = e.entry_id
          AND c.business_id = user.business_id
        LEFT JOIN
          user_ucl
          ON user_ucl.user_id = user.user_id
          AND user_ucl.contract_id = c.contract_id
        LEFT JOIN
          entry_plan ep
          ON e.entry_id = ep.entry_id
          AND user.business_id = ep.business_id
        LEFT JOIN
          mst_plan mp
          ON ep.plan_id = mp.plan_id
          AND user.business_id = mp.business_id
        WHERE
          user.business_id = :business_id
          AND user.user_id = :user_id
          AND user.status != :temporary_register

        SQL;

        $bind_params = [];
        $bind_params['contact_type_contractor'] = USER_CONTACT_TYPE_CONTRACT;
        $bind_params['contact_type_user'] = USER_CONTACT_TYPE_USER;
        $bind_params['business_id'] = $business_id;
        $bind_params['user_id'] = $user_id;
        $bind_params['temporary_register'] = USER_STATUS_TEMPORARY_REGISTER;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->current();
    }

    /**
     * emailでログイン可能な顧客情報を取得する
     *
     * @param  string $email
     * @param  int    $business_id
     * @return array
     */
    public function can_user_login_by_email($email, $business_id) {
        $sql = <<<SQL
SELECT
    u.user_id,
    u.business_id,
    u.user_type,
    u.email
FROM
    user AS u
WHERE
    u.business_id = :business_id
AND u.email = :email
AND u.login_user_id is not null
SQL;

        $param = [
            'business_id'  => $business_id,
            'email'        => $email,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * メールアドレスを条件にユーザログインー情報を取得する
     *
     * @param string $login_user_id
     * @param int    $business_id
     * @return array
     */
    public function get_user_login_info_by_login_user_id($login_user_id, $business_id) {
        $sql = <<<SQL
SELECT
    u.user_id,
    u.business_id,
    u.user_type,
    u.password,
    u.salt,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    u.join_datetime,
    u.withdraw_datetime,
    u.company_id,
    uci.email as contact_email,
    uci.contact_entry_key,
    uci.company_name as contact_company_name,
    uci.last_name as contact_last_name,
    uci.first_name as contact_first_name,
    rcp.plan_end_date,
    e.status AS entry_status,
    e.entry_id,
    c.contract_id
FROM
    user AS u
INNER JOIN
    entry AS e
ON  e.user_id = u.user_id
AND e.status != :entry_status
AND e.status != :draft_entry_status
AND e.business_id = u.business_id
LEFT JOIN
    user_contact_info as uci
    ON u.user_id = uci.user_id
    AND uci.contact_type = :contact_type
LEFT JOIN
    contract as c
    ON c.user_id = u.user_id
    AND c.business_id = :business_id
LEFT JOIN
    rel_contract_plan AS rcp
    ON rcp.contract_id = c.contract_id
    AND rcp.business_id = :business_id
LEFT JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
    AND mp.plan_type IN :plan_type
WHERE
    u.login_user_id = :login_user_id
AND u.business_id = :business_id
AND u.status IN :allow_login_status
ORDER BY e.entry_id DESC
SQL;

        $param = [
            'login_user_id'         => $login_user_id,
            'business_id'           => $business_id,
            'entry_status'          => ENTRY_STATUS_LIST['rejection'],
            'draft_entry_status'    => ENTRY_STATUS_LIST['draft'],
            'contact_type'          => CONTACT_TYPE_VALUE_LIST['CONTRACTOR'],
            'draft_cancel_status'   => USER_STATUS_VALUE_LIST['DRAFT_CANCEL'],
            'plan_type'             => ALLOW_LOGIN_PLAN_TYPE_LIST,
            'allow_login_status'    => MYPAGE_LOGIN_ALLOW_USER_STATUS_LIST,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * メールアドレスを条件にユーザー情報を取得する(重複チェック用)
     *
     * @param int    $business_id
     * @param string $email
     * @param int    $plan_type
     * @return array
     */
    public function get_exists_email_by_plan_type($business_id, $email, $plan_type) {
        $sql = <<<SQL
SELECT
    u.user_id
    , u.user_type
    , u.status
    , u.withdraw_datetime
    , mp.plan_id
    , rcp.plan_end_date
FROM
    user AS u
    INNER JOIN entry AS e
        ON e.user_id = u.user_id
        AND e.business_id = u.business_id
        AND e.status != :entry_status
        AND e.status != :draft_entry_status
    INNER JOIN entry_plan ep
        ON ep.entry_id = e.entry_id
        AND ep.business_id = e.business_id
    INNER JOIN mst_plan AS mp
        ON mp.plan_id = ep.plan_id
        AND mp.plan_type = :plan_type
    LEFT JOIN contract as c
        ON c.user_id = u.user_id
        AND c.entry_id = e.entry_id
        AND c.business_id = u.business_id
    LEFT JOIN rel_contract_plan AS rcp
        ON rcp.contract_id = c.contract_id
        AND rcp.business_id = u.business_id
WHERE
    u.email = :email
    AND u.business_id = :business_id
    AND u.status IN :user_status_list
ORDER BY
    u.join_datetime DESC
SQL;

        $param = [
            'business_id'  => $business_id,
            'email'        => $email,
            'plan_type'    => $plan_type,
            'entry_status' => ENTRY_STATUS_LIST['rejection'],
            'draft_entry_status' => ENTRY_STATUS_LIST['draft'],
            'user_status_list' => ENTRY_DUPLICATE_NOT_ALLOW_USER_STATUS_LIST,   // TODO：再申込実装の際はここの変更も必要
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 会員IDの一覧を取得する
     *
     * @param  array $user_ids
     * @param  int   $business_id
     * @return array $result
     */
    public function get_user_login_id_info_list($user_ids, $business_id) {
        $sql = <<<SQL
select
   user.login_user_id,
   mst_plan.name as login_user_plan_name,
   imei.imei as login_user_imei,
   entry_history.create_datetime as entry_create_datetime
from user
left join entry
    on user.user_id = entry.user_id
           AND user.business_id = entry.business_id
left join entry_plan
    on entry_plan.entry_id = entry.entry_id
           AND entry_plan.business_id = entry.business_id
left join contract
    on contract.user_id = user.user_id
           AND contract.entry_id = entry.entry_id
left join imei
    on contract.contract_id = imei.contract_id
           AND contract.business_id = imei.business_id
left join entry_history
    on entry_history.entry_id = entry.entry_id
           AND entry_history.business_id = entry.business_id
left join mst_plan
    on mst_plan.plan_id = entry_plan.plan_id
           AND mst_plan.business_id = entry_plan.business_id
WHERE
    user.user_id IN :user_ids
AND user.business_id = :business_id
AND user.user_type = :user_type
AND user.login_user_id is not null
AND (entry_history.status = :entry_status OR entry_history.status is null)
SQL;

        $param = [
            'user_ids'      => $user_ids,
            'business_id'   => $business_id,
            'user_type'     => USER_TYPE_LIST['PRIVATE'],
            'entry_status'  => ENTRY_STATUS_VALUE_LIST['NEW'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }
    /*
     * ユーザーIDとプラン区分を条件にユーザー情報を取得する
     *
     * @param int $business_id
     * @param int $user_id
     * @return array
     */
    public function get_user_info_by_user_id_plan_type($business_id, $user_id, $plan_type) {
        // TODO：現在の実装ではuser.statusのみ使用。今後必要に応じてカラムを増設可能
        $sql = <<<SQL
SELECT
    u.status
FROM
    user u
    INNER JOIN entry e
        ON u.user_id = e.user_id
        AND e.business_id = u.business_id
        AND e.status != :entry_status
    INNER JOIN entry_plan ep
        ON e.entry_id = ep.entry_id
    INNER JOIN mst_plan mp
        ON ep.plan_id = mp.plan_id
WHERE
    u.user_id = :user_id
    AND u.business_id = :business_id
    AND u.status IN :user_status
    AND mp.plan_type = :plan_type
SQL;

        $user_status = LOGIN_ALLOW_USER_STATUS_LIST;
        array_push($user_status, USER_STATUS_LIST['draft']); // 通常の仮申込も含める
        $param = [
            'entry_status' => ENTRY_STATUS_LIST['rejection'],
            'user_id'      => $user_id,
            'business_id'  => $business_id,
            'user_status'  => $user_status,
            'plan_type'    => $plan_type,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザ情報と法人レコードを取得する
     *
     * @param integer $business_id 事業者ID
     * @param integer $user_id ユーザーID
     * @return array 取得結果
     */
    public function get_user_info_with_company_info($business_id, $user_id)
    {
        $query = <<<SQL
SELECT
    u.user_id,
    u.business_id,
    u.user_type,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    c.company_id,
    uci.company_name,
    uci.zipcode1,
    uci.zipcode2,
    uci.prefecture,
    uci.city,
    uci.town,
    uci.block,
    uci.building,
    uci.tel1_1,
    uci.tel1_2,
    uci.tel1_3,
    uci.tel2_1,
    uci.tel2_2,
    uci.tel2_3
FROM
    user As u
INNER JOIN
    company As c
ON
    u.company_id = c.company_id
LEFT JOIN
    user_contact_info As uci
ON
    u.user_id = uci.user_id
AND
    uci.contact_type = 0
WHERE
    u.user_id = :user_id
AND
    u.business_id = :business_id
SQL;

        $param = [
            'business_id' => $business_id,
            'user_id' => $user_id
        ];

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * ユーザ情報と連絡先レコードを取得する
     *
     * @param integer $business_id 事業者ID
     * @param integer $user_id ユーザーID
     * @param integer $contact_type 連絡先種別
     * @return array 取得結果
     */
    public function get_user_info_with_contact_info($business_id, $user_id, $contact_type)
    {
        $query = <<<SQL
SELECT
    u.user_id,
    u.business_id,
    u.user_type,
    u.email,
    u.birthday,
    u.last_name,
    u.last_name_kana,
    u.first_name,
    u.first_name_kana,
    u.status,
    u.sex,
    uci.contact_type,
    uci.zipcode1,
    uci.zipcode2,
    uci.prefecture,
    uci.city,
    uci.town,
    uci.block,
    uci.building,
    uci.last_name As contact_last_name,
    uci.last_name_kana As contact_last_name_kana,
    uci.first_name As contact_first_name,
    uci.first_name_kana As contact_first_name_kana,
    uci.tel1_1,
    uci.tel1_2,
    uci.tel1_3,
    uci.tel2_1,
    uci.tel2_2,
    uci.tel2_3
FROM
    user As u
INNER JOIN
    user_contact_info As uci
ON
    u.business_id = uci.business_id
AND
    u.user_id = uci.user_id
AND
    uci.contact_type = :contact_type
WHERE
    u.user_id = :user_id
AND
    u.business_id = :business_id
SQL;

        $param = [
            'business_id' => $business_id,
            'user_id' => $user_id,
            'contact_type' => $contact_type
        ];

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * 更新する
     *
     * @param array $update_params 更新値
     *            ['カラム名' => '値']形式の連想配列
     * @param array $where_params 検索値
     *            ['カラム名' => '値']形式の連想配列
     * @return int 更新件数
     */
    public function update($update_params, $where_params)
    {
        return DB::update(self::$_table_name)->set($update_params)
            ->where($where_params)
            ->execute();
    }

    /**
     * 複数条件を指定して簡単なSELECTを行う
     * @param array $select 取得カラム
     * @param array $wheres 検索条件[0 => [{カラム名} => {値}], 1 => ...]
     * @param array $order ソート条件 [0 => [{カラム名} => {昇順/降順}]]
     * @return array 抽出結果
     */
    public function get_record($select, $wheres, $order = []) {
        if (empty($wheres)) return [];
        $query = DB::select_array($select)->from(self::$_table_name);
        foreach ($wheres as $key => $value) {
            $query->where($key, $value);
        }
        foreach ($order as $key => $value) {
            $query->order_by($key, $value);
        }
        return $query->execute()->as_array();
    }
}
