<?php

use Monolog\logger;
use Fuel\Core\Uri;

/**
 * ロガークラス
 *
 * @author kunita-k
 */
class Log_Logger extends \Monolog\logger {
    private static $LOG_FILE = null;

    /**
     * ユーザーID
     *
     * @var int
     */
    private static $user_id;

    /**
     * 事業者ID
     *
     * @var int
     */
    private static $business_id;

    /**
     * コンストラクタ
     *
     * @param unknown $name
     * @param array   $handlers
     * @param array   $processors
     */
    public function __construct($name, array $handlers = [], array $processors = []) {
        parent::__construct($name, $handlers, $processors);
        if (self::$LOG_FILE === null) {
            $reflector = new \ReflectionClass('\Monolog\Logger');
            self::$LOG_FILE = $reflector->getFileName();
        }

    }

    /**
     * (non-PHPdoc)
     *
     * @see \Monolog\Logger::addRecord()
     */
    public function addRecord($level, $message, array $context = []) {
        if (!$this->handlers) {
            $this->pushHandler(new StreamHandler('php://stderr', static::DEBUG));
        }

        if (!static::$timezone) {
            static::$timezone = new \DateTimeZone(date_default_timezone_get() ?: 'UTC');
        }

        // 5.3切替でエラーとなるためコメントアウト
        $backtrace = debug_backtrace();
        // $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $backclass = null;
        for ($i = 0, $end = count($backtrace); $i < $end; $i++) {
            $backclass = $backtrace[$i];
            if ($backclass['file'] !== self::$LOG_FILE) {
                break;
            }
            $backclass = null;
        }
        $file = null;
        $line = null;
        if ($backclass !== null) {
            $file = $backclass['file'];
            $line = $backclass['line'];
        }

        // ログ出力項目
        $record = [
            'datetime'   => DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)), static::$timezone)->setTimezone(static::$timezone),
            'service_id' => SERVICE_ID,
            'level_name' => static::getLevelName($level),
            'level'      => $level,
            'server'     => gethostname(),
            'controller' => (\Request::main() == false) ? '' : \Request::main()->controller,
            'method'     => (\Request::main() == false) ? '' : \Request::main()->action,
            'pid'        => getmypid(),
            'ip'         => $this->getIpAddress(),
            'message'    => $message,
            'userId'     => self::$user_id,
            'businessId' => self::$business_id,
            'context'    => $context,
            'stacktrace' => $backtrace,
            'file'       => $file,
            'line'       => $line,
            'extra'      => [],
            'sid'        => $this->getSessionId(),
            'ua'         => $this->getUserAgent(),
        ];
        // check if any handler will handle this message
        $handlerKey = null;
        foreach ($this->handlers as $key => $handler) {
            if ($handler->isHandling($record)) {
                $handlerKey = $key;
                break;
            }
        }
        // none found
        if (null === $handlerKey) {
            return false;
        }

        // found at least one, process message and dispatch it
        foreach ($this->processors as $processor) {
            $record = call_user_func($processor, $record);
        }
        while (isset($this->handlers[$handlerKey]) && false === $this->handlers[$handlerKey]->handle($record)) {
            $handlerKey++;
        }

        return true;

    }

    /**
     * IPアドレス取得
     *
     * @return string IPアドレス
     */
    private function getIpAddress() {
        return gethostbyname(gethostname());

    }

    /**
     * セッションから取得したログインIDを取得
     *
     * @return string ログインID|未ログイン時は固定で anonymous を返却
     */
    protected function getSessionId() {
        return "anonymous";
    }

    /**
     * リクエストのユーザーエージェントを取得
     *
     * @return string ユーザーエージェント
     */
    protected function getUserAgent() {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            return $_SERVER['HTTP_USER_AGENT'];
        }
        return "";
    }

    /**
     * ログ用のユーザー情報をセットする
     *
     * @param int $user_id
     * @param int $business_id
     */
    public static function set_user_info($user_id, $business_id) {
        self::$user_id = $user_id;
        self::$business_id = $business_id;
    }
}
