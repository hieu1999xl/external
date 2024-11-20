<?php

/**
 * パスワード変更クラス
 */
class Controller_Password_Edit extends Controller_Base {

    protected $is_atobarai_user                            = false; // 振込あと払いの会員
    protected $is_maya_installment_plan                    = false; // CHARGEプラン(プリペイド)会員判定
    protected $is_access_maya_overseas_plan_purchase_page  = false; // CHARGEプラン(プリペイド)購入判定
    protected $is_rental                                   = false; // MAYA海外レンタルプラン会員判定


    /**
     * {@inheritDoc}
     *
     * @see \Fuel\Core\Controller::before()
     */
    public function before() {
        // 未ログインでもログイン済みでもアクセス可能
        $this->is_anyone_access = true;
        parent::before();
    }

    /**
     * パスワード変更画面
     */
    public function get_edit() {
        Log::application()->info('パスワード変更画面表示処理開始');

        $service_password_edit = new Service_Password_Edit();

        // リクエストされているトークン取得
        $token = $this->param('token', '');

        if ($token === '') {
            Log::application()->info('トークンが指定されていないためログイン認証フロー');

            // トークンがリクエストされていない場合はログイン必須
            if (!$this->is_login) {
                // ログイン画面にリダイレクト
                Log::application()->info('未ログインのためログイン画面にリダイレクト');
                Response::redirect(Router::get('login'), 'location', HTTP_STATUS_UNAUTHORIZED);
            }

            // ユーザーIDをセット
            $user_id = $this->user_id;
        } else {
            Log::application()->info('トークンが指定されているためトークン認証フロー');

            // トークンを条件にユーザー情報を取得
            Log::application()->info('トークンを条件にユーザー情報を取得');
            $password_reminder_info = $service_password_edit->get_password_reminder_info($token, BUSINESS_ID);
            Log::application()->info('トークンを条件にユーザー情報を取得成功');
            Log::application()->debug('取得結果', $password_reminder_info);

            if (empty($password_reminder_info) || $service_password_edit->is_expire_date_password_reminder_token($password_reminder_info['create_datetime'])
                || $password_reminder_info['plan_type'] != PLAN_TYPE_DOMESTIC) {
                // ユーザー情報が取得できなかった場合、
                // または認証トークンの有効期限が切れていた場合
                // またはプラン種別が国内プランではない場合
                Log::application()->info('不正なアクセス、不正なトークン、または有効期限切れのトークンのため404ページにリダイレクト');
                Response::redirect(Router::get('notfound'), 'location', HTTP_STATUS_NOT_FOUND);
            }

            // ユーザーIDをセット
            $user_id = $password_reminder_info['user_id'];
        }

        // CSRFトークンの生成
        $csrf_token = Security::fetch_token();

        Log::application()->info('パスワード変更画面表示処理終了');

        // 振込あと払いの会員判定
        $this->checkAtobaraiUser();

        // MAYAプラン判定
        $this->is_maya_installment_plan();

        // MAYAプラン海外購入ページへアクセス可能か判定
        $this->is_access_maya_overseas_plan_purchase_page();

        // contract_idの取得
        $service_my_page_user = new Service_Mypage_User();
        $contract_id = $service_my_page_user->get_contract_id_by_user_id($this->user_id);

        return $this->view('password/edit/edit', [
            'edit_password_url'                          => Router::get('edit_password'),//mypage_top
            'mypage_top_url'                             => Router::get('mypage_top'),
            'user_id'                                    => $user_id,
            'token'                                      => $token,
            'csrf_token'                                 => $csrf_token,
            'title'                                      => Config::get('title.edit_password'),
            'is_atobarai_user'                           => $this->is_atobarai_user,
            'is_maya_installment_plan'                   => $this->is_maya_installment_plan,
            'is_access_maya_overseas_plan_purchase_page' => $this->is_access_maya_overseas_plan_purchase_page,
        ]);
    }

