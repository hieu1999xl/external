<?php

/**
 * ユーティリティ関連のヘルパークラス
 *
 * @author sakairi@liz-inc.co.jp
 *
 */
class Helper_Util {

    /**
     * 全角→半角の際に、「mb_convert_kana」で変換されないカナ
     *
     * @var array
     */
    private static $TO_SINGLE_BYTE_KANA = [
        'ヷ' => 'ﾜﾞ',
        'ヺ' => 'ｦﾞ',
    ];

    /**
     * 半角→全角の際に、「mb_convert_kana」で変換されないカナ
     *
     * @var array
     */
    private static $TO_MULTI_BYTE_KANA = [
        'ﾜﾞ' => 'ヷ',
        'ｦﾞ' => 'ヺ',
    ];

    /**
     * 全角→半角の際に、「mb_convert_kana」で変換されないカナ
     *
     * @var array
     */
    private static $TO_SINGLE_BYTE_SYMBOL = [
        '＂' => '"',
        '＇' => '\'',
        '＼' => '\\',
        '～' => '~',
    ];


    /**
     * 半角→全角の際に、「mb_convert_kana」で変換されないカナ
     *
     * @var array
     */
    private static $TO_MULTI_BYTE_SYMBOL = [
        '"'  => '＂',
        '\'' => '＇',
        '\\' => '＼',
        '~'  => '～',
    ];

    /**
     * 半角カナの小文字を大文字に変換
     *
     * @var array
     */
    private static $TO_BIG_KANA = [
        'ｧ' => 'ｱ',
        'ｨ' => 'ｲ',
        'ｩ' => 'ｳ',
        'ｪ' => 'ｴ',
        'ｫ' => 'ｵ',
        'ｯ' => 'ﾂ',
        'ｬ' => 'ﾔ',
        'ｭ' => 'ﾕ',
        'ｮ' => 'ﾖ',
    ];

    /**
     * オブジェクトを再帰的に配列に置換して返却する
     *
     * @param stdClass $obj
     * @return array
     */
    public static function object_to_array($obj) {
        if (is_object($obj)) {
            $obj = get_object_vars($obj);
        }
        if (is_array($obj)) {
            foreach ($obj as $key => $row) {
                $obj[$key] = self::object_to_array($row);
            }
        }
        return $obj;
    }

    /**
     * 全角カナを半角カナに変換する
     *
     * @param string $multi_byte_kana
     * @return string
     */
    public static function to_single_byte_kana($multi_byte_kana) {
        if (is_null($multi_byte_kana) || strlen($multi_byte_kana) <= 0) {
            return '';
        }

        foreach (Helper_Util::$TO_SINGLE_BYTE_KANA as $key => $value) {
            $str = str_replace($key, $value, $multi_byte_kana);
        }

        foreach (Helper_Util::$TO_SINGLE_BYTE_SYMBOL as $key => $value) {
            $str = str_replace($key, $value, $str);
        }

        return mb_convert_kana($str, 'ask', 'UTF-8');
    }

    /**
     * 全角カナを半角カナ(大文字)に変換する
     *
     * @param string $multi_byte_kana
     * @return string
     */
    public static function to_single_byte_kana_big($multi_byte_kana) {
        if (is_null($multi_byte_kana) || strlen($multi_byte_kana) <= 0) {
            return '';
        }

        $str = self::to_single_byte_kana($multi_byte_kana);

        foreach (Helper_Util::$TO_BIG_KANA as $key => $value) {
            $str = str_replace($key, $value, $str);
        }

        return $str;
    }

    /**
     * 半角文字を全角文字に変換する
     *
     * @param string $single_byte_kana
     * @return string
     */
    public static function to_multi_byte_kana($single_byte_kana) {
        if (is_null($single_byte_kana) || strlen($single_byte_kana) <= 0) {
            return '';
        }

        foreach (Helper_Util::$TO_MULTI_BYTE_KANA as $key => $value) {
            $str = str_replace($key, $value, $single_byte_kana);
        }

        foreach (Helper_Util::$TO_MULTI_BYTE_SYMBOL as $key => $value) {
            $str = str_replace($key, $value, $str);
        }

        return mb_convert_kana($str, 'ASKV', 'UTF-8');
    }

