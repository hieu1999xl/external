<?php

/**
 * 本人確認用トークンのサービスクラス
 */
class Service_Password_Forget extends Service_Base {

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
     * 本人確認用トークンを登録する
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param string $token
     */
    public function insert_password_reminder($user_id, $business_id, $token) {
        $logic_human_life_password_reminder = new Logic_HumanLife_PasswordReminder();
        $logic_human_life_password_reminder->insert_password_reminder($user_id, $business_id, $token);
    }
}
