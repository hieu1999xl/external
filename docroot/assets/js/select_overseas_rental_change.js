// select2
$(document).ready(function() {
  for (var area in gCountries) {
    var innerHtml = ""
    for (var country in gCountries[area]){
      if (country === "中国") {
        innerHtml += '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中。中国(VPN)をご購入ください）</option>'
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

});

function changePlan1(area, country){
  if(country1 == '周遊') {
    var plans = gCountriesForTour[area][country];
    var planIds = gCountriesPlanIdForTour[area][country];
  }else {
    var plans = gCountries[area][country];
    var planIds = gCountriesPlanId[area][country];
  }

  var planHtml = "";
  planHtml += "<option value='' selected>選択してください</option>";
  planHtml += "<option value='" + planIds[0] + "'" + ">500MBプラン "+plans[0]+"円（免税）</option>";
  planHtml += "<option value='" + planIds[1] + "'" + ">1GBプラン "+plans[1]+"円（免税）</option>";
  planHtml += "<option value='" + planIds[2] + "'" + ">無制限プラン "+plans[2]+"円（免税）</option>";
  $("._dataplans1").html(planHtml);
  $("._dataplans1").attr("disabled", false);

  if(plan1_id == planIds[0]){
    $('option[value="' + planIds[0] + '"]').remove();
  }else if(plan1_id == planIds[1]){
    $('option[value="' + planIds[0] + '"]').remove();
    $('option[value="' + planIds[1] + '"]').remove();
  }else if(plan1_id == planIds[2]){
    $('.overseas-change-dataplan-1').html('<span class="red-text">プラン変更不可のプランです</span><select name="plan_option[]" class="_dataplans1" hidden><option value="" selected></option></select>');
  }
};

function changePlan2(area, country){
  if(country2 == '周遊') {
    var plans = gCountriesForTour[area][country];
    var planIds = gCountriesPlanIdForTour[area][country];
  }else {
    var plans = gCountries[area][country];
    var planIds = gCountriesPlanId[area][country];
  }

  var planHtml = "";
  planHtml += "<option value='' selected>選択してください</option>";
  planHtml += "<option value='" + planIds[0] + "'" + ">500MBプラン "+plans[0]+"円（免税）</option>";
  planHtml += "<option value='" + planIds[1] + "'" + ">1GBプラン "+plans[1]+"円（免税）</option>";
  planHtml += "<option value='" + planIds[2] + "'" + ">無制限プラン "+plans[2]+"円（免税）</option>";
  $("._dataplans2").html(planHtml);
  $("._dataplans2").attr("disabled", false);

  if(plan2_id == planIds[0]){
    $('option[value="' + planIds[0] + '"]').remove();
  }else if(plan2_id == planIds[1]){
    $('option[value="' + planIds[0] + '"]').remove();
    $('option[value="' + planIds[1] + '"]').remove();
  }else if(plan2_id == planIds[2]){
    $('.overseas-change-dataplan-2').html('<span class="red-text">プラン変更不可のプランです</span><select name="plan_option[]" class="_dataplans2" hidden><option value="" selected></option></select>');
  }
};

function changePlan3(area, country){
  if(country3 == '周遊') {
    var plans = gCountriesForTour[area][country];
    var planIds = gCountriesPlanIdForTour[area][country];
  }else {
    var plans = gCountries[area][country];
    var planIds = gCountriesPlanId[area][country];
  }

  var planHtml = "";
  planHtml += "<option value='' selected>選択してください</option>";
  planHtml += "<option value='" + planIds[0] + "'" + ">500MBプラン "+plans[0]+"円（免税）</option>";
  planHtml += "<option value='" + planIds[1] + "'" + ">1GBプラン "+plans[1]+"円（免税）</option>";
  planHtml += "<option value='" + planIds[2] + "'" + ">無制限プラン "+plans[2]+"円（免税）</option>";
  $("._dataplans3").html(planHtml);
  $("._dataplans3").attr("disabled", false);

  if(plan3_id == planIds[0]){
    $('option[value="' + planIds[0] + '"]').remove();
  }else if(plan3_id == planIds[1]){
    $('option[value="' + planIds[0] + '"]').remove();
    $('option[value="' + planIds[1] + '"]').remove();
  }else if(plan3_id == planIds[2]){
    $('.overseas-change-dataplan-3').html('<span class="red-text">プラン変更不可のプランです</span><select name="plan_option[]" class="_dataplans3" hidden><option value="" selected></option></select>');
  }
};

var existing_all_1 = 0;
var existing_all_2 = 0;
var existing_all_3 = 0;

// 1ヶ国目のプラン変更による処理
function selectPlan1(area, country){
  var version = $('#version').val();
  let market_name = '';
  if (version == '1') {
    market_name = '（価格.com特典）';
  }

  if(country1 == '周遊') {
    var plans = gCountriesForTour[area][country];
    var planIds = gCountriesPlanIdForTour[area][country];
    var planNames = gCountriesPlanNameForTour[area][country];
  }else {
    var plans = gCountries[area][country];
    var planIds = gCountriesPlanId[area][country];
    var planNames = gCountriesPlanName[area][country];
  }
  var today = new Date();
  var start_date = new Date(today.getFullYear(), today.getMonth(), today.getDate());
  if (start_date > plan1_start_date) {
    plan1_start_date = start_date;
  }
  var existing_terms_1 = Math.floor((( plan1_end_date - plan1_start_date ) / 86400000) + 1);

  if($('._dataplans1 option:selected').val() == planIds[0]){
    var plans0 = parseFloat(plans[0].replace(/,/g, ""));
    existing_all_1 = plans0 * existing_terms_1;
    var existing_all_1_comma = String(existing_all_1).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.form-user-background').show();
    $('.overseas-existing-1').show();
    $(".overseas-existing-price-1").text(plans[0]);
    $(".overseas-existing-terms-1").text(existing_terms_1);
    $(".overseas-existing-all-1").text(existing_all_1_comma);
  }else if($('._dataplans1 option:selected').val() == planIds[1]){
    var plans1 = parseFloat(plans[1].replace(/,/g, ""));
    var plans1_difference = plans1 - plan1_price;
    existing_all_1 = plans1_difference * existing_terms_1;
    var existing_all_1_comma = String(existing_all_1).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.form-user-background').show();
    $('.overseas-existing-1').show();
    $(".overseas-existing-price-1").text(plans1_difference);
    $(".overseas-existing-terms-1").text(existing_terms_1);
    $(".overseas-existing-all-1").text(existing_all_1_comma);
    $(".overseas-existing-changed-plan-1").html(planNames[1]);
  }else if($('._dataplans1 option:selected').val() == planIds[2]){
    var plans2 = parseFloat(plans[2].replace(/,/g, ""));
    var plans2_difference = plans2 - plan1_price;
    existing_all_1 = plans2_difference * existing_terms_1;
    var existing_all_1_comma = String(existing_all_1).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.form-user-background').show();
    $('.overseas-existing-1').show();
    $(".overseas-existing-price-1").text(plans2_difference);
    $(".overseas-existing-terms-1").text(existing_terms_1);
    $(".overseas-existing-all-1").text(existing_all_1_comma);
    $(".overseas-existing-changed-plan-1").html(planNames[2]);
  }else{
    existing_all_1 = 0;
    $('.overseas-existing-1').hide();
  }
};

// 2ヶ国目のプラン変更による処理
function selectPlan2(area, country){
  var version = $('#version').val();
  let market_name = '';
  if (version == '1') {
    market_name = '（価格.com特典）';
  }

  if(country2 == '周遊') {
    var plans = gCountriesForTour[area][country];
    var planIds = gCountriesPlanIdForTour[area][country];
    var planNames = gCountriesPlanNameForTour[area][country];
  }else {
    var plans = gCountries[area][country];
    var planIds = gCountriesPlanId[area][country];
    var planNames = gCountriesPlanName[area][country];
  }
  var today = new Date();
  var start_date = new Date(today.getFullYear(), today.getMonth(), today.getDate());
  if (start_date > plan2_start_date) {
    plan2_start_date = start_date;
  }
  var existing_terms_2 = Math.floor((( plan2_end_date - plan2_start_date ) / 86400000) + 1);

  if($('._dataplans2 option:selected').val() == planIds[0]){
    var plans0 = parseFloat(plans[0].replace(/,/g, ""));
    existing_all_2 = plans0 * existing_terms_2;
    var existing_all_2_comma = String(existing_all_2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.form-user-background').show();
    $('.overseas-existing-2').show();
    $(".overseas-existing-price-2").text(plans[0]);
    $(".overseas-existing-terms-2").text(existing_terms_2);
    $(".overseas-existing-all-2").text(existing_all_2_comma);
  }else if($('._dataplans2 option:selected').val() == planIds[1]){
    var plans1 = parseFloat(plans[1].replace(/,/g, ""));
    var plans1_difference = plans1 - plan2_price;
    existing_all_2 = plans1_difference * existing_terms_2;
    var existing_all_2_comma = String(existing_all_2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.form-user-background').show();
    $('.overseas-existing-2').show();
    $(".overseas-existing-price-2").text(plans1_difference);
    $(".overseas-existing-terms-2").text(existing_terms_2);
    $(".overseas-existing-all-2").text(existing_all_2_comma);
    $(".overseas-existing-changed-plan-2").html(planNames[1]);
  }else if($('._dataplans2 option:selected').val() == planIds[2]){
    var plans2 = parseFloat(plans[2].replace(/,/g, ""));
    var plans2_difference = plans2 - plan2_price;
    existing_all_2 = plans2_difference * existing_terms_2;
    var existing_all_2_comma = String(existing_all_2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.form-user-background').show();
    $('.overseas-existing-2').show();
    $(".overseas-existing-price-2").text(plans2_difference);
    $(".overseas-existing-terms-2").text(existing_terms_2);
    $(".overseas-existing-all-2").text(existing_all_2_comma);
    $(".overseas-existing-changed-plan-2").html(planNames[2]);
  }else{
    existing_all_2 = 0;
    $('.overseas-existing-2').hide();
  }
};

// 3ヶ国目のプラン変更による処理
function selectPlan3(area, country){
  var version = $('#version').val();
  let market_name = '';
  if (version == '1') {
    market_name = '（価格.com特典）';
  }

  if(country3 == '周遊') {
    var plans = gCountriesForTour[area][country];
    var planIds = gCountriesPlanIdForTour[area][country];
    var planNames = gCountriesPlanNameForTour[area][country];
  }else {
    var plans = gCountries[area][country];
    var planIds = gCountriesPlanId[area][country];
    var planNames = gCountriesPlanName[area][country];
  }
  var today = new Date();
  var start_date = new Date(today.getFullYear(), today.getMonth(), today.getDate());
  if (start_date > plan3_start_date) {
    plan3_start_date = start_date;
  }
  var existing_terms_3 = Math.floor((( plan3_end_date - plan3_start_date ) / 86400000) + 1);

  if($('._dataplans3 option:selected').val() == planIds[0]){
    var plans0 = parseFloat(plans[0].replace(/,/g, ""));
    existing_all_3 = plans0 * existing_terms_3;
    var existing_all_3_comma = String(existing_all_3).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.form-user-background').show();
    $('.overseas-existing-3').show();
    $(".overseas-existing-price-3").text(plans[0]);
    $(".overseas-existing-terms-3").text(existing_terms_3);
    $(".overseas-existing-all-3").text(existing_all_3_comma);
  }else if($('._dataplans3 option:selected').val() == planIds[1]){
    var plans1 = parseFloat(plans[1].replace(/,/g, ""));
    var plans1_difference = plans1 - plan3_price;
    existing_all_3 = plans1_difference * existing_terms_3;
    var existing_all_3_comma = String(existing_all_3).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.form-user-background').show();
    $('.overseas-existing-3').show();
    $(".overseas-existing-price-3").text(plans1_difference);
    $(".overseas-existing-terms-3").text(existing_terms_3);
    $(".overseas-existing-all-3").text(existing_all_3_comma);
    $(".overseas-existing-changed-plan-3").html(planNames[1]);
  }else if($('._dataplans3 option:selected').val() == planIds[2]){
    var plans2 = parseFloat(plans[2].replace(/,/g, ""));
    var plans2_difference = plans2 - plan3_price;
    existing_all_3 = plans2_difference * existing_terms_3;
    var existing_all_3_comma = String(existing_all_3).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    $('.form-user-background').show();
    $('.overseas-existing-3').show();
    $(".overseas-existing-price-3").text(plans2_difference);
    $(".overseas-existing-terms-3").text(existing_terms_3);
    $(".overseas-existing-all-3").text(existing_all_3_comma);
    $(".overseas-existing-changed-plan-3").html(planNames[2]);
  }else{
    existing_all_3 = 0;
    $('.overseas-existing-3').hide();
  }
};

function lookupArea(country){
  for (var area in gCountries) {
    if(country in gCountries[area]){
      return area;
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

  changePlan1(area1, country1);
  if ($('#overseas-current-2').length > 0){
    changePlan2(area2, country2);
  }
  if ($('#overseas-current-3').length > 0){
    changePlan3(area3, country3);
  }
  // 変更できるプランがなかった場合は規約と決定ボタンを非表示にする
  if ($('.overseas-change-content select.form-control-country').length == 0) {
    $(".overseas-change-content.leave-checkbox-box, .overseas-change-content .js-up-btn").hide();
  }else {
    $(".overseas-change-content.leave-checkbox-box, .overseas-change-content .js-up-btn").show();
  }

  // エリア、国、プラン、同意欄を変更したら
  $("._areas, ._countries, ._dataplans1, ._dataplans2, ._dataplans3, input#data-charge-agreement-checkbox").on('change', function(){

    $('.form-user-background').hide();

    $("p.popup-kaigai-text").html('');

    selectPlan1(area1, country1);
    if ($('#overseas-current-2').length > 0){
      selectPlan2(area2, country2);
    }
    if ($('#overseas-current-3').length > 0){
      selectPlan3(area3, country3);
    }

    var planName1 = $('._dataplans1 option:selected').text();
    var planName2 = $('._dataplans2 option:selected').text();
    var planName3 = $('._dataplans3 option:selected').text();

    if(planName1.length > 0 && planName1 !== '選択してください'){
      $("p.popup-kaigai-text").append('1ヶ国目　' + country1 + '<br>' + planName1 + '<br>' + '<br>');
    }
    if(planName2.length > 0 && planName2 !== '選択してください'){
      $("p.popup-kaigai-text").append('2ヶ国目　' + country2 + '<br>' + planName2 + '<br>' + '<br>');
    }
    if(planName3.length > 0 && planName3 !== '選択してください'){
      $("p.popup-kaigai-text").append('3ヶ国目　' + country3 + '<br>' + planName3 + '<br>' + '<br>');
    }

    $("p.popup-kaigai-text br:last").remove();

    // 合計金額の計算
    var overseas_all_price = existing_all_1 + existing_all_2 + existing_all_3;
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

    var dataplan1 = $("._dataplans1 option:selected").text();
    var dataplan2 = $("._dataplans2 option:selected").text();
    var dataplan3 = $("._dataplans3 option:selected").text();

    var selectedDataPlan1 = $("._dataplans1 option:selected");
    var selectedDataPlan2 = $("._dataplans2 option:selected");
    var selectedDataPlan3 = $("._dataplans3 option:selected");

    var boxes = $('input#data-charge-agreement-checkbox:checked');

    if ((selectedDataPlan1.length > 0 && (dataplan1.length > 0 && dataplan1 !== "選択してください") || selectedDataPlan2.length > 0 && (dataplan2.length > 0 && dataplan2 !== "選択してください") || selectedDataPlan3.length > 0 && (dataplan3.length > 0 && dataplan3 !== "選択してください")) && boxes.length > 0) {
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
  $("._areas").val(area);
  var innerHtml = ""
  for (var country in gCountries[area]){
    if (country === "中国") {
      innerHtml += '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中。中国(VPN)をご購入ください）</option>'
    } else {
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
  $("._dataplans").html("");

  changeAreaClass(area);
  $("._dataplans").attr("disabled", true);
}
