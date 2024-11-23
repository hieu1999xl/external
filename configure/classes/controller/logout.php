<?php

/**
 * ログアウトクラス
 */
class Controller_Logout extends Controller_Base {
    /**
     * {@inheritDoc}
     *
     * @see \Fuel\Core\Controller::before()
     */
    public function before() {
        // ログインチェックを行わない
        $this->required_login = false;
        parent::before();
    }

    /**
     * ログアウト処理
     */
    public function get_logout() {
        Log::application()->info('ログアウト処理開始');

        // session削除前にplan_type取得
        $plan_type = Session::get('plan_type', PLAN_TYPE_DOMESTIC);
        // 認証情報を削除する
        $this->delete_auth_info_session();

        // 一時セッションにメッセージをセット
        Session::set_flash('messages', [Lang::get('messages.logout_after')]);

        Log::application()->info('ログアウト処理終了');

        // plan_typeによってリダイレクト先変更
        switch ($plan_type) {
            // CHARGEプラン(プリペイド)
            case PLAN_TYPE_INTERNATIONAL_PREPAID:
                $login_page = Router::get('prepaid_login');
                break;

            // 海外レンタルプラン
            case PLAN_TYPE_INTERNATIONAL_RENTAL:
                $login_page = Router::get('rental_login');
                break;

            // 国内プラン
            default:
                $login_page = Router::get('login');
                break;
        }

        Response::redirect($login_page, 'location', HTTP_STATUS_FOUND);
    }
}
