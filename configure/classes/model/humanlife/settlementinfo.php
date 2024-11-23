<?php

/**
 * ユーザー決済テーブルのモデルクラス
 */
class Model_HumanLife_SettlementInfo extends Model_CrudAbstract {

    /**
     * テーブル名
     *
     * @var string  GMOクレカ決済テーブル名
     */
    protected static $_table_name = 'settlement_info';

    /**
     * ユーザー決済情報を取得する
     *
     * @param int $user_id
     * @param int $business_id
     * @return array
     */
    public function get_settlement_info($user_id, $business_id) {
        $sql = <<<SQL
SELECT
    *
FROM
     settlement_info
WHERE
    user_id = :user_id
AND
    business_id = :business_id
SQL;

        $param = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 契約番号でユーザーを探して、ユーザーの決済方法を取得する
     * @param int $contract_id
     * @param int $business_id
     * @return array|null
     */
    public function get_settlement_info_by_contract_id($contract_id, $business_id) {
        $sql = <<<SQL
SELECT
    *
FROM
     settlement_info
INNER JOIN contract
    ON settlement_info.user_id = contract.user_id
    AND settlement_info.business_id = contract.business_id
WHERE
    contract.contract_id = :contract_id
AND
    contract.business_id = :business_id
SQL;

        $param = [
            'contract_id' => $contract_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * GMO会員IDを元にユーザー決済情報を取得する
     *
     * @param string $gmo_member_id
     * @param int $business_id
     * @return array
     */
    public function get_settlement_info_by_member_id($gmo_member_id, $business_id) {
        $sql = <<<SQL
SELECT
    *
FROM
    settlement_info
WHERE
    gmo_member_id = :gmo_member_id
AND
    business_id = :business_id
ORDER BY
    user_id DESC 
LIMIT
    1
SQL;

        $param = [
            'gmo_member_id'  => $gmo_member_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 登録する
     *
     * @param array $insert_params
     * @return int 登録件数
     */
    public function insert($insert_params) {

        // insert
        $query = <<<SQL
        INSERT INTO
            settlement_info
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
        return DB::query($query)->parameters($bind_params)->execute();
    }

    /**
     * 更新する
     *
     * @param array $update_params
     * @return int 更新件数
     */
    public function update($update_params) {

        // update
        $query = <<<SQL
UPDATE
    settlement_info
SET
    settlement_type = :settlement_type
  , gmo_member_id = :gmo_member_id
  , gmo_card_id = :gmo_card_id
  , gmo_bank_tran_id = :gmo_bank_tran_id
  , gmo_status = :gmo_status
  , update_datetime = :update_datetime
  , update_user = :update_user
WHERE
    user_id = :user_id
AND business_id = :business_id
SQL;

        $params = [
            'business_id' => $update_params["business_id"],
            'user_id'     => $update_params["user_id"],
            'settlement_type'  => $update_params["settlement_type"],
            'gmo_member_id'    => $update_params["gmo_member_id"],
            'gmo_card_id'      => $update_params["gmo_card_id"],
            'gmo_bank_tran_id' => $update_params["gmo_bank_tran_id"],
            'gmo_status'       => $update_params["gmo_status"],
            'update_datetime'  => $update_params["update_datetime"],
            'update_user'      => $update_params["update_user"],
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * 更新する（atone情報）
     *
     * @param array $update_params
     * @return int 更新件数
     */
    public function update_atone($update_params) {

        // update
        $query = <<<SQL
UPDATE
    settlement_info
SET
    np_status       = :np_status
  , np_token        = :np_token
  , update_user     = :update_user
SQL;
        // 決済方法の指定が有ったときのみ変更する
        if (!empty($update_params['settlement_type'])) {
            $query .= ', settlement_type = :settlement_type ';
            $query .= ', first_transaction_id = :first_transaction_id ';
        }

        $query .= <<<SQL

WHERE
    user_id = :user_id
AND business_id = :business_id
SQL;

        // パラメータが空の場合settlement_typeは更新しない（認証だけして途中でやめる場合がある）
        $params = [
            'business_id'       => BUSINESS_ID,
            'user_id'           => $update_params["user_id"],
            'np_status'         => $update_params["np_status"],
            'np_token'          => $update_params["np_token"],
            'update_user'       => $update_params["update_user"],
        ];
        if (!empty($update_params['settlement_type'])) {
            $params['settlement_type'] = $update_params['settlement_type'];
            $params['first_transaction_id'] = $update_params['first_transaction_id'];
        }

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }


    /**
     * 更新する
     *
     * @param array $update_params
     * @return int 更新件数
     */
    public function update_recurring_data($update_params) {

        // update
        $query = <<<SQL
UPDATE
    settlement_info
SET
    gmo_member_id = :gmo_member_id
  , gmo_status = :gmo_status
  , gmo_recurring_id = :gmo_recurring_id
  , email = :email
  , tel1_1 = :tel1_1
  , tel1_2 = :tel1_2
  , tel1_3 = :tel1_3

WHERE
    user_id = :user_id
SQL;

        $params = [
            'user_id' => $update_params["user_id"],
            'gmo_member_id'    => $update_params["gmo_member_id"],
            'gmo_recurring_id' => $update_params["gmo_recurring_id"],
            'gmo_status'       => $update_params["gmo_status"],
            'email'       => $update_params["email"],
            'tel1_1'       => $update_params["tel1_1"],
            'tel1_2'       => $update_params["tel1_2"],
            'tel1_3'       => $update_params["tel1_3"],
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    /**
     * GMOカードIDを更新する
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param string $gmo_card_id
     */

    public function update_gmo_card_id($user_id, $business_id) {
        $sql = <<<SQL

UPDATE
    settlement_info
SET
    settlement_type = :settlement_type,
    gmo_card_id = :gmo_card_id
WHERE
    user_id = :user_id
AND business_id = :business_id

SQL;

        $params = [
            'user_id'         => $user_id,
            'business_id'     => $business_id,
            'settlement_type' => SETTLEMENT_TYPE_VALUE_LIST['CREDIT_CARD'],
            // カードは常に1枚登録のため
            'gmo_card_id'     => 0,
        ];

        parent::pre_update($query);
        $result = DB::query($sql)->parameters($params)->execute();
        parent::post_update($result);
    }
    //        $model_human_life_settlement_info->update_gmo_card_id($user_id, $business_id, $gmo_card_id);

    /**
     * INVOICE_IDを更新する
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param string $gmo_card_id
     */

    public function update_settlement_type($user_id, $business_id) {
        $sql = <<<SQL
UPDATE
    settlement_info
SET
    settlement_type = :settlement_type
WHERE
    user_id = :user_id
AND business_id = :business_id

SQL;

        $params = [
            'user_id'         => $user_id,
            'business_id'     => $business_id,
            'settlement_type' => SETTLEMENT_TYPE_VALUE_LIST['INVOICE'],
        ];
        parent::pre_update($query);
        $result = DB::query($sql)->parameters($params)->execute();
        parent::post_update($result);
    }

    /**
     * settlement_typeを更新する
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param int $settlement_type
     */

     public function update_specify_settlement_type($user_id, $business_id, $settlement_type) {
        $sql = <<<SQL
UPDATE
    settlement_info
SET
    settlement_type = :settlement_type
WHERE
    user_id = :user_id
AND business_id = :business_id

SQL;

        $params = [
            'user_id'         => $user_id,
            'business_id'     => $business_id,
            'settlement_type' => $settlement_type,
        ];
        parent::pre_update($query);
        $result = DB::query($sql)->parameters($params)->execute();
        parent::post_update($result);
    }

    /**
     *  GET SETTLMENT_TYPE
     *
     * @param int $user_id
     * @param int $contract_id
     * @param int $business_id
     * @return array
     */
    public function get_corp_user_settlement_type($user_id,$business_id) {
        $sql = <<<SQL
SELECT
    s.settlement_type
FROM
   settlement_info AS s
WHERE
    s.user_id = :user_id
AND
    s.business_id = :business_id
SQL;

        $param = [
            'user_id'     => $user_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * GMO登録状況を更新する
     *
     * @param int    $user_id
     * @param int    $business_id
     * @param string $gmo_card_id
     */

    public function update_gmo_settlement_info($user_id, $business_id, $params) {
        $sql = <<<SQL
UPDATE
    settlement_info
SET
    settlement_type = :settlement_type,
    gmo_member_id = :gmo_member_id,
    gmo_card_id = :gmo_card_id,
    gmo_status = :gmo_status
WHERE
    user_id = :user_id
AND business_id = :business_id

SQL;

        $params = [
            'user_id'         => $user_id,
            'business_id'     => $business_id,
            'settlement_type' => $params['settlement_type'],
            'gmo_member_id'   => $params['gmo_member_id'],
            'gmo_card_id'     => $params['gmo_card_id'],
            'gmo_status'      => $params['gmo_status'],
        ];
        parent::pre_update($query);
        $result = DB::query($sql)->parameters($params)->execute();
        parent::post_update($result);
    }

    /**
     * NP atone transaction情報を更新する
     *
     * @param int    $user_id
     * @param array $params 更新パラメータ
     */

    public function update_atone_transaction_info($user_id, $params) {
        $sql = <<<SQL
UPDATE
    settlement_info
SET
    settlement_type = :settlement_type,
    np_status = :np_status,
    first_transaction_id = :first_transaction_id,
    update_user = :update_user
WHERE
    user_id = :user_id
AND business_id = :business_id

SQL;

        $params = [
            'user_id'         => $user_id,
            'business_id'     => BUSINESS_ID,
            'settlement_type' => $params['settlement_type'],
            'np_status'       => $params['np_status'],
            'first_transaction_id' => $params['first_transaction_id'],
            'update_user'     => $params['update_user'],
        ];
        parent::pre_update($query);
        $result = DB::query($sql)->parameters($params)->execute();
        parent::post_update($result);
    }

    /**
     * user_idをキーにsettlementinfo情報を取得する
     * @param int   $user_id
     * @param array $select      取得するカラム名の配列
     * @return array
     */
    public function get_gmo_settlement_by_user_id($user_id ,  array $select = ['*']){
        $query = DB::select_array($select)
                   ->from(self::$_table_name)
                   ->where('business_id', BUSINESS_ID)
                   ->where('user_id', $user_id);
        return $query->execute()->current();
    }

    /**
     * GMOこんど払いIDを更新する
     *
     * @param int    $gmo_member_id
     * @param string $gmo_recurring_id
     * @param string $gmo_status
     */
    public function update_gmo_recurring_id($gmo_member_id, $gmo_recurring_id, $gmo_status) {

        $sql = <<<SQL
UPDATE
    settlement_info
SET
    gmo_recurring_id = :gmo_recurring_id,
    gmo_status = :gmo_status
WHERE
    gmo_member_id = :gmo_member_id
AND business_id = :business_id
SQL;

        $params = [
            'gmo_recurring_id' => $gmo_recurring_id,
            'gmo_status'       => $gmo_status,
            'gmo_member_id'    => $gmo_member_id,
            'business_id'      => BUSINESS_ID,
        ];

        parent::pre_update($query);
        $result = DB::query($sql)->parameters($params)->execute();
        parent::post_update($result);
    }

    /**
     * ユーザIDを元に、レコードを取得する
     *
     * @param integer $business_id
     * @param integer $user_id
     * @return array 取得結果
     */
    public function get_by_user_id($business_id, $user_id) {
        $query = <<<SQL
        SELECT
          *
        FROM
            settlement_info
        WHERE
            business_id = :business_id
            AND user_id = :user_id

SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['user_id'] = $user_id;

        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * user_idを元にレコードを更新する
     *
     * @param int   $user_id
     * @param int   $business_id
     * @param array $update_columns
     * @return number レコード数
     */
    public function update_by_user_id($user_id, $business_id, $update_columns) {
        return DB::update(self::$_table_name)->set($update_columns)
            ->where('user_id', $user_id)
            ->where('business_id', $business_id)
            ->execute();
    }
}
