<?php

/**
 * ユーザのサービスクラス
 *
 * @author ito
 *
 */
class Service_User extends Service_Base {

    /**
     * user情報・連絡先情報を整形する
     *
     * @param  array  $user_info
     * @param  array  $contact_info
     * @return array
     */
    public function format_user_info($user_info, $contact_info) {

        $contact_info_idx_list = [
            'last_name',
            'first_name',
            'last_name_kana',
            'first_name_kana',
            'prefecture',
            'city',
            'town',
            'block',
            'building',
            'tel1_1',
            'tel1_2',
            'tel1_3',
            'tel2_1',
            'tel2_2',
            'tel2_3',
            'zipcode1',
            'zipcode2'
        ];

        // フォーム用に置換
        $convert_info_idx_list = [
            'zipcode_1' => 'zipcode1',
            'zipcode_2' => 'zipcode2'
        ];

        // user情報を整形する
        $format_user_info = $this->convert_info($convert_info_idx_list, $user_info);
        $format_user_info['email_conf'] = $format_user_info['email'];

        // 生年月日の分割
        $birthday_list = $this->split_birthday($user_info['birthday']);
        $format_user_info = array_merge($format_user_info, $birthday_list);

        // 配送先の比べる用の配列
        $use_contact_info = $this->create_info_arr($contact_info_idx_list, $format_user_info);

        // 連絡先情報
        foreach ($contact_info as $contact_type => $contact_data) {
            $format_contact_info = $this->format_contact_info($contact_info_idx_list, $contact_type, $contact_data, $use_contact_info);
            $format_user_info = array_merge($format_user_info, $format_contact_info);
        }

        // フォーム用に置換
        $convert_info_idx_list = [
            'zipcode1' => 'zipcode_1',
            'zipcode2' => 'zipcode_2'
        ];
        $format_user_info = $this->convert_info($convert_info_idx_list, $format_user_info);

        return $format_user_info;
    }

    /**
     * 誕生日を年/月/日を個別して返す
     *
     * @param date $birthday
     * @return array
     */
    private function split_birthday($birthday) {
        $date_obj = new DateTimeImmutable($birthday);
        return [
            'birthday_year' => $date_obj->format('Y'),
            'birthday_month' => $date_obj->format('n'),
            'birthday_day' => $date_obj->format('j')
        ];
    }

    /**
     * ご利用者情報・配送先情報の整形
     *
     * @param array $contact_info_key_list
     * @param int   $contact_type
     * @param array $contact_info
     * @param array $use_contact_info
     * @return array
     */
    private function format_contact_info($contact_info_key_list, $contact_type, $contact_info, $use_contact_info) {
        // ご利用者情報
        if((int) $contact_type === CONTACT_TYPE_VALUE_LIST['USER']) {
            $prefix = 'user_';
        } else {
        // 配送先情報
            $prefix = 'delivery_';
        }

        $contact_data = $this->create_info_arr($contact_info_key_list, $contact_info, $prefix);
        unset($contact_data['contact_type']);

        // ご契約者情報と (ご利用者情報 or 配送先情報)を比較して値に差異がなければ、「ご契約者様と同じ」にする
        if (count($use_contact_info) === count($contact_data) && count(array_diff($use_contact_info, $contact_data)) === 0) {
            // 「ご契約者様と同じ」
            $contact_data[$prefix.'info'] = DELIVERY_INFO_VALUE_LIST['SAME'];
        } else {
            // 「ご契約者様と異なる」
            $contact_data[$prefix.'info'] = DELIVERY_INFO_VALUE_LIST['DIFF'];
        }
        return $contact_data;
    }

    /**
     * データの変更
     *
     * @param array $convert_idx_list
     * @param array $info
     * @return array
     */
    private function convert_info($convert_idx_list, $info) {
        $result = $info;
        foreach($convert_idx_list as $before => $after) {
            $value = $result[$before];
            $result[$after] = $value;
            unset($result[$before]);
        }
        return $result;
    }

    /**
     * 必要情報の配列を作成する
     *
     * @param array $idx_list
     * @param array $data
     * @param string $prefix
     * @return array
     */
    private function create_info_arr($idx_list, $data, $prefix = '') {
        $result = [];
        foreach($idx_list as $key) {
            $result[$prefix.$key] = $data[$key];
        }
        return $result;
    }

