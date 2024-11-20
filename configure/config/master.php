<?php
/**
 * 現在日（Y-m-d）
 *
 * @var string
 */
define('CURRENT_DATE_HYPHEN', date('Y-m-d'));

/**
 * first_day_Of_current_Month
 *
 * @var string
 */
define('FIRST_DAY_OF_CURRENT_MONTH', date('Y-m-01'));

/**
 * current_year_month
 * @var string
 */
define('CURRENT_YEAR_MONTH', date('Y-m'));
/**
 * new_cancel_contract_mail_start_date
 * @var string
 */
define('NEW_CANCEL_CONTRACT_MAIL_START_DATE', 202111);
/**
 * current_last_month
 * @var string
 */
define('CURRENT_YEAR_LAST_MONTH',date("Y-m", strtotime("-1 months")));

/**
* 銀行振込プラン/銀行振込払い(前払い)請求用の架空の日付
* @var string
*/
define('BANK_TRANSFER_PLAN_SERVICE_DATE', '299901');

/**
 * 国内プランの終了日時（Y-m-d H:i:sで指定）
 *
 * @var string
 */
define('DOMESTIC_PLAN_END_DATETIME', '2100-12-31 23:59:59');

/**
 * Y-m-d H:i:s
 *
 * @var string
 */
define('FORMAT_DATETIME_HYPHEN', 'Y-m-d H:i:s');

/**
 * Y-m-d  23:59:59
 *
 * @var string
 */
define('FORMAT_DATETIME_ENDTIME_HYPHEN', 'Y-m-d 23:59:59');

/**
 * サービスID
 *
 * @var string
 */
define('SERVICE_ID', 'WIFI_WEB');

/**
 * プランID
 *
 * @var int
 */
define('PLAN_ID_1', 1);                         // ZEUS WiFi 40GBプラン
define('PLAN_ID_2', 2);                         // ZEUS WiFi 100GBプラン
define('PLAN_ID_3', 3);                         // ベーシックプラン
define('PLAN_ID_4', 4);                         // ベーシックプラン
define('PLAN_ID_326', 326);                     // ZEUS WiFi 40GBプラン しばりあり
define('PLAN_ID_327', 327);                     // ZEUS WiFi 100GBプラン しばりあり (金額：3880円)
define('PLAN_ID_328', 328);                     // ZEUS WiFi 20GBプラン しばりあり
define('PLAN_ID_329', 329);                     // ZEUS WiFi 20GBプラン
define('PLAN_ID_339', 339);                     // おうちリンク/スタンダードプラン 10GB（契約期間4ヶ月）
define('PLAN_ID_340', 340);                     // おうちリンク/スタンダードプラン 50GB（契約期間4ヶ月）
define('PLAN_ID_341', 341);                     // おうちリンク/スタンダードプラン 100GB（契約期間4ヶ月）
define('PLAN_ID_342', 342);                     // おうちリンク/フリープラン  10GB（契約期間なし）
define('PLAN_ID_343', 343);                     // おうちリンク/フリープラン  50GB（契約期間なし）
define('PLAN_ID_344', 344);                     // おうちリンク/フリープラン  100GB（契約期間なし）
define('PLAN_ID_345', 345);                     // WiMAX専用プラン（契約期間3年）
define('PLAN_ID_346', 346);                     // WiMAX専用プラン（縛りなし）
define('PLAN_ID_CLOSED_WIMAX_202206', 347);     // WiMAX専用プラン（契約期間3年） closedプラン
define('PLAN_ID_349',349);                      // WiMAX専用プラン（契約期間3年）新FUJI/新SBNから乗り換え
define('PLAN_ID_361', 361);                     // ZEUS WiFi 30GBプラン
define('PLAN_ID_362', 362);                     // ZEUS WiFi 50GBプラン
define('PLAN_ID_363', 363);                     // ZEUS WiFi 30GBプラン しばりあり
define('PLAN_ID_364', 364);                     // ZEUS WiFi 50GBプラン しばりあり
define('PLAN_ID_365', 365);                     // ZEUS WiFi 100GBプラン しばりあり (金額：3480円)
// 鹿児島レブナイズ期間限定キャンペーン専用プラン
define('PLAN_ID_371', 371);                     // ZEUS WiFi スタンダード 30GB レブナイズ用
define('PLAN_ID_372', 372);                     // ZEUS WiFi スタンダード 50GB レブナイズ用
define('PLAN_ID_373', 373);                     // ZEUS WiFi スタンダード 100GB レブナイズ用
define('PLAN_ID_374', 374);                     // ZEUS WiFi フリー 30GB レブナイズ用
define('PLAN_ID_375', 375);                     // ZEUS WiFi フリー 50GB レブナイズ用
define('PLAN_ID_376', 376);                     // ZEUS WiFi フリー 100GB レブナイズ用
// ZEUS WiFi 銀行振込プラン
define('PLAN_ID_697', 697);                     // ZEUS WiFi 銀行振込縛りあり5カ月30GBプラン
define('PLAN_ID_698', 698);                     // ZEUS WiFi 銀行振込縛りあり5カ月50GBプラン
define('PLAN_ID_699', 699);                     // ZEUS WiFi 銀行振込縛りあり5カ月100GBプラン
define('PLAN_ID_700', 700);                     // ZEUS WiFi 銀行振込縛りあり12カ月30GBプラン
define('PLAN_ID_701', 701);                     // ZEUS WiFi 銀行振込縛りあり12カ月50GBプラン
define('PLAN_ID_702', 702);                     // ZEUS WiFi 銀行振込縛りあり12カ月100GBプラン
define('PLAN_ID_703', 703);                     // ZEUS WiFi 銀行振込縛りなし5カ月30GBプラン
define('PLAN_ID_704', 704);                     // ZEUS WiFi 銀行振込縛りなし5カ月50GBプラン
define('PLAN_ID_705', 705);                     // ZEUS WiFi 銀行振込縛りなし5カ月100GBプラン
define('PLAN_ID_706', 706);                     // ZEUS WiFi 銀行振込縛りなし12カ月30GBプラン
define('PLAN_ID_707', 707);                     // ZEUS WiFi 銀行振込縛りなし12カ月50GBプラン
define('PLAN_ID_708', 708);                     // ZEUS WiFi 銀行振込縛りなし12カ月100GBプラン
// 海外レンタルプラン ※総数が膨大なので、どのプランを選んでもこのIDをキーにして送料やキャンペーンのマスタデータを取得するようにする
define('PLAN_ID_OVERSEA_RENTAL_BASE', 3601);    // 中国500MB/日レンタルプラン
define('PLAN_ID_TOUR_ASIA_500MB', 3919);                // 周遊 アジア 500MG
define('PLAN_ID_TOUR_ASIA_1GB', 3920);                  // 周遊 アジア 1GB
define('PLAN_ID_TOUR_ASIA_UNLIMITED', 3921);            // 周遊 アジア 無制限
define('PLAN_ID_TOUR_EUROPE_500MB', 3922);              // 周遊 ヨーロッパ 500MG
define('PLAN_ID_TOUR_EUROPE_1GB', 3923);                // 周遊 ヨーロッパ 1GB
define('PLAN_ID_TOUR_EUROPE_UNLIMITED', 3924);          // 周遊 ヨーロッパ 無制限
define('PLAN_ID_TOUR_WORLD_500MB', 3925);               // 周遊 世界 500MG
define('PLAN_ID_TOUR_WORLD_1GB', 3926);                 // 周遊 世界 1GB
define('PLAN_ID_TOUR_WORLD_UNLIMITED', 3927);           // 周遊 世界 無制限
define('PLAN_ID_TOUR_AFRICA_500MB', 4045);              // 周遊 アフリカ 500MG
define('PLAN_ID_TOUR_AFRICA_1GB', 4046);                // 周遊 アフリカ 1GB
define('PLAN_ID_TOUR_AFRICA_UNLIMITED', 4047);          // 周遊 アフリカ 無制限
define('PLAN_ID_TOUR_OCEANIA_500MB', 4048);             // 周遊 オセアニア 500MG
define('PLAN_ID_TOUR_OCEANIA_1GB', 4049);               // 周遊 オセアニア 1GB
define('PLAN_ID_TOUR_OCEANIA_UNLIMITED', 4050);         // 周遊 オセアニア 無制限
define('PLAN_ID_TOUR_NORTH_AMERICA_500MB', 4051);       // 周遊 北アメリカ 500MG
define('PLAN_ID_TOUR_NORTH_AMERICA_1GB', 4052);         // 周遊 北アメリカ 1GB
define('PLAN_ID_TOUR_NORTH_AMERICA_UNLIMITED', 4053);   // 周遊 北アメリカ 無制限
define('PLAN_ID_TOUR_SOUTH_AMERICA_500MB', 4054);       // 周遊 南アメリカ 500MG
define('PLAN_ID_TOUR_SOUTH_AMERICA_1GB', 4055);         // 周遊 南アメリカ 1GB
define('PLAN_ID_TOUR_SOUTH_AMERICA_UNLIMITED', 4056);   // 周遊 南アメリカ 無制限
// WiMAX ネットワークコンサルティングから入荷
define('PLAN_ID_734', 734);                     // WiMAX専用プラン（契約期間2年）
define('PLAN_ID_735', 735);                     // WiMAX専用プラン（縛りなし）

/*--------------------------/
 * 通常のデータチャージプラン
/--------------------------*/
define('PLAN_ID_330', 330);                     // データチャージ（2GB）
define('PLAN_ID_331', 331);                     // データチャージ（5GB）
define('PLAN_ID_332', 332);                     // データチャージ（10GB）

/*-----------------------------------------/
 * CHARGE国内プランマイページ用
/-----------------------------------------*/

define('OVERSEAS_PREPAID_PLAN_90DAY_100GB_PLAN_ID', 728); // CHARGE国内プラン(プリペイド)（100GB/90日）
define('OVERSEAS_PREPAID_PLAN_60DAY_50GB_PLAN_ID' , 729); // CHARGE国内プラン(プリペイド)（50GB/60日）
define('OVERSEAS_PREPAID_PLAN_30DAY_20GB_PLAN_ID' , 730); // CHARGE国内プラン(プリペイド)（20GB/30日）
define('OVERSEAS_PREPAID_PLAN_30DAY_10GB_PLAN_ID' , 731); // CHARGE国内プラン(プリペイド)（10GB/30日）
define('OVERSEAS_PREPAID_PLAN_30DAY_5GB_PLAN_ID'  , 732); // CHARGE国内プラン(プリペイド)（5GB/30日）
define('OVERSEAS_PREPAID_PLAN_30DAY_3GB_PLAN_ID'  , 733); // CHARGE国内プラン(プリペイド)（3GB/30日）

/*-----------------------------------------/
 * CHARGE国内プラン申込用
/-----------------------------------------*/
define('PREPAID_PLAN_90DAY_100GB_PLAN_ENTRY_ID', 721); // CHARGE国内プラン(プリペイド)（100GB/90日）
define('PREPAID_PLAN_60DAY_50GB_PLAN_ENTRY_ID' , 722); // CHARGE国内プラン(プリペイド)（50GB/60日）
define('PREPAID_PLAN_30DAY_20GB_PLAN_ENTRY_ID' , 723); // CHARGE国内プラン(プリペイド)（20GB/30日）
define('PREPAID_PLAN_30DAY_10GB_PLAN_ENTRY_ID' , 724); // CHARGE国内プラン(プリペイド)（10GB/30日）
define('PREPAID_PLAN_30DAY_5GB_PLAN_ENTRY_ID'  , 725); // CHARGE国内プラン(プリペイド)（5GB/30日）
define('PREPAID_PLAN_30DAY_3GB_PLAN_ENTRY_ID'  , 726); // CHARGE国内プラン(プリペイド)（3GB/30日）
define('PREPAID_PLAN_NO_CAPACITY_ENTRY_ID', 727);      // CHARGE国内プラン(プリペイド) 容量なし　端末紐づけ用
// プリペイドプラン新規購入特典：国内プリペイドプラン（3GB/30日）
define('PLAN_PREPAID_BONUS', PREPAID_PLAN_30DAY_3GB_PLAN_ENTRY_ID);

/*-----------------------------------------/
 * CHARGE国内サブスクプラン申込用(仮)
/-----------------------------------------*/
define('PREPAID_PLAN_SUBSCRIPTION_20GB_ENTRY_ID', 4065);
define('PREPAID_PLAN_SUBSCRIPTION_50GB_ENTRY_ID', 4066);
define('PREPAID_PLAN_SUBSCRIPTION_100GB_ENTRY_ID', 4067);

/*-----------------------------------------/
 * CHARGE国内プラン(プリペイド)容量・有効期間
/-----------------------------------------*/
define('PREPAID_PLAN_CAPACITY_LIST', [
    PREPAID_PLAN_90DAY_100GB_PLAN_ENTRY_ID   => '100GB / 90日',
    PREPAID_PLAN_60DAY_50GB_PLAN_ENTRY_ID    => '50GB / 60日',
    PREPAID_PLAN_30DAY_20GB_PLAN_ENTRY_ID    => '20GB / 30日',
    PREPAID_PLAN_30DAY_10GB_PLAN_ENTRY_ID    => '10GB / 30日',
    PREPAID_PLAN_30DAY_5GB_PLAN_ENTRY_ID     => '5GB / 30日',
    PREPAID_PLAN_30DAY_3GB_PLAN_ENTRY_ID     => '3GB / 30日',
    PREPAID_PLAN_NO_CAPACITY_ENTRY_ID        => '',
    PREPAID_PLAN_SUBSCRIPTION_20GB_ENTRY_ID  => '20GB',
    PREPAID_PLAN_SUBSCRIPTION_50GB_ENTRY_ID  => '50GB',
    PREPAID_PLAN_SUBSCRIPTION_100GB_ENTRY_ID => '100GB',
]);

/**
 * 通常のデータチャージのプランIDリスト
 * @var array
 */
define('DEFAULT_DETA_CAHGE_PLAN_ID_LIST', [
    PLAN_ID_330,
    PLAN_ID_331,
    PLAN_ID_332,
]);

/**
 * ZEUS申込フォームから申込可能なプラン
 *
 * @var int
 */
define('FORM_ENTRY_SPECIAL_PLAN_LIST', [
    PLAN_ID_697,
    PLAN_ID_698,
    PLAN_ID_699,
    PLAN_ID_700,
    PLAN_ID_701,
    PLAN_ID_702,
    PLAN_ID_703,
    PLAN_ID_704,
    PLAN_ID_705,
    PLAN_ID_706,
    PLAN_ID_707,
    PLAN_ID_708,
]);

/**
 * 銀行振込プラン5ヶ月プランIDリスト
 * @var array
 */
define('FORM_ENTRY_SPECIAL_5_MONTH_PLAN_LIST', [
    PLAN_ID_697,
    PLAN_ID_698,
    PLAN_ID_699,
    PLAN_ID_703,
    PLAN_ID_704,
    PLAN_ID_705,
]);

/**
 * 銀行振込プラン5ヶ月値
 * @var int
 */
define('FORM_ENTRY_SPECIAL_5_MONTH_PLAN_VALUE', 5);

/**
 * 銀行振込プラン12ヶ月プランIDリスト
 * @var array
 */
define('FORM_ENTRY_SPECIAL_12_MONTH_PLAN_LIST', [
    PLAN_ID_700,
    PLAN_ID_701,
    PLAN_ID_702,
    PLAN_ID_706,
    PLAN_ID_707,
    PLAN_ID_708,
]);

/**
 * 一括解約事務手数料プランIDリスト
 * @var array
 */
define('FORM_ENTRY_SPECIAL_CANCEL_FEE_PLAN_LIST', [
    PLAN_ID_697,
    PLAN_ID_698,
    PLAN_ID_699,
    PLAN_ID_700,
    PLAN_ID_701,
    PLAN_ID_702,
]);

/**
 * 銀行振込プラン12ヶ月値
 * @var int
 */
define('FORM_ENTRY_SPECIAL_12_MONTH_PLAN_VALUE', 12);

/**
 * プラン名
 *
 * @var string
 */
define('PLAN_ID_3_NAME', 'ベーシックプラン');

/**
 * クラウド選択可能オプション
 *
 * @var int
 */
define('OPTION_ID_CLOUD_1', 1);             // 端末あんしんオプション(ZEUS)
define('OPTION_ID_CLOUD_202302', 16);       // 端末あんしんオプション(ZEUS) 2023/02月からZEUSは値上げ

/*
 * MAYA端末(MR1)専用オプション
 * MAYAが海外使用不可のため、海外プラン購入時にH01端末をオプションとして付与し、端末発送を行う
 */
define('OPTION_ID_OVERSEAS_ONLY', 24);

/****************************
 * プリペイド選択可能オプション
 ***************************/

 /**
 * プリペイド選択可能オプション
 * ZEUS WiFi CHARGE 端末サポート（2年）
 * @var int
 */
define('OPTION_ID_PREPAID_LIGHT', 27);

 /**
 * プリペイド選択可能オプション
 * 丸ごと安心パック
 * @var int
 */
define('OPTION_ID_PREPAID_ANSHIN', 36);

 /**
 * プリペイド選択可能オプション
 * デジタルライフサポート
 * @var int
 */
define('OPTION_ID_PREPAID_INSURANCE_5', 37);

/**
 * プリペイド選択可能オプション
 * デジタルライフサポートプレミアム
 * @var int
 */
define('OPTION_ID_PREPAID_INSURANCE_20', 38);

/**
 * WiMAX専用オプション
 *
 * @var int
 */
define('OPTION_ID_WIMAX_1', 11);            // 端末あんしんオプション(WiMAX)
define('OPTION_ID_WIMAX_2', 12);            // 丸ごとあんしん
define('OPTION_ID_WIMAX_ZEUS', 13);         // 端末あんしんオプション(ZEUS+WiMAX)
define('OPTION_ID_INSURANCE_5', 14);        // 端末保険オプション年5万円
define('OPTION_ID_INSURANCE_20', 15);       // 端末保険オプション年20万円
define('OPTION_ID_WIMAX_ZEUS15GB', 21);     // ZEUS端末15GB
define('OPTION_ID_WIMAX_ZEUS30GB', 22);     // ZEUS端末30GB
define('OPTION_ID_WIMAX_ZEUS100GB', 23);    // ZEUS端末100GB
define('OPTION_ID_WIMAX_1_NWC', 33);        // ZEUS WiMAX 端末あんしんオプション

/**
 * 海外レンタルプラン用オプション
 *
 * @var int
 */
define('OPTION_ID_OVERSEA_RENTAL_SUPPORT', 25);         // 端末保証ミニ
define('OPTION_ID_OVERSEA_RENTAL_SUPPORT_WIDE', 26);    // 端末保証ワイド
define('OPTION_ID_PRIOR_DELIVERY', 29);                 // 事前配送
define('OPTION_ID_RETURN_PACK', 30);                    // 返却パック
define('OPTION_ID_TRANSIT', 34);                        // トランジット
define('OPTION_ID_INTERPRETER_SERVICE', 39);            // 通訳サービス

/**
 * WiMAXのオプショングループ
 * KEY 0 : 端末あんしんオプション, 1 : 丸ごとあんしん, 2 : ZEUS端末
 * key:option_id value:device_id
 *
 * @var array
 */
define('WIMAX_OPTION_GROUP', [
    0 => [OPTION_ID_CLOUD_1, OPTION_ID_WIMAX_1, OPTION_ID_WIMAX_ZEUS],
    1 => [OPTION_ID_WIMAX_2,],
    2 => [OPTION_ID_WIMAX_ZEUS15GB, OPTION_ID_WIMAX_ZEUS30GB, OPTION_ID_WIMAX_ZEUS100GB,],
]);

/**
 * WiMAXのオプショングループ (NWCから入荷)
 * KEY 0 : 端末あんしんオプション, 1 : 丸ごとあんしん
 * key:option_id value:device_id
 *
 * @var array
 */
define('WIMAX_OPTION_GROUP_NWC', [
    0 => [OPTION_ID_WIMAX_1_NWC,],
    1 => [OPTION_ID_WIMAX_2,],
]);

/**
 * 保険オプションIDリスト
 *
 * @var array
 */
