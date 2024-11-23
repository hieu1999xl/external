<?php

/**
 * コマンドライン引数関連のヘルパークラス
 *
 * @author sakairi@liz-inc.co.jp
 *
 */
class Helper_Mail {
    /**
     * エラーメール用のユーザーID
     *
     * @var int
     */
    private static $user_id;

    /**
     * エラーメール用の事業者ID
     *
     * @var int
     */
    private static $business_id;

    /**
     * SendMail送信
     *
     * @param $header
     * @param $body
     * @param $file_list
     * @return bool
     */
    private static function _send($header, $body, $file_list) {
        if (empty($header) || empty($body)) {
            return false;
        }

        $email = Email::forge();
        // from
        $email->from($header['from'], $header['fromName']);
        // to
        $email->to($header['to']);
        // reply to
        if (isset($header['replyTo'])) {
            $email->reply_to($header['replyTo']);
        }
        // cc
        if (isset($header['cc'])) {
            $email->cc($header['cc']);
        }
        // bcc
        if (isset($header['bcc'])) {
            $email->bcc($header['bcc']);
        }
        // subject
        $email->subject($header['subject']);
        // body
        $email->body((string)$body);
        // attached
        foreach ($file_list as $file_path) {
            if (!empty($file_path)) {
                $email->attach($file_path);
            }
        }
        // 送信
        $email->send();

        return true;

    }

    /**
     * メールを送信する
     * <pre>
     * to,fromは必須
     * body,fromName,subjectは任意(未設定の場合は空文字を設定する)
     * </pre>
     *
     * @param array $params    メール送信 パラメータ (例：array('body' => '本文', 'subject' => '件名') )
     * @param array $file_list 添付ファイルパス
     * @return boolean
     */
    public static function send_mail($params = [], $file_list = []) {
        $is_success_send = false;

        // 送信元 or 送信先がない場合は送信しない
        if (!isset($params['from']) || !isset($params['to'])) {
            return false;
        }

        if (!is_array($file_list)) {
            $file_list = [
                $file_list,
            ];
        }

        $body = (isset($params['body'])) ? $params['body'] : '';
        $header = [
            'from'     => $params['from'],
            'fromName' => (isset($params['fromName'])) ? $params['fromName'] : '',
            'to'       => $params['to'],
            'bcc'      => (isset($params['bcc'])) ? $params['bcc'] : [],
            'subject'  => (isset($params['subject'])) ? $params['subject'] : '',
        ];
        Log::application()->debug('header::' . print_r($header, true));
        Log::application()->debug('body::' . print_r($body, true));
        try {
            // 送信
            $is_success_send = self::_send($header, $body, $file_list);
        } catch (Exception $e) {
            Log::application()->addError('メール送信失敗' . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage() , [
                'exception' => $e->getTraceAsString(),
            ]);
        }

        return $is_success_send;
    }

    /**
     * 一般的なメールを送信する
     *
     * @param  string $template_name
     * @param  array  $params
     * @param  array  $file_list
     * @return boolean
     */
    public static function send_standard_mail($template_name, $params = [], $file_list = []) {
        // メール送信用パラメータ
        $default_params = Config::get("template.$template_name");
        $to = $params['email'] ?? $default_params['to'] ?? '';
        $from = $params['from'] ?? $default_params['from'] ?? '';
        // 送信元 or 送信先がない場合は送信しない
        if (!isset($from) || !isset($to)) {
            return false;
        }

        $header = [
            'from'     => $from,
            'fromName' => $params['fromName'] ?? $default_params['fromName'] ?? '',
            'to'       => $to,
            'bcc'      => $params['bcc'] ?? $default_params['bcc'] ?? '',
            'subject'  => $params['subject'] ?? $default_params['subject'] ?? '',
        ];
        $template = $default_params['template'];
        $body = View_Twig::forge($template, $params);
        Log::application()->debug('header::' . var_export($header, true));
        Log::application()->debug('body::' . $body);

        if (!is_array($file_list)) {
            $file_list = [
                $file_list,
            ];
        }

        try {
            // 送信
            self::_send($header, $body, $file_list);
        } catch (Exception $e) {
            Log::application()->addError('メール送信失敗' . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
            ]);
        }

    }

    /**
     * エラーメールを送信する
     *
     * @param array $params バインド変数
     * @return boolean
     */
    public static function send_error_mail($message = null, $e = null, $file_list = []) {
        if (!is_array($file_list)) {
            $file_list = [
                $file_list,
            ];
        }
        $header = Config::get('template.error_mail');
        $body = self::_create_error_mail_body($header['template'], $message, $e, $file_list);
        Log::application()->debug('header::' . var_export($header, true));
        Log::application()->debug('body::' . $body);

        try {
            // 送信
            self::_send($header, $body, $file_list);
        } catch (Exception $e) {
            Log::application()->addError('メール送信失敗' . ',' . $e->getFile() . ',' . $e->getLine() . ',' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
            ]);
        }

    }

    /**
     * ユーザに送信するポイント付与済みメール本文を作成する
     *
     * @param string    $template テンプレートファイルのPATH
     * @param string    $params   バインド変数
     * @param string    $message  エラーメッセージ
     * @param Exception $e        例外
     * @return string body メール本文
     */
    private static function _create_error_mail_body($template, $message, $e, $file_list) {
        if (!isset($template)) {
            return '';
        }
        $bind_params = [
            'controller'    => is_null(\Request::main()) ? '' : \Request::main()->controller,
            'method'        => is_null(\Request::main()) ? '' : \Request::main()->action,
            'file_path'     => count($file_list) ? implode(PHP_EOL, $file_list) : '',
            'message'       => is_null($message) ? '' : $message,
            'error_message' => is_null($e) ? '' : $e->getMessage(),
            'user_id'       => self::$user_id,
            'business_id'   => self::$business_id,
            'stacktrace'    => is_null($e) ? '' : $e->getTraceAsString(),
        ];
        return View_Twig::forge($template, $bind_params);

    }

    /**
     * エラーメール用のユーザー情報をセットする
     *
     * @param int $user_id
     * @param int $business_id
     */
    public static function set_user_info($user_id, $business_id) {
        self::$user_id = $user_id;
        self::$business_id = $business_id;
    }
}
