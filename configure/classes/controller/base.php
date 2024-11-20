<?php

use Parser\View_Twig;

/**
 * コントローラ基底クラス
 *
 * @author sakairi@liz-inc.co.jp
 */
class Controller_Base extends Controller {
    /**
     * ログインがチェックが必要かどうか
     *
     * @var bool
     */
    protected $required_login = true;

    /**
     * ログインしていない場合のみにアクセスできる画面の設定
     * デフォルトはログインしていなければアクセスできない
     *
     * @var bool
     */
    protected $not_login_access_only = false;

    /**
     * ログインしていても未ログインでもアクセスできる画面の設定
     * ルーティングされるメソッドで独自に実装したい場合にも使用できる
     *
     * @var bool
     */
    protected $is_anyone_access = false;

    /**
     * メンテナンス画面の処理であるかどうか
     *
     * @var bool
     */
    protected $is_maintenance_process = false;

    /**
     * ログインしているかどうか
     *
     * @var bool
     */
    protected $is_login = false;

    /**
     * ログインしているかどうか
     *
     * @var bool
     */
    protected $corporate_user_only = false;

    /**
     * ログインしているかどうか
     *
     * @var bool
     */
    protected $private_user_only = false;

    /**
     * ユーザーID
     *
     * @var int
     */
    protected $user_id;

    /**
     * メールアドレス
     *
     * @var string
     */
    protected $email;

    /**
     * ユーザー種別
     *
     * @var int
     */
    protected $user_type;

    /**
     * ユーザー名（姓）
     *
     * @var string
     */
    protected $last_name;

    /**
     * ユーザー名（名）
     *
     * @var string
     */
    protected $first_name;

    /**
     * 法人ID
     *
     * @var int
     */
    protected $company_id;

    /**
     * ユーザー情報
     *
     * @var array
     */
    protected $user_info;

    /**
     * ヘッダメニュー非表示リスト
     * @var array
     */
    protected $not_available_list = [];

    /**
     * ヘッダーメニューにレイアウト崩れ対策メニューが必要かどうか
     * @var boolean
     */
    protected $is_need_fake_header_menu = false;

    protected $can_charge_data = false;

    /**
     * 真なら法人の利用規約ダウンロードリンクのURLを専用のURLに変更する
     */
    protected $is_corp = false;

    /**
     * 真なら利用規約のダウンロードリンクを非表示にする
     */
    protected $hide_contract_service = false;

    /**
     * 真なら覚書のダウンロードリンクを表示する
     */
    protected $is_memorandum = false;

    /**
     * 支払い方法
     *
     * @var int
     */
    protected $settlement_type_value;

    /**
     * 支払い方法リスト
     *
     * @var array
     */
    protected $settlement_type_value_list = [];

    /**
     * 真なら海外レンタルプランのimei連携が済んでいる
     */
    protected $is_rental_contract = false;

    /**
     * 真なら海外レンタルプランの追加が可能
     */
    protected $is_rental_plan_add = false;

    /**
     * 真なら海外レンタルプランの変更が可能
     */
    protected $is_rental_plan_change = false;

    /**
     * 真なら海外レンタルプランの延長が可能
     */
    protected $is_rental_plan_extension = false;

    /**
     * 真なら海外レンタルプランでimei連携済
     */
    protected $is_rental_import_imei = false;

    /**
     * 真なら海外レンタルプランでimei連携解除済
     */
    protected $is_rental_unbind_device = false;

    /**
     * 配送会社情報
     *
     * @var array
     */
    protected $delivery_company_info = [];

    /**
     * BASIC認証
     *
     * @var bool
     */
    protected $access_basic_authenticate = false;

    /**
     * セッション格納キー:流入元
     *
     * @var string
     */
    public static $SES_KEY_INFLOW_SOURCE = "InflowSource";

    /**
     * セッション格納キー:流入元履歴用配列
     *
     * @var string
     */
    public static $SES_KEY_INFLOW_SOURCE_ARRAY = "InflowSourceArray";

    /**
     * セッション格納キー:流入元がa8かgmoかどうか
     *
     * アフィリエイト成果計測のため、下記セッションに格納される流入元ソースを変更
     * $SES_KEY_IS_HI_A8_INFLOW_SOURCE、$SES_KEY_IS_HI_GMO_INFLOW_SOURCE、$SES_KEY_IS_AFB_INFLOW_SOURCE
     */
    public static $SES_KEY_IS_A8_INFLOW_SOURCE = "IsA8InflowSource";
    public static $SES_KEY_IS_HI_A8_INFLOW_SOURCE = "IsHiA8InflowSource";
    public static $SES_KEY_IS_GMO_INFLOW_SOURCE = "IsGmoInflowSource";
    public static $SES_KEY_IS_HI_GMO_INFLOW_SOURCE = "IsHiGmoInflowSource";
    public static $SES_KEY_IS_HI_ASP_INFLOW_SOURCE = "IsHiAspInflowSource";
    public static $SES_KEY_IS_AFB_INFLOW_SOURCE = "IsAfbInflowSource";
    public static $SES_KEY_IS_ADREX_INFLOW_SOURCE = "IsAdrexInflowSource";
    public static $SES_KEY_IS_PRESCO_INFLOW_SOURCE = "IsPrescoInflowSource";
    public static $SES_KEY_IS_BIZMOTION_INFLOW_SOURCE = "IsBizMotionInflowSource";

    /**
     * セッション格納キー:プロモーション（LP流入元）
     *
     * @var string
     */
    public static $SES_KEY_PROMOTION = "Promotion";

    /**
     * セッション格納キー:しばり有無
     *
     * @var string
     */
    public static $SES_KEY_TIE = "Tie";

    /**
     * セッション格納キー:プラン容量
     *
     * @var string
     */
    public static $SES_KEY_PLAN = "Plan_id";

    /**
     * {@inheritDoc}
     *
     * @see \Fuel\Core\Controller::before()
     */
    public static $SES_KEY_INPUT_INFO = "InputInfo";

    /**
     * {@inheritDoc}
     *
     * @see \Fuel\Core\Controller::before()
     */
    public static $SES_KEY_CONTACT_INPUT_INFO = "ContactInputInfo";
    public static $SES_KEY_WIMAX_CONTACT_INPUT_INFO = "WimaxContactInputInfo";
    public static $SES_KEY_GLOBAL_CONTACT_INPUT_INFO = "GlobalContactInputInfo";
    public static $SES_KEY_PREPAID_CONTACT_INPUT_INFO = "PrepaidContactInputInfo";

    /**
     * セッション格納キー:プロモーションイベント情報
     *
     * @var string
     */
    public static $SES_KEY_PROMOTION_EVENT_INFO = "PromotionEvent";

    /**
     * セッション格納キー:初期契約解除申請フォーム情報
     *
     * @var string
     */
    public static $SES_KEY_INITIAL_CONTRACT_CANCEL = "InitialContractCancel";

    /**
     * セッション格納キー:GMOからのPOSTか判断するためのセッション情報(key名)
     *
     * @var string
     */
    public static $SES_KEY_CALLBACK_IS_GMO = 'CallbackIsGmo';

    /**
     * セッション格納キー:GMOからのPOSTか判断するためのセッション情報(値)
     *
     * @var bool
     */
    public static $SES_KEY_VALUE_CALLBACK_IS_GMO = true;

    /**
     * セッション格納キー:ユーザーID
     *
     * @var string
     */
    public static $SES_KEY_USER_ID = "UserId";

