// 事前配送オプションが利用可能な日付かどうかの初期フラグはfalse
var flg_delivery_day = false;

// 受取方法を選択の表示切替 start //////////////////////////////////////////////////////////////////////////////////////////////////

const $select_airport = $('select#select-airport');
const $select_store = $('select#select-store');

// 宅配受取を選択
$('.relief-item-select-delivery').click(() => {
  $(this).addClass('selected');
  $('.relief-item-select-airport').removeClass('selected');
  $('.overseas-select-place-contents.delivery').removeClass('zipcode-hidden');
  $('.overseas-select-place-contents.airport').hide();
  $('.delivery-area-caution-airport').hide();
  $(".transit-area-caution").hide();
  // 空港受取の入力値をリセット
  // 宅配受取の入力値をリセット
  $('input#zipcode_1').val('');
  $('input#zipcode_2').val('');
  $select_airport.val(0);
  $select_store.val(0);
  close_period_form();
  // 合計金額内の表示設定
  $('.receiving-method').html('宅配');
  $('.send-airport').hide();
  $('#rental-delivery-date').show();
  $('#rental-trip-date').css('border-top', 'none');
  // 合計金額を閉じる
  if (!($('.your-plan-area').hasClass('summary-close'))) {
    $('.your-plan-area').addClass('summary-close');
    $('#detail-more-tab').removeClass('your-plan-open');
    $('.detail-more').toggle();
  }
  /* ウィンドウサイズ768以上の場合のみ配送予定日の上にボーダーを追加 */
  if (window.matchMedia('(min-width: 768px)').matches) {
    $('#rental-delivery-date').css('border-top', '1px solid #909090');
  }
});

// 空港受取を選択
$('.relief-item-select-airport').click(() => {
  $(this).addClass('selected');
  $('.relief-item-select-delivery').removeClass('selected');
  $('.overseas-select-place-contents.delivery').addClass('zipcode-hidden');
  $('.overseas-select-place-contents.airport').show();
  // 宅配受取の入力値をリセット
  $('input#zipcode_1').val('');
  $('input#zipcode_2').val('');
  close_period_form();
  if ($('.validator-error-span').length) $('.validator-error-span').css('display', 'none');
  // 合計金額内の表記設定
  $('.receiving-method').html('空港');
  $('.send-airport').show();
  $('#rental-delivery-date').hide();
  $('#rental-trip-date').css('border-top', '1px solid #909090');
  $('#rental-delivery-date').css('border-top', 'none');
  // 事前配送オプションを選択できないようにする
  flg_delivery_day = false;
  $(".delivery-area").addClass("delivery-disabled");
  $("#support_option_03").prop("checked", false);
  $("#delivery_order_time").attr('disabled', false);
  $(".relief-item-select-area3").removeClass("selected");
  $('input[name="prior_delivery_date"]').val('');
  $('input[name="prior_delivery_date"]').attr('disabled', true);
  $(".delivery-mandatory").hide();
  $(".js-delivery-text").hide();
  $(".delivery-area-caution").hide();
  $(".transit-area-caution").hide();
  // 合計金額を閉じる
  if (!($('.your-plan-area').hasClass('summary-close'))) {
    $('.your-plan-area').addClass('summary-close');
    $('#detail-more-tab').removeClass('your-plan-open');
    $('.detail-more').toggle();
  }
});

// 空港を選択したときの処理
$('#select-airport').on('change', function () {
  // 選択した空港名を取得
  var airport_select = $('#select-airport').val();

  //【受取場所を選択】を選択できるようにする
  $('#select-store').removeClass('not-selected-airport');

  // 選択した空港にある受取場所のみ表示
  $('#select-store option').each(function(){
    var airport = $(this).data('airport');
    var wrap = $(this).parents().attr("class");
    if(airport !== airport_select && ($(this).text() !== '受取場所を選択')){
      // optionタグをspanで囲い非表示にする
      if(wrap !== "wrap"){
        $(this).wrap("<span class='wrap'>");
      }
    }else{
      // spanタグ削除
      if(wrap === "wrap"){
        $(this).unwrap();
      }
    }
    // ローソン Ｓ中部国際空港店は非表示にする
    $('option[data-address="愛知県常滑市セントレア１‐２"]').wrap("<span class='wrap'>");
  })

  // 表記をリセット
  var not_selected_store = $('#select-store option:first-child').val(); //【受取場所を選択】の未選択時のテキストを取得する
  $('#select-store option:first-child').show();
  $('#select-store').val(not_selected_store);
  $('#selected-convenience').html('');
  $('.send-airport-area').html('');
  $('.send-airport-store').html('');
  $('#selected-convenience-open').html('');
});

// 空港・受け取り場所選択切り替え時
$('select.overseas-select-place-select-airport').change(() => {
  if ($select_airport.val() && $select_store.val()) {
    open_period_form();
    // 選択した空港名
    var selected_airport = $('#select-airport option:selected').text();
    var selected_store = $select_store.children(':selected').text();
    // 選択した店舗の場所名（受取場所が空だった場合は住所を表示する）
    var location = $select_store.children(':selected').data('location');
    var address = $select_store.children(':selected').data('address');
    var selected_store_location = location === '' ? address : location;
    // 選択した空港のオープン時間
    var selected_store_open = $select_store.children(':selected').data('open');
    // 選択した空港の郵便番号上３桁
    var selected_store_zipcode1 = $select_store.children(':selected').data('zipcode1');
    // 選択した空港の郵便番号上３桁
    var selected_store_zipcode2 = $select_store.children(':selected').data('zipcode2');
    // 受取場所を設定
    $('#selected-convenience').html(selected_store_location);
    // 合計金額内の表記設定
    $('.send-airport-area').html(selected_airport);
    $('.send-airport-store').html(selected_store);
    // オープン時間を設定
    $('#selected-convenience-open').html(selected_store_open);
    // 郵便番号を設定（最短利用開始日取得）
    $('#zipcode_1').val(selected_store_zipcode1).change();
    $('#zipcode_2').val(selected_store_zipcode2).change();
    $('#search_btn').click();
    $('.delivery-area-caution-airport').show();
  } else {
    close_period_form();
  }
})

// 受取方法を選択の表示切替 end //////////////////////////////////////////////////////////////////////////////////////////////////
var day_to3; // カレンダー日程間隔調整用変数を定義
var termDay; // 日数用変数を定義
var tax = 0.1; // 消費税を定義
var flg_inherit_parameters = false;

// 日付をYYYY/MM/DDの書式で返すメソッド
function formatDate(dt) {
  var y = dt.getFullYear();
  var m = ('00' + (dt.getMonth()+1)).slice(-2);
  var d = ('00' + dt.getDate()).slice(-2);
  return (y + '/' + m + '/' + d);
}

// 郵便番号で海外レンタルプラン対象地域を検索 start //////////////////////////////////////////////////////////////////////////////
// ユーザビリティ関連 start
// 郵便番号 入力したら次へ start
function next_post_code(){
  zipcode_length = $('#zipcode_1').val().length;
  if(zipcode_length == 3){
    $('#zipcode_2').focus();
  }
  return;
}
// 郵便番号 入力したら次へ end

// 郵便番号 maxLengthの設定（type="number"の場合）start
function sliceMaxLength(elem, maxLength) {
  elem.value = elem.value.slice(0, maxLength);
}
// 郵便番号 maxLengthの設定（type="number"の場合）end

// 郵便番号以下のフォームを展開
function open_period_form(){
  // 郵便番号以外のフォーム表示
  $('#usage_period_block, #purchase-overseas-plan, #anshin_option, #rental_entry_button, #your_plan, .appeal-area').removeClass('overseas-form-active');
}

// 郵便番号以下のフォームを閉じる
function close_period_form(){
  // 郵便番号以外のフォーム非表示
  $('#usage_period_block, #purchase-overseas-plan, #anshin_option, #rental_entry_button, #your_plan, .appeal-area').addClass('overseas-form-active');
}
// ユーザビリティ関連 end
// 郵便番号で海外レンタルプラン対象地域を検索 end //////////////////////////////////////////////////////////////////////////////

