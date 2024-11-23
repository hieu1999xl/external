<?php

/**
 * 漢字変換マスタテーブルのモデルクラス
 *
 * @author t.shoji@humanlife.co.jp
 */
class Model_HumanLife_MstConvertKanji extends Model_CrudAbstract
{

    /**
     * テーブル名
     *
     * @var string  漢字変換マスタ
     */
    protected static $_table_name = 'mst_convert_kanji';

    /**
     * 全件取得
     *
     * @return array
     */
    public function get_all()
    {
        return DB::select()->from(self::$_table_name)->execute()->as_array();
    }
}
