<?php

/**
 * メッセージのヘルパークラス
 *
 * @author tanabe
 *
 */
class Helper_Message {

    private static $instance;

    private function __construct() {
        // 言語ファイルの読み込み
        Lang::load('messages', true);
    }

    private function getMessageCore($id, $params = []) {
        return Lang::get("messages." . $id, $params);
    }

    private static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new Helper_Message();
        }

        return self::$instance;
    }

    /**
     * メッセージを取得します。
     *
     * @param string $id     メッセージの識別子
     * @param array  $params メッセージに埋め込むパラメータ
     * @return mixed|string メッセージ
     */
    public static function getMessage($id, $params = []) {
        return self::getInstance()->getMessageCore($id, $params);
    }
}
