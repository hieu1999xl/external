<?php

/**
 * 本人確認クラス
 */
class Controller_Password_Forget extends Controller_Base {
    /**
     * {@inheritDoc}
     *
     * @see \Fuel\Core\Controller::before()
     */
    public function before() {
        // 未ログインの場合にのみアクセス可能
        $this->not_login_access_only = true;
        parent::before();
    }

    /**
     * 本人確認画面
     *
     * @return \Fuel\Core\Response
     */
    public function get_forget() {
        Log::application()->info('本人確認画面表示処理開始');

        // CSRFトークンの生成
        $csrf_token = Security::fetch_token();

        Log::application()->info('本人確認画面表示処理終了');

        return $this->view('password/forget/forget', [
            'forget_url'  => Router::get('forget'),
            'csrf_token'  => $csrf_token,
            'title'       => Config::get('title.forget_password'),
            'cssfile'     => Config::get('cssfile.forget_password'),
            'description' => Config::get('description.forget_password'),
        ]);
    }

    /**
     * 本人確認処理
     */
    public function post_forget() {
        Log::application()->info('本人確認処理開始');

        // CSRFトークンの検証
        $this->check_csrf_token(Router::get('forget'));

        // メールアドレスのバリデーションチェック
        $val = Validation::forge();
        $val->add('email', 'メールアドレス')
            ->add_rule('required');

        if (!$val->run()) {
            // メールアドレスのバリデーションでエラーがあった場合
            Log::application()->info('バリデーションエラー');
            Session::set_flash('errors', $val->error_message());
            Response::redirect(Router::get('forget'), 'location', HTTP_STATUS_BAD_REQUEST);
        }

        // メールアドレス
        $email = Input::post('email');

        // plan_type
        $plan_type = Input::post('plan_type', PLAN_TYPE_DOMESTIC);
        // ログイン先判定
        switch ($plan_type) {
            case PLAN_TYPE_INTERNATIONAL_PREPAID:
                $prefix = 'prepaid_';
                break;

            // 海外レンタルプラン
            case PLAN_TYPE_INTERNATIONAL_RENTAL:
                $prefix = 'rental_';
                break;

            // 国内プラン
            default:
                $prefix = '';
                break;
        }

        $service_password_forget = new Service_Password_Forget();
        $logic_rel_contract_option = new Logic_HumanLife_RelContractOption();

        // メールアドレスを条件にユーザー情報を取得
        Log::application()->info('ユーザー情報の取得処理');
        $user_info = $service_password_forget->get_user_login_info_by_email($email, BUSINESS_ID, $plan_type);
        // @TODO 会員IDの処理を復活させる場合は下記処理を復活させる↓
        // if (strpos($email, '@')) {
        //     $service_login = new Service_Login();
        //     // メールで会員IDでログインするべきかチェック 条件: メールと会員IDもNULLじゃないユーザーが入れたら、会員IDでログインさせる
        //     if (!$service_login->can_user_login_by_email($email, BUSINESS_ID)) {
        //         // ログイン画面にリダイレクト
        //         // エラー内容をセッションに一時格納
        //         Session::set_flash('errors', [Lang::get('messages.should_login_by_user_id')]);
        //         Response::redirect(Router::get('forget'), 'location', HTTP_STATUS_BAD_REQUEST);
        //     }
        //     $user_info = $service_password_forget->get_user_login_info_by_email($email, BUSINESS_ID);
        // } else {
        //     $user_info = $service_password_forget->get_user_login_info_by_login_user_id($email, BUSINESS_ID);
        // }
        Log::application()->info('ユーザー情報の取得成功');
        Log::application()->debug('取得結果', $user_info);

        if (empty($user_info)) {
            // ユーザー情報が存在しなかった場合
            Log::application()->info('メールアドレスを条件にユーザー情報を取得できなかったため、メール送信を行わない');
            Log::application()->info('バリデーションエラー');
            Session::set_flash('errors', [Helper_Message::getMessage("no_available_email")]);
            Response::redirect(Router::get($prefix . 'forget'), 'location', HTTP_STATUS_BAD_REQUEST);
        }

        // 法人の場合はentry_planが存在せず、imei未連携の国内・海外レンタルユーザーの場合はrel_contract_planが存在しない
        // プラン種別チェックに漏れが出てしまうため、結びつくプランのプラン種別を厳密にチェックするようにする
        // 個人の場合はentry_plan、法人の場合はentry_companyのplan_idからplan_typeを取得
        // rel_contract_planがある場合はそちらから取得するplan_typeを、無い場合は上述のentryから取得したplan_typeを判定する
        $entry_plan_id = (int)$user_info['user_type'] === USER_TYPE_LIST['PRIVATE'] ? $user_info['entry_plan_type'] : $user_info['entry_company_plan_type'];
        $user_plan_type = !empty($user_info['plan_type']) ? $user_info['plan_type'] : $entry_plan_id;
        if ((int)$user_plan_type !== (int)$plan_type) {
            // 画面から受け取ったplan_typeと取得したユーザーのplan_typeが異なる場合
            Log::application()->info('メールアドレスを条件にユーザー情報を取得できなかったため、メール送信を行わない');
            Log::application()->info('バリデーションエラー');
            Session::set_flash('errors', [Helper_Message::getMessage("no_available_email")]);
            Response::redirect(Router::get($prefix . 'forget'), 'location', HTTP_STATUS_BAD_REQUEST);
        }

        // 加入中のオプション情報を取得し保険オプションの情報を抽出する
        $option_info = isset($user_info['user_id']) ? $logic_rel_contract_option->get_contract_option_info_list_by_contract_id($user_info['business_id'], $user_info['contract_id']) : [];
        $option_info_insurance = $option_info[OPTION_TYPE_INSURANCE] ?? [];

        // ユーザーが存在している場合
        // 有効なユーザーのみパスワードの変更を許可する ※保険オプション利用ユーザーは初期契約解除も許容する
        $login_allow_possible_user_status_list = (count($option_info_insurance) > 0) ? LOGIN_ALLOW_USER_STATUS_LIST_FOR_INSURANCE : MYPAGE_LOGIN_ALLOW_POSSIBLE_USER_STATUS_LIST;
        if (!empty($user_info) && in_array((int)$user_info['status'], $login_allow_possible_user_status_list)) {
            $is_allow_in_login = true;
            $is_cancel = (int)$user_info['status'] === USER_STATUS_LIST['withdraw']
                || (count($option_info_insurance) > 0 && (int)$user_info['status'] === USER_STATUS_LIST['initial_contract_cancellation']);

            // 国内プランで申込取消の場合はパスワード再設定不可能とする
            if ((int)$plan_type === PLAN_TYPE_DOMESTIC && (int)$user_info['user_type'] === USER_TYPE_LIST['PRIVATE'] && (int)$user_info['entry_status'] === ENTRY_STATUS_VALUE_LIST['WAITING_BILLING']) {
                $is_allow_in_login = false;
            } else if ((int)$user_info['user_type'] === USER_TYPE_LIST['PRIVATE'] && $is_cancel && $user_info['plan_end_date'] != NULL) {
                $current_date = new DateTime();
                $next_month_plan_end_date = new DateTime($user_info['plan_end_date']);
                $next_month_plan_end_date->modify('last day of next month');
                // プラン解約済みでも保険オプションが継続中であれば再設定できるようにする
                $insurance_only_flg = false;
                foreach ($option_info_insurance as $row) {
                    if (is_null($row['option_end_date'])) {
                        $insurance_only_flg = true;
                    } else {
                        $next_month_option_end_date = new DateTime($row['option_end_date']);
                        $next_month_option_end_date->modify('last day of next month');
                        $insurance_only_flg = ($next_month_option_end_date >= $current_date) ? true : false;
                    }
                }
                if ($next_month_plan_end_date < $current_date && $insurance_only_flg === false) {
                    $is_allow_in_login = false;
                }
            } elseif ((int)$user_info['user_type'] === USER_TYPE_LIST['CORPORATE'] && (int)$user_info['status'] === USER_STATUS_LIST['withdraw']) {
                $is_allow_in_login = false;
            }

            if ($is_allow_in_login) {
                Log::application()->info('メールアドレスを条件にユーザー情報を取得できたため、本人確認メール送信を行う');
                // 本人確認用トークン生成
                $token = $this->get_crypt_str($email . microtime(true), $user_info['salt']);
                // 本人確認用トークンテーブルでデータを登録
                $service_password_forget->insert_password_reminder($user_info['user_id'], BUSINESS_ID, $token);
                // メール送信用パラメータ
                $params = Config::get('template.password_reminder_mail');
                $params['to'] = $user_info['email'];
                $params['body'] = $this->view($params['template'], [
                    'password_edit_url' => Router::get($prefix . 'edit_password_by_token', ['token' => $token]),
                    'plan_type'         => $user_plan_type,
                ]);
                if ((int)$plan_type === PLAN_TYPE_INTERNATIONAL_RENTAL) {
                    $params['subject'] = str_replace('ZEUS WiFi〉', 'ZEUS WiFi for GLOBAL〉', $params['subject']);
                }

                // 本人確認メール送信
                Log::application()->info('本人確認メール送信');
                $is_success_send = Helper_Mail::send_mail($params);

                if ($is_success_send) {
                    Log::application()->info('本人確認メール送信完了');
                }
            } else {
                Log::application()->info('メールアドレスを条件にユーザー情報を取得できなかったため、メール送信を行わない');
                Log::application()->info('バリデーションエラー');
                Session::set_flash('errors', [Helper_Message::getMessage("no_available_email")]);
                Response::redirect(Router::get($prefix . 'forget'), 'location', HTTP_STATUS_BAD_REQUEST);
            }
        } else {
            Log::application()->info('メールアドレスを条件にユーザー情報を取得できなかったため、メール送信を行わない');
            Log::application()->info('バリデーションエラー');
            Session::set_flash('errors', [Helper_Message::getMessage("no_available_email")]);
            Response::redirect(Router::get($prefix . 'forget'), 'location', HTTP_STATUS_BAD_REQUEST);
        }

        Log::application()->info('本人確認処理終了');

        // 本人確認完了画面にリダイレクト
        Response::redirect(Router::get($prefix . 'forget_complete'), 'location', HTTP_STATUS_FOUND);
    }

