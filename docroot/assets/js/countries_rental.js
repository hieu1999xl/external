/**
 * 海外レンタルプランの情報を取得する
 */
$(document).ready(function() {
  var base_url = location.protocol + '//' + location.host;
  var params = new URLSearchParams(document.location.search);
  var mplan_id = params.get("mplan_id");
  var plan_id = params.get("plan_id");
  var market_id_get = params.get('mid');
  var v_get = params.get('v');
  var vid_get = params.get('vid');
  var market_id = $('#market_id').val();
  var version = $('#version').val();
  var version_id = $('#version_id').val();
  var entry_flg = 0;
  // マイページなど、market_idが含まれている場合はそちらを優先したい
  if (market_id == undefined || market_id == null || market_id == '') {
    if (market_id_get == undefined || market_id_get == null || market_id_get == '') {
      market_id = 0;
    } else {
      market_id = market_id_get;
    }
  }
  if (version == undefined || version == null || version == '') {
    if (v_get == undefined || v_get == null || v_get == '') {
      version = 0;
    } else {
      version = v_get;
    }
  }
  if (version_id == undefined || version_id == null || version_id == '') {
    if (vid_get == undefined || vid_get == null || vid_get == '') {
      version_id = '';
    } else {
      version_id = vid_get;
    }
  }
  if (window.location.pathname.includes("entry/overseas")) {
    entry_flg = 1;    
  }
  var api_url = base_url + '/api/v1/get_international_rental_plan?market_id=' + market_id + '&version=' + version + '&version_id=' + version_id + '&entry_flg=' + entry_flg;

  $.ajax(api_url,
    {
      type: 'get',
      data: {},
      dataType: 'json',
      async: false, // 他のファイルで使えるように非同期
    }
  )

  // 成功時は変数にデータを格納
  .done(function(json) {
    var data = JSON.parse(json['code']);
    gCountries = data.price;
    gCountriesPlanId = data.plan_id;
    gCountriesPlanName = data.plan_name;
  })

  // 失敗時にはエラーログ出力
  .fail(function(e) {
    console.log(e)
  });

  /**
   * 海外レンタル周遊プラン向け
   */
  var api_url2 = base_url + '/api/v1/get_international_rental_tour_plan?market_id=' + market_id + '&version=' + version + '&version_id=' + version_id + '&entry_flg=' + entry_flg;
  $.ajax(api_url2,
    {
      type: 'get',
      data: {},
      dataType: 'json',
      async: false, // 他のファイルで使えるように非同期
    }
  )
  // 成功時は変数にデータを格納
  .done(function(json) {
    var data = JSON.parse(json['code']);
    gCountriesForTour = data.price;
    gCountriesPlanIdForTour = data.plan_id;
    gCountriesPlanNameForTour = data.plan_name;
  })
  // 失敗時にはエラーログ出力
  .fail(function(e) {
    console.log(e)
  });
});

$(window).on('load', function() {
  var params = new URLSearchParams(document.location.search);
  var market_id_get = params.get('mid');
  var utm_campaign_get = params.get('utm_campaign');
  // 価格コム又はアフィリエイトによる値引がある場合はヘッダーロゴを非活性にする
  (market_id_get || utm_campaign_get)
    ? $('.header-logo-overseas > a').addClass('disabled')
    : $('.header-logo-overseas > a').removeClass('disabled')
});