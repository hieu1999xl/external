

$(function() {
  const ref = document.referrer;

  if(ref.match("/faq") || ref.match("/entry")) {

    if(ref.indexOf("?") >= 0){

      var local_search = location.search;
      var local_search_text = local_search.slice(1);
      if(ref.indexOf("ul_q=") >= 0){
        var ref_prm =ref.substring(ref.indexOf("?")+1,ref.indexOf("ul_q=")-1);
      }else{
        var ref_prm =ref.substring(ref.indexOf("?")+1,ref.length);
      }

      if (ref_prm) {
        //target_urlに'？'を含む場合
        if (local_search_text) {
          //追加パラメータの先頭文字列を'&'に置換
          if(ref.match("/entry/prepaid")) {
            let add_search_text = '';
            $.each(local_search_text.split('&'), function(index, param) {
              // 同じパラメータが存在している場合は追加しない
              if (param != '' && ref_prm.indexOf(param) == -1) {
                add_search_text = add_search_text + '&' + param;
              }
            });
            history.replaceState({}, '', '?' + ref_prm + add_search_text);
          } else {
            //追加パラメータの先頭文字列を'&'に置換
            history.replaceState({}, '', '?' + ref_prm + '&' + local_search_text);
          }
        } else {
          history.replaceState({}, '', '?' + ref_prm);
        }
      }
    }
  }
});

$(function() {
  // ギガフリープラン選択したリンクによって選択状態を変化
  const urlPams = new URLSearchParams(window.location.search);

  const linkParam = urlPams.get('link');

  const checkboxMap = {
    'link1': 'plan_f_20',
    'link2': 'plan_f_40',
    'link3': 'plan_f_100',
    'link4': 'plan_s_20',
    'link5': 'plan_s_40',
    'link6': 'plan_s_100',
  };

  if(linkParam && checkboxMap[linkParam]) {
    const checkboxId = checkboxMap[linkParam];
    if(checkboxId == "plan_f_20"){
      $("#plan_f_20").click();
    }else if(checkboxId == "plan_f_40"){
      $("#plan_f_40").click();
    }else if(checkboxId == "plan_f_100"){
      $("#plan_f_100").click();
    }else if(checkboxId == "plan_s_20"){
      $("#plan_s_20").click();
    }else if(checkboxId == "plan_s_40"){
      $("#plan_s_40").click();
    }else if(checkboxId == "plan_s_100"){
      $("#plan_s_100").click();
    }
  }
});

function currentPathIs(path) {
  // pass parameter like 'faq'
  var a = "/" + path;
  var b = "/" + path + "/";

  return [a, b, path].indexOf(location.pathname) >= 0;
}

/* Page link scroll */
function scrollToHash(target, headerSelector) {
  if(headerSelector === undefined) {
    headerSelector = "header.service-header";
  }
  var speed = 1000;
  var position = 0;
  if (!isNaN(headerSelector)) {
    position = target.offset().top + headerSelector;
  } else {
    var headerHeight = $(headerSelector).height();
    position = target.offset().top - headerHeight - 20;
  }
  $("html, body").animate({ scrollTop: position }, speed, "swing");
  return false;
}

