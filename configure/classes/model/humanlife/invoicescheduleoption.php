<?php
/**
 * 請求予定テーブルのモデルクラス
 *
 * @author t.shoji@humanlife.co.jp
 */

class Model_HumanLife_InvoiceScheduleOption extends Model_CrudAbstract
{

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string 請求予定オプションテーブル名
     */
    protected static $_table_name = 'invoice_schedule_option';

    /**
     * 登録する
     *
     * @param array $pairs
     */
    public function insert($pairs)
    {
        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }
}
