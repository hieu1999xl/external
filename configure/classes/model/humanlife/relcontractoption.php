<?php

/**
 * 契約オプションテーブルのモデルクラス
 */
class Model_HumanLife_RelContractOption extends Model_CrudAbstract {

    /**
     * テーブル名
     *
     * @var string  請求書番号管理テーブル名
     */
    protected static $_table_name = 'rel_contract_option';

    /**
     * プライマリキー
     * @var String
     */
    protected static $_primary_key = 'contract_option_id';

    /**
     * プライマリキーを条件に1レコード取得する
     * @param String $id
     * @param array  $select 取得カラム名の配列
     * @return array|null 取得結果
     */
    public function get_rel_contract_option_info_by_pk($id, $select = ['*']){
        $query = DB::select_array($select)->from(self::$_table_name)
                                          ->join('mst_option', 'inner')
                                          ->on(self::$_table_name.'.option_id', '=', 'mst_option.option_id')
                                          ->where(self::$_primary_key, $id);
        return $query->execute()->current();
    }

    /**
     * プライマリキーを条件に複数レコード取得する
     * @param String $id
     * @param array  $select 取得カラム名の配列
     * @return array|null 取得結果
     */
    public function get_rel_contract_option_info_by_pks($ids, $select = ['*']){
        $query = DB::select_array($select)->from(self::$_table_name)
                                          ->where(self::$_primary_key,'in', $ids);
        return $query->execute()->as_array();
    }

    /**
     * rel_contract_option.contract_option_idとuser.user_idをキーにレコードを取得
     * @param Array  $contract_option_ids
     * @param String $user_id
     * @param String $business_id
     * @return Array
     */
    public function get_record_by_contract_option_id_and_user_id_and_enddate($contract_option_ids, $user_id, $business_id){
        $query = <<<SQL
SELECT
  rco.contract_option_id
 ,rco.contract_id
 ,rco.option_id
 ,u.user_id
 ,o.name
FROM rel_contract_option rco
INNER JOIN mst_option o
        ON rco.option_id = o.option_id
INNER JOIN contract c
        ON rco.contract_id = c.contract_id
INNER JOIN user u
        ON c.user_id = u.user_id
       AND u.user_id = :user_id
WHERE rco.contract_option_id IN :contract_option_ids
  AND rco.business_id = :business_id
  AND (   rco.option_end_date IS NULL
       OR rco.option_end_date <= NOW() )
SQL;
        $param = [
            'contract_option_ids'=> $contract_option_ids,
            'business_id'        => $business_id,
            'user_id'            => $user_id,
        ];

        return DB::query($query)->parameters($param)->execute()->as_array();
    }

    /**
     * contract_option_idとユーザーIDで現時点以降の終了日のオプションを取得する
     * @param array $contract_option_ids
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_record_by_contract_option_id_and_bank_transfer_user_id_and_enddate($contract_option_ids, $user_id, $business_id){
        $query = <<<SQL
SELECT
  rco.contract_option_id
 ,rco.contract_id
 ,rco.option_id
 ,u.user_id
 ,o.name
FROM rel_contract_option rco
INNER JOIN mst_option o
        ON rco.option_id = o.option_id
INNER JOIN contract c
        ON rco.contract_id = c.contract_id
INNER JOIN user u
        ON c.user_id = u.user_id
       AND u.user_id = :user_id
WHERE rco.contract_option_id IN :contract_option_ids
  AND rco.business_id = :business_id
  AND rco.option_end_date > NOW()
SQL;
        $param = [
            'contract_option_ids'=> $contract_option_ids,
            'business_id'        => $business_id,
            'user_id'            => $user_id,
        ];

        return DB::query($query)->parameters($param)->execute()->as_array();
    }

    /**
     * 契約中のオプション情報を削除する
     *
     * @param int    $user_id
     * @param array  $contract_option_id_list
     * @param int    $business_id
     * @param string $option_end_date
     * @return void
     */
    public function update_option_end_date_by_contract_option_id_list($user_id, $contract_option_id_list, $business_id, $option_end_date) {
        $sql = <<<SQL
UPDATE
    rel_contract_option
SET
    option_end_date = :option_end_date
    , update_user = :update_user
    , update_datetime = :update_datetime
    , cancel_application_datetime = NOW()
WHERE
    contract_option_id IN :contract_option_id_list
AND
    business_id = :business_id
SQL;

        $param = [
            'contract_option_id_list'  => $contract_option_id_list,
            'business_id'     => $business_id,
            'option_end_date' => $option_end_date,
            'update_user' => $user_id,
            'update_datetime' => date("Y-m-d H:i:s")
        ];

        DB::query($sql)->parameters($param)->execute();
    }

