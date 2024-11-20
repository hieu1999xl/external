<?php

/**
 * 端末マスタのモデルクラス
 *
 * @author tanabe
 */

class Model_HumanLife_MstDeviceInit extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     */
    protected static $_table_name = 'mst_device_init';

    /**
     * プライマリキー
     * @var String
     */
    protected static $_primary_key = 'device_init_id';

    /**
     * データ 取り
     * @param $business_id
     */

    public function get_mst_device_init_info_by_business_id($business_id){

       $sql = <<<SQL
SELECT
   *
FROM
    mst_device_init
WHERE
    business_id = :business_id
SQL;
            $param = [
                'business_id' => $business_id,
            ];

            parent::pre_find($query);
            $result = DB::query($sql)->parameters($param)->execute()->as_array();
            return parent::post_find($result);
        }

    /**
     * 端末IDによりマスタ情報の一覧を取得する
     *
     * @param int $business_id 事業者ID
     * @param array $device_id_list 端末ID
     * @return array 端末マスタ+初期費用の連想配列
     */
    public static function get_mst_device_init_list_by_device_id($business_id, $device_id_list, $select = ['*']) {
        return DB::select_array($select)
            ->from(self::$_table_name)
            ->where('business_id', $business_id)
            ->where('device_id', 'IN', $device_id_list)
            ->execute()
            ->as_array('device_id');
    }

    /**
     * 端末初期費用マスタ情報の一覧を取得する
     *
     * @param integer $business_id 事業者ID
     * @param array $device_id_list 端末IDの配列
     * @return array 端末マスタの連想配列。対象なしのときは空配列を返却する。
     */
    public static function get_mst_device_init_by_device_id($business_id, $device_id_list) {
        $query = <<<SQL
SELECT
    device_id
    , name
    , price
    , tax_type
FROM
    mst_device_init
WHERE
    business_id = :business_id
    AND device_id in :device_id_list
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

}
