<?php

/**
 * 端末マスタのモデルクラス
 *
 * @author tanabe
 */

class Model_HumanLife_MstDevice extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     */
    protected static $_table_name = 'mst_device';

    /**
     * プライマリキー
     * @var String
     */
    protected static $_primary_key = 'device_id';

    /**
     * 端末マスタ情報の一覧を取得する
     *
     * @param integer $business_id 事業者ID
     * @param array $device_type 端末タイプ
     * @return array 端末マスタの連想配列。対象なしのときは空配列を返却する。
     */
    public static function get_mst_device_list($business_id, $device_type) {

        // 端末マスタを取得
        $query = <<<SQL
            SELECT
                *
            FROM
                mst_device
            WHERE
                business_id = :business_id
                AND device_type = :device_type
                AND sale_start_date <= NOW()
                AND (sale_end_date > NOW() OR sale_end_date IS NULL)
            ORDER BY
                disp_order
        SQL;

        $param = [
            'business_id' => $business_id,
            'device_type' => $device_type,
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array();
        if (count($result) > 0) {

            // 配列のキーを「device_id」に入れ替える
            $resultTemp = [];
            $device_id_list = [];
            foreach ($result as $mstDevice) {
                $resultTemp[$mstDevice["device_id"]] = $mstDevice;
                $resultTemp[$mstDevice["device_id"]]["mst_device_init"] = [];
                $device_id_list[] = $mstDevice["device_id"];
            }
            $result = $resultTemp;

            // 初期費用マスタを取得
            $device_id_list_str = implode(",", $device_id_list);
            $query = <<<SQL
                SELECT
                    *
                FROM
                    mst_device_init
                WHERE
                    device_id IN ($device_id_list_str)
                ORDER BY
                    disp_order
            SQL;

            $param = [
            ];

            parent::pre_find($query);
            $resultInit = DB::query($query)->parameters($param)->execute()->as_array();
            foreach ($resultInit as $mstDeviceInit) {
                $result[$mstDeviceInit["device_id"]]["mst_device_init"][] = $mstDeviceInit;
            }
        }

        return parent::post_find($result);
    }

    /**
     * 端末IDをキーにして端末マスタ情報の一覧を取得する
     *
     * @param integer $business_id 事業者ID
     * @param array $device_id_list 端末IDの配列
     * @return array 端末マスタの連想配列。対象なしのときは空配列を返却する。
     */
    public static function get_mst_device_list_by_device_id($business_id, $device_id_list) {
        $query = <<<SQL
SELECT
    device_id
    , device_type
    , name
    , image_path
    , color
    , charge
    , division_month
    , tax_type
    , billing_type
    , ucl_account_type
    , item_code
FROM
    mst_device
WHERE
    business_id = :business_id
    AND device_id in :device_id_list
    AND sale_start_date <= NOW()
    AND (sale_end_date > NOW() OR sale_end_date IS NULL)
    AND delete_flag = :delete_flag
ORDER BY
    disp_order
SQL;

        $param = [
            'business_id' => $business_id,
            'device_id_list' => $device_id_list,
            'delete_flag' => FLG_OFF,
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array('device_id');
        return parent::post_find($result);
    }

    /**
     * プライマリキーで1件取得
     *
     * @param int  $id
     * @param array $select 取得カラム
     * @param array 検索結果1件
     */
    public function get_mst_device_by_id($id, $select = ['*']) {
        $query = DB::select_array($select)->from(self::$_table_name)->where('business_id', BUSINESS_ID)->where(self::$_primary_key, $id);
        return $query->execute()->current();
    }

    /**
     * アイテムコード、色、分割回数で端末を特定する
     *
     * @param array $param
     * @param array 検索結果1件
     */
    public function get_mst_device_by_payment($param) {
        $query = <<<SQL
SELECT
    device_id
    , charge
    , division_month
FROM
    mst_device
WHERE
    business_id = :business_id
    AND item_code = :item_code
    AND color = :color
    AND division_month = :division_month
SQL;

        $params = [
            'business_id'    => BUSINESS_ID,
            'item_code'      => $param['item_code'],
            'color'          => $param['color'],
            'division_month' => $param['division_month'],
        ];

        return DB::query($query)->parameters($params)->execute()->current();
    }
}
