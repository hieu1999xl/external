<?php

/**
 * CrudModelの基底クラス
 *
 * Class Model_CrudAbstract
 */
class Model_CrudAbstract extends \Fuel\Core\Model_Crud {

    /**
     * Override find
     *
     * @param array $config
     * @param null  $key
     * @return array|null
     * @throws Exception_DatabaseException
     */
    public static function find($config = [], $key = null) {
        try {
            return parent::find($config, $key);
        } catch (Exception $e) {
            throw new Exception_DatabaseException($e);
        }

    }

    /**
     * ワイルドカード文字列をエスケープする
     *
     * @param string $value
     * @return string
     */
    public static function escape($value) {
        if (is_null($value) || strlen($value) <= 0) {
            return $value;
        }

        return str_replace(["\\", "%", "_"], ["\\\\", "\%", "\_"], $value);
    }

    /**
     * Override save
     *
     * @param bool $validate
     * @return mixed
     * @throws Exception_DatabaseException
     */
    public function save($validate = true) {
        try {
            return parent::save($validate);
        } catch (Exception $e) {
            throw new Exception_DatabaseException($e);
        }

    }

    /**
     * Gets called before the query is executed.
     * Must return the query object.
     *
     * @param Database_Query $query The query object
     * @return void
     */
    protected static function pre_find(&$query) {
        Log::application()->debug(get_called_class() . ' START');

    }

    /**
     * Gets called after the query is executed and right before it is returned.
     * $result will be null if 0 rows are returned.
     *
     * @param array|null $result the result array or null when there was no result
     * @return array|null
     */
    protected static function post_find($result) {
        Log::application()->debug(get_called_class() . ' END');
        return is_null($result) ? [] : $result;

    }

    /**
     * Gets called before the insert query is executed.
     * Must return
     * the query object.
     *
     * @param Database_Query $query The query object
     * @return void
     */
    protected function pre_save(&$query) {
        Log::application()->debug(get_called_class() . ' START');

    }

    /**
     * Gets called after the insert query is executed and right before
     * it is returned.
     *
     * @param array $result insert id and number of affected rows
     * @return array
     */
    protected function post_save($result) {
        Log::application()->debug(get_called_class() . ' END');
        return $result;

    }

    /**
     * Gets called before the update query is executed.
     * Must return the query object.
     *
     * @param Database_Query $query The query object
     * @return void
     */
    protected function pre_update(&$query) {
        Log::application()->debug(get_called_class() . ' START');

    }

    /**
     * Gets called after the update query is executed and right before
     * it is returned.
     *
     * @param int $result Number of affected rows
     * @return int
     */
    protected function post_update($result) {
        Log::application()->debug(get_called_class() . ' END');
        return $result;

    }

    /**
     * Gets called before the delete query is executed.
     * Must return the query object.
     *
     * @param Database_Query $query The query object
     * @return void
     */
    protected function pre_delete(&$query) {
        Log::application()->debug(get_called_class() . ' START');
    }

    /**
     * Gets called after the delete query is executed and right before
     * it is returned.
     *
     * @param int $result Number of affected rows
     * @return int
     */
    protected function post_delete($result) {
        Log::application()->debug(get_called_class() . ' END');
        return $result;

    }

    /**
     * 文字列を指定の文字数に加工する
     *
     * @param string $str
     * @param int    $start
     * @param int    $max_size
     * @return string
     */
    public static function customize_string_length($str, $start, $max_size) {
        return mb_substr($str, $start, $max_size);
    }
}