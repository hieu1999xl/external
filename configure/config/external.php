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
        'user_code'        => 'HumanWiFi_TEST',
        'password'         => 'Human@0711',
        'password_hash'    => '41cbf75d4f8ed8b114b5066dc60ae696',
        // MAYA
        'maya_stream_no_prefix' => 'HUMAN', // 任意の5桁
        'maya_lang_type' => 'ja-JP',
        'maya_mvno_code' => 'HumanWiFi',
        'maya_partner_code' => 'HumanWiFi',
        'maya_client_id' => '5dddddb01ffdba4acff6b3b0',
        'maya_client_secret' => '5dddddb01ffdba4acff6b3b1',
        'maya_user_code' => 'HumanWiFi_TEST',
        'maya_password' => 'Human@tw2nx',
        'maya_password_hash' => '41cbf75d4f8ed8b114b5066dc60ae696',

        // ログインユーザーID
        'login_cutomer_id' => '586e0a901ffdba19dd02xxxx',       // Gimmit
        'login_cutomer_id_maya' => '586e0a901ffdba19dd02maya',  // MAYA

        // BatchCreateGroupChild（アカウント作成）のユーザーID
        'user_account_domain' => 'humaninvestment.jp',
        'user_account_prefix' => 'test_',
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
            'RegistMerchantRecurring'  => 'merchant/recurring',
        ],

        'site_id'   => 'tsite00036528',
        'site_pass' => 'evhwh12q',
        'shop_id'   => 'tshop00041419',
        'shop_pass' => '5vhbf62u',
        'condo_shop_id' => 'K9000001173',
        'condo_api_key' => 'K900000117332bca3b85b3c97bf3ac4e88d5cebc3b2197801d084bf3c25fe44b314ae6571cd',

        'new_site_id'   => 'tsite00051873',
        'new_site_pass' => 'avwg186s',
        'new_shop_id'   => 'tshop00062729',
        'new_shop_pass' => 'pa6hhwz6',

        'encoding' => 'SJIS',

        'get_token_script' => 'https://stg.static.mul-pay.jp/ext/js/token.js',
    ],

    // kintone
    'kintone'        => [
        'domain' => 'cybozu.com',
        'sub_domain' => 'zeus',
        'company_api_token' => 'JPg7v8tDcAimwUzyFL6txnVdmgXJqtvv2mZgFWib',
        'company_app_id'   => 25,
        'stg_company_api_token' => '70qxGu1s0SQeW1ZRe8QW97Tc3V8GCoq8CA9y0vO8',
        'stg_company_app_id'   => 70,
        'sbhikari_api_token' => 'IBWg6fINMuBLdVmfiaoBRYecyL86va1XaR5Av0d6',
        'sbhikari_app_id'   => 27,
        'stg_sbhikari_api_token' => 'hDrR97o1CXi00EDyZglEnbcbMIildlAQTaVV1g1b',
        'stg_sbhikari_app_id'   => 28,
        'estimate_api_token' => 'JPg7v8tDcAimwUzyFL6txnVdmgXJqtvv2mZgFWib',
        'estimate_app_id'   => 25,
        'stg_estimate_api_token' => '70qxGu1s0SQeW1ZRe8QW97Tc3V8GCoq8CA9y0vO8',
        'stg_estimate_app_id'   => 70,
    ],

    // FUJI/FONからの乗り換え
    'user'      => [
        'domain'    => 'http://192.168.33.112:8080',
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

    'google' => [
        'ads_user_account' => 'chan.chipong.human@gmail.com',
    ],
];
