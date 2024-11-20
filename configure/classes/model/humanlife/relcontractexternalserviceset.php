<?php

/**
 * 契約ーセット販売テーブルのモデルクラス
 *
 * @author
 */
class Model_HumanLife_RelContractExternalServiceSet extends Model_CrudAbstract {

    /**
     * 契約-セット販売をkintoneアプリID・レコードIDから取得する
     *
     * @param int $app_id       アプリID
     * @param int $record_id    レコードID
     * @param int $business_id  事業者ID
     * @return array
     */
    public function get_rel_contract_external_service_set_by_kintone_id($app_id, $record_id, $business_id) {
        // select
        $sql = <<<SQL
SELECT *
FROM human_life.rel_contract_external_service_set
WHERE
    app_id = :app_id
AND record_id = :record_id
AND business_id = :business_id
SQL;

        $params = [
            'app_id' => $app_id,
            'record_id' => $record_id,
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
            rel_contract_external_service_set
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
     * 契約-セット販売IDから更新する
     *
     * @param int $rel_contract_external_service_set_id 契約-セット販売ID
     * @param array $update_params 更新パラメータ
     * @return void
     */
    public function update_by_rel_contract_external_service_set_id($rel_contract_external_service_set_id, $update_params)
    {
        $set_phrase = $this->get_set_phrase($update_params);
        $query = <<<SQL
UPDATE
    rel_contract_external_service_set
SET
    $set_phrase
WHERE
    rel_contract_external_service_set_id = :rel_contract_external_service_set_id
SQL;

        $params = [
            'rel_contract_external_service_set_id' => $rel_contract_external_service_set_id,
        ];
        $param = array_merge($params, $update_params);

        parent::pre_update($query);
        $result = DB::query($query)->parameters($param)->execute();
        return parent::post_update($result);
    }

    /**
     * 更新SQLのSET句を取得する
     *
     * @param array $params
     * @return string
     */
    private function get_set_phrase($params) {
        $res = '';

        foreach ($params as $key => $param) {
            if ($res !== '') {
                $res .= ', ';
            }

            $res .= $key . ' = :' . $key;
        }

        return $res;
    }
}
