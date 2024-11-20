<?php
/**
 * Validationルールの定義ファイル
 */
return [
    'projectlist' => [
        'cond_from' => [
            'label' => '申込日（自）',
            'rules' => 'valid_date[Y/m/d]',
        ],
        'cond_to'   => [
            'label' => '申込日（至）',
            'rules' => 'valid_date[Y/m/d]',
        ],
    ],

    'projectedit' => [
        'basicinfo'     => [
            'project_status'         => [
                'label' => '店舗ステータス',
                'rules' => 'required_after_trim|code[ProjectStatus]',
            ],
            'cancel_schedule_date'   => [
                'label' => '解約予定日',
                'rules' => 'valid_date[Y/m/d]',
            ],
            'terminal_arrange_date'  => [
                'label' => '端末手配日',
                'rules' => 'valid_date[Y/m/d]',
            ],
            'terminal_delivery_date' => [
                'label' => '端末発送日',
                'rules' => 'valid_date[Y/m/d]',
            ],
            'delivery_slip_no'       => [
                'label' => '伝票番号',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'comment'                => [
                'label' => '備考',
                'rules' => 'max_length[1000]|suitable_string',
            ],
        ],
        'systemsetting' => [
            'netstars_company_code'         => [
                'label' => '企業コード',
                'rules' => 'max_length[8]|suitable_string',
            ],
            'netstars_company_name'         => [
                'label' => '企業名称',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'netstars_company_abbreviation' => [
                'label' => '企業略称',
                'rules' => 'max_length[4]|valid_string[alpha]',
            ],
            'netstars_shop_code'            => [
                'label' => '店舗コード',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'netstars_device_password'      => [
                'label' => '端末設定PW',
                'rules' => 'max_length[8]|alpha_num',
            ],
            'netstars_license_no'           => [
                'label' => 'ライセンス番号',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'netstars_merchant_id'          => [
                'label' => 'マーチャントID',
                'rules' => 'max_length[20]|alpha_num',
            ],
            'netmove_mall_code'             => [
                'label' => 'モールコード',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'netmove_device_id'             => [
                'label' => '端末識別番号',
                'rules' => 'max_length[26]|suitable_string',
            ],
            'netmove_shop_no'               => [
                'label' => '加盟店番号（SBI）',
                'rules' => 'max_length[15]|suitable_string',
            ],
            'netmove_report_date'           => [
                'label' => '報告日（SBI）',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'netmove_entry_result'          => [
                'label' => '審査結果（SBI）',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'netmove_economic_condition'    => [
                'label' => '経済条件（SBI）',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'rakuten_shop_no'               => [
                'label' => '加盟店番号（楽天カード）',
                'rules' => 'max_length[15]|suitable_string',
            ],
            'rakuten_report_date'           => [
                'label' => '報告日（楽天カード）',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'rakuten_entry_result'          => [
                'label' => '審査結果（楽天カード）',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'rakuten_economic_condition'    => [
                'label' => '経済条件（楽天カード）',
                'rules' => 'max_length[255]|suitable_string',
            ],
//             'ginren_shop_no' => array(
//                 'label' => '加盟店番号（銀聯）',
//                 'rules' => 'max_length[15]|suitable_string'
//             ),
//             'ginren_report_date' => array(
//                 'label' => '報告日（銀聯）',
//                 'rules' => 'max_length[255]|suitable_string'
//             ),
//             'ginren_entry_result' => array(
//                 'label' => '審査結果（銀聯）',
//                 'rules' => 'max_length[255]|suitable_string'
//             ),
//             'ginren_economic_condition' => array(
//                 'label' => '経済条件（銀聯）',
//                 'rules' => 'max_length[255]|suitable_string'
//             ),
            'line_channel_id'               => [
                'label' => 'ChannelId',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'line_channel_secret'           => [
                'label' => 'ChannelSecret',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'line_at_id'                    => [
                'label' => 'LINE@',
                'rules' => 'max_length[255]|suitable_string',
            ],
            'paypay_merchant_id'            => [
                'label' => '加盟店ID（merchant_id）',
                'rules' => 'max_length[20]|suitable_string',
            ],
            'railroad_company'              => [
                'label' => '交通系事業者',
                'rules' => 'max_length[4]|suitable_string',
            ],
            'waon_shop_no'                  => [
                'label' => 'WAON加盟店番号',
                'rules' => 'max_length[255]|suitable_string',
            ],
        ],
        'paymentmethod' => [
            'brand_project_status' => [
                'label' => '審査ステータス',
                'rules' => 'code[BrandProjectStatus]',
            ],
            'entry_start_date'     => [
                'label' => '加盟審査開始日',
                'rules' => 'valid_date[Y/m/d]',
            ],
            'entry_end_date'       => [
                'label' => '加盟審査終了日',
                'rules' => 'valid_date[Y/m/d]',
            ],
            'entry_result'         => [
                'label' => '加盟審査結果',
                'rules' => 'code[EntryResult]',
            ],
            'mod_start_date'       => [
                'label' => '店舗情報変更開始日',
                'rules' => 'valid_date[Y/m/d]',
            ],
            'mod_end_date'         => [
                'label' => '店舗情報変更終了日',
                'rules' => 'valid_date[Y/m/d]',
            ],
        ],
        'entryinfo'     => [
            'company_name'                => [
                'label' => '会社名',
                'rules' => 'required_after_trim|max_length[100]|suitable_string',
            ],
            'company_name_kana'           => [
                'label' => '会社名（カナ）',
                'rules' => 'required_after_trim|max_length[100]',
            ],
            'company_zip_1'               => [
                'label' => '本社郵便番号（１）',
                'rules' => 'required_after_trim|min_length[3]|max_length[3]|valid_string[numeric]',
            ],
            'company_zip_2'               => [
                'label' => '本社郵便番号（２）',
                'rules' => 'required_after_trim|min_length[4]|max_length[4]|valid_string[numeric]',
            ],
            'company_address_pref'        => [
                'label' => '本社所在地（１）',
                'rules' => 'required_after_trim|max_length[30]|suitable_string',
            ],
            'company_address_city'        => [
                'label' => '本社所在地（２）',
                'rules' => 'required_after_trim|max_length[256]|suitable_string',
            ],
            'company_address_st'          => [
                'label' => '本社所在地（３）',
                'rules' => 'required_after_trim|max_length[256]|suitable_string',
            ],
            'company_address_bldg'        => [
                'label' => '本社所在地（４）',
                'rules' => 'max_length[256]|suitable_string',
            ],
            'company_address_pref_kana'   => [
                'label' => '本社所在地（カナ）（１）',
                'rules' => 'required_after_trim|max_length[30]',
            ],
            'company_address_city_kana'   => [
                'label' => '本社所在地（カナ）（２）',
                'rules' => 'required_after_trim|max_length[256]',
            ],
            'company_address_st_kana'     => [
                'label' => '本社所在地（カナ）（３）',
                'rules' => 'required_after_trim|max_length[256]',
            ],
            'company_address_bldg_kana'   => [
                'label' => '本社所在地（カナ）（４）',
                'rules' => 'max_length[256]',
            ],
            'company_telno_1'             => [
                'label' => '本社電話番号（１）',
                'rules' => 'required_after_trim|min_length[2]|max_length[5]|valid_string[numeric]',
            ],
            'company_telno_2'             => [
                'label' => '本社電話番号（２）',
                'rules' => 'required_after_trim|min_length[1]|max_length[4]|valid_string[numeric]',
            ],
            'company_telno_3'             => [
                'label' => '本社電話番号（３）',
                'rules' => 'required_after_trim|min_length[3]|max_length[4]|valid_string[numeric]',
            ],
            'company_establish_day_year'  => [
                'label' => '会社設立日（１）',
                'rules' => 'max_length[4]|valid_string[numeric]',
            ],
            'company_establish_day_month' => [
                'label' => '会社設立日（２）',
                'rules' => 'max_length[2]|valid_string[numeric]',
            ],
            'company_establish_day_day'   => [
                'label' => '会社設立日（３）',
                'rules' => 'max_length[2]|valid_string[numeric]',
            ],
            'represent_family_name'       => [
                'label' => '代表者氏名（１）',
                'rules' => 'required_after_trim|max_length[40]|suitable_string',
            ],
            'represent_given_name'        => [
                'label' => '代表者氏名（２）',
                'rules' => 'required_after_trim|max_length[40]|suitable_string',
            ],
            'represent_family_name_kana'  => [
                'label' => '代表者氏名（カナ）（１）',
                'rules' => 'required_after_trim|max_length[40]',
            ],
            'represent_given_name_kana'   => [
                'label' => '代表者氏名（カナ）（２）',
                'rules' => 'required_after_trim|max_length[40]',
            ],
            'represent_birthday_year'     => [
                'label' => '代表者生年月日（１）',
                'rules' => 'required_after_trim|max_length[4]|valid_string[numeric]',
            ],
            'represent_birthday_month'    => [
                'label' => '代表者生年月日（２）',
                'rules' => 'required_after_trim|max_length[2]|valid_string[numeric]',
            ],
            'represent_birthday_day'      => [
                'label' => '代表者生年月日（３）',
                'rules' => 'required_after_trim|max_length[2]|valid_string[numeric]',
            ],
            'represent_gender'            => [
                'label' => '代表者性別',
                'rules' => 'required_after_trim|code[RepresentGender]',
            ],
            'represent_zip_1'             => [
                'label' => '代表者郵便番号（１）',
                'rules' => 'required_after_trim|min_length[3]|max_length[3]|valid_string[numeric]',
            ],
            'represent_zip_2'             => [
                'label' => '代表者郵便番号（２）',
                'rules' => 'required_after_trim|min_length[4]|max_length[4]|valid_string[numeric]',
            ],
            'represent_address_pref'      => [
                'label' => '代表者住所（１）',
                'rules' => 'required_after_trim|max_length[30]|suitable_string',
            ],
            'represent_address_city'      => [
                'label' => '代表者住所（２）',
                'rules' => 'required_after_trim|max_length[256]|suitable_string',
            ],
            'represent_address_st'        => [
                'label' => '代表者住所（３）',
                'rules' => 'required_after_trim|max_length[256]|suitable_string',
            ],
            'represent_address_bldg'      => [
                'label' => '代表者住所（４）',
                'rules' => 'max_length[256]|suitable_string',
            ],
            'represent_address_pref_kana' => [
                'label' => '代表者住所（カナ）（１）',
                'rules' => 'required_after_trim|max_length[30]',
            ],
            'represent_address_city_kana' => [
                'label' => '代表者住所（カナ）（２）',
                'rules' => 'required_after_trim|max_length[256]',
            ],
            'represent_address_st_kana'   => [
                'label' => '代表者住所（カナ）（３）',
                'rules' => 'required_after_trim|max_length[256]',
            ],
            'represent_address_bldg_kana' => [
                'label' => '代表者住所（カナ）（４）',
                'rules' => 'max_length[256]',
            ],
            'represent_telno_1'           => [
                'label' => '代表者電話番号（１）',
                'rules' => 'required_after_trim|min_length[2]|max_length[5]|valid_string[numeric]',
            ],
            'represent_telno_2'           => [
                'label' => '代表者電話番号（２）',
                'rules' => 'required_after_trim|min_length[1]|max_length[4]|valid_string[numeric]',
            ],
            'represent_telno_3'           => [
                'label' => '代表者電話番号（３）',
                'rules' => 'required_after_trim|min_length[3]|max_length[4]|valid_string[numeric]',
            ],
            'business_format'             => [
                'label' => '個人・法人区分',
                'rules' => 'required_after_trim|code[BusinessFormat]',
            ],
            'corporate_no'                => [
                'label' => '法人番号',
                'rules' => 'exact_length[13]|valid_string[numeric]',
            ],
            'staff_family_name'           => [
                'label' => '氏名（１）',
                'rules' => 'required_after_trim|max_length[40]|suitable_string',
            ],
            'staff_given_name'            => [
                'label' => '氏名（２）',
                'rules' => 'required_after_trim|max_length[40]|suitable_string',
            ],
            'staff_family_name_kana'      => [
                'label' => '氏名（カナ）（１）',
                'rules' => 'required_after_trim|max_length[40]',
            ],
            'staff_given_name_kana'       => [
                'label' => '氏名（カナ）（２）',
                'rules' => 'required_after_trim|max_length[40]',
            ],
            'staff_telno_1'               => [
                'label' => '連絡先電話番号（１）',
                'rules' => 'required_after_trim|min_length[2]|max_length[5]|valid_string[numeric]',
            ],
            'staff_telno_2'               => [
                'label' => '連絡先電話番号（２）',
                'rules' => 'required_after_trim|min_length[1]|max_length[4]|valid_string[numeric]',
            ],
            'staff_telno_3'               => [
                'label' => '連絡先電話番号（３）',
                'rules' => 'required_after_trim|min_length[3]|max_length[4]|valid_string[numeric]',
            ],
            'staff_mail_address'          => [
                'label' => 'メールアドレス',
                'rules' => 'required_after_trim|max_length[128]|mail_address',
            ],
            'shop_name'                   => [
                'label' => '店舗名',
                'rules' => 'required_after_trim|max_length[64]|suitable_string',
            ],
            'shop_name_kana'              => [
                'label' => '店舗名（カナ）',
                'rules' => 'required_after_trim|max_length[100]',
            ],
            'shop_name_eng'               => [
                'label' => '店舗名（英字）',
                'rules' => 'required_after_trim|max_length[100]|alpha_num',
            ],
            'shop_zip_1'                  => [
                'label' => '店舗郵便番号（１）',
                'rules' => 'required_after_trim|min_length[3]|max_length[3]|valid_string[numeric]',
            ],
            'shop_zip_2'                  => [
                'label' => '店舗郵便番号（２）',
                'rules' => 'required_after_trim|min_length[4]|max_length[4]|valid_string[numeric]',
            ],
            'shop_address_pref'           => [
                'label' => '店舗住所（１）',
                'rules' => 'required_after_trim|max_length[30]|suitable_string',
            ],
            'shop_address_city'           => [
                'label' => '店舗住所（２）',
                'rules' => 'required_after_trim|max_length[256]|suitable_string',
            ],
            'shop_address_st'             => [
                'label' => '店舗住所（３）',
                'rules' => 'required_after_trim|max_length[256]|suitable_string',
            ],
            'shop_address_bldg'           => [
                'label' => '店舗住所（４）',
                'rules' => 'max_length[256]|suitable_string',
            ],
            'shop_address_pref_kana'      => [
                'label' => '店舗住所（カナ）（１）',
                'rules' => 'required_after_trim|max_length[30]',
            ],
            'shop_address_city_kana'      => [
                'label' => '店舗住所（カナ）（２）',
                'rules' => 'required_after_trim|max_length[256]',
            ],
            'shop_address_st_kana'        => [
                'label' => '店舗住所（カナ）（３）',
                'rules' => 'required_after_trim|max_length[256]',
            ],
            'shop_address_bldg_kana'      => [
                'label' => '店舗住所（カナ）（４）',
                'rules' => 'max_length[256]',
            ],
            'shop_telno_1'                => [
                'label' => '店舗電話番号（１）',
                'rules' => 'required_after_trim|min_length[2]|max_length[5]|valid_string[numeric]',
            ],
            'shop_telno_2'                => [
                'label' => '店舗電話番号（２）',
                'rules' => 'required_after_trim|min_length[1]|max_length[4]|valid_string[numeric]',
            ],
            'shop_telno_3'                => [
                'label' => '店舗電話番号（３）',
                'rules' => 'required_after_trim|min_length[3]|max_length[4]|valid_string[numeric]',
            ],
            'shop_official_site'          => [
                'label' => '店舗ホームページURL',
                'rules' => 'required_after_trim|max_length[128]|url',
            ],
            'business_license_no'         => [
                'label' => '営業許可証番号',
                'rules' => 'required_after_trim|max_length[256]|suitable_string',
            ],
            'delivery_sales_flg'          => [
                'label' => '取引・販売方法（１）',
                'rules' => 'code[OnOff]',
            ],
            'telemarketing_flg'           => [
                'label' => '取引・販売方法（２）',
                'rules' => 'code[OnOff]',
            ],
            'chain_sales_flg'             => [
                'label' => '取引・販売方法（３）',
                'rules' => 'code[OnOff]',
            ],
            'job_invite_sales_flg'        => [
                'label' => '取引・販売方法（４）',
                'rules' => 'code[OnOff]',
            ],
            'delivery_zip_1'              => [
                'label' => '郵便番号（１）',
                'rules' => 'required_after_trim|min_length[3]|max_length[3]|valid_string[numeric]',
            ],
            'delivery_zip_2'              => [
                'label' => '郵便番号（２）',
                'rules' => 'required_after_trim|min_length[4]|max_length[4]|valid_string[numeric]',
            ],
            'delivery_address_pref'       => [
                'label' => '住所（１）',
                'rules' => 'required_after_trim|max_length[30]|suitable_string',
            ],
            'delivery_address_city'       => [
                'label' => '住所（２）',
                'rules' => 'required_after_trim|max_length[256]|suitable_string',
            ],
            'delivery_address_st'         => [
                'label' => '住所（３）',
                'rules' => 'required_after_trim|max_length[256]|suitable_string',
            ],
            'delivery_address_bldg'       => [
                'label' => '住所（４）',
                'rules' => 'max_length[256]|suitable_string',
            ],
            'delivery_telno_1'            => [
                'label' => '電話番号（１）',
                'rules' => 'required_after_trim|min_length[2]|max_length[5]|valid_string[numeric]',
            ],
            'delivery_telno_2'            => [
                'label' => '電話番号（２）',
                'rules' => 'required_after_trim|min_length[1]|max_length[4]|valid_string[numeric]',
            ],
            'delivery_telno_3'            => [
                'label' => '電話番号（３）',
                'rules' => 'required_after_trim|min_length[3]|max_length[4]|valid_string[numeric]',
            ],
            'delivery_family_name'        => [
                'label' => '受取人氏名（１）',
                'rules' => 'required_after_trim|max_length[40]|suitable_string',
            ],
            'delivery_given_name'         => [
                'label' => '受取人氏名（２）',
                'rules' => 'required_after_trim|max_length[40]|suitable_string',
            ],
            'delivery_time'               => [
                'label' => '配送希望時間',
                'rules' => 'required_after_trim|code[DeliveryTime]',
            ],
            'payment_device_flg'          => [
                'label' => '決済端末の購入',
                'rules' => 'code[OnOff]',
            ],
            'printer_purchase_flg'        => [
                'label' => 'プリンターの購入',
                'rules' => 'code[OnOff]',
            ],
            'admin_penalty_existence'     => [
                'label' => '直近5年間の特定商取引法による行政処分有無情報',
                'rules' => 'code[TrnOnOff]',
            ],
            'losing_civil_suit_existence' => [
                'label' => '消費者契約法違反の行為を理由とした民事上の敗訴判決有無',
                'rules' => 'code[TrnOnOff]',
            ],
        ],
    ],

    'payinfo' => [
        'cond_from' => [
            'label' => '決済日（自）',
            'rules' => 'required_after_trim|valid_date[Y/m/d]',
        ],
        'cond_to'   => [
            'label' => '決済日（至）',
            'rules' => 'required_after_trim|valid_date[Y/m/d]',
        ],
    ],

    'uploadfile' => [
        'file' => [
            'label' => 'ファイル',
            'rules' => 'file_required|file_upload|file_format|file_name|file_already|file_sizeof[100]|file_line_size',
        ],
    ],

    'bulkregist' => [
        'g_id'                        => [
            'label' => '店舗番号',
            'rules' => 'required_after_trim|alpha_num|regist_already|duplication',
        ],
        'company_name'                => [
            'label' => '会社名',
            'rules' => 'required_after_trim|max_length[100]|suitable_string',
        ],
        'company_name_kana'           => [
            'label' => '会社名（カナ）',
            'rules' => 'required_after_trim|max_length[100]',
        ],
        'company_zip_1'               => [
            'label' => '本社郵便番号（１）',
            'rules' => 'required_after_trim|min_length[3]|max_length[3]|valid_string[numeric]',
        ],
        'company_zip_2'               => [
            'label' => '本社郵便番号（２）',
            'rules' => 'required_after_trim|min_length[4]|max_length[4]|valid_string[numeric]',
        ],
        'company_address_pref'        => [
            'label' => '本社所在地（１）',
            'rules' => 'required_after_trim|max_length[30]|suitable_string',
        ],
        'company_address_city'        => [
            'label' => '本社所在地（２）',
            'rules' => 'required_after_trim|max_length[256]|suitable_string',
        ],
        'company_address_st'          => [
            'label' => '本社所在地（３）',
            'rules' => 'required_after_trim|max_length[256]|suitable_string',
        ],
        'company_address_bldg'        => [
            'label' => '本社所在地（４）',
            'rules' => 'max_length[256]|suitable_string',
        ],
        'company_address_pref_kana'   => [
            'label' => '本社所在地（カナ）（１）',
            'rules' => 'required_after_trim|max_length[30]',
        ],
        'company_address_city_kana'   => [
            'label' => '本社所在地（カナ）（２）',
            'rules' => 'required_after_trim|max_length[256]',
        ],
        'company_address_st_kana'     => [
            'label' => '本社所在地（カナ）（３）',
            'rules' => 'required_after_trim|max_length[256]',
        ],
        'company_address_bldg_kana'   => [
            'label' => '本社所在地（カナ）（４）',
            'rules' => 'max_length[256]',
        ],
        'company_telno_1'             => [
            'label' => '本社電話番号（１）',
            'rules' => 'required_after_trim|min_length[2]|max_length[5]|valid_string[numeric]',
        ],
        'company_telno_2'             => [
            'label' => '本社電話番号（２）',
            'rules' => 'required_after_trim|min_length[1]|max_length[4]|valid_string[numeric]',
        ],
        'company_telno_3'             => [
            'label' => '本社電話番号（３）',
            'rules' => 'required_after_trim|min_length[3]|max_length[4]|valid_string[numeric]',
        ],
        'company_establish_day_year'  => [
            'label' => '会社設立日（１）',
            'rules' => 'required_after_trim|max_length[4]|valid_string[numeric]',
        ],
        'company_establish_day_month' => [
            'label' => '会社設立日（２）',
            'rules' => 'required_after_trim|max_length[2]|valid_string[numeric]',
        ],
        'company_establish_day_day'   => [
            'label' => '会社設立日（３）',
            'rules' => 'required_after_trim|max_length[2]|valid_string[numeric]',
        ],
        'represent_family_name'       => [
            'label' => '代表者氏名（１）',
            'rules' => 'required_after_trim|max_length[40]|suitable_string',
        ],
        'represent_given_name'        => [
            'label' => '代表者氏名（２）',
            'rules' => 'required_after_trim|max_length[40]|suitable_string',
        ],
        'represent_family_name_kana'  => [
            'label' => '代表者氏名（カナ）（１）',
            'rules' => 'required_after_trim|max_length[40]',
        ],
        'represent_given_name_kana'   => [
            'label' => '代表者氏名（カナ）（２）',
            'rules' => 'required_after_trim|max_length[40]',
        ],
        'represent_birthday_year'     => [
            'label' => '代表者生年月日（１）',
            'rules' => 'required_after_trim|max_length[4]|valid_string[numeric]',
        ],
        'represent_birthday_month'    => [
            'label' => '代表者生年月日（２）',
            'rules' => 'required_after_trim|max_length[2]|valid_string[numeric]',
        ],
        'represent_birthday_day'      => [
            'label' => '代表者生年月日（３）',
            'rules' => 'required_after_trim|max_length[2]|valid_string[numeric]',
        ],
        'represent_gender'            => [
            'label' => '代表者性別',
            'rules' => 'required_after_trim|code[RepresentGender]',
        ],
        'represent_zip_1'             => [
            'label' => '代表者郵便番号（１）',
            'rules' => 'required_after_trim|min_length[3]|max_length[3]|valid_string[numeric]',
        ],
        'represent_zip_2'             => [
            'label' => '代表者郵便番号（２）',
            'rules' => 'required_after_trim|min_length[4]|max_length[4]|valid_string[numeric]',
        ],
        'represent_address_pref'      => [
            'label' => '代表者住所（１）',
            'rules' => 'required_after_trim|max_length[30]|suitable_string',
        ],
        'represent_address_city'      => [
            'label' => '代表者住所（２）',
            'rules' => 'required_after_trim|max_length[256]|suitable_string',
        ],
        'represent_address_st'        => [
            'label' => '代表者住所（３）',
            'rules' => 'required_after_trim|max_length[256]|suitable_string',
        ],
        'represent_address_bldg'      => [
            'label' => '代表者住所（４）',
            'rules' => 'max_length[256]|suitable_string',
        ],
        'represent_address_pref_kana' => [
            'label' => '代表者住所（カナ）（１）',
            'rules' => 'required_after_trim|max_length[30]',
        ],
        'represent_address_city_kana' => [
            'label' => '代表者住所（カナ）（２）',
            'rules' => 'required_after_trim|max_length[256]',
        ],
        'represent_address_st_kana'   => [
            'label' => '代表者住所（カナ）（３）',
            'rules' => 'required_after_trim|max_length[256]',
        ],
        'represent_address_bldg_kana' => [
            'label' => '代表者住所（カナ）（４）',
            'rules' => 'max_length[256]',
        ],
        'represent_telno_1'           => [
            'label' => '代表者電話番号（１）',
            'rules' => 'required_after_trim|min_length[2]|max_length[5]|valid_string[numeric]',
        ],
        'represent_telno_2'           => [
            'label' => '代表者電話番号（２）',
            'rules' => 'required_after_trim|min_length[1]|max_length[4]|valid_string[numeric]',
        ],
        'represent_telno_3'           => [
            'label' => '代表者電話番号（３）',
            'rules' => 'required_after_trim|min_length[3]|max_length[4]|valid_string[numeric]',
        ],
        'business_format'             => [
            'label' => '個人・法人区分',
            'rules' => 'required_after_trim|code[BusinessFormat]',
        ],
        'corporate_no'                => [
            'label' => '法人番号',
            'rules' => 'exact_length[13]|valid_string[numeric]',
        ],
        'staff_family_name'           => [
            'label' => '連絡先氏名（１）',
            'rules' => 'required_after_trim|max_length[40]|suitable_string',
        ],
        'staff_given_name'            => [
            'label' => '連絡先氏名（２）',
            'rules' => 'required_after_trim|max_length[40]|suitable_string',
        ],
        'staff_family_name_kana'      => [
            'label' => '連絡先氏名（カナ）（１）',
            'rules' => 'required_after_trim|max_length[40]',
        ],
        'staff_given_name_kana'       => [
            'label' => '連絡先氏名（カナ）（２）',
            'rules' => 'required_after_trim|max_length[40]',
        ],
        'staff_telno_1'               => [
            'label' => '連絡先電話番号（１）',
            'rules' => 'required_after_trim|min_length[2]|max_length[5]|valid_string[numeric]',
        ],
        'staff_telno_2'               => [
            'label' => '連絡先電話番号（２）',
            'rules' => 'required_after_trim|min_length[1]|max_length[4]|valid_string[numeric]',
        ],
        'staff_telno_3'               => [
            'label' => '連絡先電話番号（３）',
            'rules' => 'required_after_trim|min_length[3]|max_length[4]|valid_string[numeric]',
        ],
        'staff_mail_address'          => [
            'label' => '連絡先メールアドレス',
            'rules' => 'required_after_trim|max_length[128]|mail_address',
        ],
        'shop_name'                   => [
            'label' => '店舗名',
            'rules' => 'required_after_trim|max_length[64]|suitable_string',
        ],
        'shop_name_kana'              => [
            'label' => '店舗名（カナ）',
            'rules' => 'required_after_trim|max_length[100]',
        ],
        'shop_name_eng'               => [
            'label' => '店舗名（英字）',
            'rules' => 'required_after_trim|max_length[100]|alpha_num',
        ],
        'shop_zip_1'                  => [
            'label' => '店舗郵便番号（１）',
            'rules' => 'required_after_trim|min_length[3]|max_length[3]|valid_string[numeric]',
        ],
        'shop_zip_2'                  => [
            'label' => '店舗郵便番号（２）',
            'rules' => 'required_after_trim|min_length[4]|max_length[4]|valid_string[numeric]',
        ],
        'shop_address_pref'           => [
            'label' => '店舗住所（１）',
            'rules' => 'required_after_trim|max_length[30]|suitable_string',
        ],
        'shop_address_city'           => [
            'label' => '店舗住所（２）',
            'rules' => 'required_after_trim|max_length[256]|suitable_string',
        ],
        'shop_address_st'             => [
            'label' => '店舗住所（３）',
            'rules' => 'required_after_trim|max_length[256]|suitable_string',
        ],
        'shop_address_bldg'           => [
            'label' => '店舗住所（４）',
            'rules' => 'max_length[256]|suitable_string',
        ],
        'shop_address_pref_kana'      => [
            'label' => '店舗住所（カナ）（１）',
            'rules' => 'required_after_trim|max_length[30]',
        ],
        'shop_address_city_kana'      => [
            'label' => '店舗住所（カナ）（２）',
            'rules' => 'required_after_trim|max_length[256]',
        ],
        'shop_address_st_kana'        => [
            'label' => '店舗住所（カナ）（３）',
            'rules' => 'required_after_trim|max_length[256]',
        ],
        'shop_address_bldg_kana'      => [
            'label' => '店舗住所（カナ）（４）',
            'rules' => 'max_length[256]',
        ],
        'shop_telno_1'                => [
            'label' => '店舗電話番号（１）',
            'rules' => 'required_after_trim|min_length[2]|max_length[5]|valid_string[numeric]',
        ],
        'shop_telno_2'                => [
            'label' => '店舗電話番号（２）',
            'rules' => 'required_after_trim|min_length[1]|max_length[4]|valid_string[numeric]',
        ],
        'shop_telno_3'                => [
            'label' => '店舗電話番号（３）',
            'rules' => 'required_after_trim|min_length[3]|max_length[4]|valid_string[numeric]',
        ],
        'shop_official_site'          => [
            'label' => '店舗ホームページURL',
            'rules' => 'required_after_trim|max_length[128]|url',
        ],
        'business_license_no'         => [
            'label' => '営業許可証番号',
            'rules' => 'required_after_trim|max_length[256]|suitable_string',
        ],
        'delivery_sales_flg'          => [
            'label' => '取引・販売方法（１）',
            'rules' => 'required_after_trim|code[OnOff]',
        ],
        'telemarketing_flg'           => [
            'label' => '取引・販売方法（２）',
            'rules' => 'required_after_trim|code[OnOff]',
        ],
        'chain_sales_flg'             => [
            'label' => '取引・販売方法（３）',
            'rules' => 'required_after_trim|code[OnOff]',
        ],
        'job_invite_sales_flg'        => [
            'label' => '取引・販売方法（４）',
            'rules' => 'required_after_trim|code[OnOff]',
        ],
        'delivery_zip_1'              => [
            'label' => '配送先郵便番号（１）',
            'rules' => 'required_after_trim|min_length[3]|max_length[3]|valid_string[numeric]',
        ],
        'delivery_zip_2'              => [
            'label' => '配送先郵便番号（２）',
            'rules' => 'required_after_trim|min_length[4]|max_length[4]|valid_string[numeric]',
        ],
        'delivery_address_pref'       => [
            'label' => '配送先住所（１）',
            'rules' => 'required_after_trim|max_length[30]|suitable_string',
        ],
        'delivery_address_city'       => [
            'label' => '配送先住所（２）',
            'rules' => 'required_after_trim|max_length[256]|suitable_string',
        ],
        'delivery_address_st'         => [
            'label' => '配送先住所（３）',
            'rules' => 'required_after_trim|max_length[256]|suitable_string',
        ],
        'delivery_address_bldg'       => [
            'label' => '配送先住所（４）',
            'rules' => 'max_length[256]|suitable_string',
        ],
        'delivery_telno_1'            => [
            'label' => '配送先電話番号（１）',
            'rules' => 'required_after_trim|min_length[2]|max_length[5]|valid_string[numeric]',
        ],
        'delivery_telno_2'            => [
            'label' => '配送先電話番号（２）',
            'rules' => 'required_after_trim|min_length[1]|max_length[4]|valid_string[numeric]',
        ],
        'delivery_telno_3'            => [
            'label' => '配送先電話番号（３）',
            'rules' => 'required_after_trim|min_length[3]|max_length[4]|valid_string[numeric]',
        ],
        'delivery_family_name'        => [
            'label' => '受取人氏名（１）',
            'rules' => 'required_after_trim|max_length[40]|suitable_string',
        ],
        'delivery_given_name'         => [
            'label' => '受取人氏名（２）',
            'rules' => 'required_after_trim|max_length[40]|suitable_string',
        ],
        'delivery_time'               => [
            'label' => '配送希望時間',
            'rules' => 'required_after_trim|code[DeliveryTime]',
        ],
        'payment_device_flg'          => [
            'label' => '決済端末の購入',
            'rules' => 'required_after_trim|code[OnOff]',
        ],
        'printer_purchase_flg'        => [
            'label' => 'プリンターの購入',
            'rules' => 'required_after_trim|code[OnOff]',
        ],
        'admin_penalty_existence'     => [
            'label' => '直近5年間の特定商取引法による行政処分有無情報',
            'rules' => 'required_after_trim|code[TrnOnOff]',
        ],
        'losing_civil_suit_existence' => [
            'label' => '消費者契約法違反の行為を理由とした民事上の敗訴判決有無',
            'rules' => 'required_after_trim|code[TrnOnOff]',
        ],
    ],

    'paymatching' => [
        'search' => [
            'cond_from' => [
                'label' => '決済日（自）',
                'rules' => 'required_after_trim|valid_date[Y/m/d]',
            ],
            'cond_to'   => [
                'label' => '決済日（至）',
                'rules' => 'required_after_trim|valid_date[Y/m/d]',
            ],
        ],
        'edit'   => [
            'processed_flg' => [
                'label' => '処理区分',
                'rules' => 'required_after_trim|code[OnOff]',
            ],
            'note'          => [
                'label' => 'メモ',
                'rules' => 'max_length[255]|suitable_string',
            ],
        ],
    ],

    'bulkupdate' => [
        'g_id' => [
            'label' => '店舗番号',
            'rules' => 'required_after_trim|alpha_num|not_tmp_entry|not_regist|duplication',
        ],
    ],

    'info' => [
        'info_datetime' => [
            'label' => '掲出日時',
            'rules' => 'info_datetime',
        ],
        'info_txt'      => [
            'label' => 'タイトル',
            'rules' => 'required_after_trim|info_max_length[100]|suitable_string|control_code',
        ],
    ],

    'infofile' => [
        'info_file' => [
            'label' => 'お知らせPDFファイル',
            'rules' => 'info_file_required|info_file_sizeof|info_file_upload|info_file_format',
        ],
    ],

    'infourl' => [
        'info_url' => [
            'label' => 'リンク先URL',
            'rules' => 'required_after_trim|url',
        ],
    ],
];