define('INSURANCE_OPTION_LIST', [
    OPTION_ID_INSURANCE_5,
    OPTION_ID_INSURANCE_20,
    OPTION_ID_PREPAID_INSURANCE_5,
    OPTION_ID_PREPAID_INSURANCE_20,
]);

/**
 * 保険オプション補償額リスト（テキスト形式）
 *
 * @var array
 */
define('COMPENSATION_AMOUNT_LIST', [
    OPTION_ID_INSURANCE_5          => '5万円／年',
    OPTION_ID_INSURANCE_20         => '20万円／年',
    OPTION_ID_PREPAID_INSURANCE_5  => '5万円／年',
    OPTION_ID_PREPAID_INSURANCE_20 => '20万円／年',
]);
define('OPTION_HTML_TEXT_LIST', [
    OPTION_ID_INSURANCE_5          => 'デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞',
    OPTION_ID_INSURANCE_20         => 'デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞<br class="sp">／プレミアム',
    OPTION_ID_PREPAID_INSURANCE_5  => 'デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞',
    OPTION_ID_PREPAID_INSURANCE_20 => 'デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞<br class="sp">／プレミアム',
]);

/**
 * プリペイド選択可能オプションIDリスト
 *
 * @var array
 */
define('PREPAID_OPTION_LIST', [
    OPTION_ID_PREPAID_LIGHT,
]);

/**
 * プリペイド選択可能オプションIDリスト
 *
 * @var array
 */
define('PREPAID_SUBSCRIPTION_OPTION_LIST', [
    OPTION_ID_PREPAID_LIGHT,
    OPTION_ID_PREPAID_ANSHIN,
    OPTION_ID_PREPAID_INSURANCE_5,
    OPTION_ID_PREPAID_INSURANCE_20,
]);


/**
 * 臨時ファイル格納先
 *
 * @var string
 */
define('TEMP_FILE_DIRECTORY', '/home/www/rw/tmp/file/');


/**
 * ZEUS申込フォームから申込可能なプラン
 *
 * @var int
 */
define('FORM_ENTRY_PLAN_LIST', [
    PLAN_ID_1,
    PLAN_ID_2,
    PLAN_ID_3,
    PLAN_ID_4,
    PLAN_ID_326,
    PLAN_ID_327,
    PLAN_ID_328,
    PLAN_ID_329,
    PLAN_ID_361,
    PLAN_ID_362,
    PLAN_ID_363,
    PLAN_ID_364,
    PLAN_ID_365,
    PLAN_ID_371,
    PLAN_ID_372,
    PLAN_ID_373,
    PLAN_ID_374,
    PLAN_ID_375,
    PLAN_ID_376,
]);

/**
 * WiMAX申込フォームから申込可能なプラン WGから入荷
 *
 * @var int
 */
define('FORM_WIMAX_ENTRY_PLAN_LIST', [
    PLAN_ID_345,
    PLAN_ID_346,
]);

/**
 * クローズドWiMAX申込フォームから申込可能なプラン
 *
 * @var int
 */
define('FORM_CLOSED_WIMAX_ENTRY_PLAN_LIST', [
    PLAN_ID_CLOSED_WIMAX_202206,
]);

/**
 * 新FUJI/新SBNからWiMAX乗り換えプラン申込フォームから申込可能なプラン
 *
 * @var array
 */
define('FORM_CHANGE_WIMAX_ENTRY_PLAN_LIST', [
    PLAN_ID_349,
]);

/**
 * WiMAX申込フォームから申込可能なプラン NWCから入荷
 *
 * @var int
 */
define('FORM_WIMAX_ENTRY_PLAN_LIST_NWC', [
    PLAN_ID_734,
    PLAN_ID_735,
]);

/**
 * オープンハウス申込フォームから申込可能なプラン
 *
 * @var int
 */
define('FORM_OPENHOUSE_ENTRY_PLAN_LIST', [
    PLAN_ID_339,
    PLAN_ID_340,
    PLAN_ID_341,
    PLAN_ID_342,
    PLAN_ID_343,
    PLAN_ID_344,
]);

/**
 * MAYA端末-販売申込フォームから申込可能なプラン
 *
 * @var array
 */
define('FORM_MAYA_INSTALLMENT_ENTRY_PLAN_LIST', [
    PREPAID_PLAN_NO_CAPACITY_ENTRY_ID,
    PREPAID_PLAN_90DAY_100GB_PLAN_ENTRY_ID,
    PREPAID_PLAN_60DAY_50GB_PLAN_ENTRY_ID,
    PREPAID_PLAN_30DAY_20GB_PLAN_ENTRY_ID,
    PREPAID_PLAN_30DAY_10GB_PLAN_ENTRY_ID,
    PREPAID_PLAN_30DAY_3GB_PLAN_ENTRY_ID,
]);

/**
 * CHARGEサブスクプラン-販売申込フォームから申込可能なプラン
 *
 * @var array
 */
define('FORM_PREPAID_PLAN_SUBSCRIPTION_ENTRY_PLAN_LIST', [
    PREPAID_PLAN_SUBSCRIPTION_20GB_ENTRY_ID,
    PREPAID_PLAN_SUBSCRIPTION_50GB_ENTRY_ID,
    PREPAID_PLAN_SUBSCRIPTION_100GB_ENTRY_ID,
]);

/**
 * CHARGEプラン-すべての販売申込フォームから申込可能なプラン
 *
 * @var array
 */
define('FORM_PREPAID_PLAN_ALL_ENTRY_PLAN_LIST', [
    PREPAID_PLAN_NO_CAPACITY_ENTRY_ID,
    PREPAID_PLAN_90DAY_100GB_PLAN_ENTRY_ID,
    PREPAID_PLAN_60DAY_50GB_PLAN_ENTRY_ID,
    PREPAID_PLAN_30DAY_20GB_PLAN_ENTRY_ID,
    PREPAID_PLAN_30DAY_10GB_PLAN_ENTRY_ID,
    PREPAID_PLAN_30DAY_3GB_PLAN_ENTRY_ID,
    PREPAID_PLAN_SUBSCRIPTION_20GB_ENTRY_ID,
    PREPAID_PLAN_SUBSCRIPTION_50GB_ENTRY_ID,
    PREPAID_PLAN_SUBSCRIPTION_100GB_ENTRY_ID,
]);

/**
 * フリースタンダートプランIDリスト
 *
 * @var int
 */
define('FREE_DOMESTIC_PLAN_LIST', [
    PLAN_ID_1,
    PLAN_ID_2,
    PLAN_ID_329,
    PLAN_ID_361,
    PLAN_ID_362,
]);

define('STANDARD_DOMESTIC_PLAN_LIST', [
    PLAN_ID_326,
    PLAN_ID_327,
    PLAN_ID_328,
    PLAN_ID_363,
    PLAN_ID_364,
    PLAN_ID_365,
]);

/**
 * 鹿児島レブナイズ期間限定キャンペーン プランIDリスト
 */
define('REBNISE_ALL_PLAN_LIST', [
    PLAN_ID_371,
    PLAN_ID_372,
    PLAN_ID_373,
    PLAN_ID_374,
    PLAN_ID_375,
    PLAN_ID_376,
]);

/**
 * 海外レンタルプラン 周遊プランIDリスト
 */
define('INTERNATIONAL_RENTAL_TOUR_PLAN_LIST', [
    PLAN_ID_TOUR_ASIA_500MB,                // 周遊 アジア 500MG
    PLAN_ID_TOUR_ASIA_1GB,                  // 周遊 アジア 1GB
    PLAN_ID_TOUR_ASIA_UNLIMITED,            // 周遊 アジア 無制限
    PLAN_ID_TOUR_EUROPE_500MB,              // 周遊 ヨーロッパ 500MG
    PLAN_ID_TOUR_EUROPE_1GB,                // 周遊 ヨーロッパ 1GB
    PLAN_ID_TOUR_EUROPE_UNLIMITED,          // 周遊 ヨーロッパ 無制限
    PLAN_ID_TOUR_WORLD_500MB,               // 周遊 世界 500MG
    PLAN_ID_TOUR_WORLD_1GB,                 // 周遊 世界 1GB
    PLAN_ID_TOUR_WORLD_UNLIMITED,           // 周遊 世界 無制限
    PLAN_ID_TOUR_AFRICA_500MB,              // 周遊 アフリカ 500MG
    PLAN_ID_TOUR_AFRICA_1GB,                // 周遊 アフリカ 1GB
    PLAN_ID_TOUR_AFRICA_UNLIMITED,          // 周遊 アフリカ 無制限
    PLAN_ID_TOUR_OCEANIA_500MB,             // 周遊 オセアニア 500MG
    PLAN_ID_TOUR_OCEANIA_1GB,               // 周遊 オセアニア 1GB
    PLAN_ID_TOUR_OCEANIA_UNLIMITED,         // 周遊 オセアニア 無制限
    PLAN_ID_TOUR_NORTH_AMERICA_500MB,       // 周遊 北アメリカ 500MG
    PLAN_ID_TOUR_NORTH_AMERICA_1GB,         // 周遊 北アメリカ 1GB
    PLAN_ID_TOUR_NORTH_AMERICA_UNLIMITED,   // 周遊 北アメリカ 無制限
    PLAN_ID_TOUR_SOUTH_AMERICA_500MB,       // 周遊 南アメリカ 500MG
    PLAN_ID_TOUR_SOUTH_AMERICA_1GB,         // 周遊 南アメリカ 1GB
    PLAN_ID_TOUR_SOUTH_AMERICA_UNLIMITED,   // 周遊 南アメリカ 無制限
]);

define('INTERNATIONAL_RENTAL_WORLD_TOUR_PLAN_LIST', [
    PLAN_ID_TOUR_WORLD_500MB,               // 周遊 世界 500MG
    PLAN_ID_TOUR_WORLD_1GB,                 // 周遊 世界 1GB
    PLAN_ID_TOUR_WORLD_UNLIMITED,           // 周遊 世界 無制限
]);

/**
 * クラウド申込フォームから申込可能なオプション
 *
 * @var int
 */
define('FORM_CLOUD_ENTRY_OPTION_LIST', [
    OPTION_ID_CLOUD_1,              // 端末あんしんオプション (400円)
    OPTION_ID_CLOUD_202302,         // 端末あんしんオプション (528円)
    OPTION_ID_WIMAX_2,              // 丸ごと安心パックfor zeuswifi
    OPTION_ID_INSURANCE_5,          // デジタルライフサポート
    OPTION_ID_INSURANCE_20,         // デジタルライフサポートプレミアム
]);

/**
 * クラウド申込フォームから申込可能なオプション
 *
 * @var int
 */
define('FORM_CLOUD_ENTRY_SPECIAL_OPTION_LIST', [
    OPTION_ID_CLOUD_202302              // 端末あんしんオプション (580円)
]);

/**
 * WiMAX申込フォームから申込可能なオプション
 *
 * @var int
 */
define('FORM_WIMAX_ENTRY_OPTION_LIST', [
    OPTION_ID_CLOUD_1,
    OPTION_ID_WIMAX_1,
    OPTION_ID_WIMAX_2,
    OPTION_ID_WIMAX_ZEUS,
    OPTION_ID_WIMAX_ZEUS15GB,
    OPTION_ID_WIMAX_ZEUS30GB,
    OPTION_ID_WIMAX_ZEUS100GB,
]);

/**
 * WiMAX申込フォームから申込可能なオプション
 * NWCからWiMAX端末入荷
 * @var int
 */
define('FORM_WIMAX_ENTRY_OPTION_LIST_NWC', [
    OPTION_ID_WIMAX_1_NWC,
    OPTION_ID_WIMAX_2,
]);

/**
 * 海外レンタルプラン申込フォームから申込可能なオプション
 *
 * @var int
 */
define('FORM_OVERSEA_ENTRY_OPTION_LIST', [
    OPTION_ID_OVERSEA_RENTAL_SUPPORT,
    OPTION_ID_OVERSEA_RENTAL_SUPPORT_WIDE,
    OPTION_ID_PRIOR_DELIVERY,
    OPTION_ID_RETURN_PACK,
    OPTION_ID_TRANSIT,
    OPTION_ID_INTERPRETER_SERVICE,
]);

/**
 * 海外レンタルプランマイページから延長時に決済が発生するオプションリスト
 *
 * @var int
 */
define('MYPAGE_OVERSEA_EXTENSION_OPTION_INVOICE_LIST', [
    OPTION_ID_OVERSEA_RENTAL_SUPPORT,
    OPTION_ID_OVERSEA_RENTAL_SUPPORT_WIDE,
    OPTION_ID_INTERPRETER_SERVICE,
]);

/**
 * croad_sales_partner_id
 *
 * @var int
 */
define('SALES_PARTNER_ID_CROAD', 1);

/**
 * 初期リリースで選択可能な端末(H01)
 *
 * @var int
 */
define('DEVICE_ID_DEBUT', 1);

/**
 * MAYA端末(MR1) 割賦販売対応
 *
 * @var int
 */
define('DEVICE_ID_MR1_1', 36);  // 一括払い
define('DEVICE_ID_MR1_12', 39); // 12回払い
define('DEVICE_ID_MR1_24', 40); // 24回払い

/**
 * プリペイドプラン用端末(MR)
 *
 * @var int
 */
define('DEVICE_ID_PREPAID', 42);

/**
 * プリペイドプラン用端末(MR/CHARGEオートチャージプラン)
 *
 * @var int
 */
define('DEVICE_ID_PREPAID_MR', 52);

/**
 * MAYA端末(MR1)
 *
 * @var int
 */
define('DEVICE_ID_MR1', 36);

/**
 * MAYA端末(MR1) レンタル対応
 *
 * @var int
 */
define('DEVICE_ID_MR1_RENT', 41);

/**
 * 端末タイプ
 * 0: クラウド端末, 1: WiMAX端末
 * @var int
 */
define('DEVICE_TYPE_CLOUD', 0); // クラウド端末
define('DEVICE_TYPE_WIMAX', 1); // WiMAX端末

/**
 * 分割タイプ
 * 1: 一括, 24:24回払い、 36:36回払い
 * @var int
 */
define('DIVISION_MONTH_ONE_TIME' , 1);
define('DIVISION_MONTH_TWELVE' , 12);
define('DIVISION_MONTH_TWENTY_FOUR' , 24);
define('DIVISION_MONTH_THIRTY_SIX' , 36);

/**
 * 申し込み時に選択できる支払方法リスト
 * 1: 一括, 2:24回払い、 3:36回払い
 * @var int
 */
define('INSTALLMENT_PAYMENT_ONE_TIME', 1);
define('INSTALLMENT_PAYMENT_TWENTY_FOUR' , 2);
define('INSTALLMENT_PAYMENT_THIRTY_SIX' , 3);
define('INSTALLMENT_PAYMENT_LIST', [
    INSTALLMENT_PAYMENT_ONE_TIME => DIVISION_MONTH_ONE_TIME,
    INSTALLMENT_PAYMENT_TWENTY_FOUR => DIVISION_MONTH_TWENTY_FOUR,
    INSTALLMENT_PAYMENT_THIRTY_SIX => DIVISION_MONTH_THIRTY_SIX,
]);

/**
 * 顧客利用サービス種別
 * ※今後端末タイプ以外でサービスを区別する可能性も考慮し、DEVICE_TYPE_～とは別に定義
 */
define('SERVICE_TYPE_CLOUD', 0); // クラウド
define('SERVICE_TYPE_WIMAX', 1); // WiMAX
define('SERVICE_TYPE_WIMAX_INITIAL', 2); // WiMAX初期契約解除

/**
 * WiMAX+ZEUSセットのオプションで契約する端末IDリスト
 * key:option_id value:device_id
 * @var array
 */
define('WIMAX_OPTION_DEVICE_LIST', [
    OPTION_ID_WIMAX_ZEUS15GB => DEVICE_ID_DEBUT,
    OPTION_ID_WIMAX_ZEUS30GB => DEVICE_ID_DEBUT,
    OPTION_ID_WIMAX_ZEUS100GB => DEVICE_ID_DEBUT,
]);

/**
 * MAYA端末リスト
 *
 * @var array
 */
define('MAYA_DEVICE_LIST', [
    DEVICE_ID_MR1_1,  // 1回払い
    DEVICE_ID_MR1_12, // 12回払い
    DEVICE_ID_MR1_24, // 24回払い
]);

/*
 * MAYA端末(MR1)専用オプションで契約する端末IDリスト
 * key:option_id value:device_id
 * @var array
 */
define('OVERSEAS_ONLY_OPTION_DEVICE_LIST', [
    OPTION_ID_OVERSEAS_ONLY => DEVICE_ID_DEBUT,
]);

/**
 * GMO決済サイト番号
 * 1: 旧サイト, 2: 新サイト
 * @var int
 */
define('GMO_NEW_SHOP_NUMBER', 2);

/**
 * プロモーション（index）
 *
 * @var int
 */
define('PROMOTION_INDEX', 'index');

/**
 * プロモーション（limitedplan）
 *
 * @var int
 */
define('PROMOTION_LIMITEDPLAN', 'limitedplan');

/**
 * プラン選択 しばりなし
 *
 * @var int
 */
define('TIE_OFF', 0);

/**
 * プラン選択 しばりあり
 *
 * @var int
 */
define('TIE_ON', 1);

/**
 * キャッシュファイル格納先
 *
 * @var string
 */
define('CACHE_DIRECTORY', '/home/www/rw/tmp/cache');

/**
 * セッションファイル格納先
 *
 * @var string
 */
define('SESSION_DIRECTORY', '/home/www/rw/human_life/web/session');

/**
 * フラグ_OFF
 *
 * @var int
 */
define('FLG_OFF', 0);

/**
 * フラグ_ON
 *
 * @var int
 */
define('FLG_ON', 1);

/**
 * ラジオボタン用の値：「未選択」「利用しない」等の非の意味合いで用いる
 */
define('NON_SELECTED', -1);

/**
 * ユーザーのステータス
 *
 * @var array
 */
define('USER_STATUS_LIST', [
    'available'                             => 0,  // 有効
    'withdraw'                              => 1,  // 解約
    'suspend'                               => 2,  // 一時停止
    'force_withdraw'                        => 3,  // 強制解約
    'temporary_register'                    => 4,  // 仮登録
    'reserve_withdraw'                      => 5,  // 解約予約中
    'initial_contract_cancellation'         => 7,  // 初期契約解除
    'reserve_initial_contract_cancellation' => 8,  // 初期契約解除予約中
    'end_charge_subscription'               => 92, // CHARGEプランサブスク終了
    'repeat_rental'                         => 91, // 海外レンタルプランの再申込
    'draft'                                 => 99, // 仮申し込み
]);

/**
 * 法人顧客ステータスリスト
 *
 * @var array
 */
define('CORP_USER_STATUS_VALUE_LIST', [
    'INQUIRY'           => 4,
    'WAIT_CONTRACT_DOC' => 6,
    'ACTIVE'            => 0,
    'WITHDRAW'          => 2,
    'FORCE_WITHDRAW'    => 3,
]);

/**
 * ログインを許可するユーザーのステータス
 *
 * @var array
 */
