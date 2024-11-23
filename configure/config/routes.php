<?php
/**
 * ※※※※※※※※※※※※※注意事項※※※※※※※※※※※※※※※
 *
 * ・/productionはApacheのAliasで使用しているため定義しないこと
 *
 * ※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※
 */
return [
    'login'                           => ['login/login', 'name' => 'login'],
    // ログインページ(CHARGEプラン(プリペイド)向け)
    'prepaid/login'                   => ['login/prepaid_login', 'name' => 'prepaid_login'],
    // ログインページ(海外レンタルプラン向け)
    'rental/login'                    => ['login/rental_login', 'name' => 'rental_login'],
    // ログアウト
    'logout'                          => ['logout/logout', 'name' => 'logout'],
    // 500エラー
    '_500_'                           => 'error/error/500',
    // 400エラー
    '_404_'                           => 'error/error/404',
    ':any'                            => 'error/error/404',
];
