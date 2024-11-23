<?php

/**
 * ログインクラス
 */
class Controller_Login extends Controller_Base {
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
     * ログイン画面表示
     *
     * @return \Fuel\Core\Response
     */
    public function get_login() {
        Log::application()->info('ログイン画面表示処理開始');

        // CSRFトークンの生成
        $csrf_token = Security::fetch_token();

        Log::application()->info('ログイン画面表示処理終了');

        return $this->view('login', [
            'post_login_url' => Router::get('login'),
            'forget_url'     => Router::get('forget'),
            'csrf_token'     => $csrf_token,
            'title'          => Config::get('title.login', ''),
            'cssfile'        => Config::get('cssfile.login'),
            'description'    => Config::get('description.login', ''),
            'canonical'      => Config::get('canonical.login', ''),
            'next'           => Input::get('next', ''),
        ]);
    }

    /**
     * ログイン処理実行
     */
    public function post_login() {
        Log::application()->info('ログイン処理開始');

        $next = Input::post('next', '');
        // メールアドレス
        $email = Input::post('email');
        // パスワード
        $password = Input::post('password');
        $service_login = new Service_Login();

        $plan_type = Input::post('plan_type', PLAN_TYPE_DOMESTIC);
        // ログイン先判定
        switch ($plan_type) {
            case PLAN_TYPE_INTERNATIONAL_PREPAID:
                $prefix = 'prepaid_';
                $prefix_top = '_prepaid';
                break;

            // 海外レンタルプラン
            case PLAN_TYPE_INTERNATIONAL_RENTAL:
                $prefix = 'rental_';
                $prefix_top = '_rental';
                break;

            // 国内プラン
            default:
                $prefix = '';
                $prefix_top = '';
                break;
        }

        // CSRFトークンの検証
        $this->check_csrf_token(Router::get($prefix . 'login'));

        $check_login = $service_login->get_check_login_user($email, $password, false, $plan_type);

        if(!empty($check_login['error_code'])) {
            $error_code = (int) $check_login['error_code'];

            if($error_code === LOGIN_ERROR_CODE_LIST['NOT_GET_USER_INFO_CODE']) {
                // ユーザー情報が存在しなかった場合
                $err_msg = [Lang::get('messages.invalid_auth_info')];
                Log::application()->info('ログイン処理にてユーザーが存在しないためリダイレクト');

            } else if($error_code === LOGIN_ERROR_CODE_LIST['NO_MATCH_PASSWORD_CODE']) {
                // 正しいパスワードが入力されていない場合
                Log::application()->info('ログイン処理にパスワードが異なる');
                $err_msg = [Lang::get('messages.invalid_auth_info')];
            } else if($error_code === LOGIN_ERROR_CODE_LIST['INVALID_AUTH_INFO_CODE']) {
                // 正しいメールアドレス(会員ID)、またはパスワードが入力されていない場合
                Log::application()->info('ログイン処理にメールアドレス(会員ID)、またはパスワードが異なる');
                $err_msg = [Lang::get('messages.invalid_auth_info')];
            } else if($error_code === LOGIN_ERROR_CODE_LIST['SHOULD_LOGIN_BY_USER_ID']) {
                // 会員IDでのログインが必要
                Log::application()->info('会員IDでのログインが必要');
                $err_msg = [Lang::get('messages.should_login_by_user_id')];
            } else if($error_code === LOGIN_ERROR_CODE_LIST['CANCEL_USER']) {
                // 解約ユーザ
                Log::application()->info('ログイン処理にてユーザーが解約ためリダイレクト');
                $err_msg = [Lang::get('messages.contract_cancel')];
            } else {
                Log::application()->info('ログイン処理にてユーザーが解約ためリダイレクト');
                $err_msg = [Lang::get('messages.user_suspend')];
            }

            // エラー内容をセッションに一時格納
            Session::set_flash('errors', $err_msg);
            // ログイン画面にリダイレクト
            Response::redirect(Router::get($prefix . 'login'), 'location', HTTP_STATUS_BAD_REQUEST);
        }

        $user_info = $check_login['user_info'];

        // 認証情報をセッションにセット
        $this->set_session_auth_info($user_info['email'], $user_info['salt'], $plan_type);

        // 保険オプションのみの契約かどうかをセッションにセット
        Session::set('insurance_only_flg', $user_info['insurance_only_flg'] ?? false);
        // プラン解約&保険オプション継続時、プラン情報が表示可能かどうかのフラグをセッションにセット
        Session::set('view_contract_plan_flg', $user_info['view_contract_plan_flg'] ?? true);
        // 顧客拡張区分のセッション
        Session::set('expansion_type', $user_info['expansion_type'] ?? USER_EXPANSION_TYPE_USER);

        Log::application()->info('ログイン処理終了');

        // マイページTOPにリダイレクト
        if($user_info['user_type'] == USER_TYPE_LIST['CORPORATE']){
            Response::redirect(Router::get('corpmypage_top'), 'location', HTTP_STATUS_FOUND);
        }else{
            if (!empty($next)) {
                Response::redirect($next, 'location', HTTP_STATUS_FOUND);
            } else {
                Response::redirect(Router::get('mypage_top' . $prefix_top), 'location', HTTP_STATUS_FOUND);
            }
        }

    }

    /**
     * ログイン画面表示(CHARGEプラン(プリペイド)向け)
     *
     * @return \Fuel\Core\Response
     */
    public function get_prepaid_login() {
        Log::application()->info('ログイン画面表示処理開始');

        // CSRFトークンの生成
        $csrf_token = Security::fetch_token();

        Log::application()->info('ログイン画面表示処理終了');

        return $this->view('prepaid_login', [
            'post_login_url' => Router::get('login'),
            'forget_url'     => Router::get('forget'),
            'csrf_token'     => $csrf_token,
            'title'          => Config::get('title.prepaid_login', ''),
            'cssfile'        => Config::get('cssfile.login'),
            'description'    => Config::get('description.prepaid_login', ''),
            'canonical'      => Config::get('canonical.login', ''),
            'next'           => Input::get('next', ''),
        ]);
    }

    /**
     * ログイン画面表示(海外レンタルプラン向け)
     *
     * @return \Fuel\Core\Response
     */
    public function get_rental_login() {
        Log::application()->info('ログイン画面表示処理開始');

        // CSRFトークンの生成
        $csrf_token = Security::fetch_token();

        Log::application()->info('ログイン画面表示処理終了');

        return $this->view('rental_login', [
            'post_login_url' => Router::get('login'),
            'forget_url'     => Router::get('forget'),
            'csrf_token'     => $csrf_token,
            'title'          => Config::get('title.login', ''),
            'cssfile'        => Config::get('cssfile.login'),
            'description'    => Config::get('description.login', ''),
            'canonical'      => Config::get('canonical.login', ''),
            'next'           => Input::get('next', ''),
        ]);
    }

}
