<?php

/**
 * DB例外.
 *
 * @package  exception
 * @extends  Exception
 * @author   sakairi@liz-inc.co.jp
 */
class Exception_DatabaseException extends Exception {

    /**
     * Exception_DatabaseException constructor.
     *
     * @param Exception $previous
     * @param string    $override_message DB接続後の処理でExceptionをthrowしたい場合にセットするメッセージ
     */
    public function __construct(Exception $previous = null, $override_message = '') {
        $message = (strlen($override_message)) ? $override_message : $previous->getMessage();
        parent::__construct($message, 0, $previous);

    }
}