// 海外レンタルプラン　利用可能地域を郵便番号から判別（検索した場合）start
$(function () {
  //検索ボタンをクリックされたときに実行　　　　　　///////////////////////////////////←　Phase1でバックエンドが実装してくれる（郵便番号によって郵送可能地域かどうかの判別をする）
  $("#search_btn").click(function () {

    // 各入力値取得
    // 郵便番号(3けた)
    var post_1 = $('#zipcode_1').val();
    // 郵便番号(4けた)
    var post_2 = $('#zipcode_2').val();

    var param_before = $('#zipcode_1').val() +  $('#zipcode_2').val();
    //入力値をセット
    var param = {zipcode: param_before}
    //zipcloudのAPIのURL
    var send_url = "https://zipcloud.ibsnet.co.jp/api/search";
    // 対象外都道府県
    const prefectures = [];
    // 郵便番号に対応した配送日数から最短の到着日数を再計算する
    var delivery_info = get_delivery_info(post_1, post_2);
    minDaysNumber = delivery_info.min_days;
    minDays = '+' + delivery_info.min_days + 'd';
    $('input[name="rental_start_date"]').datepicker('setEndDate', maxDays);
    nowTimeMin = new Date();
    nowTimeMin.setDate(nowTimeMin.getDate() + minDaysNumber);
    nowTimeMin_format = formatDate(nowTimeMin);
    bkHolidays = delivery_info.holidays;
    // 選択できる最短の渡航日も変更する
    $('input[name="rental_start_date"]').datepicker('setStartDate', delivery_info.set_start_date);
    $('input[name="rental_end_date"]').datepicker('setStartDate', delivery_info.set_start_date);
    option_from_area = delivery_info.prior_delivery_min_days; // 事前配送サービスの最速配送日
    option_from_area_comp = new Date(option_from_area); // 事前配送サービスの最速配送日
    var delivery_days = delivery_info.delivery_days; // 発送にかかる日数

    option_from_times_area = new Date(option_from_area).getDate();

    if($("#zipcode_1").val().length == 0 && $("#zipcode_2").val().length == 0){
      // 郵便番号が空かどうか判定
      $('#zipcode-id-error-message').html('<label id="rental_zipcode-error" class="validator-error" for="rental_zipcode">' + '<span class="validator-error-span">' + '郵便番号を入力してください。' + '</span>' + '</label>');
      close_period_form();
      return false;
    }else if($("#zipcode_1").val().length != 3 || $("#zipcode_2").val().length != 4){
      // 郵便番号の形式（桁数）が正しいか判定
      $('#zipcode-id-error-message').html('<label id="rental_zipcode-error" class="validator-error" for="rental_zipcode">' + '<span class="validator-error-span">' + '郵便番号の桁数が正しくありません。' + '</span>' + '</label>');
      close_period_form();
      return false;
    }else{
      $('#zip_result').html('<div class="loading-mark-area"><img src="/assets/img/loading-mark.gif" class="loading-mark"></div>');
      $('#zip_result_lp').html('<div class="loading-mark-area"><img src="/assets/img/loading-mark.gif" class="loading-mark"></div>');
      $('#zip_result_lp_sp').html('<div class="loading-mark-area"><img src="/assets/img/loading-mark.gif" class="loading-mark"></div>');
    }

    $.ajax({
      type: "GET",
      cache: false,
      data: param,
      url: send_url,
      dataType: "jsonp",
      success: function (res) {
        //結果によって処理を振り分ける
        if (res.status == 200 && res.results != null) {
          //処理が成功したとき
          //該当する住所を表示
          var html = '';
          for (var i = 0; i < res.results.length; i++) {
            var result = res.results[i];
            html = result.address1;
          }
          if(prefectures.includes(result.address1) || delivery_days >= 4){
            // 配送地域外の場合
            $('#zipcode-id-error-message').html('<label id="rental_zipcode-error" class="validator-error" for="rental_zipcode">' + '<span class="validator-error-span">' + '離島などの一部地域は<br class="sp">配送対応を行っておりません。' + '</span>' + '</label>');
            close_period_form();
            // LP 料金シミュレーション（配送地域外だった場合の文言表示）
            $('#zip_result_lp').html('<div class="area-mark-box out"><div class="area-mark"><span class="result-mark">－</span><span class="selected-prefecture">' + html + '</span></div><div class="area-mark-text"><span class="validator-error-span">配送地域外です。今後拡大予定です。</span></div></div>');
            $('#zip_result_lp_sp').html('<div class="area-mark-box out"><div class="area-mark"><span class="result-mark">－</span><span class="selected-prefecture">' + html + '</span></div><div class="area-mark-text"><span class="validator-error-span">配送地域外です。<br>今後拡大予定です。</span></div></div>');
            $('.mypage-user-info-detail').addClass("mypage-user-info-detail-hidden");
            $('.delivery-first-title-area').addClass("mypage-user-info-detail-hidden");
            $('.save_delivery').addClass("mypage-user-info-detail-hidden");
            $('#zip_result').html('');
          }else{
            // 配送地域の場合
            $('#zip_result').html('<div class="nowTimeMin-text">最短の利用開始日<span class="sp">：</span><span class="nowTimeMin-day">' + nowTimeMin_format + '</span></div>');
            open_period_form();
            // LP 料金シミュレーション（配送地域だった場合の文言表示）
            $('#zip_result_lp').html('<div class="area-mark-box in"><div class="area-mark"><span class="result-mark"></span><span class="selected-prefecture">' + html + '</span></div><div class="area-mark-text"><span class="validator-error-span">配送地域です。</span></div></div>');
            $('#zip_result_lp_sp').html('<div class="area-mark-box in"><div class="area-mark"><span class="result-mark"></span><span class="selected-prefecture">' + html + '</span></div><div class="area-mark-text"><span class="validator-error-span">配送地域です。</span></div></div>');
            $('.mypage-user-info-detail').removeClass("mypage-user-info-detail-hidden");
            $('.delivery-first-title-area').removeClass("mypage-user-info-detail-hidden");
            $('.save_delivery').removeClass("mypage-user-info-detail-hidden");

            if(!flg_inherit_parameters){
              $('input[name="rental_start_date"]').datepicker('show');
            }
          }
        } else {
          // 郵便番号が見つからない場合
          $('#zipcode-id-error-message').html('<label id="rental_zipcode-error" class="validator-error" for="rental_zipcode">' + '<span class="validator-error-span">' + '郵便番号が見つかりません。' + '</span>' + '</label>');
          close_period_form();
          // LP 料金シミュレーション（郵便番号が見つからない場合の文言表示）
          // 郵便番号を3+4=7桁にする（郵便番号検索APIで読み取れる形にする）start
          var rental_zipcode_1 = $("#zipcode_1").val();
          var rental_zipcode_2 = $("#zipcode_2").val();
          var rental_zipcode = rental_zipcode_1 + rental_zipcode_2;
          // 郵便番号を3+4=7桁にする（郵便番号検索APIで読み取れる形にする）end
          if(rental_zipcode.length == 7){
            $('#zip_result_lp').html('<span class="rental-lp-validator-error">' + '郵便番号が見つかりません。' + '</span>');
            $('#zip_result_lp_sp').html('<span class="rental-lp-validator-error">' + '郵便番号が見つかりません。' + '</span>');
          }
          $('.mypage-user-info-detail').addClass("mypage-user-info-detail-hidden");
          $('.delivery-first-title-area').addClass("mypage-user-info-detail-hidden");
          $('.save_delivery').addClass("mypage-user-info-detail-hidden");
          $('#zip_result').html('');
        }
      },
      // システムエラーが起こっている場合の警報
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });

  });
});
// 短期レンタルプラン利用可能地域を郵便番号から判別（検索した場合）end

// 短期レンタルプラン利用可能地域を郵便番号から判別（val.jsに値を送る用）start　　///////////////////////////////////←　Phase1でバックエンドが実装してくれる（郵便番号によって郵送可能地域かどうかの判別をする）
$(function(){
  $("#zipcode_1,#zipcode_2").change(function(){

    $("#rental_zipcode").val(''); // 初期化
    $('#zip_result').html(''); // 初期化
    $('#zipcode-id-error-message').html(''); // 初期化
    $('#zip_result_lp').html(''); // 初期化
    $('#zip_result_lp_sp').html(''); // 初期化
    $('input[name="rental_start_date"]').val(''); // 初期化
    $('input[name="rental_end_date"]').val(''); // 初期化
    $('input[name="prior_delivery_date"]').val(''); // 初期化
    $(".delivery-area").addClass("delivery-disabled"); // 初期化
    $(".js-delivery-text").hide(); // 初期化
    $(".relief-item-select-area5").removeClass("selected"); // 初期化
    $("#support_option_03").prop("checked", false); // 初期化
    $(".relief-item-select-area3").removeClass("selected"); // 初期化
    $('input[name="prior_delivery_date"]').val(''); // 初期化
    $('input[name="prior_delivery_date"]').attr('disabled', true); // 初期化
    $(".delivery-mandatory").hide(); // 初期化
    $('.input-group-range-text').html('<span class="sp">渡航期間：</span>0<span> 日間</span>'); // 初期化
    $('.summary-group-day-text').html(''); // 初期化
    $('.summary-group-range-text').html(''); // 初期化
    $('.input-group-range-text-hidden').html(''); // 初期化
    $('.overseas-your-all-price').html(''); // 初期化
    $('.summary-group-countries-dataplans').html(''); // 初期化
    $('.plan-total-price').html(''); // 初期化
    $('.send-cp').html(''); // 初期化
    $('.summary-group-option-1').html(''); // 初期化
    $('.summary-group-option-2').html(''); // 初期化
    $('.summary-group-option-3').html(''); // 初期化
    $('.option-total-price').html(''); // 初期化
    $('.option-transit-price').html(''); // 初期化
    $('.transit-column').hide();
    $('.summary-group-send').html(''); // 初期化
    $('.summary-group-send-cp').html(''); // 初期化
    $('.send-total-price').html(''); // 初期化
    $('.summary-text-postage').html(''); // 初期化
    $('.overseas-delivery-text').hide(); // 初期化
    $('.overseas-delivery-year').html(''); // 初期化
    $('.overseas-year').html(''); // 初期化
    $('.overseas-delivery-month').html(''); // 初期化
    $('.overseas-month').html(''); // 初期化
    $('.overseas-delivery-day').html(''); // 初期化
    $('.overseas-day').html(''); // 初期化
    $('.overseas-time').html(''); // 初期化

    // 郵便番号を3+4=7桁にする（郵便番号検索APIで読み取れる形にする）start
    var rental_zipcode_1 = $("#zipcode_1").val();
    var rental_zipcode_2 = $("#zipcode_2").val();
    var rental_zipcode = rental_zipcode_1 + rental_zipcode_2;
    // 郵便番号を3+4=7桁にする（郵便番号検索APIで読み取れる形にする）end

    //入力値をセット
    var param = {zipcode: rental_zipcode}
    //zipcloudのAPIのURL
    var send_url = "https://zipcloud.ibsnet.co.jp/api/search";
    // 対象外都道府県
    const prefectures = [];

    $.ajax({
      type: "GET",
      cache: false,
      data: param,
      url: send_url,
      dataType: "jsonp",
      success: function (res) {
        //結果によって処理を振り分ける
        if (res.status == 200 && res.results != null) {
          //処理が成功したとき
          //該当する住所を表示
          var html = '';
          for (var i = 0; i < res.results.length; i++) {
            var result = res.results[i];
            html += result.address1;
          }
          // 利用可能地域の場合、非表示のinputタグに郵便番号7桁を導入→val.jsの空欄エラーを回避
          if(prefectures.includes(result.address1)){
          }else{
            // 配送地域の場合
            $("#rental_zipcode").val(rental_zipcode);
          }
        } else {
        }
      },
      // システムエラーが起こっている場合の警報
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
      }
    });

  }).change();
});
// 短期レンタルプラン利用可能地域を郵便番号から判別（val.jsに値を送る用）end
// 郵便番号で短期レンタルプラン対象地域を検索 end ////////////////////////////////////////////////////////////////////////////////

var option_from;
var option_to;
const option_available_from_days = 4;
const option_available_to_days = 8;