define('LOGIN_ALLOW_USER_STATUS_LIST', [
    USER_STATUS_LIST['available'],
    USER_STATUS_LIST['withdraw'],
    USER_STATUS_LIST['suspend'],
    USER_STATUS_LIST['reserve_withdraw'],
    USER_STATUS_LIST['reserve_initial_contract_cancellation'],
    USER_STATUS_LIST['repeat_rental'],
    USER_STATUS_LIST['end_charge_subscription'],
]);
define('MYPAGE_LOGIN_ALLOW_POSSIBLE_USER_STATUS_LIST', [
    USER_STATUS_LIST['available'],
    USER_STATUS_LIST['withdraw'],
    USER_STATUS_LIST['suspend'],
    USER_STATUS_LIST['reserve_withdraw'],
    USER_STATUS_LIST['reserve_initial_contract_cancellation'],
    USER_STATUS_LIST['end_charge_subscription'],
]);
define('MYPAGE_LOGIN_ALLOW_USER_STATUS_LIST', [
    USER_STATUS_LIST['available'],
    USER_STATUS_LIST['withdraw'],
    USER_STATUS_LIST['reserve_withdraw'],
    USER_STATUS_LIST['suspend'],
    USER_STATUS_LIST['force_withdraw'],
    USER_STATUS_LIST['reserve_initial_contract_cancellation'],
    USER_STATUS_LIST['initial_contract_cancellation'],
    USER_STATUS_LIST['repeat_rental'],
    USER_STATUS_LIST['end_charge_subscription'],
]);
define('DEVICE_INIT_USER_STATUS_LIST', [
    USER_STATUS_LIST['available'],
    USER_STATUS_LIST['reserve_withdraw'],
    USER_STATUS_LIST['reserve_initial_contract_cancellation'],
    USER_STATUS_LIST['draft'],
]);
define('ENTRY_DUPLICATE_NOT_ALLOW_USER_STATUS_LIST', [
    USER_STATUS_LIST['available'],
    USER_STATUS_LIST['withdraw'],
    USER_STATUS_LIST['reserve_withdraw'],
    USER_STATUS_LIST['reserve_initial_contract_cancellation'],
    USER_STATUS_LIST['force_withdraw'],
    USER_STATUS_LIST['suspend'],
    USER_STATUS_LIST['repeat_rental'],
    USER_STATUS_LIST['end_charge_subscription'],
]);
define('LOGIN_ALLOW_USER_STATUS_LIST_FOR_INSURANCE', [
    USER_STATUS_LIST['available'],
    USER_STATUS_LIST['withdraw'],
    USER_STATUS_LIST['suspend'],
    USER_STATUS_LIST['reserve_withdraw'],
    USER_STATUS_LIST['reserve_initial_contract_cancellation'],
    USER_STATUS_LIST['initial_contract_cancellation'],
    USER_STATUS_LIST['end_charge_subscription'],
]);

/**
 * 無料おかわりに関する表示を行うステータスリスト
 */
define('DISPLAY_FREE_CHARGE_RELATED_STATUS_LIST', [
    USER_STATUS_LIST['available'], // 利用中
    USER_STATUS_LIST['reserve_withdraw'], // 解約予約中
    USER_STATUS_LIST['reserve_initial_contract_cancellation'], // 初期契約解除予約中
]);

/**
 *
 * @var document_status_list
 */

define('USER_DOCUMENT_STATUS_LIST', [
    'initial_status'             => 1, // 初期状態
    'resubmit_status'            => 2, // 再提出状態
]);


/**
 * ユーザードキュメントカテゴリリスト
 *
 * @var array
 */
define('USER_DOCUMENT_CATEGORY_LIST', [
    'confirm_doc_id'             => 1, // 契約法人の確認書類
    'identity_verification_id'   => 2, // 契約担当者の本人確認書類
    'auxiliary_id'               => 3, // 補助書類
    'enrollment_verification_id' => 4, // 契約担当者の在籍確認書類
]);

/**
 * 法人ドキュメントタイプ
 *
 * @var array
 */
define('CORP_CONTRACT_DOCUMENT_LIST', [
    'register_copy_book' => 1 , //登記簿謄(抄)本
    'certificate_current_matters' => 2, // 現在事項証明書
    'seal_certificate' => 3, //印鑑証明書
    'draving_licence' => 4, //運転免許証
    'japan_passport' => 5, //日本国パスポート
    'my_number_card' => 6, //マイナンバーカード
    'health_insurance_card_and_supplementary_documents' => 7, //康保険証＋補助書類
    'receipt_utility_bill' => 8, //公共料金等の請求及び領収書
    'print_matter_issue' => 9, //官公庁発行の印刷物
    'resident_card_entry_certificate' => 10, //住民票記載事項証明書
    'invoice_residence_certificate' => 11, //住居証明書(住居証明書発給請求書)
    'notification_evacuation_site_certificate' => 12, //届出避難場所証明書
    'employee_id_card' => 13, //社員証
    'business_card' => 14, //名刺
    'health_insurance_card' => 15, //健康保険証
]);

/**
 * 申し込みステータス
 *
 * @var array
 */
define('ENTRY_STATUS_LIST', [
    'new'                           => 1, // 新規
    'under_examination'             => 2, // 審査中
    'approved'                      => 3, // 承認済み
    'output_csv'                    => 4, // CSV出力済み
    'already_sent'                  => 5, // 発送済み
    'rejection'                     => 6, // 却下
    'settlement_info_input_waiting' => 7, // 決済情報入力待ち
    'entry_settlement_error'        => 9,  // 申込NG（課金エラー）
    'have_device'                   => 11, // 端末入手済み(新規購入)
    'used_device'                   => 12, // 端末入手済み(譲渡)
    'draft'                         => 99,
    'draft_cancel'                  => 98,
]);

/**
 * 端末カラー
 *
 * @var array
 */
define('DEVICE_COLOR_LIST', [
    '0' => '',
    '1' => 'チタニウムグレー',
    '2' => 'スノーホワイト',
]);

/**
 * 端末カラー NWCから入荷したWiMAX端末
 *
 * @var array
 */
define('DEVICE_COLOR_LIST_NWC', [
    '0' => '',
    '1' => 'シャドーブラック',
    '2' => 'アイスホワイト',
]);

/**
 * プラン区分 国内プラン
 *
 * @var int
 */
define('PLAN_TYPE_DOMESTIC', 0);

/**
 * プラン区分 海外プラン_1日_300M
 *
 * @var int
 */
define('PLAN_TYPE_INTERNATIONAL_1DAY_300M', 1);

/**
 * プラン区分 海外プラン_7日_1G
 *
 * @var int
 */
define('PLAN_TYPE_INTERNATIONAL_7DAY_1G', 2);

/**
 * プラン区分 海外プラン_30日_3G
 *
 * @var int
 */
define('PLAN_TYPE_INTERNATIONAL_30DAY_3G', 3);

/**
 * プラン区分 データチャージ
 *
 * @var int
 */
define('PLAN_TYPE_DOMESTIC_DATA_CHARGE', 4);

/**
 * プラン区分 短期レンタル
 *
 * @var int
 */
define('PLAN_TYPE_RENTAL', 5);

/**
 * プラン区分 初期費用 Atone表示用
 *
 * @var int
 */
define('PLAN_TYPE_INIT', 9);

/**
 * プラン区分 オプション Atone表示用
 *
 * @var int
 */
define('PLAN_TYPE_OPTION', 'option');

/**
 * プラン区分 端末 Atone表示用
 *
 * @var int
 */
define('PLAN_TYPE_DEVICE', 'device');

/**
 * プラン区分 海外レンタルプラン
 *
 * @var int
 */
define('PLAN_TYPE_INTERNATIONAL_RENTAL', 10);

/**
 * プラン区分 海外プランベースプラン(契約紐づけ用)
 *
 * @var int
 */
define('PLAN_TYPE_INTERNATIONAL_PREPAID', 11);

/**
 * プラン区分 CHARGE国内プラン(プリペイド) 国内チャージ
 *
 * @var int
 */
define('PLAN_TYPE_INTERNATIONAL_PREPAID_DOMESTIC', 12);

/**
 * プラン区分 CHARGE国内プラン(プリペイド) 1日500MBプラン
 *
 * @var int
 */
define('PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_500MB', 13);

/**
 * プラン区分 CHARGE国内プラン(プリペイド) 1日1GBプラン
 *
 * @var int
 */
define('PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_1GB', 14);

/**
 * プラン区分 CHARGE国内プラン(プリペイド) 1日無制限プラン
 *
 * @var int
 */
define('PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_UNLIMITED', 15);

/**
 * プラン区分 CHARGE国内プラン(プリペイド) 7日1GBプラン
 *
 * @var int
 */
define('PLAN_TYPE_INTERNATIONAL_PREPAID_7DAY_1GB', 16);

/**
 * プラン区分 CHARGE国内プラン(プリペイド) 30日3GBプラン
 *
 * @var int
 */
define('PLAN_TYPE_INTERNATIONAL_PREPAID_30DAY_3GB', 17);

/**
 * プラン区分CHARGE国内プラン(プリペイド) 周遊プラン
 *
 * @var int
 */
// define('PLAN_TYPE_INTERNATIONAL_PREPAID_EXCURSION', 18);

/**
 * プラン区分 法人用特別プラン（ふるさと納税）
 *
 * @var int
 */
define('PLAN_TYPE_CORP_SPECIAL_HOMETOWN_TAX', 20);

/**
 * UCLから取得する対象のplan_type 国内
 * @var int
 */
define('TARGET_PLAN_TYPE_DOMESTIC', 0);

/**
 * UCLから取得する対象のplan_type 国外
 * @var int
 */
define('TARGET_PLAN_TYPE_INTERNATIONAL', 1);

/**
 * UCLから取得する対象のplan_type 国内/国外
 * @var int
 */
define('TARGET_PLAN_TYPE_ALL', 2);

/**
 * プラン区分
 *
 * @var array
 */
define('PLAN_TYPE_LIST', [
    'DOMESTIC'                           => PLAN_TYPE_DOMESTIC,                             // 国内プラン
    'INTERNATIONAL_1DAY_300M'            => PLAN_TYPE_INTERNATIONAL_1DAY_300M,              // 海外プラン_1日_300M
    'INTERNATIONAL_7DAY_1G'              => PLAN_TYPE_INTERNATIONAL_7DAY_1G,                // 海外プラン_7日_1G
    'INTERNATIONAL_30DAY_3G'             => PLAN_TYPE_INTERNATIONAL_30DAY_3G,               // 海外プラン_30日_3G
    'DOMESTIC_DATA_CHARGE'               => PLAN_TYPE_DOMESTIC_DATA_CHARGE,                 // データチャージ
    'INTERNATIONAL_RENTAL'               => PLAN_TYPE_INTERNATIONAL_RENTAL,                 // 海外レンタルプラン
    'INTERNATIONAL_PREPAID_1DAY_500MB'   => PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_500MB,     // CHARGE国内プラン(プリペイド) 1日500MBプラン
    'INTERNATIONAL_PREPAID_1DAY_1GB'     => PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_1GB,       // CHARGE国内プラン(プリペイド) 1日1GBプラン
    'INTERNATIONAL_PREPAID_7DAY_1GB'     => PLAN_TYPE_INTERNATIONAL_PREPAID_7DAY_1GB,       // CHARGE国内プラン(プリペイド) 7日1GBプラン
    'INTERNATIONAL_PREPAID_30DAY_3GB'    => PLAN_TYPE_INTERNATIONAL_PREPAID_30DAY_3GB,      // CHARGE国内プラン(プリペイド) 30日3GBプラン
    'INTERNATIONAL_PREPAID_UNLIMITED'    => PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_UNLIMITED, // CHARGE国内プラン(プリペイド) 1日無制限プラン
    // 'INTERNATIONAL_PREPAID_MULTI'        => PLAN_TYPE_INTERNATIONAL_PREPAID_EXCURSION,      // CHARGE国内プラン(プリペイド) 周遊プラン
    'INTERNATIONAL_BASE'                 => PLAN_TYPE_INTERNATIONAL_PREPAID,                // CHARGE国内プラン(プリペイド)ベースプラン(契約紐づけ用)
    'INTERNATIONAL_DOMESTIC'             => PLAN_TYPE_INTERNATIONAL_PREPAID_DOMESTIC,       // CHARGE国内プラン(プリペイド)用国内プラン
    ]
);

/**
 * プラン区分名
 *
 * @var array
 */
define('PLAN_TYPE_NAME_LIST', [
    PLAN_TYPE_DOMESTIC                             => '国内プラン',
    PLAN_TYPE_INTERNATIONAL_1DAY_300M              => '海外プラン_1日_300M',
    PLAN_TYPE_INTERNATIONAL_7DAY_1G                => '海外プラン_7日_1G',
    PLAN_TYPE_INTERNATIONAL_30DAY_3G               => '海外プラン_30日_3G',
    PLAN_TYPE_DOMESTIC_DATA_CHARGE                 => 'データチャージ',
    PLAN_TYPE_RENTAL                               => '短期レンタル', // Fonのみ
    PLAN_TYPE_INIT                                 => '初期費用',     // Atone表示用
    PLAN_TYPE_OPTION                               => 'オプション',   // Atone表示用
    PLAN_TYPE_DEVICE                               => '端末',        // Atone表示用
    PLAN_TYPE_INTERNATIONAL_RENTAL                 => '海外レンタルプラン',
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_500MB     => 'CHARGE国内プラン(プリペイド)500MB(1日)',
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_1GB       => 'CHARGE国内プラン(プリペイド)1GB(1日)',
    PLAN_TYPE_INTERNATIONAL_PREPAID_7DAY_1GB       => 'CHARGE国内プラン(プリペイド)1GB(7日)',
    PLAN_TYPE_INTERNATIONAL_PREPAID_30DAY_3GB      => 'CHARGE国内プラン(プリペイド)3GB(30日)',
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_UNLIMITED => 'CHARGE国内プラン(プリペイド)無制限(1日)',
    // PLAN_TYPE_INTERNATIONAL_PREPAID_EXCURSION      => '海外プリペイド周遊プラン',
    PLAN_TYPE_INTERNATIONAL_PREPAID                => 'CHARGE国内プラン(プリペイド)申込用プラン',
    PLAN_TYPE_INTERNATIONAL_PREPAID_DOMESTIC       => 'CHARGE国内プラン(プリペイド)用国内プラン',
]);

/**
 * 海外プラン区分
 *
 * @var array
 */
define('INTERNATIONAL_PLAN_TYPE_LIST', [
    PLAN_TYPE_INTERNATIONAL_1DAY_300M,
    PLAN_TYPE_INTERNATIONAL_7DAY_1G,
    PLAN_TYPE_INTERNATIONAL_30DAY_3G,
]);

/**
 * 海外プラン区分(プリペイドプラン向け)
 *
 * @var array
 */
define('INTERNATIONAL_PREPAID_PLAN_TYPE_LIST', [
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_500MB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_1GB,
    // @TODO ↓一時除外
    // PLAN_TYPE_INTERNATIONAL_PREPAID_7DAY_1GB,
    // PLAN_TYPE_INTERNATIONAL_PREPAID_30DAY_3GB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_UNLIMITED,
    // PLAN_TYPE_INTERNATIONAL_PREPAID_EXCURSION,
]);

/**
 * CHARGE国内プラン(プリペイド)用データチャージのプランIDリスト
 * @var array
 */
define('MAYA_DETA_CAHGE_PLAN_ID_LIST', [
    OVERSEAS_PREPAID_PLAN_90DAY_100GB_PLAN_ID,
    OVERSEAS_PREPAID_PLAN_60DAY_50GB_PLAN_ID,
    OVERSEAS_PREPAID_PLAN_30DAY_20GB_PLAN_ID,
    OVERSEAS_PREPAID_PLAN_30DAY_10GB_PLAN_ID,
    OVERSEAS_PREPAID_PLAN_30DAY_5GB_PLAN_ID,
    OVERSEAS_PREPAID_PLAN_30DAY_3GB_PLAN_ID,
]);

/**
 * CHARGE国内プラン(プリペイド)用データチャージのプランタイプリスト
 * @var array
 */
define('MAYA_DETA_CAHGE_PLAN_TYPE_LIST', [
    PLAN_TYPE_INTERNATIONAL_PREPAID,
    PLAN_TYPE_INTERNATIONAL_PREPAID_DOMESTIC,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_500MB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_1GB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_7DAY_1GB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_30DAY_3GB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_UNLIMITED,
    // PLAN_TYPE_INTERNATIONAL_PREPAID_EXCURSION,
]);

/**
 * CHARGE国内プラン(プリペイド)プラン変更可能プランTYPEリスト
 */
define('INTERNATIONAL_CAN_PLAN_CHANGE_PREPAID_PLAN_TYPE_LIST', [
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_500MB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_1GB,
]);

/**
 * 海外プリペイドデータ使用量名リスト
 *
 * @var array
 */
define('INTERNATIONAL_PREPAID_DATA_USAGE_LIMIT_NAME_LIST', [
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_500MB     => "500MB",
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_1GB       => "1GB",
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_UNLIMITED => "無制限",
]);

/**
 * CHARGE国内プラン(プリペイド)連続購入可能プランIDリスト
 */
define('MAYA_CONTINUOUS_PURCHASE_PLAN_TYPE_LIST', [
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_500MB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_1GB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_UNLIMITED,
]);

/**
 * CHARGE国内プラン(プリペイド)国内チャージプランタイプリスト
 */
define('INTERNATIONAL_CHANGE_PREPAID_PLAN_DOMESTIC_TYPE_LIST', [
    PLAN_TYPE_INTERNATIONAL_PREPAID,
    PLAN_TYPE_INTERNATIONAL_PREPAID_DOMESTIC,
]);


/**
 * CHARGE国内プラン(プリペイド)用データチャージのプランIDリスト
 * @var array
 */
define('MAYA_DETA_PREPAID_PLAN_TYPE_LIST', [
    PREPAID_PLAN_NO_CAPACITY_ENTRY_ID
]);

/**
 * CHARGE国内プラン(プリペイド)関連の容量管理(UCLから取得できない場合に使用)
 * @var array
 */
define('MAYA_PREPAID_PLAN_GIGA_LIST', [
    PREPAID_PLAN_NO_CAPACITY_ENTRY_ID => 0.5
]);

/**
 * CHARGE国内プラン(プリペイド)関連の容量管理/国外(UCLから取得できない場合に使用)
 * @var array
 */
define('MAYA_PREPAID_PLAN_TYPE_GIGA_LIST', [
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_500MB     => 0.5,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_1GB       => 1,
    PLAN_TYPE_INTERNATIONAL_PREPAID_7DAY_1GB       => 1,
    PLAN_TYPE_INTERNATIONAL_PREPAID_30DAY_3GB      => 3,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_UNLIMITED => 0,
    // PLAN_TYPE_INTERNATIONAL_PREPAID_EXCURSION      => 0.5,
]);

/**
 * CHARGE国内プラン(プリペイド)関連の容量管理/国内(UCLから取得できない場合に使用)
 * @var array
 */
define('MAYA_PREPAID_PLAN_DATA_CHARGE_TYPE_GIGA_LIST', [
    OVERSEAS_PREPAID_PLAN_90DAY_100GB_PLAN_ID => 100,
    OVERSEAS_PREPAID_PLAN_60DAY_50GB_PLAN_ID  => 50,
    OVERSEAS_PREPAID_PLAN_30DAY_20GB_PLAN_ID  => 20,
    OVERSEAS_PREPAID_PLAN_30DAY_10GB_PLAN_ID  => 10,
    OVERSEAS_PREPAID_PLAN_30DAY_5GB_PLAN_ID   => 5,
    OVERSEAS_PREPAID_PLAN_30DAY_3GB_PLAN_ID   => 3,
    PREPAID_PLAN_90DAY_100GB_PLAN_ENTRY_ID    => 100,
    PREPAID_PLAN_60DAY_50GB_PLAN_ENTRY_ID     => 50,
    PREPAID_PLAN_30DAY_20GB_PLAN_ENTRY_ID     => 20,
    PREPAID_PLAN_30DAY_10GB_PLAN_ENTRY_ID     => 10,
    PREPAID_PLAN_30DAY_5GB_PLAN_ENTRY_ID      => 5,
    PREPAID_PLAN_30DAY_3GB_PLAN_ENTRY_ID      => 3,
    PREPAID_PLAN_SUBSCRIPTION_20GB_ENTRY_ID   => 20,
    PREPAID_PLAN_SUBSCRIPTION_50GB_ENTRY_ID   => 50,
    PREPAID_PLAN_SUBSCRIPTION_100GB_ENTRY_ID  => 100,
    PLAN_ID_330                               => 2,
    PLAN_ID_331                               => 5,
    PLAN_ID_332                               => 10,
]);

/**
 * データチャージプラン区分
 *
 * @var array
 */
define('DATA_CHARGE_PLAN_TYPE_LIST', [
    PLAN_TYPE_DOMESTIC_DATA_CHARGE,
]);

/**
 * データチャージプラン区分（海外プリペイド国内プラン)
 *
 * @var array
 */
