<?php
/**
 * 休日マスタのロジッククラス
 *
 * @author ako.endo
 */
class Model_HumanLife_MstHoliday extends Model_CrudAbstract
{
    /**
     * データソース名
     *
     * @var string
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     *
     * @var string
     */
    protected static $_table_name = 'mst_holiday';

    /**
     * プライマリキー
     * 
     * @var string
     */
    protected static $_primary_key = 'mst_holiday_id';

    /**
     * 休日配列取得（n日後までに含まれる休日の配列を取得する）
     *
     * @param  string $rental_start_day 最短レンタル開始日数
     * @return array 休日のリスト
     */
    public function get_holidays($rental_start_day) {
        $query = <<<SQL
SELECT
    holiday 
FROM
    mst_holiday 
WHERE
    business_id = :business_id 
    AND holiday BETWEEN CURDATE() AND :to_date
SQL;

        $to_date_ymd = new DateTime('+' . $rental_start_day . ' days');
        $bind_params['business_id'] = BUSINESS_ID;
        $bind_params['to_date'] = $to_date_ymd->format(DATE_FORMAT_YMD);
        return DB::query($query)->parameters($bind_params)->execute()->as_array();
    }

    /**
     * 休日数取得（n日後までに含まれる休日数を取得する）
     * @param  string $to_date 最短レンタル開始日
     */

    public function  get_holiday_count($to_date) {

        $query = <<<SQL
        SELECT
            count(*) as count
        FROM
            mst_holiday
        WHERE
            business_id = :business_id
        AND Holiday BETWEEN CURDATE()
        AND :to_date

SQL;

        $to_date_ymd = new DateTime('+' . $to_date . ' days');
        $bind_params = [];
        $bind_params['business_id'] = BUSINESS_ID;
        $bind_params['to_date'] = $to_date_ymd->format(DATE_FORMAT_YMD);

        $result = DB::query($query)->parameters($bind_params)
        ->execute()
        ->current();
        return $result['count'];

    }

    /**
     * 休日配列取得（n日後までに含まれる休日の配列を取得する）
     * @param  string $to_days 最短レンタル開始日数
     */

    public function  get_prepaid_holidays($to_days) {

        $query = <<<SQL
        SELECT
            holiday
        FROM
            mst_holiday
        WHERE
            business_id = :business_id
        AND Holiday BETWEEN CURDATE()
        AND :to_date

SQL;

        $to_date_ymd = new DateTime('+' . $to_days . ' days');
        $bind_params = [];
        $bind_params['business_id'] = BUSINESS_ID;
        $bind_params['to_date'] = $to_date_ymd->format(DATE_FORMAT_YMD);

        $result = DB::query($query)->parameters($bind_params)
        ->execute()->as_array();
        return $result;
    }

}
