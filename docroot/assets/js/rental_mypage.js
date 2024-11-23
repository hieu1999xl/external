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
    }
  })
  // 開始日を変更した場合の処理 start
  .on('changeDate', function (selected) {
    var val_from = $('input[name="rental_start_date"]').val();

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
    }
  })
  // bootstrap-datepicker 終了日 end
})
// カレンダー（bootstrap-datepicker）設定 end //////////////////////////////////////////////////////////////////////////////////

// 表示制御 start ////////////////////////////////////////////////////////////////////////////////////////////////
$('.input-sm,.topping-2-select-area,#device_option_true,.form-item-delivery').on('click change', function(){
  var val_from = $('input[name="rental_start_date"]').val();
  var val_to = $('input[name="rental_end_date"]').val();

  // 開始日・終了日ともに選択されている場合の処理 start
  if(val_from != "" && val_to != "" && val_from != " " && val_to != " "){
    // 日付オブジェクトを生成
    var day_from = new Date(val_from);
    var day_to = new Date(val_to);

    // 日数の計算（選択画面表示用）86,400,000ミリ秒＝1日（1000ミリ秒×60秒×60分×24時間×365日）
    termDay = '<span>渡航期間</span><span class="overseas-current-terms">' + ((( day_to - day_from ) / 86400000) + 1) + '</span><span>日間</span>';

    $('.input-group-range-text').removeClass('overseas-term-disabled');

    var selectedDataPlan = $("._dataplans option:selected");
    var place = 0;
    var boxes = $('input#data-charge-agreement-checkbox:checked');
    var dataplan = $("._dataplans option:selected").text();

    if (selectedDataPlan.length > 0 && dataplan !== "選択してください") {
      var dataplanIndex = $("._dataplans").prop("selectedIndex") - 1;
      var area = $("._areas").val();
      var country = $("._countries").val();

      if($('[id=travel-type-single]').prop('checked')){
        var plans = gCountries[area][country];
      } else if ($('[id=travel-type-tour]').prop('checked')) {
        var plans = gCountriesForTour[area][country];
      }

      place = parseFloat(plans[dataplanIndex].replace(/,/g, ""));
    }
    // 追加プランの料金
    var OverseasPrice_comma = String(place).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'); //←←←←←←←←←←←←←←←←←←←←←←←←←バックエンドから【料金】の値もらったら"800"のところに差し替え
    var OverseasPrice_all = place * ((( day_to - day_from ) / 86400000) + 1); //←←←←←←←←←←←←←←←←←←←←←←←←←バックエンドから【料金】の値もらったら"800"のところに差し替え
    var OverseasPrice_all_comma = String(OverseasPrice_all).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    
    // 追加プランの期間計算
    var OverseasStart_text = $('.overseas-all-start').text();
    var OverseasStart = new Date(OverseasStart_text);
    var allTermDay = ((( day_to - OverseasStart ) / 86400000) + 1);

    // 全日程の差分
    var allTermDay_difference = allTermDay - allTermDay_first;

    // オプション料金の抽出
    var overseasOption_price_text = "";
    var overseasOption_price = 0;
    if ($('.overseas-option-price').length > 0){
      overseasOption_price_text = $('.overseas-option-price').text();
      overseasOption_price = parseFloat(overseasOption_price_text.replace(/,/g, ""));
    }

    var day_overdue;
    var OverseasPrice_all_overdue;

    if(OverseasEnd_first < day_from){
    // 延滞料金の処理（全工程の渡航終了日より追加国の渡航開始日が遅かった場合）
      day_overdue = (( day_from - OverseasEnd_first ) / 86400000) - 1;
      if (day_overdue === 0) {
        OverseasPrice_all_overdue = 0;

        $(".overseas-overdue-detail").hide();
      } else {
        OverseasPrice_all_overdue = 2000 * day_overdue;
        var OverseasPrice_all_overdue_comma = String(OverseasPrice_all_overdue).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

        $(".overseas-overdue-detail").show();
        $(".overseas-overdue-detail-sp").show();
        $(".add-price-overdue").html("2,000 円 ✕ " + day_overdue + " 日");
        $(".add-all-overdue").html(OverseasPrice_all_overdue_comma);
      }
    }else{
      day_overdue = 0;
      OverseasPrice_all_overdue = 0;

      $(".overseas-overdue-detail").hide();
    }	

    allTermDay_difference = allTermDay_difference - day_overdue;
    if(OverseasEnd_first < day_to){
    // 全日程が延びた場合のオプション料金の計算
      var overseasOption_all_price = overseasOption_price * allTermDay_difference;
      var overseasOption_all_price_comma = String(overseasOption_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      var overseasOption_all_price_tax = overseasOption_all_price * 0.1;
      var overseasOption_all_price_tax_comma = String(overseasOption_all_price_tax).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

      $('.overseas-all-end').text(val_to);
      $('.overseas-all-terms').text(allTermDay);
      if ($('.overseas-option-detail').length > 0){
        $('.overseas-option-detail').show();
      }
      $('.table-overseas-add-bottom').show();
      $('.overseas-all-terms-difference').text(allTermDay_difference);
      $('.overseas-option-all-price').text(overseasOption_all_price_comma);
      $('.overseas-tax').text(overseasOption_all_price_tax_comma);
    }else{
      // 全日程が延びなかった場合のオプション料金の計算
      $('.overseas-all-end').text(OverseasEnd_first_text);
      $('.overseas-all-terms').text(allTermDay_first_text);
      $('.overseas-option-detail').hide();
      $('.table-overseas-add-bottom').hide();
    }

    if (selectedDataPlan.length > 0 && dataplan !== "選択してください" && val_from != "" && val_to != "" && val_from != " " && val_to != " ") {
    // 追加の渡航期間 & プランが選択されている場合
      // 変更内容を表示する
      $(".form-user-background").show();

      // 追加プランの料金計算
      $(".add-price").html(OverseasPrice_comma + " 円 ✕ " + ((( day_to - day_from ) / 86400000) + 1) + " 日");
      $(".add-price-show").removeClass("add-hide");
      $(".add-all").html(OverseasPrice_all_comma);

      // 合計金額の計算
      var overseas_all_price_overdue = OverseasPrice_all + overseasOption_all_price + overseasOption_all_price_tax + OverseasPrice_all_overdue;
      var overseas_all_price_overdue_comma = String(overseas_all_price_overdue).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      var overseas_all_price = OverseasPrice_all + overseasOption_all_price + overseasOption_all_price_tax;
      var overseas_all_price_comma = String(overseas_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      if(OverseasEnd_first < day_to){
        if(OverseasEnd_first < day_from){
          $('.overseas-all-price').html('<span class="bold">' + overseas_all_price_overdue_comma + '</span> 円');
        }else{
          $('.overseas-all-price').html('<span class="bold">' + overseas_all_price_comma + '</span> 円');
        }
      }else{
        $('.overseas-all-price').html('<span class="bold">' + OverseasPrice_all_comma + '</span> 円');
      }
    } else {
    // そうでない場合
      // 変更内容を非表示、合計金額をリセットする
      $(".form-user-background").hide();
      $(".overseas-all-price").html('<span class="bold">0</span> 円');

      // 追加プラン料金欄の非表示
      $(".add-price").html("");
      $(".add-all").html("");
    }	

    if (selectedDataPlan.length > 0 && dataplan !== "選択してください" && val_from != "" && val_to != "" && val_from != " " && val_to != " " && boxes.length > 0 && val_to >= val_from) {
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

    // 日数の計算（料金計算用）
    termDayHidden = ((( day_to - day_from ) / 86400000) + 1);

    $('.input-group-range-text').html(termDay);

    $('.input-group-range-text-hidden').html(termDayHidden);
  
  }else{
  }
  // 開始日・終了日ともに選択されている場合の処理 end
});
// 表示制御 end //////////////////////////////////////////////////////////////////////////////////////////////////
