<?php

/**
 * 事業者マスタテーブルのモデルクラス
 *
 * @author m.ishikawa@humaninvestment.jp
 */
class Model_HumanLife_MstBusinessCustomer extends Model_CrudAbstract
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
     * @var string 事業者マスタ
     */
    protected static $_table_name = 'mst_business_customer';

    /**
     * 事業者コードを元に、事業者情報を取得する
     *
     * @param integer $business_id 事業者ID
     * @param boolean $is_get_deleted 削除済みも取得する場合はtrueを指定。
     * @return array 取得結果
     */
    public function get_customer_info_by_business_id($business_id, $is_get_deleted)
    {
        $query = <<<SQL
SELECT
    business_id,
    business_code,
    name,
    zipcode1,
    zipcode2,
    address,
    representative,
    tel1_1,
    tel1_2,
    tel1_3,
    fax1_1,
    fax1_2,
    fax1_3,
    sagawa_customer_id,
    service_name,
    reception_time,
    credit_billing_date,
    delete_flag
FROM
    mst_business_customer
WHERE
    business_id = :business_id
SQL;

        $param = [
            'business_id' => $business_id
        ];

        //  削除フラグをチェックする場合は検索条件を追加する
        if ($is_get_deleted === false) {
            $query += <<< SQL
AND
    delete_flag = :delete_flag
SQL;
            $param['delete_flag'] = FLG_OFF;
        }

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

    /**
     * 事業者IDから事業者情報を取得する
     *
     * @param int $business_id 事業者ID
     * @param int $delete_flag 削除フラグ
     * @return array 取得結果
     */
    public function get_by_business_id($business_id, $delete_flag = FLG_OFF) {
        $query = <<<SQL
        SELECT
            *
        FROM
            mst_business_customer
        WHERE
            business_id = :business_id

        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['delete_flag'] = $delete_flag;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }
}
