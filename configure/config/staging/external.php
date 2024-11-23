<?php
return [
    // UCloudLink
    'ucloudlink' => [
        // Gimmit
        'stream_no_prefix' => 'HUMAN', // 任意の5桁
        'lang_type'        => 'en-US',
        'mvno_code'        => 'HumanWiFi',
        'partner_code'     => 'HumanWiFi',
        'client_id'        => '5dddddb01ffdba4acff6b3b0',
        'client_secret'    => '5dddddb01ffdba4acff6b3b1',
        'user_code'        => 'ZEUSWiFi',
        'password'         => 'ZEUSWi@Hnx32',
        'password_hash'    => '51e49acbf124f9ac962fa46d0241130b',
        // MAYA
        'maya_stream_no_prefix' => 'HUMAN', // 任意の5桁
        'maya_lang_type' => 'ja-JP',
        'maya_mvno_code' => 'FujiWifi',
        'maya_partner_code' => 'HUMANLIFE',
        'maya_client_id' => '5da13cb1b881f533e5684c00',
        'maya_client_secret' => '5da13cb1b881f533e5684c01',
        'maya_user_code' => 'HUMANLIFE',
        'maya_password' => 'dm@HD721',
        'maya_password_hash' => 'b9302b6dbb23f28d1e659e2a5a64fcba',

        // ログインユーザーID
        'login_cutomer_id' => '5e00256a6499674299764668',       // Gimmit
        'login_cutomer_id_maya' => '646d74ba2a6c347da7dcf008',  // MAYA

        // BatchCreateGroupChild（アカウント作成）のユーザーID
        'user_account_domain' => 'humaninvestment.jp',
        'user_account_prefix' => 'staging_',

//        'stream_no_prefix' => 'HUMAN', // 任意の5桁
//        'lang_type'        => 'en-US',
//        'mvno_code'        => 'HumanWiFi',
//        'partner_code'     => 'HumanWiFi',
//        'client_id'        => '5dddddb01ffdba4acff6b3b0',
//        'client_secret'    => '5dddddb01ffdba4acff6b3b1',
//        'user_code'        => 'ZEUSWiFi',
//        'password'         => 'ZEUSWi@Hnx32',
//        'password_hash'    => '51e49acbf124f9ac962fa46d0241130b',
//
//        // ログインユーザーID
//        'login_cutomer_id' => '5e00256a6499674299764668',
    ],

    // GMO
    'gmo'        => [
        'domain' => 'https://pt01.mul-pay.jp',
        'condo_domain' => 'https://m-api.stg.condo-pay.com',

        'uri' => [
            'SaveMember'              => 'payment/SaveMember.idPass',
            'UpdateMember'            => 'payment/UpdateMember.idPass',
            'DeleteMember'            => 'payment/DeleteMember.idPass',
            'SearchMember'            => 'payment/SearchMember.idPass',
            'SaveCard'                => 'payment/SaveCard.idPass',
            'SearchCard'              => 'payment/SearchCard.idPass',
            'DeleteCard'              => 'payment/DeleteCard.idPass',
            'EntryTran'               => 'payment/EntryTran.idPass',
            'ExecTran'                => 'payment/ExecTran.idPass',
            'AlterTran'               => 'payment/AlterTran.idPass',
            'ChangeTran'              => 'payment/ChangeTran.idPass',
            'SearchTrade'             => 'payment/SearchTrade.idPass',
            'BankAccountEntry'        => 'payment/BankAccountEntry.idPass',
            'BankAccountTranResult'   => 'payment/BankAccountTranResult.idPass',
            'SearchMemberBankAccount' => 'payment/SearchMemberBankAccount.idPass',
            'EntryTranBankaccount'    => 'payment/EntryTranBankaccount.idPass',
            'ExecTranBankaccount'     => 'payment/ExecTranBankaccount.idPass',
            'BankaccountCancel'       => 'payment/BankaccountCancel.idPass',
            'BankaccountChange'       => 'payment/BankaccountChange.idPass',
            'SearchTradeMulti'        => 'payment/SearchTradeMulti.idPass',
            'StartMerchantTransaction' => 'merchant/transaction',
            'GetMerchantTransaction'   => 'merchant/transaction',
            'ModifyMerchantTransaction'=> 'merchant/transaction',
        ],

        'site_id'   => 'tsite00036528',
        'site_pass' => 'evhwh12q',
        'shop_id'   => 'tshop00041419',
        'shop_pass' => '5vhbf62u',
        'condo_shop_id' => 'K9000001173',
        'condo_api_key' => 'K900000117332bca3b85b3c97bf3ac4e88d5cebc3b2197801d084bf3c25fe44b314ae6571cd',

        'encoding' => 'SJIS',

        'get_token_script' => 'https://stg.static.mul-pay.jp/ext/js/token.js',
    ],
    // FUJI/FONからの乗り換え
    'user'       => [
        'domain'    => 'https://stg-web.fuji-wifi.jp',
        'uri' => [
            'user_info' => 'api/v1/user/user_info',
            'login'  => 'api/v1/user/login',
            'user_info_via_basic' => 'api/v1/user/user_info_via_basic',
        ],
        'api_key' => 'QmW2Gru8XdMdJpwStgPu',
    ],

    // HRDS（保険オプションAPI）
    'hrds' => [
        'domain'  => 'https://stg.gl-oem.jp',  // APIのドメイン
        'uri'     => [
            'EntryInsurance' => 'api',
            'CancelInsurance' => 'api',
        ],
        'api_key' => 'GRATES0003',
        'oem_id' => [
            'entry' => 'ENTRY',
            'cancel' => 'CANCEL',
        ],
        'encoding' => 'UTF-8',
        'form_domain' => 'https://www.sakura-ins-form.jp',
        'form_url'    => 'form',
        'form_id' => [
                OPTION_ID_INSURANCE_5          => '6246a04fe4e52',
                OPTION_ID_INSURANCE_20         => '6346470e12823',
                OPTION_ID_PREPAID_INSURANCE_5  => '6246a04fe4e52',
                OPTION_ID_PREPAID_INSURANCE_20 => '6346470e12823',
        ]
    ],

    // NP
    'np'        => [
        'domain' => 'https://ctir.np-payment-gateway.com/v1',

        'uri' => [
            'transactions'                  => 'transactions',               // 取引登録・更新
            'transactionsSettle'            => 'transactions/settle',        // 売上確定(現状未使用)
            'transactionsFind'              => 'transactions/find',          // 取引参照(現状未使用)
            'transactionCancellationRefund' => 'transactions/cancel-refund', // 取引キャンセル
            'healthcheck'                   => 'healthcheck'                 // 疎通チェック用
        ],

        'pub_key'   => 'FX8zQM9-7Y2CQWFJvQMslg',
        'secret_key' => 'SAvUZX5T9lgq3Cyv6MzzJQ',
        'pub_key_charge'   => '5GtxdJT_vApBdn0wxAyQeg',
        'secret_key_charge' => 'jS4uEVmVOSSIvdeUT41H0w',
        'atone_script_pass' => 'https://ctim.np-payment-gateway.com/module/np.js',
        'atone_regist_script_pass' => 'https://ct-auth.a-to-ne.jp/v1/register.js',
        'atone_order_id_prefix' => ATONE_ORDER_PREFIX_STAGING, // atone側で重複したときは定数の値を変えてください(int)
        'service_type' => '01',
    ],

    // Google
    'google'        => [
        'oauth_domain' => 'https://oauth2.googleapis.com', // oauth api ホスト
        'ads_domain' => 'https://googleads.googleapis.com',// ads api ホスト

        'uri' => [
            'oauth_token'                  => 'token',               // アクセストークン更新
            'upload_click_conversions'     => 'v17/customers/8419009945:uploadClickConversions', // クリックコンバージョンをアップロード
            'upload_conversion_adjustments'=> 'v17/customers/8419009945:uploadConversionAdjustments', // クリックコンバージョンの調整をアップロード
        ],

        'developer_token' => 'Djm1oojM4A4cV1MFRQMcvA',
        'login_customer_id' => '8419009945',
    ],

    // Paidy
    'paidy' => [
        'domain' => 'https://api.paidy.com',

        'uri' => [
            'payment_create'    => 'payments', // 定期購入
            'payment_captures'  => 'payments/:payment_id/captures', // 決済のCapture
            'payment_refunds'   => 'payments/:payment_id/refunds', // 決済のRefund
            'payment_retrieve'  => 'payments/:payment_id', // 決済データの取得
            'payment_update'    => 'payments/:payment_id', // 決済のUpdate
            'payment_close'     => 'payments/:payment_id/close', // 決済のClose
            'token_suspend'     => 'tokens/:token_id/suspend', // トークンの一時的な無効化
            'token_resume'      => 'tokens/:token_id/resume', // トークンの回復
            'token_delete'      => 'tokens/:token_id/delete', // トークンの削除
            'token_get'         => 'tokens/:token_id', // 特定のtokenオブジェクトを取得
            'token_get_all'     => 'tokens', // すべてのトークンを取得
        ],

        'paidy_version' => '2018-04-10',

        'zeus' => [
            // サブスク用（分割は3回あと払いのみ）
            // 'public_key' => 'pk_test_4ag2v9m8kej4tr65iaepj6n5ns', // テスト用公開鍵
            // 'secret_key' => 'sk_test_e7dd1ubl4bb3ksqsum1tnmm71g', // テスト用秘密鍵
            // 'token' => [
            //     'wallet_id' => 'ZEUS WiFi',
            //     'token_type' => 'recurring',    // 定期購入
            // ],
        ],

        'global' => [
            // 海外用（分割は3回あと払いのみ）
            // 'public_key' => 'pk_test_4ag2v9m8kej4tr65iaepj6n5ns', // テスト用公開鍵
            // 'secret_key' => 'sk_test_e7dd1ubl4bb3ksqsum1tnmm71g', // テスト用秘密鍵
            // 'token' => [
            //     'wallet_id' => 'ZEUS WiFi for GLOBAL',
            //     'token_type' => 'recurring',    // 定期購入
            // ],
        ],

        'charge' => [
            // チャージ・オートチャージ用（分割は3回あと払いのほか、6回あと払い、12回あと払い対応）
            'public_key' => 'pk_test_c4fsuo82mj1ahp8vac89m8mj19', // テスト用公開鍵
            'secret_key' => 'sk_test_4hhidl7c761p7dvp9iidrpu0ua', // テスト用秘密鍵
            'token' => [
                'wallet_id' => 'ZEUS WiFi CHARGE',
                'token_type' => 'recurring',    // 定期購入
            ],
        ],

        'payment_test' => [
            'email' => 'successful.payment@paidy.com',  // トークン作成および決済テスト用
            'phone' => '08000000001',
        ],

        'paidy_order_ref_prefix' => 'stg', // 決済のAPIへのリクエスト、Paidy管理画面、決済履歴テーブルに使用する
    ],
];
