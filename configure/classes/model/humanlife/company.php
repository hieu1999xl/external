<?php

/**
 * 法人テーブルのモデルクラス
 */
class Model_HumanLife_Company extends Model_CrudAbstract {

    /**
     * テーブル名
     *
     * @var string
     */
    protected static $_table_name = 'company';

    /**
     * 登録する
     *
     * @param array $insert_params
     * @return int 登録したレコードのcompany_id
     */
    public function insert($insert_params) {

        // insert
        $query = <<<SQL
        INSERT INTO
            company
        SQL;

        $bind_params = [];
        $set = '(';
        $val = ') VALUES (';
        $is_first = true;
        foreach ($insert_params as $column => $value) {
            if (!$is_first) {
                $set .= ', ';
                $val .= ', ';
            }

            $set .= $column;
            $val .= ':' . $column;
            $bind_params[$column] = $value;
            $is_first = false;
        }
        $val .= ')';

        $query = $query . $set . $val;
        return DB::query($query)->parameters($bind_params)->execute()[0];
    }

    /**
     * 認証キーを条件に企業情報を取得する
     *
     * @param $entry_key
     * @return array
     */
    public function get_company_info_by_entry_key($entry_key) {
        
        $query = <<<SQL
        SELECT c.*, u.*,
              uci.email as email_address,
              uci.company_name,
              uci.last_name as user_last_name,
              uci.first_name as user_first_name
        FROM company AS c 
            INNER JOIN user AS u
            ON c.company_id = u.company_id
            INNER JOIN user_contact_info AS uci
            ON u.user_id = uci.user_id
        WHERE
            c.entry_key = :entry_key
        AND u.status = :status
        AND c.entry_key_expire_datetime > NOW()
SQL;

        $bind_params = [
            'entry_key' => $entry_key,
            'status'    => CORP_USER_STATUS_VALUE_LIST['WAIT_CONTRACT_DOC'],
        ];

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 複数条件を指定して簡単なSELECTを行う
     * @param array $select 取得カラム
     * @param array $wheres 検索条件[0 => [{カラム名} => {値}], 1 => ...]
     * @return array 抽出結果
     */
    public function get_record($select, $wheres) {
        if (empty($wheres)) return [];
        $query = DB::select_array($select)->from(self::$_table_name);
        foreach ($wheres as $key => $value) {
            $query->where($key, $value);
        }
        return $query->execute()->as_array();
    }

    /**
     * user_idで法人情報を取得すす
     * @param int $user_id
     * @param array $select 取得カラム
     * @return array 抽出結果
     */
    public function get_record_by_user_id($user_id, $select) {
        if (is_null($user_id)) return [];

        $sql = <<<SQL
SELECT
    %select_params%
FROM
    company c 
    INNER JOIN user u 
        ON c.company_id = u.company_id 
WHERE
    u.user_id = :user_id
SQL;

        $select_params = [];
        foreach ($select as $key) {
            $select_params[] = 'c.' . $key;
        }
        $sql = str_replace('%select_params%', implode(',', $select_params), $sql);

        return DB::query($sql)->parameters(['user_id' => $user_id])->execute()->current();
    }

    /**
     * 顧客IDをキーにして更新処理を行う
     *
     * @param int $user_id
     * @param array $params 更新用のパラメータ[0 => [{カラム名} => {値}], 1 => ...]
     * @return int 更新されたレコード数
     */
    public function update_by_user_id($user_id, $params)
    {
        // 更新内容設定
        $set_params = [];
        foreach (array_keys($params) as $column) {
            $set_params[] = $column . " = :" . $column;
        }

        $sql = <<<SQL
UPDATE company 
SET
    %set_params%
WHERE
    company_id = ( 
        SELECT
            company_id 
        FROM
            user 
        WHERE
            user_id = :user_id
    )
SQL;

        $sql = str_replace('%set_params%', implode(',', $set_params), $sql);
        $params['user_id'] = $user_id;
        parent::pre_update($sql);
        $result = DB::query($sql)->parameters($params)->execute();
        return parent::post_update($result);
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
        if (empty($wheres)) return 0;
        return DB::update(self::$_table_name)->set($pairs)->where($wheres)->execute();
    }
}
