<?php

/**
 * 汎用アンケートテーブルのモデルクラス
 */
class Model_HumanLife_MstSurveyQuestion extends Model_CrudAbstract {

    /**
     * アンケートの設問と回答選択肢を取得する
     * @param int $business_id
     * @param int $survey_type アンケート区分
     *
     * @return array アンケートの設問情報を格納した配列
     */
    public function get_survey_question_and_answer($business_id, $survey_type) {
        // 画面上の処理の関係上、positionをquestion_idとして取得する
        $query = <<<SQL
SELECT
    q.question_id
    , q.question
    , q.survey_type
    , a.answer_id
    , a.answer_type
    , a.previous_answer_id
    , a.answer 
FROM
    mst_survey_question q 
    INNER JOIN mst_survey_answer a 
        ON q.question_id = a.question_id 
WHERE
    q.business_id = :business_id 
    AND q.survey_type = :survey_type 
    AND q.delete_flag = :delete_flag 
    AND a.delete_flag = :delete_flag 
ORDER BY
    q.position ASC
    , a.position ASC
SQL;

        $param = [
            'business_id' => $business_id,
            'survey_type' => $survey_type,
            'delete_flag' => FLG_OFF,
        ];

        return DB::query($query)->parameters($param)->execute()->as_array();
    }
}
