<?php

require_once APPPATH . 'classes/controller/login.php';

/**
 * ログインクラスのユニットテスト
 *
 * @group App
 */
class Test_Controller_Login extends Testcase {
    /**
     * ログイン画面表示
     *
     * @test
     */
    public function ログイン画面表示のテスト() {
        $response = Request::forge('login')->set_method('GET')->execute()->response();
    }
}
