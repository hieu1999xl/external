<?php

/**
 * GMOオーダーID・請求実績リレーション(rel_gmo_order_id_management_invoice_result)テーブルのモデルクラス
 *
 * @author s.ito@humanlife.co.jp
 */
class Model_HumanLife_RelGmoOrderIdManagementInvoiceResult extends Model_CrudAbstract
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
    protected static $_table_name = 'rel_gmo_order_id_management_invoice_result';

    /**
     * 請求明細番号を元に、最新の請求実績とのリレーションレコードを取得する
     *
     * @param integer $business_id
     * @param integer $invoice_id
     * @return array 取得結果
     */
    public function get_latest_by_invoice_id($business_id, $invoice_id)
    {
        $query = <<<SQL
        SELECT
          *
        FROM
          rel_gmo_order_id_management_invoice_result
        WHERE
          business_id = :business_id
          AND invoice_id = :invoice_id
        ORDER BY
          order_id DESC
        LIMIT
          1
        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['invoice_id'] = $invoice_id;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->as_array();
    }
}