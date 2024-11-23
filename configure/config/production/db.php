<?php
/**
 * The production database settings. These get merged with the global settings.
 */
return [
    'active' => 'master',

    'master' => [
        'type'         => 'pdo',
        'connection'   => [
            'dsn'        => 'mysql:host=prod-mysql8.cx2hre1saro5.ap-northeast-1.rds.amazonaws.com;dbname=human_life;port=3306',
            'username'   => 'wifi-app',
            'password'   => '2Zfi&S2yZuMt',
            'persistent' => false,
        ],
        'identifier'   => '',
        'table_prefix' => '',
        'charset'      => 'utf8',
        'enable_cache' => false,
        'profiling'    => false,
    ],
    'redis' => [
        'default' => [
            'hostname' => 'prod-zeus-web-001.tqaciz.0001.apne1.cache.amazonaws.com',
            'port' => 6379,
            'timeout' => null,
        ],
    ],
];
