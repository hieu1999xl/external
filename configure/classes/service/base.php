<?php

/**
 * サービス基底クラス
 *
 * @author sakairi@liz-inc.co.jp
 *
 */
class Service_Base {
    /**
     * 利用終了日を返す
     *
     * @param int $plan_type
     * @param int $plan_id
     * @return string
     */
    public function get_calculate_use_end_date($plan_type = PLAN_TYPE_LIST['DOMESTIC'], $plan_id = '') {
        // 現在日時
        $current_date = date('Y-m-d');
        // 現在日のタイムスタンプ
        $timestamp = strtotime($current_date);
        // 現在日
        $current_day = date('d', $timestamp);

        if ($plan_type == PLAN_TYPE_LIST['DOMESTIC']) {
            // 国内プランの場合
            if ($current_day < CANCEL_CLOSE_DAY) {
                // 解約受付締め日より前の場合
                // 当月を利用終了日とする
                $use_end_date = date('Y-m-t 23:59:59', strtotime($current_date));
            } else {
                // 解約受付締め日以上の場合
                // 翌月初を利用終了日とする
                $use_end_date = date('Y-m-d 23:59:59', strtotime('last day of next month' . $current_date));
            }
        } else if ($plan_type == PLAN_TYPE_LIST['DOMESTIC_DATA_CHARGE']) {
            // データチャージプランの場合
            $use_end_date = date('Y-m-d 23:59:59', strtotime('last day of this month' . $current_date));
        } else if ($plan_type == PLAN_TYPE_LIST['INTERNATIONAL_BASE']) {
            // CHARGEプランの場合
            $last_day = date('d', strtotime('last day of this month' . $current_date));
            if ($current_day >= 5 && $last_day >= $current_day ) {
                $use_end_date = date('Y-m-d 23:59:59', strtotime('last day of +2 month' . $current_date));
            } else {
                $use_end_date = date('Y-m-d 23:59:59', strtotime('last day of next month' . $current_date));
            }
        } else {
            // 海外プランの場合
            $current_time = date('H:i:s');
            $base_datetime = date('Y-m-d ' . BASIC_START_TIME_OF_THE_DAY);
            // 当サービスにおける1日の開始日を過ぎているかどうか
            $is_passed_start_today_time = $this->is_passed_target_time($current_time);

            if ($is_passed_start_today_time) {
                $base_datetime = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($base_datetime)));
            }

