<?php

/**
 * キャンペーンマスタテーブルのモデルクラス
 */
class Model_HumanLife_MstCampaign extends Model_CrudAbstract {
    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * プランIDから期間内で有効なキャンペーンを取得する
     *
     * @param int $business_id 事業者ID
     * @param int $plan_id プランID
     * @return array キャンペーンマスタ情報
     */
    public function get_active_campaign_by_plan_id($business_id, $plan_id) {
        $sql = <<<SQL
SELECT
    campaign_id
    ,business_id
    ,plan_id
    ,name
    ,campaign_start_datetime
    ,campaign_end_datetime
    ,apply_start_month_count
    ,apply_end_month_count
    ,discount_amount
    ,active_flg
    ,create_datetime
    ,create_user
    ,update_datetime
    ,update_user
FROM
    mst_campaign
WHERE
    business_id = :business_id
AND plan_id = :plan_id
AND active_flg = :active_flg
AND campaign_start_datetime <= NOW()
AND (campaign_end_datetime > NOW() OR campaign_end_datetime IS NULL)
AND external_service_set_id IS NULL
ORDER BY
    campaign_id
SQL;

        $param = [
            'business_id'  => $business_id,
            'plan_id' => $plan_id,
            'active_flg' => FLG_ON
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * キャンペーンマスタ情報の一覧を取得する
     *
     * @param integer $business_id 事業者ID
     * @return array キャンペーンマスタの連想配列。対象なしのときは空配列を返却する。
     */
    public static function get_mst_campaign_list($business_id) {

        // キャンペーンマスタを取得
        $query = <<<SQL
SELECT
    *
FROM
    mst_campaign
WHERE
    business_id = :business_id
    AND active_flg = :active_flg
    AND campaign_start_datetime <= NOW()
    AND (campaign_end_datetime > NOW() OR campaign_end_datetime IS NULL)
    AND sales_partner_id IS NULL
    AND external_service_set_id IS NULL
ORDER BY
    campaign_id
SQL;

        $param = [
            'business_id' => $business_id,
            'active_flg' => FLG_ON
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array();

        if (count($result) > 0) {

            // 配列のキーを「campaign_id」に入れ替える
            $resultTemp = [];
            $campaign_id_list = [];
            foreach ($result as $mstCampaign) {
                $resultTemp[$mstCampaign["campaign_id"]] = $mstCampaign;
                $campaign_id_list[] = $mstCampaign["campaign_id"];
            }
            $result = $resultTemp;
        }

        return parent::post_find($result);
    }

    /**
     * プランIDから期間内で有効なキャンペーンを取得する
     *
     * @param int $business_id 事業者ID
     * @param int $plan_id プランID
     * @return array キャンペーンマスタ情報
     */
    public function get_active_campaign_info_by_plan_id($business_id, $plan_id, $campaign_type) {
        $sql = <<<SQL
SELECT
    *
FROM
    mst_campaign
WHERE
    business_id = :business_id
AND plan_id = :plan_id
AND active_flg = :active_flg
AND campaign_type = :campaign_type
AND campaign_start_datetime <= NOW()
AND sales_partner_id IS NULL
AND external_service_set_id IS NULL
AND (campaign_end_datetime > NOW() OR campaign_end_datetime IS NULL)
ORDER BY
    campaign_id
SQL;
        $param = [
            'business_id'  => $business_id,
            'plan_id' => $plan_id,
            'active_flg' => FLG_ON,
            'campaign_type' => $campaign_type
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
}

    /**
     * キャンペーンマスタ別の一覧を取得する
     *
     * @param integer $business_id 事業者ID
     * @param array   $campaign_type キャンペーンタイプ
     * @return array キャンペーンマスタの連想配列。対象なしのときは空配列を返却する。
     */
    public static function get_mst_campaign_list_by_campaign_type($business_id, $campaign_type) {

        // キャンペーンマスタを取得
        $query = <<<SQL
SELECT
    *
FROM
    mst_campaign
WHERE
    business_id = :business_id
    AND active_flg = :active_flg
    AND campaign_start_datetime <= NOW()
    AND (campaign_end_datetime > NOW() OR campaign_end_datetime IS NULL)
    AND sales_partner_id IS NULL
    AND external_service_set_id IS NULL
    AND campaign_type IN :campaign_type
ORDER BY
    campaign_id
SQL;

        $param = [
            'business_id' => $business_id,
            'active_flg' => FLG_ON,
            'campaign_type' => $campaign_type,
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array();

        if (count($result) > 0) {

            // 配列のキーを「campaign_id」に入れ替える
            $resultTemp = [];
            $campaign_id_list = [];
            foreach ($result as $mstCampaign) {
                $resultTemp[$mstCampaign["campaign_id"]] = $mstCampaign;
                $campaign_id_list[] = $mstCampaign["campaign_id"];
            }
            $result = $resultTemp;
        }

        return parent::post_find($result);
    }

    /**
     * キャンペーンマスタ情報の一覧を取得する(法人)
     *
     * @param integer $business_id 事業者ID
     * @return array キャンペーンマスタの連想配列。対象なしのときは空配列を返却する。
     */
    public static function get_company_mst_campaign_list($business_id) {

        // キャンペーンマスタを取得
        $query = <<<SQL
SELECT
    *
FROM
    mst_campaign
WHERE
    business_id = :business_id
    AND active_flg = :active_flg
    AND campaign_start_datetime <= NOW()
    AND (campaign_end_datetime > NOW() OR campaign_end_datetime IS NULL)
    AND sales_partner_id IS NULL
    AND external_service_set_id IS NULL
    AND campaign_type IN :campaign_type
ORDER BY
    campaign_id
SQL;

        $param = [
            'business_id' => $business_id,
            'active_flg' => FLG_ON,
            'campaign_type' => [CAMPAIGN_TYPE_ALL],
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array();

        if (count($result) > 0) {

            // 配列のキーを「campaign_id」に入れ替える
            $resultTemp = [];
            $campaign_id_list = [];
            foreach ($result as $mstCampaign) {
                $resultTemp[$mstCampaign["campaign_id"]] = $mstCampaign;
                $campaign_id_list[] = $mstCampaign["campaign_id"];
            }
            $result = $resultTemp;
        }

        return parent::post_find($result);
    }

    /**
     * キャンペーンマスタ情報の一覧を取得する
     *
     * @param integer $business_id 事業者ID
     * @return array キャンペーンマスタの連想配列。対象なしのときは空配列を返却する。
     */
    public static function get_mst_sales_partner_campaign_list($business_id, $sales_partner_id) {

        // キャンペーンマスタを取得
        $query = <<<SQL

SELECT
    *
FROM
    mst_campaign
WHERE
    business_id = :business_id
    AND active_flg = :active_flg
    AND campaign_start_datetime <= NOW()
    AND (campaign_end_datetime > NOW() OR campaign_end_datetime IS NULL)
    AND sales_partner_id = :sales_partner_id
ORDER BY
    campaign_id
SQL;

        $param = [
            'business_id' => $business_id,
            'active_flg' => FLG_ON,
            'sales_partner_id' => $sales_partner_id,
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array();

        if (count($result) > 0) {

            // 配列のキーを「campaign_id」に入れ替える
            $resultTemp = [];
            $campaign_id_list = [];
            foreach ($result as $mstCampaign) {
                $resultTemp[$mstCampaign["campaign_id"]] = $mstCampaign;
                $campaign_id_list[] = $mstCampaign["campaign_id"];
            }
            $result = $resultTemp;
        }
        return parent::post_find($result);
    }

    /**
     * キャンペーンマスタ情報の一覧を取得する(セット販売)
     *
     * @param integer $business_id 事業者ID
     * @return array キャンペーンマスタの連想配列。対象なしのときは空配列を返却する。
     */
    public static function get_mst_external_service_set_campaign_list($business_id, $external_service_set_id) {

        // キャンペーンマスタを取得
        $query = <<<SQL

SELECT
    *
FROM
    mst_campaign
WHERE
    business_id = :business_id
    AND active_flg = :active_flg
    AND campaign_start_datetime <= NOW()
    AND (campaign_end_datetime > NOW() OR campaign_end_datetime IS NULL)
    AND external_service_set_id = :external_service_set_id
ORDER BY
    campaign_id
SQL;

        $param = [
            'business_id' => $business_id,
            'active_flg' => FLG_ON,
            'external_service_set_id' => $external_service_set_id,
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array();

        if (count($result) > 0) {

            // 配列のキーを「campaign_id」に入れ替える
            $resultTemp = [];
            $campaign_id_list = [];
            foreach ($result as $mstCampaign) {
                $resultTemp[$mstCampaign["campaign_id"]] = $mstCampaign;
                $campaign_id_list[] = $mstCampaign["campaign_id"];
            }
            $result = $resultTemp;
        }
        return parent::post_find($result);
    }
    /**
     * プラン変更時に適用できるキャンペーンマスタの一覧を取得する
     *
     * @param integer $business_id 事業者ID
     * @return array キャンペーンマスタの連想配列。対象なしのときは空配列を返却する。
     */
    public static function get_mst_campaign_list_for_plan_change($business_id) {

        // キャンペーンマスタを取得
        $query = <<<SQL
SELECT
    rp.mst_plan_change_rule_id, mc.*
FROM
    rel_plan_change_rule_campaign AS rp
INNER JOIN mst_campaign mc ON 
    rp.campaign_id = mc.campaign_id 
WHERE
    mc.business_id = :business_id
ORDER BY
    rp.mst_plan_change_rule_id,mc.campaign_id
SQL;

        $param = [
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array();

        if (count($result) > 0) {

            // 配列のキーを「mst_plan_change_rule_id」と「campaign_id」に入れ替える
            $resultTemp = [];
            $campaign_id_list = [];
            foreach ($result as $mstCampaign) {
                $resultTemp[$mstCampaign["mst_plan_change_rule_id"]][$mstCampaign["campaign_id"]]= $mstCampaign;
            }
            $result = $resultTemp;
        }

        return parent::post_find($result);
    }

    /**
     * プランID+オプションIDから期間内で有効なオプションキャンペーンを取得する
     *
     * @param int $business_id 事業者ID
     * @param int $plan_id プランID
     * @param int $option_id オプションID
     * @return array キャンペーンマスタ情報
     */
    public function get_active_option_campaign_info_by_plan_id($business_id, $plan_id, $option_id) {
        $sql = <<<SQL
SELECT
    * 
FROM
    mst_campaign 
WHERE
    business_id = :business_id 
    AND plan_id = :plan_id 
    AND option_id = :option_id 
    AND active_flg = :active_flg 
    AND campaign_start_datetime <= NOW() 
    AND ( 
        campaign_end_datetime > NOW() 
        OR campaign_end_datetime IS NULL
    ) 
ORDER BY
    campaign_id
SQL;

        $param = [
            'business_id'  => $business_id,
            'plan_id' => $plan_id,
            'option_id' => $option_id,
            'active_flg' => FLG_ON,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * プラン区分からキャンペーン情報を取得する
     *
     * @param int $business_id 事業者ID
     * @param array $plan_type_arr プラン区分の配列
     * @param array $campaign_type_arr キャンペーン区分の配列
     * @return array キャンペーンマスタ情報
     */
    public static function get_campaign_info_by_plan_type($business_id, $plan_type_arr, $campaign_type_arr) {
        $sql = <<<SQL
SELECT
    mc.campaign_id
    , mc.plan_id
    , mc.discount_amount
    , mc.confirm_display_name
    , mc.apply_start_month_count
    , mc.apply_end_month_count
FROM
    mst_campaign mc
    INNER JOIN mst_plan mp
        ON mc.business_id = mp.business_id
        AND mc.plan_id = mp.plan_id
WHERE
    mc.business_id = :business_id
    AND mc.active_flg = :active_flg
    AND mc.campaign_start_datetime <= NOW()
    AND (
        mc.campaign_end_datetime > NOW()
        OR mc.campaign_end_datetime IS NULL
    )
    AND mc.sales_partner_id IS NULL
    AND mc.external_service_set_id IS NULL
    AND mc.campaign_type IN :campaign_type
    AND mp.plan_type IN :plan_type
ORDER BY
    mp.campaign_id
SQL;

        $param = [
            'business_id'  => $business_id,
            'campaign_type' => $campaign_type_arr,
            'plan_type' => $plan_type_arr,
            'active_flg' => FLG_ON,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

}