    /**
     * オプションの登録を行う
     *
     * @param int    $contract_id
     * @param int    $option_id
     * @param int    $business_id
     * @param string $option_start_date
     * @param string $option_end_date
     * @return array
     */
    public function insert_contract_option($contract_id, $option_id, $business_id, $option_start_date, $option_end_date) {
        $sql = <<<SQL
INSERT INTO
    rel_contract_option (
        contract_id,
        option_id,
        business_id,
        option_start_date,
        option_end_date,
        create_datetime,
        create_user,
        update_datetime,
        update_user
    )
VALUE (
    :contract_id,
    :option_id,
    :business_id,
    :option_start_date,
    :option_end_date,
    NOW(),
    :create_user,
    NOW(),
    :update_user
)
SQL;

        $param = [
            'contract_id'       => $contract_id,
            'option_id'         => $option_id,
            'business_id'       => $business_id,
            'option_start_date' => $option_start_date,
            'option_end_date'   => $option_end_date,
            'create_user'       => SYSTEM_USER_NAME,
            'update_user'       => SYSTEM_USER_NAME,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute();
        return parent::post_find($result);
    }

    /**
     * 契約IDを条件に契約－オプション情報を取得する
     *
     * @param int $business_id
     * @param int $contract_id
     * @return array
     */
    public function get_contract_option_info_list_by_contract_id($business_id, $contract_id) {
        $sql = <<<SQL
SELECT
    rco.contract_option_id
  , rco.option_start_date
  , rco.option_end_date
  , mo.option_id
  , mo.name
  , mo.option_type
  , mo.price
  , mo.billing_type
  , mo.tax_type
FROM
    rel_contract_option AS rco
        INNER JOIN
            mst_option AS mo
        ON
            mo.option_id = rco.option_id
        AND mo.business_id = rco.business_id
WHERE
    rco.contract_id = :contract_id
AND rco.business_id = :business_id
AND rco.delete_flag = :delete_flag
ORDER BY
    rco.contract_option_id ASC
SQL;

        $params = [
            'contract_id' => $contract_id,
            'business_id' => $business_id,
            'delete_flag' => FLG_OFF,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 契約IDを条件に契約－オプション情報を取得する
     *
     * @param int $business_id
     * @param int $contract_id
     * @param array $option_id_list
     * @return array
     */
    public function get_contract_option_info_list_by_contract_id_and_option_id_list($business_id, $contract_id, $option_id_list) {
        $sql = <<<SQL
SELECT
    rco.contract_option_id
  , rco.contract_id
  , rco.insurance_account
  , mo.option_id
  , mo.name
  , mo.option_type
  , mo.price
  , mo.billing_type
  , mo.tax_type
  , mo.insurance_plan_id
FROM
    rel_contract_option AS rco
        INNER JOIN
            mst_option AS mo
        ON
            mo.option_id = rco.option_id
        AND mo.business_id = rco.business_id
WHERE
    rco.contract_id = :contract_id
AND rco.option_id IN :option_id_list
AND rco.business_id = :business_id
AND rco.delete_flag = :delete_flag
AND rco.option_end_date IS NULL
ORDER BY
    rco.contract_option_id ASC
SQL;

        $params = [
            'contract_id' => $contract_id,
            'option_id_list' => $option_id_list,
            'business_id' => $business_id,
            'delete_flag' => FLG_OFF,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * ユーザIDを条件に月額課金オプションの利用終了日を更新する
     *
     * @param int    $business_id
     * @param int    $user_id
     * @param string $option_end_date
     * @return int
     */
    public function update_option_end_date_of_monthly_option_by_user_id($business_id, $user_id, $option_end_date) {
        $sql = <<<SQL
UPDATE
    rel_contract_option AS rco
SET
    option_end_date = :option_end_date
  , update_datetime = :current_datetime
  , update_user = :system_user
WHERE
    rco.business_id = :business_id
AND rco.option_end_date IS NULL
AND rco.delete_flag = :delete_flag
AND rco.contract_id IN (
        SELECT
            c.contract_id
        FROM
            contract AS c
        WHERE
            c.business_id = rco.business_id
        AND c.user_id = :user_id
    )
AND rco.option_id IN (
        SELECT
            mo.option_id
        FROM
            mst_option AS mo
        WHERE
            mo.business_id = rco.business_id
        AND mo.billing_type = :billing_type
    )
SQL;

        $params = [
            'option_end_date'  => $option_end_date,
            'current_datetime' => Helper_Time::getCurrentDateTime(),
            'system_user'      => SYSTEM_USER_NAME,
            'business_id'      => $business_id,
            'delete_flag'      => FLG_OFF,
            'user_id'          => $user_id,
            'billing_type'     => BILLING‗TYPE_VALUE_LIST['MONTHLY'],
        ];

        parent::pre_update($sql);
        $result = DB::query($sql)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * レコードを更新する
     *
     * @param array $pairs ['カラム名' => '値']形式の連想配列
     * @param array $wheres
     * @return number レコード数
     */
    public function update($pairs, $wheres) {
        return DB::update(self::$_table_name)->set($pairs)->where($wheres)->execute();
    }

    /**
     * 契約IDをkeyに契約オプション情報を取得する
     *
     * @param int $business_id
     * @param int $contract_id
     *
     * @return array
     */
    public function get_valid_rel_contract_option_by_contract_id($business_id, $contract_id)
    {
        $query = DB::select()
        ->from(self::$_table_name)
        ->where('business_id', $business_id)
        ->where('contract_id', $contract_id)
        ->where('delete_flag', FLG_OFF)
        ->where_open()
            ->where('option_end_date', '=', null)
            ->or_where('option_end_date', '>', DB::expr('now()'))
        ->where_close();

        return $query->execute()->as_array();
    }

    /**
     * 契約IDとオプションIDで契約オプション情報を取得する
     *
     * @param int $business_id
     * @param int $contract_id
     * @param int $option_id
     *
     * @return array
     */
    public function get_contract_option_by_contract_id_and_option_id($business_id, $contract_id, $option_id)
    {
        $query = DB::select(
            'rco.contract_option_id',
            'rco.option_id',
            'rco.option_start_date',
            'mo.name',
            'mo.option_type',
            'mo.price',
            'mo.billing_type',
            'mo.tax_type',
            'mo.insurance_plan_id',
            'eo.entry_option_id'
        )
        ->from([self::$_table_name, 'rco'])
        ->join(['mst_option', 'mo'])
            ->on('rco.business_id', '=', 'mo.business_id')
            ->on('rco.option_id', '=', 'mo.option_id')
        ->join(['contract', 'c'])
            ->on('rco.business_id', '=', 'c.business_id')
            ->on('rco.contract_id', '=', 'c.contract_id')
        ->join(['entry_option', 'eo'], 'left')
            ->on('rco.business_id', '=', 'eo.business_id')
            ->on('c.entry_id', '=', 'eo.entry_id')
            ->on('rco.option_id', '=', 'eo.option_id')
        ->where('rco.business_id', $business_id)
        ->where('rco.contract_id', $contract_id)
        ->where('rco.option_id', $option_id)
        ->where('rco.delete_flag', FLG_OFF)
        ->where('rco.option_end_date', '=', null);

        return $query->execute()->as_array();
    }

    /**
     * 契約IDを条件にオプションの利用終了日を更新する
     *
     * @param int    $business_id
     * @param int    $contract_id
     * @param string $option_end_date
     * @return int
     */
    public function update_option_end_date_by_contract_id($business_id, $contract_id, $option_end_date) {
        $sql = <<<SQL
UPDATE
    rel_contract_option AS rco
SET
    option_end_date = :option_end_date
  , update_datetime = :current_datetime
  , update_user = :system_user
WHERE
    rco.business_id = :business_id
AND rco.option_end_date IS NULL
AND rco.delete_flag = :delete_flag
AND rco.contract_id IN (
        SELECT
            c.contract_id
        FROM
            contract AS c
        WHERE
            c.business_id = rco.business_id
        AND c.contract_id = :contract_id
    )
AND rco.option_id IN (
        SELECT
            mo.option_id
        FROM
            mst_option AS mo
        WHERE
            mo.business_id = rco.business_id
        AND mo.billing_type = :billing_type
    )
SQL;

        $params = [
            'option_end_date'  => $option_end_date,
            'current_datetime' => Helper_Time::getCurrentDateTime(),
            'system_user'      => SYSTEM_USER_NAME,
            'business_id'      => $business_id,
            'delete_flag'      => FLG_OFF,
            'contract_id'      => $contract_id,
            'billing_type'     => BILLING‗TYPE_VALUE_LIST['MONTHLY'],
        ];

        parent::pre_update($sql);
        $result = DB::query($sql)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * PKを条件にオプションの利用終了日を更新する
     *
     * @param int    $business_id
     * @param int    $contract_option_id
     * @param string $option_end_date
     * @return int
     */
    public function update_option_end_date_by_contract_option_id($business_id, $contract_option_id, $option_end_date) {
        $sql = <<<SQL
UPDATE
    rel_contract_option
SET
    option_end_date = :option_end_date
  , update_datetime = :current_datetime
  , update_user = :system_user
WHERE
    business_id = :business_id
AND delete_flag = :delete_flag
AND contract_option_id = :contract_option_id
SQL;

        $params = [
            'business_id'        => $business_id,
            'contract_option_id' => $contract_option_id,
            'option_end_date'    => $option_end_date,
            'current_datetime'   => Helper_Time::getCurrentDateTime(),
            'system_user'        => SYSTEM_USER_NAME,
            'delete_flag'        => FLG_OFF,
        ];

        parent::pre_update($sql);
        $result = DB::query($sql)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * 契約IDを条件にオプションの利用終了日を更新する
     *
     * @param int    $business_id
     * @param int    $contract_id
     * @param string $option_end_date
     * @return int
     */
    public function update_option_end_date_by_contract_id_for_rental($business_id, $contract_id, $option_end_date) {
        $sql = <<<SQL
UPDATE
    rel_contract_option AS rco
SET
    option_end_date = :option_end_date
  , rental_end_date = :option_end_date
  , update_datetime = :current_datetime
  , update_user = :system_user
WHERE
    rco.business_id = :business_id
AND rco.delete_flag = :delete_flag
AND rco.contract_id IN (
        SELECT
            c.contract_id
        FROM
            contract AS c
        WHERE
            c.business_id = rco.business_id
        AND c.contract_id = :contract_id
    )
AND rco.option_id IN (
        SELECT
            mo.option_id
        FROM
            mst_option AS mo
        WHERE
            mo.business_id = rco.business_id
        AND mo.billing_type = :billing_type
    )
SQL;

        $params = [
            'option_end_date'  => $option_end_date,
            'current_datetime' => Helper_Time::getCurrentDateTime(),
            'system_user'      => SYSTEM_USER_NAME,
            'business_id'      => $business_id,
            'delete_flag'      => FLG_OFF,
            'contract_id'      => $contract_id,
            'billing_type'     => BILLING‗TYPE_VALUE_LIST['EACH_TIME'],
        ];

        parent::pre_update($sql);
        $result = DB::query($sql)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * PKを条件にオプションの利用終了日を更新する
     *
     * @param int    $business_id
     * @param int    $contract_option_id
     * @param string $option_end_date
     * @return int
     */
    public function update_option_end_date_by_contract_option_id_for_rental($business_id, $contract_option_id, $option_end_date) {
        $sql = <<<SQL
UPDATE
    rel_contract_option
SET
    option_end_date = :option_end_date
  , rental_end_date = :option_end_date
  , update_datetime = :current_datetime
  , update_user = :system_user
WHERE
    business_id = :business_id
AND delete_flag = :delete_flag
AND contract_option_id = :contract_option_id
SQL;

        $params = [
            'business_id'        => $business_id,
            'contract_option_id' => $contract_option_id,
            'option_end_date'    => $option_end_date,
            'current_datetime'   => Helper_Time::getCurrentDateTime(),
            'system_user'        => SYSTEM_USER_NAME,
            'delete_flag'        => FLG_OFF,
        ];

        parent::pre_update($sql);
        $result = DB::query($sql)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * contract_idから購入済みのオプションの情報を取得する
     *
     * @param  int   $contract_id
     * @return array 取得結果
     */
    public function get_purchased_prepaid_option_by_contract_id($contract_id) {
        $sql = <<<SQL
SELECT
    rco.contract_option_id,
    rco.option_id,
    rco.option_start_date,
    rco.option_end_date,
    rco.create_datetime AS option_entry_datetime,
    mo.name,
    mo.price,
    mo.tax_type,
    mo.option_type
FROM rel_contract_option AS rco
INNER JOIN
    mst_option AS mo
    ON rco.option_id = mo.option_id
    AND rco.business_id = mo.business_id
WHERE
    rco.contract_id = :contract_id AND
    rco.business_id = :business_id AND
    mo.business_id = :business_id
ORDER BY rco.contract_option_id DESC
SQL;

        $param = [
            'contract_id' => $contract_id,
            'business_id' => BUSINESS_ID,
        ];

        return DB::query($sql)->parameters($param)->execute()->as_array();
    }

    /**
     * 契約IDとオプションIDを条件に契約－オプション情報の数を取得する
     *
     * @param int $business_id
     * @param int $contract_id
     * @param int $option_id
     * @return array
     */
    public function get_count_contract_option_info_all_list_by_contract_id_and_option_id_list($business_id, $contract_id, $option_id) {
        $sql = <<<SQL
SELECT
    count(contract_option_id) as count
FROM
    rel_contract_option
WHERE
    contract_id = :contract_id
AND option_id   = :option_id
AND business_id = :business_id
AND delete_flag = :delete_flag
SQL;

        $params = [
            'contract_id' => $contract_id,
            'option_id'   => $option_id,
            'business_id' => $business_id,
            'delete_flag' => FLG_OFF,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute();
        return parent::post_find($result[0]['count']);
    }
}
