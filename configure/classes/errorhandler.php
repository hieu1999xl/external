<?php

/**
 *
 */
class Errorhandler extends \Fuel\Core\Errorhandler {

    /**
     * todo 本番で想定外の例外エラーが発生した時に表示するviewファイルに変更
     *
     * @Override
     *
     * @return void
     */
    protected static function show_production_error($e) {
        // when we're on CLI, always show the php error
        if (\Fuel::$is_cli) {
            return static::show_php_error($e);
        }

        if (!headers_sent()) {
            $protocol = \Input::server('SERVER_PROTOCOL') ? \Input::server('SERVER_PROTOCOL') : 'HTTP/1.1';
            header($protocol . ' 500 Internal Server Error');
        }

        exit(\View_Twig::forge('error/common', [
            'title'       => Config::get('title.error'),
            "summary"     => "エラーが発生しました。",
            "sub_summary" => "Internal Server Error",
            "details"     => [
                "ただいまアクセス集中、または不具合発生中のために、",
                "繋がりにくくなっております。",
                "少し時間をおいて再度アクセスをお願いいたします。",
                "ご不便をおかけして申し訳ございません。",
            ],
            "back_label"  => "トップに戻る",
            "back_url"    => Config::get('base_url'),
        ]));
    }
}
