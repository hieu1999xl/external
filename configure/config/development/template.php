<?php
/**
 * テンプレート関連の定義ファイル
 * 例：メールの設定など
 */
return [

    /**
     * エラーメール設定
     */
    'error_mail'             => [
        'from'    => 'noreply@zeus-wifi.jp',
        'to'      => '',
        'subject' => '【開発】【ZEUS】【WEB】システムエラー検知',
    ],

    /**
     * 本人確認メール設定
     */
    'password_reminder_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'fromName' => 'HUMANLIFE',
        'subject'  => '[開発]【HUMANLIFE】本人確認のお願い',
    ],
];
