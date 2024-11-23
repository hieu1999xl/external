// 端末の売り切れ制御（以下の１と２を変更してください）

// １. 売り切れになった端末の制御
$(function() {
  // 売り切れになった端末のソールドアウト関数をここに入れて下さい（以下参照）
  // soldOutGalaxy(); ← Galaxy 5G Mobile Wi-Fi
  // soldOutX11(); ← Speed Wi-Fi 5G X11（gray&white両方売り切れの場合）
  // soldOutX11Gray(); ← Speed Wi-Fi 5G X11（grayだけ売り切れの場合）
  // soldOutX11White(); ← Speed Wi-Fi 5G X11（whiteだけ売り切れの場合）
  // soldOutL12(); ← Speed Wi-Fi HOME 5G L12
  // soldOutL11(); ← Speed Wi-Fi HOME 5G L11
  //
  // （例）Galaxy 5G Mobile Wi-Fiが売り切れになった場合
  // $(function() {
  //   soldOutGalaxy();
  // });
});

// ２．Speed Wi-Fi 5G X11が売り切れの場合（gray&white両方売り切れの場合 or grayだけ売り切れの場合 or whiteだけ売り切れの場合）、以下も変更すること
function soldOutX11Entry(){
  // Speed Wi-Fi 5G X11が売り切れの場合、以下をコメントアウトする

  // var wimaxSelectPage = location.pathname.indexOf("/entry/wimax/select") === 0;
  // if(wimaxSelectPage){
  //   $(".x11-detail").show();
  // }

  // Speed Wi-Fi 5G X11が売り切れの場合、以下のコメントアウトを外す

  // $(".x11-detail").hide();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////以下ソールドアウト関数（変更不要）

// ソールドアウト関数（Galaxy 5G Mobile Wi-Fi）
function soldOutGalaxy(){
  $(".sold-out.Galaxy").show();
  $(".wimax-device-select.Galaxy").addClass("sold");
  $('.slide-Galaxy').before($('.slide-X11'));
}

// ソールドアウト関数（Speed Wi-Fi 5G X11（gray&white両方売り切れの場合））
function soldOutX11(){
  $(".sold-out.X11").show();
  $(".wimax-device-select.X11").addClass("sold");
}

// ソールドアウト関数（Speed Wi-Fi 5G X11（grayだけ売り切れの場合））
function soldOutX11Gray(){
  $(".X11-all").hide();
  $(".X11-gray").hide();
  $(".X11-white").show();
  $(".X11-white-2").show();
  $('input[id="x11_detail1_id_2"]').prop("checked",true);
  $(".swiper-box-caution").hide();
  $(".X11-all-caution-area").addClass("X11-all-caution");
}

// ソールドアウト関数（Speed Wi-Fi 5G X11（whiteだけ売り切れの場合））
function soldOutX11White(){
  $(".X11-gray").show();
  $(".X11-all").hide();
  $('input[id="x11_detail1_id_1"]').prop("checked",true);
  $(".swiper-box-caution").hide();
  $(".X11-all-caution-area").addClass("X11-all-caution");
}

// ソールドアウト関数（Speed Wi-Fi HOME 5G L13）
function soldOutL13(){
  $(".sold-out.L13").show();
  $(".wimax-device-select.L13").addClass("sold");
}

// ソールドアウト関数（Speed Wi-Fi HOME 5G L12）
function soldOutL12(){
  $(".sold-out.L12").show();
  $(".wimax-device-select.L12").addClass("sold");
}

// ソールドアウト関数（Speed Wi-Fi HOME 5G L11）
function soldOutL11(){
  $(".sold-out.L11").show();
  $(".wimax-device-select.L11").addClass("sold");
  $('.slide-L11').before($('.slide-L12'));
}

// ソールドアウト関数（Speed Wi-Fi 5G X12（gray&white両方売り切れの場合））
function soldOutX12(){
  $(".sold-out.X12").show();
  $(".wimax-device-select.X12").addClass("sold");
}

// ソールドアウト関数（Speed Wi-Fi 5G X12（grayだけ売り切れの場合））
function soldOutX12Gray(){
  $(".X12-all").hide();
  $(".X12-gray").hide();
  $(".X12-white").show();
  $(".X12-white-2").show();
  $('input[id="x12_detail1_id_2"]').prop("checked",true);
  $(".swiper-box-caution").hide();
  $(".X12-all-caution-area").addClass("X12-all-caution");
}

// ソールドアウト関数（Speed Wi-Fi 5G X12（whiteだけ売り切れの場合））
function soldOutX12White(){
  $(".X12-gray").show();
  $(".X12-all").hide();
  $('input[id="x12_detail1_id_1"]').prop("checked",true);
  $(".swiper-box-caution").hide();
  $(".X12-all-caution-area").addClass("X12-all-caution");
}