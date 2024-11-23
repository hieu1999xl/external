<?php

/**
 * APIエラー用例外.
 *
 * @package  exception
 * @extends  Exception
 * @author   sakairi@liz-inc.co.jp
 */
class Exception_ApiBadRequestException extends Exception {

    /**
     * APIのエラー詳細情報
     *
     * @var array
     */
    private $_error_info = null;

    /**
     * Exception_ApiBadRequestException constructor.
     *
     * @param string    $message    エラーメッセージ
     * @param array     $code       APIのステータスコード
     * @param array     $error_info APIのエラー情報
     * @param Exception $previous
     */
    public function __construct($message = "", $code = 0, $error_info = [], Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->_error_info = $error_info;

    }

    /**
     * sub_errors getter
     *
     * @return array
     */
    public function error_info() {
        return $this->_error_info;

    }
}
