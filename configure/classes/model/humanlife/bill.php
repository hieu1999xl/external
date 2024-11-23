<?php

/**
 * 請求書テーブルのモデルクラス
 *
 * @author m.ishikawa@humanlife.co.jp
 */

class Model_HumanLife_Bill extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string  請求書テーブル名
     */
    protected static $_table_name = 'bill';

    /**
     * 最新の事業者IDの登録請求書番号を取得する
     *
     * @param integer $business_id 事業者ID
     * @param integer $user_id 請求先ユーザID
     * @param integer $service_use_date サービス利用年月
     * @return array 請求書番号
     */
    public function get_registered_bill_id($business_id, $user_id, $service_use_date) {
        $query = <<<SQL
SELECT
    bill_id
FROM
    bill
WHERE
    business_id = :business_id
AND
    user_id = :user_id
AND
    service_use_date = :service_use_date
SQL;

        $param = [
            'business_id' => $business_id,
            'user_id' => $user_id,
            'service_use_date' => $service_use_date,
        ];

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * 請求書IDから請求書情報を取得する
     *
     * @param int $business_id 事業者ID
     * @param int $bill_id 請求書ID
     * @return array 取得結果
     */
    public function get_by_bill_id($business_id, $bill_id)
    {
        $query = <<<SQL
        SELECT
            bill.*
            , bill_issue_history.issue_datetime
            , CONCAT('〒', uci.zipcode1, '-', uci.zipcode2) AS zipcode
            , CONCAT(uci.prefecture, uci.city, uci.town, uci.block) AS user_address
            , CONCAT(uci.last_name,uci.first_name) AS user_name
            , uci.building
            , uci.company_name
            , uci.payment_due_date_type
            , uci.send_type
            , user.user_type
            , user.last_name_kana
            , user.first_name_kana
            , user.person_in_charge_flag
            , user.person_in_charge_flag
            , paysys_settlement_history.paysys_id
            , paysys_settlement_history.invoice_id
            , paysys_settlement_history.order_id
            , paysys_settlement_history.paysys_order_id
            , paysys_settlement_history.order_datetime
            , paysys_settlement_history.amount
            , paysys_settlement_history.delivery_type
            , paysys_settlement_history.url
            , paysys_settlement_history.url_date_of_expiry
            , paysys_settlement_history.payment_deadline
            , paysys_settlement_history.api_status
            , paysys_settlement_history.payment_status
            , paysys_settlement_history.message
        FROM
            bill
        INNER JOIN user
                ON bill.user_id = user.user_id
        LEFT JOIN bill_issue_history
            ON bill.business_id = bill_issue_history.business_id
            AND bill.bill_id = bill_issue_history.bill_id
            AND bill.latest_bill_issue_id = bill_issue_history.bill_issue_id
        LEFT JOIN user_contact_info as uci
            ON bill.business_id = uci.business_id
            AND bill.user_id = uci.user_id
        LEFT JOIN paysys_settlement_history
            ON bill.business_id = paysys_settlement_history.business_id
            AND bill.bill_id = paysys_settlement_history.bill_id
            AND paysys_settlement_history.delete_flg = :delete_flg
        WHERE
            bill.bill_id = :bill_id
            AND bill.business_id = :business_id
            AND uci.contact_type = 0

SQL;

        $bind_params = [];
        $bind_params['bill_id'] = $bill_id;
        $bind_params['business_id'] = $business_id;
        $bind_params['delete_flg'] = FLG_OFF;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * サービス利用日、ユーザIDから該当請求書の請求書支払い履歴を取得する
     *
     * @param  int   $service_use_date
     * @param  int   $user_id
     * @return array 取得結果
     */
    public function get_payment_date_by_service_use_date_and_user_id($service_use_date, $user_id)
    {
        $sql =
<<<SQL
SELECT bph.*
FROM   bill
INNER JOIN bill_payment_history bph
        ON bill.bill_id = bph.bill_id
WHERE bill.user_id = :user_id
  AND bill.service_use_date = :service_use_date
ORDER BY bph.payment_count DESC
SQL;

        $bind_params = [];
        $bind_params['user_id'] = $user_id;
        $bind_params['service_use_date'] = $service_use_date;

        return DB::query($sql)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 請求書一件の更新を行う
     *
     * @param array $params ['カラム名'=>値] の配列
     * @param int   $business_id
     * @param int   $bill_id     請求書ID
     * @return array 更新結果
     */
    public function update_one($params, $business_id, $bill_id)
    {
        $query = DB::update(self::$_table_name);

        foreach ($params as $key=>$val)
        {
            $query->value($key, $val);
        }
        $query->where('business_id', $business_id)
              ->where('bill_id', $bill_id);

        return $query->execute();
    }

    /**
     * ユーザーID、サービス利用年月から請求書情報を取得する
     *
     * @param integer $business_id      事業者ID
     * @param integer $user_id          ユーザーID
     * @param integer $service_use_date サービス利用年月
     * @return array 取得結果
     */
    public function get_by_user_id_and_service_use_date($business_id, $user_id, $service_use_date) {
        $query = <<<SQL
        SELECT
             *
        FROM
            bill
        WHERE
            business_id = :business_id
            AND user_id = :user_id
            AND service_use_date = :service_use_date

SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['user_id'] = $user_id;
        $bind_params['service_use_date'] = $service_use_date;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    /**
     * user_idを元にユーザーの請求書情報を取得する
     *
     * @param  int $user_id
     * @param  int $business_id
     * @return array
     */
    public function get_user_bill_list($user_id, $business_id) {
        $query = <<<SQL
SELECT *
FROM bill
WHERE user_id = :user_id AND
      business_id = :business_id
ORDER BY service_use_date DESC
SQL;

        $bind_params = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
        ];

        return DB::query($query)->parameters($bind_params)
        ->execute()
        ->as_array();
    }

    /**
     * 指定されたパラメータで請求書を登録する
     *
     * @param array $param 各カラムをキーに持つ連想配列型の登録データ
     * @return integer
     */
    public function regist_bill(array $param) {
        $query = <<<SQL
INSERT INTO
    bill
(
    `business_id`,
    `bill_id`,
    `user_id`,
    `service_use_date`,
    `to_bill_zipcode1`,
    `to_bill_zipcode2`,
    `to_bill_address`,
    `to_bill_copmpany_name`,
    `to_bill_name`,
    `from_bill_zipcode1`,
    `from_bill_zipcode2`,
    `from_bill_address`,
    `from_bill_company_name`,
    `from_bill_tel1_1`,
    `from_bill_tel1_2`,
    `from_bill_tel1_3`,
    `from_bill_fax1_1`,
    `from_bill_fax1_2`,
    `from_bill_fax1_3`,
    `billing_closing_date`,
    `transfer_due_date`,
    `bill_fixed_status`,
    `bill_issue_status`,
    `latest_bill_issue_id`,
    `bill_status`,
    `bill_type`,
    `create_user`,
    `update_user`
)
VALUES
(
    :business_id,
    :bill_id,
    :user_id,
    :service_use_date,
    :to_bill_zipcode1,
    :to_bill_zipcode2,
    :to_bill_address,
    :to_bill_copmpany_name,
    :to_bill_name,
    :from_bill_zipcode1,
    :from_bill_zipcode2,
    :from_bill_address,
    :from_bill_company_name,
    :from_bill_tel1_1,
    :from_bill_tel1_2,
    :from_bill_tel1_3,
    :from_bill_fax1_1,
    :from_bill_fax1_2,
    :from_bill_fax1_3,
    :billing_closing_date,
    :transfer_due_date,
    :bill_fixed_status,
    :bill_issue_status,
    :latest_bill_issue_id,
    :bill_status,
    :bill_type,
    :create_user,
    :update_user
)
SQL;

        $param['create_user'] = SYSTEM_USER_NAME;
        $param['update_user'] = SYSTEM_USER_NAME;

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * 請求書発行ステータスと最新請求書発行番号を更新する
     *
     * @param int $business_id 事業者ID
     * @param int $bill_id 請求書ID
     * @param int $bill_fixed_status 請求書確定ステータス
     * @param int $latest_bill_issue_id 最新請求書発行番号
     * @param string $login_user_id 更新ユーザーID
     * @return int レコード数
     */
    public function update_bill_issue_status_and_latest_bill_issue_id($business_id, $bill_id, $bill_issue_status, $latest_bill_issue_id, $login_user_id)
    {
        $query = <<<SQL
        UPDATE
            bill
        SET
            bill_issue_status = :bill_issue_status
          , latest_bill_issue_id = :latest_bill_issue_id
          , update_datetime = :update_datetime
          , update_user = :update_user
        WHERE
          business_id = :business_id
          AND bill_id = :bill_id

SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['bill_id'] = $bill_id;
        $bind_params['bill_issue_status'] = $bill_issue_status;
        $bind_params['latest_bill_issue_id'] = $latest_bill_issue_id;
        $bind_params['update_datetime'] = Helper_Time::getCurrentDateTime();
        $bind_params['update_user'] = $login_user_id;

        return DB::query($query)->parameters($bind_params)->execute();
    }
}
