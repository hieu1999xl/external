<?php

/**
 * 申し込み-流入元詳細テーブルのモデルクラス
 */
class Model_HumanLife_EntryInflowSourceDetail extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string 法人テーブル名
     */
    protected static $_table_name = 'entry_inflow_source_detail';

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

    /**
     * レコードをINSERTする
     *
     * @param array $pairs
     *            ['カラム名' => '値']形式の連想配列
     * @return number レコード数
     */
    public function get_source_and_medium_by_entry_id($entry_id, $business_id)
    {
        // select
        $sql = <<<SQL
SELECT h_source, h_medium, utm_source, utm_medium
FROM human_life.entry_inflow_source_detail
    WHERE entry_inflow_source_detail.business_id = :business_id
    AND entry_inflow_source_detail.entry_id = :entry_id
SQL;

        $params = [
            'business_id' => $business_id,
            'entry_id'     => $entry_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }
}
