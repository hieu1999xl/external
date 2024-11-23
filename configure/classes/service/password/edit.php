<?php

/**
 * パスワード変更のサービスクラス
 */
class Service_Password_Edit extends Service_Base {

    /**
     * トークンから本人確認用データを取得する
     *
     * @param string $token
     * @param int    $business_id
     * @return array
     */
    public function get_password_reminder_info($token, $business_id) {
        $logic = new Logic_HumanLife_Passwordreminder();
        // 認証トークンを条件にユーザー情報取得
        return $logic->get_password_reminder_info($token, $business_id);
    }

    /**
     * パスワードを忘れた方の認証トークンが有効期限内であるかどうか
     *
     * @param string $datetime
     * @return bool
     */
    public function is_expire_date_password_reminder_token($datetime) {
        $is_expired = false;

        // 現在日時のタイムスタンプを取得
        $current_timestamp = strtotime(date('YmdHis'));

        // 有効期限のタイムスタンプを算出
        $expire_date_timestamp = strtotime('+' . PASSWORD_REMINDER_EXPIRED_MINUTE . 'minute', strtotime($datetime));

        if ($expire_date_timestamp <= $current_timestamp) {
            // 現在日時が有効期限以上だった場合
            $is_expired = true;
        }

        return $is_expired;
    }

    /**
     * ユーザー情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_user_info($user_id, $business_id) {
        $logic_human_life_user = new Logic_HumanLife_User();
        return $logic_human_life_user->get_user_info_by_user_id($user_id, $business_id);
    }

    /**
     * パスワード変更
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param string $password
     * @throws Exception
     */
    public function update_user_password($user_id, $business_id, $password) {
        $logic_human_life_user = new Logic_HumanLife_User();
        $logic_human_life_password_reminder = new Logic_HumanLife_Passwordreminder();

        try {
            // トランザクションの開始
            DB::start_transaction();

            // パスワードの更新
            $logic_human_life_user->update_user_password($user_id, $business_id, $password);

            // トークンの論理削除
            $logic_human_life_password_reminder->delete_password_reminder($user_id, $business_id);

            // コミット
            DB::commit_transaction();
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }

    /**
     * 仮申込パスワード変更
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param string $password
     * @throws Exception
     */
    public function update_draft_user_password($user_id, $business_id, $password) {
        $logic_human_life_user = new Logic_HumanLife_User();
        $logic_human_life_password_reminder = new Logic_HumanLife_Passwordreminder();

        try {
            // トランザクションの開始
            DB::start_transaction();

            // パスワードの更新
            $logic_human_life_user->update_draft_user_password($user_id, $business_id, $password);

            // コミット
            DB::commit_transaction();
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
    }

}
