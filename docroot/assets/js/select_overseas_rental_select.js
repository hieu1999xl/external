let params = new URLSearchParams(document.location.search);
var flagTour = false;

// パラメータ取得（周遊かどうか）
let plan_id_tour = params.get("plan_id_tour");

if( plan_id_tour ){
  flagTour = true;
}

// エクシディア経由のパラメータ取得
var flagHonne = false; //HonNe
var flagWimaxhikaku = false; //WiMAX比較、YouTube
var flagEvervest = false; //エバーベスト
var flagMobistar = false; //海外レンタルWiFi比較ナビ

//utm_campaignの中身によってフラグ変更
let utm_campaign = params.get("utm_campaign");

//エクシディア経由の人判定用
var campaign_params;

$(function(){
  //海外レンタルWiFi比較ナビのポップアップ
  var top_notion_popup_over = `
    <div class="guidance-notion-black-background guidance-notion-black-background-hikakunavi"></div>
    <div class="white-content-box-guidance-notion-hikakunavi">
      <div class="white-content-box-guidance-notion-hikakunavi-inner">
        <div class="guidance-hikakunavi-body">
          <h2 class="head-ttl">
            <div class="ttl-img">
              <img src="/assets/img/mobistar_logo.png" alt="" width="340" height="56">
            </div>
            <div class="ttl-txt"><span>限</span><span>定</span>特典！</div>
          </h2>
          <div class="campaign-bg">
            <div class="campaign-container">
              <div class="cp-item">
                <div class="sub-ttl">特典 1</div>
                <img src="/assets/img/guidance-hikaku-point1.svg" class="pc" alt="プラン料金各国大幅値下げ！最大82%OFF!" width="230" height="146">
                <img src="/assets/img/guidance-hikaku-point-sp1.svg" class="sp" alt="プラン料金各国大幅値下げ！最大82%OFF!" width="528" height="126">
              </div>
              <div class="cp-item">
                <div class="sub-ttl">特典 2</div>
                <img src="/assets/img/guidance-hikaku-point2.svg" class="pc" alt="キャンペーン中！往復送料が無料！" width="230" height="146">
                <img src="/assets/img/guidance-hikaku-point-sp2.svg" class="sp" alt="キャンペーン中！往復送料が無料！" width="528" height="126">
              </div>
              <div class="cp-item">
                <div class="sub-ttl">特典 3</div>
                <img src="/assets/img/guidance-hikaku-point3.svg" class="pc" alt="多言語通訳サポートが無料で使える！" width="230" height="146">
                <img src="/assets/img/guidance-hikaku-point-sp3.svg" class="sp" alt="多言語通訳サポートが無料で使える！" width="528" height="126">
              </div>
            </div>
          </div>
          <div class="default-btn-main default-btn-main-kakaku-top">
            <div class="guidance-popup-close-button">
              <span>今すぐ申し込み！</span>
            </div>
          </div>
          <img class="kv-middle" src="https://d1q08lkutgkcx2.cloudfront.net/image/kv-global-top.webp" alt="海外だってがんばる価格 ZEUS WiFi for GLOBAL" width="600" height="254">
          <div class="section-ttl">
            <h3>
              <span>ZEUS WiFi for GLOBAL</span>の<br class="sp">ここが<span>スゴイ</span>！
              <img class="plane" src="/assets/img/global-plane-icon.png" alt="飛行機" width="80" height="40">
              <img class="device" src="/assets/img/global-device-icon.png" alt="端末" width="80" height="53">
            </h3>
          </div>
          <div class="campaign-bg">
            <div class="campaign-container">
              <div class="cp-item">
                <div class="sub-ttl">Point1</div>
                <img src="/assets/img/guidance-hikaku-point4.svg" class="pc" alt="端末は出発日の最大8日前までに受取り！" width="230" height="146">
                <img src="/assets/img/guidance-hikaku-point-sp4.svg" class="sp" alt="端末は出発日の最大8日前までに受取り！" width="528" height="126">
              </div>
              <div class="cp-item">
                <div class="sub-ttl">Point2</div>
                <img src="/assets/img/guidance-hikaku-point5.svg" class="pc" alt="お急ぎの方に！10時までの申し込みで最短翌日到着" width="230" height="146">
                <img src="/assets/img/guidance-hikaku-point-sp5.svg" class="sp" alt="お急ぎの方に！10時までの申し込みで最短翌日到着" width="528" height="126">
              </div>
              <div class="cp-item top-margin">
                <div class="sub-ttl">Point3</div>
                <img src="/assets/img/guidance-hikaku-point6.svg" class="pc" alt="マイページから領収書発行OK" width="230" height="146">
                <img src="/assets/img/guidance-hikaku-point-sp6.svg" class="sp" alt="マイページから領収書発行OK" width="528" height="126">
              </div>
            </div>
          </div>
          <div class="default-btn-main default-btn-main-kakaku-bottom">
            <div class="guidance-popup-close-button">
              <span>申し込みを進める</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;

  //エクシディア
  if(utm_campaign){
    campaign_params = utm_campaign;
    
    //HonNe
    if(campaign_params == "honne"){
      flagHonne = true;
      $(".cp-price").addClass("cp-true");
      $(".honne").addClass("cp-true");
      $(".wimax_hikaku").removeClass("cp-true");
      $(".everbest").removeClass("cp-true");

    //WiMAX比較、YouTube
    }else if(campaign_params == "wimaxhikaku"){
      flagWimaxhikaku = true;
      $(".cp-price").addClass("cp-true");
      $(".honne").removeClass("cp-true");
      $(".wimax_hikaku").addClass("cp-true");
      $(".everbest").removeClass("cp-true");
    
    //エバーベスト
    }else if(campaign_params == "everbest"){
      flagEvervest = true;
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

      if(window.location.pathname.includes('/entry/overseas/select')){
        $("body").append(top_notion_popup_over);
      }
      $(".guidance-notion-black-background-hikakunavi,.guidance-popup-close-button").click(function(){
        hideGuidancePopuphikakunavi();
      });
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
});
function hideGuidancePopuphikakunavi(){
  $(".guidance-notion-black-background-hikakunavi").hide();
  $(".white-content-box-guidance-notion-hikakunavi").hide();
}
function showGuidancePopuphikakunavi(){
  $(".guidance-notion-black-background-hikakunavi").show();
  $(".white-content-box-guidance-notion-hikakunavi").show();
}

// 1ヶ国プランの場合のセレクトタグ start ////////////////////////////////////////////////////////////////////////////////////////////////
function singleType(){
    $("._areas").html("<option disabled selected>エリアを選択</option>"); //初期化
    $("._countries").html("<option disabled selected>国を選択</option>"); //初期化

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
          if (country == lp_country || country == sp_country) {
            var line = '<option data-area="'+area+'" value="'+country+'" selected="selected">'+country+'</option>'
          } else {
            var line = '<option data-area="'+area+'" value="'+country+'">'+country+'</option>'
          }
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
      if ((area == lp_area || area == sp_area) && lp_country !== "ミャンマー") {
        var areaLine = '<option value="'+area+'" selected="selected">'+area+'</option>'
      } else {
        var areaLine = '<option value="'+area+'">'+area+'</option>'
      }
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

    if(window.location.pathname.includes("/select")){
      // LPでプランを選択してからプラン選択画面に進んだ場合はプラン選択済みの状態にする
      if (lp_area != '' && lp_country != '' && lp_plan_id != '') {
        // ミャンマー停止対応 start
        if(lp_country == "ミャンマー" || lp_country == "バングラデシュ"){
          return false;
        }
        // ミャンマー停止対応 end

        var lp_plans = gCountries[lp_area][lp_country];
        var lp_plan_id_list = gCountriesPlanId[lp_area][lp_country];

        $(".overseas-plan-section").removeClass('section-hide');

        $(".overseas-plan1-price").text(lp_plans[0]);
        $(".overseas-plan2-price").text(lp_plans[1]);
        $(".overseas-plan3-price").text(lp_plans[2]);

        $("#500mb").val(lp_plan_id_list[0]);
        $("#1gb").val(lp_plan_id_list[1]);
        $("#free").val(lp_plan_id_list[2]);

        if (lp_plan_id_list[0] == lp_plan_id) {
          $(".relief-item-select-area6").click();
        } else if (lp_plan_id_list[1] == lp_plan_id) {
          $(".relief-item-select-area7").click();
        } else if (lp_plan_id_list[2] == lp_plan_id) {
          $(".relief-item-select-area8").click();
        }

        changePlan(lp_area, lp_country);
        $('._dataplans').val(lp_plan_id).change();
          
      } else if (sp_area != '' && sp_country != '' && sp_plan_id != '') {
        var sp_plans = gCountries[sp_area][sp_country];
        var sp_plan_id_list = gCountriesPlanId[sp_area][sp_country];
        
        $(".overseas-plan-section").removeClass('section-hide');
        
        $(".overseas-plan1-price").text(sp_plans[0]);
        $(".overseas-plan2-price").text(sp_plans[1]);
        $(".overseas-plan3-price").text(sp_plans[2]);

        $("#500mb").val(sp_plan_id_list[0]);
        $("#1gb").val(sp_plan_id_list[1]);
        $("#free").val(sp_plan_id_list[2]);
        
        if (sp_plan_id_list[0] == sp_plan_id) {
          $(".relief-item-select-area6").click();
        } else if (sp_plan_id_list[1] == sp_plan_id) {
          $(".relief-item-select-area7").click();
        } else if (sp_plan_id_list[2] == sp_plan_id) {
          $(".relief-item-select-area8").click();
        }
        
        changePlan(sp_area, sp_country);
        $('._dataplans').val(sp_plan_id).change();
      }
    }

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
// 1ヶ国プランの場合のセレクトタグ end ////////////////////////////////////////////////////////////////////////////////////////////////

// 周遊プランの場合のセレクトタグ start ////////////////////////////////////////////////////////////////////////////////////////////////
function tourType(){
  $("._areas").html("<option disabled selected>エリアを選択</option>"); //初期化
  $("._countries").html("<option disabled selected>国を選択</option>"); //初期化

  for (var area in gCountriesForTour) {
    var innerHtml = ""
    for (var country in gCountriesForTour[area]){
        if (country == lp_country || country == sp_country) {
          var line = '<option data-area="'+area+'" value="'+country+'" selected="selected">'+country+'</option>'
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
    if (area == lp_area || area == sp_area) {
      var areaLine = '<option value="'+area+'" selected="selected">'+area+'</option>'
    } else {
      var areaLine = '<option value="'+area+'">'+area+'</option>'
    }
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

  if(window.location.pathname.includes("/select")){
    // LPでプランを選択してからプラン選択画面に進んだ場合はプラン選択済みの状態にする
    if (lp_area != '' && lp_country != '' && lp_plan_id != '') {
      var lp_plans = gCountriesForTour[lp_area][lp_country];
      var lp_plan_id_list = gCountriesPlanIdForTour[lp_area][lp_country];

      $(".overseas-plan-section").removeClass('section-hide');

      $(".overseas-plan1-price").text(lp_plans[0]);
      $(".overseas-plan2-price").text(lp_plans[1]);
      $(".overseas-plan3-price").text(lp_plans[2]);

      $("#500mb").val(lp_plan_id_list[0]);
      $("#1gb").val(lp_plan_id_list[1]);
      $("#free").val(lp_plan_id_list[2]);

      if (lp_plan_id_list[0] == lp_plan_id) {
        $(".relief-item-select-area6").click();
      } else if (lp_plan_id_list[1] == lp_plan_id) {
        $(".relief-item-select-area7").click();
      } else if (lp_plan_id_list[2] == lp_plan_id) {
        $(".relief-item-select-area8").click();
      }

      changePlan(lp_area, lp_country);
      $('._dataplans').val(lp_plan_id).change();

      var dataplanValue = $("._dataplans option:selected").val();

      if($('[id=tour-asia_1]').prop('checked')){
        $('[id=tour-asia_1]').val(dataplanValue);
      } else if ($('[id=tour-europe_1]').prop('checked')) {
        $('[id=tour-europe_1]').val(dataplanValue);
      } else if ($('[id=tour-world_1]').prop('checked')) {
        $('[id=tour-world_1]').val(dataplanValue);
      }
        
    } else if (sp_area != '' && sp_country != '' && sp_plan_id != '') {
      var sp_plans = gCountriesForTour[sp_area][sp_country];
      var sp_plan_id_list = gCountriesPlanIdForTour[sp_area][sp_country];
      
      $(".overseas-plan-section").removeClass('section-hide');
      
      $(".overseas-plan1-price").text(sp_plans[0]);
      $(".overseas-plan2-price").text(sp_plans[1]);
      $(".overseas-plan3-price").text(sp_plans[2]);
      
      $("#500mb").val(sp_plan_id_list[0]);
      $("#1gb").val(sp_plan_id_list[1]);
      $("#free").val(sp_plan_id_list[2]);
      
      if (sp_plan_id_list[0] == sp_plan_id) {
        $(".relief-item-select-area6").click();
      } else if (sp_plan_id_list[1] == sp_plan_id) {
        $(".relief-item-select-area7").click();
      } else if (sp_plan_id_list[2] == sp_plan_id) {
        $(".relief-item-select-area8").click();
      }
      
      changePlan(sp_area, sp_country);
      $('._dataplans').val(sp_plan_id).change();

      var dataplanValue = $("._dataplans option:selected").val();

      if($('[id=tour-asia_1]').prop('checked')){
        $('[id=tour-asia_1]').val(dataplanValue);
      } else if ($('[id=tour-europe_1]').prop('checked')) {
        $('[id=tour-europe_1]').val(dataplanValue);
      } else if ($('[id=tour-world_1]').prop('checked')) {
        $('[id=tour-world_1]').val(dataplanValue);
      }
    }
  }

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

// 初期発火 start ////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {
  if(window.location.pathname.includes("/select") || window.location.pathname.includes("/confirm")){
    if(flagTour){
      $('[id=travel-type-tour]').prop('checked', true);
      $('#select-country-plan').fadeOut(100);
      $('#select-continent-plan').fadeIn(100);
      tourType();
    }else{
      singleType();
    }
  }
});
// 初期発火 end ////////////////////////////////////////////////////////////////////////////////////////////////

// セレクトタグの国/周遊の切替 start ////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {
  $('[name="travel_type"]:radio').change( function() {

    // 他サイトから来た場合のプランデータ引き継ぎ解除
    lp_area = ''; // 初期化
    lp_country = ''; // 初期化
    lp_plan_id = ''; // 初期化
    sp_area = ''; // 初期化
    sp_country = ''; // 初期化
    sp_plan_id = ''; // 初期化

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

  $("._areas.js-tabindex").change(function(){
    var area = $(this).val();
    _areaSelected(area);
  })

  $('._countries.js-tabindex, input[name="country_plan"]').change(function(){
    var country = $(this).val();

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

  $("._dataplans").change(function(){

    var country = $("._countries").val();
    var dataplan = $("._dataplans option:selected").text();
    var dataplanIndex = $("._dataplans").prop("selectedIndex") - 1;

    var planName = country + " " + dataplan;
    $("p.popup-kaigai-text").text(planName);

    var selectedDataPlan = $("._dataplans option:selected");
    if (selectedDataPlan.length > 0) {
      $("div#overseas_submit_button").removeClass(
        "decoration-button-area-disabled"
      );
    } else {
      $("div#overseas_submit_button").addClass("decoration-button-area-disabled");
    }

    var dataplanValue = $("._dataplans option:selected").val();

    $(".reception-stopped").hide();
    if($('[id=tour-asia_1]').prop('checked')){
      $(".reception-stopped").show();
      $('[id=tour-asia_1]').val(dataplanValue);
    } else if ($('[id=tour-europe_1]').prop('checked')) {
      $(".reception-stopped").hide();
      $('[id=tour-europe_1]').val(dataplanValue);
    } else if ($('[id=tour-world_1]').prop('checked')) {
      $(".reception-stopped").show();
      $('[id=tour-world_1]').val(dataplanValue);
    }
  });

  $('._areas.js-tabindex, ._countries.js-tabindex, input[name="country_plan"]').change(function(){
    var country = $("._countries").val();
    var selectedDataPlan = $("._dataplans option:selected");
    var dataplan = $("._dataplans option:selected").text();

    // 他サイトから来た場合のプランデータ引き継ぎ解除
    lp_area = ''; // 初期化
    lp_country = ''; // 初期化
    lp_plan_id = ''; // 初期化
    sp_area = ''; // 初期化
    sp_country = ''; // 初期化
    sp_plan_id = ''; // 初期化

    if(country && country !== "選択してください"){
      $(".overseas-plan-section").removeClass('section-hide');

      $(".relief-item-select-area8").click();

      $(".overseas-plan1-price").text(plans0);
      $(".overseas-plan2-price").text(plans1);
      $(".overseas-plan3-price").text(plans2);

      // 通常プラン
      $("#500mb").val(plans0_id);
      $("#1gb").val(plans1_id);

      $("#free").val(plans2_id).change();
    }else{
      $(".overseas-plan-section").addClass('section-hide');
    }

    if (selectedDataPlan.length = 0 || dataplan == "選択してください"){
      var radio = $(".overseas-plan-section .topping-2-select-area-relief-option").siblings("label").find("input");
      radio.prop('checked', false);
      $(".overseas-plan-section .topping-2-select-area-relief-option").removeClass("selected");
      $('.summary-group-countries-dataplans').html('');
      $('.plan-total-price').html('');
    }
  });

  $(".topping-2-select-area-relief-option").click(function(e){
    if($(this).siblings("label").find("input").attr("id") === "500mb"){
      $('._dataplans').val(plans0_id).change();
    }else if($(this).siblings("label").find("input").attr("id") === "1gb"){
      $('._dataplans').val(plans1_id).change();
    }else if($(this).siblings("label").find("input").attr("id") === "free"){
      $('._dataplans').val(plans2_id).change();
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

$(document).ready(function() {
  var selectedDataPlan = $("._dataplans option:selected");
  if (selectedDataPlan.length > 0) {
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