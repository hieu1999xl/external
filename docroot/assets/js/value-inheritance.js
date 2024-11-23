// プラン情報パラメータ引き継ぎ（発火イベント）その他発火させたいところ（他JSファイル）にも valueInheritance(); を入れています start /////////////////////////////////
$(function() {
  $('input[name="plan_id"]:radio,[name="device_option"],[name="quantity"]').on('click change', function(){
    valueInheritance();
  });
});
// プラン情報パラメータ引き継ぎ（発火イベント）その他発火させたいところ（他JSファイル）にも valueInheritance(); を入れています end /////////////////////////////////

// プラン情報パラメータ引き継ぎ start ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function valueInheritance(){

  // URLを取得
  var url = new URL(window.location.href);

  // 選択したプラン情報を取得する
  var inheritancePlan = $('input[name="plan_id"]:checked').val();
  var inheritanceDeviceOption = $('input[name="device_option"]:checked').val();
  var inheritanceQuantity = $('select[name="quantity"]').val();

  // 選択したプラン情報をパラメータに設置する
  if(inheritancePlan){
    url.searchParams.set('inheritancePlan', inheritancePlan);
  }else{
    url.searchParams.delete('inheritancePlan');
  }

  if(inheritanceDeviceOption == 16){
    url.searchParams.set('inheritanceDeviceOption', inheritanceDeviceOption);
  }else{
    url.searchParams.delete('inheritanceDeviceOption');
  }

  if(inheritanceQuantity){
    url.searchParams.set('inheritanceQuantity', inheritanceQuantity);
  }else{
    url.searchParams.delete('inheritanceQuantity');
  }

  window.history.pushState({}, '', url);
}

$(function(){
  // 前ページのパラメータを取得する
  var url = new URL(document.referrer).searchParams;

  // 前ページのパラメータを現ページのURLに設置する
  if(document.referrer.includes("/entry")){
    window.history.pushState({}, '', '?' + url);
  }

  // パラメータで引き継いだプラン情報をSTEP1とSTEP3で反映する
  if(window.location.pathname.includes("/select") || window.location.pathname.includes("/confirm")){
    var inheritancePlan = url.get('inheritancePlan');
    var inheritanceDeviceOption = url.get('inheritanceDeviceOption');
    var inheritanceQuantity = url.get('inheritanceQuantity');

    var inheritancePlan_in = $('input[name="plan_id"][value="' + inheritancePlan + '"]');
    var inheritanceDeviceOption_in = $('#topping-2-select-area-relief-option');
    var inheritanceQuantity_in = $('select[name="quantity"]');

    if(inheritancePlan){
      inheritancePlan_in.click();
    }

    if(document.referrer.includes("/entry")){
      if(inheritanceDeviceOption){
        inheritanceDeviceOption_in.click();
      }else{
        $("#option1").prop("checked",false);
        $("#option-checkbox-false").prop("checked",true);
        $(".relief-item-select-area").removeClass("selected");
      }
    }

    if(inheritanceQuantity){
      inheritanceQuantity_in.val(inheritanceQuantity).click();
    }

  }
});
// プラン情報パラメータ引き継ぎ end ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
