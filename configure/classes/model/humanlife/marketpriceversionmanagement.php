<?php

/**
 * 市価バージョン管理マスタテーブルのモデルクラス
 *
 * @author kor.miyamoto@humanlife.co.jp
 */
class Model_HumanLife_MarketPriceVersionManagement extends Model_CrudAbstract
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
     * @var string 市価バージョン管理マスタテーブル名
     */
    protected static $_table_name = 'market_price_version_management';

    /**
     * パラメータとして使用されている値を条件にレコードを取得する
     *
     * @param integer $business_id
     * @param integer $market_id
     * @param integer $version
     * @param string  $version_id 
     * @return array 取得結果
     */
    public function get_market_price_version_info($business_id, $market_id, $version, $version_id)
    {
        $query = <<<SQL
        SELECT
            *
        FROM
            market_price_version_management
        WHERE
            business_id = :business_id
        AND market_id = :market_id
        AND version = :version

        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['market_id'] = $market_id;
        $bind_params['version'] = $version;

        if (empty($version_id)) {   // version=1 はversion_id nullのため
            $query .= ' AND version_id IS NULL ';
        } else {
            $query .= ' AND version_id = :version_id';
            $bind_params['version_id'] = $version_id;
        }
        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->current();
    }

    /**
     * 現在適用されているバージョンの情報を取得する
     *
     * @param integer $business_id
     * @param integer $market_id
     * @return array 取得結果
     */
    public function get_market_price_current_version_info($business_id, $market_id)
    {
        $query = <<<SQL
        SELECT
            *
        FROM
            market_price_version_management
        WHERE
            business_id = :business_id
        AND market_id = :market_id
        AND sale_start_date <= NOW()
        AND (
            sale_end_date > NOW()
            OR sale_end_date IS NULL
        )
        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['market_id'] = $market_id;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->current();
    }

    /**
     * 指定されたバージョンの情報を取得する
     *
     * @param integer $business_id
     * @param integer $market_id
     * @param integer $version
     * @return array 取得結果
     */
    public function get_market_price_current_version_info_by_version($business_id, $market_id, $version) {
        $query = <<<SQL
        SELECT
            *
        FROM
            market_price_version_management
        WHERE
            business_id = :business_id
        AND market_id = :market_id
        AND version = :version
        SQL;

        $bind_params = [];
        $bind_params['business_id'] = $business_id;
        $bind_params['market_id'] = $market_id;
        $bind_params['version'] = $version;

        return DB::query($query)->parameters($bind_params)
            ->execute()
            ->current();
    }
}
