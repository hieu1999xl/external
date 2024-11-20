<?php

/**
 * 申し込み-流入元履歴テーブルのモデルクラス
 * @author a.kurabayashi@humaninvestment.jp
 */
class Model_HumanLife_EntryInflowSourceHistory extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string テーブル名
     */
    protected static $_table_name = 'entry_inflow_source_history';

    /**
     * レコードをINSERTする
     *
     * @param array $pairs
     *            ['カラム名' => '値']形式の連想配列
     * @return number レコード数
     */
    public function insert($pairs) {
        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }
}
