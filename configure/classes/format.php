<?php

/**
 * Formatクラスの拡張
 *
 * @author sakairi@liz-inc.co.jp
 *
 */
class Format extends Fuel\Core\Format {

    /**
     * csv出力時にsjisになる様にoverride
     *
     * {@inheritdoc}
     *
     * @see \Fuel\Core\Format::to_csv()
     */
    public function to_csv($data = null, $delimiter = null, $enclose_numbers = null, array $headings = []) {
        $csv = parent::to_csv($data, $delimiter, $enclose_numbers, $headings);
        return mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');

    }
}