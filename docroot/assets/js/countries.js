/**
 * 海外プランの情報を取得する
 */
$(document).ready(function() {
  var base_url = location.protocol + '//' + location.host;
  /**
   * 国内プラン用海外プラン向け
   */
  var api_url = base_url + '/api/v1/get_international_plan';
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
  })
     // 失敗時にはエラーログ出力
  .fail(function(e) {
    console.log(e)
  });

  /**
   * CHARGEプラン(プリペイド)向け
   */
  var api_url2 = base_url + '/api/v1/get_international_prepaid_plan';
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
    gCountriesForPrepaid = data.price;
    gCountriesPlanIdForPrepaid = data.plan_id;
    gCountriesPlanTypeForPrepaid = data.plan_type;

    // 周遊プラン
    gCountriesForTour = data.tour.price;
    gCountriesPlanIdForTour = data.tour.plan_id;
    gCountriesPlanTypeForTour = data.tour.plan_type;
  })
  // 失敗時にはエラーログ出力
  .fail(function(e) {
    console.log(e)
  });
});
