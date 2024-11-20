// 1ヶ国プランの場合のセレクトタグ start ////////////////////////////////////////////////////////////////////////////////////////////////
function singleType(){
  $("._areas").html("<option disabled selected>エリアを選択</option>"); //初期化
  $("._countries").html("<option disabled selected>国を選択</option>"); //初期化
  $('.js-popular-country').removeClass('selected');
  $('.overseas-country-flex').removeClass('hide');

  for (var area in gCountries) {
    var innerHtml = ""
    for (var country in gCountries[area]){
      if (country === "中国") {
        innerHtml += '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中。中国(VPN)をご購入ください）</option>'
      } else if (country === "ミャンマー") {
        innerHtml += '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中）</option>'
      } else if (country === "バングラデシュ" || country === "バングラディッシュ") {
        innerHtml += '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中）</option>'
      } else {
        var line = '<option data-area="'+area+'" value="'+country+'">'+country+'</option>'
        innerHtml += line;
      }
    }
    var lineOptGroup = "";
    lineOptGroup += '<optgroup label="'+area+'">';
    lineOptGroup += innerHtml;
    lineOptGroup += '</optgroup>';
    // Add optgroup to coutries
    $(".search-by-country-name-select").append(lineOptGroup);
    $("._countries").append(lineOptGroup);

    // Add area to area
    var areaLine = '<option value="'+area+'">'+area+'</option>'
    $("._areas").append(areaLine);

    // サービスサイト（海外利用ページ）の「エリア」表示 start
    var _map = {
        "アフリカ": "africa",
        "アジア": "asia",
        "オセアニア": "oceania",
        "ヨーロッパ": "europe",
        "北アメリカ": "north-america",
        "南アメリカ": "south-america"
    };
    var alphabet_area = _map[area];

    if(area == 'アジア'){
    // 「エリア」が「アジア」だったらclassに「overseas-category-box-selected」（初期選択）をつける
      var areaLines = '<div category="'+alphabet_area+'" class="faq-nav-icon-box nav-icon-box overseas-category-box overseas-category-box-selected">'
      +'<div class="nav-box">'
      +'<div class="nav-box-text">'
      +area
      +'</div>'
      +'</div>'
      +'</div>';
    } else {
    // 「エリア」がそれ以外だったら
      var areaLines = '<div category="'+alphabet_area+'" class="faq-nav-icon-box nav-icon-box overseas-category-box">'
      +'<div class="nav-box">'
      +'<div class="nav-box-text">'
      +area
      +'</div>'
      +'</div>'
      +'</div>';
    }
    // 「エリア」を挿入する
    $("._areas_s").append(areaLines);
    // サービスサイト（海外利用ページ）の「エリア」表示 end

    // サービスサイト（海外利用ページ）の「国名」「料金」表示 start
    var planAreas = '#overseas-category-' + alphabet_area;
    var planArea = $(planAreas).find('.plan-area');

    // 「エリア」に分類される「国名」とその「料金」をforで回す
    for (var country in gCountries[area]){
      var plans = gCountries[area][country];
      var planHtmls = '<tr>'
      +'<td>'+country+'</td>'
      +'<td class="plan-300m overseas-table-unselected">'+plans[0]+'円</td>'
      +'<td class="plan-1g">'+plans[1]+'円</td>'
      +'<td class="plan-3g overseas-table-unselected">'+plans[2]+'円</td>'
      +'</tr>';

      // 該当する「エリア」毎に挿入する（以下5か国はファーストビューで表示されるようにする）（DB順に処理）
      var planArea_p = $(planAreas).find('.plan-area tr').eq(0);
      if(country == '中国'){
        // $(planArea).prepend(planHtmls);
      } else if(country == '中国(VPN)') {
        $(planArea).prepend(planHtmls);
      } else if(country == '台湾') {
        $(planArea).prepend(planHtmls);
      } else if(country == '韓国') {
        $(planArea).prepend(planHtmls);
      } else if(country == '香港') {
        $(planArea_p).after(planHtmls);
      } else {
      // 5か国以外は下に順次追加していく
        $(planArea).append(planHtmls);
      }
    }
    // サービスサイト（海外利用ページ）の「国名」「料金」表示 end
  };
  function hiraToKana(str) {
    return str.replace(/[\u3041-\u3096]/g, function(match) {
      var chr = match.charCodeAt(0) + 0x60;
      return String.fromCharCode(chr);
    });
  };

  function customMatcher(params, data) {
    // https://select2.org/searching#matching-grouped-options

    var words = params.term;
    var areaCountries = data.children;

    // When got no input.
    if(words === undefined) {
      return data;
    }
    var kanaWord = hiraToKana(words);

    // For "Click and search" option
    if (areaCountries === undefined) {
      return null;
    }

    // matches for child countries of area
    var filteredChildren = [];
    areaCountries.forEach(function(country){
      var countryText = country.text;

      if(countryText.indexOf(words) > -1) {
        // Input includes kana
        filteredChildren.push(country);
      } else if(countryText.indexOf(kanaWord) > -1) {
        // When input includes hira and matchs kana
        filteredChildren.push(country);
      }
    });

    if (filteredChildren.length) {
      var modifiedData = $.extend({}, data, true);
      modifiedData.children = filteredChildren;

      return modifiedData;
    }
    // return null if no child matches;
    return null;
  }

  // Initialinze select2
  $('.search-by-country-name-select').select2({
    matcher: customMatcher,
    width: 'resolve'
  });
}