    /**
     * パスワード変更処理
     *
     * @throws Exception
     */
    public function post_edit() {
        $password = Input::post('password', '');
        $password_confirm = Input::post('password_confirm', '');
        $token = Input::post('token', '');
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
        $service_password_edit = new Service_Password_Edit();
        $service_user = new Service_Mypage_User();
        $service_contract = new Service_Mypage_Contract();
        $logic_rel_contract_option = new Logic_HumanLife_RelContractOption();
        Log::application()->info('パスワード変更処理開始');

        if ($token === '') {
            Log::application()->info('トークンが指定されていないためログイン認証フロー');
            // エラーだった場合のリダイレクト先
            $redirect_url = Router::get($prefix . 'password_edit');
            // ユーザーIDをセット
            $user_id = $this->user_id;
        } else {
            Log::application()->info('トークンが指定されているためトークン認証フロー');
            // エラーだった場合のリダイレクト先
            $redirect_url = Router::get($prefix . 'edit_password_by_token', ['token' => $token]);
            // トークンを条件にユーザー情報取得
            Log::application()->info('トークンを条件にユーザー情報を取得');
            $password_reminder_info = $service_password_edit->get_password_reminder_info($token, BUSINESS_ID);
            Log::application()->info('トークンを条件にユーザー情報を取得成功');
            Log::application()->debug('取得結果', $password_reminder_info);

            if (empty($password_reminder_info) || $service_password_edit->is_expire_date_password_reminder_token($password_reminder_info['create_datetime'])) {
                // ユーザー情報が取得できなかった場合、
                // または認証トークンの有効期限が切れていた場合
                Log::application()->info('不正なトークン、または有効期限切れのトークンのため404ページにリダイレクト');
                Response::redirect(Router::get('notfound'), 'location', HTTP_STATUS_NOT_FOUND);
            }
            // ユーザーIDをセット
            $user_id = $password_reminder_info['user_id'];
        }

        // CSRFトークンの検証
        $this->check_csrf_token($redirect_url);

        // パスワードのバリデーション
        $val = Validation::forge();
        $val->add('password', 'パスワード')
            ->add_rule('required')
            ->add_rule('valid_password')
            ->add_rule('match_value', $password_confirm);
        $val->add('password_confirm', 'パスワード（確認）')
            ->add_rule('required');

        if (!$val->run()) {
            // バリデーションでエラーがあった場合
            Log::application()->info('バリデーションエラー');
            Session::set_flash('errors', $val->error_message());
            Response::redirect($redirect_url, 'location', HTTP_STATUS_BAD_REQUEST);
        }

        // ユーザー情報取得
        Log::application()->info('ユーザー情報の取得');
        // ユーザー情報取得

        // 加入中のオプション情報を取得し保険オプションの情報を抽出する
        $contract_info = $service_contract->get_contract_info_by_user_id($user_id);
        $option_info = isset($contract_info['contract_id']) ? $logic_rel_contract_option->get_contract_option_info_list_by_contract_id(BUSINESS_ID, $contract_info['contract_id']) : [];
        $is_insurance = in_array(OPTION_TYPE_INSURANCE, array_keys($option_info));

        if ($is_insurance) {
            // 保険ユーザー
            $user_info = $service_user->get_user_info_for_insurance($user_id, BUSINESS_ID);
        } else {
            $user_info = $service_password_edit->get_user_info($user_id, BUSINESS_ID);
        }
        Log::application()->info('ユーザー情報の取得成功');
        Log::application()->debug('取得結果', $user_info);

        // パスワード暗号化
        $crypt_password = $this->get_crypt_str($password, $user_info['salt']);

        // パスワード更新
        Log::application()->info('パスワードの更新');
        $service_password_edit->update_user_password($user_id, BUSINESS_ID, $crypt_password);
        Log::application()->info('パスワードの更新成功');

        // メール送信用パラメータ
        $params = Config::get('template.password_edit_mail');
        $params['to'] = $user_info['email'];
        if ((int)$plan_type === PLAN_TYPE_INTERNATIONAL_RENTAL) {
            $params['subject'] = str_replace('ZEUS WiFi〉', 'ZEUS WiFi for GLOBAL〉', $params['subject']);
        }
        $params['body'] = $this->view($params['template'], [
            'last_name'  => $user_info['last_name'],
            'first_name' => $user_info['first_name'],
            'plan_type'  => $plan_type,
        ]);

        // パスワード変更完了メール
        Log::application()->info('パスワード変更完了メール送信');
        $is_success_send = Helper_Mail::send_mail($params);

        if ($is_success_send) {
            Log::application()->info('パスワード変更完了メール送信完了');
        }

        Log::application()->info('パスワード変更処理終了');

        // パスワード変更完了画面にリダイレクト
        Response::redirect(Router::get($prefix . 'edit_password_complete'), 'location', HTTP_STATUS_FOUND);
    }

