<?php

/**
 * 端末初期費用除外マスタテーブルのモデルクラス
 */
class Model_HumanLife_MstDeviceInitExclude extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string 端末初期費用除外マスタテーブル名
     */
    protected static $_table_name = 'mst_device_init_exclude';

    /**
     * 端末初期費用を除外するかどうか
     *
     * @param int $business_id
     * @param int $device_id
     * @param string $h_source
     * @param string $h_medium
     * @return boolean
     */
    public function is_device_init_exclude_by_entry_id($business_id, $device_id, $h_source, $h_medium)
    {
        $query = <<<SQL
SELECT
    1
FROM
    mst_device_init_exclude AS mdie
INNER JOIN
    mst_inflow_source AS mis
ON
    mdie.inflow_source_id = mis.inflow_source_id
WHERE
    mdie.business_id = :business_id
    AND mdie.device_id = :device_id
    AND mdie.delete_flag = :delete_flag
    AND mis.h_source = :h_source
    AND mis.h_medium = :h_medium
SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['device_id'] = $device_id;
        $bind_params['delete_flag'] = FLG_OFF;
        $bind_params['h_source'] = $h_source;
        $bind_params['h_medium'] = $h_medium;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }
}
