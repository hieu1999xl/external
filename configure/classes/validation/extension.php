<?php

/**
 * 独自バリデーションクラス
 *
 * @author sakairi@liz-inc.co.jp
 *
 */
class Validation_Extension {

    private static $_gid_list = [];
    private static $_tmp_name = NULL;
    private static $_file_name = NULL;
    private static $_upload_flg = FALSE;

    /**
     * 機種依存文字チェック
     *
     * @param string $value
     * @return boolean
     */
    public static function _validation_suitable_string($value) {
        if ($value == null || strlen($value) == 0) {
            return true;
        }

        // 機種依存文字が含まれているかチェック
        if (strlen($value) !== strlen(mb_convert_encoding(mb_convert_encoding($value, 'SJIS', 'UTF-8'), 'UTF-8', 'SJIS'))) {
            return false;
        }
        return true;
    }

    /**
     * 制御文字チェック
     *
     * @param string $val
     * @return  bool
     */
    public function _validation_control_code($val) {
        // 下記コードの制御文字が含まれているかチェック
        if (preg_match('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', $val) == 1) {
            return false;
        }
        return true;
    }

    /**
     * 必須チェック（TRIMしてからチェック）
     *
     * @param string $value
     * @return boolean
     */
    public static function _validation_required_after_trim($value) {
        return trim(mb_convert_kana($value, "s", 'UTF-8')) != '';
    }

    /**
     * 日付チェック
     *
     * @param string $value
     * @return boolean
     */
    public static function _validation_date($value) {
        if (is_null($value) || strlen($value) <= 0) {
            return true;
        }

        $ymd = explode('/', $value);
        if (checkdate((int)$ymd[1], (int)$ymd[2], (int)$ymd[0])) {
            return true;
        }

        return false;
    }

    /**
     * 成人チェック
     *
     * @param string $value
     * @return boolean
     */
    public static function _validation_adult($value) {

        $adult = strtotime("-18 year");
        $valueTime = strtotime($value);
        if ($valueTime < $adult) {
            return true;
        }

        return false;
    }

    /**
     * メールアドレス形式チェック
     *
     * 下記RFC規定準拠
     * RFC 5321 (Simple Mail Transfer Protocol)
     * RFC 5322 (Internet Message Format)
     *
     * @param string $value
     * @return boolean
     */
    public static function _validation_mail_address($value) {
        if (is_null($value) || strlen($value) <= 0) {
            return true;
        }

        if (preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $value)) {
            return true;
        }