define('DATA_CHARGE_PREPAID_PLAN_TYPE_LIST', [
    PLAN_TYPE_INTERNATIONAL_PREPAID,
    PLAN_TYPE_INTERNATIONAL_PREPAID_DOMESTIC,
    PLAN_TYPE_DOMESTIC_DATA_CHARGE,
]);

/**
 * 海外プラン用データチャージ・海外プラン区分
 *
 * @var array
 */
define('DATA_CHARGE_INTERNATIONAL_PLAN_TYPE_LIST', [
    PLAN_TYPE_INTERNATIONAL_PREPAID_DOMESTIC,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_500MB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_1GB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_7DAY_1GB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_30DAY_3GB,
    PLAN_TYPE_INTERNATIONAL_PREPAID_1DAY_UNLIMITED,
    PLAN_TYPE_INTERNATIONAL_PREPAID,
]);

/**
 * 海外プラン一覧用区分配列
 *
 * @var array
 */
define('INTERNATIONAL_PLAN_CONTINENT_LIST',[
    'ヨーロッパ' => [],
    '北アメリカ' => [],
    'アジア' => [],
    'アフリカ' => [],
    '南アメリカ' => [],
    'オセアニア' => [],
]);

/**
 * 海外プラン一覧用区分配列
 *
 * @var array
 */
define('INTERNATIONAL_TOUR_PLAN_CONTINENT_LIST',[
    'ヨーロッパ' => [],
    '北アメリカ' => [],
    'アジア' => [],
    'アフリカ' => [],
    '南アメリカ' => [],
    'オセアニア' => [],
    '全世界' => [],
]);

/**
 * 当サービスにおける1日の開始時間・プランの利用終了日の閾値
 * 9:00 ~ 翌8:59
 *
 * @var array
 */
define('BASIC_START_TIME_OF_THE_DAY', '09:00:00');

/**
 * 半角スペース
 *
 * @var string
 */
define('SPACE_HALF_WIDTH', ' ');

/**
 * 全角スペース
 *
 * @var string
 */
define('SPACE_FULL_WIDTH', '　');

/**
 * HTTPステータスコード_正常
 *
 * @var int
 */
define('HTTP_STATUS_OK', 200);

/**
 * HTTPステータスコード_リダイレクト
 *
 * @var int
 */
define('HTTP_STATUS_FOUND', 302);

/**
 * HTTPステータスコード_テンポラリリダイレクト
 *
 * @var int
 */
define('HTTP_STATUS_TEMPORARY_REDIRECT', 307);

/**
 * HTTPステータスコード_リクエスト不正
 *
 * @var int
 */
define('HTTP_STATUS_BAD_REQUEST', 400);

/**
 * HTTPステータスコード_認証失敗
 *
 * @var int
 */
define('HTTP_STATUS_UNAUTHORIZED', 401);

/**
 * HTTPステータスコード_不正アクセス
 *
 * @var int
 */
define('HTTP_STATUS_FORBIDDEN', 403);

/**
 * HTTPステータスコード_未検出
 *
 * @var int
 */
define('HTTP_STATUS_NOT_FOUND', 404);

/**
 * HTTPステータスコード_タイムアウト
 *
 * @var int
 */
define('HTTP_STATUS_REQUEST_TIMEOUT', 408);

/**
 * HTTPステータスコード_内部エラー
 *
 * @var int
 */
define('HTTP_STATUS_INTERNAL_SERVER_ERROR', 500);

/**
 * HTTPステータスコード_サービス利用不可
 *
 * @var int
 */
define('HTTP_STATUS_SERVICE_UNAVAILABLE', 503);
/**
 * デビューキャンペーン受付期限
 *
 * @var int
 */
define('ENTRY_REFUSE_BEGIN_TIME', 0);
/**
 * 事業者ID
 *
 * @var int
 */
define('BUSINESS_ID', 1);

/**
 * ソルト
 *
 * @var string
 */
define('SALT', 'ふいらんまーひゅ');

/**
 * 各月の解約受付締め日
 *
 * @var int
 */
define('CANCEL_CLOSE_DAY', 26);

/**
 * システムユーザー名
 * 作成者や更新者に利用
 *
 * @var string
 */
define('SYSTEM_USER_NAME', 'SYSTEM_CONSUMER');

/**
 * パスワード最小文字数
 *
 * @var int
 */
define('PASSWORD_MIN_LENGTH', 8);

/**
 * パスワード最大文字数
 *
 * @var int
 */
define('PASSWORD_MAX_LENGTH', 16);

/**
 * 本人確認トークン有効日数
 *
 * @var int
 */
define('PASSWORD_REMINDER_EXPIRED_MINUTE', 1440);

/**
 * SAAS連携リトライ回数
 */
define('SAAS_RETRY_COUNT', 1);

// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
// ディレクトリ・ファイル関連
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
/**
 * ディレクトリのデフォルトパーミッション
 *
 * @var int
 */
define('DIRECTORY_PERMISSION', 0755);

/**
 * キャッシュディレクトリのパーミッション
 *
 * @var int
 */
define('CACHE_DIRECTORY_PERMISSION', 0777);

/**
 * ファイルのデフォルトパーミッション
 *
 * @var int
 */
define('FILE_PERMISSION', 0666);

// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
// view用の設定関連
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
/**
 * 生年月日選択項目の開始年
 *
 * @var int
 */
define('BIRTH_DAY_START_YEAR', date('Y') - 110);

/**
 * 生年月日選択項目の終了年
 *
 * @var int
 */
define('BIRTH_DAY_END_YEAR', date('Y') - 20);

/**
 * 生年月日選択項目の開始月
 *
 * @var int
 */
define('BIRTH_DAY_START_MONTH', 1);

/**
 * 生年月日選択項目の終了月
 *
 * @var int
 */
define('BIRTH_DAY_END_MONTH', 12);

/**
 * 生年月日選択項目の開始日
 *
 * @var int
 */
define('BIRTH_DAY_START_DAY', 1);

/**
 * 生年月日選択項目の終了日
 *
 * @var int
 */
define('BIRTH_DAY_END_DAY', 31);

/**
 */
define('PREFECTURE_LIST', [
    1  => '北海道',
    2  => '青森県',
    3  => '岩手県',
    4  => '宮城県',
    5  => '秋田県',
    6  => '山形県',
    7  => '福島県',
    8  => '茨城県',
    9  => '栃木県',
    10 => '群馬県',
    11 => '埼玉県',
    12 => '千葉県',
    13 => '東京都',
    14 => '神奈川県',
    15 => '新潟県',
    16 => '富山県',
    17 => '石川県',
    18 => '福井県',
    19 => '山梨県',
    20 => '長野県',
    21 => '岐阜県',
    22 => '静岡県',
    23 => '愛知県',
    24 => '三重県',
    25 => '滋賀県',
    26 => '京都府',
    27 => '大阪府',
    28 => '兵庫県',
    29 => '奈良県',
    30 => '和歌山県',
    31 => '鳥取県',
    32 => '島根県',
    33 => '岡山県',
    34 => '広島県',
    35 => '山口県',
    36 => '徳島県',
    37 => '香川県',
    38 => '愛媛県',
    39 => '高知県',
    40 => '福岡県',
    41 => '佐賀県',
    42 => '長崎県',
    43 => '熊本県',
    44 => '大分県',
    45 => '宮崎県',
    46 => '鹿児島県',
    47 => '沖縄県',
]);

/**
 * 申し込みステータス（表示）
 *
 * @var array
 */
define('DISPLAY_ENTRY_STATUS_LIST', [
    'entry'    => 'お申し込み中',
    'approved' => 'ご契約中',
]);

// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
// 各種フォーマット
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
/**
 * 日付フォーマット_Y
 *
 * @var string
 */
define('DATE_FORMAT_Y', 'Y');

/**
 * 日付フォーマット_M
 *
 * @var string
 */
define('DATE_FORMAT_M', 'm');

/**
 * 日付フォーマット_D
 *
 * @var string
 */
define('DATE_FORMAT_D', 'd');

/**
 * 日付フォーマット_YM
 *
 * @var string
 */
define('DATE_FORMAT_YM', 'Y-m');

/**
 * 日付フォーマット_YMD
 *
 * @var string
 */
define('DATE_FORMAT_YMD', 'Y-m-d');

/**
 * 日付フォーマット_YMD(スラッシュ)
 *
 * @var string
 */
define('DATE_FORMAT_YMD_SLASH', 'Y/m/d');

/**
 * 日付フォーマット YYYY年MM月DD日
 * @var unknown
 */
define('DATE_FORMAT_YMD_NENGATSUHI', 'Y年m月d日');

/**
 * 日付フォーマット M月D日（先頭のゼロ付け無し）
 * @var unknown
 */
define('DATE_FORMAT_YMD_GATSUHI_NOZERO', 'n月j日');

/**
 * 日付フォーマット YYYY年M月D日（先頭のゼロ付け無し）
 * @var unknown
 */
define('DATE_FORMAT_YMD_NENGATSUHI_NOZERO', 'Y年n月j日');

/**
 * 日付フォーマット_YMDHI
 *
 * @var string
 */
define('DATE_FORMAT_YMDHI', 'Y-m-d H:i');

/**
 * 日付フォーマット_YMDHIS
 *
 * @var string
 */
define('DATE_FORMAT_YMDHIS', 'Y-m-d H:i:s');

/**
 * 日付フォーマット_利用終了日算出閾値
 *
 * @var string
 */
define('DATE_FORMAT_THRESHOLD', 'Y-m-25');

/**
 * 日付フォーマット_0時
 *
 * @var string
 */
define('DATE_FORMAT_YMDHIS_ZERO', 'Y-m-d 00:00:00');

/**
 * 課金開始日＋8日
 *
 * @var string
 */
define('APPLICATION_DURATION_DAY', '8');

/**
 * 届出日＋8日
 *
 * @var string
 */
define('RETURN_DEADLINE_DURATION_DAY', '8');

/**
 * BASIC認証のユーザー名
 *
 * @var string
 */
define('BASIC_AUTH_USER_NAME', 'Staging@Human0213');

/**
 * BAISC認証のパスワード
 *
 * @var string
 */
define('BASIC_AUTH_PASSWORD', '7002a62f729fa06a84d9a560dab6e1d3');

/**
 * コールセンター名前リスト
 *
 * @var array
 */
define('CALLCENTER_LIST', [
    0 => 'HL(新宿)',
    1 => 'HL(大阪)',
    2 => 'HL(つくば)',
]);

/**
 * FAQ値リスト
 *
 * @var array
 */
define('FAQ_STATUS_VALUE_LIST', [
    0 => '公開中',
    1 => '非公開',
    2 => '準備中',
]);
define('FAQ_CATEGORY_STATUS_VALUE_LIST', [
    0 => '公開中',
    1 => '非公開',
    2 => '準備中',
]);
/**
 * FAQ PAGEリスト
 *
 * @var array
 */
define('FAQ_PAGE_VALUE_LIST', [
    'COMMON'    => '2', // よくある質問
    'SUPPORT'   => '3', // サポート
    'PROMOTION' => '4', // プロモーション
    'FOREIGN'   => '5', // 海外プラン
    'WIMAX'     => '7', // WiMAX
    'OPENHOUSE' => '6', // オープンハウス
]);
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
// DB定義値
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
/**
 * ステータス値リスト
 *
 * @var array
 */
define('USER_STATUS_VALUE_LIST', [
    'VALID'                         => 0,  // 有効
    'INVALID'                       => 1,  // 解約
    'STOP'                          => 2,  // 停止
    'FORCE_WITHDRAW'                => 3,  // 強制解約
    'TEMPORARY_REGISTER'            => 4,  // 仮登録
    'RESERVE_WITHDRAW'              => 5,  // 解約予約中
    'INITIAL_CONTRACT_CANCELLATION' => 7,  // 初期契約解除
    'REPEAT_RENTAL'                 => 91, // 再申込中
    'END_CHARGE_SUBSCRIPTION'       => 92, // CHARGEプランサブスク終了
    'DRAFT'                         => 99, // 仮申込
    'DRAFT_CANCEL'                  => 98, // 申込キャンセル
]);

/**
 * 顧客ステータスリスト(key=>DB値,value=>論理値)
 *
 * @var array
 */
define('USER_STATUS_DISPLAY_NAME_LIST', [
    0 => '利用中',
    1 => '解約',
    2 => '停止中',
    3 => '強制解約',
    5 => '解約予約中',
    7 => '初期契約解除',
    8 => '初期契約解除予約中',
    99 =>'仮申込',
]);

/**
 * 申し込みステータス値リスト
 *
 * @var array
 */
define('ENTRY_STATUS_VALUE_LIST', [
    'NEW'             => 1, // 新規
    'JUDGING'         => 2, // 審査中
    'APPROVED'        => 3, // 承認済
    ''                => 4, // CSV出力済
    ''                => 5, // 発送済
    'REJECTION'       => 6, // 却下
    'WAITING_BILLING' => 7, // 決済情報入力待ち
    'ENTRY_ERROR'     => 9,  // 申込NG（課金エラー）
    'HAVE_DEVICE'     => 11, // 端末入手済み(新規購入)
    'USED_DEVICE'     => 12, // 端末入手済み(譲渡)
    'DRAFT'           => 99, // 仮申込
]);

/**
 * 申し込みステータス（新規）
 */
define('ENTRY_STATUS_ENTRY', 1);

/**
 * 申し込みステータス（審査中）
 */
define('ENTRY_STATUS_EXAMINATION', 2);

/**
 * 申し込みステータス（承認済み）
 */
define('ENTRY_STATUS_APPROVED', 3);

/**
 * 申し込みステータス（CSV出力済）
 */
define('ENTRY_STATUS_CSV_OUTPUT', 4);

/**
 * 申し込みステータス（発送済み）
 */
define('ENTRY_STATUS_DELIVERY', 5);

/**
 * 申し込みステータス（審査NG）
 */
define('ENTRY_STATUS_CANCEL', 6);

/**
 * 申し込みステータス（申込取消）
 */
define('ENTRY_STATUS_ENTRY_CANCEL', 7);

/**
 * 申し込みステータス（申込NG（課金エラー））
 */
define('ENTRY_STATUS_ENTRY_ERROR', 9);

/**
 * 申し込みステータス(入金待ち)
 */
define('ENTRY_STATUS_WAITING_PAYMENT', 10);

/**
 * 申し込みステータス(端末入手済み・新規購入)
 */
define('ENTRY_STATUS_HAVE_DEVICE', 11);

/**
 * 申し込みステータス(端末入手済み・譲渡)
 */
define('ENTRY_STATUS_USED_DEVICE', 12);

/**
 * 申し込みステータス（仮申込キャンセル）
 */
define('ENTRY_STATUS_DRAFT_CANCEL', 98);

/**
 * 申し込みステータス（仮申込）
 */
define('ENTRY_STATUS_DRAFT', 99);

/**
 * 仮申し込みステータスメール除外リスト
 *
 * @var array
 */
define('ENTRY_STATUS_EXCLUDE_LIST', [
    ENTRY_STATUS_DRAFT,
    ENTRY_STATUS_DRAFT_CANCEL,
]);


/**
 * 保険オプション加入判定用 判定対象申し込みステータスリスト
 */
define('INSURANCE_OPTION_JADGE_TARGET_ENTRY_STATUS_LIST', [
    ENTRY_STATUS_ENTRY,
    ENTRY_STATUS_EXAMINATION,
    ENTRY_STATUS_APPROVED,
    ENTRY_STATUS_CSV_OUTPUT,
    ENTRY_STATUS_DELIVERY,
]);

/**
 * 顧客区分（個人）
 */
define('USER_TYPE_PERSON', 0);

/**
 * 顧客区分（法人）
 */
define('USER_TYPE_CORPORATE', 1);

/**
 * ユーザー区分
 *
 * @var array
 */
define('USER_TYPE_LIST', [
    'PRIVATE'   => USER_TYPE_PERSON,   // 個人
    'CORPORATE' => USER_TYPE_CORPORATE // 法人
]);

/**
 * 希望連絡時間
 */
define('CONTACT_TIME_NO', 1);
define('CONTACT_TIME_10_12', 2);
define('CONTACT_TIME_12_15', 3);
define('CONTACT_TIME_15_1830', 4);
define('CONTACT_TIME_LIST',[
    CONTACT_TIME_NO => '指定なし',
    CONTACT_TIME_10_12 => '10:00-12:00',
    CONTACT_TIME_12_15 => '12:00-15:00',
    CONTACT_TIME_15_1830 => '15:00-18:30',
]);

/**
 * 支払い期限
 */
define('PAYMENT_DUE_DATE_TYPE_THIS_MONTH', 0);
define('PAYMENT_DUE_DATE_TYPE_PLUS_1_MONTH', 1);
define('PAYMENT_DUE_DATE_TYPE_PLUS_2_MONTH', 2);
define('PAYMENT_DUE_DATE_TYPE_LIST', [
    PAYMENT_DUE_DATE_TYPE_THIS_MONTH => '当月末払い',
    PAYMENT_DUE_DATE_TYPE_PLUS_1_MONTH => '翌月末払い',
]);

/**
 * 請求書送付方法
 */
define("SEND_TYPE_EMAIL", 0);
define("SEND_TYPE_POST_MAIL", 1);
define('SEND_TYPE_LIST', [
    SEND_TYPE_EMAIL     => 'メール',
    SEND_TYPE_POST_MAIL => '郵送',
]);

/**
 * セット販売名
 *
 * @var array
 */
define('EXTERNAL_SERVICE_SET_NAME_LIST', [
    'sbhikari', // SB Hikari

]);

/**
 * セット販売名 MST
 *
 * @var array
 */
define('EXTERNAL_SERVICE_SET_ID_LIST', [
    'sbhikari' => 1, // SB Hikari

]);

/**
 * セット販売名申し込みタイプ
 *
 * @var array
 */
define('EXTERNAL_SERVICE_ENTRY_TYPE', [
    'NEW' => 1, //新規
    'EXISTING' => 2, //既存

]);
/**
 * セット販売名申し込みタイプ新規
 *
 * @var int
 */
define('EXTERNAL_SERVICE_ENTRY_TYPE_NEW', 1);


/**
 * 光回線キャンペーンID
 *
 * @var int
 */
define('EXTERNAL_SERVICE_SET_ID_HIKARI_CAMPAIGN', 1);

/**
 * Twitter特別キャンペーンID（新規ユーザー用）
 *
 * @var int
 */
define('EXTERNAL_SERVICE_SET_ID_TWITTER_CAMPAIGN_NEW', 2);

/**
 * Twitter特別キャンペーンID（既存ユーザー用）
 *
 * @var int
 */
define('EXTERNAL_SERVICE_SET_ID_TWITTER_CAMPAIGN_EXISTING', 3);

/**
 * 海外レンタル端末送料無料キャンペーンID
 *
 * @var int
 */
define('CAMPAIGN_ID_OVERSEA_RENTAL_FREE_SHIPPIG', 100);

/**
 * 海外レンタル返却パック無料キャンペーンID
 *
 * @var int
 */
define('CAMPAIGN_ID_OVERSEA_RETURN_PACK_FREE', 108);

/**
 * 海外レンタル通訳オプション無料キャンペーンID
 *
 * @var int
 */
define('CAMPAIGN_ID_OVERSEA_INTERPRETER_FREE', 109);

/**
 * キャンペーンモード（個人ユーザー用）
 * TODO:LIMITED_URL_CAMPAIGN_GROUP_TWITTERやEXTERNAL_SERVICE_ENTRY_TYPE_EXISTINGと使い方が似ているのでは?確認必要
 * @var int
 */
define('PERSONAL_CAMPAIGN_MODE', [
    'normal' => 1,
    'croad'  => 2,
    'hikari' => 3,
    'twitter'=> 4,
]);

/**
 * Twitter特別キャンペーン・URL管理用
 *
 * @var int
 */
define('LIMITED_URL_CAMPAIGN_GROUP_TWITTER', 1);

/**
 * セット販売名申し込みタイプ既存
 *
 * @var int
 */
define('EXTERNAL_SERVICE_ENTRY_TYPE_EXISTING', 2);

/**
 * GMO登録ステータス
 *
 * @var array
 */