    /**
     * ユーザIDを元に、ユーザレコードを取得する
     * internal_mngより移植
     *
     * @param int $business_id
     * @param int $user_id
     * @return mixed
     */
    public function get_user_data_by_user_id($business_id, $user_id)
    {
        $logic_user = new Logic_HumanLife_User();
        $user_data = $logic_user->get_user_data_by_user_id($business_id, $user_id);

        if (! empty($user_data)) {
            // ユーザれコードが取得できた場合、
            // 契約番号をセット
            $user_data['mall_number'] = $user_data['contract_id'] ? sprintf('%05d-%08d', $user_data['business_id'], $user_data['contract_id']) : '';
        }
        return $user_data;
    }

    /**
     * UCLの端末再開処理
     * internal_mngより移植
     *
     * @param int $update_user_id
     * @param int $business_id
     * @param array $user
     * @param integer $ucl_account_type 初期値はGimmit
     * @return array [処理結果, 解約失敗Object]
     */
    public function resume_user($update_user_id = USER_UCL_ADMIN_ID, $business_id, $user, $ucl_account_type = UCL_ACCOUNT_TYPE_GIMMIT)
    {
        $logic_user = new Logic_HumanLife_User();

        // UCLアクセストークン管理にUCLユーザID毎のアクセストークンの最新を保存
        $ucl_access_token_management = new Logic_HumanLife_UclAccessTokenManagement();
        $ret_gul = $ucl_access_token_management->get_latest_access_token($ucl_account_type);

        $ucl_access_token = $ret_gul['data']['accessToken'];
        $ucl_user_id = $ret_gul['data']['userId'];

        $common = [
            'logic_user' => $logic_user,
            'ucl_access_token' => $ucl_access_token,
            'ucl_user_id' => $ucl_user_id
        ];

        $statuses = [
            'user_status' => USER_STATUS_VALUE_LIST['VALID'],
            'ucl_operate_type' => UCL_USER_OPERATE_TYPE_START
        ];

        return $this->update_user_status($common, $update_user_id, $business_id, $user, $statuses, $ucl_account_type);
    }

    /**
     * ユーザステータス更新処理
     * internal_mngより移植
     *
     * @param array $common
     * @param int $update_user_id
     * @param int $business_id
     * @param array $user
     * @param array $statuses
     * @param integer $ucl_account_type 初期値はGimmit
     * @return array [処理結果, 解約失敗Object]
     */
    private function update_user_status($common, $update_user_id, $business_id, $user, $statuses, $ucl_account_type)
    {
        $logic_user = $common['logic_user'];
        $ucl_access_token = $common['ucl_access_token'];
        $ucl_user_id = $common['ucl_user_id'];

        $user_id = $user['user_id'];
        $ucl_user_code = $user['user_code'];

        $user_status = $statuses['user_status'];
        $ucl_operate_type = $statuses['ucl_operate_type'];

        try {
            DB::start_transaction();

            // UCL（WiMAXも対象）
            $logic_ucl_ssu = new Logic_UCloudLink_StopSubUser();
            if ($ucl_operate_type == UCL_USER_OPERATE_TYPE_STOP) {
                $result = $logic_ucl_ssu->stop($ucl_access_token, $ucl_user_id, $ucl_user_code, $ucl_account_type);
            } else {
                $result = $logic_ucl_ssu->start($ucl_access_token, $ucl_user_id, $ucl_user_code, $ucl_account_type);
            }

            if ($result['resultCode'] != UCL_RESULT_CODE_SUCCESS) {
                $msg = "[{__CLASS__}][{__FUNCTION__}][UCL] StopSubUserに失敗しました。" . " resultCode: {$result['resultCode']} user_id: {$user_id}";
                Log::application()->error($msg);
                Helper_Mail::send_error_mail($msg, null, null);
                DB::rollback_transaction();
                return [
                    false,
                    null
                ];
            }

            Log::application()->info('UCLでの端末有効化に成功しました。 端末ID：' . $result['streamNo']);
            // DBのステータスを更新
            $update_params = [
                'status' => $user_status,
                'update_user' => $update_user_id,
            ];
            $logic_user->update_user_info($user_id, $business_id, $update_params);

            DB::commit_transaction();
        } catch (Exception $e) {
            DB::rollback_transaction();
            throw $e;
        }
        return [
            true,
            null
        ];
    }

    /**
     * 対象ユーザがWiMAXかを返す
     *
     * @param int $user_id
     * @return bool WiMAXならtrue
     */
    public function is_wimax($user_id) {

        $logic = new Logic_HumanLife_Entry();
        $result = $logic->get_mst_plan_by_user_id($user_id);
        if ($result['device_type'] === (string)DEVICE_TYPE_WIMAX) {
            return true;
        }
        return false;
    }

}