var globalTopSelectedCountry = "asia";
$(document).ready(function() {
  /*header*/
  $(function() {
    if (currentPathIs('charm')){
      $("#header-menu-charm").addClass("header-menu-selected");
    }
    if (currentPathIs('price')){
      $("#header-menu-price").addClass("header-menu-selected");
    }
    if (currentPathIs('overseas')){
      $("#header-menu-overseas").addClass("header-menu-selected");
    }
    if (currentPathIs('device')){
      $("#header-menu-device").addClass("header-menu-selected");
    }
    if (currentPathIs('guide')){
      $("#header-menu-guide").addClass("header-menu-selected");
    }
    if (currentPathIs('faq')){
      $("#header-menu-faq").addClass("header-menu-selected");
    }
  });

  /*支払い方法により表示を変える */
    function togglePaymentMethod() {
    var selected_value = $(
      'select[id="payment-system"] option:selected'
    ).val();
    if (selected_value) {
      if (selected_value == "1") {
        $(".credit_card_input").css("display", "");
        $(".invoice_input").css("display", "none");
      } else if (selected_value == "3") {
        $(".credit_card_input").css("display", "none");
        $(".invoice_input").css("display", "");
      } else {
        $(".invoice_input").css("display", "");
      }
    }
  }
  $(function() {
    togglePaymentMethod();
    $('select[id="payment-system"]').change(function() {
      togglePaymentMethod();
    });
  });

  /*支払い方法により表示を変える */
  function toogleRegisterPaymentMethod() {
    var selected_value = $(
        'select[name="payment_method"] option:selected'
    ).val();
    if (selected_value) {
      $("#payment-method-invoice").css("display", "none");
      if (selected_value == "1") {
        $("#payment-method-account-transfer").css("display", "none");
        $("#payment-method-creditcard").css("display", "");
        $("#payment-method-creditcard tr").css("display", "");

        $("#editpayment_button_credit").removeClass("editpayment-button-hidden");
        $("#editpayment_button_atone").addClass("editpayment-button-hidden");
        $("#payment_method_tr").removeClass("payment_atone");

        $(".payment-select-caution-hidden").css("display", "");

      } else if (selected_value == "2") {
        $("#payment-method-creditcard").css("display", "none");
        $("#payment-method-account-transfer").css("display", "");
      } else if (selected_value == "3") {  // 請求書
        $("#payment-method-creditcard").css("display", "none");
        $("#payment-method-invoice").css("display", "");
        $("#payment-method-account-transfer").css("display", "");
      } else if (selected_value == "5") {  // atone
        $("#payment-method-creditcard tr").css("display", "none");
        $("#payment_method_tr").css("display", "");
        $("#payment_method_tr").addClass("payment_atone");

        $("#editpayment_button_credit").addClass("editpayment-button-hidden");
        $("#editpayment_button_atone").removeClass("editpayment-button-hidden");

        $(".payment-select-caution-hidden").css("display", "none");

      } else {
        $("#payment-method-creditcard").css("display", "none");
        $("#payment-method-account-transfer").css("display", "none");
      }
    }
  }

  $(function() {
    toogleRegisterPaymentMethod();
    $('select[name="payment_method"]').change(function() {
      toogleRegisterPaymentMethod();
    });
  });

 /*利用者情報により表示を変える */
  function toggleUserInfoDetail() {
    var selected_value = $('input[name="user_info"]:checked').val();
    if (selected_value == "1") {
      $(".mypage-user-info-detail").addClass("mypage-user-info-detail-hidden");
     $(".delivery-address-change").hide();
      if(window.location.pathname.includes("/entry/user") || window.location.pathname.includes("/entry/prepaid/user") ){
        $(".mypage-address-info").addClass("not-inputted-items-hidden");
        $("#delivery_info_same").prop("checked",true);
        toggleDeliveryInfoDetail();
      }
      if(window.location.pathname.includes("/entry/oh_specialplans/user")){ // add oh_specialplans
        $(".mypage-address-info").addClass("not-inputted-items-hidden");
        $("#delivery_info_same").prop("checked",true);
        toggleDeliveryInfoDetail();
      }
    } else if (selected_value == "2") {
      $(".mypage-user-info-detail").removeClass("mypage-user-info-detail-hidden");
     $(".delivery-address-change").show();
      if(window.location.pathname.includes("/entry/user") || window.location.pathname.includes("/entry/prepaid/user") ){
        $(".mypage-address-info").removeClass("not-inputted-items-hidden");
      }
      if(window.location.pathname.includes("/entry/oh_specialplans/user")){ // add oh_specialplans
        $(".mypage-address-info").removeClass("not-inputted-items-hidden");
      }
    }
  }
  $(function() {
    toggleUserInfoDetail();
    $('input[name="user_info"]').change(function() {
      toggleUserInfoDetail();
    });
  });

  function toggleCorpContactDetail() {
    var selected_value = $('input[name="corp_contact_info"]:checked').val();
    if (selected_value == "2") {
      $(".mypage-user-info-detail").removeClass("mypage-user-info-detail-hidden")
    } else if (selected_value == "1") {
      $(".mypage-user-info-detail").addClass("mypage-user-info-detail-hidden");
    }
  }
  $(function() {
    toggleCorpContactDetail();
    $('input[name="corp_contact_info"]').change(function() {
      toggleCorpContactDetail();
    });
  });

  /*法人支払い情報により表示を変える */
  function toggleCorpPaymentInfoDetail() {
    var selected_value = $('input[name="corp_payment_info"]:checked').val();
    if (selected_value == "1") {
      $(".corp-payment-info-detail").addClass(
        "corp-payment-info-detail-hidden"
      );
    } else if (selected_value == "2") {
      $(".corp-payment-info-detail").removeClass(
        "corp-payment-info-detail-hidden"
      );
    }
  }
  $(function() {
    toggleCorpPaymentInfoDetail();
    $('input[name="corp_payment_info"]').change(function() {
      toggleCorpPaymentInfoDetail();
    });
  });

  /*配送先情報により表示を変える */
  function toggleDeliveryInfoDetail() {
    var selected_value = $('input[name="delivery_info"]:checked').val();
    if(window.location.pathname.includes("/entry/user") || window.location.pathname.includes("/entry/prepaid/user") ){
      if(selected_value){
        $(".mypage-delivery-info").removeClass("not-inputted-items-hidden");
      }
    }
    if(window.location.pathname.includes("/entry/oh_specialplans/user")){ // add oh_specialplans
      if(selected_value){
        $(".mypage-delivery-info").removeClass("not-inputted-items-hidden");
      }
    }
    if (selected_value == "1"||$('#delivery_info_different2:checked').val() == "2") {
      $(".mypage-delivery-info-detail").addClass(
        "mypage-delivery-info-detail-hidden"
      );
    } else if (selected_value == "2" && !window.location.pathname.includes("/entry/special/confirm")) {
      $(".mypage-delivery-info-detail").removeClass(
        "mypage-delivery-info-detail-hidden"
      );
    }
  }
  $(function() {
    toggleDeliveryInfoDetail();
    $('input[name="delivery_info"]').change(function() {
      toggleDeliveryInfoDetail();
    });
  });

  $(function() {
    function toggleDeliveryTime() {
      var selected_value = $('select[name="delivery_order_time"]').val();
      if(selected_value){
        $(".mypage-password-info").removeClass("not-inputted-items-hidden");
      }
    }
    toggleDeliveryTime();
    $('select[name="delivery_order_time"]').change(function() {
      toggleDeliveryTime();
    });
  });

  /*配送先情報により表示を変える */
  function toggleCorpDeliveryInfoDetail() {
    var selected_value = $('input[name="deliverycorp_info"]:checked').val();
    if (selected_value == "1") {
      $(".mypage-delivery-info-detail").addClass(
        "mypage-delivery-info-detail-hidden"
      );
    } else if (selected_value == "2") {
      $(".mypage-delivery-info-detail").removeClass(
        "mypage-delivery-info-detail-hidden"
      );
    }
  }
  $(function() {
    toggleCorpDeliveryInfoDetail();
    $('input[name="deliverycorp_info"]').change(function() {
      toggleCorpDeliveryInfoDetail();
    });
  });

  /* 端末IDにより表示変える */
  function toggleContract() {
    var selected_value = $(
      'select[name="mypage-contract-select"] option:selected'
    ).val();
    $("div.mypage-contract-wrapper").addClass("mypage-contract-wrapper-hidden");
    $("div#" + selected_value).removeClass("mypage-contract-wrapper-hidden");
  }

  $(function() {
    toggleContract();
    $('select[name="mypage-contract-select"]').change(function() {
      toggleContract();
    });
  });


  /* payment history 年により表示を切り替える */
  function togglePaymentHistory() {
    var selected_value = $(
      'select[name="mypage-payment-history-select"] option:selected'
    ).val();
    $("div.mypage-payment-history-wrapper").addClass("mypage-payment-history-wrapper-hidden");
    $("div#" + selected_value).removeClass("mypage-payment-history-wrapper-hidden");
  }

  $(function() {
    togglePaymentHistory();
    $('select[name="mypage-payment-history-select"]').change(function() {
      togglePaymentHistory();
    });
  });

  /* data flow 年により表示を切り替える */
  function toggleDataFlow() {
    var selected_value = $(
      'select[name="mypage-data-flow-select"] option:selected'
    ).val();
    $("div.mypage-data-flow-wrapper").addClass("mypage-data-flow-wrapper-hidden");
    $("div#" + selected_value).removeClass("mypage-data-flow-wrapper-hidden");
  }

  $(function() {
    toggleDataFlow();
    $('select[name="mypage-data-flow-select"]').change(function() {
      toggleDataFlow();
    });
  });

  // plan-selectでBoxクリック
  $(function() {
    var $trList = $("tr.plan-selection-row:has(input)"); //trでinputタグをもつものを取得
    $trList.each(function() {
      //取得したtrタグそれぞれに処理を行う
      var $input = $(this).find("input"); //trからinputタグを取得しておく。
      $(this).click(function() {
        $input.prop("checked", true);
        var $trList2 = $("tr.plan-selection-row:has(input)"); //trでinputタグをもつものを取得
        $trList2.each(function() {
          //取得したtrタグそれぞれに処理を行う
          $(this).removeClass("selected-row");
        });
        $(this).addClass("selected-row");
      });
    });
  });

  // option-selectでBoxクリック
  $(function() {
    var $trList = $("tr.option-selection-row:has(input)"); //trでinputタグをもつものを取得
    $trList.each(function() {
      //取得したtrタグそれぞれに処理を行う
      var $input = $(this).find("input"); //trからinputタグを取得しておく。
      $(this).click(function() {
        if ($input.prop("checked")) {
          $input.prop("checked", false);
          $(this).removeClass("selected-row");
        } else {
          $input.prop("checked", true);
          $(this).addClass("selected-row");
        }
      });
    });
  });

  // https://teratail.com/questions/104712
  $(document).on("mouseover", function(event) {
    let target = $(event.target);
    let related = target.closest("[data-related]");
    let menu = related.length
      ? $(related.attr("data-related"))[0]
      : target.closest(".sub-menu")[0];
    $(".sub-menu").each(function(index, element) {
      $(element).toggleClass("sub-menu-visible", element === menu);
    });
  });

  $("select#plan-option").change(function() {
    var planName = $("select#plan-option option:selected").text();
    $("p.popup-kaigai-text").text(planName);
  });
  // Toggle submit button everty time key up

  function resetUserFormSubmitButton(){
    $("div.form-entry-user-invalid-box").addClass("box-hidden");
    $("div.form-entry-user-submit").removeClass("box-hidden");
  }
  $(function() {
    $(".entry-form input[type='text']").keyup(function() {
      resetUserFormSubmitButton();
    });
    $(".entry-form input[type='password']").keyup(function() {
      resetUserFormSubmitButton();
    });
    $(".entry-form input[type='email']").keyup(function() {
      resetUserFormSubmitButton();
    });
    $(".entry-form input").change(function() {
      resetUserFormSubmitButton();
    });
    $(".entry-form select").change(function() {
      resetUserFormSubmitButton();
    });
    $("input.validate-user-info").change(function() {
      resetUserFormSubmitButton();
    });
  });

  // leave-checkboxチェックボックス
  $(function() {
    var isPage = location.pathname.indexOf("/entry/prepaid/confirm") === 0;
    if(isPage){
      // Not options page
      return;
    }

    $("input#leave-checkbox").change(function() {
      var checked = $(this).prop("checked");
      if (checked) {
        $("div#entry_user_submit").removeClass(
          "decoration-button-area-disabled"
        );
        $("input#button-submit").removeAttr("disabled");
      } else {
        $("div#entry_user_submit").addClass("decoration-button-area-disabled");
        $("input#button-submit").attr("disabled", "disabled");
      }
    });
  });


  // LP FAQ collapse
  function toggleFaqTitle(elem) {
    // mypage-faq-answer
    var next = $(elem).next();
    if($(".lp-faq-contents-v2").length > 0){
      // When FAQ v2
      var faqArrowOpenImage = "https://d1q08lkutgkcx2.cloudfront.net/image/faq-arrow-open.svg";
      var faqArrowCloseImage = "https://d1q08lkutgkcx2.cloudfront.net/image/faq-arrow-close.svg";

      var faqQuestionIconOpenImage = "https://d1q08lkutgkcx2.cloudfront.net/image/faq-q-white.svg";
      var faqQuestionIconCloseImage = "https://d1q08lkutgkcx2.cloudfront.net/image/faq-q-black.svg";

    }

    if (next.hasClass("lp-faq-answer-hidden")) {
      next.removeClass("lp-faq-answer-hidden");
      $(elem).addClass("lp-faq-question-open");

      // Arrow
      $(elem)
        .find("span.lp-faq-question-label")
        .find("img")
        .attr("src", faqArrowOpenImage);
      // Icon
      $(elem)
        .find("img.faq-question-icon")
        .attr("src", faqQuestionIconOpenImage);

    } else {
      next.addClass("lp-faq-answer-hidden");
      $(elem).removeClass("lp-faq-question-open");
      // Arrow
      $(elem)
        .find("span.lp-faq-question-label ")
        .find("img")
        .attr("src",faqArrowCloseImage);
      // Icon
      $(elem)
        .find("img.faq-question-icon")
        .attr("src", faqQuestionIconCloseImage);
    }
  }

  $(function() {
    $("h2.lp-faq-question").click(function() {
      toggleFaqTitle(this);
    });
  });

  // TOP FAQ category collapse
  function toggleFaqCategory(elem) {
    $("div.faq-category-area").removeClass("faq-category-area-active");
    $("div.faq-category-box").removeClass("faq-category-box-selected");
    $(elem).addClass("faq-category-box-selected");
    $("div.faq-category-area").addClass("faq-category-area-hidden");
    var category = $(elem).attr("category");
    var _selector = "div#faq-category-" + category;
    $(_selector).removeClass("faq-category-area-hidden");
    $(_selector).addClass("faq-category-area-active");
  }

  //FAQ category collapse
  function toggleFaqCategoryTopV2(elem) {
    $("div.white-content-box-faq-v2").removeClass("active");
    $("div.white-content-box-faq-v2").addClass("inactive");
    var section = $(elem).attr("section");
    var _selector = "#" + section;
    $(_selector).removeClass("inactive");
    $(_selector).addClass("active");
    console.log(elem);
    $(".faq-category-box").removeClass("faq-category-box-selected");
    $(elem).addClass("faq-category-box-selected");

  }

  function faqScrollToHash() {
    if (!currentPathIs('faq') && !currentPathIs('mypage/support') && !currentPathIs('corpmypage/support')){
      return;
    }
    var urlHash = location.hash;
    if (!urlHash) {
      return;
    }
    var title = null;
    if (urlHash.indexOf(".") > -1) {
      var elems = urlHash.split(".");
      urlHash = elems[0];
      title = elems[1];
    }
    var category = urlHash.replace("#faq-category-", "");
    var target = $("div.faq-category-box").attr("category", category)[0];
    toggleFaqCategory(target);
    if (title) {
      var selector = "#" + title;
      var target = $(selector);
      if (!target) {
        return;
      }
      toggleFaqOpenShut(target, true);
      // scroll
      $("body,html")
        .stop()
        .scrollTop(0);
      scrollToHash(target, (currentPathIs('mypage/support') || currentPathIs('corpmypage/support')) ? 0 : undefined);
    }
  }

  $(function() {
    faqScrollToHash();
  });

  $('.content-box a').on('click', function () {
    var href = $(this).attr('href');
    var hash = href.substring(href.indexOf('#'));
    if (location.hash.match(hash)) {
      var target = $(hash.split('#')[1].split('.')[1]);
      faqScrollToHash(target, true);
    }
  });

  window.addEventListener("hashchange", function() {
    faqScrollToHash();
  });

  $(function() {
    $("div.faq-category-box").click(function() {
      toggleFaqCategory(this);
    });
  });

  $(function() {
    $("div.lp-limited-plan div.faq-category-box").click(function() {
      toggleFaqCategory(this);
    });
    $("div.top-faq-v2-categories div.faq-category-box").click(function() {
      toggleFaqCategoryTopV2(this);
    });
  });

  // TOP overseas category collapse
  $(function() {
    $("div.overseas-category-box").click(function() {
      $("div.overseas-category-box").removeClass(
        "overseas-category-box-selected"
      );
      $(this).addClass("overseas-category-box-selected");
      $("div.overseas-category-area").addClass("overseas-category-area-hidden");
      var category = $(this).attr("category");
      globalTopSelectedCountry = category;
      var _selector = "div#overseas-category-" + category;
      $(_selector).removeClass("overseas-category-area-hidden");
    });
  });

  // TOP overseas plan select (SP)
  $(function() {
    $("select.overseas-plan-select-sp").on("change", function() {
      var $this = $(this);
      var $option = $this.find("option:selected");
      var elems = $option.text().split(" ");
      var _day = elems[1];
      var _size = elems[0];
      var _html =
        `<span class="overseas-table-th-large">${_size}</span>
        <span class="overseas-table-th-lighter">${_day}</span>`;
      $("div.overseas-plan-select-sp-div p.label").html(_html);

      var selectedPlan = ".plan-" + $option.val();
      $(".plan-300m").addClass("overseas-table-unselected");
      $(".plan-1g").addClass("overseas-table-unselected");
      $(".plan-3g").addClass("overseas-table-unselected");
      $(selectedPlan).removeClass("overseas-table-unselected");
    });
  });

  // Swiper
  // https://haniwaman.com/swiper/#i-8
  $(function() {
    // In mypage and forms, if Swiper is not defined, return.
    if (typeof Swiper !== "function") {
      return;

    }else{
      // Device page

      //initialize swiper when document ready
      var mySwiper = new Swiper(".swiper-container", {
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
        },
        loop: true,
        speed: 1000,
        autoHeight: true,
        autoplay:
          window.location.pathname.includes('/device')
            ? false
            : {
                delay: 3000,
                disableOnInteraction: true
              },
        pagination: {
          el: ".swiper-my-pagination",
          clickable: true,
          renderBullet: function(index, className) {
            return (
              '<span class="' +
              className +
              '">' +
              '<img src="https://d1q08lkutgkcx2.cloudfront.net/image/terminal-' +
              (index + 1) +
              '-thum_t.png" alt="">' +
              "</span>"
            );
          }
        }
      });
    }
  });
});

/**
 * 確認ダイアログを表示します。
 * @param  {String} message ダイアログに表示するメッセージ
 * @param  {Function} [okFunction] OKボタンクリック時に実行される関数
 * @param  {Function} [cancelFunction] Cancelボタンクリック時に実行される関数
 */
function showConfirmDialog(
  message,
  okFunction,
  cancelFunction,
  submitText,
  title,
  dialogClassLeft,
  dialogClassRight
) {
  // Dialogを破棄する関数
  var _destroyDialog = function(dialogElement) {
    dialogElement.dialog("destroy"); // ※destroyなので、closeイベントは発生しない
    dialogElement.remove(); // ※動的に生成された要素を削除する必要がある
  };

  // Dialog要素(呼び出し毎に、動的に生成)
  var $dialog = $("<div></div>").html(message);

  // 各ボタンに対応する関数を宣言
  // ※Dialogを破棄後、コールバック関数を実行する
  var _funcOk = function() {
    _destroyDialog($dialog);
    if (okFunction) {
      okFunction();
    }
  };
  var _funcCancel = function() {
    _destroyDialog($dialog);
    if (cancelFunction) {
      cancelFunction();
    }
  };
  $dialog.dialog({
    title: "",
    width: "80%",
    dialogClass: "mypage-confirm-dialog",
    closeText: "キャンセル",
    closeOnEscape: true,
    close: _funcCancel,
    modal: true,
    title: title,
    // 各ボタンの設定
    buttons: [
      {
        text: "キャンセル",
        class: dialogClassLeft,
        click: function() {
          $(this).dialog("close");
        }
      },
      { text: submitText, class: dialogClassRight, click: _funcOk }
    ]
  });
}

function executeTask() {
  $("form").submit();
}

// Cancelで実行する処理
function cancelTask() {}

