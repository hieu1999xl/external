/**
 * user_idを元にデータ使用量を取得する
 */
$(document).ready(function() {
  var user_id = $("#user_id").val();
  var base_url = location.protocol + '//' + location.host;
  var api_url = base_url + '/api/v1/get_data_usage_rental';
  $.ajax(api_url,
    {
      type: 'get',
      data: {
              'user_id': user_id,
            },
      dataType: 'json',
      async: false, // 他のファイルで使えるように非同期
    }
  )
  // 成功時は変数にデータを格納
  .done(function(json) {
    var data = JSON.parse(json['code']);
    userDataUsage = data;
  })
  // 失敗時にはエラーログ出力
  .fail(function(e) {
    console.log(e)
  });
});
