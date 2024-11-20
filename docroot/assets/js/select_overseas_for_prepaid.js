// 1ヶ国プランの場合のセレクトタグ start ////////////////////////////////////////////////////////////////////////////////////////////////
function singleType() {
  $("._areas").html("<option disabled selected>エリアを選択</option>"); //初期化
  $("._countries").html("<option disabled selected>国を選択</option>"); //初期化

  for (var area in gCountriesForPrepaid) {
    var innerHtml = ""
    for (var country in gCountriesForPrepaid[area]){
      if (country === "ミャンマー") {
        var line = '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中）</option>'
      } else if (country === "バングラデシュ" || country === "バングラディッシュ") {
        var line = '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中）</option>'
      } else {
        var line = '<option data-area="'+area+'" value="'+country+'">'+country+'</option>'
      }

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
    for (var country in gCountriesForPrepaid[area]){
      var plans = gCountriesForPrepaid[area][country];
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
};
// 1ヶ国プランの場合のセレクトタグ end ////////////////////////////////////////////////////////////////////////////////////////////////

// 周遊プランの場合のセレクトタグ start ////////////////////////////////////////////////////////////////////////////////////////////////
function tourType() {
  $("._areas").html("<option disabled selected>エリアを選択</option>"); //初期化
  $("._countries").html("<option disabled selected>国を選択</option>"); //初期化

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

};
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
        $(".reception-stopped").hide();
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
var plans3_id;
var plans0;
var plans1;
var plans2;
var plans3;

function changePlan(area, country){
  var forTourFlg = country === '周遊'
  var plans = forTourFlg ? gCountriesForTour[area][country] : gCountriesForPrepaid[area][country];
  var planIds = forTourFlg ? gCountriesPlanIdForTour[area][country] : gCountriesPlanIdForPrepaid[area][country];
  var planTypes = forTourFlg ? gCountriesPlanTypeForTour[area][country] : gCountriesPlanTypeForPrepaid[area][country];

  var planHtml = "";
  planHtml += "<option disabled selected>プランを選択</option>";
  planHtml += "<option value='" + planIds[0] + "'" + " price='" + plans[0] + "'" + " plan_type='" + planTypes[0] + "'" + " days='1'>500MB/日プラン</option>";
  planHtml += "<option value='" + planIds[1] + "'" + " price='" + plans[1] + "'" + " plan_type='" + planTypes[1] + "'" + " days='1'>1GB/日プラン</option>";
  planHtml += "<option value='" + planIds[2] + "'" + " price='" + plans[2] + "'" + " plan_type='" + planTypes[2] + "'" + " days='1'>無制限/日プラン</option>";

  $("._dataplans").html(planHtml);
  $("._dataplans").attr("disabled", false);

  plans0_id = planIds[0];
  plans1_id = planIds[1];
  plans2_id = planIds[2];
  plans0 = plans[0];
  plans1 = plans[1];
  plans2 = plans[2];
};

function lookupArea(country){
  for (var area in gCountriesForPrepaid) {
    if(country in gCountriesForPrepaid[area]){
      return area;
    }
  }
}

$(document).ready(function() {
  $("._areas").change(function(){
    var optionSelected = $("option:selected", this);
    var area = optionSelected.val()
    _areaSelected(area);
  })

  $("._countries").change(function(){
    var optionSelected = $("option:selected", this);
    var country = optionSelected.val();
    var area = lookupArea(country);
    _areaSelected(area);
    $("._areas").val(area);
    $("._countries").val(country);
    changePlan(area, country);
  })

  $('input[name="plan_id_tour"]').on('change', function(){
    var country = '周遊';
    var area = $(this).attr("alt");
    $('select[name="_areas"]').val(area).change();
    $("._dataplans").attr("disabled", false);
    changePlan(area, country);

    $(".reception-stopped").hide();
    if($('[id=tour-asia_1]').prop('checked')){
      $(".reception-stopped").show();
    } else if ($('[id=tour-europe_1]').prop('checked')) {
      $(".reception-stopped").hide();
    } else if ($('[id=tour-world_1]').prop('checked')) {
      $(".reception-stopped").show();
    }
  });

  $("._areas, ._countries").change(function(){
    var country = $("._countries").val();
    var selectedDataPlan = $("._dataplans option:selected");
    var dataplan = $("._dataplans option:selected").text();

    // 決定ボタンをinactiveにする
    $("div#overseas_submit_button").addClass("decoration-button-area-disabled");

    if(country && country !== "国・地域を選択"){
      $(".overseas-plan-section").removeClass('section-hide');

      $(".relief-item-select-area8").click();

      $(".overseas-plan1-price").text(plans0);
      $(".overseas-plan2-price").text(plans1);
      $(".overseas-plan3-price").text(plans2);

      $("#500mb").val(plans0_id);
      $("#1gb").val(plans1_id);
      $("#free").val(plans2_id);
    }else{
      $(".overseas-plan-section").addClass('section-hide');
    }

    if (selectedDataPlan.length = 0 || dataplan == "プランを選択"){
      var radio = $(".overseas-plan-section .topping-2-select-area-relief-option").siblings("label").find("input");
      radio.prop('checked', false);
      $(".overseas-plan-section .topping-2-select-area-relief-option").removeClass("selected");
      $('.summary-group-countries-dataplans').html('');
      $('.plan-total-price').html('');
    }
  });

  $(".topping-2-select-area-relief-option").click(function(e){
    if($(this).siblings("label").find("input").attr("id") === "500mb"){
      $('._dataplans').val(plans0_id);
    }else if($(this).siblings("label").find("input").attr("id") === "1gb"){
      $('._dataplans').val(plans1_id);
    }else if($(this).siblings("label").find("input").attr("id") === "free"){
      $('._dataplans').val(plans2_id);
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
  for (var country in gCountriesForPrepaid[area]){
    if (country === "ミャンマー") {
      var line = '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中）</option>'
    }else if (country === "バングラデシュ" || country === "バングラディッシュ") {
      var line = '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中）</option>'
    }  else {
      var line = '<option data-area="'+area+'" value="'+country+'">'+country+'</option>'
    }

    innerHtml += line;
  }
  var lineOptGroup = "<option disabled selected>国・地域を選択</option>";
  lineOptGroup += '<optgroup label="'+area+'">';
  lineOptGroup += innerHtml;
  lineOptGroup += '</optgroup>';
  // Add optgroup to coutries
  $("._countries").html(lineOptGroup);

  changeAreaClass(area);
  $("._dataplans").html('<option disabled="" selected="">プランを選択</option>');
  $("._dataplans").attr("disabled", true);
}
