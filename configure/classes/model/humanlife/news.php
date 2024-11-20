<?php

/**
 * NEWSテーブルのモデルクラス
 *
 * @author i.moriyama@humanlife.co.jp
 */
class Model_HumanLife_News extends Model_CrudAbstract
{
    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';
    
    /**
     * テーブル名
     */
    protected static $_table_name = 'news';
    
    /**
     * お知らせIDを条件に必要なお知らせ情報を取得
     *
     * @param int $news_id
     * @param array $select
     * @return array
     */
    public function select($news_id,  array $select = ['*'])
    {
        return DB::select_array($select)
            ->from(self::$_table_name)
            ->where('news_id', $news_id)
            ->execute()
            ->current();
    }

    /**
     * 公開中の全てのお知らせを取得する
     *
     * @return array
     */
    public function get_all_news_is_now_showing()
    {
        return DB::select()
            ->from(self::$_table_name)
            ->where('publish_start_datetime', '<', Helper_Time::getCurrentDateTime())
            ->and_where('publish_end_datetime', '>', Helper_Time::getCurrentDateTime())
            ->order_by('news_date', 'DESC')
            ->order_by('display_order', 'ASC')
            ->execute()
            ->as_array();
    }

    /**
     * wimaxページに表示する公開中の全てのお知らせを取得する
     *
     * @param int $business_id
     * @return array
     */
    public function get_all_news_is_wimax($business_id)
    {
        return DB::select()
            ->from(self::$_table_name)
            ->where('publish_start_datetime', '<', Helper_Time::getCurrentDateTime())
            ->and_where('publish_end_datetime', '>', Helper_Time::getCurrentDateTime())
            ->and_where('is_wimax', NEWS_IS_SHOWN_WIMAX_PAGE_FLAG_LIST['FLAG_ON'])
            ->and_where('business_id', $business_id)
            ->order_by('news_date', 'DESC')
            ->order_by('display_order', 'ASC')
            ->execute()
            ->as_array();
    }    
}
