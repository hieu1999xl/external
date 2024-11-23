<?php

/**
 * GMOオーダーID管理のモデルクラス
 *
 * @author tanabe
 */

class Model_HumanLife_GmoOrderIdManagement extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * GMOオーダーIDを発番する
     *
     * @return int GMOオーダーID
     */
    public static function publish_id() {

        // テーブルをロック
        $query = <<<SQL
LOCK TABLES gmo_order_id_management WRITE
SQL;
        DB::query($query)->execute();

        // 初期確認
        $query = <<<SQL
SELECT
    order_id
FROM
    gmo_order_id_management
SQL;
        parent::pre_find($query);
        $init_result = DB::query($query)->execute()->as_array();

        // 最初の発番かどうか
        $is_first = empty($init_result);

        if ($is_first) {
            // 登録
            $query = <<<SQL
INSERT INTO
    gmo_order_id_management
(
    order_id,
    create_user,
    update_user
)
VALUES
(
    :order_id,
    :create_user,
    :update_user
)
SQL;

            $param = [
                'order_id'    => 1,
                'create_user' => SYSTEM_USER_NAME,
                'update_user' => SYSTEM_USER_NAME,
            ];

            DB::query($query)->parameters($param)->execute();
        } else {
            // 発番
            $query = <<<SQL
UPDATE
    gmo_order_id_management
SET
    order_id = order_id + 1,
    create_user = :create_user,
    update_user = :update_user
SQL;
            $param = [
                'create_user' => SYSTEM_USER_NAME,
                'update_user' => SYSTEM_USER_NAME,
            ];

            DB::query($query)->parameters($param)->execute();
        }

        // 値取得
        $query = <<<SQL
SELECT
    MAX(order_id) order_id
FROM
    gmo_order_id_management
SQL;
        parent::pre_find($query);
        $result = DB::query($query)->execute()->as_array();

        // テーブルロックを解除
        $query = <<<SQL
UNLOCK TABLES
SQL;
        DB::query($query)->execute();

        return parent::post_find($result)[0]["order_id"];
    }
}