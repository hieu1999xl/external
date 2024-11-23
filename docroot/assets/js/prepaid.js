var tax = 1.1;
var taxOnly = 0.1;

//////////////////////////////////////////////////////////////////////////////// プラン・容量選択画面専用JS start //////////////////////////////////////////////////////////////////////////////
$(function() {
  // プランにチェックを入れる start //////////////////////////////////////////////////////
  $(".prepaid-plan").click(function() {
    var target = $(this);
    var checkBox = $(target).find("input");
    checkBox.prop('checked', true);
    $(".prepaid-plan").removeClass("selected");
    $(target).addClass("selected");
  });

  $('input[name="plan_id"]').change(function(e) {
    var target = $(e.target).parents('.prepaid-plan');
    var checkBox = $(target).find("input");
    checkBox.prop('checked', true);
    $(".prepaid-plan").removeClass("selected");
    $(target).addClass("selected");
  });

  $('.confirm-plan-popup-btn').on('click', function() {
    let input = $('input[name="plan_id"]:checked');
    let target = $(input).parents('.prepaid-plan');
    $(target).removeClass("selected");
    $(target).addClass("selected");
  });

  // プランにチェックを入れる end ////////////////////////////////////////////////////////

  // デバイスにチェックを入れる start //////////////////////////////////////////////////////
  $(".prepaid-device-area.device-select").click(function() {
    var target = $(this);
    var checkBox = $(target).find("input");
    checkBox.prop('checked', true);
    $(".prepaid-device-area").removeClass("selected");
    $(target).addClass("selected");
  })
  // デバイスにチェックを入れる end ////////////////////////////////////////////////////////

  var get_option_id_insurance = parseInt($('input[name="option_id_insurance"]:checked').val()) || 37;
  $(".digital-life .relief-item-select-area3,.digital-life .relief-item-select-area3 + span,.digital-life .relief-item-select-area3 + span + p").click(function () {
    set_option_id_insurance = parseInt($('[name="option_id_insurance"]:checked').val());
    if (set_option_id_insurance > 0) get_option_id_insurance = set_option_id_insurance;
    if ($(".digital-life .relief-item-select-area3").hasClass("selected")) {
      $(".digital-life .relief-item-select-area3").removeClass("selected");
      $("#option_id_insurance_non").prop("checked",true);
    } else {
      $(".digital-life .relief-item-select-area3").addClass("selected");
      $("#option_id_insurance_20").prop("checked", true);
    }
      $(".dls-select-box").toggle();
  });

  //アラートの確認で選択した方にチェックを入れる
  $(".alart-notion-black-background,.alart-popup-close-button,.btn-option-close,.entry-option-popup .background").click(function() {
    var checkFalse = $("#option-checkbox-false").prop("checked");
    var checkFalse2 = $("#option2-checkbox-false").prop("checked");
    if (window.location.pathname.includes("/entry/prepaid/sub/select")||window.location.pathname.includes("/entry/prepaid/sub/confirm")) {
      if (opFlg === "1") {
        if (checkFalse) {
          $("#option1").prop("checked",false);
          $(".relief-item-select-area").removeClass("selected");
        } else {
          $("#option1").prop("checked",true);
          $(".relief-item-select-area").addClass("selected");
        }
      } else {
        if (checkFalse2 != undefined) {
          if (checkFalse2) {
            $("#option2").prop("checked",false);
            $(".relief-item-select-area2").removeClass("selected");
          } else {
            $("#option2").prop("checked",true);
            $(".relief-item-select-area2").addClass("selected");
          }
        }
      }
    } else {
      //つけない
      if (checkFalse) {
        $("#device_option_false").click();
        selectTopping2(".entry-option-right .topping-2-select-area");
        noselectTopping2(".entry-option-left .topping-2-select-area");
        //つける または何も選択しない
      } else {
        if (checkFalse2 != undefined) {
          $("#device_option_true").click();
          selectTopping2(".entry-option-left .topping-2-select-area");
          noselectTopping2(".entry-option-right .topping-2-select-area");
        }
      }
    }
  });

  // 料金内訳追従 start /////////////////////////////////////////////////////////////////
  $('#detail-more-tab').on('click', function() {
    if ($('.your-plan-area').hasClass('summary-close')) {
      $('.your-plan-area').removeClass('summary-close');
      $('#detail-more-tab').addClass('your-plan-open');
    } else {
      $('.your-plan-area').addClass('summary-close');
      $('#detail-more-tab').removeClass('your-plan-open');
    }
    $('.detail-more').toggle();
    // ウェブアクセシビリティ対応（内訳を開いた直後スクロールできるようにする）
    $('.detail-more').focus();
  });

  $('.input-sm, ._areas, ._countries, ._dataplans, #anshin_option .entry-option-select, #detail-more-tab').on('click change', function() {

    // オートチャージ申し込みフォームの場合は追従処理させない
    if (window.location.pathname.includes('/entry/prepaid/sub/select')) return;

    if ($('.your-plan-area').hasClass('summary-close')) {
      if (window.matchMedia("(max-width: 768px)").matches) {
        //画面横幅が768px以下のときの処理
        $('.your-plan-area').css('height', 65);
      } else {
        //画面横幅が769px以上のときの処理
        $('.your-plan-area').css('height', 120);
      };
    } else {
      if (window.matchMedia("(max-width: 768px)").matches) {
        //画面横幅が768px以下のときの処理
        var your_plan_height = $('#your_plan').height() - 13;
      } else {
        //画面横幅が769px以上のときの処理
        var your_plan_height = $('#your_plan').height() + 27.4;
      };

      $('.your-plan-area').css('height', your_plan_height);
    }
  });

  $(window).on("scroll", function() {
    const scrollHeight = $(document).height();/*ページ全体の高さ*/
    const scrollPosition = $(window).height() + $(window).scrollTop();/*ページの一番上からスクロールされた距離*/
    const footHeight = 345;/*追従の高さ(PC)*/
    const footHeightSP = 370;/*追従の高さ(SP)*/

    // プリペイド申し込みフォームの場合は追従処理させない
    if (window.location.pathname.includes('/entry/prepaid/select') || window.location.pathname.includes('/entry/prepaid/sub/select')) return;

    if (window.matchMedia("(max-width: 767px)").matches) {
      //画面横幅が767px以下のときの処理
      if ( scrollHeight - scrollPosition  <= footHeightSP ) {
        $("#your_plan").css({
          "position":"absolute",
          "bottom": footHeightSP,
        });
        // $(".plan-summary-area-table.contract").show();
      } else {
        $("#your_plan").css({
          "position":"fixed",
          "bottom": "10px",
        });
        // $(".plan-summary-area-table.contract").hide();
      }
    } else {
      //画面横幅が768px以上のときの処理
      if(window.location.pathname.includes("/entry/prepaid/select")) { //プリペイド通常プランのみあなたのプランはこちらの出現タイミングを調整
        if ( scrollHeight - scrollPosition  <= footHeight || $(window).scrollTop() == 0) {
          $("#your_plan").css({
            "position":"absolute",
            "bottom": footHeight,
          });
        } else if (scrollPosition > 1200) {
          $("#your_plan").css({
            "position":"fixed",
            "bottom": "10px",
          });
        }
      }else {
        if ( scrollHeight - scrollPosition  <= footHeight ) {
          $("#your_plan").css({
            "position":"absolute",
            "bottom": footHeight,
          });
        } else {
          $("#your_plan").css({
            "position":"fixed",
            "bottom": "10px",
          });
        }
      }
    };
  });
  // 料金内訳追従 end ///////////////////////////////////////////////////////////////////

  // あなたのプランはこちら　のイベント発火 start /////////////////////////////////////////
  $('.prepaid-plan, input[name="plan_id"], .entry-option-select, input[name="selected_option[]"], .prepaid-device-area, input[name="device_id"]').on('click change', function() {
    prepaidForm();
  });
  // あなたのプランはこちら　のイベント発火 end ///////////////////////////////////////////
})