        return false;
    }

    /**
     * メールアドレス形式チェック(GMO APIチェック用)
     *
     * 下記RFC規定準拠(ただしdocomo,AU(ezweb.ne.jp,au.com)はチェック対象外)
     * RFC 5321 (Simple Mail Transfer Protocol)
     * RFC 5322 (Internet Message Format)
     * + 「+」記号を弾く
     *
     * @param string $value
     * @return boolean
     */
    public static function _validation_mail_address_gmo($value) {
        if (is_null($value) || strlen($value) <= 0) {
            return true;
        }

        // GMOのAPIで+が入ったメールアドレスがエラーになるので、予め弾いておく(記号を追加する場合は|で区切る)
        if (preg_match('/\+/', $value) === 1) return false;

        if (preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $value) ||
            preg_match('/^[a-z]+[-a-z0-9_.]*@docomo\.ne\.jp$/i', $value) ||
            preg_match('/^[a-z]+[-a-z0-9_.]*@ezweb\.ne\.jp$/i', $value) ||
            preg_match('/^[a-z]+[-a-z0-9_.]*@au\.com$/i', $value)) {
            return true;
        }

        return false;
    }

    /**
     * URL形式チェック
     *
     * @param string $value
     * @return boolean
     */
    public static function _validation_url($value) {
        if (is_null($value) || strlen($value) <= 0) {
            return true;
        }

        if (preg_match("/^(https?):\/\/([A-Z0-9][A-Z0-9_-]*(\.[A-Z0-9][A-Z0-9-_]*)*(\.[A-Z]{2,})):?(\d+)?\/?/i", $value)) {
            return true;
        }

        return false;
    }

    /**
     * コード値チェック
     *
     * @param string $value
     * @param string $code_name
     * @return boolean
     */
    public static function _validation_code($value, $code_name) {
        if (is_null($value) || strlen($value) <= 0) {
            return true;
        }

        if ($code_name == 'OnOff') {
            if ($value == FLG_ON || $value == FLG_OFF) {
                return true;
            }

            return false;
        }

        $class = Helper_Code::class;
        $function_name = 'get' . $code_name . 'Name';

        $reflection_method = new ReflectionMethod('Helper_Code', $function_name);
        return 0 < strlen($reflection_method->invoke(new Helper_Code(), $value));
    }

    /**
     * 半角英数字チェック
     *
     * @param string $value
     * @return boolean
     */
    public static function _validation_alpha_num($value) {
        if (is_null($value) || strlen($value) <= 0) {
            return true;
        }

        if (preg_match('/^[0-9A-Za-z\-_]+$/', $value)) {
            return true;
        }

        return false;
    }

    /**
     * ファイル必須チェック
     *
     * @param array $value
     * @return boolean
     */
    public static function _validation_file_required() {
        foreach ($_FILES as $chek_type => $file_value) {
            self::$_tmp_name = $file_value['tmp_name'];
            self::$_file_name = $file_value['name'];
            if ($chek_type == 'update_csv') {
                self::$_upload_flg = TRUE;
            }
        }
        if (isset(self::$_tmp_name)) {
            return true;
        }
        return false;
    }

    /**
     * ファイルアップロードチェック
     *
     * @param array $value
     * @return boolean
     */
    public static function _validation_file_upload() {
        if (!isset(self::$_tmp_name)) {
            return true;
        }

        if (is_uploaded_file(self::$_tmp_name)) {
            return true;
        }
        return false;
    }

    /**
     * ファイルフォーマットチェック
     *
     * @param array $value
     * @return boolean
     */
    public static function _validation_file_format() {
        if (!isset(self::$_tmp_name)) {
            return true;
        }
        if (pathinfo(self::$_file_name, PATHINFO_EXTENSION) === "csv") {
            return true;
        }
        return false;
    }

    /**
     * ファイル名チェック
     *
     * @param array $value
     * @return boolean
     */
    public static function _validation_file_name() {
        if (!isset(self::$_tmp_name)) {
            return true;
        }
        $filename_array = explode('_', self::$_file_name);
        $file_type = 'regist';
        if (self::$_upload_flg) {
            $file_type = 'update';
        }
        if ($filename_array[0] === 'gnavi'
            && $filename_array[1] === $file_type
            && strlen($filename_array[2]) === 8) {
            return true;
        }
        return false;
    }

    /**
     * ファイル名重複チェック
     *
     * @param array $value
     * @return boolean
     */
    public static function _validation_file_already() {
        if (!isset(self::$_tmp_name)) {
            return true;
        }
        $file_path = ENTRY_REGIST_FILE_PATH;
        if (self::$_upload_flg) {
            $file_path = ENTRY_UPDATE_FILE_PATH;
        }
        if (!Helper_File::is_exist_file($file_path . self::$_file_name)) {
            return true;
        }
        return false;
    }

    /**
     * ファイル内行数チェック
     *
     * @param int $num
     * @return boolean
     */
    public static function _validation_file_sizeof($val, $num) {
        if (!isset(self::$_tmp_name)) {
            return true;
        }
        // 1行目はヘッダー情報のため除外
        $file_cnt = count(file(self::$_tmp_name)) - 1;
        if ($file_cnt <= $num) {
            return true;
        }
        return false;
    }

    /**
     * ファイル1行のデータ数チェック
     *
     * @return boolean
     */
    public static function _validation_file_line_size() {
        if (!isset(self::$_tmp_name)) {
            return true;
        }
        // 1行に記載される想定のデータ数を取得
        $csv_key_cnt = count(Helper_Code::$BULK_ENTRY_CSV_KEY);
        // 一括更新の場合
        if (self::$_upload_flg) {
            $csv_key_cnt = count(Helper_Code::$BULK_UPDATE_CSV_KEY);
        }
        // ファイルを配列で取得
        $buf = mb_convert_encoding(file_get_contents(self::$_tmp_name), "utf-8", "sjis");
        $lines = explode("\r\n", $buf);
        $err_flg = FLG_OFF;
        foreach ($lines as $line_key => $line) {
            // 配列にする
            $line_data = explode(',', $line);
            // 改行を考慮
            if (!empty($line_data[0])) {
                if (count($line_data) != $csv_key_cnt) {
                    $err_flg = FLG_ON;
                    break;
                }
            }
        }
        if ($err_flg == FLG_ON) {
            return false;
        }
        return true;
    }

    /**
     * 店舗番号登録済みチェック
     *
     * @param string $g_id
     * @return boolean
     */
    public static function _validation_regist_already($g_id) {
        $trn_entry = new Logic_Gpay_TrnEntry();
        $result = $trn_entry->get_entry_gid($g_id);
        if (!empty($result)) {
            return false;
        }
        return true;
    }

    /**
     * ファイル内店舗番号重複チェック
     *
     * @param string $g_id
     * @return boolean
     */
    public static function _validation_duplication($g_id) {
        if (in_array($g_id, self::$_gid_list)) {
            return false;
        }
        self::$_gid_list[] = $g_id;
        return true;
    }

    /**
     * 店舗番号未登録チェック
     *
     * @param string $g_id
     * @return boolean
     */
    public static function _validation_not_regist($g_id) {
        $trn_entry = new Logic_Gpay_TrnEntry();
        $result = $trn_entry->get_entry_gid($g_id);
        if (empty($result)) {
            return false;
        }
        return true;
    }

    /**
     * 仮登録のみ店舗番号チェック
     *
     * @param string $g_id
     * @return boolean
     */
    public static function _validation_not_tmp_entry($g_id) {
        $trn_project = new Logic_Gpay_TrnProject();
        $result = $trn_project->get_tmp_entry_project($g_id);
        if ($result) {
            return false;
        }
        return true;
    }

    /**
     * お知らせ掲出日時チェック
     *
     * @param array $value
     * @return boolean
     */
    public static function _validation_info_datetime($value) {
        $input = new DateTime($value);
        $now = new DateTime(date("Y-m-d H:i:s"));

        if ($value !== date("Y-m-d H:i:s", strtotime($value))) {
            return false;
        }

        if ($input < $now) {
            return false;
        }
        return true;
    }

    /**
     * お知らせ掲出最大文字数チェック
     *
     * @param string $val
     * @param int    $length
     * @return  bool
     */
    public function _validation_info_max_length($val, $length) {
        return \Str::length($val) <= $length;
    }

    /**
     * お知らせ掲出ファイル必須チェック
     *
     * @param array $value
     * @return boolean
     */
    public static function _validation_info_file_required($value) {
        if (isset($value['tmp_name'])) {
            return true;
        }
        return false;
    }

    /**
     * お知らせ掲出ファイルアップロードチェック
     *
     * @param array $value
     * @return boolean
     */
    public static function _validation_info_file_upload($value) {
        if (!is_uploaded_file($value['tmp_name'])) {
            return false;
        }
        if ($value['error'] != 0) {
            return false;
        }
        return true;
    }

    /**
     * お知らせ掲出ファイルフォーマットチェック
     *
     * @param array $value
     * @return boolean
     */
    public static function _validation_info_file_format($value) {
        if (!pathinfo($value['name'], PATHINFO_EXTENSION) === "pdf") {
            return false;
        }
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileinfo, $value['tmp_name']);
        finfo_close($fileinfo);
        if ($mimeType != "application/pdf") {
            return false;
        }
        return true;
    }

    /**
     * お知らせ掲出ファイルサイズチェック
     * 2MBまで
     *
     * @param array $value
     * @return boolean
     */
    public static function _validation_info_file_sizeof($value) {
        if ($value['error'] == 1 || $value['error'] == 2) {
            return false;
        }
        if ($value['size'] > 2097152) {
            return false;
        }
        return true;
    }


    /**
     * 必須チェック（選択項目用）
     *
     * @param string $param チェックする値
     * @param array $options 選択候補(任意)
     * @return boolean
     */
    public static function _validation_required_select($param, $options = []) {
        if (is_array($param)) {
            $values = $param;
        } else {
            $values = [];
            $values[] = $param;
        }
        foreach ($values as $value) {
            $val = mb_convert_kana($value, "s", 'UTF-8');
            if ($val == '') {
                return false;
            }
            if ($options) {
                if (!in_array($val, $options)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 桁数チェック（エラーメッセージに「は」を含めない）
     * (例)「【氏名（漢字）は姓名合わせて】30文字以内で入力してください。」
     *
     * @param string $value
     * @param string $options 選択候補(任意)
     * @return boolean
     */
    public static function _validation_max_length_custom($value, $length) {
        return Validation::instance()->_validation_max_length($value, $length);
    }

    /**
     * 桁数範囲チェック
     *
     * @param string 対象の文字列
     * @param int 指定桁数min
     * @param int 指定桁数max
     * @return bool
     */
    public function _validation_range($value, $length_min, $length_max) {
        $target_length = mb_strlen($value);
        return $target_length >= $length_min && $target_length <= $length_max;
    }

    /**
     * 全角カナ文字チェック
     *
     * @param string $value
     * @return bool
     */
    public static function _validation_multi_byte_kana($value) {
        if (is_null($value) || strlen($value) <= 0) {
            return true;
        }

        mb_regex_encoding("UTF-8");
        if (preg_match('/^[ァ-ヶ０-９Ａ-Ｚー－‐]+$/u', $value)) {
            return true;
        }

        return false;
    }

    /**
     * 氏名文字チェック
     *
     * @param string $value
     * @return bool
     */
    public static function _validation_name($value) {

        mb_regex_encoding("UTF-8");

        // かな
        $kana = '\x81\x5b|\x82[\x9F-\xF1]|\x83[\x40-\x7E]|\x83[\x80-\x96]';
        // 漢字
        $chineseChar = '\x81\x58|[\x88-\x9f][\x40-\xfc]|[\xe0-\xfb][\x40-\xfc]|\xfc[\xa2-\xee]';

        // 入力値をUTF-8、SJISで1文字ずつ分割する
        $utf8 = preg_split('//u', $value, -1, PREG_SPLIT_NO_EMPTY);
        $sjis = $utf8;
        mb_convert_variables('sjis-win', 'UTF-8', $sjis);

        // 異体字セレクタ、または禁則文字が含まれていた場合、該当する文字を返却する
        foreach ($utf8 as $i => $char) {
            // 16進数に変換
            $hex = bin2hex($char);
            // 異体字セレクタの場合
            if (preg_match('/^F3A0848[0-9|A-F]$/i', $hex)) {
                return false;
            }
        }

        // SJISに変換できない文字、または入力不可文字が含まれていた場合、該当する文字を返却する
        foreach ($sjis as $i => $char) {
            if (empty(trim($char))) {
                continue;
            }
            if ($char === '?' && $utf8[$i] !== '?' || !preg_match('/^' . $kana . '|' . $chineseChar . '$/', $char)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 半角数字チェック
     *
     * @param string $value
     * @return boolean
     */
    public static function _validation_num($value) {
        if (is_null($value) || strlen($value) <= 0) {
            return true;
        }

        if (preg_match('/^[0-9\-_]+$/', $value)) {
            return true;
        }

        return false;
    }
    public static function _validation_quantity_count($value){
        if ($value < 1){
            return false;
        }
        return true;
    }

    /**
     * 選択できない値をチェック（選択項目用）
     * $optionsに一致する値があればエラーにする
     *
     * @param $value
     * @param $options
     * @return bool
     */
    public static function _validation_exclude_select($value, $options = null) {
        $val = mb_convert_kana($value, "s", 'UTF-8');
        if ($val === '') {
            return false;
        }
        if ($options) {
            if (in_array($val, $options)) {
                return false;
            }
        }
        return true;
    }

}
