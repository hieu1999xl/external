<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */
return [
    /**
     * Logging Threshold.
     * Can be set to any of the following:
     *
     * Fuel::L_NONE
     * Fuel::L_ERROR
     * Fuel::L_WARNING
     * Fuel::L_DEBUG
     * Fuel::L_INFO
     * Fuel::L_ALL
     */
    /**
     * ログのレベル(debugログ以上を指定)
     */
    'log_level' => Fuel::L_INFO,

    /**
     * 自動メール送信のログレベル(debugログ以上を指定)
     */
    'error_mail_log_level' => Fuel::L_ERROR,
    /**
     * アプリケーションのベース URL。相対指定することもできます。
     * 末尾は必ずスラッシュにする必要があります
     * ('/foo/', 'http://example.com/')
     */
    'base_url' => 'https://zeus-wifi.jp/',
    'global_url' => 'https://zeuswifi-global.jp/',

];
