<?php

/**
 * プラン初期費用マスタテーブルのモデルクラス
 */
class Model_HumanLife_MstPlanInit extends Model_CrudAbstract {

    /**
     * プランIDを条件にプラン初期費用情報を取得する
     *
     * @param int $plan_id
     * @return array
     */
    public function get_plan_init_info_list_by_plan_id($plan_id) {
        $sql = <<<SQL
SELECT
    mpi.plan_init_id
  , mpi.plan_init_name
  , mpi.price
  , mpi.tax_type
FROM
    mst_plan_init AS mpi
WHERE
    mpi.plan_id = :plan_id
AND mpi.delete_flag = :delete_flag
ORDER BY
    mpi.plan_init_id ASC
SQL;

        $params = [
            'plan_id'     => $plan_id,
            'delete_flag' => FLG_OFF,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

}