    /**
     * 本人確認完了画面
     *
     * @return \Fuel\Core\Response
     */
    public function get_complete() {
        Log::application()->info('本人確認画面表示処理終了');
        return $this->view('password/forget/complete', [
            'title' => Config::get('title.forget_password_complete'),
            'cssfile' => Config::get('cssfile.forget_password_complete'),
        ]);
    }

    /**
     * 本人確認画面(海外レンタルプラン向け)
     *
     * @return \Fuel\Core\Response
     */
    public function get_rental_forget() {
        Log::application()->info('本人確認画面表示処理開始');

        // CSRFトークンの生成
        $csrf_token = Security::fetch_token();

        Log::application()->info('本人確認画面表示処理終了');

        return $this->view('password/forget/rental_forget', [
            'forget_url'  => Router::get('forget'),
            'csrf_token'  => $csrf_token,
            'title'       => Config::get('title.forget_password'),
            'cssfile'     => Config::get('cssfile.forget_password'),
            'description' => Config::get('description.forget_password'),
        ]);
    }

    /**
     * 本人確認完了画面(海外レンタルプラン向け)
     *
     * @return \Fuel\Core\Response
     */
    public function get_rental_complete() {
        Log::application()->info('本人確認画面表示処理開始');
        Log::application()->info('本人確認画面表示処理終了');
        return $this->view('password/forget/rental_complete', [
            'title'            => Config::get('title.forget_password_complete'),
            'cssfile'          => Config::get('cssfile.forget_password_complete'),
            'rental_login_url' => Router::get('rental_login'),
        ]);
    }

    /**
     * 本人確認画面(CHARGEプラン(プリペイド)向け)
     *
     * @return \Fuel\Core\Response
     */
    public function get_prepaid_forget() {
        Log::application()->info('本人確認画面表示処理開始');

        // CSRFトークンの生成
        $csrf_token = Security::fetch_token();

        Log::application()->info('本人確認画面表示処理終了');

        return $this->view('password/forget/prepaid_forget', [
            'forget_url'  => Router::get('forget'),
            'csrf_token'  => $csrf_token,
            'title'       => Config::get('title.forget_password_prepaid'),
            'cssfile'     => Config::get('cssfile.forget_password'),
            'description' => Config::get('description.forget_password'),
        ]);
    }

    /**
     * 本人確認完了画面(CHARGEプラン(プリペイド)向け)
     *
     * @return \Fuel\Core\Response
     */
    public function get_prepaid_complete() {
        Log::application()->info('本人確認画面表示処理終了');
        return $this->view('password/forget/prepaid_complete', [
            'title'             => Config::get('title.forget_password_complete_prepaid'),
            'cssfile'           => Config::get('cssfile.forget_password_complete'),
            'prepaid_login_url' => Router::get('prepaid_login'),
            'hide_header_menu'  => true,
        ]);
    }
}
