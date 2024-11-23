<?php

// 終了時にエラーログが出ていればエラーメールを出す
register_shutdown_function(function(){
    $last_error = error_get_last();
    $fatal_levels = array(E_PARSE, E_ERROR, E_USER_ERROR, E_COMPILE_ERROR);

    if ($last_error AND in_array($last_error['type'], $fatal_levels)){
        Log::application()->info('Server : ' .var_export($_SERVER, true));
        Log::application()->info('Cookie : ' .var_export($_COOKIE, true));

        Log::application()->error(var_export($last_error, true), array(
            'Fatal Error' => $last_error
        ));
        Helper_Mail::send_error_mail('予期せぬエラー', new Exception(var_export($last_error, true)));

        $redirectUrl = Uri::create('_500_');
        Response::redirect($redirectUrl);
    }
});

// Bootstrap the framework DO NOT edit this
require COREPATH . 'bootstrap.php';

\Autoloader::add_classes(array(
    'Log' => APPPATH . 'classes/log.php',
    'Log_Handler' => APPPATH . 'classes/log/handler.php',
    'Log_Logger' => APPPATH . 'classes/log/logger.php',
    'Log_NativeMailHandler' => APPPATH . 'classes/log/nativemailhandler.php',
    'Database_PDO_Connection' => APPPATH . 'classes/database/pdo/connection.php',
    'Database_Query' => APPPATH . 'classes/database/query.php',
    'Email_Driver_Smtp' => APPPATH . 'classes/email/driver/smtp.php',
    'Errorhandler' => APPPATH . 'classes/errorhandler.php',
    'Fieldset' => APPPATH . 'classes/fieldset.php',
    'Format' => APPPATH . 'classes/format.php',
    'Pagination' => APPPATH . 'classes/pagination.php',
    'Security' => APPPATH . 'classes/security.php',
    'Session_File' => APPPATH . 'classes/session/file.php',
    'Validation' => APPPATH . 'classes/validation.php',
    'Validation_Error' => APPPATH . 'classes/validation/error.php',
));

// Register the autoloader
\Autoloader::register();

/**
 * Your environment.
 * Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
// 環境切り替え設定
// _/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
switch (true) {
    case (getenv('HUMANENV') === 'LOCAL') :
        // ローカル環境
        Fuel::$env = 'local';
        break;
    case (getenv('HUMANENV') === 'TEST') :
        // テスト環境
        Fuel::$env = Fuel::TEST;
        break;
    case (getenv('HUMANENV') === 'DEV') :
        // 開発環境
        Fuel::$env = Fuel::DEVELOPMENT;
        break;
    case (getenv('HUMANENV') === 'STAG') :
        // ステージング環境
        Fuel::$env = Fuel::STAGING;
        break;
    case (getenv('HUMANENV') === 'PROD') :
        // 本番環境
        Fuel::$env = Fuel::PRODUCTION;
        break;
    default :
        // 未設定時
        die('環境設定がされておりません');
        break;
}

// 定数ファイル読み込み
require_once APPPATH . 'config' . DIRECTORY_SEPARATOR . 'master.php';

// Initialize the framework with the config file.
\Fuel::init('config.php');
