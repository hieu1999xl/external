<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */
return [
    /**
     * アプリケーションのベース URL。相対指定することもできます。
     * 末尾は必ずスラッシュにする必要があります
     * ('/foo/', 'http://example.com/')
     */
    // 'base_url' => null,

    /**
     * Fuel によって生成される URL に追加するサフィックス。
     * サフィックスが拡張子の場合、ドットを含める必要があります。
     * ('.html')
     */
    // 'url_suffix' => '',

    /**
     * メインブートストラップファイル名です。
     * mod_rewirte を使用する場合は、これを false にするか削除します。
     */
    // 'index_file' => false,

    /**
     * プロファイラを有効にするかどうか
     */
    // 'profiling' => false,

    /**
     * キャッシュファイルを保存するディレクトリ。
     * このディレクトリを書き込み可能にする必要があります。
     */
    // 'cache_dir' => APPPATH.'cache/',

    /**
     * キャッシュを有効にするかどうか
     */
    // 'caching' => false,
    /**
     * キャッシュファイルの生存期間を秒単位で指定します。
     */
    // 'cache_lifetime' => 3600,

    /**
     * ob_start() に与えられるコールバックで、gzip 圧縮による出力を可能にする ob_gzhandler に設定される。
     */
    // 'ob_callback' => null,

    /**
     * エラーが検出された際の挙動を決める設定キーを格納する配列:
     */
    // 'errors' => array(
    /**
     * どの PHP エラーが発生したときに実行を続けるか。 エラー処理 を参照してください。
     */
    // 'continue_on' => array(),
    /**
     * 表示を止める前に出力するエラーの数 (out-of-memory エラーを避けます)
     */
    // 'throttle' => 10,
    /**
     * notice を表示するかどうか
     */
    // 'notices' => true,
    /**
     * Render previous contents or show it as HTML?
     */
    // 'render_prior' => false,
    // ),

    /**
     * アプリケーションのデフォルトの言語。 Lang クラス で使用します。
     */
    'language'            => 'ja',
    /**
     * 設定した言語が有効でない場合のdefault言語
     */
    'language_fallback'   => 'en',
    /**
     * PHP のインストールで必要な setlocale() を使用する場合、セットしている設定を禁止するために false をセットします。
     * この構文設定は OS 毎に異なります。例えば、Ubuntu は .utf8 (エンコーディング) サフィックスが必要です。
     */
    'locale'              => 'ja_JP.UTF-8',

    /**
     * アプリケーションのデフォルトの文字エンコード
     */
    'encoding'            => 'UTF-8',
    //
    /**
     * DateTime settings
     *
     * time() を使用する際に、サーバの gmt タイムスタンプのオフセットからのオフセット秒数
     * これは、不適切なサーバ設定を訂正するためのみの設定です: time() は絶えず 1970年1月1日 00:00:00 GMT からの秒数を返すべきです。
     */
    // 'server_gmt_offset' => 0,
    /**
     * サーバのタイムゾーン。
     */
    'default_timezone'    => 'Asia/Tokyo',

    /**
     * Logging Threshold.
     * Can be set to any of the following:
     *
     * Fuel::L_NONE
     * Fuel::L_ERROR
     * Fuel::L_WARNING
     * Fuel::L_DEBUG
     * Fuel::L_INFO
     * Fuel::L_ALL
     */
    /**
     * ログの閾値。どのレベルのメッセージからログを取るか、またはログを取りたいレベルの配列。 取り得る値について
     */
    'log_threshold'       => Fuel::L_NONE,
    /**
     * ログを保存するディレクトリ。このディレクトリを書き込み可能にする必要があります
     * ※monologカスタムのため、不要
     */
    // 'log_path' => APPPATH.'logs/',
    /**
     * ログで使用される date/time の書式。
     * ※monologカスタムのため、不要
     */
    // 'log_date_format' => 'Y-m-d H:i:s',

    /**
     * ログのレベル(debugログ以上を指定)
     */
    'log_level' => Fuel::L_DEBUG,

    /**
     * 自動メール送信のログレベル(debugログ以上を指定)
     */
    'error_mail_log_level' => Fuel::L_ERROR,

    /**
     * ログファイルの出力先
     */
    'log_file' => APPPATH . 'logs/application.log',

    /**
     * アプリケーションのセキュリティを操作する設定キーを格納する配列:
     */
    'security'            => [
        /**
         * true にすると、check_token() を使用して CSRF トークンを自動的にチェックする。
         * チェックに失敗すると SecurityException 例外が投げられる。
         */
        'csrf_autoload'       => false,
        /**
         * csrf_autoload を true にすると、この配列にある http メソッドすべてで CSRF トークンが検証される。
         */
        // 'csrf_autoload_methods' => array('post', 'put', 'delete'),
        /**
         * true にすると、 CSRF トークンの検証が失敗したときに HttpBadRequestException が投げられます。
         * false にすると、一般的な SecurityException が投げられます。後方互換のためデフォルトは false です。
         */
        // 'csrf_bad_request_on_fail' => false,

        /**
         * When true, Form::open() adds CSRF token hidden field automatically.
         */
        // 'csrf_auto_token' => false,
        /**
         * CSRF トークンクッキーの名前。トークンを含むフィールド名としても使用。
         */
        'csrf_token_key'      => 'fuel_csrf_token',
        /**
         * CRSF トークンクッキーの有効期限。デフォルトでは、ブラウザセッション終了時まで有効。
         */
        'csrf_expiration'     => 0,

        /**
         * 生成されるトークンを予測しにくくするためのソルト
         */
        // 'token_salt' => 'put your salt value here to make the token more secure',

        /**
         * "X" headers が存在するときに Input クラスから使用可能にするかどうか。
         * HTTP_X_FORWARDED_FOR や HTTP_X_FORWARDED_PROTO など。
         */
        // 'allow_x_headers' => false,

        /**
         * URI をフィルタする PHP 関数。xss_clean をセットできます。
         * これは入力のサイズに応じてパフォーマンスが犠牲になります。
         *
         * WARNING: Using xss_clean will cause a performance hit.
         * How much is dependant on how much input data there is.
         */
        'uri_filter'          => [
            'htmlentities',
        ],

        /**
         * 入力の配列 ($_GET, $_POST, $_COOKIE) をフィルタする PHP 関数。xss_clean をセットできます。
         * これは入力のサイズに応じてパフォーマンスが犠牲になります。
         */
        // 'input_filter' => array(),

        /**
         * ビューにセットする変数をフィルタする PHP 関数。
         * xss_clean をセットすることもできますが、 変数のサイズによりパフォーマンスに打撃を与える可能性があります。
         */
        'output_filter'     => [
            'Security::htmlentities',
        ],

        /**
         * 自動的にデータをエンコードするかどうか
         */
        // 'htmlentities_flags' => ENT_QUOTES,

        /**
         * エンコードされたものを再エンコードするかどうか。デフォルトは false
         */
        // 'htmlentities_double_encode' => false,

        /**
         * true にすると、ビューに渡すオブジェクトはすべて自動的にエンコードされる。
         */
        // 'auto_filter_output' => true,

        /**
         * ビューに渡す変数の自動エンコーディングが有効なとき、オブジェクトを渡すときに問題が生じることがある。
         * この配列で定義したクラスは自動エンコードされない。
         */
        'whitelisted_classes' => [
            'Fuel\\Core\\Presenter',
            'Fuel\\Core\\Response',
            'Fuel\\Core\\View',
            'Fuel\\Core\\ViewModel',
            'Closure',
        ],
    ],
    /**
     * グローバルなクッキーの設定を定義する設定キーを格納する配列：
     */
    // 'cookie' => array(
    /**
     * クッキーが期限切れになるまでの秒数
     */
    // 'expiration' => 0,
    /**
     * クッキーが有効なパスを制限する
     */
    // 'path' => '/',
    /**
     * クッキーが有効なドメインを制限する
     */
    // 'domain' => null,
    /**
     * セキュアな接続でのみクッキーを送信する
     */
    // 'secure' => false,
    /**
     * Javascript 接続を無効にし、 HTTP だけでクッキーを送信する
     */
    // 'http_only' => false,
    // ),

    /**
     * Validation settings
     */
    // 'validation' => array(
    /**
     * true にした場合で、入力された配列に値が見つからなかった場合、値は Input::param になります。
     */
    // 'global_input_fallback' => true,
    // ),

    /**
     * URI をコントローラのクラス名にマッピングする際にコントローラを見つけるのに仕様されるクラスのプレフィックス。
     * コントローラを名前空間に置きたい、または app/classes/controller とは別の場所に置きたい場合に、 この値を変更する必要があります。
     */
    // 'controller_prefix' => 'Controller_',

    /**
     * Routing settings
     */
    // 'routing' => array(
    /**
     * もし false の場合、新しいルートは URI の大文字小文字を区別しないとしてマッチさせます。
     * もし true の場合、マッチは大文字小文字を区別します。もし指定がなければ、設定されているデフォルトが使われます。
     */
    // 'case_sensitive' => true,

    /**
     * Whether to strip the extension
     */
    // 'strip_extension' => true,
    // ),

    /**
     * モジュールのディレクトリへのパス。場所を指定せずにモジュールを追加するときに使われます。
     * By default empty, but to use them you can add something
     * like this:
     * array(APPPATH.'modules'.DS)
     *
     * Paths MUST end with a directory separator (the DS constant)!
     */
    // 'module_paths' => array(
    // //APPPATH.'modules'.DS
    // ),

    /**
     * To enable you to split up your additions to the framework, packages are
     * used.
     * You can define the basepaths for your packages here. By default
     * empty, but to use them you can add something like this:
     * array(APPPATH.'modules'.DS)
     *
     * Paths MUST end with a directory separator (the DS constant)!
     */
    'package_paths'       => [
        PKGPATH,
    ],
    /**
     * ***********************************************************************
     */
    /* 初期化時にフレームワークが読み込まなければならないアイテムを格納する配列： */
    /**
     * ***********************************************************************
     */
    'always_load'         => [
        /**
         * These packages are loaded on Fuel's startup.
         * You can specify them in the following manner:
         *
         * array('auth'); // This will assume the packages are in PKGPATH
         *
         * // Use this format to specify the path to the package explicitly
         * array(
         * array('auth' => PKGPATH.'auth/')
         * );
         */
        'packages' => [
            'orm',
            'parser',
            'email',
            'casset',
        ],
        'config'   => [
            'breadcrumb'     => 'breadcrumb',
            'const'          => 'const',
            'db'             => 'db',
            'retry'          => 'retry',
            'parser'         => 'parser',
            'stub'           => 'stub',
            'rules'          => 'rules',
            'external'       => 'external',
            'template'       => 'template',
            'title'          => 'title',
            'maintenance'    => 'maintenance',
            'canonical'      => 'canonical',
            'description'    => 'description',
            'gmoerrorcode'   => 'gmoerrorcode',
            'pagination'     => 'pagination',
            'atoneerrorcode' => 'AtoneErrorCode',
            'ses'            => 'ses',
            's3'             => 's3',
            'cssfile'        => 'cssfile',
        ],
        'language' => [
            'messages' => 'messages',
        ],
    ],
];

/**
 * These modules are always loaded on Fuel's startup.
 * You can specify them
 * in the following manner:
 *
 * array('module_name');
 *
 * A path must be set in module_paths for this to work.
 */
// 'modules' => array(),

/**
 * Classes to autoload & initialize even when not used
 */
// 'classes' => array(),

/**
 * Configs to autoload
 *
 * Examples: if you want to load 'session' config into a group 'session' you only have to
 * add 'session'. If you want to add it to another group (example: 'auth') you have to
 * add it like 'session' => 'auth'.
 * If you don't want the config in a group use null as groupname.
 */
// 'config' => array(),

/**
 * Language files to autoload
 *
 * Examples: if you want to load 'validation' lang into a group 'validation' you only have to
 * add 'validation'. If you want to add it to another group (example: 'forms') you have to
 * add it like 'validation' => 'forms'.
 * If you don't want the lang in a group use null as groupname.
 */
// 'language' => array(),
