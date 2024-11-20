<?php

/**
 * 初期契約解除アンケートテーブルのモデルクラス
 */
class Model_HumanLife_InitialContractCancelSurveyQuestion extends Model_CrudAbstract {

    /**
     * 解約アンケート質問と答えを取得する
     *
     * @return array
     */
    public function get_initial_contract_cancel_survey_question_and_answer() {
        $query = <<<SQL
        select initial_contract_cancel_survey_question.question_id, initial_contract_cancel_survey_question.question, initial_contract_cancel_survey_answer.answer_id, initial_contract_cancel_survey_answer.answer_type, initial_contract_cancel_survey_answer.previous_answer_id, initial_contract_cancel_survey_answer.answer
        from initial_contract_cancel_survey_question
        join initial_contract_cancel_survey_answer on initial_contract_cancel_survey_question.question_id = initial_contract_cancel_survey_answer.question_id
        where initial_contract_cancel_survey_question.delete_flag = 0
        AND initial_contract_cancel_survey_answer.delete_flag = 0
        ORDER BY initial_contract_cancel_survey_question.position ASC, initial_contract_cancel_survey_answer.position ASC
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
     * @param $initial_contract_cancel_survey_answer
     * @param $initial_contract_cancel_survey_answer_text
     */
    public function insert_initial_contract_cancel_survey_response($user_id, $contract_id, $question_id, $initial_contract_cancel_survey_answer, $initial_contract_cancel_survey_answer_text, $cancel_type)
    {
        $sql = <<<SQL
INSERT INTO
       initial_contract_cancel_survey_response(
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
            'answer_text'    => $initial_contract_cancel_survey_answer_text,
            'contract_id'    => $contract_id,
            'answer_id'      => $initial_contract_cancel_survey_answer,
            'cancel_type'    => $cancel_type,
            'create_user'    => SYSTEM_USER_NAME,
            'update_user'    => SYSTEM_USER_NAME,
        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($param)->execute();
        parent::post_find($result);

    }
}