    /**
     * パスワード変更完了画面
     */
    public function get_complete() {
        Log::application()->info('パスワード変更完了画面表示処理開始');
        Log::application()->info('パスワード変更完了画面表示処理終了');

        // 振込あと払いの会員判定
        $this->checkAtobaraiUser();

        // MAYAプラン判定
        $this->is_maya_installment_plan();

        // MAYAプラン海外購入ページへアクセス可能か判定
        $this->is_access_maya_overseas_plan_purchase_page();

        return $this->view('password/edit/complete', [
            'login_url'                                  => Router::get('login'),
            'title'                                      => Config::get('title.edit_password_complete'),
            'is_rental'                                  => $this->is_rental,
            'is_atobarai_user'                           => $this->is_atobarai_user,
            'is_maya_installment_plan'                   => $this->is_maya_installment_plan,
            'is_access_maya_overseas_plan_purchase_page' => $this->is_access_maya_overseas_plan_purchase_page,
        ]);
    }

    /**
     * パスワード変更画面(海外レンタルプラン向け)
     */
    public function get_rental_edit() {
        Log::application()->info('パスワード変更画面表示処理開始');

        $contract_id = '';

        $service_password_edit = new Service_Password_Edit();

        // リクエストされているトークン取得
        $token = $this->param('token', '');

        if ($token === '') {
            Log::application()->info('トークンが指定されていないためログイン認証フロー');

            // トークンがリクエストされていない場合はログイン必須
            if (!$this->is_login) {
                // ログイン画面にリダイレクト
                Log::application()->info('未ログインのためログイン画面にリダイレクト');
                Response::redirect(Router::get('rental_login'), 'location', HTTP_STATUS_UNAUTHORIZED);
            }

            $service_mypage_user = new Service_Mypage_User();

            // contract_idの取得
            $contract_id = $service_mypage_user->get_contract_id_by_user_id_for_rental($this->user_id);

            // ユーザーIDをセット
            $user_id = $this->user_id;
        } else {
            Log::application()->info('トークンが指定されているためトークン認証フロー');

            // トークンを条件にユーザー情報を取得
            Log::application()->info('トークンを条件にユーザー情報を取得');
            $password_reminder_info = $service_password_edit->get_password_reminder_info($token, BUSINESS_ID);
            Log::application()->info('トークンを条件にユーザー情報を取得成功');
            Log::application()->debug('取得結果', $password_reminder_info);

            if (empty($password_reminder_info)) {
                // ユーザー情報が取得できなかった場合
                Log::application()->info('不正なアクセス、不正なトークン、または有効期限切れのトークンのため404ページにリダイレクト');
                Response::redirect(Router::get('notfound'), 'location', HTTP_STATUS_NOT_FOUND);
            }

            // imei未連携の国内・海外レンタルユーザーの場合はrel_contract_planが存在しない
            // プラン種別チェックに漏れが出てしまうため、結びつくプランのプラン種別を厳密にチェックするようにする
            // rel_contract_planがある場合はそちらから取得するplan_typeを、無い場合はentry_planから取得したplan_typeを判定する
            $user_plan_type = !empty($password_reminder_info['plan_type']) ? $password_reminder_info['plan_type'] : $password_reminder_info['entry_plan_type'];
            if ($service_password_edit->is_expire_date_password_reminder_token($password_reminder_info['create_datetime'])
            || $user_plan_type != PLAN_TYPE_INTERNATIONAL_RENTAL) {
                // 認証トークンの有効期限が切れていた場合
                // またはプラン種別が海外レンタルプランではない場合
                Log::application()->info('不正なアクセス、不正なトークン、または有効期限切れのトークンのため404ページにリダイレクト');
                Response::redirect(Router::get('notfound'), 'location', HTTP_STATUS_NOT_FOUND);
            }

            // ユーザーIDをセット
            $user_id = $password_reminder_info['user_id'];
        }

        // 追加・変更・延長ポップアップ制御の判定
        $this->checkRentalPlanEndData();

        // CSRFトークンの生成
        $csrf_token = Security::fetch_token();

        Log::application()->info('パスワード変更画面表示処理終了');

        return $this->view('password/edit/rental_edit', [
            'edit_password_url'         => Router::get('edit_password'),//mypage_top
            'mypage_top_url'            => Router::get('mypage_top'),
            'user_id'                   => $user_id,
            'contract_id'               => $contract_id,
            'token'                     => $token,
            'csrf_token'                => $csrf_token,
            'title'                     => Config::get('title.edit_password_rental'),
            'is_rental_plan_add'        => $this->is_rental_plan_add,
            'is_rental_plan_change'     => $this->is_rental_plan_change,
            'is_rental_plan_extension'  => $this->is_rental_plan_extension,
            'is_rental_import_imei'     => $this->is_rental_import_imei,
            'is_rental_unbind_device'   => $this->is_rental_unbind_device,
        ]);
    }

