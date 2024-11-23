<?php

/**
 * 契約情報テーブルのモデルクラス
 */
class Model_HumanLife_Contract extends Model_CrudAbstract {

    /**
     * テーブル名
     *
     * @var string 契約テーブル名
     */
    protected static $_table_name = 'contract';

    /**
     * 契約情報を取得する
     *
     * @param $contract_id
     * @param $business_id
     * @return array
     */
    public function get_contract_info($contract_id, $business_id) {
        $sql = <<<SQL
SELECT
    c.contract_id,
    e.status AS entry_status,
    e.entry_id,
    GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rcp.contract_plan_id, ''), IFNULL(rcp.order_sn, ''), IFNULL(rcp.order_id, ''), IFNULL(rcp.plan_end_date, ''), IFNULL(mp.plan_id, ''), IFNULL(mp.name, '')
        , IFNULL(mp.plan_type, ''), IFNULL(mp.price, ''), IFNULL(mp.tax_type, ''), IFNULL(mp.billing_type, ''), IFNULL(mp.sale_end_date, '')) ORDER BY mp.disp_order) AS plan_info_list_str,
    GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rco.contract_option_id, ''), IFNULL(rco.option_end_date, ''), IFNULL(mo.option_id, ''), IFNULL(mo.name, ''), IFNULL(mo.option_type, '')
        , IFNULL(mo.price, ''), IFNULL(mo.tax_type, ''), IFNULL(mo.billing_type, ''), IFNULL(mo.sale_end_datetime, '')) ORDER BY mo.disp_order) AS option_info_list_str,
    GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rpd.rel_contract_device_id, ''), IFNULL(rpd.device_plan_end_date, ''), IFNULL(md.device_id, ''), IFNULL(md.name, ''), IFNULL(md.device_type, '')
        , IFNULL(md.charge, ''), IFNULL(md.division_month, ''), IFNULL(md.tax_type, ''), IFNULL(md.billing_type, ''), IFNULL(md.sale_end_date, ''), IFNULL(md.color, '')) ORDER BY md.disp_order) AS device_info_list_str
FROM
    contract AS c
INNER JOIN
    entry AS e
    ON  e.entry_id = c.entry_id
    AND e.status != :status
LEFT JOIN
    rel_contract_device AS rpd
    ON  rpd.contract_id = c.contract_id
    AND rpd.business_id = c.business_id
    AND rpd.delete_flag = :delete_flag
LEFT JOIN
    mst_device AS md
    ON  md.device_id = rpd.device_id
    AND md.business_id = c.business_id
LEFT JOIN
    rel_contract_plan AS rcp
    ON  rcp.contract_id = c.contract_id
    AND rcp.business_id = c.business_id
    AND rcp.plan_end_date IS NULL
    AND rcp.delete_flag = :delete_flag
LEFT JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = c.business_id
    AND mp.plan_type = :domestic_plan_type
LEFT JOIN
    rel_contract_option rco
    ON  rco.contract_id = c.contract_id
    AND rco.business_id = c.business_id
    AND rco.option_end_date IS NULL
    AND rcp.delete_flag = :delete_flag
LEFT JOIN
    mst_option AS mo
    ON  mo.option_id = rco.option_id
    AND mo.business_id = c.business_id
WHERE
    c.contract_id = :contract_id
AND c.business_id = :business_id
AND c.delete_flag = :delete_flag
GROUP BY
    c.contract_id, e.status
SQL;

        $param = [
            'contract_id'                  => $contract_id,
            'business_id'                  => $business_id,
            'status'                       => ENTRY_STATUS_LIST['rejection'],
            'domestic_plan_type'           => PLAN_TYPE_LIST['DOMESTIC'],
            'international_plan_type_list' => INTERNATIONAL_PLAN_TYPE_LIST,
            'delete_flag'                  => FLG_OFF,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 銀行振り込みの契約情報を取得する
     *
     * @param $contract_id
     * @param $business_id
     * @return array
     */
    public function get_bank_transfer_contract_info($contract_id, $business_id) {
        $sql = <<<SQL
SELECT
    c.contract_id,
    e.status AS entry_status,
    e.entry_id,
    GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rcp.contract_plan_id, ''), IFNULL(rcp.order_sn, ''), IFNULL(rcp.order_id, ''), IFNULL(rcp.plan_end_date, ''), IFNULL(mp.plan_id, ''), IFNULL(mp.name, '')
        , IFNULL(mp.plan_type, ''), IFNULL(mp.price, ''), IFNULL(mp.tax_type, ''), IFNULL(mp.billing_type, ''), IFNULL(mp.sale_end_date, '')) ORDER BY mp.disp_order) AS plan_info_list_str,
    GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rco.contract_option_id, ''), IFNULL(rco.option_end_date, ''), IFNULL(mo.option_id, ''), IFNULL(mo.name, ''), IFNULL(mo.option_type, '')
        , IFNULL(mo.price, ''), IFNULL(mo.tax_type, ''), IFNULL(mo.billing_type, ''), IFNULL(mo.sale_end_datetime, '')) ORDER BY mo.disp_order) AS option_info_list_str,
    GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rpd.rel_contract_device_id, ''), IFNULL(rpd.device_plan_end_date, ''), IFNULL(md.device_id, ''), IFNULL(md.name, ''), IFNULL(md.device_type, '')
        , IFNULL(md.charge, ''), IFNULL(md.division_month, ''), IFNULL(md.tax_type, ''), IFNULL(md.billing_type, ''), IFNULL(md.sale_end_date, ''), IFNULL(md.color, '')) ORDER BY md.disp_order) AS device_info_list_str
