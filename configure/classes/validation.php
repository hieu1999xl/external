<?php

/**
 * Validationクラス拡張
 *
 * @author sakairi@liz-inc.co.jp
 */
class Validation extends Fuel\Core\Validation {
    /**
     * コンストラクタ
     * 独自バリデーションクラスのメソッドを追加
     *
     * @param unknown $fieldset
     */
    protected function __construct($fieldset) {
        parent::__construct($fieldset);
        $this->add_callable(new Validation_Extension());
    }

    /**
     * 検証条件をまとめて指定
     *
     * @param array $params 検証条件 <br>
     *                      例：array('hoge' => array('label' => 'ほげ', 'rules' => 'required'))
     * @return boolean
     */
    public function add_fieldset($params = []) {
        // 検証条件セット
        if (is_array($params)) {
            foreach ($params as $name => $conf) {
                if (strlen($conf['rules']) > 0) {
                    $this->add_field($name, $conf['label'], $conf['rules']);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * パスワード形式チェック
     *
     * @param string $val
     * @return bool
     */
    public function _validation_valid_password($val) {
        if ($this->_empty($val)) {
            return true;
        }

        // 半角英字が含まれているか
        if (preg_match('/[a-zA-Z]/u', $val) !== 1) {
            return false;
        }

        // 半角数字が含まれているか
        if (preg_match('/[0-9]/u', $val) !== 1) {
            return false;
        }

        // 半角英数字のみか
        if (!$this->_validation_valid_string($val, 'alpha_numeric')) {
            return false;
        }

        // 最小文字数以上か
        if (!$this->_validation_min_length($val, PASSWORD_MIN_LENGTH)) {
            return false;
        }

        // 最大文字数以下か
        if (!$this->_validation_max_length($val, PASSWORD_MAX_LENGTH)) {
            return false;
        }

        return true;
    }

    /**
     * パスワード一致チェック
     *
     * @param string $val
     * @param string $password
     * @param string $salt
     * @return bool
     */
    public function _validation_match_password($val, $password, $salt) {
        // ハッシュ値の生成
        $hash_val = hash_hmac('sha256', $val . $salt, false);
        return $this->_empty($val) || $this->_validation_match_value($hash_val, $password, true);
    }

    /**
     * 入力した日付が指定の日以前であることのチェック
     *
     * @param string $from
     * @param string $to
     * @return bool false: 日付相関エラー
     */
    public static function _validation_date_before($from, $to) {
        if (is_null($from) || strlen($from) <= 0 || is_null($to) || strlen($to) <= 0) {
            return false;
        }
        if (new DateTime($to) < new DateTime($from)) {
            return false;
        }
        return true;
    }

    /**
     * 日付の有効範囲チェック
     *
     * @param string $date 入力値
     * @param string $from
     * @param string $to
     * @return bool false: 日付相関エラー
     */
    public static function _validation_date_range($date, $from, $to) {
        if (new DateTime($date) < new DateTime($from) || new DateTime($to) < new DateTime($date)) {
            return false;
        }
        return true;
    }

    /**
     * 最短レンタル開始日チェック
     *
     * @param string $date レンタル開始日 
     * @param int $min_days 最短開始日数
     * @return bool false: 日付相関エラー
     */
    public static function _validation_rental_start_days($date, $min_days) {
        $target_date = new DateTime('+' . $min_days . 'days');
        if (new DateTime($date) >= $target_date->setTime(0, 0, 0)) {
            return true;
        }

        return false;
    }
}
