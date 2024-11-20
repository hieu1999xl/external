// //
// Capacity
// //
$(document).ready(function() {
    function selectCapacity(target) {
        var checkBox = $(target).siblings(".form-capacity-select-checkbox-area").find("input");
        checkBox.prop('checked', true);
        $(".form-capacity-select-area").removeClass("selected");
        $(target).addClass("selected");
        
        updateTwitterCampaignSummary();
    }
    $(".form-capacity-select-area").hover(
        function(e){
            var srcTarget = $(e.target);
            var targetArea;
            if(srcTarget.hasClass('form-capacity-select-area')){
                targetArea = srcTarget;
            }else{
                targetArea = srcTarget.parents(".form-capacity-select-area");
            }
            $(targetArea).addClass("active");
        },
        function (e){
            // hover can react to child elements of the class
            var srcTarget = $(e.target);
            var targetArea;
            if(srcTarget.hasClass('form-capacity-select-area')){
                targetArea = srcTarget;
            }else{
                targetArea = srcTarget.parents(".form-capacity-select-area");
            }
            $(targetArea).removeClass("active");
        }
    )
    function initializeCapacity() {
        var elem = $('input[name="plan_id"]:checked')
        var val = elem.val();
        if(val === undefined){
            return;
        }
        var target = elem.parents('.form-capacity-select-checkbox-area').siblings('.form-capacity-select-area');
        selectCapacity(target);
    }
    initializeCapacity();

    var ua = navigator.userAgent;
    $(".form-capacity-pull-down-button-left").click(function(e){
        // p in the button reacts
        var targetButton = $(e.target);
        var target = $('.form-capacity-description-body-left');
        if (target.hasClass("hidden")){
            target.removeClass("hidden");
            targetButton.find(".pull-down-arrow-to-open").hide();
            targetButton.find(".pull-down-arrow-to-close").show();
            targetButton.addClass("form-capacity-pull-down-button-open");
            if (ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
              var targetButton2 = $(".form-capacity-pull-down-button-right");
              var target2 = $('.form-capacity-description-body-right');
              if(targetButton2.hasClass("form-capacity-pull-down-button-open")){
                target2.addClass("hidden");
                targetButton2.find(".pull-down-arrow-to-close").hide();
                targetButton2.find(".pull-down-arrow-to-open").show();
                targetButton2.removeClass("form-capacity-pull-down-button-open");
              }
            }
        }else{
            target.addClass("hidden");
            targetButton.find(".pull-down-arrow-to-close").hide();
            targetButton.find(".pull-down-arrow-to-open").show();
            targetButton.removeClass("form-capacity-pull-down-button-open");
        }
    });
})


// //
//Option button
// //
function expandFormOptionDetail() {
    var planOptionDetailClosed = $(
      "div.form-plan-option-detail-description"
    ).hasClass("form-plan-option-detail-description-close");

    if (planOptionDetailClosed) {
      $("div.form-plan-option-detail-description-button-pink").removeClass(
        "form-plan-option-detail-description-button-close"
      );
      $("div.form-plan-option-detail-description-button").addClass(
        "form-plan-option-detail-description-button-close"
      );
      $("div.form-plan-option-detail-description").removeClass(
        "form-plan-option-detail-description-close"
      );
      $("div.form-plan-option-detail-button").addClass(
        "form-plan-option-detail-button-open"
      );
      $(".form-plan-option-detail-button").html("内容詳細　▲");
    } else {
      $("div.form-plan-option-detail-description-button").removeClass(
        "form-plan-option-detail-description-button-close"
      );
      $("div.form-plan-option-detail-description-button-pink").addClass(
        "form-plan-option-detail-description-button-close"
      );
      $("div.form-plan-option-detail-description").addClass(
        "form-plan-option-detail-description-close"
      );
      $("div.form-plan-option-detail-button").removeClass(
        "form-plan-option-detail-button-open"
      );
      $(".form-plan-option-detail-button").html("内容詳細　▼");
    }
  }

// //
// Topping 2
// //

