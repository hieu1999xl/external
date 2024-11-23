<?php

/**
 * 申し込み－端末テーブルのモデルクラス
 */
class Model_HumanLife_EntryDevice extends Model_CrudAbstract {

    /**
     * 申込IDを条件に申し込み－端末情報を取得する
     *
     * @param int $business_id
     * @param int $entry_id
     * @return array
     */
    public function get_entry_device_info_list_by_entry_id($business_id, $entry_id) {
        $sql = <<<SQL
SELECT
    ed.entry_device_id
  , md.device_id
  , md.name
  , md.image_path
  , md.color
FROM
    entry_device AS ed
        INNER JOIN
            mst_device AS md
        ON
            md.device_id = ed.device_id
        AND md.business_id = ed.business_id
WHERE
    ed.entry_id = :entry_id
AND ed.business_id = :business_id
ORDER BY
    ed.entry_device_id ASC
SQL;

        $params = [
            'entry_id'    => $entry_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 申込IDを条件に端末初期費用マスタを取得する
     *
     * @param int $business_id
     * @param int $entry_id
     * @return array
     */
    public function get_mst_device_init_info_list_by_entry_id($business_id, $entry_id) {
        $sql = <<<SQL
SELECT
    mdi.*, md.ucl_account_type, ed.imei, ed.is_new
FROM
    entry_device AS ed
INNER JOIN
    mst_device AS md
ON
    md.device_id = ed.device_id
AND md.business_id = ed.business_id
INNER JOIN
    mst_device_init AS mdi
ON
    mdi.device_id = ed.device_id
AND mdi.business_id = ed.business_id
WHERE
    ed.entry_id = :entry_id
AND ed.business_id = :business_id
ORDER BY
    ed.entry_device_id ASC
SQL;

        $params = [
            'entry_id'    => $entry_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    /**
     * 登録する
     *
     * @param array $insert_params
     * @return number
     */
    public function insert($insert_params) {

        $query = <<<SQL
        INSERT INTO
            entry_device
        SQL;

        $bind_params = [];
        $set = '(';
        $val = ') VALUES (';
        $is_first = true;
        foreach ($insert_params as $column => $value) {
            if (!$is_first) {
                $set .= ', ';
                $val .= ', ';
            }

            $set .= $column;
            $val .= ':' . $column;
            $bind_params[$column] = $value;
            $is_first = false;
        }
        $val .= ')';

        $query = $query . $set . $val;
        return DB::query($query)->parameters($bind_params)->execute()[0];
    }

    /**
     * 削除する
     *
     * @param array $insert_params
     * @return number
     */
    public function delete_entry_device($entry_id, $business_id) {
        $sql = <<<SQL
DELETE FROM
    entry_device
WHERE
    entry_id = :entry_id
AND
    business_id = :business_id
SQL;

        $params = [
            'entry_id'     => $entry_id,
            'business_id' => $business_id,
        ];

        parent::pre_find($query);
        DB::query($sql)->parameters($params)->execute();
    }

    /**
     * entry_idを元にレコードを更新する
     *
     * @param int   $entry_id
     * @param array $update_columns
     * @return number レコード数
     */
    public function update_by_entry_id($entry_id, $update_columns) {
        return DB::update('entry_device')
            ->set($update_columns)
            ->where('entry_id', $entry_id)
            ->where('business_id', BUSINESS_ID)
            ->execute();
    }
}
