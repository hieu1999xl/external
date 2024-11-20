<?php

/**
 * プランマスタテーブルのモデルクラス
 *
 * @author nakamura@liz-inc.co.jp
 */
class Model_HumanLife_MstShippingDevice extends Model_CrudAbstract {

    /**
     * テーブル名
     *
     * @var string 法人テーブル名
     */
    protected static $_table_name = 'mst_shipping_device';

    /**
     * レコードを更新する
     *
     * @param array $pairs
     *            ['カラム名' => '値']形式の連想配列
     * @param array $wheres
     * @return number レコード数
     */
    public function update($pairs, $wheres) {
        return DB::update(self::$_table_name)->set($pairs)->where($wheres)->execute();
    }

    /**
     * IMEIをキーに端末タイプを取得する
     *
     * @param integer $business_id 事業者ID
     * @param string $imei imei
     * @return array 端末タイプ
     */
    public function get_device_type_by_imei($business_id, $imei)
    {
        $query = <<<SQL
        SELECT
            device_type
        FROM
            mst_shipping_device msd
        WHERE
            msd.imei2 = :imei
        AND msd.business_id = :business_id
        SQL;

        $params = [
            'business_id' => $business_id,
            'imei' => $imei,
        ];

        return DB::query($query)->parameters($params)->execute()->as_array();
    }

    /**
     * imeiに紐づくレコードを返す
     * @param int $imei 端末ID
     * @param array $select 取得カラム
     * @return array
     */
    public function get_record_by_imei($business_id, $imei, $select)
    {
        $query = DB::select_array($select)->from(self::$_table_name)
                                          ->where('imei2', '=', $imei, 'AND', 'business_id', '=', $business_id);
        return $query->execute()->as_array();
    }

}
