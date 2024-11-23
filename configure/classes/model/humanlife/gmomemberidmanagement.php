<?php

/**
 * GMO会員ID管理のモデルクラス
 *
 * @author tanabe
 */

class Model_HumanLife_GmoMemberIdManagement extends Model_CrudAbstract {

    /**
     * データソース名
     *
     * @var string ZEUSスキーマ名
     */
    protected static $_connection = 'human_life';

    /**
     * GMO会員IDを発番する
     *
     * @return int GMO会員ID
     */
    public static function publish_id() {

        // テーブルをロック
        $query = <<<SQL
LOCK TABLES gmo_member_id_management WRITE
SQL;
        DB::query($query)->execute();

        // 初期確認
        $query = <<<SQL
SELECT
    gmo_member_id gmo_member_id
FROM
    gmo_member_id_management
SQL;
        parent::pre_find($query);
        $init_result = DB::query($query)->execute()->as_array();

        // 最初の発番かどうか
        $is_first = empty($init_result);

        if ($is_first) {
            // 登録
            $query = <<<SQL
INSERT INTO
    gmo_member_id_management
(
    gmo_member_id,
    create_user,
    update_user
)
VALUES
(
    :gmo_member_id,
    :create_user,
    :update_user
)
SQL;

            $param = [
                'gmo_member_id' => 1,
                'create_user'   => SYSTEM_USER_NAME,
                'update_user'   => SYSTEM_USER_NAME,
            ];

            DB::query($query)->parameters($param)->execute();
        } else {
            // 発番
            $query = <<<SQL
UPDATE
    gmo_member_id_management
SET
    gmo_member_id = gmo_member_id + 1,
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
    MAX(gmo_member_id) gmo_member_id
FROM
    gmo_member_id_management
SQL;
        parent::pre_find($query);
        $result = DB::query($query)->execute()->as_array();

        // テーブルロックを解除
        $query = <<<SQL
UNLOCK TABLES
SQL;
        DB::query($query)->execute();

        return parent::post_find($result)[0]["gmo_member_id"];
    }
}