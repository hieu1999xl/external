<?php

/**
 * バリデーション
 *
 * @author sakairi@liz-inc.co.jp
 *
 */
class Helper_Validation {

    /**
     * 必須チェック
     *
     * @param string $value
     * @param string $label
     * @return string エラーの場合はエラーメッセージ
     */
    public static function valid_required($value, $label = null) {
        if (is_null($value) || strlen($value) <= 0) {
            return sprintf(ERR_MSG_PROJECTEDIT_003, $label);
        }

        return '';
    }

    /**
     * 指定された文字が全角文字かを判定する
     *
     * @param string $value
     * @param string $param
     * @return string エラーの場合はエラーメッセージ
     */
    public static function valid_multi_byte($value, $label = null) {
        if (is_null($value) || strlen($value) <= 0) {
            return '';
        }

        $result = self::isNotIncludedDisabledCharByFullWidth($value);
        if ($result['bool']) {
            return '';
        }

        return sprintf(ERR_MSG_PROJECTEDIT_001, $label);
    }

    /**
     * 全角文字列に使用不可文字が含まれていないことをチェック
     *
     * 以下のJIS X 0208文字であることをチェックする。
     * 各種記号、英数字、かな 01区～08区
     * JIS第一水準漢字 16区～47区
     * JIS第二水準漢字 48区～84区
     *
     * 判定結果がfalseの場合、該当する文字も返却する
     *
     * @param string $val 対象の文字列
     * @return array 使用不可文字有無（true：含まれていない、false：含まれている）
     */
    public static function isNotIncludedDisabledCharByFullWidth($input_param) {
        mb_regex_encoding("UTF-8");

        $result['bool'] = true;
        $result['matches'] = '';

        // 記号
        $symbol = '\x81[\x40-\x7E]|\x81[\x80-\xAC]|\x81[\xB8-\xBF]|\x81[\xC8-\xCE]|\x81[\xDA-\xE8]|\x81[\xF0-\xF7]|\x81\xFC';
        // 数字
        $number = '\x82[\x4F-\x58]';
        // 英字
        $alpha = '\x82[\x60-\x79]|\x82[\x81-\x9A]';
        // かな
        $kana = '\x82[\x9F-\xF1]|\x83[\x40-\x7E]|\x83[\x80-\x96]';
        // ギリシア文字
        $greece = '\x83[\x9F-\xB6]|\x83[\x9F-\xB6]|\x83[\xBF-\xD6]|\x84[\x40-\x60]|\x84[\x70-\x91]|\x84[\x9F-\xBE]';
        // 漢字
        $chineseChar = '\x88[\x9F-\xFC]|[\x89-\x97][\x40-\xFC]|\x98[\x40-\x72]|\x98[\x9F-\xFC]|[\x99-\xE9][\x40-\xFC]|\xEA[\x40-\xA4]';

        // 入力値をUTF-8、SJISで1文字ずつ分割する
        $utf8 = preg_split('//u', $input_param, -1, PREG_SPLIT_NO_EMPTY);
        $sjis = $utf8;
        mb_convert_variables('SJIS', 'UTF-8', $sjis);

        // 異体字セレクタ、または禁則文字が含まれていた場合、該当する文字を返却する
        foreach ($utf8 as $i => $char) {
            // 16進数に変換
            $hex = bin2hex($char);
            // 異体字セレクタの場合
            if (preg_match('/^F3A0848[0-9|A-F]$/i', $hex)) {
                $result['bool'] = false;
                $result['matches'] = $utf8[$i - 1];
                return $result;
            }
        }

        // SJISに変換できない文字、または入力不可文字が含まれていた場合、該当する文字を返却する
        foreach ($sjis as $i => $char) {
            if (empty(trim($char))) {
                continue;
            }
            if ($char === '?' && $utf8[$i] !== '?' || !preg_match('/^' . $symbol . '|' . $number . '|' . $alpha . '|' . $kana . '|' . $greece . '|' . $chineseChar . '$/', $char)) {
                $result['bool'] = false;
                $result['matches'] = $utf8[$i];
                return $result;
            }
        }
        return $result;
    }

    /**
     * 指定された文字が全角カナかを判定する
     *
     * @param string $value
     * @param string $label
     * @return string エラーの場合はエラーメッセージ
     */
    public static function valid_multi_byte_kana($value, $label = null) {
        if (is_null($value) || strlen($value) <= 0) {
            return '';
        }

        mb_regex_encoding("UTF-8");
        if (preg_match('/^[ァ-ヶ０-９Ａ-Ｚー－‐]+$/u', $value)) {
            return '';
        }

        return sprintf(ERR_MSG_PROJECTEDIT_001, $label);
    }

    /**
     * 指定された年、月、日が正しい日付かを判定する
     *
     * @param string $year
     * @param string $month
     * @param string $day
     * @param string $label
     * @return string エラーの場合はエラーメッセージ
     */
    public static function valid_date($year, $month, $day, $label = null) {
        if ((is_null($year) || strlen($year) <= 0) ||
            (is_null($month) || strlen($month) <= 0) ||
            (is_null($day) || strlen($day) <= 0)) {
            return '';
        }

        if (checkdate($month, $day, $year)) {
            return '';
        }

        return sprintf(ERR_MSG_PROJECTEDIT_002, $label);
    }

    /**
     * 相関チェック（店舗ステータスが解約済みの場合、解約予定日は必須）
     *
     * @param string $cancel_schedule_date
     * @param string $label
     * @return string エラーの場合はエラーメッセージ
     */
    public static function valid_required_cancel_schedule_date($cancel_schedule_date, $label = null) {
        if (is_null($cancel_schedule_date) || strlen($cancel_schedule_date) <= 0) {
            return sprintf(ERR_MSG_PROJECTEDIT_003, $label);
        }

        return '';
    }

    /**
     * 相関チェック（解約予定日が入力されている場合、店舗ステータスは解約済みに設定）
     *
     * @param string $project_status
     * @param string $label
     * @param string $param
     * @return string エラーの場合はエラーメッセージ
     */
    public static function valid_project_status($project_status, $label = null, $param = null) {
        if ($project_status != PROJECT_STATUS_CALCEL) {
            return sprintf(ERR_MSG_PROJECTEDIT_004, $label, $param);
        }

        return '';
    }

    /**
     * 桁数チェック
     *
     * @param string $value
     * @param string $label
     * @param int    $param
     * @return string
     */
    public static function valid_min_length($value, $label = null, $param = null) {
        if (is_null($value) || strlen($value) <= 0) {
            return '';
        }

        if (Str::length($value) < $param) {
            return sprintf(ERR_MSG_PROJECTEDIT_009, $label, $param);
        }

        return '';
    }

    /**
     * 日付範囲チェック
     *
     * @param string $from
     * @param string $to
     * @param string $label
     * @return string
     */
    public static function valid_date_range($from, $to, $label = null) {
        if (is_null($from) || strlen($from) <= 0 || is_null($to) || strlen($to) <= 0) {
            return '';
        }

        if (new DateTime($to) < new DateTime($from)) {
            return sprintf(ERR_MSG_PROJECTEDIT_010, $label);
        }

        return '';
    }
}