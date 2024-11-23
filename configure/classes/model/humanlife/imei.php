<?php

/**
 * IMEIテーブルのモデルクラス
 *
 * @author kaneta@liz-inc.co.jp
 */
class Model_HumanLife_Imei extends Model_CrudAbstract
{

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string IMEI
     */
    protected static $_table_name = 'imei';

    /**
     * contract_idに紐づくIMEI情報を取得する
     *
     * @param int $business_id
     * @param int $contract_id
     *
     * @return array 取得結果
     */
    public function get_imeis_by_contract($business_id, $contract_id) {

    $query = <<<SQL
SELECT
    imei
FROM
    imei
WHERE
    business_id = :business_id
    AND contract_id = :contract_id
    AND imei IS NOT NULL
    AND imei <> ''
    AND delete_flag = :delete_flag
SQL;

        $bind_params['business_id'] = $business_id;
        $bind_params['contract_id'] = $contract_id;
        $bind_params['delete_flag'] = FLG_OFF;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    /**
     * sagawa 問い合わせ番号情報を取得する
     *
     * @param int $business_id
     * @param int $tracking_from_date YYYYMMDD
     *
     * @return array 取得結果
     */

    public function get_inquiry_number_without_delivery_datetime($business_id, $tracking_from_date) {
        $query = <<<SQL
SELECT
    contract_id, rel_contract_device_id, inquiry_no
FROM
    imei
WHERE
    business_id = :business_id
    AND delivery_datetime IS NULL
    AND imei IS NOT NULL
    AND imei <> ''
    AND delete_flag = :delete_flag
    AND shipment_date >= :tracking_from_date
SQL;

        $bind_params['business_id'] = $business_id;
        $bind_params['delete_flag'] = FLG_OFF;
        $bind_params['tracking_from_date'] = $tracking_from_date;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    /**
     * 複数の契約IDそれぞれに紐づく全てのレコード(imeiカラムに値あり)を取得(法人向け)
     *
     * @param $business_id
     * @param $contract_ids
     * @return array
     */
    public function get_imeis_by_contract_ids($business_id, $contract_ids) {
        $query = <<<SQL
        SELECT
            *
        FROM
            imei
        WHERE
                business_id   = :business_id
            AND contract_id   IN :contract_ids
            AND imei IS NOT NULL
            AND imei <> ''
            AND delete_flag   = 0

        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['contract_ids'] = $contract_ids;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    public function update_imei_delivery_datetime($business_id, $inquiry_no, $delivery_datetime) {
        $query = <<<SQL
UPDATE
    imei
SET
  delivery_datetime = :delivery_datetime
WHERE
    business_id = :business_id
AND inquiry_no = :inquiry_no
ORDER BY shipment_date DESC
LIMIT 1
SQL;
        $params = [
            'business_id' => $business_id,
            'inquiry_no'     => $inquiry_no,
            'delivery_datetime' => $delivery_datetime,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    public function update_return_due_date_by_contract_id($contract_id, $business_id, $return_due_date) {
        $query = <<<SQL
UPDATE
    imei
SET
  return_due_date = :return_due_date ,
  initial_contract_cancel_apply_datetime = :initial_contract_cancel_apply_datetime ,
  initial_contract_cancel_apply_from = :initial_contract_cancel_apply_from
WHERE
    business_id = :business_id
AND contract_id = :contract_id
SQL;
        $params = [
            'business_id' => $business_id,
            'contract_id'     => $contract_id,
            'return_due_date' => $return_due_date,
            'initial_contract_cancel_apply_datetime' => Helper_Time::getCurrentDateTime(),
            'initial_contract_cancel_apply_from' => INITIAL_CANCEL_FROM_CUSTOMER,
        ];

        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }

    public function get_imei_delivery_datetime_by_contract_id($business_id, $contract_id) {
        $query = <<<SQL
SELECT
    contract_id, rel_contract_device_id, delivery_datetime, return_due_date, imei
FROM
    imei
WHERE
    business_id = :business_id
    AND delete_flag = :delete_flag
    AND contract_id = :contract_id
ORDER BY contract_id, rel_contract_device_id, business_id;
SQL;

        $bind_params['business_id'] = $business_id;
        $bind_params['delete_flag'] = FLG_OFF;
        $bind_params['contract_id'] = $contract_id;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
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
        return DB::insert(self::$_table_name)->set($pairs)->execute();
    }

    /**
     * レコードをINSERTする(オプション端末IMEI紐づけ前)
     *
     * @param int    $contract_id
     * @param int    $business_id
     * @param int    $rel_contract_device_id
     * @return array
     */
    public function insert_option_device_imei($contract_id, $business_id, $rel_contract_device_id)
    {
        $sql = <<<SQL
INSERT INTO
    imei (
        contract_id,
        business_id,
        rel_contract_device_id,
        create_user,
        update_user
    )
VALUE (
    :contract_id,
    :business_id,
    :rel_contract_device_id,
    :create_user,
    :update_user
)
SQL;

        $param = [
            'contract_id'               => $contract_id,
            'business_id'               => $business_id,
            'rel_contract_device_id'    => $rel_contract_device_id,
            'create_user'               => SYSTEM_USER_NAME,
            'update_user'               => SYSTEM_USER_NAME,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($param)->execute();
        return parent::post_find($result);
    }

    /**
     * imei経由でcontract_idに紐づくshipping_device情報を返す
     * @param int $contract_id
     * @param array $select 取得カラム
     * @return array
     */
    public function get_shipping_device_info_by_contract_id($contract_id, $select=['*'])
    {
        $query = DB::select_array($select)->from(self::$_table_name . ' i')
            ->join('mst_shipping_device msd', 'LEFT')
                ->on('msd.imei2', '=', 'i.imei')
                ->on('msd.business_id', '=', BUSINESS_ID)
            ->where('i.business_id', '=', BUSINESS_ID)
            ->where('i.contract_id', '=', $contract_id)
        ;
        return $query->execute()->current();
    }

    /**
     * 汎用的に使用するSELECT（IN句非対応）
     * 
     * @param array $select SELECT対象のカラム
     * @param array $wheres WHERE用の条件
     */
    public function get_records($select, $wheres) {
        $query = DB::select_array($select)->from(self::$_table_name);
        foreach($wheres as $key => $value){
            $query->where($key, $value);
        }
        return $query->execute()->as_array();
    }
}
