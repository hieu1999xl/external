<?php

/**
 * 別サービスの解約アンケートテーブルのモデルクラス
 */
class Model_HumanLife_CancelSurveyAltServiceQuestion extends Model_CrudAbstract {

    /**
     * 解約アンケート質問と答えを取得する
     * @param int $business_id
     * @param int $service_type サービス種別
     *
     * @return array アンケートの設問情報を格納した配列
     */
    public function get_cancel_survey_question_and_answer($business_id, $service_type) {

        // 画面上の処理の関係上、positionをquestion_idとして取得する
        $query = <<<SQL
SELECT
    q.position as question_id
    , q.question
    , a.answer_id
    , a.answer_type
    , a.previous_answer_id
    , a.answer
FROM
    cancel_survey_alt_service_question q
    INNER JOIN cancel_survey_alt_service_answer a
        ON q.question_id = a.question_id
WHERE
    q.business_id = :business_id
    AND q.service_type = :service_type
    AND q.delete_flag = :delete_flag
    AND a.delete_flag = :delete_flag
ORDER BY
    q.position ASC
    , a.position ASC
SQL;

        $param = [
            'business_id' => $business_id,
            'service_type' => $service_type,
            'delete_flag' => FLG_OFF,
        ];

        return DB::query($query)->parameters($param)->execute()->as_array();
    }

    /**
     * 解約申請者からの返答を登録する
     *
     * @param int $business_id
     * @param int $service_type サービス種別
     * @param int $user_id
     * @param int $contract_id
     * @param int $question_id
     * @param array $cancel_survey_answer
     * @param array $cancel_survey_answer_text
     * 
     * @return 実行結果
     */
    public function insert_cancel_survey_response($business_id, $service_type, $user_id, $contract_id, $question_id, $cancel_survey_answer, $cancel_survey_answer_text, $cancel_type)
    {

        $sql = <<<SQL
INSERT INTO cancel_survey_alt_service_responce( 
    business_id
    , service_type
    , question_id
    , answer_id
    , text_response
    , user_id
    , contract_id
    , cancel_type
    , create_datetime
    , create_user
    , update_datetime
    , update_user
) VALUE ( 
    :business_id
    , :service_type
    , :question_id
    , :answer_id
    , :text_response
    , :user_id
    , :contract_id
    , :cancel_type
    , NOW()
    , :create_user
    , NOW()
    , :update_user
)
SQL;

        $param = [
            'business_id'    => $business_id,
            'service_type'   => $service_type,
            'question_id'    => $question_id,
            'answer_id'      => $cancel_survey_answer,
            'text_response'  => $cancel_survey_answer_text,
            'user_id'        => $user_id,
            'contract_id'    => $contract_id,
            'cancel_type'    => $cancel_type,
            'create_user'    => SYSTEM_USER_NAME,
            'update_user'    => SYSTEM_USER_NAME,
        ];

        return DB::query($sql)->parameters($param)->execute();
    }
}