// カレンダー（bootstrap-datepicker）設定 start ////////////////////////////////////////////////////////////////////////////////
// 休日はbkHolidaysから取得
$(function(){

  if(!window.location.pathname.includes("/select") && !window.location.pathname.includes("/confirm")){
    return false;
  }

  // 事前配送オプションの最も早い選択可能日（郵便番号による判別）
  nowTimeMinOp = nowTimeMin;
  if(!window.location.pathname.includes("/confirm")){
    option_from_nowTimeMinOp = nowTimeMinOp.getDate() - 1;
  }
  option_from_times_area = nowTimeMinOp.setDate(option_from_nowTimeMinOp);
  option_from_area_comparison = option_from_times_area / 86400000;
  option_from_date_area = new Date(option_from_times_area);
  option_from_area = formatDate(option_from_date_area);
  option_from_area_comp = new Date(option_from_area);

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
    var day_from = new Date(val_from);
    var day_from2 = new Date(val_from);

    // 事前配送オプションの最も早い選択可能日（渡航日-6日）
    option_from_day_from = day_from.getDate() - option_available_to_days;
    option_from_times = day_from.setDate(option_from_day_from);
    option_from_comparison = option_from_times / 86400000;
    option_from_date = new Date(option_from_times);
    option_from = formatDate(option_from_date);
    option_from_comp = new Date(option_from);

    // 事前配送オプションの最も遅い選択可能日（渡航日-2日）
    option_to_day_from = day_from2.getDate() - option_available_from_days;
    option_to_times = day_from2.setDate(option_to_day_from);
    option_to_comparison = option_to_times / 86400000;
    option_to_date = new Date(option_to_times);
    option_to = formatDate(option_to_date);
    option_to_comp = new Date(option_to);

    const $selectedAirport = $('.relief-item-select-airport').hasClass('selected');
    const $confirmAirport = $('#receiving-method-airport').length;
    // 事前配送オプション期間外、または空港受取が選択されていた場合
    if((option_from_area_comp > option_to_comp) || $selectedAirport){
      // 事前配送オプションを選択できないようにする
      flg_delivery_day = false;
      $(".delivery-area").addClass("delivery-disabled");
      $("#support_option_03").prop("checked", false);
      $("#delivery_order_time").attr('disabled', false);
      $(".relief-item-select-area3").removeClass("selected");
      $('input[name="prior_delivery_date"]').val('');
      $('input[name="prior_delivery_date"]').attr('disabled', true);
      $(".delivery-mandatory").hide();
      $(".js-delivery-text").hide();
      // 事前配送オプション期間外の時のみメッセージを表示する
      !$selectedAirport && $(".delivery-area-caution").show();
      // STEP3：空港受取の場合は事前配送OPのエラーメッセージを削除する
      $confirmAirport === 1 && $(".delivery-area-caution").hide();
    }else if(option_from_date < option_from_area_comp){
      flg_delivery_day = true;
      $('input[name="prior_delivery_date"]').datepicker('setStartDate', option_from_area);
    }else{
      flg_delivery_day = true;
      $('input[name="prior_delivery_date"]').datepicker('setStartDate', option_from);
    }
    $('input[name="prior_delivery_date"]').datepicker('setEndDate', option_to);

    $('input[name="prior_delivery_date"]').datepicker('update');

    var day_to2 = day_from.setDate(day_from.getDate() + 30);
    var day_to2_month = ('0' + (day_from.getMonth() + 1)).slice(-2);
    var day_to2_day = ('0' + day_from.getDate()).slice(-2);
    day_to3 = day_from.getFullYear() + '/' + day_to2_month + '/' + day_to2_day;

    // $('input[name="rental_end_date"]').datepicker('setEndDate', day_to3);
    $('input[name="rental_end_date"]').datepicker('setStartDate', val_from);

    $('input[name="rental_end_date"]').datepicker('show');
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

    // 選択したご利用終了日の31日前の日付（ミリ秒）start
    var day_end = new Date(val_end);
    var day_to2 = day_end.setDate(day_end.getDate() - 30);
    var day_to2_month = ('0' + (day_end.getMonth() + 1)).slice(-2);
    var day_to2_day = ('0' + day_end.getDate()).slice(-2);
    day_to3 = day_end.getFullYear() + '/' + day_to2_month + '/' + day_to2_day;
    var three_days_later = new Date(day_to3);
    var three_days_later_time = three_days_later.getTime();
    // 選択したご利用終了日の31日前の日付（ミリ秒）end

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

  // bootstrap-datepicker 事前配送オプション受け取り希望日
  $('input[name="prior_delivery_date"]').datepicker({
    language:'ja', // 日本語化
    format: 'yyyy/mm/dd', // 日付表示をyyyy/mm/ddにフォーマット
    disableTouchKeyboard: false, // モバイル端末のキーボード無効化
    todayHighlight: true, // 現在日付をハイライトする
    enableOnReadonly: true, // readonly属性が付いている場合はピッカーを表示しない
    autoclose: true, // 日付選択時に自動でピッカーを閉じる
    orientation: 'bottom', // ピッカー表示位置（下）
    templates: {
      leftArrow: '＜', // ピッカーの一部に使用されるテンプレート
      rightArrow: '＞' // ピッカーの一部に使用されるテンプレート
    },
  })
  // 事前配送オプション受け取り希望日を変更した場合の処理 start
  .on('changeDate', function (selected) {
    $('#datepicker_prior_delivery-error').remove();
  });
  // 事前配送オプション受け取り希望日を変更した場合の処理 end

})
// カレンダー（bootstrap-datepicker）設定 end //////////////////////////////////////////////////////////////////////////////////

