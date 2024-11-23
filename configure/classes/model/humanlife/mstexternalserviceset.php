<?php

/**
 * セット販売マスタテーブルのモデルクラス
 *
 */
class Model_HumanLife_MstExternalServiceSet extends Model_CrudAbstract
{

//     /**
//      * データソース名
//      * @var string ZEUSスキーマ名
//      */
//     protected static $_connection = 'human_life';

    /**
     * テーブル名
     * @var string テーブル名
     */
    protected static $_table_name = 'mst_external_service_set';
    
    /**
     * プライマリキー
     * @var array
     */
    protected static $_primary_key = 'external_service_set_id';
    
    /**
     * 全てのレコードを取得する
     * @param  array $columns 取得カラム名配列
     * @return array 取得結果
     */
    public function get_all_record($columns = ['*'])
    {
        return DB::select_array($columns)->from(self::$_table_name)->execute()->as_array();
    }
    
    /**
     * エイリアスと有効日時をキーに1レコード取得する
     * @param string $alias       エイリアス名
     * @param string $target_date 有効日で検索する場合指定する(YYYY/MM/DD)
     * @param array  $columns     取得カラム名配列
     * @return array|null         取得結果|レコードが取得できなかった場合null
     */
    public function get_record_by_alias_sale_date($alias
                                                 ,$target_date
                                                 ,$columns  = ['*'])
    {
        $query = DB::select_array($columns)->from(self::$_table_name)
                                           ->where('alias', $alias)
                                           ->and_where('sale_start_date', '<=', $target_date)
                                           ->and_where('sale_end_date', '>', $target_date);
        $result = $query->execute()->as_array();
        if(count($result)> 0){
            return $result[0];
        }
        return null;
    }
    
    /**
     * 有効期間内のレコードを取得する
     * @param string $target_date 有効日で検索する場合指定する(YYYY/MM/DD)
     * @param array $columns      取得カラム名配列
     * @return array 取得結果
     */
    public function get_record_by_sale_date($target_date
                                           ,$columns  = ['*'])
    {
        $result = DB::select_array($columns)->from(self::$_table_name)
                                            ->where('sale_start_date', '>=')
                                            ->and_where('sale_end_date', '<')
                                            ->execute()
                                            ->as_array();
        return $result;
    }

}