    public function before() {
        parent::before();
        Log::application()->info('Controller Start');
        Log::application()->info('共通処理開始');

        if (Fuel::$env === Fuel::PRODUCTION || Fuel::$env === Fuel::STAGING || Fuel::$env === 'local') {
            if ($this->access_basic_authenticate) {
                // 電話受付の本番、ステージング、ローカル環境のBASIC認証を付ける
                $this->http_basic_authenticate_with();
            }
        }

        // メンテナンスチェック
        if ($this->is_maintenance()) {
            if (!$this->is_maintenance_process) {
                // メンテナンス中の場合かつ、
                // メンテナンス画面の処理でない場合
                // メンテナンス画面に遷移
                Log::application()->info('メンテナンス中のため、メンテナンスページにリダイレクト');
                Response::redirect(Router::get('maintenance'), 'location', HTTP_STATUS_UNAUTHORIZED);
            }
        } else {
            if ($this->is_maintenance_process) {
                // メンテナンス中でない場合かつ、
                // メンテナンス画面の処理の場合
                // TOPに遷移

                // 流入元判断用のパラメータ
                $inflow_source = Session::get(self::$SES_KEY_INFLOW_SOURCE, []);
                if (empty($inflow_source) ||
                    (
                        (Input::get('h_source', '') != '' && Input::get('h_medium', '') != '') ||
                        (Input::get('utm_source', '') != '' && Input::get('utm_medium', '') != '')
                    )
                ) {
                    Session::set(self::$SES_KEY_INFLOW_SOURCE, [
                        'h_source' => Input::get('h_source', ''),
                        'h_medium' => Input::get('h_medium', ''),
                        'h_campaignid' => Input::get('h_campaignid', ''),
                        'h_adgroupid' => Input::get('h_adgroupid', ''),
                        'h_targetid' => Input::get('h_targetid', ''),
                        'h_creativeid' => Input::get('h_creativeid', ''),
                        'h_addevice' => Input::get('h_addevice', ''),
                        'h_devicemodel' => Input::get('h_devicemodel', ''),
                        'h_lp' => Input::get('h_lp', ''),
                        'h_term' => Input::get('h_term', ''),
                        'h_matchtype' => Input::get('h_matchtype', ''),
                        'h_position' => Input::get('h_position', ''),
                        'h_network' => Input::get('h_network', ''),
                        'h_area' => Input::get('h_area', ''),
                        'h_campaign' => Input::get('h_campaign', ''),
                        'h_group' => Input::get('h_group', ''),
                        'h_content' => Input::get('h_content', ''),
                        'utm_source' => Input::get('utm_source', ''),
                        'utm_medium' => Input::get('utm_medium', ''),
                        'utm_campaignid' => Input::get('utm_campaignid', ''),
                        'utm_adgroupid' => Input::get('utm_adgroupid', ''),
                        'utm_targetid' => Input::get('utm_targetid', ''),
                        'utm_creativeid' => Input::get('utm_creativeid', ''),
                        'utm_addevice' => Input::get('utm_addevice', ''),
                        'utm_devicemodel' => Input::get('utm_devicemodel', ''),
                        'utm_lp' => Input::get('utm_lp', ''),
                        'utm_term' => Input::get('utm_term', ''),
                        'utm_matchtype' => Input::get('utm_matchtype', ''),
                        'utm_position' => Input::get('utm_position', ''),
                        'utm_network' => Input::get('utm_network', ''),
                        'utm_area' => Input::get('utm_area', ''),
                        'utm_campaign' => Input::get('utm_campaign', ''),
                        'utm_group' => Input::get('utm_group', ''),
                        'utm_content' => Input::get('utm_content', ''),
                        'affid' => Input::get('s', ''),
                        'gclid' => Input::get('gclid', ''),
                        'yclid' => Input::get('yclid', ''),
                        'msclkid' => Input::get('msclkid', ''),
                        'af' => Input::get('af', ''),
                        'change_plan_distinction' => Input::get('change_plan_distinction', ''),
                        'xuid' => Input::get('admage_istation_xuid', ''),
                    ]);
                }

                Log::application()->info('メンテナンス中でないため、TOPにリダイレクト');
                Response::redirect(Uri::base(), 'location', HTTP_STATUS_FOUND);
            }
        }

        // 流入元判断用のパラメータ
        $inflow_source = Session::get(self::$SES_KEY_INFLOW_SOURCE, []);
        $inflow_source_array = Session::get(self::$SES_KEY_INFLOW_SOURCE_ARRAY, []);
        if (empty($inflow_source) ||
           (Input::get('h_source', '') != '' && Input::get('h_medium', '') != '') ||
           (Input::get('utm_source', '') != '' && Input::get('utm_medium', '') != '')
        ) {
            Session::set(self::$SES_KEY_INFLOW_SOURCE, [
                'h_source' => Input::get('h_source', ''),
                'h_medium' => Input::get('h_medium', ''),
                'h_campaignid' => Input::get('h_campaignid', ''),
                'h_adgroupid' => Input::get('h_adgroupid', ''),
                'h_targetid' => Input::get('h_targetid', ''),
                'h_creativeid' => Input::get('h_creativeid', ''),
                'h_addevice' => Input::get('h_addevice', ''),
                'h_devicemodel' => Input::get('h_devicemodel', ''),
                'h_lp' => Input::get('h_lp', ''),
                'h_term' => Input::get('h_term', ''),
                'h_matchtype' => Input::get('h_matchtype', ''),
                'h_position' => Input::get('h_position', ''),
                'h_network' => Input::get('h_network', ''),
                'h_area' => Input::get('h_area', ''),
                'h_campaign' => Input::get('h_campaign', ''),
                'h_group' => Input::get('h_group', ''),
                'h_content' => Input::get('h_content', ''),
                'utm_source' => Input::get('utm_source', ''),
                'utm_medium' => Input::get('utm_medium', ''),
                'utm_campaignid' => Input::get('utm_campaignid', ''),
                'utm_adgroupid' => Input::get('utm_adgroupid', ''),
                'utm_targetid' => Input::get('utm_targetid', ''),
                'utm_creativeid' => Input::get('utm_creativeid', ''),
                'utm_addevice' => Input::get('utm_addevice', ''),
                'utm_devicemodel' => Input::get('utm_devicemodel', ''),
                'utm_lp' => Input::get('utm_lp', ''),
                'utm_term' => Input::get('utm_term', ''),
                'utm_matchtype' => Input::get('utm_matchtype', ''),
                'utm_position' => Input::get('utm_position', ''),
                'utm_network' => Input::get('utm_network', ''),
                'utm_area' => Input::get('utm_area', ''),
                'utm_campaign' => Input::get('utm_campaign', ''),
                'utm_group' => Input::get('utm_group', ''),
                'utm_content' => Input::get('utm_content', ''),
                'affid' => Input::get('s', ''),
                'gclid' => Input::get('gclid', ''),
                'yclid' => Input::get('yclid', ''),
                'msclkid' => Input::get('msclkid', ''),
                'af' => Input::get('af', ''),
                'change_plan_distinction' => Input::get('change_plan_distinction', ''),
                'xuid' => Input::get('admage_istation_xuid', ''),
            ]);
            $inflow_source_array[] = [
                'utm_source'      => Input::get('utm_source', ''),
                'utm_medium'      => Input::get('utm_medium', ''),
                'gclid'           => Input::get('gclid', ''),
                'yclid'           => Input::get('yclid', ''),
                'msclkid'         => Input::get('msclkid', ''),
                'referrer'        => Input::referrer(),
                'url'             => $this->request->route->controller_path,
                'access_datetime' => Helper_Time::getCurrentDateTime(),
            ];
            Session::set(self::$SES_KEY_INFLOW_SOURCE_ARRAY, $inflow_source_array);
        }

        // プロモーション（LP流入元）のパラメータ
        $promotion = Session::get(self::$SES_KEY_PROMOTION, '');
        if (empty($promotion) || (Input::get('promotion', '') != '')) {
            Session::set(self::$SES_KEY_PROMOTION, Input::get('promotion', ''));
        }

        // しばり有無のパラメータ
        $tie = Session::get(self::$SES_KEY_TIE, '');
        if (empty($tie) || (Input::get('tie', '') != '')) {
            Session::set(self::$SES_KEY_TIE, Input::get('tie', ''));
        }

        // プラン容量のパラメータ
        $plan = Session::get(self::$SES_KEY_PLAN, '');
        if (empty($plan) || (Input::get('plan_id', '') != '')) {
            Session::set(self::$SES_KEY_PLAN, Input::get('plan_id', ''));
        }

        // URIからplan_typeを判定する(/mypage/*系限定)
        $uri = $_SERVER['REQUEST_URI'];
        $uri_array = explode('/', $uri);
        $uri_1 = $uri_array[1] ?? '';
        $uri_2 = $uri_array[2] ?? '';

        if ($uri_1 === 'mypage' && $uri_2 === 'prepaid') {
            // CHARGEプラン(プリペイド)
            $uri_plan_plan_type = PLAN_TYPE_INTERNATIONAL_PREPAID;
        } else if ($uri_1 === 'mypage' && $uri_2 === 'rental') {
            // 海外レンタルプラン
            $uri_plan_plan_type = PLAN_TYPE_INTERNATIONAL_RENTAL;
        } else {
            // それ以外
            $uri_plan_plan_type = PLAN_TYPE_DOMESTIC;
        }

        // plan_typeを判定する
        // セッション ＞ getパラメータ ＞ URIの優先度で判定
        $plan_type = Session::get('plan_type', NULL) ?? Input::get('plan_type', NULL) ?? $uri_plan_plan_type;
        // ログイン先判定
        switch ($plan_type) {
            case PLAN_TYPE_INTERNATIONAL_PREPAID:
                $prefix = 'prepaid_';
                break;

            // 海外レンタルプラン
            case PLAN_TYPE_INTERNATIONAL_RENTAL:
                $prefix = 'rental_';
                break;

            // 国内プラン
            default:
                $prefix = '';
                break;
        }

        // ログインチェック
        if ($this->required_login) {
            if ($this->is_login()) {
                $this->is_login = true;
            }

            if (!$this->is_login && !$this->not_login_access_only && !$this->is_anyone_access) {
                // ログインしていないかつ、
                // ログイン時のみにアクセスできる画面の場合、
                // ログイン画面にリダイレクト
                Log::application()->info('未ログインのため、ログイン画面にリダイレクト');

                if (strstr(Uri::string(), 'mypage/contract/rental') !== false ||
                    strstr(Uri::string(), 'mypage/data-flow/rental') !== false ||
                    strstr(Uri::string(), 'mypage/payment-history/rental') !== false ||
                    strstr(Uri::string(), 'mypage/rental') !== false ||
                    strstr(Uri::string(), 'rental/add') !== false ||
                    strstr(Uri::string(), 'rental/extension') !== false ||
                    strstr(Uri::string(), 'rental/change') !== false) {
                    Response::redirect(Router::get('rental_login'). '?next=/' . Uri::string(), 'location', HTTP_STATUS_UNAUTHORIZED);
                } else {
                    Response::redirect(Router::get($prefix . 'login'). '?next=/' . Uri::string(), 'location', HTTP_STATUS_UNAUTHORIZED);
                }
            }

            if ($this->is_login && $this->not_login_access_only && !$this->is_anyone_access) {
                // ログイン済みかつ、
                // ログイン時にアクセスできない画面の場合
                // マイページTOPにリダイレクト
                Log::application()->info('ログイン済みのため、マイページTOPにリダイレクト');
                if ($this->user_type == USER_TYPE_LIST['CORPORATE']) {
                    Response::redirect(Router::get('corpmypage_top'), 'location', HTTP_STATUS_FOUND);
                } elseif ($this->user_type == USER_TYPE_LIST["PRIVATE"]) {
                    $next = Input::post('next', '');
                    if (!empty($next)) {
                        Response::redirect($next, 'location', HTTP_STATUS_FOUND);
                    } else {
                        Response::redirect(Router::get('mypage_top'), 'location', HTTP_STATUS_FOUND);
                    }
                    Response::redirect(Router::get('mypage_top'), 'location', HTTP_STATUS_FOUND);
                }
            }

            if ($this->is_login && $this->corporate_user_only) {
                // ログイン済みかつ、
                // ログイン時にアクセスできない画面の場合
                // マイページTOPにリダイレクト
                if ($this->user_type != USER_TYPE_LIST['CORPORATE']) {
                    Response::redirect(Router::get('notfound'), 'location', HTTP_STATUS_NOT_FOUND);
                }
            }

            if ($this->is_login && $this->private_user_only) {
                // ログイン済みかつ、
                // ログイン時にアクセスできない画面の場合
                // マイページTOPにリダイレクト
                if ($this->user_type != USER_TYPE_LIST["PRIVATE"]) {
                    Response::redirect(Router::get('notfound'), 'location', HTTP_STATUS_NOT_FOUND);
                }
            }
        }

        Log::application()->info('共通処理終了');
    }

    /**
     * {@inheritDoc}
     *
     * @see \Fuel\Core\Controller::after()
     */
    public function after($response) {
        Log::application()->info('Controller End');
        $response->set_header('X-FRAME-OPTIONS', 'SAMEORIGIN');
        return parent::after($response);
    }