$(function() {
  if ($('#your_plan').length) {
    prepaidForm(); // あなたのプランはこちら　の初回発火
  }
})

//　H01チェックしてたのに売り切れてしまった人は、端末選択をMR1に切り替える start /////////////////////////////////////////
$(function() {
  if ($('#soldout').length) {
    var device_id_soldout = $('input[name="device_id"]:checked').val();
    if(device_id_soldout == 42){
      $('input[id="plan_p_device_h01"]').prop("checked", false);
      $('input[id="plan_p_device"]').prop("checked", true);
    }
  }else{
    return;
  }
})
//　H01チェックしてたのに売り切れてしまった人は、チェックをMR1にする end /////////////////////////////////////////

// あなたのプランはこちら start /////////////////////////////////////////////////////////
// //
// ID情報格納
// //
var gSummaryPrices = {
  plan_id: {
    "721": {
      "capacity": 100,
      "terms": 90,
      "price": 4480,
    },
    "722": {
      "capacity": 50,
      "terms": 60,
      "price": 3580,
    },
    "723": {
      "capacity": 20,
      "terms": 30,
      "price": 2280,
    },
    "724": {
      "capacity": 10,
      "terms": 30,
      "price": 1280,
    },
    "726": {
      "capacity": 3,
      "terms": 30,
      "price": 660,
    },
    "727": {
      "capacity": 0,
      "terms": "",
      "price": 0,
    },
    "4065": {
      "capacity": 20,
      "terms": 1,
      "price": 1980,
      "priceAfter25month": 2530,
    },
    "4066": {
      "capacity": 50,
      "terms": 1,
      "price": 3080,
      "priceAfter25month": 3850,
    },
    "4067": {
      "capacity": 100,
      "terms": 1,
      "price": 3300,
      "priceAfter25month": 4180,
    },
  },
  deviceOption: {
    "36": {
      "name": "丸ごと安心パック for ZEUS WiFi",
      "price": 0,
    },
    "37": {
      "name": "デジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞",
      "price": 0,
    },
    "38": {
      "name": "デジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞/プレミアム",
      "price": 0,
    },
    "27": {
      "name": "ZEUS WiFi CHARGE <br class='sp'>端末サポート（2年）",
      "price": 3300,
    },
  },
  device: {
    "42": {
      "name": "ZEUS WiFi CHARGE（端末/MR）",
      "price": 18000,
    },
    "52": {
      "name": "ZEUS WiFi CHARGE（端末/MR）",
      "price": 15000,
    },
  },
}

