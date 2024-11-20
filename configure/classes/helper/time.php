<?php

/**
 * 時刻関連のヘルパークラス
 *
 * @author sakairi@liz-inc.co.jp
 *
 */
class Helper_Time {

    /**
     * 現在時刻を取得（yyyy-mm-dd HH:ii:ss）
     *
     * @return string
     */
    public static function getCurrentDateTime() {
        return date("Y-m-d H:i:s");
    }

    /**
     * 現在時刻を取得（yyyymmddHHiiss）
     *
     * @return string yyyymmddHHiissにマイクロ秒をつける。マイクロ秒の小数点以下がない場合は、0000をつける。
     */
    public static function getCurrentTimeMillis() {
        $date = new DateTime();
        $mtime_org = microtime(true);
        $mtime = isset(explode('.', $mtime_org)[1]) ? explode('.', $mtime_org)[1] : '0000';
        return $date->format("YmdHis") . $mtime;
    }

    /**
     * 対象日の曜日(日本語名)を取得する
     *
     * @param string $date 日付文字列
     * @return string
     */
    public static function convert_to_week_str($date) {
        $week = [
            '日',
            '月',
            '火',
            '水',
            '木',
            '金',
            '土',
        ];
        $week_no = date('w', strtotime($date));
        return $week[$week_no];

    }

    /**
     * 対象の日時から指定した日時を取得
     *
     * @param string $datetime
     * @param string $diff_text
     */
    public static function getDateStrtoTime($datetime, $diff_text) {
        return date("Y-m-d H:i:s", strtotime($diff_text . $datetime));
    }

    /**
     * カード有効期間の年の選択肢（現在の年～)
     */
    public static function getCreditCardExpiryYearList() {
        $expiry_year_array = [];
        $current_year = date("Y");
        $max_year = date("Y", strtotime("+10 year"));
        for ($x = $current_year; $x <= $max_year; $x++) {
            $expiry_year_array[] = substr($x, 2);
        }
        return $expiry_year_array;
    }

    /**
     * 日付を指定の日付フォーマットに変換して返す
     *
     * @param string $time
     *            日付
     * @param string $from_format
     *            変換前のフォーマット
     * @param string $to_format
     *            変換後のフォーマット
     * @return string|false 変換後の日付 or false
     */
    public static function convert_to_datetime_format($time = '19700101', $from_format = 'Ymd', $to_format = 'Y-m-d H:i:s')
    {
        if (empty($time)) {
            return FALSE;
        }

        $datetime = DateTime::createFromFormat($from_format, $time);
        return $datetime->format($to_format);
    }

    /**
     * UTCタイムスタンプに返還する
     *
     * @param string $datetime
     * @param string $from_format
     * @return int UTCタイムスタンプ
     */
    public static function convert_to_utc_timestamp($datetime, $from_format = 'Y-m-d H:i:s')
    {
        if (empty($datetime)) {
            return FALSE;
        }

        $datetime = DateTime::createFromFormat($from_format, $datetime, new DateTimeZone('UTC'));
        $utc_timestamp = $datetime->getTimestamp();
        // ミリ秒まで指定するため0埋め
        $utc_timestamp = str_pad($utc_timestamp, 13, '0', STR_PAD_RIGHT);
        return $utc_timestamp;
    }

    /**
     * 日付のフォーマットと存在する年月日かを厳密にチェック
     *
     * @param string $date
     * @param string $date_format
     * @return bool
     */
    public static function chack_date_format($date, $date_format = DATE_FORMAT_YMD) {
        // 空文字はエラーとする
        if ($date == '') {
            return false;
        }

        $delimiter = '';
        switch ($date_format) {
            case DATE_FORMAT_YMD:
                // Y-m-d形式かをチェックする
                if(!preg_match('/^[1-9]{1}[0-9]{0,3}\-[0-9]{1,2}\-[0-9]{1,2}$/', $date)){
                    return false;
                }
                $delimiter = '-';
                break;
            case DATE_FORMAT_YMD_SLASH:
                // Y/m/d形式かをチェックする
                if(!preg_match('/^[1-9]{1}[0-9]{0,3}\/[0-9]{1,2}\/[0-9]{1,2}$/', $date)){
                    return false;
                }
                $delimiter = '/';
                break;
            default:
                return false;
        }
     
        list($y, $m, $d) = explode($delimiter, $date);
     
        // 存在する日付かをチェック
        if(!checkdate($m, $d, $y)){
            return false;
        }
        return true;
    }
}
