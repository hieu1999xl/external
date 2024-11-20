var opFlg; // ポップアップが開いているかどうか判定用フラグ
var opUnSelectFlg; // オプションが選択されていない時のフラグ

// ポップアップ表示処理 start ////////////////////////////////////////////////////////////////////
function showOptionAlart(){
  if(!$("#option1").prop("checked")){
    return;
  }else{
    $("input[id='option-checkbox-true']").parent(".custom-check-box-v2").addClass("check-option");
    $("input[id='option-checkbox-false']").parent(".custom-check-box-v2").removeClass("check-option");
    $("#option-checkbox-true").prop("checked", true);
    $(".alart-notion-black-background").show();
    $("#device_option_check").show();

    $('[data-focusmove="prepaid-device-option"]').focus();
  }
  opFlg = "1";
}

function showOption2Alart(){
  if(!($("#option2").prop("checked"))){
    $("#option2").prop("checked", true);
    $(".relief-item-select-area2").removeClass("selected");
  }else{
    $("#option2").prop("checked", false);
    $(".relief-item-select-area2").removeClass("selected");
  }
  prepaidForm();
  return;
}

function showOption3Alart(){
  if(!($("#option3").prop("checked"))){
    $("#option3").prop("checked", true);
    $(".relief-item-select-area2").removeClass("selected");
  }else{
    $("#option3").prop("checked", false);
    $(".relief-item-select-area2").removeClass("selected");
  }
  prepaidForm();
  return;
}
// ポップアップ表示処理 end //////////////////////////////////////////////////////////////////////

// ポップアップ非表示処理 start //////////////////////////////////////////////////////////////////
function hideOptionAlart(){
  $(".alart-notion-black-background").hide();
  $("#device_option_check").hide();
}
// ポップアップ非表示処理 end ////////////////////////////////////////////////////////////////////

$(function(){
  // オプションをクリックした時の処理 start ///////////////////////////////////////////////////////
  $(".entry-option-tanmatsu-anshin .topping-2-select-area-relief-option").click(function(e){
    if ($(this).siblings("label").find("input").attr("id") === "option2"){
      showOptionAlart();
    }else {
      if($(this).siblings("label").find("input").prop("checked") == true) {
        showOptionAlart();
      }else {
        $("#option1").prop("checked",true);
        $(".relief-option-1").addClass("selected");
      }
    }
  });
  // オプションをクリックした時の処理 end /////////////////////////////////////////////////////////

  // ポップアップの中身 end /////////////////////////////////////////////////////////////////////
  var document_popup = `
<div class="alart-notion-black-background"></div>
<div class="option-popup-block prepaid-opt-block" id="device_option_check">
    <div class="entry-option-popup">
        <div class="background"></div>
        <div class="entry-option-popup-body">
            <div class="alart-popup-close-button js-tabindex" tabindex="0" data-focusmove="prepaid-device-option"><i class="fas fa-times"></i></div>
            <div class="popup-contents">
                <div class="popup-wrap popup-tanmatsu-anshin-notice">
                    <div class="popup-header">
                        <h2 class="title">本当に加入しなくて<br class="sp">大丈夫ですか？</h2>
                        <div class="group">
                            <div class="icon"><img alt="注意事項" width="70" height="70" src="/assets/img/plan-opt-notice-icon.svg"></div>
                            <p class="text">
                              <strong>新規ご契約時のみ加入が可能です。</strong>
                              <br>
                              申込後の途中加入はできません。
                            </p>
                        </div>
                    </div>
                    <div class="popup-body">
                      <div class="popup-container">
                        <div class="item">
                          <img alt="端末交換" width="150" height="166" src="/assets/img/prepaid_popup_exchang.webp" class="pc" aria-hidden="true">
                        </div>
                        <h3>端末の故障・破損により端末交換を行う場合、<br>交換費用19,800円(税込)がかかるところ、<br><span class="color-pink">11,000円(税込)のご負担のみ</span>に！</h3>
                      </div>
                      <p class="desc">
                      端末サポート未加入で故障・破損により<br>端末交換を行う場合には、19,800円がかかります。
                      </p>
                    </div>
                    <div class="popup-bottom">
                        <div class="option-check"><label class="custom-check-box-v2 js-tabindex" for="option-checkbox-true" tabindex="0">加入する<input id="option-checkbox-true" type="radio" name="device_option" value="true"><span></span></label><label class="custom-check-box-v2 js-tabindex" for="option-checkbox-false" tabindex="0">加入しない<input id="option-checkbox-false" type="radio" name="device_option" value="false"><span></span></label></div>
                        <div class="custom-check-box-v2 option-check btn-option-close js-tabindex" tabindex="0">オプション選択に戻る</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
`;
// ポップアップの中身 end ////////////////////////////////////////////////////////////////////////////

  // ポップアップセッティング
  $("body").append(document_popup);
  hideOptionAlart();

  // ポップアップ内の処理 start //////////////////////////////////////////////////////////////////////
  // ポップアップ内のボタン部分
  var optionTrue = $("input[id='option-checkbox-true']").parent(".custom-check-box-v2");
  var optionFalse = $("input[id='option-checkbox-false']").parent(".custom-check-box-v2");
  optionTrue.addClass("check-option"); // 初期チェック

  // 選択中のポップアップ内のボタン部分を黄色くする
  $("input[name='device_option']:radio").change(function() {
    var checkVal = $(this).val();
    if(checkVal === "true"){
      optionTrue.addClass("check-option");
      optionFalse.removeClass("check-option");
    }else{
      optionTrue.removeClass("check-option");
      optionFalse.addClass("check-option");
    }
  });

  // ポップアップを閉じるときの処理
  $(".alart-notion-black-background,.alart-popup-close-button,.btn-option-close,.entry-option-popup .background").click(function(){
    var checkFalse = $("#option-checkbox-false").prop("checked");
    if(checkFalse){
      $("#option1").prop("checked",false);
      $(".relief-option-1").removeClass("selected");
      $("#option2").prop("checked",true);
      $(".relief-option-2").addClass("selected");
      $('.plan-summary-option.tanmatsu, .plan-summary-option.marugoto, .plan-summary-option.digital-life').hide();

      opUnSelectFlg = true;
      prepaidForm(); // あなたのプランはこちら　の初回発火
    }else{
      $("#option1").prop("checked",true);
      $(".relief-option-1").addClass("selected");
    }
    hideOptionAlart();
    $(".prepaid-device-option").focus();
  });
  // ポップアップ内の処理 end ///////////////////////////////////////////////////////////////////////

  $(".entry-option-digital-life .topping-2-select-area-relief-option, .entry-option-marugoto-anshin .topping-2-select-area-relief-option").click(function(e){
    if ($(this).siblings("label").find("input").prop('checked')) {
      if ($(this).siblings("label").find("input").attr("id") === "option1") {
        showOptionAlart();
      } else if ($(this).siblings("label").find("input").attr("id") === "option2") {
        showOption2Alart();
      } else if ($(this).siblings("label").find("input").attr("id") === "option3") {
        showOption3Alart();
      }
    } else {
      $(this).addClass("selected");
      $(this).siblings("label").find("input").prop('checked', true);
      prepaidForm();
    }
  });
});