    /**
     * パスワード変更完了画面(海外レンタルプラン向け)
     */
    public function get_rental_complete() {
        Log::application()->info('パスワード変更完了画面表示処理開始');
        $contract_id = '';
        if ($this->is_login) {
            $service_mypage_user = new Service_Mypage_User();

            // contract_idの取得
            $contract_id = $service_mypage_user->get_contract_id_by_user_id_for_rental($this->user_id);

            // 追加・変更・延長ポップアップ制御の判定
            $this->checkRentalPlanEndData();
        }
        Log::application()->info('パスワード変更完了画面表示処理終了');

        return $this->view('password/edit/rental_complete', [
            'rental_login_url'          => Router::get('rental_login'),
            'title'                     => Config::get('title.edit_password_complete_rental'),
            'contract_id'               => $contract_id,
            'is_login'                  => $this->is_login,
            'is_rental_plan_add'        => $this->is_rental_plan_add,
            'is_rental_plan_change'     => $this->is_rental_plan_change,
            'is_rental_plan_extension'  => $this->is_rental_plan_extension,
            'is_rental_import_imei'     => $this->is_rental_import_imei,
            'is_rental_unbind_device'   => $this->is_rental_unbind_device,
        ]);
    }

    /**
     * パスワード変更画面(CHARGEプラン(プリペイド)向け)
     */
    public function get_prepaid_edit() {
        Log::application()->info('パスワード変更画面表示処理開始');

        $service_password_edit = new Service_Password_Edit();

        // リクエストされているトークン取得
        $token = $this->param('token', '');

        if ($token === '') {
            Log::application()->info('トークンが指定されていないためログイン認証フロー');

            // トークンがリクエストされていない場合はログイン必須
            if (!$this->is_login) {
                // ログイン画面にリダイレクト
                Log::application()->info('未ログインのためログイン画面にリダイレクト');
                Response::redirect(Router::get('prepaid_login'), 'location', HTTP_STATUS_UNAUTHORIZED);
            }

            // ユーザーIDをセット
            $user_id = $this->user_id;
        } else {
            Log::application()->info('トークンが指定されているためトークン認証フロー');

            // トークンを条件にユーザー情報を取得
            Log::application()->info('トークンを条件にユーザー情報を取得');
            $password_reminder_info = $service_password_edit->get_password_reminder_info($token, BUSINESS_ID);
            Log::application()->info('トークンを条件にユーザー情報を取得成功');
            Log::application()->debug('取得結果', $password_reminder_info);

            if (empty($password_reminder_info) || $service_password_edit->is_expire_date_password_reminder_token($password_reminder_info['create_datetime'])
                || $password_reminder_info['plan_type'] != PLAN_TYPE_INTERNATIONAL_PREPAID) {
                // ユーザー情報が取得できなかった場合、
                // またはプラン種別がCHARGEプラン(プリペイド)ではない場合
                Log::application()->info('不正なアクセス、不正なトークン、または有効期限切れのトークンのため404ページにリダイレクト');
                Log::application()->info('不正なトークン、または有効期限切れのトークンのため404ページにリダイレクト');
                Response::redirect(Router::get('notfound'), 'location', HTTP_STATUS_NOT_FOUND);
            }

            // ユーザーIDをセット
            $user_id = $password_reminder_info['user_id'];
        }

        // CSRFトークンの生成
        $csrf_token = Security::fetch_token();

        Log::application()->info('パスワード変更画面表示処理終了');

        // MAYAプラン判定
        $this->is_maya_installment_plan();

        // MAYAプラン海外購入ページへアクセス可能か判定
        $this->is_access_maya_overseas_plan_purchase_page();

        // URIからplan_typeを判定する(/prepaid/password/*系限定)
        $uri = $_SERVER['REQUEST_URI'];
        $uri_array = explode('/', $uri);
        $uri_1 = $uri_array[1] ?? '';

        if ($uri_1 === 'prepaid') {
            // CHARGEプラン(プリペイド)
            $this->is_maya_installment_plan = true;
        }

        return $this->view('password/edit/prepaid_edit', [
            'edit_password_url'                          => Router::get('edit_password'),//mypage_top
            'user_id'                                    => $user_id,
            'token'                                      => $token,
            'csrf_token'                                 => $csrf_token,
            'title'                                      => Config::get('title.edit_password_prepaid'),
            'is_maya_installment_plan'                   => $this->is_maya_installment_plan,
            'is_access_maya_overseas_plan_purchase_page' => $this->is_access_maya_overseas_plan_purchase_page,
        ]);
    }