    /**
     * Returns a new View object.
     *
     * @param string $file
     * @param array  $data
     * @param array  $safe_list
     * @param bool   $auto_filter
     * @param int    $http_status
     * @return \Fuel\Core\Response
     */
    protected function view($file, $data = [], $safe_list = [], $auto_filter = null, $http_status = HTTP_STATUS_OK) {
        // 共通項目をセットする
        // 一時セッションからメッセージを取得
        $data['messages'] = array_unique(Session::get_flash('messages', []));
        // 一時セッションからエラーメッセージを取得
        $data['errors'] = array_unique(Session::get_flash('errors', []));

        // 基本情報をセット
        // ログインしているかどうか
        $data['is_login'] = $this->is_login;
        // 法人ユーザーかどうか
        $data['is_company_user'] = $this->user_type == USER_TYPE_LIST['CORPORATE'];
        // ユーザー名
        $data['login_last_name'] = $this->last_name;
        $data['login_first_name'] = $this->first_name;
        $data['can_charge_data'] = $this->can_charge_data;
        // メニュー用のURLをセット
        // マイページTOP
        $data['mypage_top_url'] = Router::get('mypage_top');
        // ご契約情報確認画面
        $data['index_contract_url'] = Router::get('index_contract');
        // お客様情報確認画面
        $data['show_user_url'] = Router::get('show_user');
        // 利用明細画面
        $data['payment_history_url'] = Router::get('payment_history');
        // データ利用量画面
        $data['data_flow_url'] = Router::get('data_flow');
        // 海外データ詳細
        $data['data_flow_overseas_url'] = Router::get('data_flow_overseas');
        // サポート画面
        $data['support_url'] = Router::get('support');
        // 海外データプラン画面
        $data['mypage_overseas_url'] = Router::get('index_overseas');
        // 海外データプラン購入処理画面
        $data['post_overseas_url'] = Router::get('post_edit_overseas');
        // マイページ初期契約解除画面
        $data['mypage_contract_initial_cancel_url'] = Router::get('mypage_contract_initial_cancel');
        // マイページ初期契約解除画面
        $data['mypage_anshin_kaiyaku_url'] = Router::get('mypage_anshin_kaiyaku');
        // マイページ デジタルライフサポート申し込み画面
        $data['mypage_insurance_option_url'] = Router::get('mypage_insurance_option');
        // データチャージプラン購入画面
        $data['mypage_data_flow_edit_url'] = Router::get('get_data_flow_edit');
        // データチャージプラン購入処理
        $data['mypage_data_flow_post_edit_url'] = Router::get('post_data_flow_edit');
        // プラン変更
        $data['plan_change_url'] = Router::get('plan_change');
        // プラン変更完了画面
        $data['plan_change_complete_url'] = Router::get('plan_change_complete');
        // プラン変更完了画面
        $data['plan_change_cancel_complete_url'] = Router::get('plan_change_cancel_complete');
        // 秋キャンペーン用 データチャージ受取画面
        $data['mypage_data_flow_edit_campaign_url'] = Router::get('edit_campaign');
        // 秋キャンペーン用 データチャージ受取処理
        $data['mypage_data_flow_post_edit_campaign_url'] = Router::get('edit_campaign');
        // CHARGEプラン(プリペイド)ログイン画面
        $data['prepaid_login_url'] = Router::get('prepaid_login');
        // 海外レンタルログイン画面
        $data['rental_login_url'] = Router::get('rental_login');
        // 海外レンタルマイページTOP
        $data['mypage_top_rental_url'] = Router::get('mypage_top_rental');
        // ご契約情報画面(海外レンタル)
        $data['mypage_overseas_rental_contract_url'] = Router::get('index_contract_rental');
        // 利用明細画面(海外レンタル)
        $data['mypage_overseas_rental_payment_history_url'] = Router::get('payment_history_rental');
        // ご利用状況画面(海外レンタル)
        $data['mypage_overseas_rental_data_flow_url'] = Router::get('data_flow_rental');
        // 海外データレンタルプラン追加画面
        $data['mypage_overseas_rental_add_url'] = Router::get('get_add_overseas_rental', ['id' => isset($data['contract_id']) ? $data['contract_id'] : '']);
        // 海外データレンタルプラン延長画面
        $data['mypage_overseas_rental_extension_url'] = Router::get('get_extension_overseas_rental', ['id' => isset($data['contract_id']) ? $data['contract_id'] : '']);
        // 海外データレンタルプラン変更画面
        $data['mypage_overseas_rental_change_url'] = Router::get('get_change_overseas_rental', ['id' => isset($data['contract_id']) ? $data['contract_id'] : '']);

        // 海外データレンタルプラン追加処理
        $data['post_mypage_overseas_rental_add_url'] = Router::get('post_add_overseas_rental');
        // 海外データレンタルプラン延長処理
        $data['post_mypage_overseas_rental_extension_url'] = Router::get('post_extension_overseas_rental');
        // 海外データレンタルプラン変更処理
        $data['post_mypage_overseas_rental_change_url'] = Router::get('post_change_overseas_rental');

        // CHARGEプラン(プリペイド)マイページTOP
        $data['mypage_top_prepaid_url']      = Router::get('mypage_top_prepaid');
        // CHARGEプラン(プリペイド)利用明細
        $data['payment_history_prepaid_url'] = Router::get('payment_history_prepaid');
        // CHARGEプラン(プリペイド)申込内容確認 過去情報
        $data['index_contract_prepaid_url']  = Router::get('index_contract_prepaid');
        // CHARGEプラン(プリペイド)端末オプション購入画面
        $data['prepaid_contract_option_edit_url']  = Router::get('get_prepaid_contract_option_edit');
        // CHARGEプラン(プリペイド)端末オプション購入完了画面
        $data['prepaid_contract_option_complete_url']  = Router::get('post_prepaid_contract_option_complete');
        // CHARGEプラン(プリペイド)会員情報確認 変更
        $data['show_user_prepaid_url']       = Router::get('show_user_prepaid');
        // CHARGEプラン(プリペイド)現在の利用状況 データ残量
        $data['data_flow_prepaid_url']       = Router::get('data_flow_prepaid');
        // CHARGEプラン(プリペイド)パスワード変更
        $data['edit_password_prepaid_url']   = Router::get('prepaid_edit_password');
        // CHARGEプラン(プリペイド)/国内プラン購入ページ
        $data['edit_prepaid_add_plan_domestic_url']   = Router::get('get_prepaid_add_plan_domestic_edit');
        // CHARGEプラン(プリペイド)/海外プラン購入ページ
        $data['edit_prepaid_add_plan_overseas_url']   = Router::get('get_prepaid_add_plan_overseas_edit');
        // CHARGEプラン(プリペイド)/国内データチャージプラン購入ページ
        $data['edit_prepaid_add_plan_data_flow_edit_url']   = Router::get('get_prepaid_add_plan_data_flow_edit');
        // CHARGEプラン(プリペイド)/プラン購入完了ページ
        $data['post_prepaid_add_plan_complete_url']   = Router::get('post_prepaid_add_plan_complete');
        // CHARGEプラン(プリペイド)/プラン延長処理
        $data['post_prepaid_extension_complete_url']   = Router::get('post_prepaid_extension_complete');
        // CHARGEプラン(プリペイド)/海外プラン期間延長ページ
        $data['extension_prepaid_add_plan_overseas_url']   = Router::get('get_prepaid_add_plan_overseas_extension');
        // CHARGEプラン(プリペイド)/海外プラン容量変更ページ
        $data['change_prepaid_add_plan_overseas_url']   = Router::get('get_prepaid_add_plan_overseas_change');
        // CHARGEプラン(プリペイド)/海外プラン容量変更処理
        $data['post_prepaid_change_complete_url']   = Router::get('post_prepaid_change_complete');
        // CHARGEプラン(プリペイド)LP
        $data['prepaid_lp_url']    = Router::get('prepaid_lp');
        // CHARGEプラン(プリペイド)パスワード忘れた方画面
        $data['prepaid_forget_password']    = Router::get('prepaid_forget');

        // 法人マイページTOP
        $data['corpmypage_top_url'] = Router::get('corpmypage_top');
        // ご契約情報確認画面
        $data['corp_index_contract_url'] = Router::get('corp_index_contract');
        // お客様情報確認画面
        $data['corp_show_user_url'] = Router::get('show_corp_user');
        $data['uploadfile_url'] = Router::get('entry_corp_uploadfile');
        // ご契約情報選択画面
        $data['corp_choose_contract_url'] = Router::get('get_corp_choose_contract');
        // ご契約情報選択画面
        $data['corp_choose_cancel_contract_url'] = Router::get('get_corp_choose_contract_cancel');
        // 利用明細画面
        $data['corp_payment_history_url'] = Router::get('corp_payment_history');
        // データ利用量画面
        $data['corp_data_flow_url'] = Router::get('corp_data_flow');
        // サポート画面
        $data['corp_support_url'] = Router::get('corp_support');
        //法人データチャージプラン購入画面
        $data['corpmypage_data_flow_edit_url'] = Router::get('corp_get_data_flow_edit');
        // 法人データチャージプラン購入処理
        $data['corpmypage_data_flow_post_edit_url'] = Router::get('corp_post_data_flow_edit');
        // 秋キャンペーン用 データチャージ受取画面
        $data['corpmypage_data_flow_edit_campaign_url'] = Router::get('corp_edit_campaign');
        // 秋キャンペーン用 データチャージ受取処理
        $data['corpmypage_data_flow_post_edit_campaign_url'] = Router::get('corp_post_edit_campaign');
        // 海外データプラン画面
        $data['corp_overseas_url'] = Router::get('index_corp_overseas');
        // 海外データプラン購入画面
        $data['get_corp_overseas_url'] = Router::get('get_edit_corp_overseas');
        // 海外データプラン購入処理画面
        $data['post_corp_overseas_url'] = Router::get('post_edit_corp_overseas');
        // プラン変更
        $data['corp_plan_change_url'] = Router::get('corp_plan_change');
        // プラン変更
        $data['post_corp_plan_change_url'] = Router::get('corp_post_plan_change');
        // プラン変更完了画面
        $data['corp_plan_change_complete_url'] = Router::get('corp_plan_change_complete');
        // プラン変更完了画面
        $data['corp_plan_change_cancel_complete_url'] = Router::get('corp_plan_change_cancel_complete');
        // ログイン
        $data['login_url'] = Router::get('login');
        // ログアウト
        $data['logout_url'] = Router::get('logout');
        // ログイン海外レンタル
        $data['login_rental_url'] = Router::get('rental_login');
        // 利用規約PDF
        $data['pdf_contract_url'] = Router::get('pdf_contract');
        // 利用規約PDF(2024/02/01まで)
        $data['pdf_contract_20240201_url'] = Router::get('pdf_contract_20240201');
        // 利用規約PDF(2023/08/30まで)
        $data['pdf_contract_20230830_url'] = Router::get('pdf_contract_20230830');
        // 利用規約PDF(2023/05/31まで)
        $data['pdf_contract_20230531_url'] = Router::get('pdf_contract_20230531');
        // 利用規約PDF(2023/04/20まで)
        $data['pdf_contract_20230420_url'] = Router::get('pdf_contract_20230420');
        // 利用規約PDF(2023/02/19まで)
        $data['pdf_contract_20230219_url'] = Router::get('pdf_contract_20230219');
        // 利用規約PDF(2023/01/31まで)
        $data['pdf_contract_20230131_url'] = Router::get('pdf_contract_20230131');
        // 利用規約PDF(2023/01/25まで)
        $data['pdf_contract_20230125_url'] = Router::get('pdf_contract_20230125');
        // 利用規約PDF(2023/01/11まで)
        $data['pdf_contract_20230111_url'] = Router::get('pdf_contract_20230111');
        // 利用規約PDF(2022/12/05まで)
        $data['pdf_contract_20221205_url'] = Router::get('pdf_contract_20221205');
        // 利用規約PDF(2022/10/03まで)(2023/08/01改定)
        $data['pdf_contract_20221003_url'] = Router::get('pdf_contract_20221003');
        // 利用規約PDF(2022/10/03まで)
        $data['pdf_contract_20221003_20230801_url'] = Router::get('pdf_contract_20221003_20230801');

        // 利用規約PDF(2022/09/06まで)(2023/08/01改定)
        $data['pdf_contract_20220906_url'] = Router::get('pdf_contract_20220906');
        // 利用規約PDF(2022/09/06まで)
        $data['pdf_contract_20220906_20230801_url'] = Router::get('pdf_contract_20220906_20230801');

        // 利用規約PDF(2022/07/25まで)(2023/08/01改定)
        $data['pdf_contract_20220725_20230801_url'] = Router::get('pdf_contract_20220725_20230801');
        // 利用規約PDF(2022/07/25まで)
        $data['pdf_contract_20220725_url'] = Router::get('pdf_contract_20220725');

        // 利用規約PDF(2022/06/30まで)(2023/08/01改定)
        $data['pdf_contract_20220630_20230801_url'] = Router::get('pdf_contract_20220630_20230801');
        // 利用規約PDF(2022/06/30まで)
        $data['pdf_contract_20220630_url'] = Router::get('pdf_contract_20220630');

        // 利用規約PDF(2022/05/30まで)(2023/08/01改定)
        $data['pdf_contract_20220530_20230801_url'] = Router::get('pdf_contract_20220530_20230801');
        // 利用規約PDF(2022/05/30まで)
        $data['pdf_contract_20220530_url'] = Router::get('pdf_contract_20220530');

        $data['pdf_contract_20220413_url'] = Router::get('pdf_contract_20220413');
        // 利用規約PDF(2022/04/05まで)
        $data['pdf_contract_20220405_url'] = Router::get('pdf_contract_20220405');
        // 利用規約PDF(2022/02/28まで)
        $data['pdf_contract_20220228_url'] = Router::get('pdf_contract_20220228');
        // 利用規約PDF(2022/01/31まで)
        $data['pdf_contract_20220131_url'] = Router::get('pdf_contract_20220131');
        // 利用規約PDF(2022/01/19まで)
        $data['pdf_contract_20220119_url'] = Router::get('pdf_contract_20220119');
        // 利用規約PDF(2021/12/06まで)
        $data['pdf_contract_20211206_url'] = Router::get('pdf_contract_20211206');
        // 利用規約PDF(2021/10/31まで)
        $data['pdf_contract_20211031_url'] = Router::get('pdf_contract_20211031');
        // 利用規約PDF(2021/09/30まで)
        $data['pdf_contract_20210930_url'] = Router::get('pdf_contract_20210930');
        // 利用規約PDF(2021/08/23まで)
        $data['pdf_contract_20210824_url'] = Router::get('pdf_contract_20210824');
        // 利用規約PDF(2021/08/01まで)
        $data['pdf_contract_20210801_url'] = Router::get('pdf_contract_20210801');
        // 利用規約PDF(2021/06/30まで)
        $data['pdf_contract_20210630_url'] = Router::get('pdf_contract_20210630');
        // 利用規約PDF(2021/05/26まで)
        $data['pdf_contract_20210526_url'] = Router::get('pdf_contract_20210526');
        // 利用規約PDF(2021/04/06まで)
        $data['pdf_contract_20210406_url'] = Router::get('pdf_contract_20210406');
        // 利用規約PDF(2020/11/30まで)
        $data['pdf_contract_20201130_url'] = Router::get('pdf_contract_20201130');
        // 利用規約PDF(2020/11/04まで)
        $data['pdf_contract_20201104_url'] = Router::get('pdf_contract_20201104');
        // 利用規約PDF(2020/10/14まで)
        $data['pdf_contract_20201014_url'] = Router::get('pdf_contract_20201014');
        // 利用規約PDF(2020/09/14まで)
        $data['pdf_contract_20200914_url'] = Router::get('pdf_contract_20200914');
        // 利用規約PDF(2020/08/06まで)
        $data['pdf_contract_20200806_url'] = Router::get('pdf_contract_20200806');
        // 利用規約PDF(別紙)
        $data['pdf_contract_attachment_url'] = Router::get('pdf_contract_attachment');
        // 利用規約PDF(別紙)(2024/08/14まで)
        $data['pdf_contract_attachment_20240814_url'] = Router::get('pdf_contract_attachment_20240814');
        // 利用規約PDF(別紙)(2024/03/31まで)
        $data['pdf_contract_attachment_20240331_url'] = Router::get('pdf_contract_attachment_20240331');
        // 利用規約PDF(別紙)(2024/03/03まで)
        $data['pdf_contract_attachment_20240303_url'] = Router::get('pdf_contract_attachment_20240303');
        // 利用規約PDF(別紙)(2024/02/01まで)
        $data['pdf_contract_attachment_20240201_url'] = Router::get('pdf_contract_attachment_20240201');
        // 利用規約PDF(別紙)(2023/10/01まで)
        $data['pdf_contract_attachment_20231001_url'] = Router::get('pdf_contract_attachment_20231001');

        // CHARGEプラン(プリペイド)利用規約PDF
        $data['pdf_contract_prepaid_url'] = Router::get('pdf_contract_prepaid');
        // CHARGEプラン(プリペイド)利用規約PDF(2024/2/5まで)
        $data['pdf_contract_prepaid_20240205_url'] = Router::get('pdf_contract_prepaid_20240205');
        // CHARGEプラン(プリペイド)利用規約PDF(2023/12/20まで)
        $data['pdf_contract_prepaid_20231220_url'] = Router::get('pdf_contract_prepaid_20231220');
        // CHARGEプラン(プリペイド)利用規約PDF(別紙)
        $data['pdf_contract_prepaid_attachment_url'] = Router::get('pdf_contract_prepaid_attachment');
        // CHARGEプラン(プリペイド)利用規約PDF(別紙)(2024/10/2まで)
        $data['pdf_contract_prepaid_attachment_20241002_url'] = Router::get('pdf_contract_prepaid_attachment_20241002');
        // CHARGEプラン(プリペイド)利用規約PDF(別紙)(2024/2/5まで)
        $data['pdf_contract_prepaid_attachment_20240205_url'] = Router::get('pdf_contract_prepaid_attachment_20240205');
        // CHARGEプラン(プリペイド)利用規約PDF(別紙)(2023/12/20まで)
        $data['pdf_contract_prepaid_attachment_20231220_url'] = Router::get('pdf_contract_prepaid_attachment_20231220');
        // CHARGEプラン(プリペイド)オートチャージプラン利用規約PDF
        $data['pdf_contract_prepaid_sub_url'] = Router::get('pdf_contract_prepaid_sub');
        // CHARGEプラン(プリペイド)オートチャージプラン利用規約PDF(別紙)
        $data['pdf_contract_prepaid_sub_attachment_url'] = Router::get('pdf_contract_prepaid_sub_attachment');
        // CHARGEプラン(プリペイド)オプションサービス規約PDF
        $data['pdf_contract_prepaid_option_url'] = Router::get('pdf_contract_prepaid_option');
        // CHARGEプラン(プリペイド)オプションサービス規約PDF(2024/3/31まで)
        $data['pdf_contract_prepaid_option_20240331_url'] = Router::get('pdf_contract_prepaid_option_20240331');
        // CHARGEプラン(プリペイド)オプションサービス規約PDF(2024/2/5まで)
        $data['pdf_contract_prepaid_option_20240205_url'] = Router::get('pdf_contract_prepaid_option_20240205');
        // CHARGEプラン(プリペイド)対応端末販売規約PDF（オートチャージプラン共通）
        $data['pdf_contract_prepaid_device_url'] = Router::get('pdf_contract_prepaid_device');
        // CHARGEプラン(プリペイド)対応端末販売規約PDF(2024/3/31まで)
        $data['pdf_contract_prepaid_device_20240331_url'] = Router::get('pdf_contract_prepaid_device_20240331');
        // CHARGEプラン(プリペイド)対応端末販売規約PDF(2024/2/5まで)
        $data['pdf_contract_prepaid_device_20240205_url'] = Router::get('pdf_contract_prepaid_device_20240205');
        // CHARGEプラン(プリペイド)オートチャージプランオプションサービスキャンペーン規約PDF
        $data['pdf_contract_prepaid_sub_op_campaign_url'] = Router::get('pdf_contract_prepaid_sub_op_campaign');

        // 海外レンタルプラン利用規約PDF
        $data['pdf_contract_global_url'] = Router::get('pdf_contract_global');
        // 海外レンタルプラン利用規約PDF(2024/04/07まで)
        $data['pdf_contract_global_url_20240407'] = Router::get('pdf_contract_global_20240407');
        // 海外レンタルプラン利用規約PDF(2024/01/24まで)
        $data['pdf_contract_global_url_20240124'] = Router::get('pdf_contract_global_20240124');
        // 海外レンタルプラン利用規約PDF(2023/11/20まで)
        $data['pdf_contract_global_url_20231120'] = Router::get('pdf_contract_global_20231120');
        // 海外レンタルプラン利用規約PDF(別紙)
        $data['pdf_contract_global_attachment_url'] = Router::get('pdf_contract_global_attachment');
        // 海外レンタルプラン利用規約PDF(別紙)(2024/08/14まで)
        $data['pdf_contract_global_attachment_url_20240814'] = Router::get('pdf_contract_global_attachment_20240814');
        // 海外レンタルプラン利用規約PDF(別紙)(2024/01/28まで)
        $data['pdf_contract_global_attachment_url_20240128'] = Router::get('pdf_contract_global_attachment_20240128');
        // 海外レンタルプラン利用規約PDF(別紙)(2024/01/24まで)
        $data['pdf_contract_global_attachment_url_20240124'] = Router::get('pdf_contract_global_attachment_20240124');
        // 海外レンタルプラン利用規約PDF(別紙)(2024/01/03まで)
        $data['pdf_contract_global_attachment_url_20240103'] = Router::get('pdf_contract_global_attachment_20240103');
        // 海外レンタルプラン利用規約PDF(別紙)(2023/11/20まで)
        $data['pdf_contract_global_attachment_url_20231120'] = Router::get('pdf_contract_global_attachment_20231120');
        // 海外レンタルプランオプションサービス規約PDF
        $data['pdf_contract_global_option_url'] = Router::get('pdf_contract_global_option');
        // 海外レンタルプランオプションサービス規約PDF(2024/03/27まで)
        $data['pdf_contract_global_option_url_20240327'] = Router::get('pdf_contract_global_option_20240327');
        // 海外レンタルプランオプションサービス規約PDF(2024/01/28まで)
        $data['pdf_contract_global_option_url_20240128'] = Router::get('pdf_contract_global_option_20240128');
        // 海外レンタルプランオプションサービス規約PDF(2024/01/24まで)
        $data['pdf_contract_global_option_url_20240124'] = Router::get('pdf_contract_global_option_20240124');
        // 海外レンタルプランオプションサービス規約PDF(2023/11/28まで)
        $data['pdf_contract_global_option_url_20231128'] = Router::get('pdf_contract_global_option_20231128');
        // 海外レンタルプランオプションサービス規約PDF(2023/10/17まで)
        $data['pdf_contract_global_option_url_20231017'] = Router::get('pdf_contract_global_option_20231017');

        // 海外レンタル法人向けプラン利用規約PDF
        $data['pdf_contract_global_biz_url'] = Router::get('pdf_contract_global_biz');
        // 海外レンタル法人向けプラン利用規約PDF(別紙)
        $data['pdf_contract_global_biz_attachment_url'] = Router::get('pdf_contract_global_biz_attachment');
        // 海外レンタル法人向けプラン利用規約PDF(別紙)(2024/08/14まで)
        $data['pdf_contract_global_biz_attachment_url_20240814'] = Router::get('pdf_contract_global_biz_attachment_20240814');
        // 海外レンタル法人向けプラン端末あんしんオプション規約PDF
        $data['pdf_contract_global_biz_option_url'] = Router::get('pdf_contract_global_biz_option');

        // 利用規約PDF(キャスティングロード)
        $data['pdf_contract_CR_url'] = Router::get('pdf_contract_CR');
        // 利用規約PDF(オープンハウス)
        $data['pdf_contract_openhouse_url'] = Router::get('pdf_contract_openhouse');
        // 利用規約PDF(オープンハウス)(2023/05/31まで)
        $data['pdf_contract_openhouse_20230531_url'] = Router::get('pdf_contract_openhouse_20230531');
        // 利用規約PDF(オープンハウス)(2023/01/31まで)
        //$data['pdf_contract_openhouse_20230131_url'] = Router::get('pdf_contract_openhouse_20230131');
        // 利用規約PDF(鹿児島レブナイズ特別キャンペーン)
        $data['pdf_contract_kgr_cp_url'] = Router::get('pdf_contract_kgr_cp');
        // 利用規約PDF(まとめて前払いプラン)
        $data['pdf_contract_bulk_url'] = Router::get('pdf_contract_bulk');
        // 利用規約PDF(まとめて前払いプラン)(2023/05/31まで)
        $data['pdf_contract_bulk_20230531_url'] = Router::get('pdf_contract_bulk_20230531');
        // 利用規約PDF(まとめて前払いプラン 別紙)
        $data['pdf_contract_bulk_attachment_url'] = Router::get('pdf_contract_bulk_attachment');
        // 利用規約PDF(おうちリンク　別紙)
        $data['pdf_contract_home_attachment_url'] = Router::get('pdf_contract_home_attachment');
        // 利用規約PDF(WiMAX)
        $data['pdf_contract_wimax_url'] = Router::get('pdf_contract_wimax');
        // 利用規約PDF(WiMAX)(2024/02/25まで)
        $data['pdf_contract_wimax_20240225_url'] = Router::get('pdf_contract_wimax_20240225');
        // 利用規約PDF(WiMAX)(2023/12/24まで)
        $data['pdf_contract_wimax_20231224_url'] = Router::get('pdf_contract_wimax_20231224');
        // 利用規約PDF(WiMAX)(2023/05/31まで)
        $data['pdf_contract_wimax_20230531_url'] = Router::get('pdf_contract_wimax_20230531');
        // 利用規約PDF(WiMAX)(2023/04/26まで)
        $data['pdf_contract_wimax_20230426_url'] = Router::get('pdf_contract_wimax_20230426');
        // 利用規約PDF(WiMAX)(2023/01/31まで)
        $data['pdf_contract_wimax_20230131_url'] = Router::get('pdf_contract_wimax_20230131');
        // 利用規約PDF(WiMAX)(2022/12/25まで)
        $data['pdf_contract_wimax_20221225_url'] = Router::get('pdf_contract_wimax_20221225');
        // 利用規約PDF(WiMAX)(2022/10/03まで)
        $data['pdf_contract_wimax_20221003_url'] = Router::get('pdf_contract_wimax_20221003');
        // 利用規約PDF(WiMAX)(2022/10/03まで) ※2023年8月1日再改定
        $data['pdf_contract_wimax_20221003_20230801_url'] = Router::get('pdf_contract_wimax_20221003_20230801');
        // 利用規約PDF(WiMAX)(2022/06/30まで)
        $data['pdf_contract_wimax_20220630_url'] = Router::get('pdf_contract_wimax_20220630');
        // 利用規約PDF(WiMAX)(2022/06/30まで) ※2023年8月1日再改定
        $data['pdf_contract_wimax_20220630_20230801_url'] = Router::get('pdf_contract_wimax_20220630_20230801');
        // 利用規約PDF(WiMAX)(2022/06/20まで)
        $data['pdf_contract_wimax_20220620_url'] = Router::get('pdf_contract_wimax_20220620');
        // 利用規約PDF(WiMAX)別紙
        $data['pdf_contract_wimax_attachment_url'] = Router::get('pdf_contract_wimax_attachment');
        // 利用規約PDF(WiMAX)別紙（2024/08/14まで）
        $data['pdf_contract_wimax_attachment_20240814_url'] = Router::get('pdf_contract_wimax_attachment_20240814');
        // 利用規約PDF(WiMAX)別紙（2024/07/10まで）
        $data['pdf_contract_wimax_attachment_20240710_url'] = Router::get('pdf_contract_wimax_attachment_20240710');
        // 利用規約PDF(WiMAX)別紙（2024/03/03まで）
        $data['pdf_contract_wimax_attachment_20240303_url'] = Router::get('pdf_contract_wimax_attachment_20240303');
        // 利用規約PDF(WiMAX)別紙（2024/02/25まで）
        $data['pdf_contract_wimax_attachment_20240225_url'] = Router::get('pdf_contract_wimax_attachment_20240225');
        // ZEUS WiMAX 端末あんしんオプション規約
        $data['pdf_contract_wimax_option_1_url'] = Router::get('pdf_contract_wimax_option_1');
        // ZEUS WiMAX 端末あんしんオプション規約（2024/02/25まで）
        $data['pdf_contract_wimax_option_1_20240225_url'] = Router::get('pdf_contract_wimax_option_1_20240225');
        // ZEUS WiMAX 端末あんしんオプション規約（2023/12/24まで）
        $data['pdf_contract_wimax_option_1_20231224_url'] = Router::get('pdf_contract_wimax_option_1_20231224');
        // ZEUS WiMAX 端末あんしんオプション規約（2023/05/31まで）
        $data['pdf_contract_wimax_option_1_20230531_url'] = Router::get('pdf_contract_wimax_option_1_20230531');
        // ZEUS WiMAX 端末あんしんオプション規約（2023/04/26まで）
        $data['pdf_contract_wimax_option_1_20230426_url'] = Router::get('pdf_contract_wimax_option_1_20230426');
        // ZEUS WiMAX 端末あんしんオプション規約（2023/01/31まで）
        $data['pdf_contract_wimax_option_1_20230131_url'] = Router::get('pdf_contract_wimax_option_1_20230131');
        // ZEUS WiMAX 端末あんしんオプション規約（2022/12/25まで）
        $data['pdf_contract_wimax_option_1_20221225_url'] = Router::get('pdf_contract_wimax_option_1_20221225');
        // 丸ごと安心パック for ZEUS WiFi 利用規約
        $data['pdf_contract_wimax_option_2_url'] = Router::get('pdf_contract_wimax_option_2');
        // 丸ごと安心パック for ZEUS WiFi 利用規約（2024/03/31まで）
        $data['pdf_contract_wimax_option_2_20240331_url'] = Router::get('pdf_contract_wimax_option_2_20240331');
        // 丸ごと安心パック for ZEUS WiFi 利用規約（2024/02/01まで）
        $data['pdf_contract_wimax_option_2_20240201_url'] = Router::get('pdf_contract_wimax_option_2_20240201');
        // 丸ごと安心パック for ZEUS WiFi 利用規約（2022/12/25まで）
        $data['pdf_contract_wimax_option_2_20221225_url'] = Router::get('pdf_contract_wimax_option_2_20221225');
        // 丸ごと安心パック for ZEUS WiFi 利用規約（2023/01/31まで）
        $data['pdf_contract_wimax_option_2_20230131_url'] = Router::get('pdf_contract_wimax_option_2_20230131');
        // ZEUS WiFi 利用規約（重要事項説明書）(ZEUSセット)
        $data['pdf_contract_wimax_zeusset_url'] = Router::get('pdf_contract_wimax_zeusset');
        // ZEUS WiFi 利用規約（重要事項説明書）(ZEUSセット)（2024/03/03まで）
        $data['pdf_contract_wimax_zeusset_20240303_url'] = Router::get('pdf_contract_wimax_zeusset_20240303');
        // ZEUS WiFi 利用規約（重要事項説明書）(ZEUSセット)（2023/05/31まで）
        $data['pdf_contract_wimax_zeusset_20230531_url'] = Router::get('pdf_contract_wimax_zeusset_20230531');
        // ZEUS WiFi 利用規約（重要事項説明書）(ZEUSセット)（2023/04/26まで）
        $data['pdf_contract_wimax_zeusset_20230426_url'] = Router::get('pdf_contract_wimax_zeusset_20230426');
        // ZEUS WiFi 利用規約（重要事項説明書）(ZEUSセット)（2023/02/19まで）
        $data['pdf_contract_wimax_zeusset_20230219_url'] = Router::get('pdf_contract_wimax_zeusset_20230219');
        // ZEUS WiFi 利用規約（重要事項説明書）(ZEUSセット)（2023/01/31まで）
        $data['pdf_contract_wimax_zeusset_20230131_url'] = Router::get('pdf_contract_wimax_zeusset_20230131');
        // ZEUS WiFi 利用規約（重要事項説明書）(ZEUSセット)（2022/12/25まで）
        $data['pdf_contract_wimax_zeusset_20221225_url'] = Router::get('pdf_contract_wimax_zeusset_20221225');
        // ZEUS WiFi 利用規約（重要事項説明書）(ZEUSセット)（2022/10/03まで）
        $data['pdf_contract_wimax_zeusset_20221003_url'] = Router::get('pdf_contract_wimax_zeusset_20221003');
        // ZEUS WiFi 利用規約（重要事項説明書）(ZEUSセット)（2022/10/03まで）※2023年8月1日再改定
        $data['pdf_contract_wimax_zeusset_20221003_20230801_url'] = Router::get('pdf_contract_wimax_zeusset_20221003_20230801');
        // ZEUS WiFi 利用規約（重要事項説明書）(ZEUSセット)（2022/09/12まで）
        $data['pdf_contract_wimax_zeusset_20220912_url'] = Router::get('pdf_contract_wimax_zeusset_20220912');
        // ZEUS WiFi 利用規約（重要事項説明書）(ZEUSセット)（2022/09/12まで）※2023年8月1日再改定
        $data['pdf_contract_wimax_zeusset_20220912_20230801_url'] = Router::get('pdf_contract_wimax_zeusset_20220912_20230801');
        // ZEUS WiMAX キャンペーン規約
        $data['pdf_contract_wimax_campaign_url'] = Router::get('pdf_contract_wimax_campaign');
        // ZEUS WiMAX ご利用者様限定プラン キャンペーン規約
        $data['pdf_contract_closed_wimax_campaign_url'] = Router::get('pdf_contract_closed_wimax_campaign');
        // ZEUS WiMAX ご契約者様限定乗り換えプラン キャンペーン規約
        $data['pdf_contract_contractor_wimax_campaign_url'] = Router::get('pdf_contract_contractor_wimax_campaign');
        // 端末販売規約(WiMAX)
        $data['pdf_contract_wimax_device_url'] = Router::get('pdf_contract_wimax_device');
        // 端末販売規約(WiMAX)（2024/02/25まで）
        $data['pdf_contract_wimax_device_20240225_url'] = Router::get('pdf_contract_wimax_device_20240225');
        // 端末販売規約(WiMAX)（2023/12/24まで）
        $data['pdf_contract_wimax_device_20231224_url'] = Router::get('pdf_contract_wimax_device_20231224');
        // 端末販売規約(WiMAX)（2023/01/31まで）
        $data['pdf_contract_wimax_device_20230131_url'] = Router::get('pdf_contract_wimax_device_20230131');
        // 端末販売契約解除規約(WiMAX)
        $data['pdf_contract_wimax_device_cancellation_url'] = Router::get('pdf_contract_wimax_device_cancellation');
        // 端末販売契約解除規約(WiMAX)（2023/01/31まで）
        $data['pdf_contract_wimax_device_cancellation_20230131_url'] = Router::get('pdf_contract_wimax_device_cancellation_20230131');
        // 割賦販売契約約款(WiMAX)
        $data['pdf_contract_wimax_installment_url'] = Router::get('pdf_contract_wimax_installment');
        // 割賦販売契約約款(WiMAX)（2024/02/25まで）
        $data['pdf_contract_wimax_installment_20240225_url'] = Router::get('pdf_contract_wimax_installment_20240225');
        // 割賦販売契約約款(WiMAX)（2023/12/24まで）
        $data['pdf_contract_wimax_installment_20231224_url'] = Router::get('pdf_contract_wimax_installment_20231224');
        // 割賦販売契約約款(WiMAX)（2023/01/31まで）
        $data['pdf_contract_wimax_installment_20230131_url'] = Router::get('pdf_contract_wimax_installment_20230131');
        //プラン変更用利用規約
        $data['pdf_contract_plan_change_url'] = Router::get('pdf_contract_plan_change');
        // ブランド変更用利用規約
        $data['pdf_contract_change_brand_url'] = Router::get('pdf_contract_change_brand');
        //保険オプション（通常）利用規約
        $data['pdf_contract_insurance_option_url'] = Router::get('pdf_contract_insurance_option');
        //保険オプション（プレミアム）利用規約
        $data['pdf_contract_insurance_option_premium_url'] = Router::get('pdf_contract_insurance_option_premium');
        //保険オプション（通常）利用規約（2024/03/31まで）
        $data['pdf_contract_insurance_option_20240331_url'] = Router::get('pdf_contract_insurance_option_20240331');
        //保険オプション（通常）利用規約（2023/06/25まで）
        $data['pdf_contract_insurance_option_20230625_url'] = Router::get('pdf_contract_insurance_option_20230625');
        //保険オプション（通常）利用規約（2023/02/19まで）
        $data['pdf_contract_insurance_option_20230219_url'] = Router::get('pdf_contract_insurance_option_20230219');
        //保険オプション（通常）利用規約（2023/01/31まで）
        $data['pdf_contract_insurance_option_20230131_url'] = Router::get('pdf_contract_insurance_option_20230131');
        //保険オプション（プレミアム）利用規約（2024/03/31まで）
        $data['pdf_contract_insurance_option_premium_20240331_url'] = Router::get('pdf_contract_insurance_option_premium_20240331');
        //保険オプション（プレミアム）利用規約（2023/06/25まで）
        $data['pdf_contract_insurance_option_premium_20230625_url'] = Router::get('pdf_contract_insurance_option_premium_20230625');
        //保険オプション（プレミアム）利用規約（2023/01/31まで）
        $data['pdf_contract_insurance_option_premium_20230131_url'] = Router::get('pdf_contract_insurance_option_premium_20230131');
        //保険オプション（プレミアム）利用規約（2023/05/10まで）
        $data['pdf_contract_insurance_option_premium_20230510_url'] = Router::get('pdf_contract_insurance_option_premium_20230510');
        // プライバシーポリシーPDF
        $data['pdf_privacy_url'] = Router::get('pdf_privacy');
        // プライバシーポリシー(個人情報の取り扱いについて)PDF
        $data['pdf_privacy_attachment_url'] = Router::get('pdf_privacy_attachment');
        // あんしんオプション規約（2024/02/01まで）
        $data['pdf_contract_device_insurance_20240201_url'] = Router::get('contract_device_insurance_20240201');
        // あんしんオプション規約（2023/10/01まで）
        $data['pdf_contract_device_insurance_20231001_url'] = Router::get('contract_device_insurance_20231001');
        // あんしんオプション規約（2023/05/31まで）
        $data['pdf_contract_device_insurance_20230531_url'] = Router::get('contract_device_insurance_20230531');
        // あんしんオプション規約（2023/04/20まで）
        $data['pdf_contract_device_insurance_20230420_url'] = Router::get('contract_device_insurance_20230420');
        // あんしんオプション規約（2023/01/31まで）
        $data['pdf_contract_device_insurance_20230131_url'] = Router::get('contract_device_insurance_20230131');
        // あんしんオプション規約（2023/01/25まで）
        $data['pdf_contract_device_insurance_20230125_url'] = Router::get('contract_device_insurance_20230125');
        // あんしんオプション規約（2023/01/11まで）
        $data['pdf_contract_device_insurance_20230111_url'] = Router::get('contract_device_insurance_20230111');
        // あんしんオプション規約(2022/12/25まで)
        $data['pdf_contract_device_insurance_20221225_url'] = Router::get('contract_device_insurance_20221225');
        // あんしんオプション規約（2022/10/03まで）
        $data['pdf_contract_device_insurance_20221003_url'] = Router::get('contract_device_insurance_20221003');
        // あんしんオプション規約（2022/10/03まで）(2023/08/01改定)
        $data['pdf_contract_device_insurance_20221003_20230801_url'] = Router::get('contract_device_insurance_20221003_20230801');
        // あんしんオプション規約（2022/04/14まで）
        $data['pdf_contract_device_insurance_20220414_url'] = Router::get('contract_device_insurance_20220414');
        // あんしんオプション規約（2022/01/19まで）
        $data['pdf_contract_device_insurance_20220119_url'] = Router::get('contract_device_insurance_20220119');
        // あんしんオプション規約
        $data['pdf_contract_device_insurance_url'] = Router::get('contract_device_insurance');
        // あんしんオプション規約(まとめて前払いプラン)
        $data['pdf_contract_device_insurance_bulk_url'] = Router::get('contract_device_insurance_bulk');
        // あんしんオプション規約(まとめて前払いプラン)（2023/05/31まで）
        $data['pdf_contract_device_insurance_bulk_20230531_url'] = Router::get('contract_device_insurance_bulk_20230531');
        // 取扱説明書
        $data['pdf_instruction_manual_url'] = Router::get('instruction_manual');
        // 取扱説明書（MR1）
        $data['pdf_instruction_manual_mr1_url'] = Router::get('instruction_manual_mr1');
        // 取扱説明書（MR1 海外レンタル専用）
        $data['pdf_instruction_manual_mr1_global_url'] = Router::get('instruction_manual_mr1_global');
        // 取扱説明書　英語
        $data['pdf_englishi_instruction_manual_url'] = Router::get('englishi_instruction_manual');
        // 取扱説明書　中国語（繁体）Traditional_Chinese
        $data['pdf_traditional_chinese_instruction_manual_url'] = Router::get('traditional_chinese_instruction_manual');
        // 取扱説明書　中国語（簡体）Simplified_Chinese
        $data['pdf_simplified_chinese_instruction_manual_url'] = Router::get('simplified_chinese_instruction_manual');
        // 取扱説明書　韓国語
        $data['pdf_korean_instruction_manual_url'] = Router::get('korean_instruction_manual');
        // お支払いについて（クレジットカード払い）
        $data['pdf_about_payment_credit_url'] = Router::get('about_payment_credit');
        // お支払いについて（atone翌月払い）
        $data['pdf_about_payment_atone_url'] = Router::get('about_payment_atone');
        // 会社概要
        $data['company_url'] = Router::get('company');
        // お問い合わせ
        $data['contact_url'] = Router::get('contact');
        // お知らせ
        $data['news_url'] = Router::get('news');
        // お知らせ_20220708
        $data['news_20220708_url'] = Router::get('20220708');
        // お知らせ_20200330
        $data['news_20200330_url'] = Router::get('20200330');
        // コールセンターのご案内
        $data['callcenter_url'] = Router::get('callcenter');
        // あんしん解約サポート
        $data['anshin_kaiyaku_url'] = Router::get('anshin_kaiyaku');
        // 体験キャンペーン
        $data['taiken_campaign_url'] = Router::get('taiken_campaign');
        // キャンペーンアーカイブ
        $data['campaign_archive_url'] = Router::get('campaign_archive');
        // デュアルスタイル・節約術
        $data['dual_url'] = Router::get('dual');
        // 取扱説明書の言語選択ページ（QRコードの遷移先）
        $data['instruction_manual_language_url'] = Router::get('instruction_manual_language');
        // ホテルWi-Fiユーザー向け動画ページ1
        $data['hotel_wifi_movie_01_url'] = Router::get('hotel_wifi_movie_01');
        // ホテルWi-Fiユーザー向け動画ページ2
        $data['hotel_wifi_movie_02_url'] = Router::get('hotel_wifi_movie_02');
        // VMA2020スペシャルキャンペーン
        $data['vma2020campaign_url'] = Router::get('vma2020specialcampaignterms');
        // キャンペーン 光回線（ZEUS開通済ユーザー向け）
        $data['setcampaign_existing_url'] = Router::get('setcampaign_existing');
        // キャンペーン 光回線の規約（ZEUS開通済ユーザー向け）
        $data['setcampaign_existing_terms_url'] = Router::get('setcampaign_existing_terms');
        // キャンペーン 光回線の規約（新規ユーザー向け）
        $data['setcampaign_new_terms_url'] = Router::get('setcampaign_new_terms');
        // twitterキャンペーン規約（ZEUS新規・既存両ユーザー対応）
        $data['twitter_campaign_terms_url'] = Router::get('twittercampaign_terms');
        // お役立ち情報
        $data['column_url'] = Router::get('column');
        // お役立ち情報2
        $data['column_2_url'] = Router::get('column_2');
        // お役立ち情報詳細1
        $data['column_detail_1_url'] = Router::get('column_detail_1');
        // お役立ち情報詳細2
        $data['column_detail_2_url'] = Router::get('column_detail_2');
        // お役立ち情報詳細3
        $data['column_detail_3_url'] = Router::get('column_detail_3');
        // お役立ち情報詳細4
        $data['column_detail_4_url'] = Router::get('column_detail_4');
        // お役立ち情報詳細5
        $data['column_detail_5_url'] = Router::get('column_detail_5');
        // お役立ち情報詳細6
        $data['column_detail_6_url'] = Router::get('column_detail_6');
        // お役立ち情報詳細7
        $data['column_detail_7_url'] = Router::get('column_detail_7');
        // 利用規約・重要事項説明書
        $data['terms_url'] = Router::get('terms');
        // よくある質問
        $data['faq_url'] = Router::get('faq');
        // 海外利用
        $data['overseas_use_url'] = Router::get('overseas_use');
        // TOP
        $data['top_url'] = Uri::base();
        // 申し込みページ
        $data['entry_url'] = Router::get('entry');
        // 申し込み容量ページ
        $data['entry_select_url'] = Router::get('entry_select');
        // 20201105 - 申し込みページ
        $data['entry_options_url'] = Router::get('entry_options');
        // 申し込み容量ページ
        $data['entry_corp_select_url'] = Router::get('entry_corp_select');
        // 20201105 - 申し込みページ
        $data['entry_corp_options_url'] = Router::get('entry_corp_options');
        // Hikari GET申し込みページ
        $data['entry_hikari_select_url'] = Router::get('entry_hikari_select');
        // Hikari POST申し込みページcontact_url
        $data['entry_hikari_options_url'] = Router::get('entry_hikari_options');

        // 光セット新規申し込みページ
        $data['entry_external_serviceset_select_url'] = Router::get('entry_externalserviceset_select',['alias'=>$data['alias'] ?? '']);
        // 光セット新規
        $data['entry_external_serviceset_options_url'] = Router::get('entry_externalserviceset_options', ['alias'=>$data['alias'] ?? '']);

        // twitterキャンペーン プランのデータ容量選択
        $data['entry_twitter_select_url'] = Router::get('entry_twitter_select');
        // twitterキャンペーン プラン選択画面処理
        $data['entry_twitter_options_url'] = Router::get('entry_twitter_options');
        // twitterキャンペーン お客様情報入力
        $data['entry_twitter_user_url'] = Router::get('entry_twitter_user');
        // twitterキャンペーン 入力内容確認
        $data['entry_twitter_confirm_url'] = Router::get('entry_twitter_confirm');
        // twitterキャンペーン 入力内容変更
        $data['entry_twitter_edit_url'] = Router::get('entry_twitter_edit');
        // twitterキャンペーン お支払い情報入力
        $data['entry_twitter_payment_url'] = Router::get('entry_twitter_payment');
        // twitterキャンペーン 申し込み完了
        $data['entry_twitter_complete_url'] = Router::get('entry_twitter_complete');
        // twitterキャンペーン 既存ユーザー用申し込み
        $data['campaign_twitter_contact_url'] = Router::get('campaign_twitter_contact');
        // twitterキャンペーン 既存ユーザー用入力内容確認
        $data['campaign_twitter_contact_confirm_url'] = Router::get('campaign_twitter_contact_confirm');
        // twitterキャンペーン 既存ユーザー用申し込み完了
        $data['campaign_twitter_contact_complete_url'] = Router::get('campaign_twitter_contact_complete');

        // croad
        $data['castingroad_url'] = Router::get('castingroad');
        $data['entry_salespartner_select'] = Router::get('entry_salespartner_select');

        // wimax
        $data['wimax_url'] = Router::get('wimax');
        $data['wimax_zeus_set_url'] = Router::get('wimax_zeus_set');
        $data['entry_wimax_select'] = Router::get('entry_wimax_select');
        $data['wimax_contact_url'] = Router::get('wimax_contact');
        $data['wimax_contact_confirm_url'] = Router::get('wimax_contact_confirm');
        $data['wimax_contact_complete_url'] = Router::get('wimax_contact_complete');
        $data['wimax_faq_url'] = Router::get('wimax_faq');
        $data['wimax_device_faq_url'] = Router::get('wimax_device_faq');
        $data['wimax_trouble_shooting_url'] = Router::get('wimax_trouble_shooting');
        $data['wimax_news_url'] = Router::get('wimax_news');

        // WiMAX お知らせ_20220708
        $data['wimax_news_20220708_url'] = Router::get('wimax_news_20220708');

        // wimax 利用規約・重要事項説明書
        $data['wimax_terms_url'] = Router::get('wimax_terms');

        // wimax特別プラン
        $data['entry_closed_wimax_select'] = Router::get('entry_closed_wimax_select');

        //海外向けレンタルプランLP 料金表
        $data['global_rental_price_url'] = Router::get('global_rental_price');

        //海外向けレンタルプランLP 周遊プラン対象国
        $data['global_rental_excursion_url'] = Router::get('global_rental_excursion');

        // 海外向けレンタルプラン問い合わせフォーム
        $data['global_contact_url'] = Router::get('global_contact');
        $data['global_contact_confirm_url'] = Router::get('global_contact_confirm');
        $data['global_contact_complete_url'] = Router::get('global_contact_complete');

        // ZEUS Prepaidプラン問い合わせフォーム
        $data['prepaid_contact_url'] = Router::get('prepaid_contact');
        $data['prepaid_contact_confirm_url'] = Router::get('prepaid_contact_confirm');
        $data['prepaid_contact_complete_url'] = Router::get('prepaid_contact_complete');

        // 保険オプションLP
        $data['insurance_option_url'] = Router::get('insurance_option');

        // セゾンカード タイアップキャンペーンページ
        $data['saison_campaign_url'] = Router::get('saison_campaign');

        //一括前払いプランLP
        $data['bulk_prepayment_url'] = Router::get('bulk_prepayment');

        // openhouse
        $data['openhouse_url'] = Router::get('openhouse');
        $data['company_openhouse_url'] = Router::get('company_openhouse');
        $data['entry_openhouse_select'] = Router::get('entry_openhouse_select');

        // ZEUS WiFi CHARGE FAQ
        $data['faq_prepaid_url'] = Router::get('faq_prepaid');

        // ZEUS WiFi CHARGE 特商法
        $data['company_prepaid_url'] = Router::get('company_prepaid');

        // ZEUS WiFi CHARGE 規約
        $data['terms_prepaid_url'] = Router::get('terms_prepaid');

        //business_url
        $data['business_url']= Router::get('business');
        $data['corp_entry_url']= Router::get('corp_entry');

        // 鹿児島レブナイズLP
        $data['promotion_kagoshima_rebnise_url'] = Router::get('promotion_kagoshima_rebnise');

        //法人パートナーページ（日ごとプラン）
        $data['business_partner_url']= Router::get('business_partner');

        // ふるさと納税限定プランLP
        $data['business_special_url'] = Router::get('business_special');

        //hotel_plan_url
        $data['hotel_plan_url']= Router::get('hotel_plan');

        //法人見積ページ_url
        $data['estimate_url']= Router::get('estimate');

        // 現在のURL
        $data['current_url'] = Uri::current();
        // プラン選択
        $data['planselect_url'] = Router::get('planselect');
        // 初期契約解除について
        $data['contract_initial_cancel_url'] = Router::get('contract_initial_cancel');

        // 初期契約解除申請フォーム画面
        $data['initial_contract_cancellation_application_url'] = Router::get('mypage_initial_contract_cancellation_application');
        //初期契約解除申請確認フォーム画面
        $data['initial_contract_cancellation_application_confirm_url'] = Router::get('mypage_initial_contract_cancellation_application_confirm');
        // 法人申し込みの流れ
        $data['business_guide_url'] = Router::get('business_guide');
        // 請求日のご案内
        $data['invoice_url'] = Router::get('invoice');

        // キャスティングロード プラン選択
        $data['entry_salespartner_options_url'] = Router::get('entry_salespartner_options');
        // キャスティングロード お客様情報入力
        $data['entry_salespartner_user'] = Router::get('entry_salespartner_user');

        // マイページリンク表示フラグ配列
        $data['not_available_list'] = $this->not_available_list;
        $data['is_need_fake_header_menu'] = $this->is_need_fake_header_menu;

        // 利用規約 法人
        $data['corp_contract_service_url'] = Router::get('corp_contract_service_url');
        // 覚書 法人
        $data['corp_memorandum_url'] = Router::get('corp_memorandum_url');

        // 法人利用規約
        $data['is_corp'] = $this->is_corp;
        $data['hide_contract_service'] = $this->hide_contract_service;

        // 法人覚書
        $data['is_memorandum'] = $this->is_memorandum;

        // WiMAX プラン選択
        $data['entry_wimax_options_url'] = Router::get('entry_wimax_options');
        // WiMAX お客様情報入力
        $data['entry_wimax_user'] = Router::get('entry_wimax_user');

        // WiMAX特別プラン プラン選択
        $data['entry_closed_wimax_options_url'] = Router::get('entry_closed_wimax_options');
        // WiMAX特別プラン お客様情報入力
        $data['entry_closed_wimax_user'] = Router::get('entry_closed_wimax_user');

        // オープンハウス プラン選択
        $data['entry_openhouse_options_url'] = Router::get('entry_openhouse_options');
        // オープンハウス お客様情報入力
        $data['entry_openhouse_user'] = Router::get('entry_openhouse_user');

        // プリペイドプラン
        $data['entry_prepaid_imei_url'] = Router::get('entry_prepaid_imei');
        $data['entry_prepaid_select_url'] = Router::get('entry_prepaid_select');

        // 支払い方法
        $data['settlement_type_value'] = $this->settlement_type_value;
        // 支払い方法リスト
        $data['settlement_type_value_list'] = $this->settlement_type_value_list;

        // pdf出力用にassetパス追加
        Asset::add_path('assets/pdf/', 'pdf');

        $view = View_Twig::forge($file, $data, $auto_filter);

        // エスケープしないで渡す情報のセット
        foreach ($safe_list as $key => $value) {
            $view->set_safe($key, $value);
        }

        return Response::forge($view, $http_status);
    }