define('GMO_STATUS_LIST', [
    'SUCCESS'    => 9, // 登録済
    'PROCESSING' => 1 // 処理中
]);

/**
 * GMOAPIで決済コールする際の処理区分:CANCEL
 * CANCEL：キャンセルを設定すると自動的に下記3つのいずれかに変換される
 * ・VOID：取消
 * ・RETURN：返品
 * ・RETURNX：月跨り返品
 * @var string
 */
define('GMO_JOBCD_CANCEL', 'CANCEL');

/**
 * GMOこんど払い与信結果ステータス
 * @var array
 */
define('GMO_CONDO_TRAN_RESULT_LIST', [
    'SUCCESS'    => 'OK', // 登録済
    'FAIL'    => 'NG' // 登録済
]);

/**
 * GMOこんど払いエンドユーザーの認証結果ステータス
 *
 * @var array
 */
define('GMO_CONDO_AUTH_RESULT_LIST', [
    'SUCCESS'    => 'DONE', // 認証済み
    'FAIL'    => 'FAIL' // 認証失敗
]);

/**
 * 性別値リスト
 *
 * @var array
 */
define('SEX_VALUE_LIST', [
    'MALE'   => 0, // 男性
    'FEMALE' => 1 // 女性
]);

/**
 * 性別文言リスト
 *
 * @var array
 */
define('SEX_LABEL_LIST', [
    SEX_VALUE_LIST['MALE']   => '男性',
    SEX_VALUE_LIST['FEMALE'] => '女性',
]);

/**
 * atone用性別値リスト
 *
 * @var array
 */
define('SEX_VALUE_LIST_FOR_ATONE', [
    SEX_VALUE_LIST['MALE']   => 1, // 男性
    SEX_VALUE_LIST['FEMALE'] => 2  // 女性
]);

/**
 * atoneの支払いタイプ：サブスクプラン
 *
 * @var int
 */
define('ATONE_SERVICE_TYPE_SUBSCRIPTION', 1);

/**
 * atoneの支払いタイプ：プリペイドプラン
 *
 * @var int
 */
define('ATONE_SERVICE_TYPE_PREPAID', 2);

/**
 * 決済種別値リスト
 *
 * @var array
 */
define('SETTLEMENT_TYPE_VALUE_LIST', [
    'CREDIT_CARD'   => 1,  // クレジットカード
    // フェーズ1では対象外
    // 'ACCOUNT_ONLINE' => 2, // 口座振替（オンライン申込）
    'INVOICE'       => 3,  // 請求書払い
    'CONDO_PAY'     => 4,  // こんど払い
    'ATONE'         => 5,  // atone 翌月払い（コンビニ/口座振替）
    'ACCOUNT_SBS'   => 6,  // 口座振替（SBS）
    'BANK_TRANSFER' => 7,  // 銀行振込（一括前払いプラン）
    'ATOBARAI'      => 10, // 振込あと払い
    'MAEBARAI'      => 11, // 銀行振込（前払い）
    'PAYSYS'        => 12, // Paysys
    'PAIDY'         => 13, // あと払い（ペイディ）
]);

/**
 * 決済種別文言リスト
 *
 * @var array
 */
define('SETTLEMENT_TYPE_LABEL_LIST', [
    SETTLEMENT_TYPE_VALUE_LIST['CREDIT_CARD']   => 'クレジットカード',
    // フェーズ1では対象外
    // SETTLEMENT_TYPE_VALUE_LIST['ACCOUNT_ONLINE'] => '口座振替（オンライン申込）',
    SETTLEMENT_TYPE_VALUE_LIST['INVOICE']       => '請求書払い',
    SETTLEMENT_TYPE_VALUE_LIST['CONDO_PAY']     => 'コンビニ後払い',
    SETTLEMENT_TYPE_VALUE_LIST['ATONE']         => 'atone 翌月払い（コンビニ/口座振替）',
    SETTLEMENT_TYPE_VALUE_LIST['ACCOUNT_SBS']   => '口座振替（SBS）',
    SETTLEMENT_TYPE_VALUE_LIST['BANK_TRANSFER'] => '銀行振込',
    SETTLEMENT_TYPE_VALUE_LIST['ATOBARAI']      => '振込あと払い',
    SETTLEMENT_TYPE_VALUE_LIST['MAEBARAI']      => '銀行振込（前払い）',
    SETTLEMENT_TYPE_VALUE_LIST['PAYSYS']        => 'Paysys',
    SETTLEMENT_TYPE_VALUE_LIST['PAIDY']         => 'あと払い（ペイディ）',
]);

/**
 * 支払方法：クレジットカード
 *
 * @var int
 */
define('SETTLEMENT_TYPE_CREDIT_CARD', 1);

/**
 * 支払方法：口座振替
 *
 * @var int
 */
define('SETTLEMENT_TYPE_DIRECT_DEBIT', 2);

/**
 * 支払方法：請求書払い
 *
 * @var int
 */
define('SETTLEMENT_TYPE_BILL', 3);

/**
 * 支払方法：こんど払い
 *
 * @var int
 */
define('SETTLEMENT_TYPE_CONDO_PAY', 4);

/**
 * 支払方法：atone後払い
 *
 * @var int
 */
define('SETTLEMENT_TYPE_ATONE', 5);

/**
 * 支払方法：SBS口座振替
 *
 * @var int
 */
define('SETTLEMENT_TYPE_SBS_DIRECTDEBIT', 6);


/**
 * 支払方法：銀行振込
 *
 * @var int
 */
define('SETTLEMENT_TYPE_BANK_TRANSFER', 7);

/**
 * 支払方法：振込あと払い
 *
 * @var int
 */
define('SETTLEMENT_TYPE_ATOBARAI', 10);

/**
 * 支払方法：銀行振込（前払い）
 *
 * @var int
 */
define('SETTLEMENT_TYPE_MAEBARAI', 11);

/**
 * 支払方法：Paysys
 *
 * @var int
 */
define('SETTLEMENT_TYPE_PAYSYS', 12);

/**
 * 支払方法：あと払い（ペイディ）
 *
 * @var int
 */
define('SETTLEMENT_TYPE_PAIDY', 13);

/**
 * 連絡先種別値リスト
 *
 * @var array
 */
define('CONTACT_TYPE_VALUE_LIST', [
    'CONTRACTOR' => 0, // 契約者連絡先
    'USER'       => 1, // 利用者連絡先
    'BILLING'    => 2 // 請求先連絡先
]);

/**
 * 課金区分値リスト
 *
 * @var array
 */
define('BILLING‗TYPE_VALUE_LIST', [ // TODO：BILLING_TYPE_VALUE_LIST に直す
    'MONTHLY'   => 0, // 月額課金
    'EACH_TIME' => 1, // 都度課金
    'PREPAID'   => 4, // 月額料金(CHARGEプランサブスク)
]);

/**
 * 税区分値リスト
 *
 * @var array
 */
define('TAX_TYPE_VALUE_LIST', [
    'NOT_INCLUDED' => 1, // 税別
    'EXEMPT'       => 2, // 非課税
    'INCLUDED'     => 3 // 税込
]);

/**
 * 税区分文言リスト
 *
 * @var array
 */
define('TAX_TYPE_LABEL_LIST', [
    TAX_TYPE_VALUE_LIST['NOT_INCLUDED'] => '税別',
    TAX_TYPE_VALUE_LIST['EXEMPT']       => '非課税',
    TAX_TYPE_VALUE_LIST['INCLUDED']     => '税込',
]);

/**
 * 税区分文言リスト
 *
 * @var array
 */
define('TAX_TYPE_VIEW_LABEL_LIST', [
    TAX_TYPE_VALUE_LIST['NOT_INCLUDED'] => '税抜',
    TAX_TYPE_VALUE_LIST['EXEMPT']       => '免税',
]);

/**
 * オプション区分
 *
 * @var int
 */
define('OPTION_TYPE_INTANGIBLE', 1);    // 無形商品
define('OPTION_TYPE_TANGIBLE', 2);      // 有形商品
define('OPTION_TYPE_RENTAL', 3);        // レンタルオプション
define('OPTION_TYPE_INSURANCE', 4);     // 保険オプション
define('OPTION_TYPE_TANGIBLE_OVERSEA', 5);  // 有形商品（海外）

/**
 * オプション(無形商品)区分値リスト
 *
 * @var array
 */
define('OPTION_TYPE_VALUE_LIST', [
    'PLAN'   => 0,  // プランオプション
    'DEVICE' => 1,  // 端末オプション
    'RENTAL' => 3,  // レンタルオプション
]);

/**
 * 請求ステータスリスト
 *
 * @var array
 */
define('INVOICE_STATUS_VALUE_LIST', [
    'BILL_BEF'          => 1,  // 請求予定
    'BILLING'           => 2,  // 請求中
    'WAITING_PAYMENT'   => 12, // 入金待ち
    'BILL_COMP'         => 3,  // 請求済み
    'BILL_FAIL'         => 4,  // 請求失敗
    'CANCEL'            => 5,  // 請求キャンセル中
    'CANCEL_COMP'       => 6,  // 請求キャンセル済み
    'CANCEL_FAIL'       => 7,  // 請求キャンセル失敗
    'RECHARGE'          => 8,  // 再請求予定
    'BILL_FAIL_ENTRY'   => 9,  // 申込時請求失敗
    'WAITING_BILL'      => 10, // 請求書発行待ち
    'CHARGEBACK'        => 11, //チャージバック
    'WAITING_REFUND'    => 13, //返金待ち
    'BILL_SKIPPED'      => 98, // 請求書->クレカに変更した時点に前の請求をスキップする
    'BILL_EXCLUDED'     => 99, // 請求除外
]);

/**
 * 請求ステータス文言リスト
 *
 * @var array
 */
define('INVOICE_STATUS_LABEL_LIST', [
    INVOICE_STATUS_VALUE_LIST['BILL_BEF']           => '請求予定',
    INVOICE_STATUS_VALUE_LIST['BILLING']            => '請求中',
    INVOICE_STATUS_VALUE_LIST['BILL_COMP']          => '請求済み',
    INVOICE_STATUS_VALUE_LIST['BILL_FAIL']          => '請求失敗',
    INVOICE_STATUS_VALUE_LIST['CANCEL']             => '請求キャンセル中',
    INVOICE_STATUS_VALUE_LIST['CANCEL_COMP']        => '請求キャンセル済み',
    INVOICE_STATUS_VALUE_LIST['CANCEL_FAIL']        => '請求キャンセル失敗',
    INVOICE_STATUS_VALUE_LIST['RECHARGE']           => '請求失敗のため再請求予定',
    INVOICE_STATUS_VALUE_LIST['BILL_FAIL_ENTRY']    => '申込時請求失敗',
    INVOICE_STATUS_VALUE_LIST['WAITING_PAYMENT']    => '入金待ち',
    INVOICE_STATUS_VALUE_LIST['WAITING_BILL']       => '請求書発行待ち',
    INVOICE_STATUS_VALUE_LIST['CHARGEBACK']         => '請求済み', //チャージバックは請求済みに表示される
    INVOICE_STATUS_VALUE_LIST['WAITING_REFUND']     => '返金待ち',
    INVOICE_STATUS_VALUE_LIST['BILL_SKIPPED']       => '請求予定',
    INVOICE_STATUS_VALUE_LIST['BILL_EXCLUDED']      => '請求除外',
]);

define('INVOICE_STATUS_NOT_SHOW_LABEL_LIST', [
    INVOICE_STATUS_VALUE_LIST['CANCEL_COMP']        => '請求キャンセル済み',
]);

/**
 * 請求ステータスのうち、未納と判定されるリスト
 * @var unknown
 */
define('INVOICE_STATUS_UNPAID_LIST', [
    INVOICE_STATUS_VALUE_LIST['BILL_BEF'],
    INVOICE_STATUS_VALUE_LIST['BILLING']
]);

/**
 * 請求区分
 *
 * @var array
 */
define('INVOICE_TYPE_LIST', [
    'PLAN'         => 1, // プラン
    'OPTION'       => 2, // オプション
    'FIX'          => 3, // 調整金
    'INIT'         => 4, // 初期費用
    'CHARGE'       => 5, // チャージ
    'OVERSEAS'     => 6, // 海外プラン
    'DEVICE_PRICE' => 7, // 端末代金
    'DEVICE_LOAN'  => 8 //端末残債
]);
/**
 * 請求区分名
 *
 * @var array
 */
define('INVOICE_TYPE_NAME_LIST', [
    1 => 'プラン',
    2 => 'オプション',
    3 => '調整金',
    4 => '初期費用',
    5 => 'チャージ',
    6 => '海外プラン',
    7 => '端末代金',
    8 => '端末残債',
]);

/**
 * プランの請求区分リスト
 *
 * @var array
 */
define('PLAN_INVOICE_TYPE_LIST', [
    'PLAN'     => 1, // プラン
    'CHARGE'   => 5, // チャージ
    'OVERSEAS' => 6, // 海外プラン
]);

/**
 * 請求区分: プラン
 * @var integer
 */
define('INVOICE_TYPE_PLAN', 1);

/**
 * 請求区分: オプション
 *
 * @var integer
 */
define('INVOICE_TYPE_OPTION', 2);

/**
 * 請求区分: 調整金
 *
 * @var integer
 */
define('INVOICE_TYPE_FIX', 3);

/**
 * 請求区分：端末初期費用
 *
 * @var int
 */
define('INVOICE_TYPE_DEVICE_INIT', 4);

/**
 * 請求区分: データチャージ
 *
 * @var integer
 */
define('INVOICE_TYPE_DATACHARGE', 5);

/**
 * 請求区分: 海外プラン
 *
 * @var integer
 */
define('INVOICE_TYPE_OVERSEAS_PLAN', 6);

/**
 * 請求区分：端末代金
 * @var int
 */
define('INVOICE_TYPE_DEVICE_PRICE', 7);

/**
 * 請求区分：端末残債
 * @var int
 */
define('INVOICE_TYPE_DEVICE_LOAN', 8);

/**
 * 端末料金の請求区分リスト
 *
 * @var array
 */
define('INVOICE_TYPE_DEVICE_FEE_LIST', [
    'DEVICE_PLAN'   => INVOICE_TYPE_DEVICE_PRICE, // 端末料金
    'DEVICE_LOAN' => INVOICE_TYPE_DEVICE_LOAN, // 端末残
]);

/**
 * 処理区分リスト
 *
 * @var array
 */
define('GMO_JOB_CODE_LIST', [
    'CHECK'   => 'CHECK', // 有効性チェック
    'CAPTURE' => 'CAPTURE', // 即時売り上げ
    'AUTH'    => 'AUTH', // 仮売り上げ
    'SAUTH'   => 'SAUTH' // 簡易オーソリ
]);

/**
 * 請求書出力時にグルーピングを行わない請求区分
 * @var array
 */
define('BILL_NO_GROUPING_INVOICE_TYPE',[
    INVOICE_TYPE_LIST['CHARGE'], INVOICE_TYPE_LIST['OVERSEAS']
]);

/**
 * 税区分:  税別
 *
 * @var integer
 */
define('TAX_TYPE_EXCLUDE', 1);

/**
 * 税区分: 非課税
 *
 * @var integer
 */
define('TAX_TYPE_EXEMPT', 2);

/**
 * 税区分: 税込
 *
 * @var integer
 */
define('TAX_TYPE_INCLUDE', 3);

/**
 * 調整金タイプ : 支払い過不足金
 */
define('ADJUSTMENT_MONEY_TYPE_PAYMENT_NO_FIT', 5);

/**
 * こんど払い / atone 各請求商品名のprefix
 */
define('ITEM_PREFIX_LIST' , [
    DEVICE_TYPE_CLOUD => 'ZEUS WiFi',
    DEVICE_TYPE_WIMAX => 'ZEUS WiMAX',
]);

//請求書に担当者名入れない
define('PERSON_IN_CHARGE_FLAG_OFF', 0);

//請求書に担当者名入れる
define('PERSON_IN_CHARGE_FLAG_ON', 1);

/**
 * 請求書確定ステータス: 下書き
 *
 * @var integer
 */
define('BILL_FIXED_STATUS_DRAFT', 0);

/**
 * 請求書確定ステータス: 確定
 *
 * @var integer
 */
define('BILL_FIXED_STATUS_FIXED', 1);

/**
 * 請求書発行ステータス: 未発行
 *
 * @var integer
 */
define('BILL_ISSUE_STATUS_UNISSUE', 0);

/**
 * 請求書発行ステータス: 発行済み
 *
 * @var integer
 */
define('BILL_ISSUE_STATUS_ISSUED', 1);

/**
 * 請求書発行ステータス: 取消
 *
 * @var integer
 */
define('BILL_ISSUE_STATUS_CANCEL', 9);

/**
 * 請求書ステータス: 準備中
 *
 * @var integer
 */
define('BILL_STATUS_PREPARE', 0);

/**
 * 請求書ステータス: 送付待ち
 *
 * @var integer
 */
define('BILL_STATUS_UNSENT', 1);

/**
 * 請求書ステータス: 送付済み
 *
 * @var integer
 */
define('BILL_STATUS_SENT', 2);

/**
 * 請求書ステータス: 入金待ち
 *
 * @var integer
 */
define('BILL_STATUS_UNPAID', 3);

/**
 * 請求書ステータス: 入金済み
 *
 * @var integer
 */
define('BILL_STATUS_PAID', 4);

/**
 * 請求書ステータス: メール送信済み
 *
 * @var integer
 */
define('BILL_STATUS_COMPLETE_MAIL_SENT', 6);

/**
 * 請求書ステータス: ダウンロード済み
 *
 * @var integer
 */
define('BILL_STATUS_COMPLETE_DL', 7);

/**
 * 請求書ステータス: 送信・DL済み
 *
 * @var integer
 */
define('BILL_STATUS_COMPLETE_MAIL_SENT_AND_DL', 8);

/**
 * マイページでダウンロード可能な請求書ステータス
 *
 * @var array
 */
define('SHOW_BILL_STATSU_LIST', [
    BILL_STATUS_UNPAID,
    BILL_STATUS_COMPLETE_MAIL_SENT,
    BILL_STATUS_COMPLETE_MAIL_SENT_AND_DL,
]);

/**
 * 請求書タイプ：請求書(デフォルト)
 */
define('BILL_TYPE_INVOICE', 1);

/**
 * 請求書タイプ：振込あと払い
 */
define('BILL_TYPE_ATOBARAI', 2);

/**
 * 請求書タイプ：銀行振込(前払い)
 */
define('BILL_TYPE_MAEBARAI', 3);

/**
 * 請求書タイプ：Paysys
 *
 * @var int
 */
define('BILL_TYPE_PAYSYS', 4);

/**
 * Paysys支払いステータス 未入金
 * @var int
 */
define('PAYSYS_PAYMENT_STATUS_NOT_PAYMENT', 1);

/**
 * Paysys支払いステータス 入金済み
 * @var int
 */
define('PAYSYS_PAYMENT_STATUS_DEPOSITED', 2);

/**
 * 支払い方法リスト
 *
 * @var array
 */
define('GMO_METHOD_LIST', [
    'FULL'                          => '1', // 一括
    'INSTALLMENTS'                  => '2', // 分割
    'BONUS_FULL'                    => '3', // ボーナス一括
    'GMO_METHOD_BONUS_INSTALLMENTS' => '4', // ボーナス分割
    'GMO_METHOD_REVOLVING'          => '5' // リボ
]);

/**
 * クレカ決済ステータスリスト
 *
 * @var array
 */
define('GMO_CREDIT_CARD_STATUS_LIST', [
    'UNPROCESSED'   => 'UNPROCESSED', // 未決済
    'AUTHENTICATED' => 'AUTHENTICATED', // 未決済(3DS 登録済)
    'CHECK'         => 'CHECK', // 有効性チェック
    'CAPTURE'       => 'CAPTURE', // 即時売り上げ
    'AUTH'          => 'AUTH', // 仮売り上げ
    'SALES'         => 'SALES', // 実売り上げ
    'VOID'          => 'VOID', // 取消
    'RETURN'        => 'RETURN', // 返品
    'RETURNX'       => 'RETURNX', // 月跨り返品
    'SAUTH'         => 'SAUTH' // 簡易オーソリ
]);