// 国/周遊の切替 start ////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {
  $('[name="travel_type"]:radio').change( function() {
    if($('[id=travel-type-single]').prop('checked')){
      $('#select-continent-plan').fadeOut(100);
      $('#select-country-plan').fadeIn(100);
      $(".overseas-plan-section").addClass('section-hide');
      $('input[name="plan_id_tour"]').prop("checked", false);
    } else if ($('[id=travel-type-tour]').prop('checked')) {
      $('#select-country-plan').fadeOut(100);
      $('#select-continent-plan').fadeIn(100);
      $(".overseas-plan-section").addClass('section-hide');
      $('input[name="country_plan"]').prop("checked", false);
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

$('input[name="plan_id_tour"]').on('change', function(){
  var country_plan = '周遊';
  var country_plan_area = $(this).attr("alt");

  $('select[name="_areas"]').val(country_plan_area).change();
  $('select[name="_countries"]').val(country_plan).change();
});

$('input[name="_areas"],select[name="_countries"]').on('change', function(){
  if($('[id=travel-type-single]').prop('checked')){
    var country_plan = $('input[name="country_plan"]:checked').val();
    var country_plan_select = $('select[name="_countries"]').val();

    if(country_plan == country_plan_select){
      return false;
    } else {
      $('input[name="country_plan"]').prop("checked", false);
    }
  } else if ($('[id=travel-type-tour]').prop('checked')) {
    var country_plan = $('input[name="plan_id_tour"]:checked').attr("alt");
    var country_plan_select = $('select[name="_areas"]').val();

    if(country_plan == country_plan_select){
      return false;
    } else {
      $('input[name="plan_id_tour"]').prop("checked", false);
    }
  }
});
// 国の制御 end //////////////////////////////////////////////////////////////////////////////////////////////////

// 日数・お届け予定日取得 start ////////////////////////////////////////////////////////////////////////////////////////////////
function overseasSchedule(){
  var val_from = $('input[name="rental_start_date"]').val();
  var val_to = $('input[name="rental_end_date"]').val();

  // 料金初期値
  var rental_price_all = 0;
  var op_total_price = 0;
  var op_total_price_tax = 0;

  // 事前配送オプションの初期フラグはfalse
  var flg_delivery = false;

  // 開始日・終了日ともに選択されている場合の処理 start
  if(val_from != "" && val_to != "" && val_from != " " && val_to != " "){
    // 日付オブジェクトを生成
    var day_from = new Date(val_from);
    var day_to = new Date(val_to);

    // 日数の計算（選択画面表示用）86,400,000ミリ秒＝1日（1000ミリ秒×60秒×60分×24時間×365日）
    termDay = '<span class="sp">渡航期間：</span>' + ((( day_to - day_from ) / 86400000) + 1) + '<span> 日間</span>';

    // Summary 日程
    summary_Day = val_from + '<span> ～ </span>' + val_to;

    // Summary 日数の計算（選択画面表示用）86,400,000ミリ秒＝1日（1000ミリ秒×60秒×60分×24時間×365日）
    summary_termDay = ((( day_to - day_from ) / 86400000) + 1);
    summary_termDay_text = '（' + summary_termDay + '日間）';

    // 日数の計算（料金計算用）
    termDayHidden = ((( day_to - day_from ) / 86400000) + 1);

    // 国名
    summary_countries = $('._countries option:selected').val();

    // エリア名
    summary_area =$('._areas option:selected').val();

    // データプラン
    summary_dataplans = $('._dataplans option:selected').text();
    summary_dataplans_val = $('._dataplans option:selected').val();

    // 周回プラン
    var tour_id = $('input[name="plan_id_tour"]:checked').val();

    // マーケットID取得用
    // URLを取得
    var m_url = new URL(window.location.href);
    // パラメータを取得
    var m_params = m_url.searchParams;
    // マーケットIDを取得
    var mid_params = m_params.get("mid");

    if(tour_id && gCountriesForTour[summary_area]){
      var lp_plans = gCountriesForTour[summary_area]["周遊"];
      var lp_plan_id_list = gCountriesPlanIdForTour[summary_area]["周遊"];
      var idx = lp_plan_id_list.indexOf(tour_id);
      var tour_price_comma = lp_plans[idx];

      // 周回プラン（通常）
      if(tour_id == 3919){
        tour_name = 'アジア周遊　500MBプラン';
      }else if(tour_id == 3920){
        tour_name = 'アジア周遊　1GBプラン';
      }else if(tour_id == 3921){
        tour_name = 'アジア周遊　無制限プラン';
      }else if(tour_id == 3922){
        tour_name = 'ヨーロッパ周遊　500MBプラン';
      }else if(tour_id == 3923){
        tour_name = 'ヨーロッパ周遊　1GBプラン';
      }else if(tour_id == 3924){
        tour_name = 'ヨーロッパ周遊　無制限プラン';
      }else if(tour_id == 3925){
        tour_name = '世界周遊　500MBプラン';
      }else if(tour_id == 3926){
        tour_name = '世界周遊　1GBプラン';
      }else if(tour_id == 3927){
        tour_name = '世界周遊　無制限プラン';
      }else if(tour_id == 4045){
        tour_name = 'アフリカ周遊　500MBプラン';
      }else if(tour_id == 4046){
        tour_name = 'アフリカ周遊　1GBプラン';
      }else if(tour_id == 4047){
        tour_name = 'アフリカ周遊　無制限プラン';
      }else if(tour_id == 4048){
        tour_name = 'オセアニア周遊　500MBプラン';
      }else if(tour_id == 4049){
        tour_name = 'オセアニア周遊　1GBプラン';
      }else if(tour_id == 4050){
        tour_name = 'オセアニア周遊　無制限プラン';
      }else if(tour_id == 4051){
        tour_name = '北アメリカ周遊　500MBプラン';
      }else if(tour_id == 4052){
        tour_name = '北アメリカ周遊　1GBプラン';
      }else if(tour_id == 4053){
        tour_name = '北アメリカ周遊　無制限プラン';
      }else if(tour_id == 4054){
        tour_name = '南アメリカ周遊　500MBプラン';
      }else if(tour_id == 4055){
        tour_name = '南アメリカ周遊　1GBプラン';
      }else if(tour_id == 4056){
        tour_name = '南アメリカ周遊　無制限プラン';
      }

      if(tour_price_comma){
        var tour_price = parseFloat(tour_price_comma.replace(/,/g, ""));
        var rental_price_all = tour_price * ((( day_to - day_from ) / 86400000) + 1);
        var rental_price_all_comma = String(rental_price_all).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

        if(mid_params == 1){
          $('.summary-group-countries-dataplans').html('<span>' + tour_name + '（価格.com特典）' + '</span><span class="overseas-center-price">' + tour_price_comma + ' <span class="your-price-sp">円 ✕ ' +  ((( day_to - day_from ) / 86400000) + 1) + ' 日</span></span>');
        }else{
          $('.summary-group-countries-dataplans').html('<span>' + tour_name  + '</span><span>' + tour_price_comma + ' <span class="your-price-sp">円 ✕ <span class="day-space">' +  ((( day_to - day_from ) / 86400000) + 1) + '</span> 日</span>');
          $('.interpretation-space').html((( day_to - day_from ) / 86400000) + 1);
        }

        $('.plan-total-price').html('小計 <span class="summary-text-device-option-price">' + rental_price_all_comma + '</span> 円<span class="tax">（免税）</span>');
      }

    }else if(summary_countries && summary_countries !== '選択してください' && summary_dataplans_val && summary_dataplans_val !== '選択してください'){
      // 国名 / データプラン
      var rental_price_text = $('._dataplans option:selected').attr('alt');
      var rental_price = parseFloat(rental_price_text.replace(/,/g, ""));

      if(mid_params == 1){
        summary_countries_dataplans = summary_countries +　 + summary_dataplans + '（価格.com特典）';
      }else{
        summary_countries_dataplans = summary_countries +　 + summary_dataplans;
      }

      summary_countries_dataplans_price = rental_price_text + ' <span class="your-price-sp">円 ✕ <span class="day-space">' +  ((( day_to - day_from ) / 86400000) + 1) + '</span> 日</span>';
      rental_price_all = rental_price * ((( day_to - day_from ) / 86400000) + 1);
      var rental_price_all_comma = String(rental_price_all).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      $('.interpretation-space').html((( day_to - day_from ) / 86400000) + 1);

      $('.summary-group-countries-dataplans').html('<span>' + summary_countries_dataplans + '</span><span class="overseas-center-price">' + summary_countries_dataplans_price + '</span>');
      $('.plan-total-price').html('小計 <span class="summary-text-device-option-price">' + rental_price_all_comma + '</span> 円<span class="tax">（免税）</span>');
    }else{
      $('.summary-group-countries-dataplans').html('');
      $('.plan-total-price').html('');
    }

    var op_anshin_price = 0;
    var op_anshin_price_total = 0;
    var op_advance_delivery_price = 0;
    var op_return_pack_price = 0;
    var op_transit_price = 0;

    //エクシディア経由　返却パック0円キャンペーン
    var op_return_pack_cp_price = 0;
    var op_return_pack_cp_text = '返却パック無料キャンペーン'

    // 端末サポート オプション
    summary_op_anshin = $('input[name="support_option_id"]:checked').val();

    // 合計金額に日数を表示する
    $('.interpretation-space').html((( day_to - day_from ) / 86400000) + 1);

    if(summary_op_anshin == '25'){
      summary_op_anshin_text = '端末サポート / ミニ　';
      op_anshin_price = 200;
      op_anshin_price_total = 200 * ((( day_to - day_from ) / 86400000) + 1);
      summary_op_anshin_price = op_anshin_price + ' <span class="your-price-sp">円 ✕ <span class="day-space">' +  ((( day_to - day_from ) / 86400000) + 1) + '</span> 日</span>';
      $('.summary-group-option-1').html('<span class="name-pc-wide">' + summary_op_anshin_text + '</span> <span>' + summary_op_anshin_price + '</span>');
    }else if(summary_op_anshin == '26'){
      summary_op_anshin_text = '端末サポート / ワイド　';
      op_anshin_price = 300;
      op_anshin_price_total = 300 * ((( day_to - day_from ) / 86400000) + 1);
      summary_op_anshin_price = '<span>' + op_anshin_price + '</span> <span class="your-price-sp">円 ✕ <span class="day-space">' +  ((( day_to - day_from ) / 86400000) + 1) + '</span> 日</span>';
      $('.summary-group-option-1').html('<span class="name-pc-wide">' + summary_op_anshin_text + '</span> <span>' + summary_op_anshin_price + '</span>');
    }else{
      $('.summary-group-option-1').html('');
    }

    if(flg_delivery_day){
      // 事前配送オプションを選択可能にする
      $(".delivery-area").removeClass("delivery-disabled");
      $(".delivery-area-caution").hide();
      $(".js-delivery-text").show();
    }

    // 事前配送オプション
    if($('#support_option_03').prop('checked')){
      // 事前配送オプションの日付を選択可能にする
      $("#datepicker_prior_delivery").attr('disabled', false);
      $(".overseas-select-inner-box .form-item-delivery-time").css('pointer-events','auto');
      $(".overseas-select-inner-box .form-item-delivery-time").css('background-color','rgb(217, 217, 217)');
      $(".delivery-mandatory").show();

      //事前配送受け取り日
      var activeOptionDate = $('#datepicker_prior_delivery').val();
      var activeDay = new Date(activeOptionDate);

      //渡航開始日
      var start_day = $('#datepicker_start').val();
      var start_day_date = new Date(start_day);
      start_day_date.setDate(start_day_date.getDate() - 3); // 前日を求める
      var activeStartDay = start_day_date;

      /*配送日と事前配送日の間が何日か計算 */
      //現在日の経過ミリ秒から選択日の経過ミリ秒を差し引く
      var activeStartDayNum = activeStartDay.getTime();  // 基準日付時間（1970年1月1日）からの経過ミリ秒取得
      var activeDayNum = activeDay.getTime();  // 基準日付時間（1970年1月1日）からの経過ミリ秒取得
      var activeDayCount = activeStartDayNum - activeDayNum;  // 各経過ミリ秒の差を計算
      var activeDayCountNum = (Math.trunc(activeDayCount / 24 / 60 / 60 / 1000));  // 経過ミリ秒の差を日数に変換

      summary_op_advance_delivery_text = '事前配送オプション';
      op_advance_delivery_price = 500;
      summary_op_advance_delivery_price = '<span>' + op_advance_delivery_price + '</span> 円<span class="space"></span>';
      //事前配送料金（500円）×日数
      summary_op_advance_delivery_price_day = op_advance_delivery_price * activeDayCountNum;

      //受け取り日入力前なら「〇日前」を非表示
      if(isNaN(activeDayCountNum)){
        $('.summary-group-option-2').html('<span>' + summary_op_advance_delivery_text + '</span> <span class="summary-option-2">' + op_advance_delivery_price + ' <span class="your-price2-sp"> 円</span>');
      }else{
        $('.summary-group-option-2').html('<span>' + summary_op_advance_delivery_text + '</span> <span class="summary-option-2">' + summary_op_advance_delivery_price_day.toLocaleString() + '<span class="your-price2-sp"> 円</span>');
        flg_delivery = true;
        op_advance_delivery_price = summary_op_advance_delivery_price_day;
      }
    }else{
      $('input[name="prior_delivery_date"]').val('');
      $('input[name="prior_delivery_date"]').attr('disabled', true);
      $(".form-item-delivery-time").val('00');
      $(".overseas-select-inner-box .form-item-delivery-time").css('pointer-events','none');
      $(".overseas-select-inner-box .form-item-delivery-time").css('background-color','#e8e8e8');
      $(".delivery-mandatory").hide();
      $('.summary-group-option-2').html('');
      flg_delivery = false;
      flg_CountNum = false;
    }

    if($("input[name='received_place']:checked").val() == 0 &&  $("select[name='delivery_order_time']").val() == '00') {
      $('.overseas-time').text("時間指定無し");
    }

    // 返却パック
    if($('#support_option_04').prop('checked')){
      summary_op_return_pack_text = '返却パック';
      op_return_pack_price = 1000;
      op_return_pack_cp_price = -1000;

      op_return_pack_price_comma = String(op_return_pack_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      summary_op_return_pack_price = '<span>' + op_return_pack_price_comma + '</span> 円<span class="space"></span>';
      $('.summary-group-option-3').html('<span>' + summary_op_return_pack_text + '</span> <span class="your-price2-sp">' + summary_op_return_pack_price + '</span>');

      //エクシディア経由なら返却パック0円キャンペーンを出す
      if(campaign_params &&
        flagHonne == true || flagWimaxhikaku == true || flagEvervest == true || flagMobistar == true){
        op_return_pack_cp_price_comma = String(op_return_pack_cp_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        summary_op_return_pack_cp_price = '<span>' + op_return_pack_cp_price_comma + '</span> 円<span class="space"></span>';
        $('.summary-group-option-3-cp').html('<span>' + op_return_pack_cp_text + '</span> <span class="your-price2-sp">' + summary_op_return_pack_cp_price + '</span>');
        $('.op_return_pack-cp').html('<span>' + op_return_pack_cp_text + '</span>');
      }
    }else{
      $('.summary-group-option-3').html('');
      $('.summary-group-option-3-cp').html('');
      $('.op_return_pack-cp').html('');
    }

    // トランジットオプション
    // 世界周遊のみトランジットオプションは付けられない
    if($("#travel-type-tour").prop('checked') && $("#tour-world_1").prop('checked')){
      $(".transit-option-area").addClass("transit-disabled");
      $("#support_option_05").prop("checked", false);
      $(".relief-item-select-area5").removeClass("selected");
      $(".transit-area-caution").show();
    }else{
      $(".transit-option-area").removeClass("transit-disabled");
      $(".transit-area-caution").hide();
    }

    if($('#support_option_05').prop('checked')){
      summary_op_transit_text = 'トランジットオプション';
      op_transit_price = 1500;
      op_transit_price_comma = String(op_transit_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      $('.transit-column').hide();
      summary_op_transit_price = '<span>' + op_transit_price_comma + '</span> 円';
      op_transit_price_comma_text = '小計 <span class="summary-text-device-option-price">' + op_transit_price_comma + '</span> 円<span class="tax">（免税）</span>';
      $('.summary-group-option-4').html('<span class="transit-name transit-name-1">' + summary_op_transit_text + '</span> <span class="your-price2-sp">' + summary_op_transit_price + '</span>');
      $('.option-transit-price').html(op_transit_price_comma_text);
    }else{
      $('.transit-column').hide();
      $('.summary-group-option-4').html('');
      $('.option-transit-price').html('');
    }
    if(op_anshin_price_total == 0 && op_advance_delivery_price == "" && op_return_pack_price == "" && op_transit_price !== ""){
      $(".option-total-price").html('小計 <span class="summary-text-device-option-price">' + 0 + '</span> 円<span class="space-tax"></span>');
      $('.transit-column').show();
      $('.transit-name').removeClass('transit-name-1');
    }else if(op_anshin_price_total || op_advance_delivery_price || op_return_pack_price || op_transit_price){
      //エクシディア経由の場合、返却パック0円
      if(campaign_params &&
        flagHonne == true || flagWimaxhikaku == true || flagEvervest == true || flagMobistar == true){
        op_total_price = op_anshin_price_total + op_advance_delivery_price
      }else{
        op_total_price = op_anshin_price_total + op_advance_delivery_price + op_return_pack_price;
      }
      op_total_price_comma = String(op_total_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      op_total_price_comma_text = '小計 <span class="summary-text-device-option-price">' + op_total_price_comma + '</span> 円<span class="tax">（税抜）</span>';
      $("div.your-plan-area div.summary-table-row").show();
      $('.option-total-price').html(op_total_price_comma_text);
    }else{
      $("div.your-plan-area div.summary-table-row").show();
      $('.transit-column').hide();
      $('.option-total-price').html('');
    }

    // 送料
    var send_price = 500;
    var send_cp_price = -500;
    var send_text = '送料';
    var send_cp_text = '送料無料キャンペーン';

    summary_send_price = send_price + ' 円';
    summary_send_cp_price = send_cp_price + ' 円';
    $('.summary-group-send').html('<span>' + send_text + '</span><span class="your-price2-sp">' + summary_send_price + '<span class="space"></span></span>');
    $('.summary-group-send-cp').html('<span>' + send_cp_text + '</span><span class="your-price2-sp">' + summary_send_cp_price + '<span class="space"></span></span>');

    var send_total_price;

    // キャンペーンの表記
    if(send_price || send_cp_price){
      send_total_price = send_price + send_cp_price;
      send_total_comma = String(send_total_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      send_total_comma_text = '小計 <span class="summary-text-device-option-price">' + send_total_comma + '</span> 円';

      $('.send-cp').html('<span>' + send_cp_text + '</span>');
      $('#send-cp-area').show();
      $('.send-total-price').html(send_total_comma_text);
    }else{
      $('#send-cp-area').hide();
      $('.send-total-price').html('');
    }

    // 消費税の計算
    if(op_total_price){
      op_total_price_tax = op_total_price * tax;
      op_total_price_tax_comma = String(op_total_price_tax).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      op_total_price_tax_text = '<span class="summary-text-device-option-tax">' + op_total_price_tax_comma + '</span><span> 円</span>';
      $('.summary-text-postage').html(op_total_price_tax_text);
    }else{
      $('.summary-text-postage').html('');
    }

    // 合計金額の計算
    var overseas_your_all_price = rental_price_all + op_total_price + op_total_price_tax + op_transit_price;
    var overseas_your_all_price_comma = String(overseas_your_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.overseas-your-all-price').html('<span class="big-num">' + overseas_your_all_price_comma + '</span> 円（税込）');

    // 配送予定日時（事前配送オプションなし）
    var start_day = $('#datepicker_start').val();
    var start_day_date = new Date(start_day);
    start_day_date.setDate(start_day_date.getDate() - 3); // 前日を求める

    var getYear = start_day_date.getFullYear();
    var getMonth1 = start_day_date.getMonth() + 1;
    var getMonth = ( '000' + getMonth1 ).slice( -2 );
    var getDate1 = start_day_date.getDate();
    var getDate = ( '000' + getDate1 ).slice( -2 );

    // 配送予定日時（事前配送オプションあり）
    var start_day_op = $('#datepicker_prior_delivery').val();
    var start_day_date_op = new Date(start_day_op);

    var getYear_op = start_day_date_op.getFullYear();
    var getMonth_op1 = start_day_date_op.getMonth() + 1;
    var getMonth_op = ( '000' + getMonth_op1 ).slice( -2 );
    var getDate_op1 = start_day_date_op.getDate();
    var getDate_op = ( '000' + getDate_op1 ).slice( -2 );

    // 時間表記
    var start_time = $('#timepicker .form-item-delivery-time').val();
    if($('#timepicker .form-item-delivery-time option[value=' + start_time +']').text() == '指定無し') {
      var start_time_v = '時間指定無し';
    }else {
      var start_time_v = $('#timepicker .form-item-delivery-time option[value=' + start_time +']').text();
    }

    // オプション説明欄の日付表記
    $('.overseas-delivery-text').show();
    $('.overseas-delivery-year-usually').html(getYear);
    $('.overseas-delivery-month-usually').html(getMonth);
    $('.overseas-delivery-day-usually').html(getDate);

    if(start_time != "") {
      $('.overseas-time').html(start_time_v);
    } else {
      $('.overseas-time').html("");
    }
    $(".form-item-delivery-time").change(function(){
      var start_time = $('#timepicker .form-item-delivery-time').val();
      var start_time_v = $('#timepicker .form-item-delivery-time option[value=' + start_time +']').text();
      $('.overseas-time').html(start_time_v);
      if(start_time_v == "指定無し") {
        $('.overseas-time').html("時間指定無し");
      };
    })

  if(flg_delivery && start_day_op != "" && start_day_op != " ") {
    $('.overseas-delivery-year').html(getYear_op);
    $('.overseas-delivery-month').html(getMonth_op);
    $('.overseas-delivery-day').html(getDate_op);
    $('.overseas-time').html(start_time_v);
  } else {
    $('.overseas-delivery-year').html(getYear);
    $('.overseas-year').html("/");
    $('.overseas-delivery-month').html(getMonth);
    $('.overseas-month').html("/");
    $('.overseas-delivery-day').html(getDate);
    $('.overseas-day').html("");
  }

    $('.input-group-range-text').html(termDay);
    $('.summary-group-day-text').html(summary_Day);
    $('.send-airport-date').html(val_from);
    $('.summary-group-range-text').html(summary_termDay_text);
    $('.input-group-range-text-hidden').html(termDayHidden);

    var shortPlanDay_lp = $('.input-group-range-text-hidden').text();
    var tax_lp = 1.1;

    if (shortPlanDay_lp <= 15 ) {
      planTaxFee_lp = 430 * shortPlanDay_lp * tax_lp;
    } else if (15 < shortPlanDay_lp <= 31 ) {
      planTaxFee_lp = 430 * 15 * tax_lp;
    }

    planTaxFee_lp = Math.floor(planTaxFee_lp);

    $(".input-group-range-text-lp").html("<span class='rental-lp-calc'>" + (( day_to - day_from ) / 86400000) + "</span>" + "<span>泊</span>" + "<span class='rental-lp-calc'>" + ((( day_to - day_from ) / 86400000) + 1) + "</span>" + "<span>日</span>" + "<span class='rental-lp-calc-price'>" + planTaxFee_lp.toLocaleString() + "</span>" + "<span class='plan-tax'>円(税込)</span>");
  }else{
  }
  // 開始日・終了日ともに選択されている場合の処理 end
}
// 日数・お届け予定日取得 end //////////////////////////////////////////////////////////////////////////////////////////////////

// 日数・お届け予定日取得のイベント発火 start //////////////////////////////////////////////////////////////////////////////////////////////////
$('.input-sm,.topping-2-select-area,#device_option_true,.form-item-delivery,._areas,._countries,._dataplans,.entry-option-select,.country-plan,input[name="plan_id_tour"]').on('click change', function(){
  overseasSchedule();
});
// 日数・お届け予定日取得のイベント発火 end //////////////////////////////////////////////////////////////////////////////////////////////////

// 一カ国プランを選択しているかどうかの初期フラグはfalse
var flg_country_select = false;

$('._areas,._countries,._dataplans').on('click change', function(){
  flg_country_select = true;
});

// 料金内訳追従 start //////////////////////////////////////////////////////////////////////////////////////////////////
$('#detail-more-tab').on('click', function(){
  if($('.your-plan-area').hasClass('summary-close')){
    $('.your-plan-area').removeClass('summary-close');
    $('#detail-more-tab').addClass('your-plan-open');
  }else{
    $('.your-plan-area').addClass('summary-close');
    $('#detail-more-tab').removeClass('your-plan-open');
  }
  $('.detail-more').toggle();
});

$('.input-sm,._areas,._countries,._dataplans,#anshin_option .entry-option-select,#detail-more-tab').on('click change', function(){
  if($('.your-plan-area').hasClass('summary-close')){
    if (window.matchMedia("(max-width: 768px)").matches) {
      //画面横幅が768px以下のときの処理
      $('.your-plan-area').css('height', 156);
    } else {
      //画面横幅が769px以上のときの処理
      $('.your-plan-area').css('height', 192);
    };
  }else{
    if (window.matchMedia("(max-width: 768px)").matches) {
      //画面横幅が768px以下のときの処理
      var your_plan_height = $('#your_plan').height() + 80;
    } else {
      //画面横幅が769px以上のときの処理
      var your_plan_height = $('#your_plan').height() + 100;
    };

    $('.your-plan-area').css('height', your_plan_height);
  }
});

$(function() {
  $(window).on("scroll", function() {
    const scrollHeight = $(document).height();/*ページ全体の高さ*/
    const scrollPosition = $(window).height() + $(window).scrollTop();/*ページの一番上からスクロールされた距離*/
    const footHeight =450;/*追従の高さ(PC)*/
    const footHeightSP = 430;/*追従の高さ(SP)*/

    if (window.matchMedia("(max-width: 768px)").matches) {
      //画面横幅が768px以下のときの処理
      if ( scrollHeight - scrollPosition  <= footHeightSP ) {
        $("#your_plan").css({
          "position":"absolute",
          "bottom": footHeightSP,
        });
      } else {
        $("#your_plan").css({
          "position":"fixed",
          "bottom": "10px",
        });
      }
    } else {
      //画面横幅が769px以上のときの処理
      if ( scrollHeight - scrollPosition  <= footHeight ) {
        console.log("a");
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
    };
  });
});
// 料金内訳追従 end //////////////////////////////////////////////////////////////////////////////////////////////////

// 郵便番号から配送日数を取得する start //////////////////////////////////////////////////////////////////////////////////////////////////
function get_delivery_info(zipcode_1, zipcode_2) {
  var delivery_info = [];
  var base_url = location.protocol + '//' + location.host;
  var api_url = base_url + '/api/v1/delivery_info';
  $.ajax(api_url,
    {
      type: 'get',
      data: {
        'zipcode_1': zipcode_1,
        'zipcode_2': zipcode_2
      },
      dataType: 'json',
      async: false, // 他のファイルで使えるように非同期
    }
  )
  // 成功時は変数にデータを格納
  .done(function(json) {
    delivery_info = JSON.parse(json['code']);
  })
  // 失敗時にはエラーログ出力
  .fail(function(e) {
    console.log(e);
  });
  return delivery_info;
}
// 郵便番号から配送日数を取得する end //////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////// 確認画面専用JS start //////////////////////////////////////////////////////////////////////////////
// 事前配送オプション（確認画面）の制御 start //////////////////////////////////////////////////////////////////////////////////////////////////
function overseasConfirmDelivery(){

  $('input[name="prior_delivery_date"]').datepicker({
    language:'ja', // 日本語化
    format: 'yyyy/mm/dd', // 日付表示をyyyy/mm/ddにフォーマット
    disableTouchKeyboard: false, // モバイル端末のキーボード無効化
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
      $('input[name="prior_delivery_date"]').val(deliveryDate);

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

  // 配送予定日時（事前配送オプションなし）
  var start_day = $('#datepicker_start').val();
  var start_day_date = new Date(start_day);
  start_day_date.setDate(start_day_date.getDate() - 1); // 前日を求める

  var getYear = start_day_date.getFullYear();
  var getMonth = start_day_date.getMonth() + 1;

  var getDate = start_day_date.getDate();

  // オプション説明欄の日付表記
  $('.overseas-delivery-text').show();
  $('.overseas-delivery-year-usually').html(getYear);
  $('.overseas-delivery-month-usually').html(getMonth);
  $('.overseas-delivery-day-usually').html(getDate);

  // 日付をYYYY-MM-DDの書式で返すメソッド
  function formatDate(dt) {
    var y = dt.getFullYear();
    var m = ('00' + (dt.getMonth()+1)).slice(-2);
    var d = ('00' + dt.getDate()).slice(-2);
    return (y + '/' + m + '/' + d);
  }

  var val_from = $('input[name="rental_start_date"]').val();

  var day_from = new Date(val_from);
  var day_from2 = new Date(val_from);

  // 事前配送オプションの最も早い選択可能日（郵便番号による判別）
  nowTimeMinOp = nowTimeMin;
  option_from_nowTimeMinOp = nowTimeMinOp.getDate() - 1;
  option_from_times_area = nowTimeMinOp.setDate(option_from_nowTimeMinOp);
  option_from_area_comparison = option_from_times_area / 86400000;
  option_from_date_area = new Date(option_from_times_area);
  option_from_area = formatDate(option_from_date_area);
  option_from_area_comp = new Date(option_from_area);

  // 事前配送オプションの最も早い選択可能日（渡航日-6日）
  option_from_day_from = day_from.getDate() - option_available_to_days;
  option_from_times = day_from.setDate(option_from_day_from);
  option_from_comparison = option_from_times / 86400000;
  option_from_date = new Date(option_from_times);
  option_from = formatDate(option_from_date);
  option_from_comp = new Date(option_from);

  // 事前配送オプションの最も遅い選択可能日（渡航日-2日）
  option_to_day_from = day_from2.getDate() - option_available_from_days;
  option_to_times = day_from2.setDate(option_to_day_from);
  option_to_comparison = option_to_times / 86400000;
  option_to_date = new Date(option_to_times);
  option_to = formatDate(option_to_date);
  option_to_comp = new Date(option_to);

  if(option_from_area_comp > option_to_comp){
    // 事前配送オプションを選択できないようにする
    flg_delivery_day = false;
    $(".delivery-area").addClass("delivery-disabled");
    $(".delivery-area-caution").show();
    $("#support_option_03").prop("checked", false);
    $(".relief-item-select-area3").removeClass("selected");
    $("#delivery_order_time").attr('disabled', false);
    $('input[name="prior_delivery_date"]').val('');
    $('input[name="prior_delivery_date"]').attr('disabled', true);
    $(".delivery-mandatory").hide();
    $(".js-delivery-text").hide();
  }else if(option_from_times < option_from_times_area){
    flg_delivery_day = true;
    $('input[name="prior_delivery_date"]').datepicker('setStartDate', option_from_area);
  }else{
    flg_delivery_day = true;
    $('input[name="prior_delivery_date"]').datepicker('setStartDate', option_from);
  }
  $('input[name="prior_delivery_date"]').datepicker('setEndDate', option_to);

  if(flg_delivery_day){
    // 事前配送オプションを選択可能にする
    $(".delivery-area").removeClass("delivery-disabled");
    $(".delivery-area-caution").hide();
    $(".js-delivery-text").show();
  }

  // 事前配送オプション
  if($('#support_option_03').prop('checked')){
    // 事前配送オプションの日付を選択可能にする
    $("#datepicker_prior_delivery").attr('disabled', false);
    $(".overseas-select-inner-box .form-item-delivery-time").css('pointer-events','auto');
    $(".overseas-select-inner-box .form-item-delivery-time").css('background-color','rgb(217, 217, 217)');
    $(".delivery-mandatory").show();
    flg_delivery = true;
  }else{
    $('input[name="prior_delivery_date"]').val('');
    $('input[name="prior_delivery_date"]').attr('disabled', true);
    $(".form-item-delivery-time").val('00');
    $(".overseas-select-inner-box .form-item-delivery-time").css('pointer-events','none');
    $(".overseas-select-inner-box .form-item-delivery-time").css('background-color','#e8e8e8');
    $(".delivery-mandatory").hide();
    flg_delivery = false;
  }
}
$(window).on('load', function() {
  let params = new URLSearchParams(document.location.search);
  let delivery_flag = params.get("received_place2");
  if (delivery_flag) {
    $(".delivery-area-caution").hide();
    $(".delivery-area-caution-airport").show();
  }else {
    $(".delivery-area-caution-airport").hide();
  }
});

// 事前配送オプション（確認画面）の制御 end //////////////////////////////////////////////////////////////////////////////////////////////////


// その他の入力フォームのバリデーション
function otherInputVali() {
  var checked_other_flg_all = false;
  var checked_other_flg1 = true;
  var checked_other_flg2 = true;
  var checked_other_flg3 = true;

  var checked_other1 = $("input#answer_32").prop("checked");
  if (checked_other1) {
    var text = $(".form-other-32 input").val();
    if (text !== "") {
      checked_other_flg1 = true;
      $(".other-input-caution_32").hide();
    } else {
      checked_other_flg1 = false;
      $(".other-input-caution_32").show();
    }
  }else {
    $(".form-other-32 input").val('');
    $(".other-input-caution_32").hide();
  }

  var checked_other2 = $("input#answer_37").prop("checked");
  if (checked_other2) {
    var text = $(".form-other-37 input").val();
    if (text !== "") {
      checked_other_flg2 = true;
      $(".other-input-caution_37").hide();
    } else {
      checked_other_flg2 = false;
      $(".other-input-caution_37").show();
    }
  }else {
    $(".form-other-37 input").val('');
    $(".other-input-caution_37").hide();
  }

  var checked_other3 = $("input#answer_40").prop("checked");
  if (checked_other3) {
    var text = $(".form-other-40 input").val();
    if (text !== "") {
      checked_other_flg3 = true;
      $(".other-input-caution_40").hide();
    } else {
      checked_other_flg3 = false;
      $(".other-input-caution_40").show();
    }
  }else {
    $(".form-other-40 input").val('');
    $(".other-input-caution_40").hide();
  }

  if(checked_other_flg1 && checked_other_flg2 && checked_other_flg3) {
    checked_other_flg_all = true;
  }else {
    checked_other_flg_all = false;
  }
  return checked_other_flg_all;
}
$(function() {
  // チェックボックスとアンケート必須
  $("input#overseas-leave-checkbox, .question-area1, .other-input-form, input#answer_32, input#answer_37, input#answer_40").on('click change blur', function(){
    var isPage = location.pathname.indexOf("/entry/overseas/confirm") === 0;
    if(!isPage){
      // Not options page
      return;
    }

    // その他の入力フォームが空じゃないかチェック
    var other_input_flag = otherInputVali();

    // 同意チェック
    var checked = $("input#overseas-leave-checkbox").prop("checked");
    $("#agree").val(checked ? 1 : 0);

    // 渡航理由アンケートのチェック数取得
    let checks_count = 0;
    let checks = document.getElementsByClassName("question-area1");
    let checks_length = checks.length;
    for (let i=0; i<checks_length; i++) {
      if (checks[i].checked) {
        checks_count++;
      }
    }

    // 同意チェック & アンケート回答に1つ以上チェックがあれば次画面へ進行可
    if (checked && checks_count > 0 && other_input_flag) {
      $("div#entry_user_submit").removeClass(
        "decoration-button-area-disabled"
      );
      $("input#button-submit").removeAttr("disabled");
      $(".questionnaire-caution").hide();
    } else if (checked && checks_count == 0 ) {
      let scroll = $(".global-questionnaire").offset().top;
      $('html, body').animate({scrollTop:scroll});
      $(".questionnaire-caution").show();
      $("div#entry_user_submit").addClass("decoration-button-area-disabled");
      $("input#button-submit").attr("disabled", "disabled");
    }else {
      $("div#entry_user_submit").addClass("decoration-button-area-disabled");
      $("input#button-submit").attr("disabled", "disabled");
    }

    // アンケート2の「Google・Yahoo!・Bingなどの検索」回答にチェックがある場合は2-2に1つ以上チェックがあれば次画面へ進行可
    // let checks_count2_2 = 0;
    // var checks2_2 = document.getElementsByClassName("question-area2-2");
    // let checks_length2 = checks2_2.length;
    // for (let i=0; i<checks_length2; i++) {
    //   if (checks2_2[i].checked) {
    //     checks_count2_2++;
    //   }
    // }
    // var checked_type2_2 = $("input#answer_25").prop("checked");
    // if(checked_type2_2 && checks_count2_2 == 0 || !other_input_flag) {
    //   $("div#entry_user_submit").addClass("decoration-button-area-disabled");
    //   $("input#button-submit").attr("disabled", "disabled");
    // } else if (!checked_type2_2 && checks_count2_2 > 0) {
    //   $(".question-area2-2").prop("checked", false);
    // } else if (checked_type2_2 && checks_count2_2 > 0 && checked) {
    //   $("div#entry_user_submit").removeClass("decoration-button-area-disabled");
    //   $("input#button-submit").removeAttr("disabled");
    //   $(".questionnaire-caution").hide();
    // }
    // アンケート2の「画像や動画などのインターネット広告」回答にチェックがある場合は2-3に1つ以上チェックがあれば次画面へ進行可
    // let checks_count2_3 = 0;
    // var checks2_3 = document.getElementsByClassName("question-area2-3");
    // let checks_length3 = checks2_3.length;
    // for (let i=0; i<checks_length3; i++) {
    //   if (checks2_3[i].checked) {
    //     checks_count2_3++;
    //   }
    // }
    // var checked_type2_3 = $("input#answer_26").prop("checked");
    // if(checked_type2_3 && checks_count2_3 == 0 || checked_type2_3 && checks_count2_3 > 0 && checked_type2_2 && checks_count2_2 == 0 || !other_input_flag) {
    //   $("div#entry_user_submit").addClass("decoration-button-area-disabled");
    //   $("input#button-submit").attr("disabled", "disabled");
    // } else if (!checked_type2_3 && checks_count2_3 > 0) {
    //   $(".question-area2-3").prop("checked", false);
    // } else if (checked_type2_3 && checks_count2_3 > 0 && checked) {
    //   $("div#entry_user_submit").removeClass("decoration-button-area-disabled");
    //   $("input#button-submit").removeAttr("disabled");
    //   $(".questionnaire-caution").hide();
    // }
  });
});

//////////////////////////////////////////////////////////////////////////////// 確認画面専用JS end ////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////// 再申し込み専用JS start //////////////////////////////////////////////////////////////////////////////
// 郵便番号で短期レンタルプラン対象地域を検索 start //////////////////////////////////////////////////////////////////////////////

$(function(){
  if(window.location.pathname == "/mypage/contract/repeat"){
    delivery_order_time_1 = $('[name=delivery_order_time] option').first();
    delivery_order_time_1.text('日時指定無し');
  }

  if($(".input-sm").hasClass('rental-date-initial')){
    $('input[name="rental_start_date"]').attr('value', ' ');
    $('input[name="rental_end_date"]').attr('value', ' ');
  }
});

$('.input-sm').on('click change', function(){
  $(this).removeClass('rental-date-initial');
});

// 郵便番号で短期レンタルプラン対象地域を検索 end ////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////// 再申し込み専用JS end ////////////////////////////////////////////////////////////////////////////////
$("#entry-plan-form").keypress(function (e) {
  if (e.keyCode == 13) {
    if($("#usage_period_block").css('display')=="block"){
      $("#button-submit").click();
    } else {
      return false;
    }
  }
});

// プラン情報パラメータ引き継ぎ start //////////////////////////////////////////////////////////////////////////////////////////////////
$('#received_place_01,#received_place_02,#select-airport,#select-store,#zipcode_1,#zipcode_2,input[name="travel_type"],.input-sm,.topping-2-select-area,#device_option_true,.form-item-delivery,._areas,._countries,._dataplans,.entry-option-select,.country-plan,input[name="plan_id_tour"],.form-user-select-sp').on('click change', function(){
  // URLを取得
  var url = new URL(window.location.href);

  if(window.location.pathname.includes("/select")){
    var received_place1 = $('input#received_place_01:checked').val() && $('input#received_place_01').val();
    var received_place2 = $('input#received_place_02:checked').val() && $('input#received_place_02').val();
    var select_airport = $('#select-airport').val();
    var select_store = $('#select-store').val();
    var zip1 = $('input[name="rental_zipcode_1"]').val();
    var zip2 = $('input[name="rental_zipcode_2"]').val();
    var start = $('input[name="rental_start_date"]').val();
    var end = $('input[name="rental_end_date"]').val();
  }

  var type = $('input[name="travel_type"]:checked').val();
  var pickup = $('input[name="country_plan"]:checked').attr('id');
  var area = $('select[name="_areas"]').val();
  var co = $('select[name="_countries"]').val();
  var to = $('input[name="plan_id_tour"]:checked').val();
  var plan = $('input[name="plan_per_day"]:checked').val();
  var op1 = $('input[name="support_option_id"]:checked').val();
  var op2 = $('#support_option_03:checked').val();
  var op2_date = $('input[name="prior_delivery_date"]').val();
  var op2_time = $(".form-item-delivery-time").val();
  var op3 = $('#support_option_04:checked').val();
  var op4 = $('#support_option_05:checked').val();

  if(window.location.pathname.includes("/select")){
    if(received_place1){
      url.searchParams.set('received_place1', received_place1);
    }else{
      url.searchParams.delete('received_place1');
    }

    if(received_place2){
      url.searchParams.set('received_place2', received_place2);
    }else{
      url.searchParams.delete('received_place2');
    }

    if(select_airport){
      url.searchParams.set('select_airport', select_airport);
    }else{
      url.searchParams.delete('select_airport');
    }

    if(select_store){
      url.searchParams.set('select_store', select_store);
    }else{
      url.searchParams.delete('select_store');
    }

    if(zip1){
      url.searchParams.set('zip1', zip1);
    }else{
      url.searchParams.delete('zip1');
    }

    if(zip2){
      url.searchParams.set('zip2', zip2);
    }else{
      url.searchParams.delete('zip2');
    }

    if(start){
      url.searchParams.set('start', start);
    }else{
      url.searchParams.delete('start');
    }

    if(end){
      url.searchParams.set('end', end);
    }else{
      url.searchParams.delete('end');
    }
  }

  if(type){
    url.searchParams.set('type', type);
  }else{
    url.searchParams.delete('type');
  }

  if(type == 'single'){
    if(pickup){
      url.searchParams.set('pickup', pickup);
    }

    if(area){
      url.searchParams.set('area', area);
    }else{
      url.searchParams.delete('area');
    }

    if(co){
      url.searchParams.set('co', co);
    }else{
      url.searchParams.delete('co');
    }

    if(plan){
      url.searchParams.set('plan', plan);
    }else{
      url.searchParams.delete('plan');
    }
  }else{
    url.searchParams.delete('pickup');
    url.searchParams.delete('area');
    url.searchParams.delete('co');
    url.searchParams.delete('plan');
  }

  if(type == 'tour'){
    if(to){
      url.searchParams.set('to', to);
    }else{
      url.searchParams.delete('to');
    }
  }else{
    url.searchParams.delete('to');
  }

  if(op1){
    url.searchParams.set('op1', op1);
  }else{
    url.searchParams.delete('op1');
  }

  if(op2){
    url.searchParams.set('op2', op2);
  }else{
    url.searchParams.delete('op2');
  }

  if(op2_date){
    url.searchParams.set('op2_date', op2_date);
  }else{
    url.searchParams.delete('op2_date');
  }

  if(op2_time){
    url.searchParams.set('op2_time', op2_time);
  }else{
    url.searchParams.delete('op2_time');
  }

  if(op3){
    url.searchParams.set('op3', op3);
  }else{
    url.searchParams.delete('op3');
  }

  if(op4){
    url.searchParams.set('op4', op4);
  }else{
    url.searchParams.delete('op4');
  }

  window.history.pushState({}, '', url);
});

// STEP2→STEP1にブラウザバックした時にリロードする
window.addEventListener("pageshow", function (event) {
  var entries = performance.getEntriesByType("navigation");
  entries.forEach(function (entry) {
    if (entry.type == "back_forward") {

      // 現在のURLを取得
      var url = window.location.href;

      // STEP1の時
      if(url.includes("/select")){
        // リロードする
        window.location.reload();
      }
    }
  });
});

$(function(){
  // 前のページのURL取得
  var referrer_url = document.referrer;

  if(referrer_url.includes("/entry")){
    // 前のページのURLからパラメータ取得
    var url = new URL(referrer_url).searchParams;

    // 今のぺージに反映
    window.history.pushState({}, '', '?' + url);
  }

  if(window.location.pathname.includes("/select") || window.location.pathname.includes("/confirm")){
    if(!url){
      return false;
    }
    var received_place1 = url.get('received_place1');
    var received_place2 = url.get('received_place2');
    var select_airport = url.get('select_airport');
    var select_store = url.get('select_store');
    var zip1 = url.get('zip1');
    var zip2 = url.get('zip2');
    var start = url.get('start');
    var end = url.get('end');
    var type = url.get('type');
    var pickup = url.get('pickup');
    var area = url.get('area');
    var co = url.get('co');
    var to = url.get('to');
    var plan = url.get('plan');
    var op1 = url.get('op1');
    var op2 = url.get('op2');
    var op2_date = url.get('op2_date');
    var op2_time = url.get('op2_time');
    var op3 = url.get('op3');
    var op4 = url.get('op4');

    var received_place1_in = $('.relief-item-select-delivery');
    var received_place2_in = $('.relief-item-select-airport');
    var select_airport_in = $('select[name="select-airport"]');
    var select_store_in = $('select[name="select-store"]');
    var zip1_in = $('input[name="rental_zipcode_1"]');
    var zip2_in = $('input[name="rental_zipcode_2"]');
    var start_in = $('input[name="rental_start_date"]');
    var end_in = $('input[name="rental_end_date"]');
    var type_in = $('input[name="travel_type"][value="' + type + '"]');
    var pickup_in = $('input[name="country_plan"][id="' + pickup + '"]');
    var area_in = $('select[name="_areas"]');
    var co_in = $('select[name="_countries"]');
    var to_in = $('input[name="plan_id_tour"][id="' + to + '"]');
    var op2_date_in = $('input[name="prior_delivery_date"]');
    var op2_time_in = $('.form-item-delivery-time');

    if(received_place1){
      received_place1_in.click();
    }

    if(received_place2){
      received_place2_in.click();
    }

    if(select_airport){
      select_airport_in.val(select_airport).change();
    }

    if(select_store){
      select_store_in.val(select_store).change();
    }

    if(zip1){
      zip1_in.val(zip1);
    }

    if(zip2){
      zip2_in.val(zip2);
    }

    if(zip1 && zip2){
      flg_inherit_parameters = true;
      $('#search_btn').click();
    }

    if(start){
      start_in.datepicker('setDate', start);
      start_in.datepicker('hide');
    }

    if(end){
      end_in.datepicker('setDate', end);
      end_in.datepicker('hide');
    }

    if(type){
      type_in.prop('checked', true).change();
    }

    if(type == 'single'){
      if(pickup){
        pickup_in.click();
      }else{
        if(area){
          area_in.val(area).change();
        }
        if(co){
          co_in.val(co).change();
        }
      }

      $(".overseas-plan-section").removeClass('section-hide');

      if(plan){
        var plan_in = $('input[name="plan_per_day"][value="' + plan + '"]').closest('.entry-option-select').find('.topping-2-select-area-relief-option');
        plan_in.click();
      }
    }

    //20240424 ミャンマー受付停止の注記用
    if(type == 'tour'){
      $(".reception-stopped").hide();
      if(to){
        if(to == '3919' || to == '3920' || to == '3921' || to == '4476' || to == '4477' || to == '4478'){
          $('#tour-asia_1').prop('checked', true).change();
          var plan_in = $('input[name="plan_per_day"][value="' + to + '"]').closest('.entry-option-select').find('.topping-2-select-area-relief-option');
          $(".reception-stopped").show();
          plan_in.click();
        }else if(to == '3922' || to == '3923' || to == '3924' || to == '4479' || to == '4480' || to == '4481'){
          $('#tour-europe_1').prop('checked', true).change();
          var plan_in = $('input[name="plan_per_day"][value="' + to + '"]').closest('.entry-option-select').find('.topping-2-select-area-relief-option');
          $(".reception-stopped").hide();
          plan_in.click();
        }else if(to == '3925' || to == '3926' || to == '3927' || to == '4473' || to == '4474' || to == '4475'){
          $('#tour-world_1').prop('checked', true).change();
          var plan_in = $('input[name="plan_per_day"][value="' + to + '"]').closest('.entry-option-select').find('.topping-2-select-area-relief-option');
          $(".reception-stopped").show();
          plan_in.click();
        }
      }
    }

    if(window.location.pathname.includes("/select")){
      if(op1){
        var op1_in = $('input[name="support_option_id"][value="' + op1 + '"]').closest('.entry-option-select').find('.topping-2-select-area-relief-option');
        op1_in.click();
      }

      if(op2){
        var op2_in = $('#support_option_03').closest('.entry-option-select').find('.topping-2-select-area-relief-option');
        op2_in.click();
      }

      if(op2_date){
        op2_date_in.datepicker('setDate', op2_date);
        op2_date_in.datepicker('hide');
      }

      if(op2_time){
        op2_time_in.val(op2_time);
      }

      if(op3){
        var op3_in = $('#support_option_04').closest('.entry-option-select').find('.topping-2-select-area-relief-option');
        op3_in.click();
      }

      if(op4){
        var op4_in = $('#support_option_05').closest('.entry-option-select').find('.topping-2-select-area-relief-option');
        op4_in.click();
      }

      // エクシディア経由のパラメータ引き継ぎ
      if(zip1 && zip2 && flg_inherit_parameters == true){
        if(window.location.pathname.includes("/entry/overseas/select")){
          // エクシディア経由のパラメータ取得
          let params = new URLSearchParams(document.location.search);

          flagHonne = false; //HonNe
          flagWimaxhikaku = false; //WiMAX比較、YouTube
          flagEvervest = false; //エバーベスト
          flagMobistar = false; //海外レンタルWiFi比較ナビ

          //utm_campaignの中身によってフラグ変更
          let utm_campaign = params.get("utm_campaign");

          //エクシディア
          if(utm_campaign){
            campaign_params = utm_campaign;

            //HonNe
            if(campaign_params == "honne"){
              flagHonne = true;
              overseasSchedule();
              $(".cp-price").addClass("cp-true");
              $(".honne").addClass("cp-true");
              $(".wimax_hikaku").removeClass("cp-true");
              $(".everbest").removeClass("cp-true");

            //WiMAX比較、YouTube
            }else if(campaign_params == "wimaxhikaku"){
              flagWimaxhikaku = true;
              overseasSchedule();
              $(".cp-price").addClass("cp-true");
              $(".honne").removeClass("cp-true");
              $(".wimax_hikaku").addClass("cp-true");
              $(".everbest").removeClass("cp-true");

            //エバーベスト
            }else if(campaign_params == "everbest"){
              flagEvervest = true;
              overseasSchedule();
              $(".cp-price").addClass("cp-true");
              $(".honne").removeClass("cp-true");
              $(".wimax_hikaku").removeClass("cp-true");
              $(".everbest").addClass("cp-true");

            //海外レンタルWiFi比較ナビ
            }else if(campaign_params == "mobistar_cp1"){
              flagMobistar = true;
              $(".cp-price").addClass("cp-true");
              $(".cp-price.cp-banner").removeClass("cp-true");
              $(".honne").removeClass("cp-true");
              $(".wimax_hikaku").removeClass("cp-true");
              $(".everbest").removeClass("cp-true");
            }

            //エクシディア経由なら返却パック0円キャンペーンを出す
            if($('#support_option_04').prop('checked') &&
              flagHonne == true || flagWimaxhikaku == true || flagEvervest == true || flagMobistar == true){
            }
          //それ以外
          }else{
            campaign_params = "";
            flagHonne = false;
            flagWimaxhikaku = false;
            flagEvervest = false;
            flagMobistar = false;
            $(".honne, .wimax_hikaku, .everbest").removeClass("cp-true");
            $(".cp-price").removeClass("cp-true");
          }
        }
      }
    }

    if(window.location.pathname.includes("/confirm")){
      if(op2){
        var op2_in = $('#support_option_03').closest('.entry-option-select').find('.topping-2-select-area-relief-option');
        op2_in.click();
      }

      if(op2_date){
        op2_date_in.datepicker('setDate', op2_date);
        op2_date_in.datepicker('hide');
      }

      if(op2_time){
        op2_time_in.val(op2_time);
      }
    }

  }
});
// プラン情報パラメータ引き継ぎ end //////////////////////////////////////////////////////////////////////////////////////////////////

$(document).ready(function() {
  // URLを取得
  const urlParam = window.location.search;
  // パラメータを取得
  const params = new URLSearchParams(urlParam);
  const tagName = params.get('op1');
  // マーケットIDを取得
  const mid_params = params.get('mid');

  /* 端末サポートワイドをデフォルトチェック */
  if (window.location.pathname.includes("/entry/overseas/select")) {
    /* フォーム内で戻ってきた場合、または価格コム経由の場合はデフォルトチェックなし */
    if (document.URL.match(tagName) || mid_params == 1) {
      return;
    } else {
      $("#support_option_02").click();
      $(".topping-2-select-area-relief-option.relief-item-select-area-wide").addClass("selected");
    }
  }
});

$(document).ready(function() {
    let urlParamUser = window.location.search;
    let paramsUser = new URLSearchParams(urlParamUser);
    let tagNameUser = paramsUser.get('op2_time');
    let tagNameUnspecified = "00";
    var is_prior_delivery = "ご出発日3日前までにお届けいたします。";
  /* 事前配送OPデフォルトチェック */
  $('#zipcode_1,#zipcode_2').on('click change', function(){
    if(window.location.pathname.includes("/entry/overseas/select")){
      if (document.URL.match(tagNameUser)){
        return;
      }else{
        $("#support_option_03").prop("checked",true);
        $(".relief-item-select-area3").addClass("selected");
        $(".overseas-select-inner-box .form-item-delivery-time").val('00');
      }
    }
  })
  /* 事前配送OPの値で出し分け */
  if(window.location.pathname.includes("/entry/overseas/user")){
    //事前配送OP選択しいるかどうかを配送予定日のテキストで判断
    if($(".pick-up-date").text() == is_prior_delivery){
      //事前配送OPなし（時間指定なし）
      if (tagNameUser == tagNameUnspecified){
        $(".form-item-delivery-time option[value='00']").addClass("selected");
        $(".form-item-delivery-time").val('00');
        return;
      }
    //事前配送OPあり
    }else{
      $(".user-delivery-time").hide();
    }
  };
});

$(document).ready(function() {
  if(window.location.pathname.includes("/entry/overseas/confirm")){
    if ($("#support_option_03").prop("checked") == false){
      return;
    }else if($("#support_option_03").prop("checked") == true){
      $(".confirm-delivery-time").hide();
    }
  };
});

$(document).ready(function() {
  // URLを取得
  const urlParam3 = window.location.search;
  // パラメータを取得
  const paramsOP3 = new URLSearchParams(urlParam3);
  const tagNameOP3 = paramsOP3.get('op3');
  // マーケットIDを取得
  const mid_params = params.get('mid');

  /* 返却パックデフォルトチェック */
  if (window.location.pathname.includes("/entry/overseas/select")) {
    /* フォーム内で戻ってきた場合、またはエクシディア経由の場合、または価格コム経由の場合はデフォルトチェックなし*/
    if (document.URL.match(tagNameOP3) ||
      (mid_params == 1) ||
      campaign_params &&
      flagHonne == true || flagWimaxhikaku == true || flagEvervest == true || flagMobistar == true) {
      return;
    } else {
      $("#support_option_04").prop("checked",true);
      $(".relief-item-select-area4").addClass("selected");
    }
  }
});

$(document).ready(function() {
  if($(".user-delivery-time").css('display')=='none'){
    var timetext = $(".form-item-delivery-time option:selected").text();
    if(timetext == "指定無し") {
      $(timetext).text("時間指定無し");
    }
    $(".pick-up-date").append("  "+timetext);
  }
});
