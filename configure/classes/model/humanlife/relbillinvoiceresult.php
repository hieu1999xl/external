<?php

/**
 * 請求書・請求実績リレーション(rel_bill_invoice_result)テーブルのモデルクラス
 *
 * @author m.ishikawa@humanlife.co.jp
 */
class Model_HumanLife_RelBillInvoiceResult extends Model_CrudAbstract
{
    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string テーブル名
     */
    protected static $_table_name = 'rel_bill_invoice_result';

    /**
     * 請求書番号を元に、リレーションに紐づく請求実績端末初期費用を取得する
     *
     * @param integer $business_id 事業者ID
     * @param integer $bill_id 請求書番号
     * @return array 取得結果
     */
    public function get_rel_and_invoice_result_device_init_by_bill_id($business_id, $bill_id)
    {
        $query = <<<SQL
        SELECT
            rel_bill_invoice_result.business_id
            , rel_bill_invoice_result.bill_id
            , invoice_result.invoice_type
            , invoice_result.amount
            , invoice_result.tax_price
            , invoice_result.tax_type
            , invoice_result.tax_rate
            , invoice_result.service_use_date
            , invoice_result_device_init.invoice_id
            , invoice_result_device_init.device_init_id
            , invoice_result_device_init.name
            , invoice_result_device_init.price
            , invoice_result_device_init.tax_type
            , invoice_result_device_init.create_datetime
            , invoice_result_device_init.create_user
            , invoice_result_device_init.update_datetime
            , invoice_result_device_init.update_user
        FROM
          rel_bill_invoice_result
        INNER JOIN invoice_result
            ON rel_bill_invoice_result.business_id = invoice_result.business_id
            AND rel_bill_invoice_result.invoice_id = invoice_result.invoice_id
        INNER JOIN invoice_result_device_init
            ON invoice_result.business_id = invoice_result_device_init.business_id
            AND invoice_result.invoice_id = invoice_result_device_init.invoice_id
        WHERE
          rel_bill_invoice_result.business_id = :business_id
          AND rel_bill_invoice_result.bill_id = :bill_id
          AND invoice_result.invoice_type = :invoice_type

        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['bill_id'] = $bill_id;
        $bind_params['invoice_type'] = INVOICE_TYPE_DEVICE_INIT;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 請求書番号を元に、リレーションに紐づく請求実績プランを取得する
     *
     * @param integer $business_id 事業者ID
     * @param integer $bill_id 請求書番号
     * @return array 取得結果
     */
    public function get_rel_and_invoice_result_plan_by_bill_id($business_id, $bill_id)
    {
        $query = <<<SQL
        SELECT
            rel_bill_invoice_result.business_id
            , rel_bill_invoice_result.bill_id
            , invoice_result.invoice_type
            , invoice_result.amount
            , invoice_result.tax_price
            , invoice_result.tax_type
            , invoice_result.tax_rate
            , invoice_result.service_use_date
            , invoice_result_plan.invoice_id
            , invoice_result_plan.plan_id
            , invoice_result_plan.name
            , invoice_result_plan.price
            , invoice_result_plan.tax_type
            , invoice_result_plan.billing_type
            , invoice_result_plan.create_datetime
            , invoice_result_plan.create_user
            , invoice_result_plan.update_datetime
            , invoice_result_plan.update_user
        FROM
          rel_bill_invoice_result
        INNER JOIN invoice_result
            ON rel_bill_invoice_result.business_id = invoice_result.business_id
            AND rel_bill_invoice_result.invoice_id = invoice_result.invoice_id
        INNER JOIN invoice_result_plan
            ON invoice_result.business_id = invoice_result_plan.business_id
            AND invoice_result.invoice_id = invoice_result_plan.invoice_id
        WHERE
          rel_bill_invoice_result.business_id = :business_id
          AND rel_bill_invoice_result.bill_id = :bill_id
          AND invoice_result.invoice_type IN :invoice_type

        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['bill_id'] = $bill_id;
        $bind_params['invoice_type'] = PLAN_INVOICE_TYPE_LIST;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 請求書番号を元に、リレーションに紐づく請求実績オプションを取得する
     *
     * @param integer $business_id 事業者ID
     * @param integer $bill_id 請求書番号
     * @return array 取得結果
     */
    public function get_rel_and_invoice_result_option_by_bill_id($business_id, $bill_id)
    {
        $query = <<<SQL
        SELECT
            rel_bill_invoice_result.business_id
            , rel_bill_invoice_result.bill_id
            , invoice_result.invoice_type
            , invoice_result.amount
            , invoice_result.tax_price
            , invoice_result.tax_type
            , invoice_result.tax_rate
            , invoice_result.service_use_date
            , invoice_result_option.invoice_id
            , invoice_result_option.option_id
            , invoice_result_option.name
            , invoice_result_option.price
            , invoice_result_option.tax_type
            , invoice_result_option.create_datetime
            , invoice_result_option.create_user
            , invoice_result_option.update_datetime
            , invoice_result_option.update_user
        FROM
          rel_bill_invoice_result
        INNER JOIN invoice_result
            ON rel_bill_invoice_result.business_id = invoice_result.business_id
            AND rel_bill_invoice_result.invoice_id = invoice_result.invoice_id
        INNER JOIN invoice_result_option
            ON invoice_result.business_id = invoice_result_option.business_id
            AND invoice_result.invoice_id = invoice_result_option.invoice_id
        WHERE
          rel_bill_invoice_result.business_id = :business_id
          AND rel_bill_invoice_result.bill_id = :bill_id
          AND invoice_result.invoice_type = :invoice_type

        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['bill_id'] = $bill_id;
        $bind_params['invoice_type'] = INVOICE_TYPE_OPTION;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 請求書番号を元に、リレーションに紐づく請求実績調整金を取得する
     *
     * @param integer $business_id
     *            事業者ID
     * @param integer $bill_id
     *            請求書番号
     * @return array 取得結果
     */
    public function get_rel_and_invoice_result_adjustment_money_by_bill_id($business_id, $bill_id)
    {
        $query = <<<SQL
        SELECT
            rel_bill_invoice_result.business_id
            , rel_bill_invoice_result.bill_id
            , invoice_result.invoice_type
            , invoice_result.amount
            , invoice_result.tax_price
            , invoice_result.tax_type
            , invoice_result.tax_rate
            , invoice_result.service_use_date
            , invoice_result_adjustment_money.invoice_id
            , invoice_result_adjustment_money.adjustment_money_id
            , invoice_result_adjustment_money.type adjustment_money_type
            , invoice_result_adjustment_money.name
            , invoice_result_adjustment_money.price
            , invoice_result_adjustment_money.tax_type
            , invoice_result_adjustment_money.create_datetime
            , invoice_result_adjustment_money.create_user
            , invoice_result_adjustment_money.update_datetime
            , invoice_result_adjustment_money.update_user
        FROM
          rel_bill_invoice_result
        INNER JOIN invoice_result
            ON rel_bill_invoice_result.business_id = invoice_result.business_id
            AND rel_bill_invoice_result.invoice_id = invoice_result.invoice_id
        INNER JOIN invoice_result_adjustment_money
            ON invoice_result.business_id = invoice_result_adjustment_money.business_id
            AND invoice_result.invoice_id = invoice_result_adjustment_money.invoice_id
        WHERE
          rel_bill_invoice_result.business_id = :business_id
          AND rel_bill_invoice_result.bill_id = :bill_id
          AND invoice_result.invoice_type = :invoice_type

        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['bill_id'] = $bill_id;
        $bind_params['invoice_type'] = INVOICE_TYPE_FIX;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 請求書番号を元に、リレーションに紐づく請求実績端末料金を取得する
     *
     * @param integer $business_id
     *            事業者ID
     * @param integer $bill_id
     *            請求書番号
     * @return array 取得結果
     */
    public function get_rel_and_invoice_result_device_fee_by_bill_id($business_id, $bill_id)
    {
        $query = <<<SQL
        SELECT
            rel_bill_invoice_result.business_id
            , rel_bill_invoice_result.bill_id
            , invoice_result.invoice_type
            , invoice_result.amount
            , invoice_result.tax_price
            , invoice_result.tax_type
            , invoice_result.tax_rate
            , invoice_result.service_use_date
            , invoice_result_device_fee.invoice_id
            , invoice_result_device_fee.device_id
            , invoice_result_device_fee.name
            , invoice_result_device_fee.price
            , invoice_result_device_fee.tax_type
            , invoice_result_device_fee.create_datetime
            , invoice_result_device_fee.create_user
            , invoice_result_device_fee.update_datetime
            , invoice_result_device_fee.update_user
        FROM
          rel_bill_invoice_result
        INNER JOIN invoice_result
            ON rel_bill_invoice_result.business_id = invoice_result.business_id
            AND rel_bill_invoice_result.invoice_id = invoice_result.invoice_id
        INNER JOIN invoice_result_device_fee
            ON invoice_result.business_id = invoice_result_device_fee.business_id
            AND invoice_result.invoice_id = invoice_result_device_fee.invoice_id
        WHERE
          rel_bill_invoice_result.business_id = :business_id
          AND rel_bill_invoice_result.bill_id = :bill_id
          AND invoice_result.invoice_type IN :invoice_type

SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['bill_id'] = $bill_id;
        $bind_params['invoice_type'] = [
          INVOICE_TYPE_DEVICE_PRICE,
          INVOICE_TYPE_DEVICE_LOAN,
        ];

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 請求書番号を元に、リレーションに紐づく総額の合計を取得する
     *
     * @param integer $business_id 事業者ID
     * @param integer $bill_id 請求書番号
     * @return array 取得結果
     */
    public function get_total_amount_by_bill_id($business_id, $bill_id)
    {
        $query = <<<SQL
        SELECT
          SUM(invoice_result.amount) AS total_amount
        FROM
          rel_bill_invoice_result
        INNER JOIN invoice_result
            ON rel_bill_invoice_result.business_id = invoice_result.business_id
            AND rel_bill_invoice_result.invoice_id = invoice_result.invoice_id
        WHERE
          rel_bill_invoice_result.business_id = :business_id
          AND rel_bill_invoice_result.bill_id = :bill_id

        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['bill_id'] = $bill_id;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }
}
