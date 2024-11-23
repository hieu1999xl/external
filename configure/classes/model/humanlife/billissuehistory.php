<?php

/**
 * 請求書発行履歴(bill_issue_history)テーブルのモデルクラス
 *
 * @author m.ishikawa@humaninvestment.jp
 */
class Model_HumanLife_BillIssueHistory extends Model_CrudAbstract
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
     * @var string テーブル名
     */
    protected static $_table_name = 'bill_issue_history';

    protected static $_primary_key = 'bill_issue_id';

    /**
     * レコードをINSERTする
     *
     * @param array $pairs
     *            ['カラム名' => '値']形式の連想配列
     * @return number レコード数
     */
    public function insert($pairs)
    {
        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }
}
