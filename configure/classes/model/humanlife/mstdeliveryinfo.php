<?php

/**
 * 配送レベル情報マスタのモデルクラス
 *
 * @author ako.endo
 */
class Model_HumanLife_MstDeliveryInfo extends Model_CrudAbstract
{
    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * テーブル名
     */
    protected static $_table_name = 'mst_delivery_info';

    /**
     * お知らせIDを条件に必要なお知らせ情報を取得
     *
     * @param int $zipcode1
     * @param int $zipcode2
     * @return array 検索結果
     */
    public function select($zipcode1, $zipcode2, $select = ['*']) {
        return DB::select_array($select)
            ->from(self::$_table_name)
            ->where('zipcode1', $zipcode1)
            ->and_where('zipcode2', $zipcode2)
            ->execute()
            ->current();
    }
}
