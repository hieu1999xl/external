<?php

/**
 * 流入元マスタのモデルクラス
 *
 * @author tanabe
 */

class Model_HumanLife_MstInflowSource extends Model_CrudAbstract
{

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * 流入元データを取得する
     *
     * @param string $h_source
     * @param string $h_medium
     *
     * @return array [] : $result
     */
    public function get_inflow_source($h_source, $h_medium)
    {
        $sql = <<<SQL
SELECT 
    *
FROM
    mst_inflow_source
WHERE
    h_source = :h_source
AND
    h_medium = :h_medium
AND
    delete_flg = :delete_flg;
SQL;

        $param = [
            'h_source'     => $h_source,
            'h_medium'     => $h_medium,
            'delete_flg' => FLG_OFF,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }
}