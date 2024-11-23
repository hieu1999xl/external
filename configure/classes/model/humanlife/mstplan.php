<?php

/**
 * プランマスタテーブルのモデルクラス
 */
class Model_HumanLife_MstPlan extends Model_CrudAbstract {
    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * 海外プラン一覧を取得する
     *
     * @param int  $business_id
     * @param bool $is_prepaid true:CHARGEプラン(プリペイド) false:国内プラン向け海外プラン
     * @return array
     */
    public function get_international_plan_info_list($business_id, $is_prepaid) {
        $sql = <<<SQL
SELECT
    plan_id
  , plan_type
  , goods_id
  , name AS plan_name
  , price AS plan_price
  , tax_type
  , billing_type
FROM
    mst_plan
WHERE
    business_id = :business_id
AND plan_type IN :international_plan_type_list
AND sale_start_date <= NOW()
AND (sale_end_date > NOW() OR sale_end_date IS NULL)
ORDER BY
    disp_order
SQL;

        $param = [
            'business_id'                  => $business_id,
            'international_plan_type_list' => ($is_prepaid) ? INTERNATIONAL_PREPAID_PLAN_TYPE_LIST : INTERNATIONAL_PLAN_TYPE_LIST,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 大州・国名を含む海外プラン一覧を取得する（プラン区分指定対応）
     *
     * @param  int  $business_id
     * @param  bool $is_prepaid true:CHARGEプラン(プリペイド) false:国内プラン向け海外プラン
     * @return array
     */
    public function get_international_plan_list($business_id, $is_prepaid) {
        $sql = <<<SQL
SELECT mcp.plan_id, mp.name, mp.price, mcp.continent_name, mcp.country_name, mp.plan_type
FROM mst_plan AS mp
INNER JOIN mst_continent_plan AS mcp ON mp.plan_id = mcp.plan_id
WHERE mp.plan_type IN :international_plan_type_list AND
        mp.business_id = :business_id AND
        mcp.business_id = :business_id AND
        mp.sale_start_date <= NOW() AND
        (mp.sale_end_date > NOW() OR mp.sale_end_date IS NULL)
ORDER BY mcp.country_name, mcp.plan_id;
SQL;

        $param = [
            'business_id'                  => $business_id,
            'international_plan_type_list' => ($is_prepaid) ? INTERNATIONAL_PREPAID_PLAN_TYPE_LIST : INTERNATIONAL_PLAN_TYPE_LIST,
        ];

        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * 大州・国名を含む海外レンタルプラン一覧を取得する（プラン区分指定対応）
     * TODO : mst_plan_market_priceをjoinしているので、要確認
     * @param int   $business_id
     * @param array $plan_type_list
     * @return array
     */
    public function get_international_plan_list_by_plan_type($business_id, $plan_type_list) {
        $sql = <<<SQL
SELECT
    mcp.plan_id
    , mp.name
    , mp.price
    , mp.plan_type
    , mcp.continent_name
    , mcp.country_name
FROM
    mst_plan AS mp
    INNER JOIN mst_continent_plan AS mcp
        ON mp.business_id = mcp.business_id
        AND mp.plan_id = mcp.plan_id
WHERE
    mp.plan_type IN :plan_type_list
    AND mp.business_id = :business_id
    AND mp.sale_start_date <= NOW()
    AND (
        mp.sale_end_date > NOW()
        OR mp.sale_end_date IS NULL
    )
ORDER BY
    mcp.continent_name
    , mcp.country_name
    , mcp.plan_id
SQL;

        $param = [
            'business_id'    => $business_id,
            'plan_type_list' => $plan_type_list,
        ];

        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * 大州・国名を含む海外レンタルプラン一覧を取得する（プラン区分指定対応）
     *
     * @param  int    $business_id
     * @param  array  $plan_type_list
     * @param  int    $market_id
     * @param  int    $version
     * @return array
     */
    public function get_international_plan_list_by_plan_type_and_market_id($business_id, $plan_type_list, $market_id, $version) {
        $sql = <<<SQL
SELECT
    mcp.plan_id
    , mpmp.name
    , mpmp.price
    , mp.plan_type
    , mcp.continent_name
    , mcp.country_name
FROM
    mst_plan AS mp
    INNER JOIN mst_continent_plan AS mcp
        ON mp.business_id = mcp.business_id
        AND mp.plan_id = mcp.plan_id
    INNER JOIN mst_plan_market_price AS mpmp
        ON mp.business_id = mpmp.business_id
        AND mp.plan_id = mpmp.plan_id
WHERE
    mp.plan_type IN :plan_type_list
    AND mp.business_id = :business_id
    AND mp.sale_start_date <= NOW()
    AND (
        mp.sale_end_date > NOW()
        OR mp.sale_end_date IS NULL
    )
    AND mpmp.market_id = :market_id

SQL;


        $param = [
            'business_id'    => $business_id,
            'plan_type_list' => $plan_type_list,
            'market_id'      => $market_id,
        ];

        if (!empty($version)) {
            $param['version'] = $version;
            $sql .= <<<SQL
    AND mpmp.version = :version

SQL;
        }
    $sql .= <<<SQL
ORDER BY
    mcp.continent_name
    , mcp.country_name
    , mcp.plan_id
SQL;


        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * 大州・国名を含む海外レンタルプラン(価格変動タイプ)一覧を取得する（プラン区分指定対応）
     *
     * @param int   $business_id
     * @param array $plan_type_list
     * @return array
     */
    public function get_international_sp_plan_list_by_plan_type($business_id, $plan_type_list) {
        $sql = <<<SQL
SELECT
    mcp.plan_id
    , mp.name
    , mp.price AS regular_price
    , mpmp.price
    , mp.plan_type
    , mcp.continent_name
    , mcp.country_name
FROM
    mst_plan AS mp
    INNER JOIN mst_continent_plan AS mcp
        ON mp.business_id = mcp.business_id
        AND mp.plan_id = mcp.plan_id
    INNER JOIN mst_plan_market_price AS mpmp
        ON mp.business_id = mpmp.business_id
        AND mp.plan_id = mpmp.plan_id
WHERE
    mp.plan_type IN :plan_type_list
    AND mp.business_id = :business_id
    AND mpmp.sale_start_date <= NOW()
    AND (
        mpmp.sale_end_date > NOW()
        OR mpmp.sale_end_date IS NULL
    )
ORDER BY
    mcp.continent_name
    , mcp.country_name
    , mp.disp_order

SQL;

        $param = [
            'business_id'    => $business_id,
            'plan_type_list' => $plan_type_list,
        ];

        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * 大州・国名を含む海外レンタル周遊プラン一覧を取得する
     *
     * @param int   $business_id
     * @param array $plan_type_list
     * @return array
     */
    public function get_international_plan_list_for_tour_by_plan_type($business_id, $plan_type_list) {
        $sql = <<<SQL
SELECT
    mcp.plan_id
    , mp.name
    , mp.price
    , mp.plan_type
    , mcp.continent_name
    , mcp.country_name
FROM
    mst_plan AS mp
    INNER JOIN mst_continent_plan AS mcp
        ON mp.business_id = mcp.business_id
        AND mp.plan_id = mcp.plan_id
WHERE
    mp.plan_type IN :plan_type_list
    AND mp.plan_id IN :plan_id_list
    AND mp.business_id = :business_id
    AND mp.sale_start_date <= NOW()
    AND (
        mp.sale_end_date > NOW()
        OR mp.sale_end_date IS NULL
    )
ORDER BY
    mcp.continent_name
    , mcp.country_name
    , mcp.plan_id
SQL;

        $param = [
            'business_id'    => $business_id,
            'plan_id_list'   => INTERNATIONAL_RENTAL_TOUR_PLAN_LIST,
            'plan_type_list' => $plan_type_list,
        ];

        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * 大州・国名を含む海外レンタル周遊プラン一覧を取得する
     *
     * @param int   $business_id
     * @param array $plan_type_list
     * @param  int    $market_id
     * @param  int    $version
     * @return array
     */
    public function get_international_plan_list_for_tour_by_plan_type_and_market_id($business_id, $plan_type_list, $market_id, $version) {
        $sql = <<<SQL
SELECT
    mcp.plan_id
    , mpmp.name
    , mpmp.price
    , mp.plan_type
    , mcp.continent_name
    , mcp.country_name
FROM
    mst_plan AS mp
    INNER JOIN mst_continent_plan AS mcp
        ON mp.business_id = mcp.business_id
        AND mp.plan_id = mcp.plan_id
    INNER JOIN mst_plan_market_price AS mpmp
        ON mp.business_id = mpmp.business_id
        AND mp.plan_id = mpmp.plan_id
WHERE
    mp.plan_type IN :plan_type_list
    AND mp.plan_id IN :plan_id_list
    AND mp.business_id = :business_id
    AND mp.sale_start_date <= NOW()
    AND (
        mp.sale_end_date > NOW()
        OR mp.sale_end_date IS NULL
    )
    AND mpmp.market_id = :market_id

SQL;

        $param = [
            'business_id'    => $business_id,
            'plan_id_list'   => INTERNATIONAL_RENTAL_TOUR_PLAN_LIST,
            'plan_type_list' => $plan_type_list,
            'market_id'      => $market_id,
        ];

        if (!empty($version)) {
            $param['version'] = $version;
            $sql .= <<<SQL
    AND mpmp.version = :version

SQL;
        }
    $sql .= <<<SQL
ORDER BY
    mcp.continent_name
    , mcp.country_name
    , mcp.plan_id
SQL;
        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * CHARGEプラン(プリペイド)向けの国内チャージを取得する
     *
     * @param int $business_id
     * @return array
     */
    public function get_data_charge_international_plan_info_list($business_id) {
        $sql = <<<SQL
SELECT
    plan_id
  , plan_type
  , goods_id
  , name AS plan_name
  , price AS plan_price
  , tax_type
  , billing_type
FROM
    mst_plan
WHERE
    business_id = :business_id
AND plan_type = :domestic_data_charge_plan_type
AND sale_start_date <= NOW()
AND (sale_end_date > NOW() OR sale_end_date IS NULL)
ORDER BY
    disp_order
SQL;

        $param = [
            'business_id'                    => $business_id,
            'domestic_data_charge_plan_type' => PLAN_TYPE_INTERNATIONAL_PREPAID_DOMESTIC,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * データチャージプラン一覧を取得する
     *
     * @param int $business_id
     * @return array
     */
    public function get_data_charge_plan_info_list($business_id) {
        $sql = <<<SQL
SELECT
    plan_id
  , plan_type
  , goods_id
  , name AS plan_name
  , price AS plan_price
  , tax_type
  , billing_type
FROM
    mst_plan
WHERE
    business_id = :business_id
AND plan_type = :domestic_data_charge_plan_type
AND sale_start_date <= NOW()
AND (sale_end_date > NOW() OR sale_end_date IS NULL)
ORDER BY
    disp_order
SQL;

        $param = [
            'business_id'                    => $business_id,
            'domestic_data_charge_plan_type' => PLAN_TYPE_LIST['DOMESTIC_DATA_CHARGE'],
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * プラン情報を取得する(market_idとversionに対応)
     *
     * @param int $plan_id
     * @param int $business_id
     * @param int $market_id
     * @param int $version
     * @return array
     */
    public function get_overseas_rental_plan_info($plan_id, $business_id, $market_id, $version) {
        $sql = <<<SQL
SELECT
    mp.plan_id,
    mp.plan_type,
    mp.goods_id,
    mp.goods_id_maya,
    mp.goods_id_maya_transit,
    mp.name,
    mp.price,
    mp.tax_type,
    mp.billing_type,
    mp.data_usage_limit,
    mp.pay_as_you_go_daily_price,
    mp.is_cancel_fee_required,
    mp.pay_as_you_go_type,
    mpmp.price AS market_price,
    mpmp.name AS market_name
FROM
    mst_plan AS mp
LEFT JOIN mst_plan_market_price AS mpmp
    ON mp.plan_id = mpmp.plan_id
WHERE
    mp.plan_id = :plan_id
AND
    mp.business_id = :business_id
AND
    mp.sale_start_date <= NOW()
AND
    (mp.sale_end_date > NOW() OR mp.sale_end_date IS NULL)
SQL;
        if (!empty($market_id)) {
    $sql .= <<<SQL
AND
    mpmp.market_id = :market_id
AND
    mpmp.version = :version
SQL;
        }

        $param = [
            'plan_id'     => $plan_id,
            'business_id' => $business_id,
        ];

        $param['market_id'] = empty($market_id) ? null : $market_id;
        $param['version'] = empty($version) ? null : $version;

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * プラン情報を取得する
     *
     * @param int $plan_id
     * @param int $business_id
     * @return array
     */
    public function get_plan_info($plan_id, $business_id) {
        $sql = <<<SQL
SELECT
    plan_id,
    plan_type,
    goods_id,
    goods_id_maya,
    goods_id_maya_transit,
    name,
    price,
    tax_type,
    billing_type,
    data_usage_limit,
    pay_as_you_go_daily_price,
    is_cancel_fee_required,
    pay_as_you_go_type
FROM
    mst_plan
WHERE
    plan_id = :plan_id
AND
    business_id = :business_id
AND
    sale_start_date <= NOW()
AND
    (sale_end_date > NOW() OR sale_end_date IS NULL)
SQL;

        $param = [
            'plan_id'     => $plan_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 海外プラン情報を取得する
     *
     * @param int $international_plan_id
     * @param int $business_id
     * @return array
     */
    public function get_international_plan_info($international_plan_id, $business_id) {
        $sql = <<<SQL
SELECT
    plan_id
  , plan_type
  , goods_id
  , name
  , price
  , tax_type
  , billing_type
FROM
    mst_plan
WHERE
    plan_id = :international_plan_id
AND business_id = :business_id
AND plan_type IN :international_plan_type_list
AND sale_start_date <= NOW()
AND (sale_end_date > NOW() OR sale_end_date IS NULL)
SQL;

        $param = [
            'international_plan_id'        => $international_plan_id,
            'business_id'                  => $business_id,
            'international_plan_type_list' => INTERNATIONAL_PLAN_TYPE_LIST,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * データチャージプラン情報を取得する
     *
     * @param int $data_charge_plan_id
     * @param int $business_id
     * @return array
     */
    public function get_data_charge_plan_info($data_charge_plan_id, $business_id) {
        $sql = <<<SQL
SELECT
    plan_id
  , plan_type
  , goods_id
  , name
  , price
  , tax_type
  , billing_type
FROM
    mst_plan
WHERE
    plan_id = :data_charge_plan_id
AND business_id = :business_id
AND plan_type IN :data_charge_plan_type_list
AND sale_start_date <= NOW()
AND (sale_end_date > NOW() OR sale_end_date IS NULL)
SQL;

        $param = [
            'data_charge_plan_id'        => $data_charge_plan_id,
            'business_id'                => $business_id,
            'data_charge_plan_type_list' => DATA_CHARGE_PLAN_TYPE_LIST,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 海外プラン用データチャージ・海外プラン情報を取得する
     *
     * @param int $data_charge_plan_id
     * @param int $business_id
     * @return array
     */
    public function get_data_charge_plan_info_for_international_plan($data_charge_plan_id, $business_id) {
        $sql = <<<SQL
SELECT
    plan_id
  , plan_type
  , goods_id
  , name
  , price
  , tax_type
  , billing_type
FROM
    mst_plan
WHERE
    plan_id = :data_charge_plan_id
AND business_id = :business_id
AND plan_type IN :data_charge_plan_type_list
AND sale_start_date <= NOW()
AND (sale_end_date > NOW() OR sale_end_date IS NULL)
SQL;

        $param = [
            'data_charge_plan_id'        => $data_charge_plan_id,
            'business_id'                => $business_id,
            'data_charge_plan_type_list' => DATA_CHARGE_INTERNATIONAL_PLAN_TYPE_LIST,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * プランマスタ情報の一覧を取得する
     *
     * @param integer $business_id 事業者ID
     * @param array $plan_id_list プランIDの配列
     * @return array プランマスタとプラン初期費用マスタの連想配列。対象なしのときは空配列を返却する。
     */
    public static function get_mst_plan_list($business_id, $plan_id_list = []) {

        // プランマスタを取得
        if (empty($plan_id_list)) {
            $query = <<<SQL
                SELECT
                    *
                FROM
                    mst_plan
                WHERE
                    business_id = :business_id
                    AND sale_start_date <= NOW()
                    AND (sale_end_date > NOW() OR sale_end_date IS NULL)
                ORDER BY
                    disp_order
            SQL;
        } else {
            $plan_id_list_str = implode(",", $plan_id_list);
            $query = <<<SQL
                SELECT
                    *
                FROM
                    mst_plan
                WHERE
                    business_id = :business_id
                    AND sale_start_date <= NOW()
                    AND (sale_end_date > NOW() OR sale_end_date IS NULL)
                    AND plan_id IN ($plan_id_list_str)
                ORDER BY
                    disp_order
            SQL;
        }

        $param = [
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array();
        if (count($result) > 0) {

            // 配列のキーを「plan_id」に入れ替える
            $resultTemp = [];
            $plan_id_list = [];
            foreach ($result as $mstPlan) {
                $resultTemp[$mstPlan["plan_id"]] = $mstPlan;
                $resultTemp[$mstPlan["plan_id"]]["mst_plan_init"] = [];
                $plan_id_list[] = $mstPlan["plan_id"];
            }
            $result = $resultTemp;
        }

        return parent::post_find($result);
    }


    /**
     * プラン区分をキーにしてプランマスタ情報の一覧を取得する
     *
     * @param integer $business_id 事業者ID
     * @param array $plan_type_list プラン区分の配列
     * @return array プランマスタ情報
     */
    public static function get_mst_plan_list_by_plan_type($business_id, $plan_type_list) {
        // プランマスタを取得
        $query = <<<SQL
SELECT
    plan_id
    , name
    , price
    , billing_type
    , tax_type
FROM
    mst_plan
WHERE
    business_id = :business_id
    AND sale_start_date <= NOW()
    AND (sale_end_date > NOW() OR sale_end_date IS NULL)
    AND plan_type IN :plan_type
ORDER BY
    disp_order
SQL;

        $param = [
            'business_id' => $business_id,
            'plan_type' => $plan_type_list
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array('plan_id');
        return parent::post_find($result);
    }

    /**
     * プラン区分をキーにしてプランマスタ・プラン市価マスタ情報の一覧を取得する（海外レンタル）
     *
     * @param integer $business_id 事業者ID
     * @param integer $market_id マーケットID 1:価格com 2:海外WiFiレンタル比較ナビ
     * @param array $plan_type_list プラン区分の配列
     * @return array プランマスタ情報
     */
    public static function get_mst_plan_market_price_list_by_plan_type($business_id, $market_id, $plan_type_list) {
        // プランマスタを取得
        $query = <<<SQL
SELECT
    mpmp.market_price_id
    , mp.plan_id
    , mpmp.name
    , mpmp.price
    , mp.billing_type
    , mp.tax_type
FROM
    mst_plan AS mp
    INNER JOIN mst_plan_market_price AS mpmp
        ON mp.business_id = mpmp.business_id
        AND mp.plan_id = mpmp.plan_id
WHERE
    mp.business_id = :business_id
    AND mpmp.sale_start_date <= NOW()
    AND (mpmp.sale_end_date > NOW() OR mpmp.sale_end_date IS NULL)
    AND plan_type IN :plan_type
    AND market_id = :market_id
ORDER BY
    disp_order
SQL;

        $param = [
            'business_id' => $business_id,
            'plan_type' => $plan_type_list,
            'market_id' => $market_id
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array('plan_id');
        return parent::post_find($result);
    }

    /**
     * 契約中のプランがデータチャージ可能かどうかをチェックする
     *
     * @param int $user_id
     * @return array 検索結果
     */
    public function get_can_charge_data($user_id){

            $sql = <<<SQL
SELECT
    mst.can_charge_data
FROM
    contract AS c
LEFT JOIN
    rel_contract_plan AS cp
ON
    c.contract_id = cp.contract_id
LEFT JOIN
    mst_plan  AS mst
ON
    cp.plan_id = mst.plan_id
WHERE
    c.user_id = :user_id
AND
   c.delete_flag = 0
AND
   cp.delete_flag = 0
AND
   cp.plan_start_date is NOT NULL
AND
   cp.plan_end_date is NULL
AND
   mst.can_charge_data = 1
SQL;
            $param = [
                'user_id' => $user_id,
            ];

            parent::pre_find($query);
            $result = DB::query($sql)->parameters($param)->execute()->as_array();
            return parent::post_find($result);
        }

    /**
     * mst_planから条件付きで取得する
     * @param array $params 取得パラム名の配列
     * @param array $where  取得条件['パラム名' => 値]の配列 (=のみ)
     * @param boolean $is_get_delete 削除フラグつきを取得する場合true
     * @return array
     */
    public function get_record($params = ['*'], $wheres = [], $is_get_delete = false){
        $query = DB::select_array($params)->from('mst_plan')->order_by('disp_order');
        foreach($wheres as $param_name => $value){
            $query->where($param_name, $value);
        }
        if(!$is_get_delete){
            $query->where('delete_flag', FLG_OFF);
        }
        return $query->execute()->as_array('plan_id');
    }

    /**
     * 顧客IDからプラン情報を取得する
     *
     * @param int $business_id
     * @param int $user_id
     *
     * @return array
     */
    public function get_plan_info_by_user_id($business_id, $user_id)
    {
        $query = DB::select(
            'e.user_id',
            'e.entry_id',
            'e.rental_days',
            'mp.plan_id',
            ['mp.name', 'plan_name'],
            'mp.plan_type',
            'mp.device_type',
            'mp.data_usage_limit',
        )
        ->from(['entry', 'e'])
        ->join(['entry_plan', 'ep'])
            ->on('e.business_id', '=', 'ep.business_id')
            ->on('e.entry_id', '=', 'ep.entry_id')
        ->join(['mst_plan', 'mp'])
            ->on('ep.business_id', '=', 'mp.business_id')
            ->on('ep.plan_id', '=', 'mp.plan_id')
        ->where('e.business_id', $business_id)
        ->where('e.user_id', $user_id);

        return $query->execute()->as_array();
    }

    /**
     * 海外プラン情報を取得する
     *
     * @param int $international_plan_id
     * @param int $business_id
     * @return array
     */
    public function get_international_rental_plan_info($international_plan_id, $business_id) {
        $sql = <<<SQL
SELECT
    plan_id
  , plan_type
  , goods_id
  , name
  , price
  , tax_type
  , billing_type
  , data_usage_limit
FROM
    mst_plan
WHERE
    plan_id = :international_plan_id
AND business_id = :business_id
AND plan_type = :international_plan_type
AND sale_start_date <= NOW()
AND (sale_end_date > NOW() OR sale_end_date IS NULL)
SQL;

        $param = [
            'international_plan_id'   => $international_plan_id,
            'business_id'             => $business_id,
            'international_plan_type' => PLAN_TYPE_INTERNATIONAL_RENTAL,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 海外レンタルプラン情報を取得する
     *
     * @param array $plan_id_list
     * @param int   $business_id
     * @return array
     */
    public function get_international_rental_plan_info_list($plan_id_list, $business_id) {
        $sql = <<<SQL
SELECT
    mp.plan_id
  , mp.name as plan_name
  , mp.price
  , mp.data_usage_limit
  , mcp.continent_name
  , mcp.country_name
FROM
    mst_plan as mp
LEFT JOIN
    mst_continent_plan as mcp
ON  mcp.plan_id = mp.plan_id
AND mcp.business_id = mp.business_id
WHERE
    mp.plan_id IN :international_plan_id_list
AND mp.business_id = :business_id
AND mp.plan_type = :international_plan_type
AND mp.sale_start_date <= NOW()
AND (mp.sale_end_date > NOW() OR mp.sale_end_date IS NULL)
ORDER BY mp.disp_order
SQL;

        $param = [
            'international_plan_id_list'   => $plan_id_list,
            'business_id'                  => $business_id,
            'international_plan_type'      => PLAN_TYPE_INTERNATIONAL_RENTAL,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 海外レンタルプラン情報を取得する
     *
     * @param array $plan_id_list
     * @param int   $business_id
     * @param int   $market_id
     * @param int   $version
     * @return array
     */
    public function get_international_rental_plan_info_list_by_market_id($plan_id_list, $business_id, $market_id, $version) {
        $sql = <<<SQL
SELECT
    mp.plan_id
  , mpmp.name as plan_name
  , mpmp.price
  , mp.data_usage_limit
  , mcp.continent_name
  , mcp.country_name
FROM
    mst_plan as mp
LEFT JOIN
    mst_continent_plan as mcp
ON  mcp.plan_id = mp.plan_id
AND mcp.business_id = mp.business_id
LEFT JOIN
    mst_plan_market_price as mpmp
ON  mpmp.plan_id = mp.plan_id
AND mcp.business_id = mp.business_id
WHERE
    mp.plan_id IN :international_plan_id_list
AND mp.business_id = :business_id
AND mp.plan_type = :international_plan_type
AND mp.sale_start_date <= NOW()
AND (mp.sale_end_date > NOW() OR mp.sale_end_date IS NULL)
AND mpmp.market_id = :market_id
AND mpmp.version = :version
SQL;

        $param = [
            'international_plan_id_list'   => $plan_id_list,
            'business_id'                  => $business_id,
            'international_plan_type'      => PLAN_TYPE_INTERNATIONAL_RENTAL,
            'market_id'                    => $market_id,
            'version'                      => $version,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 国名からプランの情報を取得する
     * @param  string $continent_name
     * @param  string $country_name
     * @param  array  $plan_type
     * @return array
     */
    public function get_prepaid_plan_info_by_country_name($continent_name, $country_name, $plan_type) {
        $sql = <<<SQL
SELECT mp.*,
       mcp.continent_name,
       mcp.country_name
FROM mst_plan AS mp
LEFT JOIN mst_continent_plan AS mcp
    ON mp.plan_id = mcp.plan_id AND mp.business_id = mcp.business_id
WHERE mp.plan_type IN :plan_type AND
      mcp.continent_name = :continent_name AND
      mcp.country_name = :country_name AND
      mp.business_id = :business_id
SQL;
        $param = [
            'business_id'  => BUSINESS_ID,
            'plan_type'    => $plan_type,
            'continent_name' => $continent_name,
            'country_name' => $country_name,
        ];
        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }
}