    /**
     * 認証情報のセッションを削除する
     *
     * @return void
     */
    protected function delete_auth_info_session() {
        Log::application()->info('認証情報のセッションの削除処理開始');
        Session::delete('auth_info');
        Session::delete('email');
        Session::delete('plan_type');
        Log::application()->info('認証情報のセッションの削除処理終了');
    }

    /**
     * 指定されたデータをエスケープする
     *
     * @param array|string $var
     * @return array|string
     */
    protected function _escape($var) {
        if (is_array($var)) {
            return array_map('Controller_Base::_escape', $var);
        } else {
            return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
        }
    }

    /**
     * CSRFトークンのチェックを行う
     * 不正なCSRFトークンだった場合、指定されたURLにリダイレクト
     *
     * @param string $redirect_url
     * @return void
     */
    protected function check_csrf_token($redirect_url) {
        Log::application()->info('CSRFトークンチェック開始');

        // CSRFトークンの検証
        if (!Security::check_token()) {
            // 不正なCSRFトークン情報だった場合
            // エラー内容をセッションに一時格納
            Log::application()->info('CSRFトークンチェックのエラー');
            Session::set_flash('errors', [Lang::get('messages.invalid_token')]);
            Response::redirect($redirect_url, 'location', HTTP_STATUS_BAD_REQUEST);
        }

        Log::application()->info('CSRFトークンチェック終了 正しいCSRFトークン');

    }

