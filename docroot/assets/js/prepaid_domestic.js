var tax = 1.1;
var taxOnly = 0.1;

// //
// ID情報格納
// //
var gSummaryPrices = {
  plan_id: {
    "charge_100gb": {
      "name": "100GB / 90日",
      "capacity": 100,
      "terms": 90,
      "price": 4073,
    },
    "charge_50gb": {
      "name": "50GB / 60日",
      "capacity": 50,
      "terms": 60,
      "price": 3255,
    },
    "charge_20gb": {
      "name": "20GB / 30日",
      "capacity": 20,
      "terms": 30,
      "price": 2073,
    },
    "charge_10gb": {
      "name": "10GB / 30日",
      "capacity": 10,
      "terms": 30,
      "price": 1164,
    },
    "charge_3gb": {
      "name": "3GB / 30日",
      "capacity": 5,
      "terms": 30,
      "price": 600,
    },
  },
}

// 表示制御 start ////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {
  $('input[name="plan_option[]"], input#data-charge-agreement-checkbox').change(function() {

    // 選択したプラン
    var checked = $('input[name="plan_option[]"]:checked');
    // 規約同意チェックボックス
    var boxes = $('input#data-charge-agreement-checkbox:checked');

    // 選択中のプランID
    var plan_id = $('input[name="plan_option[]"]:checked').attr('id');

    if(checked.length > 0){
      // 選択中のプラン名
      var plan_name = gSummaryPrices.plan_id[plan_id].name;

      // 選択中のプラン料金
      var plan_price = gSummaryPrices.plan_id[plan_id].price;
      var plan_price_comma = String(plan_price).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

      // 消費税
      var plan_tax = Math.floor(plan_price * taxOnly);
      var plan_tax_comma = String(plan_tax).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

      // 合計金額
      var add_total = plan_price + plan_tax;
      var add_total_comma = String(add_total).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

      // 期間設定
      $('input[name="terms"]').val(gSummaryPrices.plan_id[plan_id].terms);

      // 変更内容を表示する
      $(".form-user-background").show();
      $(".add-plan-days").html(plan_name);
      $(".add-price").html(plan_price_comma + " 円");
      $(".add-all").html(plan_price_comma);
      $(".add-tax").html(plan_tax_comma);
      $(".add-total").html(add_total_comma);

      // プランを選択済み＆同意にチェックが入っていた時
      if(boxes.length > 0){
        $("div#data_charge_user_submit").removeClass("decoration-button-area-disabled");
        $("input#button-submit").removeAttr("disabled");
      }else{
        $("div#data_charge_user_submit").addClass("decoration-button-area-disabled");
        $("input#button-submit").attr("disabled", "disabled");
      }
    }
  });
});
