<?php

class Model_HumanLife_InvoiceScheduleAdjustmentMoney extends Model_CrudAbstract
{

    /**
     *
     * @param
     * @return
     */
    public function insert_invoice_schedule_adjustment_money($param) {


        $query = <<<SQL
INSERT INTO
    invoice_schedule_adjustment_money
(
    `business_id`,
    `invoice_id`,
    `adjustment_money_id`,
    `type`,
    `name`,
    `price`,
    `tax_type`,
    `bill_datetime`,
    `create_user`,
    `update_user`
)
VALUES
(
    :business_id,
    :invoice_id,
    :adjustment_money_id,
    :type,
    :name,
    :price,
    :tax_type,
    :bill_datetime,
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
     * 請求明細番号を元に、レコードを取得する
     *
     * @param integer $business_id
     * @param integer $invoice_id
     * @param integer $adjustment_money_id
     * @return array 取得結果
     */
    public function get_by_invoice_id($business_id, $invoice_id, $adjustment_money_id) {
        $query = <<<SQL
        SELECT
          *
        FROM
          invoice_schedule_adjustment_money
        WHERE
          business_id = :business_id
          AND invoice_id = :invoice_id
          AND adjustment_money_id = :adjustment_money_id

SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['invoice_id'] = $invoice_id;
        $bind_params['adjustment_money_id'] = $adjustment_money_id;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }
}
