<?php

/**
 * オプションマスタテーブルのモデルクラス
 */
class Model_HumanLife_MstOption extends Model_CrudAbstract {
    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string  オプションマスタ
     */
    protected static $_table_name = 'mst_option';
    
    /**
     * プライマリキー
     * @var String
     */
    protected static $_primary_key = 'option_id';
    
    /**
     * プライマリキーを条件に1レコード取得する
     * @param  int   $id
     * @param  array $select 取得カラム名の文字列配列
     * @return array|null
     */
    public function get_record_by_id($id, $select ){
        $query = DB::select_array($select)->from(self::$_table_name)
                                          ->where(self::$_primary_key, $id);
        return $query->execute()->current();
    }
    
    /**
     * オプション一覧を取得する
     *
     * @param int $business_id
     * @return array
     */
    public function get_option_list($business_id) {
        $sql = <<<SQL
SELECT
    option_id,
    name,
    price,
    tax_type,
    billing_type,
    disp_order
FROM
    mst_option
WHERE
    business_id = :business_id
AND
    sale_start_datetime <= NOW()
AND
    (sale_end_datetime > NOW() OR sale_end_datetime IS NULL )
ORDER BY
    disp_order
SQL;

        $param = [
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * オプション一覧を取得する
     *
     * @param int $option_id
     * @param int $business_id
     * @return array
     */
    public function get_option_info($option_id, $business_id) {
        $sql = <<<SQL
SELECT
    option_id,
    name,
    option_type,
    price,
    tax_type,
    billing_type,
    disp_order
FROM
    mst_option
WHERE
    option_id = :option_id
AND
    business_id = :business_id
AND
    sale_start_datetime <= NOW()
AND
    (sale_end_datetime > NOW() OR sale_end_datetime IS NULL)
ORDER BY
    disp_order
SQL;

        $param = [
            'option_id'   => $option_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * オプション一覧を取得する
     *
     * @param array $option_id_list
     * @param int   $business_id
     * @return array
     */
    public function get_option_list_by_option_id_list($option_id_list, $business_id) {
        $sql = <<<SQL
SELECT
    option_id,
    name,
    price,
    tax_type,
    billing_type,
    disp_order
FROM
    mst_option
WHERE
    option_id IN :option_id_list
AND
    business_id = :business_id
AND
    sale_start_datetime <= NOW()
AND
    sale_end_datetime > NOW()
ORDER BY
    disp_order
SQL;

        $param = [
            'option_id_list' => $option_id_list,
            'business_id'    => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * オプションマスタ情報の一覧を取得する
     *
     * @param integer $business_id 事業者ID
     * @param array $entry_option_list 許可するオプション
     * @return array オプションマスタの連想配列。対象なしのときは空配列を返却する。
     */
    public static function get_mst_option_list($business_id, $entry_option_list) {

        $entry_option_str = implode(',', $entry_option_list);
        // オプションマスタを取得
        $query = <<<SQL
SELECT
    *
FROM
    mst_option
WHERE
    business_id = :business_id
    AND option_id IN ($entry_option_str)
    AND sale_start_datetime <= NOW()
    AND (sale_end_datetime > NOW() OR sale_end_datetime IS NULL)
ORDER BY
    disp_order
SQL;

        $param = [
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array();

        if (count($result) > 0) {

            // 配列のキーを「option_id」に入れ替える
            $resultTemp = [];
            $option_id_list = [];
            foreach ($result as $mstOption) {
                $resultTemp[$mstOption["option_id"]] = $mstOption;
                $option_id_list[] = $mstOption["option_id"];
            }
            $result = $resultTemp;
        }

        return parent::post_find($result);
    }
}
