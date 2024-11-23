<?php
/**
 * スタブの設定値クラス
 * 値に応じて正常/エラー時の固定値を切り替えて渡す様にするための定義ファイル
 * stub_classが0の場合はクラス毎、親(実クラス)のfunctionが呼び出される
 * 例：
 * array (
 *    '[Daoクラス名]'　=> array(
 *      '[スタブfunction名]' => [スタブ利用有無](0:利用なし（親のメソッド呼び出し） 1: スタブ利用(正常) 2: スタブ利用(エラー))
 *    )
 * )
 *
 */
return [
    // UCloudLink
    'External_UCloudLink_GrpUserLogin'                => ['stub_class' => 1],
    'External_UCloudLink_GrpUserLogout'               => ['stub_class' => 1],
    'External_UCloudLink_BatchCreateGroupChild'       => ['stub_class' => 1],
    'External_UCloudLink_QuerySubUserListInfo'        => ['stub_class' => 1],
    'External_UCloudLink_QueryGrpOfferList'           => ['stub_class' => 1],
    'External_UCloudLink_GrpCreateOrder'              => ['stub_class' => 1],
    'External_UCloudLink_QueryUserOfferList'          => ['stub_class' => 1],
    'External_UCloudLink_StopSubUser'                 => ['stub_class' => 1],
    'External_UCloudLink_DeleteSubUser'               => ['stub_class' => 1],
    'External_UCloudLink_ResetPwdForSubUser'          => ['stub_class' => 1],
    'External_UCloudLink_BindDevice'                  => ['stub_class' => 1],
    'External_UCloudLink_BatchUnBindDevice'           => ['stub_class' => 1],
    'External_UCloudLink_QueryBindingRelationInfo'    => ['stub_class' => 1],
    'External_UCloudLink_LockDevice'                  => ['stub_class' => 1],
    'External_UCloudLink_TopUpForSubUser'             => ['stub_class' => 1],
    'External_UCloudLink_QueryTopUpListInfo'          => ['stub_class' => 1],
    'External_UCloudLink_QueryAccountDetailListInfo'  => ['stub_class' => 1],
    'External_UCloudLink_QuerySubUserListByBatch'     => ['stub_class' => 1],
    'External_UCloudLink_QueryOrderRelationByOrderId' => ['stub_class' => 1],
    'External_UCloudLink_CancelOrder'                 => ['stub_class' => 1],
    'External_UCloudLink_DisableOrderRelation'        => ['stub_class' => 1],

    // GMO
    'External_Gmo_SaveMember'                         => ['stub_class' => 1],
    'External_Gmo_UpdateMember'                       => ['stub_class' => 1],
    'External_Gmo_DeleteMember'                       => ['stub_class' => 1],
    'External_Gmo_SearchMember'                       => ['stub_class' => 1],
    'External_Gmo_SaveCard'                           => ['stub_class' => 1],
    'External_Gmo_SearchCard'                         => ['stub_class' => 1],
    'External_Gmo_DeleteCard'                         => ['stub_class' => 1],
    'External_Gmo_EntryTran'                          => ['stub_class' => 1],
    'External_Gmo_ExecTran'                           => ['stub_class' => 1],
    'External_Gmo_AlterTran'                          => ['stub_class' => 1],
    'External_Gmo_ChangeTran'                         => ['stub_class' => 1],
    'External_Gmo_SearchTrade'                        => ['stub_class' => 1],
    'External_Gmo_BankAccountEntry'                   => ['stub_class' => 1],
    'External_Gmo_BankAccountTranResult'              => ['stub_class' => 1],
    'External_Gmo_SearchMemberBankAccount'            => ['stub_class' => 1],
    'External_Gmo_EntryTranBankAccount'               => ['stub_class' => 1],
    'External_Gmo_ExecTranBankAccount'                => ['stub_class' => 1],
    'External_Gmo_BankAccountCancel'                  => ['stub_class' => 1],
    'External_Gmo_BankAccountChange'                  => ['stub_class' => 1],
    'External_Gmo_SearchTradeMulti'                   => ['stub_class' => 1],
    'External_Gmo_StartMerchantTransaction'           => ['stub_class' => 1],
    'External_Gmo_GetMerchantTransaction'             => ['stub_class' => 1],

    // HRDS
    'External_Hrds_EntryInsurance'                    => ['stub_class' => 1],
    'External_Hrds_CancelInsurance'                   => ['stub_class' => 1],

    // Google OAuth
    'External_Google_OauthToken'                      => ['stub_class' => 1],

    // Google Ads API
    'External_Google_AdsCustomersUploadClickConversions'     => ['stub_class' => 1],
    'External_Google_AdsCustomersUploadConversionAdjustment' => ['stub_class' => 1],
];
