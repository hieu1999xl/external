<?php

/**
 * NEWSカテゴリのマスタのモデルクラス
 *
 * @author i.moriyama@humanlife.co.jp
 */

class Model_HumanLife_MstNewsCategory extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';
    
    /**
     * テーブル名
     */
    protected static $_table_name = 'mst_news_category';

    /**
     * 全てのマスタカテゴリを取得する
     *
     * @return array
     */
    public function get_all_news_category()
    {
        return DB::select()
            ->from(self::$_table_name)
            ->execute()
            ->as_array();
    }
}
