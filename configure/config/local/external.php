<?php
return [

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
        'atone_order_id_prefix' => ATONE_ORDER_PREFIX_LOCAL, // atone側で重複したときは定数の値を変えてください(int)
        'service_type' => '01',
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
            'email' => 'successful.payment@paidy.com',  // トークン作成および決済テスト用（本人確認済み・通常はこれを使う）
            'phone' => '08000000001',
        ],

        'paidy_order_ref_prefix' => 'local', // 決済のAPIへのリクエスト、Paidy管理画面、決済履歴テーブルに使用する
    ],
];
