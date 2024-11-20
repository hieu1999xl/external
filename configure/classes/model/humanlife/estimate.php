<?php
/**
 * 見積テーブルのモデルクラス
 */
class Model_HumanLife_Estimate extends Model_CrudAbstract {

    /**
     * テーブル名
     *
     * @var string 見積テーブル名
     */
    protected static $_table_name = 'estimate';

   /**
    * 登録する
     * @param array $pairs
     *            ['カラム名' => '値']形式の連想配列
     * @return number
    */
    public function insert_estimate_info($pairs)
    {
        return DB::insert(self::$_table_name)->set($pairs)->execute()[0];
    }

    /**
     * get
     * @param $business_id
     *
     */

    public function get_estimate_id_by_business_id($business_id) {
        $sql = <<<SQL
SELECT
    estimate.estimate_id
FROM
    estimate
WHERE
    business_id = :business_id
    ORDER BY estimate_id DESC LIMIT 1;

SQL;
                $param = [
                    'business_id'  => $business_id,
                ];

                parent::pre_find($query);
                $result = DB::query($sql)->parameters($param)->execute()->as_array();
                return parent::post_find($result);
            }
}
