<?php
return [
    'extensions' => [
        'php'  => 'View',
        'twig' => 'View_Twig',
    ],
    'View_Twig'  => [
        'auto_encode' => true,
        'views_paths' => [
            APPPATH . 'views',
        ],
        'delimiters'  => [
            'tag_block'    => [
                'left'  => '{%',
                'right' => '%}',
            ],
            'tag_comment'  => [
                'left'  => '{#',
                'right' => '#}',
            ],
            'tag_variable' => [
                'left'  => '{{',
                'right' => '}}',
            ],
        ],
        'environment' => [
            'debug'               => true,
            'charset'             => 'utf-8',
            'base_template_class' => 'Twig_Template',
            'cache'               => APPPATH.'cache'.DS.'twig'.DS,
            'auto_reload'         => true,
            'strict_variables'    => false,
            'autoescape'          => false,
            'optimizations'       => -1,
        ],
        'extensions'  => [
            'Twig_Fuel_Extension',
            'Casset_Addons_Twig',
        ],
    ],
];

