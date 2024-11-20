<?php

/**
 * 請求テーブルのモデルクラス
 */
class Model_HumanLife_Invoice extends Model_CrudAbstract {

    /**
     * ユーザーIDを条件に請求予定情報・請求実績情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @param bool $specify_sort
     * @return array
     */
    public function get_invoice_schedule_info_list_by_user_id($user_id, $business_id, $specify_sort = false) {
        $sql = <<<SQL
SELECT
    ins.business_id
  , ins.invoice_id
  , ins.user_id
  , ins.company_id
  , ins.invoice_type
  , ins.tax_price AS schedule_tax_price
  , ins.tax_type AS schedule_tax_type
  , ins.tax_rate AS schedule_tax_rate
  , DATE_FORMAT(ins.invoice_schedule_datetime, '%Y/%m/%d') AS invoice_schedule_date
  , ins.amount AS schedule_amount
  , insp.plan_id
  , insp.name AS plan_name
  , inso.option_id
  , inso.name AS option_name
  , inrdi.device_init_id
  , inrdi.name AS init_name
  , insam.adjustment_money_id
  , insam.name AS adjustment_money_name
  , insdf.device_id
  , insdf.name AS device_fee_name
  , inr.invoice_status
  , DATE_FORMAT(inr.invoice_result_datetime, '%Y/%m/%d') AS invoice_result_date
  , inr.amount AS result_amount
  , inr.settlement_type
  , inr.tax_price AS result_tax_price
  , inr.tax_type AS result_tax_type
  , inr.tax_rate AS result_tax_rate
  , ins.service_use_date
  , ins.schedule_child_id
  , ins.use_day_count
  , ins.use_flow_gb
  , ins.contract_pay_as_you_go_child_id
  , mp.pay_as_you_go_type
  , mp.plan_type
  /* 適応中のキャンペーン名を取得、複数キャンペーンを考慮し半赤くスペース区切り */
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
      cc.contract_id = ins.contract_id
      AND cc.active_flg = :active_flg
      AND cc.apply_start_year_month <= DATE_FORMAT(ins.invoice_schedule_datetime, '%Y%m')
      AND (
        cc.apply_end_year_month is null
        OR cc.apply_end_year_month >= DATE_FORMAT(ins.invoice_schedule_datetime, '%Y%m')
      )
    AND mc.plan_id = insp.plan_id
  ) AS campaign_name
FROM
    invoice_schedule AS ins
LEFT JOIN
    invoice_schedule_plan AS insp
    ON  insp.business_id = ins.business_id
    AND insp.invoice_id = ins.invoice_id
    AND ins.invoice_type IN :invoice_type_plan
LEFT JOIN
    invoice_schedule_option AS inso
    ON  inso.business_id = ins.business_id
    AND inso.invoice_id = ins.invoice_id
    AND ins.invoice_type = :invoice_type_option
LEFT JOIN
    invoice_schedule_device_init AS inrdi
    ON inrdi.business_id = ins.business_id
    AND inrdi.invoice_id = ins.invoice_id
    AND ins.invoice_type = :invoice_type_init
LEFT JOIN
    invoice_schedule_adjustment_money AS insam
    ON insam.business_id = ins.business_id
    AND insam.invoice_id = ins.invoice_id
    AND ins.invoice_type = :invoice_type_adjustment_money
LEFT JOIN
    invoice_schedule_device_fee AS insdf
    ON insdf.business_id = ins.business_id
    AND insdf.invoice_id = ins.invoice_id
    AND ins.invoice_type IN :invoice_type_device_fee
LEFT JOIN
    invoice_result AS inr
    ON  inr.business_id = ins.business_id
    AND inr.invoice_id = ins.invoice_id
    AND inr.user_id = ins.user_id
LEFT JOIN
    mst_plan AS mp
    ON  insp.business_id = mp.business_id
    AND insp.plan_id = mp.plan_id
WHERE
    ins.user_id = :user_id
AND ins.business_id = :business_id
SQL;

        $param = [
            'user_id'             => $user_id,
            'business_id'         => $business_id,
            'invoice_type_plan'   => PLAN_INVOICE_TYPE_LIST,
            'invoice_type_option' => INVOICE_TYPE_LIST['OPTION'],
            'invoice_type_init'   => INVOICE_TYPE_LIST['INIT'],
            'invoice_type_adjustment_money' => INVOICE_TYPE_LIST['FIX'],
            'invoice_type_device_fee' => INVOICE_TYPE_DEVICE_FEE_LIST,
            'active_flg'          => FLG_ON,
        ];

