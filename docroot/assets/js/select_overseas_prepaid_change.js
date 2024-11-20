var existing_all_1 = 0;
var existing_all_2 = 0;
var existing_all_3 = 0;
var overseas_all_price = 0;

// プラン変更をする国を選択しているかどうかのフラグ
var flg_change = false;

// プラン変更の可否判定 start ////////////////////////////////////////////////////////////////////////////////
function changePlan1(area, country){
  var planIds = gCountriesPlanIdForPrepaid[area][country];

  if(plan1_id == planIds[0]){
    $('.overseas-change-dataplan-1').html('<span class="red-text">プラン変更不可のプランです</span><select name="plan_option[]" class="_dataplans1" hidden><option value="" selected></option></select>');
  }else if(plan1_id == planIds[2]){
    $('.overseas-change-dataplan-1').html('<span class="red-text">プラン変更不可のプランです</span><select name="plan_option[]" class="_dataplans1" hidden><option value="" selected></option></select>');
  }
};
// プラン変更の可否判定 end ////////////////////////////////////////////////////////////////////////////////

// 1ヶ国目のプラン変更による処理
function selectPlan1(area, country){
  var useDate = $('input[name="extension-country"]:checked').attr('use-date');
  var countryId = $('input[name="extension-country"]:checked').attr('target');
  if (country == '周遊') {
    // 周遊プラン選択時
    var plans = gCountriesForTour[area][country];
    var view_area = area + ' ';
  } else {
    // 通常の利用国の選択時
    var plans = gCountriesForPrepaid[area][country];
    var view_area = '';
  }
  var planType = $("input[name='plan_type']").val();
  var planNo = (planType == '14') ? 1 : 2;
  var planName = (planType == '14') ? '1GB' : '無制限';
  var existing_terms_1_text = useDate;
  var existing_terms_1 = parseFloat(existing_terms_1_text.replace(/,/g, ""));
  var plans2 = parseFloat(plans[planNo].replace(/,/g, ""));
  var plans2_difference = plans2 - eval('plan' + countryId + '_price');
  var plans2_difference_comma = String(plans2_difference).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
  existing_all_1 = plans2_difference * existing_terms_1;
  var existing_all_1_comma = String(existing_all_1).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
  overseas_all_price = existing_all_1;

  $('.form-user-background').show();
  $('.existing').hide();
  $('.overseas-existing-1').show();
  $(".overseas-existing-price-1").text(plans2_difference_comma);
  $(".overseas-existing-all-1").text(existing_all_1_comma);
  $(".overseas-existing-terms-1").text(useDate);
  $(".overseas-existing-country").html('<span class="overseas-existing-country-1">' + view_area + country + '</span>（' + planName + '/日プラン）');
};

$(document).ready(function() {

  // @TODO フロントチームへ ↓変更できるプランだけ出すので、とりあえずはいらなさそうだと思います。
  // プラン変更の可否判定処理実行
  // changePlan1(area1, country1);
  // if ($('#overseas-current-2').length > 0){
  //   changePlan2(area2, country2);
  // }
  // if ($('#overseas-current-3').length > 0){
  //   changePlan3(area3, country3);
  // }

  // 海外データ 容量変更の利用国・プラン・合計金額の表示設定/制御
  function checkedExtensionCountry() {
    var countryId = $('input[name="extension-country"]:checked').attr('target');

    $('.plan-type').prop('disabled', true);
    $('._dataplans' + countryId).prop('disabled', false);
    $('input[name="old_plan_type"]').val($('input[name="extension-country"]:checked').attr('plan-type'));
    $('input[name="plan_type"]').val($('._dataplans' + countryId).val());
    $('input[name="change_plan_id"]').val($('input[name="extension-country"]:checked').attr('plan-id'));
    $('input[name="change_contract_plan_id"]').val(countryId);
    $('input[name="start_date"]').val(eval('plan' + countryId + '_start_date'));
    $('input[name="end_date"]').val(eval('plan' + countryId + '_end_date'));
    $('input[name="use_date"]').val($('input[name="extension-country"]:checked').attr('use-date'));
    $('input[name="continent_name"]').val(eval('area' + countryId));
    $('input[name="country_name"]').val(eval('country' + countryId));

    if($("input[name='extension-country']:checked").attr('id') == "extension-country" + countryId){
      selectPlan1(eval('area' + countryId), eval('country' + countryId));
      flg_change = true;
    }else{
      flg_change = false;
      $('.form-user-background').hide();
    }

    // 合計金額の計算
    var overseas_all_price_comma = String(overseas_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    if(overseas_all_price == 0){
      $(".overseas-all-price").html('<span class="bold">0</span> 円');
    }else{
      $('.overseas-all-price').html('<span class="bold">' + overseas_all_price_comma + '</span> 円');
    }

    var existing_td = $(".existing:visible").children('.existing-td-top');
    var existing_top_td = $(".existing:visible").first().children('.existing-td-top');

    existing_td.text('');
    existing_top_td.text('利用国・地域');

    var boxes = $('input#data-charge-agreement-checkbox:checked');

    if (flg_change && boxes.length > 0) {
    // 追加の渡航期間 & 利用国・プラン & 同意欄が選択されている場合
      // 決定ボタンをactiveにする
      $("div#overseas_submit_button").removeClass(
        "decoration-button-area-disabled"
      );
    } else {
    // そうでない場合
      // 決定ボタンをinactiveにする
      $("div#overseas_submit_button").addClass("decoration-button-area-disabled");
    }
  }

  // エリア、国、プラン、同意欄を変更した時に実行
  $("input[name='extension-country'], input#data-charge-agreement-checkbox").on('change, click', function(){
    checkedExtensionCountry();
  });
  $('.extension-country-wrapper.js-input-radio').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
        checkedExtensionCountry();
      }
  });
  $('.mypage-agreement-checkbox.js-confirm-box').keyup(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
        checkedExtensionCountry();
      }
  });

  $('.plan-type').on('change', function(){
    var countryId = $('input[name="extension-country"]:checked').attr('target');
    $("input[name='plan_type']").val($(this).val());
    selectPlan1(eval('area' + countryId), eval('country' + countryId));
  });
});
