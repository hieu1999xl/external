<?php

/**
 * ユーザテーブルのロジッククラス
 */
class Logic_HumanLife_User extends Logic_Base {

    /**
     * メールアドレスを条件にユーザー情報を取得する
     *
     * @param string $email
     * @param int    $business_id
     * @return array
     */
    public function get_user_info_by_email($email, $business_id) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        // メールアドレスを条件にユーザー情報を取得
        $user_info = $model_human_life_user->get_user_info_by_email($email, $business_id);

        if (!empty($user_info)) {
            $res = $user_info[0];
        }
        return $res;
    }

    /**
     * メールアドレスを条件にユーザー情報を取得する(重複チェック専用)
     *
     * @param string $email
     * @param int    $business_id
     * @return array
     */
    public function get_user_info_by_email_for_duplicate_check($email, $business_id)
    {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        // メールアドレスを条件にユーザー情報を取得
        $user_info = $model_human_life_user->get_user_info_by_email_for_duplicate_check($email, $business_id);

        if (!empty($user_info)) {
            $res = $user_info[0];
        }
        return $res;
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
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        // メールアドレスを条件にユーザー情報を取得
        $user_info = $model_human_life_user->get_user_login_info_by_email($email, $business_id, $plan_type);

        if (!empty($user_info)) {
            $res = $user_info[0];
        }
        return $res;
    }

    /**
     * ハッシュを条件にユーザー情報を取得する
     *
     * @param string $telephone_entry_hash
     * @param int $user_id
     * @param int entry_id
     * @return array
     */
    public function get_user_info_by_telephone_entry_hash($telephone_entry_hash) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        //ハッシュを条件にユーザー情報を取得
        $user_info = $model_human_life_user->get_user_info_by_telephone_entry_hash($telephone_entry_hash);

        if (!empty($user_info)) {
            $res = $user_info[0];
        }

        return $res;
    }


    /**
     * フリープラン初期契約解除を除外して後かと判断する
     *
     * @param $entry_id
     * @param int $business_id
     */
    public function is_user_entry_after_free_plan_initial_contract_cancellation_excluded($entry_id, $business_id) {
        $model_user = new Model_HumanLife_User();
        $result_user = $model_user->is_user_entry_after_free_plan_initial_contract_cancellation_excluded($entry_id, $business_id);
        return !empty($result_user);
    }

    public function get_user_info_with_set_entry($email, $last_name, $first_name, $last_name_kana, $first_name_kana, $business_id, $external_service_set_id = 1) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        // メールアドレスを条件にユーザー情報を取得
        $user_info = $model_human_life_user->get_user_info_with_set_entry($email, $last_name, $first_name, $last_name_kana, $first_name_kana, $business_id, $external_service_set_id);

        if (!empty($user_info)) {
            $res = $user_info[0];
        }
        return $res;
    }

    public function get_user_info_by_name_and_email($email, $last_name, $first_name, $last_name_kana, $first_name_kana, $business_id) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        // メールアドレスを条件にユーザー情報を取得
        $user_info = $model_human_life_user->get_user_info_by_name_and_email($email, $last_name, $first_name, $last_name_kana, $first_name_kana, $business_id);

        if (!empty($user_info)) {
            $res = $user_info[0];
        }
        return $res;
    }

    public function get_user_contact_info_by_email($email, $business_id) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        // メールアドレスを条件にユーザー情報を取得
        $user_info = $model_human_life_user->get_user_contact_info_by_email($email, $business_id);

        if (!empty($user_info)) {
            $res = $user_info[0];
        }
        return $res;
    }

    public function get_user_contact_info_by_user_id($user_id, $business_id) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        // user_idを条件にユーザー情報を取得
        $user_info = $model_human_life_user->get_user_contact_info_by_user_id($user_id, $business_id);

        return $user_info;
    }

    public function get_user_info_by_invoice_email($user_id, $business_id) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        // メールアドレスを条件にユーザー情報を取得
        $user_info = $model_human_life_user->get_user_info_by_invoice_email($user_id, $business_id);

        if (!empty($user_info)) {
            $res = $user_info[0];
        }
        return $res;
    }

    /**
     * 名前、住所、電話番号を条件にユーザー情報を取得する
     *
     * @param string $last_name
     * @param string $first_name
     * @param string $last_name_kana
     * @param string $first_name_kana
     * @param string $tel1_1
     * @param string $tel1_2
     * @param string $tel1_3
     * @param string $prefecture
     * @param string $city
     * @param $town
     * @param int $business_id
     * @return array
     */
    public function get_user_entry_count($last_name,$first_name,$last_name_kana,$first_name_kana,$tel1_1,$tel1_2,$tel1_3,$prefecture,$city,$town,$business_id) {
        $model_human_life_user = new Model_HumanLife_User();
        // 名前、住所、電話番号を条件にユーザー情報を取得
        return $model_human_life_user->get_user_entry_count($last_name,$first_name,$last_name_kana,$first_name_kana,$tel1_1,$tel1_2,$tel1_3,$prefecture,$city,$town,$business_id);
    }

    /**
     * 住所、電話番号を条件にユーザー情報を取得する
     *
     * @param string $tel1_1
     * @param string $tel1_2
     * @param string $tel1_3
     * @param string $prefecture
     * @param string $city
     * @param $town
     * @param int $business_id
     * @return array
     */
    public function get_user_entry_is_suspected($tel1_1,$tel1_2,$tel1_3,$prefecture,$city,$town,$block,$business_id) {
        $model_human_life_user = new Model_HumanLife_User();
        // 名前、住所、電話番号を条件にユーザー情報を取得
        return $model_human_life_user->get_user_entry_is_suspected($tel1_1,$tel1_2,$tel1_3,$prefecture,$city,$town,$block,$business_id);
    }

    /**
     * メールアドレスを条件にユーザー情報を取得する
     *
     * @param string $email
     * @param int    $business_id
     * @return array
     */
    public function get_corpuser_info_by_email($email, $business_id) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        // メールアドレスを条件にユーザー情報を取得
        $user_info = $model_human_life_user->get_cropuser_info_by_email($email, $business_id);

        if (!empty($user_info)) {
            $res = $user_info[0];
        }

        return $res;
    }

    /**
     * メールアドレスを条件に現時点で有効なユーザー情報を取得する
     *
     * @param string $email
     * @param int    $business_id
     * @return array
     */
    public function get_valid_user_list_by_email($email, $business_id) {
        $model_human_life_user = new Model_HumanLife_User();
        return $model_human_life_user->get_valid_user_list_by_email($email, $business_id);
    }

    /**
     * ユーザIDと契約IDを条件に契約データの件数を返す
     *
     * @param int $user_id
     * @param int $contract_id
     * @param int $business_id
     * @return int
     */
    public function get_user_contract_count($user_id, $contract_id, $business_id) {
        $model_user = new Model_HumanLife_User();
        // ユーザーIDと契約IDを条件に契約情報を取得する
        return $model_user->get_user_contract_count($user_id, $contract_id, $business_id);
    }

    /**
     * ユーザーIDと契約IDを条件に契約情報を取得する
     *
     * @param int $user_id
     * @param int $contract_id
     * @param int $business_id
     * @return array
     */
    public function get_user_contract_info($user_id, $contract_id, $business_id) {
        $res = [];

        $model_user = new Model_HumanLife_User();
        // ユーザーIDと契約IDを条件に契約情報を取得する
        $contract_info_list = $model_user->get_user_contract_info($user_id, $contract_id, $business_id);

        if (!empty($contract_info_list)) {
            $res = $contract_info_list[0];
            // カンマ区切りになっているオプションIDを配列に変換
            $res['option_id_list'] = explode(',', $res['option_id_list']);
        }

        return $res;
    }

    /**
     * ユーザーに紐づく契約プラン情報を取得する
     *
     * @param int $user_id
     * @param int $contract_plan_id
     * @param int $business_id
     *
     * @return array
     */
    public function get_user_contract_plan_info($user_id, $contract_plan_id, $business_id) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        $user_contract_plan_info = $model_human_life_user->get_user_contract_plan_info($user_id, $contract_plan_id, $business_id);

        if (!empty($user_contract_plan_info)) {
            $res = $user_contract_plan_info[0];
        }

        return $res;
    }

    /**
     * ユーザーIDを条件にユーザー情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_user_info_by_user_id($user_id, $business_id, $login_allow_user_status_list = LOGIN_ALLOW_USER_STATUS_LIST) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        $user_info_list = $model_human_life_user->get_user_info_by_user_id($user_id, $business_id, $login_allow_user_status_list);

        if (!empty($user_info_list)) {
            $res = $user_info_list[0];
        }

        return $res;
    }

    /**
     * ユーザーIDを条件にユーザー情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_draft_user_info_by_user_id($user_id, $business_id) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        $user_info_list = $model_human_life_user->get_draft_user_info_by_user_id($user_id, $business_id);

        if (!empty($user_info_list)) {
            $res = $user_info_list[0];
        }

        return $res;
    }

    /**
     * ユーザーIDを条件にユーザー情報(必要な情報)を取得する
     *
     * @param int $user_id
     * @param array $select
     * @return array
     */
    public function get_user_info_by_only_user_id($user_id , $select){
        return Model_HumanLife_User::forge()->get_user_info_by_only_user_id($user_id , $select);
    }

    /**
     * ユーザーIDを条件にユーザー情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_user_detail_info_by_user_id($user_id, $business_id) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        $user_info_list = $model_human_life_user->get_user_detail_info_by_user_id($user_id, $business_id);
        if (!empty($user_info_list)) {
            $res = $user_info_list[0];
            // ユーザー連絡先情報を整形する
            $res['contact_info_list'] = $this->format_user_contact($res['contact_info_list_str']);
        }

        return $res;
    }

    /**
     * ユーザーIDを条件にユーザー情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_corp_user_detail_info_by_user_id($user_id, $business_id) {
        $model = new Model_HumanLife_User();
        $user_info_list = $model->get_corp_user_detail_info_by_user_id($user_id, $business_id);
        $res = $user_info_list[0] ?? [];
        if (!empty($res['company_info_list_str'])) {
            // 会社ユーザー連絡先情報を整形する
            $res['company_info_list'] = $this->format_corp_user_contact($res['company_info_list_str']);
        }

        return $res;
    }

    /**
     * ユーザーに紐づくUCL情報を取得する
     *
     * @param $user_id
     * @param $contract_id
     * @param $business_id
     * @return array
     */
    public function get_user_ucl_info($user_id, $contract_id, $business_id) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        $user_ucl_info_list = $model_human_life_user->get_user_ucl_info($user_id, $contract_id, $business_id);

        if (!empty($user_ucl_info_list)) {
            $res = $user_ucl_info_list[0];

        }

        return $res;
    }

    /**
     * ユーザー情報を更新する
     *
     * @param int   $user_id
     * @param int   $business_id
     * @param array $params
     */
    public function update_user_info($user_id, $business_id, $params) {
        $model_human_life_user = new Model_HumanLife_User();
        $model_human_life_user->update_user_info($user_id, $business_id, $params);
    }

    /**
     * ユーザIDを条件にユーザ情報を無効(退会)状態に更新する
     *
     * @param int $business_id
     * @param int $user_id
     * @return int
     */
    public function update_invalid_status_by_user_id($business_id, $user_id) {
        $model_humanlife_user = new Model_HumanLife_User();
        $result = $model_humanlife_user->update_invalid_status_by_user_id($business_id, $user_id);
        return $result;
    }

    /**
     * パスワード変更
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param string $password
     */
    public function update_user_password($user_id, $business_id, $password) {
        $model_humanlife_user = new Model_HumanLife_User();
        $model_humanlife_user->update_user_password($user_id, $business_id, $password);
    }

    public function update_draft_user_password($user_id, $business_id, $password) {
        $model_humanlife_user = new Model_HumanLife_User();
        $model_humanlife_user->update_draft_user_password($user_id, $business_id, $password);
    }

    public function cancel_draft_user_by_user_id($business_id, $user_id) {
        $model = new Model_HumanLife_User();
        return $model->cancel_draft_user_by_user_id($business_id, $user_id);
    }

    public function cancel_draft_user_with_same_email($business_id, $email, $user_id) {
        $model = new Model_HumanLife_User();
        return $model->cancel_draft_user_with_same_email($business_id, $email, $user_id);
    }

    /**
     * ユーザー連絡先情報を整形する
     *
     * @param string $contact_info_list_str
     * @return array
     */
    private function format_user_contact($contact_info_list_str) {
        $res = [];

        // カンマ区切りに連結されたユーザー連絡先城リストを配列に変換
        $contact_info_list = explode(',', $contact_info_list_str);

        foreach ($contact_info_list as $contact_info_str) {
            // アンダースコア区切りに連結されたオプション情報を配列に変換
            $option_info = explode('_', $contact_info_str);

            if ($option_info[0] !== '') {
                $res[] = [
                    'contact_type'    => $option_info[0],
                    'zipcode1'        => $option_info[1],
                    'zipcode2'        => $option_info[2],
                    'prefecture'      => $option_info[3],
                    'city'            => $option_info[4],
                    'town'            => $option_info[5],
                    'block'           => $option_info[6],
                    'building'        => $option_info[7],
                    'last_name'       => $option_info[8],
                    'last_name_kana'  => $option_info[9],
                    'first_name'      => $option_info[10],
                    'first_name_kana' => $option_info[11],
                    'tel1_1'          => $option_info[12],
                    'tel1_2'          => $option_info[13],
                    'tel1_3'          => $option_info[14],
                    'tel2_1'          => isset($option_info[15]) ? $option_info[15] : '',
                    'tel2_2'          => isset($option_info[16]) ? $option_info[16] : '',
                    'tel2_3'          => isset($option_info[17]) ? $option_info[17] : '',
                ];
            }
        }

        return $res;
    }

    /**
     * Corpユーザー連絡先情報を整形する
     *
     * @param string $contact_info_list_str
     * @return array
     */
    private function format_corp_user_contact($company_info_list_str) {

        $res = [];

        // カンマ区切りに連結されたユーザー連絡先城リストを配列に変換
        $company_info_list = explode(',', $company_info_list_str);
        foreach ($company_info_list as $company_info_str) {
            // アンダースコア区切りに連結されたオプション情報を配列に変換
            $option_info = explode('_', $company_info_str);


            if ($option_info[0] !== '') {

                $res[] = [

                    'zipcode1'        => $option_info[0],
                    'zipcode2'        => $option_info[1],
                    'prefecture'      => $option_info[2],
                    'city'            => $option_info[3],
                    'town'            => $option_info[4],
                    'block'           => $option_info[5],
                    'building'        => $option_info[6],
                    'tel1_1'          => $option_info[7],
                    'tel1_2'          => $option_info[8],
                    'tel1_3'          => $option_info[9],
                    'tel2_1'          => $option_info[10],
                    'tel2_2'          => $option_info[11],
                    'tel2_3'          => $option_info[12],

                ];
            }
        }
        return $res;

    }

    /**
     * 法人ID変更
     *
     * @param int    $business_id
     * @param string $user_id
     * @param int    $company_id
     * @return number
     */
    public function update_company_id($business_id, $user_id, $company_id) {
        $model_humanlife_user = new Model_HumanLife_User();
        return $model_humanlife_user->update_company_id($business_id, $user_id, $company_id);
    }

    /**
     * 登録する
     *
     * @param array $insert_params
     * @return number
     */
    public function insert($insert_params) {
        $model_human_life_user = new Model_HumanLife_User();
        return $model_human_life_user->insert($insert_params);
    }

    /**
     * get_user_info and contract_id
     * @param int    $user_id
     * @param int    $business_id
     * @return array
     */
    public function get_user_info_and_contract_id_by_user_id($user_id, $business_id) {
        $model_human_life_user = new Model_HumanLife_User();
        return $model_human_life_user->get_user_info_and_contract_id_by_user_id($user_id, $business_id);
    }

    /**
     * ユーザIDを条件にユーザ情報と法人情報を取得する
     *
     * @param int $business_id
     * @param int $user_id
     * @return array
     */
    public function get_user_corp_info_by_user_id($business_id, $user_id) {
        $model_human_life_user = new Model_HumanLife_User();
        return $model_human_life_user->get_user_corp_info_by_user_id($business_id, $user_id);
    }

    /**
     * 利用日が指定された範囲内の契約情報を取得する
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function get_rel_contract_info_list_by_target_range_date($user_id, $business_id, $start_date, $end_date) {
        $model_human_life_user = new Model_HumanLife_User();
        $rel_contract_info_list = $model_human_life_user->get_rel_contract_info_list_by_target_range_date($user_id, $business_id, $start_date, $end_date);

        foreach ($rel_contract_info_list as $key => $rel_contract_info) {
            // プラン情報を整形する
            $rel_contract_info_list['contract_plan_info_list'] = $this->format_contract_plan($rel_contract_info['contract_plan_info_list_str']);
            // オプション情報を整形する
            $rel_contract_info_list['contract_option_info_list'] = $this->format_contract_option($rel_contract_info['contract_option_info_list_str']);
        }

        return $rel_contract_info_list;
    }

    //get user mail
    public function get_user_email_by_user_id($user_id, $business_id){
        $model_human_life_user = new Model_HumanLife_User();
        $user_email_list = $model_human_life_user->get_user_email_by_user_id($user_id, $business_id);

        $email_info = [];
        if (!empty($user_email_list)) {
            $email_info = $user_email_list[0];
        }
        return $email_info;
    }

    /**
     * 契約プラン情報を整形する
     *
     * @param string $contact_plan_info_list_str
     * @return array
     */
    private function format_contract_plan($contact_plan_info_list_str) {
        $res = [];

        // カンマ区切りに連結された契約プラン情報を配列に変換
        $contact_plan_info_list = explode(',', $contact_plan_info_list_str);

        foreach ($contact_plan_info_list as $contact_plan_info_str) {
            // アンダースコア区切りに連結された契約プラン情報を配列に変換
            $contact_plan_info = explode('_', $contact_plan_info_str);

            if ($contact_plan_info[0] !== '') {
                $res[] = [
                    'contract_plan_id' => $contact_plan_info[0],
                    'price'            => $contact_plan_info[1],
                ];
            }
        }

        return $res;
    }

    /**
     * 契約オプション情報を整形する
     *
     * @param string $contact_option_info_list_str
     * @return array
     */
    private function format_contract_option($contact_option_info_list_str) {
        $res = [];

        // カンマ区切りに連結された契約プラン情報を配列に変換
        $contact_option_info_list = explode(',', $contact_option_info_list_str);

        foreach ($contact_option_info_list as $contact_option_info_str) {
            // アンダースコア区切りに連結された契約プラン情報を配列に変換
            $contact_option_info = explode('_', $contact_option_info_str);

            if ($contact_option_info[0] !== '') {
                $res[] = [
                    'contract_option_id' => $contact_option_info[0],
                    'price'              => $contact_option_info[1],
                ];
            }
        }

        return $res;
    }

    /**
     * ユーザIDでユーザー情報を取得する
     *
     * @param array $where_column
     * @return array
     */
    public function get_form_user_info_by_user_id($user_id) {
        return Model_HumanLife_User::forge()->get_form_user_info_by_user_id($user_id);
    }

    /**
     * ユーザIDを元に、ユーザレコードを取得する
     * internal_mngより移植
     *
     * @param int $business_id
     * @param int $user_id
     * @return array
     */
    public function get_user_data_by_user_id($business_id, $user_id)
    {
        $model_user = new Model_HumanLife_User();
        $record = $model_user->get_user_data_by_user_id($business_id, $user_id);

        return (empty($record)) ? null : $record;
    }

    /**
     * emailでログイン可能な顧客情報を取得する
     *
     * @param  string $email
     * @param  int    $business_id
     * @return array
     */
    public function can_user_login_by_email($email, $business_id) {
        $model_human_life_user = new Model_HumanLife_User();
        $user_with_login_id_list = $model_human_life_user->can_user_login_by_email($email, $business_id);

        return empty($user_with_login_id_list);
    }

    /**
     * メールアドレスを条件にユーザー情報を取得する
     *
     * @param string $login_user_id
     * @param int    $business_id
     * @return array
     */
    public function get_user_login_info_by_login_user_id($login_user_id, $business_id) {
        $res = [];

        $model_human_life_user = new Model_HumanLife_User();
        // メールアドレスを条件にユーザー情報を取得
        $user_info = $model_human_life_user->get_user_login_info_by_login_user_id($login_user_id, $business_id);

        if (!empty($user_info)) {
            $res = $user_info[0];
        }
        return $res;
    }

    /**
     * 会員IDの一覧を取得する
     *
     * @param  array $user_ids
     * @param  int   $business_id
     * @return array $result
     */
    public function get_user_login_id_info_list($user_ids, $business_id) {
        $model_human_life_user = new Model_HumanLife_User();

        $user_info_list = $model_human_life_user->get_user_login_id_info_list($user_ids, $business_id);

        return $user_info_list;
    }

    /**
     * メールアドレスを条件にユーザーリスト情報を取得する
     *
     * @param string $email
     * @param int    $business_id
     * @return array
     */
    public function get_user_info_list_by_email($email, $business_id) {

        $model_human_life_user = new Model_HumanLife_User();
        // メールアドレスを条件にユーザー情報を取得
        $user_info_list = $model_human_life_user->get_user_info_by_email($email, $business_id);

        return $user_info_list;
    }

    /**
     * ユーザー区分から請求先情報を取得する
     *
     * @param integer $business_id 事業者ID
     * @param integer $user_id ユーザーID
     * @param integer $user_type ユーザー区分
     * @return array
     */
    public function get_bill_to_info($business_id, $user_id, $user_type)
    {
        $model = new Model_HumanLife_User();
        $user_info = [];

        if ($user_type === USER_TYPE_LIST['PRIVATE']) {
            $result = $model->get_user_info_with_contact_info($business_id, $user_id, USER_CONTACT_TYPE_CONTRACT);
            if ($result !== []) {
                $user_info = $result[0];
                // 契約者連絡先の氏名が設定されていた場合はユーザー氏名を上書き設定する
                $user_info['last_name'] = empty($user_info['contact_last_name']) ? $user_info['last_name'] : $user_info['contact_last_name'];
                $user_info['last_name_kana'] = empty($user_info['contact_last_name_kana']) ? $user_info['last_name_kana'] : $user_info['contact_last_name_kana'];
                $user_info['first_name'] = empty($user_info['contact_first_name']) ? $user_info['first_name'] : $user_info['contact_first_name'];
                $user_info['first_name_kana'] = empty($user_info['contact_first_name_kana']) ? $user_info['first_name_kana'] : $user_info['contact_first_name_kana'];
            }
        } else {
            $result = $model->get_user_info_with_company_info($business_id, $user_id);
            if ($result !== []) {
                $user_info = $result[0];
            }
        }
        return $user_info;
    }

    /**
     * メールアドレスとプラン区分から
     *
     * @param int    $business_id
     * @param string $email
     * @param int    $plan_type
     * @return array 複数申込情報対応
     */
    public function get_exists_email_by_plan_type($business_id, $email, $plan_type)
    {
        $model_human_life_user = new Model_HumanLife_User();
        // メールアドレスを条件にユーザー情報を取得
        return $model_human_life_user->get_exists_email_by_plan_type($business_id, $email, $plan_type);
    }

    /**
     * ユーザーIDとプラン区分を条件にユーザーのステータスを取得する
     *
     * @param int $business_id
     * @param int $user_id
     * @return int 対象ユーザーのステータス
     */
    public function get_user_status_by_user_id_plan_type($business_id, $user_id, $plan_type) {
        $model_human_life_user = new Model_HumanLife_User();
        $result = $model_human_life_user->get_user_info_by_user_id_plan_type($business_id, $user_id, $plan_type);
        $return = array_unique(array_column($result, 'status'));
        return $return[0] ?? null;
    }

    /**
     * セゾンカード受付番号変更
     *
     * @param string $saison_code
     * @param int    $user_id
     */
    public function update_saison_code($saison_code, $user_id) {
        $update_params = [
            'saison_code'   => $saison_code,
            'update_user'   => $user_id,
            'saison_update_datetime'    => Helper_Time::getCurrentDateTime(),
        ];
        $wheres = [
            'user_id'   => $user_id,
        ];
        $model_humanlife_user = new Model_HumanLife_User();
        $model_humanlife_user->update($update_params, $wheres);
    }

    /**
     * user_idをキーにした検索
     *
     * @param int $user_id
     * @return array 検索結果1件
     */
    public function get_record_by_pk($user_id) {
        $model = new Model_HumanLife_User();
        $select = ['company_id'];   // 必要に応じてカラムを追加
        $result = $model->get_record($select, ['user_id' => $user_id]);
        return $result[0] ?? [];
    }

    /**
     * emailをキーにした検索
     *
     * @param string $email
     * @return array $result 同一メールアドレスの複数ユーザーを想定
     */
    public function get_record_by_email($email) {
        $model = new Model_HumanLife_User();
        $select = ['user_id'];   // 必要に応じてカラムを追加
        $result = $model->get_record($select, ['email' => $email]);
        return $result;
    }
}