        if($specify_sort === true) {
            // 利用明細画面で並び替える
            $sql .= <<<SQL

ORDER BY
    FIELD(ins.invoice_type, :INIT, :OPTION, :PLAN, :FIX, :CHARGE, :OVERSEAS, :DEVICE_PRICE, :DEVICE_LOAN)
    ,ins.schedule_child_id
    ,ins.use_flow_gb
    ,insp.plan_id IS NULL ASC
    ,ins.service_use_date DESC
    ,ins.invoice_id
SQL;
            // invoice_typeで指定した順番で並び替える
            foreach (INVOICE_TYPE_LIST as $key => $invoice_type) {
                $param[$key] =  $invoice_type;
            }
        }

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }


    /**
     * ユーザーIDを条件に請求予定情報・請求実績情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_corp_invoice_schedule_info_list_by_user_id($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    ins.business_id
  , ins.invoice_id
  , ins.user_id
  , ins.company_id
  , ins.invoice_type
  , ins.tax_price AS schedule_tax_price
  , DATE_FORMAT(ins.invoice_schedule_datetime, '%Y/%m/%d') AS invoice_schedule_date
  , ins.amount AS schedule_amount
  , insp.plan_id
  , insp.name AS plan_name
  , inso.option_id
  , inso.name AS option_name
  , inrdi.device_init_id
  , inrdi.name AS init_name
  , inr.invoice_status
  , DATE_FORMAT(inr.invoice_result_datetime, '%Y/%m/%d') AS invoice_result_date
  , inr.amount AS result_amount
  , inr.settlement_type
  , inr.tax_price AS result_tax_price
  /* 適応中のキャンペーン名を取得、複数キャンペーンを考慮し半赤くスペース区切り */
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
      cc.contract_id = ins.contract_id
      AND cc.active_flg = :active_flg
      AND cc.apply_start_year_month <= DATE_FORMAT(ins.invoice_schedule_datetime, '%Y%m')
      AND (
        cc.apply_end_year_month is null
        OR cc.apply_end_year_month >= DATE_FORMAT(ins.invoice_schedule_datetime, '%Y%m')
      )
    AND mc.plan_id = insp.plan_id
  ) AS campaign_name
FROM
    invoice_schedule AS ins
LEFT JOIN
    invoice_schedule_plan AS insp
    ON  insp.business_id = ins.business_id
    AND insp.invoice_id = ins.invoice_id
    AND ins.invoice_type IN :invoice_type_plan
LEFT JOIN
    invoice_schedule_option AS inso
    ON  inso.business_id = ins.business_id
    AND inso.invoice_id = ins.invoice_id
    AND ins.invoice_type = :invoice_type_option
LEFT JOIN
    invoice_schedule_device_init AS inrdi
    ON inrdi.business_id = ins.business_id
    AND inrdi.invoice_id = ins.invoice_id
    AND ins.invoice_type = :invoice_type_init
LEFT JOIN
    invoice_result AS inr
    ON  inr.business_id = ins.business_id
    AND inr.invoice_id = ins.invoice_id
    AND inr.user_id = ins.user_id
WHERE
    ins.user_id = :user_id
