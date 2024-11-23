// //
// Capacity
// //

document.write("<script type='text/javascript' src='/assets/js/wimax_sale_script.js'></script>");

$(document).ready(function() {
  function selectCapacity(target) {
    var checkBox = $(target).siblings(".form-capacity-select-checkbox-area").find("input");
    checkBox.prop('checked', true);
    $(".form-capacity-select-area").removeClass("selected");
    $(target).addClass("selected");

    if(window.location.pathname.includes("/entry/corp/select") || window.location.pathname.includes("/entry/corp/confirm")){
      valueInheritance();
    }

    updateSummary();
    updateTelephoneSummary();
    updateCorpSummary();
    updateHikariSummary();
    updateCRSummary();
    updateTwitterCampaignSummary();
    updateOHSummary();
    updateWimaxSummary();
    updateWimaxClosedSummary();
    updateRebniseSummary();
    updateSpecialSummary();
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
  $(".form-capacity-select-area").click(function(e){
    var target = $(e.target).parents('.form-capacity-select-area');
    selectCapacity(target);
  })

  $('input[name="plan_id"]').change(function(e){
    var target = $(e.target).parents('.form-capacity-select-checkbox-area').siblings('.form-capacity-select-area');
    selectCapacity(target);
  })

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
      $("div.wimax-value-plan-left").removeClass("hidden");
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
      $("div.wimax-value-plan-left").addClass("hidden");
      $(".form-capacity-pull-down-button-left").children(".pull-down-arrow-to-close").hide();
      $(".form-capacity-pull-down-button-left").children(".pull-down-arrow-to-open").show();
      $(".form-capacity-pull-down-button-left").removeClass("form-capacity-pull-down-button-open");
    }
  });
  $(".form-capacity-pull-down-button-right").click(function(e){
    // p in the button reacts
    var targetButton = $(e.target);
    var target = $('.form-capacity-description-body-right');
    if (target.hasClass("hidden")){
      target.removeClass("hidden");
      $("div.wimax-value-plan-right").removeClass("hidden");
      targetButton.find(".pull-down-arrow-to-open").hide();
      targetButton.find(".pull-down-arrow-to-close").show();
      targetButton.addClass("form-capacity-pull-down-button-open");
      if (ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
        var targetButton2 = $(".form-capacity-pull-down-button-left");
        var target2 = $('.form-capacity-description-body-left');
        if(targetButton2.hasClass("form-capacity-pull-down-button-open")){
          target2.addClass("hidden");
          targetButton2.find(".pull-down-arrow-to-close").hide();
          targetButton2.find(".pull-down-arrow-to-open").show();
          targetButton2.removeClass("form-capacity-pull-down-button-open");
        }
      }
    }else{
      target.addClass("hidden");
      $("div.wimax-value-plan-right").addClass("hidden");
      targetButton.find(".pull-down-arrow-to-close").hide();
      targetButton.find(".pull-down-arrow-to-open").show();
      targetButton.removeClass("form-capacity-pull-down-button-open");
    }
  });
  // 端末プルダウン
  $(".entry-rental-device-title").click(function(e){
    var targetButton = $(e.target);
    var target = $(this).next('.entry-rental-device-flex');
    if (target.hasClass("hidden")){
      target.removeClass("hidden");
      targetButton.find(".pull-down-arrow-to-open").hide();
      targetButton.find(".pull-down-arrow-to-close").show();
    }else{
      target.addClass("hidden");
      targetButton.find(".pull-down-arrow-to-close").hide();
      targetButton.find(".pull-down-arrow-to-open").show();
    }
  });

  $(".form-capacity-pull-down-button-right,").click(function(){
    if($(".form-capacity-description-body-right").hasClass("hidden")){
      $(".form-capacity-pull-down-button-right").children(".pull-down-arrow-to-open").show();
      $(".form-capacity-pull-down-button-right").children(".pull-down-arrow-to-close").hide();
    }else{
      $(".form-capacity-pull-down-button-right").children(".pull-down-arrow-to-open").hide();
      $(".form-capacity-pull-down-button-right").children(".pull-down-arrow-to-close").show();
    }
  });
  $(".form-capacity-pull-down-button-left").click(function(){
    if($(".form-capacity-description-body-left").hasClass("hidden")){
      $(this).children(".pull-down-arrow-to-open").show();
      $(this).children(".pull-down-arrow-to-close").hide();
    }else{
      $(this).children(".pull-down-arrow-to-open").hide();
      $(this).children(".pull-down-arrow-to-close").show();
    }
  });

  // 端末ポップアップ
  $(function(){
    $(".modal.js-modal").hide();
    $('.device-js-modal-open').each(function(){
      $(this).on('click',function(){
        var target = $(this).data('target');
        var modal = document.getElementById(target);
        $(modal).fadeIn();
        return false;
      });
    });
    $('.device-js-modal-close').on('click',function(){
      $('.js-modal').fadeOut();
      return false;
    });
  });

  // まとめて前払いプラン専用 プラン内訳
  $(".form-capacity-pull-down-button-left-special").click(function(e){
    // p in the button reacts
    var targetButton = $(this);
    var target = $(this).next('.form-capacity-description').find('.form-capacity-description-body-left');
    if (target.hasClass("hidden")){
      target.removeClass("hidden");
      targetButton.find(".pull-down-arrow-to-open").hide();
      targetButton.find(".pull-down-arrow-to-close").show();
      targetButton.addClass("form-capacity-pull-down-button-open");
      if (ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
        var targetButton2 = $(".form-capacity-pull-down-button-right-special");
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
  
  $(".form-capacity-pull-down-button-right-special").click(function(e){
    // p in the button reacts
    var targetButton = $(this);
    var target = $(this).next('.form-capacity-description').find('.form-capacity-description-body-right');
    if (target.hasClass("hidden")){
      target.removeClass("hidden");
      targetButton.find(".pull-down-arrow-to-open").hide();
      targetButton.find(".pull-down-arrow-to-close").show();
      targetButton.addClass("form-capacity-pull-down-button-open");
      if (ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
        var targetButton2 = $(".form-capacity-pull-down-button-left-special");
        var target2 = $('.form-capacity-description-body-left-special');
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
  
  $(".form-capacity-pull-down-button").click(function(e){
    // p in the button reacts
    var targetButton = $(e.target);
    var target = $('.form-capacity-description-body');
    if (target.hasClass("hidden")){
      target.removeClass("hidden");
      $("div.wimax-cashbackCP-detail").removeClass("hidden");
      targetButton.find(".pull-down-arrow-to-open").hide();
      targetButton.find(".pull-down-arrow-to-close").show();
      targetButton.addClass("form-capacity-pull-down-button-open");
      if (ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
        var targetButton2 = $(".form-capacity-pull-down-button-left");
        var target2 = $('.form-capacity-description-body-left');
        if(targetButton2.hasClass("form-capacity-pull-down-button-open")){
          target2.addClass("hidden");
          targetButton2.find(".pull-down-arrow-to-close").hide();
          targetButton2.find(".pull-down-arrow-to-open").show();
          targetButton2.removeClass("form-capacity-pull-down-button-open");
        }
      }
    }else{
      target.addClass("hidden");
      $("div.wimax-cashbackCP-detail").addClass("hidden");
      targetButton.find(".pull-down-arrow-to-close").hide();
      targetButton.find(".pull-down-arrow-to-open").show();
      targetButton.removeClass("form-capacity-pull-down-button-open");
    }
  });
})

// //
//device select
// //
//selectで、デフォルトの端末をH-01にする
$(document).ready(function() {
  if(window.location.pathname.includes("/entry/select")){
    $("#device_h01").click();
    $(".device-default-select").addClass("selected");
  }else{
    return;
  }
});

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
//Option button(WiMAX)start
// //
function expandFormOptionDetail1() {
  $('.entry-option.marugoto').removeAttr('tabindex', 0)
  var planOptionDetailClosed = $(
    "div.form-plan-option-detail-description"
  ).hasClass("form-plan-option-detail-description-close");
  const isWimaxForm = (window.location.pathname.includes("/entry/wimax/select")) || (window.location.pathname.includes("/entry/wimax/confirm"));
  $("div.form-plan-option-detail-2-description").addClass(
    "form-plan-option-detail-2-description-close"
  );
  $("div.form-plan-option-detail-2-button").removeClass(
    "form-plan-option-detail-button-open"
  );
  !isWimaxForm && $(".form-plan-option-detail-2-button").html("内容詳細　▼");
  $(".entry-option-right-under-r").removeClass("entry-option-right-open");
  $(".entry-option-right-under-rc").removeClass("entry-option-right-open-c");

  $("div.form-plan-option-detail-3-description").addClass(
    "form-plan-option-detail-3-description-close"
  );
  $("div.form-plan-option-detail-3-button").removeClass(
    "form-plan-option-detail-button-open"
  );
  !isWimaxForm && $(".form-plan-option-detail-3-button").html("内容詳細　▼");
  $("#wimax-entry-option-a2").removeClass("wimax-entry-option-a2");

  if (planOptionDetailClosed) {
    $("div.form-plan-option-detail-description").removeClass(
      "form-plan-option-detail-description-close"
    );
    $("div.form-plan-option-detail-button").addClass(
      "form-plan-option-detail-button-open"
    );
    $(".entry-option-right-under-l").addClass("entry-option-right-open");
    $(".entry-option-right-under-lc").addClass("entry-option-right-open-c");
    $("#wimax-entry-option-a1").addClass("wimax-entry-option-a1");
    !isWimaxForm && $(".form-plan-option-detail-button").html("内容詳細　▲");
    // WiMAX/端末あんしんオプションプルダウンのフォーカス制御
    if (isWimaxForm) {
      $('.form-plan-option-detail').attr('tabindex', 0);
      $('.form-plan-option-detail').focus();
      $('.form-plan-option-detail').keydown(function(event) {
        if( event.keyCode == 9 ) { // 9：TabキーのkeyCode
          $('.entry-option.marugoto').attr('tabindex', 0)
          $('.entry-option.marugoto').focus();
        }
      })
      $('#wimax-entry-option-a2').keyup(function(event) {
        if( event.keyCode == 9 ) { // 9：TabキーのkeyCode
          $('.entry-option.marugoto').removeAttr('tabindex', 0)
        }
      })
    }
  } else {
    $("div.form-plan-option-detail-description").addClass(
      "form-plan-option-detail-description-close"
    );
    $("div.form-plan-option-detail-button").removeClass(
      "form-plan-option-detail-button-open"
    );
    $(".entry-option-right-under-l").removeClass("entry-option-right-open");
    $(".entry-option-right-under-lc").removeClass("entry-option-right-open-c");
    $("#wimax-entry-option-a1").removeClass("wimax-entry-option-a1");
    !isWimaxForm && $(".form-plan-option-detail-button").html("内容詳細　▼");
    isWimaxForm && $('.form-plan-option-detail').removeAttr('tabindex', 0);
  }
}

function expandFormOptionDetail2() {
  var planOptionDetailClosed = $(
    "div.form-plan-option-detail-2-description"
  ).hasClass("form-plan-option-detail-2-description-close");
  const isWimaxForm = (window.location.pathname.includes("/entry/wimax/select")) || (window.location.pathname.includes("/entry/wimax/confirm"));

  $("div.form-plan-option-detail-description").addClass(
    "form-plan-option-detail-description-close"
  );
  $("div.form-plan-option-detail-button").removeClass(
    "form-plan-option-detail-button-open"
  );
  !isWimaxForm && $(".form-plan-option-detail-button").html("内容詳細　▼");
  $(".entry-option-right-under-l").removeClass("entry-option-right-open");
  $(".entry-option-right-under-lc").removeClass("entry-option-right-open-c");

  $("div.form-plan-option-detail-3-description").addClass(
    "form-plan-option-detail-3-description-close"
  );
  $("div.form-plan-option-detail-3-button").removeClass(
    "form-plan-option-detail-button-open"
  );
  !isWimaxForm && $(".form-plan-option-detail-3-button").html("内容詳細　▼");
  $("#wimax-entry-option-a1").removeClass("wimax-entry-option-a1");

  if (planOptionDetailClosed) {
    $("div.form-plan-option-detail-2-description").removeClass(
      "form-plan-option-detail-2-description-close"
    );
    $("div.form-plan-option-detail-2-button").addClass(
      "form-plan-option-detail-button-open"
    );
    $(".entry-option-right-under-r").addClass("entry-option-right-open");
    $(".entry-option-right-under-rc").addClass("entry-option-right-open-c");
    $("#wimax-entry-option-a2").addClass("wimax-entry-option-a2");
    !isWimaxForm && $(".form-plan-option-detail-2-button").html("内容詳細　▲");
    // WiMAX/丸ごと安心パックプルダウンのフォーカス制御
    if (isWimaxForm) {
      $('.form-plan-option-detail-2').attr('tabindex', 0);
      $('.form-plan-option-detail-2').focus();
    }
  } else {
    $("div.form-plan-option-detail-2-description").addClass(
      "form-plan-option-detail-2-description-close"
    );
    $("div.form-plan-option-detail-2-button").removeClass(
      "form-plan-option-detail-button-open"
    );
    $(".entry-option-right-under-r").removeClass("entry-option-right-open");
    $(".entry-option-right-under-rc").removeClass("entry-option-right-open-c");
    $("#wimax-entry-option-a2").removeClass("wimax-entry-option-a2");
    !isWimaxForm && $(".form-plan-option-detail-2-button").html("内容詳細　▼");
    isWimaxForm && $('.form-plan-option-detail-2').removeAttr('tabindex', 0);
  }
}

function expandFormOptionDetail3() {
  var planOptionDetailClosed = $(
    "div.form-plan-option-detail-3-description"
  ).hasClass("form-plan-option-detail-3-description-close");

  $("div.form-plan-option-detail-description").addClass(
    "form-plan-option-detail-description-close"
  );
  $("div.form-plan-option-detail-button").removeClass(
    "form-plan-option-detail-button-open"
  );
  $(".form-plan-option-detail-button").html("内容詳細　▼");

  $("div.form-plan-option-detail-2-description").addClass(
    "form-plan-option-detail-2-description-close"
  );
  $("div.form-plan-option-detail-2-button").removeClass(
    "form-plan-option-detail-button-open"
  );
  $(".form-plan-option-detail-2-button").html("内容詳細　▼");

  if (planOptionDetailClosed) {
    $("div.form-plan-option-detail-3-description").removeClass(
      "form-plan-option-detail-3-description-close"
    );
    $("div.form-plan-option-detail-3-button").addClass(
      "form-plan-option-detail-button-open"
    );
    $(".form-plan-option-detail-3-button").html("内容詳細　▲");
  } else {
    $("div.form-plan-option-detail-3-description").addClass(
      "form-plan-option-detail-3-description-close"
    );
    $("div.form-plan-option-detail-3-button").removeClass(
      "form-plan-option-detail-button-open"
    );
    $(".form-plan-option-detail-3-button").html("内容詳細　▼");
  }
}

// //
//Option button(WiMAX)end
// //

// //
// Topping 2
// //

//selectで、デフォルトをオプション「つける」にする
$(document).ready(function() {
  if(window.location.pathname.includes("/entry/select")||
     window.location.pathname.includes("/entry/corp/select")||
     window.location.pathname.includes("/entry/oh_specialplans/select")){
    $("#device_option_true").click();
    $(".entry-option-left > .topping-2-select-area").addClass("selected");
  }else{
    return;
  }
});

//selectで、デフォルトのプランを5Gギガ放題バリュープランにする
$(document).ready(function() {
  if(window.location.pathname.includes("/entry/wimax/select")){
    $("#plan_wimax_1").click();
    $(".wimax-plan-default-select").addClass("selected");
    $("#device_2").click();
    $(".x12-black").addClass("selected");
    $("#x12_detail1_id_1").click();
    $(".x12-color-1").addClass("selected");
    $("#installment_payment_2").click();
    $(".wimax-payment24").addClass("selected");
  }else{
    return;
  }
});

// WiMAX特別プラン start
//selectで、デフォルトをオプション「つける」にする
$(document).ready(function() {
  if(window.location.pathname.includes("/entry/wimax/closed/select")){
    $("#option1,#option2").click();
    $(".topping-2-select-area-wimax-option").addClass("selected");
  }else{
    return;
  }
});
// WiMAX特別プラン end

$(function(){
  if(window.location.pathname.includes("/entry/select")||window.location.pathname.includes("/entry/corp/select")){
    $("#option1,#option2,#option3").click();
    $(".topping-2-select-area-relief-option").addClass("selected");
  }else{
    return;
  }
});


function selectTopping2(target) {
  var checkBox = $(target).siblings(".topping-2-select-checkbox-area").find("input");
  checkBox.prop('checked', true);
  $(".topping-2-select-area").removeClass("selected");
  $(target).addClass("selected");
  updateSummary();
  updateCorpSummary();
  updateHikariSummary();
  updateTwitterCampaignSummary();
  updateOHSummary();
  updateRebniseSummary();
  updateTelephoneSummary();
}
function noselectTopping2(target) {
  var checkBox = $(target).siblings(".topping-2-select-checkbox-area").find("input");
  checkBox.prop('checked', false);
  $(".topping-2-select-area").addClass("selected");
  $(target).removeClass("selected");
  updateSummary();
  updateCorpSummary();
  updateHikariSummary();
  updateTwitterCampaignSummary();
  updateOHSummary();
  updateRebniseSummary();
  updateTelephoneSummary();
}
$(document).ready(function() {

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

});

function selectToppingWimaxX11Detail1(target) {
  var checkBox = $(target).siblings(".topping-2-select-checkbox-area").find("input");
  checkBox.prop('checked', true);
  $(".topping-2-select-area-wimax-x11-detail1").removeClass("selected");
  $(target).addClass("selected");
  updateWimaxSummary();
  updateWimaxClosedSummary();

  if(window.location.pathname.includes('/entry/wimax/confirm')){

    var x12_detail1_change = $("input[name=x12_detail1]:checked").val();

    // device color (Speed Wi-Fi 5G X11選択時のみ)
    if(x12_detail1_change == 1){
      $(".x12-black").show();
      $(".x12-white").hide();
      $(".x12-black").addClass("selected");
      $(".x12-white").removeClass("selected");
    }else if(x12_detail1_change == 2){
      $(".x12-black").hide();
      $(".x12-white").show();
      $(".x12-white").addClass("selected");
      $(".x12-black").removeClass("selected");
    }else{
      $(".x12-black").show();
      $(".x12-white").hide();
    }
  }
}

$(document).ready(function() {
  $(".topping-2-select-area-wimax-x11-detail1").hover(
    function(e){
      // hover can react to child elements of the class
      $(this).addClass("active");
    },
    function (e){
      // hover can react to child elements of the class
      $(this).removeClass("active");
    }
  )
  $(".topping-2-select-area-wimax-x11-detail1").click(function(e){
    var target = $(e.target).parents('.topping-2-select-area-wimax-x11-detail1');
    selectToppingWimaxX11Detail1(target);
  })
});

function selectToppingWimaxX11Detail2(target) {
  var checkBox = $(target).siblings(".topping-2-select-checkbox-area").find("input");
  checkBox.prop('checked', true);
  $(".topping-2-select-area-wimax-x11-detail2").removeClass("selected");
  $(target).addClass("selected");
  updateWimaxSummary();
}
$(document).ready(function() {
  $(".topping-2-select-area-wimax-x11-detail2").hover(
    function(e){
      // hover can react to child elements of the class
      $(this).addClass("active");
    },
    function (e){
      // hover can react to child elements of the class
      $(this).removeClass("active");
    }
  )
  $(".topping-2-select-area-wimax-x11-detail2").click(function(e){
    var target = $(e.target).parents('.topping-2-select-area-wimax-x11-detail2');
    selectToppingWimaxX11Detail2(target);
  })
});

function selectToppingWimaxPeriod(target) {
  var checkBox = $(target).siblings(".topping-2-select-checkbox-area").find("input");
  checkBox.prop('checked', true);
  $(".topping-2-select-area-wimax-period").removeClass("selected");
  $(target).addClass("selected");
  updateWimaxSummary();
}
$(document).ready(function() {
  $(".topping-2-select-area-wimax-period").hover(
    function(e){
      // hover can react to child elements of the class
      $(this).addClass("active");
    },
    function (e){
      // hover can react to child elements of the class
      $(this).removeClass("active");
    }
  )
  $(".topping-2-select-area-wimax-period").click(function(e){
    var target = $(e.target).parents('.topping-2-select-area-wimax-period');
    selectToppingWimaxPeriod(target);
  })
});

function selectToppingWimaxPayment(target) {
  var checkBox = $(target).siblings(".topping-2-select-checkbox-area").find("input");
  checkBox.prop('checked', true);
  $(".topping-2-select-area-wimax-payment").removeClass("selected");
  $(target).addClass("selected");
  updateWimaxSummary();
}
$(document).ready(function() {
  $(".topping-2-select-area-wimax-payment").hover(
    function(e){
      // hover can react to child elements of the class
      $(this).addClass("active");
    },
    function (e){
      // hover can react to child elements of the class
      $(this).removeClass("active");
    }
  )
  $(".topping-2-select-area-wimax-payment").click(function(e){
    var target = $(e.target).parents('.topping-2-select-area-wimax-payment');
    selectToppingWimaxPayment(target);
  })
});


//ZEUS WiFiセットプラン
function selectToppingWimaxZeusSet(target) {
  var checkBox = $(target).siblings(".topping-2-select-checkbox-area").find("input");
  checkBox.prop('checked', true);
  $(".topping-2-select-area-wimax-zeus-set").removeClass("selected");
  $(target).addClass("selected");
  updateWimaxSummary();
}
$(document).ready(function() {
  $(".topping-2-select-area-wimax-zeus-set").hover(
    function(e){
      $(this).addClass("active");
    },
    function (e){
      $(this).removeClass("active");
    }
  )
  $(".zeus-giga-area").hide();
  $(".option-zeus-wifi").hide();

  $(".topping-2-select-area-wimax-zeus-set").click(function(e){
    var target = $(e.target).parents('.topping-2-select-area-wimax-zeus-set');
    selectToppingWimaxZeusSet(target);

    var set_check = $('input:radio[name="zeus_set"]:checked').val();
    if(set_check == "set1"){
      $(".zeus-giga-area").show();

      //端末あんしんオプションの表示数を変える
      $(".option-zeus-wifi").show();
    }else{
      $('input.zeus_set_gb:checked').prop("checked" , false);
      $(".topping-2-select-area-wimax-zeus-set-giga").removeClass("selected");
      $(".zeus-giga-area").hide();

      //確認画面なら、セットプランを「つけない」で確定させたら、オプションの表示数を変える
      if(window.location.pathname.includes("/entry/wimax/confirm")){
        var setFalse = $(".confirm-pay").find("#zeus-set-0");
        if(set_check == "set0" && setFalse == "true"){
          //端末あんしんオプションをwimaxだけにする
          $(".option-zeus-wifi").hide();
          $("input[id=option1_2]").prop("checked", false);
          $("input[id=option1_2]").parents($(".topping-2-select-area-wimax-zeus-set-giga")).removeClass("selected");
          $("input[id=option1_3]").prop("checked", false);
          $("input[id=option1_3]").parents($(".topping-2-select-area-wimax-zeus-set-giga")).removeClass("selected");
        }
      }else{
        //端末あんしんオプションをwimaxだけにする
        $(".option-zeus-wifi").hide();
        $("input[id=option1_2]").prop("checked", false);
        $("input[id=option1_2]").parents($(".topping-2-select-area-wimax-zeus-set-giga")).removeClass("selected");
        $("input[id=option1_3]").prop("checked", false);
        $("input[id=option1_3]").parents($(".topping-2-select-area-wimax-zeus-set-giga")).removeClass("selected");
      }
    }
    updateWimaxSummary();

  })
});

function selectToppingWimaxZeusSetGiga(target) {
  var checkBox = $(target).siblings(".topping-2-select-checkbox-area").find("input");
  checkBox.prop('checked', true);
  $(".topping-2-select-area-wimax-zeus-set-giga").removeClass("selected");
  $(target).addClass("selected");
  updateWimaxSummary();
}
$(document).ready(function() {
  $(".topping-2-select-area-wimax-zeus-set-giga").hover(
    function(e){
      $(this).addClass("active");
    },
    function (e){
      $(this).removeClass("active");
    }
  )
  $(".topping-2-select-area-wimax-zeus-set-giga").click(function(e){
    var target = $(e.target).parents('.topping-2-select-area-wimax-zeus-set-giga');
    selectToppingWimaxZeusSetGiga(target);
  })
});

$(window).on('load resize', function(){
  var winW = $(window).width();
  var devW = 767;
  if (winW > devW) {
    $(".topping-2-select-area-wimax-option").hover(
      function(e){
        // hover can react to child elements of the class
        $(this).addClass("active");
      },
      function (e){
        // hover can react to child elements of the class
        $(this).removeClass("active");
      }
    )
  }
});



$(function() {
  var target;
  $(".topping-2-select-area-wimax-option").click(function(){
    target = $(this);

    var deviceOption1 = $("input.option1:checked").val();
    if (deviceOption1 === undefined) {
      deviceOption1 = 'false';
    }

    var deviceOption2 = $("input[id=option2]:checked").val();
    if (deviceOption2 === undefined) {
      deviceOption2 = 'false';
    }

    //target(this)が端末あんしんオプション　かつ　targetがチェックされていない場合
    if(target.find("input.option1").prop("checked") == true && deviceOption2 === '12'){
      if($("input[id=plan_wimax_1]").prop("checked") == true){
        showDeviceWiMAXOptionPopup('option1');
      }else if($("input[id=plan_wimax_2]").prop("checked") == true){
        showDeviceWiMAXOption2Popup('option1');
      }
    }else if((deviceOption1 === '33'||deviceOption1 === '1'||deviceOption1 === '13') && target.find("input#option2").prop("checked") == true){
      if($("input[id=plan_wimax_1]").prop("checked") == true){
        showDeviceWiMAXOptionPopup('option2');
      }else if($("input[id=plan_wimax_2]").prop("checked") == true){
        showDeviceWiMAXOption2Popup('option2');
      }
    }else{
      updateWimaxSummary();
    }
  });

  //オプションのチェックボックス切り替え
  $(function($){
    $('.entry-option-left-option .topping-2-select-area-wimax-option').click(function() {
      if($(this).find('input:checkbox').prop('checked')){
        $('.entry-option-left-option .topping-2-select-area-wimax-option').find('input:checkbox').prop('checked', false);
        $('.entry-option-left-option .topping-2-select-area-wimax-option').removeClass('selected');
        $('.entry-option-left-option .topping-2-select-area-wimax-option').removeClass('active');
      }else{
        $('.entry-option-left-option .topping-2-select-area-wimax-option').find('input:checkbox').prop('checked', false);
        $('.entry-option-left-option .topping-2-select-area-wimax-option').removeClass('selected');
        $(this).find('input:checkbox').prop('checked', true);
        $(this).addClass('selected');
      }
      updateWimaxSummary();
    });

    $('.entry-option-right-option-2 .topping-2-select-area-wimax-option').click(function() {
      if($(this).find('input:checkbox').prop('checked')){
        $(this).find('input:checkbox').prop('checked', false);
        $(this).removeClass('selected');
        $(this).removeClass('active');
      }else{
        $(this).find('input:checkbox').prop('checked', true);
        $(this).addClass('selected');
      }
      updateWimaxSummary();
    });
});

  $(".wimax-device-option-confirm-button").click(function(){
    selectToppingWimaxCampaign(target);
    hideDeviceWiMAXOptionPopup();
  });

  $(".wimax-device-option-confirm-button-back").click(function(){
    selectToppingWimaxCampaign2(target);
    hideDeviceWiMAXOptionPopup();
  });

  $(".wimax-device-option2-confirm-button").click(function(){
    selectToppingWimaxCampaign(target);
    hideDeviceWiMAXOption2Popup();
  });

  $(".wimax-device-option2-confirm-button-back").click(function(){
    selectToppingWimaxCampaign2(target);
    hideDeviceWiMAXOption2Popup();
  });

  // 選択されたオプション
  let selectOption = '';

  function showDeviceWiMAXOptionPopup(option){
    $(".device-option-confirm-popup").show();
    $(".form-black-background-device-option").show();
    $('.js-focus-target').focus();
    selectOption = option;
  }

  function hideDeviceWiMAXOptionPopup(){
    $(".device-option-confirm-popup").hide();
    $(".form-black-background-device-option").hide();
    selectOption === 'option1' && $('#wimax-entry-option-a1').focus()
    selectOption === 'option2' && $('#wimax-entry-option-a2').focus()
  }

  function showDeviceWiMAXOption2Popup(option){
    $(".device-option2-confirm-popup").show();
    $(".form-black-background-device-option2").show();
    $('.js-focus-target').focus();
    selectOption = option;
  }

  function hideDeviceWiMAXOption2Popup(){
    $(".device-option2-confirm-popup").hide();
    $(".form-black-background-device-option2").hide();
    selectOption === 'option1' && $('#wimax-entry-option-a1').focus()
    selectOption === 'option2' && $('#wimax-entry-option-a2').focus()
  }

  $(".topping-2-select-area-wimax-campaign").hover(
    function(e){
      // hover can react to child elements of the class
      $(this).addClass("active");
    },
    function (e){
      // hover can react to child elements of the class
      $(this).removeClass("active");
    }
  );
  $(".topping-2-select-area-wimax-campaign").click(function(e){
    var target = $(e.target).parents('.topping-2-select-area-wimax-campaign');
    selectToppingWimaxCampaign(target);
  })

  //オプション「変更する」
  function selectToppingWimaxCampaign(target) {
    var checkBox = $(target).find("input");
    if(checkBox.prop('checked')){
      checkBox.prop('checked', true);
      $(target).addClass("selected");
    } else {
      checkBox.prop('checked', false);
      $(target).removeClass("selected");
    }
    updateWimaxSummary();
  }

  //オプション「変更しない」
  function selectToppingWimaxCampaign2(target) {
    var checkBox = $(target).find("input");
    if(checkBox.prop('checked')){
      checkBox.prop('checked', false);
      $(target).removeClass("selected");
    } else {
      checkBox.prop('checked', true);
      $(target).addClass("selected");
    }
    updateWimaxSummary();
    updateWimaxClosedSummary();
  }
});

function selectToppingWimaxConfirm(target) {
  var checkBox = $(target).siblings(".form-capacity-select-checkbox-area").find("input");
  checkBox.prop('checked', true);

  if(checkBox.val() == '7') {
    $('.x12-detail').show();
    $('.wimax-item-color-confirm').on('click', function(){
      // device color (Speed Wi-Fi 5G X11選択時のみ)
      if($("input[name=x12_detail1]:checked").val()==="1"){
        $(".x12-black").show();
        $(".x12-white").hide();
        $(".x12-black").addClass("selected");
        $(".x12-white").removeClass("selected");
      }else if($("input[name=x12_detail1]:checked").val()==="2"){
        $(".x12-black").hide();
        $(".x12-white").show();
        $(".x12-white").addClass("selected");
        $(".x12-black").removeClass("selected");
      }else{
        $(".x12-black").show();
        $(".x12-white").hide();
      }
    });
  }else {
    $('.x12-detail').hide();
  };

  $('.x11-detail').addClass('wimax-no-select-x11');
  $(".topping-2-select-area-wimax-confirm").removeClass("selected");
  $(target).addClass("selected");
  if ($(".x11select").hasClass('selected')) {
    $('.x11-detail').removeClass('wimax-no-select-x11');
  }
  updateWimaxSummary();
  updateWimaxClosedSummary();
}
$(document).ready(function() {
  $(".topping-2-select-area-wimax-confirm").hover(
    function(e){
      // hover can react to child elements of the class
      $(this).addClass("active");
    },
    function (e){
      // hover can react to child elements of the class
      $(this).removeClass("active");
    }
  )

  $(".topping-2-select-area-wimax-confirm").click(function(e){
    var target = $(e.target).parents('.topping-2-select-area-wimax-confirm');
    selectToppingWimaxConfirm(target);
  })

});

$(function() {
  // 法人申込み 台数変更した時の処理
  $("select[name='quantity']").on('change', function(){
    // 台数を取得する
    var deviceQuantityVal = $("select[name='quantity'] option:selected").val();
    var deviceQuantity = "<span class='your-plan-quantity'>" + deviceQuantityVal + "</span>台";

    //【あなたのプランはこちら】に台数を表示する
    $(".summary-text-quantity").html(deviceQuantity);

    updateCorpSummary();
  });
});

// //
// Device Option Popup
// //
// logincs are in script.js

// //
// Update summary
// //
var gSummaryPrices = {
  plan_id: {
    "1": {
      "capacity": 50,
      "price": 3828,
      "price2": 3828,
      "cancel_fee":0,
    },
    "2": {
      "capacity": 100,
      "price": 4708,
      "price2": 4708,
      "cancel_fee":0,
    },
    "326": {
      "capacity": 50,
      "price": 1480,
      "price2": 3106,
      "cancel_fee":3278,
      "price_after": 3278,
    },
    "327": {
      "capacity": 100,
      "price": 1980,
      "price2": 3212,
      "cancel_fee":3828,
      "price_after": 3828,
    },
    "328": {
      "capacity": 30,
      "price": 980,
      "price2": 2361,
      "cancel_fee":2508,
      "price_after": 2508,
    },
    "329": {
      "capacity": 30,
      "price": 3168,
      "price2": 3168,
    },
    "363": {
      "capacity": 30,
      "price": 980,
      "price2": 2361,
      "cancel_fee":2508,
      "price_after": 2508,
    },
    "361": {
      "capacity": 30,
      "price": 3168,
      "price2": 3168,
      "cancel_fee":0,
    },
    "364": {
      "capacity": 50,
      "price": 1480,
      "price2": 3106,
      "cancel_fee":3278,
      "price_after": 3278,
    },
    "362": {
      "capacity": 50,
      "price": 3828,
      "price2": 3828,
      "cancel_fee":0,
    },
    "365": {
      "capacity": 100,
      "price": 1980,
      "price2": 3212,
      "cancel_fee":3828,
      "price_after": 3828,
    },
    "697": {
      "capacity": 30,
      "price": 0,
      "price2": 2508,
      "cancel_fee": 2508,
      "month": 5,
      "period": 1,
    },
    "698": {
      "capacity": 50,
      "price": 0,
      "price2": 3278,
      "cancel_fee": 3278,
      "month": 5,
      "period": 1,
    },
    "699": {
      "capacity": 100,
      "price": 0,
      "price2": 3828,
      "cancel_fee": 3828,
      "month":5,
      "period": 1,
    },
    "700": {
      "capacity": 30,
      "price": 0,
      "price2": 2508,
      "cancel_fee": 2508,
      "month":12,
      "period": 1,
    },
    "701": {
      "capacity": 50,
      "price": 0,
      "price2": 3278,
      "cancel_fee": 3278,
      "month": 12,
      "period": 1,
    },
    "702": {
      "capacity": 100,
      "price": 0,
      "price2": 3828,
      "cancel_fee": 3828,
      "month": 12,
      "period": 1,
    },
    "703": {
      "capacity": 30,
      "price": 0,
      "price2": 3168,
      "cancel_fee": 3168,
      "month": 5,
      "period": 0,
    },
    "704": {
      "capacity": 50,
      "price": 0,
      "price2": 3828,
      "cancel_fee":3828,
      "month":5,
      "period": 0,
    },
    "705": {
      "capacity": 100,
      "price": 0,
      "price2": 4708,
      "cancel_fee": 4708,
      "month": 5,
      "period": 0,
    },
    "706": {
      "capacity": 30,
      "price": 0,
      "price2": 3168,
      "cancel_fee": 3168,
      "month": 12,
      "period": 0,
    },
    "707": {
      "capacity": 50,
      "price": 0,
      "price2": 3828,
      "cancel_fee": 3828,
      "month": 12,
      "period": 0,
    },
    "708": {
      "capacity": 100,
      "price": 0,
      "price2": 4708,
      "cancel_fee": 4708,
      "month": 12,
      "period": 0,
    },
  },
  deviceOption: {
    'true': 580,
    'false': 0,
  },
  deviceOption01: {
    "16": {
      "price": 580,
    },
    "false": {
      "price": 0,
    },
  },
  deviceOption02: {
    "12": {
      "price": 999,
    },
    "false": {
      "price": 0,
    },
  },
  insuranceOption: {
    "14": {
      "price": 660,
    },
    "15": {
      "price": 990,
    },
    "-1": {
      "price": 0,
    },
  }
}

function updateCorpSummary(){

  let planFee;

  var isOptionsPage = location.pathname.indexOf("/entry/corp/select") === 0;
  if(!isOptionsPage){
    // Not options page
    return;
  }

  // gSelectedCapacity is given in entry/options in script tag
  var capacity = gSelectedCapacity;
  var plan_id = $("input[name=plan_id]:checked").val();
  if (plan_id === undefined) {
    plan_id = $("input:hidden[name=plan_id]").val();
  }
  var deviceOption01 = $("input[name=device_option]:checked").val();
  var initialFee = gInitialFee;
  var cancelFee = gCancelFee;

  // 台数を取得する
  var deviceQuantity = $("select[name='quantity'] option:selected").val();

  //
  // Text
  // ///

  // capacity
  // $(".summary-text-capacity").text(capacity);

  // tie
  if(gSummaryPrices.plan_id[plan_id] && gSummaryPrices.plan_id[plan_id].cancel_fee > 0){
    $(".summary-text-tie-plan-name").text("スタンダードプラン");
    $(".summary-text-tie-period").text("(契約期間2年)");
    $(".summary-text-capacity").html("<br class='sp'>" + gSummaryPrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryPrices.plan_id[plan_id].cancel_fee;
  }else if (gSummaryPrices.plan_id[plan_id] && gSummaryPrices.plan_id[plan_id].cancel_fee === 0){
    $(".summary-text-tie-plan-name").text("フリープラン");
    $(".summary-text-tie-period").text("(契約期間なし)");
    $(".summary-text-capacity").html("<br class='sp'>" + gSummaryPrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryPrices.plan_id[plan_id].cancel_fee;
  }else{
    $(".summary-text-tie-title").text("未選択");
    $(".summary-text-tie-period").text("未選択");
    cancelFee = 0;
  }

  // device option
  if(deviceOption01 === 'true'){
    $(".summary-text-device-option-title").html("つける");
    $(".summary-text-device-option-price").html("580" + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
  }else if(deviceOption01 === '16'){
    $(".summary-text-device-option-title").html("つける");
    $(".summary-text-device-option-price").html("580" + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
  }else if(deviceOption01 === 'false'){
    $(".summary-text-device-option-title").text("つけない");
    $(".summary-text-device-option-price").html("0" + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
  }else{
    $(".summary-text-device-option-title").text("未選択");
    $(".summary-text-device-option-price").html("0" + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
  }

  // ///
  // price
  // ///

  // initial and cancel
  $(".summary-text-initial-fee").html(initialFee.toLocaleString() + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
  if(cancelFee > 0){
    $(".summary-text-cancel-fee").html("<span class='small-price-attention'>※</span>");
    $(".summary-text-cancel-tax-fee").html(cancelFee.toLocaleString() + "<span class='plan-tax'>円</span>");
  }else{
    $(".summary-text-cancel-fee").html("");
    $(".summary-text-cancel-tax-fee").html("0<span class='plan-tax'>円</span>");
  }

  // monthly
  if (gSummaryPrices.plan_id[plan_id]) {
    planFee = gSummaryPrices.plan_id[plan_id].price;
    var planFee2 = gSummaryPrices.plan_id[plan_id].price2;
    if (gSummaryPrices.plan_id[plan_id].price_after) {
      priceAfter = gSummaryPrices.plan_id[plan_id].price_after;
    }
  } else {
    planFee = 0;
    planFee2 = 0;
    priceAfter = 0;
  }

  var deviceOptionKey01 = deviceOption01 || "false";
  var deviceOptionFee = gSummaryPrices.deviceOption01[deviceOptionKey01].price;
  var monthlyFee = (planFee + deviceOptionFee) * deviceQuantity;
  var monthlyFee2 = (planFee2 + deviceOptionFee) * deviceQuantity;
  var monthlyFeeAfter = (priceAfter + deviceOptionFee) * deviceQuantity;
  var initialCost = 3300 * deviceQuantity;

  $("#campaign_row").hide();
  $("#campaign_attention").hide();
  $(".monthly-period2.open").hide();
  $(".after-payment.open").hide();
  $(".monthly-period.breakdown").hide();
  $(".summary-text-monthly").text("");
  $(".monthly-payment-after").text("");

  if (gSummaryPrices.plan_id[plan_id]) {
    $(".summary-text-monthly-tax-total").html(monthlyFee.toLocaleString() + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
    $(".monthly-period.breakdown").show();
    $(".monthly-period2.open").show();
    $(".monthly-period2.breakdown").show();
    $(".after-payment.open").show();
    $(".device-option-list").show();
    if(deviceOption01 === 'false'){
      $(".device-option-list").hide();
    }

    $(".initial-cost-breakdown").html("3,300<span class='plan-tax'>円 ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span>");
    $(".summary-text-initial-fee").html(initialCost.toLocaleString() + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");

    if(plan_id == "326" || plan_id == "327" || plan_id == "328" || plan_id == "363" || plan_id == "364" || plan_id == "365"){
      $("#campaign_row").show();
      $("#campaign_attention").show();
      // 割引期間
      var discountMonthEarly = 3;
      var discountMonthLate = 24;
      // 合計とプルダウン
      $(".summary-text-campaign-name").html("神コスパキャンペーン 第2弾");
      $(".summary-text-monthly").html(discountMonthEarly + "ヶ月目まで");
      $(".summary-text-monthly-tax-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
      $(".summary-text-monthly-tax-total2").html((monthlyFee2).toLocaleString() + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
      $(".breakdown-plan-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円 ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span>");
      $(".breakdown-plan-fee2").html(planFee2.toLocaleString() + "<span class='plan-tax'>円 ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span>");
      $(".breakdown-plan-after-fee").html(priceAfter.toLocaleString() + "<span class='plan-tax'>円 ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span>");
      $(".breakdown-device01-option").html("580<span class='plan-tax'>円 ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span>");
      $(".monthly-payment-after").html(monthlyFeeAfter.toLocaleString() + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
      // 注意書き
      $(".campaign-attention").html("※神コスパキャンペーン第2弾について<br>"
      + "<span class='attention-indent'>課金開始月を1ヶ月目として、" + discountMonthEarly + "ヶ月目までの月額基本料を" + planFee.toLocaleString() + "円、<br class='pc'>"
      + discountMonthLate + "ヶ月目までの月額基本料を" + planFee2.toLocaleString() + "円、" + "" + (discountMonthLate + 1) + "ヶ月目以降の月額基本料を" + priceAfter.toLocaleString() + "円といたします。</span>"
      + "<br>"
      + "※契約期間について<br>"
      + "<span class='attention-indent'>課金開始日が属する月を起算として24ヶ月の契約とします。<br class='pc'>"
      + "契約期間内に解約した場合は、解約事務手数料（" + priceAfter.toLocaleString() + "円）が発生します。</span>"
      + "<br>"
      );
    }else{
      $("#campaign_row").hide();
      $("#campaign_attention").hide();
      $(".monthly-period2.open").hide();
      $(".monthly-period2.breakdown").hide();
      $(".monthly-period.after-payment.breakdown").hide();
      $(".after-payment.open").hide();
      // 合計とプルダウン
      $(".summary-text-monthly").html("");
      $(".breakdown-plan-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円 ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span>");
      $(".breakdown-device01-option").html("580<span class='plan-tax'>円 ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span>");
      $(".summary-text-monthly-tax-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
    }
  }else{
    $(".summary-text-monthly-tax-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
    $(".summary-text-monthly-tax-total").html(monthlyFee.toLocaleString() + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
    if(deviceOptionFee>0){
      $(".summary-text-monthly-tax-total").html(monthlyFee.toLocaleString() + "<span class='plan-tax'>円</span>" + "<span class='width-adjustment'><span class='plan-tax'> ✕ </span>" + deviceQuantity + "<span class='plan-tax'>台</span></span>");
    }
  }
}

function updateSummary(){

  var isOptionsPage = location.pathname.indexOf("/entry/select") === 0;
  if(!isOptionsPage){
      // Not options page
      return;
  }

  // gSelectedCapacity is given in entry/options in script tag
  var capacity = gSelectedCapacity;
  var plan_id = $("input[name=plan_id]:checked").val();
  if (plan_id === undefined) {
      plan_id = $("input:hidden[name=plan_id]").val();
  }

  var deviceOption01 = $("input[id=option1]:checked").val();
  if (deviceOption01 === undefined) {
    deviceOption01 = 'false';
  }

  var deviceOption02 = $("input[id=option2]:checked").val();
  if (deviceOption02 === undefined) {
    deviceOption02 = 'false';
  }
  var deviceOptionKey01 = deviceOption01 || "false";
  var deviceOptionKey02 = deviceOption02 || "false";
  var deviceOption01_price = gSummaryPrices.deviceOption01[deviceOptionKey01].price;
  var deviceOption02_price = gSummaryPrices.deviceOption02[deviceOptionKey02].price;

  var insuranceOption = $("input[name=option_id_insurance]:checked").val();
  var insuranceOptionKey = insuranceOption;
  var insuranceOption_price = gSummaryPrices.insuranceOption[insuranceOptionKey].price;

  var initialFee = gInitialFee;
  var cancelFee = gCancelFee;

  //
  // Text
  // ///

  // capacity
  // $(".summary-text-capacity").text(capacity);

  // tie
  if(gSummaryPrices.plan_id[plan_id] && gSummaryPrices.plan_id[plan_id].cancel_fee > 0){
    $(".summary-text-tie-plan-name").text("スタンダードプラン");
    $(".summary-text-tie-period").text("(契約期間2年)");
    $(".summary-text-capacity").html(gSummaryPrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryPrices.plan_id[plan_id].cancel_fee;
  }else if (gSummaryPrices.plan_id[plan_id] && gSummaryPrices.plan_id[plan_id].cancel_fee === 0){
    $(".summary-text-tie-plan-name").text("フリープラン");
    $(".summary-text-tie-period").text("(契約期間なし)");
    $(".summary-text-capacity").html(gSummaryPrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryPrices.plan_id[plan_id].cancel_fee;
  }else{
    $(".summary-text-tie-title").text("未選択");
    $(".summary-text-tie-period").text("未選択");
    cancelFee = 0;
  }

    // device option01
  if(deviceOption01 === '16'){
    // $(".summary-text-device-option-title01").html("つける");
    $(".summary-text-device-option-price01").html(deviceOption01_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
  }else{
    // $(".summary-text-device-option-title01").text("つけない");
    $(".summary-text-device-option-price01").html("0" + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
  }

  // device option02
  if(deviceOption02 === '12'){
    // $(".summary-text-device-option-title02").html("つける");
    $(".summary-text-device-option-price02").html(deviceOption02_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
  }else{
    // $(".summary-text-device-option-title02").text("つけない");
    $(".summary-text-device-option-price02").html("0" + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
  }

  // insurance option
  var attentionNumber;
  if(plan_id == "363" || plan_id == "364" || plan_id == "365"){
    attentionNumber = 2;
  }else{
      attentionNumber = 1;
  }
  if(insuranceOption === '14'){
    $(".breakdown-insurance-option-title").closest('div.breakdown-list').show();
    // $(".summary-text-insurance-option-title").html("つける");
    $(".summary-text-insurance-option-premium").html("");
    $(".summary-text-insurance-option-price").html("0<span class='plan-tax'>円</span><span class='small-price-attention'>※" + attentionNumber + "</span>");
    $(".insurance-option-campaign").html("※" + attentionNumber + "：デジタルライフサポートスタートキャンペーン<br>課金開始月を1ヶ月目として、2ヶ月目までのデジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞利用料を無料、3ヶ月目以降を" + insuranceOption_price + "円といたします。");
  }else if(insuranceOption === '15'){
    $(".breakdown-insurance-option-title").closest('div.breakdown-list').show();
    // $(".summary-text-insurance-option-title").html("つける");
    $(".summary-text-insurance-option-premium").html("/プレミアム");
    $(".summary-text-insurance-option-price").html("0<span class='plan-tax'>円</span><span class='small-price-attention'>※" + attentionNumber + "</span>");
    $(".insurance-option-campaign").html("※" + attentionNumber + "：デジタルライフサポートスタートキャンペーン<br>課金開始月を1ヶ月目として、2ヶ月目までのデジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞／プレミアム利用料を無料、3ヶ月目以降を" + insuranceOption_price + "円といたします。");
  }else if(insuranceOption === '-1'){
    // $(".summary-text-insurance-option-title").html("つけない");
    $(".summary-text-insurance-option-premium").html("");
    $(".summary-text-insurance-option-price").html("0" + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
    $(".insurance-option-campaign").html("");
    $(".breakdown-insurance-option-title").closest('div.breakdown-list').hide();
  }

  // ///
  // price
  // ///

  // initial and cancel
  $(".summary-text-initial-fee").html(initialFee.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
  $("#cancel_fee_attention").hide();
  if(cancelFee > 0){
    $(".summary-text-cancel-fee").html("<span class='small-price-attention'>※</span>");
    $(".summary-text-cancel-tax-fee").html(cancelFee.toLocaleString() + "<span class='plan-tax'>円</span>");
    $("#cancel_fee_attention").show();
  }else{
    $(".summary-text-cancel-fee").html("");
    $(".summary-text-cancel-tax-fee").html("0<span class='plan-tax'>円</span>");
  }

  // monthly

  let planFee;  //3ヶ月目までの割引後料金
  let planFee2; //24ヶ月目までの割引後料金

  if (gSummaryPrices.plan_id[plan_id]) {
    planFee = gSummaryPrices.plan_id[plan_id].price;
    planFee2 = gSummaryPrices.plan_id[plan_id].price2;
    if (gSummaryPrices.plan_id[plan_id].price_after) {
      priceAfter = gSummaryPrices.plan_id[plan_id].price_after;
    }
  } else {
    planFee = 0;
  }

  var deviceOptionFee =  deviceOption01_price + deviceOption02_price;
  var monthlyFee = planFee + deviceOptionFee + insuranceOption_price;
  var monthlyFee2 = planFee2 + deviceOptionFee + insuranceOption_price;
  var campaignFee = planFee + deviceOptionFee;
  var campaignFee2 = planFee2 + deviceOptionFee;
  var insuranceCampaignFee = planFee + deviceOptionFee;
  var insuranceCampaignFee2 = planFee2 + deviceOptionFee;

  $("#campaign_row").hide();
  $("#campaign_attention").hide();
  $(".campaign-period").hide();
  $(".summary-text-monthly").text("");
  $(".monthly-payment-after").text("");
  $(".monthly-campaign-after").hide();
  $(".monthly-period.breakdown").hide();
  $(".monthly-period2.open").hide();
  $(".monthly-period2.breakdown").hide();
  $(".after-payment").hide();

  if (gSummaryPrices.plan_id[plan_id]) {
    $(".summary-text-monthly-tax-total").html(monthlyFee.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
    $(".summary-text-monthly-tax-total2").html(monthlyFee2.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
    $(".summary-text-campaign-tax-total").html(campaignFee.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
    if((plan_id == "326" || plan_id == "327" || plan_id == "328" || plan_id == "363" || plan_id == "364" || plan_id == "365")){
      $(".summary-text-monthly-tax-fee").html("" + planFee.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'>※1</span>");
      $("#campaign_row").show();
      $("#campaign_attention").show();
      if((insuranceOption === '14' || insuranceOption === '15')){
        $(".campaign-period").show();
      }
      $(".monthly-period").show();
      $(".monthly-period2").show();
      $(".monthly-campaign-after").hide();
      if((insuranceOption === '14' || insuranceOption === '15')){
        $(".summary-text-campaign-name").html("神コスパキャンペーン 第2弾<br>デジタルライフサポートスタートキャンペーン");
      }else{
        $(".summary-text-campaign-name").html("神コスパキャンペーン 第2弾");
      }
      var campaignMonth = 2;
      var discountMonthEarly = 3;
      var discountMonthLate = 24;
      $(".summary-text-campaign").html(campaignMonth + "ヶ月目まで");
      $(".breakdown-plan-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      $(".breakdown-plan-fee2").html(planFee2.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      $(".summary-text-monthly").html(discountMonthEarly + "ヶ月目まで");
      $(".summary-text-monthly2").html(discountMonthLate + "ヶ月目まで");
      $(".monthly-period.breakdown").show();
      $(".monthly-period2.breakdown").show();
      // 内訳
      if(deviceOption01_price>0) {
        $(".options-rows").show();
        $('.device01-option').show();
        if (window.matchMedia("(min-width: 768px)").matches) {
          $('.plan-summary-table-row.insurance-option').css('border-top','1px solid #909090');
        }
        $(".breakdown-device01-option-title").html("端末あんしんオプション");
        $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      } else {
        $('.device01-option').hide();
        $('.plan-summary-table-row.insurance-option').css('border-top','none');
      }
      if(deviceOption02_price>0) {
        $(".options-rows").show();
        $('.device02-option').show();
        $(".breakdown-device02-option-title").html("丸ごと安心パック for ZEUS WiFi");
        $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      } else {
        $('.device02-option').hide();
      }
      if(insuranceOption_price>0) {
        $(".options-rows").show();
        $('.insurance-option').show();
        if(insuranceOption_price == "660") {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
        } else {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞<br>／プレミアム");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
        }
      } else {
        $('.insurance-option').hide();
      }

      if(deviceOption01_price == 0 && deviceOption02_price == 0 && insuranceOption_price == 0){
        $(".options-rows").hide();
      }
      // 内訳end

      // 月額基本料start
      $(".campaign-attention").html("※1：神コスパキャンペーン 第2弾<br>課金開始月を1ヶ月目として、" + discountMonthEarly + "ヶ月目までの月額基本料を" + planFee.toLocaleString() + "円、"
      + discountMonthLate + "ヶ月目までの月額基本料を" + planFee2.toLocaleString() + "円、"
      + (discountMonthLate + 1) + "ヶ月目以降の月額基本料を" + priceAfter.toLocaleString() + "円といたします。");
      //月額基本料End

      $(".after-text-monthly").html((discountMonthLate + 1) + "ヶ月目以降");
      $(".monthly-payment-after").html((priceAfter + deviceOptionFee + insuranceOption_price).toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      $(".breakdown-plan-after-fee").html(priceAfter.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      $(".campaign-period.after-payment").hide();
    }else if(plan_id == "326" || plan_id == "327" || plan_id == "328"){
      $(".summary-text-monthly-tax-fee").html("<span class='small-price-attention'>※</span>" + planFee.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      $("#campaign_row").show();
      $("#campaign_attention").show();
      $(".campaign-period").hide();
      $(".monthly-period").show();
      $(".monthly-period2").show();
      $(".options-rows").show();
      $(".summary-text-campaign-name").html("神コスパキャンペーン 第2弾");
      var discountMonthEarly = 3;
      var discountMonthLate = 24;
      $(".summary-text-monthly").html(discountMonthEarly + "ヶ月目まで");
      $(".summary-text-monthly2").html(discountMonthLate + "ヶ月目まで");
      // 内訳
      if(deviceOption01_price>0) {
        $(".options-rows").show();
        $('.device01-option').show();
        if (window.matchMedia("(min-width: 768px)").matches) {
          $('.plan-summary-table-row.insurance-option').css('border-top','1px solid #909090');
        }
        $(".breakdown-device01-option-title").html("端末あんしんオプション");
        $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      } else {
        $(".options-rows").show();
        $('.device01-option').hide();
        $('.plan-summary-table-row.insurance-option').css('border-top','none');
      }
      if(deviceOption02_price>0) {
        $('.device02-option').show();
        $(".breakdown-device02-option-title").html("丸ごと安心パック for ZEUS WiFi");
        $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      } else {
        $('.device02-option').hide();
      }
      if(insuranceOption_price>0) {
        $(".options-rows").show();
        $('.insurance-option').show();
        if(insuranceOption_price == "660") {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
        } else {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞<br>／プレミアム");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
        }
      } else {
        $('.insurance-option').hide();
      }
      if(deviceOption01_price == 0 && deviceOption02_price == 0 && insuranceOption_price == 0){
        $(".options-rows").hide();
      }

      // 内訳end
      $(".after-text-monthly").html((discountMonthLate + 1) + "ヶ月目以降");
      $(".campaign-attention").html("※1：神コスパキャンペーン 第2弾<br>課金開始月を1ヶ月目として、" + discountMonthEarly + "ヶ月目までの月額基本料を" + planFee.toLocaleString() + "円、" + (discountMonthLate + 1) + "ヶ月目以降の月額基本料を" + priceAfter.toLocaleString() + "円といたします。");
      $(".monthly-payment-after").html((priceAfter + deviceOptionFee + insuranceOption_price).toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
    }else if(insuranceOption === '14' || insuranceOption === '15') {

      var campaignMonth = 2;
      $(".summary-text-monthly-tax-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      $("#campaign_row").show();
      $(".campaign-period").show();
      $(".monthly-period").hide();
      $(".monthly-period2").hide();
      $(".options-rows").show();
      $(".summary-text-campaign-name").html("デジタルライフサポートスタートキャンペーン");
      $("#campaign_attention").hide();
      $(".monthly-campaign-after").show();
      $(".summary-text-campaign").html(campaignMonth + "ヶ月目まで");
      $(".after-text-campaign").html((campaignMonth + 1) + "ヶ月目以降");
      $(".monthly-campaign-after").html(monthlyFee.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      $(".breakdown-plan-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      $(".breakdown-plan-fee2").html(planFee2.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      // 内訳
      if(deviceOption01_price>0) {
        $(".options-rows").show();
        $('.device01-option').show();
        if (window.matchMedia("(min-width: 768px)").matches) {
          $('.plan-summary-table-row.insurance-option').css('border-top','1px solid #909090');
        }
        $(".breakdown-device01-option-title").html("端末あんしんオプション");
        $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      } else {
        $('.device01-option').hide();
        $('.plan-summary-table-row.insurance-option').css('border-top','none');
      }
      if(deviceOption02_price>0) {
        $(".options-rows").show();
        $('.device02-option').show();
        $(".breakdown-device02-option-title").html("丸ごと安心パック for ZEUS WiFi");
        $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      } else {
        $('.device02-option').hide();
      }
      if(insuranceOption_price>0) {
        $(".options-rows").show();
        $('.insurance-option').show();
        if(insuranceOption_price == "660") {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
        } else {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞<br>／プレミアム");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
        }
      }
      if(deviceOption01_price == 0 && deviceOption02_price == 0 && insuranceOption_price == 0){
        $(".options-rows").hide();
      }

      // 内訳end
    }else{
      $(".summary-text-monthly-tax-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      $("#campaign_row").hide();
      $("#campaign_attention").hide();
      $(".monthly-period").show();
      $(".monthly-period2").show();
      $(".options-rows").show();
      $('.insurance-option').hide();
      $(".after-payment").hide();
      $(".monthly-period2.open").hide();
      $(".monthly-period2.breakdown").hide();
      $(".breakdown-plan-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");

      if(deviceOption01_price>0) {
        $(".options-rows").show();
        $('.device01-option').show();
        $('.plan-summary-table-row.insurance-option').css('border-top','1px solid #909090');
        $(".breakdown-device01-option-title").html("端末あんしんオプション");
        $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      } else {
        $('.device01-option').hide();
        $('.plan-summary-table-row.insurance-option').css('border-top','none');
      }
      if(deviceOption02_price>0) {
        $(".options-rows").show();
        $('.device02-option').show();
        $(".breakdown-device02-option-title").html("丸ごと安心パック for ZEUS WiFi");
        $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      } else {
        $('.device02-option').hide();
      }
      // $(".breakdown-device01-option-title").html("端末あんしんオプション");
      // $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      // $(".breakdown-device02-option-title").html("丸ごと安心パック for ZEUS WiFi");
      // $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      if(deviceOption01_price == 0 && deviceOption02_price == 0){
        $(".options-rows").hide();
      }
    }
  }else{
    $(".summary-text-monthly-tax-fee").html(planFee + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
    $(".summary-text-monthly-tax-total").html(monthlyFee.toLocaleString()  + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
    $(".summary-text-monthly-tax-total2").html(monthlyFee.toLocaleString()  + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
    if(deviceOptionFee>0){
      $(".summary-text-monthly-tax-total").html(insuranceCampaignFee.toLocaleString()  + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
      $(".summary-text-monthly-tax-total2").html(insuranceCampaignFee.toLocaleString()  + "<span class='plan-tax'>円</span><span class='small-price-attention'></span>");
    }
    $('.insurance-option').hide();
      if(deviceOption01_price == 0 && deviceOption02_price == 0 && insuranceOption_price == 0){
        $(".options-rows").hide();
    }
  }
}

//鹿児島レブナイズ特別キャンペーン 20230209 start

var gSummaryRebnisePrices = {
  plan_id: {
    "371": {
      "capacity": 30,
      "price": 980,
      "price2": 2361,
      "cancel_fee":2508,
      "price_after": 2508,
    },
    "372": {
      "capacity": 50,
      "price": 1480,
      "price2": 3106,
      "cancel_fee":3278,
      "price_after": 3278,
    },
    "373": {
      "capacity": 100,
      "price": 1980,
      "price2": 3212,
      "cancel_fee":3828,
      "price_after": 3828,
    },
    "374": {
      "capacity": 30,
      "price": 3168,
      "price2": 3168,
      "cancel_fee":0,
      "price_after": 3168,
    },
    "375": {
      "capacity": 50,
      "price": 3828,
      "price2": 3828,
      "cancel_fee":0,
      "price_after": 3828,
    },
    "376": {
      "capacity": 100,
      "price": 4708,
      "price2": 4708,
      "cancel_fee":0,
      "price_after": 4708,
    },
  },
  deviceOption: {
    'true': 580,
    'false': 0,
  },
  deviceOption01: {
    "16": {
      "price": 580,
    },
    "false": {
      "price": 0,
    },
  },
  deviceOption02: {
    "12": {
      "price": 999,
    },
    "false": {
      "price": 0,
    },
  },
  insuranceOption: {
    "14": {
      "price": 660,
    },
    "15": {
      "price": 990,
    },
    "-1": {
      "price": 0,
    },
  }
}


function updateRebniseSummary(){

  var isOptionsPage = location.pathname.indexOf("/entry/select") === 0;
  if(!isOptionsPage){
    // Not options page
    return;
  }
  var params = new URL(window.location.href).searchParams;
  if(!(params.get('utm_source') === 'rebnise') && !(params.get('utm_medium') === 'pr')){//バック実装後にコメント解除
    return;
  }

  // gSelectedCapacity is given in entry/options in script tag
  var capacity = gSelectedCapacity;
  var plan_id = $("input[name=plan_id]:checked").val();
  if (plan_id === undefined) {
    plan_id = $("input:hidden[name=plan_id]").val();
  }

  var deviceOption01 = $("input[id=option1]:checked").val();
  if (deviceOption01 === undefined) {
    deviceOption01 = 'false';
  }

  var deviceOption02 = $("input[id=option2]:checked").val();
  if (deviceOption02 === undefined) {
    deviceOption02 = 'false';
  }
  var deviceOptionKey01 = deviceOption01 || "false";
  var deviceOptionKey02 = deviceOption02 || "false";
  var deviceOption01_price = gSummaryRebnisePrices.deviceOption01[deviceOptionKey01].price;
  var deviceOption02_price = gSummaryRebnisePrices.deviceOption02[deviceOptionKey02].price;

  var insuranceOption = $("input[name=option_id_insurance]:checked").val();
  if (insuranceOption === undefined) {
    insuranceOption = 'false';
  }
  var insuranceOptionKey = insuranceOption || "false";
  var insuranceOption_price = gSummaryRebnisePrices.insuranceOption[insuranceOptionKey].price;

  var initialFee = gInitialFee;
  var cancelFee = gCancelFee;

  //
  // Text
  // ///

  // capacity
  // $(".summary-text-capacity").text(capacity);

  // tie
  if(gSummaryRebnisePrices.plan_id[plan_id] && gSummaryRebnisePrices.plan_id[plan_id].cancel_fee > 0){
    $(".summary-text-tie-plan-name").html("鹿児島レブナイズ期間限定<br>/スタンダードプラン");
    $(".summary-text-tie-period").text("(契約期間2年)");
    $(".summary-text-capacity").html("<br>" + gSummaryRebnisePrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryRebnisePrices.plan_id[plan_id].cancel_fee;
  }else if (gSummaryRebnisePrices.plan_id[plan_id] && gSummaryRebnisePrices.plan_id[plan_id].cancel_fee === 0){
    $(".summary-text-tie-plan-name").html("鹿児島レブナイズ期間限定<br>/フリープラン");
    $(".summary-text-tie-period").text("(契約期間なし)");
    $(".summary-text-capacity").html("<br>" + gSummaryRebnisePrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryRebnisePrices.plan_id[plan_id].cancel_fee;
  }else{
    $(".summary-text-tie-title").text("未選択");
    $(".summary-text-tie-period").text("未選択");
    cancelFee = 0;
  }

    // device option01
  if(deviceOption01 === '16'){
    $(".summary-text-device-option-title01").html("つける");
    $(".summary-text-device-option-price01").html(deviceOption01_price + "<span class='plan-tax'>円</span>");
  }else{
    $(".summary-text-device-option-title01").text("つけない");
    $(".summary-text-device-option-price01").html("0" + "<span class='plan-tax'>円</span>");
  }

  // device option02
  if(deviceOption02 === '12'){
    $(".summary-text-device-option-title02").html("つける");
    $(".summary-text-device-option-price02").html(deviceOption02_price + "<span class='plan-tax'>円</span>");
  }else{
    $(".summary-text-device-option-title02").text("つけない");
    $(".summary-text-device-option-price02").html("0" + "<span class='plan-tax'>円</span>");
  }

  // insurance option
  if(insuranceOption === '14'){
    $(".breakdown-insurance-option-title").closest('div.breakdown-list').show();
    $(".summary-text-insurance-option-title").html("つける");
    $(".summary-text-insurance-option-premium").html("");
    $(".summary-text-insurance-option-price").html("<span class='small-price-attention'>※</span>0<span class='plan-tax'>円</span>");
    $(".insurance-option-campaign").html("※デジタルライフサポートスタートキャンペーンについて：<br>課金開始月を1ヶ月目として、2ヶ月目までのデジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞利用料を無料、3ヶ月目以降を" + insuranceOption_price + "円といたします。");
  }else if(insuranceOption === '15'){
    $(".breakdown-insurance-option-title").closest('div.breakdown-list').show();
    $(".summary-text-insurance-option-title").html("つける");
    $(".summary-text-insurance-option-premium").html("/プレミアム");
    $(".summary-text-insurance-option-price").html("<span class='small-price-attention'>※</span>0<span class='plan-tax'>円</span>");
    $(".insurance-option-campaign").html("※デジタルライフサポートスタートキャンペーンについて：<br>課金開始月を1ヶ月目として、2ヶ月目までのデジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞／プレミアム利用料を無料、3ヶ月目以降を" + insuranceOption_price + "円といたします。");
  }else if(insuranceOption === '-1'){
    $(".summary-text-insurance-option-title").html("つけない");
    $(".summary-text-insurance-option-premium").html("");
    $(".summary-text-insurance-option-price").html("0" + "<span class='plan-tax'>円</span>");
    $(".insurance-option-campaign").html("");
    $(".breakdown-insurance-option-title").closest('div.breakdown-list').hide();
  }

  // ///
  // price
  // ///

  // initial and cancel
  $(".summary-text-initial-fee").html(initialFee.toLocaleString() + "<span class='plan-tax'>円</span>");
  $("#cancel_fee_attention").hide();
  if(cancelFee > 0){
    $(".summary-text-cancel-fee").html("<span class='small-price-attention'>※</span>");
    $(".summary-text-cancel-tax-fee").html(cancelFee.toLocaleString() + "<span class='plan-tax'>円</span>");
    $("#cancel_fee_attention").show();
  }else{
    $(".summary-text-cancel-fee").html("");
    $(".summary-text-cancel-tax-fee").html("0<span class='plan-tax'>円</span>");
  }

  // monthly

  let planFee;  //3ヶ月目までの割引後料金
  let planFee2; //24ヶ月目までの割引後料金

  if (gSummaryRebnisePrices.plan_id[plan_id]) {
    planFee = gSummaryRebnisePrices.plan_id[plan_id].price;
    planFee2 = gSummaryRebnisePrices.plan_id[plan_id].price2;
    if (gSummaryRebnisePrices.plan_id[plan_id].price_after) {
      priceAfter = gSummaryRebnisePrices.plan_id[plan_id].price_after;
    }
  } else {
    planFee = 0;
  }

  var deviceOptionFee =  deviceOption01_price + deviceOption02_price;
  var monthlyFee = deviceOptionFee + insuranceOption_price;
  var monthlyFee2 = planFee2 + deviceOptionFee + insuranceOption_price;
  var campaignFee = deviceOptionFee;
  var campaignFee2 = planFee2 + deviceOptionFee;
  var insuranceCampaignFee = planFee + deviceOptionFee;
  var insuranceCampaignFee2 = planFee2 + deviceOptionFee;

  $("#campaign_row").hide();
  $("#campaign_attention").hide();
  $(".campaign-period").hide();
  $(".summary-text-monthly").text("");
  $(".monthly-payment-after").text("");
  $(".monthly-campaign-after").hide();
  $(".monthly-campaign-after2").hide();
  $(".monthly-period.breakdown").hide();
  $(".monthly-period2.open").hide();
  $(".monthly-period2.breakdown").hide();
  $(".after-payment").hide();

  if (gSummaryRebnisePrices.plan_id[plan_id]) {
    $(".summary-text-monthly-tax-total").html(monthlyFee.toLocaleString() + "<span class='plan-tax'>円</span>");
    $(".summary-text-monthly-tax-total2").html(monthlyFee2.toLocaleString() + "<span class='plan-tax'>円</span>");
    $(".summary-text-campaign-tax-total").html(campaignFee.toLocaleString() + "<span class='plan-tax'>円</span>");
    if(plan_id == "371" || plan_id == "372" || plan_id == "373"){
      $(".summary-text-monthly-tax-fee").html("<span class='small-price-attention'>※</span>0<span class='plan-tax'>円</span>");
      $("#campaign_row").show();
      $("#campaign_attention").show();
      if((insuranceOption === '14' || insuranceOption === '15')){
        $(".campaign-period").show();
      }
      $(".monthly-period").show();
      $(".monthly-period2").show();
      $(".monthly-campaign-after").hide();
      $(".monthly-campaign-after2").hide();
      if((insuranceOption === '14' || insuranceOption === '15')){
        $(".summary-text-campaign-name").html("鹿児島レブナイズ特別キャンペーン<br>デジタルライフサポートスタートキャンペーン");
      }else{
        $(".summary-text-campaign-name").html("鹿児島レブナイズ特別キャンペーン<br>");
      }
      var campaignMonth = 2;
      var discountMonthEarly = 3;
      var discountMonthLate = 24;
      $(".summary-text-campaign").html(campaignMonth + "ヶ月目まで");
      $(".breakdown-plan-fee").html("0<span class='plan-tax'>円</span>");
      $(".breakdown-plan-fee2").html(planFee2.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".breakdown-nocampaign-plan-fee").html(planFee2.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".summary-text-monthly").html(discountMonthEarly + "ヶ月目まで");
      $(".summary-text-monthly2").html(discountMonthLate + "ヶ月目まで");
      $(".monthly-period.breakdown").show();
      $(".monthly-period2.breakdown").show();
      // 内訳
      if(deviceOption01_price>0) {
        $(".breakdown-device01-option").closest('div.breakdown-list').show();
        $(".breakdown-device01-option-title").html("端末あんしんオプション");
        $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device01-option-title").closest('div.breakdown-list').hide();
      }
      if(deviceOption02_price>0) {
        $(".breakdown-device02-option").closest('div.breakdown-list').show();
        $(".breakdown-device02-option-title").html("丸ごと安心パック <br class='sp'>for ZEUS WiFi");
        $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device02-option-title").closest('div.breakdown-list').hide();
      }
      if(insuranceOption_price>0) {
        $(".breakdown-insurance-option").closest('div.breakdown-list').show();
        if(insuranceOption_price == "660") {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span>");
        } else {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞<br>／プレミアム");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span>");
        }
      } else {
        $(".breakdown-insurance-option-title").closest('div.breakdown-list').hide();
      }
      // 内訳end
      // 月額基本料start

      $(".campaign-attention-rebnise").html("※鹿児島レブナイズ特別キャンペーンについて：<br>課金開始月を1ヶ月目として、" + discountMonthEarly + "ヶ月目までの月額基本料を無料、"
      + discountMonthLate + "ヶ月目までの月額基本料を" + planFee2.toLocaleString() + "円、"
      + (discountMonthLate + 1) + "ヶ月目以降の月額基本料を" + priceAfter.toLocaleString() + "円といたします。");

      //月額基本料End

      $(".after-text-monthly").html((discountMonthLate + 1) + "ヶ月目以降");
      $(".monthly-payment-after").html((priceAfter + deviceOptionFee + insuranceOption_price).toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".breakdown-plan-after-fee").html(priceAfter.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".campaign-period.after-payment").hide();
    }else if(plan_id == "374" || plan_id == "375" || plan_id == "376"){
      $(".summary-text-campaign").html(campaignMonth + "ヶ月目まで");
      $(".summary-text-monthly-tax-fee").html("<span class='small-price-attention'>※</span>0<span class='plan-tax'>円</span>");
      $(".breakdown-plan-fee").html("0<span class='plan-tax'>円</span>");
      $(".campaign-period.after-payment").show();
      $(".monthly-period.breakdown").show();
      $(".monthly-period2").show();
      $(".monthly-period.after-payment.breakdown").hide();
      $("monthly-campaign-after").html(((monthlyFee).toLocaleString()) + "<span class='plan-tax'>円</span>");
      $("#campaign_row").show();
      if((insuranceOption === '14' || insuranceOption === '15')){
        $(".summary-text-campaign-name").html("鹿児島レブナイズ特別キャンペーン<br>デジタルライフサポートスタートキャンペーン");
      }else{
        $(".summary-text-campaign-name").html("鹿児島レブナイズ特別キャンペーン<br>");
      }
      var discountMonthEarly = 2;
      var discountMonthLate = 3;
      $(".campaign-attention-rebnise").html("※鹿児島レブナイズ特別キャンペーンについて：<br>課金開始月を1ヶ月目として、" + discountMonthLate + "ヶ月目までの月額基本料を無料、"
      + (discountMonthLate + 1) + "ヶ月目以降の月額基本料を" + priceAfter.toLocaleString() + "円といたします。");
      $(".campaign-attention-rebnise").parent().show();
      $(".after-text-campaign").html(discountMonthEarly + "ヶ月目まで");
      $(".summary-text-monthly").html(discountMonthLate + "ヶ月目まで");
      $(".summary-text-monthly2").html(discountMonthLate + 1 + "ヶ月目以降");
      if(insuranceOption === '-1'){
        $(".campaign-period.after-payment").hide();
      }
      // 内訳
      if(deviceOption01_price>0) {
        $(".breakdown-device01-option").closest('div.breakdown-list').show();
        $(".breakdown-device01-option-title").html("端末あんしんオプション");
        $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device01-option-title").closest('div.breakdown-list').hide();
      }
      if(deviceOption02_price>0) {
        $(".breakdown-device02-option").closest('div.breakdown-list').show();
        $(".breakdown-device02-option-title").html("丸ごと安心パック <br class='sp'>for ZEUS WiFi");
        $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device02-option-title").closest('div.breakdown-list').hide();
      }
      if(insuranceOption_price>0) {
        $(".breakdown-insurance-option").closest('div.breakdown-list').show();
        if(insuranceOption_price == "660") {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span>");
        } else {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞<br>／プレミアム");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span>");
        }
      } else {
        $(".breakdown-insurance-option-title").closest('div.breakdown-list').hide();
      }
      // 内訳end

      $(".monthly-campaign-after").show();
      $(".monthly-campaign-after").html(monthlyFee.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".breakdown-plan-fee2").html(planFee2.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".breakdown-plan-fee").html("0<span class='plan-tax'>円</span>");
      $(".after-text-monthly").html((discountMonthLate + 1) + "ヶ月目以降");
      $(".campaign-attention").html("");
      $(".monthly-payment-after").html((priceAfter + deviceOptionFee + insuranceOption_price).toLocaleString() + "<span class='plan-tax'>円</span>");
    }else if(insuranceOption === '14' || insuranceOption === '15') {
      var campaignMonth = 2;
      $(".summary-text-monthly-tax-fee").html("<span class='small-price-attention'>※</span>0<span class='plan-tax'>円</span>");
      $("#campaign_row").show();
      $(".campaign-period").show();
      $(".monthly-period").hide();
      $(".monthly-period2").hide();
      $(".summary-text-campaign-name").html("鹿児島レブナイズ特別キャンペーン<br>デジタルライフサポートスタートキャンペーン");
      $("#campaign_attention").hide();
      $(".monthly-campaign-after").show();
      $(".monthly-campaign-after2").show();
      $(".summary-text-campaign").html(campaignMonth + "ヶ月目まで");
      $(".after-text-campaign").html((campaignMonth + 1) + "ヶ月目まで");
      $(".after-text-campaign2").html((campaignMonth + 2) + "ヶ月目以降");
      $(".monthly-campaign-after").html(monthlyFee.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".monthly-campaign-after2").html(monthlyFee2.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".breakdown-plan-fee").html("0<span class='plan-tax'>円</span>");
      $(".breakdown-plan-fee2").html(planFee2.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".breakdown-nocampaign-plan-fee").html(planFee2.toLocaleString() + "<span class='plan-tax'>円</span>");
      // 内訳
      if(deviceOption01_price>0) {
        $(".breakdown-device01-option").closest('div.breakdown-list').show();
        $(".breakdown-device01-option-title").html("端末あんしんオプション");
        $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device01-option-title").closest('div.breakdown-list').hide();
      }
      if(deviceOption02_price>0) {
        $(".breakdown-device02-option").closest('div.breakdown-list').show();
        $(".breakdown-device02-option-title").html("丸ごと安心パック <br class='sp'>for ZEUS WiFi");
        $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device02-option-title").closest('div.breakdown-list').hide();
      }
      if(insuranceOption_price>0) {
        $(".breakdown-insurance-option").closest('div.breakdown-list').show();
        if(insuranceOption_price == "660") {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span>");
        } else {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞<br>／プレミアム");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span>");
        }
      } else {
        $(".breakdown-insurance-option-title").closest('div.breakdown-list').hide();
      }
      // 内訳end
    }else{
      $(".summary-text-monthly-tax-fee").html("<span class='small-price-attention'>※</span>0<span class='plan-tax'>円</span>");
      $("#campaign_row").hide();
      $("#campaign_attention").hide();
      $(".monthly-period").show();
      $(".monthly-period2").show();
      $(".after-payment").hide();
      $(".monthly-period2.open").hide();
      $(".monthly-period2.breakdown").hide();
      $(".breakdown-plan-fee").html("0<span class='plan-tax'>円</span>");
      $(".breakdown-nocampaign-plan-fee").html(planFee2.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".breakdown-device01-option-title").html("端末あんしんオプション");
      $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span>");
      $(".breakdown-device02-option-title").html("丸ごと安心パック <br class='sp'>for ZEUS WiFi");
      $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span>");
    }
  }else{
    $(".summary-text-monthly-tax-fee").html("<span class='small-price-attention'>※</span>0<span class='plan-tax'>円</span>");
    $(".summary-text-monthly-tax-total").html(monthlyFee.toLocaleString()  + "<span class='plan-tax'>円</span>");
    $(".summary-text-monthly-tax-total2").html(monthlyFee.toLocaleString()  + "<span class='plan-tax'>円</span>");
    if(deviceOptionFee>0){
        $(".summary-text-monthly-tax-total").html(insuranceCampaignFee.toLocaleString()  + "<span class='plan-tax'>円</span>");
        $(".summary-text-monthly-tax-total2").html(insuranceCampaignFee.toLocaleString()  + "<span class='plan-tax'>円</span>");
    }
  }
  if(plan_id == "374" || plan_id == "375" || plan_id == "376"){
    if(deviceOption01 == '16' && deviceOption02 == '12'){
      $(".monthly-campaign-after").html("1,579<span class='plan-tax'>円</span>");
    }
    else if(deviceOption01 == '16'){
      $(".monthly-campaign-after").html("580<span class='plan-tax'>円</span>");
    }
    else if(deviceOption02 == '12'){
      $(".monthly-campaign-after").html("999<span class='plan-tax'>円</span>");
    }
    else{
      $(".monthly-campaign-after").html("0<span class='plan-tax'>円</span>");
    }

  }
}

//鹿児島レブナイズ特別キャンペーン 20230209 end

// 内訳を開く
$(function(){
  //クリックで動く
  // $('.fee-button.open').click(function(){
  //   $(this).toggleClass('active');
  //   $(this).next('.breakdown').children('.summary-table-column-right').slideToggle();
  // });
  $('#monthly-pay-toggle').click(function(){
    $('#toggle-open').slideToggle();
    $(this).toggleClass("active");
  });

  $('.campaign-period.open').click(function(){
    $(this).toggleClass('active');
    $(this).next('.campaign-period.breakdown').children('.summary-table-column-right').slideToggle();
  });
  $('.monthly-period.open').click(function(){
    $(this).toggleClass('active');
    $(this).next('.monthly-period.breakdown').children('.summary-table-column-right').slideToggle();
  });
  $('.monthly-period2.open').click(function(){
    $(this).toggleClass('active');
    $(this).next('.monthly-period2.breakdown').children('.summary-table-column-right').slideToggle();
  });
  // $('#monthly-pay-toggle,.fee-button.open').click();

});

function updateTelephoneSummary(){
  var isOptionsPage = location.pathname.indexOf("/telephone") === 0;
  if(!isOptionsPage){
    // Not options page
    return;
  }
  
  // gSelectedCapacity is given in entry/options in script tag
  var capacity = gSelectedCapacity;
  var plan_id = $("input[name=plan_id]:checked").val();
  if (plan_id === undefined) {
    plan_id = $("input:hidden[name=plan_id]").val();
  }

  var deviceOption01 = $("input[id=option1]:checked").val();
  if (deviceOption01 === undefined) {
    deviceOption01 = 'false';
  }

  var deviceOption02 = $("input[id=option2]:checked").val();
  if (deviceOption02 === undefined) {
    deviceOption02 = 'false';
  }
  var deviceOptionKey01 = deviceOption01 || "false";
  var deviceOptionKey02 = deviceOption02 || "false";
  var deviceOption01_price = gSummaryPrices.deviceOption01[deviceOptionKey01].price;
  var deviceOption02_price = gSummaryPrices.deviceOption02[deviceOptionKey02].price;

  var insuranceOption = $("input[name=option_id_insurance]:checked").val();
  if (insuranceOption === undefined) {
    insuranceOption = 'false';
  }
  var insuranceOptionKey = insuranceOption || "false";
  var insuranceOption_price = gSummaryPrices.insuranceOption[insuranceOptionKey].price;
  var initialFee = gInitialFee;
  var cancelFee = gCancelFee;

  // tie
  if(gSummaryPrices.plan_id[plan_id] && gSummaryPrices.plan_id[plan_id].cancel_fee > 0){
    $(".summary-text-tie-plan-name").text("スタンダードプラン");
    $(".summary-text-tie-period").text("(契約期間2年)");
    $(".summary-text-capacity").html("<br>" + gSummaryPrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryPrices.plan_id[plan_id].cancel_fee;
  }else if (gSummaryPrices.plan_id[plan_id] && gSummaryPrices.plan_id[plan_id].cancel_fee === 0){
    $(".summary-text-tie-plan-name").text("フリープラン");
    $(".summary-text-tie-period").text("(契約期間なし)");
    $(".summary-text-capacity").html("<br>" + gSummaryPrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryPrices.plan_id[plan_id].cancel_fee;
  }else{
    $(".summary-text-tie-title").text("未選択");
    $(".summary-text-tie-period").text("未選択");
    cancelFee = 0;
  }

  // device option01
  if(deviceOption01 === '16'){
    $(".summary-text-device-option-title01").html("つける");
    $(".summary-text-device-option-price01").html(deviceOption01_price + "<span class='plan-tax'>円</span>");
  }else{
    $(".summary-text-device-option-title01").text("つけない");
    $(".summary-text-device-option-price01").html("0" + "<span class='plan-tax'>円</span>");
  }

  // device option02
  if(deviceOption02 === '12'){
    $(".summary-text-device-option-title02").html("つける");
    $(".summary-text-device-option-price02").html(deviceOption02_price + "<span class='plan-tax'>円</span>");
  }else{
    $(".summary-text-device-option-title02").text("つけない");
    $(".summary-text-device-option-price02").html("0" + "<span class='plan-tax'>円</span>");
  }

  // insurance option
  if(insuranceOption === '14'){
    $(".summary-text-insurance-option-title").html("つける");
    $(".summary-text-insurance-option-premium").html("");
    $(".summary-text-insurance-option-price").html("<span class='small-price-attention'>※</span>0<span class='plan-tax'>円</span>");
    $(".insurance-option-campaign").html("※デジタルライフサポートスタートキャンペーンについて：<br>課金開始月を1ヶ月目として、2ヶ月目までのデジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞利用料を無料、3ヶ月目以降を" + insuranceOption_price + "円といたします。");
  }else if(insuranceOption === '15'){
    $(".breakdown-insurance-option-title").closest('div.breakdown-list').show();
    $(".summary-text-insurance-option-title").html("つける");
    $(".summary-text-insurance-option-premium").html("/プレミアム");
    $(".summary-text-insurance-option-price").html("<span class='small-price-attention'>※</span>0<span class='plan-tax'>円</span>");
    $(".insurance-option-campaign").html("※デジタルライフサポートスタートキャンペーンについて：<br>課金開始月を1ヶ月目として、2ヶ月目までのデジタルライフサポート＜デジタル機器 故障・盗難総合サポート＞／プレミアム利用料を無料、3ヶ月目以降を" + insuranceOption_price + "円といたします。");
  }else if(insuranceOption === '-1'){
    $(".summary-text-insurance-option-title").html("つけない");
    $(".summary-text-insurance-option-premium").html("");
    $(".summary-text-insurance-option-price").html("0" + "<span class='plan-tax'>円</span>");
    $(".insurance-option-campaign").html("");
    $(".breakdown-insurance-option-title").closest('div.breakdown-list').hide();
  }

  // ///
  // price
  // ///

  // initial and cancel
  $(".summary-text-initial-fee").html(initialFee.toLocaleString() + "<span class='plan-tax'>円</span>");
  $("#cancel_fee_attention").hide();
  if(cancelFee > 0){
    $(".summary-text-cancel-fee").html("<span class='small-price-attention'>※</span>");
    $(".summary-text-cancel-tax-fee").html(cancelFee.toLocaleString() + "<span class='plan-tax'>円</span>");
    $("#cancel_fee_attention").show();
  }else{
    $(".summary-text-cancel-fee").html("");
    $(".summary-text-cancel-tax-fee").html("0<span class='plan-tax'>円</span>");
  }

  // monthly

  let planFee;  //3ヶ月目までの割引後料金
  let planFee2; //24ヶ月目までの割引後料金

  if (gSummaryPrices.plan_id[plan_id]) {
    planFee = gSummaryPrices.plan_id[plan_id].price;
    planFee2 = gSummaryPrices.plan_id[plan_id].price2;
    if (gSummaryPrices.plan_id[plan_id].price_after) {
      priceAfter = gSummaryPrices.plan_id[plan_id].price_after;
    }
  } else {
    planFee = 0;
  }

  var deviceOptionFee =  deviceOption01_price + deviceOption02_price;
  var monthlyFee = planFee + deviceOptionFee + insuranceOption_price;
  var monthlyFee2 = planFee2 + deviceOptionFee + insuranceOption_price;
  var campaignFee = planFee + deviceOptionFee;
  var campaignFee2 = planFee2 + deviceOptionFee;
  var insuranceCampaignFee = planFee + deviceOptionFee;
  var insuranceCampaignFee2 = planFee2 + deviceOptionFee;

  $("#campaign_row").hide();
  $("#campaign_attention").hide();
  $(".campaign-period").hide();
  $(".summary-text-monthly").text("");
  $(".monthly-payment-after").text("");
  $(".monthly-campaign-after").hide();
  $(".monthly-period.breakdown").hide();
  $(".monthly-period2.open").hide();
  $(".monthly-period2.breakdown").hide();
  $(".after-payment").hide();

  if (gSummaryPrices.plan_id[plan_id]) {
    $(".summary-text-monthly-tax-total").html(monthlyFee.toLocaleString() + "<span class='plan-tax'>円</span>");
    $(".summary-text-monthly-tax-total2").html(monthlyFee2.toLocaleString() + "<span class='plan-tax'>円</span>");
    $(".summary-text-campaign-tax-total").html(campaignFee.toLocaleString() + "<span class='plan-tax'>円</span>");
    if((plan_id == "326" || plan_id == "327" || plan_id == "328" || plan_id == "363" || plan_id == "364" || plan_id == "365")){
      $(".summary-text-monthly-tax-fee").html("<span class='small-price-attention'>※</span>" + planFee.toLocaleString() + "<span class='plan-tax'>円</span>");
      $("#campaign_row").show();
      $("#campaign_attention").show();
      if((insuranceOption === '14' || insuranceOption === '15')){
        $(".campaign-period").show();
      }
      $(".monthly-period").show();
      $(".monthly-period2").show();
      $(".monthly-campaign-after").hide();
      if((insuranceOption === '14' || insuranceOption === '15')){
        $(".summary-text-campaign-name").html("神コスパキャンペーン 第2弾<br>デジタルライフサポートスタートキャンペーン");
      }else{
        $(".summary-text-campaign-name").html("神コスパキャンペーン 第2弾");
      }
      var campaignMonth = 2;
      var discountMonthEarly = 3;
      var discountMonthLate = 24;
      $(".summary-text-campaign").html(campaignMonth + "ヶ月目まで");
      $(".breakdown-plan-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".breakdown-plan-fee2").html(planFee2.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".summary-text-monthly").html(discountMonthEarly + "ヶ月目まで");
      $(".summary-text-monthly2").html(discountMonthLate + "ヶ月目まで");
      $(".monthly-period.breakdown").show();
      $(".monthly-period2.breakdown").show();
      // 内訳
      if(deviceOption01_price>0) {
        $(".breakdown-device01-option").closest('div.breakdown-list').show();
        $(".breakdown-device01-option-title").html("端末あんしんオプション");
        $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device01-option-title").closest('div.breakdown-list').hide();
      }
      if(deviceOption02_price>0) {
        $(".breakdown-device02-option").closest('div.breakdown-list').show();
        $(".breakdown-device02-option-title").html("丸ごと安心パック <br class='sp'>for ZEUS WiFi");
        $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device02-option-title").closest('div.breakdown-list').hide();
      }
      if(insuranceOption_price>0) {
        $(".breakdown-insurance-option").closest('div.breakdown-list').show();
        if(insuranceOption_price == "660") {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span>");
        } else {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞<br>／プレミアム");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span>");
        }
      } else {
        $(".breakdown-insurance-option-title").closest('div.breakdown-list').hide();
      }
      // 内訳end

      // 月額基本料start
      $(".campaign-attention").html("※神コスパキャンペーン 第2弾について：<br>課金開始月を1ヶ月目として、" + discountMonthEarly + "ヶ月目までの月額基本料を" + planFee.toLocaleString() + "円、"
      + discountMonthLate + "ヶ月目までの月額基本料を" + planFee2.toLocaleString() + "円、"
      + (discountMonthLate + 1) + "ヶ月目以降の月額基本料を" + priceAfter.toLocaleString() + "円といたします。");
      //月額基本料End

      $(".after-text-monthly").html((discountMonthLate + 1) + "ヶ月目以降");
      $(".monthly-payment-after").html((priceAfter + deviceOptionFee + insuranceOption_price).toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".breakdown-plan-after-fee").html(priceAfter.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".campaign-period.after-payment").hide();
    }else if(plan_id == "326" || plan_id == "327" || plan_id == "328"){
      $(".summary-text-monthly-tax-fee").html("<span class='small-price-attention'>※</span>" + planFee.toLocaleString() + "<span class='plan-tax'>円</span>");
      $("#campaign_row").show();
      $("#campaign_attention").show();
      $(".campaign-period").hide();
      $(".monthly-period").show();
      $(".monthly-period2").show();
      $(".summary-text-campaign-name").html("神コスパキャンペーン 第2弾");
      var discountMonthEarly = 3;
      var discountMonthLate = 24;
      $(".summary-text-monthly").html(discountMonthEarly + "ヶ月目まで");
      $(".summary-text-monthly2").html(discountMonthLate + "ヶ月目まで");
      // 内訳
      if(deviceOption01_price>0) {
        $(".breakdown-device01-option").closest('div.breakdown-list').show();
        $(".breakdown-device01-option-title").html("端末あんしんオプション");
        $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device01-option-title").closest('div.breakdown-list').hide();
      }
      if(deviceOption02_price>0) {
        $(".breakdown-device02-option").closest('div.breakdown-list').show();
        $(".breakdown-device02-option-title").html("丸ごと安心パック <br class='sp'>for ZEUS WiFi");
        $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device02-option-title").closest('div.breakdown-list').hide();
      }
      if(insuranceOption_price>0) {
        $(".breakdown-insurance-option").closest('div.breakdown-list').show();
        if(insuranceOption_price == "660") {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span>");
        } else {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞<br>／プレミアム");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span>");
        }
      } else {
        $(".breakdown-insurance-option-title").closest('div.breakdown-list').hide();
      }
      // 内訳end
      $(".after-text-monthly").html((discountMonthLate + 1) + "ヶ月目以降");
      $(".campaign-attention").html("※神コスパキャンペーン 第2弾について：<br>課金開始月を1ヶ月目として、" + discountMonthEarly + "ヶ月目までの月額基本料を" + planFee.toLocaleString() + "円、" + (discountMonthLate + 1) + "ヶ月目以降の月額基本料を" + priceAfter.toLocaleString() + "円といたします。");
      $(".monthly-payment-after").html((priceAfter + deviceOptionFee + insuranceOption_price).toLocaleString() + "<span class='plan-tax'>円</span>");
    }else if(insuranceOption === '14' || insuranceOption === '15') {
      var campaignMonth = 2;
      $(".summary-text-monthly-tax-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span>");
      $("#campaign_row").show();
      $(".campaign-period").show();
      $(".monthly-period").hide();
      $(".monthly-period2").hide();
      $(".summary-text-campaign-name").html("デジタルライフサポートスタートキャンペーン");
      $("#campaign_attention").hide();
      $(".monthly-campaign-after").show();
      $(".summary-text-campaign").html(campaignMonth + "ヶ月目まで");
      $(".after-text-campaign").html((campaignMonth + 1) + "ヶ月目以降");
      $(".monthly-campaign-after").html(monthlyFee.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".breakdown-plan-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".breakdown-plan-fee2").html(planFee2.toLocaleString() + "<span class='plan-tax'>円</span>");
      // 内訳
      if(deviceOption01_price>0) {
        $(".breakdown-device01-option").closest('div.breakdown-list').show();
        $(".breakdown-device01-option-title").html("端末あんしんオプション");
        $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device01-option-title").closest('div.breakdown-list').hide();
      }
      if(deviceOption02_price>0) {
        $(".breakdown-device02-option").closest('div.breakdown-list').show();
        $(".breakdown-device02-option-title").html("丸ごと安心パック <br class='sp'>for ZEUS WiFi");
        $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device02-option-title").closest('div.breakdown-list').hide();
      }
      if(insuranceOption_price>0) {
        $(".breakdown-insurance-option").closest('div.breakdown-list').show();
        if(insuranceOption_price == "660") {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span>");
        } else {
          $(".breakdown-insurance-option-title").html("デジタルライフサポート<br>＜デジタル機器 故障・盗難総合サポート＞<br>／プレミアム");
          $(".breakdown-insurance-option").html(insuranceOption_price + "<span class='plan-tax'>円</span>");
        }
      } else {
        $(".breakdown-insurance-option-title").closest('div.breakdown-list').hide();
      }
      // 内訳end
    }else{
      $(".summary-text-monthly-tax-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span>");
      $("#campaign_row").hide();
      $("#campaign_attention").hide();
      $(".monthly-period").show();
      $(".monthly-period2").show();
      $(".after-payment").hide();
      $(".monthly-period2.open").hide();
      $(".monthly-period2.breakdown").hide();
      $(".breakdown-plan-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".breakdown-device01-option-title").html("端末あんしんオプション");
      $(".breakdown-device01-option").html(deviceOption01_price + "<span class='plan-tax'>円</span>");
      $(".breakdown-device02-option-title").html("丸ごと安心パック <br class='sp'>for ZEUS WiFi");
      $(".breakdown-device02-option").html(deviceOption02_price + "<span class='plan-tax'>円</span>");
    }
  }else{
    $(".summary-text-monthly-tax-fee").html(planFee + "<span class='plan-tax'>円</span>");
    $(".summary-text-monthly-tax-total").html(monthlyFee.toLocaleString()  + "<span class='plan-tax'>円</span>");
    $(".summary-text-monthly-tax-total2").html(monthlyFee.toLocaleString()  + "<span class='plan-tax'>円</span>");
    if(deviceOptionFee>0){
      $(".summary-text-monthly-tax-total").html(insuranceCampaignFee.toLocaleString()  + "<span class='plan-tax'>円</span>");
      $(".summary-text-monthly-tax-total2").html(insuranceCampaignFee.toLocaleString()  + "<span class='plan-tax'>円</span>");
    }
  }
}

// WiMAX start

// //
// Update summary
// //
var gSummaryWimaxPrices = {
  plan_id: {
    "false": {
      "price": 0,
    },
    "345": {
      "price": 3740,
      "price_after1": 3784,
      "price_after2": 4708,
      "cancel_fee":1,
    },
    "346": {
      "price": 4400,
      "price_after1": 4818,
      "cancel_fee":0,
    },
    "347": {
      "price": 1474,
      "price_after1": 3784,
      "price_after2": 4708,
      "cancel_fee":1,
    },
    "349": {
      "price": 1474,
      "price_after1": 3784,
      "price_after2": 4708,
      "cancel_fee":1,
    },
    "734": {
      "price": 3740,
      "price_after1": 3740,
      "price_after2": 4290,
      "cancel_fee":1,
    },
    "735": {
      "price": 4400,
      "price_after1": 4400,
      "price_after2": 4950,
      "cancel_fee":0,
    },
  },
  wimax_device_id: {
    "false": {
      "price": 0,
    },
    "2": {
      "price": 27720,
    },
    "3": {
        "price": 27720,
    },
    "4": {
        "price": 19800,
    },
    "5": {
        "price": 19800,
    },
    "6": {
        "price": 25200,
    },
    "7": {
        "price": 25200,
    },
  },
  installment_payment: {
    "false": {
      "times": 0,
    },
    "1": {
      "times": 1,
      "price": 27720,
    },
    "2": {
      "times": 24,
      "price": 1155,
    },
    "3": {
      "times": 36,
      "price": 770,
    },
  },
  zeus_set: {
    "false": {
      "price": 0,
    },
    "set0": {
      "price": 0,
    },
    "21": {
      "price": 968,
    },
    "22": {
      "price": 1408,
    },
    "23": {
      "price": 2178,
    },
  },

  deviceOption1: {
    "false": {
      "price": 0,
    },
    "1": {
      "price": 440,
    },
    "11": {
      "price": 638,
    },
    "13": {
      "price": 858,
    },
    "33": {
      "price": 638,
    },
  },
  deviceOption2: {
    "false": {
      "price": 0,
    },
    "12": {
      "price": 999,
    },
  }
}

function updateWimaxSummary(){

  let planFee;

  var isOptionsPage = location.pathname.indexOf("/entry/wimax/select") === 0;
  if(!isOptionsPage){
    // Not options page
    return;
  }

  // gSelectedCapacity is given in entry/options in script tag
  var plan_id = $("input[name=plan_id]:checked").val();
  if (plan_id === undefined) {
    plan_id = 'false';
  }

  var deviceOption1 = $("input.option1:checked").val();
  if (deviceOption1 === undefined) {
    deviceOption1 = 'false';
  }

  var deviceOption2 = $("input[id=option2]:checked").val();
  if (deviceOption2 === undefined) {
    deviceOption2 = 'false';
  }

  // ZEUS WiFi set
  var zeus_set = $("input.zeus_set_gb:checked").val();
  if (zeus_set === undefined) {
    zeus_set = 'false';
  }

  var wimax_device_id = $("input[name=wimax_device_id]:checked").val();
  if (wimax_device_id === undefined) {
    wimax_device_id = 'false';
  }
  var installment_payment = $("input[name=installment_payment]:checked").val();
  if (installment_payment === undefined) {
    installment_payment = 'false';
  }
  var initialFee = 3850;
  var cancelFee = gCancelFee;
  var installment_payment_price = gSummaryWimaxPrices.installment_payment[installment_payment].price;
  if (installment_payment === 'false') {
    installment_payment_price = 0;
  }

  // device
  if(gSummaryWimaxPrices.wimax_device_id[wimax_device_id] && wimax_device_id === '2'){
    $(".summary-text-tie-device-name").text("Speed Wi-Fi HOME 5G L13");
    $(".x12-detail").hide();
  }else if (gSummaryWimaxPrices.wimax_device_id[wimax_device_id] && wimax_device_id === '3'){
    $(".summary-text-tie-device-name").text("Speed Wi-Fi 5G X12");
    $(".x12-detail").hide();
  }else if (gSummaryWimaxPrices.wimax_device_id[wimax_device_id] && wimax_device_id === '4'){
    $(".summary-text-tie-device-name").text("Speed Wi-Fi HOME 5G L13");
    $(".x12-detail").hide();
  }else if (gSummaryWimaxPrices.wimax_device_id[wimax_device_id] && wimax_device_id === '5'){
    $(".summary-text-tie-device-name").text("Galaxy 5G Mobile Wi-Fi");
    $(".x12-detail").hide();
  }else if (gSummaryWimaxPrices.wimax_device_id[wimax_device_id] && wimax_device_id === '6'){
    $(".summary-text-tie-device-name").text("Speed Wi-Fi HOME 5G L13");
    $(".x12-detail").hide();
  }else if (gSummaryWimaxPrices.wimax_device_id[wimax_device_id] && wimax_device_id === '7'){
    $(".summary-text-tie-device-name").text("Speed Wi-Fi 5G X12");
    $(".x12-detail").show();
  }else{
    $(".summary-text-tie-device-name").text("未選択");
    $(".x12-detail").hide();
  }

  // device color (Speed Wi-Fi 5G X11選択時のみ)
  $(".x12-black").show();
  $(".x12-white").hide();
  if (gSummaryWimaxPrices.wimax_device_id[wimax_device_id] && wimax_device_id === '7'){
    $(".selected-device-X12").show();
    if($("input[name=x12_detail1]:checked").val()==="1"){
      $(".x12-black").show();
      $(".x12-white").hide();
      $(".x12-white").removeClass("selected");
      $(".summary-text-device-color").text("シャドーブラック");
    }else if($("input[name=x12_detail1]:checked").val()==="2"){
      $(".x12-black").hide();
      $(".x12-white").show();
      $(".x12-white").addClass("selected");
      $(".summary-text-device-color").text("アイスホワイト");
    }else{
      $(".summary-text-device-color").text("未選択");
      $(".x12-black").show();
      $(".x12-white").hide();
    }
  }else{
    $(".selected-device-X12").hide();
  }

  // installment payment

  if(gSummaryWimaxPrices.installment_payment[installment_payment] && installment_payment === '1'){
    $(".summary-text-installment-payment").text("一括払い");
    $(".summary-text-installment-payment-price").html(installment_payment_price.toLocaleString() + "<span class='plan-tax'>円</span>");
  }else if (gSummaryWimaxPrices.installment_payment[installment_payment] && installment_payment === '2'){
    $(".summary-text-installment-payment").text("24回払い");
    $(".summary-text-installment-payment-price").html(installment_payment_price.toLocaleString() + "<span class='plan-tax'>円 ☓ </span>24<span class='plan-tax'>回</span>");
  }else if (gSummaryWimaxPrices.installment_payment[installment_payment] && installment_payment === '3'){
    $(".summary-text-installment-payment").text("36回払い");
    $(".summary-text-installment-payment-price").html(installment_payment_price.toLocaleString() + "<span class='plan-tax'>円 ☓ </span>36<span class='plan-tax'>回</span>");
  }else{
    $(".summary-text-installment-payment").text("未選択");
    $(".summary-text-installment-payment-price").html("0" + "<span class='plan-tax'>円</span>");
  }

  // tie
  if(gSummaryWimaxPrices.plan_id[plan_id] && gSummaryWimaxPrices.plan_id[plan_id].cancel_fee === 1){
    $(".summary-text-tie-plan-name").html("5Gギガ放題<br class='sp'>プラスSバリュープラン");
    cancelFee = gSummaryWimaxPrices.plan_id[plan_id].cancel_fee;
  }else if (gSummaryWimaxPrices.plan_id[plan_id] && gSummaryWimaxPrices.plan_id[plan_id].cancel_fee === 0){
    $(".summary-text-tie-plan-name").html("5Gギガ放題<br class='sp'>プラスSフリープラン");
    cancelFee = gSummaryWimaxPrices.plan_id[plan_id].cancel_fee;
  }else{
    $(".summary-text-tie-plan-name").text("未選択");
    cancelFee = 0;
  }

  // device option1
  if(deviceOption1 === '33'){
    $(".set-name").html("<br class='pc'>" + "for WiMAX");
    $(".textline > .set-name").html("<br>" + "for WiMAX");
    $(".summary-text-device-option-title-1").html("つける");
    $(".summary-text-device-option-price-1").html("638" + "<span class='plan-tax'>円</span>");
    $(".device-option1").show();
  }else if(deviceOption1 === '1'){
    $(".set-name").html("<br class='pc'>" + "for cloud");
    $(".textline > .set-name").html("<br>" + "for cloud");
    $(".summary-text-device-option-title-1").html("つける");
    $(".summary-text-device-option-price-1").html("440" + "<span class='plan-tax'>円</span>");
    $(".device-option1").show();
  }else if(deviceOption1 === '13'){
    $(".set-name").text("W");
    $(".textline > .set-name").text("W");
    $(".summary-text-device-option-title-1").html("つける");
    $(".summary-text-device-option-price-1").html("858" + "<span class='plan-tax'>円</span>");
    $(".device-option1").show();
  }else{
    $(".set-name").html("");
    $(".summary-text-device-option-title-1").text("つけない");
    $(".summary-text-device-option-price-1").html("0" + "<span class='plan-tax'>円</span>");
    $(".device-option1").hide();
    $(".option-detail-after").html('');
  }

  // device option2
  if(deviceOption2 === '12'){
    $(".summary-text-device-option-title-2").html("つける");
    $(".summary-text-device-option-price-2").html("999" + "<span class='plan-tax'>円</span>");
    $(".device-option2").show();
  }else{
    $(".summary-text-device-option-title-2").text("つけない");
    $(".summary-text-device-option-price-2").html("0" + "<span class='plan-tax'>円</span>");
    $(".device-option2").hide();
    $(".option-detail-after").html('');
  }

  // ZEUS WiFi set
  if(gSummaryWimaxPrices.zeus_set[zeus_set] && zeus_set === '21'){
    $(".summary-text-zeus-set").text("つける(15GB)");
    $(".summary-text-zeus-set-price").html("968" + "<span class='plan-tax'>円</span>");
    $(".device-option1.zeus-set-row").show();
    $(".set-giga").text("(15GB)");
  }else if(gSummaryWimaxPrices.zeus_set[zeus_set] && zeus_set === '22'){
    $(".summary-text-zeus-set").text("つける(30GB)");
    $(".summary-text-zeus-set-price").html("1,408" + "<span class='plan-tax'>円</span>");
    $(".device-option1.zeus-set-row").show();
    $(".set-giga").text("(30GB)");
  }else if(gSummaryWimaxPrices.zeus_set[zeus_set] && zeus_set === '23'){
    $(".summary-text-zeus-set").text("つける(100GB)");
    $(".summary-text-zeus-set-price").html("2,178" + "<span class='plan-tax'>円</span>");
    $(".device-option1.zeus-set-row").show();
    $(".set-giga").text("(100GB)");
  }else if(gSummaryWimaxPrices.zeus_set[zeus_set] && zeus_set === 'false'){
    $(".summary-text-zeus-set").text("つけない");
    $(".summary-text-zeus-set-price").html("0" + "<span class='plan-tax'>円</span>");
    $(".device-option1.zeus-set-row").hide();
  }else{
    $(".summary-text-zeus-set").text("未選択");
    $(".summary-text-zeus-set-price").html("0" + "<span class='plan-tax'>円</span>");
    $(".device-option1.zeus-set-row").hide();
  }

  // WiMAX option キャンペーン start
  // バリュープラン選択時
  if(gSummaryWimaxPrices.plan_id[plan_id].cancel_fee === 1 && (deviceOption1 === '33'||deviceOption1 === '1'||deviceOption1 === '13') && deviceOption2 === '12'){
    $(".summary-text-device-option-title-campaign-3").show();
    $(".cashbackCP").show();
    $("input[name=campaign_id]").prop('checked', true);
    $(".topping-2-select-area-wimax-campaign").addClass("selected");
    $(".summary-text-device-option-price-1").html("<span class='plan-tax'>※</span>" + "0" + "<span class='plan-tax'>円</span>");
    $(".summary-text-device-option-price-2").html("<span class='plan-tax'>※</span>" + "0" + "<span class='plan-tax'>円</span>");
    $(".option-campaign").html("※2");
    $(".option-detail-after").html("<span class='option-caution-text-flex'><span>※</span><span>オプションセットキャンペーンについて：<br>課金開始月を0ヶ月目として1ヶ月目までを無料といたします。</span></span>");
  }else{
    $(".summary-text-device-option-title-campaign-3").hide();
    $(".cashbackCP").hide();
    $("input[name=campaign_id]").prop('checked', false);
    $(".topping-2-select-area-wimax-campaign").removeClass("selected");

    if(gSummaryWimaxPrices.plan_id[plan_id].cancel_fee === 0 && (deviceOption1 === '33'||deviceOption1 === '1'||deviceOption1 === '13') && deviceOption2 === '12'){
      $(".summary-text-device-option-price-1").html("<span class='plan-tax'>※</span>" + "0" + "<span class='plan-tax'>円</span>");
      $(".summary-text-device-option-price-2").html("<span class='plan-tax'>※</span>" + "0" + "<span class='plan-tax'>円</span>");
      $(".option-campaign").html("※2");
    }else{
      $(".option-campaign").html("");
    }
  }

  if(deviceOption1 === '33' && deviceOption2 === '12'){
    $(".summary-text-device-option-title-campaign-2").show();
  }else if(deviceOption1 === '1' && deviceOption2 === '12'){
    $(".summary-text-device-option-title-campaign-2").show();
  }else if(deviceOption1 === '13' && deviceOption2 === '12'){
    $(".summary-text-device-option-title-campaign-2").show();
  }else{
    $(".summary-text-device-option-title-campaign-2").hide();
  }

  if(gSummaryWimaxPrices.plan_id[plan_id].cancel_fee === 1){
    $(".mypage-section-container-campaign").show();
  }else{
    $(".mypage-section-container-campaign").hide();
  }
  // WiMAX option キャンペーン end

  // ///
  // price
  // ///

  var cpFlg = (deviceOption1 === '33'||deviceOption1 === '1'||deviceOption1 === '13') && deviceOption2 === '12';

  // cancellation penalty
  $(".summary-text-initial-fee").html(initialFee.toLocaleString() + "<span class='plan-tax'>円</span>");
  
  var installmentPrice = 0;
  var cancelPrice = 0;
  if(cancelFee == 1){
    installmentPrice += 1;
    cancelPrice += 2;
  }
  if(cpFlg){
    installmentPrice += 1;
    cancelPrice += 1;
  }
  if(installment_payment == "3") {
    installmentPrice += 1;
    cancelPrice += 1;
    if(getParam("utm_medium") == "transfer"){
      installment_payment_price = 0;
      $(".summary-text-installment-payment").text("36回払い");
      $(".summary-text-installment-payment-price").html("0<span class='plan-tax'>円※" + installmentPrice + "</span>");
    }
  }

  if(cancelPrice == 0){
    $(".summary-text-cancel-tax-fee").html("0<span class='plan-tax'>円</span>");
  }else if($("input[name='plan_id']:checked").val() == '735'){
    $(".summary-text-cancel-tax-fee").html("0<span class='plan-tax'>円</span>");
  }else{
    $(".summary-text-cancel-tax-fee").html("<span class='plan-tax'>※</span>4,290<span class='plan-tax'>円</span>");
  }

  // monthly
  var price1;
  var price2;
  var price3;

  if (gSummaryWimaxPrices.plan_id[plan_id]) {
    price1 = gSummaryWimaxPrices.plan_id[plan_id].price;
    price2 = gSummaryWimaxPrices.plan_id[plan_id].price_after1;
    price3 = gSummaryWimaxPrices.plan_id[plan_id].price_after2;
  } else {
    price1 = 0;
  }
  var deviceOption1_price = gSummaryWimaxPrices.deviceOption1[deviceOption1].price;
  var deviceOption2_price = gSummaryWimaxPrices.deviceOption2[deviceOption2].price;
  if(cpFlg){
    deviceOption1_price = 0;
    deviceOption2_price = 0;
  }
  var priceZeus = gSummaryWimaxPrices.zeus_set[zeus_set].price;
  priceTotal = price1 + deviceOption1_price + deviceOption2_price + priceZeus;

  $(".summary-text-monthly").text("");
  $(".monthly-payment-after").text("");

  if (gSummaryWimaxPrices.plan_id[plan_id]) {
    if (plan_id === 'false') {
      $(".breakdown-tab").hide();
    }else{
      $(".summary-text-monthly-tax-total").html(priceTotal.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".summary-text-monthly-tax-fee").html("<span class='plan-tax'>※</span>" + price1.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".summary-text-monthly-tax-device").html(installment_payment_price.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".summary-text-monthly").html("キャンペーン適用価格");
      $(".summary-text-monthly-first").html("初月");
      if(installment_payment == "1"){
        $(".summary-text-monthly-device").html("初回のみ");
      }else if(installment_payment == "2"){
        $(".summary-text-monthly-device").html("課金開始月～<br class='sp'>23ヶ月目まで");
      }else if(installment_payment == "3"){
        $(".summary-text-monthly-device").html("課金開始月～<br class='sp'>35ヶ月目まで");
        if(getParam("utm_medium") == "transfer"){
          $(".summary-text-monthly-tax-device").html(installment_payment_price.toLocaleString() + "<span class='plan-tax'>円※" + installmentPrice + "</span>");
        }else{
          $(".summary-text-monthly-tax-device").html(installment_payment_price.toLocaleString() + "<span class='plan-tax'>円※" + installmentPrice + "</span>");
        }
      }else{
        $(".summary-text-monthly-tax-device").html(installment_payment_price.toLocaleString() + "<span class='plan-tax'>円</span>");
      }
      if (gSummaryWimaxPrices.plan_id[plan_id].cancel_fee === 1) {
        $(".monthly-payment-after").html("<span class='option-caution-text-flex'><span>※</span><span>ZEUS WiMAXカムバックキャンペーンについて：<br>課金開始月を0ヶ月目として、12ヶ月目までの月額基本料を3,400円（税込3,740円）といたします。</span></span>");
      }else{
        $(".monthly-payment-after").html("<span class='option-caution-text-flex'><span>※</span><span>ZEUS WiMAXカムバックキャンペーンについて：<br>課金開始月を0ヶ月目として、12ヶ月目までの月額基本料を4,000円（税込4,400円）といたします。</span></span>");
      }
      $(".breakdown-tab").show();
    }
  }else{
    $(".summary-text-monthly-tax-fee").html(planFee + "<span class='plan-tax'>円</span>");
    $(".summary-text-monthly-tax-total").html(priceTotal  + "<span class='plan-tax'>円</span>");
    $(".breakdown-tab").hide();
    $(".summary-text-monthly-tax-device").html(installment_payment_price.toLocaleString() + "<span class='plan-tax'>円</span>");
  }

  var notion = [];
  // バリュープラン
  if(cancelFee == 1){
    if((deviceOption1 === '33' || deviceOption1 === '1' ||deviceOption1 === '13') && deviceOption2 === '12'){
      // $(".option-detail-after").html("<span class='option-caution-text-flex'><span>※</span><span>オプションセットキャンペーンについて：<br>課金開始月を0ヶ月目として1ヶ月目までを無料といたします。</span></span>");
    }else{
      notion = []
    }
    // バリュープラン：24回払い
    if(installment_payment == "2") {
      notion.push("端末代総額：27,720円<br>支払期間：課金開始月（0ヶ月）から24回。月額利用料と同じタイミングで請求いたします。<br>実質年率：0％");
    }
    // バリュープラン：36回払い
    if(installment_payment == "3") {
      if(getParam("utm_medium") == "transfer"){
        notion.push("端末代総額：27,720円<br>支払期間：課金開始月（0ヶ月）から36回。月額利用料と同じタイミングで請求いたします。<br>実質年率：0％<br>＜端末代無料キャンペーンについて＞<br>端末代金の分割払い金額（36回×605円）をご契約された期間（課金開始月（0ヶ月）～35ヶ月目まで）毎月値引きいたします。(※)<br>※課金開始月（0ヶ月）～35ヶ月目までに解約された場合、解約月をもって本キャンペーンは適用外となります。端末代金の残債分に関しましては解約月に一括請求となります。");
      }else{
        notion.push("端末代総額：27,720円<br>支払期間：課金開始月（0ヶ月）から36回。月額利用料と同じタイミングで請求いたします。<br>実質年率：0％");
      }
    }
    notion.push("<span><span class='option-caution-text-flex'><span></span><span>解約事務手数料について：<br>課金開始月を0ヶ月目として24ヶ月目以降に解約される場合は、解約事務手数料はかかりません。</span></span>");
  }else{
  // フリープラン
    if((deviceOption1 === '33' || deviceOption1 === '1' ||deviceOption1 === '13')  && deviceOption2 === '12'){
      // $(".option-detail-after").html("<span><span class='option-caution-text-flex'><span>※</span><span>オプションセットキャンペーンについて：<br>課金開始月を0ヶ月目として1ヶ月目までを無料といたします。</span></span>");
    }else{
      notion = []
    }
    // フリープラン：24回払い
    if(installment_payment == "2") {
      notion.push("端末代総額：27,720円<br>支払期間：課金開始月（0ヶ月）から24回。月額利用料と同じタイミングで請求いたします。<br>実質年率：0％");
    }
    // フリープラン：36回払い
    if(installment_payment == "3") {
      notion.push("端末代総額：27,720円<br>支払期間：課金開始月（0ヶ月）から36回。月額利用料と同じタイミングで請求いたします。<br>実質年率：0％");
    }
  }
  var notionMsg = "";
  for (var i = 0; i < notion.length; i++) {
    notionMsg = notionMsg + ("<span class='wimax-notionMsg-flex'>" + "<span>※" + "</span>" + notion[i] + "</span>");
  }
  $(".campaign-notion-detail").html(notionMsg);
}

// WiMAX特別プラン start
function updateWimaxClosedSummary(){

  let planFee;

  var isOptionsPage = location.pathname.indexOf("/entry/wimax/closed/select") === 0;
  if(!isOptionsPage){
    // Not options page
    return;
  }

  // gSelectedCapacity is given in entry/options in script tag
  var plan_id = $("input[name=plan_id]:checked").val();
  if (plan_id === undefined) {
    plan_id = 'false';
  }

  var deviceOption1 = $("input[id=option1]:checked").val();
  if (deviceOption1 === undefined) {
    deviceOption1 = 'false';
  }

  var deviceOption2 = $("input[id=option2]:checked").val();
  if (deviceOption2 === undefined) {
    deviceOption2 = 'false';
  }

  var wimax_device_id = $("input[name=wimax_device_id]:checked").val();
  if (wimax_device_id === undefined) {
    wimax_device_id = 'false';
  }
  var installment_payment = $("input[name=installment_payment]:checked").val();
  if (installment_payment === undefined) {
    installment_payment = 'false';
  }
  var initialFee = gInitialFee;
  var cancelFee = gCancelFee;
  var installment_payment_price = gSummaryWimaxPrices.installment_payment[installment_payment].price;
  if (installment_payment === 'false') {
    installment_payment_price = 0;
  }

  // device
  if(gSummaryWimaxPrices.wimax_device_id[wimax_device_id] && wimax_device_id === '2'){
    $(".summary-text-tie-device-name").text("Speed Wi-Fi HOME 5G L12");
    $(".x11-detail").hide();
  }else if (gSummaryWimaxPrices.wimax_device_id[wimax_device_id] && wimax_device_id === '3'){
    $(".summary-text-tie-device-name").text("Speed Wi-Fi 5G X11");
    $(".x11-detail").show();
  }else if (gSummaryWimaxPrices.wimax_device_id[wimax_device_id] && wimax_device_id === '4'){
    $(".summary-text-tie-device-name").text("Speed Wi-Fi HOME 5G L11");
    $(".x11-detail").hide();
  }else if (gSummaryWimaxPrices.wimax_device_id[wimax_device_id] && wimax_device_id === '5'){
    $(".summary-text-tie-device-name").text("Galaxy 5G Mobile Wi-Fi");
    $(".x11-detail").hide();
  }else{
    $(".summary-text-tie-device-name").text("未選択");
    $(".x11-detail").hide();
  }

  // installment payment
  if (gSummaryWimaxPrices.installment_payment[installment_payment] && installment_payment === '3'){
    $(".summary-text-installment-payment").text("36回払い");
    $(".summary-text-installment-payment-price").html("0" + "<span class='plan-tax'>円※1</span>");
  }else{
    $(".summary-text-installment-payment").text("未選択");
    $(".summary-text-installment-payment-price").html("0" + "<span class='plan-tax'>円</span>");
  }

  // tie
  if(gSummaryWimaxPrices.plan_id[plan_id] && gSummaryWimaxPrices.plan_id[plan_id].cancel_fee === 1){
    $(".summary-text-tie-plan-name").text("5Gギガ放題バリュープラン");
    cancelFee = gSummaryWimaxPrices.plan_id[plan_id].cancel_fee;
  }else if (gSummaryWimaxPrices.plan_id[plan_id] && gSummaryWimaxPrices.plan_id[plan_id].cancel_fee === 0){
    $(".summary-text-tie-plan-name").text("5Gギガ放題フリープラン");
    cancelFee = gSummaryWimaxPrices.plan_id[plan_id].cancel_fee;
  }else{
    $(".summary-text-tie-plan-name").text("未選択");
    cancelFee = 0;
  }

  // device option1
  if(deviceOption1 === '33'){
    $(".summary-text-device-option-title-1").html("つける");
    $(".summary-text-device-option-price-1").html("638" + "<span class='plan-tax'>円(税込)</span>");
    $(".device-option1").show();
  }else{
    $(".summary-text-device-option-title-1").text("つけない");
    $(".summary-text-device-option-price-1").html("0" + "<span class='plan-tax'>円</span>");
    $(".device-option1").hide();
  }

  // device option2
  if(deviceOption2 === '12'){
    $(".summary-text-device-option-title-2").html("つける");
    $(".summary-text-device-option-price-2").html("999" + "<span class='plan-tax'>円(税込)</span>");
    $(".device-option2").show();
  }else{
    $(".summary-text-device-option-title-2").text("つけない");
    $(".summary-text-device-option-price-2").html("0" + "<span class='plan-tax'>円</span>");
    $(".device-option2").hide();
  }

  // WiMAX option キャンペーン start
  // バリュープラン選択時
  if(gSummaryWimaxPrices.plan_id[plan_id].cancel_fee === 1 && deviceOption1 === '33' && deviceOption2 === '12'){
    $(".summary-text-device-option-title-campaign-3").show();
    $("input[name=campaign_id]").prop('checked', true);
    $(".topping-2-select-area-wimax-campaign").addClass("selected");
    $(".summary-text-device-option-price-1").html("<span class='plan-tax'>最大2ヶ月 </span>" + "0" + "<span class='plan-tax'>円</span>");
    $(".summary-text-device-option-price-2").html("<span class='plan-tax'>最大2ヶ月 </span>" + "0" + "<span class='plan-tax'>円</span>");
    $(".option-campaign").html("※3");

    $(".wimax-item-select-campaign").on('click',function(){
      $("input[name=campaign_id]").prop('checked', false);
      $(".topping-2-select-area-wimax-campaign").removeClass("selected");
      $("input[id=option1]").prop('checked', false);
      $(".topping-2-select-area-wimax-option").removeClass("selected");
      $("input[id=option2]").prop('checked', false);
      var winW = $(window).width();
      var devW = 767;
      if (winW <= devW) {
        $(".topping-2-select-area-wimax-campaign").removeClass("active");
      }
    });
  }else{
    $(".summary-text-device-option-title-campaign-3").hide();
    $("input[name=campaign_id]").prop('checked', false);
    $(".topping-2-select-area-wimax-campaign").removeClass("selected");
    if(gSummaryWimaxPrices.plan_id[plan_id].cancel_fee === 0 && deviceOption1 === '11' && deviceOption2 === '12'){
      $(".summary-text-device-option-price-1").html("<span class='plan-tax'>最大2ヶ月 </span>" + "0" + "<span class='plan-tax'>円</span>");
      $(".summary-text-device-option-price-2").html("<span class='plan-tax'>最大2ヶ月 </span>" + "0" + "<span class='plan-tax'>円</span>");
      $(".option-campaign").html("※3");
    }else{
      $(".option-campaign").html("");
    }

    $(".wimax-item-select-campaign").on('click',function(){
      $("input[name=campaign_id]").prop('checked', true);
      $(".topping-2-select-area-wimax-campaign").addClass("selected");
      $("input[id=option1]").prop('checked', true);
      $(".topping-2-select-area-wimax-option").addClass("selected");
      $("input[id=option2]").prop('checked', true);
    })
  }

  if(deviceOption1 === '33' && deviceOption2 === '12'){
    $(".summary-text-device-option-title-campaign-2").show();
  }else{
    $(".summary-text-device-option-title-campaign-2").hide();
  }

  if(gSummaryWimaxPrices.plan_id[plan_id].cancel_fee === 1){
    $(".mypage-section-container-campaign").show();
  }else{
    $(".mypage-section-container-campaign").hide();
  }
  // WiMAX option キャンペーン end

  // ///
  // price
  // ///

  var cpFlg = deviceOption1 === '33' && deviceOption2 === '12';

  // cancellation penalty
  $(".summary-text-initial-fee").html(initialFee.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
  if(cancelFee == 1){
    if(cpFlg){
      if(installment_payment == "3") {
        $(".summary-text-cancel-tax-fee").html("4,290<span class='plan-tax'>円(税込) ※4</span>");
      } else {
        $(".summary-text-cancel-tax-fee").html("4,290<span class='plan-tax'>円(税込) ※3</span>");
      }
    }else{
      $(".summary-text-cancel-tax-fee").html("4,290<span class='plan-tax'>円(税込) ※2</span>");
    }
  }else{
    $(".summary-text-cancel-tax-fee").html("0<span class='plan-tax'>円</span>");
  }

  // monthly
  var price1;
  var price2;
  var price3;

  if (gSummaryWimaxPrices.plan_id[plan_id]) {
    price1 = gSummaryWimaxPrices.plan_id[plan_id].price;
    price2 = gSummaryWimaxPrices.plan_id[plan_id].price_after1;
    price3 = gSummaryWimaxPrices.plan_id[plan_id].price_after2;
  } else {
    price1 = 0;
  }

  var deviceOption1_price = gSummaryWimaxPrices.deviceOption1[deviceOption1].price;
  var deviceOption2_price = gSummaryWimaxPrices.deviceOption2[deviceOption2].price;
  if(cpFlg){
    deviceOption1_price = 0;
    deviceOption2_price = 0;
  }
  priceTotal = price1 + deviceOption1_price + deviceOption2_price;

  $(".summary-text-monthly").text("");
  $(".monthly-payment-after").text("");

  if (gSummaryWimaxPrices.plan_id[plan_id]) {
    if (plan_id === 'false') {
      $(".breakdown-tab").hide();
    }else{
      $(".summary-text-monthly-tax-total").html(priceTotal.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
      $(".summary-text-monthly-tax-fee").html(price1.toLocaleString() + "<span class='plan-tax'>円(税込)※2</span>");
      $(".summary-text-monthly-tax-device").html("0" + "<span class='plan-tax'>円※1</span>");
      $(".summary-text-monthly").html("キャンペーン適用価格");
      $(".summary-text-monthly-first").html("初月");
      if(installment_payment == "1"){
        $(".summary-text-monthly-device").html("初回のみ");
      }else if(installment_payment == "2"){
        $(".summary-text-monthly-device").html("課金開始月～<br class='sp'>23ヶ月目まで");
      }else if(installment_payment == "3"){
        $(".summary-text-monthly-device").html("課金開始月～<br class='sp'>35ヶ月目まで");
        $(".summary-text-monthly-tax-device").html(installment_payment_price.toLocaleString() + "<span class='plan-tax'>円(税込)※3</span>");
      }else{
        $(".summary-text-monthly-tax-device").html("0" + "<span class='plan-tax'>円※1</span>");
      }
      if (gSummaryWimaxPrices.plan_id[plan_id].cancel_fee === 1) {
        $(".device-campaign-detail").html("<span class='option-caution-text-flex'><span>※1　</span><span>端末代金の分割払い金額（36回×605円(税込)）をご契約された期間（課金開始月（0ヶ月）～35ヶ月目まで）毎月値引きいたします。(※)<br>※課金開始月（0ヶ月）～35ヶ月目までに解約された場合、解約月をもって本キャンペーンは適用外となります。端末代金の残債分に関しましては解約月に一括請求となります。</span></span><br>");
        $(".monthly-payment-after").html("<span class='option-caution-text-flex'><span>※2　</span><span>5Gギガ放題バリュープランの月額基本料を下記のキャンペーン価格といたします。(※)<br>・課金開始月の翌月から起算して2ヶ月目まで1,340円（1,474円税込）<br>・3ヶ月目から36ヶ月目まで3,440円（3,784円税込）<br>・37ヶ月目以降4,280円（4,708円税込）<br>※本キャンペーン適用のお客様の初月基本料は、上記キャンペーン価格の日割計算となります。</span></span>");
      }
      $(".breakdown-tab").show();
    }
  }else{
    $(".summary-text-monthly-tax-fee").html(planFee + "<span class='plan-tax'>円</span>");
    $(".summary-text-monthly-tax-total").html(priceAfter  + "<span class='plan-tax'>円</span>");
    $(".breakdown-tab").hide();
    $(".summary-text-monthly-tax-device").html("0" + "<span class='plan-tax'>円※1</span>");
  }

  var notion = [];
  if(cancelFee == 1){
    if(deviceOption1 === '33' && deviceOption2 === '12'){
      notion.push("<span>「ZEUS WiMAX 端末あんしんオプション」、「丸ごと安心パック for ZEUS WiFi」の月額利用料を、課金開始月の翌月分まで無料といたします。(※)<br>※ZEUS WiMAX契約時に上記2つのオプションサービスを申し込み頂いたお客様が対象となります。ただし、無料期間中にどちらかのオプションサービスを解約された場合、本キャンペーンは適用外となり、もう一方のオプションサービスの月額利用料が課金されます。</span>");
    }else{
      notion = []
    }
    if(installment_payment == "3") {
      notion.push("端末代総額：27,720円（税込）<br>支払期間：課金開始月（0ヶ月）から36回。月額利用料と同じタイミングで請求いたします。<br>実質年率：0％");
    }
    notion.push("12ヶ月目以降の解約は解約事務手数料がかかりません。");
  }else{
    if(deviceOption1 === '33' && deviceOption2 === '12'){
      notion.push("<span>「ZEUS WiMAX 端末あんしんオプション」、「丸ごと安心パック for ZEUS WiFi」の月額利用料を、課金開始月の翌月分まで無料といたします。(※)<br>※ZEUS WiMAX契約時に上記2つのオプションサービスを申し込み頂いたお客様が対象となります。ただし、無料期間中にどちらかのオプションサービスを解約された場合、本キャンペーンは適用外となり、もう一方のオプションサービスの月額利用料が課金されます。</span>");
    }else{
      notion = []
    }
    if(installment_payment == "3") {
      notion.push("端末代総額：27,720円（税込）<br>支払期間：課金開始月（0ヶ月）から36回。月額利用料と同じタイミングで請求いたします。<br>実質年率：0％");
    }
  }
  var notionMsg = "";
  for (var i = 0; i < notion.length; i++) {
    notionMsg = notionMsg + ("<br><span class='wimax-notionMsg-flex'>" + "<span>※" + (i+3) + "　</span>" + notion[i] + "<br>" + "</span>");
  }
  $(".campaign-notion-detail").html(notionMsg);
}
// WiMAX特別プラン end

function wimaxEntrySubmit() {
  var wimax_device_id = $("input[name=wimax_device_id]:checked").val();
  var installment_payment = $("input[name=installment_payment]:checked").val();
  var x11_detail1 = $("input[name=x11_detail1]:checked").val();
  var x12_detail1 = $("input[name=x12_detail1]:checked").val();

  var wimax_device_id_uncheck = $("input[name=wimax_device_id]:checked").length;
  var installment_payment_uncheck = $("input[name=installment_payment]:checked").length;
  var x11_detail1_uncheck = $("input[name=x11_detail1]:checked").length;
  var x12_detail1_uncheck = $("input[name=x12_detail1]:checked").length;

  if(wimax_device_id == "3"){
    if(installment_payment == "1"){
      if(x11_detail1 == "1"){
        $("input[name='device[]']").val('33');
      }else if(x11_detail1 == "2"){
        $("input[name='device[]']").val('35');
      }
    }else if(installment_payment == "3"){
      if(x11_detail1 == "1"){
        $("input[name='device[]']").val('30');
      }else if(x11_detail1 == "2"){
        $("input[name='device[]']").val('34');
      }
    }
  }else if(wimax_device_id == "5"){
    if(installment_payment == "1"){
      $("input[name='device[]']").val('24');
    }else if(installment_payment == "3"){
      $("input[name='device[]']").val('32');
    }
  }else if(wimax_device_id == "2"){
    if(installment_payment == "1"){
      $("input[name='device[]']").val('21');
    }else if(installment_payment == "3"){
      $("input[name='device[]']").val('29');
    }
  }else if(wimax_device_id == "4"){
    if(installment_payment == "1"){
      $("input[name='device[]']").val('23');
    }else if(installment_payment == "3"){
      $("input[name='device[]']").val('31');
    }
  }else if(wimax_device_id == "3"){
    if(installment_payment == "1"){
      $("input[name='device[]']").val('35');
    }else if(installment_payment == "3"){
      $("input[name='device[]']").val('34');
    }
  }else if(wimax_device_id === '6'){
    // Speed Wi-Fi HOME 5G L13
    if(installment_payment == "1"){
      $("input[name='device[]']").val('43');
    }else if(installment_payment == "2"){
      $("input[name='device[]']").val('44');
    }else if(installment_payment == "3") {
      $("input[name='device[]']").val('49');
    }
  }else if(wimax_device_id === '7'){
    // Speed Wi-Fi 5G X12
    if(installment_payment == "1"){
      if(x12_detail1 == "1"){
        $("input[name='device[]']").val('45');  // 一括黒
      }else if(x12_detail1 == "2"){
        $("input[name='device[]']").val('47');  // 一括白
      }
    }else if(installment_payment == "2"){
      if(x12_detail1 == "1"){
        $("input[name='device[]']").val('46');  // 分割黒
      }else if(x12_detail1 == "2"){
        $("input[name='device[]']").val('48');  // 分割白
      }
    }else if(installment_payment == "3"){
      if(x12_detail1 == "1"){
        $("input[name='device[]']").val('50');  // 分割黒
      }else if(x12_detail1 == "2"){
        $("input[name='device[]']").val('51');  // 分割白
      }
    }
  }

  $("#device-id-error-message").html('');
  $("#installment-payment-id-error-message").html('');
  $("#plan-id-error-message").html('');
  $("#zeus-set-id-error-message").html('');

  if (wimax_device_id_uncheck == 0) {
    $("#device-id-error-message").html('<label class="validator-error">端末を選択してください。</label>');
    $(window).scrollTop($("#device-id-error-message").position().top);
    if (installment_payment_uncheck == 0) {
      $("#installment-payment-id-error-message").html('<label class="validator-error">端末代金の支払い方法を選択してください。</label>');
    }
    return false;
  } else if (wimax_device_id == 3 && x11_detail1_uncheck == 0) {
    $("#device-id-error-message").html('<label class="validator-error">端末カラーを選択してください。</label>');
    $(window).scrollTop($("#device-id-error-message").position().top);
    if (installment_payment_uncheck == 0) {
      $("#installment-payment-id-error-message").html('<label class="validator-error">端末代金の支払い方法を選択してください。</label>');
    }
    return false;
  } else if (installment_payment_uncheck == 0) {
    $("#installment-payment-id-error-message").html('<label class="validator-error">端末代金の支払い方法を選択してください。</label>');
    $(window).scrollTop($(".wimax-entry-section-5").position().top);
    return false;
  }

  document.forms[0].submit();
}
// WiMAX end

// //
// Update SB-Hikari-Set summary
// //
var gSummaryHikariPrices = {
  plan_id: {
    "1": {
      "capacity": 40,
      "price": 1000,
      "cancel_fee":0,
    },
    "2": {
      "capacity": 100,
      "price": 2300,
      "cancel_fee":0,
    },
    "326": {
      "capacity": 40,
      "price": 700,
      "cancel_fee": 9500,
    },
    "327": {
      "capacity": 100,
      "price": 1000,
      "cancel_fee":9500,
    },
    "328": {
      "capacity": 20,
      "price": 0,
      "cancel_fee":9500,
    },
    "329": {
      "capacity": 20,
      "price": 400,
      "cancel_fee":0,
    },
  },
  deviceOption: {
    'true': 400,
    'false': 0,
  }
}


function updateHikariSummary(){

  let planFee;
  let planHikariFee;

  var isOptionsPagehikari = location.pathname.indexOf("/entry/externalserviceset/select") === 0;

  if(!isOptionsPagehikari){
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

  // capacity
  // $(".summary-text-capacity").text(capacity);

  // tie
  if(gSummaryHikariPrices.plan_id[plan_id] && gSummaryHikariPrices.plan_id[plan_id].cancel_fee === 9500){
//        $(".summary-text-tie-title").text("つけない");
    $(".summary-text-tie-plan-name").html("スタンダード<br class=\"sp\">プラン");
    $(".summary-text-tie-period").text("2年");
    $(".summary-text-capacity").text(gSummaryHikariPrices.plan_id[plan_id].capacity);
    cancelFee = gSummaryHikariPrices.plan_id[plan_id].cancel_fee;
  }else if (gSummaryHikariPrices.plan_id[plan_id] && gSummaryHikariPrices.plan_id[plan_id].cancel_fee === 0){
//        $(".summary-text-tie-title").text("つける");
    $(".summary-text-tie-plan-name").text("フリープラン");
    $(".summary-text-tie-period").text("なし");
    $(".summary-text-capacity").text(gSummaryHikariPrices.plan_id[plan_id].capacity);
    cancelFee = gSummaryHikariPrices.plan_id[plan_id].cancel_fee;
  }else{
    $(".summary-text-tie-title").text("未選択");
    $(".summary-text-tie-period").text("未選択");
    cancelFee = 0;
  }

  // device option
  if(deviceOption === 'true'){
    $(".summary-text-device-option-title").text("つける");
  }else{
    $(".summary-text-device-option-title").text("つけない");
  }

  // initial fee


  // ///
  // price
  // ///

  // initial and cancel
  $(".summary-text-initial-fee").text(initialFee.toLocaleString());
  $(".summary-text-cancel-fee").text(cancelFee.toLocaleString());
  if (cancelFee != 0){
    $(".summary-text-cancel-fee-with-tax").text("(" + (cancelFee * 1.1).toLocaleString() + "円税込)");
  }else{
    $(".summary-text-cancel-fee-with-tax").text("");
  }

  // monthly
  if (gSummaryPrices.plan_id[plan_id]) {
    planFee = gSummaryPrices.plan_id[plan_id].price;
  } else {
    planFee = 0;
  }
  if (gSummaryHikariPrices.plan_id[plan_id]) {
    planHikariFee = gSummaryHikariPrices.plan_id[plan_id].price;
    $(".summary-text-monthly-discount").text("(-1,980)");
  } else {
    planHikariFee = 0;
  }

  var deviceOptionKey = deviceOption || "false";
  var deviceOptionFee = gSummaryHikariPrices.deviceOption[deviceOptionKey];
  var beforemonthlyFee = planFee + deviceOptionFee;
  var aftermonthlyFee = planHikariFee + deviceOptionFee;

  $(".summary-text-monthly-fee").text(beforemonthlyFee.toLocaleString());
  $(".summary-text-after-hikari-monthly-fee").text(aftermonthlyFee.toLocaleString());

  var beforetotalPriceWihtoutTax = beforemonthlyFee;
  var beforetax = beforetotalPriceWihtoutTax * 0.1;

  var aftertotalPriceWihtoutTax = aftermonthlyFee;
  var aftertax = aftertotalPriceWihtoutTax * 0.1;

  $(".summary-text-tax").text(beforetax.toLocaleString());
  $(".summary-text-after-hikari-tax").text(aftertax.toLocaleString());

  var beforetotal = beforetotalPriceWihtoutTax + beforetax;
  var aftertotal = aftertotalPriceWihtoutTax + aftertax;

  $(".summary-text-total").text(beforetotal.toLocaleString());
  $(".summary-text-after-hikari-total").text(aftertotal.toLocaleString());

}

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
    $(".summary-text-device-option-price").html("528円<br class='sp'>(580円税込)");
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

// //
// Device Option Popup
// //
// logincs are in script.js

// //
// Update summary
// //
var gSummaryCRPrices = {
  plan_id: {
    "1": {
      "capacity": 40,
      "price": 2580,
      "cancel_fee":0,
    },
    "2": {
      "capacity": 100,
      "price": 3680,
      "cancel_fee":0,
    },
    "326": {
      "capacity": 40,
      "price": 1528,
      "cancel_fee": 9500,
      "price_after": 2680,
    },
    "327": {
      "capacity": 100,
      "price": 2980,
      "cancel_fee":9500,
    },
    "328": {
      "capacity": 20,
      "price": 891,
      "cancel_fee":9500,
      "price_after": 1980,
    },
    "329": {
      "capacity": 20,
      "price": 2180,
      "cancel_fee":0,
    },
    "363": {
      "capacity": 30,
      "price": 2280,
      "cancel_fee":9500,
      "price_after": 2280,
    },
    "361": {
      "capacity": 30,
      "price": 2880,
      "cancel_fee":0,
    },
    "364": {
      "capacity": 50,
      "price": 2980,
      "cancel_fee":9500,
      "price_after": 2980,
    },
    "362": {
      "capacity": 50,
      "price": 3480,
      "cancel_fee":0,
    },
    "365": {
      "capacity": 100,
      "price": 2980,
      "cancel_fee":9500,
    },
  },
  deviceOption: {
    'true': 400,
    'false': 0,
  }
}
function updateCRSummary(){

  let planFee;

  var isOptionsPage = location.pathname.indexOf("/entry/salespartner/select") === 0;
  if(!isOptionsPage){
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

  //
  // Text
  // ///

  // capacity
  // $(".summary-text-capacity").text(capacity);

  // tie
  if(gSummaryCRPrices.plan_id[plan_id] && gSummaryCRPrices.plan_id[plan_id].cancel_fee === 9500){
    $(".summary-text-tie-plan-name").text("スタンダードプラン");
    $(".summary-text-tie-period").text("(契約期間2年)");
    $(".summary-text-capacity").html("<br>" + gSummaryCRPrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryCRPrices.plan_id[plan_id].cancel_fee;
  }else if (gSummaryCRPrices.plan_id[plan_id] && gSummaryCRPrices.plan_id[plan_id].cancel_fee === 0){
//        $(".summary-text-tie-title").text("つける");
    $(".summary-text-tie-plan-name").text("フリープラン");
    $(".summary-text-tie-period").text("(契約期間なし)");
    $(".summary-text-capacity").html("<br>" + gSummaryCRPrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryCRPrices.plan_id[plan_id].cancel_fee;
  }else{
    $(".summary-text-tie-title").text("未選択");
    $(".summary-text-tie-period").text("未選択");
    cancelFee = 0;
  }

  // device option
  if(deviceOption === 'true'){
    $(".summary-text-device-option-title").html("つける");
    $(".summary-text-device-option-price").html("440" + "<span class='plan-tax'>円(税込)</span>");
  }else if(deviceOption === 'false'){
    $(".summary-text-device-option-title").text("つけない");
    $(".summary-text-device-option-price").html("0" + "<span class='plan-tax'>円</span>");
  }else{
    $(".summary-text-device-option-title").text("未選択");
    $(".summary-text-device-option-price").html("0" + "<span class='plan-tax'>円</span>");
  }


  // ///
  // price
  // ///

  var tax = 1.1;

  // initial and cancel
  initialTaxFee = initialFee * tax;
  cancelTaxFee = cancelFee * tax;
  $(".summary-text-initial-fee").html(initialTaxFee.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
  $("#cancel_fee_attention").hide();
  if(cancelFee == 9500){
    $(".summary-text-cancel-fee").html("<span class='small-price-attention'>※</span>");
    $(".summary-text-cancel-tax-fee").html(cancelTaxFee.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
    $("#cancel_fee_attention").show();
  }else{
    $(".summary-text-cancel-fee").html("");
    $(".summary-text-cancel-tax-fee").html("0<span class='plan-tax'>円</span>");
  }

  // monthly
  if (gSummaryCRPrices.plan_id[plan_id]) {
    planFee = gSummaryCRPrices.plan_id[plan_id].price;
    planTaxFee = planFee * tax;
    planTaxFee = Math.floor(planTaxFee);
    if (gSummaryCRPrices.plan_id[plan_id].price_after) {
        priceAfter = gSummaryCRPrices.plan_id[plan_id].price_after;
        priceTaxAfter = priceAfter * tax;
        priceTaxAfter = Math.floor(priceTaxAfter);
      }
  } else {
    planFee = 0;
    planTaxFee = planFee * tax;
  }

  var deviceOptionKey = deviceOption || "false";
  var deviceOptionFee = gSummaryCRPrices.deviceOption[deviceOptionKey];
  var deviceOptionTaxFee = deviceOptionFee * tax;
  deviceOptionTaxFee = Math.floor(deviceOptionTaxFee);
  var monthlyFee = planFee + deviceOptionFee;
  var monthlyTaxFee = planTaxFee + deviceOptionTaxFee;

  $("#campaign_row").hide();
  $("#campaign_attention").hide();
  $(".summary-text-monthly").text("");
  $(".monthly-payment-after").text("");

  if (gSummaryPrices.plan_id[plan_id]) {
    $(".summary-text-monthly-tax-total").html(monthlyTaxFee.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
    if(plan_id == "326" || plan_id == "327" || plan_id == "328"){

      $("#campaign_row").show();
      $("#campaign_attention").show();

      if(plan_id == "327"){
        $(".summary-text-campaign-name").html("キャスティングロード優待キャンペーン<br>ZEUS Wキャンペーン（10GBボーナス）");
        $(".summary-text-monthly-tax-fee").html(planTaxFee.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
        $(".summary-text-monthly").hide();
        $(".campaign-attention").hide();
        $(".monthly-payment-after").hide();

      } else if(plan_id == "326"){
        $(".summary-text-monthly").show();
        $(".campaign-attention").show();
        $(".monthly-payment-after").show();

        $(".summary-text-campaign-name").html("ZEUS Wキャンペーン（10GBボーナス）");
        $(".summary-text-monthly-tax-fee").html("<span class='small-price-attention'>※</span>" + planTaxFee.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
        $(".summary-text-monthly").html("3ヶ月目まで");
        $(".campaign-attention").html("※課金開始月を1ヶ月目として、3ヶ月目までの月額基本料を" + planTaxFee.toLocaleString() + "円、4ヶ月目以降の月額基本料を" + priceTaxAfter.toLocaleString() + "円といたします。");
        $(".monthly-payment-after").html("[4ヶ月目以降 " + (priceTaxAfter + deviceOptionTaxFee).toLocaleString() + "円(税込)]");

      } else {
        $(".summary-text-monthly").show();
        $(".campaign-attention").show();
        $(".monthly-payment-after").show();

        $(".summary-text-campaign-name").html("ZEUS Wキャンペーン（5GBボーナス）");
        $(".summary-text-monthly-tax-fee").html("<span class='small-price-attention'>※</span>" + planTaxFee.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
        $(".summary-text-monthly").html("3ヶ月目まで");
        $(".campaign-attention").html("※課金開始月を1ヶ月目として、3ヶ月目までの月額基本料を" + planTaxFee.toLocaleString() + "円、4ヶ月目以降の月額基本料を" + priceTaxAfter.toLocaleString() + "円といたします。");
        $(".monthly-payment-after").html("[4ヶ月目以降 " + (priceTaxAfter + deviceOptionTaxFee).toLocaleString() + "円(税込)]");
      }


    }else if(plan_id == "1" || plan_id == "2" || plan_id == "329"){
      $(".summary-text-monthly-tax-fee").html(planTaxFee.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
      $(".summary-text-campaign-name").html("キャスティングロード優待キャンペーン");
      $("#campaign_row").show();
    }
    else{
      $(".summary-text-monthly-tax-fee").html(planTaxFee.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
      $("#campaign_row").hide();
      $("#campaign_attention").hide();
    }
  }else{
    $(".summary-text-monthly-tax-fee").html(planTaxFee + "<span class='plan-tax'>円</span>");
    $(".summary-text-monthly-tax-total").html(monthlyTaxFee  + "<span class='plan-tax'>円</span>");
    if(deviceOptionTaxFee>0){
      $(".summary-text-monthly-tax-total").html(monthlyTaxFee  + "<span class='plan-tax'>円(税込)</span>");
    }
  }

}

var gSummaryOHPrices = {
    plan_id: {
      "339": {
        "capacity": 10,
        "price": 1089,
        "cancel_fee":1,
      },
      "340": {
        "capacity": 50,
        "price": 2178,
        "cancel_fee":1,
      },
      "341": {
        "capacity": 100,
        "price": 2728,
        "cancel_fee":1,
      },

      "342": {
        "capacity": 10,
        "price": 2178,
        "cancel_fee":0,
      },
      "343": {
        "capacity": 50,
        "price": 3278,
        "cancel_fee":0,
      },
      "344": {
        "capacity": 100,
        "price": 4378,
        "cancel_fee":0,
      },
    },
    deviceOption: {
      'true': 440,
      'false': 0,
    }
}

function updateOHSummary(){

  let planFee;

  var isOptionsPage = location.pathname.indexOf("/entry/oh_specialplans/select") === 0;
  if(!isOptionsPage){
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

  //
  // Text
  // ///

  // capacity
  // $(".summary-text-capacity").text(capacity);

  // tie
  if(gSummaryOHPrices.plan_id[plan_id] && gSummaryOHPrices.plan_id[plan_id].cancel_fee === 1){
    $(".summary-text-tie-plan-name").html('物件購入者様特別/<br>スタンダードプラン');
    $(".summary-text-tie-period").text("(契約期間4ヶ月)");
    $(".summary-text-capacity").html("<br>" + gSummaryOHPrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryOHPrices.plan_id[plan_id].cancel_fee;
  }else if (gSummaryOHPrices.plan_id[plan_id] && gSummaryOHPrices.plan_id[plan_id].cancel_fee === 0){
    $(".summary-text-tie-plan-name").html('物件購入者様特別/<br>フリープラン');
    $(".summary-text-tie-period").text("(契約期間なし)");
    $(".summary-text-capacity").html("<br>" + gSummaryOHPrices.plan_id[plan_id].capacity + "GB");
    cancelFee = gSummaryOHPrices.plan_id[plan_id].cancel_fee;
  }else{
    $(".summary-text-tie-title").text("未選択");
    $(".summary-text-tie-period").text("未選択");
    cancelFee = 0;
  }

  // device option
  if(deviceOption === 'true'){
    $(".summary-text-device-option-title").html("つける");
    $(".summary-text-device-option-price").html("440" + "<span class='plan-tax'>円(税込)</span>");
  }else if(deviceOption === 'false'){
    $(".summary-text-device-option-title").text("つけない");
    $(".summary-text-device-option-price").html("0" + "<span class='plan-tax'>円<span class='space'></span></span>");
  }else{
    $(".summary-text-device-option-title").text("未選択");
    $(".summary-text-device-option-price").html("0" + "<span class='plan-tax'>円<span class='space'></span></span>");
  }

  // ///
  // price
  // ///

  // initial and cancel
  $("#cancel_fee_attention").hide();
  $(".cancel-month").hide();

  switch(gSummaryOHPrices.plan_id[plan_id] && gSummaryOHPrices.plan_id[plan_id].cancel_fee){
    //縛りあり
    case 1:
      initialFee = 1500;
      $(".cancel-month").show();
      $("#cancel_fee_attention").show();
      $(".summary-text-cancel-fee").html("<span class='small-price-attention'>※</span>");
      $(".cancel-month").html("月額費用の");
      $(".cancel-month-num").html("ヶ月分");
      $(".summary-text-cancel-tax-fee").html(gSummaryOHPrices.plan_id[plan_id].cancel_fee.toLocaleString());
      break;

      //縛りなし
      case 0:
          initialFee = 3000;
          $(".summary-text-cancel-fee").html("");
          $(".summary-text-cancel-tax-fee").html(gSummaryOHPrices.plan_id[plan_id].cancel_fee.toLocaleString());
      $(".cancel-month-num").html("円");
    break;

    default:
      initialFee = 0;
      $(".cancel-month-num").html("未選択");
    break;
  }

  if(initialFee > 0){
    initialFeeTax = Math.floor(initialFee * 1.1);
    $(".summary-text-initial-fee").html(initialFeeTax.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
  }else{
    $(".summary-text-initial-fee").html(initialFee.toLocaleString() + "<span class='plan-tax'>円<span class='space'></span></span>");
  }

  // monthly
  if (gSummaryOHPrices.plan_id[plan_id]) {
    planFee = gSummaryOHPrices.plan_id[plan_id].price;
    if (gSummaryOHPrices.plan_id[plan_id].price_after) {
      priceAfter = gSummaryOHPrices.plan_id[plan_id].price_after;
    }
  } else {
    planFee = 0;
  }

  var deviceOptionKey = deviceOption || "false";
  var deviceOptionFee = Math.floor(gSummaryOHPrices.deviceOption[deviceOptionKey]);
  var monthlyFee = planFee + deviceOptionFee;

  $(".summary-text-monthly").text("");
  $(".monthly-payment-after").text("");

  if (gSummaryOHPrices.plan_id[plan_id]) {
    $(".summary-text-monthly-tax-total").html(monthlyFee.toLocaleString() + "<span class='plan-tax'> 円(税込)</span>");
    if(plan_id == "339" || plan_id == "340" || plan_id == "341"){
      $(".summary-text-monthly-tax-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
      var discountMonth = 4 + 1;
      $(".discount-month").html(discountMonth.toLocaleString());
    }else{
      $(".summary-text-monthly-tax-fee").html(planFee.toLocaleString() + "<span class='plan-tax'>円(税込)</span>");
    }
  }else{
    $(".summary-text-monthly-tax-fee").html(planFee + "<span class='plan-tax'>円<span class='space'></span></span>");
    $(".summary-text-monthly-tax-total").html(monthlyFee + "<span class='plan-tax'>円<span class='space'></span></span>");
    if(deviceOptionFee > 0){
      $(".summary-text-monthly-tax-total").html(monthlyFee + "<span class='plan-tax'>円(税込)</span>");
    }
  }
}

// 銀行振り込みプラン
function updateSpecialSummary(){

  var isOptionsPage = location.pathname.indexOf("/entry/special/select") === 0;
  if(!isOptionsPage){
      // Not options page
      return;
  }

  // gSelectedCapacity is given in entry/options in script tag
  var plan_id = $("input[name=plan_id]:checked").val();
  if (plan_id === undefined) {
      plan_id = 0;
  }
  var month = '';

  var deviceOption01 = $("input[id=option1]:checked").val();
  if (deviceOption01 === undefined) {
    deviceOption01 = 'false';
  }

  var deviceOptionKey01 = deviceOption01 || "false";
  var deviceOption01_price = gSummaryPrices.deviceOption01[deviceOptionKey01].price;

  var initialFee = gInitialFee;
  var cancelFee = gCancelFee;

  // tie
  if (gSummaryPrices.plan_id[plan_id]) {
    var spacialPlanTitle = 'まとめて前払い' + (gSummaryPrices.plan_id[plan_id].period !== 0 ? 'スタンダードプラン' : 'フリープラン');
    $(".summary-text-tie-plan-name").text(spacialPlanTitle);
    month = gSummaryPrices.plan_id[plan_id].month;
    var specialPlanSubTitle = gSummaryPrices.plan_id[plan_id].capacity + "GB";
    specialPlanSubTitle += " (" + gSummaryPrices.plan_id[plan_id].month + "ヶ月分一括/";
    if (gSummaryPrices.plan_id[plan_id].period !== 0) {
      specialPlanSubTitle += "契約期間" + (gSummaryPrices.plan_id[plan_id].month + 1) + "ヶ月";
    } else {
      specialPlanSubTitle += "契約期間なし";
    }
    specialPlanSubTitle += ")";
    $(".summary-text-tie-period").html(specialPlanSubTitle);
    cancelFee = gSummaryPrices.plan_id[plan_id].cancel_fee;
  }else{
    $(".summary-text-tie-title").text("未選択");
    $(".summary-text-tie-period").text("未選択");
    cancelFee = 0;
  }

    // device option01
  if(deviceOption01 === '16'){
    $(".summary-text-device-option-title01").html("つける");
    deviceOption01_price = deviceOption01_price * month;
    $(".summary-text-device-option-price01").html(deviceOption01_price.toLocaleString()  + "<span class='plan-tax'>円</span>");
  }else{
    $(".summary-text-device-option-title01").text("つけない");
    $(".summary-text-device-option-price01").html("0" + "<span class='plan-tax'>円</span>");
  }

  // ///
  // price
  // ///

  // initial and cancel
  $(".summary-text-initial-fee").html("<span class=\"center\"></span><span><span class=\"breakdown-plan-fee\">" + initialFee.toLocaleString() + "</span><span class='plan-tax'>円</span><em></em></span>");
  $("#cancel_fee_attention").hide();
  if(gSummaryPrices.plan_id[plan_id] && gSummaryPrices.plan_id[plan_id].period === 0){
    $(".summary-text-cancel-fee").html("");
    $(".summary-text-cancel-tax-fee").html("0<span class='plan-tax'>円</span>");
  }else if(cancelFee > 0){
    $(".summary-text-cancel-fee").html("<span class='small-price-attention'>※</span>");
    $(".summary-text-cancel-tax-fee").html(cancelFee.toLocaleString() + "<span class='plan-tax'>円</span>");
    $("#cancel_fee_attention").show();
  }else{
    $(".summary-text-cancel-fee").html("");
    $(".summary-text-cancel-tax-fee").html("0<span class='plan-tax'>円</span>");
  }

  // monthly
  if (gSummaryPrices.plan_id[plan_id]) {
    planFee = gSummaryPrices.plan_id[plan_id].price;
    planFee2 = gSummaryPrices.plan_id[plan_id].price2;
    if (gSummaryPrices.plan_id[plan_id].price_after) {
      priceAfter = gSummaryPrices.plan_id[plan_id].price_after;
    }
  } else {
    planFee = 0;
  }

  var totalFee = 0;
  var totalFee2 = 0;
  if (gSummaryPrices.plan_id[plan_id]) {
    var deviceOptionFee = 0;
    var monthlyFee = 0;
    if ((plan_id == "697" || plan_id == "698" || plan_id == "699" || plan_id == "700" || plan_id == "701" || plan_id == "702" || plan_id == "703" || plan_id == "704" || plan_id == "705" || plan_id == "706" || plan_id == "707" || plan_id == "708")) {
      totalFee = planFee + (planFee2 * month);
      totalFee2 = planFee + (planFee2 * month) + initialFee + deviceOption01_price;
      $(".campaign-period.breakdown").removeClass("hidden");
      $(".summary-text-campaign-tax-total").html(totalFee2.toLocaleString() + "<span class='plan-tax'>円</span>")
      $(".summary-text-monthly-tax-fee").html(totalFee.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".summary-text-first-month").html(planFee.toLocaleString() + "<span class='plan-tax'>円</span>");
      $(".summary-text-after-month").text(planFee2.toLocaleString() + "×" + month);
      // 内訳
      if(deviceOption01_price>0) {
        $(".breakdown-device01-option").closest('div.breakdown-list').show();
        $(".breakdown-device01-option-title").html("端末あんしんオプション");
        $(".option-text-first-month").html("<span class=\"center\">1ヶ月目</span><span><span class=\"breakdown-plan-fee\">" + planFee.toLocaleString() + "</span><span class='plan-tax'>円</span><em></em></span>");
        $(".option-text-after-month").html("<span class=\"center\">2～" + (month + 1) + "ヶ月目</span><span><span class=\"breakdown-plan-fee\">" + (deviceOption01_price / month).toLocaleString() + "</span><span class='plan-tax'>円</span><em>×" + month + "</em></span>");
        $(".breakdown-device01-option").html(deviceOption01_price / month + "<span class='plan-tax'>円</span>");
      } else {
        $(".breakdown-device01-option-title").closest('div.breakdown-list').hide();
      }
      // 内訳end
      $(".summary-text-first-month").html("<span class=\"center\">1ヶ月目</span><span><span class=\"breakdown-plan-fee\">" + planFee.toLocaleString() + "</span><span class='plan-tax'>円</span><em></em></span>");
      $(".summary-text-after-month").html("<span class=\"center\">2～" + (month + 1) + "ヶ月目</span><span><span class=\"breakdown-plan-fee\">" + planFee2.toLocaleString() + "</span><span class='plan-tax'>円</span><em>×" + month + "</em></span>");
    }
  } else {
    $(".campaign-period.breakdown").addClass("hidden");
    $(".summary-text-campaign-tax-total").html(totalFee.toLocaleString() + "<span class='plan-tax'>円</span>")
  }
  // 端末あんしんオプション
  if (gSummaryPrices.plan_id[plan_id] && gSummaryPrices.plan_id[plan_id].month == 5) {
    $('.option-anshin-bulk-5').show();
    $('.option-anshin-bulk-12').hide();
    $('.option-anshin-bulk-month-1').text('6');
    $('.option-anshin-bulk-month-2').text('5');
  } else {
    $('.option-anshin-bulk-5').hide();
    $('.option-anshin-bulk-12').show();
    $('.option-anshin-bulk-month-1').text('13');
    $('.option-anshin-bulk-month-2').text('12');
  }
  if ($("#option-checkbox-true").prop('checked') || $("#option1").prop('checked')) {
    $("#device01-option-list").show();
    $(".option-anshin-bulk-5,.option-anshin-bulk-12").addClass("selected");
  }
  $('.entry-option-left').show();
}

$(function(){
  if(window.location.pathname.includes("/entry/special/select")){
    $(".entry-option-left").click(function(){
      updateSpecialSummary();
    });

    //アラート内のボタン部分
    var optionTrue = $("input[id='option-checkbox-true']").parent(".custom-check-box-v2");
    var optionFalse = $("input[id='option-checkbox-false']").parent(".custom-check-box-v2");
    optionTrue.addClass("check-option");

    //ボタンを変更したときに、「つけない」にチェックを変えたらクラスの付与先を変更する
    $("input[name='device_option']:radio").change(function() {
      var checkVal = $(this).val();
      if(checkVal === "true"){
        optionTrue.addClass("check-option");
        optionFalse.removeClass("check-option");
      }else{
        optionTrue.removeClass("check-option");
        optionFalse.addClass("check-option");
      }
    });
  }
});

$(document).ready(function() {
  // initial calculate
  updateSummary();
  updateTelephoneSummary();
  updateCorpSummary();
  updateHikariSummary();
  updateCRSummary();
  updateTwitterCampaignSummary();
  updateOHSummary();
  updateWimaxSummary();
  updateWimaxClosedSummary();
  updateRebniseSummary();
  updateSpecialSummary();
});

// ///
// Auto input kana
// ///

$(function() {
  //name属性で判別する場合
  if (!$.fn['autoKana']) return;
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
  $.fn.autoKana('input[name="responsible_last_name"] ', 'input[name="responsible_last_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="responsible_first_name"] ', 'input[name="responsible_first_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="invoice_company_name"] ', 'input[name="invoice_company_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="invoice_last_name"] ', 'input[name="invoice_last_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="invoice_first_name"] ', 'input[name="invoice_first_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="represent_last_name"] ', 'input[name="represent_last_name_kana"]', {katakana:true});
  $.fn.autoKana('input[name="represent_first_name"] ', 'input[name="represent_first_name_kana"]', {katakana:true});
});
var opFlg;
function showOptionAlart(){
  if(window.location.pathname.includes("/entry/select")||window.location.pathname.includes("/entry/confirm")){
    if(!$("#option1").prop("checked")){
      return;
    }else{
      $("input[id='option-checkbox-true']").parent(".custom-check-box-v2").addClass("check-option");
      $("input[id='option-checkbox-false']").parent(".custom-check-box-v2").removeClass("check-option");
      $("#option-checkbox-true").prop("checked", true);
      $(".alart-notion-black-background").show();
      $("#device_option_check").show();
    }
  }else{
    if($("#device_option_false").prop("checked")){
      return;
    }else{
      $("input[id='option-checkbox-true']").parent(".custom-check-box-v2").addClass("check-option");
      $("input[id='option-checkbox-false']").parent(".custom-check-box-v2").removeClass("check-option");
      $("#option-checkbox-true").prop("checked", true);
      $(".alart-notion-black-background").show();
      $("#device_option_check").show();
    }
  }
  opFlg = "1";
}
//アラート表示

function showOption2Alart(){
  if(!($("#option2").prop("checked"))){
    $("#option2").prop("checked", true);
    $(".relief-item-select-area2").removeClass("selected");
  }else{
    $("#option2").prop("checked", false);
    $(".relief-item-select-area2").removeClass("selected");
  }
  updateSummary();
  return;
}

$(function(){
  $(".topping-2-select-area-relief-option").click(function(e){
    if ($(this).siblings("label").find("input").prop('checked')){
      if($(this).siblings("label").find("input").attr("id") === "option1"){
        showOptionAlart();
        $(".alart-popup-close-button").focus();
      }else if($(this).siblings("label").find("input").attr("id") === "option2"){
        showOption2Alart();
      }
    }else{
      $(this).addClass("selected");
      $(this).siblings("label").find("input").prop('checked', true);

      if(window.location.pathname.includes("/entry/corp/select") || window.location.pathname.includes("/entry/corp/confirm")){
        valueInheritance();
      }
      
      updateSummary();
      updateCorpSummary();
      updateRebniseSummary();
      updateTelephoneSummary();
    }
  });

  //デジタルライフサポート
  //ボタンクリックで発火
  $(".relief-item-select-area3").click(function () {
    var insuranceFlg; //チェックの判定用
    //デジタルライフサポートのチェックを外す（つけない）
    if($(this).hasClass('selected')){
      insuranceFlg = -1;

    //デジタルライフサポート プレミアム
    }else if($(this).hasClass('digital-premium')){
      insuranceFlg = 15;

    //デジタルライフサポート 通常
    }else if($(this).hasClass('digital-normal')){
      insuranceFlg = 14;
    }

    //チェックしたものによってクラス、チェック入れ替える
    switch (insuranceFlg) {
      //デジタルライフサポート プレミアム
      case 15:
        $("#option_id_insurance_5").prop("checked", false);
        $("#option_id_insurance_20").prop("checked", true);
        $("#option_id_insurance_non").prop("checked", false);
        $(".digital-normal").removeClass("selected");
        $(".digital-premium").addClass("selected");
      break;

      //デジタルライフサポート 通常
      case 14:
        $("#option_id_insurance_5").prop("checked", true);
        $("#option_id_insurance_20").prop("checked", false);
        $("#option_id_insurance_non").prop("checked", false);
        $(".digital-normal").addClass("selected");
        $(".digital-premium").removeClass("selected");
      break;

      //デジタルライフサポートのチェックを外す（つけない
      default:
        $("#option_id_insurance_5").prop("checked", false);
        $("#option_id_insurance_20").prop("checked", false);
        $("#option_id_insurance_non").prop("checked", true);
        $(".relief-item-select-area3").removeClass('selected');
      break;
    }

    //支払額に反映させる
    updateSummary();
    updateRebniseSummary();
    updateTelephoneSummary();
  });

  var document_popup = `
<div class="alart-notion-black-background"></div>
<div class="option-popup-block" id="device_option_check">
    <div class="entry-option-popup">
        <div class="background"></div>
        <div class="entry-option-popup-body">
            <div class="alart-popup-close-button js-tabindex-tanmatsu-popup" tabindex="0"><i class="fas fa-times"></i></div>
            <div class="popup-contents" tabindex="0">
                <div class="popup-wrap popup-tanmatsu-anshin popup-tanmatsu-anshin-notice">
                    <div class="popup-header">
                        <h2 class="title">本当に加入しなくて大丈夫ですか？</h2>
                        <div class="group">
                            <div class="icon"><img alt="注意のアイコン" width="70" height="70" src="https://d1q08lkutgkcx2.cloudfront.net/image/plan-opt-notice-icon.svg"></div>
                            <p class="text text-left"><strong>新規ご契約時のみ加入が可能です。</strong><br>契約後の途中加入や再加入はできません。<br>契約後はいつでもご解約いただけます。</p>
                        </div>
                    </div>
                    <div class="popup-body">
                        <div class="content-images">
                            <div class="heading">
                                <h3 class="bg-pink">こんなときに安心！</h3>
                            </div>
                            <ul class="images">
                                <li>
                                    <div class="box">
                                        <div class="img">
                                          <img alt="自然故障" width="117" height="96" src="/assets/img/icon-malfunction.svg" aria-hidden="true">
                                        </div>
                                        <p>自然故障</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="box">
                                      <div class="img">
                                        <img alt="破損" width="117" height="96" src="/assets/img/icon-corruption.svg" aria-hidden="true">
                                      </div>
                                      <p>破損</p>
                                    </div>
    
                                </li>
                                <li>
                                    <div class="box">
                                        <div class="img">
                                          <img alt="水濡れ・水没" width="117" height="96" src="/assets/img/icon-wetness.svg" aria-hidden="true">
                                        </div>
                                        <p>水濡れ</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="notice">
                            <p>端末あんしんオプションに加入すると<br>端末損害金が<span class="big">0</span><span class="red">円</span>に！</p>
                        </div>
                        <div class="notice-2">
                            <p>端末あんしんオプション未加入で破損・水没などにより、<br class="pc">端末交換を行う場合には、最大19,800円がかかります。</p>
                        </div>
                    </div>
                    <div class="popup-bottom">
                        <div class="option-check"><label class="custom-check-box-v2 js-input-radio js-tabindex-tanmatsu-popup add-tanmatsu-anshin" for="option-checkbox-true" tabindex="0">加入する<input id="option-checkbox-true" type="radio" name="device_option" value="true"><span></span></label><label class="custom-check-box-v2 js-tabindex-tanmatsu-popup" for="option-checkbox-false" tabindex="0">加入しない<input id="option-checkbox-false" type="radio" name="device_option" value="false"><span></span></label></div>
                        <div class="custom-check-box-v2 option-check btn-option-close js-tabindex-tanmatsu-popup" tanmatsu-anshin" tabindex="0">オプション選択に戻る</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
`;

  var document_popup2 = '<div class="pop-up-news white-content-box-alart-notion" id="device_option_check2"><div class="alart-popup-close-button"><i class="fas fa-times"></i></div><img src="https://d1q08lkutgkcx2.cloudfront.net/image/option-alart0-2.png" class="device-alart" width="500" height="500" alt="利用可能サービスの画像"><div class="option-check"><label class="custom-check-box-v2" for="option2-checkbox-true">加入する<input id="option2-checkbox-true" type="radio" name="device_option2" value="true"><span></span></label><label class="custom-check-box-v2" for="option2-checkbox-false">加入しない<input id="option2-checkbox-false" type="radio" name="device_option2" value="false"><span></span></label></div><div class="custom-check-box-v2 option-check btn-option-close">プラン選択に戻る</div></div>';

  if(window.location.pathname.includes("/entry/oh_specialplans/select") || window.location.pathname.includes("/entry/oh_specialplans/confirm")){
    $(".js-anshin-popup").append(document_popup + document_popup2);
  }else {
    $("body").append(document_popup + document_popup2);
  }
  
  hideOptionAlart();
  hideOption2Alart();

  //アラート内のボタン部分
  var optionTrue = $("input[id='option-checkbox-true']").parent(".custom-check-box-v2");
  var optionFalse = $("input[id='option-checkbox-false']").parent(".custom-check-box-v2");
  optionTrue.addClass("check-option");
  var option2True = $("input[id='option2-checkbox-true']").parent(".custom-check-box-v2");
  var option2False = $("input[id='option2-checkbox-false']").parent(".custom-check-box-v2");
  option2True.addClass("check-option");

  //ボタンを変更したときに、「つけない」にチェックを変えたらクラスの付与先を変更する
  $("input[name='device_option']:radio").change(function() {
      var checkVal = $(this).val();
      if(checkVal === "true"){
        optionTrue.addClass("check-option");
        optionFalse.removeClass("check-option");
      }else{
        optionTrue.removeClass("check-option");
        optionFalse.addClass("check-option");
      }
  });
  $("input[name='device_option2']:radio").change(function() {
    var checkVal2 = $(this).val();
    if(checkVal2 === "true"){
      option2True.addClass("check-option");
      option2False.removeClass("check-option");
    }else{
      option2True.removeClass("check-option");
      option2False.addClass("check-option");
    }
  });

  function hideOptionAlart(){
    $(".alart-notion-black-background").hide();
    // $(".background").hide();
    $("#device_option_check").hide();
  }
  function hideOption2Alart(){
    $(".alart-notion-black-background").hide();
    $("#device_option_check2").hide();
  }

  // STEP1/3詳細ポップアップを閉じた後にフォーカスする要素を指定する
  function focusTarget(targetClass) {
    // var attrClass = target.attr('class');
    // var targetClass = attrClass.replace(/alart-popup-close-button|js-tabindex|custom-check-box-v2|option-check|btn-option-close/g, '').trim();
    if (targetClass) {
      // 各オプションの詳細ポップアップ
      $('.relief-item-select-area-box' + ('.' + targetClass)).focus();
    } else {
      // 端末あんしんオプションポップアップ
      $('.relief-item-select-area-box.tanmatsu-anshin').focus();
    }
  }

  //アラートの確認で選択した方にチェックを入れる
  $(".alart-notion-black-background, .alart-popup-close-button, .btn-option-close, .entry-option-popup .background .js-openhouse-popup-colose, .option-popup-block#device_option_check .background").click(function(){
    var checkFalse = $("#option-checkbox-false").prop("checked");
    var checkFalse2 = $("#option2-checkbox-false").prop("checked");
    var checkOption1 = $("#option1").prop("checked");
    //URLを変数化
    var windowSelect = window.location.pathname.includes("/entry/select");
    var windowConfirm = window.location.pathname.includes("/entry/confirm");
    var windowSpecialSelect = window.location.pathname.includes("/entry/special/select");
    var windowSpecialConfirm = window.location.pathname.includes("/entry/special/confirm");
    var windowCorpSelect = window.location.pathname.includes("/entry/corp/select");
    var windowCorpConfirm = window.location.pathname.includes("/entry/corp/confirm");

    // 閉じたモーダルの判別用変数
    var attrClass = $(this).attr('class');
    var targetClass = attrClass.replace(/alart-popup-close-button|js-tabindex|custom-check-box-v2|option-check|btn-option-close/g, '').trim();

    if(windowSelect || windowConfirm ||
       windowCorpSelect ||windowCorpConfirm ||
       windowSpecialSelect||windowSpecialConfirm){
      if(opFlg === "1"){
        if(checkFalse){
          // 閉じたモーダルが「端末あんしんオプション詳細を見る」モーダル＋端末あんしんオプション選択済みの場合はreturnする
          if ((targetClass === 'tanmatsu-anshin') && checkOption1) {
            focusTarget(targetClass);
            return;
          } else {
            $("#option1").prop("checked",false);
            $(".relief-item-select-area").removeClass("selected");
          }
        }else{
          $("#option1").prop("checked",true);
          $(".relief-item-select-area").addClass("selected");
        }
        focusTarget(targetClass);
      }else{
        if(checkFalse2){
          $("#option2").prop("checked",false);
          $(".relief-item-select-area2").removeClass("selected");
        }else if (!windowSelect && !windowConfirm){
          $("#option2").prop("checked",true);
          $(".relief-item-select-area2").addClass("selected");
        }
        focusTarget(targetClass);
        checkFalse = null;
      }
    }else{
      //つけない
      if(checkFalse){
        $("#device_option_false").click();
        selectTopping2(".entry-option-right .topping-2-select-area");
        noselectTopping2(".entry-option-left .topping-2-select-area");
        //つける または何も選択しない
      }else{
        $("#device_option_true").click();
        selectTopping2(".entry-option-left .topping-2-select-area");
        noselectTopping2(".entry-option-right .topping-2-select-area");
      }
    }

    if(window.location.pathname.includes("/entry/corp/select") || window.location.pathname.includes("/entry/corp/confirm")){
      valueInheritance();
    }

    updateSummary();
    updateCorpSummary();
    hideOptionAlart();
    hideOption2Alart();
    updateRebniseSummary();
    updateSpecialSummary();
    updateTelephoneSummary();
  });
});