/**
 * クレカ決済ステータスリスト
 *
 * @var array
 */
define('GMO_DIRECT_DEBIT_STATUS_LIST', [
    'UNPROCESSED' => 'UNPROCESSED', // 未決済
    'REQSUCCESS'  => 'REQSUCCESS', // 請求登録済み
    'CANCEL'      => 'CANCEL', // 取消済み
    'SEND'        => 'SEND', // 請求依頼済み
    'PAYSUCCESS'  => 'PAYSUCCESS', // 請求成功
    'PAYFAIL'     => 'PAYFAIL' // 請求失敗
]);

/**
 * こんど払いステータスリスト
 *
 * @var array
 */
define('GMO_CONDO_PAY_STATUS_LIST', [
    'ENTRY'                => 'ENTRY',                // 与信前
    'AUTHORI_UNCOMMITTED'  => 'AUTHORI_UNCOMMITTED',  // 与信OKで加盟店通知前
    'AUTHORIZED'           => 'AUTHORIZED',           // 売上確定待ち
    'CAPTURED'             => 'CAPTURED',             // 売上確定した
    'FAIL'                 => 'FAIL',                 // 与信NGとなった
    'CANCEL'               => 'CANCEL',               // キャンセルされた
    'ERROR'                => 'ERROR',                // 加盟店通知に失敗した
    'BILL_CANCEL'          => 'BILL_CANCEL',          // 請求確定後にキャンセルされた
]);

/**
 * こんど払い CANCEL コマンド
 * @var string
 */
define('GMO_CONDO_PAY_COMMAND_CANCEL','CANCEL'); // キャンセル

/**
 * マイページアクセス不可ディレクトリ
 * @var string
 */
define('INACCESSIBLE_MYPAGE_DATA_FLOW' , 'data-flow');
define('INACCESSIBLE_MYPAGE_PAYMENT_HISTORY' , 'payment-history');
define('INACCESSIBLE_MYPAGE_CONTACT' , 'contact');
define('INACCESSIBLE_MYPAGE_USER' , 'user');
define('INACCESSIBLE_MYPAGE_OVERSEAS' , 'overseas');
define('INACCESSIBLE_MYPAGE_SUPPORT' , 'support');
define('INACCESSIBLE_MYPAGE_DATA_CHARGE' , 'data-charge');

/**
 * 表示ヘッダーメニューリスト
 */
define('DEFAULT_DISPLAY_HEADER_MENU', [
    INACCESSIBLE_MYPAGE_DATA_FLOW,       // データ使用料・データチャージ
    INACCESSIBLE_MYPAGE_PAYMENT_HISTORY, // ご利用明細
    INACCESSIBLE_MYPAGE_CONTACT,         // ご契約情報
    INACCESSIBLE_MYPAGE_USER,            // お客様情報
    INACCESSIBLE_MYPAGE_OVERSEAS,        // 海外データプラン
    INACCESSIBLE_MYPAGE_SUPPORT,         // サポート
]);

/**
 * change_email
 * @var int
 */
define('USER_CONTACT_INFO_REGISTERED_ENTRY_CORPB_EDITING_EMAIL', 1);
/**
 * APIリクエスト数が上限を超えたときのエラー詳細コード
 *
 * @var string[]
 */
define('GMO_USAGE_LIMIT_ERR_INFO_LIST', [
    'E92000001',
    'E92000002',
]);

/**
 * 海外レンタルプラン変更種別:追加
 */
define('INTERNATIONAL_RENTAL_CHANGE_HISTORY_ADD', 1);

/**
 * 海外レンタルプラン変更種別:延長
 */
define('INTERNATIONAL_RENTAL_CHANGE_HISTORY_EXTENSION', 2);

/**
 * 海外レンタルプラン変更種別:変更
 */
define('INTERNATIONAL_RENTAL_CHANGE_HISTORY_CHANGE', 3);

/**
 * 海外レンタルプラン変更種別:追加、延長
 */
define('INTERNATIONAL_RENTAL_CHANGE_HISTORY_ADD_EXTENSION', 4);

/**
 * CHARGE国内プラン(プリペイド)変更種別:追加
 */
define('INTERNATIONAL_PREPAID_CHANGE_HISTORY_ADD', 5);

/**
 * CHARGE国内プラン(プリペイド)変更種別:延長
 */
define('INTERNATIONAL_PREPAID_CHANGE_HISTORY_EXTENSION', 6);

/**
 * CHARGE国内プラン(プリペイド)変更種別:変更
 */
define('INTERNATIONAL_PREPAID_CHANGE_HISTORY_CHANGE', 7);

/**
 * 海外レンタルプラン変更ステータス:成功
 */
define('INTERNATIONAL_RENTAL_CHANGE_STATUS_SUCCESS', 1);

/**
 * 海外レンタルプラン変更ステータス:失敗
 */
define('INTERNATIONAL_RENTAL_CHANGE_STATUS_FAIL', 2);

// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
// お知らせ関連
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
/**
 * お知らせページ表示フラグリスト
 */
define('NEWS_IS_SHOWN_NEWS_PAGE_FLAG_LIST', [
    'FLAG_OFF' => '0', // 非公開
    'FLAG_ON'  => '1', // 公開中
]);

/**
 * TOPページ表示フラグリスト
 */
define('NEWS_IS_SHOWN_TOP_PAGE_FLAG_LIST', [
    'FLAG_OFF' => '0', // 非公開
    'FLAG_ON'  => '1', // 公開中
]);

/**
 * WIMAXページ表示フラグリスト
 */
define('NEWS_IS_SHOWN_WIMAX_PAGE_FLAG_LIST', [
    'FLAG_OFF' => '0', // 非公開
    'FLAG_ON'  => '1', // 公開中
]);

// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
// UCL設定値関連
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
/**
 * channelType
 *
 * @var array
 */
define('CHANNEL_TYPE_LIST', [
    'GRP' => 'GRP',
]);

/**
 * orderType
 *
 * @var array
 */
define('ORDER_TYPE', [
    'BUYPKG' => 'BUYPKG',
]);

/**
 * currencyType
 *
 * @var array
 */
define('CURRENCY_TYPE', [
    'JPN' => 'JPN',
    'EUN' => 'EUN',
]);

/**
 * payMethod
 *
 * @var array
 */
define('PAY_METHOD', [
    'ACCOUNT_AMOUNT' => 'ACCOUNT_AMOUNT',
]);

/**
 * アクセストークンの有効時間（単位: hour）
 *
 * @var integer
 */
define('UCL_ACCESS_TOKEN_EXPIRE_HOUR', 8);

/**
 * UCLレスポンスの正常コード
 *
 * @var int
 */
define('UCL_RESULT_CODE_SUCCESS', 00000000);

/**
 * UCLAPI 結果コード(アカウントが既に存在します)
 *
 * @var string
 */
define('UCL_RESULT_CODE_HAS_EXIST', '01020040');

/**
 * StopSubUser OperateType(stop)
 *
 * @var string
 */
define('UCL_USER_OPERATE_TYPE_STOP', '0');

/**
 * StopSubUser OperateType(start)
 *
 * @var string
 */
define('UCL_USER_OPERATE_TYPE_START', '1');

/**
 * UCLでのデータ使用状況：未使用(非アクティブ)
 * @var string
 */
define('UCL_DATA_STATSU_NOT_ACTIVATED', 'NOT_ACTIVATED');

/**
 * UCLでのデータ使用状況：使用中
 * @var string
 */
define('UCL_DATA_STATSU_IN_USING', 'IN_USING');

/**
 * UCLでのデータ使用状況：有効
 * @var string
 */
define('UCL_DATA_STATSU_VALID', 'VALID');

/**
 * UCLでのデータ使用状況：期限切れ
 * @var string
 */
define('UCL_DATA_STATSU_EXPIRE', 'EXPIRE');

/**
 * UCLでのデータ使用状況：使用終了
 * @var string
 */
define('UCL_DATA_STATSU_USE_END', 'USE_END');

/**
 * UCLでのデータ使用状況：移行
 * @var string
 */
define('UCL_DATA_STATSU_TRANSFER', 'TRANSFER');

/**
 * UCLでのデータ使用状況：登録解除
 * @var string
 */
define('UCL_DATA_STATSU_UNSUBSCRIBE', 'UNSUBSCRIBE');

/**
 * UCLでのデータ使用状況：解約
 * @var string
 */
define('UCL_DATA_STATSU_INVALID', 'INVALID');

/**
 * データチャージを監視するUCL上でのステータスリスト
 * @var array
 */
define('UCL_DATA_STATSU_NAME_LIST', [
    UCL_DATA_STATSU_NOT_ACTIVATED => '未使用',
    UCL_DATA_STATSU_IN_USING => 'ご利用中',
    UCL_DATA_STATSU_VALID => 'ご利用中',  // 有効だが利用中と同じにする
    UCL_DATA_STATSU_EXPIRE => '期限切れ',
    UCL_DATA_STATSU_USE_END => '使用終了',
    UCL_DATA_STATSU_TRANSFER => '移行',
    UCL_DATA_STATSU_UNSUBSCRIBE => '登録解除',
    UCL_DATA_STATSU_INVALID     => '解約',
]);

/**
 * アカウントタイプ：Gimmit
 * @var int
 */
define('UCL_ACCOUNT_TYPE_GIMMIT', 1);

/**
 * アカウントタイプMAYA
 * @var int
 */
define('UCL_ACCOUNT_TYPE_MAYA', 2);

/**
 * BatchCreateGroupChild registerType
 *
 * @var string
 */
define('UCL_USER_REGISTER_TYPE_EMAIL', 'EMAIL');

/**
 * UCL goods type PKAG(データチャージ系)
 *
 * @var string
 */
define('UCL_GOODS_TYPE_PKAG', 'PKAG');

/**
 * UCL goods type DISC(daily/monthlyリセット系※通常プランや海外プラン)
 *
 * @var string
 */
define('UCL_GOODS_TYPE_DISC', 'DISC');

/**
 * UCL goods type ALL
 *
 * @var string
 */
define('UCL_GOODS_TYPE_ALL', 'ALL');

// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
// 流入元サイト関連
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
/**
 * 流入元コード:LP
 *
 * @var string
 */
define('INFLOW_SOURCE_CODE_LP', 'lp');

/**
 * 流入元コード:サービス紹介サイト
 *
 * @var string
 */
define('INFLOW_SOURCE_CODE_SERVICE_INTRODUCTION', 'introduction');

/**
 * 流入元コードリスト
 *
 * @var string
 */
define('INFLOW_SOURCE_CODELIST', [
    INFLOW_SOURCE_CODE_LP,
    INFLOW_SOURCE_CODE_SERVICE_INTRODUCTION,
]);

/**
 * 流入元ソース 名称
 */
define('INFLOW_SOURCE_NAME_GMO', 'gmoaf');
define('INFLOW_SOURCE_NAME_HI_GMO', 'gmoaff[affiliate](HI)');
define('INFLOW_SOURCE_NAME_A8', 'a8'); //wiz a8
define('INFLOW_SOURCE_NAME_HI_A8', 'a8[affiliate](HI)'); //HI a8
define('INFLOW_SOURCE_NAME_HI_ASP', 'selfasp');
define('INFLOW_SOURCE_NAME_ADREX', 'adrex(HI)');
define('INFLOW_SOURCE_NAME_AFB', 'afb(HI)');
define('INFLOW_SOURCE_UNKNOWN_INFLOW_SOURCE_NAME', '不明');
define('INFLOW_SOURCE_NAME_DRAFT_HI', '仮申込(HI)');
define('INFLOW_SOURCE_TELEPHONE_INFLOW_SOURCE_NAME', '電話');
define('INFLOW_SOURCE_NAME_CHIBALOTTE', 'chibalotte');
define('INFLOW_SOURCE_NAME_PRESCO', 'PRESCO');
define('INFLOW_SOURCE_NAME_GMO_AF', 'gmo[AF]');
define('INFLOW_SOURCE_NAME_A8_AF', 'a8[AF]');
define('INFLOW_SOURCE_NAME_AFB_AF', 'afb[AF]');
define('INFLOW_SOURCE_NAME_BIZMOTION', 'Biz.motion');
define('INFLOW_SOURCE_NAME_ORGANIC', 'organic');

/**
 * promotion event campaign 名称
 */
define('VMA_2020_PROMOTION_EVENT_CODE', 'vma2020');
define('VMA_2020_PROMOTION_EVENT_ID', 1);

/**
 * 利用者情報値リスト
 *
 * @var array
 */
define('USER_INFO_VALUE_LIST', [
    'SAME' => 1,    // ご契約者様と同じ
    'DIFF' => 2,    // ご契約者様と違う
]);
/**
 * 配送先情報値リスト
 *
 * @var array
 */
define('DELIVERY_INFO_VALUE_LIST', [
    'SAME' => 1, // ご契約者様と同じ
    'DIFF' => 2  // ご契約者様と違う（またはご利用者様と同じ）
]);
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
// 調整金関連
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
/**
 * 調整金区分：違約金
 *
 * @var int
 */
define('ADJUSTMENT_TYPE_PENALTY', 1);

/**
 * 調整金区分：端末代金
 *
 * @var int
 */
define('ADJUSTMENT_TYPE_TERMINAL_PRICE', 2);

/**
 * 調整金区分：調整(割引)
 *
 * @var int
 */
define('ADJUSTMENT_TYPE_DISCOUNT', 3);

/**
 * 調整金区分：未納
 *
 * @var int
 */
define('ADJUSTMENT_TYPE_UNPAID', 4);

/**
 * 調整金区分：送料
 *
 * @var int
 */
define('ADJUSTMENT_TYPE_POSTAGE', 9);

/**
 * 調整金区分リスト(key=>コード値,value=>論理値)
 *
 * @var array
 */
define('ADJUSTMENT_TYPE_LIST', [
    ADJUSTMENT_TYPE_PENALTY        => '手数料',
    ADJUSTMENT_TYPE_TERMINAL_PRICE => '端末代金',
    ADJUSTMENT_TYPE_DISCOUNT       => '調整(割引)',
    ADJUSTMENT_TYPE_UNPAID         => '未納分',
    ADJUSTMENT_TYPE_POSTAGE        => '送料',
]);

/**
 * 解約事務手数料 ID
 */
define('ADJUSTMENT_MONEY_ID_CANCELLATION_FEE', 5);

/**
 * 調整金マスタID - こんど払い手数料
 */
define('ADJUSTMENT_MONEY_ID_CONDO_FEE', 29);

/**
 * 調整金マスタID - レンタル端末送料
 */
define('ADJUSTMENT_MONEY_ID_RENTAL_POSTAGE_OVERSEAS', '57');

/**
 * 調整金マスタID - 海外レンタル延滞金
 */
define('ADJUSTMENT_MONEY_ID_INTERNATIONAL_RENTAL_EXPIRE_FEE', 58);

/**
 * kintoneの法人案件管理の対応ステータスリスト
 *
 * @var array
 */
define('CORP_KINTONE_STATUS_LIST', [
    'INQUIRY'   => "未対応",
    'ENTRY'     => "申込書待ち",
]);

/**
 * kintoneの法人案件管理の確度リスト
 *
 * @var array
 */
define('CORP_KINTONE_ACCURACY_LIST', [
    'INQUIRY'   => "B",
    'ENTRY'     => "WEB受注",
]);

/**
 * kintoneの法人案件管理のプラン名リスト
 * ※ mst_planの情報とマッチングして見積書のリストでも使用しています。
 *
 * @var array
 */
define('CORP_KINTONE_PLAN_NAME_LIST', [
    PLAN_ID_1 => "フリー40GB",
    PLAN_ID_2 => "フリー100GB",
    PLAN_ID_329 => "フリー20GB",
    PLAN_ID_361 => "フリー30GB",
    PLAN_ID_362 => "フリー50GB",
    PLAN_ID_326 => "スタンダード40GB",
    PLAN_ID_327 => "スタンダード100GB",
    PLAN_ID_328 => "スタンダード20GB",
    PLAN_ID_363 => "スタンダード30GB",
    PLAN_ID_364 => "スタンダード50GB",
    PLAN_ID_365 => "スタンダード100GB(23/1/26から)",
]);

/**
 * kintoneの法人案件管理のオプション名リスト
 *
 * @var int
 */
define('CORP_KINTONE_OPTION_NAME_LIST', [
    OPTION_ID_CLOUD_1 => "端末あんしんオプション",
    OPTION_ID_WIMAX_1 => "端末あんしんオプション",
    OPTION_ID_WIMAX_ZEUS => "端末あんしんオプション",
    OPTION_ID_CLOUD_202302 => "端末あんしんオプション(23/1/26から)",
    OPTION_ID_WIMAX_1_NWC => "端末あんしんオプション(WiMAX23/12から)",
]);

/**
 * kintoneのwebhook notification type
 *
 * @var string
 */
define('KINTONE_NOTIFICATION_TYPE', "UPDATE_RECORD");

/**
 * kintoneの光セット申込リストのZEUS WiFi 契約タイプ
 *
 * @var array
 */
define('SBHIKARI_KINTONE_CONTRACT_TYPE', [
    'EXIST'   => "既存",
    'NEW'     => "新規",
]);

/**
 * kintoneの法人見積書リストの導入時期
 *
 * @var array
 */
define('ESTIMATE_KINTONE_APPLICATION_TIME', [
    '1'   => "今すぐ",
    '2'   => "1ヶ月以内",
    '3'   => "3ヶ月以内",
    '4'   => "未定",
]);

/**
 * キャンペーンタイプ:全て
 */
define('CAMPAIGN_TYPE_ALL', 0);
/**
 * キャンペーンタイプ:個人
 */
define('CAMPAIGN_TYPE_PERSONAL', 1);
/**
 * キャンペーンタイプ:法人
 */
define('CAMPAIGN_TYPE_COMPANY', 2);
/**
 * 申込み時期 : 法人
 */
define('APPLICATION_TIME_LIST',[
    'IMMEDIATELY'  => 1,
    'ONE_MONTH'    => 2,
    'THREE_MONTH'  => 3,
    'UNDECIDED'    => 4,
]);

// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
// 端末管理関連
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/

/**
 * 端末管理所在地リスト
 */
define('TERMINAL_LOCATION_SGW',  2);    // 佐川GL
define('TERMINAL_LOCATION_HI',   3);    // HI
define('TERMINAL_LOCATION_USER', 4);    // ユーザー
define('TERMINAL_LOCATION_SHOP', 14);   // 端末販売店(取扱い端末：MR1)
/**
 * 端末管理アクションリスト
 */
define('TERMINAL_ACTION_SHIPMENT',   1);  // 出荷
define('TERMINAL_ACTION_SWITCH',     7);  // 紐付け切替
define('TERMINAL_ACTION_CANCELAPP',  13); // 解約申請
define('TERMINAL_ACTION_RECEIVE',    4);  // 受取り

/**
 * 期契約解除申請
 */
define('TERMINAL_ACTION_CANCELINIT', 10); // 初期契約解除申請

/**
 * 端末管理ステータスリスト
 */
define('TERMINAL_STATUS_STOCK',      1);  // 在庫
define('TERMINAL_STATUS_SHIPPING',   3);  // 配送中
define('TERMINAL_STATUS_WAITRETURN', 6);  // 返却待ち
define('TERMINAL_STATUS_USING',      4);  // 利用中

/**
 * 端末管理：流入元
 */
define('INFLOW_SOURCE_ATTR_HI', 1);  // HI
define('INFLOW_SOURCE_ATTR_WIZ', 2); // Wiz

/**
 * 最大ファイルのアップロードサイズ
 */
define('MAXIMUM_FILE_UPLOAD_SIZE', 4194304);

/**
 * 契約解除理由のリスト
 *
 * @var array
 */
define('CANCEL_CONTRACT_REASON_LIST', [
    'weak_signal' => 1 , //電波が悪い
    'slow_speed' => 2, // 速度が遅い
    'not_connect' => 3, //繋がらない
    'high_price' => 4, //料金が高い
    'dissatisfied_with_support' => 5, //サポートが不満
    'other' => 6, //その他
]);

/**
 * 解約理由：解約ステータス
 */