FROM
    contract AS c
INNER JOIN
    entry AS e
    ON  e.entry_id = c.entry_id
    AND e.status != :status
LEFT JOIN
    rel_contract_device AS rpd
    ON  rpd.contract_id = c.contract_id
    AND rpd.business_id = c.business_id
    AND rpd.delete_flag = :delete_flag
LEFT JOIN
    mst_device AS md
    ON  md.device_id = rpd.device_id
    AND md.business_id = c.business_id
LEFT JOIN
    rel_contract_plan AS rcp
    ON  rcp.contract_id = c.contract_id
    AND rcp.business_id = c.business_id
    AND rcp.delete_flag = :delete_flag
LEFT JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = c.business_id
    AND mp.plan_type = :domestic_plan_type
LEFT JOIN
    rel_contract_option rco
    ON  rco.contract_id = c.contract_id
    AND rco.business_id = c.business_id
    AND rcp.delete_flag = :delete_flag
LEFT JOIN
    mst_option AS mo
    ON  mo.option_id = rco.option_id
    AND mo.business_id = c.business_id
WHERE
    c.contract_id = :contract_id
AND c.business_id = :business_id
AND c.delete_flag = :delete_flag
GROUP BY
    c.contract_id, e.status
SQL;

        $param = [
            'contract_id'                  => $contract_id,
            'business_id'                  => $business_id,
            'status'                       => ENTRY_STATUS_LIST['rejection'],
            'domestic_plan_type'           => PLAN_TYPE_LIST['DOMESTIC'],
            'international_plan_type_list' => INTERNATIONAL_PLAN_TYPE_LIST,
            'delete_flag'                  => FLG_OFF,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * CHARGEプランユーザーの契約情報を取得する
     *
     * @param $contract_id
     * @param $business_id
     * @return array
     */
    public function get_prepaid_contract_info($contract_id, $business_id) {
        $sql = <<<SQL
SELECT
    c.contract_id,
    e.status AS entry_status,
    e.entry_id,
    GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rcp.contract_plan_id, ''), IFNULL(rcp.order_sn, ''), IFNULL(rcp.order_id, ''), IFNULL(rcp.plan_end_date, ''), IFNULL(mp.plan_id, ''), IFNULL(mp.name, '')
        , IFNULL(mp.plan_type, ''), IFNULL(mp.price, ''), IFNULL(mp.tax_type, ''), IFNULL(mp.billing_type, ''), IFNULL(mp.sale_end_date, '')) ORDER BY mp.disp_order) AS plan_info_list_str,
    GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rco.contract_option_id, ''), IFNULL(rco.option_end_date, ''), IFNULL(mo.option_id, ''), IFNULL(mo.name, ''), IFNULL(mo.option_type, '')
        , IFNULL(mo.price, ''), IFNULL(mo.tax_type, ''), IFNULL(mo.billing_type, ''), IFNULL(mo.sale_end_datetime, '')) ORDER BY mo.disp_order) AS option_info_list_str,
    GROUP_CONCAT(DISTINCT CONCAT_WS('_', IFNULL(rpd.rel_contract_device_id, ''), IFNULL(rpd.device_plan_end_date, ''), IFNULL(md.device_id, ''), IFNULL(md.name, ''), IFNULL(md.device_type, '')
        , IFNULL(md.charge, ''), IFNULL(md.division_month, ''), IFNULL(md.tax_type, ''), IFNULL(md.billing_type, ''), IFNULL(md.sale_end_date, ''), IFNULL(md.color, '')) ORDER BY md.disp_order) AS device_info_list_str
FROM
    contract AS c
INNER JOIN
    entry AS e
    ON  e.entry_id = c.entry_id
    AND e.status != :status
LEFT JOIN
    rel_contract_device AS rpd
    ON  rpd.contract_id = c.contract_id
    AND rpd.business_id = c.business_id
    AND rpd.delete_flag = :delete_flag
LEFT JOIN
    mst_device AS md
    ON  md.device_id = rpd.device_id
    AND md.business_id = c.business_id
