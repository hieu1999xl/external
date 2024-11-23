<?php

/**
 * 契約－端末テーブルのモデルクラス
 */
class Model_HumanLife_RelContractDevice extends Model_CrudAbstract {

    /**
     * テーブル名
     *
     * @var string 契約－端末テーブル名
     */
    protected static $_table_name = 'rel_contract_device';

    /**
     * 契約IDを条件に契約－端末情報を取得する
     *
     * @param int $business_id
     * @param int $contract_id
     * @return array
     */
    public function get_contract_device_info_list_by_contract_id($business_id, $contract_id) {
        $sql = <<<SQL
SELECT
    rcd.rel_contract_device_id
  , md.device_id
  , md.name
  , md.image_path
  , md.color
  , md.item_code
  , i.imei
FROM
    rel_contract_device AS rcd
        INNER JOIN
            mst_device AS md
        ON
            md.device_id = rcd.device_id
        AND md.business_id = rcd.business_id
        LEFT OUTER JOIN
            imei AS i
        ON
            i.contract_id = rcd.contract_id
        AND i.rel_contract_device_id = rcd.rel_contract_device_id
        AND i.business_id = rcd.business_id
WHERE
    rcd.contract_id = :contract_id
AND rcd.business_id = :business_id
AND rcd.delete_flag = :delete_flag
ORDER BY
    rcd.rel_contract_device_id ASC
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
     * 端末を解約する
     *
     * @param int $user_id
     * @param int $business_id
     * @param int $contract_device_id
     * @param datetime $end_date
     * @return number レコード数
     */
    public function cancel_contract_device($user_id, $contract_device_id, $business_id, $end_date)
    {
        $query = <<<SQL
        UPDATE rel_contract_device
        SET
        device_plan_end_date = :device_plan_end_date
        , device_cancel_application_datetime = :device_cancel_application_datetime
        , update_user     = :update_user
        , update_datetime = :update_datetime
        WHERE
          business_id = :business_id
          AND rel_contract_device_id = :rel_contract_device_id

        SQL;

        $bind_params = [];
        $bind_params['device_plan_end_date'] = $end_date;
        $bind_params['device_cancel_application_datetime'] = date("Y-m-d H:i:s");
        $bind_params['update_user'] = $user_id;
        $bind_params['update_datetime'] = date("Y-m-d H:i:s");
        $bind_params['business_id'] = $business_id;
        $bind_params['rel_contract_device_id'] = $contract_device_id;

        return DB::query($query)->parameters($bind_params)->execute();
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
     * @param int    $contract_id
     * @param int    $business_id
     * @param int    $device_id
     * @return array
     */
    public function insert_contract_device($contract_id, $business_id, $device_id)
    {
        $sql = <<<SQL
INSERT INTO
    rel_contract_device (
        contract_id,
        business_id,
        device_id,
        create_user,
        update_user
    )
VALUE (
    :contract_id,
    :business_id,
    :device_id,
    :create_user,
    :update_user
)
SQL;

        $param = [
            'contract_id'       => $contract_id,
            'business_id'       => $business_id,
            'device_id'         => $device_id,
            'create_user'       => SYSTEM_USER_NAME,
            'update_user'       => SYSTEM_USER_NAME,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($param)->execute();
        return parent::post_find($result);
    }

}