define('CANCEL_TYPE_CANCEL', 1);  // 解約
define('CANCEL_TYPE_INITIAL_CANCEL', 2); // 初期契約解除

/**
 * 初期契約解除申請経由：経由
 */
define('INITIAL_CANCEL_FROM_CUSTOMER', 1);  // マイページ経由

/**
 * 仮申込エラーユーザーリスト
 */
define('DRAFT_ENTRY_ERROR_USER_ID_LIST', [
    "61076", "60885", "60894", "60954", "60996", "60992", "61004"
]);

/**
 * プラン変更処理状態
 * 10(申請)→30(ucl登録処理完了)→40(ucl無効化処理完了=変更処理完了)の順にステータスが変わる。39、49=失敗、99=キャンセル
 */
define('PLAN_CHANGE_APPLICATION', 10);                          // 申請
define('PLAN_CHANGE_UCL_REGISTRATION_PROCESS_COMPLETED', 30);   // ucl登録処理完了
define('PLAN_CHANGE_UCL_REGISTRATION_PROCESS_FAILED', 39);      // ucl登録処理失敗
define('PLAN_CHANGE_UCL_INVALIDATION_PROCESS_COMPLETED', 40);   // ucl無効化処理完了
define('PLAN_CHANGE_UCL_INVALIDATION_PROCESS_FAILED', 49);      // ucl無効化処理失敗
define('PLAN_CHANGE_CANCEL', 99);                               // キャンセル

define('PLAN_CHANGE_PROCESSING_STATUS_LIST', [
    PLAN_CHANGE_APPLICATION                         => '申請',
    PLAN_CHANGE_UCL_REGISTRATION_PROCESS_COMPLETED  => 'ucl登録処理完了',
    PLAN_CHANGE_UCL_REGISTRATION_PROCESS_FAILED     => 'ucl登録処理失敗',
    PLAN_CHANGE_UCL_INVALIDATION_PROCESS_COMPLETED  => 'ucl無効化処理完了',
    PLAN_CHANGE_UCL_INVALIDATION_PROCESS_FAILED     => 'ucl無効化処理失敗',
    PLAN_CHANGE_CANCEL                              => 'キャンセル'
]);

/**
 * プラン変更した側がどちらか(管理画面orマイページ)
 */
define('CHARGE_OPERATOR_SIDE_INTERNAL_MNG', 1); // 管理画面から操作
define('CHARGE_OPERATOR_SIDE_MY_PAGE', 2);      // マイページから操作

/**
 * プラン変更月末月初処理が全完了したか？
 */
define('PLAN_CHANGE_PROCESS_COMPLETE', 1);      // 処理全完了
define('PLAN_CHANGE_PROCESS_INCOMPLETE', 0);    // 処理未完了

/**
 * プラン変更・UCLにて次月用の新プラン購入を実行する時刻
 *　(次月プラン購入は、当月末日)
 * @var array
 */
define('PLAN_CHANGE_UCL_NEXT_PLAN_BUY_TIME', [
    'HOUR'      => 15,
    'MINUTE'    => 0,
    'SECOND'    => 0
]);

define('MOLL_ID_FORMAT', '%05d-%08d');          // モールIDフォーマット

/**
 * おかわりキャンペーン対象外
 */
define('CHARGE_CAMPAIGN_STATUS_NOT_APPLICABLE', 0);

/**
 * おかわりキャンペーン対象
 */
define('CHARGE_CAMPAIGN_STATUS_APPLICABLE', 1);

/**
 * おかわりキャンペーン(受け取り済み)
 */
define('CHARGE_CAMPAIGN_STATUS_FREE_EMPTY', 2);

/**
 * おかわりキャンペーン(未納)
 */
define('CHARGE_CAMPAIGN_STATUS_UNPAID', 3);

/**
 * 無料チャージのプランID(5G)
 */
define('FREE_CHARGE_CAMPAIGN_ID_5G',  334);
/**
 * 無料チャージのプランID(5G)
 */
define('FREE_CHARGE_CAMPAIGN_ID_10G', 335);

/**
 * 電話受付キャンペーンコード・キャンペーン名リスト
 * コードの編成　adjustment_money_id is_first_month_free (adjustment_money_id:0は調整金なしの意味)
 * 00：契約事務手数料無料・初月あり、01：契約事務手数料無料・初月無料、190：契約事務手数料あり・初月無料
 */
define('CALLCENTER_CAMPAIGN_LIST',[
    '00' => '',
    '01' =>'ZEUS WiFiご優待キャンペーン(契約事務手数料無料・月額基本料初月無料)',
    '190' => '',
]);

/**
 * 特殊な条件のあるキャンペーンのcampaign_id：WiMAXのキャッシュバックキャンペーン、オプション2ヶ月無料キャンペーン(新FUJI/新SBN乗り換え)
 */
define('SPECIAL_CONDITION_CAMPAIGN_ID_LIST_WIMAX_OPTION', [58,59,60,72]);

/**
 * 特殊な条件（申込確認メールの注釈表示）のあるキャンペーンのcampaign_id：WiMAXのオプション2ヶ月無料キャンペーン
 */
define('SPECIAL_CONDITION_CAMPAIGN_ID_LIST_WIMAX_OPTION_CAPTION', [
    58 => '（最大2ヶ月無料）（※2）',
    60 => '（最大2ヶ月無料）（※2）',
    64 => '（最大2ヶ月無料） ※3', // WiMAXのオプション2ヶ月無料キャンペーン(2022/6のクローズキャンペーン
    72 => '（最大2ヶ月無料） ※3',   // WiMAXのオプション2ヶ月無料キャンペーン 新FUJI・SBN乗り換え
]);

/**
 * 特殊な条件のあるキャンペーンのcampaign_id：WiMAXのキャッシュバックキャンペーン、オプション2ヶ月無料キャンペーン
 */
define('SPECIAL_CONDITION_CAMPAIGN_ID_LIST_WIMAX_OPTION_202206', [64]);

/**
 * オプション解約で解除されるキャンペーンIDリスト(オプション２か月無料キャンペーン)
 */
define('CANCEL_OPTION_CONDITION_REMOVE_CAMPAIGN_ID_LIST_WIMAX_OPTION', [58,60,72]);

/**
 * オプション解約で解除されるキャンペーンIDリスト(オプション２か月無料キャンペーン202206クローズキャンペーン分)
 */
define('CANCEL_OPTION_CONDITION_REMOVE_CAMPAIGN_ID_LIST_WIMAX_OPTION_202206', [64]);

/**
 * 特殊な条件のあるキャンペーンのcampaign_id：WiMAXのキャッシュバックキャンペーン、オプション2ヶ月無料キャンペーン(WiMAX販売NWCから入荷)
 */
define('SPECIAL_CONDITION_CAMPAIGN_ID_LIST_WIMAX_OPTION_NWC', [103,104,106]);

/**
 * オプション解約で解除されるキャンペーンIDリスト(オプション２か月無料キャンペーン)(WiMAX販売NWCから入荷)
 */
define('CANCEL_OPTION_CONDITION_REMOVE_CAMPAIGN_ID_LIST_WIMAX_OPTION_NWC', [103,106]);

/**
 *  端末あんしんオプションのoption_idリスト(マイページのオプション解約チェックで使用。それ以外で使用する場合は注意)
 */
define('TANMATSU_ANSHIN_OPTION_ID_LIST',[OPTION_ID_CLOUD_1, OPTION_ID_WIMAX_1, OPTION_ID_WIMAX_ZEUS, OPTION_ID_CLOUD_202302, OPTION_ID_WIMAX_1_NWC]);

/**
 * 編集アカウント情報ID
 */
define('EDIT_ACCOUNT_INFORMATION', 1);

/**
 * 編集支払い情報ID
 */
define('EDIT_PAYMENT_INFORMATION', 2);

/**
 * チェックボックスID
 */
define('PAYMENT_CORP_CHECKBOX', [
    'one' => 1 ,
    'two' => 2,
    'three' => 3,
    'four' => 4,
]);

/**
 * support@zeus-wifi.jp
 */
define('ZEUS_SUPPORT_MAIL_ADDRESS', 'support@zeus-wifi.jp');

// ↓WiMAX解約アンケート関連の定数
// TODO: ※納期の都合上、突貫工事にて定数に書き出したが、できれば将来的にマスタテーブルで管理するようにする
/**
 * 解約する理由：Wi-Fiが必要なくなった
 * クラウド、WiMAXともに同じ値
 */
define('CANCEL_SURVEY_REASON_UNNECESSARY_IDS', [
    SERVICE_TYPE_CLOUD => 7,
    SERVICE_TYPE_WIMAX => 7,
    SERVICE_TYPE_WIMAX_INITIAL => 67,
]);
/**
 * 解約する理由：その他
 * クラウド、WiMAXともに同じ値
 */
define('CANCEL_SURVEY_REASON_ETC_IDS', [
    SERVICE_TYPE_CLOUD => 10,
    SERVICE_TYPE_WIMAX => 10,
    SERVICE_TYPE_WIMAX_INITIAL => 70,
]);
/**
 * 乗り換え先：詳細回答不要
 */
define('SERVICE_CHANGE_NO_DETAIL_IDS', [
    SERVICE_TYPE_CLOUD => [16,17],
    SERVICE_TYPE_WIMAX => [16],
    SERVICE_TYPE_WIMAX_INITIAL => [76],
]);
/**
 * 乗り換え先：光・その他
 * クラウド、WiMAXともに同じ値
 */
define('SERVICE_CHANGE_HIKARI_ETC_IDS', [
    SERVICE_TYPE_CLOUD => 23,
    SERVICE_TYPE_WIMAX => 23,
    SERVICE_TYPE_WIMAX_INITIAL => 83,
]);
/**
 * 乗り換え先：据え置き型・その他
 */
define('SERVICE_CHANGE_STATIONARY_ETC_IDS', [
    SERVICE_TYPE_CLOUD => 36,
    SERVICE_TYPE_WIMAX => 38,
    SERVICE_TYPE_WIMAX_INITIAL => 98,
]);
/**
 * 乗り換え先：携帯/テザリング・その他
 */
define('SERVICE_CHANGE_TETHERING_ETC_IDS', [
    SERVICE_TYPE_CLOUD => 45,
    SERVICE_TYPE_WIMAX => 50,
    SERVICE_TYPE_WIMAX_INITIAL => 110,
]);
/**
 * 乗り換え先：ポケットWiFi・その他
 */
define('SERVICE_CHANGE_POCKET_ETC_IDS', [
    SERVICE_TYPE_CLOUD => 31,
    SERVICE_TYPE_WIMAX => 33,
    SERVICE_TYPE_WIMAX_INITIAL => 93,
]);
/**
 * 乗り換え先：SIM・その他
 */
define('SERVICE_CHANGE_SIM_ETC_IDS', [
    SERVICE_TYPE_CLOUD => 52,
    SERVICE_TYPE_WIMAX => 57,
    SERVICE_TYPE_WIMAX_INITIAL => 117,
]);
/**
 * 乗り換え先：ケーブルTV回線・その他
 */
define('SERVICE_CHANGE_CABLE_ETC_IDS', [
    SERVICE_TYPE_CLOUD => null,
    SERVICE_TYPE_WIMAX => 60,
    SERVICE_TYPE_WIMAX_INITIAL => 120,
]);
// ↑WiMAX解約アンケート関連の定数ここまで（将来マスタテーブルで管理）

/**
 * こんど払いで請求する請求区分リスト
 */
define('CONDO_INVOICE_TYPE_LIST' , [
    INVOICE_TYPE_PLAN           =>  INVOICE_TYPE_PLAN,
    INVOICE_TYPE_OPTION         =>  INVOICE_TYPE_OPTION,
    INVOICE_TYPE_DEVICE_PRICE   =>  INVOICE_TYPE_DEVICE_PRICE,
    INVOICE_TYPE_DEVICE_LOAN    =>  INVOICE_TYPE_DEVICE_LOAN
]);

/**
 * 3年しばりの利用期間別の解約違約金のリスト
 * {利用期間} => {adjustment_money_id}, ...
 */
define('ADJUSTMENT_MONEY_ID_CANCELLATION_FEE_LIST_3YEARS', [
    12 => 30,   // ～12ヶ月
    24 => 31,   // ～24ヶ月
    36 => 32,   // ～36ヶ月
]);

/**
 * 3年しばりの利用期間別の解約違約金のリスト（新基準）
 * {利用期間} => {adjustment_money_id}, ...
 */
define('ADJUSTMENT_MONEY_ID_CANCELLATION_FEE_LIST_3YEARS_NEW', [
    12 => 36,   // ～12ヶ月
    24 => 36,   // ～24ヶ月
    36 => 36,   // ～36ヶ月
]);

/**
 * 3年しばり対象プランリスト
 * {plan_id} => [{contract_duration_month} => {adjustment_money_id}, ...], {plan_id} => ...
 */
define('REL_PLAN_MONTH_MST_ADJUSTMENT_MONEY_LIST', [
    PLAN_ID_345 => ADJUSTMENT_MONEY_ID_CANCELLATION_FEE_LIST_3YEARS,                    // WiMAX専用プラン（契約期間3年）
    PLAN_ID_CLOSED_WIMAX_202206 => ADJUSTMENT_MONEY_ID_CANCELLATION_FEE_LIST_3YEARS,    // WiMAX専用プラン（契約期間3年）
    PLAN_ID_349 => ADJUSTMENT_MONEY_ID_CANCELLATION_FEE_LIST_3YEARS_NEW,                // WiMAXFUJI・SBN乗り換え専用プラン（契約期間3年）
]);

/**
 * FRONT側のWIMAX_IDに紐づくdevice_id
 * device_id => FRONTで割り当てられているID
 */
define('FRONT_WIMAX_DEVICE_ID_LIST' , [
    21 => 2,    // Speed Wi-Fi HOME 5G L12
    22 => 3,    // Speed Wi-Fi 5G X11
    23 => 4,    // Speed Wi-Fi HOME 5G L11
    24 => 5,    // Galaxy 5G Mobile Wi-Fi
    29 => 2,
    30 => 3,
    31 => 4,
    32 => 5,
    33 => 3,
    34 => 3,
    35 => 3,
    43 => 6,    // Speed Wi-Fi HOME 5G L13
    44 => 6,
    49 => 6,
    45 => 7,    // Speed Wi-Fi 5G X12
    46 => 7,
    47 => 7,
    48 => 7,
    50 => 7,
    51 => 7,
]);

/**
 * FRONT側のWIMAX_COLORに紐づくdevice_id
 * device_id => FRONTで割り当てられている端末のcolor
 * 1 => チタニウムグレー , 2 => スノーホワイト
 */
define('WIMAX_DEVICE_COLOR' , [
    30 => 1,
    33 => 1,
    34 => 2,
    35 => 2,
]);

/**
 * FRONT側のWIMAX_COLOR_NWに紐づくdevice_id
 * device_id => FRONTで割り当てられている端末のcolor
 * 1 => シャドーブラック , 2 => アイスホワイト
 */
define('WIMAX_DEVICE_COLOR_NWC' , [
    45 => 1,
    46 => 1,
    50 => 1,
    47 => 2,
    48 => 2,
    51 => 2,
]);

/**
 * こんど払い 契約事務手数料の商品名
 */
define('GMO_CONDO_PAY_ITEM_CONTRACT_FEE_NAME_LIST' , [
    DEVICE_TYPE_CLOUD => 'ZEUS WiFi契約事務手数料',
    DEVICE_TYPE_WIMAX => 'ZEUS WiMAX契約事務手数料',
]);

/**
 * こんど払い 商品カテゴリ名
 */
define('GMO_CONDO_PAY_CATEGORY_DEVICE_INIT_NAME' , '端末初期費用');

/**
 * FON system_id
 */
define('SYSTEM_ID_FON', 2);
/**
 * fuji system_id
 */
define('SYSTEM_ID_FUJI', 3);

define('SYSTEM_ID_NAME_LIST', [
//    SYSTEM_ID_ZEUS => 'ZEUS WiFi',
    SYSTEM_ID_FON => '縛りなしWiFi',
    SYSTEM_ID_FUJI => 'FUJI WiFi',
]);

/**
 * ログイン時のエラーコード
 */
define('LOGIN_ERROR_CODE_LIST',[
    'NO_HASH_CODE'              => 1,
    'NO_USER_ID_CODE'           => 2,
    'NO_MATCH_API_KEY_CODE'     => 3,
    'NOT_GET_USER_INFO_CODE'    => 4,
    'LOGIN_NO_USER'             => 5,
    'LOGIN_CANCEL_USER'         => 6,
    'NO_MATCH_PASSWORD_CODE'    => 7,
    'CANCEL_USER'               => 8,
    'SUSPEND_CODE'              => 9,
    'INVALID_USER_STATUS_CODE'  => 10,
    'INVALID_AUTH_INFO_CODE'    => 11,
    'SHOULD_LOGIN_BY_USER_ID'   => 12,
]);

/**
 * HTTP Request type
 */
define('HTTP_REQUEST_TYPE_POST', 'POST');
define('HTTP_REQUEST_TYPE_GET', 'GET');

/**
 * ユーザ連絡先.連絡先種別：契約者連絡先
 *
 * @var int
 */
define('USER_CONTACT_TYPE_CONTRACT', 0);

/**
 * ユーザ連絡先.連絡先種別：利用者連絡先
 *
 * @var int
 */
define('USER_CONTACT_TYPE_USER', 1);

/**
 * 顧客ステータス：仮登録
 *
 * @var int
 */
define('USER_STATUS_TEMPORARY_REGISTER', 4);

/**
 * UCLAPIコール用ID
 *
 * @var int
 */
define('USER_UCL_ADMIN_ID', 1);

/**
 * 課金区分: 月額で使った日数の従量課金
 *
 * @var integer
 */
define('PAY_AS_YOU_GO_DAILY_TYPE', 1);

/**
 * 課金区分: 月額で合計使用量の従量課金
 *
 * @var integer
 */
define('PAY_AS_YOU_GO_MONTHLY_TOTAL_TYPE', 2);

/**
 * 従量制で使った日の最低データ使用量
 * この値を変更する場合batchも変更する必要があります。
 * @var integer
 */
define('PAY_AS_YOU_GO_DAILY_MINIMUM_USAGE_MB', 100);

/**
 * 1024mb = 1gb
 * この値を変更する場合batchも変更する必要があります。
 */
define('DATA_FLOW_UNIT_TIMES', 1024);

// 利用規約のPDF_TYPE
define('PDF_TYPE_CONTRACT_SERVICE', 1);

// 覚書のPDF_TYPE
define('PDF_TYPE_MEMORANDUM', 2);

/**
 * 回線プラン解約&保険オプション継続時、プラン解約から何ヶ月目まではプラン情報を閲覧できるか定義
 *
 * @var int
 */
define('INSURANCE_VIEW_CONTRACT_PLAN_END_MONTH', 6);

/**
 * atone status code
 *
 * @var int
 */
define('ATONE_STATUS_OK', '00');     // 審査OK
define('ATONE_STATUS_NG', '20');     // 審査NG
define('ATONE_STATUS_CANCEL_OK', '30'); // キャンセルOK
define('ATONE_STATUS_CANCEL_NG', '40'); // キャンセルNG
define('ATONE_STATUS_REGIST', '90'); // 認証のみ
define('ATONE_STATUS_API_ERROR', '99'); // APIエラー

/**
 * atone api区分 1: web(決済モジュール), 2:web(決済api), 3:mng, 4:batch
 *
 * @var int
 */
define('ATONE_API_TYPE_WEB_M', '1'); // web(決済モジュール)
define('ATONE_API_TYPE_WEB_A', '2'); // web(決済api)
define('ATONE_API_TYPE_MNG', '3');   // mng
define('ATONE_API_TYPE_BATCH', '4'); // batch

/**
 * atone API実行でマニュアルに記載がないエラーコードが返ってきた用
 *
 * @var string
 */
define('ATONE_API_NO_ERROR_CODE_KEY', 'NOERO001');

/**
 * atone審査NG理由コード
 *
 * @var int
 */
define('ATONE_STATUS_NG_AMOUNT_EXCEEDS', 'NG001'); // 金額超過
define('ATONE_STATUS_NG_ETC', 'NG999'); // その他