    /**
     * 半角英字を全角かつ大文字に変換
     *
     * @param string  $str
     * @param boolean $conv_flg  全角　true：する/false：しない
     * @param boolean $upper_flg 大文字　true：する/false：しない
     * @return string
     */
    public static function to_upper_and_conv_eng($str, $conv_flg = false, $upper_flg = false) {
        if (is_null($str) || strlen($str) <= 0) {
            return '';
        }
        // 全角かつ大文字にも変換する場合
        if ($conv_flg === true && $upper_flg === true) {
            return mb_convert_kana(strtoupper($str), 'R');
            // 全角のみ
        } elseif ($conv_flg === true) {
            return mb_convert_kana($str, 'R');
            // 大文字のみ
        } elseif ($upper_flg === true) {
            return strtoupper($str);
        }
        return $str;
    }

    /**
     * 環境依存文字を削除する
     *
     * @param string|array $value
     * @return string
     */
    public static function delete_suitable_string($value) {
        if (is_array($value)) {
            if (empty($value)) {
                return [];
            }
        } else if (is_null($value) || strlen($value) <= 0) {
            return '';
        }

        $search = ['①', '②', '③', '④', '⑤', '⑥', '⑦', '⑧', '⑨', '⑩', '⑪', '⑫', '⑬', '⑭', '⑮', '⑯', '⑰', '⑱', '⑲', '⑳', 'Ⅰ', 'Ⅱ', 'Ⅲ', 'Ⅳ', 'Ⅴ', 'Ⅵ', 'Ⅶ', 'Ⅷ', 'Ⅸ', 'Ⅹ', '㍉', '㌔', '㌢', '㍍', '㌘', '㌧', '㌃', '㌶', '㍑', '㍗', '㌍', '㌦', '㌣', '㌫', '㍊', '㌻', '㎜', '㎝', '㎞', '㎎', '㎏', '㏄', '㎡', '㍻', '〝', '〟', '№', '㏍', '℡', '㊤', '㊥', '㊦', '㊧', '㊨', '㈱', '㈲', '㈹', '㍾', '㍽', '㍼', '∮', '∑', '∟', '⊿', '纊', '褜', '鍈', '銈', '蓜', '俉', '炻', '昱', '棈', '鋹', '曻', '彅', '丨', '仡', '仼', '伀', '伃', '伹', '佖', '侒', '侊', '侚', '侔', '俍', '偀', '倢', '俿', '倞', '偆', '偰', '偂', '傔', '僴', '僘', '兊', '兤', '冝', '冾', '凬', '刕', '劜', '劦', '勀', '勛', '匀', '匇', '匤', '卲', '厓', '厲', '叝', '﨎', '咜', '咊', '咩', '哿', '喆', '坙', '坥', '垬', '埈', '埇', '﨏', '增', '墲', '夋', '奓', '奛', '奝', '奣', '妤', '妺', '孖', '寀', '甯', '寘', '寬', '尞', '岦', '岺', '峵', '崧', '嵓', '﨑', '嵂', '嵭', '嶸', '嶹', '巐', '弡', '弴', '彧', '德', '忞', '恝', '悅', '悊', '惞', '惕', '愠', '惲', '愑', '愷', '愰', '憘', '戓', '抦', '揵', '摠', '撝', '擎', '敎', '昀', '昕', '昻', '昉', '昮', '昞', '昤', '晥', '晗', '晙', '晳', '暙', '暠', '暲', '暿', '曺', '朎', '杦', '枻', '桒', '柀', '栁', '桄', '棏', '﨓', '楨', '﨔', '榘', '槢', '樰', '橫', '橆', '橳', '橾', '櫢', '櫤', '毖', '氿', '汜', '沆', '汯', '泚', '洄', '涇', '浯', '涖', '涬', '淏', '淸', '淲', '淼', '渹', '湜', '渧', '渼', '溿', '澈', '澵', '濵', '瀅', '瀇', '瀨', '炅', '炫', '焏', '焄', '煜', '煆', '煇', '凞', '燁', '燾', '犱', '犾', '猤', '獷', '玽', '珉', '珖', '珣', '珒', '琇', '珵', '琦', '琪', '琩', '琮', '瑢', '璉', '璟', '甁', '畯', '皂', '皜', '皞', '皛', '皦', '睆', '劯', '砡', '硎', '硤', '硺', '礰', '禔', '禛', '竑', '竧', '竫', '箞', '絈', '絜', '綷', '綠', '緖', '繒', '罇', '羡', '茁', '荢', '荿', '菇', '菶', '葈', '蒴', '蕓', '蕙', '蕫', '﨟', '薰', '蘒', '﨡', '蠇', '裵', '訒', '訷', '詹', '誧', '誾', '諟', '諶', '譓', '譿', '賰', '賴', '贒', '赶', '﨣', '軏', '﨤', '遧', '郞', '鄕', '鄧', '釚', '釗', '釞', '釭', '釮', '釤', '釥', '鈆', '鈐', '鈊', '鈺', '鉀', '鈼', '鉎', '鉙', '鉑', '鈹', '鉧', '銧', '鉷', '鉸', '鋧', '鋗', '鋙', '鋐', '﨧', '鋕', '鋠', '鋓', '錥', '錡', '鋻', '﨨', '錞', '鋿', '錝', '錂', '鍰', '鍗', '鎤', '鏆', '鏞', '鏸', '鐱', '鑅', '鑈', '閒', '﨩', '隝', '隯', '霳', '霻', '靃', '靍', '靏', '靑', '靕', '顗', '顥', '餧', '馞', '驎', '髙', '髜', '魵', '魲', '鮏', '鮱', '鮻', '鰀', '鵰', '鵫', '鸙', '黑', 'ⅰ', 'ⅱ', 'ⅲ', 'ⅳ', 'ⅴ', 'ⅵ', 'ⅶ', 'ⅷ', 'ⅸ', 'ⅹ', '￤', '＇', '＂', '¡', '¤', '¦', '©', 'ª', '«', '­', '®', '¯', '²', '³', 'µ', '·', '¸', '¹', 'º', '»', '¼', '½', '¾', '¿', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ', '™'];
        $replace = [];
        return str_replace($search, $replace, $value);
    }

    /**
     * 法人格
     *
     * @var array
     */
    private static $COOPRATE_CROWN_KANA = [
        'ｶﾌﾞｼｷｶﾞｲｼﾔ',
        'ｶﾌﾞｼｷｶｲｼﾔ',
        'ﾕｳｹﾞﾝｶﾞｲｼﾔ',
        'ﾕｳｹﾞﾝｶｲｼﾔ',
        'ｺﾞｳﾒｲｶﾞｲｼﾔ',
        'ｺﾞｳﾒｲｶｲｼﾔ',
        'ｺﾞｳｼｶﾞｲｼﾔ',
        'ｺﾞｳｼｶｲｼﾔ',
        'ｺﾞｳﾄﾞｳｶﾞｲｼﾔ',
        'ｺﾞｳﾄﾞｳｶｲｼﾔ',
    ];

    /**
     * 半角カナの会社名の法人格前後に半角スペースを付加する。
     *
     * @param string $str
     * @return string
     */
    public static function add_space_while_cooprate_crown($str) {
        if (is_null($str) || strlen($str) <= 0) {
            return '';
        }

        foreach (self::$COOPRATE_CROWN_KANA as $key => $value) {
            $str = preg_replace('/^' . $value . '/', $value . ' ', $str);
            $str = preg_replace('/' . $value . '$/', ' ' . $value, $str);
        }

        return $str;
    }

    /**
     * 日本語の住所の「１丁目１番１号」を「１－１－１」に変換する。
     *
     * @param string $str
     * @return string
     */
    public static function conv_zenkaku_address_haifun($str) {
        if (is_null($str) || strlen($str) <= 0) {
            return '';
        }

        $str = preg_replace('/([１２３４５６７８９０])丁目/u', '$1－', $str);
        $str = preg_replace('/([１２３４５６７８９０])番地/u', '$1－', $str);
        $str = preg_replace('/([１２３４５６７８９０])番/u', '$1－', $str);
        $str = preg_replace('/([１２３４５６７８９０])号/u', '$1', $str);

        $str = preg_replace('/([一二三四五六七八九〇十百])丁目/u', '$1－', $str);
        $str = preg_replace('/([一二三四五六七八九〇十百])番地/u', '$1－', $str);
        $str = preg_replace('/([一二三四五六七八九〇十百])番/u', '$1－', $str);
        $str = preg_replace('/([一二三四五六七八九〇十百])号/u', '$1', $str);

        // 最後がハイフンだったら除去
        $str = preg_replace('/(.*)－$/u', '$1', $str);

        return $str;
    }

    /**
     * 全角カナの住所の「１チョウメ１バン１ゴウ」を「１－１－１」に変換する。
     *
     * @param string $str
     * @return string
     */
    public static function conv_zenkaku_kana_address_haifun($str) {
        if (is_null($str) || strlen($str) <= 0) {
            return '';
        }

        $str = preg_replace('/([１２３４５６７８９０])チョウメ/u', '$1－', $str);
        $str = preg_replace('/([１２３４５６７８９０])バン/u', '$1－', $str);
        $str = preg_replace('/([１２３４５６７８９０])ゴウ/u', '$1', $str);

        return $str;
    }

    /**
     * 和暦の元号番号(明治=1,大正=2,昭和=3,平成=4,新元号=5)を取得します。
     *
     * @param date $dt
     * @return number
     */
    public static function get_era_no($dt) {

        $date = (int)date('Ymd', strtotime($dt));
        $era_no = 0;

        if ($date >= 20190501) {        //新元号元年（2019年5月1日以降）
            $era_no = 5;
        } else if ($date >= 19890108) { //平成元年（1989年1月8日以降）
            $era_no = 4;
        } else if ($date >= 19261225) { //昭和元年（1926年12月25日以降）
            $era_no = 3;
        } else if ($date >= 19120730) { //大正元年（1912年7月30日以降）
            $era_no = 2;
        } else if ($date >= 18680125) { //明治元年（1868年1月25日以降）
            $era_no = 1;
        }

        return $era_no;
    }

    /**
     * 和暦の年月日(YYMMDD)を取得します。
     *
     * @param date $dt
     * @return string
     */
    public static function get_wareki($dt) {

        $date = (int)date('Ymd', strtotime($dt));
        $year = (int)date('Y', strtotime($dt));
        $md = date('md', strtotime($dt));

        $wareki = '';

        if ($date >= 20190501) {        //新元号元年（2019年5月1日以降）
            $year -= 2018;
        } else if ($date >= 19890108) { //平成元年（1989年1月8日以降）
            $year -= 1988;
        } else if ($date >= 19261225) { //昭和元年（1926年12月25日以降）
            $year -= 1925;
        } else if ($date >= 19120730) { //大正元年（1912年7月30日以降）
            $year -= 1911;
        } else if ($date >= 18680125) { //明治元年（1868年1月25日以降）
            $year -= 1867;
        }

        $wareki = substr(sprintf("%04d", $year), 2, 2) . $md;

        return $wareki;
    }
    
    /**
     * 税込み金額を返す
     * @param int $price_without_tax 税抜き金額
     * @param int $tax_rate 税率(%)
     * @return int 税込み金額
     */
    public static function get_price_with_tax($price_without_tax, $tax_rate){
        $price_with_tax = $price_without_tax + floor( $price_without_tax * ($tax_rate / 100) );
        return $price_with_tax;
    }
    
    /**
     * 指定された月数分加算する
     *
     * @param DateTimeInterface $before 加算前のDateTimeオブジェクト
     * @param int 月数（指定ない場合は1ヶ月）
     * @return DateTime DateTimeオブジェクト
     */
    public static function add_month(DateTimeInterface $before, int $month = 1) {
        $beforeMonth = $before->format("n");
        
        // 加算する
        $after       = $before->add(new DateInterval("P" . $month . "M"));
        $afterMonth  = $after->format("n");
        
        // 加算結果が期待値と異なる場合は、前月の最終日に修正する
        $tmpAfterMonth = $beforeMonth + $month;
        $expectAfterMonth = $tmpAfterMonth > 12 ? $tmpAfterMonth - 12 : $tmpAfterMonth;
        
        if ($expectAfterMonth != $afterMonth) {
            $after = $after->modify("last day of last month");
        }
        
        return $after;
    }
    
    /**
     * 契約期間、終了日等を取得する
     * @param string $contract_start 契約開始日
     * @param int    $auto_renewal   自動更新
     * @param int    $contract_duration_month 契約期間
     * @param int    $device_type    端末種別
     * @param int    $renuwal_range       更新月の範囲(0は周期後の月のみ)
     * @param string $this_period_display_format 取得する日付のフォーマット(契約期間)
     * @param string $next_update_display_format 取得する日付のフォーマット(更新月)
     * @return array
     */
    public static function get_contract_period($contract_start
                                              ,$auto_renewal
                                              ,$contract_duration_month
                                              ,$device_type
                                              ,$renuwal_range = 1
                                              ,$this_period_display_format = 'Y年m月d日'
                                              ,$next_update_display_format = 'Y年m月')
    {
        $contract_start_immu = new DateTimeImmutable($contract_start);
        
        // 各日付を初期化
        $contract_period['next_contract_update_from']  = null; // 契約更新開始
        $contract_period['next_contract_update_to']    = null; // 契約更新終了
        $contract_period['contract_range_year']        = null; // 契約期間(年)
        $contract_period['this_contract_from']         = null; // 契約開始日
        $contract_period['this_contract_to']           = null; // 契約終了日

        // 契約開始月(日付計算ズレ対策もかねて1日扱い)
        $start_month_immu = new DateTimeImmutable($contract_start_immu->format('Y-m-01'));

        $now_date_immu = new DateTimeImmutable('now');

        // 契約開始からの経過月数を求める(現在日 と 契約開始日の差分)
        $date_diff = $start_month_immu->diff($now_date_immu);
        $diff_month_count = ($date_diff->format('%y') * 12) + $date_diff->format('%m');

        // 表示用経過月数取得(WiMAXは契約開始月が0か月目、WiFiは契約開始月が1か月目)
        $contract_after_month = self::get_contract_after_month($diff_month_count, $device_type);

        // フリープランは契約開始日と契約月数のみでよい
        if($contract_duration_month == 0){
            $contract_period['contract_after_month']      = $contract_after_month; // 契約後経過月数
            $contract_period['this_contract_period_from'] = $contract_start_immu->format($this_period_display_format);
            return $contract_period;
        }

        // 契約期間
        $end_period_display_format = str_replace('d', 't', $this_period_display_format);
        $this_contract_period = self::get_this_contract_period($auto_renewal, $contract_duration_month, $contract_start_immu, $start_month_immu, $diff_month_count);
        // 更新月
        // 月の最終日フォーマット(出力ファイルにdが指定された時に使う)
        $to_next_update_display_format = str_replace('d', 't', $next_update_display_format);
        $contract_update_month = self::get_contract_update_period($auto_renewal, $this_contract_period['to'], $contract_duration_month, $diff_month_count, $renuwal_range, $start_month_immu);

        $contract_period['contract_after_month']       = $contract_after_month; // 契約後経過月数
        $contract_period['this_contract_from']         = !is_null($this_contract_period['from']) ? $this_contract_period['from']->format($this_period_display_format) : null;  // 契約開始日
        $contract_period['this_contract_to']           = !is_null($this_contract_period['to']) ? $this_contract_period['to']->format($end_period_display_format) : null; // 契約終了日
        $contract_period['contract_range_year']        = $this_contract_period['contract_range_year']; // 契約期間(年)
        $contract_period['next_contract_update_from']  = !is_null($contract_update_month['from']) ? $contract_update_month['from']->format($next_update_display_format) : null; // 契約更新開始
        $contract_period['next_contract_update_to']    = !is_null($contract_update_month['to']) ? $contract_update_month['to']->format($to_next_update_display_format) : null;   // 契約更新終了

        return $contract_period;

    }
    
    /**
     * 契約期間の取得
     * @param string $auto_renewal
     * @param string $contract_duration_month
     * @param DateTimeImmutable $contract_start_immu
     * @param DateTimeImmutable $start_month_immu
     * @param int $diff_month_count 課金開始からの経過月数
     * @return array
     */
    public static function get_this_contract_period($auto_renewal
                                                   ,$contract_duration_month
                                                   ,$contract_start_immu
                                                   ,$start_month_immu
                                                   ,$diff_month_count)
    {
        
        $contract_period_range['from'] = null;
        $contract_period_range['to']   = null;
        $contract_period_range['contract_range_year'] = floor($contract_duration_month / 12);
        
        // 契約終了日(契約月を1ヵ月目として計算)
        $add_month = $contract_duration_month - 1;
        
        if($auto_renewal == FLG_OFF){
            // 自動更新ではないとき
            // 契約期間
            $contract_period_range['from'] = $contract_start_immu;
            $contract_period_range['to']   = $start_month_immu->modify("+{$add_month} months");
        } else {
            // 自動更新の時
            // 何回目の更新？
            $contract_period_count = floor($diff_month_count / $contract_duration_month);
            // 契約開始日 = スタート月 + (更新回数 * 契約月)
            $from_add_month = $contract_period_count * $contract_duration_month;
            $to_add_month = $from_add_month + $add_month;
            if($contract_period_count > 0){
                // 契約更新が行われている場合、、開始日は1日になる
                $contract_period_range['from'] = $start_month_immu->modify("+{$from_add_month} months");
                $contract_period_range['to'] = $start_month_immu->modify("+{$to_add_month} months");

            } else {
                $contract_period_range['from'] = $contract_start_immu;
                $contract_period_range['to']   = $start_month_immu->modify("+{$add_month} months");
            }

        }

        return $contract_period_range;
    }
    
    /**
     * 更新月の取得
     * @param String $auto_renewal
     * @param DateTimeImmutable $this_contract_to
     * @param String $contract_duration_month
     * @param int $diff_month_count
     * @param int $renuwal_range
     * @param DateTimeImmutable $start_month_immu
     * @return array
     */
    public static function get_contract_update_period($auto_renewal
                                                     ,$this_contract_to
                                                     ,$contract_duration_month
                                                     ,$diff_month_count
                                                     ,$renuwal_range
                                                     ,$start_month_immu)
    {

        $next_contract_update['from'] = null;
        $next_contract_update['to'] = null;

        // 自動更新判定
        if($auto_renewal == FLG_OFF){
            // 自動更新ではないとき
            $next_contract_update['from'] = $this_contract_to; // 契約終了日

        } else {
            // 自動更新の時
            $calc_diff_month_count = $diff_month_count +1;
            // 何回目の更新？
            $contract_period_count = floor($calc_diff_month_count / $contract_duration_month);
            // 契約何か月目
            $period_after_month = $calc_diff_month_count % $contract_duration_month;
            
            if($contract_period_count == 0){
                // 契約更新を迎えてない
                $next_period = 1;
            } elseif($period_after_month >= $renuwal_range){
                // 更新範囲期間内
                $next_period = 1;
            } else {
                $next_period = 0;
            }

            // 次回の更新月(契約月から何か月後)
            $next_period_month_to_count = ($contract_period_count + $next_period) * $contract_duration_month;
            $next_period_month_from_count = $next_period_month_to_count - $renuwal_range;

            // 更新月
            $next_contract_update['from'] = $start_month_immu->modify("+{$next_period_month_from_count} months");
            $next_contract_update['to']   = $start_month_immu->modify("+{$next_period_month_to_count} months");

        }

        return $next_contract_update;
    }
    
    /**
     * 契約後何か月目なのか取得する
     * @param int $diff_month_count
     * @param string $device_type
     * @return int
     */
    public static function get_contract_after_month($diff_month_count, $device_type){

        // 表示用経過月数(WiMAXは契約開始月が0か月目、WiFiは契約開始月が1か月目)
        switch($device_type){
            case DEVICE_TYPE_CLOUD:
                $display_month_start_count = 1;
                break;
            case DEVICE_TYPE_WIMAX:
                $display_month_start_count = 0;
                break;
        }

        $contract_after_month = $diff_month_count + $display_month_start_count;
        return $contract_after_month;
        
    }

    /**
     * ランダムな半角英数字を生成する
     *
     * @param int $digit
     *            桁数
     * @return string
     */
    public static function generate_random_alphanum($length)
    {
        $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
        $r_str = null;
        for ($i = 0; $i < $length; $i ++) {
            $r_str .= $str[rand(0, count($str) - 1)];
        }
        return $r_str;
    }

    /**
     * 登録時の不具合の原因となる文字列を置換する
     *
     * @param array $params 複数カラムを持つ連想配列
     * @return array $params 値部分を置換した後の配列
     */
    public static function replace_target_str($params) {
        $params = str_replace(',', '、', $params);  // 半角カンマ変換
        $params = str_replace("\t", '', $params);   // タブ文字削除
        return $params;
    }
}
