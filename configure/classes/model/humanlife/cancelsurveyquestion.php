<?php

/**
 * 解約アンケートテーブルのモデルクラス
 */
class Model_HumanLife_CancelSurveyQuestion extends Model_CrudAbstract {

    /**
     * 解約アンケート質問と答えを取得する
     *
     * @return array
     */
    public function get_cancel_survey_question_and_answer() {
        $query = <<<SQL
        select cancel_survey_question.question_id, cancel_survey_question.question, cancel_survey_answer.answer_id, cancel_survey_answer.answer_type, cancel_survey_answer.previous_answer_id, cancel_survey_answer.answer
        from cancel_survey_question
        join cancel_survey_answer on cancel_survey_question.question_id = cancel_survey_answer.question_id
        where cancel_survey_question.delete_flag = 0
        AND cancel_survey_answer.delete_flag = 0
        ORDER BY cancel_survey_question.position ASC, cancel_survey_answer.position ASC
        ;
SQL;

        return DB::query($query)->execute()->as_array();
    }

    /**
     * 解約アンケート質問と答えを保存する
     *
     * @param $user_id
     * @param $contract_id
     * @param $question_id
     * @param $cancel_survey_answer
     * @param $cancel_survey_answer_text
     */
    public function insert_cancel_survey_response($user_id, $contract_id, $question_id, $cancel_survey_answer, $cancel_survey_answer_text, $cancel_type)
    {
        $sql = <<<SQL
INSERT INTO
       cancel_survey_response(
       question_id,
       answer_id,
       text_response,
       user_id,
       contract_id,
       cancel_type,
       create_datetime,
       create_user,
       update_datetime,
       update_user
      )
 VALUE(
  :question_id,
  :answer_id,
  :answer_text,
  :user_id,
  :contract_id,
  :cancel_type,
  NOW(),
  :create_user,
  NOW(),
  :update_user
)
SQL;

        $param = [
            'user_id'        => $user_id,
            'question_id'    => $question_id,
            'answer_text'    => $cancel_survey_answer_text,
            'contract_id'    => $contract_id,
            'answer_id'      => $cancel_survey_answer,
            'cancel_type'    => $cancel_type,
            'create_user'    => SYSTEM_USER_NAME,
            'update_user'    => SYSTEM_USER_NAME,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute();
        parent::post_find($result);

    }
}