    /**
     * セッションに認証情報をセットする
     *
     * @param string $email
     * @param string $salt
     * @param int    $plan_type
     * @return void
     */
    protected function set_session_auth_info($email, $salt, $plan_type=PLAN_TYPE_DOMESTIC) {
        // 認証情報を暗号化
        $crypt_auth_str = $this->get_crypt_str($email, $salt);
        // 暗号化したユーザーのメールアドレスをセッションにセット
        Session::set('auth_info', $crypt_auth_str);
        Session::set('email', Crypt::encode($email, SALT));
        Session::set('plan_type', $plan_type);
    }

    /**
     * トークンを取得する
     *
     * @param string $val
     * @param string $salt
     * @return string
     */
    protected function get_crypt_str($val, $salt) {
        return hash_hmac('sha256', $val . $salt, false);
    }

    /**
     * ログインしているかを判定する
     *
     * @return boolean ログインしている場合はtrue
     */
    private function is_login() {
        Log::application()->info('ログインチェック処理開始');
        $is_login = false;
        $service_base = new Service_Base();
        // セッションから認証情報を取得する
        $auth_info = Session::get('auth_info', '');
        $crypt_email = Session::get('email', '');
        $plan_type = Session::get('plan_type', PLAN_TYPE_DOMESTIC);
        // メールアドレスを復号化
        $email = Crypt::decode($crypt_email, SALT);
        if ($auth_info === '' || $crypt_email === '' || !$email) {
            if ($this->is_gmo_collback(Input::post())) {
                Log::application()->info('GMOからの遷移です。');
                $is_login = true;
            } else {
                // いずれかのセッション情報が取得できなかった場合
                Log::application()->info('ログインチェック処理にて、未ログイン、セッション情報不足またはセッション情報の複合化失敗のためセッション情報を削除');
                $this->delete_auth_info_session();
            }
        } else {
            // メールアドレスを条件にユーザー情報を取得する
            Log::application()->info('メールアドレスを条件にユーザー情報取得');
            $user_info = $service_base->get_user_login_info_by_email($email, BUSINESS_ID, $plan_type);
            Log::application()->info('メールアドレスを条件にユーザー情報取得完了');
            Log::application()->debug('取得結果', $user_info);

            if (empty($user_info)) {
                // ユーザー情報が存在しない場合
                Log::application()->info('ログインチェック処理にて、セッションにセットされたメールアドレスを条件に有効なユーザー情報が存在しなかったためセッション情報を削除');
                $this->delete_auth_info_session();
            } else {
                if (!$this->is_valid_auth_info($auth_info, $user_info['email'], $user_info['salt'])) {
                    // 暗号化されているセッション情報の値が不正な場合
                    Log::application()->info('セッションに格納されている認証情報が不正なためセッション情報を削除');
                    $this->delete_auth_info_session();
                } else if ((int) $user_info['status'] === USER_STATUS_LIST['force_withdraw']) {
                    Log::application()->info('ログイン中にユーザーのステータスが強制解約になったためセッション情報を削除');
                    $this->delete_auth_info_session();
                } else {
                    // 認証情報が正しい場合
                    $is_login = true;
                    // 共通情報をセットする
                    $this->set_common_info($user_info);
                    $this->can_charge_data = $service_base->get_can_charge_data($user_info['user_id']);

                    // user_idをセッションに保存
                    Session::set(self::$SES_KEY_USER_ID, $user_info['user_id']);
                }
            }
        }

        $is_login_message = $is_login ? 'ログイン中' : '未ログイン';
        Log::application()->info('ログインチェック処理終了 ' . $is_login_message);

        return $is_login;
    }

