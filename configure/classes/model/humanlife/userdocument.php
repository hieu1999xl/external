<?php


/**
 * 端末初期費用除外マスタテーブルのモデルクラス
 */
class Model_HumanLife_UserDocument extends Model_CrudAbstract {
    
    public function insert_user_document_info($user_id,$doc_category_id,$doc_id, $doc_key, $business_id, $file_order, $upload_count) {

        $query = <<<SQL
INSERT INTO
    user_document
(
    `business_id`,
    `user_id`,
    `doc_category_id`,
    `doc_type_id`,
    `file_order`,
    `doc_key`,
    `status`,
    `upload_count`,
    `create_user`,
    `update_user`
)
VALUES
(
    :business_id,
    :user_id,
    :doc_category_id,
    :confirm_doc_id,
    :file_order,
    :doc_key,
    :status,
    :upload_count,
    :create_user,
    :update_user
)
SQL;
        
        $param = [
            'business_id'    => $business_id,
            'status'         => FLG_ON,
            'user_id'        => $user_id,
            'confirm_doc_id' => $doc_id,
            'file_order'     => $file_order,
            'doc_key'        => $doc_key,
            'doc_category_id'=> $doc_category_id,
            'upload_count'   => $upload_count+1,
            'create_user'    => SYSTEM_USER_NAME,
            'update_user'    => SYSTEM_USER_NAME,
        ];
        
        $result = DB::query($query)->parameters($param)->execute();
        return $result;
    }
    /**
     * 
     */
    
    public function get_user_document_info($user_id, $business_id) {
        
        $query = <<<SQL
        SELECT
            *
        FROM
            user_document
        WHERE
            user_id = :user_id
        AND business_id = :business_id
        AND status = :status
        SQL;
        
        $bind_params = [];
        $bind_params['user_id'] = $user_id;
        $bind_params['business_id'] = $business_id;
        $bind_params['status'] = USER_DOCUMENT_STATUS_LIST['resubmit_status'];
        
        return DB::query($query)->parameters($bind_params)
        ->execute()
        ->as_array();
        
    }
    /**
     * get_upload_document_count
     * @param  $user_id
     * @param  $business_id
     * @return array
     */
    public function get_upload_document_count($user_id, $business_id){
        
        $query = <<<SQL
        SELECT
            MAX(upload_count) as upload_count
        FROM
            user_document
        WHERE
            user_id = :user_id
        AND business_id = :business_id
        SQL;
        
        $bind_params = [];
        $bind_params['user_id'] = $user_id;
        $bind_params['business_id'] = $business_id; 
        
        return DB::query($query)->parameters($bind_params)
        ->execute()
        ->as_array();
    }
    
    /**
     * 更新する
     *
     * @param array $user
     * @return int 更新件数
     */
    public function update_user_document($user_id, $doc_category_id, $doc_id, $doc_key, $business_id){
  
        // update
        $query = <<<SQL
UPDATE
    user_document
SET
     doc_type_id = :doc_type_id
  , doc_key = :doc_key
  , status = :initial_status
  , create_user = :create_user
  , update_user = :update_user
   
WHERE
    user_id = :user_id
AND business_id = :business_id
AND doc_category_id = :doc_category_id
AND status = :resubmit_status

SQL;
        $params = [
            'business_id'     => $business_id,
            'initial_status'  => USER_DOCUMENT_STATUS_LIST['initial_status'],
            'resubmit_status' => USER_DOCUMENT_STATUS_LIST['resubmit_status'],
            'user_id'         => $user_id,
            'doc_category_id'     => $doc_category_id,
            'doc_key'         => $doc_key,
            'doc_type_id'     => $doc_id,
            'create_user'     => SYSTEM_USER_NAME,
            'update_user'     => SYSTEM_USER_NAME,
        ];
        
        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
    }
    
    /**
     * 
     * @param  $user_id
     * @param  $doc_category_id
     * @param  $business_id
     * @return number
     */
    public function update_user_document_initial_status($user_id, $doc_category_id,$business_id) {
        
        $query = <<<SQL
UPDATE
    user_document
SET
    status = :initial_status
WHERE
    user_id = :user_id
AND business_id = :business_id
AND doc_category_id = :doc_category_id
AND status = :resubmit_status

SQL;
        $params = [
            'business_id'     => $business_id,
            'initial_status'  => USER_DOCUMENT_STATUS_LIST['initial_status'],
            'resubmit_status' => USER_DOCUMENT_STATUS_LIST['resubmit_status'],
            'user_id'         => $user_id,
            'doc_category_id' => $doc_category_id,
        ];
        
        parent::pre_update($query);
        $result = DB::query($query)->parameters($params)->execute();
        return parent::post_update($result);
        
    }
}
