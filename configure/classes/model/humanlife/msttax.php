<?php

/**
 * 消費税マスタテーブルのモデルクラス
 */
class Model_HumanLife_MstTax extends Model_CrudAbstract {
    /**
     * 消費税を取得する
     *
     * @return array
     */
    public function get_tax() {
        $sql = <<<SQL
SELECT
    tax_rate
FROM
    mst_tax
WHERE
    tax_start_date < NOW()
SQL;

        parent::pre_find($query);
        $result = DB::query($sql)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 適用開始日を条件に適用される消費税情報を取得する
     *
     * @param string $tax_start_date
     * @return array
     */
    public function get_tax_info_by_tax_start_date($tax_start_date) {
        $sql = <<<SQL
SELECT
    *
FROM
    mst_tax AS mt
WHERE
    mt.tax_start_date <= :tax_start_date
ORDER BY
    mt.tax_start_date DESC
LIMIT
    1
SQL;

        $params = [
            'tax_start_date' => $tax_start_date,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 現在有効な消費税マスタ情報を取得する
     *
     * @return array 消費税マスタの連想配列。対象なしのときは空配列を返却する。
     */
    public static function get_current_mst_tax() {

        // 消費税マスタを取得
        $query = <<<SQL
SELECT
    *
FROM
    mst_tax
WHERE
    tax_start_date = (
        SELECT
            MAX(tax_start_date)
        FROM
            mst_tax
        WHERE
            tax_start_date <= CURRENT_DATE()
    )
SQL;

        $param = [
        ];

        parent::pre_find($query);
        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 指定された日付に有効な消費税率を取得する
     *
     * @param DateTime $target_date 消費税を計算したい時期を指定
     * @return array 消費税率
     */
    public function get_tax_rate_by_datetime(DateTime $target_date) {
        $query = <<<SQL
SELECT
    tax_rate
FROM
    mst_tax
WHERE
    tax_start_date <= :target_date
ORDER BY
    tax_start_date DESC
LIMIT
    1
SQL;

        $param = [
            'target_date' => $target_date->format(DATE_FORMAT_YMD)
        ];

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }
}