// 端末プルダウン
$(function() {
  $(".entry-rental-device-title").click(function(e){
    var targetButton = $(e.target);
    var target = $('.entry-rental-device-flex');
    if (target.hasClass("hidden")){
      target.removeClass("hidden");
      targetButton.find(".pull-down-arrow-to-open").hide();
      targetButton.find(".pull-down-arrow-to-close").show();
    }else{
      target.addClass("hidden");
      targetButton.find(".pull-down-arrow-to-close").hide();
      targetButton.find(".pull-down-arrow-to-open").show();
    }
  });
});

// ///
// Auto input kana
// ///
$(function() {
  //name属性で判別する場合
  if (!$.fn['autoKana']) return;
  $.fn.autoKana('input[name="last_name"] ', 'input[name="last_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="first_name"] ', 'input[name="first_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="user_last_name"] ', 'input[name="user_last_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="user_first_name"] ', 'input[name="user_first_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="delivery_last_name"] ', 'input[name="delivery_last_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="delivery_first_name"] ', 'input[name="delivery_first_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="deliverycorp_last_name"] ', 'input[name="deliverycorp_last_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="deliverycorp_first_name"] ', 'input[name="deliverycorp_first_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="corp_company_name"] ', 'input[name="corp_company_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="corp_last_name"] ', 'input[name="corp_last_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="corp_first_name"] ', 'input[name="corp_first_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="company_name"] ', 'input[name="company_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="invoice_company_name"] ', 'input[name="invoice_company_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="invoice_last_name"] ', 'input[name="invoice_last_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="invoice_first_name"] ', 'input[name="invoice_first_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="represent_last_name"] ', 'input[name="represent_last_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="represent_first_name"] ', 'input[name="represent_first_name_kana"]', {katakana:true});
});

// 継続課金プラン/申込フォーム画面判別 start //////////////////////////////////////////////////////////////////////
$(function(){
  if(window.location.pathname.includes('sub')) {
    $('.mypage-section-container').addClass('sub-entry-prepaid');
  }
});
// 継続課金プラン/申込フォーム画面判別 end //////////////////////////////////////////////////////////////////////

// 継続課金プラン/価格コム限定 start //////////////////////////////////////////////////////////////////////
$(document).ready(function() {
  // URLを取得
  var url = new URL(window.location.href);
  // パラメータを取得
  var params = url.searchParams;
  var utm_source_params = params.get('utm_source');
  if(window.location.pathname.includes('/entry/prepaid/sub/select') && utm_source_params === 'kakaku'){
    // 価格コムからの流入の場合は固有のクラスを付与
    $('body').addClass('kakaku');
  }
  if(window.location.pathname.includes('/entry/prepaid/sub/') && utm_source_params === 'kakaku'){
    // 価格コムからの流入の場合はフッターリンクのTopを隠す
    $('.footer-link-hide').css('display', 'none');
  }
});
// 継続課金プラン/価格コム限定 end //////////////////////////////////////////////////////////////////////