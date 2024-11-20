<?php

use Fuel\Core\Config;
use Hikaeme\Monolog\Formatter\LtsvFormatter;
use Monolog\Handler\NativeMailerHandler;

/**
 * ログ管理クラス
 *
 * @author sakairi@liz-inc.co.jp
 */
class Log {
    /**
     *
     * @var log
     */
    private static $instance;
    /**
     * アプリログ用のロガー
     *
     * @var Log_Logger
     */
    private $applicationLogger;
    /**
     * 日付フォーマット
     *
     * @var string
     */
    const DATE_FORMAT = 'Y-m-d H:i:s.u';

    /**
     * コンストラクタ
     * <pre>
     * ログのハンドラとフォーマットを設定します。
     * </pre>
     */
    public function __construct() {
        $labeling = [
            'datetime'   => 'time',
            'service_id' => 'service_id',
            'level_name' => 'level',
            'server'     => 'server',
            'controller' => 'controller',
            'method'     => 'method',
            'pid'        => 'pid',
            'ip'         => 'ip',
            'message'    => 'message',
            'userId'     => 'userId',
            'businessId' => 'businessId',
            'context'    => 'context',
            'stacktrace' => 'stacktrace',
            'file'       => 'file',
            'line'       => 'line',
            'extra'      => 'extra',
            'sid'        => 'sid',
            'ua'         => 'ua',
        ];
        $log_handler = new Log_Handler(Config::get('log_file'), 0, Config::get('log_level'));
        $log_handler->setFormatter(new LtsvFormatter(self::DATE_FORMAT, $labeling));

        $error_mail_handler = new Log_NativeMailHandler(Config::get('template.error_mail.to'), Config::get('template.error_mail.subject'), Config::get('template.error_mail.from'), Config::get('error_mail_log_level'));
        $error_mail_handler->setFormatter(new LtsvFormatter(self::DATE_FORMAT, $labeling));

        $this->applicationLogger = new Log_Logger('application', array(
            $log_handler
            // $error_mail_handler // ログ出力内容を整形してbodyに詰め込む対応工数がとれないため、自動送信はクローズ
        ));
    }

    /**
     * インスタンス取得
     */
    private static function init() {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

    }

    /**
     * オペレーションログ
     *
     * @return Log_Logger
     */
    public static function application()
    {
        static::init();
        return self::$instance->applicationLogger;
    }
}