function confirm(
  submitText,
  title,
  dialogClassLeft,
  dialogClassRight,
  textClass,
  formId
) {
  if (textClass === undefined) {
    textClass = ".cancel-popup";
  }

  // 法人は除く（アンケートが必要な個人のみ適用）
  if(!window.location.pathname.includes("/corpmypage")){
    /* special cases*/
    var leaveCheckedExist = $("input#cancel-contract-checkbox").val();
    if(leaveCheckedExist){
      var leaveChecked = $("input#cancel-contract-checkbox").prop("checked");
      var checks = document.getElementsByClassName("leave-survey-answer-checkbox");
      var checkReason;
      for ( i = 0; i < 10; i++) {
        if ( checks[i].checked === true ) {
          checkReason += checks[i].value + " ";
        }
      }
      var passwordText = $("input#leave-password").val();
      if ((leaveCheckedExist && !leaveChecked) || !checkReason || !passwordText) {
        return;
      }
      if ($('.validator-error-data-charge').length) {
        return;
      }
      // パスワードの桁数が8桁未満 or 16桁以上だった場合returnさせる
      if (passwordText.length < 8 || passwordText.length > 16) {
        return;
      }
    }
  }

  var execFunc = function() {
    $("form").submit();
  };
  if (formId !== undefined) {
    execFunc = function() {
      $("form#" + formId).submit();
    };
  }

  var text = $(textClass).html();
  showConfirmDialog(
    text,
    execFunc,
    cancelTask,
    submitText,
    title,
    dialogClassLeft,
    dialogClassRight
  );
}



function formNameToString(name){
  var hash = {
    "last_name": "*氏名を入力してください。",
    "first_name": "*氏名を入力してください。",
    "representative_last_name": "*氏名を入力してください。",
    "representative_first_name": "*氏名を入力してください。",
    "last_name_kana": "*氏名（カナ）を入力してください。",
    "first_name_kana": "*氏名（カナ）を入力してください。",
    "representative_last_name_kana": "*氏名（カナ）を入力してください。",
    "representative_first_name_kana": "*氏名（カナ）を入力してください。",
    "sex": "*性別を選択してください。",
    "birthday_year": "*生年月日を選択してください。",
    "birthday_month": "*生年月日を選択してください。",
    "birthday_day": "*生年月日を選択してください。",
    "tel1_1": "*電話番号を入力してください。",
    "tel1_2": "*電話番号を入力してください。",
    "tel1_3": "*電話番号を入力してください。",
    "representative_tel1_1": "*電話番号を入力してください。",
    "representative_tel1_2": "*電話番号を入力してください。",
    "representative_tel1_3": "*電話番号を入力してください。",
    "email": "*メールアドレスを入力してください。",
    "email_conf": "*メールアドレス（確認用）を入力してください。",
    "email_confirm": "*メールアドレス（確認用）を入力してください。",

    // address
    "zipcode_1": "*郵便番号を入力してください。",
    "zipcode_2": "*郵便番号を入力してください。",
    "prefecture": "*都道府県を選択してください。",
    "city": "*市区郡を入力してください。",
    "town": "*町名を入力してください。",
    "block": "*番地を入力してください。",
    "room_number": "*部屋番号を入力してください。",

    // user
    "user_info": "*ご利用者様情報を選択してください。",
    "user_last_name": "*氏名を入力してください。",
    "user_first_name": "*氏名を入力してください。",
    "user_last_name_kana": "*氏名（カナ）を入力してください。",
    "user_first_name_kana": "*氏名（カナ）を入力してください。",
    "user_tel1_1": "*電話番号を入力してください。",
    "user_tel1_2": "*電話番号を入力してください。",
    "user_tel1_3": "*電話番号を入力してください。",
    "user_zipcode_1": "*郵便番号を入力してください。",
    "user_zipcode_2": "*郵便番号を入力してください。",
    "user_prefecture": "*都道府県を選択してください。",
    "user_city": "*市区郡を入力してください。",
    "user_town": "*町名を入力してください。",
    "user_block": "*番地を入力してください。",
    "user_room_number": "*部屋番号を入力してください。",

    // delivery
    "delivery_info": "*配送先情報を選択してください",
    "delivery_last_name": "*氏名を入力してください。",
    "delivery_first_name": "*氏名を入力してください。",
    "delivery_last_name_kana": "*氏名（カナ）を入力してください。",
    "delivery_first_name_kana": "*氏名（カナ）を入力してください。",
    "delivery_tel1_1": "*電話番号を入力してください。",
    "delivery_tel1_2": "*電話番号を入力してください。",
    "delivery_tel1_3": "*電話番号を入力してください。",
    "delivery_zipcode_1": "*郵便番号を入力してください。",
    "delivery_zipcode_2": "*郵便番号を入力してください。",
    "delivery_prefecture": "*都道府県を選択してください。",
    "delivery_city": "*市区郡を入力してください。",
    "delivery_town": "*町名を入力してください。",
    "delivery_block": "*番地を入力してください。",
    "delivery_room_number": "*部屋番号を入力してください。",
    "delivery_order_time": "*配送時間を選択してください。",

    //corp info
    "corp_company_name": "*法人名（漢字）を入力してください。",
    "corp_company_name_kana" : "*法人名（カナ）を入力してください。",
    "corp_last_name" : "*代表者名（漢字）を入力してください。",
    "corp_first_name" : "*代表者名（漢字）を入力してください。",
    "corp_last_name_kana" : "*代表者名（カナ）を入力してください。",
    "corp_first_name_kana" : "*代表者名（カナ）を入力してください。",
    "company_hp_url" : "*会社ホームページURLを入力してください。",
    "corp_tel1_1" : "*代表電話番号を入力してください。",
    "corp_tel1_2" : "*代表電話番号を入力してください。",
    "corp_tel1_3" : "*代表電話番号を入力してください。",
    "responsible_last_name" : "*担当者名（漢字）を入力してください。",
    "responsible_first_name" : "*担当者名（漢字）を入力してください。",
    "responsible_last_name_kana" : "*担当者名（カナ）を入力してください。",
    "responsible_first_name_kana" : "*担当者名（カナ）を入力してください。",
    "corp_tel2_1" : "*担当者電話番号を入力してください。",
    "corp_tel2_2" : "*担当者電話番号を入力してください。",
    "corp_tel2_3" : "*担当者電話番号を入力してください。",
    "responsible_tel1_1" : "*担当者電話番号を入力してください。",
    "responsible_tel1_2" : "*担当者電話番号を入力してください。",
    "responsible_tel1_3" : "*担当者電話番号を入力してください。",
    "corp_email" : "*メールアドレス を入力してください。",
    "corp_email_conf" : "*メールアドレス（確認用）を入力してください。",
    "corp_password" : "*パスワードを入力してください。",
    "corp_password_confirm" : "*パスワード（確認用）を入力してください。",

    //corp_address
    "add_corp_zipcode1": "*郵便番号を入力してください。",
    "add_corp_zipcode2": "*郵便番号を入力してください。",
    "add_corp_prefecture": "*都道府県を選択してください。",
    "add_corp_city": "*市区郡を入力してください。",
    "add_corp_town": "*町名を入力してください。",
    "add_corp_block": "*番地を入力してください。",

    //corp_delivery
    "deliverycorp_info": "*配送先情報を選択してください。",
    "deliverycorp_last_name": "*担当者名（漢字）を入力してください。",
    "deliverycorp_first_name": "*担当者名（漢字）を入力してください。",
    "deliverycorp_last_name_kana": "*担当者名（カナ）を入力してください。",
    "deliverycorp_first_name_kana": "*担当者名（カナ）を入力してください。",
    "deliverycorp_tel1_1": "*担当者電話番号を入力してください。",
    "deliverycorp_tel1_2": "*担当者電話番号を入力してください。",
    "deliverycorp_tel1_3": "*担当者電話番号を入力してください。",
    "deliverycorp_zipcode_1": "*郵便番号を入力してください。",
    "deliverycorp_zipcode_2": "*郵便番号を入力してください。",
    "deliverycorp_prefecture": "*都道府県を選択してください。",
    "deliverycorp_city": "*市区郡を入力してください。",
    "deliverycorp_town": "*町名を入力してください。",
    "deliverycorp_block": "*番地を入力してください。",
    "deliverycorp_order_time": "*配送時間を選択してください。",

    //corp contact
    "corp_contact_info": "*請求先情報を選択してください。",
    "invoice_company_name" : "*法人名（漢字）を入力してください。",
    "invoice_company_name_kana" : "*法人名（カナ）を入力してください。",
    "invoice_department_name" : "*部署名を入力してください。",
    "invoice_last_name" : "*担当者名（漢字）を入力してください。",
    "invoice_first_name" : "*担当者名（漢字）を入力してください。",
    "invoice_last_name_kana" : "*担当者名（カナ）を入力してください。",
    "invoice_first_name_kana" : "*担当者名（カナ）を入力してください。",
    "invoice_tel1_1" : "*担当者電話番号を入力してください。",
    "invoice_tel1_2" : "*担当者電話番号を入力してください。",
    "invoice_tel1_3" : "*担当者電話番号を入力してください。",
    "invoice_email" : "*メールアドレス を入力してください。",
    "invoice_email_conf" : "*メールアドレス（確認用）を入力してください。",

    //corp_user
    "payment_method":"*支払い方法を選択してください。",
    "holdername":"*カード名義を入力してください。",
    "cardno":"*カード番号を入力してください。",
    "expire_month":"*カード有効期限の月を選択してください。",
    "expire_year":"*カード有効期限の年を選択してください。",
    "securitycode":"*セキュリティコードを入力してください。",
    "contact_company":"*会社名を入力してください。",
    "contact_last_name":"*氏名を入力してください。",
    "contact_first_name":"*氏名を入力してください。",
    "contact_email_address":"*メールアドレスを入力してください。",
    "contact_email_address_conf":"*メールアドレス（確認用）を入力してください。",
    "corporate_checkbox":"*請求書送付先を選択してください。",
    "payment_due_date_type":"*支払いサイクルを選択してください。",

    // Password
    "password": "*パスワードを入力してください。",
    "password_confirm": "*パスワード（確認用）を入力してください。",
  };
  return hash[name];
}

//支払い方法選択
function toggleUserPayment() {
  var selected_value = $('input[name="settlement_type"]:checked').val();
  //クレカ(SETTLEMENT_TYPE_VALUE_LIST[CREDIT_CARD])
  if (selected_value == "1") {
    $("#payment_select_creditcard").removeClass("mypage-user-info-detail-hidden");
    $("#payment_select_postpay").addClass("mypage-user-info-detail-hidden");
    $(".form-entry-user-submit-creditcard").css('display','block');
    $(".form-entry-user-submit-postpay").css('display','none');
    $("#payment_deferred_attention").hide();
  //atone(SETTLEMENT_TYPE_VALUE_LIST[ATONE])
  } else if (selected_value == "5") {
    $("#payment_select_creditcard").addClass("mypage-user-info-detail-hidden");
    $("#payment_select_postpay").removeClass("mypage-user-info-detail-hidden");
    $(".form-entry-user-submit-creditcard").css('display','none');
    $(".form-entry-user-submit-postpay").css('display','block');
    if (window.location.pathname.includes("entry/telephone/payment/draft/")) {
      $("#payment_deferred_attention").show().html('<span>atone 翌月払い（コンビニ/口座振替）ご選択時の注意事項</span><span>・atoneへお支払いいただく請求手数料として、190円(209円税込)がかかります。口座振替の場合は無料です。</span><span>・支払い方法で「atone 翌月払い」を選択された場合、データチャージ・海外データプランのご利用はできません。</span><br><span>※atone支払の場合、一度契約事務手数料の請求が発生しますが、翌営業日に請求キャンセルいたします。</span>');
    } else {
      $("#payment_deferred_attention").show().html('<span>atone 翌月払い（コンビニ/口座振替）ご選択時の注意事項</span><span>・atoneへお支払いいただく請求手数料として、190円(209円税込)がかかります。口座振替の場合は無料です。</span><span>・支払い方法で「atone 翌月払い」を選択された場合、データチャージ・海外データプランのご利用はできません。</span>');
    }
  }
}
$(function() {
  toggleUserPayment();
  $('input[name="settlement_type"]').change(function() {
    toggleUserPayment();
  });
});
+
function putFailedItem(counter, klass, name){
  var targetItemList;
  if(klass.indexOf("form-item-contractor") > -1){
    targetItemList = counter["form-item-contractor"];
  }else if(klass.indexOf("form-item-user-info") > -1){
    targetItemList = counter["form-item-user-info"];
  }else if(klass.indexOf("form-item-address") > -1){
    targetItemList = counter["form-item-address"];
  }else if(klass.indexOf("form-item-user") > -1){
    targetItemList = counter["form-item-user"];
  }else if(klass.indexOf("form-item-delivery") > -1){
    targetItemList = counter["form-item-delivery-info"]
  }else if(klass.indexOf("form-item-delivery-info") > -1){
    targetItemList = counter["form-item-delivery"]
  }else if(klass.indexOf("form-item-delivery-time") > -1){
    targetItemList = counter["form-item-delivery-time"]
  }else if(klass.indexOf("form-item-corp-info") > -1){
    targetItemList = counter["form-item-corp-info"];
  }else if(klass.indexOf("form-item-corp-address") > -1){
    targetItemList = counter["form-item-corp-address"]
  }else if(klass.indexOf("form-item-delivery-corp") > -1){
    targetItemList = counter["form-item-delivery-corp"]
  }else if(klass.indexOf("form-item-corp-contact") > -1){
    targetItemList = counter["form-item-corp-contact"]
  }else if(klass.indexOf("form-item-corp-mail") > -1){
    targetItemList = counter["form-item-corp-mail"]
  }else if(klass.indexOf("form-item-password") > -1){
    targetItemList = counter["form-item-password"]
  }else if(klass.indexOf("form-item-corp-card") > -1){
    targetItemList = counter["form-item-corp-card"]
  } else if(klass.indexOf("form-item-corp-invoice") > -1){
    targetItemList = counter["form-item-corp-invoice"]
  } else if(klass.indexOf("form-item-corp-email-address") > -1){
    targetItemList = counter["form-item-corp-email-address"]
  }else{
    return;
  }//
  targetItemList.push(name)
};

