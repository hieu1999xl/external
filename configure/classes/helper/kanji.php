<?php

/**
 * 漢字のヘルパークラス
 *
 * @author t.shoji@humanlife.co.jp
 */
class Helper_Kanji
{

    private $_kanji_list;

    function __construct()
    {
        // DBから変換用漢字リストを取得する
        $model_mst_convert_kanji = new Model_HumanLife_MstConvertKanji();
        $arr_mst_convert_kanji = $model_mst_convert_kanji->get_all();
        $this->_kanji_list = array_column($arr_mst_convert_kanji, 'before_convert_kanji', 'after_convert_kanji');
    }

    /**
     * 漢字変換
     *
     * @param string $target_kanji
     *
     * @return string $return_kanji
     */
    public function convert($target_kanji)
    {
        $return_kanji = '';
        $word_count = mb_strlen($target_kanji);
        for ($i = 0; $i < $word_count; $i++) {
            // 1文字ずつ抜き出して変換
            $kanji = mb_substr($target_kanji, $i, 1);
            $convert_result = array_search($kanji, $this->_kanji_list);
            $return_kanji .= $convert_result === false ? $kanji : $convert_result;
        }

        return $return_kanji;
    }
}
