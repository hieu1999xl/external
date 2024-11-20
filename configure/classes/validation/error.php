<?php

/**
 * ValidationErrorクラス拡張.
 *
 * @author sakairi@liz-inc.co.jp
 */
class Validation_Error extends Fuel\Core\Validation_Error {

    /**
     * valid_stringのパラメータ部分の日本語化切替拡張
     *
     * {@inheritdoc}
     *
     * @see \Fuel\Core\Validation_Error::_replace_tags()
     */
    protected function _replace_tags($msg) {
        $msg = parent::_replace_tags($msg);
        $find = __('validation.valid_string_params');

        if ($find) {

            $msg = str_replace('valid_string(', '', $msg);
            $msg = str_replace(')', '', $msg);

            foreach ($find as $param => $str) {
                $msg = str_replace($param, $str, $msg);
            }
        }

        return $msg;

    }
}