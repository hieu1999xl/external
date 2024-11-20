<?php
/**
 * テンプレート関連の定義ファイル
 * 例：メールの設定など
 */
return [

    /**
     * エラーメール設定
     */
    'error_mail'               => [
        'from'    => 'system-alart@zeus-wifi.jp',
        'to'      => [
            'wifi-engineer@humanlife.co.jp',
        ],
        'subject' => '【本番】【ZEUS】【WEB】システムエラー検知',
    ],

    /**
     * 申し込み完了メール
     */
    'entry_mail'               => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉お申し込みありがとうございます',
        'template' => 'mail/entry',
    ],

    /**
     * 仮申込メール
     */
    'send_draft_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉お支払い登録のお願い',
        'template' => 'mail/entry_telephone_draft'
    ],

    /**
     * (キャスティングロード経由)申し込み完了メール
     */
    'entry_mail_salespartner' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉お申し込みありがとうございます',
        'template' => 'mail/entry_salespartner',
    ],

    /**
     * (WiMAX経由)申し込み完了メール
     */
    'entry_mail_wimax' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiMAX〉お申し込みありがとうございます',
        'template' => 'mail/entry_wimax',
    ],
    /**
     * (オープンハウス経由)申し込み完了メール
     */
    'entry_mail_openhouse' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉お申し込みありがとうございます',
        'template' => 'mail/entry_openhouse',
    ],


    /**
     * (セット販売)申し込み完了メール
     */
    'entry_mail_external_service_set' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉お申し込みありがとうございます',
        'template' => 'mail/externalserviceset/',
    ],

    /**
     * 法人申し込み完了メール
    */
    'entry_corp_mail'               => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉お申し込みありがとうございます',
        'template' => 'mail/entry_corp',
    ],

    /**
     * 申し込み完了メール(一括銀行振り込みプラン)
     */
    'entry_special_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉お申し込みありがとうございます',
        'template' => 'mail/entry_special',
    ],

    /**
     * 申し込み完了メール(プリペイドプラン/買い切りプラン)
     */
    'entry_mail_prepaid' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi CHARGE〉お申し込みありがとうございます',
        'template' => 'mail/entry_prepaid',
    ],

    /**
     * 申し込み完了メール(プリペイドプラン/サブスクプラン)
     */
    'entry_mail_prepaid_subscription' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi CHARGE〉お申し込みありがとうございます',
        'template' => 'mail/entry_prepaid_subscription',
    ],

    /**
     * 海外レンタル申し込み完了メール
     */
    'entry_overseas_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'support@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi for GLOBAL〉お申し込みありがとうございます',
        'template' => 'mail/entry_overseas',
    ],

    //法人請求書メール
    'entry_mail_corp_contact'         => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉仮登録完了メール',
        'template' => 'mail/entry_mail_corp_contact',
    ],

    /**
     * 申し込みエラーメール
     */
    'entry_settlement_error_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉決済処理に失敗しました',
        'template' => 'mail/entry_settlement_error',
    ],

    /**
     * こんど払い与信NGメール
     */
    'entry_condo_callback_error_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [],
        'subject'  => '<ZEUS WiFi>お申し込み審査結果のご連絡',
        'template' => 'mail/entry_condo_callback_error',
    ],

    /**
     * こんど払い与信NGメール(登録情報の変更)
     */
    'change_condo_callback_error_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '<ZEUS WiFi>「コンビニ後払い」登録情報の変更ができませんでした',
        'template' => 'mail/change_condo_callback_error',
    ],

    /**
     * お客様情報変更メール
     */
    'user_edit_mail'           => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉お客様情報変更のお知らせ',
        'template' => 'mail/user_edit',
    ],

    /**
     * お客様情報変更メール（法人）
     */
    'user_edit_corp_mail'           => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉お客様情報変更のお知らせ',
        'template' => 'mail/user_edit_corp',
    ],

    /**
     * お支払い方法変更メール
     */
    'user_payment_edit_mail'   => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉お支払い情報変更のお知らせ',
        'template' => 'mail/user_payment_edit',
    ],

    /**
     * こんど払い byGMOのご登録情報変更メール
     */
    'user_payment_condopay_data_edit_mail'   => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉「コンビニ後払い」登録情報を変更しました',
        'template' => 'mail/user_payment_condopay_data_edit',
    ],


    /**
     * お支払いsettlement_notificationメール
     */
    'user_updated_settlement_notification_mail'   => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => 'wifi-corp@humanlife.co.jp',
        'subject'  => '〈〈確認〉〉支払い方法が変更されました',
        'template' => 'mail/user_updated_settlement_notification_mail',
    ],


    /**
     * データチャージプラン購入メール
     */
    'data_charge_edit_mail'       => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉データチャージ完了のお知らせ',
        'template' => 'mail/data_charge_edit',
    ],

    /**
     * データチャージ購入メール(CHARGEプラン)
     */
    'data_charge_edit_mail_prepaid'       => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi CHARGE〉データチャージ完了のお知らせ',
        'template' => 'mail/data_charge_edit_prepaid',
    ],

    /**
     * オプション購入メール
     */
    'prepaid_option_edit_mail'       => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉オプションの購入完了のお知らせ',
        'template' => 'mail/prepaid_option_edit',
    ],

    /**
     * 契約情報変更メール
     */
    'contract_edit_mail'       => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉ご契約内容変更のお知らせ',
        'template' => 'mail/contract_edit',
    ],

    /**
     * オプション解約受付メール
     */
    'contract_option_cancel_mail'       => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉オプションの解約を受け付けました',
        'template' => 'mail/contract_option_cancel',
    ],

    /**
     * オプション解約受付メール(CHARGE)
     */
    'contract_option_cancel_mail_prepaid'       => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi CHARGE〉オプションの解約を受け付けました',
        'template' => 'mail/contract_option_cancel_prepaid',
    ],

    /**
     * 契約情報解約メール
     */
    'contract_cancel_mail'     => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉解約受付完了のお知らせ',
        'template' => 'mail/contract_cancel',
    ],

    /**
     * 契約情報解約メール
     */
    'new_contract_cancel_mail'     => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉解約受付完了・端末返却についてのご案内',
        'template' => 'mail/new_contract_cancel',
    ],

    /**
     * 法人契約情報解約メール
     */
    'corp_contract_cancel_mail'     => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉解約受付完了・端末返却についてのご案内',
        'template' => 'mail/corp_contract_cancel',
    ],

    /**
     * 契約情報解約メール(WiMAX用)
     */
    'contract_cancel_mail_by_wimax'     => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiMAX〉解約受付完了のお知らせ',
        'template' => 'mail/contract_cancel_by_wimax',
    ],

    /**
     * 契約情報解約メール(CHARGE用)
     */
    'contract_cancel_mail_by_prepaid'     => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi CHARGE〉解約受付完了のお知らせ',
        'template' => 'mail/contract_cancel_by_prepaid',
    ],

    /**
     * 初期契約解除の申請メール
     */
    'initial_contract_cancel_mail'     => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            '',
        ],
        'subject'  => '＜ZEUS WiFi＞申請を受け付けました。',
        'template' => 'mail/initial_contract_cancel',
    ],

    /**
     * 初期契約解除の申請メール
     */
    'new_initial_contract_cancel_mail'     => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            '',
        ],
        'subject'  => '＜ZEUS WiFi＞初期契約解除の申請受付完了・端末返却についてのご案内',
        'template' => 'mail/new_initial_contract_cancel',
    ],

    /**
     * 初期契約解除の申請メール(WiMAX用)
     */
    'initial_contract_cancel_mail_by_wimax'     => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            '',
        ],
        'subject'  => '＜ZEUS WiMAX＞申請を受け付けました。',
        'template' => 'mail/initial_contract_cancel_by_wimax',
    ],

    /**
     * パスワード再設定メール
     */
    'password_reminder_mail'   => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉パスワード再設定のお知らせ',
        'template' => 'mail/password_reminder',
    ],

    /**
     * 会員ID忘れたメール
     */
    'loginid_reminder_mail'   => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉会員IDのお知らせ',
        'template' => 'mail/loginid_reminder',
    ],

    /**
     * パスワード変更完了メール
     */
    'password_edit_mail'       => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉パスワード変更のお知らせ',
        'template' => 'mail/password_edit',
    ],

    /**
     * 法人申し込みA完了メール
     */
    'entry_mail_corpa'         => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'wifi-corp@humanlife.co.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉お問い合わせありがとうございます',
        'template' => 'mail/entry_corpa',
    ],

    /**
     * 法人申し込みA完了メール・ふるさと納税特別プラン（差し替え用、先にentry_mail_corpaを読み込んでいる前提）
     */
    'entry_mail_corpa_hometown_tax' => [
        'bcc'      => [
            'wifi-furusato@humanlife.co.jp' // ふるさと納税特別プランの対応メンバーのメーリングリスト
        ],
    ],

    /**
     * 法人申し込みB完了メール
     */
    'entry_mail_corpb'         => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'wifi-corp@humanlife.co.jp'
        ],
        'subject'  => '〈ZEUS WiFi〉お問い合わせありがとうございます',
        'template' => 'mail/entry_corpb',
    ],

    'entry_contact_mail_corpb'         => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉仮登録完了メール',
        'template' => 'mail/entry_contact_corpb',
    ],

    /**
     * 法人申し込みB完了メール
     */
    'entry_corpb_support_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'wifi-corp@humanlife.co.jp',
        ],
        'subject'  => '〈ZEUS WiFi〉支払い方法が登録されました',
        'template' => 'mail/entry_corpb_support',
    ],

    /**
     * 問い合わせ送信メール
     */
    'contact_to_support_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => 'support@zeus-wifi.jp',
        'subject'  => '〈ZEUS WiFi〉問い合わせのお知らせ',
        'template' => 'mail/contact_to_support',
    ],

    /**
     * 問い合わせ法人送信メール
     */
    'contact_to_business_support_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => 'wifi-corp@humanlife.co.jp',
        'subject'  => '〈ZEUS WiFi〉問い合わせのお知らせ',
        'template' => 'mail/contact_to_support',

    ],

    /**
     * 問い合わせ送信メール
     */
    'contact_to_customer_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉お問い合わせを受け付けました',
        'template' => 'mail/contact_to_customer',
    ],
    /**
     * 問い合わせ送信メール
     */
    'sbhikari_to_support_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => 'human-cs＠humanlife.co.jp',
        'subject'  => '〈ZEUS WiFi〉光回線セットの問い合わせのお知らせ',
        'template' => 'mail/sbhikari_to_support',
    ],

    /**
     * 問い合わせ送信メール
     */
    'sbhikari_to_customer_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉光回線セットの問い合わせのお知らせ',
        'template' => 'mail/sbhikari_to_customer',
    ],
    /**
     * Twitter特別キャンペーン申し込み完了メール（管理者向け）
     */
    'twitter_to_support_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => 'wifi-mgr@humanlife.co.jp',
        'subject'  => '〈ZEUS WiFi〉Twitter特別キャンペーン申し込みのお知らせ',
        'template' => 'mail/campaign/twittercontract/to_support',
    ],

    /**
     * Twitter特別キャンペーン・既存ユーザー申し込み完了メール（顧客向け）
     */
    'twitter_to_customer_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉お申し込みありがとうございます',
        'template' => 'mail/campaign/twittercontract/to_customer',
    ],

    /**
     * Twitter特別キャンペーン・新規ユーザー申し込み完了メール（顧客向け）
     */
    'twitter_to_entry_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉お申し込みありがとうございます',
        'template' => 'mail/campaign/twittercontract/entry',
    ],

    /**
     * WiMAX問い合わせ送信メール
     */
    'contact_to_support_by_wimax_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => 'support@zeus-wifi.jp',
        'subject'  => '＜ZEUS WiMAX＞問い合わせのお知らせ',
        'template' => 'mail/contact_to_support_by_wimax',
    ],

    /**
     * WiMAX問い合わせ法人送信メール
     */
    'contact_to_business_support_by_wimax_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => 'wifi-corp@humanlife.co.jp',
        'subject'  => '＜ZEUS WiMAX＞問い合わせのお知らせ',
        'template' => 'mail/contact_to_support_by_wimax',
    ],

    /**
     * WiMAX問い合わせ送信メール
     */
    'contact_to_customer_by_wimax_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '＜ZEUS WiMAX＞お問い合わせを受け付けました',
        'template' => 'mail/contact_to_customer_by_wimax',
    ],

    /**
     * 海外レンタル問い合わせ送信メール
     */
    'contact_to_support_by_global_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => 'support@zeus-wifi.jp',
        'subject'  => '＜ZEUS WiFi for GLOBAL＞問い合わせのお知らせ',
        'template' => 'mail/contact_to_support_by_global',
    ],

    /**
     * 海外レンタル問い合わせ法人送信メール
     */
    'contact_to_business_support_by_global_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => 'wifi-corp@humanlife.co.jp',
        'subject'  => '＜ZEUS WiFi for GLOBAL＞問い合わせのお知らせ',
        'template' => 'mail/contact_to_support_by_global',
    ],

    /**
     * 海外レンタル問い合わせ送信メール
     */
    'contact_to_customer_by_global_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '＜ZEUS WiFi for GLOBAL＞お問い合わせを受け付けました',
        'template' => 'mail/contact_to_customer_by_global',
    ],

    /**
     * プリペイド問い合わせ送信メール
     */
    'contact_to_support_by_prepaid_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => 'support@zeus-wifi.jp',
        'subject'  => '〈ZEUS WiFi CHARGE〉問い合わせのお知らせ',
        'template' => 'mail/contact_to_support_by_prepaid',
    ],
    /**
     * プリペイド問い合わせ法人送信メール
     */
    'contact_to_business_support_by_prepaid_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => 'wifi-corp@humanlife.co.jp',
        'subject'  => '〈ZEUS WiFi CHARGE〉問い合わせのお知らせ',
        'template' => 'mail/contact_to_support_by_prepaid',
    ],

    /**
     * プリペイド問い合わせ送信メール
     */
    'contact_to_customer_by_prepaid_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi CHARGE〉お問い合わせを受け付けました',
        'template' => 'mail/contact_to_customer_by_prepaid',
    ],

    /**
     * プラン変更キャンセルメール
     */
    'plan_change_cancel_mail'     => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉プラン変更キャンセル手続き完了のお知らせ',
        'template' => 'mail/plan_change_cancel',
    ],

    /**
     * プラン変更申込メール
     */
    'plan_change_entry_mail'     => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉プラン変更お申込み手続き完了のお知らせ',
        'template' => 'mail/plan_change_entry',
    ],

    /**
     * atone決済キャンセル発生通知メール
     */
    'atone_cancel_refund_mail'     => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'      => [
            'wifi-engineer@humanlife.co.jp',
            'billing@humanlife.co.jp',
        ],
        'subject'  => '〈ZEUS WiFi〉atone決済キャンセル発生のお知らせ',
        'template' => 'mail/atone_cancel_refund_mail',
    ],

    /**
     * Paysys入金通知更新失敗発生通知メール
     */
    'paysys_webhook_error_mail' => [
        'from' => 'noreply@zeus-wifi.jp',
        'to'   => [
            'wifi-engineer@humanlife.co.jp',
            'billing@humanlife.co.jp',
        ],
        'subject' => '<ZEUS WiFi>Paysys入金通知失敗のお知らせ',
    ],

    /**
     * Paysys入金通知再開メール
     */
    'paysys_webhook_resume_mail'     => [
        'from' => 'noreply@zeus-wifi.jp',
        'to'   => [
            'wifi-engineer@humanlife.co.jp',
            'billing@humanlife.co.jp',
        ],
        'subject'  => '<ZEUS WiFi>Paysys入金通知によるユーザーステータス再開のお知らせ',
    ],

    /**
     * 保険オプション・顧客ID通知メール
     */
    'entry_insurance' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'subject'  => '〈ZEUS WiFi〉お申込みのデジタルライフサポートについて',
        'template' => 'mail/entry_insurance.twig'
    ],

    /**
     * 請求書メール(銀行振込/プラン)
     */
    'send_bill_mail_datacharge' => [
        'cc'       => [],
        'from'     => 'support@zeus-wifi.jp',
        'subject'  => '【重要】〈ZEUS WiFi〉プランご購入のご利用料金お支払いのお願い',
        'template' => 'mail/send_bill_mail_datacharge.twig'
    ],

    /**
     * 請求書メール(銀行振込/オプション)
     */
    'send_bill_mail_option' => [
        'cc'       => [],
        'from'     => 'support@zeus-wifi.jp',
        'subject'  => '【重要】〈ZEUS WiFi〉オプションご購入のご利用料金お支払いのお願い',
        'template' => 'mail/send_bill_mail_option.twig'
    ],

    /**
     * 端末交換申請メール(サポート宛)送信メール
     */
    'exchange_request_to_support_mail'  => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => 'support@zeus-wifi.jp',
        'subject'  => '〈ZEUS WiFi〉端末交換申請のお知らせ',
        'template' => 'mail/exchange_request_to_support',
    ],

    /**
     * 端末交換申請メール(ユーザー控え)送信メール
     */
    'exchange_request_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'subject'  => '〈ZEUS WiFi〉端末交換申請を受け付けました',
        'template' => 'mail/exchange_request',
    ],

    /**
     * 海外レンタル申込キャンセルメール
     */
    'entry_cancel_mail_by_international_rental' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'support@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi for GLOBAL〉キャンセル手続き完了のお知らせ',
        'template' => 'mail/entry_cancel_mail_by_international_rental',
    ],

    /**
     * 海外レンタルプラン変更メール
     */
    'plan_change_mail_by_international_rental' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'support@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi for GLOBAL〉プラン変更完了のご案内',
        'template' => 'mail/plan_change_mail_by_international_rental',
    ],

    /**
     * 海外レンタル利用期間延長メール
     */
    'plan_extension_mail_by_international_rental' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'support@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi for GLOBAL〉利用期間延長を受付けました',
        'template' => 'mail/plan_extension_mail_by_international_rental',
    ],

    /**
     * 海外レンタル利用国追加メール
     */
    'plan_add_mail_by_international_rental' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'support@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi for GLOBAL〉利用国の追加を受付けました',
        'template' => 'mail/plan_add_mail_by_international_rental',
    ],

    /**
     * GMOクレジットカード決済キャンセル発生通知メール
     */
    'gmo_credit_settlement_cancel_failed'     => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'      => [
            'wifi-engineer@humanlife.co.jp',
            'billing@humanlife.co.jp',
        ],
        'subject'  => '〈ZEUS WiFi for GLOBAL〉申込キャンセル時にGMOクレジットカード決済キャンセル発生のお知らせ',
        'template' => 'mail/gmo_credit_settlement_cancel_failed',
    ],

    /**
     * CHARGEプラン(プリペイド)変更メール
     */
    'plan_change_mail_by_international_prepaid' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi CHARGE〉プラン変更完了のご案内',
        'template' => 'mail/plan_change_mail_by_international_prepaid',
    ],

    /**
     * 海外プリペイド利用期間延長メール
     */
    'plan_extension_mail_by_international_prepaid' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi CHARGE〉利用期間延長を受付けました',
        'template' => 'mail/plan_extension_mail_by_international_prepaid',
    ],

    /**
     * 海外プリペイド利用国追加メール
     */
    'plan_add_mail_by_international_prepaid' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi CHARGE〉利用国の追加を受付けました',
        'template' => 'mail/plan_add_mail_by_international_prepaid',
    ],

    /**
     * ギガチャージ(国内)購入メール
     */
    'giga_charge_edit_mail' => [
        'from'     => 'noreply@zeus-wifi.jp',
        'to'       => '',
        'bcc'      => [
            'consumer-info@zeus-wifi.jp',
            'maildealer-26@mdkapok.maildealer.jp'
        ],
        'subject'  => '〈ZEUS WiFi CHARGE〉ギガチャージを受付けました',
        'template' => 'mail/giga_charge_edit',
    ],

    /**
     * プリペイドプラン無効化失敗メール
     */
    'failure_disable_prepaid_plan_mail' => [
        'from'     => 'system-alart@zeus-wifi.jp',
        'to'       => [
            'error_info@googlegroups.com',
            'billing@humanlife.co.jp',
            'yta.hasebe@humanlife.co.jp',
            'kit.matsumoto@humanlife.co.jp',
        ],
        'subject'  => '【重要】〈ZEUS WiFi CHARGE〉プラン変更時に旧プランの無効化に失敗しました。',
        'template' => 'mail/failure_disable_prepaid_plan',
    ],

    /**
     * 海外レンタルプラン無効化失敗メール
     */
    'failure_disable_rental_plan_mail' => [
        'from'     => 'system-alart@zeus-wifi.jp',
        'to'       => [
            'error_info@googlegroups.com',
            'billing@humanlife.co.jp',
            'yta.hasebe@humanlife.co.jp',
            'kit.matsumoto@humanlife.co.jp',
        ],
        'subject'  => '【重要】〈ZEUS WiFi for GLOBAL〉プラン変更時に旧プランの無効化に失敗しました。',
        'template' => 'mail/failure_disable_rental_plan',
    ],

    /**
     * Webhook整合性チェックメール
     */
    'webhook_check_charge_mail' => [
        'from'    => 'noreply@zeus-wifi.jp',
        'to'      => [
            'wifi-engineer@humanlife.co.jp',
            'billing@humanlife.co.jp',
        ],
        'subject'  => '〈ZEUS WiFi CHARGE〉ペイディ情報チェックのお願い',
        'template' => 'mail/webhook_check_charge_mail',
    ],
];
