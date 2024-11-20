<?php

/**
 * 請求書の支払い履歴テーブル
 * @author m.ishikawa@humanlife.co.jp
 */
class Model_HumanLife_BillPaymentHistory extends Model_CrudAbstract
{

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     */
    protected static $_table_name = 'bill_payment_history';

    // プライマリキー
    protected static $_primary_key = 'bill_payment_history_id';

    /**
     * データをインサート
     * @param array $regist_data 登録するデータ群
     * @return array 登録結果
     */
    public function insert($regist_data){
        return DB::insert(self::$_table_name)->set($regist_data)->execute();
    }
}