// 周遊プランの場合のセレクトタグ start ////////////////////////////////////////////////////////////////////////////////////////////////
function tourType(){
  $("._areas").html("<option disabled selected>エリアを選択</option>"); //初期化
  $("._countries").html("<option disabled selected>国を選択</option>"); //初期化
  $('.js-popular-country').removeClass('selected');
  $('.overseas-country-flex').addClass('hide');

  for (var area in gCountriesForTour) {
    var innerHtml = ""
    for (var country in gCountriesForTour[area]){
      var line = '<option data-area="'+area+'" value="'+country+'">'+country+'</option>'
      innerHtml += line;
    }
    var lineOptGroup = "";
    lineOptGroup += '<optgroup label="'+area+'">';
    lineOptGroup += innerHtml;
    lineOptGroup += '</optgroup>';
    // Add optgroup to coutries
    $(".search-by-country-name-select").append(lineOptGroup);
    $("._countries").append(lineOptGroup);

    // Add area to area
    var areaLine = '<option value="'+area+'">'+area+'</option>'
    $("._areas").append(areaLine);

    // サービスサイト（海外利用ページ）の「エリア」表示 start
    var _map = {
      "アフリカ": "africa",
      "アジア": "asia",
      "オセアニア": "oceania",
      "ヨーロッパ": "europe",
      "北アメリカ": "north-america",
      "南アメリカ": "south-america"
    };
    var alphabet_area = _map[area];

    if(area == 'アジア'){
    // 「エリア」が「アジア」だったらclassに「overseas-category-box-selected」（初期選択）をつける
      var areaLines = '<div category="'+alphabet_area+'" class="faq-nav-icon-box nav-icon-box overseas-category-box overseas-category-box-selected">'
      +'<div class="nav-box">'
      +'<div class="nav-box-text">'
      +area
      +'</div>'
      +'</div>'
      +'</div>';
    } else {
    // 「エリア」がそれ以外だったら
      var areaLines = '<div category="'+alphabet_area+'" class="faq-nav-icon-box nav-icon-box overseas-category-box">'
      +'<div class="nav-box">'
      +'<div class="nav-box-text">'
      +area
      +'</div>'
      +'</div>'
      +'</div>';
    }
    // 「エリア」を挿入する
    $("._areas_s").append(areaLines);
    // サービスサイト（海外利用ページ）の「エリア」表示 end

    // サービスサイト（海外利用ページ）の「国名」「料金」表示 start
    var planAreas = '#overseas-category-' + alphabet_area;
    var planArea = $(planAreas).find('.plan-area');

    // 「エリア」に分類される「国名」とその「料金」をforで回す
    for (var country in gCountriesForTour[area]){
      var plans = gCountriesForTour[area][country];
      var planHtmls = '<tr>'
      +'<td>'+country+'</td>'
      +'<td class="plan-300m overseas-table-unselected">'+plans[0]+'円</td>'
      +'<td class="plan-1g">'+plans[1]+'円</td>'
      +'<td class="plan-3g overseas-table-unselected">'+plans[2]+'円</td>'
      +'</tr>';

      // 該当する「エリア」毎に挿入する（以下5か国はファーストビューで表示されるようにする）（DB順に処理）
      var planArea_p = $(planAreas).find('.plan-area tr').eq(0);
      if(country == '中国'){
        // $(planArea).prepend(planHtmls);
      } else if(country == '中国(VPN)') {
        $(planArea).prepend(planHtmls);
      } else if(country == '台湾') {
        $(planArea).prepend(planHtmls);
      } else if(country == '韓国') {
        $(planArea).prepend(planHtmls);
      } else if(country == '香港') {
        $(planArea_p).after(planHtmls);
      } else {
      // 5か国以外は下に順次追加していく
        $(planArea).append(planHtmls);
      }
    }
    // サービスサイト（海外利用ページ）の「国名」「料金」表示 end
  };

  function hiraToKana(str) {
    return str.replace(/[\u3041-\u3096]/g, function(match) {
      var chr = match.charCodeAt(0) + 0x60;
      return String.fromCharCode(chr);
    });
  };

  function customMatcher(params, data) {
    // https://select2.org/searching#matching-grouped-options

    var words = params.term;
    var areaCountries = data.children;

    // When got no input.
    if(words === undefined) {
      return data;
    }
    var kanaWord = hiraToKana(words);

    // For "Click and search" option
    if (areaCountries === undefined) {
      return null;
    }

    // matches for child countries of area
    var filteredChildren = [];
    areaCountries.forEach(function(country){
      var countryText = country.text;

      if(countryText.indexOf(words) > -1) {
        // Input includes kana
        filteredChildren.push(country);
      } else if(countryText.indexOf(kanaWord) > -1) {
        // When input includes hira and matchs kana
        filteredChildren.push(country);
      }
    });

    if (filteredChildren.length) {
      var modifiedData = $.extend({}, data, true);
      modifiedData.children = filteredChildren;

      return modifiedData;
    }
    // return null if no child matches;
    return null;
  }
}
// 周遊プランの場合のセレクトタグ end ////////////////////////////////////////////////////////////////////////////////////////////////