$(document).ready(function() {
    function selectTopping2(target) {
        var checkBox = $(target).siblings(".topping-2-select-checkbox-area").find("input");
        checkBox.prop('checked', true);
        $(".topping-2-select-area").removeClass("selected");
        $(target).addClass("selected");

        updateTwitterCampaignSummary();
    }
    function noselectTopping2(target) {
        var checkBox = $(target).siblings(".topping-2-select-checkbox-area").find("input");
        checkBox.prop('checked', false);
        $(".topping-2-select-area").addClass("selected");
        $(target).removeClass("selected");

        updateTwitterCampaignSummary();
    }

    $(".topping-2-select-area").hover(
        function(e){
            // hover can react to child elements of the class
            $(this).addClass("active");
        },
        function (e){
            // hover can react to child elements of the class
            $(this).removeClass("active");
        }
    )
    $(".topping-2-select-area").click(function(e){
        var target = $(e.target).parents('.topping-2-select-area');
        selectTopping2(target);
    })

    $('input[name="device_option"]').change(function(e){
        var target = $(e.target).parents('.topping-2-select-checkbox-area').siblings('.topping-2-select-area');
        selectTopping2(target);
    })
    function initializeTopping2() {
        var isOptionsPage = location.pathname.indexOf("/entry/select") === 0;

        if(!isOptionsPage){
            // Not options page
            return;
        }

        var elem = $('input[name="device_option"]:checked')
        var val = elem.val();
        if(val === undefined){
            return;
        }
        var target = $(elem).parents('.topping-2-select-checkbox-area').siblings('.topping-2-select-area');
        selectTopping2(target);
    }
    initializeTopping2();

})
// //
// Update TwitterCampaign summary
// //
var gSummaryTwitterPrices = {
    plan_id: {
        "329": {
            "capacity": 20,
            "price": 0,
            "cancel_fee":0,
        },
    },
    deviceOption: {
        'true': 400,
        'false': 0,
    }
}
function updateTwitterCampaignSummary(){
    let planFee;

    var isOptionsPageTwitter = location.pathname.indexOf("/entry/twitter/select") === 0;
    if(!isOptionsPageTwitter){
        // Not options page
        return;
    }

    // gSelectedCapacity is given in entry/options in script tag
    var capacity = gSelectedCapacity;
    var plan_id = $("input[name=plan_id]:checked").val();
    if (plan_id === undefined) {
        plan_id = $("input:hidden[name=plan_id]").val();
    }
    var deviceOption = $("input[name=device_option]:checked").val();
    var initialFee = gInitialFee;
    var cancelFee = gCancelFee;

    // ///
    // Text
    // ///

    // tie
    $(".summary-text-tie-plan-name").text("フリープラン");
    $(".summary-text-tie-period").text("(契約期間なし)");
    $(".summary-text-capacity").html("<br>" + gSummaryTwitterPrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryTwitterPrices.plan_id[plan_id].cancel_fee;

    // device option
    if(deviceOption === 'true'){
        $(".summary-text-device-option-title").html("端末あんしん<br class='sp'>オプション");
        $(".summary-text-device-option-price").html("400円<br class='sp'>(440円税込)");
    }else{
        $(".summary-text-device-option-title").text("なし");
        $(".summary-text-device-option-price").text("0円");
    }

    $(".summary-text-monthly-total").text("0");


    // ///
    // price
    // ///

    var tax = 1.1;

    // initial and cancel
    initialTaxFee = initialFee * tax;
    cancelTaxFee = cancelFee * tax;
    $(".summary-text-initial-fee").html(initialFee.toLocaleString() + "円");
    $(".summary-text-cancel-fee").text(cancelFee.toLocaleString() + "円");
    $("#cancel_fee_attention").hide();
    $(".summary-text-cancel-tax-fee").html("");
    // monthly
    if (gSummaryTwitterPrices.plan_id[plan_id]) {
        planFee = gSummaryTwitterPrices.plan_id[plan_id].price;
        planTaxFee = planFee * tax;
        planTaxFee = Math.floor(planTaxFee);
    } else {
        planFee = 0;
    }

    $(".summary-text-monthly-fee").text(planFee.toLocaleString());
    $(".summary-text-monthly-tax-fee").text("(" + planTaxFee.toLocaleString() + "円税込)");
    $("#campaign_attention").hide();
    $(".summary-text-monthly-tax-total").show();

    var deviceOptionKey = deviceOption || "false";
    var deviceOptionFee = gSummaryTwitterPrices.deviceOption[deviceOptionKey];
    var deviceOptionTaxFee = deviceOptionFee * tax;
    var monthlyFee = planFee + deviceOptionFee;
    var monthlyTaxFee = planTaxFee + deviceOptionTaxFee;

    if(deviceOption === 'true'){
        $(".summary-text-monthly-total").text(monthlyFee.toLocaleString());
        $(".summary-text-monthly-tax-total").text("(" + monthlyTaxFee.toLocaleString() + "円税込)");
    }else{
        $(".summary-text-monthly-total").text(monthlyFee.toLocaleString());
        $(".summary-text-monthly-tax-total").hide();
    }
}

$(document).ready(function() {
    // initial calculate
    updateTwitterCampaignSummary();
})


// ///
// Auto input kana
// ///

$(function() {
    //name属性で判別する場合
    $.fn.autoKana('input[name="last_name"] ', 'input[name="last_name_kana"]', {katakana:true});　
    $.fn.autoKana('input[name="first_name"] ', 'input[name="first_name_kana"]', {katakana:true});　
    $.fn.autoKana('input[name="user_last_name"] ', 'input[name="user_last_name_kana"]', {katakana:true});　
    $.fn.autoKana('input[name="user_first_name"] ', 'input[name="user_first_name_kana"]', {katakana:true});　
    $.fn.autoKana('input[name="delivery_last_name"] ', 'input[name="delivery_last_name_kana"]', {katakana:true});　
    $.fn.autoKana('input[name="delivery_first_name"] ', 'input[name="delivery_first_name_kana"]', {katakana:true});　
    $.fn.autoKana('input[name="deliverycorp_last_name"] ', 'input[name="deliverycorp_last_name_kana"]', {katakana:true});　
    $.fn.autoKana('input[name="deliverycorp_first_name"] ', 'input[name="deliverycorp_first_name_kana"]', {katakana:true});　
    $.fn.autoKana('input[name="corp_company_name"] ', 'input[name="corp_company_name_kana"]', {katakana:true});
    $.fn.autoKana('input[name="corp_last_name"] ', 'input[name="corp_last_name_kana"]', {katakana:true});　
    $.fn.autoKana('input[name="corp_first_name"] ', 'input[name="corp_first_name_kana"]', {katakana:true});
    $.fn.autoKana('input[name="company_name"] ', 'input[name="company_name_kana"]', {katakana:true});
    $.fn.autoKana('input[name="invoice_company_name"] ', 'input[name="invoice_company_name_kana"]', {katakana:true});
    $.fn.autoKana('input[name="invoice_last_name"] ', 'input[name="invoice_last_name_kana"]', {katakana:true});　
    $.fn.autoKana('input[name="invoice_first_name"] ', 'input[name="invoice_first_name_kana"]', {katakana:true});
    $.fn.autoKana('input[name="represent_last_name"] ', 'input[name="represent_last_name_kana"]', {katakana:true});　
    $.fn.autoKana('input[name="represent_first_name"] ', 'input[name="represent_first_name_kana"]', {katakana:true});
});　
