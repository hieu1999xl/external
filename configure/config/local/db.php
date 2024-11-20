<?php

/**
 * The test database settings. These get merged with the global settings.
 *
 * This environment is primarily used by unit tests, to run on a controlled environment.
 */
return array(
    'active' => 'master',

    'master' => array(
        'type' => 'pdo',
        'connection' => array(
            'dsn' => 'mysql:host=mysql_zues;dbname=human_life;port=3306',
            'username' => 'user29',
            'password' => 'user29',
            'persistent' => false
        ),
        'identifier' => '',
        'table_prefix' => '',
        'charset' => 'utf8',
        'enable_cache' => false,
        'profiling' => true
    ),
    // redisの設定です。
    'redis' => array(
        'default' => array(
            'hostname' => 'redis_zues',
            'port' => 6379,
            'password' => 'sample_123',
            'timeout' => null,
        ),
    ),
);
