<?php

/**
 * 本人確認用トークンテーブルのモデルクラス
 */
class Model_HumanLife_PasswordReminder extends Model_CrudAbstract {
    /**
     * 本人確認用トークンを登録する
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param string $token
     */
    public function insert_password_reminder($user_id, $business_id, $token) {
        $sql = <<<SQL
INSERT INTO
    password_reminder
(
    user_id,
    business_id,
    token,
    delete_flag
)
VALUE
(
    :user_id,
    :business_id,
    :token,
    :delete_flag
)
SQL;
        $param = [
            'user_id'         => $user_id,
            'business_id'     => $business_id,
            'token'           => $token,
            'delete_flag'     => FLG_OFF,
        ];

        parent::pre_save($sql);
        $result = DB::query($sql)->parameters($param)->execute();
        parent::post_save($result);
    }

    /**
     * トークンから本人確認用データを取得する
     *
     * @param string $token
     * @param int    $business_id
     * @return array
     */
    public function get_password_reminder_info($token, $business_id) {
        $sql = <<<SQL
SELECT
    pr.business_id,
    pr.user_id,
    pr.token,
    pr.create_datetime,
    u.user_type,
    mp.plan_type,
    epmp.plan_type as entry_plan_type
FROM
    password_reminder as pr
INNER JOIN
    user AS u
ON  u.user_id = pr.user_id
AND u.business_id = :business_id
INNER JOIN
    entry AS e
ON  e.user_id = pr.user_id
AND e.business_id = u.business_id
LEFT JOIN
    entry_plan AS ep
    ON ep.entry_id = e.entry_id
    AND ep.business_id = e.business_id
LEFT JOIN
    mst_plan AS epmp
    ON  epmp.plan_id = ep.plan_id
    AND epmp.business_id = ep.business_id
LEFT JOIN contract as c
    on c.user_id = pr.user_id
    AND c.business_id = pr.business_id
LEFT JOIN rel_contract_plan as rcp
    on rcp.contract_id = c.contract_id
    AND rcp.business_id = c.business_id
LEFT JOIN mst_plan as mp
    on mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
WHERE
    pr.token = :token
AND
    pr.business_id = :business_id
AND
    pr.delete_flag = :delete_flag
AND
    (mp.plan_type IS NULL OR mp.plan_type IN :plan_type_list)
SQL;
        $param = [
            'token'       => $token,
            'business_id' => $business_id,
            'delete_flag' => FLG_OFF,
            'plan_type_list' => [
                PLAN_TYPE_DOMESTIC,
                PLAN_TYPE_INTERNATIONAL_RENTAL,
                PLAN_TYPE_INTERNATIONAL_PREPAID
            ],
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 本人確認用データの削除する
     *
     * @param int $business_id
     * @param int $user_id
     */
    public function delete_password_reminder($user_id, $business_id) {
        $sql = <<<SQL
UPDATE
    password_reminder
SET
    delete_flag = :delete_flag,
    update_datetime = :update_datetime
WHERE
    user_id = :user_id
AND business_id = :business_id
SQL;
        $param = [
            'delete_flag'     => FLG_ON,
            'update_datetime' => Helper_Time::getCurrentDateTime(),
            'user_id'         => $user_id,
            'business_id'     => $business_id,
        ];

        parent::pre_save($query);
        $result = DB::query($sql)->parameters($param)->execute();
        parent::post_save($result);
    }
}