    /**
     * GMOからの遷移か確認する
     * @param array $post GMOから返ってくる$_POSTの内容
     * @return bool
     */
    private function is_gmo_collback($post = []) {
        if (empty($post)) return false;
        if (!empty($post['merchantRequestId']) && !empty($post['recurringId']) && !empty($post['authResult'])) {
            // GMOから返ってくる値が全部存在する場合のみに実行
            $post_request_id = $post['merchantRequestId'];
            $post_recurring_id = $post['recurringId'];
            $post_auth_result = $post['authResult'];
            $logic_gmo_recurring_history = Logic_HumanLife_GmoRecurringHistory::instance();
            // merchantRequestIdを元にGMOに渡したデータを取得
            $recurring_history = $logic_gmo_recurring_history->get_gmo_recurring_history_by_gmo_request_id($post_request_id, ['*']);

            // 成功と失敗によってレスポンスを分ける
            if ($post_auth_result === GMO_CONDO_AUTH_RESULT_LIST['SUCCESS']) {
                // merchantRequestIdとrecurringIdが一致している場合はログイン処理に進む
                if ($post_request_id === $recurring_history['gmo_request_id'] && $post_recurring_id === $recurring_history['gmo_recurring_id'] ) {
                    $this->gmo_collback_auto_login($recurring_history);
                    return true;
                } else {
                    return false;
                }
            } else {
                // 失敗の場合は失敗を表示するだけなのですぐ返す(ページ遷移するとセッションが切れる)
                $this->gmo_collback_auto_login($recurring_history);
                return true;
            }

        } else {
            return false;
        }
    }

