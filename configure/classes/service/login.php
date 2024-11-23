<?php

/**
 * ログインのサービスクラス
 */
class Service_Login extends Service_Base {

    public function get_check_login_user($email, $password, $is_api_login = false, $plan_type = PLAN_TYPE_DOMESTIC) {
        // ユーザーの存在チェック
        $service_login = new Service_Login();
        Log::application()->info('ユーザーの存在チェック処理');
        if (empty($email) || empty($password)) {
            // 会員IDもしくはパスワードを入力しなかった場合
            return ['error_code' => LOGIN_ERROR_CODE_LIST['INVALID_AUTH_INFO_CODE']];
        }
        $user_info = $service_login->get_user_login_info_by_email($email, BUSINESS_ID, $plan_type);
        // @TODO 会員IDの処理を復活させる場合は下記処理を復活させる↓
        // if (strpos($email, '@')) {
        //     // メールで会員IDでログインするべきかチェック 条件: メールと会員IDもNULLじゃないユーザーが入れたら、会員IDでログインさせる
        //     if (!$service_login->can_user_login_by_email($email, BUSINESS_ID)) {
        //         // ログイン画面にリダイレクト
        //         // エラー内容をセッションに一時格納
        //         return ['error_code' => LOGIN_ERROR_CODE_LIST['SHOULD_LOGIN_BY_USER_ID']];
        //     }
        //     $user_info = $service_login->get_user_login_info_by_email($email, BUSINESS_ID);
        // } else {
        //     if (empty($email) || empty($password)) {
        //         // 会員IDもしくはパスワードを入力しなかった場合
        //         return ['error_code' => LOGIN_ERROR_CODE_LIST['INVALID_AUTH_INFO_CODE']];
        //     }
        //     $user_info = $service_login->get_user_login_info_by_login_user_id($email, BUSINESS_ID);
        // }
        Log::application()->info('ユーザーの存在チェック処理完了');
        Log::application()->debug('取得結果', $user_info);

        if (empty($user_info)) {
            // ユーザー情報が存在しなかった場合
            return ['error_code' => LOGIN_ERROR_CODE_LIST['NOT_GET_USER_INFO_CODE']];
        }

        // 法人の場合はentry_planが存在せず、imei未連携の国内・海外レンタルユーザーの場合はrel_contract_planが存在しない
        // プラン種別チェックに漏れが出てしまうため、結びつくプランのプラン種別を厳密にチェックするようにする
        // 個人の場合はentry_plan、法人の場合はentry_companyのplan_idからplan_typeを取得
        // rel_contract_planがある場合はそちらから取得するplan_typeを、無い場合は上述のentryから取得したplan_typeを判定する
        $entry_plan_id = (int)$user_info['user_type'] === USER_TYPE_LIST['PRIVATE'] ? $user_info['entry_plan_type'] : $user_info['entry_company_plan_type'];
        $user_plan_type = !empty($user_info['plan_type']) ? $user_info['plan_type'] : $entry_plan_id;
        if ((int)$user_plan_type !== (int)$plan_type) {
            // 画面から受け取ったplan_typeと取得したユーザーのplan_typeが異なる場合
            return ['error_code' => LOGIN_ERROR_CODE_LIST['NOT_GET_USER_INFO_CODE']];
        }

        // パスワードのバリデーション
        $val = Validation::forge();
        $val->add('password', 'パスワード')->add_rule('required')
            ->add_rule('match_password', $user_info['password'], $user_info['salt']);

        if (!$val->run(['password' => $password])) {
            // 正しいパスワードが入力されていない場合
            return ['error_code' => LOGIN_ERROR_CODE_LIST['NO_MATCH_PASSWORD_CODE']];
        }

        // 加入中のオプション情報を取得し保険オプションの情報を抽出する
        $logic_rel_contract_option = new Logic_HumanLife_RelContractOption();
        $option_info = $logic_rel_contract_option->get_contract_option_info_list_by_contract_id($user_info['business_id'], $user_info['contract_id']);
        $option_info_insurance = $option_info[OPTION_TYPE_INSURANCE] ?? [];

        // 有効以外のステータス or エントリー時のステータスが申込み取り消しの場合は解約 @see FON_JP-633
        // 保険オプション利用者に限り、初期契約解除も受け入れる
        $is_allow_possible_user = (in_array((int)$user_info['status'], MYPAGE_LOGIN_ALLOW_POSSIBLE_USER_STATUS_LIST)
            || (count($option_info_insurance) > 0 && (int)$user_info['status'] === USER_STATUS_LIST['initial_contract_cancellation']));

        if ((int)$plan_type === PLAN_TYPE_DOMESTIC) {
            if (!$is_allow_possible_user
                || ((int)$user_info['user_type'] === USER_TYPE_LIST['PRIVATE'] && (int)$user_info['entry_status'] === ENTRY_STATUS_VALUE_LIST['WAITING_BILLING'])
            ) {
                return $is_api_login ? ['error_code' => LOGIN_ERROR_CODE_LIST['INVALID_USER_STATUS_CODE']] : ['error_code' => LOGIN_ERROR_CODE_LIST['CANCEL_USER']];
            }
        }

        // 通常ログインの場合チェック
        if (!$is_api_login) {
            // 個人ユーザでステータスが解約かつプランの終了日が設定されている場合
            // 保険オプション利用者に限り、初期契約解除も受け入れる
            /**
             * @TODO 海外プラン関連はプラン終了日がある場合がある
             */
            $is_cancel = (int)$user_info['status'] === USER_STATUS_LIST['withdraw']
                || (count($option_info_insurance) > 0 && (int)$user_info['status'] === USER_STATUS_LIST['initial_contract_cancellation']);

            if ((int)$user_info['user_type'] === USER_TYPE_LIST['PRIVATE'] && $is_cancel && $user_info['plan_end_date'] != NULL) {
                $current_date = new DateTime();
                $next_month_plan_end_date = new DateTime($user_info['plan_end_date']);
                $next_month_plan_end_date->modify('last day of next month');
                $user_info['insurance_only_flg'] = false;       // 保険オプションのみ継続フラグ
                $user_info['view_contract_plan_flg'] = true;    // 契約プラン情報表示フラグ

                // 保険オプションの各種チェック
                foreach ($option_info_insurance as $row) {
                    if (is_null($row['option_end_date'])) {
                        // 保険オプションのみ継続中
                        $user_info['insurance_only_flg'] = true;
                    } else {
                        $next_month_option_end_date = new DateTime($row['option_end_date']);
                        $next_month_option_end_date->modify('last day of next month');
                        // 保険オプション解約より2ヶ月経過すればログイン不可になる
                        $user_info['insurance_only_flg'] = ($next_month_option_end_date >= $current_date) ? true : false;
                    }
                    // 保険オプション継続によりログイン可能な状態であっても、回線プラン終了より一定月数を過ぎたらプラン情報を非表示にする
                    $view_contract_plan_end_date = new DateTime($user_info['plan_end_date']);
                    $view_contract_plan_end_date->modify('last day of +' . INSURANCE_VIEW_CONTRACT_PLAN_END_MONTH . ' month');
                    $user_info['view_contract_plan_flg'] = ($view_contract_plan_end_date >= $current_date) ? true : false;
                }

                // プラン解約の翌月末日を過ぎており、なおかつ保険オプション解約の翌月末日を過ぎている場合はログイン不可とする
                if ($next_month_plan_end_date < $current_date && $user_info['insurance_only_flg'] === false) {
                    return ['error_code' => LOGIN_ERROR_CODE_LIST['CANCEL_USER']];
                }
            } else if ((int)$user_info['user_type'] === USER_TYPE_LIST['CORPORATE'] && (int)$user_info['status'] === USER_STATUS_LIST['withdraw']) {
                // 法人ユーザでステータスが解約の場合はログイン不可とする
                return ['error_code' => LOGIN_ERROR_CODE_LIST['CANCEL_USER']];
            }
        }

        return ['user_info' => $user_info];
    }

    /**
     * emailでログイン可能な顧客情報を取得する
     *
     * @param  string $email
     * @param  int    $business_id
     * @return array
     */
    public function can_user_login_by_email($email, $business_id) {
        $logic_human_life_user = new Logic_HumanLife_User();
        return $logic_human_life_user->can_user_login_by_email($email, $business_id);

    }

}
