var day_to3; // カレンダー日程間隔調整用変数を定義
var termDay; // 日数用変数を定義
var tax = 0.1; // 消費税を定義

// カレンダー（bootstrap-datepicker）設定 start ////////////////////////////////////////////////////////////////////////////////
// 休日はbkHolidaysから取得
$(function(){
  // bootstrap-datepicker 開始日 start
  $('input[name="rental_start_date"]').datepicker({

    language:'ja', // 日本語化
    format: 'yyyy/mm/dd', // 日付表示をyyyy/mm/ddにフォーマット
    disableTouchKeyboard: false, // モバイル端末のキーボード無効化
    startDate: minDays, // 最短利用開始日（初期表示）
    endDate: maxDays, // 最長利用開始日（初期表示）
    todayHighlight: true, // 現在日付をハイライトする
    enableOnReadonly: true, // readonly属性が付いている場合はピッカーを表示しない
    autoclose: true, // 日付選択時に自動でピッカーを閉じる
    orientation: 'bottom', // ピッカー表示位置（下）
    templates: {
    leftArrow: '＜', // ピッカーの一部に使用されるテンプレート
    rightArrow: '＞' // ピッカーの一部に使用されるテンプレート
    },

    // datepickerオプション以外の処理（休日反映）start
    beforeShowDay: function(date){

      for (var i = 0; i < bkHolidays.length; i++) {
        var holiday = new Date(Date.parse(bkHolidays[i]));
        if (holiday.getYear() == date.getYear() &&
          holiday.getMonth() == date.getMonth() &&
          holiday.getDate() == date.getDate()) {
          return {
            classes: 'holiday'
          };
        }
      }
    // datepickerオプション以外の処理（休日反映）end
    },
  })
  // 開始日を変更した場合の処理 start
  .on('changeDate', function (selected) {
    var val_from = $('input[name="rental_start_date"]').val();
    $('input[name="rental_end_date"]').datepicker('setStartDate', val_from);
  });
  // 開始日を変更した場合の処理 end
  // bootstrap-datepicker 開始日 end

  // bootstrap-datepicker 終了日 start
  $('input[name="rental_end_date"]').datepicker({

    language:'ja', // 日本語化
    format: 'yyyy/mm/dd', // 日付表示をyyyy/mm/ddにフォーマット
    disableTouchKeyboard: false, // モバイル端末のキーボード無効化
    startDate: minDays, // 最短利用開始日（初期表示）
    todayHighlight: true, // 現在日付をハイライトする
    enableOnReadonly: true, // readonly属性が付いている場合はピッカーを表示しない
    autoclose: true, // 日付選択時に自動でピッカーを閉じる
    orientation: 'bottom right', // ピッカー表示位置（下）
    templates: {
    leftArrow: '＜', // ピッカーの一部に使用されるテンプレート
    rightArrow: '＞' // ピッカーの一部に使用されるテンプレート
    },

    // datepickerオプション以外の処理（休日反映）start
    beforeShowDay: function(date){

      for (var i = 0; i < bkHolidays.length; i++) {
        var holiday = new Date(Date.parse(bkHolidays[i]));
        if (holiday.getYear() == date.getYear() &&
          holiday.getMonth() == date.getMonth() &&
          holiday.getDate() == date.getDate()) {
          return {
            classes: 'holiday'
          };
        }
      }
    },
    // datepickerオプション以外の処理（休日反映）end
  })
  // 終了日を変更した場合の処理 start
  .on('changeDate', function (selected) {
    // 選択したご利用終了日 start
    var val_end = $('input[name="rental_end_date"]').val();
    // 選択したご利用終了日 end

    // 選択したご利用終了日（ミリ秒）start
    var new_max_select_day = new Date(val_end);
    var max_select_day = new_max_select_day.getTime();
    // 選択したご利用終了日（ミリ秒）end

    // 終了日を変更した場合の開始日の選択可能日制御 start
    if(maxDaysTime > max_select_day){
      $('input[name="rental_start_date"]').datepicker('setStartDate', minDays);
      $('input[name="rental_start_date"]').datepicker('setEndDate', val_end);
    }else{
      $('input[name="rental_start_date"]').datepicker('setStartDate', minDays);
      $('input[name="rental_start_date"]').datepicker('setEndDate', maxDays);
    }
    // 終了日を変更した場合の開始日の選択可能日制御 end
  });
  // 終了日を変更した場合の処理 end
  // bootstrap-datepicker 終了日 end
})
// カレンダー（bootstrap-datepicker）設定 end //////////////////////////////////////////////////////////////////////////////////

// 国/周遊の切替 start ////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {
  $('[name="travel_type"]:radio').change( function() {
    if($('[id=travel-type-single]').prop('checked')){
      $('#select-continent-plan').fadeOut();
      $('#select-country-plan').fadeIn();
      $('.another-country').fadeIn();
      $('#country-plan-text').text('人気渡航先から選ぶ');
      $('input[name="plan_id_tour"]').prop("checked", false);
      $("._dataplans").attr("disabled", true);
      $("._dataplans").html("<option disabled selected>プランを選択</option>"); // 初期化
      $(".form-user-background").hide(); // 変更内容を非表示
      if(flg_country_select){
        $(".overseas-plan-section").removeClass('section-hide');
      }
    } else if ($('[id=travel-type-tour]').prop('checked')) {
      $('#select-country-plan').fadeOut();
      $('#select-continent-plan').fadeIn();
      $(".overseas-plan-section").addClass('section-hide');
      $('.another-country').fadeOut();
      $('#country-plan-text').text('周遊先から選ぶ');
      $('input[name="country_plan"]').prop("checked", false);
      $("._dataplans").attr("disabled", true);
      $("._dataplans").html("<option disabled selected>プランを選択</option>"); // 初期化
      $(".form-user-background").hide(); // 変更内容を非表示
    }
  });
});
// 国/周遊の切替 end ////////////////////////////////////////////////////////////////////////////////////////////////

