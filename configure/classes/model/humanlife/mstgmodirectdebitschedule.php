<?php

/**
 * GMO口座振替スケジュールマスタのモデルクラス
 *
 * @author sakairi@liz-inc.co.jp
 */

class Model_HumanLife_MstGmoDirectDebitSchedule extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string スキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string GMO口座振替スケジュールマスタテーブル名
     */
    protected static $_table_name = 'mst_gmo_direct_debit_schedule';

    /**
     * 実行日に有効な振替指定日を取得する
     *
     * @param string $target_date 振替指定日を取得したい時期を指定
     * @return array 振替指定日
     */
    public function get_transfer_designated_date_by_datetime($target_date) {
        $query = <<<SQL
SELECT
    transfer_designated_date
FROM
    mst_gmo_direct_debit_schedule
WHERE
    transfer_request_acceptance_start_date <= :target_date
AND
    transfer_request_acceptance_end_date >= :target_date
SQL;

        $param = [
            'target_date' => $target_date,
        ];

        $result = DB::query($query)->parameters($param)->execute()->as_array();
        return $result;
    }

}