// ファーストビューではセレクトタグを1ヶ国に切替 start ////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {
  singleType();
});
// ファーストビューではセレクトタグを1ヶ国に切替 end ////////////////////////////////////////////////////////////////////////////////////////////////

// セレクトタグの国/周遊の切替 start ////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {
  $('[name="travel_type"]:radio').change( function() {
    if($('[id=travel-type-single]').prop('checked')){
      singleType();
    } else if ($('[id=travel-type-tour]').prop('checked')) {
      $(".reception-stopped").hide();
      tourType();
    } 
  });
});
// セレクトタグの国/周遊の切替 end ////////////////////////////////////////////////////////////////////////////////////////////////

var plans0_id;
var plans1_id;
var plans2_id;
var plans0;
var plans1;
var plans2;

function changePlan(area, country){
  var planHtml = "";

  if($('[id=travel-type-single]').prop('checked')){
    var plans = gCountries[area][country];
    var planIds = gCountriesPlanId[area][country];

    planHtml += "<option disabled>選択してください</option>";
    planHtml += "<option value='" + planIds[0] + "'" + " alt='" + plans[0] + "'>1日500MBプラン</option>";
    planHtml += "<option value='" + planIds[1] + "'" + " alt='" + plans[1] + "'>1日1GBプラン</option>";
    planHtml += "<option value='" + planIds[2] + "'" + " alt='" + plans[2] + "' selected>無制限プラン</option>";
    $("._dataplans").html(planHtml);
    $("._dataplans").attr("disabled", false);

    plans0_id = planIds[0];
    plans1_id = planIds[1];
    plans2_id = planIds[2];
    plans0 = plans[0];
    plans1 = plans[1];
    plans2 = plans[2];
  } else if ($('[id=travel-type-tour]').prop('checked')) {
    var plans = gCountriesForTour[area][country];
    var planIds = gCountriesPlanIdForTour[area][country];

    planHtml += "<option disabled>選択してください</option>";
    planHtml += "<option value='" + planIds[0] + "'" + " alt='" + plans[0] + "'>1日500MBプラン</option>";
    planHtml += "<option value='" + planIds[1] + "'" + " alt='" + plans[1] + "'>1日1GBプラン</option>";
    planHtml += "<option value='" + planIds[2] + "'" + " alt='" + plans[2] + "' selected>無制限プラン</option>";
    $("._dataplans").html(planHtml);
    $("._dataplans").attr("disabled", false);

    plans0_id = planIds[0];
    plans1_id = planIds[1];
    plans2_id = planIds[2];
    plans0 = plans[0];
    plans1 = plans[1];
    plans2 = plans[2];
  } 
};

function lookupArea(country){
  if($('[id=travel-type-single]').prop('checked')){
    for (var area in gCountries) {
      if(country in gCountries[area]){
        return area;
      }
    }
  } else if ($('[id=travel-type-tour]').prop('checked')) {
    for (var area in gCountriesForTour) {
      if(country in gCountriesForTour[area]){
        return area;
      }
    }
  } 
}

