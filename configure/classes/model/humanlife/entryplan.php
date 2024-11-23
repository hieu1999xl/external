<?php

/**
 * 申し込み－プランテーブルのモデルクラス
 */
class Model_HumanLife_EntryPlan extends Model_CrudAbstract {

    /**
     * 申込IDを条件に申し込み－プラン情報を取得する
     *
     * @param int $business_id
     * @param int $entry_id
     * @return array
     */
    public function get_entry_plan_info_list_by_entry_id($business_id, $entry_id) {
        $sql = <<<SQL
SELECT
    ep.entry_plan_id
  , ep.market_price_id
  , ep.market_id
  , ep.version
  , mp.plan_id
  , mp.name
  , mp.plan_type
  , mp.price
  , mp.billing_type
  , mp.tax_type
  , mp.init_fee
  , mp.init_fee_tax_type
FROM
    entry_plan AS ep
        INNER JOIN
            mst_plan AS mp
        ON
            mp.plan_id = ep.plan_id
        AND mp.business_id = ep.business_id
WHERE
    ep.entry_id = :entry_id
AND ep.business_id = :business_id
ORDER BY
    ep.entry_plan_id ASC
SQL;

        $params = [
            'entry_id'    => $entry_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 契約IDを条件に申し込み－プラン情報を取得する
     *
     * @param int $contract_id
     * @param int $plan_id
     * @param int $business_id
     * @param int $user_id
     * @return array
     */
    public function get_entry_plan_by_contract_id($contract_id, $plan_id, $business_id, $user_id) {
        $sql = <<<SQL
SELECT
    ep.*,
    msd.ucl_account_type
FROM
    entry_plan AS ep
INNER JOIN
    mst_plan AS mp
ON
    mp.plan_id = ep.plan_id
AND mp.business_id = ep.business_id
INNER JOIN
    contract AS c
ON
    c.business_id = ep.business_id
AND c.entry_id = ep.entry_id
AND c.contract_id = :contract_id
AND c.user_id = :user_id
LEFT JOIN
    imei i
ON i.business_id = ep.business_id
AND i.contract_id = c.contract_id
LEFT JOIN
    mst_shipping_device msd
ON msd.business_id = ep.business_id
AND msd.imei2 = i.imei
WHERE
    ep.plan_id = :plan_id
AND ep.business_id = :business_id
SQL;

        $params = [
            'contract_id' => $contract_id,
            'user_id'     => $user_id,
            'plan_id'     => $plan_id,
            'business_id' => $business_id,
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
            entry_plan
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

    public function delete_entry_plan($entry_id, $business_id)
    {
        $sql = <<<SQL
DELETE FROM
    entry_plan
WHERE
    entry_id = :entry_id
AND
    business_id = :business_id
SQL;

        $params = [
            'entry_id' => $entry_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        DB::query($sql)->parameters($params)->execute();
    }

    /**
     * フリープランあるかどうか
     * @param int $entry_id
     * @param int $business_id
     * @return array
     */
    public function get_free_plan_count($entry_id, $business_id) {
        $sql = <<<SQL
SELECT
   count(ep.plan_id) as count
FROM
    entry_plan AS ep
INNER JOIN
    mst_plan AS mp
ON
    mp.plan_id = ep.plan_id
AND mp.business_id = ep.business_id
WHERE
    mp.plan_type = :plan_type
AND ep.entry_id = :entry_id
AND mp.is_cancel_fee_required = :is_cancel_fee_required
AND ep.business_id = :business_id
SQL;

        $params = [
            'entry_id'               => $entry_id,
            'business_id'            => $business_id,
            'plan_type'              => PLAN_TYPE_LIST['DOMESTIC'],
            'is_cancel_fee_required' => FLG_OFF,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 契約IDを条件に申し込み－プラン情報を取得する
     *
     * @param int $contract_id
     * @param int $business_id
     * @param int $user_id
     * @return array
     */
    public function get_entry_plan_by_contract_id_for_rental($contract_id, $business_id, $user_id) {
        $sql = <<<SQL
SELECT
    ep.*,
    msd.ucl_account_type
FROM
    entry as e
INNER JOIN
    entry_plan AS ep
ON
    ep.entry_id = e.entry_id
AND ep.business_id = e.business_id
INNER JOIN
    mst_plan AS mp
ON
    mp.plan_id = ep.plan_id
AND mp.business_id = ep.business_id
INNER JOIN
    contract AS c
ON
    c.business_id = ep.business_id
AND c.entry_id = ep.entry_id
AND c.contract_id = :contract_id
AND c.user_id = :user_id
LEFT JOIN
    imei i
ON i.business_id = ep.business_id
AND i.contract_id = c.contract_id
LEFT JOIN
    mst_shipping_device msd
ON  msd.business_id = ep.business_id
AND msd.imei2 = i.imei
WHERE
    e.user_id = :user_id
AND e.business_id = :business_id
SQL;

        $params = [
            'contract_id' => $contract_id,
            'user_id'     => $user_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }
}