    /**
     * GMOからのリダイレクトの際に自動ログインさせる
     * @todo 有効期限を配慮する処理を入れる
     * @param array $recurring_history GMOに登録した情報
     */
    private function gmo_collback_auto_login($recurring_history) {
        // 一度セッションを削除
        $this->delete_auth_info_session();
        $logic_user = Logic_HumanLife_User::instance();
        $user_id = $recurring_history['user_id'];
        $user_info = $logic_user->get_user_detail_info_by_user_id($user_id, BUSINESS_ID);
        // GMOからのレスポンスに進むフラグを再セット(関数分けるかも)
        Session::set(self::$SES_KEY_CALLBACK_IS_GMO, self::$SES_KEY_VALUE_CALLBACK_IS_GMO);
        // 新しいセッションをセット
        $this->set_session_auth_info($user_info['email'], $user_info['salt']);
        Log::application()->info('GMOからの自動ログイン');
    }

    /**
     * 共通情報をセットする
     *
     * @param array $user_info
     * @param int   $last_month_use_price
     * @return void
     */
    private function set_common_info($user_info) {

        $service_my_page_user = new Service_Mypage_User();

        Log::application()->info('共通情報のセット処理開始');
        $this->user_id = $user_info['user_id'];
        $this->user_type = $user_info['user_type'];
        $this->email = $user_info['email'];
        $this->last_name = $user_info['last_name'];
        $this->first_name = $user_info['first_name'];
        $this->company_id = $user_info['company_id'];
        // ヘッダ用リンク非表示リスト
        $this->not_available_list = $service_my_page_user->get_not_avalilable_list($this->user_id);
        $this->is_need_fake_header_menu = $service_my_page_user->get_is_need_fake_header_menu($this->not_available_list);

        $this->user_info = $user_info;

        if($this->user_id && $this->company_id) {
            // 法人用 利用規約が存在するか確認する
            $contract_service_user = $service_my_page_user->get_contract_service_id(BUSINESS_ID, $this->user_id);
            // 利用規約の表示制御のためプラン情報を習得する
            $is_hotel_plan = $service_my_page_user->get_is_hotel_plan($this->user_id, BUSINESS_ID);
            if(!empty($contract_service_user['contract_service_id'])) {
                // 法人に紐づいた利用規約のダウンロードリンクに変更する
                $this->is_corp = true;
            } else if($is_hotel_plan) {
                // ホテルプランの場合、利用規約データが存在しなければDLリンクを非表示にする
                $this->hide_contract_service = true;
            }

            // 法人用 覚書が存在するか確認する
            $memorandum = $service_my_page_user->get_memorandum_id(BUSINESS_ID, $this->user_id);
            if (!empty($memorandum['contract_service_id'])) {
                // 覚書ダウンロードリンクを表示する
                $this->is_memorandum = true;
            }
        }

        // 支払い方法取得
        $logic_settlement_info = new Logic_HumanLife_SettlementInfo();
        $settlement_info = $logic_settlement_info->get_settlement_info($this->user_id, BUSINESS_ID);
        $this->settlement_type_value = $settlement_info['settlement_type'];
        $this->settlement_type_value_list = SETTLEMENT_TYPE_VALUE_LIST;

        // ログ用のユーザー情報をセットする
        Log_Logger::set_user_info($user_info['user_id'], BUSINESS_ID);
        // エラーメール用のユーザー情報をセットする
        Helper_Mail::set_user_info($user_info['user_id'], BUSINESS_ID);
        Log::application()->info('共通情報のセット処理終了');
    }