// Validates user form
// Called from val.js
function validateUserForm(formId, invalidItems) {
  names = Object.keys(invalidItems);

  if(formId !== "entry-user-form" && formId !== "entry-payment-form" && formId !== "entry-corp-user-form" && formId !== "entry-corp-form"){
    return;
  }

  if (names.length == 0) {
    $("div.form-entry-user-invalid-box").addClass("box-hidden");
    $("div.form-entry-user-submit").removeClass("box-hidden");
    $("div.form-entry-user-submit").removeClass("decoration-button-area-disabled");
    return;
  }

  var failedItemCounter = {
    "form-item-contractor": [],
    "form-item-user-info": [],
    "form-item-address": [],
    "form-item-user": [],
    "form-item-delivery-info": [],
    "form-item-delivery": [],
    "form-item-delivery-time": [],
    "form-item-corp-mail":[],
    "form-item-password": [],
    "form-item-corp-info" : [],
    "form-item-corp-address":[],
    "form-item-delivery-corp":[],
    "form-item-corp-contact" :[],
    "form-item-corp-card":[],
    "form-item-corp-invoice":[],
    "form-item-corp-email-address":[],
  };

  names.forEach(function(name){
    if(name.indexOf("user_info") == 0){
      failedItemCounter["form-item-user-info"].push(name);
    }else if(name.indexOf("user_") == 0){
      failedItemCounter["form-item-user"].push(name);
    }else if(name.indexOf("delivery_info") == 0){
      failedItemCounter["form-item-delivery-info"].push(name);
    }else if(name.indexOf("delivery_order_time") == 0){
      if(window.location.pathname.includes("/entry/user") || window.location.pathname.includes("/entry/prepaid/user")){
        failedItemCounter["form-item-delivery-time"].push(name);
      }else if(window.location.pathname.includes("/entry/oh_specialplans/user")){ // add oh_specialplans
        failedItemCounter["form-item-delivery-time"].push(name);
      }else{
        failedItemCounter["form-item-delivery"].push(name);
      }
    }else if(name.indexOf("delivery_") == 0){
      failedItemCounter["form-item-delivery"].push(name);
    }else if(name.indexOf("invoice_") == 0 || name == 'corp_contact_info'){  // 請求先情報選択も請求先情報の配列に受け入れる ←TODO:corp_contact_infoの物理名を修正
      failedItemCounter["form-item-corp-contact"].push(name);
    }else if(name.indexOf("corp_") == 0 && name != 'corp_contact_info'){     // 請求先情報選択はご契約法人情報の配列から除く ←TODO:corp_contact_infoの物理名を修正
      failedItemCounter["form-item-corp-info"].push(name);
    }else if(name.indexOf("company_hp_url") == 0){
      failedItemCounter["form-item-corp-info"].push(name);
    }else if(name.indexOf("responsible_last_name") == 0 || name.indexOf("responsible_first_name") == 0 || name.indexOf("responsible_tel1_") == 0){
      failedItemCounter["form-item-corp-info"].push(name);
    }else if(name.indexOf("add_") == 0){
      failedItemCounter["form-item-corp-address"].push(name);
    }else if(["email","email_conf"].indexOf(name) > -1){
      if($('#entry-corp-form').length){
        failedItemCounter["form-item-corp-mail"].push(name);
      }else{
        failedItemCounter["form-item-contractor"].push(name);
      }
    }else if(name.indexOf("deliverycorp_") == 0){
      failedItemCounter["form-item-delivery-corp"].push(name);
    }else if(name.indexOf("password") == 0 && ! window.location.pathname.includes("prepaid")){
      failedItemCounter["form-item-password"].push(name);
    }else if(["zipcode_1", "zipcode_2", "prefecture", "city", "town", "block"].indexOf(name) > -1){
      failedItemCounter["form-item-address"].push(name);
    }else if(["zipcode_1", "zipcode_2", "prefecture", "city", "town", "block"].indexOf(name) > -1){
      failedItemCounter["form-item-address"].push(name);
    } else if (name.indexOf("room_number") > -1) { // 建物名・部屋番号
      failedItemCounter["form-item-address"].push(name);
    } else if (name.indexOf("user_room_number") > -1) { // 建物名・部屋番号
      failedItemCounter["form-item-user"].push(name);
    } else if (name.indexOf("delivery_room_number") > -1) { // 建物名・部屋番号
      failedItemCounter["form-item-user"].push(name);
    }else if(["payment_method"].indexOf(name) > -1){
      failedItemCounter["form-item-corp-card"].push(name);
    }else if(["payment_method","holdername","cardno","expire_month","expire_year","securitycode","contact_company","contact_last_name","contact_first_name","payment_due_date_type","corporate_checkbox","contact_email_address","contact_email_address_conf"].indexOf(name) > -1){
      if($("#corp_payment_method_select").val() == "1"){//クレカ選択のとき
        if(["payment_method","holdername","cardno","expire_month","expire_year","securitycode"].indexOf(name) > -1){
          failedItemCounter["form-item-corp-card"].push(name);
        }else if(["contact_company","contact_last_name","contact_first_name","corporate_checkbox","contact_email_address","contact_email_address_conf"].indexOf(name) > -1){
          failedItemCounter["form-item-corp-invoice"].push(name);
        }
      }else if($("#corp_payment_method_select").val() == "3"){
        failedItemCounter["form-item-corp-card"].push(name);
      }
      else if($("#corp_payment_method_select").val() == "3"){
        failedItemCounter["form-item-corp-card"].push(name);
      }else if($(".entry-form").find(".first-box-margin")){
        failedItemCounter["form-item-corp-email-address"].push(name);
      }
    }else{
      failedItemCounter["form-item-contractor"].push(name);
    }
  });


  //////////////////
  // Validation failed
  //////////////////

  //change button
  $("div.form-entry-user-invalid-box").removeClass("box-hidden");
  $("div.form-entry-user-submit").addClass("box-hidden");
  $("div.not-inputted-items").addClass("not-inputted-items-hidden");

  // Alert contractor
  var alertLines = []
  var invalidItems = [];
  ["last_name", "first_name", "representative_last_name", "representative_first_name", "last_name_kana", "first_name_kana", "representative_last_name_kana", "representative_first_name_kana", "sex", "birthday_year", "birthday_month", "birthday_day", "tel1_1", "tel1_2", "tel1_3", "representative_tel1_1", "representative_tel1_2", "representative_tel1_3", "email", "email_confirm", "email_conf", "password", "password_confirm"].forEach(function(v){
    if(failedItemCounter["form-item-contractor"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });
  if(invalidItems.length > 0){
    $("div.not-inputted-items-contractor").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-contractor").html(alertLines.join(""));

  // Alert user(entry/select only)
  var alertLines = []
  var invalidItems = [];
  ["user_info"].forEach(function(v){
    if(failedItemCounter["form-item-user-info"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });
  if(invalidItems.length > 0){
    $("div.not-inputted-items-user-info").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-user-info").html(alertLines.join(""));

  // Alert address
  var alertLines = []
  var invalidItems = [];
  ["zipcode_1", "zipcode_2", "prefecture", "city", "town", "block", "room_number"].forEach(function(v){
    if(failedItemCounter["form-item-address"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });
  if(invalidItems.length > 0){
    $("div.not-inputted-items-address").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-address").html(alertLines.join(""));

  // Alert user
  var alertLines = []
  var invalidItems = [];
  ["user_last_name","user_first_name","user_last_name_kana","user_first_name_kana","user_tel1_1","user_tel1_2","user_tel1_3","user_zipcode_1","user_zipcode_2","user_prefecture","user_city","user_town","user_block","user_room_number"].forEach(function(v){
    if(failedItemCounter["form-item-user"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });
  if(invalidItems.length > 0){
    $("div.not-inputted-items-user").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-user").html(alertLines.join(""));

  // Alert delivery(entry/user only)
  var alertLines = []
  var invalidItems = [];
  ["delivery_info"].forEach(function(v){
    if(failedItemCounter["form-item-delivery-info"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });
  if(invalidItems.length > 0){
    $("div.not-inputted-items-delivery-info").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-delivery-info").html(alertLines.join(""));

  // Alert delivery
  var alertLines = []
  var invalidItems = [];
  ["delivery_last_name","delivery_first_name","delivery_last_name_kana","delivery_first_name_kana","delivery_tel1_1","delivery_tel1_2","delivery_tel1_3","delivery_zipcode_1","delivery_zipcode_2","delivery_prefecture","delivery_city","delivery_town","delivery_block","delivery_room_number","delivery_order_time"].forEach(function(v){
    if(failedItemCounter["form-item-delivery"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });
  if(invalidItems.length > 0){
    $("div.not-inputted-items-delivery").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-delivery").html(alertLines.join(""));

  // Alert delivery time(entry/user only)
  var alertLines = []
  var invalidItems = [];
  ["delivery_order_time"].forEach(function(v){
    if(failedItemCounter["form-item-delivery-time"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });
  if(invalidItems.length > 0){
    $("div.not-inputted-items-delivery-time").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-delivery-time").html(alertLines.join(""));

  // Alert invoice mail-address
  var alertLines = []
  var invalidItems = [];
  ["email","email_conf","contact_email_address","contact_email_address_conf"].forEach(function(v){
    if(failedItemCounter["form-item-corp-mail"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });
  if(invalidItems.length > 0){
    $("div.not-inputted-items-corp-mail").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-corp-mail").html(alertLines.join(""));

  var alertLines = []
  var invalidItems = [];
  ['password', 'password_confirm'].forEach(function(v){
    if(failedItemCounter["form-item-password"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });
  if(invalidItems.length > 0){
    $("div.not-inputted-items-password").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-password").html(alertLines.join(""));


  //Alert corp_user

  var alertLines = []
  var invalidItems = [];
  if(invalidItems.length > 0){
    $("div.not-inputted-items-corp-user").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-corp-user").html(alertLines.join(""));
  var alertLines = []
  var invalidItems = [];
  ["corp_company_name","corp_company_name_kana","corp_last_name","corp_first_name","corp_last_name_kana","corp_first_name_kana","company_hp_url","corp_tel1_1","corp_tel1_2","corp_tel1_3","responsible_last_name","responsible_first_name","responsible_last_name_kana","responsible_first_name_kana","corp_tel2_1","corp_tel2_2","corp_tel2_3","responsible_tel1_1","responsible_tel1_2","responsible_tel1_3","corp_email","corp_email_conf","corp_password","corp_password_confirm"].forEach(function(v){
    if(failedItemCounter["form-item-corp-info"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });

  if(invalidItems.length > 0){
    $("div.not-inputted-items-corp-user").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-corp-user").html(alertLines.join(""));

  //Alert address

  var alertLines = []
  var invalidItems = [];
  if(invalidItems.length > 0){
    $("div.not-inputted-items-corp-address").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-corp-address").html(alertLines.join(""));
  var alertLines = []
  var invalidItems = [];
  ["add_corp_zipcode1","add_corp_zipcode2","add_corp_prefecture","add_corp_city","add_corp_town","add_corp_block"].forEach(function(v){
    if(failedItemCounter["form-item-corp-address"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });

  if(invalidItems.length > 0){
    $("div.not-inputted-items-corp-address").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-corp-address").html(alertLines.join(""));

  //Alert corp-delivery

  var alertLines = []
  var invalidItems = [];
  if(invalidItems.length > 0){
    $("div.not-inputted-items-delivery-corp").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-delivery-corp").html(alertLines.join(""));
  var alertLines = []
  var invalidItems = [];
  ["deliverycorp_info","deliverycorp_last_name","deliverycorp_first_name","deliverycorp_last_name_kana","deliverycorp_first_name_kana","deliverycorp_tel1_1","deliverycorp_tel1_2","deliverycorp_tel1_3","deliverycorp_zipcode_1","deliverycorp_zipcode_2","deliverycorp_prefecture","deliverycorp_city","deliverycorp_town","deliverycorp_block","deliverycorp_order_time"].forEach(function(v){
    if(failedItemCounter["form-item-delivery-corp"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });

  if(invalidItems.length > 0){
    $("div.not-inputted-items-delivery-corp").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-delivery-corp").html(alertLines.join(""));


  //Alert corp-contact
  var alertLines = []
  var invalidItems = [];
  if(invalidItems.length > 0){
    $("div.not-inputted-items-corp-contact").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-corp-contact").html(alertLines.join(""));
  var alertLines = []
  var invalidItems = [];
  ["corp_contact_info","invoice_company_name","invoice_company_name_kana","invoice_department_name","invoice_last_name","invoice_first_name","invoice_last_name_kana","invoice_first_name_kana","invoice_tel1_1","invoice_tel1_2","invoice_tel1_3","invoice_email","invoice_email_conf","corporate_checkbox"].forEach(function(v){
    if(failedItemCounter["form-item-corp-contact"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });
  if(invalidItems.length > 0){
    $("div.not-inputted-items-corp-contact").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-corp-contact").html(alertLines.join(""));

  // Alert corp-user
  var alertLines = []
  var invalidItems = [];
  if($("#corp_payment_method_select").val() == "3"){
    var payment_method_select = ["payment_method","holdername","cardno","expire_month","expire_year","securitycode","contact_company","contact_last_name","contact_first_name","contact_email_address","contact_email_address_conf","corporate_checkbox","payment_due_date_type"];
  }else{
    var payment_method_select = ["payment_method","holdername","cardno","expire_month","expire_year","securitycode"];
  }
  payment_method_select.forEach(function(v){
    if(failedItemCounter["form-item-corp-card"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });
  if(invalidItems.length > 0){
    $("div.not-inputted-items-card").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-card").html(alertLines.join(""));

  var alertLines = []
  var invalidItems = [];
  ["contact_company","contact_last_name","contact_first_name","contact_email_address","contact_email_address_conf","corporate_checkbox"].forEach(function(v){//name名
    if(failedItemCounter["form-item-corp-invoice"].indexOf(v) > -1){//クラス名
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });
  if(invalidItems.length > 0){
    $("div.not-inputted-items-invoice").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-invoice").html(alertLines.join(""));

  //Alert corp email address
  var alertLines = []
  var invalidItems = [];
  ["contact_email_address","contact_email_address_conf"].forEach(function(v){
    if(failedItemCounter["form-item-corp-email-address"].indexOf(v) > -1){
      invalidItems.push(v);
    }
  });
  invalidItems.forEach(function(v){
    var str = formNameToString(v);
    var str = "<p>" + str + "</p>";
    if(alertLines.indexOf(str) == -1){
      alertLines.push(str);
    }
  });

  if(invalidItems.length > 0){
    $("div.not-inputted-items-corp-email-address").removeClass("not-inputted-items-hidden");
  }
  $(".not-inputted-items-corp-email-address").html(alertLines.join(""));

  var popupLines = [];
  var invalidSections = [];
  if(failedItemCounter["form-item-contractor"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-contractor\")' class='not-inputed-link'><p><u>*ご契約者様情報</u></p></a>");
    invalidSections.push("#not-inputted-items-contractor");
  }
  if(failedItemCounter["form-item-corp-info"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-corp-user\")' class='not-inputed-link'><p><u>*ご契約者様情報</u></p></a>");
    invalidSections.push("#not-inputted-items-corp-user");
  }
  if(failedItemCounter["form-item-user-info"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-user-info\")' class='not-inputed-link'><p><u>*ご利用者様について</u></p></a>");
    invalidSections.push("#not-inputted-items-user-info");
  }
  if(failedItemCounter["form-item-address"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-address\")' class='not-inputed-link'><p><u>*ご契約者様住所</u></p></a>");
    invalidSections.push("#not-inputted-items-address");
  }
  if(failedItemCounter["form-item-user"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-user\")' class='not-inputed-link'><p><u>*ご利用者様情報</u></p></a>");
    invalidSections.push("#not-inputted-items-user");
  }
  if(failedItemCounter["form-item-corp-address"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-corp-address\")' class='not-inputed-link'><p><u>*ご契約者様住所</u></p></a>");
    invalidSections.push("#not-inputted-items-corp-address");
  }
  if(failedItemCounter["form-item-delivery-info"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-delivery-info\")' class='not-inputed-link'><p><u>*配送先について</u></p></a>");
    invalidSections.push("#not-inputted-items-delivery-info");
  }
  if(failedItemCounter["form-item-delivery"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-delivery\")' class='not-inputed-link'><p><u>*配送先情報</u></p></a>");
    invalidSections.push("#not-inputted-items-delivery");
  }
  if(failedItemCounter["form-item-delivery-time"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-delivery-time\")' class='not-inputed-link'><p><u>*配送時間</u></p></a>");
    invalidSections.push("#not-inputted-items-delivery-time");
  }
  if(failedItemCounter["form-item-delivery-corp"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-delivery-corp\")' class='not-inputed-link'><p><u>*配送先情報</u></p></a>");
    invalidSections.push("#not-inputted-items-delivery-corp");
  }
  if(failedItemCounter["form-item-corp-contact"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-corp-contact\")' class='not-inputed-link'><p><u>*請求先情報</u></p></a>");
    invalidSections.push("#not-inputted-items-corp-contact");
  }

  if(failedItemCounter["form-item-corp-mail"].length > 0){
      popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-corp-mail\")' class='not-inputed-link'><p><u>*アカウント情報</u></p></a>");
      invalidSections.push("#not-inputted-items-corp-mail");
    }
  if(failedItemCounter["form-item-password"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-password\")' class='not-inputed-link'><p><u>*ログインパスワード</u></p></a>");
    invalidSections.push("#not-inputted-items-password");
  }

  if(failedItemCounter["form-item-corp-card"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-card\")' class='not-inputed-link'><p><u>*支払い情報</u></p></a>");
    invalidSections.push("#not-inputted-items-card");
  }

  if(failedItemCounter["form-item-corp-invoice"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-invoice\")' class='not-inputed-link'><p><u>*支払い情報</u></p></a>");
    invalidSections.push("#not-inputted-items-invoice");
  }

  if(failedItemCounter["form-item-corp-email-address"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-corp-email-address\")' class='not-inputed-link'><p><u>*メールアドレスの確認</u></p></a>");
    invalidSections.push("#not-inputted-items-corp-email-address");
  }

  $("div.user-form-alert-lines").html(popupLines.join(""));

  currentInvaliSectionHash = invalidSections[0];
  // Popup
  userFormAlertClick(currentInvaliSectionHash);
};

var currentInvaliSectionHash;

function userFormAlertClick(targetHash){
  if(targetHash === undefined){
    targetHash = currentInvaliSectionHash;
  }
  hideDeviceOptionPopup();
  var target = $(targetHash);
  scrollToHash(target, "header.mypage-header");
}

function deviceOptionPopupCancelClick(){
  targetHash = "#device-option-error-message";
  hideDeviceOptionPopup();
  var target = $(targetHash);
  scrollToHash(target, "header.mypage-header");
}

function deviceOptionChangePopupCancelClick(){
  $(".edit-partial-device-option").scrollTop(0);
  hideDeviceOptionPopup();
}
function creditCardChangePopupCancelClick(){
  hideCreditCardPopup();
}
function creditCardChangeNamePopupCancelClick(){
  hideCreditCardNamePopup();
}

// WiMAX start
function wimaxDeviceChangePopupCancelClick(){
  $(".edit-partial-device").scrollTop(0);
  hideDeviceOptionPopup();
}
// WiMAX end

// Form edit
$(document).ready(function() {
  $(".form-black-background").click(function(){
    hideFormEditPopup();
  });
});
function showFormEditPopup(mode){
  var selector = ".mypage-confirm-hidden-form-" + mode;
  var selector2 = ".edit-partial-" + mode;
  $(".form-black-background").show();
  $(selector).show();
  $(selector2).show();
  togglePlanTab(mode); // 一括払いプラン用：タブを切り替える
  focusTarget(); // 申し込みフォームSTEP3：ポップアップ内の要素にフォーカスを当てる
}
function hideFormEditPopup(mode){
  $(".edit-partial-plan").hide();
  $(".edit-partial-kgr-plan").hide();
  $(".edit-partial-device-option").hide();
  $(".edit-partial-zeus-set").hide();
  $(".edit-partial-contractor").hide();
  $(".edit-partial-address").hide();
  $(".edit-partial-user").hide();
  $(".edit-partial-delivery").hide();
  $(".edit-partial-corp-contact").hide();
  $(".edit-partial-device").hide();
  $(".edit-partial-installment-payment").hide();
  $(".edit-partial-rental_days").hide();
  $(".form-black-background").hide();
  $(".mypage-confirm-hidden-form").hide();
  $(".edit-partial-quantity").hide();
  focusTarget(mode);
}

function focusTarget(mode) {
  if (window.location.pathname.includes('/entry/confirm') 
  || window.location.pathname.includes('/entry/corp/confirm') 
  || window.location.pathname.includes('/entry/oh_specialplans/confirm')
  || window.location.pathname.includes('/entry/prepaid/confirm')
  || window.location.pathname.includes('/entry/prepaid/sub/confirm')
  || window.location.pathname.includes('/entry/wimax/confirm')) {
    $('.js-focus-target').focus();
    // 申し込みフォームSTEP3：ポップアップを閉じた後のフォーカス設定
    if (mode) $('.' + mode).focus();
  }
}

// showFormEditPopupで開くモーダルにIMEI関連のパラメータを渡す
function showContractImeiDetail(mode, imei) {
  // 各種ボタンのリンク先URLの生成
  let link_corp_data_flow = document.getElementById('link_corp_data_flow');
  link_corp_data_flow.setAttribute('href', $('#corp_data_flow_url').attr('value') + '?imei=' + imei);
  let link_corp_overseas = document.getElementById('link_corp_overseas');
  link_corp_overseas.setAttribute('href', $('#corp_overseas_url').attr('value') + '?imei=' + imei);

  // プランIDによるボタンの表示制御
  let basic_plans = [3,4];    // ベーシックプランのプランID
  let plan_id = Number($("#button_plan_id_"+imei).val());
  if ($.inArray(plan_id, basic_plans) === -1) {
    link_corp_data_flow.setAttribute('style', 'display:block;');
  } else {
    link_corp_data_flow.setAttribute('style', 'display:none;');
  }

  showFormEditPopup(mode);
}

// 一括払いプラン用：タブを切り替える
function togglePlanTab(mode) {
  if (window.location.pathname.includes("/entry/special/confirm") && mode == 'plan') {
    var plan_id = $('[name="plan_id"]:checked').val();
    if (plan_id >= 703) {
      $('#special-contract-tab-1').prop('checked', false);
      $('#special-contract-tab-2').prop('checked', true);
      $('.standard_contract.special-contract-plans').hide();
      $('.free_contract.special-contract-plans').show();
    }
  }
}

// ご契約端末一覧の絞り込み
$(function() {
  $("#contract_imei").on('input', function(e) {
    // 入力したタイミングで絞り込みを行う
    let imei_row_list = document.getElementsByName('imei_rows');
    let input_str = $("#contract_imei").val();
    for (var i = 0; i < imei_row_list.length; i++) {
      var imei_row = imei_row_list[i].className;
      if (imei_row.indexOf(input_str) > -1) {
        imei_row_list[i].setAttribute("style", "");
      } else {
        imei_row_list[i].setAttribute("style", "display:none");
      }
    }
  });
});

// Device option popup
$(document).ready(function() {
  $(".form-black-background-device-option").click(function(){
    if($(this).hasClass("user-form-bg")){
      userFormAlertClick();
    }else{
      hideDeviceOptionPopup();
    }
  });

  $('#entry-plan-form').submit(function(){
    var page_url = location.href;
    var valDeviceOption;

    // wimaxページのplan formだった場合 強制的にtrue
    if ( page_url.indexOf('wimax') != -1) {
      valDeviceOption = true;
    } else if(window.location.pathname.includes("/entry/select")){
      valDeviceOption = $("input[name='selected_option[]']:checked").val();
      if(valDeviceOption === undefined){
        valDeviceOption = "false";
      }
    }else{
      valDeviceOption = $("input[name='device_option']:checked").val();
    }

    //determine by plan_id
    var valTie = $("input[name='plan_id']:checked").val();

    if (valTie === undefined) {
      valTie = $('input:hidden[name="plan_id"]').val();
    }

    if(valTie === undefined){
      return false;
    }

    if(valDeviceOption === undefined){
      // Disable validate.js submitHandler (va.js)
      $(this).attr("preventSubumit", "true");
      return false;
    }else if(valDeviceOption === "false"){
      showDeviceOptionPopup();
      $(this).attr("preventSubumit", "true");
      return false;
    }
    $(this).attr("preventSubumit", "false");
    return true;
  });
});

function forceSubmitDeviceOption(){
  var form = $('#entry-plan-form');
  // Enable validate.js submitHandler (va.js)
  form.attr("forceSubumit", "true");
  form.submit();
}

$(document).ready(function() {
  $(".form-black-background-device-option").click(function(){
    if($(this).hasClass("user-form-bg")){
      userFormAlertClick();
    }else{
      hideDeviceOptionPopup();
    }
  });
  $('#form-entry-edit-device-option').submit(function(){

    if(window.location.pathname.includes("/entry/select")){
      var valDeviceOption = $("input[name='device_option']:checked").val();
    }
    //determine by plan_id
    var valTie = $("input[name='plan_id']:checked").val();

    if (valTie === undefined) {
      valTie = $('input:hidden[name="plan_id"]').val();
    }
    if(valTie === undefined || valDeviceOption === undefined){
      return false;
    }

    if(valDeviceOption === "false"){
      // showDeviceOptionPopup();
      // Disable validate.js submitHandler (va.js)
      // $(this).attr("preventSubumit", "true");
      return false;
    }
    $(this).attr("preventSubumit", "false");
    return true;
  });
});

function forceSubmitChangeDeviceOption(){
  var form = $('#form-entry-edit-device-option');
  // Enable validate.js submitHandler (va.js)
  form.attr("forceSubumit", "true");
  form.submit();
}

function showDeviceOptionPopup(){
  $(".device-option-confirm-popup").show();
  $(".form-black-background-device-option").show();
}
function hideDeviceOptionPopup(){
  $(".device-option-confirm-popup").hide();
  $(".form-black-background-device-option").hide();
}
function hideCreditCardPopup(){
  $(".credit-card-confirm-popup").hide();
  $(".form-black-background-credit-card").hide();
}
function hideCreditCardNamePopup(){
  $(".credit-card-name-confirm-popup").hide();
  $(".form-black-background-credit-card-name").hide();
  $("#entry_user_submit").focus();
  // 修正するボタンが押下された場合はカード名義の入力欄にフォーカスを当てる
  if (window.location.pathname.includes('/entry/payment')
  || window.location.pathname.includes('/entry/wimax/payment')
  || window.location.pathname.includes('/entry/oh_specialplans/payment')) $('input#card-name').focus();
}
$(document).ready(function(){
  $("#leave-checkbox").prop("checked", false);

  function toggleLeaveCheckBox(){
    var boxes = $('input#leave-checkbox:checked');
    $(".confirm-box").removeClass("confirm-box-selected");
    if(boxes.length > 0){
      $(".confirm-box").addClass("confirm-box-selected");
    }
  }

  $("#leave-checkbox").click(function(){
    toggleLeaveCheckBox();
  });
  toggleLeaveCheckBox();
});

$(document).ready(function(){
  $("#data-charge-agreement-checkbox, #leave-checkbox-plan, #overseas-data-agreement-checkbox").prop("checked", false);

  function toggleLeaveCheckBox(){
    var boxes = $('input#data-charge-agreement-checkbox:checked, input#overseas-data-agreement-checkbox:checked');
    $(".confirm-box").removeClass("confirm-box-selected");
    if(boxes.length > 0){
      $(".confirm-box").addClass("confirm-box-selected");
    }
  }

  $("#data-charge-agreement-checkbox, #overseas-data-agreement-checkbox").click(function(){
    toggleLeaveCheckBox();
  });
  $('.mypage-agreement-checkbox.js-confirm-box').keyup(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
        toggleLeaveCheckBox();
      }
  });
  toggleLeaveCheckBox();
});

$(document).ready(function() {
  // パスワードの表示切り替え
  $(".toggle-password").click(function () {
    // iconの切り替え
    $(this).toggleClass("fa-eye fa-eye-slash");
    // 入力フォームの取得
    var input = $(this).parent().prevAll("input");
    // type切替
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
});

$(document).ready(function() {
  $("div.special-campaignterms-confirm #leave-checkbox").click(function(){
    var isChecked = $(this).prop('checked');
    if(isChecked){
      $("div.special-campaignterms-button-text").removeClass("inactive");
      $("div.special-campaignterms-button-text").addClass("active");
    }else{
      $("div.special-campaignterms-button-text").removeClass("active");
      $("div.special-campaignterms-button-text").addClass("inactive");
    }
  });
});
// New mypage

// $(function(){
//   if(location.pathname == '/mypage/contract/rental') {
//     $('.mypage-nav').addClass('mypage-nav-moved');
//   }
// });

// Mypage path finder
function currentMypagePathIs(path) {
  if(path === 'password' && location.pathname.indexOf('password') > -1) {
    return true;
  }

  // pass parameter like 'faq'
  var a = "/mypage/" + path;
  var b = "/mypage/" + path + "/";
  var c = "/corpmypage/" + path;
  var d = "/corpmypage/" + path + "/";

  if (location.pathname.indexOf(a) != -1){
    return true;
  }else if(location.pathname.indexOf(b) != -1){
    return true;
  }else if(location.pathname.indexOf(c) != -1){
    return true;
  }else if(location.pathname.indexOf(d) != -1){
    return true;
  }else {
    return false;
  }
}

// Mypage path finder（海外レンタルプラン用）
function currentMypagePathIsOverseas(path) {
  if(path === 'password' && location.pathname.indexOf('password') > -1) {
    return true;
  }

  // pass parameter like 'faq'
  var a = "/mypage/" + path + "/rental";
  var b = "/mypage/" + path;
  var c = "/rental/" + path;
  var d = "/rental/" + path;
  var e = "/rental/" + path;

  if (location.pathname.indexOf(a) != -1){
    return true;
  }else if(location.pathname.indexOf(b) != -1){
    return true;
  }else if(location.pathname.indexOf(c) != -1){
    return true;
  }else if(location.pathname.indexOf(d) != -1){
    return true;
  }else if(location.pathname.indexOf(e) != -1){
    return true;
  }
}

$(document).ready(function() {

  function navOnLeft(){
    $("div.mypage-nav").removeClass("mypage-nav-moved");

    $("div.mypage-nav-arrow-left").addClass("mypage-nav-arrow-hidden");
    $("div.mypage-nav-arrow-left").removeClass("mypage-nav-arrow-shown");

    $("div.mypage-nav-arrow-right").addClass("mypage-nav-arrow-shown");
    $("div.mypage-nav-arrow-right").removeClass("mypage-nav-arrow-hidden");
  }
  function navOnRight(){
    $("div.mypage-nav").addClass("mypage-nav-moved");

    $("div.mypage-nav-arrow-left").addClass("mypage-nav-arrow-shown");
    $("div.mypage-nav-arrow-left").removeClass("mypage-nav-arrow-hidden");

    $("div.mypage-nav-arrow-right").addClass("mypage-nav-arrow-hidden");
    $("div.mypage-nav-arrow-right").removeClass("mypage-nav-arrow-shown");
  }

  $(function() {
    let globalNav = $(".mypage-nav-wrapper").attr('id');
    if(location.pathname.indexOf("rental") != -1 || globalNav == 'mypage-nav-wrapper-global') {
    // 海外レンタルプラン用
      if (currentMypagePathIsOverseas('data-flow')){
        navOnLeft();
        $("#mypage-nav-item-1").addClass("mypage-nav-item-active");
      } else if (currentMypagePathIsOverseas('payment-history')){
        navOnLeft();
        $("#mypage-nav-item-2").addClass("mypage-nav-item-active");
      }else if (currentMypagePathIsOverseas('user')){
        navOnLeft();
        $("#mypage-nav-item-3").addClass("mypage-nav-item-active");
      }else if (currentMypagePathIsOverseas('contract')){
        navOnRight();
        $("#mypage-nav-item-4").addClass("mypage-nav-item-active");
      }else if (currentMypagePathIsOverseas('change')){
        navOnRight();
        $("#mypage-nav-item-6").addClass("mypage-nav-item-active");
      }else if (currentMypagePathIsOverseas('extension')){
        navOnRight();
        $("#mypage-nav-item-6").addClass("mypage-nav-item-active");
      }else if (currentMypagePathIsOverseas('add')){
        navOnRight();
        $("#mypage-nav-item-6").addClass("mypage-nav-item-active");
      }else {
        // Do nothing
      }
    }else{
    // その他
      if (currentMypagePathIs('data-flow')){
        navOnLeft();
        $("#mypage-nav-item-1").addClass("mypage-nav-item-active");
      } else if (currentMypagePathIs('payment-history')){
        navOnLeft();
        $("#mypage-nav-item-2").addClass("mypage-nav-item-active");
      }else if (currentMypagePathIs('contract')){
        navOnLeft();
        $("#mypage-nav-item-3").addClass("mypage-nav-item-active");
      }else if (currentMypagePathIs('user') || currentMypagePathIs('password')){
        navOnRight();
        $("#mypage-nav-item-4").addClass("mypage-nav-item-active");
      }else if (currentMypagePathIs('overseas')){
        navOnRight();
        $("#mypage-nav-item-5").addClass("mypage-nav-item-active");
      }else if (currentMypagePathIs('support')){
        navOnRight();
        $("#mypage-nav-item-6").addClass("mypage-nav-item-active");
      }else {
        // Do nothing
      }
    }

    // Enable nav move animation with delay
    setTimeout(function(){
      $("div.mypage-nav").css("transition", "0.5s");
      $("div.mypage-nav-moved").css("transition", "0.5s");
    }, 500)
  });

  $("div.mypage-nav-arrow-left").addClass('mypage-nav-arrow-hidden');
  $("div.mypage-nav-arrow-left").removeClass('mypage-nav-arrow-shown');

  $("div.mypage-nav-arrow-left").click(function(){
    navOnLeft();
  })
  $("div.mypage-nav-arrow-right").click(function(){
    navOnRight();
  })
});

// ///
// release_202010
// ///
$(document).ready(function() {
  // application flow open and close
  $(".application-flow-button").click(function(e){
    // p in the button reacts
    var targetButton = $(e.target).parents(".application-flow-button")
    var target = targetButton.siblings('.application-flow');
    var targetButtonClose = targetButton.siblings('.application-flow-button-close');
    if (target.hasClass("hidden")){
        target.removeClass("hidden");
        targetButtonClose.removeClass("hidden");
        targetButton.find(".pull-down-arrow-to-open").hide();
        targetButton.find(".pull-down-arrow-to-close").show();
    }else{
        target.addClass("hidden");
        targetButtonClose.addClass("hidden");
        targetButton.find(".pull-down-arrow-to-close").hide();
        targetButton.find(".pull-down-arrow-to-open").show();
    }
  });
})

$(document).ready(function() {
  if(!(currentPathIs("invoice") )){
        return;
      }
  // application flow close
  $(".application-flow-button-close").click(function(e){
    // p in the button reacts
    var targetButton1 = $(this);
    var targetButton2 = targetButton1.siblings(".application-flow-button");
    var target = targetButton1.siblings(".application-flow");
    target.addClass("hidden");
    $(this).addClass("hidden");
    targetButton1.find(".pull-down-arrow-to-close").show();
    targetButton2.find(".pull-down-arrow-to-close").hide();
    targetButton2.find(".pull-down-arrow-to-open").show();

    var targetScroll = $(e.target).parents(".application-flow");
    var headerSelector = "header.site-header";
    var speed = 50;
    var headerHeight = $(headerSelector).height();
    var position = targetScroll.offset().top - headerHeight - 20;
    $("html, body").animate({ scrollTop: position }, speed, "linear");
    return false;
  });

  //ScrollHint
  new ScrollHint('.js-scrollable', {
    scrollHintIconAppendClass: 'scroll-hint-icon-white', // white-icon will appear
    i18n: {
      scrollable: 'スクロールできます'
    }
  });
});

$(function(){
  $(".tab_content dt").on("click", function() {
      toggleFaqOpenShut(this);
  });
});

function toggleFaqOpenShut(elem, open = false) {
  if (open) {
    $(elem).next().slideDown();
    $(elem).addClass("active");
  } else {
    $(elem).next().slideToggle();
    $(elem).toggleClass("active");
  }
};

///
// 画面横の追従ボタン
///

document.addEventListener('scroll', function() {
  scrollToggleClass("#hint_wrap", "#price_fix","show");
});
function scrollToggleClass(rangeTarget, addTarget, classname) {
  if($(rangeTarget).length){
    scroll = $(window).scrollTop();
    startPos = $(rangeTarget).offset().top;
    endPos = startPos + $(rangeTarget).outerHeight();

    if(window.location.pathname.includes("/faq")){
      endPos =  $(rangeTarget).outerHeight() - (startPos*3);
    }

    if (scroll > startPos && scroll < endPos) {
        $(addTarget).addClass(classname);
    } else {
        $(addTarget).removeClass(classname);
    }
  }
}

///
// 画面横の追従ボタン
///

document.addEventListener('scroll', function() {
  scrollToggleClass("#hint_wrap", "#price_fix_column","show");
});
function scrollToggleClass(rangeTarget, addTarget, classname) {
  if($(rangeTarget).length){
    scroll = $(window).scrollTop();
    startPos = $(rangeTarget).offset().top;
    endPos = startPos + $(rangeTarget).outerHeight();

    if (scroll > startPos && scroll < endPos) {
        $(addTarget).addClass(classname);
    } else {
        $(addTarget).removeClass(classname);
    }
  }
}


///
// 画面横の追従ボタン(column_detail_1~7のページ)
///
$(function(){

if(window.location.pathname.includes("/column_detail_")){
  document.addEventListener('scroll', function() {
    scrollToggleClass("#hint_wrap", "#entry_fix","show");
  });
  function scrollToggleClass(rangeTarget, addTarget, classname) {
    if($(rangeTarget).length){
      scroll = $(window).scrollTop();
      startPos = $(rangeTarget).offset().top;
      endPos = startPos + $(rangeTarget).outerHeight() - 200;

      if (scroll > startPos && scroll < endPos) {
          $(addTarget).addClass(classname);
        } else {
          $(addTarget).removeClass(classname);
      }
    }
  }
}
});


$(function(){
  $("#company_file_upload_hint,.close").click(function(){
    if($("#company_file_upload_hint").hasClass("active")){
      $("#company_file_upload_hint").removeClass("active");
    }else{
        $("#company_file_upload_hint").addClass("active");
    }
  });
});

///
// 画面横の追従ボタン（申込ボタン）
///

document.addEventListener('scroll', function() {
  scrollToggleClass("#entry_wrap", "#entry_fix","show");
});
function scrollToggleClass(rangeTarget, addTarget, classname) {
  if($(rangeTarget).length){
    scroll = $(window).scrollTop();
    startPos = $(rangeTarget).offset().top;
    endPos = startPos + $(rangeTarget).outerHeight();

    if (window.location.pathname.includes("/faq")) { // AI FAQ
      startPos = $('#faq-section').offset().top - (window.innerHeight * 0.25);
      endPos =  $('.footer-menu').offset().top - (window.innerHeight * 0.95);
    } else if (window.location.pathname.includes("/mypage/support") || window.location.pathname.includes("/corpmypage/support")) {
      endPos = $(rangeTarget).outerHeight() - (startPos / 1.2);
    }

    if ($(document).has('#btn-chatbot')) {
      startPos = 100;
      if (window.innerWidth > 767 && window.innerHeight < 700) {
        $('#entry_fix').css('top', 150);
      }
    }
    if (window.location.pathname.includes("/business") && window.innerWidth > 767) {
      startPos = $(rangeTarget).offset().top + 1000;
      endPos = startPos + 2500;
    }
    if (scroll > startPos && scroll < endPos) {
        $(addTarget).addClass(classname);
    } else {
        $(addTarget).removeClass(classname);
    }
    if(window.location.pathname.includes("/business_partner" || "/business_partner/hotel_plan")){
      footer = $(".footer-menu").outerHeight();
      footerShare = $(".footer-share").outerHeight();
      SideButton =$("#entry_fix").outerHeight();
      ContactSection = $(".hotel-plan-contact").outerHeight();
      if( window.matchMedia('(max-width:767px)').matches ){
        ContactSection = $(".hotel-plan-contact").outerHeight()+100;
      }
      if (scroll > startPos && scroll < endPos-footer-footerShare+ContactSection-SideButton) {
        $(addTarget).addClass(classname);
      } else {
          $(addTarget).removeClass(classname);
      }

    }
  }
}

$(function(){
  $(".price-fix-hint,.close").click(function(){
    if($(".price-fix-hint,.hint_pop").hasClass("active")){
      $(".price-fix-hint,.hint_pop").removeClass("active");
      if (typeof ul_widget == 'function') ul_widget('show');
    }else{
      $(".price-fix-hint,.hint_pop").addClass("active");
      if (typeof ul_widget == 'function') ul_widget('hide');
    }
  });
});

$(function(){
  if(window.location.pathname.includes("/entry/special")){
    $("#special-hint-event,.close").click(function(){
      if($("#special-hint-event,.hint_pop").hasClass("active")){
        $("#special-hint-event,.hint_pop").removeClass("active");
      }else{
          $("#special-hint-event,.hint_pop").addClass("active");
      }
    });
  }
});

// //容量選びのヒント start

// $(document).ready(function() {

// var top_notion_popup = '<div class="hint-notion-black-background"></div>';

// $("body").append(top_notion_popup);
//   hideHintNotionPopup();

//   function hideHintNotionPopup(){
//     $(".hint-notion-black-background").hide();
//     $("#price_fix,.hint_pop").hide();
//   }
//   $(".hint-notion-black-background").click(function(){
//     hideHintNotionPopup();
//   })
//   $("#price_fix,.close").click(function(){
//     hideHintNotionPopup();
//   })
// });

// function showHintNotionPopup(){
//   $(".hint-notion-black-background").show();
//   $("#price_fix,.hint_pop").show();
// }
// //容量選びのヒント end

$(function(){
  $("#sp-menu").click(function(){
    if($("#sp-menu,header ul").hasClass("clicked")){
      $("#sp-menu,header ul").removeClass("clicked");
      $('.ul-widget-main-window').show();
    }else{
      $("#sp-menu,header ul").addClass("clicked");
      $('.ul-widget-main-window').hide();
    }
  });
  if(window.location.pathname.includes("/business")) {
    $(".sp_nav a").click(function(){
      if($("#sp-menu,header ul").hasClass("clicked")){
        $("#sp-menu,header ul").removeClass("clicked");
        $('.ul-widget-main-window').show();
      }else{
        $("#sp-menu,header ul").addClass("clicked");
        $('.ul-widget-main-window').hide();
      }
    });

  }
});

// プラン変更ボタン
$(function() {
  $("input#leave-checkbox-plan, input#plan-input-password, select#plan-pulldown-select").change(function() {
    var checked = $("input#leave-checkbox-plan").prop("checked");
    var inputed = $("input#plan-input-password").val().length;
    let planId = $("select#plan-pulldown-select").val();

    if (checked && inputed > 7 && planId) {
      $(".plan-change-button").removeClass(
          "decoration-button-area-disabled"
      );
      $("#plan-change-confirm").removeAttr("disabled");
    } else {
      $(".plan-change-button").addClass("decoration-button-area-disabled");
      $("#plan-change-confirm").attr("disabled", "disabled");
    }
  });
});

/*注意のポップアップ*/
function showPresentLimitPopup(){
  $(".present-limit-confirm-popup").show();
  $(".form-black-background-present-limit").show();
}
function hidePresentLimitPopup(){
  $(".present-limit-confirm-popup").hide();
  $(".form-black-background-present-limit").hide();
}
function showPresentPayErrorPopup(){
  $(".present-pay-error-confirm-popup").show();
  $(".form-black-background-present-pay-error").show();
}
function hidePresentPayErrorPopup(){
  $(".present-pay-error-confirm-popup").hide();
  $(".form-black-background-present-pay-error").hide();
}
function showPresentLimitPopupForCorp(contract_id){
  // 法人マイページ用
  var href_dataflow = $("#href_dataflow").val();
  $("#edit_data_charge_plan_url_for_limit").attr("href", href_dataflow.replace(":id", contract_id));
  $(".present-limit-confirm-popup").show();
  $(".form-black-background-present-limit").show();
}
function showSaisonAlreadyPopup(){
  $(".saison-already-confirm-popup").show();
  $(".form-black-background-saison-already").show();
}
function hideSaisonAlreadyPopup(){
  $(".saison-already-confirm-popup").hide();
  $(".form-black-background-saison-already").hide();
}

// 一括オプション解約のURLへ遷移する（個人）
function linkToBulkOptionCancelURL(class_name){
  let get_url = '';
  let get_params = [];
  $(class_name+':checked').each(function(i, elem){
    get_params.push( 'ids[]=' + $(elem).val() ) ;
  });
  get_url = get_params.join('&');
  window.location.href = '/mypage/contract/bulk_option_cancel?' + get_url;
}

// 一括オプション解約のURLへ遷移する（法人）
function corpLinkToBulkOptionCancelURL(class_name){
  let get_url = '';
  let get_params = [];
  $(class_name+':checked').each(function(i, elem){
    get_params.push( 'ids[]=' + $(elem).val() ) ;
  });
  get_url = get_params.join('&');
  window.location.href = '/corpmypage/contract/bulk_option_cancel?' + get_url;
}

$(function() {
    $(function(){
        if( window.matchMedia('(max-width:767px)').matches ){
            var headerHight = 100;
        }else{
            var headerHight = 127;
        }
        if(window.location.pathname.includes("/business_partner/hotel_plan")){
            var headerHight = $(".service-header").outerHeight();
        }
        $('a[href^="#"]').click(function(){
            var href= $(this).attr("href");
            var target = $(href == "#" || href == "" ? 'html' : href);
            var position = target.offset().top;
            $("html, body").animate({scrollTop:position-headerHight}, 550, "swing");
            return false;
        });
    });
});

//スライドショー
$(window).on('load', function() {
  if(window.location.pathname === "/"){
    $('.slider').slick({
      accessibility: true,
      autoplay: true,
      autoplaySpeed: 2500,
      dots: true,
      fade: true,
      speed: 1500,
    });
  }
});

function submitUserToDeliveryInfo(){
  $("input[name=delivery_last_name]").val($("input[name=user_last_name]").val());
  $("input[name=delivery_first_name]").val($("input[name=user_first_name]").val());
  $("input[name=delivery_last_name_kana]").val($("input[name=user_last_name_kana]").val());
  $("input[name=delivery_first_name_kana]").val($("input[name=user_first_name_kana]").val());
  $("input[name=delivery_tel1_1]").val($("input[name=user_tel1_1]").val());
  $("input[name=delivery_tel1_2]").val($("input[name=user_tel1_2]").val());
  $("input[name=delivery_tel1_3]").val($("input[name=user_tel1_3]").val());
  $("input[name=delivery_zipcode_1]").val($("input[name=user_zipcode_1]").val());
  $("input[name=delivery_zipcode_2]").val($("input[name=user_zipcode_2]").val());
  $("select[name=delivery_prefecture]").val($("select[name=user_prefecture]").val());
  $("input[name=delivery_city]").val($("input[name=user_city]").val());
  $("input[name=delivery_town]").val($("input[name=user_town]").val());
  $("input[name=delivery_block]").val($("input[name=user_block]").val());
  $("input[name=delivery_building_name]").val($("input[name=user_building_name]").val());
  $("input[name=delivery_room_number]").val($("input[name=user_room_number]").val());
}

/**
 * Get the URL parameter value
 *
 * @param  name {string} パラメータのキー文字列
 * @return  url {url} 対象のURL文字列（任意）
 */
function getParam(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
$(function() {
    if(getParam("utm_source")=="fuji"){
      $(".wimax-fuji").show();
    }else if(getParam("utm_source")=="sbn"){
      $(".wimax-sbn").show();
    }
});

//Before Title

$(function() {
  if(window.location.pathname.includes("/entry/wimax/user")||window.location.pathname.includes("/entry/wimax/confirm")||window.location.pathname.includes("/entry/wimax/payment")||window.location.pathname.includes("/entry/wimax/complete")){
    var firstTitles = [];
    firstTitles.push($(".first-title"));
    console.log(firstTitles);
    firstTitles.forEach(function(val,index,ar){
      console.log(val.text());
      var firstTitleTexts = val.text().trim();
      switch (firstTitleTexts) {
        case "契約内容確認オプションサービス":
          val.addClass("first-title-box-water-non-subtitle");
        break;
        case "お客様情報入力":
          val.addClass("first-title-box-water-non-subtitle");
        break;
        case "支払い方法選択":
          val.addClass("first-title-box-water-non-subtitle");
        break;
        case "お申し込み完了":
          val.addClass("first-title-box-water-non-subtitle");
        break;
      }
    });
  }else{
    return;
  }
});

// 20230220 お客様サポート カスタマーセンターへのお問い合わせポップアップ start

$(function(){
  //開くボタンをクリックしたらモーダルを表示する
  $('.callcenter-modal-open').on('click',function(){
    $('.callcenter-modal-container').addClass('active');
    return false;
  });

  //閉じるボタンをクリックしたらモーダルを閉じる
  $('.callcenter-modal-close').on('click',function(){
    $('.callcenter-modal-container').removeClass('active');
  });

  //モーダルの外側をクリックしたらモーダルを閉じる
  $(document).on('click',function(e) {
    if(!$(e.target).closest('.callcenter-modal-body').length) {
      $('.callcenter-modal-container').removeClass('active');
    }
  });
});

// 20230220 お客様サポート カスタマーセンターへのお問い合わせポップアップ start


// 建物名を入力するときに部屋番号入力欄を表示
(($) => {
  $(() => {
    $('.js-building').each((i, e) => {
      const state = 'active';
      const $nameInput = $('.js-building-name input', e);
      const $room = $('.js-building-room', e);
      const $roomInput = $('.js-building-room input', e);
      const $roomAny = $('.js-building-room-any', e);
      const $back = $('.js-building-back', e);
      const userInfo = '[name="user_info"], [name="delivery_info"], [name="deliverycorp_info"]';
      const userInfoChecked = '[name="user_info"]:checked, [name="delivery_info"]:checked, [name="deliverycorp_info"]:checked';
      const $tmp = {
        name: $nameInput.val(),
        room: $roomInput.val()
      }
      if ($roomInput.length && $roomInput.val().length >= 1) {
        $room.addClass(state);
      }
      if ($roomAny.length && $nameInput.length && $nameInput.val().length >= 1) {
        $room.addClass(state);
      }
      if ($(userInfoChecked, e).val() == 1) {
        $room.removeClass(state);
      }
      $nameInput.on('focus', () => {
        $room.addClass(state);
      }).on('blur', () => {
        if ($nameInput.val().length < 1) {
          $room.removeClass(state);
          $roomInput.val('');
        }
      });
      $back.on('click', () => {
        $nameInput.val($tmp.name);
        $roomInput.val($tmp.room);
        if ($tmp.length) {
          if ($tmp.name.length >= 1) {
            $room.addClass(state);
          }
        }
        if ($(userInfoChecked, e).val() == 1) {
          $room.removeClass(state);
        } else if ($(userInfoChecked, e).val() == 2) {
          $room.addClass(state);
        }
        $roomInput.next().find('.validator-error').hide();
      });
      $(userInfo, e).on('click', () => {
        if ($(userInfoChecked, e).val() == 1) {
          $room.removeClass(state);
        } else if ($(userInfoChecked, e).val() == 2) {
          if ($nameInput.length && $nameInput.val().length >= 1) {
            $room.addClass(state);
          }
          if ($roomAny.length) {
            $room.addClass(state);
          }
        }
      });
    });
  });
})(jQuery);
// 一括前払いプラン： URLパラメータ引き継ぎ設定スクリプト
var prm;

function retrieveGETqs() {

  var query = window.location.search.substring(1);
  return query;
   /* 引数がない時は処理しない */
  if (!query) return false;

}

$(function(){
  jQuery('a.prm-transfer').click(function() {

  var targetUrl = $(this).attr("href");

  var str = ''
  str = retrieveGETqs();

  if (str) {
    $('a.prm-transfer').attr('href', targetUrl + '?' + str);
  }
 })
})
// 一括前払いプラン： URLパラメータ引き継ぎ設定スクリプト end

//申し込みの時決済ボタン押す処理 start
$(document).ready(function() {
  // 利用：クラスpayment-submit-buttonを付き、data-settlement-typeとdata-draft-entry-idも同じ要素に付けてください
  $('.payment-submit-button').on('click', function() {
    if($(this).data('settlement-type') === undefined || ($(this).data('draft-entry-id') === undefined)) {
      return;
    }
    $.ajax({
      type: 'GET',
      url: '/api/v1/entry_payment_action',
      data: {
        entry_id: $(this).data('draft-entry-id'),
        last_payment_settlement_type: $(this).data('settlement-type')
      },
      dataType: 'json' //データをjson形式で飛ばす
    })
        //↓フォームの送信に成功した場合の処理
        .done(function(data) {

        })
        //↓フォームの送信に失敗した場合の処理
        .fail(function() {

        });
  });
});
//申し込みの時決済ボタン押す処理 end

//法人ページヘッダーメニューのお申し込みボタン
$(document).on('click', function(e) {
  if(!$(e.target).closest('#application-menu').length && !$(e.target).closest('#application-button').length){
    $('#application-menu').hide();
  }else if($(e.target).closest('#application-button').length){
    if($('#application-menu').is(':hidden')){
      $('#application-menu').show();
    }else{
      $('#application-menu').hide();
    }
  }
});
$(document).on('click', function(e) {
  if(!$(e.target).closest('#application-menu-sp').length && !$(e.target).closest('#application-button-sp').length){
    $('#application-menu-sp').hide();
  }else if($(e.target).closest('#application-button-sp').length){
    if($('#application-menu-sp').is(':hidden')){
      $('#application-menu-sp').show();
    }else{
      $('#application-menu-sp').hide();
    }
  }
});
$(function(){
  $('#application-button-sp2').click(function(){
    $('#application-menu-sp2').slideToggle();

    $('li.sp_nav_bond.sp_nav_type02');
  });
});

/**
 * CHARGEプラン(プリペイド)の国内プラン・海外プラン切替処理
 */
$(document).ready(function() {
  $('#domestic-plan').click(function(){
    $('#form-edit-data-flow').show();
    $('.overseas-area').hide();
    $(this).css('background-color', 'white');
    $(this).css('color', '#3C3C3C');
    $('#overseas-plan').css('background-color', '#3C3C3C');
    $('#overseas-plan').css('color', 'white');
  });
  $('#overseas-plan').click(function(){
    $('.overseas-area').show();
    $('#form-edit-data-flow').hide();
    $(this).css('background-color', 'white');
    $(this).css('color', '#3C3C3C');
    $('#domestic-plan').css('background-color', '#3C3C3C');
    $('#domestic-plan').css('color', 'white');
  });
});

// ギガフリーアコーディオン
$(function(){
  $('.js-free-30giga-content').css('display', 'none');
  $('.js-free-30giga-btn, .js-free-30giga-btn-img').on('click', function(){
    $('.js-free-30giga-btn').toggleClass('open');
    $('.js-free-30giga-content').slideToggle(300);
  });
});
$(function(){
  $('.js-free-50giga-content').css('display', 'none');
  $('.js-free-50giga-btn, .js-free-50giga-btn-img').on('click', function(){
    $('.js-free-50giga-btn').toggleClass('open');
    $('.js-free-50giga-content').slideToggle(300);
  });
});
$(function(){
  $('.js-free-100giga-content').css('display', 'none');
  $('.js-free-100giga-btn, .js-free-100giga-btn-img').on('click', function(){
    $('.js-free-100giga-btn').toggleClass('open');
    $('.js-free-100giga-content').slideToggle(300);
  });
});
// ギガスタンダードアコーディオン
$(function(){
  $('.js-std-30giga-content').css('display', 'none');
  $('.js-std-30giga-btn, .js-std-30giga-btn-img').on('click', function(){
    $('.js-std-30giga-btn').toggleClass('open');
    $('.js-std-30giga-content').slideToggle(300);
  });
});
$(function(){
  $('.js-std-50giga-content').css('display', 'none');
  $('.js-std-50giga-btn, .js-std-50giga-btn-img').on('click', function(){
    $('.js-std-50giga-btn').toggleClass('open');
    $('.js-std-50giga-content').slideToggle(300);
  });
});
$(function(){
  $('.js-std-100giga-content').css('display', 'none');
  $('.js-std-100giga-btn, .js-std-100giga-btn-img').on('click', function(){
    $('.js-std-100giga-btn').toggleClass('open');
    $('.js-std-100giga-content').slideToggle(300);
  });
});
// ギガアコーディオンここまで

// 神コスパドロップダウン
$(function(){
  $('.js-cost-content').css('display', 'none');
  $('.js-slidedown-btn').on('click', function(){
    $('.js-slidedown-btn').toggleClass('open');
    $('.js-cost-content').slideToggle(300);
  });
});

// クレディセゾンキャンペーン条件ドロップダウン
$(function() {
  $('.js-saison-campaign-title').click(function () {
      $(".js-saison-campaign-content").toggle();
      $(".js-saison-campaign-title").toggleClass("open");
  });
});

// マイページセゾンカード受付番号入力の受付番号を送信するボタンを活性化
$(function() {
  $(".input-saison-number").on('blur', function() {
    if($(".input-saison-number").val() == "" || $(".input-saison-number").val().length !== 16) {
      $('.saison-number-add').addClass('decoration-button-area-disabled');
      $('.saison-vaidation-error-area').text('16桁でご入力ください。');
    }else {
      $('.saison-number-add').removeClass('decoration-button-area-disabled');
      $('.saison-vaidation-error-area').text('');
    }
  })
});

// 登録できないアドレスプルダウン
$(function() {
    $('.subsc-mail-caution').click(function () {
      $(this).siblings('.subsc-mail-caution-contents').toggle();
      $(this).toggleClass("open");
      if($(this).hasClass("open")){
          $(this).text("登録できないアドレスの詳細はこちら▲");
      }else{
          $(this).text("登録できないアドレスの詳細はこちら▼");
      }
  });
});
