// 日付をYYYY-MM-DDの書式で返すメソッド
function formatDate(dt) {
  var y = dt.getFullYear();
  var m = ('00' + (dt.getMonth()+1)).slice(-2);
  var d = ('00' + dt.getDate()).slice(-2);
  return (y + '/' + m + '/' + d);
}

// 満了日を迎えたプランは非活性化する start ////////////////////////////////////////////////////////////////////////////////
$(function(){
  // 今日の日付
  var now = new Date();

  // 各プランの初期終了日
  var val_to_1 = $('input[name="rental_end_date_1"]').val();
  var val_to_2 = new Date();
  var val_to_3 = new Date();

  if ($('#overseas-current-2').length > 0) {
    val_to_2 = $('input[name="rental_end_date_2"]').val();
  }
  if ($('#overseas-current-3').length > 0) {
    val_to_3 = $('input[name="rental_end_date_3"]').val();
  }

  // 日付オブジェクトを生成
  var day_to_1 = new Date(val_to_1);
  var day_to_2 = new Date(val_to_2);
  var day_to_3 = new Date(val_to_3);

  // 各プランが満了している場合の処理
  if(now > (day_to_1 + 1)){
    $('input[name="rental_end_date_1"]').attr("disabled", true);
  }

  if(now > (day_to_2 + 1)){
    $('input[name="rental_end_date_2"]').attr("disabled", true);
  }

  if(now > (day_to_3 + 1)){
    $('input[name="rental_end_date_3"]').attr("disabled", true);
  }
});
// 満了日を迎えたプランは非活性化する end //////////////////////////////////////////////////////////////////////////////////

// カレンダー（bootstrap-datepicker）設定 start ////////////////////////////////////////////////////////////////////////////////
$(function(){

  // bootstrap-datepicker-1 終了日 start
  $('input[name="rental_end_date_1"]').datepicker({
    language:'ja', // 日本語化
    format: 'yyyy/mm/dd', // 日付表示をyyyy/mm/ddにフォーマット
    disableTouchKeyboard: false, // モバイル端末のキーボード無効化
    startDate: minDays1, // 最短利用開始日（初期表示）
    // endDate: maxDays, // 最長利用開始日（初期表示）
    todayHighlight: true, // 現在日付をハイライトする
    enableOnReadonly: true, // readonly属性が付いている場合はピッカーを表示しない
    autoclose: true, // 日付選択時に自動でピッカーを閉じる
    orientation: 'bottom right', // ピッカー表示位置（下）
    templates: {
    leftArrow: '＜', // ピッカーの一部に使用されるテンプレート
    rightArrow: '＞' // ピッカーの一部に使用されるテンプレート
    }
  })
  // bootstrap-datepicker-1 終了日 end

  // bootstrap-datepicker-2 終了日 start
  $('input[name="rental_end_date_2"]').datepicker({
    language:'ja', // 日本語化
    format: 'yyyy/mm/dd', // 日付表示をyyyy/mm/ddにフォーマット
    disableTouchKeyboard: false, // モバイル端末のキーボード無効化
    startDate: minDays2, // 最短利用開始日（初期表示）
    // endDate: maxDays, // 最長利用開始日（初期表示）
    todayHighlight: true, // 現在日付をハイライトする
    enableOnReadonly: true, // readonly属性が付いている場合はピッカーを表示しない
    autoclose: true, // 日付選択時に自動でピッカーを閉じる
    orientation: 'bottom right', // ピッカー表示位置（下）
    templates: {
    leftArrow: '＜', // ピッカーの一部に使用されるテンプレート
    rightArrow: '＞' // ピッカーの一部に使用されるテンプレート
    }
  })
  // bootstrap-datepicker-2 終了日 end

  // bootstrap-datepicker-3 終了日 start
  $('input[name="rental_end_date_3"]').datepicker({
    language:'ja', // 日本語化
    format: 'yyyy/mm/dd', // 日付表示をyyyy/mm/ddにフォーマット
    disableTouchKeyboard: false, // モバイル端末のキーボード無効化
    startDate: minDays3, // 最短利用開始日（初期表示）
    // endDate: maxDays, // 最長利用開始日（初期表示）
    todayHighlight: true, // 現在日付をハイライトする
    enableOnReadonly: true, // readonly属性が付いている場合はピッカーを表示しない
    autoclose: true, // 日付選択時に自動でピッカーを閉じる
    orientation: 'bottom right', // ピッカー表示位置（下）
    templates: {
    leftArrow: '＜', // ピッカーの一部に使用されるテンプレート
    rightArrow: '＞' // ピッカーの一部に使用されるテンプレート
    }
  })
  // bootstrap-datepicker-3 終了日 end

})
// カレンダー（bootstrap-datepicker）設定 end //////////////////////////////////////////////////////////////////////////////////