AND ins.business_id = :business_id
SQL;

        $param = [
            'user_id'             => $user_id,
            'business_id'         => $business_id,
            'invoice_type_plan'   => PLAN_INVOICE_TYPE_LIST,
            'invoice_type_option' => INVOICE_TYPE_LIST['OPTION'],
            'invoice_type_init'   => INVOICE_TYPE_LIST['INIT'],
            'active_flg'          => FLG_ON,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザーIDと年月を条件に請求予定情報・請求実績情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @param int $year
     * @param int $month
     * @param string $display
     * @param bool $specify_sort
     * @return array
     */
    public function get_invoice_schedule_info_list_by_yearmonth($user_id, $business_id, $year, $month, $display, $specify_sort = false) {
        $sql = <<<SQL
SELECT
    ins.business_id
  , ins.invoice_id
  , ins.user_id
  , ins.company_id
  , ins.invoice_type
  , ins.tax_price AS schedule_tax_price
  , ins.tax_type AS schedule_tax_type
  , ins.tax_rate AS schedule_tax_rate
  , DATE_FORMAT(ins.invoice_schedule_datetime, '%Y/%m/%d') AS invoice_schedule_date
  , ins.amount AS schedule_amount
  , insp.plan_id
  , insp.name AS plan_name
  , inso.option_id
  , inso.name AS option_name
  , inrdi.device_init_id
  , inrdi.name AS init_name
  , insam.adjustment_money_id
  , insam.name AS adjustment_money_name
  , inr.invoice_status
  , DATE_FORMAT(inr.invoice_result_datetime, '%Y/%m/%d') AS invoice_result_date
  , inr.amount AS result_amount
  , inr.settlement_type
  , inr.tax_price AS result_tax_price
  , inr.tax_type AS result_tax_type
  , inr.tax_rate AS result_tax_rate
  , ins.service_use_date
  , ins.schedule_child_id
  , ins.use_day_count
  , ins.use_flow_gb
  , ins.contract_pay_as_you_go_child_id
  , insdf.name AS device_fee_name
  , mp.pay_as_you_go_type
  , mp.plan_type 
  /* 適応中のキャンペーン名を取得、複数キャンペーンを考慮し半赤くスペース区切り */
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
      cc.contract_id = ins.contract_id
      AND cc.active_flg = :active_flg
      AND cc.apply_start_year_month <= DATE_FORMAT(ins.invoice_schedule_datetime, '%Y%m')
      AND (
        cc.apply_end_year_month is null
        OR cc.apply_end_year_month >= DATE_FORMAT(ins.invoice_schedule_datetime, '%Y%m')
      )
    AND mc.plan_id = insp.plan_id
  ) AS campaign_name
FROM
    invoice_schedule AS ins
LEFT JOIN
    invoice_schedule_plan AS insp
    ON  insp.business_id = ins.business_id
    AND insp.invoice_id = ins.invoice_id
    AND ins.invoice_type IN :invoice_type_plan
LEFT JOIN
    invoice_schedule_option AS inso
    ON  inso.business_id = ins.business_id
    AND inso.invoice_id = ins.invoice_id
    AND ins.invoice_type = :invoice_type_option
LEFT JOIN
    invoice_schedule_device_init AS inrdi
    ON inrdi.business_id = ins.business_id
    AND inrdi.invoice_id = ins.invoice_id
    AND ins.invoice_type = :invoice_type_init
LEFT JOIN
    invoice_schedule_adjustment_money AS insam
    ON insam.business_id = ins.business_id
    AND insam.invoice_id = ins.invoice_id
    AND ins.invoice_type = :invoice_type_adjustment_money
LEFT JOIN
    invoice_result AS inr
    ON  inr.business_id = ins.business_id
    AND inr.invoice_id = ins.invoice_id
    AND inr.user_id = ins.user_id
LEFT JOIN
    invoice_schedule_device_fee AS insdf
    ON insdf.business_id = ins.business_id
    AND insdf.invoice_id = ins.invoice_id
    AND ins.invoice_type IN :invoice_type_device_fee
LEFT JOIN
    mst_plan AS mp
    ON  insp.business_id = mp.business_id
    AND insp.plan_id = mp.plan_id
WHERE
    ins.user_id = :user_id
AND ins.business_id = :business_id
SQL;

        $param = [
            'user_id'                       => $user_id,
            'business_id'                   => $business_id,
            'invoice_type_plan'             => PLAN_INVOICE_TYPE_LIST,
            'invoice_type_option'           => INVOICE_TYPE_LIST['OPTION'],
            'invoice_type_init'             => INVOICE_TYPE_LIST['INIT'],
            'invoice_type_adjustment_money' => INVOICE_TYPE_LIST['FIX'],
            'invoice_type_device_fee'       => INVOICE_TYPE_DEVICE_FEE_LIST,
            'active_flg'                    => FLG_ON,
        ];
        if($display === "monthly_bill"){
            $sql .= ' AND ( DATE_FORMAT(ins.invoice_schedule_datetime, "%Y-%m") = :invoice_schedule_datetime';
            $sql .= ' OR DATE_FORMAT(inr.invoice_result_datetime, "%Y-%m") = :invoice_schedule_datetime)';
            $param['invoice_schedule_datetime'] = $year.'-'.$month;
        } else {
            $sql .= ' AND ins.service_use_date = :service_use_date';
            $param['service_use_date'] = $year.$month;
        }

        // invoice_typeで指定した順番で並び替える
        if($specify_sort === true) {
            // 利用明細画面で並び替える
            $sql .= <<<SQL

ORDER BY
    FIELD(ins.invoice_type, :INIT, :OPTION, :PLAN, :FIX, :CHARGE, :OVERSEAS, :DEVICE_PRICE, :DEVICE_LOAN)
    ,ins.schedule_child_id
    ,ins.use_flow_gb
    ,insp.plan_id IS NULL ASC
    ,ins.service_use_date DESC
    ,ins.invoice_id
SQL;
            foreach (INVOICE_TYPE_LIST as $key => $invoice_type) {
                $param[$key] =  $invoice_type;
            }
        }

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザーIDと請求番号を条件に請求予定情報・請求実績情報を取得する
     *
     * @param int   $user_id
     * @param int   $business_id
     * @param array $invoice_ids
     * @return array
     */
    public function get_invoice_schedule_info_list_by_invoice_id($user_id, $business_id, $invoice_ids) {
        $sql = <<<SQL
SELECT
    ins.business_id
  , ins.invoice_id
  , ins.user_id
  , ins.company_id
  , ins.invoice_type
  , ins.tax_price AS schedule_tax_price
  , ins.tax_type AS schedule_tax_type
  , ins.tax_rate AS schedule_tax_rate
  , DATE_FORMAT(ins.invoice_schedule_datetime, '%Y/%m/%d') AS invoice_schedule_date
  , ins.amount AS schedule_amount
  , insp.plan_id
  , insp.name AS plan_name
  , inso.option_id
  , inso.name AS option_name
  , inrdi.device_init_id
  , inrdi.name AS init_name
  , insam.adjustment_money_id
  , insam.name AS adjustment_money_name
  , inr.invoice_status
  , DATE_FORMAT(inr.invoice_result_datetime, '%Y/%m/%d') AS invoice_result_date
  , inr.amount AS result_amount
  , inr.settlement_type
  , inr.tax_price AS result_tax_price
  , inr.tax_type AS result_tax_type
  , inr.tax_rate AS result_tax_rate
  , ins.service_use_date
  , ins.schedule_child_id
  , ins.use_day_count
  , ins.use_flow_gb
  , ins.contract_pay_as_you_go_child_id
  , insdf.name AS device_fee_name
  , mp.pay_as_you_go_type
  /* 適応中のキャンペーン名を取得、複数キャンペーンを考慮し半赤くスペース区切り */
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
      cc.contract_id = ins.contract_id
      AND cc.active_flg = :active_flg
      AND cc.apply_start_year_month <= DATE_FORMAT(ins.invoice_schedule_datetime, '%Y%m')
      AND (
        cc.apply_end_year_month is null
        OR cc.apply_end_year_month >= DATE_FORMAT(ins.invoice_schedule_datetime, '%Y%m')
      )
    AND mc.plan_id = insp.plan_id
  ) AS campaign_name
FROM
    invoice_schedule AS ins
LEFT JOIN
    invoice_schedule_plan AS insp
    ON  insp.business_id = ins.business_id
    AND insp.invoice_id = ins.invoice_id
    AND ins.invoice_type IN :invoice_type_plan
LEFT JOIN
    invoice_schedule_option AS inso
    ON  inso.business_id = ins.business_id
    AND inso.invoice_id = ins.invoice_id
    AND ins.invoice_type = :invoice_type_option
LEFT JOIN
    invoice_schedule_device_init AS inrdi
    ON inrdi.business_id = ins.business_id
    AND inrdi.invoice_id = ins.invoice_id
    AND ins.invoice_type = :invoice_type_init
LEFT JOIN
    invoice_schedule_adjustment_money AS insam
    ON insam.business_id = ins.business_id
    AND insam.invoice_id = ins.invoice_id
    AND ins.invoice_type = :invoice_type_adjustment_money
LEFT JOIN
    invoice_result AS inr
    ON  inr.business_id = ins.business_id
    AND inr.invoice_id = ins.invoice_id
    AND inr.user_id = ins.user_id
LEFT JOIN
    invoice_schedule_device_fee AS insdf
    ON insdf.business_id = ins.business_id
    AND insdf.invoice_id = ins.invoice_id
    AND ins.invoice_type IN :invoice_type_device_fee
LEFT JOIN
    mst_plan AS mp
    ON  insp.business_id = mp.business_id
    AND insp.plan_id = mp.plan_id
WHERE
    ins.user_id = :user_id
AND ins.business_id = :business_id
AND ins.invoice_id IN :invoice_ids
SQL;

        $param = [
            'user_id'                       => $user_id,
            'business_id'                   => $business_id,
            'invoice_type_plan'             => PLAN_INVOICE_TYPE_LIST,
            'invoice_type_option'           => INVOICE_TYPE_LIST['OPTION'],
            'invoice_type_init'             => INVOICE_TYPE_LIST['INIT'],
            'invoice_type_adjustment_money' => INVOICE_TYPE_LIST['FIX'],
            'invoice_type_device_fee'       => INVOICE_TYPE_DEVICE_FEE_LIST,
            'active_flg'                    => FLG_ON,
            'invoice_ids'                   => $invoice_ids,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }
}
