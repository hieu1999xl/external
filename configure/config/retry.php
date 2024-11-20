<?php
return [
    /**
     * level : 300,400,500
     * 300:HTTPステータス300以上
     * 400:HTTPステータス400以上
     * 500:HTTPステータス500以上
     * times : リトライ回数
     * interval : 秒定義
     */

    'default_timeout' => 120,
    'level'           => 400,
    'times'           => 3,
    'interval'        => 3,

    'ucloudlink' => [
        'level'    => 400,
        'times'    => 3,
        'interval' => 3,
    ],

    'gmo' => [
        'level'    => 400,
        'times'    => 3,
        'interval' => 3,
        'timeout'  => 90, // カード会社と接続する場合の推奨値の90秒
    ],

    'user' => [
        'level'    => 400,
        'times'    => 3,
        'interval' => 3,
    ],

    'hrds' => [
        'level'    => 400,
        'times'    => 3,
        'interval' => 3,
    ],

    'google' => [
        'level'    => 400,
        'times'    => 3,
        'interval' => 3,
    ],

    'paidy' => [
        'level'    => 400,
        'times'    => 3,
        'interval' => 3,
    ],
];
