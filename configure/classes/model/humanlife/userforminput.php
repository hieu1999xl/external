<?php
/**
 * 離脱フォームユーザ情報テーブルのモデルクラス
 */
class Model_HumanLife_UserFormInput extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string 離脱フォームユーザ情報テーブル名
     */
    protected static $_table_name = 'user_form_input';

    /**
     * @param string $form フォーム名
     * @param string $session_key セッションID
     * フォーム名とセッションキーでレコードを取得
     */
    public function get_by_form_and_session_id($form, $session_key) {

        $query = <<<SQL
SELECT
    user_form_input.user_form_input_id
FROM
    user_form_input
WHERE
    form = :form
    AND session_key = :session_key
SQL;

        $param = [
            'form'    => $form,
            'session_key' => $session_key,
        ];

        return DB::query($query)->parameters($param)
            ->execute()
            ->as_array();
    }

    /**
     * @param string $form フォーム名
     * @param string $email メールアドレス
     * フォーム名とメールアドレスでレコードを取得
     */
    public function get_by_form_and_email($form, $email) {

        $query = <<<SQL
SELECT
    user_form_input.user_form_input_id
FROM
    user_form_input
WHERE
    form = :form
    AND email = :email
SQL;

        $param = [
            'form'  => $form,
            'email' => $email,
        ];

        return DB::query($query)->parameters($param)
            ->execute()
            ->as_array();
    }

    /**
     * @param int $id レコードPK
     * レコードを物理的削除
     */
    public function remove_by_id($id) {

        $query = <<<SQL
DELETE FROM
    user_form_input
WHERE
    user_form_input.user_form_input_id = :id
SQL;

        $param = [
            'id'    => $id,
        ];

        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }

    /**
     * レコードをINSERTする
     *
     * @param array $pairs
     *            ['カラム名' => '値']形式の連想配列
     * @return number レコード数
     */
    public function insert($pairs)
    {
        $now_timestamp = time();
        $currentDateTime = date("Y-m-d H:i:s", $now_timestamp);

        $pairs['create_datetime'] = $currentDateTime;
        $pairs['create_user'] = SYSTEM_USER_NAME;
        $pairs['update_datetime'] = $currentDateTime;
        $pairs['update_user'] = SYSTEM_USER_NAME;

        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }

    /**
     * レコードを更新する
     *
     * @param array $pairs
     *            ['カラム名' => '値']形式の連想配列
     * @param array $wheres
     * @return number レコード数
     */
    public function update($pairs, $wheres) {
        return DB::update(self::$_table_name)->set($pairs)->where($wheres)->execute();
    }
}
