<?php

use Fuel\Core\Fuel;

/**
 * ロジック基底クラス
 *
 * @author sakairi@liz-inc.co.jp
 *
 */
class Logic_Base {

    private $logic_tax;

    /**
     * コンストラクタ
     */
    public function __construct() {
    }

    /**
     * ロジックインスタンスを取得する
     *
     * @return object
     */
    public static function instance() {
        $class_name = get_called_class();
        $instance = new $class_name();
        return $instance;
    }

    /**
     * 消費税額を計算する
     *
     * @param int price 計算を行う金額
     * @return int 消費税額
     */
    protected function culculate_tax($price) {
        return Logic_HumanLife_MstTax::instance()->culculate_tax($price);
    }

    /**
     * 最短利用開始日計算
     *
     * @param string $base_days 計算開始日
     * @param array $holidays 休日配列
     * @return array 最短利用開始日（+n日）
     */
    public function calc_min_days_for_prepaid($base_days=PREPAID_START_DAYS, $holidays) {
        $target_datetime = new DateTime();
        $target_datetime2 = new DateTime();
        $target_datetime = $target_datetime->modify('+' . $base_days . ' day');
        $target_datetime2 = $target_datetime2->modify('+' . $base_days . ' day');
        // 振込期限日を二日前に設定
        $target_datetime2->modify('-1 day');
        // base_date更新
        for ($i = 0; $i < 30; $i++) {
            $target_date = $target_datetime->format('Y-m-d');
            $target_date2 = $target_datetime2->format('Y-m-d');
            if (in_array($target_date, $holidays) || in_array($target_date2, $holidays)) {
                if($target_date == FIFTH_DAY_OF_FIFTH_MONTH){
                    break;
                } else {
                    $base_days++;
                    $target_date = $target_datetime->modify('+1 day')->format('Y-m-d');
                    $target_date2 = $target_datetime2->modify('+1 day')->format('Y-m-d');
                }
            } else {
                return  $base_days;
            }
        }
    }

    /**
     * レンタル期間取得
     * @param string $from_date 開始日 (datetime format)
     * @param string $to_date 終了日 (datetime format)
     * @return int レンタル日数
     */
    public function calc_rental_days($from_date, $to_date) {
        $start_date = new DateTimeImmutable($from_date);
        $end_date = new DateTimeImmutable($to_date);
        $diff = $start_date->diff($end_date);
        $rental_days = (int)$diff->format('%a')+1; // 開始日も含めるため+1
        return $rental_days;
    }

    /**
     * 最短レンタル開始日数計算
     *
     * @param int $base_days 基本日数（現在日からの日数）
     * @param array $holidays 休日配列
     * @return int 最短レンタル開始日数（$base_days + 連続した休日日数）
     */
    public function calc_min_days($base_days, $holidays) {
        $target_days = $base_days -1; // 当日出荷するケースも存在するので基準の1日前から計算する
        $target_datetime = new DateTimeImmutable("+$target_days days");
        $count_holidays = count($holidays);

        // 現在日 + $base_days の日付から連続した休日の日数分だけ加算する（土日や連休明けの日を取得する）
        for ($i=0; $i<=$count_holidays; $i++) {
            $target_date = $target_datetime->modify("+$i day")->format('Y-m-d');
            if (!in_array($target_date, $holidays)) {
                $base_days += $i;
                break;
            }
        }

        return  $base_days;
    }
}