    /**
     * パスワード変更完了画面(CHARGEプラン(プリペイド)向け)
     */
    public function get_prepaid_complete() {
        Log::application()->info('パスワード変更完了画面表示処理開始');
        Log::application()->info('パスワード変更完了画面表示処理終了');

        // MAYAプラン判定
        $this->is_maya_installment_plan();

        Session::set('plan_type', PLAN_TYPE_INTERNATIONAL_PREPAID);

        return $this->view('password/edit/prepaid_complete', [
            'prepaid_login_url' => Router::get('prepaid_login'),
            'title'     => Config::get('title.edit_password_complete_prepaid'),
            'is_maya_installment_plan' => $this->is_maya_installment_plan,
            'is_login'                 => $this->is_login,
        ]);
    }

    /**
     * settlement_infoを取得して、振込あと払いのユーザーか判定する
     */
    private function checkAtobaraiUser()
    {
        if(empty($this->user_id)) {
            $this->is_atobarai_user = false; // 未ログインの対応
        } else {
            // 決済方法をとる
            $service_user = new Service_Mypage_User();
            $this->is_atobarai_user = $service_user->is_atobarai_user($this->user_id, BUSINESS_ID);
        }
    }

    /**
     * CHARGEプラン(プリペイド)か判断する
     */
    private function is_maya_installment_plan() {
        if(empty($this->user_id)) {
            // 未ログインの対応
            $this->is_maya_installment_plan = false;
        } else {
            // 契約プランをとる
            $service_user = new Service_Mypage_User();
            $this->is_maya_installment_plan = $service_user->is_maya_installment_plan($this->user_id, BUSINESS_ID);
        }
    }

    /**
     * CHARGEプラン(プリペイド)購入ページへアクセス可能か判定する
     */
    private function is_access_maya_overseas_plan_purchase_page() {
        if(empty($this->user_id)) {
            // 未ログインの対応
            $this->is_access_maya_overseas_plan_purchase_page = false;
        } else {
            // 契約プランをとる
            $service_user = new Service_Mypage_User();
            $this->is_access_maya_overseas_plan_purchase_page = $service_user->is_access_maya_overseas_plan_purchase_page($this->user_id);
        }
    }

}