// 国の制御 start ////////////////////////////////////////////////////////////////////////////////////////////////
$('input[name="country_plan"]').on('change', function(){
  var country_plan = $(this).val();
  var country_plan_area = $(this).attr("alt");

  $('select[name="_areas"]').val(country_plan_area).change();
  $('select[name="_countries"]').val(country_plan).change();
});

$('input[name="_areas"],select[name="_countries"]').on('change', function(){
  var country_plan = $('input[name="country_plan"]:checked').val();
  var country_plan_select = $('select[name="_countries"]').val();

  if(country_plan == country_plan_select){
    return false;
  } else {
    $('input[name="country_plan"]').prop("checked", false);
  }
});
// 国の制御 end //////////////////////////////////////////////////////////////////////////////////////////////////

$('.input[name="country_plan"],select[name="_areas"],select[name="_countries"]').on('change', function(){
  // 変更内容を非表示
  $(".form-user-background").hide();
});

// 表示制御 start ////////////////////////////////////////////////////////////////////////////////////////////////
function overseasPeriodCalc() {
  var val_from = $('input[name="rental_start_date"]').val();
  var val_to = $('input[name="rental_end_date"]').val();
  // plan_type設定
  var plan_type = $('select[name="plan_option[]"] option:selected').attr('plan_type');
  $('input[name="plan_type"]').val(plan_type);

  // 開始日・終了日ともに選択されている場合の処理 start
  if(val_from != "" && val_to != "" && val_from != " " && val_to != " "){
    // 日付オブジェクトを生成
    var day_from = new Date(val_from);
    var day_to = new Date(val_to);
    var use_date = ((day_to - day_from) / 86400000) + 1;

    // 日数の計算（選択画面表示用）86,400,000ミリ秒＝1日（1000ミリ秒×60秒×60分×24時間×365日）
    termDay = use_date + '<span>日間</span>';
    $('.input-group-range-text').html(termDay);
    $('input[name="use_date"]').val(use_date);

    // 日数の計算（料金計算用）
    termDayHidden = use_date;
    $('.input-group-range-text-hidden').html(termDayHidden);

    var selectedDataPlan = $("._dataplans option:selected");
    var place = 0;
    var boxes = $('input#data-charge-agreement-checkbox:checked');
    var dataplan = $("._dataplans option:selected").text();

    if (selectedDataPlan.length > 0 && dataplan !== "プランを選択") {
    // 追加の渡航期間 & プランが選択されている場合
      var dataplanIndex = $("._dataplans").prop("selectedIndex") - 1;
      var area = $("._areas").val();
      var country = $("._countries").val();
      var forTourFlg = (country === undefined) || ( country === null)
      var plans = forTourFlg ? gCountriesForTour[area]['周遊'] : gCountriesForPrepaid[area][country];

      var place = parseFloat(plans[dataplanIndex].replace(/,/g, ""));

      // 追加プランの料金
      var OverseasPrice_comma = String(place).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'); //←←←←←←←←←←←←←←←←←←←←←←←←←バックエンドから【料金】の値もらったら"800"のところに差し替え
      var OverseasPrice_all = place * use_date; //←←←←←←←←←←←←←←←←←←←←←←←←←バックエンドから【料金】の値もらったら"800"のところに差し替え
      var OverseasPrice_all_comma = String(OverseasPrice_all).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

       // 変更内容を表示する
      $(".form-user-background").show();

      // 渡航期間を計算する
      var OverseasTerms = use_date;

      // 渡航日
      $(".add-plan-days").html(val_from + " ～ " + val_to + "<span class='pc'>（" + OverseasTerms + "日間）</span>");
      $(".add-terms").html(OverseasTerms);

      // 追加プラン名
      // 周遊の場合はエリア名、単国の場合は国名を表示する
      var placeName = forTourFlg ? ((area === '全世界' && '世界周遊') || (area + '周遊')) : country
      $(".add-plan").html(placeName + "（" + dataplan + "）");

      // 追加プランの料金計算
      $(".add-price").html(OverseasPrice_comma + " 円 ✕ " + use_date + " 日");
      $(".add-price-show").removeClass("add-hide");
      $(".add-all").html(OverseasPrice_all_comma);

      // 合計金額の計算
      $('.overseas-all-price').html('<span class="bold">' + OverseasPrice_all_comma + '</span> 円');
    } else {
    // そうでない場合
      // 変更内容を非表示、合計金額をリセットする
      $(".form-user-background").hide();
      $(".overseas-all-price").html('<span class="bold">0</span> 円');

      // 追加プラン料金欄の非表示
      $(".add-price").html("");
      $(".add-all").html("");
    }

    if (selectedDataPlan.length > 0 && dataplan !== "プランを選択" && boxes.length > 0) {
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

  }else{
  }
  // 開始日・終了日ともに選択されている場合の処理 end
}

// 利用期間、国、プラン、同意欄を変更した時に実行
$('.input-sm,select[name="plan_option[]"],#data-charge-agreement-checkbox').on('click change', function(){
  overseasPeriodCalc();
});
$('.mypage-agreement-checkbox.js-confirm-box').keyup(function(event) {
  if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
    overseasPeriodCalc();
    }
});
// 表示制御 end //////////////////////////////////////////////////////////////////////////////////////////////////

// GETパラメータを個別に取得する
function get_getParam(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}
