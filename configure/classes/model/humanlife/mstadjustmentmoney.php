<?php

class Model_HumanLife_MstAdjustmentMoney extends Model_CrudAbstract
{
    /**
     * テーブル名
     */
    protected static $_table_name = 'mst_adjustment_money';

    /**
     *
     * @param  $business_id
     */

    public function  get_cancel_fee_info_from_mst_adjustment_money($business_id) {

        $query = <<<SQL
        SELECT
             *
        FROM
            mst_adjustment_money
        WHERE
            business_id = :business_id
        AND adjustment_money_id = :adjustment_money_id
        ORDER BY disp_order ASC

        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['adjustment_money_id'] = ADJUSTMENT_MONEY_ID_CANCELLATION_FEE;

        return DB::query($query)->parameters($bind_params)
        ->execute()
        ->as_array();

    }

    /**
     * plan_idを元に解約違約金を取得する
     * @param  $business_id
     * @param int $plan_id プランID
     * @param datetime $expired_datetime 有効期限
     */
    public function  get_cancel_fee_info_by_plan_id($business_id, $plan_id, $expired_datetime=null) {

        $query = <<<SQL
        SELECT
             *
        FROM
            mst_adjustment_money
        WHERE
            business_id = :business_id
        AND plan_id = :plan_id
        AND is_contract_penalty_fee = :is_contract_penalty_fee 
        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['plan_id'] = $plan_id;
        $bind_params['is_contract_penalty_fee'] = FLG_ON;

        if (empty($expired_datetime)) {
            $query .= ' AND expired_datetime IS NULL ';
        } else {
            $query .= ' AND (expired_datetime IS NULL OR expired_datetime > :expired_datetime) ';
            $bind_params['expired_datetime'] = $expired_datetime;
        }
        $query .= ' ORDER BY disp_order ASC ';

        return DB::query($query)->parameters($bind_params)
        ->execute()
        ->as_array();

    }

    /**
     * @param int  $adjustment_money_id
     * @param array  $select
     */
    public function get_adjustment_money_id_info($adjustment_money_id , array $select = ['*']) {
        $query = DB::select_array($select)
                    ->from(self::$_table_name)
                    ->where('business_id', BUSINESS_ID)
                    ->where('adjustment_money_id', $adjustment_money_id)
        ;
        return $query->execute()->current();
    }

    /**
     * plan_idをキーに調整金取得
     * 
     * @param int  $plan_id
     * @param array  $select
     * @return array 調整金リスト
     */
    public function get_adjustment_money_by_plan_id($plan_id , $select) {
        $query = DB::select_array($select)
            ->from(self::$_table_name)
            ->where('business_id', BUSINESS_ID)
            ->where('plan_id', $plan_id);
        return $query->execute()->current();
    }

}
