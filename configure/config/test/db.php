<?php
/**
 * The test database settings. These get merged with the global settings.
 *
 * This environment is primarily used by unit tests, to run on a controlled environment.
 */
return [
    'active' => 'sales',

    'sales' => [
        'type'         => 'pdo',
        'connection'   => [
            'dsn'        => 'mysql:host=192.168.4.102;dbname=human_life;port=3306',
            'username'   => 'human_life',
            'password'   => 'human_life',
            'persistent' => false,
        ],
        'identifier'   => '',
        'table_prefix' => '',
        'charset'      => 'utf8',
        'enable_cache' => false,
        'profiling'    => false,
    ],

];
