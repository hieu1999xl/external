var day_to3; // カレンダー日程間隔調整用変数を定義
var termDay; // 日数用変数を定義
var tax = 0.1; // 消費税を定義
var plan_end_date;

// 日付をYYYY-MM-DDの書式で返すメソッド
function formatDate(dt) {
  var y = dt.getFullYear();
  var m = ('00' + (dt.getMonth()+1)).slice(-2);
  var d = ('00' + dt.getDate()).slice(-2);
  return (y + '/' + m + '/' + d);
}

// 読み込み時選択された国の終了日を変更可能にする
$(function(){
  $('.input-sm').addClass('form-control-disabled'); //初期化
  $('.input-sm').attr('tabindex','-1'); //初期化
  var countryId = $('input[name="extension-country"]:checked').attr('target');
  var planId = $('input[name="extension-country"]:checked').attr('plan-id');
  var planType = $('input[name="extension-country"]:checked').attr('plan-type');

  $('input[name="rental_end_date_' + countryId + '"]').removeClass('form-control-disabled');
  $('input[name="rental_end_date_' + countryId + '"]').removeAttr('tabindex');
  $('input[name="plan_type"]').val(planType);
  $('input[name="extension_plan_id"]').val(planId);
  $('input[name="extension_contract_plan_id"]').val(countryId);
  $('input[name="start_date"]').val(eval('nextDate' + countryId + '_text'));
  $('input[name="end_date"]').val("");
});

// 選択された国の終了日を変更可能にする
$('input[name="extension-country"]').on('change', function(){
  $('.input-sm').addClass('form-control-disabled'); //初期化
  $('.input-sm').attr('tabindex','-1'); //初期化
  var countryId = $(this).attr('target');
  var planId = $(this).attr('plan-id');
  var planType = $(this).attr('plan-type');

  $('input[name="rental_end_date_' + countryId + '"]').removeClass('form-control-disabled');
  $('input[name="rental_end_date_' + countryId + '"]').removeAttr('tabindex');
  $('input[name="plan_type"]').val(planType);
  $('input[name="extension_plan_id"]').val(planId);
  $('input[name="extension_contract_plan_id"]').val(countryId);
  $('input[name="start_date"]').val(eval('nextDate' + countryId + '_text'));
  $('input[name="end_date"]').val("");
});

$('input.datepicker_end').on('change', function(){
  var countryId = $('input[name="extension-country"]:checked').attr('target');
  var plan_start_date = $('.pc .usage-start .overseas-current-start-' + countryId).text();
  plan_end_date = $(this).val();
  $('input[name="end_date"]').val(plan_end_date);
  var day_from = new Date(plan_start_date);
  var day_to = new Date(plan_end_date);
  var term = ((( day_to - day_from ) / 86400000) + 1);
  $('.usage-period .input-group-range-text-' + countryId).html(term + '<span> 日間</span>');
});

// 表示制御 start ////////////////////////////////////////////////////////////////////////////////////////////////
function overseasPeriodCalc() {
  var val_from_1 = $('input[name="start_date"]').val();
  var val_to_1 = plan_end_date;

  // 日付オブジェクトを生成
  var day_from_1 = new Date(val_from_1);
  var day_to_1 = new Date(val_to_1);

  var countryId = $('input[name="extension-country"]:checked').attr('target');
  var endDate1 = eval('endDate' + countryId);

  // 日数の計算（変更前の日数）86,400,000ミリ秒＝1日（1000ミリ秒×60秒×60分×24時間×365日）
  before_term_1 = ((( endDate1 - day_from_1 ) / 86400000) + 1);

  // 日数の計算（選択画面表示用）86,400,000ミリ秒＝1日（1000ミリ秒×60秒×60分×24時間×365日）
  term_1 = ((( day_to_1 - day_from_1 ) / 86400000) + 1);

  // 日数の計算（差分）
  term_1_difference = term_1 - before_term_1;

  termDay_1 = term_1 + '<span>日間</span>';

  // 渡航期間表示用
  $('.input-group-range-text-1').html(termDay_1);

  // 変更内容はこちら用
  $('.overseas-existing-terms-1').html(term_1_difference);

  // 日数の計算（料金計算用）
  $('.input-group-range-text-hidden-1').html(term_1_difference);

  // 送信用
  $('input[name="use_date"]').val(term_1_difference);

  // 規約同意チェックボックス
  var boxes = $('input#data-charge-agreement-checkbox:checked');

  // 既存プランの料金（１ヶ国目）
  var overseasExisting_price_1_text = $('input[name="extension-country"]:checked').attr('price');
  var overseasExisting_price_1 = parseFloat(overseasExisting_price_1_text.replace(/,/g, ""));
  var overseasExisting_price_all_1 = overseasExisting_price_1 * term_1_difference;
  var overseasExisting_price_all_comma_1 = String(overseasExisting_price_all_1).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
  var overseasExisting_price_1_comma = String(overseasExisting_price_1).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
  $('.overseas-existing-all-1').html(overseasExisting_price_all_comma_1);
  $('.overseas-existing-price-1').html(overseasExisting_price_1_comma);

  // 選択している国名を変更
  var countryId = $('input[name="extension-country"]:checked').attr('target');
  var country_name_1 = $('label#extension-country-name-' + countryId).attr('plan-name');
  var country_name_1_pc = '<span class="overseas-existing-country-1">' + country_name_1.replace(' ', '</span>（') + '）';
  var country_name_1_sp = country_name_1.replace(' ', '<br>（') + '）';
  $('.country-name-country-1').html(country_name_1_pc);
  $('.overseas-existing-1 th').html(country_name_1_sp);

  if(endDate1 < day_to_1){
    $('.overseas-existing-1').show();
  }else{
    $('.overseas-existing-1').hide();
  }

  var existing_td = $(".existing:visible").children('.existing-td-top');
  var existing_top_td = $(".existing:visible").first().children('.existing-td-top');

  existing_td.text('');
  existing_top_td.text('利用国・地域');

  if(endDate1 < day_to_1){
  // 延長するプランがある場合の計算
    $('.form-user-background').show();

    // 合計金額の計算
    var overseas_all_price = overseasExisting_price_all_1;
    var overseas_all_price_comma = String(overseas_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.overseas-all-price').html('<span class="bold">' + overseas_all_price_comma + '</span> 円');
  }else{
  // 延長するプランがない場合の計算
    $('.form-user-background').hide();

    $('.overseas-all-price').html('<span class="bold">0</span> 円');
  }

  if ((endDate1 < day_to_1) && boxes.length > 0) {
  // 延長するプランがある & 同意欄が選択されている場合
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

// 利用期間、同意欄を変更した時に実行
$('.input-sm,input#data-charge-agreement-checkbox').on('click change', function(){
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