// 表示制御 start ////////////////////////////////////////////////////////////////////////////////////////////////
$('.input-sm,.topping-2-select-area,#device_option_true,.form-item-delivery,input#data-charge-agreement-checkbox').on('click change', function(){
  var val_from_1 = $('.overseas-current-start-1').text();
  var val_from_2 = $('.overseas-current-start-2').text();
  var val_from_3 = $('.overseas-current-start-3').text();
  var val_to_1 = $('input[name="rental_end_date_1"]').val();
  var val_to_2 = new Date();
  var val_to_3 = new Date();

  if ($('#overseas-current-2').length > 0) {
    val_to_2 = $('input[name="rental_end_date_2"]').val();
  }
  if ($('#overseas-current-3').length > 0) {
    val_to_3 = $('input[name="rental_end_date_3"]').val();
  }

  // 日付オブジェクトを生成
  var day_from_1 = new Date(val_from_1);
  var day_from_2 = new Date(val_from_2);
  var day_from_3 = new Date(val_from_3);
  var day_to_1 = new Date(val_to_1);
  var day_to_2 = new Date(val_to_2);
  var day_to_3 = new Date(val_to_3);

  // 日数の計算（変更前の日数）86,400,000ミリ秒＝1日（1000ミリ秒×60秒×60分×24時間×365日）
  before_term_1 = ((( endDate1 - day_from_1 ) / 86400000) + 1);
  before_term_2 = ((( endDate2 - day_from_2 ) / 86400000) + 1);
  before_term_3 = ((( endDate3 - day_from_3 ) / 86400000) + 1);

  // 日数の計算（選択画面表示用）86,400,000ミリ秒＝1日（1000ミリ秒×60秒×60分×24時間×365日）
  term_1 = ((( day_to_1 - day_from_1 ) / 86400000) + 1);
  term_2 = ((( day_to_2 - day_from_2 ) / 86400000) + 1);
  term_3 = ((( day_to_3 - day_from_3 ) / 86400000) + 1);

  // 日数の計算（差分）
  term_1_difference = term_1 - before_term_1;
  term_2_difference = term_2 - before_term_2;
  term_3_difference = term_3 - before_term_3;

  termDay_1 = '<span>渡航期間</span><span class="overseas-current-terms">' + term_1 + '</span><span>日間</span>';
  termDay_2 = '<span>渡航期間</span><span class="overseas-current-terms">' + term_2 + '</span><span>日間</span>';
  termDay_3 = '<span>渡航期間</span><span class="overseas-current-terms">' + term_3 + '</span><span>日間</span>';

  // 渡航期間表示用
  $('.input-group-range-text-1').html(termDay_1);
  $('.input-group-range-text-2').html(termDay_2);
  $('.input-group-range-text-3').html(termDay_3);

  // 変更内容はこちら用
  $('.overseas-existing-terms-1').html(term_1_difference);
  $('.overseas-existing-terms-2').html(term_2_difference);
  $('.overseas-existing-terms-3').html(term_3_difference);

  // 日数の計算（料金計算用）
  $('.input-group-range-text-hidden-1').html(term_1_difference);
  $('.input-group-range-text-hidden-2').html(term_2_difference);
  $('.input-group-range-text-hidden-3').html(term_3_difference);

  // 規約同意チェックボックス
  var boxes = $('input#data-charge-agreement-checkbox:checked');

  // 既存プランの料金（１ヶ国目）
  var overseasExisting_price_1_text = $('.pc .overseas-existing-price-1').text();
  var overseasExisting_price_1 = parseFloat(overseasExisting_price_1_text.replace(/,/g, ""));
  var overseasExisting_price_all_1 = overseasExisting_price_1 * term_1_difference;
  var overseasExisting_price_all_comma_1 = String(overseasExisting_price_all_1).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
  $('.overseas-existing-all-1').html(overseasExisting_price_all_comma_1);

  // 既存プランの料金（２ヶ国目）
  var overseasExisting_price_2_text = "";
  var overseasExisting_price_2 = 0;
  var overseasExisting_price_all_2 = 0;
  var overseasExisting_price_all_comma_2 = String(overseasExisting_price_all_2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
  if ($('#overseas-current-2').length > 0) {
    overseasExisting_price_2_text = $('.pc .overseas-existing-price-2').text();
    overseasExisting_price_2 = parseFloat(overseasExisting_price_2_text.replace(/,/g, ""));
    overseasExisting_price_all_2 = overseasExisting_price_2 * term_2_difference;
    overseasExisting_price_all_comma_2 = String(overseasExisting_price_all_2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.overseas-existing-all-2').html(overseasExisting_price_all_comma_2);
  }

  // 既存プランの料金（３ヶ国目）
  var overseasExisting_price_3_text = "";
  var overseasExisting_price_3 = 0;
  var overseasExisting_price_all_3 = 0;
  var overseasExisting_price_all_comma_3 = 0;
  if ($('#overseas-current-3').length > 0) {
    overseasExisting_price_3_text = $('.pc .overseas-existing-price-3').text();
    overseasExisting_price_3 = parseFloat(overseasExisting_price_3_text.replace(/,/g, ""));
    overseasExisting_price_all_3 = overseasExisting_price_3 * term_3_difference;
    overseasExisting_price_all_comma_3 = String(overseasExisting_price_all_3).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.overseas-existing-all-3').html(overseasExisting_price_all_comma_3);
  }
  
  // オプション期間の計算
  var OverseasStart_text = $('.overseas-all-start').text();
  var OverseasStart = new Date(OverseasStart_text);

  // プランの中で終了日が一番遅い日付
  var day_to_max = new Date(Math.max(day_to_1,day_to_2,day_to_3));
  var day_to_max_format = formatDate(day_to_max);

  // 全日程の期間
  var allTermDay = ((( day_to_max - OverseasStart ) / 86400000) + 1);

  // 全日程の期間（差分）
  var allTermDay_difference = allTermDay - allTermDay_first;

  // オプション料金の抽出
  var overseasOption_price_text = "";
  var overseasOption_price = 0;

  var country1 = $('.overseas-existing-country-1').text();
  var country2 = $('.overseas-existing-country-2').text();
  var country3 = $('.overseas-existing-country-3').text();

  var termsText1 = val_from_1 + ' ～ ' + val_to_1;
  var termsText2 = val_from_2 + ' ～ ' + val_to_2;
  var termsText3 = val_from_3 + ' ～ ' + val_to_3;

  $("p.popup-kaigai-text").html('');

  if(endDate1 < day_to_1){
    $('.overseas-existing-1').show();
    $("p.popup-kaigai-text").append(country1 + '<br>' + termsText1 + '<br>' + '<br>');
  }else{
    $('.overseas-existing-1').hide();
  }

  if(endDate2 < day_to_2){
    $('.overseas-existing-2').show();
    $("p.popup-kaigai-text").append(country2 + '<br>' + termsText2 + '<br>' + '<br>');
  }else{
    $('.overseas-existing-2').hide();
  }

  if(endDate3 < day_to_3){
    $('.overseas-existing-3').show();
    $("p.popup-kaigai-text").append(country3 + '<br>' + termsText3 + '<br>' + '<br>');
  }else{
    $('.overseas-existing-3').hide();
  }

  $("p.popup-kaigai-text br:last").remove();

  var existing_td = $(".existing:visible").children('.existing-td-top');
  var existing_top_td = $(".existing:visible").first().children('.existing-td-top');

  existing_td.text('');
  existing_top_td.text('利用国・地域');

  if ($('.overseas-option-price').length > 0){
    overseasOption_price_text = $('.overseas-option-price').text();
    overseasOption_price = parseFloat(overseasOption_price_text.replace(/,/g, ""));
  }

  if(endDate1 < day_to_1 || endDate2 < day_to_2 || endDate3 < day_to_3){
  // 全日程が延びた場合の計算
    var overseasOption_all_price = overseasOption_price * allTermDay_difference;
    var overseasOption_all_price_comma = String(overseasOption_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    var overseasOption_all_price_tax = overseasOption_all_price * 0.1;
    var overseasOption_all_price_tax_comma = String(overseasOption_all_price_tax).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

    $('.form-user-background').show();
    $('.overseas-all-end').text(day_to_max_format);
    $('.overseas-all-terms').text(allTermDay);
    $('.overseas-all-terms-difference').text(allTermDay_difference);
    $('.overseas-option-all-price').text(overseasOption_all_price_comma);
    $('.overseas-tax').text(overseasOption_all_price_tax_comma);

    // 合計金額の計算
    var overseas_all_price = overseasExisting_price_all_1 + overseasExisting_price_all_2 + overseasExisting_price_all_3 + overseasOption_all_price + overseasOption_all_price_tax;
    var overseas_all_price_comma = String(overseas_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.overseas-all-price').html('<span class="bold">' + overseas_all_price_comma + '</span> 円');
  }else{
  // 全日程が延びなかった場合の計算
    var overseasOption_all_price = overseasOption_price * allTermDay_first;
    var overseasOption_all_price_comma = String(overseasOption_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    var overseasOption_all_price_tax = overseasOption_all_price * 0.1;
    var overseasOption_all_price_tax_comma = String(overseasOption_all_price_tax).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

    $('.form-user-background').hide();

    $('.overseas-all-price').html('<span class="bold">0</span> 円');
  }

  if ((endDate1 < day_to_1 || endDate2 < day_to_2 || endDate3 < day_to_3) && boxes.length > 0) {
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
});
// 表示制御 end //////////////////////////////////////////////////////////////////////////////////////////////////