<?php

/**
 * 企業の料金未納履歴テーブルのモデルクラス
 */
class Model_HumanLife_CompanyUnpaidHistory extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string  テーブル物理名
     */
    protected static $_table_name = 'company_unpaid_history';

    /**
     * プライマリキー
     */ 
    protected static $_primary_key = 'company_unpaid_history_id';

    /**
     * 対象の企業の料金未納の件数を抽出する
     * 
     * @param  array $params<string, int> 検索条件（business_id、user_id、company_id）
     * @return array 抽出結果
     */
    public function get_company_unpaid_count($params) {

        $query = <<<SQL
SELECT 
    count(company_unpaid_history_id) as count
FROM
    company_unpaid_history 
WHERE
    business_id = :business_id
    AND user_id = :user_id
    AND company_id = :company_id
    AND active_flag = :active_flag
SQL;

        foreach ($params as $key => $value) {
            $param[$key] = $value;
        }
        $param = array_merge($param, ['active_flag' => FLG_ON]);

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }
}