LEFT JOIN
    rel_contract_plan AS rcp
    ON  rcp.contract_id = c.contract_id
    AND rcp.business_id = c.business_id
    AND rcp.delete_flag = :delete_flag
LEFT JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = c.business_id
    AND mp.plan_type = :domestic_plan_type
LEFT JOIN
    rel_contract_option rco
    ON  rco.contract_id = c.contract_id
    AND rco.business_id = c.business_id
    AND rcp.delete_flag = :delete_flag
LEFT JOIN
    mst_option AS mo
    ON  mo.option_id = rco.option_id
    AND mo.business_id = c.business_id
WHERE
    c.contract_id = :contract_id
AND c.business_id = :business_id
AND c.delete_flag = :delete_flag
GROUP BY
    c.contract_id, e.status
SQL;

        $param = [
            'contract_id'                  => $contract_id,
            'business_id'                  => $business_id,
            'status'                       => ENTRY_STATUS_LIST['rejection'],
            'domestic_plan_type'           => PLAN_TYPE_LIST['INTERNATIONAL_BASE'],
            'delete_flag'                  => FLG_OFF,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }


    /**
     * ユーザIDを条件に紐づく契約情報を取得する
     *
     * @param int $business_id
     * @param int $user_id
     * @return array
     */
    public function get_contract_info_list_by_user_id($business_id, $user_id) {
        $sql = <<<SQL
SELECT
    *
FROM
    contract AS c
WHERE
    c.business_id = :business_id
AND c.user_id = :user_id
AND c.delete_flag = :delete_flag
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
     * ユーザIDを条件に紐づく契約情報を取得する（contract_infoテーブルから取得）
     *
     * @param int $business_id
     * @param int $user_id
     * @return array
     */
    public function get_contract_info_by_user_id_from_contract_info_table($business_id, $user_id) {
        $sql = <<<SQL
SELECT
    *
FROM
    contract_info AS c
WHERE
    c.business_id = :business_id
AND c.user_id = :user_id
AND c.delete_flag = :delete_flag
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
     * ユーザIDを条件に紐づく契約情報を取得する
     *
     * @param int $business_id
     * @param int $user_id
     * @return array
     */
    public function contract_domestic_plan_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    c.contract_id
  , cmpd.plan_id
FROM contract AS c
LEFT JOIN
    rel_contract_plan AS rcpd
    ON  rcpd.contract_id = c.contract_id
    AND rcpd.business_id = c.business_id
    AND rcpd.delete_flag = :delete_flag
INNER JOIN
    mst_plan AS cmpd
    ON  cmpd.plan_id = rcpd.plan_id
    AND cmpd.business_id = rcpd.business_id
    AND cmpd.plan_type = :domestic_plan_type
WHERE
    c.user_id = :user_id
AND c.business_id = :business_id
AND c.delete_flag = :delete_flag
SQL;

        $params = [
            'business_id'           => $business_id,
            'user_id'               => $user_id,
            'domestic_plan_type'    => PLAN_TYPE_LIST['DOMESTIC'],
            'delete_flag'           => FLG_OFF,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 契約IDをキーに申込ID, プランID, オプションIDを返す
     * @param int $contract_id 契約ID
     */
    public function get_entry_ids_by_contract_id($contract_id){
        $sql =
<<<SQL
SELECT
  c.entry_id,
  ec.plan_id,
  (CASE WHEN ec.device_warranty = 1 THEN 1  WHEN ec.device_warranty = 16 THEN 16 ELSE NULL END) option_id
FROM contract c
INNER JOIN entry_company ec
        ON c.entry_id = ec.entry_id
       AND c.entry_company_id = ec.entry_company_id
WHERE contract_id = :contract_id
SQL;
        $bind_params = [
            'contract_id' => $contract_id,
        ];
        $result = DB::query($sql)->parameters($bind_params)->execute()->as_array();

        return $result ? $result[0] : null;

    }

    /**
     * ユーザIDをキーに適用キャンペーンを取得する
     * @param int    $user_id ユーザID
     * @param int    $target_month 対象月(YYYYMM)
     * @return array
     */
    public function get_apply_charge_campaign_by_user_id($user_id, $target_month){

        $sql =
<<<SQL
SELECT
  c.contract_id
 ,cc.campaign_id
 ,mc.charge_plan_id
 ,mc.charge_valid_count
FROM contract c
INNER JOIN contract_campaign cc
        ON c.contract_id = cc.contract_id
       AND cc.apply_start_year_month <= :target_month
       AND cc.apply_end_year_month >= :target_month
       AND cc.active_flg = :active_flg
INNER JOIN mst_campaign mc
        ON cc.campaign_id = mc.campaign_id
       AND mc.charge_plan_id IS NOT NULL
INNER JOIN rel_contract_plan rcp
        ON c.contract_id = rcp.contract_id
        AND rcp.plan_id = mc.plan_id
INNER JOIN mst_plan mp
        ON rcp.plan_id = mp.plan_id
WHERE c.user_id = :user_id
        AND mp.plan_type = :domestic_plan_type
SQL;

        $bind_params = [
            'user_id'      => $user_id,
            'target_month' => $target_month,
            'active_flg'   => FLG_ON,
            'domestic_plan_type' => PLAN_TYPE_LIST['DOMESTIC'],
        ];

        return DB::query($sql)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * ユーザに紐づく全ての契約を取得する(法人向け)
     * TODO:: get_contract_info_list_by_user_id とほぼ同じでは?違いを確認する。
     * @param $user_id
     * @return array
     */
    public function get_by_user_id($user_id)
    {
        $query = <<<SQL
        SELECT
            *
        FROM
            contract
        WHERE
            user_id = :user_id
            AND delete_flag = :delete_flag

        SQL;

        $bind_params = [];
        $bind_params['user_id'] = $user_id;
        $bind_params['delete_flag'] = FLG_OFF;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * ユーザIDを条件に紐づく海外レンタルプランの各種契約情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_contract_data_list_by_user_id_for_rental($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    c.contract_id
  , mp.plan_id
  , mp.name as plan_name
  , mp.price as plan_price
  , mo.option_id
  , mo.name as option_name
  , mo.price as option_price
  , (
      SELECT
          GROUP_CONCAT(DISTINCT name)
      FROM
        contract_campaign AS cc
      INNER JOIN
        mst_campaign AS mc
      ON
        cc.campaign_id = mc.campaign_id
      WHERE
      cc.contract_id = c.contract_id
      AND cc.active_flg = :active_flg
      AND cc.apply_start_year_month <= DATE_FORMAT(rcp.plan_start_date, '%Y%m')
      AND (
        cc.apply_end_year_month is null
        OR cc.apply_end_year_month >= DATE_FORMAT(rcp.plan_start_date, '%Y%m')
      )
    AND mc.plan_id = rcp.plan_id
  ) AS campaign_name
  , mc.discount_amount
  , rcp.plan_start_date
  , rcp.plan_end_date
  , eh.entry_id
  , eh.create_datetime
FROM contract AS c
INNER JOIN
    rel_contract_plan AS rcp
    ON  rcp.contract_id = c.contract_id
    AND rcp.business_id = c.business_id
    AND rcp.delete_flag = :delete_flag
INNER JOIN
    mst_plan AS mp
    ON  mp.plan_id = rcp.plan_id
    AND mp.business_id = rcp.business_id
    AND mp.plan_type = :international_rental_plan_type
LEFT JOIN
    rel_contract_option AS rco
    ON  rco.contract_id = c.contract_id
    AND rco.business_id = c.business_id
    AND rco.delete_flag = :delete_flag
LEFT JOIN
    mst_option AS mo
    ON  mo. option_id = rco. option_id
    AND mo.business_id = rco.business_id
LEFT JOIN
    contract_campaign AS cc
    ON  cc.contract_id = c.contract_id
    AND cc.active_flg = :active_flg
    AND cc.apply_start_year_month <= DATE_FORMAT(rcp.plan_start_date, '%Y%m')
    AND (
        cc.apply_end_year_month is null
        OR cc.apply_end_year_month >= DATE_FORMAT(rcp.plan_start_date, '%Y%m')
    )
LEFT JOIN
    mst_campaign AS mc
    ON  mc.campaign_id = cc.campaign_id
    AND mc.plan_id = rcp.plan_id
INNER JOIN
    entry_history AS eh
    ON  eh.entry_id = c.entry_id
    AND eh.status IN :entry_status
WHERE
    c.user_id = :user_id
AND c.business_id = :business_id
AND c.delete_flag = :delete_flag
ORDER BY
    eh.create_datetime ASC
SQL;

        $params = [
            'business_id'                    => $business_id,
            'user_id'                        => $user_id,
            'international_rental_plan_type' => PLAN_TYPE_LIST['INTERNATIONAL_RENTAL'],
            'delete_flag'                    => FLG_OFF,
            'active_flg'                     => FLG_ON,
            'entry_status'                   => INTERNATIONAL_RENTAL_MYPAGE_ENTRY_STATUS_LIST,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 論理削除する
     *
     * @param int $business_id 事業者ID
     * @param int $contract_id 契約ID
     * @return int 削除件数
     */
    public function logical_delete($business_id, $contract_id)
    {
        $query = <<<SQL
        UPDATE
            contract
        SET
            delete_flag = :delete_flag
        WHERE
            business_id = :business_id
            AND contract_id = :contract_id

        SQL;

        $params = [
            'business_id'     => $business_id,
            'contract_id'     => $contract_id,
            'delete_flag'     => FLG_ON,
        ];

        return DB::query($query)->parameters($params)->execute()[1];
    }

    public function get_contract_document_key_by_contract_id($contract_id, $user_id, $business_id)
    {
        $query = <<<SQL
        SELECT
            contract_pdf_key
        FROM
            contract
        WHERE
            user_id = :user_id
            AND contract_id = :contract_id
            AND business_id = :business_id
            AND delete_flag = :delete_flag

        SQL;

        $bind_params = [];
        $bind_params['contract_id'] = $contract_id;
        $bind_params['user_id'] = $user_id;
        $bind_params['business_id'] = $business_id;
        $bind_params['delete_flag'] = FLG_OFF;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 申込IDから契約情報を取得する
     *
     * @param int $business_id 事業者ID
     * @param int $entry_id 申込ID
     * @return array 取得結果
     */
    public function get_by_entry_id($business_id, $entry_id)
    {
        $query = <<<SQL
        SELECT
             *
        FROM
            contract
        WHERE
            business_id = :business_id
            AND entry_id = :entry_id
            AND delete_flag = :delete_flag

        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['entry_id'] = $entry_id;
        $bind_params['delete_flag'] = FLG_OFF;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * user_idから購入済みのMAYAプリペイド海外プランのプラン情報をを取得する
     *
     * @param  int   $user_id
     * @param  bool  $is_charge_subscription
     * @return array 取得結果
     */
    public function get_purchased_maya_plan_data_by_user_id($user_id, $is_charge_subscription) {
        $sql = <<<SQL
SELECT
    rcp.contract_plan_id,
    c.contract_id,
    rcp.plan_id,
    rcp.plan_start_date AS start_date,
    rcp.plan_end_date AS end_date,
    rcp.create_datetime AS entry_datetime,
    mp.name AS name,
    mp.price AS price,
    mp.tax_type AS tax_type,
    mp.plan_type,
    e.entry_id,
    ep.plan_id AS entry_plan_id,
    ins.invoice_id,
    'プラン' AS label,
    ir.invoice_result_datetime,
    mcp.continent_name,
    mcp.country_name,
    CASE WHEN mp.plan_type = 13 THEN '500MB'
         WHEN mp.plan_type = 14 THEN '1GB'
         WHEN mp.plan_type = 15 THEN '無制限'
    END AS giga,
    rcch.change_type,
    rcch.before_id,
    rcch.after_id,
    rcch.after_start_datetime,
    rcch.before_start_datetime,
    rcch.after_start_datetime,
    rcch.before_end_datetime,
    rcch.after_end_datetime,
    mpb.plan_type AS before_plan_type,
    mpa.plan_type AS after_plan_type
FROM contract AS c
INNER JOIN
    rel_contract_plan AS rcp
    ON rcp.contract_id = c.contract_id
    AND rcp.business_id = c.business_id
INNER JOIN
    entry AS e
    ON  c.user_id = e.user_id
    AND c.business_id = e.business_id
LEFT JOIN
    entry_plan AS ep
    ON e.entry_id = ep.entry_id
    AND e.business_id = ep.business_id
INNER JOIN
    mst_plan AS mp
    ON rcp.plan_id = mp.plan_id
    AND rcp.business_id = mp.business_id
LEFT JOIN
    mst_continent_plan AS mcp
    ON mp.plan_id = mcp.plan_id
    AND mp.business_id = mcp.business_id
LEFT JOIN
    invoice_schedule AS ins
    ON rcp.contract_plan_id = ins.contract_child_id
    AND rcp.business_id = ins.business_id
LEFT JOIN
    invoice_schedule_plan AS insp
    ON ins.invoice_id = insp.invoice_id
    AND ins.business_id = insp.business_id
LEFT JOIN
    invoice_result AS ir
    ON ins.invoice_id = ir.invoice_id
    AND ins.business_id = ir.business_id
LEFT JOIN
    invoice_result_plan AS irp
    ON ir.invoice_id = irp.invoice_id
    AND ir.business_id = irp.business_id
LEFT JOIN
    rel_contract_change_history AS rcch
    ON ins.invoice_id = rcch.invoice_id
LEFT JOIN
    mst_plan AS mpb
    ON mpb.plan_id = rcch.before_id
LEFT JOIN
    mst_plan AS mpa
    ON mpa.plan_id = rcch.after_id
WHERE
    c.user_id = :user_id AND
    rcp.business_id = :business_id AND
    mp.business_id = :business_id AND
    mp.plan_type IN :plan_type AND
    ins.user_id = :user_id AND
    ins.amount != 0 AND
    ir.invoice_result_datetime IS NOT NULL
GROUP BY rcp.contract_plan_id,
         e.entry_id,
         ep.plan_id,
         ins.invoice_id,
         mcp.continent_name,
         mcp.country_name,
         rcch.change_type,
         rcch.before_start_datetime,
         rcch.after_start_datetime,
         rcch.before_end_datetime,
         rcch.after_end_datetime,
         rcch.change_type,
         rcch.before_id,
         rcch.after_id,
         before_plan_type,
         after_plan_type
ORDER BY rcp.contract_plan_id DESC

SQL;

        $plan_type_list = DATA_CHARGE_INTERNATIONAL_PLAN_TYPE_LIST;
        if ($is_charge_subscription) {
            array_push($plan_type_list, PLAN_TYPE_DOMESTIC_DATA_CHARGE);
        }
        $param = [
            'user_id'     => $user_id,
            'business_id' => BUSINESS_ID,
            'plan_type'   => $plan_type_list,
        ];

        return DB::query($sql)->parameters($param)->execute()->as_array();
    }


    /**
     * user_idから購入済みのMAYAプリペイド海外プランのオプション情報をを取得する
     *
     * @param  int   $user_id
     * @return array 取得結果
     */
    public function get_purchased_maya_option_data_by_user_id($user_id) {
        $sql = <<<SQL
SELECT
    c.contract_id,
    rco.contract_option_id,
    rco.option_id,
    rco.option_start_date AS start_date,
    rco.option_end_date AS end_date,
    rco.create_datetime AS entry_datetime,
    mo.name AS name,
    mo.price AS price,
    mo.tax_type AS tax_type,
    mo.option_type,
    eo.entry_id,
    eo.option_id AS entry_option_id,
    ins.invoice_id,
    ir.invoice_result_datetime,
    'オプション' AS label
FROM contract AS c
INNER JOIN
    rel_contract_option AS rco
    ON rco.contract_id = c.contract_id
    AND rco.business_id = c.business_id
INNER JOIN
    entry AS e
    ON  c.user_id = e.user_id
    AND c.business_id = e.business_id
LEFT JOIN
    entry_option AS eo
    ON e.entry_id = eo.entry_id
    AND e.business_id = eo.business_id
INNER JOIN
    mst_option AS mo
    ON rco.option_id = mo.option_id
    AND rco.business_id = mo.business_id
LEFT JOIN
    invoice_schedule AS ins
    ON rco.contract_option_id = ins.contract_child_id
    AND rco.business_id = ins.business_id
LEFT JOIN
    invoice_schedule_option AS inco
    ON ins.invoice_id = inco.invoice_id
    AND ins.business_id = inco.business_id
LEFT JOIN
    invoice_result AS ir
    ON ins.invoice_id = ir.invoice_id
    AND ins.business_id = ir.business_id
LEFT JOIN
    invoice_result_option AS iro
    ON ir.invoice_id = iro.invoice_id
    AND ir.business_id = iro.business_id
WHERE
    c.user_id = :user_id AND
    rco.business_id = :business_id AND
    mo.business_id = :business_id AND
    ins.user_id = :user_id AND
    ir.invoice_result_datetime IS NOT NULL
GROUP BY rco.contract_option_id, e.entry_id, eo.option_id, ins.invoice_id
ORDER BY rco.contract_option_id DESC
SQL;

        $param = [
            'user_id' => $user_id,
            'business_id' => BUSINESS_ID,
        ];

        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * user_idから購入済みのMAYAプリペイド海外プランの端末情報をを取得する
     *
     * @param  int   $user_id
     * @return array 取得結果
     */
    public function get_purchased_maya_device_data_by_user_id($user_id) {
        $sql = <<<SQL
SELECT
    c.contract_id,
    rcd.rel_contract_device_id AS contract_device_id,
    rcd.device_id,
    rcd.device_plan_start_date AS start_date,
    rcd.device_plan_end_date AS end_date,
    rcd.create_datetime AS entry_datetime,
    md.name AS name,
    md.charge AS price,
    md.tax_type AS tax_type,
    md.device_type,
    e.entry_id,
    ed.device_id AS entry_device_id,
    ed.is_new,
    ins.invoice_id,
    ir.invoice_result_datetime,
    '端末' AS label
FROM contract AS c
INNER JOIN
    rel_contract_device AS rcd
    ON rcd.contract_id = c.contract_id
    AND rcd.business_id = c.business_id
INNER JOIN
    entry AS e
    ON  c.user_id = e.user_id
    AND c.business_id = e.business_id
LEFT JOIN
    entry_device AS ed
    ON e.entry_id = ed.entry_id
    AND e.business_id = ed.business_id
INNER JOIN
    mst_device AS md
    ON rcd.device_id = md.device_id
    AND rcd.business_id = md.business_id
LEFT JOIN
    invoice_schedule AS ins
    ON rcd.rel_contract_device_id = ins.contract_child_id
    AND rcd.business_id = ins.business_id
LEFT JOIN
    invoice_schedule_device_fee AS insd
    ON ins.invoice_id = insd.invoice_id
    AND ins.business_id = insd.business_id
LEFT JOIN
    invoice_result AS ir
    ON ins.invoice_id = ir.invoice_id
    AND ins.business_id = ir.business_id
LEFT JOIN
    invoice_result_device_fee AS ird
    ON ir.invoice_id = ird.invoice_id
    AND ir.business_id = ird.business_id

WHERE
    c.user_id = :user_id AND
    rcd.business_id = :business_id AND
    md.business_id = :business_id AND
    ins.user_id = :user_id AND
    ir.invoice_result_datetime IS NOT NULL
GROUP BY rcd.rel_contract_device_id, e.entry_id, ed.device_id, ed.is_new, ins.invoice_id
ORDER BY rcd.rel_contract_device_id DESC
SQL;

        $param = [
            'user_id' => $user_id,
            'business_id' => BUSINESS_ID,
        ];

        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * user_idから購入済みのMAYAプリペイド海外プランの初期費用情報をを取得する
     *
     * @param  int   $user_id
     * @return array 取得結果
     */
    public function get_purchased_maya_device_init_data_by_user_id($user_id) {
        $sql = <<<SQL
SELECT
    mdi.name AS name,
    mdi.price AS price,
    mdi.tax_type AS tax_type,
    ins.invoice_id,
    ir.invoice_result_datetime,
    '契約事務手数料' AS label
FROM contract AS c
INNER JOIN
    invoice_schedule AS ins
    ON c.user_id = ins.user_id
    AND c.business_id = ins.business_id
LEFT JOIN
    invoice_schedule_device_init AS inco
    ON ins.invoice_id = inco.invoice_id
    AND ins.business_id = inco.business_id
LEFT JOIN
    invoice_result AS ir
    ON ins.invoice_id = ir.invoice_id
    AND ins.business_id = ir.business_id
LEFT JOIN
    invoice_result_device_init AS iro
    ON ir.invoice_id = iro.invoice_id
    AND ir.business_id = iro.business_id
INNER JOIN
    mst_device_init AS mdi
    ON inco.device_init_id = mdi.device_init_id
    AND inco.business_id = mdi.business_id

WHERE
    c.user_id = :user_id AND
    mdi.business_id = :business_id AND
    ins.user_id = :user_id AND
    ir.invoice_result_datetime IS NOT NULL
GROUP BY ins.invoice_id
ORDER BY ins.invoice_id DESC
SQL;

        $param = [
            'user_id' => $user_id,
            'business_id' => BUSINESS_ID,
        ];

        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * ユーザーIDからIMEIを取得する
     *
     * @param  int $user_id
     * @return array
     */
    public function get_user_imei_data($user_id) {
        $sql = <<<SQL
SELECT
    i.imei,
    ed.is_new,
    msd.sales_date,
    e.create_datetime,
    e.status,
    rco.contract_option_id
FROM contract AS c
LEFT JOIN
    rel_contract_device AS rcd
ON c.contract_id = rcd.contract_id
LEFT JOIN
    rel_contract_option AS rco
ON c.contract_id = rco.contract_id
LEFT JOIN
    imei AS i
ON  i.contract_id = rcd.contract_id
AND i.rel_contract_device_id = rcd.rel_contract_device_id
AND i.business_id = rcd.business_id
AND i.delete_flag = :delete_flag
LEFT JOIN
    mst_shipping_device AS msd
ON i.imei = msd.imei2
INNER JOIN
    entry AS e
ON c.user_id = e.user_id
LEFT JOIN
    entry_device AS ed
ON e.entry_id = ed.entry_id AND i.imei = ed.imei
WHERE c.user_id = :user_id AND
      c.business_id = :business_id
SQL;

        $param = [
            'user_id' => $user_id,
            'business_id' => BUSINESS_ID,
            'delete_flag' => FLG_OFF,
        ];

        return DB::query($sql)->parameters($param)->execute()->current();
    }

    /**
     * レコードをINSERTする
     *
     * @param array $pairs
     *            ['カラム名' => '値']形式の連想配列
     * @return number レコード数
     */
    public function insert($pairs)
    {
        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }

    /**
     * ユーザIDを条件に紐づく契約情報を取得する(複数契約前提、降順で取得)
     *
     * @param int $business_id
     * @param int $user_id
     * @return array
     */
    public function get_contract_info_list_by_user_id_for_rental($business_id, $user_id) {
        $sql = <<<SQL
SELECT
    *
FROM
    contract AS c
WHERE
    c.business_id = :business_id
AND c.user_id = :user_id
AND c.delete_flag = :delete_flag
ORDER BY
    c.contract_id DESC
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
     * 申し込みIDから契約情報（最新利用情報）を取得する
     *
     * @param int $entry_id
     * @param array $select 選択カラム
     * @return array 検索結果
     */
    public function get_contract_info_by_entry_id($entry_id, $select=['*'])
    {

        $query = DB::select_array($select)
            ->from(['contract', 'c'])
            ->join(['rel_contract_plan', 'rcp'])
            ->on('rcp.contract_id', '=', 'c.contract_id')
            ->on('rcp.delete_flag', '=', FLG_OFF)
            ->join(['mst_plan', 'mp'])
            ->on('mp.plan_id', '=', 'rcp.plan_id')
            ->where('c.business_id', BUSINESS_ID)
            ->where('c.entry_id', $entry_id)
            ->order_by('rcp.plan_start_date');

        return $query->execute()->as_array();
    }

    /**
     * 終了日を過ぎていない延長可能なプリペイドプランの一覧を返却する
     *
     * @param  int   $user_id
     * @return array
     */
    public function get_can_extension_prepaid_plan($user_id) {
        $datetime = new DateTime();
        $sql = <<<SQL
SELECT
    mp.name,
    rcp.plan_id,
    rcp.contract_plan_id AS id,
    rcp.plan_start_date,
    rcp.plan_end_date,
    mcp.continent_name,
    mcp.country_name,
    mp.price,
    mp.plan_type
FROM contract AS c
INNER JOIN rel_contract_plan AS rcp
    ON c.contract_id = rcp.contract_id
INNER JOIN mst_plan AS mp
    ON rcp.plan_id = mp.plan_id
INNER JOIN mst_continent_plan AS mcp
    ON mp.plan_id = mcp.plan_id
WHERE c.user_id = :user_id AND
      c.business_id = :business_id AND
      rcp.plan_end_date >= :enddatetime AND
      mp.plan_type IN :plan_type
SQL;
        $params = [
            'business_id' => BUSINESS_ID,
            'user_id'     => $user_id,
            'plan_type'   => INTERNATIONAL_PREPAID_PLAN_TYPE_LIST,
            'enddatetime' => $datetime->format(FORMAT_DATETIME_ENDTIME_HYPHEN)
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 終了日を過ぎていないプラン変更可能なプリペイドプランの一覧を返却する
     *
     * @param  int   $user_id
     * @return array
     */
    public function get_can_change_prepaid_plan($user_id) {
        $datetime = new DateTime();
        $sql = <<<SQL
SELECT
    mp.name,
    rcp.plan_id,
    rcp.contract_plan_id AS id,
    rcp.plan_start_date,
    rcp.plan_end_date,
    mcp.continent_name,
    mcp.country_name,
    mp.price,
    mp.plan_type,
    rcch.*
FROM contract AS c
INNER JOIN rel_contract_plan AS rcp
    ON c.contract_id = rcp.contract_id
INNER JOIN mst_plan AS mp
    ON rcp.plan_id = mp.plan_id
INNER JOIN mst_continent_plan AS mcp
    ON mp.plan_id = mcp.plan_id
LEFT JOIN rel_contract_change_history AS rcch
    ON rcp.contract_plan_id = rcch.rel_contract_id
WHERE c.user_id = :user_id AND
      c.business_id = :business_id AND
      rcp.plan_end_date >= :end_datetime AND
      mp.plan_type IN :plan_type
SQL;
        $params = [
            'business_id'  => BUSINESS_ID,
            'user_id'      => $user_id,
            'plan_type'    => INTERNATIONAL_CAN_PLAN_CHANGE_PREPAID_PLAN_TYPE_LIST,
            'end_datetime' => $datetime->format(FORMAT_DATETIME_ENDTIME_HYPHEN)
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 一番最新の購入プリペイドプランを取得する
     *
     * @param  int   $user_id
     * @param  int   $plan_id
     * @return array
     */
    public function get_latest_purchase_prepaid_plan($user_id, $plan_id) {
        $sql = <<<SQL
SELECT
    mp.name AS plan_name,
    rcp.plan_id,
    rcp.contract_plan_id AS id,
    rcp.plan_start_date,
    rcp.plan_end_date,
    mcp.continent_name,
    mcp.country_name,
    mp.price AS plan_price,
    mp.plan_type,
    mp.tax_type
FROM contract AS c
INNER JOIN rel_contract_plan AS rcp
    ON c.contract_id = rcp.contract_id
INNER JOIN mst_plan AS mp
    ON rcp.plan_id = mp.plan_id
LEFT JOIN mst_continent_plan AS mcp
    ON mp.plan_id = mcp.plan_id
WHERE c.user_id = :user_id AND
      c.business_id = :business_id AND
      mp.plan_id = :plan_id
ORDER BY rcp.contract_plan_id DESC
SQL;
        $params = [
            'business_id'  => BUSINESS_ID,
            'user_id'      => $user_id,
            'plan_id'      => $plan_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->current();
        return parent::post_find($result);
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