$(document).ready(function() {
  $(".search-by-country-name-select").change(function(){
    var optionSelected = $("option:selected", this);
    var area = optionSelected.attr('data-area');
    var country = optionSelected.attr('value');

    $("._areas").val(area);
    _areaSelected(area);

    $("._countries").val(country);

    changePlan(area, country);
    var scrollTarget = $("#purchase-overseas-plan");
    scrollToHash(scrollTarget, 'header.mypage-header');
  })

  $("._areas").change(function(){
    var optionSelected = $("option:selected", this);
    var area = optionSelected.val()
    _areaSelected(area);
  })

  $("._countries").change(function(){
    var optionSelected = $("option:selected", this);
    var country = optionSelected.val();

    if($('[id=travel-type-single]').prop('checked')){
      var area = lookupArea(country);
    } else if ($('[id=travel-type-tour]').prop('checked')) {
      var area = $("._areas").val();
    }

    _areaSelected(area);
    $("._areas").val(area);
    $("._countries").val(country);
    changePlan(area, country);
  })

  // エリア、国、プラン、同意欄を変更したら
  $("._areas, ._countries, ._dataplans, input#data-charge-agreement-checkbox").on('change', function(){

    var area = $("._areas").val();
    var country = $("._countries").val();
    var dataplan = $("._dataplans option:selected").text();
    var dataplanIndex = $("._dataplans").prop("selectedIndex") - 1;

    var planName = country + "<br>" + dataplan;
    $("p.popup-kaigai-text").html(planName);

    // Look up to planOptionIds in overseas/edit/index.html
    // var planOption = planOptionIds[country][dataplanIndex];
    // $("#plan-option").val(planOption);

    var selectedDataPlan = $("._dataplans option:selected");
    var place = 0;
    var val_from = $('input[name="rental_start_date"]').val();
    var val_to = $('input[name="rental_end_date"]').val();
    var boxes = $('input#data-charge-agreement-checkbox:checked');

    var country_number = $('.overseas-term').length - 1;

    var val_from = $('input[name="rental_start_date"]').val();
    var val_to = $('input[name="rental_end_date"]').val();

    var day_from = new Date(val_from);
    var day_to = new Date(val_to);

    if ($('[id=travel-type-single]').prop('checked')) {
      var plans = gCountries[area][country];
      var plannames = gCountriesPlanName[area][country];
    } else if ($('[id=travel-type-tour]').prop('checked')) {
      var plans = gCountriesForTour[area][country];
      var plannames = gCountriesPlanNameForTour[area][country];

      $(".reception-stopped").hide();
      if (area == "アジア") {
        $(".reception-stopped").show();
      } else if (area == "全世界") {
        $(".reception-stopped").show();
      }
    }

    if (country) {
      // プランが選択されている場合
      if (selectedDataPlan.length > 0 && dataplan !== "選択してください" ) {
        place = parseFloat(plans[dataplanIndex].replace(/,/g, ""));
        // プラン名を表示する
        $(".overseas-add-country").show();
        $(".overseas-add-country-sp").text("");
        if($('[id=travel-type-single]').prop('checked')){
          $(".add-plan").html(country_number + "ヶ国目　<br class='sp'>" + plannames[dataplanIndex]);
        } else if ($('[id=travel-type-tour]').prop('checked')) {
          $(".add-plan").html(country_number + "ヶ国目　<br class='sp'>" + plannames[dataplanIndex]);
        }
      } else {
        // プラン名を非表示にする
        $(".overseas-add-country").hide();
        $(".overseas-add-country-sp").text("小計");
        $(".add-plan").html("");
      }
    }

    var OverseasPrice_comma = String(place).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'); //←←←←←←←←←←←←←←←←←←←←←←←←←バックエンドから【料金】の値もらったら"800"のところに差し替え
    var OverseasPrice_all = place * ((( day_to - day_from ) / 86400000) + 1); //←←←←←←←←←←←←←←←←←←←←←←←←←バックエンドから【料金】の値もらったら"800"のところに差し替え
    var OverseasPrice_all_comma = String(OverseasPrice_all).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

    // 追加プランの期間計算
    var OverseasStart_text = $('.overseas-all-start').text();
    var OverseasStart = new Date(OverseasStart_text);
    var allTermDay = ((( day_to - OverseasStart ) / 86400000) + 1);

    // 全日程の差分
    var allTermDay_difference = allTermDay - allTermDay_first;

    if(allTermDay_difference < 0){
      allTermDay_difference = 0;
    }

    // オプション料金の抽出
    var overseasOption_price_text = "";
    var overseasOption_price = 0;
    if ($('.overseas-option-price').length > 0){
      overseasOption_price_text = $('.overseas-option-price').text();
      overseasOption_price = parseFloat(overseasOption_price_text.replace(/,/g, ""));
    }

    // 延滞料金
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
      $('.overseas-option-all-price').text(overseasOption_all_price_comma);
      $('.overseas-tax').text(overseasOption_all_price_tax_comma);
    }else{
    // 全日程が延びなかった場合のオプション料金の計算
      var overseasOption_all_price = overseasOption_price * allTermDay_first;
      var overseasOption_all_price_comma = String(overseasOption_all_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      var overseasOption_all_price_tax = overseasOption_all_price * 0.1;
      var overseasOption_all_price_tax_comma = String(overseasOption_all_price_tax).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      $('.overseas-all-end').text(OverseasEnd_first_text);
      $('.overseas-all-terms').text(allTermDay_first_text);
      $('.overseas-option-all-price').text(overseasOption_all_price_comma);
      $('.overseas-tax').text(overseasOption_all_price_tax_comma);
    }

    if (selectedDataPlan.length > 0 && dataplan !== "選択してください" && val_from != "" && val_to != "" && val_from != " " && val_to != " ") {
    // 追加の渡航期間 & プランが選択されている場合

      // 変更内容を表示する
      $(".form-user-background").show();

      // 追加プランの料金計算
      $(".add-price").html(OverseasPrice_comma + " 円 ✕ " + ((( day_to - day_from ) / 86400000) + 1) + " 日");
      $(".add-price-show").removeClass("add-hide");
      $(".add-all").html(OverseasPrice_all_comma);
      var overseasOption_all_price = overseasOption_price * allTermDay_difference;
      var overseasOption_all_price_tax = overseasOption_all_price * 0.1;

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
  });

  $(function(){
    $('.worldmap-map area').hover(
      function() {
        $(".worldmap-img").removeClass("active");
        $(".worldmap-img").addClass("inactive");
        var area = $(this).attr('data-area');
        var selector = '.worldmap-' + area;
        $(selector).removeClass("inactive");
        $(selector).addClass("active");
      },
      function() {
        $(".worldmap-img").removeClass("active");
        $(".worldmap-img").addClass("inactive");

        $(".worldmap-img.selected").removeClass("inactive");
        $(".worldmap-img.selected").addClass("active");
      }
    )
  });
  $(function () {
    if (!$.fn['rwdImageMaps']) return;
    $('img[usemap]').rwdImageMaps();
  });

});

function areaSelected(area){
  _areaSelected(area);
}

function changeAreaClass(area){
  var _map = {
    "アフリカ": "africa",
    "アジア": "asia",
    "オセアニア": "oceania",
    "ヨーロッパ": "europe",
    "北アメリカ": "north-america",
    "南アメリカ": "south-america"
  };
  var alphabet_area = _map[area];
  var selector = '.worldmap-' + alphabet_area;

  $(".worldmap-img").removeClass("selected");
  $(".worldmap-img").removeClass("active");
  $(".worldmap-img").addClass("inactive");
  $(selector).addClass("selected");
  $(selector).removeClass("inactive");
  $(selector).addClass("active");
}

function _areaSelected(area){
  if($('[id=travel-type-single]').prop('checked')){
    $("._areas").val(area);
    var innerHtml = ""
    for (var country in gCountries[area]){
      if (country === "中国") {
        innerHtml += '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中。中国(VPN)をご購入ください）</option>'
      } else if (country === "ミャンマー") {
        innerHtml += '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中）</option>'
      } else if (country === "バングラデシュ" || country === "バングラディッシュ") {
        innerHtml += '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中）</option>'
      }  else {
        var line = '<option data-area="'+area+'" value="'+country+'">'+country+'</option>'
        innerHtml += line;
      }
    }
    var lineOptGroup = "<option disabled selected>選択してください</option>";
    lineOptGroup += '<optgroup label="'+area+'">';
    lineOptGroup += innerHtml;
    lineOptGroup += '</optgroup>';

    // Add optgroup to coutries
    $("._countries").html(lineOptGroup);

    changeAreaClass(area);
    $("._dataplans").attr("disabled", true);
  } else if ($('[id=travel-type-tour]').prop('checked')) {
    $("._areas").val(area);
    var innerHtml = ""
    for (var country in gCountriesForTour[area]){
      var line = '<option data-area="'+area+'" value="'+country+'">'+country+'</option>'
      innerHtml += line;
    }
    var lineOptGroup = "<option disabled selected>選択してください</option>";
    lineOptGroup += '<optgroup label="'+area+'">';
    lineOptGroup += innerHtml;
    lineOptGroup += '</optgroup>';

    // Add optgroup to coutries
    $("._countries").html(lineOptGroup);

    changeAreaClass(area);
    $("._dataplans").attr("disabled", true);
  }
}
