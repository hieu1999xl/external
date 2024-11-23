<?php

/**
 * ファイル例外.
 *
 * @package  exception
 * @extends  Exception
 * @author   akiyama.k
 */
class Exception_FileException extends Exception {

    /**
     * Exception_FileException constructor.
     *
     * @param string $message   エラーメッセージ
     * @param string $file_path ファイルパス
     */
    public function __construct($message = '', $file_path = '') {
        if ($file_path !== '') {
            $message .= ' : ' . $file_path;
        }
        parent::__construct($message, 0, null);
    }
}