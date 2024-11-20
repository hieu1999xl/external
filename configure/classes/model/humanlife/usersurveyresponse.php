<?php

/**
 * 汎用アンケート返答テーブルのモデルクラス
 *
 * @author ako.endo
 */
class Model_HumanLife_UserSurveyResponse extends Model_CrudAbstract {


    /**
     * テーブル名
     *
     * @var string 見積テーブル名
     */
    protected static $_table_name = 'user_survey_response';

    /**
     * 解約申請者からの返答を登録する
     *
     * @param int $business_id
     * @param array $params
     * 
     * @return array 実行結果
     */
    public function insert_survey_response($business_id, $params)
    {
        $sql = <<<SQL
INSERT INTO user_survey_response(
    business_id
    , user_id
    , entry_id
    , contract_id
    , survey_type
    , question_id
    , answer_id
    , text_response
    , create_user
    , update_user
) VALUE ( 
    :business_id
    , :user_id
    , :entry_id
    , :contract_id
    , :survey_type
    , :question_id
    , :answer_id
    , :text_response
    , :create_user
    , :update_user
)
SQL;

        $param = [
            'business_id'   => $business_id,
            'user_id'       => $params['user_id'],
            'entry_id'      => $params['entry_id'],
            'contract_id'   => $params['contract_id'] ?? null,
            'survey_type'   => $params['survey_type'],
            'question_id'   => $params['question_id'],
            'answer_id'     => $params['answer_id'],
            'text_response' => $params['text_response'] ?? null,
            'create_user'   => $params['create_user'],
            'update_user'   => $params['update_user'],
        ];

        return DB::query($sql)->parameters($param)->execute();
    }

    /**
     * 返答を削除する（仮申込データ更新用）
     * @param int $business_id
     * @param int $user_id
     * @param int $entry_id
     * 
     * @return int 削除件数
     */
    public function delete_user_survey_response($business_id, $user_id, $entry_id) {
        return DB::delete(self::$_table_name)
            ->where('business_id', $business_id)
            ->and_where('user_id', $user_id)
            ->and_where('entry_id', $entry_id)->execute();
    }
}