/**
 * atone審査NG理由
 *
 * @var array
 */
define('ATONE_STATUS_NG_LIST', [
    ATONE_STATUS_NG_AMOUNT_EXCEEDS => 'atone 翌月払いを利用した決済金額がお客様の利用可能な上限金額を超過しています。',
    ATONE_STATUS_NG_ETC => 'atone 翌月払いをご利用いただけませんでした。',
]);

/**
 * atone API実行でtokenの有効期限切れが起きた際のエラーコード
 *
 * @var string
 */
define('ATONE_STATUS_ERROR_TOKEN', 'EATN0104'); // その他

/**
 * atone order prefix
 *
 * @var int
 */
define('ATONE_ORDER_PREFIX_LOCAL', '1111');   // ローカル環境
define('ATONE_ORDER_PREFIX_STAGING', '2222'); // ステージング環境

/**
 * atone カテゴリー
 * @var array
 */
define('ATONE_CATEGORY_LIST', [
    INVOICE_TYPE_PLAN          => 'プラン',
    INVOICE_TYPE_OPTION        => 'オプション',
    INVOICE_TYPE_DATACHARGE    => 'データチャージ',
    INVOICE_TYPE_OVERSEAS_PLAN => '海外プラン'
]);

/**
 * atone 支払方法変更可能な支払方法
 *
 * @var array
 */
define('ATONE_ALLOW_CHANGE_SETTLEMENT_TYPE_LIST', [
    SETTLEMENT_TYPE_VALUE_LIST['ATONE'],
    SETTLEMENT_TYPE_VALUE_LIST['ATOBARAI'],
]);

/**
 * ユーザースターテス 有効
 *
 * @var string
 */
define('ENABLE_USER_STATUS', 'enable');

/** 特別プラン案内用暗号化キー
 *
 * @var string
 */
define('SPECIAL_PLAN_CIPHER_KEY', 'za4auiNTB6jFFudC94Vt');

/**
 * 通常のチャージ
 * @var string
 */
define('DATA_CHARGE_TYPE_DEFAULT', 'charge');

/**
 * プリペイドタイプのチャージ
 * @var string
 */
define('DATA_CHARGE_TYPE_PACKAGE', 'packagecharge');

/**
 * CHARGE国内プラン(プリペイド)最短利用開始日
 */
define('PREPAID_START_DAYS', 4); // +n日以降の日付から借りられる

/**
 * CHARGE国内プラン(プリペイド)最終利用開始日
 */
define('PREPAID_START_DAYS_LIMIT', 14); // 利用開始日は+n日まで選択可能

/**
 * fifth_day_Of_fifth_Month
 *
 * @var string
 */
define('FIFTH_DAY_OF_FIFTH_MONTH', '2023-05-05');

/**
 * 改行コード(LF)
 *
 * @var string
 */
define('LIFE_FEED', "\n");

/**
 * PM時間
 *
 * @var int
 */
define('PM_HOUR', 12);

/**
 * 短期レンタル金額算出用定数
 */
define('RENTAL_HALF_MONTH_DAYS', 15);   // 半月の日数
define('RENTAL_MONTH_DAYS', 31);        // 一月の日数

/**
 * 短期レンタル最短レンタル開始日
 */
define('RENTAL_START_DAYS', 2); // +n日以降の日付から借りられる

/**
 * 短期レンタル最終レンタル開始日（フロント側で設定されている90日 + バッファ10日）
 */
define('RENTAL_START_DAYS_LIMIT', 100); // レンタル開始日は+n日まで選択可能

/**
 * 選択不可の都道府県リスト（海外レンタルプラン用）
 */
define('PREFECTURE_TO_EXCLUDE_LIST_OVERSEAS', [
]);

/**
 * マイページでキャンセル不可能な海外レンタルプラン対象エントリーステータスリスト
 */
define('INTERNATIONAL_RENTAL_CANCEL_ENTRY_STATUS_LIST', [
    ENTRY_STATUS_CSV_OUTPUT,    // CSV出力済
    ENTRY_STATUS_DELIVERY,      // 発送済
    ENTRY_STATUS_CANCEL,        // 申込取消
    ENTRY_STATUS_ENTRY_CANCEL,  // 審査NG
]);

/**
 * マイページを使用可能な海外レンタルプラン対象エントリーステータスリスト
 */
define('INTERNATIONAL_RENTAL_MYPAGE_ENTRY_STATUS_LIST', [
    ENTRY_STATUS_ENTRY,
    ENTRY_STATUS_EXAMINATION,
    ENTRY_STATUS_APPROVED,
    ENTRY_STATUS_CSV_OUTPUT,
    ENTRY_STATUS_DELIVERY,
]);

/**
 * 取込ステータス：取込成功
 */
define('IMEI_IMPORT_STATUS_OK', '2');

/**
 * CHARGEプラン用：新規購入IMEI
 * @var int
 */
define('IMEI_IS_NEW', 0);

/**
 * CHARGEプラン用：譲渡購入IMEI
 * @var int
 */
define('IMEI_IS_NOT_NEW', 1);

/**
 * アンケート区分
 *
 * @var string
 */
define('SURVEY_TYPE_TRAVEL_PURPOSE', '1');      // 海外レンタルプラン・渡航目的、きっかけ等
define('SURVEY_TYPE_HOW_TO_GET_DEVICE', '2');   // CHARGE国内プラン(プリペイド)・端末入手経路

/**
 * 海外レンタルデータ使用量:500M
 */
define('INTERNATIONAL_RENTAL_DATA_USAGE_LIMIT_500M', 512);

/**
 * 海外レンタルデータ使用量:1G
 */
define('INTERNATIONAL_RENTAL_DATA_USAGE_LIMIT_1G', 1024);

/**
 * 海外レンタルデータ使用量:無制限
 */
define('INTERNATIONAL_RENTAL_DATA_USAGE_LIMIT_UNLIMITED', 0);

/**
 * 海外レンタルデータ使用量名リスト
 *
 * @var array
 */
define('INTERNATIONAL_RENTAL_DATA_USAGE_LIMIT_NAME_LIST', [
    INTERNATIONAL_RENTAL_DATA_USAGE_LIMIT_500M      => "500MB",
    INTERNATIONAL_RENTAL_DATA_USAGE_LIMIT_1G        => "1GB",
    INTERNATIONAL_RENTAL_DATA_USAGE_LIMIT_UNLIMITED => "無制限",
]);

/**
 * MAYA切替日
 *
 * @var int
 */
define('MAYA_REPLACE_DATE', '2023-10-02 11:59:00'); // 10/02 12:00から切り替え

/**
 * レンタル端末配送の最大日数
 */
define('MAXIMUM_DELIVERY_DAYS', 11);

/**
 * レンタル端末配送対象外となる日数
 */
define('DELIVERY_DAYS_TO_EXCLUDE', 4);

/**
 * 海外レンタル・発送可能日の区切り時間
 *
 * @var int
 */
define('DELIVERY_BORDER_HOUR', 10);
/**
 * デビューキャンペーン
 *
 * @var string
 */
define('CAMPAIGN_ID_DEBUT', 'デビューキャンペーン');

/**
 * スタンダードプラン 100GBデビューキャンペーン
 *
 * @var string
 */
define('CAMPAIGN_ID_DEBUT_100GB', 'スタンダードプラン 100GBデビューキャンペーン');

/**
 * 春の ZEUS キャンペーン
 *
 * @var string
 */
define('CAMPAIGN_ID_SPRING',[
    'スタンダードプラン 20GB 春のZEUSキャンペーン',
    'スタンダードプラン 40GB 春のZEUSキャンペーン'
]);

/**
 * 法人乗り換えキャンペーン
 *
 * @var string
 */
define('CAMPAIGN_ID_CORP_TRANSFER',[
    'スタンダードプラン 20GB 法人乗り換えキャンペーン',
    'スタンダードプラン 40GB 法人乗り換えキャンペーン',
    'スタンダードプラン 100GB 法人乗り換えキャンペーン',
]);

/**
 * ZEUS サマーキャンペーン
 *
 * @var string
 */
define('CAMPAIGN_ID_SUMMER',[
    'スタンダードプラン 20GB ZEUSサマーキャンペーン',
    'スタンダードプラン 40GB ZEUSサマーキャンペーン',
]);

/**
 * ZEUS W キャンペーン
 *
 * @var string
 */
define('CAMPAIGN_ID_W',[
    'ZEUS Wキャンペーン(5GBボーナス)',
    'ZEUS Wキャンペーン(10GBボーナス)',
]);

/**
 * ZEUS SALE キャンペーン
 *
 * @var string
 */
define('CAMPAIGN_ID_SALE',[
    'スタンダードプラン 20GB SALEキャンペーン',
    'スタンダードプラン 40GB SALEキャンペーン',
    'スタンダードプラン 100GB SALEキャンペーン',
]);

/**
 * ZEUS SALE キャンペーン第 2 弾
 *
 * @var string
 */
define('CAMPAIGN_ID_SALE_TWO','ZEUS SALEキャンペーン第２弾');

/**
 * 神コスパキャンペーン
 *
 * @var string
 */
define('CAMPAIGN_ID_DIVINE_COST','神コスパキャンペーン');

/**
 * 神コスパキャンペーン2
 *
 * @var string
 */
define('CAMPAIGN_ID_DIVINE_COST_TWO','神コスパキャンペーン2');

/**
 * ZEUS 5,000円キャッシュバックキャンペーン
 *
 * @var string
 */
define('CAMPAIGN_ID_CASHBACK','ZEUS 5,000円キャッシュバックキャンペーン');

/**
 * 申し込みフォーム名 - 海外レンタル(離脱ユーザー情報記録用)
 *
 * @var string
 */
define('OVERSEAS_USER_FORM','overseas_user');

/**
 * 申し込みフォーム名 - 国内サブスク(離脱ユーザー情報記録用)
 *
 * @var string
 */
define('DOMESTIC_SUBSCRIBE_USER_FORM','domestic_subscribe_user');

/**
 * GMO 利用できないスタートタイム yyyy-mm-dd hh:mm:ss
 *
 * @var string
 */
define('GMO_DISABLE_START_DATETIME', null);

/**
 * GMO 利用できない時サービスとENUM配列 (今後従って必要なし)
 *
 * @var integer
 */
define('GLOBAL_PAGE', 1);
define('WIMAX_PAGE', 2);
define('CHARGE_PAGE', 3);

/**
 * 外部サイトからくる場合の金額を判定するためのID
 *
 * @var int
 */
define('MARKET_ID_KAKAKU_COM', 1);
define('MARKET_ID_HIKAKU_NABI', 2);

/**
 * 外部サイト判定パラメータ
 * @var string
 */
define('HIKAKU_NABI_INFLOW_KEY_UTM_SOURCE', 'mobistar');
define('HIKAKU_NABI_INFLOW_KEY_UTM_MEDIUM', 'af');

/**
 * 海外レンタル: 事前配送オプションの最短選択できる日
 *
 * @var integer
 */
define('DELIVERY_OPTION_AVAILABLE_FROM_DAYS', 4);

/**
 * 海外レンタル: 事前配送オプションの最長選択できる日
 *
 * @var integer
 */
define('DELIVERY_OPTION_AVAILABLE_TO_DAYS', 8);

/**
 * 領収書区分
 *
 * @var integer
 */
define('RECEIPT_TYPE_ENTRY', '1');              // 申込
define('RECEIPT_TYPE_ADD_PLAN', '2');           // プラン追加
define('RECEIPT_TYPE_EXTENSION_PLAN', '3');     // プラン延長
define('RECEIPT_TYPE_CHANGE_PLAN', '4');        // プラン変更（アップセル）
define('RECEIPT_TYPE_EXPIRE_FEE', '5');         // 延滞金 + 端末延滞金
define('RECEIPT_TYPE_DEVICE_DAMAGE_FEE', '6');  // 返却後の端末損害金

/**
 * 領収書但し書き ※仮の文言。後日清書を依頼すること。サービス名部分は動的に置換できるようにすべきか検討。
 *
 * @var array
 */
define('PAYMENT_DESCRIPTION_LIST', [
    RECEIPT_TYPE_ENTRY => 'ZEUS WiFi for GLOBAL ご利用料金として',
    RECEIPT_TYPE_ADD_PLAN => 'ZEUS WiFi for GLOBAL 利用国の追加として',
    RECEIPT_TYPE_EXTENSION_PLAN => 'ZEUS WiFi for GLOBAL 渡航期間の延長として',
    RECEIPT_TYPE_CHANGE_PLAN => 'ZEUS WiFi for GLOBAL 容量変更として',
    RECEIPT_TYPE_EXPIRE_FEE => 'ZEUS WiFi for GLOBAL 延滞金として',
    RECEIPT_TYPE_DEVICE_DAMAGE_FEE => 'ZEUS WiFi for GLOBAL 端末損害金として',
]);

/**
 * 顧客拡張区分・通常の個人の申込
 *
 * @var string
 */
define('USER_EXPANSION_TYPE_USER', '0');

/**
 * 顧客拡張区分・海外レンタルプランの法人申込（個人の申込みフォームと一部共用）
 *
 * @var string
 */
define('USER_EXPANSION_TYPE_OVERSEA_RENTAL_COMPANY', '1');

/**
 * 申込・受取場所区分
 *
 * @var string
 */
define('DELIVERY_RECEIVE_PLACE_TYPE_HOME', '0');    // 自宅受取
define('DELIVERY_RECEIVE_PLACE_TYPE_CONVENIENCE', '1'); // 空港エリア内コンビニ受取
define('DELIVERY_RECEIVE_PLACE_TYPE_LIST', [
    DELIVERY_RECEIVE_PLACE_TYPE_HOME => '宅配受取',
    DELIVERY_RECEIVE_PLACE_TYPE_CONVENIENCE => '空港受取',
]);

/**
 * 配送会社コード（佐川・ヤマト）
 */
define('ZEUS_DELIVERY_COMPANY_SAGAWA', '0001');  // 佐川急便（importimei.csvのコード）
define('ZEUS_DELIVERY_COMPANY_YAMATO', '0002');  // ヤマト運輸（importimei.csvのコード）

/**
 * 配送会社（importimei）
 */
define('DELIVERY_COMPANY_NAME_LIST', [
    ZEUS_DELIVERY_COMPANY_SAGAWA => '佐川急便',
    ZEUS_DELIVERY_COMPANY_YAMATO => 'ヤマト運輸',
]);

/**
 * ヤマト配送区分
 * 下記は、取扱いなし
 * 着払い：payment on delivery
 * 代引き：cash on delivery　(CODと短縮されていることもある)
 * @var int
 */
define('DELIVERY_TYPE_YAMATO_TA_Q_BIN_BOX', 0);     // 宅急便(発払い)
define('DELIVERY_TYPE_YAMATO_NEKOPOS', 7);          // ネコポス Nekopos service とヤマトに表記あり
define('DELIVERY_TYPE_YAMATO_TA_Q_BIN_COMPACT', 8); // 宅急便コンパクト

/**
 * ヤマトサービス区分
 * 下記はZEUSでは定義しない
 * 4：FUJIルーターレンタル 5：FUJISIMレンタル 6：縛りなし 7：縛りなし超短期 10:縛りなしリチャージ(プリペイド)
 * @var int
 */
define('SERVICE_TYPE_YAMATO_DOMESTIC', 1);              // ZEUS国内レンタル：サブスク(個人、法人1台含む) オープンハウス・一括前払い
define('SERVICE_TYPE_YAMATO_INTERNATIONAL_RENTAL', 2);  // ZEUS海外レンタル
define('SERVICE_TYPE_YAMATO_SHORT_RENTAL', 3);          // ZEUS短期レンタル (現在は楽天EC)
define('SERVICE_TYPE_YAMATO_PREPAID', 8);               // ZEUS CHARGE (プリペイド)
define('SERVICE_TYPE_YAMATO_PREPAID_AUTO', 11);         // ZEUS CHARGE (オートリチャージ)
define('SERVICE_TYPE_YAMATO_WIMAX_PERSON', 14);         // ZEUSWiMAX(個人)
define('SERVICE_TYPE_YAMATO_DOMESTIC_CORP', 12);        // ZEUS法人

/**
 * ネコポス配送時間
 * ネコポス配送時間指定不可のため'0000':時間指定なしを設定する
 * @var string
 */
define('DELIVERY_ORDER_TIME_NEKOPOS', '0000');

/**
 * 法人特別プラン種別
 * @var string
 */
define('BUSINESS_SPECIAL_HOMETOWN_TAX', '1');   // 法人向けふるさと納税プラン

/**
 * WiMAX配送区分
 * ホームルーターは大きいので宅急便、モバイルルーターは宅急便コンパクトで配送する
 * @var array
 */
define('WIMAX_DELIVERY_TYPE_LIST', [
     DELIVERY_TYPE_YAMATO_TA_Q_BIN_BOX => [43, 44, 49,],
     DELIVERY_TYPE_YAMATO_TA_Q_BIN_COMPACT => [45, 46, 47, 48, 50, 51,]
]);

/**
 * インボイス対応用トランザクション種別：インボイス対応
 * @var int
 */
define('TRANSACTION_TYPE_INVOICE_SUPPORT', 1);

/**
 * Paidy加盟店区分 ※対応する管理画面アカウントで分けている
 */
define('PAIDY_MERCHANT_TYPE_ZEUS', 1);  // ZEUS 国内サブスク、海外レンタルなど（分割は3回あと払いのみ）
define('PAIDY_MERCHANT_TYPE_CHAGE', 2); // ZEUS チャージプラン、オートチャージなど（分割は3回あと払いのほか、6回あと払い、12回あと払い対応）
define('PAIDY_MERCHANT_TYPE_LIST',[
    PAIDY_MERCHANT_TYPE_ZEUS => 'zeus',
    PAIDY_MERCHANT_TYPE_CHAGE => 'charge',
]);

/**
 * Paidy決済に関連してZEUS側で定義したエラーコード
 */
define('PAIDY_ERROR_CODE_ZEUS_TOKEN_FAILED', 'zeus.token.failed');
define('PAIDY_ERROR_CODE_ZEUS_TOKEN_INVALID', 'zeus.token.invalid');

/**
 * Paidy決済API等のエラーコードとそれに対応したメッセージ
 */
define('PAIDY_ERROR_CODE_MESSAGE_LIST',[
    PAIDY_ERROR_CODE_ZEUS_TOKEN_FAILED  => 'トークン情報が取得できませんでした。', // TODO：お客様に案内するための妥当な文言
    PAIDY_ERROR_CODE_ZEUS_TOKEN_INVALID => '無効なトークンです。',
    'request_content.malformed'         => '決済に必要な情報が足りません。', // Paidyの決済APIのエラーオブジェクト内のcodeの値に対応したメッセージ
    'authentication.failed'             => '認証に失敗しました。',
]);

/**
 * PaidyのWebhookチェックステータス
 */
define('PAIDY_WEBHOOK_STATUS_BEFORE_CHECKING', 0); // 確認前
define('PAIDY_WEBHOOK_STATUS_OK', 1); // 確認OK
define('PAIDY_WEBHOOK_STATUS_DISAGREEMENT', 2); // 不整合あり
define('PAIDY_WEBHOOK_STATUS_FIXED', 9); // 修正済

/**
 * 請求書の登録番号
 */
define('BILL_REGISTRATION_NUMBER', 'T3011001125518');

/**
 * 請求書の登録番号
 */
define('TRANSACTION_ACTION_DEVICE_INIT_PAYMENT', '初期費用決済');
define('TRANSACTION_ACTION_DEVICE_PAYMENT', '端末決済');
define('TRANSACTION_ACTION_PLAN_PAYMENT', 'プラン決済');
define('TRANSACTION_ACTION_OPTION_PAYMENT', 'オプション決済');
define('TRANSACTION_ACTION_INTERNAL_RENTAL_PLAN_PAYMENT', '海外レンタルプラン決済');
define('TRANSACTION_ACTION_EXPIRE_FEE_PAYMENT', '延滞金決済');
define('TRANSACTION_ACTION_CANCEL_PAYMENT', '決済キャンセル');
