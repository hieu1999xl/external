// select2
$(document).ready(function() {
  for (var area in gCountries) {
    var innerHtml = ""
    for (var country in gCountries[area]){
      if (country === "中国") {
        innerHtml += '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中。中国(VPN)をご購入ください）</option>'
      } else if (country === "ミャンマー") {
        innerHtml += '<option disabled data-area="'+area+'" value="'+country+'">'+country+'（申込停止中）</option>'
      } else if (country === "バングラデシュ" || country === "バングラディッシュ"|| country === "バングラディッシュ") {
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
      var areaLines = '<div category="'+alphabet_area+'" class="faq-nav-icon-box nav-icon-box overseas-category-box overseas-category-box-selected js-tabindex-overseas-use" tabindex="0">'
      +'<div class="nav-box">'
      +'<div class="nav-box-text">'
      +area
      +'</div>'
      +'</div>'
      +'</div>';
    } else {
    // 「エリア」がそれ以外だったら
      var areaLines = '<div category="'+alphabet_area+'" class="faq-nav-icon-box nav-icon-box overseas-category-box js-tabindex-overseas-use" tabindex="0">'
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

  // サービスサイト（海外利用ページ）国の表示順変更
  $(function() {
    const asia = $('div[category="asia"]');
    const oceania = $('div[category="oceania"]');
    const europe = $('div[category="europe"]');
    const north_america = $('div[category="north-america"]');
    const south_america = $('div[category="south-america"]');
    const africa = $('div[category="africa"]');
    $(asia).after(oceania, europe, north_america, south_america, africa);
  })

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

  // 対象要素がページ内にある時のみ実行する
  if ($('.search-by-country-name-select').length) {
    // Initialinze select2
    $('.search-by-country-name-select').select2({
      matcher: customMatcher,
      width: 'resolve'
    });
  }

});

function changePlan(area, country){
  var plans = gCountries[area][country];
  var planIds = gCountriesPlanId[area][country];

  var planHtml = "";
  planHtml += "<option disabled selected>選択してください</option>";
  planHtml += "<option value='" + planIds[0] + "'" + ">300MB（1日）プラン "+plans[0]+"円（免税）</option>";
  planHtml += "<option value='" + planIds[1] + "'" + ">1GB（7日）プラン "+plans[1]+"円（免税）</option>";
  planHtml += "<option value='" + planIds[2] + "'" + ">3GB（30日）プラン "+plans[2]+"円（免税）</option>";
  $("._dataplans").html(planHtml);
  $("._dataplans").attr("disabled", false);
};

function lookupArea(country){
  for (var area in gCountries) {
    if(country in gCountries[area]){
      return area;
    }
  }
}

/* マイページ 海外データプランの購入ボタンの編集制御 */
// 国名選択時の処理
function selectedConuntryName(target) {
  var isPurchaseArea = target.hasClass('_countries'); // 海外データプランの購入 > 国名選択だった場合trueを返す
  var optionSelected = $("option:selected", target);
  var country = optionSelected.val();
  var area = isPurchaseArea ? lookupArea(country) : optionSelected.attr('data-area');
  // 地域/国/プラン設定
  _areaSelected(area);
  $("._areas").val(area);
  $("._countries").val(country);
  changePlan(area, country);
  // データプランと購入ボタンを初期値に戻す
  $("._dataplans").val('');
  $("div#overseas_submit_button").addClass("decoration-button-area-disabled");
  // 海外データプランの購入 > 国名選択だった場合はreturn
  if (isPurchaseArea) return;
  // スクロール処理実行
  var scrollTarget = $("#purchase-overseas-plan");
  scrollToHash(scrollTarget, 'header.mypage-header');
}

// 地域名選択時の処理
function selectedAreaName(target) {
  var optionSelected = $("option:selected", target);
  var area = optionSelected.val();
  _areaSelected(area);
  // 購入ボタンを初期値に戻す
  $("div#overseas_submit_button").addClass("decoration-button-area-disabled");
}

// データプラン選択時の処理
function selecetedDataPlan() {
  var country = $("._countries").val();
  var dataplan = $("._dataplans option:selected").text();
  var dataplanIndex = $("._dataplans").prop("selectedIndex") - 1;

  var planName = country + " " + dataplan;
  $("p.popup-kaigai-text").text(planName);

  var selectedDataPlan = $("._dataplans option:selected");
  if (selectedDataPlan.length > 0 && $("#overseas-data-agreement-checkbox").prop("checked")) {
    $("div#overseas_submit_button").removeClass(
      "decoration-button-area-disabled"
    );
  } else {
    $("div#overseas_submit_button").addClass("decoration-button-area-disabled");
  }
}

// 「同意する」チェック時の処理
function checedConfirmButton() {
  var selectedDataPlan = $("._dataplans option:selected");
  if (selectedDataPlan.length > 0
      && $("#overseas-data-agreement-checkbox").prop("checked")
      && selectedDataPlan.val() !== '選択してください') {
    $("div#overseas_submit_button").removeClass("decoration-button-area-disabled");
  } else {
    $("div#overseas_submit_button").addClass("decoration-button-area-disabled");
  }
}

$(document).ready(function() {
  // 国名検索 > 国名選択時
  $(".search-by-country-name-select").change(function(){
    selectedConuntryName($(this));
  })
  // 地域名選択時
  $("._areas").change(function(){
    selectedAreaName($(this));
  })
  // 海外データプランの購入 > 国名選択時
  $("._countries").change(function(){
    selectedConuntryName($(this));
  })
  // データプラン選択時
  $("._dataplans").change(function(){
    selecetedDataPlan();
  });
  // 「同意する」チェック時
  $("#overseas-data-agreement-checkbox").change(function(){
    checedConfirmButton();
  });
  $(".custom-check-box.js-confirm-box.overseas-data-plan").keyup(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      checedConfirmButton();
    }
  });

  $(function(){
    // 地域画像ホバー時の処理
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

$(document).ready(function() {
  var selectedDataPlan = $("._dataplans option:selected");
  if (selectedDataPlan.length > 0 && $("#overseas-data-agreement-checkbox").prop("checked")) {
    $("div#overseas_submit_button").removeClass(
      "decoration-button-area-disabled"
    );
  } else {
    $("div#overseas_submit_button").addClass("decoration-button-area-disabled");
  }
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

  var scrollTarget = $("#purchase-overseas-plan");
  scrollToHash(scrollTarget, 'header.mypage-header');
}

function _areaSelected(area){
  $("._areas").val(area);
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
  var lineOptGroup = "<option disabled selected>選択してください</option>";
  lineOptGroup += '<optgroup label="'+area+'">';
  lineOptGroup += innerHtml;
  lineOptGroup += '</optgroup>';
  // Add optgroup to coutries
  $("._countries").html(lineOptGroup);

  changeAreaClass(area);
  $("._dataplans").attr("disabled", true);

  // 海外データプラン購入 > 国名にフォーカスさせる
  $('#form-edit-overseas ._countries').focus();
}