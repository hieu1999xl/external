<?php
return [
    // UCloudLink
    'ucloudlink' => [
        'domain' => 'https://saas.ucloudlink.com',

        'uri' => [
            'GrpUserLogin'                => 'bss/grp/noauth/GrpUserLogin',
            'GrpUserLogout'               => 'bss/grp/user/GrpUserLogout',
            'BatchCreateGroupChild'       => 'bss/grp/user/BatchCreateGroupChild',
            'QuerySubUserListInfo'        => 'bss/grp/user/QuerySubUserListInfo',
            'QueryGrpOfferList'           => 'bss/grp/goods/QueryGrpOfferList',
            'GrpCreateOrder'              => 'bss/grp/order/GrpCreateOrder',
            'QueryUserOfferList'          => 'bss/grp/goods/QueryUserOfferList',
            'StopSubUser'                 => 'bss/grp/user/StopSubUser',
            'DeleteSubUser'               => 'bss/grp/user/DeleteSubUser',
            'BindDevice'                  => 'bss/grp/tml/BindDevice',
            'BatchUnBindDevice'           => 'bss/grp/tml/BatchUnBindDevice',
            'QueryBindingRelationInfo'    => 'bss/grp/tml/QueryBindingRelationInfo',
            'LockDevice'                  => 'bss/grp/tml/LockDevice',
            'TopUpForSubUser'             => 'bss/grp/topup/TopUpForSubUser',
            'QueryTopUpListInfo'          => 'bss/grp/topup/QueryTopUpListInfo',
            'QueryAccountDetailListInfo'  => 'bss/grp/user/QueryAccountDetailListInfo',
            'QuerySubUserListByBatch'     => 'bss/grp/user/QuerySubUserListByBatch',
            'QueryOrderRelationByOrderId' => 'bss/grp/order/QueryOrderRelationByOrderId',
            'CancelOrder'                 => 'bss/grp/order/CancelOrder',
            'DisableOrderRelation'        => 'bss/grp/goods/DisableOrderRelation',
        ],

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
        'user_account_prefix' => '',

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
        'domain' => 'https://p01.mul-pay.jp',
        'condo_domain' => 'https://m-api.condo-pay.com',

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

        'site_id'   => 'mst2000021328',
        'site_pass' => 'fa6heeb9',
        'shop_id'   => '9200001862817',
        'shop_pass' => '9xt8tzm5',
        'condo_shop_id' => 'K2000000535',
        'condo_api_key' => 'K200000053597a54e24f8b340418944222617fd93c0e0f087ae0143b526490773f9877f54e4',

        'new_site_id'   => 'mst2000034141',
        'new_site_pass' => 'babs99c6',
        'new_shop_id'   => '9200005909037',
        'new_shop_pass' => 'td3kxa3a',

        'encoding' => 'SJIS',

        'get_token_script' => 'https://static.mul-pay.jp/ext/js/token.js',
    ],
    // FUJI/FONからの乗り換え
    'user'       => [
        'domain'    => 'https://web.fuji-wifi.jp',
        'uri' => [
            'user_info' => 'api/v1/user/user_info',
            'login'  => 'api/v1/user/login',
            'user_info_via_basic' => 'api/v1/user/user_info_via_basic',
        ],
        'api_key' => 'KDcq8QmeRTqV486F6Xu',
    ],

    // HRDS（保険オプションAPI）
    'hrds' => [
        'domain'  => 'https://gl-oem.jp',  // APIのドメイン
        'uri'     => [
            'EntryInsurance' => 'api',
            'CancelInsurance' => 'api',
        ],
        'api_key' => 'GRAAPI0003',
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
        'domain' => 'https://ir.np-payment-gateway.com/v1/',

        'uri' => [
            'transactions'                  => 'transactions',               // 取引登録・更新
            'transactionsSettle'            => 'transactions/settle',        // 売上確定(現状未使用)
            'transactionsFind'              => 'transactions/find',          // 取引参照(現状未使用)
            'transactionCancellationRefund' => 'transactions/cancel-refund', // 取引キャンセル
            'healthcheck'                   => 'healthcheck'                 // 疎通チェック用
        ],

        'pub_key'   => 'dTbMXD7IhGVV_38r5-xv_Q',
        'secret_key' => 'd_yUfnFBl4jMMQrpk8HwnA',
        'pub_key_charge'   => 'fHNpsg25ITRAZPOxeOq6VA',
        'secret_key_charge' => 'MIUP7uYjVllc0epFjY6AEA',
        'atone_script_pass' => 'https://im.np-payment-gateway.com/module/np.js',
        'atone_regist_script_pass' => 'https://auth.atone.be/v1/register.js',
        'atone_order_id_prefix' => '', // atone側で重複したときは定数の値を変えてください(int)
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
            // 'public_key' => 'pk_live_3jk74q22aouoinpc8i9so8bqja', // テスト用公開鍵
            // 'secret_key' => 'sk_live_jqndcfq0b6ot0oftlcge203nhg', // テスト用秘密鍵
            // 'token' => [
            //     'wallet_id' => 'ZEUS WiFi',
            //     'token_type' => 'recurring',    // 定期購入
            // ],
        ],

        'global' => [
            // 海外用（分割は3回あと払いのみ）
            // 'public_key' => 'pk_live_3jk74q22aouoinpc8i9so8bqja', // テスト用公開鍵
            // 'secret_key' => 'sk_live_jqndcfq0b6ot0oftlcge203nhg', // テスト用秘密鍵
            // 'token' => [
            //     'wallet_id' => 'ZEUS WiFi for GLOBAL',
            //     'token_type' => 'recurring',    // 定期購入
            // ],
        ],

        'charge' => [
            // チャージ・オートチャージ用（分割は3回あと払いのほか、6回あと払い、12回あと払い対応）
            'public_key' => 'pk_live_eh08r55pds4rofb475iqsjr82l', // 本番用公開鍵
            'secret_key' => 'sk_live_isicilg1cjajhv1nph14tk1ltj', // 本番用秘密鍵
            'token' => [
                'wallet_id' => 'ZEUS WiFi CHARGE',
                'token_type' => 'recurring',    // 定期購入
            ],
        ],

        'payment_test' => [],

        'paidy_order_ref_prefix' => '', // 決済のAPIへのリクエスト、Paidy管理画面、決済履歴テーブルに使用する
    ],
];