    /**
     * セッションに含まれる認証情報が正しいかどうかを返す
     *
     * @param string $auth_info
     * @param string $email
     * @param string $salt
     * @return bool
     */
    private function is_valid_auth_info($auth_info, $email, $salt) {
        Log::application()->info('セッションに含まれる認証情報のチェック処理開始');

        $is_valid = true;

        if ($auth_info !== hash_hmac('sha256', $email . $salt, false)) {
            $is_valid = false;
        }

        $is_valid_message = $is_valid ? '正しい認証情報' : '不正な認証情報';
        Log::application()->info('セッションに含まれる認証情報のチェック処理終了 ' . $is_valid_message);

        return $is_valid;
    }

    /**
     * メンテナンス中かどうかを返す
     *
     * @return bool
     */
    private function is_maintenance() {
        Log::application()->info('メンテナンスチェック処理開始');
        $is_maintenance = Config::get('maintenance.is_maintenance', false);
        $is_maintenance_message = $is_maintenance ? 'メンテナンス中' : 'メンテナンス期間外';
        Log::application()->info('メンテナンスチェック処理終了 ' . $is_maintenance_message);
        return $is_maintenance;
    }

    /**
     * BASIC認証機能
     *
     * @param string $realm
     */
    private function http_basic_authenticate_with($realm = "Protected area") {
        if (!isset($_SERVER['PHP_AUTH_USER']) || !($_SERVER['PHP_AUTH_USER'] == BASIC_AUTH_USER_NAME && $_SERVER['PHP_AUTH_PW'] == BASIC_AUTH_PASSWORD)) {
            header('WWW-Authenticate: Basic realm="' . $realm . '"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Not allowed to access.';
            exit;
        }
    }

    /**
     * 初期表示かどうか
     * 初期表示の場合、セッションデータを削除する
     */
    protected function init_access_session_delete() {
        if (!Input::get('c_flg', false)) {
            // 初期表示の場合セッションデータを削除する
            Session::delete(self::$SES_KEY_INPUT_INFO);
        }
    }

    /**
     * 初期表示かどうか
     * 初期表示の場合、セッションデータを削除する
     */
    protected function init_contact_access_session_delete() {
        if (!Input::get('c_flg', false)) {
            // 初期表示の場合セッションデータを削除する
            Session::delete(self::$SES_KEY_CONTACT_INPUT_INFO);
        }
    }

    /**
     * 初期表示かどうか
     * 初期表示の場合、セッションデータを削除する
     */
    protected function init_wimax_contact_access_session_delete() {
        if (!Input::get('c_flg', false)) {
            // 初期表示の場合セッションデータを削除する
            Session::delete(self::$SES_KEY_WIMAX_CONTACT_INPUT_INFO);
        }
    }

    /**
     * 初期表示かどうか
     * 初期表示の場合、セッションデータを削除する
     */
    protected function init_global_contact_access_session_delete() {
        if (!Input::get('c_flg', false)) {
            // 初期表示の場合セッションデータを削除する
            Session::delete(self::$SES_KEY_GLOBAL_CONTACT_INPUT_INFO);
        }
    }

    /**
     * 初期表示かどうか
     * 初期表示の場合、セッションデータを削除する
     */
    protected function init_prepaid_contact_access_session_delete() {
        if (!Input::get('c_flg', false)) {
            // 初期表示の場合セッションデータを削除する
            Session::delete(self::$SES_KEY_PREPAID_CONTACT_INPUT_INFO);
        }
    }

    /**
     *  認証が必要か
     * パラメータに合致するmst_inflow_sourceの結果をセッションに保存
     */
    protected function is_required_auth() {
        // パラメータを取得
        $inflow_source = Session::get(self::$SES_KEY_INFLOW_SOURCE, []);
        $mst_inflow_source = Service_Entry::get_inflow_source_data($inflow_source);
        if (!empty($mst_inflow_source))
        {
            $query_string = Input::query_string();
            // セッションに追加
            $inflow_source['is_auth_required'] = $mst_inflow_source['is_auth_required'];
            $inflow_source['entry_route_name'] = $mst_inflow_source['entry_route_name'] === null ?
                                                    [] : explode(':',$mst_inflow_source['entry_route_name']);
            $inflow_source['select_view_file_name'] = $mst_inflow_source['select_view_file_name'];
            $inflow_source['lp_route_name'] = $mst_inflow_source['lp_route_name'];
            $inflow_source['query_string'] = $query_string;
            Session::set(self::$SES_KEY_INFLOW_SOURCE, $inflow_source);
        }
    }

    /**
     * FUJI APIからユーザ情報を取得
     *
     *
     * @return boolean
     */
    protected function getApiUserInfo($ses_key_input_info,$params=[]) {
        // セッションから流入経路と乗り換えのsourceを取得
        $inflow_source = Session::get(self::$SES_KEY_INFLOW_SOURCE, []);
        $is_change_user = false;

        // FUJI/FONからのhashがある場合
        if(!empty($inflow_source['change_plan_distinction'])) {
            $user_info = Service_Entry::get_change_plan_user_info(['change_plan_distinction' => $inflow_source['change_plan_distinction']]);
            if(!empty($user_info['error_code'])) {
                return $is_change_user;
            }
            $user_info = $user_info['user_info'];
        } else if(!empty($inflow_source['user_params'])) {
            $user_info = Service_Entry::get_change_plan_user_info($inflow_source['user_params']);
            if(!empty($user_info['error_code'])) {
                return $is_change_user;
            }
            $user_info = $user_info['user_info'];
        // 電話受付の場合basic認証経由
        } else if($this->access_basic_authenticate && !empty($params)) {
            $user_info = Service_Entry::get_user_info_via_basic($params);
            if(!empty($user_info['error_code'])) {
                return $is_change_user;
            }
            $user_info = $user_info['user_info'];
        // 乗り換えパラメータがある場合
        } else if($inflow_source['utm_medium'] === 'transfer') {
            $use_api = false;
            if ($inflow_source['utm_source'] === 'sbn') {
                $system_id = SYSTEM_ID_FON;
                $use_api = true;
            } else if($inflow_source['utm_source'] === 'fuji') {
                $system_id = SYSTEM_ID_FUJI;
                $use_api = true;
            } else {
                // TODO:今の所zeusが入る予定utm_mediumがtransfer以外でzeusが入る場合、修正が必要
                $user_info = Session::get($ses_key_input_info, []);
            }

            if($use_api) {
                if (empty($params) || !isset($inflow_source['user_params'])) {
                    return $is_change_user;
                }
                // 認証APIへPOSTする
                $user_params = Service_Entry::check_login_user($params['email'], $params['password'], $system_id);
                if(!empty($user_params['error_code'])) {
                    return $is_change_user;
                }
                // user情報APIへGETする
                $user_info = Service_Entry::get_change_plan_user_info($user_params);
                if(!empty($user_info['error_code'])) {
                    return $is_change_user;
                }
                $user_info = $user_info['user_info'];
            }
        }

        if(!empty($user_info)) {
            // ユーザーデータが取得できた場合、セッションに保存
            Session::set($ses_key_input_info, $user_info);
            $is_change_user = true;
        }

        return $is_change_user;
    }

    /**
     * 契約情報を取得して渡航期間を判定し、渡航期間終了日で各海外プラン追加、延長、変更機能を使用できるか判定する
     */
    protected function checkRentalPlanEndData() {
        $service_user = new Service_Mypage_User();
        $result = $service_user->is_rental_plan_change($this->user_id, BUSINESS_ID);

        $this->is_rental_contract = $result['is_contract'];
        $this->is_rental_plan_add = $result['is_add'];
        $this->is_rental_plan_change = $result['is_change'];
        $this->is_rental_plan_extension = $result['is_extension'];
        $this->is_rental_import_imei = $result['is_import_imei'];
        $this->is_rental_unbind_device = $result['is_unbind_device'];
    }

    /**
     * GMO利用できない時トップ遷移
     */
    protected function redirectToTopMaintenance($top_page_enum = 0) {
        // GMO利用できない時間を取る
        if (empty(GMO_DISABLE_START_DATETIME)) {
            return;
        } else {
            $gmo_disable_start_datetime = new DateTime(GMO_DISABLE_START_DATETIME);
        }

        // Current date and time
        $current_datetime = new DateTime();

        //GMO利用できない時間後トップにredirectする
        if ($current_datetime > $gmo_disable_start_datetime) {
            if ((int)$top_page_enum === GLOBAL_PAGE) {
                Response::redirect('https://zeuswifi-global.jp?maintenance=maintenance', 'location', HTTP_STATUS_OK);
            } elseif ((int)$top_page_enum === WIMAX_PAGE) {
                Response::redirect('https://wimax-zeuswifi.jp/?maintenance=maintenance', 'location', HTTP_STATUS_OK);
            } elseif ((int)$top_page_enum === CHARGE_PAGE) {
                Response::redirect(Router::get('prepaid_lp') . '?maintenance=maintenance', 'location', HTTP_STATUS_OK);
            } else {
                Response::redirect(Uri::base() . '?maintenance=maintenance', 'location', HTTP_STATUS_OK);
            }
        }
    }
}