function prepaidForm() {
  // 選択中のプランID
  var plan_id = $('input[name="plan_id"]:checked').val();
  var is_subscription = (plan_id == 4065 || plan_id == 4066 || plan_id == 4067) ?  true : false;
  if (is_subscription) {
    var device_id = "52";
  } else {
    var device_id = "42";
  }

  if (plan_id === null || plan_id === "") {
    $('.plan-summary-data').hide();

    planUnSelectFlg = true;
  } else {
    // 選択中のプラン容量
    var plan_capacity = gSummaryPrices.plan_id[plan_id].capacity;

    // 選択中のプラン期間
    var plan_terms = gSummaryPrices.plan_id[plan_id].terms;

    // 選択中のプラン料金
    if (is_subscription) {
      var plan_price = Math.floor(gSummaryPrices.plan_id[plan_id].price);
      var plan_price_after25month = gSummaryPrices.plan_id[plan_id].priceAfter25month;
    } else {
      var plan_price = gSummaryPrices.plan_id[plan_id].price;
    }
    var plan_price_comma = String(plan_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    var plan_price_after25month_comma = String(plan_price_after25month).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

    $('.plan-summary-data').show();
    if (plan_terms == "") {
      $('.summary-group-countries-dataplans').html('<span></span>');
      planUnSelectFlg = true;
    } else {
      if (is_subscription) {
        $('.summary-group-countries-dataplans').html('<span>オートチャージプラン ' + plan_capacity + 'GB</span>');
      } else {
        $('.summary-group-countries-dataplans').html('<span>国内データプラン （' + plan_capacity + 'GB / ' + plan_terms + '日）</span>');
      }
      planUnSelectFlg = false;
    }
    if (is_subscription) {
      $('.plan-total-price').html('<span class="summary-price-text">' + plan_price_comma + '</span> 円 <span class="atten-sub">※1</span>');
      $('.monthly-total-price').html('<span class="summary-price-text">' + plan_price_comma + '</span> 円');
      $('.plan-price').html('<span class="summary-price-text">' + plan_price_comma + '</span> 円');
      $('.plan-price-after25month').html('<span class="summary-price-text">' + plan_price_after25month_comma + '</span> 円');
    } else {
      $('.plan-total-price').html('<span class="summary-price-text">' + plan_price_comma + '</span> 円');
    }
  }

  // 端末料金
  var devicePrice = gSummaryPrices.device[device_id].price;
  var device_price_comma = String(devicePrice * tax).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
  $('.plan-device-price .summary-price-text').text(device_price_comma);

  var insuranceOption = $("input[name=option_id_insurance]:checked").val();
  if (insuranceOption === undefined) {
    insuranceOption = 'false';
  }

  // オプションID
  var deviceOptionIds = $('input[name="selected_option[]"]:checked').map(function() {
    return $(this).val();
  }).get();

  if (insuranceOption != 'false' && insuranceOption != -1 && insuranceOption != '') {
    deviceOptionIds.push(insuranceOption);
  }
  let deviceOption_name, deviceOption_price, deviceOption_price_comma;
  let total_deviceOption_price = 0;
  $('.plan-summary-option.tanmatsu, .plan-summary-option.marugoto, .plan-summary-option.digital-life').hide();
  $('.sub-anshin-camp, .sub-dezilife-camp, .sub-dezisapo-camp').hide();
  $('#sub-contract').html('2');
  $('#contract-caution-number').html('2');

  if (is_subscription) {
    $('.device-total').html('<span class="summary-price-text">' + device_price_comma + '</span> 円');
  }

  var marugoflug = false;

  $.each(deviceOptionIds, function(index, deviceOption) {
    // オプション料金の表記
    if (deviceOption == '27') {
      // オプション名
      deviceOption_name = gSummaryPrices.deviceOption[deviceOption].name;

      // オプション料金
      deviceOption_price = gSummaryPrices.deviceOption[deviceOption].price;
      deviceOption_price_comma = String(deviceOption_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      total_deviceOption_price += deviceOption_price;

      // 端末代 + オプション料金
      deviceTotal_price = devicePrice * tax + deviceOption_price;
      deviceTotal_price_comma = String(deviceTotal_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

      if (is_subscription) {
        $('.plan-summary-option.tanmatsu').show();
        $('.tanmatsu .summary-group-option').html('<span>' + deviceOption_name + '</span>');
        $('.tanmatsu .option-total-price').parent('p').addClass('marginBt2');
        $('.tanmatsu .option-total-price').html('<span class="summary-price-text">' + deviceOption_price_comma + '</span> 円');
        $('.device-total').html('<span class="summary-price-text">' + deviceTotal_price_comma + '</span> 円');
      } else {
        $('.summary-group-option').html('<span>' + deviceOption_name + '</span>');
        $('.option-total-price').parent('p').addClass('marginBt2');
        $('.option-total-price').html('<span class="summary-price-text">' + deviceOption_price_comma + '</span> 円');
      }
      opUnSelectFlg = false;
    } else if (deviceOption == '36') {
      // オプション名
      deviceOption_name = gSummaryPrices.deviceOption[deviceOption].name;

      // オプション料金
      deviceOption_price = gSummaryPrices.deviceOption[deviceOption].price;
      deviceOption_price_comma = String(deviceOption_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

      $('.plan-summary-option.marugoto').show();
      $('.sub-anshin-camp').show();
      $('#sub-anshin').html('2');
      $('#sub-contract').html('3');
      $('#contract-caution-number').html('3');
      marugoflug = true;
      $('.marugoto .summary-group-option').html('<div><span>' + deviceOption_name + '</span></div>');
      $('.marugoto .summary-table-column-right').html('<p class="marginBt2"><span class="summary-price-text">' + deviceOption_price_comma + '</span> 円 <span class="atten-sub">※<span id="marugoto-caution-number">2</span></span></p>');
      opUnSelectFlg = false;
    } else if (deviceOption == '37' || deviceOption == '38') {
      // オプション名
      deviceOption_name = gSummaryPrices.deviceOption[deviceOption].name;

      // オプション料金
      deviceOption_price = gSummaryPrices.deviceOption[deviceOption].price;
      deviceOption_price_comma = String(deviceOption_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

      $('.plan-summary-option.digital-life').show();
      if(marugoflug){
        $('#sub-anshin').html('3');
        $('#sub-contract').html('4');
        $('#contract-caution-number').html('4');
      }else{
        $('#sub-contract').html('3');
        $('#contract-caution-number').html('3');
      }
      $('.digital-life .summary-group-option').html('<div><span>' + deviceOption_name + '</span></div>');
      $('.digital-life .summary-table-column-right').html('<p class="marginBt2"><span class="summary-price-text">' + deviceOption_price_comma + '</span> 円 <span class="atten-sub">※2</span></p>');
      $('#marugoto-caution-number').html('3');
      opUnSelectFlg = false;
    } else {
      if (!is_subscription) {
        $('.plan-summary-option').show();
        $('.summary-group-option').html('<span>つけない</span>');
        $('.option-total-price').parent('p').addClass('marginBt2');
        $('.option-total-price').html('<span class="summary-price-text">' + 0 + '</span> 円');
        opUnSelectFlg = true;
      }
    }
    if (deviceOption == '37') {
      $('.sub-dezilife-camp').show();
      $('.sub-dezilife-price').html('660');
    } else if (deviceOption == '38') {
      $('.sub-dezisapo-camp').show();
      $('.sub-dezilife-price').html('990');
    };
  });

  if (opUnSelectFlg) {
  // オプションつけない場合
    if (planUnSelectFlg) {
    // 端末のみの場合
      // 消費税の計算
      var all_price_tax = Math.floor((devicePrice) * taxOnly);
      all_price_tax_comma = String(all_price_tax).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      $('.summary-text-postage').html('<span class="summary-price-text">' + all_price_tax_comma + '</span> 円');

      // 合計金額の計算
      var overseas_your_all_price = Math.floor((devicePrice) * tax);
      var overseas_your_all_price_comma = String(overseas_your_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      $('.overseas-your-all-price').html(overseas_your_all_price_comma);
    } else {
    // 端末＋プランの場合
      // 消費税の計算
      var all_price_tax = Math.floor((plan_price + devicePrice) * taxOnly);
      all_price_tax_comma = String(all_price_tax).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      $('.summary-text-postage').html('<span class="summary-price-text">' + all_price_tax_comma + '</span> 円');

      // 合計金額の計算
      var overseas_your_all_price = Math.floor(plan_price + (devicePrice * tax));
      var overseas_your_all_price_comma = String(overseas_your_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      $('.overseas-your-all-price').html(overseas_your_all_price_comma);
    }
  } else {
  // オプションつける場合
    if (planUnSelectFlg) {
    // 端末のみの場合
      // 消費税の計算
      var all_price_tax = Math.floor((devicePrice + deviceOption_price) * taxOnly);
      all_price_tax_comma = String(all_price_tax).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      $('.summary-text-postage').html('<span class="summary-price-text">' + all_price_tax_comma + '</span> 円');

      // 合計金額の計算
      var overseas_your_all_price = Math.floor((devicePrice * tax) + deviceOption_price);
      var overseas_your_all_price_comma = String(overseas_your_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      $('.overseas-your-all-price').html(overseas_your_all_price_comma);
    } else {
    // 端末＋プランの場合
      // 消費税の計算
      var all_price_tax = Math.floor((plan_price + devicePrice + deviceOption_price) * taxOnly);
      all_price_tax_comma = String(all_price_tax).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      $('.summary-text-postage').html('<span class="summary-price-text">' + all_price_tax_comma + '</span> 円');
      // 合計金額の計算
      var overseas_your_all_price = Math.floor((plan_price + total_deviceOption_price) + (devicePrice * tax));
      var overseas_your_all_price_comma = String(overseas_your_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      $('.overseas-your-all-price').html(overseas_your_all_price_comma);
    }
  }
}

$(function() {
  $('.confirm-opt-popup-btn').on('click', function() {
    let input = $('input[name="selected_option[]"]:checked');
    let target = $(input).parents('.relief-option-ckeckbox').prev('.relief-item-select-area-box');
    $(target).removeClass("selected");
    $(target).addClass("selected");
  });

  // 25か月目以降のプラン料金設定（継続課金プラン契約内容確認画面）
  if(window.location.pathname.includes("/entry/prepaid/sub/confirm")) {
    const $plan_price = $('.plan-tax').text().replace(/\D+/g, '');
    let plan_price_after25month = '';
    // プラン料金ごとに25か月目以降のプラン料金設定
    if ($plan_price === '3300') plan_price_after25month = 4180;
    if ($plan_price === '3080') plan_price_after25month = 3850;
    if ($plan_price === '1980') plan_price_after25month = 2530;

    const plan_price_after25month_comma = String(plan_price_after25month).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.plan-price-after25month').text(plan_price_after25month_comma);
  }
});

// あなたのプランはこちら end /////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////// プラン・容量選択画面専用JS end //////////////////////////////////////////////////////////////////////////////

$(function() {
  // チェックボックスとアンケート必須
  $("input#leave-checkbox, .survey_answer").on('click change', function() {

    // 同意チェック
    var checked = $("input#leave-checkbox").prop("checked");

    // アンケートのチェック有無
    var checks_count = $(".survey_answer:checked").prop("checked");

    if ($('.prepaid-questionnaire').length) {
    // アンケートがあった場合
      // 同意チェック & アンケート回答に1つ以上チェックがあれば次画面へ進行可
      if (checked && checks_count) {
        $("div#entry_user_submit").removeClass(
          "decoration-button-area-disabled"
        );
        $("input#button-submit").removeAttr("disabled");
      } else {
        $("div#entry_user_submit").addClass("decoration-button-area-disabled");
        $("input#button-submit").attr("disabled", "disabled");
      }
    } else {
    // アンケートがなかった場合
      // 同意チェックがあれば次画面へ進行可
      if (checked) {
        $("div#entry_user_submit").removeClass(
          "decoration-button-area-disabled"
        );
        $("input#button-submit").removeAttr("disabled");
      } else {
        $("div#entry_user_submit").addClass("decoration-button-area-disabled");
        $("input#button-submit").attr("disabled", "disabled");
      }
    }
  });
});

function selectTopping2(target) {
  var checkBox = $(target).siblings(".topping-2-select-checkbox-area").find("input");
  checkBox.prop('checked', true);
  $(".topping-2-select-area").removeClass("selected");
  $(target).addClass("selected");
  prepaidForm();
}
function noselectTopping2(target) {
  var checkBox = $(target).siblings(".topping-2-select-checkbox-area").find("input");
  checkBox.prop('checked', false);
  $(".topping-2-select-area").addClass("selected");
  $(target).removeClass("selected");
  prepaidForm();
}

//////////////////////////////////////////////////////////////////////////////// 支払い方法選択画面専用JS start //////////////////////////////////////////////////////////////////////////////
function toggleUserPayment() {
  var selected_value = $('input[name="settlement_type"]:checked').val();
  //クレカ(SETTLEMENT_TYPE_VALUE_LIST[CREDIT_CARD])
  if (selected_value == "1") {
    $("#payment_select_creditcard").removeClass("mypage-user-info-detail-hidden");
    $("#payment_select_postpay").addClass("mypage-user-info-detail-hidden");
    $("#payment_select_maebarai").addClass("mypage-user-info-detail-hidden");
    $("#payment_select_paidy").addClass("mypage-user-info-detail-hidden");
    $(".form-entry-user-submit-creditcard").css('display','block');
    $(".form-entry-user-submit-postpay").css('display','none');
    $(".form-entry-user-submit-paidy").css('display','none');
    $("#payment_deferred_attention").hide();
  //atone(SETTLEMENT_TYPE_VALUE_LIST[ATONE])
  } else if (selected_value == "5") {
    $("#payment_select_maebarai").addClass("mypage-user-info-detail-hidden");
    $("#payment_select_creditcard").addClass("mypage-user-info-detail-hidden");
    $("#payment_select_postpay").removeClass("mypage-user-info-detail-hidden");
    $("#payment_select_paidy").addClass("mypage-user-info-detail-hidden");
    $(".form-entry-user-submit-creditcard").css('display','none');
    $(".form-entry-user-submit-postpay").css('display','block');
    $(".form-entry-user-submit-paidy").css('display','none');
    $("#payment_deferred_attention").show().html('<span>atone 翌月払い（コンビニ/口座振替）ご選択時の注意事項</span><span>atoneへお支払いいただく請求手数料として、190円(209円税込)がかかります。口座振替の場合は無料です。</span>');
  } else if (selected_value == "11") {//銀行振込（前払い）
    $("#payment_select_creditcard").addClass("mypage-user-info-detail-hidden");
    $("#payment_select_postpay").addClass("mypage-user-info-detail-hidden");
    $("#payment_select_maebarai").removeClass("mypage-user-info-detail-hidden");
    $("#payment_select_paidy").addClass("mypage-user-info-detail-hidden");
    $(".form-entry-user-submit-creditcard").css('display','block');
    $(".form-entry-user-submit-postpay").css('display','none');
    $(".form-entry-user-submit-paidy").css('display','none');
  } else if (selected_value == "13") {//あと払い（ペイディ）
    $("#payment_select_creditcard").addClass("mypage-user-info-detail-hidden");
    $("#payment_select_postpay").addClass("mypage-user-info-detail-hidden");
    $("#payment_select_maebarai").addClass("mypage-user-info-detail-hidden");
    $("#payment_select_paidy").removeClass("mypage-user-info-detail-hidden");
    $(".form-entry-user-submit-creditcard").css('display','none');
    $(".form-entry-user-submit-postpay").css('display','none');
    $(".form-entry-user-submit-paidy").css('display','block');
    $("#payment_deferred_attention").hide();
  }
}

$(function() {
  toggleUserPayment();
  $('input[name="settlement_type"]').change(function() {
    toggleUserPayment();
  });
})
//////////////////////////////////////////////////////////////////////////////// 支払い方法選択画面専用JS end //////////////////////////////////////////////////////////////////////////////
// 選択端末名変更 //
$(function() {
$('#detail-more-tab,.device-select').on('click', function() {
  if ($('.sub-select .prepaid-device-area.device-select:first-of-type').hasClass("selected")) {
    $('.flex-box-select:not(.your-plan) .plan-summary-table-row:first-of-type .summary-table-column-center.adjust').html('');
    $('.flex-box-select:not(.your-plan) .plan-summary-table-row:first-of-type .summary-table-column-center.adjust').html('ZEUS WiFi CHARGE MR1');
  }else if ($('.sub-select .prepaid-device-area.device-select:not(:nth-of-type(1))').hasClass("selected")) {
    $('.flex-box-select:not(.your-plan) .plan-summary-table-row:first-of-type .summary-table-column-center.adjust').html('ZEUS WiFi CHARGE H01（中古）');
  }
  });
});

$(function() {
  if ((window.location.pathname.includes("/entry/prepaid/sub/select"))||(window.location.pathname.includes("/entry/prepaid/sub/confirm"))){
    $('.add-contents').prepend('<p class="subhead">＼ 今なら最大2ヶ月無料！／</p>');
  }
  });
$(function() {
  if ($('.sub-select .relief-item-select-area-box,.sub-select #detail-more-tab').on('click', function() {
    setTimeout(function(){
      var optionmarugoto = $('.plan-summary-option.marugoto').css('display');
      var optiondigitallife = $('.plan-summary-option.digital-life').css('display');
      if (optionmarugoto == 'none' && optiondigitallife == 'none') {
      $('.plan-summary-table-row:has(.sub-select-opt)').hide();
      } else {
        $('.plan-summary-table-row:has(.sub-select-opt)').show();
      }
    },300);
  }));
});
