<?php

/**
 * 申し込みテーブルのモデルクラス
 */
class Model_HumanLife_Entry extends Model_CrudAbstract {

    /**
     * テーブル名
     *
     * @var string  請求書番号管理テーブル名
     */
    protected static $_table_name = 'entry';

    /**
     * ユーザIDを条件に有効な申し込み情報の件数を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_valid_entry_count_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    COUNT(*) AS count
FROM
    entry AS e
WHERE
    e.user_id = :user_id
AND e.business_id = :business_id
AND e.status != :status
SQL;

        $params = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
            'status'      => ENTRY_STATUS_VALUE_LIST['REJECTION'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザIDを条件に有効な申し込み(契約)情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @param int $user_type
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function entry_contract_info_list_by_user_id($user_id, $business_id, $user_type, $limit = null, $offset = 0) {
        $sql = <<<SQL
SELECT
    e.entry_id
  , e.user_id
  , e.status AS entry_status
  , c.contract_id
  , emp.plan_id AS entry_plan_id
  , emp.name AS entry_plan_name
  , emp.plan_type AS entry_plan_type
  , emp.price AS entry_plan_price
  , emp.billing_type AS entry_plan_billomg_type
  , emp.tax_type AS entry_plan_tax_include_flag
  , emp.contract_duration_month
  , emp.is_cancel_fee_required
  , emp.auto_renewal
  , emp.device_type
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(eo.entry_option_id, ''), IFNULL(emo.option_id, ''), IFNULL(emo.name, ''), IFNULL(emo.option_type, '')
      , IFNULL(emo.price, ''), IFNULL(emo.billing_type, ''), IFNULL(emo.tax_type, '')) ORDER BY emo.disp_order) AS entry_option_info_list_str
  , emd.device_id AS entry_device_id
  , emd.name AS entry_device_name
  , emd.image_path AS entry_device_image_path
  , emd.color AS entry_device_color
  , emd.charge AS entry_device_charge
  , emd.tax_type AS entry_device_tax_type
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rcpd.contract_plan_id, ''), IFNULL(cmpd.plan_id, ''), IFNULL(cmpd.name, ''), IFNULL(cmpd.plan_type, ''), IFNULL(cmpd.price, '')
      , IFNULL(cmpd.billing_type, ''), IFNULL(cmpd.tax_type, ''), IFNULL(rcpd.plan_start_date, ''), IFNULL(rcpd.plan_end_date, '')
      , IFNULL(cmpd.auto_renewal,''), IFNULL(cmpd.device_type,''), IFNULL(cmpd.contract_duration_month,''), IFNULL(cmpd.is_cancel_fee_required,'')
      , IFNULL(cmpd.pay_as_you_go_type,''), IFNULL(cmpd.is_hotel_plan,'')) ORDER BY cmpd.disp_order) AS contract_domestic_plan_info_list_str
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rco.contract_option_id, ''), IFNULL(cmo.option_id, ''), IFNULL(cmo.name, ''), IFNULL(cmo.option_type, ''), IFNULL(cmo.price, '')
      , IFNULL(cmo.billing_type, ''), IFNULL(cmo.tax_type, ''), IFNULL(rco.option_start_date, ''), IFNULL(rco.option_end_date, ''), IFNULL(rco.insurance_account, '')) ORDER BY cmo.disp_order) AS contract_option_info_list_str
  , cmd.device_id AS contract_device_id
  , cmd.name AS contract_device_name
  , cmd.image_path AS contract_device_image_path
  , cmd.color AS contract_device_color
  , cmd.charge AS contract_device_charge
  , cmd.tax_type AS contract_device_tax_type
  , cmd.division_month AS division_month
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rcpd.contract_plan_id, ''))) AS entry_contract_plan_id
  , i.imei
  , msd.sales_date
  , min(eh.create_datetime) as create_datetime
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(ed.is_new, ''))) AS is_new
FROM
    entry AS e
        INNER JOIN
            entry_plan AS ep
        ON  ep.entry_id = e.entry_id
        AND ep.business_id = e.business_id
        INNER JOIN
            entry_history eh
        ON  eh.entry_id = e.entry_id
        AND eh.status IN :eh_status
        LEFT JOIN
            mst_plan AS emp
        ON  emp.plan_id = ep.plan_id
        AND emp.business_id = ep.business_id
        LEFT JOIN
            entry_option AS eo
        ON  eo.entry_id = e.entry_id
        AND eo.business_id = e.business_id
        LEFT JOIN
            mst_option AS emo
        ON  emo.option_id = eo.option_id
        AND emo.business_id = eo.business_id
        INNER JOIN
            entry_device AS ed
        ON  ed.entry_id = e.entry_id
        AND ed.business_id = e.business_id
        INNER JOIN
            mst_device AS emd
        ON  emd.device_id = ed.device_id
        AND emd.business_id = ed.business_id
        LEFT JOIN
            contract AS c
        ON  c.user_id = e.user_id
        AND c.business_id = e.business_id
        AND c.entry_id = e.entry_id
        AND c.delete_flag = :delete_flag
        # 国内プラン
        LEFT JOIN
            rel_contract_plan AS rcpd
        ON  rcpd.contract_id = c.contract_id
        AND rcpd.business_id = c.business_id
        AND rcpd.delete_flag = :delete_flag
        LEFT JOIN
            mst_plan AS cmpd
        ON  cmpd.plan_id = rcpd.plan_id
        AND cmpd.business_id = rcpd.business_id
        AND cmpd.plan_type IN :domestic_plan_type
        LEFT JOIN
            rel_contract_option AS rco
        ON  rco.contract_id = c.contract_id
        AND rco.business_id = c.business_id
        AND (rco.option_end_date > NOW() OR rco.option_end_date IS NULL)
        AND rco.delete_flag = :delete_flag
        LEFT JOIN
            mst_option AS cmo
        ON  cmo.option_id = rco.option_id
        AND cmo.business_id = rco.business_id
        LEFT JOIN
            rel_contract_device rcd
        ON  rcd.contract_id = c.contract_id
        AND rcd.business_id = c.business_id
SQL;
        if ((int)$user_type === 0) {
            $sql .= <<<SQL
        AND rcd.device_id = ed.device_id
SQL;
}
    $sql .= <<<SQL
        LEFT JOIN
            mst_device AS cmd
        ON  cmd.device_id = rcd.device_id
        AND cmd.business_id = rcd.business_id
        LEFT JOIN
            imei AS i
        ON  i.contract_id = rcd.contract_id
        AND i.rel_contract_device_id = rcd.rel_contract_device_id
        AND i.business_id = rcd.business_id
        AND i.delete_flag = :delete_flag
        LEFT JOIN
            mst_shipping_device AS msd
        ON i.imei = msd.imei2
WHERE
    e.user_id = :user_id
AND e.business_id = :business_id
AND e.status != :status
GROUP BY
    e.entry_id, e.status, e.create_datetime, c.contract_id
  , emp.plan_id, emp.name, emp.plan_type, emp.price, emp.billing_type, emp.tax_type
  , emd.device_id, emd.name, emd.image_path, emd.color
  , cmd.device_id, cmd.name, cmd.image_path, cmd.color, i.imei, msd.sales_date, eh.entry_id
ORDER BY
    c.contract_id IS NULL DESC,
    e.entry_id ASC
SQL;

        $params = [
            'user_id'                      => $user_id,
            'business_id'                  => $business_id,
            'status'                       => ENTRY_STATUS_VALUE_LIST['REJECTION'],
            'domestic_plan_type'           => [PLAN_TYPE_DOMESTIC, PLAN_TYPE_INTERNATIONAL_PREPAID],
            'international_plan_type_list' => INTERNATIONAL_PLAN_TYPE_LIST,
            'delete_flag'                  => FLG_OFF,
            'monthly_type'                 => BILLING‗TYPE_VALUE_LIST['MONTHLY'],
            'bill_complete_status'         => INVOICE_STATUS_VALUE_LIST['BILL_COMP'],
            'eh_status'                    => [
                ENTRY_STATUS_ENTRY,
                ENTRY_STATUS_HAVE_DEVICE
            ],
        ];

        if (!is_null($limit)) {
            $sql .= PHP_EOL . <<<SQL
LIMIT
    :limit
SQL;
            $params['limit'] = $limit;
        }

        if (0 < $offset) {
            $sql .= PHP_EOL . <<<SQL
OFFSET
    :offset
SQL;
            $params['offset'] = $offset;
        }

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }


    /**
     * 法人ユーザIDを条件に有効な申し込み(契約)情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function entry_contract_info_list_by_corp_user_id($user_id, $business_id, $limit = null, $offset = 0, $flag) {
        $sql = <<<SQL
SELECT
    e.entry_id
  , e.status AS entry_status
  , e.create_datetime
  , c.contract_id
  , c.entry_company_id
  , emp.plan_id AS entry_plan_id
  , emp.name AS entry_plan_name
  , emp.plan_type AS entry_plan_type
  , emp.price AS entry_plan_price
  , emp.billing_type AS entry_plan_billomg_type
  , emp.tax_type AS entry_plan_tax_include_flag
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(eo.entry_option_id, ''), IFNULL(emo.option_id, ''), IFNULL(emo.name, ''), IFNULL(emo.option_type, '')
      , IFNULL(emo.price, ''), IFNULL(emo.billing_type, ''), IFNULL(emo.tax_type, '')) ORDER BY emo.disp_order) AS entry_option_info_list_str
  , emd.device_id AS entry_device_id
  , emd.name AS entry_device_name
  , emd.image_path AS entry_device_image_path
  , emd.color AS entry_device_color
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rcpd.contract_plan_id, ''), IFNULL(cmpd.plan_id, ''), IFNULL(cmpd.name, ''), IFNULL(cmpd.plan_type, ''), IFNULL(cmpd.price, '')
      , IFNULL(cmpd.billing_type, ''), IFNULL(cmpd.tax_type, ''), IFNULL(rcpd.plan_start_date, ''), IFNULL(rcpd.plan_end_date, '')
      , IFNULL(cmpd.auto_renewal,''), IFNULL(cmpd.device_type,''), IFNULL(cmpd.contract_duration_month,''), IFNULL(cmpd.is_cancel_fee_required,'')
      , IFNULL(cmpd.pay_as_you_go_type,''), IFNULL(cmpd.is_hotel_plan,'')) ORDER BY cmpd.disp_order) AS contract_domestic_plan_info_list_str
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rco.contract_option_id, ''), IFNULL(cmo.option_id, ''), IFNULL(cmo.name, ''), IFNULL(cmo.option_type, ''), IFNULL(cmo.price, '')
      , IFNULL(cmo.billing_type, ''), IFNULL(cmo.tax_type, ''), IFNULL(rco.option_start_date, ''), IFNULL(rco.option_end_date, '')) ORDER BY cmo.disp_order) AS contract_option_info_list_str
  , cmd.device_id AS contract_device_id
  , cmd.name AS contract_device_name
  , cmd.image_path AS contract_device_image_path
  , cmd.color AS contract_device_color
  , i.imei
  , emp.auto_renewal
  , emp.device_type
  , emp.contract_duration_month
  , emp.pay_as_you_go_type
  , emp.is_hotel_plan
FROM
    entry AS e
    INNER JOIN
            entry_company AS ec
        ON  ec.entry_id = e.entry_id
        AND ec.business_id = e.business_id
        LEFT JOIN
            mst_plan AS emp
        ON  emp.plan_id = ec.plan_id
        AND emp.business_id = ec.business_id
        LEFT JOIN
            entry_option AS eo
        ON  eo.entry_id = e.entry_id
        AND eo.business_id = e.business_id
        LEFT JOIN
            mst_option AS emo
        ON  emo.option_id = eo.option_id
        AND emo.business_id = eo.business_id
        -- INNER JOIN
--             entry_device AS ed
--         ON  ed.entry_id = e.entry_id
--         AND ed.business_id = e.business_id
        INNER JOIN
            mst_device AS emd
        ON  emd.device_id = ec.device_id
        AND emd.business_id = ec.business_id
        LEFT JOIN
            contract AS c
        ON  c.user_id = e.user_id
        AND c.business_id = e.business_id
        AND c.entry_id = e.entry_id
        AND c.delete_flag = :delete_flag
        AND c.entry_company_id = ec.entry_company_id
--         # 国内プラン
        LEFT JOIN
            rel_contract_plan AS rcpd
        ON  rcpd.contract_id = c.contract_id
        AND rcpd.business_id = c.business_id
        AND rcpd.delete_flag = :delete_flag
        LEFT JOIN
            mst_plan AS cmpd
        ON  cmpd.plan_id = rcpd.plan_id
        AND cmpd.business_id = rcpd.business_id
        AND cmpd.plan_type = :domestic_plan_type
        LEFT JOIN
            rel_contract_option AS rco
        ON  rco.contract_id = c.contract_id
        AND rco.business_id = c.business_id
SQL;
        if ($flag == FLG_OFF){
            $sql.= ' AND (rco.option_end_date > NOW() OR rco.option_end_date IS NULL)';
        }
$sql.= <<<SQL
        AND rco.delete_flag = :delete_flag
        LEFT JOIN
            mst_option AS cmo
        ON  cmo.option_id = rco.option_id
        AND cmo.business_id = rco.business_id
        LEFT JOIN
            rel_contract_device rcd
        ON  rcd.contract_id = c.contract_id
        AND rcd.business_id = c.business_id
        LEFT JOIN
            mst_device AS cmd
        ON  cmd.device_id = rcd.device_id
        AND cmd.business_id = rcd.business_id
        LEFT JOIN
            imei AS i
        ON  i.contract_id = rcd.contract_id
        AND i.rel_contract_device_id = rcd.rel_contract_device_id
        AND i.business_id = rcd.business_id
        AND i.delete_flag = :delete_flag
WHERE
    e.user_id = :user_id
AND e.business_id = :business_id
AND e.status != :status
GROUP BY
    e.entry_id, e.status, e.create_datetime, c.contract_id
  , emp.plan_id, emp.name, emp.plan_type, emp.price, emp.billing_type, emp.tax_type
  , emd.device_id, emd.name, emd.image_path, emd.color
  , cmd.device_id, cmd.name, cmd.image_path, cmd.color, i.imei
ORDER BY
    c.contract_id IS NULL DESC,
    e.entry_id ASC
SQL;

        $params = [
            'user_id'                      => $user_id,
            'business_id'                  => $business_id,
            'status'                       => ENTRY_STATUS_VALUE_LIST['REJECTION'],
            'domestic_plan_type'           => PLAN_TYPE_LIST['DOMESTIC'],
            'international_plan_type_list' => INTERNATIONAL_PLAN_TYPE_LIST,
            'delete_flag'                  => FLG_OFF,
            'monthly_type'                 => BILLING‗TYPE_VALUE_LIST['MONTHLY'],
            'bill_complete_status'         => INVOICE_STATUS_VALUE_LIST['BILL_COMP'],
        ];

//        if (!is_null($limit)) {
//            $sql .= PHP_EOL . <<<SQL
//LIMIT
//    :limit
//SQL;
//            $params['limit'] = $limit;
//        }
//
//        if (0 < $offset) {
//            $sql .= PHP_EOL . <<<SQL
//OFFSET
//    :offset
//SQL;
//            $params['offset'] = $offset;
//        }

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザIDとステータスを条件に有効な申し込み情報を取得する
     *
     * @param int $business_id
     * @param int $user_id
     * @param int $status
     * @return array
     */
    public function get_entry_by_user_id_and_status($business_id, $user_id, $status) {
        $sql = <<<SQL
SELECT
    e.*
FROM
    entry AS e
WHERE
    e.user_id = :user_id
AND e.business_id = :business_id
AND e.status IN :status
SQL;

        $params = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
            'status'      => $status,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 登録する
     *
     * @param array $insert_params
     * @return number
     */
    public function insert($insert_params) {

        $query = <<<SQL
        INSERT INTO
            entry
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
     * レコードを更新する
     *
     * @param  array  $update_columns
     * @param  array  $where_columns
     * @return number レコード数
     */
    public function update($update_columns, $where_columns) {
        $query = DB::update(self::$_table_name);
        foreach ($update_columns as $key=>$val) {
            $query->value($key, $val);
        }
        foreach ($where_columns as $key2=>$val2) {
            $query->where($key2, $val2);
        }

        return $query->execute();
    }

    /**
     * affiliate_order_numberを登録する
     *
     * @param $entry_id
     * @param $user_id
     * @param $business_id
     * @param $affiliate_code
     * @return number
     */
    public function insert_affiliate_order_number($entry_id, $user_id, $business_id, $affiliate_code) {
        // update
        $query = <<<SQL
UPDATE
    entry
SET
  affiliate_order_number = :affiliate_order_number
WHERE
    entry_id = :entry_id
AND business_id = :business_id
AND user_id = :user_id
SQL;
        $params = [
            'business_id' => $business_id,
            'entry_id'    => $entry_id,
            'user_id'     => $user_id,
            'affiliate_order_number' => $affiliate_code,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * ステータスを更新する
     *
     * @param int $business_id 事業者ID
     * @param int $entry_id    申込ID
     * @param int $status      変更後ステータス
     * @return int 更新件数
     */
    public function update_status($business_id, $entry_id, $status, $update_datetime, $update_user) {

        // update
        $query = <<<SQL
UPDATE
    entry
SET
    status = :status
  , update_datetime = :update_datetime
  , update_user = :update_user
WHERE
    entry_id = :entry_id
AND business_id = :business_id
SQL;

        $params = [
            'business_id' => $business_id,
            'entry_id'    => $entry_id,

            'status'          => $status,
            'update_datetime' => $update_datetime,
            'update_user'     => $update_user,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * 流入元を更新する
     *
     * @param int $business_id 事業者ID
     * @param int $entry_id 申込ID
     * @param $inflow_source_name
     * @param $update_datetime
     * @param $update_user
     * @return int 更新件数
     */
    public function update_inflow_source_by_entry_id($business_id, $entry_id, $inflow_source_name, $update_datetime, $update_user) {

        // update
        $query = <<<SQL
UPDATE
    entry
SET
    inflow_source = :inflow_source_name
  , update_datetime = :update_datetime
  , update_user = :update_user
WHERE
    entry_id = :entry_id
AND business_id = :business_id
SQL;

        $params = [
            'business_id' => $business_id,
            'entry_id'    => $entry_id,
            'inflow_source_name'          => $inflow_source_name,
            'update_datetime' => $update_datetime,
            'update_user' => $update_user,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * 前の流入元を保存する
     *
     * @param int $business_id 事業者ID
     * @param int $entry_id 申込ID
     * @param $inflow_source_name
     * @param $update_datetime
     * @param $update_user
     * @return int 更新件数
     */
    public function update_origin_inflow_source($business_id, $entry_id, $update_datetime, $update_user) {

        // update
        $query = <<<SQL
UPDATE
    entry
SET
    origin_inflow_source = inflow_source
  , update_datetime = :update_datetime
  , update_user = :update_user
WHERE
    entry_id = :entry_id
AND business_id = :business_id
SQL;

        $params = [
            'business_id' => $business_id,
            'entry_id'    => $entry_id,
            'update_datetime' => $update_datetime,
            'update_user' => $update_user,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * 最終流入元を保存する
     *
     * @param int    $business_id 事業者ID
     * @param int    $entry_id 申込ID
     * @param string $inflow_source_name 流入元名
     * @return int 更新件数
     */
    public function update_last_inflow_source($business_id, $entry_id, $inflow_source_name) {

        // update
        $query = <<<SQL
UPDATE
    entry
SET
    last_inflow_source = :inflow_source
WHERE
    entry_id = :entry_id
AND business_id = :business_id
SQL;

        $params = [
            'business_id'   => $business_id,
            'entry_id'      => $entry_id,
            'inflow_source' => $inflow_source_name,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    public function cancel_draft_entry_by_entry_id($business_id, $entry_id) {
        $query = <<<SQL
UPDATE
    entry e
SET
    e.status = :status
  , e.update_datetime = :update_datetime
  , e.update_user = :update_user
WHERE
    e.entry_id = :entry_id
AND e.business_id = :business_id
AND e.status = :draft_status
SQL;

        $params = [
            'business_id' => $business_id,
            'entry_id'    => $entry_id,
            'status'          => ENTRY_STATUS_LIST['draft_cancel'],
            'draft_status'    => ENTRY_STATUS_LIST['draft'],
            'update_datetime' => Helper_Time::getCurrentDateTime(),
            'update_user'     => SYSTEM_USER_NAME,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    public function get_draft_entry_id_user_id_with_same_email($business_id, $email, $entry_id) {
        $sql = <<<SQL
SELECT
    e.entry_id, e.user_id
FROM entry e
LEFT JOIN user u
ON e.user_id = u.user_id AND e.business_id = u.business_id
WHERE
    e.entry_id <> :entry_id
AND u.email = :email
AND e.business_id = :business_id
AND e.status = :draft_status
SQL;

        $params = [
            'business_id' => $business_id,
            'entry_id'    => $entry_id,
            'email'       => $email,
            'status'          => ENTRY_STATUS_LIST['draft_cancel'],
            'draft_status'    => ENTRY_STATUS_LIST['draft'],
            'update_datetime' => Helper_Time::getCurrentDateTime(),
            'update_user'     => SYSTEM_USER_NAME,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    public function cancel_draft_entry_with_same_email($business_id, $email, $entry_id) {
        $query = <<<SQL
UPDATE
    entry e
    LEFT JOIN user u
    ON e.user_id = u.user_id AND e.business_id = u.business_id
SET
    e.status = :status
  , e.update_datetime = :update_datetime
  , e.update_user = :update_user
WHERE
    e.entry_id <> :entry_id
AND u.email = :email
AND e.business_id = :business_id
AND u.business_id = :business_id
AND e.status = :draft_status
SQL;

        $params = [
            'business_id' => $business_id,
            'entry_id'    => $entry_id,
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

    /**
     * 法人の申し込みの台数を取得する
     *
     * @param int $user_id 顧客ID
     * @param int $business_id 事業者ID
     * @return [entry_id, entry_quantity]
     */
    public function get_entry_quantity_by_user_id($user_id, $business_id) {

        // select
        $sql = <<<SQL
SELECT entry.entry_id,
    entry.status,
    entry.create_datetime,
    entry_company.entry_company_id,
    entry_company.quantity,
    mst_plan.name as plan_name,
    mst_plan.price as mst_plan_price,
    FORMAT(mst_plan.price, 0) as mst_plan_price_string,
     entry_company.device_warranty
FROM human_life.entry
join entry_company
ON entry.entry_id = entry_company.entry_id
join mst_plan
on entry_company.plan_id = mst_plan.plan_id
where entry.user_id = :user_id
    AND entry.business_id = :business_id
    AND entry_company.delete_flag = 0
SQL;

        $params = [
            'business_id' => $business_id,
            'user_id'     => $user_id,
            'delete_flag' => FLG_OFF,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 申し込み情報を更新する
     *
     * @param int   $user_id
     * @param int   $business_id
     * @param array $update_params
     */
    public function update_entry_info($entry_id, $business_id, $update_params) {
        // 更新SQLのSET句を取得する
        $set_phrase = $this->get_set_phrase($update_params);

        $sql = <<<SQL
UPDATE
    entry
SET
    $set_phrase
WHERE
    entry_id = :entry_id
AND
    business_id = :business_id
AND
    status = :draft_entry_status
SQL;

        $params = [
            'entry_id'     => $entry_id,
            'business_id' => $business_id,
            'draft_entry_status' => ENTRY_STATUS_VALUE_LIST['DRAFT'],
        ];

        $params = array_merge($params, $update_params);
        parent::pre_find($query);
        DB::query($sql)->parameters($params)->execute();
    }

    /**
     * entry_idを元にentryテーブルの情報を取得する
     *
     * @param int   $entry_id
     * @param int   $business_id
     * @return array
     */
    public function get_entry_by_entry_id($entry_id, $business_id) {

        // select
        $sql = <<<SQL
SELECT *
FROM human_life.entry
    WHERE entry.business_id = :business_id
    AND entry.entry_id = :entry_id
SQL;

        $params = [
            'business_id' => $business_id,
            'entry_id'    => $entry_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * entry_idを元にentryテーブルの情報を取得する
     *
     * @param int   $entry_id
     * @param int   $business_id
     * @return array
     */
    public function get_entry_with_gclid_by_entry_id($entry_id, $business_id) {

        // select
        $sql = <<<SQL
SELECT e.entry_id, e.affiliate_order_number as order_number, eisd.gclid as gclid
FROM entry as e
INNER JOIN
    entry_inflow_source_detail eisd ON
        e.entry_id = eisd.entry_id
AND e.business_id = eisd.business_id
    WHERE e.business_id = :business_id
    AND e.entry_id = :entry_id
    AND eisd.gclid is not null
SQL;

        $params = [
            'business_id' => $business_id,
            'entry_id'    => $entry_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 申し込みの時に決済ボタンを押すイベントを登録
     * @param  array
     * @return int
     */
    public function update_entry_payment_action_details($param) {
        $query = <<<SQL
UPDATE
    entry e
SET
    e.last_payment_settlement_type = :last_payment_settlement_type
  , e.latest_payment_click_datetime = :latest_payment_click_datetime
  , e.update_datetime = :update_datetime
  , e.update_user = :update_user
WHERE
    e.entry_id = :entry_id
AND e.business_id = :business_id
SQL;

        $params = [
            'business_id' => $param['business_id'],
            'entry_id'    => $param['entry_id'],
            'last_payment_settlement_type' => $param['settlement_type'],
            'latest_payment_click_datetime' => Helper_Time::getCurrentDateTime(),
            'update_datetime' => Helper_Time::getCurrentDateTime(),
            'update_user'     => SYSTEM_USER_NAME,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    public function get_all_entry_detail_by_order_key($order_key, $business_id) {
        // select
        $sql = <<<SQL
        SELECT *
        FROM human_life.entry
    WHERE entry.business_id = :business_id
        AND entry.affiliate_order_number = :order_key
SQL;
        $params = [
            'business_id' => $business_id,
            'order_key'     => $order_key,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * User_idとOrder Noから仮申込情報を取得する
     *
     * @param int $user_id
     * @param string $entry_hash 仮申込メールに記載のhash key
     * @return array
     */
    public function get_draft_entry_by_order_info($user_id, $entry_hash) {
        // select
        $sql = <<<SQL
        SELECT *
        FROM human_life.entry
    WHERE entry.business_id = :business_id
        AND entry.user_id = :user_id
        AND entry.affiliate_order_number = :entry_hash
        AND entry.status = :status
SQL;
        $params = [
            'business_id' => BUSINESS_ID,
            'user_id'     => $user_id,
            'entry_hash'  => $entry_hash,
            'status'      => ENTRY_STATUS_LIST['draft'],
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->current();
        return parent::post_find($result);
    }

    /**
     * User_idから仮申込情報を取得する
     *
     * @param int $user_id
     * @return array
     */
    public function get_draft_entry_by_user_id($user_id) {
        // select
        $sql = <<<SQL
        SELECT *
        FROM entry AS e
        INNER JOIN user AS u ON e.user_id = u.user_id
    WHERE e.business_id = :business_id
        AND e.user_id = :user_id
        AND e.status = :status
SQL;
        $params = [
            'business_id' => BUSINESS_ID,
            'user_id'     => $user_id,
            'status'      => ENTRY_STATUS_LIST['draft'],
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->current();
        return parent::post_find($result);
    }


    public function get_entry_by_order_key($order_key, $business_id) {
        // select
        $sql = <<<SQL
SELECT
e.entry_id as entry_id
, e.user_id
, e.open_house_id
, e.zipcode1 as zipcode_1
, e.zipcode2 as zipcode_2
, e.prefecture
, e.city
, e.town
, e.block
, e.building
, e.tel1_1
, e.tel1_2
, e.tel1_3
, e.delivery_order_time
, e.mst_change_rule_id
, e.affiliate_order_number
, ep.plan_id as plan_id
, eo.option_id as option_id
, ec.campaign_id as campaign_id
, ed.device_id
, mp.name as plan_name
, mp.price as plan_price
, mc.name as campaign_name
, mc.discount_amount as discount_amount
, mc.campaign_introduction as campaign_introduction
, mc.confirm_display_name as confirm_display_name
, mo.price as option_price
, md.name as device_name
, ey.delivery_company_cd
, ey.service_type
, ey.delivery_type
FROM human_life.entry e
    LEFT JOIN human_life.entry_plan ep
        ON e.entry_id = ep.entry_id
        AND e.business_id = ep.business_id
    LEFT JOIN human_life.entry_campaign ec
        ON e.entry_id = ec.entry_id
    LEFT JOIN human_life.mst_plan mp
        ON ep.plan_id = mp.plan_id
        AND ep.business_id = mp.business_id
    LEFT JOIN human_life.mst_campaign mc
        ON ec.campaign_id = mc.campaign_id
    LEFT JOIN human_life.entry_option eo
        ON e.entry_id = eo.entry_id
        AND e.business_id = eo.business_id
    LEFT JOIN human_life.mst_option mo
        ON eo.option_id = mo.option_id
        AND eo.business_id = mo.business_id
    LEFT JOIN human_life.entry_device ed
        ON e.entry_id = ed.entry_id
        AND e.business_id = ed.business_id
    LEFT JOIN human_life.mst_device md
        ON ed.device_id = md.device_id
        AND ed.business_id = md.business_id
    LEFT JOIN human_life.entry_yamato_delivery_info ey
        ON e.entry_id = ey.entry_id
        AND e.business_id = ey.business_id
    WHERE e.business_id = :business_id
    AND e.affiliate_order_number = :order_key

SQL;

        $params = [
            'business_id' => $business_id,
            'order_key'     => $order_key,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * order_key又はentry_idをキーにプリペイドプランの申込情報を取得する
     * @param string $order_key
     * @param int $business_id
     * @param int $entry_id
     * @return array
     */
    public function get_entry_by_order_key_prepaid($order_key, $business_id, $entry_id) {
        // select
        $sql = <<<SQL
SELECT
e.entry_id as entry_id
, e.user_id
, e.status
, e.zipcode1 as zipcode_1
, e.zipcode2 as zipcode_2
, e.prefecture
, e.city
, e.town
, e.block
, e.building
, e.tel1_1
, e.tel1_2
, e.tel1_3
, e.delivery_order_time
, ep.entry_plan_id
, ep.plan_id
, eo.entry_option_id
, eo.option_id
, ed.entry_device_id
, ed.device_id
, ed.is_new
, ed.imei
, u.birthday
, u.last_name
, u.first_name
, u.last_name_kana
, u.first_name_kana
, u.email
FROM human_life.entry e
    LEFT JOIN human_life.entry_plan ep
        ON e.entry_id = ep.entry_id
        AND e.business_id = ep.business_id
    LEFT JOIN human_life.entry_option eo
        ON e.entry_id = eo.entry_id
        AND e.business_id = eo.business_id
    LEFT JOIN human_life.entry_device ed
        ON e.entry_id = ed.entry_id
        AND e.business_id = ed.business_id
    LEFT JOIN human_life.user u
        ON e.user_id = u.user_id
        AND e.business_id = u.business_id
    WHERE e.business_id = :business_id

SQL;

        $params = [];
        $params['business_id'] = $business_id;

        if (is_null($entry_id)) {
            $sql .= 'AND e.affiliate_order_number = :order_key' . LIFE_FEED;
            $params['order_key'] = $order_key;
        } else {
            $sql .= 'AND e.entry_id = :entry_id' . LIFE_FEED;
            $params['entry_id'] = $entry_id;
        }

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 仮申込からの再開用のデータを取得（法人用）
     * 
     * @param string $order_key URLパラメータ
     * @return array 申込情報の1次元配列
     */
    public function get_corp_entry_by_order_key($order_key) {
        $sql = <<<SQL
SELECT
    e.entry_id
    , e.user_id
    , u.email AS corp_email
    , u.last_name AS responsible_last_name
    , u.last_name_kana AS responsible_last_name_kana
    , u.first_name AS responsible_first_name
    , u.first_name_kana AS responsible_first_name_kana
    , c.name AS corp_company_name
    , c.name_kana AS corp_company_name_kana
    , c.zipcode1 AS add_corp_zipcode1
    , c.zipcode2 AS add_corp_zipcode2
    , c.prefecture AS add_corp_prefecture
    , c.city AS add_corp_city
    , c.town AS add_corp_town
    , c.block AS add_corp_block
    , c.building AS add_corp_building
    , c.tel1_1 AS corp_tel1_1
    , c.tel1_2 AS corp_tel1_2
    , c.tel1_3 AS corp_tel1_3
    , c.tel2_1 AS corp_tel2_1
    , c.tel2_2 AS corp_tel2_2
    , c.tel2_3 AS corp_tel2_3
    , c.representative_last_name AS corp_last_name
    , c.representative_last_name_kana AS corp_last_name_kana
    , c.representative_first_name AS corp_first_name
    , c.representative_first_name_kana AS corp_first_name_kana
    , c.hp_url AS company_hp_url
    , uc.last_name AS invoice_last_name
    , uc.last_name_kana AS invoice_last_name_kana
    , uc.first_name AS invoice_first_name
    , uc.first_name_kana AS invoice_first_name_kana
    , uc.email AS invoice_email
    , uc.tel1_1 AS invoice_tel1_1
    , uc.tel1_2 AS invoice_tel1_2
    , uc.tel1_3 AS invoice_tel1_3
    , uc.company_name AS invoice_company_name
    , uc.company_name_kana AS invoice_company_name_kana
    , uc.department_name AS invoice_department_name
    , d.zipcode1 AS deliverycorp_zipcode_1
    , d.zipcode2 AS deliverycorp_zipcode_2
    , d.prefecture AS deliverycorp_prefecture
    , d.city AS deliverycorp_city
    , d.town AS deliverycorp_town
    , d.block AS deliverycorp_block
    , d.building AS deliverycorp_building
    , d.last_name AS deliverycorp_last_name
    , d.last_name_kana AS deliverycorp_last_name_kana
    , d.first_name AS deliverycorp_first_name
    , d.first_name_kana AS deliverycorp_first_name_kana
    , d.tel1_1 AS deliverycorp_tel1_1
    , d.tel1_2 AS deliverycorp_tel1_2
    , d.tel1_3 AS deliverycorp_tel1_3
    , d.tel2_1 AS deliverycorp_tel2_1
    , d.tel2_2 AS deliverycorp_tel2_2
    , d.tel2_3 AS deliverycorp_tel2_3
    , d.delivery_order_time AS deliverycorp_order_time
FROM
    entry e 
    INNER JOIN user u 
        ON e.user_id = u.user_id 
    INNER JOIN company c 
        ON u.company_id = c.company_id 
    INNER JOIN user_contact_info uc 
        ON u.user_id = uc.user_id 
        AND uc.contact_type = :contractor 
    INNER JOIN delivery d 
        ON u.user_id = d.user_id 
WHERE
    e.affiliate_order_number = :order_key
SQL;

        $params = [
            'order_key' => $order_key,
            'contractor' => USER_CONTACT_TYPE_CONTRACT, // 法人契約者・請求先
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->current();   // 該当行は1件のみという前提
        return parent::post_find($result);
    }

    /**
     * user_idをキーにmst_planを取得する
     * @param array $user_id
     * @return array|null レコードが取得できない場合null
     */
    public function get_mst_plan_by_user_id($user_id, $select = ['*']){
        $query = DB::select_array($select)->from(self::$_table_name)
                                          ->join('entry_plan', 'inner')
                                          ->on(self::$_table_name.'.entry_id', '=', 'entry_plan.entry_id')
                                          ->join('mst_plan', 'inner')
                                          ->on('entry_plan.plan_id', '=', 'mst_plan.plan_id')
                                          ->where('user_id', $user_id);
        return $query->execute()->current();

    }

    /**
     * user_idをキーにmst_optionを取得する
     * @param array $user_id
     * @return array|null レコードが取得できない場合null
     */
    public function get_mst_option_by_user_id($user_id, $select = ['*']){
        $query = DB::select_array($select)->from(self::$_table_name)
                                          ->join('entry_option', 'inner')
                                          ->on(self::$_table_name.'.entry_id', '=', 'entry_option.entry_id')
                                          ->join('mst_option', 'inner')
                                          ->on('entry_option.option_id', '=', 'mst_option.option_id')
                                          ->where('user_id', $user_id);
        return $query->execute()->as_array();

    }

    /**
     * ユーザIDを条件に申し込みプランを取得する - 個人用
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function entry_domestic_plan_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    e.entry_id
  , emp.plan_id
FROM
    entry AS e
        INNER JOIN
            entry_plan AS ep
        ON  ep.entry_id = e.entry_id
        AND ep.business_id = e.business_id
        INNER JOIN
            mst_plan AS emp
        ON  emp.plan_id = ep.plan_id
        AND emp.business_id = ep.business_id
        AND emp.plan_type = :domestic_plan_type
WHERE
    e.user_id = :user_id
AND e.business_id = :business_id
AND e.status != :status
SQL;

        $params = [
            'user_id'                      => $user_id,
            'business_id'                  => $business_id,
            'status'                       => ENTRY_STATUS_VALUE_LIST['REJECTION'],
            'domestic_plan_type'           => PLAN_TYPE_LIST['DOMESTIC'],
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザIDを条件に申し込みプランを取得する - 個人用(plan_type指定なし)
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function entry_plan_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    e.entry_id
  , emp.plan_id
FROM
    entry AS e
        INNER JOIN
            entry_plan AS ep
        ON  ep.entry_id = e.entry_id
        AND ep.business_id = e.business_id
        INNER JOIN
            mst_plan AS emp
        ON  emp.plan_id = ep.plan_id
        AND emp.business_id = ep.business_id
WHERE
    e.user_id = :user_id
AND e.business_id = :business_id
AND e.status != :status
SQL;

        $params = [
            'user_id'                      => $user_id,
            'business_id'                  => $business_id,
            'status'                       => ENTRY_STATUS_VALUE_LIST['REJECTION'],
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
     * user_idを元にentryのstatusを取得する
     * @param  int $business_id
     * @param  int $user_id
     * @return array
     */
    public function get_entry_status_and_sent_mail_datetime_by_user_id($business_id, $user_id) {
        $query = <<<SQL
        SELECT
            status,
            plan_guidance_mail_sent_datetime
        FROM
            entry
        WHERE
            user_id = :user_id AND
            business_id = :business_id
SQL;

        $bind_params['user_id']     = $user_id;
        $bind_params['business_id'] = $business_id;
        return DB::query($query)->parameters($bind_params)->execute()->current();
    }

    /**
     * 申込IDから申込情報とユーザー情報を取得する
     *
     * @param int $business_id 事業者ID
     * @param int $entry_id    申込ID
     * @param int $user_type   ユーザー種別
     * @return 取得結果
     */
    public function get_entry_user_by_entry_id($business_id, $entry_id, $user_type = null) {
        $query = <<<SQL
        SELECT
            e.business_id
            , e.entry_id
            , e.user_id
            , e.status
            , e.inflow_source
            , e.affiliate_order_number
            , e.zipcode1 AS delivery_zipcode1
            , e.zipcode2 AS delivery_zipcode2
            , e.prefecture AS delivery_prefecture
            , e.city AS delivery_city
            , e.town AS delivery_town
            , e.block AS delivery_block
            , e.building AS delivery_building
            , e.last_name AS delivery_last_name
            , e.last_name_kana AS delivery_last_name_kana
            , e.first_name AS delivery_first_name
            , e.first_name_kana AS delivery_first_name_kana
            , e.tel1_1 AS delivery_tel1_1
            , e.tel1_2 AS delivery_tel1_2
            , e.tel1_3 AS delivery_tel1_3
            , e.tel2_1 AS delivery_tel2_1
            , e.tel2_2 AS delivery_tel2_2
            , e.tel2_3 AS delivery_tel2_3
            , e.delivery_order_time
            , e.payment_register_mail_sent_datetime
            , e.create_datetime
            , e.create_user
            , e.update_datetime
            , e.update_user
            , e.entry_count
            , u.user_type
            , u.password
            , u.salt
            , u.email
            , u.birthday
            , u.last_name
            , u.last_name_kana
            , u.first_name
            , u.first_name_kana
            , u.status AS user_status
            , u.sex
            , u.join_datetime
            , u.withdraw_datetime
            , u.company_id
            , u.create_datetime
            , u.create_user
            , u.update_datetime
            , u.update_user
            , uci.contact_type
            , uci.zipcode1 AS user_contact_info_zipcode1
            , uci.zipcode2 AS user_contact_info_zipcode2
            , uci.prefecture AS user_contact_info_prefecture
            , uci.city AS user_contact_info_city
            , uci.town AS user_contact_info_town
            , uci.block AS user_contact_info_block
            , uci.building AS user_contact_info_building
            , uci.last_name AS user_contact_info_last_name
            , uci.last_name_kana AS user_contact_info_last_name_kana
            , uci.first_name AS user_contact_info_first_name
            , uci.first_name_kana AS user_contact_info_first_name_kana
            , uci.tel1_1 AS user_contact_info_tel1_1
            , uci.tel1_2 AS user_contact_info_tel1_2
            , uci.tel1_3 AS user_contact_info_tel1_3
            , uci.tel2_1 AS user_contact_info_tel2_1
            , uci.tel2_2 AS user_contact_info_tel2_2
            , uci.tel2_3 AS user_contact_info_tel2_3
            , uci.create_datetime AS user_contact_info_create_datetime
            , uci.create_user AS user_contact_info_create_user
            , uci.update_datetime AS user_contact_info_update_datetime
            , uci.update_user AS user_contact_info_update_user
            , si.settlement_type
            , si.gmo_member_id
            , i.delivery_note_no
            , i.delivery_datetime
            , i.inquiry_no
            , ep.plan_id
        FROM
            entry AS e
        LEFT JOIN entry_plan AS ep
            ON e.entry_id = ep.entry_id
            AND e.business_id = ep.business_id
        INNER JOIN user AS u
            ON e.user_id = u.user_id
            AND e.business_id = u.business_id
        INNER JOIN user_contact_info AS uci
            ON u.user_id = uci.user_id
            AND u.business_id = uci.business_id
        LEFT JOIN settlement_info AS si
            ON u.user_id = si.user_id
            AND u.business_id = si.business_id
        LEFT JOIN contract AS c
            ON e.entry_id = c.entry_id
            AND e.business_id = c.business_id
            AND u.user_id = c.user_id
        LEFT JOIN imei AS i
            ON c.contract_id = i.contract_id
        WHERE
            e.business_id = :business_id
            AND e.entry_id = :entry_id

        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['entry_id'] = $entry_id;

        if (!is_null($user_type)) {
            $query .= 'AND u.user_type = :user_type' . LIFE_FEED;
            $bind_params['user_type'] = $user_type;
        }

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 顧客IDから申し込み情報を取得する
     *
     * @param int $user_id
     *
     * @return array
     */
    public function get_entry_info_by_user_id($user_id)
    {
        $query = DB::select()
        ->from(self::$_table_name)
        ->where('business_id', BUSINESS_ID)
        ->where('user_id', $user_id);

        return $query->execute()->as_array();
    }

    /**
     * atoneの決済に必要な値を取得する
     *
     * @param int $user_id
     * @return array atone決済に必要な情報
     */
    public function get_entry_info_atone_commission($user_id) {

        $query = <<<SQL
SELECT
    c.prefecture
    , c.zipcode1
    , c.zipcode2
    , c.prefecture
    , c.city
    , c.town
    , c.block
    , c.building
    , c.last_name
    , c.first_name
    , c.last_name_kana
    , c.first_name_kana
    , u.email
    , c.tel1_1
    , c.tel1_2
    , c.tel1_3
    , u.birthday
    , u.user_id
    , u.sex
    , s.first_transaction_id
    , s.np_token
FROM
    entry e
    INNER JOIN user_contact_info c
        ON e.user_id = c.user_id
        AND c.contact_type = :contact_type
    INNER JOIN user u
        ON e.business_id = u.business_id
        AND e.user_id = u.user_id
    INNER JOIN settlement_info s
        ON s.business_id = u.business_id
        AND s.user_id = u.user_id
WHERE
    e.user_id = :user_id
    AND e.status NOT IN :status
SQL;

        $param = [
            'user_id'      => $user_id,
            'contact_type' => SYSTEM_USER_NAME,
            'status'       => ENTRY_STATUS_EXCLUDE_LIST,
        ];

        return DB::query($query)->parameters($param)->execute()->current();
    }

    /*
     * 申し込みIDから利用明細情報を取得する
     *
     * @param int $entry_id
     * @param array $select 選択カラム
     * @return array 検索結果
     */
    public function get_entry_info_by_entry_id($entry_id, $select=['*'])
    {

        $query = DB::select_array($select)
        ->from(self::$_table_name . ' AS e')
        ->join(['user', 'u'])
        ->on('u.user_id', '=', 'e.user_id')
        ->join(['entry_plan', 'ep'])
        ->on('ep.entry_id', '=', 'e.entry_id')
        ->join(['mst_plan', 'mp'])
        ->on('mp.plan_id', '=', 'ep.plan_id')
        ->join(['entry_option', 'eo'], 'left')
        ->on('eo.entry_id', '=', 'e.entry_id')
        ->join(['mst_option', 'mo'], 'left')
        ->on('mo.option_id', '=', 'eo.option_id')
        ->where('e.business_id', BUSINESS_ID)
        ->where('e.entry_id', $entry_id)
        ->order_by('mp.plan_id')
        ->order_by('mo.option_id')
        ;

        return $query->execute()->as_array();
    }

    /**
     * ユーザIDを条件に有効な海外レンタルの申し込み(契約)情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function entry_contract_info_list_by_user_id_for_contract_rental($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    e.entry_id
  , e.user_id
  , e.status AS entry_status
  , e.rental_start_date
  , e.rental_end_date
  , e.delivery_order_date
  , e.delivery_limit_date
  , c.contract_id
  , c.contract_pdf_key
  , emp.plan_id AS entry_plan_id
  , emp.name AS entry_plan_name
  , emcp.continent_name
  , emcp.country_name
  , emp.plan_type AS entry_plan_type
  , emp.price AS entry_plan_price
  , emp.data_usage_limit
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(eo.entry_option_id, ''), IFNULL(emo.option_id, ''), IFNULL(emo.name, ''), IFNULL(emo.option_type, '')
      , IFNULL(emo.price, ''), IFNULL(emo.billing_type, ''), IFNULL(emo.tax_type, '')) ORDER BY emo.disp_order) AS entry_option_info_list_str
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rco.contract_option_id, ''), IFNULL(cmo.option_id, ''), IFNULL(cmo.name, ''), IFNULL(cmo.option_type, ''), IFNULL(cmo.price, '')
      , IFNULL(cmo.billing_type, ''), IFNULL(cmo.tax_type, ''), IFNULL(rco.option_start_date, ''), IFNULL(rco.option_end_date, ''), IFNULL(rco.insurance_account, '')) ORDER BY cmo.disp_order) AS contract_option_info_list_str
  , i.imei
  , i.shipment_date
  , min(eh.create_datetime) as create_datetime
  , ep.market_id
  , ep.version
FROM
    entry AS e
        INNER JOIN
            entry_plan AS ep
        ON  ep.entry_id = e.entry_id
        AND ep.business_id = e.business_id
        INNER JOIN
            entry_history eh
        ON  eh.entry_id = e.entry_id
        AND eh.status IN :eh_status
        LEFT JOIN
            mst_plan AS emp
        ON  emp.plan_id = ep.plan_id
        AND emp.business_id = ep.business_id
        LEFT JOIN
            mst_continent_plan AS emcp
        ON  emcp.plan_id = ep.plan_id
        AND emcp.business_id = ep.business_id
        LEFT JOIN
            entry_option AS eo
        ON  eo.entry_id = e.entry_id
        AND eo.business_id = e.business_id
        LEFT JOIN
            mst_option AS emo
        ON  emo.option_id = eo.option_id
        AND emo.business_id = eo.business_id
        INNER JOIN
            entry_device AS ed
        ON  ed.entry_id = e.entry_id
        AND ed.business_id = e.business_id
        INNER JOIN
            mst_device AS emd
        ON  emd.device_id = ed.device_id
        AND emd.business_id = ed.business_id
        LEFT JOIN
            contract AS c
        ON  c.user_id = e.user_id
        AND c.business_id = e.business_id
        AND c.entry_id = e.entry_id
        AND c.delete_flag = :delete_flag
        LEFT JOIN
            rel_contract_plan AS rcpd
        ON  rcpd.contract_id = c.contract_id
        AND rcpd.business_id = c.business_id
        AND rcpd.delete_flag = :delete_flag
        LEFT JOIN
            mst_plan AS cmpd
        ON  cmpd.plan_id = rcpd.plan_id
        AND cmpd.business_id = rcpd.business_id
        AND cmpd.plan_type = :international_rental_plan
        LEFT JOIN
            mst_continent_plan AS cmcp
        ON  cmcp.plan_id = rcpd.plan_id
        AND cmcp.business_id = rcpd.business_id
        LEFT JOIN
            rel_contract_option AS rco
        ON  rco.contract_id = c.contract_id
        AND rco.business_id = c.business_id
        AND rco.delete_flag = :delete_flag
        LEFT JOIN
            mst_option AS cmo
        ON  cmo.option_id = rco.option_id
        AND cmo.business_id = rco.business_id
        LEFT JOIN
            rel_contract_device rcd
        ON  rcd.contract_id = c.contract_id
        AND rcd.business_id = c.business_id
        AND rcd.device_id = ed.device_id
        LEFT JOIN
            mst_device AS cmd
        ON  cmd.device_id = rcd.device_id
        AND cmd.business_id = rcd.business_id
        LEFT JOIN
            imei AS i
        ON  i.contract_id = rcd.contract_id
        AND i.rel_contract_device_id = rcd.rel_contract_device_id
        AND i.business_id = rcd.business_id
        AND i.delete_flag = :delete_flag
        LEFT JOIN
            mst_plan_market_price AS mpmp
        ON  emp.plan_id = mpmp.plan_id
        AND emp.business_id = mpmp.business_id
WHERE
    e.user_id = :user_id
AND e.business_id = :business_id
AND e.status NOT IN :status
GROUP BY
    e.entry_id, e.status, e.delivery_order_date, e.create_datetime, c.contract_id
  , emp.plan_id, emp.name, emcp.continent_name, emcp.country_name, emp.plan_type, emp.price, emp.data_usage_limit
  , i.imei, i.shipment_date, ep.market_id, ep.version
ORDER BY
    e.entry_id DESC
SQL;

        $params = [
            'user_id'                        => $user_id,
            'business_id'                    => $business_id,
            'status'                         => [ENTRY_STATUS_CANCEL, ENTRY_STATUS_DRAFT_CANCEL, ENTRY_STATUS_DRAFT],
            'international_rental_plan'      => PLAN_TYPE_LIST['INTERNATIONAL_RENTAL'],
            'delete_flag'                    => FLG_OFF,
            'eh_status'                      => INTERNATIONAL_RENTAL_MYPAGE_ENTRY_STATUS_LIST,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 申込IDを条件に有効な海外レンタルの申し込み(契約)情報を取得する
     *
     * @param int $entry_id
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_entry_info_rental_by_entry_id_user_id($entry_id, $user_id, $business_id) {
        $sql = <<<SQL
SELECT
    e.entry_id
  , e.user_id
  , e.status AS entry_status
  , e.rental_start_date
  , e.rental_end_date
  , e.delivery_order_date
  , e.delivery_limit_date
  , c.contract_id
  , emp.plan_id AS entry_plan_id
  , emp.name AS entry_plan_name
  , emcp.country_name
  , emp.plan_type AS entry_plan_type
  , emp.price AS entry_plan_price
  , emp.data_usage_limit
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(eo.entry_option_id, ''), IFNULL(emo.option_id, ''), IFNULL(emo.name, ''), IFNULL(emo.option_type, '')
      , IFNULL(emo.price, ''), IFNULL(emo.billing_type, ''), IFNULL(emo.tax_type, '')) ORDER BY emo.disp_order) AS entry_option_info_list_str
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rco.contract_option_id, ''), IFNULL(cmo.option_id, ''), IFNULL(cmo.name, ''), IFNULL(cmo.option_type, ''), IFNULL(cmo.price, '')
      , IFNULL(cmo.billing_type, ''), IFNULL(cmo.tax_type, ''), IFNULL(rco.option_start_date, ''), IFNULL(rco.option_end_date, ''), IFNULL(rco.insurance_account, '')) ORDER BY cmo.disp_order) AS contract_option_info_list_str
  , i.imei
  , min(eh.create_datetime) as create_datetime
  , ep.market_id
  , ep.version
  , mpmp.name AS market_name
FROM
    entry AS e
        INNER JOIN
            entry_plan AS ep
        ON  ep.entry_id = e.entry_id
        AND ep.business_id = e.business_id
        INNER JOIN
            entry_history eh
        ON  eh.entry_id = e.entry_id
        AND eh.status = :eh_status
        LEFT JOIN
            mst_plan AS emp
        ON  emp.plan_id = ep.plan_id
        AND emp.business_id = ep.business_id
        LEFT JOIN
            mst_continent_plan AS emcp
        ON  emcp.plan_id = ep.plan_id
        AND emcp.business_id = ep.business_id
        LEFT JOIN
            entry_option AS eo
        ON  eo.entry_id = e.entry_id
        AND eo.business_id = e.business_id
        LEFT JOIN
            mst_option AS emo
        ON  emo.option_id = eo.option_id
        AND emo.business_id = eo.business_id
        INNER JOIN
            entry_device AS ed
        ON  ed.entry_id = e.entry_id
        AND ed.business_id = e.business_id
        INNER JOIN
            mst_device AS emd
        ON  emd.device_id = ed.device_id
        AND emd.business_id = ed.business_id
        LEFT JOIN
            contract AS c
        ON  c.user_id = e.user_id
        AND c.business_id = e.business_id
        AND c.entry_id = e.entry_id
        AND c.delete_flag = :delete_flag
        LEFT JOIN
            rel_contract_option AS rco
        ON  rco.contract_id = c.contract_id
        AND rco.business_id = c.business_id
        AND (rco.option_end_date > NOW() OR rco.option_end_date IS NULL)
        AND rco.delete_flag = :delete_flag
        LEFT JOIN
            mst_option AS cmo
        ON  cmo.option_id = rco.option_id
        AND cmo.business_id = rco.business_id
        LEFT JOIN
            rel_contract_device rcd
        ON  rcd.contract_id = c.contract_id
        AND rcd.business_id = c.business_id
        AND rcd.device_id = ed.device_id
        LEFT JOIN
            mst_device AS cmd
        ON  cmd.device_id = rcd.device_id
        AND cmd.business_id = rcd.business_id
        LEFT JOIN
            imei AS i
        ON  i.contract_id = rcd.contract_id
        AND i.rel_contract_device_id = rcd.rel_contract_device_id
        AND i.business_id = rcd.business_id
        AND i.delete_flag = :delete_flag
        LEFT JOIN
            mst_plan_market_price AS mpmp
        ON  emp.plan_id = mpmp.plan_id
        AND emp.business_id = mpmp.business_id
WHERE
    e.entry_id = :entry_id
AND e.user_id = :user_id
AND e.business_id = :business_id
AND e.status != :status
GROUP BY
    e.entry_id, e.status, e.delivery_order_date, e.create_datetime, c.contract_id
  , emp.plan_id, emp.name, emcp.country_name, emp.plan_type, emp.price, emp.data_usage_limit
  , i.imei, eh.entry_id, ep.market_id, ep.version, mpmp.name
ORDER BY
    e.entry_id ASC
SQL;

        $params = [
            'entry_id'                  => $entry_id,
            'user_id'                   => $user_id,
            'business_id'               => $business_id,
            'status'                    => ENTRY_STATUS_VALUE_LIST['REJECTION'],
            'international_rental_plan' => PLAN_TYPE_LIST['INTERNATIONAL_RENTAL'],
            'delete_flag'               => FLG_OFF,
            'eh_status'                 => ENTRY_STATUS_VALUE_LIST['NEW'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザIDを条件に有効な海外レンタルの申し込み(契約)情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function entry_contract_info_list_by_user_id_for_overseas_rental($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    e.entry_id
  , e.user_id
  , e.status AS entry_status
  , e.rental_start_date
  , e.rental_end_date
  , e.delivery_order_date
  , c.contract_id
  , emp.plan_id AS entry_plan_id
  , emp.name AS entry_plan_name
  , emp.plan_type AS entry_plan_type
  , emp.price AS entry_plan_price
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(eo.entry_option_id, ''), IFNULL(emo.option_id, ''), IFNULL(emo.name, ''), IFNULL(emo.option_type, '')
      , IFNULL(emo.price, ''), IFNULL(emo.billing_type, ''), IFNULL(emo.tax_type, '')) ORDER BY emo.disp_order) AS entry_option_info_list_str
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rcpd.contract_plan_id, ''), IFNULL(cmpd.plan_id, ''), IFNULL(cmpd.name, ''), IFNULL(cmcp.continent_name, ''), IFNULL(cmcp.country_name, ''), IFNULL(cmpd.plan_type, ''), IFNULL(cmpd.price, '')
      , IFNULL(cmpd.billing_type, ''), IFNULL(cmpd.tax_type, ''), IFNULL(rcpd.plan_start_date, ''), IFNULL(rcpd.plan_end_date, ''), IFNULL(cmpd.device_type,'')
      , IFNULL(cmpd.data_usage_limit,'')) ORDER BY rcpd.contract_plan_id) AS contract_plan_info_list_str
  , GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rco.contract_option_id, ''), IFNULL(cmo.option_id, ''), IFNULL(cmo.name, ''), IFNULL(cmo.option_type, ''), IFNULL(cmo.price, '')
      , IFNULL(cmo.billing_type, ''), IFNULL(cmo.tax_type, ''), IFNULL(rco.option_start_date, ''), IFNULL(rco.option_end_date, ''), IFNULL(rco.insurance_account, '')) ORDER BY cmo.disp_order) AS contract_option_info_list_str
  , i.imei
  , min(eh.create_datetime) as create_datetime
  , ep.market_price_id
  , ep.market_id
  , ep.version
FROM
    entry AS e
        INNER JOIN
            entry_plan AS ep
        ON  ep.entry_id = e.entry_id
        AND ep.business_id = e.business_id
        INNER JOIN
            entry_history eh
        ON  eh.entry_id = e.entry_id
        AND eh.status IN :eh_status
        LEFT JOIN
            mst_plan AS emp
        ON  emp.plan_id = ep.plan_id
        AND emp.business_id = ep.business_id
        LEFT JOIN
            entry_option AS eo
        ON  eo.entry_id = e.entry_id
        AND eo.business_id = e.business_id
        LEFT JOIN
            mst_option AS emo
        ON  emo.option_id = eo.option_id
        AND emo.business_id = eo.business_id
        INNER JOIN
            entry_device AS ed
        ON  ed.entry_id = e.entry_id
        AND ed.business_id = e.business_id
        INNER JOIN
            mst_device AS emd
        ON  emd.device_id = ed.device_id
        AND emd.business_id = ed.business_id
        LEFT JOIN
            contract AS c
        ON  c.user_id = e.user_id
        AND c.business_id = e.business_id
        AND c.entry_id = e.entry_id
        AND c.delete_flag = :delete_flag
        LEFT JOIN
            rel_contract_plan AS rcpd
        ON  rcpd.contract_id = c.contract_id
        AND rcpd.business_id = c.business_id
        AND rcpd.delete_flag = :delete_flag
        LEFT JOIN
            mst_plan AS cmpd
        ON  cmpd.plan_id = rcpd.plan_id
        AND cmpd.business_id = rcpd.business_id
        AND cmpd.plan_type = :international_rental_plan
        LEFT JOIN
            mst_continent_plan AS cmcp
        ON  cmcp.plan_id = rcpd.plan_id
        AND cmcp.business_id = rcpd.business_id
        LEFT JOIN
            rel_contract_option AS rco
        ON  rco.contract_id = c.contract_id
        AND rco.business_id = c.business_id
        AND rco.option_end_date IS NOT NULL
        AND rco.delete_flag = :delete_flag
        LEFT JOIN
            mst_option AS cmo
        ON  cmo.option_id = rco.option_id
        AND cmo.business_id = rco.business_id
        LEFT JOIN
            rel_contract_device rcd
        ON  rcd.contract_id = c.contract_id
        AND rcd.business_id = c.business_id
        AND rcd.device_id = ed.device_id
        LEFT JOIN
            mst_device AS cmd
        ON  cmd.device_id = rcd.device_id
        AND cmd.business_id = rcd.business_id
        LEFT JOIN
            imei AS i
        ON  i.contract_id = rcd.contract_id
        AND i.rel_contract_device_id = rcd.rel_contract_device_id
        AND i.business_id = rcd.business_id
        AND i.delete_flag = :delete_flag
WHERE
    e.user_id = :user_id
AND e.business_id = :business_id
AND e.status != :status
GROUP BY
    e.entry_id, e.status, e.delivery_order_date, e.create_datetime, c.contract_id
  , emp.plan_id, emp.name, emp.plan_type, emp.price
  , ep.market_price_id, ep.market_id, ep.version
  , i.imei, eh.entry_id
ORDER BY
    e.entry_id DESC
SQL;

        $params = [
            'user_id'                   => $user_id,
            'business_id'               => $business_id,
            'status'                    => ENTRY_STATUS_VALUE_LIST['REJECTION'],
            'international_rental_plan' => PLAN_TYPE_LIST['INTERNATIONAL_RENTAL'],
            'delete_flag'               => FLG_OFF,
            'eh_status'                 => INTERNATIONAL_RENTAL_MYPAGE_ENTRY_STATUS_LIST,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザIDを条件に有効な海外レンタルの申し込み(契約)情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function entry_contract_plan_info_list_by_user_id_for_rental($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    e.entry_id
  , c.contract_id
  , rcpd.contract_plan_id
  , cmpd.plan_id
  , cmpd.name as plan_name
  , cmcp.continent_name
  , cmcp.country_name
  , cmpd.plan_type
  , cmpd.price
  , cmpd.billing_type
  , cmpd.tax_type
  , rcpd.plan_start_date
  , rcpd.plan_end_date
  , cmpd.device_type
  , cmpd.data_usage_limit
FROM
    entry AS e
        LEFT JOIN
            contract AS c
        ON  c.user_id = e.user_id
        AND c.business_id = e.business_id
        AND c.entry_id = e.entry_id
        AND c.delete_flag = :delete_flag
        LEFT JOIN
            rel_contract_plan AS rcpd
        ON  rcpd.contract_id = c.contract_id
        AND rcpd.business_id = c.business_id
        AND rcpd.delete_flag = :delete_flag
        LEFT JOIN
            mst_plan AS cmpd
        ON  cmpd.plan_id = rcpd.plan_id
        AND cmpd.business_id = rcpd.business_id
        AND cmpd.plan_type = :international_rental_plan
        LEFT JOIN
            mst_continent_plan AS cmcp
        ON  cmcp.plan_id = rcpd.plan_id
        AND cmcp.business_id = rcpd.business_id
WHERE
    e.user_id = :user_id
AND e.business_id = :business_id
AND e.status != :status
GROUP BY
e.entry_id, c.contract_id, rcpd.contract_plan_id
  , cmpd.plan_id, cmpd.name, cmcp.continent_name, cmcp.country_name, cmpd.plan_type
  , cmpd.price, cmpd.billing_type, cmpd.tax_type, rcpd.plan_start_date, rcpd.plan_end_date
  , cmpd.device_type, cmpd.data_usage_limit
ORDER BY
    c.contract_id IS NULL DESC,
    e.entry_id ASC,
    rcpd.contract_plan_id ASC
SQL;

        $params = [
            'user_id'                   => $user_id,
            'business_id'               => $business_id,
            'status'                    => ENTRY_STATUS_VALUE_LIST['REJECTION'],
            'international_rental_plan' => PLAN_TYPE_LIST['INTERNATIONAL_RENTAL'],
            'delete_flag'               => FLG_OFF,
            'eh_status'                 => INTERNATIONAL_RENTAL_MYPAGE_ENTRY_STATUS_LIST,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 申込&契約情報を取得
     *
     * @param int $business_id
     * @param int $user_id
     *
     * @return array 申込&契約情報
     */
    public function get_entry_contract_info_by_user_id($business_id, $user_id) {
        $sql = <<<SQL
SELECT
    e.entry_id
    , e.status
    , e.delivery_receive_place_type
    , c.contract_id
FROM
    entry e
    LEFT JOIN contract c
        ON c.user_id = e.user_id
        AND c.entry_id = e.entry_id
        AND c.business_id = e.business_id
WHERE
    e.user_id = :user_id
    AND e.business_id = :business_id
ORDER BY
    e.entry_id DESC
    , c.contract_id DESC
SQL;

        $params = [
            'user_id' => $user_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザIDを条件に有効な海外レンタルの申し込み(契約)情報を取得する(価格.com対応)
     *
     * @param int $user_id
     * @param int $business_id
     * @param int $market_id
     * @param int $version
     * @return array
     */
    public function entry_contract_plan_info_list_by_user_id_and_market_id_for_rental($user_id, $business_id, $market_id, $version) {
        $sql = <<<SQL
SELECT
    e.entry_id
  , c.contract_id
  , rcpd.contract_plan_id
  , cmpd.plan_id
  , cmpd.name as plan_name
  , cmcp.continent_name
  , cmcp.country_name
  , cmpd.plan_type
  , cmpd.price
  , cmpd.billing_type
  , cmpd.tax_type
  , rcpd.plan_start_date
  , rcpd.plan_end_date
  , cmpd.device_type
  , cmpd.data_usage_limit
  , mpmp.price AS market_price
FROM
    entry AS e
        LEFT JOIN
            contract AS c
        ON  c.user_id = e.user_id
        AND c.business_id = e.business_id
        AND c.entry_id = e.entry_id
        AND c.delete_flag = :delete_flag
        LEFT JOIN
            rel_contract_plan AS rcpd
        ON  rcpd.contract_id = c.contract_id
        AND rcpd.business_id = c.business_id
        AND rcpd.delete_flag = :delete_flag
        LEFT JOIN
            mst_plan AS cmpd
        ON  cmpd.plan_id = rcpd.plan_id
        AND cmpd.business_id = rcpd.business_id
        AND cmpd.plan_type = :international_rental_plan
        LEFT JOIN
            mst_continent_plan AS cmcp
        ON  cmcp.plan_id = rcpd.plan_id
        AND cmcp.business_id = rcpd.business_id
        LEFT JOIN
            mst_plan_market_price AS mpmp
        ON cmpd.plan_id = mpmp.plan_id
WHERE
    e.user_id = :user_id
AND e.business_id = :business_id
AND e.status != :status
AND mpmp.market_id = :market_id
AND mpmp.version = :version
GROUP BY
e.entry_id, c.contract_id, rcpd.contract_plan_id
  , cmpd.plan_id, cmpd.name, cmcp.continent_name, cmcp.country_name, cmpd.plan_type
  , cmpd.price, cmpd.billing_type, cmpd.tax_type, rcpd.plan_start_date, rcpd.plan_end_date
  , cmpd.device_type, cmpd.data_usage_limit, mpmp.price
ORDER BY
    c.contract_id IS NULL DESC,
    e.entry_id ASC,
    rcpd.contract_plan_id ASC
SQL;

        $params = [
            'user_id'                   => $user_id,
            'business_id'               => $business_id,
            'status'                    => ENTRY_STATUS_VALUE_LIST['REJECTION'],
            'international_rental_plan' => PLAN_TYPE_LIST['INTERNATIONAL_RENTAL'],
            'delete_flag'               => FLG_OFF,
            'eh_status'                 => INTERNATIONAL_RENTAL_MYPAGE_ENTRY_STATUS_LIST,
            'market_id'                 => $market_id,
            'version'                   => $version,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 複数条件を指定して簡単なSELECTを行う
     * @param array $select 取得カラム
     * @param array $wheres 検索条件[0 => [{カラム名} => {値}], 1 => ...]
     * @return array 抽出結果
     */
    public function get_record($select, $wheres) {
        if (empty($wheres)) return [];
        $query = DB::select_array($select)->from(self::$_table_name);
        foreach ($wheres as $key => $value) {
            $query->where($key, $value);
        }
        return $query->execute()->as_array();
    }

    /**
     * user_idを元にaffiliate_order_numberを取得する
     *
     * @param  int $user_id
     * @param  int $business_id
     * @return array
     */
    public function get_affiliate_order_number_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT affiliate_order_number
FROM entry
WHERE user_id = :user_id AND
      business_id = :business_id
SQL;

        $params = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
        ];
        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->current();
        return parent::post_find($result);
    }
}