            $international_prepaid_id_list = [
                PLAN_TYPE_LIST['INTERNATIONAL_PREPAID_1DAY_500MB'],
                PLAN_TYPE_LIST['INTERNATIONAL_PREPAID_1DAY_1GB'],
                PLAN_TYPE_LIST['INTERNATIONAL_PREPAID_UNLIMITED'],
            ];
            if ($plan_type == PLAN_TYPE_LIST['INTERNATIONAL_1DAY_300M'] || in_array($plan_type, $international_prepaid_id_list)) {
                // 海外プラン_1日の場合
                $use_end_date = $base_datetime;
            } else if ($plan_type == PLAN_TYPE_LIST['INTERNATIONAL_7DAY_1G'] || $plan_type == PLAN_TYPE_LIST['INTERNATIONAL_PREPAID_7DAY_1GB']) {
                // 海外プラン_7日の場合
                $use_end_date = date('Y-m-d H:i:s', strtotime('+7day', strtotime($base_datetime)));
            } else if ($plan_type == PLAN_TYPE_LIST['INTERNATIONAL_30DAY_3G'] || $plan_type == PLAN_TYPE_LIST['INTERNATIONAL_PREPAID_30DAY_3GB']) {
                // 海外プラン_30日の場合
                $use_end_date = date('Y-m-d H:i:s', strtotime('+30day', strtotime($base_datetime)));
            } else if ($plan_type == PLAN_TYPE_LIST['INTERNATIONAL_PREPAID_UNLIMITED']) {
                // 海外プリペイド(無制限)プラン
                $use_end_date = date('Y-m-d H:i:s', strtotime('+1year', strtotime($base_datetime)));
            } else if ($plan_type == PLAN_TYPE_LIST['INTERNATIONAL_BASE']) {
                // CHARGEプラン(プリペイド) 端末のみ
                $use_end_date = DOMESTIC_PLAN_END_DATETIME;
            } else {
                // CHARGEプラン(プリペイド)国内チャージ
                switch ($plan_id) {
                    // 国内30日の場合
                    case OVERSEAS_PREPAID_PLAN_30DAY_3GB_PLAN_ID:
                    case OVERSEAS_PREPAID_PLAN_30DAY_5GB_PLAN_ID:
                    case OVERSEAS_PREPAID_PLAN_30DAY_10GB_PLAN_ID:
                    case OVERSEAS_PREPAID_PLAN_30DAY_20GB_PLAN_ID:
                    case PREPAID_PLAN_30DAY_3GB_PLAN_ENTRY_ID:
                    case PREPAID_PLAN_30DAY_5GB_PLAN_ENTRY_ID:
                    case PREPAID_PLAN_30DAY_10GB_PLAN_ENTRY_ID:
                    case PREPAID_PLAN_30DAY_20GB_PLAN_ENTRY_ID:
                        $use_end_date = date('Y-m-d H:i:s', strtotime('+30day', strtotime($base_datetime)));
                        break;

                    // 国内60日の場合
                    case OVERSEAS_PREPAID_PLAN_60DAY_50GB_PLAN_ID:
                    case PREPAID_PLAN_60DAY_50GB_PLAN_ENTRY_ID:
                        $use_end_date = date('Y-m-d H:i:s', strtotime('+60day', strtotime($base_datetime)));
                        break;

                    // 国内90日の場合
                    case OVERSEAS_PREPAID_PLAN_90DAY_100GB_PLAN_ID:
                    case PREPAID_PLAN_90DAY_100GB_PLAN_ENTRY_ID:
                        $use_end_date = date('Y-m-d H:i:s', strtotime('+90day', strtotime($base_datetime)));
                        break;
                }
            }
        }
        return $use_end_date;
    }

    /**
     * 利用開始日を返す
     *
     * @param int $plan_type
     * @return string
     */
    public function get_calculate_use_start_date($plan_type = PLAN_TYPE_LIST['DOMESTIC']) {
        $current_date = date('Y-m-d');

        if ($plan_type == PLAN_TYPE_LIST['DOMESTIC']) {
            // 国内プランの場合
            $use_start_date = date('Y-m-01', strtotime($current_date . '+1 month'));
        } else {
            // 海外プランの場合
            $use_start_date = $current_date;
        }

        return $use_start_date;
    }

    /**
     * 当サービスにおける1日の開始時間を過ぎているかどうかを返す
     *
     * @param $target_time
     * @param $current_time
     * @return bool
     */
    private function is_passed_target_time($current_time, $target_time = BASIC_START_TIME_OF_THE_DAY) {
        $is_passed = false;

        if (strtotime($target_time) < strtotime($current_time)) {
            $is_passed = true;
        }

        return $is_passed;
    }

    /**
     * メールアドレスを条件にユーザー情報を取得する
     *
     * @param string $email
     * @param int    $business_id
     * @return array
     */
    public function get_user_info_by_email($email, $business_id) {
        // ユーザーの存在チェック
        $logic_human_life_user = new Logic_HumanLife_User();
        return $logic_human_life_user->get_user_info_by_email($email, $business_id);
    }

    /**
     * メールアドレスを条件にユーザー情報を取得する
     *
     * @param string $email
     * @param int    $business_id
     * @param int    $plan_type
     * @return array
     */
    public function get_user_login_info_by_email($email, $business_id, $plan_type=PLAN_TYPE_DOMESTIC) {
        // ユーザーの存在チェック
        $logic_human_life_user = new Logic_HumanLife_User();
        return $logic_human_life_user->get_user_login_info_by_email($email, $business_id, $plan_type);
    }

    /**
     * メールアドレスを条件にユーザー情報を取得する
     *
     * @param string $login_user_id
     * @param int    $business_id
     * @return array
     */
    public function get_user_login_info_by_login_user_id($login_user_id, $business_id) {
        // ユーザーの存在チェック
        $logic_humanlife_mstplan = new Logic_HumanLife_User();
        return $logic_humanlife_mstplan->get_user_login_info_by_login_user_id($login_user_id, $business_id);
    }

    public function get_can_charge_data($user_id) {
        $logic_humanlife_mstplan = new Logic_HumanLife_MstPlan();
        $result_data = $logic_humanlife_mstplan->get_can_charge_data($user_id);
        return count($result_data) > 0;
    }

    /**
     * ハッシュを条件にユーザー情報を取得する
     *
     * @param string $telephone_entry_hash
     * @return array
     */
    public static function get_user_info_by_telephone_entry_hash($telephone_entry_hash) {
        // ユーザーの存在チェック
        $logic_human_life_user = new Logic_HumanLife_User();
        return $logic_human_life_user->get_user_info_by_telephone_entry_hash($telephone_entry_hash);
    }


    /**
     * 先月分の利用料を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return int
     */
    public function get_last_month_use_amount($user_id, $business_id) {
        $logic_human_life_user = new Logic_HumanLife_User();

        $res = 0;

        // 先月
        $current_month = date('Y-m', strtotime(date('Y-m-1') . '-1 month'));
        // 先月初日
        $last_month_first_date = date('Y-m-d', strtotime('first day of ' . $current_month));
        // 先月末日
        $last_month_last_date = date('Y-m-d', strtotime('last day of ' . $current_month));

        $rel_contract_info_list = $logic_human_life_user->get_rel_contract_info_list_by_target_range_date($user_id, $business_id, $last_month_first_date, $last_month_last_date);

        // 先月利用分のプランを計算
        foreach ($rel_contract_info_list['contract_plan_info_list'] as $contract_plan_info) {
            $res += (int)$contract_plan_info['price'];
        }

        // 先月利用分のオプションを計算
        foreach ($rel_contract_info_list['contract_option_info_list'] as $contract_option_info) {
            $res += (int)$contract_option_info['price'];
        }

        return $res;
    }

    /**
     * 税込み額を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return int
     */
    public function calc_amount_with_tax($plan_info) {
        $logic_mst_tax = new Logic_HumanLife_MstTax();

        // 税区分から総額を計算する
        // 非課税
        if ($plan_info['tax_type'] == TAX_TYPE_VALUE_LIST['EXEMPT']) {
            $tax_price = NULL;
            $amount = $plan_info['price'];
        // 税込み
        } elseif ($plan_info['tax_type'] == TAX_TYPE_VALUE_LIST['INCLUDED']) {
            $tax_price = NULL;
            $amount = $plan_info['price'];
        // 税別
        } else {
            $tax_price = $logic_mst_tax->culculate_tax($plan_info['price']);
            $amount = (int)$plan_info['price'] + $tax_price;
        }

        return $amount;
    }

    /**
     * 海外レンタルプランの金額を計算する
     *
     * @param int $plan_price プラン金額
     * @param int $rental_days レンタル日数
     * @return int レンタル金額
     */
    public static function get_overseas_rental_price($plan_price, $rental_days=1) {
        // TODO：現状は縛りなしの短期レンタルのように期間ごとに計算式が変わることは無い。もし今後条件が追加されたらここに分岐を書き足すこと。
        return (int)$plan_price * (int)$rental_days;
    }

    /**
     * PHPの「mb_convert_kana」風文字列置換え（半角マイナス対応）
     *
     *
     * @param String $str 変換する文字列
     * @param String $opt 変換オプション
     *
     * @return String 変換された文字列
     */
    public function convertKanaAll($str = '', $opt = '')
    {
        /**
         * 入力文字列の揺らぎの修正を主な目的としていますので「mb_convert_kana」とは
         * 異なります。
         *
         * オプション文字列の先頭から変換関数を順番に実行していきます。
         *
         * 再変換時に元の文字列に戻る保障はありません。
         * 文字数が変わる可能性があります。
         * 「濁点」「半濁点」の揺らぎの修正をデフォルトで行います。
         * 「ゕゖ」を「ヵヶ」にデフォルトで変換します。
         * 「水平タブ(HT)」をスペース4文字に展開します。
         * 「改行(LF)」以外の制御文字を空文字に変換します。
         * 半角カタカナは全角カタカナに置き換えられます。
         *
         * オプションの相違点
         * 「h」「H」「K」「k」は存在しません。半角カタカナはデフォルトで
         * 全角カタカナに変換されます。
         * 「V」は「う濁」から「は濁」への変換となります。
         *
         * ひらがなに無いカタカナは変換しません。
         * 「ㇰ」「ㇱ」「ㇲ」「ㇳ」「ㇴ」「ㇵ」「ㇶ」「ㇷ」
         * 「ㇸ」「ㇹ」「ㇺ」「ㇻ」「ㇼ」「ㇽ」「ㇾ」「ㇿ」
         *
         * 合成できなかった濁点・半濁点は単独の濁点(U+309B)・半濁点(U+309C)になります。
         * NFKC正規化では「U+3099（゙）」「U+309A（゚）」ですがフォントによっては
         * うまく表示されないための対処です。
         * 「mb_convert_kana」と同じ処理になります。
         *
         * http://hydrocul.github.io/wiki/blog/2014/1127-unicode-nfkd-mb-convert-kana.html
         *
         * オプションで使用する文字列
         * r: 「全角」英字を「半角」に変換します。
         * R: 「半角」英字を「全角」に変換します。
         * n: 「全角」数字を「半角」に変換します。
         * N: 「半角」数字を「全角」に変換します。
         * a: 「全角」英数字記号を「半角」に変換します。
         * A: 「半角」英数字記号を「全角」に変換します。
         * s: 「全角」スペースを「半角」に変換します（U+3000 -> U+0020）。
         * S: 「半角」スペースを「全角」に変換します（U+0020 -> U+3000）。
         * c: 「全角カタカナ」を「全角ひらがな」に変換します。
         * C: 「全角ひらがな」を「全角カタカナ」に変換します。
         * v: 「う濁」を「は濁」に変換します。
         * V: 「ウ濁」を「ハ濁」に変換します。
         * Q: 「半角」クォーテーション、「半角」アポストロフィを「全角」に変換します。
         * q: 「全角」クォーテーション、「全角」アポストロフィを「半角」に変換します。
         * B: 「半角」バックスラッシュを「全角」に変換します。
         * b: 「全角」バックスラッシュを「半角」に変換します。
         * T: 「半角」チルダを「全角」にチルダ変換します。
         * t: 「全角」チルダを「半角」チルダに変換します。
         * W: 全角「波ダッシュ」を全角「チルダ」に変換します。
         * w: 全角「チルダ」を全角「波ダッシュ」に変換します。
         * P: 「ハイフン、ダッシュ、マイナス」を「全角ハイフンマイナス」に変換します。（U+FF0D）
         * p: 「ハイフン、ダッシュ、マイナス」を「半角ハイフンマイナス」に変換します。（U+002D）
         * U: 「U+0021」～「U+007E」以外の「半角」記号を「全角」記号に変換します。
         * u: 「U+0021」～「U+007E」以外の「全角」記号を「半角」記号に変換します。
         * X: 「カッコ付き文字」を「半角括弧と中の文字」に展開します。
         * Y: 集合文字を展開します。（単位文字以外）
         * Z: 小字形文字を大文字に変換します。（U+FE50～U+FE6B）
         */
        // 変換する文字・オプションが文字列でない場合はそのまま返す
        if (!is_string($str) or ! is_string($opt)) {
            return $str;
        }

        /** ------------------------------------------------------------------------
         * ここから文字の揺らぎを修正する初期化関数です。
         * ---------------------------------------------------------------------- */
        $init = function() use(&$str) {
            // 「水平タブ(HT)」をスペース4文字に展開します。
            // 「ゕゖ」を「ヵヶ」に変換します。
            // 「U+3099（゙）」「U+309A（゚）」を単独の濁点
            // 「U+309B（゛）」「U+309C（゜）」に変換します。
            $src = array("\t", '゙', '゚', 'ゕ', 'ゖ');
            $rep = array('    ', '゛', '゜', 'ヵ', 'ヶ');
            $str = str_replace($src, $rep, $str);

            // 半角カタカナを全角カタカナに変換します。
            $str = mb_convert_kana($str, 'KV');

            // 「改行(LF)」以外の制御文字を空文字に変換します。
            $str = preg_replace('/[\x00-\x09\x0b-\x1f\x7f-\x9f]/u', '', $str);
            // unicodoの制御文字を空文字に変換します。
            $decoded = json_decode(
                            '["' .
                            '\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007' .
                            '\u2008\u2009\u200A\u200B\u200C\u200D\u200E\u200F' .
                            '\u2028\u2029\u202A\u202B\u202C\u202D\u202E' .
                            '\u2060' .
                            '\u206A\u206B\u206C\u206D\u206E\u206F' .
                            '\uFFF9\uFFFA\uFFFB' .
                            '"]', true)[0];
            $str = str_replace($decoded, '', $str);

            // 濁点・半濁点付きの文字を一文字に変換します。
            //
            // 「ゔ」は「う゛」に展開されます。
            // 「わ゛」は「う゛ぁ」に変換されます。
            // 「ゐ゛」は「う゛ぃ」に変換されます。
            // 「ゑ゛」は「う゛ぇ」に変換されます。
            // 「を゛」は「う゛ぉ」に変換されます。
            // 「ヷ」「ワ゛」は「ヴァ」に展開されます。
            // 「ヸ」「ヰ゛」は「ヴィ」に展開されます。
            // 「ヹ」「ヱ゛」は「ヴェ」に展開されます。
            // 「ヺ」「ヲ゛」は「ヴォ」に展開されます。
            $multi = array(
                'か゛', 'き゛', 'く゛', 'け゛', 'こ゛',
                'さ゛', 'し゛', 'す゛', 'せ゛', 'そ゛',
                'た゛', 'ち゛', 'つ゛', 'て゛', 'と゛',
                'は゛', 'ひ゛', 'ふ゛', 'へ゛', 'ほ゛',
                'は゜', 'ひ゜', 'ふ゜', 'へ゜', 'ほ゜',
                'ゔ', 'ゝ゛',
                'わ゛', 'ゐ゛', 'ゑ゛', 'を゛',
                'カ゛', 'キ゛', 'ク゛', 'ケ゛', 'コ゛',
                'サ゛', 'シ゛', 'ス゛', 'セ゛', 'ソ゛',
                'タ゛', 'チ゛', 'ツ゛', 'テ゛', 'ト゛',
                'ハ゛', 'ヒ゛', 'フ゛', 'ヘ゛', 'ホ゛',
                'ハ゜', 'ヒ゜', 'フ゜', 'ヘ゜', 'ホ゜',
                'ウ゛', 'ヽ゛',
                'ワ゛', 'ヰ゛', 'ヱ゛', 'ヲ゛',
                'ヷ', 'ヸ', 'ヹ', 'ヺ'
            );
            $single = array(
                'が', 'ぎ', 'ぐ', 'げ', 'ご',
                'ざ', 'じ', 'ず', 'ぜ', 'ぞ',
                'だ', 'ぢ', 'づ', 'で', 'ど',
                'ば', 'び', 'ぶ', 'べ', 'ぼ',
                'ぱ', 'ぴ', 'ぷ', 'ぺ', 'ぽ',
                'う゛', 'ゞ',
                'う゛ぁ', 'う゛ぃ', 'う゛ぇ', 'う゛ぉ',
                'ガ', 'ギ', 'グ', 'ゲ', 'ゴ',
                'ザ', 'ジ', 'ズ', 'ゼ', 'ゾ',
                'ダ', 'ヂ', 'ヅ', 'デ', 'ド',
                'バ', 'ビ', 'ブ', 'ベ', 'ボ',
                'パ', 'ピ', 'プ', 'ペ', 'ポ',
                'ヴ', 'ヾ',
                'ヴァ', 'ヴィ', 'ヴェ', 'ヴォ',
                'ヴァ', 'ヴィ', 'ヴェ', 'ヴォ'
            );

            $str = str_replace($multi, $single, $str);
        };

        /** ------------------------------------------------------------------------
         * ここからオプションの文字により変換を行う関数です。
         * ---------------------------------------------------------------------- */
        $convert = function($s) use(&$str) {
            switch ($s) {
                // r: 「全角」英字を「半角」に変換します。
                case 'r':
                    $str = mb_convert_kana($str, 'r');
                    break;

                // R: 「半角」英字を「全角」に変換します。
                case 'R':
                    $str = mb_convert_kana($str, 'R');
                    break;

                // n: 「全角」数字を「半角」に変換します。
                case 'n':
                    $str = mb_convert_kana($str, 'n');
                    break;

                // N: 「半角」数字を「全角」に変換します。
                case 'N':
                    $str = mb_convert_kana($str, 'N');
                    break;

                // a: 「全角」英数字記号を「半角」に変換します。
                //
                // "a", "A" オプションに含まれる文字は、
                // U+0022, U+0027, U+005C, U+007Eを除く（" ' \ ~ ）
                // U+0021 - U+007E の範囲です。
                case 'a':
                    $str = mb_convert_kana($str, 'a');
                    break;

                // A: 「半角」英数字記号を「全角」に変換します 。
                //
                // "a", "A" オプションに含まれる文字は、
                // U+0022, U+0027, U+005C, U+007Eを除く（" ' \ ~ ）
                // U+0021 - U+007E の範囲です。
                case 'A':
                    $str = mb_convert_kana($str, 'A');
                    break;

                // s: 「全角」スペースを「半角」に変換します（U+3000 -> U+0020）。
                case 's':
                    $str = mb_convert_kana($str, 's');
                    break;

                // S: 「半角」スペースを「全角」に変換します（U+0020 -> U+3000）。
                case 'S':
                    $str = mb_convert_kana($str, 'S');
                    break;

                // c: 「全角カタカナ」を「全角ひらがな」に変換します。
                //
                // 「ヽヾ」は「ゝゞ」に変換されます。
                // 「ヴ」は「う゛」に展開されます。
                // 「ヶ」は変換されません。（変換先が「か」「が」「こ」の複数あるため）
                // 「ヵ」は「か」に変換されます。
                // http://www.wikiwand.com/ja/%E6%8D%A8%E3%81%A6%E4%BB%AE%E5%90%8D
                case 'c':
                    $str = mb_convert_kana($str, 'c');
                    $kana = array('ヴ', 'ヵ', 'ヽ', 'ヾ');
                    $hira = array('う゛', 'か', 'ゝ', 'ゞ');
                    $str = str_replace($kana, $hira, $str);
                    break;

                // C: 「全角ひらがな」を「全角カタカナ」に変換します。
                //
                // 「ゝゞ」は「ヽヾ」に変換されます。
                // 「う゛」は「ヴ」に結合されます。
                case 'C':
                    $str = mb_convert_kana($str, 'C');
                    $hira = array('ウ゛', 'ゝ', 'ゞ');
                    $kana = array('ヴ', 'ヽ', 'ヾ');
                    $str = str_replace($hira, $kana, $str);
                    break;

                // v: 「う濁」を「は濁」に変換します。
                //
                // 「う゛ぁ」「う゛ぃ」「う゛」「う゛ぇ」「う゛ぉ」を
                // 「ば」「び」「ぶ」「べ」「ぼ」に変換します。
                case 'v':
                    $udaku = array(
                        'う゛ぁ', 'う゛ぃ', 'う゛ぇ', 'う゛ぉ', 'う゛',
                        'ゔぁ', 'ゔぃ', 'ゔぇ', 'ゔぉ', 'ゔ'
                    );
                    $hadaku = array(
                        'ば', 'び', 'べ', 'ぼ', 'ぶ',
                        'ば', 'び', 'べ', 'ぼ', 'ぶ'
                    );
                    $str = str_replace($udaku, $hadaku, $str);
                    break;

                // V: 「ウ濁」を「ハ濁」に変換します。
                //
                // 「ヴァ」「ヴィ」「ヴ」「ヴェ」「ヴォ」を
                // 「バ」「ビ」「ブ」「ベ」「ボ」に変換します。
                case 'V':
                    $udaku = array(
                        'ウ゛ァ', 'ウ゛ィ', 'ウ゛ェ', 'ウ゛ォ', 'ウ゛',
                        'ヴァ', 'ヴィ', 'ヴェ', 'ヴォ', 'ヴ'
                    );
                    $hadaku = array(
                        'バ', 'ビ', 'ベ', 'ボ', 'ブ',
                        'バ', 'ビ', 'ベ', 'ボ', 'ブ'
                    );
                    $str = str_replace($udaku, $hadaku, $str);
                    break;

                // Q: 半角クォーテーション、半角アポストロフィを全角に変換します。
                case 'Q':
                    $han = array('"', "'");
                    $zen = array('＂', '＇');
                    $str = str_replace($han, $zen, $str);
                    break;

                // q: 全角クォーテーション、全角アポストロフィを半角に変換します。
                case 'q':
                    $han = array('"', "'");
                    $zen = array('＂', '＇');
                    $str = str_replace($zen, $han, $str);
                    break;

                // B: 半角バックスラッシュを全角に変換します。
                case 'B':
                    $han = "\\";
                    $zen = '＼';
                    $str = str_replace($han, $zen, $str);
                    break;

                // b: 全角バックスラッシュを半角に変換します。
                case 'b':
                    $han = "\\";
                    $zen = '＼';
                    $str = str_replace($zen, $han, $str);
                    break;

                // T: 半角チルダを全角にチルダ変換します。
                case 'T':
                    $han = '~';
                    $zen = '～';
                    $str = str_replace($han, $zen, $str);
                    break;

                // t: 全角チルダを半角チルダに変換します。
                case 't':
                    $han = '~';
                    $zen = '～';
                    $str = str_replace($zen, $han, $str);
                    break;

                // W: 全角波ダッシュを全角チルダに変換します。
                case 'W':
                    $nami = '〜';
                    $tilde = '～';
                    $str = str_replace($nami, $tilde, $str);
                    break;

                // w: 全角チルダを全角波ダッシュに変換します。
                case 'w':
                    $nami = '〜';
                    $tilde = '～';
                    $str = str_replace($tilde, $nami, $str);
                    break;

                // P: ハイフン、ダッシュ、マイナスを全角ハイフンマイナスに変換します。（U+FF0D）
                //    英数記号の後ろにある全角・半角長音符も含む
                //
                // http://hydrocul.github.io/wiki/blog/2014/1101-hyphen-minus-wave-tilde.html
                //    「U+002D」半角ハイフンマイナス
                //    「U+FE63」小さいハイフンマイナス。NFKD/NFKC正規化で U+002D
                //    「U+FF0D」全角ハイフンマイナス
                //    「U+2212」「U+207B」「U+208B」マイナス
                //    「U+2010」「U+2011」ハイフン
                //    「U+2012」～「U+2015」「U+FE58」ダッシュ
                case 'P':
                    $phyhen = array(
                        '-', '﹣', '－', '−', '⁻', '₋',
                        '‐', '‑', '‒', '–', '—', '―', '﹘'
                    );
                    $change = '－';
                    $str = str_replace($phyhen, $change, $str);
                    $str = preg_replace('/([!-~！-～])(ー|ｰ)/u', '$1' . $change, $str);
                    break;

                // p: ハイフン、ダッシュ、マイナスを半角ハイフンマイナスに変換します。（U+002D）
                //    英数記号の後ろにある全角・半角長音符も含む
                //
                // http://hydrocul.github.io/wiki/blog/2014/1101-hyphen-minus-wave-tilde.html
                //    「U+002D」半角ハイフンマイナス
                //    「U+FE63」小さいハイフンマイナス。NFKD/NFKC正規化で U+002D
                //    「U+FF0D」全角ハイフンマイナス
                //    「U+2212」「U+207B」「U+208B」マイナス
                //    「U+2010」「U+2011」ハイフン
                //    「U+2012」～「U+2015」「U+FE58」ダッシュ
                case 'p':
                    $phyhen = array(
                        '-', '﹣', '－', '−', '⁻', '₋',
                        '‐', '‑', '‒', '–', '—', '―', '﹘'
                    );
                    $change = '-';
                    $str = str_replace($phyhen, $change, $str);
                    $str = preg_replace('/([!-~！-～])(ー|ｰ)/u', '$1' . $change, $str);
                    break;

                // U: 「U+0021」～「U+007E」以外の「半角」記号を「全角」記号に変換します。
                //
                // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/uff00.html
                case 'U':
                    $han = array(
                        '⦅', '⦆', '¢', '£', '¬', '¯', '¦', '¥',
                        '₩', '￨', '￩', '￪', '￫', '￬', '￭', '￮'
                    );
                    $zen = array(
                        '｟', '｠', '￠', '￡', '￢', '￣', '￤', '￥',
                        '￦', '│', '←', '↑', '→', '↓', '■', '○'
                    );
                    $str = str_replace($han, $zen, $str);
                    break;

                // u: 「U+0021」～「U+007E」以外の「全角」記号を「半角」記号に変換します。
                //
                // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/uff00.html
                case 'u':
                    $han = array(
                        '⦅', '⦆', '¢', '£', '¬', '¯', '¦', '¥',
                        '₩', '￨', '￩', '￪', '￫', '￬', '￭', '￮'
                    );
                    $zen = array(
                        '｟', '｠', '￠', '￡', '￢', '￣', '￤', '￥',
                        '￦', '│', '←', '↑', '→', '↓', '■', '○'
                    );
                    $str = str_replace($zen, $han, $str);
                    break;

                // X: カッコ付き文字を半角括弧と中の文字に展開します。
                //
                // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/u2460.html
                // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/u3200.html
                case 'X':
                    $single = array(
                        '⑴', '⑵', '⑶', '⑷', '⑸',
                        '⑹', '⑺', '⑻', '⑼', '⑽',
                        '⑾', '⑿', '⒀', '⒁', '⒂',
                        '⒃', '⒄', '⒅', '⒆', '⒇',
                        '⒜', '⒝', '⒞', '⒟', '⒠', '⒡', '⒢', '⒣',
                        '⒤', '⒥', '⒦', '⒧', '⒨', '⒩', '⒪', '⒫',
                        '⒬', '⒭', '⒮', '⒯', '⒰', '⒱', '⒲', '⒳',
                        '⒴', '⒵',
                        '㈠', '㈡', '㈢', '㈣', '㈤',
                        '㈥', '㈦', '㈧', '㈨', '㈩',
                        '㈪', '㈫', '㈬', '㈭', '㈮', '㈯', '㈰',
                        '㈱', '㈲', '㈳', '㈴', '㈵', '㈶', '㈷',
                        '㈸', '㈹', '㈺', '㈻', '㈼', '㈽', '㈾',
                        '㈿', '㉀', '㉁', '㉂', '㉃'
                    );
                    $multi = array(
                        '(1)', '(2)', '(3)', '(4)', '(5)',
                        '(6)', '(7)', '(8)', '(9)', '(10)',
                        '(11)', '(12)', '(13)', '(14)', '(15)',
                        '(16)', '(17)', '(18)', '(19)', '(20)',
                        '(a)', '(b)', '(c)', '(d)', '(e)', '(f)', '(g)', '(h)',
                        '(i)', '(j)', '(k)', '(l)', '(m)', '(n)', '(o)', '(p)',
                        '(q)', '(r)', '(s)', '(t)', '(u)', '(v)', '(w)', '(x)',
                        '(y)', '(z)',
                        '(一)', '(二)', '(三)', '(四)', '(五)',
                        '(六)', '(七)', '(八)', '(九)', '(十)',
                        '(月)', '(火)', '(水)', '(木)', '(金)', '(土)', '(日)',
                        '(株)', '(有)', '(社)', '(名)', '(特)', '(財)', '(祝)',
                        '(労)', '(代)', '(呼)', '(学)', '(監)', '(企)', '(資)',
                        '(協)', '(祭)', '(休)', '(自)', '(至)'
                    );
                    $str = str_replace($single, $multi, $str);
                    break;

                // Y: 集合文字を展開します。（単位文字以外）
                //
                // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/u2460.html
                // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/u3200.html
                // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/u3300.html
                case 'Y':
                    $single = array(
                        '㌀', '㌁', '㌂', '㌃', '㌄', '㌅',
                        '㌆', '㌇', '㌈', '㌉', '㌊', '㌋',
                        '㌌', '㌍', '㌎', '㌏', '㌐', '㌑', '㌒',
                        '㌓', '㌔', '㌕', '㌖', '㌗', '㌘',
                        '㌙', '㌚', '㌛', '㌜', '㌝', '㌞',
                        '㌟', '㌠', '㌡', '㌢', '㌣', '㌤',
                        '㌥', '㌦', '㌧', '㌨', '㌩', '㌪', '㌫',
                        '㌬', '㌭', '㌮', '㌯', '㌰', '㌱', '㌲',
                        '㌳', '㌴', '㌵', '㌶', '㌷', '㌸',
                        '㌹', '㌺', '㌻', '㌼', '㌽', '㌾', '㌿',
                        '㍀', '㍁', '㍂', '㍃', '㍄', '㍅', '㍆',
                        '㍇', '㍈', '㍉', '㍊', '㍋', '㍌',
                        '㍍', '㍎', '㍏', '㍐', '㍑', '㍒', '㍓',
                        '㍔', '㍕', '㍖', '㍗',
                        '㍿', '㍻', '㍼', '㍽', '㍾',
                        '㋀', '㋁', '㋂', '㋃', '㋄', '㋅',
                        '㋆', '㋇', '㋈', '㋉', '㋊', '㋋',
                        '㏠', '㏡', '㏢', '㏣', '㏤',
                        '㏥', '㏦', '㏧', '㏨', '㏩',
                        '㏪', '㏫', '㏬', '㏭', '㏮',
                        '㏯', '㏰', '㏱', '㏲', '㏳',
                        '㏴', '㏵', '㏶', '㏷', '㏸',
                        '㏹', '㏺', '㏻', '㏼', '㏽', '㏾',
                        '㍘', '㍙', '㍚', '㍛', '㍜', '㍝',
                        '㍞', '㍟', '㍠', '㍡', '㍢',
                        '㍣', '㍤', '㍥', '㍦', '㍧',
                        '㍨', '㍩', '㍪', '㍫', '㍬',
                        '㍭', '㍮', '㍯', '㍰',
                        '⒈', '⒉', '⒊', '⒋', '⒌', '⒍', '⒎', '⒏', '⒐', '⒑',
                        '⒒', '⒓', '⒔', '⒕', '⒖', '⒗', '⒘', '⒙', '⒚', '⒛',
                        '№', '℡', '㏍', '㏇', '㏂', '㏘'
                    );
                    $multi = array(
                        'アパート', 'アルファ', 'アンペア', 'アール', 'イニング', 'インチ',
                        'ウォン', 'エスクード', 'エーカー', 'オンス', 'オーム', 'カイリ',
                        'カラット', 'カロリー', 'ガロン', 'ガンマ', 'ギガ', 'ギニー', 'キュリー',
                        'ギルダー', 'キロ', 'キログラム', 'キロメートル', 'キロワット', 'グラム',
                        'グラムトン', 'クルゼイロ', 'クローネ', 'ケース', 'コルナ', 'コーポ',
                        'サイクル', 'サンチーム', 'シリング', 'センチ', 'セント', 'ダース',
                        'デシ', 'ドル', 'トン', 'ナノ', 'ノット', 'ハイツ', 'パーセント',
                        'パーツ', 'バーレル', 'ピアストル', 'ピクル', 'ピコ', 'ビル', 'ファラッド',
                        'フィート', 'ブッシェル', 'フラン', 'ヘクタール', 'ペソ', 'ペニヒ',
                        'ヘルツ', 'ペンス', 'ページ', 'ベータ', 'ポイント', 'ボルト', 'ホン',
                        'ポンド', 'ホール', 'ホーン', 'マイクロ', 'マイル', 'マッハ', 'マルク',
                        'マンション', 'ミクロン', 'ミリ', 'ミリバール', 'メガ', 'メガトン',
                        'メートル', 'ヤード', 'ヤール', 'ユアン', 'リットル', 'リラ', 'ルピー',
                        'ルーブル', 'レム', 'レントゲン', 'ワット',
                        '株式会社', '平成', '昭和', '大正', '明治',
                        '1月', '2月', '3月', '4月', '5月', '6月',
                        '7月', '8月', '9月', '10月', '11月', '12月',
                        '1日', '2日', '3日', '4日', '5日',
                        '6日', '7日', '8日', '9日', '10日',
                        '11日', '12日', '13日', '14日', '15日',
                        '16日', '17日', '18日', '19日', '20日',
                        '21日', '22日', '23日', '24日', '25日',
                        '26日', '27日', '28日', '29日', '30日', '31日',
                        '0点', '1点', '2点', '3点', '4点', '5点',
                        '6点', '7点', '8点', '9点', '10点',
                        '11点', '12点', '13点', '14点', '15点',
                        '16点', '17点', '18点', '19点', '20点',
                        '21点', '22点', '23点', '24点',
                        '1.', '2.', '3.', '4.', '5.', '6.', '7.', '8.', '9.', '10.',
                        '11.', '12.', '13.', '14.', '15.', '16.', '17.', '18.', '19.',
                        '20.',
                        'No.', 'TEL', 'K.K.', 'Co.', 'a.m.', 'p.m.'
                    );
                    $str = str_replace($single, $multi, $str);
                    break;

                // 「未使用」カッコの変換ではないです！！カッコはdefaultで対応済み
                // Z: 小字形文字を大文字に変換します。（U+FE50～U+FE6B）
                // 「﹐﹑﹒﹔﹕﹖﹗﹘﹙﹚﹛﹜﹝﹞﹟﹠﹡﹢﹣﹤﹥﹦﹨﹩﹪﹫」
                //
                // 「U+FF58」は「U+2014」へマッピングされていますが、揺らぎの訂正のため
                // 「U+002D（半角ハイフンマイナス）」に変換します。
                //
                // http://www.asahi-net.or.jp/~ax2s-kmtn/ref/unicode/ufe50.html
                case 'Z':
                    $small = array(
                        '﹐', '﹑', '﹒', '﹔', '﹕', '﹖', '﹗', '﹘', '﹙', '﹚',
                        '﹛', '﹜', '﹝', '﹞', '﹟', '﹠', '﹡', '﹢', '﹣',
                        '﹤', '﹥', '﹦', '﹨', '﹩', '﹪', '﹫'
                    );
                    $big = array(
                        ',', '、', '.', ';', ':', '?', '!', '-', '(', ')',
                        '{', '}', '〔', '〕', '#', '&', '*', '+', '-',
                        '<', '>', '=', "\\", '$', '%', '@'
                    );
                    $str = str_replace($small, $big, $str);
                    break;
                default :
                    break;
            }
        };

        // 文字列の初期化（揺らぎの訂正）を行ないます
        $init();
        // オプション文字列を分解して一文字ごとに$convertを実行します
        array_map($convert, str_split($opt));

        return $str;
    }

    /**
     * UCLから返ってくるタイムスタンプを指定のフォーマット+日本時間に変換して返却する
     *
     * @param  int    $ucl_timestamp UCLから返ってくるタイムスタンプ(GMT0の13桁のミリ秒)
     * @param  string $format        DateTimeでフォーマットする日付の形式
     * @return string フォーマットされた日付
     */
    function format_ucl_timestamp($ucl_timestamp, $format) {
        $timestamp = floor($ucl_timestamp / 1000);
        $datetime = new DateTime('@' . $timestamp);
        $datetime->setTimezone(new DateTimeZone('Asia/Tokyo'));
        return $datetime->format($format);
    }
}
