<?php

/**
 * 端末管理履歴(imei_manage_history)テーブルのモデルクラス
 *
 * @author akio-endo
 *
 */
class Model_HumanLife_Imeimanagehistory extends Model_CrudAbstract
{

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string テーブル名
     */
    protected static $_table_name = 'imei_manage_history';

     /**
     * レコードをINSERTする
     *
     * @param array $params
     *            ['カラム名' => '値']形式の連想配列
     * @return array ['キー', 'レコード数']
     */
    public function insert_by_imei_list($params) {

        $query = <<<SQL
INSERT 
INTO imei_manage_history( 
    business_id
    , imei
    , user_id
    , entry_id
    , contract_id
    , user_attribute
    , location
    , terminal_action
    , status
    , action_user
    , action_datetime
    , note
    , create_user
    , create_datetime
    , update_user
    , update_datetime
) VALUES (
    :business_id
    , :imei
    , :user_id
    , :entry_id
    , :contract_id
    , :user_attribute
    , :location
    , :terminal_action
    , :status
    , :update_user
    , :update_datetime
    , :note
    , :update_user
    , :update_datetime
    , :update_user
    , :update_datetime
)
SQL;

        $bind_params = $params;
        return DB::query($query)->parameters($bind_params)->execute();
    }

    /**
     * 端末管理履歴に必要な申込情報および流入元情報を取得する
     */
    public function get_entry_inflow($business_id, $contract_id) {

        $query = <<<SQL
SELECT
    c.contract_id
    , e.entry_id 
    , e.inflow_source
    , i.user_attribute
FROM
    contract c 
    INNER JOIN entry e 
        ON c.entry_id = e.entry_id 
        AND c.user_id = e.user_id 
    LEFT JOIN mst_inflow_source i 
        ON e.inflow_source = i.inflow_source_name 
        AND i.delete_flg = 0 
WHERE
    c.business_id = :business_id
    AND c.contract_id = :contract_id
ORDER BY
    e.create_datetime
LIMIT 1
SQL;

        $bind_params = [
            'business_id' => $business_id,
            'contract_id' => $contract_id,
        ];
        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

    /**
     * 対象の端末の直近の紐付け日の紐付けのレコードに、解約日を登録する
     * 
     * @param int $imei
     */
    public function update_unbind_imei($where_params) {

        $query = <<<SQL
UPDATE imei_manage_history h 
SET
    h.unbind_datetime = :update_datetime 
WHERE
    h.business_id = :business_id
    AND h.imei_manage_id = ( 
        SELECT
            tmp.imei_manage_id 
        FROM
            ( 
                SELECT
                    imei_manage_id 
                FROM
                    imei_manage_history 
                WHERE
                    business_id = :business_id
                    AND imei = :imei 
                    AND (
                        ( 
                            -- 佐川：出荷：配送中
                            location = :terminal_location_sgw
                            AND terminal_action = :terminal_action_shipment
                            AND status = :terminal_status_shipping
                        ) 
                        OR ( 
                            -- 代替機
                            location = :terminal_location_hi
                            AND terminal_action = :terminal_action_switch
                            AND (status = :terminal_status_stock OR status = :terminal_status_shipping)
                        ) 
                    )
                ORDER BY
                    imei_manage_id DESC 
                LIMIT
                    :limit
            ) tmp
    )
SQL;

        $bind_params = [];
        foreach ($where_params as $key => $value) {
            $bind_params[$key] = $value;
        }

        return DB::query($query)->parameters($bind_params)->execute();

    }

    /**
     * 端末管理の履歴の取得
     *
     * @param array $where_params
     * @return array 取得結果
     */
    public function get_imei_history_by_imei($where_params)
    {
        $bind_params = [];

        $query = <<<SQL
SELECT
    ih.action_datetime
    , ih.location
    , ih.terminal_action
    , ih.status
    , ih.action_user
    , ih.note 
    , ih.breakdown_reason_id 
FROM
    imei_manage_history ih 
WHERE
    ih.imei = :imei 
ORDER BY
    ih.action_datetime DESC
SQL;

        $bind_params['imei']  = $where_params['imei'];

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }

}
