<?php

/**
 * 流入元キャンペーンテーブルのモデルクラス
 */
class Model_HumanLife_MstInflowCampaign extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string テーブル名
     */
    protected static $_table_name = 'mst_inflow_campaign';

    /**
     * 該当キャンペーンを取得
     * 
     * @param array $param 検索キー
     * @return array 取得結果
     */
    public function get_by_key($param, $select=['*'])
    {
        $query = DB::select_array($select)
            ->from(self::$_table_name)
        ;
        foreach ($param as $key => $where) {
            $query->where($key, $where);
        }
        return $query->execute()->current();
    }
}