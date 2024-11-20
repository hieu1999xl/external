<?php

/**
 * 外部接続例外.
 *
 * @package  exception
 * @extends  Exception
 * @author   sakairi@liz-inc.co.jp
 */
class Exception_ExternalException extends Exception {

    /**
     * Exception_ExternalException constructor.
     *
     * @param           $message
     * @param integer   $code
     * @param Exception $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);

    }
}
