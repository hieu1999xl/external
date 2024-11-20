function currentPathIs(path) {
  // pass parameter like 'faq'
  var a = "/" + path;
  var b = "/" + path + "/";

  return [a, b, path].indexOf(location.pathname) >= 0;
}

/* Page link scroll */
function scrollToHash(target, headerSelector) {
  if(headerSelector === undefined) {
    headerSelector="header";
  }
  if (target.offset() === undefined) return false;
  var speed = 1000;
  var headerHeight = $(headerSelector).height();
  var position = target.offset().top - headerHeight;
  $("html, body").animate({ scrollTop: position }, speed, "swing");
  return false;
}

var globalTopSelectedCountry = "asia";
$(document).ready(function() {

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
        $("#payment-method-creditcard tr").css("display", "");
        $("#editpayment_button_credit").removeClass("editpayment-button-hidden");
        $("#editpayment_button_atone").addClass("editpayment-button-hidden");
        $(".payment-select-caution-hidden").css("display", "");
      } else if (selected_value == "2") {
        $("#payment-method-creditcard tr").css("display", "none");
        $("#payment-method-account-transfer").css("display", "");
      } else if (selected_value == "3") {  // 請求書
        $("#payment-method-creditcard tr").css("display", "none");
        $("#payment-method-invoice").css("display", "");
        $("#payment-method-account-transfer").css("display", "");
      } else if (selected_value == "5") {  // atone
        $(".credit_field").hide();
        $("#credit-description").hide();
        $('#atone-description').show();
        if($('#atone-description').length){
          $('#atone-description').show();
        }

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
      if(window.location.pathname === "/entry/user" || window.location.pathname === "/entry/prepaid/user"){
        $(".mypage-address-info").addClass("not-inputted-items-hidden");
        $("#delivery_info_same").prop("checked",true);
        toggleDeliveryInfoDetail();
      }
    } else if (selected_value == "2") {
      $(".mypage-user-info-detail").removeClass("mypage-user-info-detail-hidden");
      if(window.location.pathname === "/entry/user" || window.location.pathname === "/entry/prepaid/user"){
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
       $(".mypage-user-info-detail").removeClass("mypage-user-info-detail-hidden");
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

  /*支払い情報により表示を変える */
  function togglePaymentInfoDetail() {
    var selected_value = $('input[name="settlement_type"]:checked').val();
    //クレカ(SETTLEMENT_TYPE_VALUE_LIST[CREDIT_CARD])
    if (selected_value == "1") {
      $(".mypage-payment-info-detail-card").show();
      $(".mypage-payment-info-detail-deferred").hide();
      $("#payment_deferred_attention").hide();
      $(".mypage-payment-info-detail-atone").hide();
      $(".atone-draft-section").hide();
      $("div#entry_user_submit").removeClass("decoration-button-area-disabled");
      //後払い(SETTLEMENT_TYPE_VALUE_LIST[CONDO_PAY])
    } else if (selected_value == "5") {
      $(".mypage-payment-info-detail-card").hide();
      $(".mypage-payment-info-detail-atone").show();
      $(".mypage-payment-info-detail-deferred").show();
      $(".atone-draft-section").show();
      $("div#entry_user_submit").addClass("decoration-button-area-disabled");
      $("#payment_deferred_attention").show().html(`<div class="attention">
        <h2 class="attention-head">atone 翌月払い（コンビニ/口座振替）ご選択時の注意事項</h2>
        <ul class="attention-body">
          <li>atoneへお支払いいただく請求手数料として、190円（209円税込）がかかります。口座振替の場合は無料です。</li>
          <li>支払い方法で「atone 翌月払い」を選択された場合、データチャージ・海外データプランのご利用はできません。</li>
        </ul>
        </div>`);
    }
  }
  $(function() {
    togglePaymentInfoDetail();
    $('input[name="settlement_type"]').change(function() {
      togglePaymentInfoDetail();
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
    if(window.location.pathname === "/entry/user" || window.location.pathname === "/entry/prepaid/user"){
      if(selected_value){
        $(".mypage-delivery-info").removeClass("not-inputted-items-hidden");
      }
    }
    if (selected_value == "1"||$('#delivery_info_different2:checked').val() == "2") {
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
    // input#leave-checkboxがあるページにブラウザバックされた場合 チェック処理を行う
    if($("input#leave-checkbox").length > 0){
      window.onpageshow = function(e) {
        if (e.persisted) {
          $("input#leave-checkbox").prop('checked',true).change();
        }
      };
    };
  });

  // LP FAQ collapse
  function toggleFaqTitle(elem) {
    // mypage-faq-answer
    var next = $(elem).next();
    if($(".lp-faq-contents-v2").length > 0){
      // When FAQ v2
      var faqArrowOpenImage = "/assets/img/faq-arrow-open-green.svg";
      var faqArrowCloseImage = "/assets/img/icon-arrow-open.svg";

      var faqQuestionIconOpenImage = "/assets/img/faq-q-green.svg";
      var faqQuestionIconCloseImage = "/assets/img/icon-q.svg";

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
    $(".faq-category-box").removeClass("faq-category-box-selected");
    $(elem).addClass("faq-category-box-selected");

  }

  function faqScrollToHash() {
    var urlHash = location.hash;
    if (!urlHash) {
      return;
    }
    var title = null;
    if (urlHash.indexOf(".") > -1) {
      $(".bg_first_popup").remove();
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
      var target = $(selector);
      scrollToHash(target);
    }
  }

  $(function() {
    faqScrollToHash();
  });

  $('.tab_content a').on("click", function () {
    if ($(this).attr('href').match(/faq\-category\-/)) faqScrollToHash();
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
      var _text1 = $(".select-1").html();
      var _text2 = $(".select-2").html();
      var _text3 = $(".select-3").html();

      var selectedPlan = ".plan-" + $option.val();
      $(".plan-300m").addClass("overseas-table-unselected");
      $(".plan-1g").addClass("overseas-table-unselected");
      $(".plan-3g").addClass("overseas-table-unselected");
      $(selectedPlan).removeClass("overseas-table-unselected");

      if(selectedPlan == ".plan-300m"){
        $("div.overseas-plan-select-sp-div p.label").html(_text1);
      } else if(selectedPlan == ".plan-1g") {
        $("div.overseas-plan-select-sp-div p.label").html(_text2);
      } else {
        $("div.overseas-plan-select-sp-div p.label").html(_text3);
      }
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
        autoplay: {
          delay: 3000,
          disableOnInteraction: true,
          stopOnLastSlide: true,
        },
        pagination: {
          el: ".swiper-my-pagination",
          clickable: true,
          renderBullet: function(index, className) {
            return (
              '<span class="' +
              className +
              '">' +
              '<img src="https://d1q08lkutgkcx2.cloudfront.net/image/terminal0' +
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

    /* special cases*/
    var leaveCheckedExist = $("input#cancel-contract-checkbox").val();
    if(leaveCheckedExist){
      var leaveChecked = $("input#cancel-contract-checkbox").prop("checked");
      var checks = document.getElementsByClassName("leave-survey-answer-checkbox");
      var checks_len = Object.keys(checks).length;
      var checkReason = null;
      for ( i = 0; i < checks_len; i++) {
        if ( checks[i].checked === true && checks[i].offsetHeight > 0 ) {
          checkReason += checks[i].value + " ";
        }
      }
      var passwordText = $("input#leave-password").val();
      if ((leaveCheckedExist && !leaveChecked) || !checkReason || !passwordText) {
        return;
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
    "last_name_kana": "*氏名(カナ)を入力してください。",
    "first_name_kana": "*氏名(カナ)を入力してください。",
    "sex": "*性別を選択してください。",
    "birthday_year": "*生年月日を選択してください。",
    "birthday_month": "*生年月日を選択してください。",
    "birthday_day": "*生年月日を選択してください。",
    "tel1_1": "*電話番号を入力してください。",
    "tel1_2": "*電話番号を入力してください。",
    "tel1_3": "*電話番号を入力してください。",
    "email": "*メールアドレスを入力してください。",
    "email_conf": "*メールアドレス(確認用)を入力してください。",
    "email_confirm": "*メールアドレス(確認用)を入力してください。",

    // address
    "zipcode_1": "*郵便番号を入力してください。",
    "zipcode_2": "*郵便番号を入力してください。",
    "prefecture": "*都道府県を選択してください。",
    "city": "*市区郡を入力してください。",
    "town": "*町名を入力してください。",
    "block": "*番地を入力してください。",
    "room_number": "*部屋番号を入力してください。",

    // address（短期レンタルプラン）
    "rental_zipcode_user": "*発送地域外です。配送先が異なる場合は配送先情報欄にご入力ください。",

    // user
    "user_info": "*ご利用者様情報を選択してください。",
    "user_last_name": "*氏名を入力してください。",
    "user_first_name": "*氏名を入力してください。",
    "user_last_name_kana": "*氏名(カナ)を入力してください。",
    "user_first_name_kana": "*氏名(カナ)を入力してください。",
    "user_tel1_1": "*電話番号を入力してください。",
    "user_tel1_2": "*電話番号を入力してください。",
    "user_tel1_3": "*電話番号を入力してください。",
    "user_zipcode_1": "*郵便番号を入力してください。",
    "user_zipcode_2": "*郵便番号を入力してください。",
    "user_zipcode1": "*郵便番号を入力してください。",
    "user_zipcode2": "*郵便番号を入力してください。",
    "user_prefecture": "*都道府県を選択してください。",
    "user_city": "*市区郡を入力してください。",
    "user_town": "*町名を入力してください。",
    "user_block": "*番地を入力してください。",
    "user_room_number": "*部屋番号を入力してください。",

    // delivery
    "delivery_info": "*配送先情報を選択してください",
    "delivery_last_name": "*氏名を入力してください。",
    "delivery_first_name": "*氏名を入力してください。",
    "delivery_last_name_kana": "*氏名(カナ)を入力してください。",
    "delivery_first_name_kana": "*氏名(カナ)を入力してください。",
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

    // delivery（短期レンタルプラン）
    "rental_delivery_zipcode_user": "*発送地域外です。今後も発送地域を拡大予定です。",

    //corp info
    "corp_company_name": "*法人名（漢字）を入力してください。",
    "corp_company_name_kana" : "*法人名（カナ）を入力してください。",
    "corp_last_name" : "*担当者名（漢字）を入力してください。",
    "corp_first_name" : "*担当者名（漢字）を入力してください。",
    "corp_last_name_kana" : "*担当者名（カナ）を入力してください。",
    "corp_first_name_kana" : "*担当者名（カナ）を入力してください。",
    "corp_tel1_1" : "*電話番号(連絡先1)を入力してください。",
    "corp_tel1_2" : "*電話番号(連絡先1)を入力してください。",
    "corp_tel1_3" : "*電話番号(連絡先1)を入力してください。",
    "corp_email" : "*メールアドレス を入力してください。",
    "corp_email_conf" : "*メールアドレス(確認用)を入力してください。",
    "corp_password" : "*パスワードを入力してください。",
    "corp_password_confirm" : "*パスワード(確認用)を入力してください。",

    //corp_address
    "add_corp_zipcode1": "*郵便番号を入力してください。",
    "add_corp_zipcode2": "*郵便番号を入力してください。",
    "add_corp_prefecture": "*都道府県を選択してください。",
    "add_corp_city": "*市区郡を入力してください。",
    "add_corp_town": "*町名を入力してください。",
    "add_corp_block": "*番地を入力してください。",

    //corp_delivery
    "deliverycorp_info": "*配送先情報を選択してください。",
    "deliverycorp_last_name": "*氏名を入力してください。",
    "deliverycorp_first_name": "*氏名を入力してください。",
    "deliverycorp_last_name_kana": "*氏名(カナ)を入力してください。",
    "deliverycorp_first_name_kana": "*氏名(カナ)を入力してください。",
    "deliverycorp_tel1_1": "*電話番号(連絡先1)を入力してください。",
    "deliverycorp_tel1_2": "*電話番号(連絡先1)を入力してください。",
    "deliverycorp_tel1_3": "*電話番号(連絡先1)を入力してください。",
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
    "invoice_email" : "*請求書送付先メールアドレス を入力してください。",
    "invoice_email_conf" : "*請求書送付先メールアドレス（確認用) を入力してください。",
    "invoice_tel1_1" : "*電話番号を入力してください。",
    "invoice_tel1_2" : "*電話番号を入力してください。",
    "invoice_tel1_3" : "*電話番号を入力してください。",

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
    "contact_email_address_conf":"*メールアドレス(確認用)を入力してください。",
    "corporate_checkbox":"*請求書送付先を選択してください。",
    "payment_due_date_type":"*支払いサイクルを選択してください。",

    // Password
    "password": "*パスワードを入力してください。",
    "password_confirm": "*パスワード(確認用)を入力してください。",
  };
  return hash[name];
}

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
      if(window.location.pathname == "/entry/user" || window.location.pathname === "/entry/prepaid/user"){
        failedItemCounter["form-item-delivery-time"].push(name);
      }else{
        failedItemCounter["form-item-delivery"].push(name);
      }
    }else if(name.indexOf("delivery_") == 0 || ["rental_delivery_zipcode_user"].indexOf(name) > -1){
      failedItemCounter["form-item-delivery"].push(name);
    }else if(name.indexOf("invoice_") == 0 || name == 'corp_contact_info'){  // 請求先情報選択も請求先情報の配列に受け入れる ←TODO:corp_contact_infoの物理名を修正
      failedItemCounter["form-item-corp-contact"].push(name);
    }else if(name.indexOf("corp_") == 0 && name != 'corp_contact_info'){     // 請求先情報選択はご契約法人情報の配列から除く ←TODO:corp_contact_infoの物理名を修正
      failedItemCounter["form-item-corp-info"].push(name);
    }else if(name.indexOf("add_") == 0){
      failedItemCounter["form-item-corp-address"].push(name);
    }else if(["email","email_conf"].indexOf(name) > -1){
      if($("#entry-corp-form")[0]){
        failedItemCounter["form-item-corp-mail"].push(name);
      }else{
        failedItemCounter["form-item-contractor"].push(name);
      }
    }else if(name.indexOf("deliverycorp_") == 0){
      failedItemCounter["form-item-delivery-corp"].push(name);
    }else if(name.indexOf("password") == 0){
      failedItemCounter["form-item-password"].push(name);
    }else if(["rental_zipcode_user", "zipcode_1", "zipcode_2", "prefecture", "city", "town", "block"].indexOf(name) > -1){
      failedItemCounter["form-item-address"].push(name);
    }else if(["rental_zipcode_user", "zipcode_1", "zipcode_2", "prefecture", "city", "town", "block"].indexOf(name) > -1){
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
  ["last_name", "first_name", "last_name_kana", "first_name_kana", "sex", "birthday_year", "birthday_month", "birthday_day", "tel1_1", "tel1_2", "tel1_3", "email", "email_confirm", "email_conf"].forEach(function(v){
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
  ["rental_zipcode_user", "zipcode_1", "zipcode_2", "prefecture", "city", "town", "block", "room_number"].forEach(function(v){
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
  ["user_last_name","user_first_name","user_last_name_kana","user_first_name_kana","user_tel1_1","user_tel1_2","user_tel1_3","user_zipcode_1","user_zipcode_2","user_zipcode1","user_zipcode2","user_prefecture","user_city","user_town","user_block","user_room_number"].forEach(function(v){
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
  ["rental_delivery_zipcode_user","delivery_last_name","delivery_first_name","delivery_last_name_kana","delivery_first_name_kana","delivery_tel1_1","delivery_tel1_2","delivery_tel1_3","delivery_zipcode_1","delivery_zipcode_2","delivery_prefecture","delivery_city","delivery_town","delivery_block","delivery_room_number","delivery_order_time"].forEach(function(v){
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
  ["corp_company_name","corp_company_name_kana","corp_last_name","corp_first_name","corp_last_name_kana","corp_first_name_kana","corp_tel1_1","corp_tel1_2","corp_tel1_3","corp_email","corp_email_conf","corp_password","corp_password_confirm"].forEach(function(v){
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
  ["corp_contact_info","invoice_company_name","invoice_company_name_kana","invoice_department_name","invoice_last_name","invoice_first_name","invoice_last_name_kana","invoice_first_name_kana","invoice_email","invoice_email_conf","invoice_tel1_1","invoice_tel1_2","invoice_tel1_3","corporate_checkbox"].forEach(function(v){
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
  if(failedItemCounter["form-item-address"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-address\")' class='not-inputed-link'><p><u>*ご契約者様住所</u></p></a>");
    invalidSections.push("#not-inputted-items-address");
  }
  if(failedItemCounter["form-item-user-info"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-user-info\")' class='not-inputed-link'><p><u>*ご利用者様について</u></p></a>");
    invalidSections.push("#not-inputted-items-user-info");
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
  scrollToHash(target, "header.mypage-header")
}

function deviceOptionPopupCancelClick(){
  targetHash = "#device-option-error-message";
  hideDeviceOptionPopup();
  var target = $(targetHash);
  scrollToHash(target, "header.mypage-header")
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
}
function hideFormEditPopup(){
  $(".edit-partial-plan").hide();
  $(".edit-partial-device-option").hide();
  $(".edit-partial-device-option-cloud").hide();
  $(".edit-partial-contractor").hide();
  $(".edit-partial-address").hide();
  $(".edit-partial-user").hide();
  $(".edit-partial-delivery").hide();
  $(".edit-partial-corp-contact").hide();
  $(".form-black-background").hide();
  $(".mypage-confirm-hidden-form").hide();
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
    var valDeviceOption = $("input[name='device_option']:checked").val();
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
    }
    else if(valDeviceOption === "false"){
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
  $('#entry-plan-form').submit(function(){
    var valDeviceOption = $("input[name='device_option']:checked").val();
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
    }
    else if(valDeviceOption === ""){
      showDeviceOptionPopup();
      $(this).attr("preventSubumit", "true");
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
  $("#data-charge-agreement-checkbox, #leave-checkbox-plan").prop("checked", false);

  function toggleLeaveCheckBox(){
    var boxes = $('input#data-charge-agreement-checkbox:checked');
    $(".confirm-box").removeClass("confirm-box-selected");
    if(boxes.length > 0){
      $(".confirm-box").addClass("confirm-box-selected");
    }
  }

  $("#data-charge-agreement-checkbox").click(function(){
    toggleLeaveCheckBox();
  });
  toggleLeaveCheckBox();
});

$(document).ready(function() {
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

// Mypage path finder
function currentMypagePathIs(path) {
  if(path === 'password' && location.pathname.indexOf('password') > -1) {
    return true;
  }

  // pass parameter like 'faq'
  var a = "/mypage/" + path;
  var b = "/mypage/" + path + "/";
  var c = "/corpmypage/" + path;
  var d = "/corpmypage/" + path + "/"

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
  $(".tab_content dt").on("click", function () {
      toggleFaqOpenShut(this);
  });
});

function toggleFaqOpenShut(elem, active = false) {
  if (active) {
    $(elem).next().slideDown();
    $(elem).addClass("active");
    return;
  }
  $(elem).next().slideToggle();
  $(elem).toggleClass("active");
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

    if(window.location.pathname === "/qa" || window.location.pathname === "/faq" ){
      endPos =  $(rangeTarget).outerHeight() - (startPos*3);

    }

    if (scroll > startPos && scroll < endPos) {
        $(addTarget).addClass(classname);

    } else {
        $(addTarget).removeClass(classname);


    }
  }
}


$(function(){
  $("#price_fix,.close").click(function(){
    if($("#price_fix,.hint_pop").hasClass("active")){
      $("#price_fix,.hint_pop").removeClass("active");
    }else{
        $("#price_fix,.hint_pop").addClass("active");
    }
  });
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
    var correction = window.innerWidth > 767 ? 0.7 : 0.9;
    endPos = $('footer').offset().top - window.innerHeight + $('footer').outerHeight() * correction;
    if ($('#faq-content').length) { // FAQ
      if (scroll > startPos) {
        $('#price_fix').addClass(classname);
      } else {
        $('#price_fix').removeClass(classname);
      }
      if (scroll > startPos && scroll < endPos) {
        $('#entry_fix').addClass(classname);
      } else {
        $('#entry_fix').removeClass(classname);
      }
    } else {
      if (scroll > startPos && scroll < endPos) {
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
    }else{
        $(".price-fix-hint,.hint_pop").addClass("active");
    }
  });
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
    }else{
        $("#sp-menu,header ul").addClass("clicked");
    }
  });
});

//法人お申し込みページ（１台のみ）必要書類ポップアップ start
  $(document).ready(function() {
  if(!(window.location.pathname === "/entry/corp/select" || window.location.pathname === "/qa" || window.location.pathname === "/faq")){
    return;
  }

  var document_popup = '<div class="document-notion-black-background"></div> <div class="pop-up-news white-content-box-document-notion popup-required-documents"> <div class="document-popup-close-button"><img src="https://d1q08lkutgkcx2.cloudfront.net/image/popup-close.svg"></div> <div class="white-content-box-title white-content-box-title-notion"> <p>必要書類について<span class="sp_br"><br></span>ご確認ください</p> </div> <div class="white-content-box-inner-document"> <div class="white-content-box-body"> <p>法人名義でご契約の場合、法人申込書とあわせ、ご契約担当者様の本人確認のため、以下①②③の確認書類の写しの提出が必要となります。</p><div class="div-pc"> <table border="3" style="width:100%;border-collapse: collapse"> <thead style="border-bottom:0.35em double;"> <tr> <th></th> <th>確認書類</th> <th>備考</th> </tr> </thead> <tbody> <tr> <th>①契約法人の確認書類<br/>(右記のいずれか1点)</th> <td> <p>・登記簿謄(抄)本<br/>・現在(履歴)事項証明書<br/>・印鑑証明書 </p> </td> <td> <p>※契約法人名・契約住所と一致していることが必要です。<br/>※発行日から3ヶ月以内であることが必要です。</p> </td> </tr> <tr> <th>②申込者本人確認書類<br/>(右記のいずれか1点)</p></th> <td> <p>・運転免許証<br/>・日本国パスポート<br/>・マイナンバーカード<br/>・健康保険証＋補助書類 </p> </td> <td> <p>※マイナンバー通知カードは受付不可。<br/>※補助書類については、以下「◆補助書類について」参照。</p> </td> </tr> <tr> <th>③申込者の在籍確認書類<br/>(右記のいずれか1点)</th> <td> <p>・社員証<br/>・名刺<br/> ・健康保険証 </p> </td> <td> <p>※契約法人名と同一法人名が記載されていることが必要です。</p> </td> </tr> <tr> <th>◆補助書類について</th> <td> <p>・公共料金等の請求及び領収書<br/>・官公庁発行の印刷物<br/>・住民票記載事項証明書<br/>・住居証明書(住居証明書発給請求書)<br/>・届出避難場所証明書 </p> </td> <td> <p>※健康保険証の氏名と一致していることが必要です。<br/>※発行日から3ヶ月以内であることが必要です。<br/>※届出避難場所証明書については、発行日から6ヶ月以内まで受付可。</p> </td> </tr> </tbody> </table> </div> <div class="div-sp"> <table border="3" style="width:100%;border-collapse: collapse"> <thead style="border-bottom:3px double;"> <tr> <th colspan="2">①契約法人の確認書類<br/>(下記のいずれか1点)</th> </tr> </thead> <tbody> <tr> <th style="width:45%">確認書類</th> <th>備考</th> </tr> <tr> <td> <p>・登記簿謄(抄)本<br/>・現在(履歴)事項証明書<br/>・印鑑証明書 </p> </td> <td> <p>※契約法人名・契約住所と一致していることが必要です。<br/>※発行日から3ヶ月以内であることが必要です。</p> </td> </tr> </tbody> <thead style="border-top:3px solid;border-bottom:3px double;"> <tr> <th colspan="2">②申込者本人確認書類<br/>(下記のいずれか1点)</p></th> </tr> </thead> <tbody> <tr> <th>確認書類</th> <th>備考</th> </tr> <tr> <td> <p>・運転免許証<br/>・日本国パスポート<br/>・マイナンバーカード<br/>・健康保険証＋補助書類 </p> </td> <td> <p>※マイナンバー通知カードは受付不可。<br/>※補助書類については、以下「◆補助書類について」参照。</p> </td> </tr> </tbody> <thead style="border-top:3px solid;border-bottom:3px double;"> <tr> <th colspan="2">③申込者の在籍確認書類<br/>(下記のいずれか1点)</th> </tr> </thead> <tbody> <tr> <th>確認書類</th> <th>備考</th> </tr> <tr> <td> <p>・社員証<br/>・名刺<br/>・健康保険証 </p> </td> <td> <p>※契約法人名と同一法人名が記載されていることが必要です。</p> </td> </tr> </tbody> <thead style="border-top:3px solid;border-bottom:3px double;"> <tr> <th colspan="2">◆補助書類について</th> </tr> </thead> <tbody> <tr><th>確認書類</th><th>備考</th> </tr> <tr> <td> <p>・公共料金等の請求及び領収書<br/>・官公庁発行の印刷物<br/>・住民票記載事項証明書<br/>・住居証明書(住居証明書発給請求書)<br/>・届出避難場所証明書 </p></td> <td> <p>※健康保険証の氏名と一致していることが必要です。<br/>※発行日から3ヶ月以内であることが必要です。<br/>※届出避難場所証明書については、発行日から6ヶ月以内まで受付可。</p> </td> </tr> </tbody> </table> </div> <p class="document-description">お申し込み完了後、書類アップロード用のURLをメールにて送付いたします。</p> <p>予め上記書類の準備をお願いいたします。</p> </div> </div></div>';

  $("body").append(document_popup);
  if(window.location.pathname === "/faq" || window.location.pathname === "/qa"){
    hideCorpApplyDocumentPopup();
  }else{
    showCorpApplyDocumentPopup();
  }

//隠す
  function hideCorpApplyDocumentPopup(){
    $(".document-notion-black-background").hide();
    $(".white-content-box-document-notion").hide();
  }
  $(".document-notion-black-background").click(function(){
    hideCorpApplyDocumentPopup();
  })
  $(".document-popup-close-button").click(function(){
    hideCorpApplyDocumentPopup();
  })
  $(".doc-pop").click(function(){
    showCorpApplyDocumentPopup();
  })

});
   //見せる
  function showCorpApplyDocumentPopup(){
    $(".document-notion-black-background").show();
    $(".white-content-box-document-notion").show();
  }
//法人お申し込みページ（１台のみ）必要書類ポップアップ end

/*秋キャンペーン*/

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

// 一括オプション解約のURLへ遷移する
function linkToBulkOptionCancelURL(class_name){
  let get_url = '';
  let get_params = [];
  $(class_name+':checked').each(function(i, elem){
    get_params.push( 'ids[]=' + $(elem).val() ) ;
  });
  get_url = get_params.join('&');
  window.location.href = '/mypage/contract/bulk_option_cancel?' + get_url;
}

$(function() {
  $("#toggleimg").click(function(){
    $(".how-to-get").slideToggle();
    $(".how-to-get").toggleClass("open");
    $(".toggle").toggleClass("open");
  });
});

$(function() {

  $('.uk-tile').mouseleave(function() {
        $('.uk-drop').addClass('uk-drop-close');
  });

  $('.toggle-bgc').hover(function (){
    $('.uk-drop').removeClass('uk-drop-close');
  });
});

// $(document).ready(function() {
//   if($('div').hasClass('form-application-container')){
//     return;
//   }else{

//     jQuery(function(){
//       if( window.matchMedia('(max-width:767px)').matches ){
//         var headerHight = 77; //ヘッダの高さ
//         jQuery('a[href^="#"]').click(function () {
//           if ($(this).attr('href').match(/faq\-category\-/)) return;
//           var href= jQuery(this).attr("href");
//           var target = jQuery(href == "#" || href == "" ? 'html' : href);
//           var position = target.offset().top-headerHight; //ヘッダの高さ分位置をずらす
//           jQuery("html, body").animate({scrollTop:position}, 550, "swing");
//           return false;
//         });
//       }
//     });

//     jQuery(function(){
//       if( window.matchMedia('(min-width:768px)').matches ){
//         var headerHight = 87; //ヘッダの高さ
//         jQuery('a[href^="#"]').not('#entry-plan-form').click(function () {
//           if ($(this).attr('href').match(/faq\-category\-/)) return;
//           var href= jQuery(this).attr("href");
//           var target = jQuery(href == "#" || href == "" ? 'html' : href);
//           var position = target.offset().top-headerHight; //ヘッダの高さ分位置をずらす
//           jQuery("html, body").animate({scrollTop:position}, 550, "swing");
//           return false;
//         });
//       }
//     });
//   }
// });

//ヘッダー　スクロールしたら影を表示
$(window).scroll(function () {
  if($(window).scrollTop() > 20) {
    $('header').addClass('scroll');
  } else {
    $('header').removeClass('scroll');
  }
});

//マイページ　ナビの表示を切り替える
$(document).ready(function() {
  if(window.location.pathname === "/login" || window.location.pathname === "/password/forget" || window.location.pathname === "/password/forget/complete" || window.location.pathname === "/loginid/forget" || window.location.pathname === "/loginid/forget/complete"){
    $(".mypage-nav-wrapper").hide();
  }else{
    $(".mypage-nav-wrapper").show();
  }
});

// //
// Capacity
// //
$(document).ready(function() {
  function selectCapacity(target) {
      var checkBox = $(target).siblings(".form-capacity-select-checkbox-area").find("input");
      checkBox.prop('checked', true);
      $(".form-capacity-select-area").removeClass("selected");
      $(target).addClass("selected");
      updateSummary();
      updateCorpSummary();
      updateSpecialSummary();
      updatePrepaidSummary();
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
          targetButton.find(".pull-down-arrow-to-open").hide();
          targetButton.find(".pull-down-arrow-to-close").show();
          targetButton.addClass("form-capacity-pull-down-button-open");
          // if (ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
          //   var targetButton2 = $(".form-capacity-pull-down-button-right");
          //   var target2 = $('.form-capacity-description-body-right');
          //   if(targetButton2.hasClass("form-capacity-pull-down-button-open")){
          //     target2.addClass("hidden");
          //     targetButton2.find(".pull-down-arrow-to-close").hide();
          //     targetButton2.find(".pull-down-arrow-to-open").show();
          //     targetButton2.removeClass("form-capacity-pull-down-button-open");
          //   }
          // }
      }else{
          target.addClass("hidden");
          targetButton.find(".pull-down-arrow-to-close").hide();
          targetButton.find(".pull-down-arrow-to-open").show();
          targetButton.removeClass("form-capacity-pull-down-button-open");
      }
  });
})

//オプション「つけない」のアラート start
$(document).ready(function () {

  var document_popup = '<div class="alart-notion-black-background"></div><div class="pop-up-news white-content-box-alart-notion"><div class="alart-popup-close-button"><i class="fas fa-times"></i></div><img src="/assets/img/option-alart.svg" class="device-alart" width="150" height="150"><div class="option-check"><label class="custom-check-box-v2" for="option-checkbox-true">加入する<input id="option-checkbox-true" type="radio" name="device_option" value="true"><span></span></label><label class="custom-check-box-v2" for="option-checkbox-false">加入しない<input id="option-checkbox-false" type="radio" name="device_option" value="false"><span></span></label></div><div class="custom-check-box-v2 option-check btn-option-close">プラン選択に戻る</div></div>';

  // var document_popup2 = '<div class="pop-up-news white-content-box-alart-notion" id="device_option_check2"><div class="alart-popup-close-button"><i class="fas fa-times"></i></div><img src="/assets/img/option-alart02.svg" class="device-alart" width="500" height="500"><div class="option-check"><label class="custom-check-box-v2" for="option2-checkbox-true">加入する<input id="option2-checkbox-true" type="radio" name="device_option2" value="true"><span></span></label><label class="custom-check-box-v2" for="option2-checkbox-false">加入しない<input id="option2-checkbox-false" type="radio" name="device_option2" value="false"><span></span></label></div><div class="custom-check-box-v2 option-check btn-option-close">プラン選択に戻る</div></div>';

  $("body").append(document_popup);
  hideOptionAlart();

  //アラート内のボタン部分
  $(function(){
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
  });

  function hideOptionAlart(){
    $(".alart-notion-black-background").hide();
    $(".white-content-box-alart-notion").hide();
  }

  //アラートの確認で選択した方にチェックを入れる
  $(function() {
    $(".alart-notion-black-background,.alart-popup-close-button,.btn-option-close").click(function(){
      var checkFalse = $("#option-checkbox-false").prop("checked");

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
      hideOptionAlart();
    });
  });
});

//アラート表示
function showOptionAlart(){

  if($("#device_option_false").prop("checked")){
    return;
  }else{
    $("input[id='option-checkbox-true']").parent(".custom-check-box-v2").addClass("check-option");
    $("input[id='option-checkbox-false']").parent(".custom-check-box-v2").removeClass("check-option");
    $("#option-checkbox-true").prop("checked", true);
    $(".alart-notion-black-background").show();
    $(".white-content-box-alart-notion").show();
  }
};

// function showOptionAlart2(){
//   if(!($("#option2").prop("checked"))){
//     return;
//   }else{
//     $("input[id='option2-checkbox-true']").parent(".custom-check-box-v2").addClass("check-option");
//     $("input[id='option2-checkbox-false']").parent(".custom-check-box-v2").removeClass("check-option");
//     $("#option2-checkbox-true").prop("checked", true);
//     $(".alart-notion-black-background").show();
//     $("#device_option_check2").show();
//   }
// }

$(function() {
  $(".cashback-detail-title").click(function(){
    $(this).siblings("div").slideToggle(150);
    $(".cashback-detail-title").toggleClass("open");
  });
  $(".cashback-flow-title").click(function(){
    $(this).siblings("div").slideToggle(150);
    $(".cashback-flow-title").toggleClass("open");
  });
});

// GoGoキャンペーン
$(function() {
  $(".gogo-campaign-flow-title").click(function(){
    $(this).siblings("div").slideToggle(150);
    $(".gogo-campaign-flow-title").toggleClass("open");
  });
});

// オプション SPプルダウン start
$(function() {
  $(".plan-detail-title-1").click(function(){
    $(this).siblings("div").slideToggle(150);
    $(".plan-detail-title-1").toggleClass("open");
  });
  $(".plan-detail-title-2").click(function(){
    $(this).siblings("div").slideToggle(150);
    $(".plan-detail-title-2").toggleClass("open");
  });
  $(".plan-detail-title-3").click(function(){
    $(this).siblings("div").slideToggle(150);
    $(".plan-detail-title-3").toggleClass("open");
  });
  $(".plan-detail-title-4").click(function(){
    $(this).siblings("div").slideToggle(150);
    $(".plan-detail-title-4").toggleClass("open");
  });
});
// オプション SPプルダウン end

//スライドショー
$(window).on('load', function() {
  if(window.location.pathname === "/"){
    $('.slider').slick({
      accessibility: true,
      autoplay: true,
      autoplaySpeed: 5000,
      dots: false,
      fade: true,
    });
  }
});

//マイページ 解約申請した人向けWiMAX乗り換えの案内
//ポップアップ start
$(document).ready(function() {

  function hideTransferPopup(){
    $(".transfer-notion-black-background").hide();
    $(".white-content-box-transfer-notion").hide();
  }

  showTransferPopup();

  $(".transfer-notion-black-background,.transfer-popup-close-button").click(function(){
    hideTransferPopup();
  });
});

function showTransferPopup(){
  $(".transfer-notion-black-background").show();
  $(".white-content-box-transfer-notion").show();
}


//マイページ 解約申請した人向け ご契約者限定（ワンコインプラン）乗り換え
//ポップアップ start
$(document).ready(function() {

  function hideTransfer2Popup(){
    $(".transfer-notion-black-background").hide();
    $(".white-content-box-transfer-notion").hide();
  }

  showTransfer2Popup();

  $(".transfer-notion-black-background,.transfer-popup-close-button").click(function(){
    hideTransfer2Popup();
  });
});

function showTransfer2Popup(){
  $(".transfer-notion-black-background").show();
  $(".white-content-box-transfer-notion").show();
}

$(function() {
  $(".user-flow-title").click(function(){
    $(".user-flow-detail").slideToggle();
    $(".user-flow-title").toggleClass("open");
  });
  $(".user-flow-detail-close").click(function(){
    $(".user-flow-detail").slideToggle();
    $(".user-flow-title").toggleClass("open");
  });
  $(".rental-entry-pop img").click(function(){
    $(".rental-entry-pop").fadeOut(150);
  });
  $('.rental a[href*="#"]').click(function () {
    var target = $(this.hash);
    scrollToHash(target, "header");
  });
  // リチャージプラン
  $('#recharge a[href*="#"]').click(function (e) {
    if (location.href.match(/\/recharge\/.+/)) return;
    if (!$(this).attr('href').match(/\/recharge#/)) return;
    e.preventDefault();
    var target = $(this.hash);
    scrollToHash(target, "header");
  });
});

function getMinDate(min_days){
  var entryDate = new Date();
  entryDate.setDate(entryDate.getDate() + parseInt(min_days));
  var result = entryDate.getMonth()+1 + "月" + entryDate.getDate() + "日";
  $(".rental-entry-btn-detail span").html(result);
}

// 短期レンタルプラン マイページの返却方法まで移動
$(function() {
  // URLパラメーターの取得
  var search = $(location).attr('search');
  var headerHight = 80; //ヘッダの高さ
  // 正規表現でreturn-rental-deviceが含まれている場合を検索
  if(search.match(/return-rental-device/)){
    // #user-edit-formまでスクロールする
    $("html,body").animate({scrollTop:$('#user-edit-form').offset().top-headerHight}, 550, "swing");
  }
});

// リピートレンタルページの場合、bodyにclass追加
$(function() {
  if(window.location.pathname === "/mypage/contract/repeat"){
    $("body").addClass("repeat-rental");
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

// お知らせ見本 start
// //海外データプラン利用料改定のご案内 start
// $(document).ready(function() {
//   var _html = ''
//   + '<div class="under-kv-notion">'
//   +   '<div class="under-kv-notion-inner">'
//   +     '<p class="under-kv-notion-title">'
//   +       '<a href="javascript:showOverseasPricePopup()">'
//   +         '<img class="important-mark" alt="重要なお知らせ" width="300" height="139" src="https://shibarinashi-wifi.jp/assets/img/important-mark.svg?1669860730">'
//   +         '海外データプラン利用料改定のご案内'
//   +       '</a>'
//   +     '</p>'
//   +   '</div>'
//   + '</div>';

//   if(window.location.pathname == "/"){
//     $(".top-kv").after(_html);
//   }else if(window.location.pathname === "/mypage/overseas"){
//     $(".mypage-nav-wrapper").after(_html);
//     $(".under-kv-notion").addClass("mypage-under-kv-notion");
//   }else{
//     return;
//   }

//   var top_notion_popup = ''
//   + '<div class="overseas-price-notion-black-background"></div>'
//   + '<div class="pop-up-news white-content-box-overseas-price-notion">'
//   +   '<div class="overseas-price-popup-close-button">'
//   +     '<img src="/assets/img/popup-close.svg">'
//   +   '</div>'
//   +   '<div class="white-content-box-title white-content-box-title-notion white-content-box-title-uknetworkfault">'
//   +     '<p>海外データプラン<br class="sp">利用料改定のご案内</p>'
//   +   '</div>'
//   +   '<div class="white-content-box-inner-overseas-price">'
//   +     '<div class="white-content-box-body">'
//   +       '<p>日頃より縛りなしWiFiをご愛顧いただきまして、誠にありがとうございます。</p>'
//   +       '<br>'
//   +       '<p>海外データプランにつきまして、2023年2月20日以降のご購入分より料金改定させていただきます。</p>'
//   +       '<p>改定後の料金は<a href="/overseas_price_20230220" target="_blank" class="pink-link">こちら</a>。</p>'
//   +       '<br>'
//   +       '<p>なお、ご利用日にかかわらず2023年2月20日までに海外データプランをご購入いただいた場合は、改定前の料金となります。</p>'
//   +       '<p>（海外データプランが未使用の場合でも、海外データプラン購入日から180日後に失効となりますので、ご注意ください。）</p>'
//   +       '<br>'
//   +       '<p>ご不明な点がございましたらサポート窓口までご連絡いただきますようお願いいたします。</p>'
//   +     '</div>'
//   +   '</div>'
//   + '</div>';

//   $("body").append(top_notion_popup);
//   hideOverseasPricePopup();

//   $(".overseas-price-notion-black-background").click(function(){
//     hideOverseasPricePopup();
//   })
//   $(".overseas-price-popup-close-button").click(function(){
//     hideOverseasPricePopup();
//   })
// });

// function showOverseasPricePopup(){
//   $(".overseas-price-notion-black-background").show();
//   $(".white-content-box-overseas-price-notion").show();
// }

// function hideOverseasPricePopup(){
//   $(".overseas-price-notion-black-background").hide();
//   $(".white-content-box-overseas-price-notion").hide();
// }
// //海外データプラン利用料改定のご案内 end
// お知らせ見本 end

//キャッシュバックキャンペーン start
$(document).ready(function() {
  if(!window.location.pathname.includes("/campaign_archive")){
    return;
  }
  var _html = ''
  _html += '<div class="info-content"><div class="info-date">2022年4月1日～2022年6月30日</div><a href="javascript:showCashBackNotionPopup()" class="campaign-link"><div class="info-title">キャッシュバックキャンペーン</div></a></p>';

  console.log(_html)
  $("div.white-content-box-inner div.white-content-box-area").after(_html);

  var top_notion_popup = '<div class="cashback-notion-black-background"></div>'
  + '<div class="pop-up-news white-content-box-cashback-notion"><div class="cashback-popup-close-button">'
  + '<img src="https://d1q08lkutgkcx2.cloudfront.net/image/popup-close.svg"></div><div class="white-content-box-title white-content-box-title-notion"><p>'
  + 'キャッシュバックキャンペーン'
  + '</p></div><div class="white-content-box-inner-cashback"><div class="white-content-box-body"><div class="debut-description">'
  + '<div class="campaign-archive-description"><div class="campaign-archive-description-img-box">'
  + '<img src="/assets/img/banner_cashback_campaign.svg" alt="キャッシュバックキャンペーン"></div></div><div class="debut-description-period"><div class="debut-description-period-title"><div class="blue-box"><p>'
  + 'キャンペーン期間'
  + '</p></div></div><div class="debut-description-period-desciption"><p>'
  + '2022年4月1日～2022年6月30日※１'
  + '</p></div></div><div class="debut-description-body"><div class="debut-description-body-title"><div class="blue-box"><p>'
  + 'キャンペーン内容'
  + '</p></div></div><div class="debut-description-body-desciption">'
  + '<p>下記の「キャンペーン対象条件」を満たしたお客様を対象に下記金額をキャッシュバック致します。※２</p>'
  + '<p>縛りなし 10GB プラン（契約期間なし）：11,340 円キャッシュバック</p>'
  + '<p>縛りなし 30GB プラン（契約期間なし）：10,720 円キャッシュバック</p>'
  + '<p>縛りなし 60GB プラン（契約期間なし）：13,920 円キャッシュバック</p>'
  + '<p>縛りなし 90GB プラン（契約期間なし）：15,920 円キャッシュバック</p>'
  + '</div></div><div class="debut-description-body"><div class="debut-description-body-title"><div class="blue-box"><p>'
  + 'キャンペーン対象条件'
  + '</p></div></div><div class="debut-description-body-desciption">'
  + '<p>・キャンペーン期間中、下記プランを個人名義でご契約されたお客様。</p>'
  + '<p>縛りなし 10GB プラン（契約期間なし）</p>'
  + '<p>縛りなし 30GB プラン（契約期間なし）</p>'
  + '<p>縛りなし 60GB プラン（契約期間なし）</p>'
  + '<p>縛りなし 90GB プラン（契約期間なし）</p>'
  + '<p>・課金開始月を 1 ヶ月目として 12 ヶ月目の末日（以下、「キャッシュバック判定日」といいます）まで継続利用の確認が取れたお客様。（解約された場合は、キャンペーン対象外となります。）</p>'
  + '<p>・縛りなし WiFi の料金の未払いや滞納が 1 度もないお客様。</p>'
  + '<p>・2023 年 3 月に、当社より送付するメールから期日内にアンケートにご回答頂いたお客様。（申込時にご登録頂いたメールアドレス宛に送付致します。）</p>'
  + '<p>・2023 年 4 月に、当社より送付するメールから期日内にキャッシュバックのお手続きを行って頂いたお客様。（申込時にご登録頂いたメールアドレス宛に送付致します。）</p><br>'
  + '<p class="remark-text">・注意事項</p>'
  + '<p class="remark-text">※１：本キャンペーンは、予告なく終了または変更する場合があります。</p>'
  + '<p class="remark-text">※２：キャッシュバックは「RealPay ギフト」にて選べるギフトコードの URL を送付致します。（ギフトコードは PayPay/Amazon ギフト券/LINEpay 等と引き換え可能です。URLには引き換え期限があります。ギフトコードの URL については理由の如何を問わず再送致しかねます。）また、状況により「Real Pay ギフト」ではなく他の方法にて実施する場合があります。</p>'
  + '</p></div></div>'
  + '<div class="debut-description-body"><div class="debut-description-body-title"><div class="blue-box"><p>'
  + 'キャンペーン対象外条件'
  + '</p></div></div><div class="debut-description-body-desciption">'
  + '<p>・法人契約のお客様</p>'
  + '<p>・キャッシュバック判定日までに縛りなし WiFi を解約されたお客様</p>'
  + '<p>・縛りなし WiFi の料金の未払いや滞納の履歴があるお客様</p>'
  + '<p>・当社からのアンケートに未回答のお客様</p>'
  + '<p>・ギフトコードの URL からギフトコードの引き換えを行わなかったお客様</p>'
  + '</div></div>'
  + '</div></div></div></div></div></div></div></div>'

    $("body").append(top_notion_popup);
    hideCashBackNotionPopup();

    function hideCashBackNotionPopup(){
      $(".cashback-notion-black-background").hide();
      $(".white-content-box-cashback-notion").hide();
    }
    $(".cashback-notion-black-background").click(function(){
      hideCashBackNotionPopup();
    })
    $(".cashback-popup-close-button").click(function(){
      hideCashBackNotionPopup();
    })
  });

  function showCashBackNotionPopup(){
    $(".cashback-notion-black-background").show();
    $(".white-content-box-cashback-notion").show();
  }
//キャッシュバックキャンペーン end

//はじめておトクキャンペーン（春トクキャンペーン） start
$(document).ready(function() {
  if(!window.location.pathname.includes("/campaign_archive")){
    return;
  }
  var _html = ''
  _html += '<div class="info-content"><div class="info-date">2022年3月10日～2023年2月8日</div><a href="javascript:showFirstAdvantageNotionPopup()" class="campaign-link"><div class="info-title">はじめておトクキャンペーン（春トクキャンペーン）</div></a></p>';

  console.log(_html)
  $("div.white-content-box-inner div.white-content-box-area").after(_html);

  var top_notion_popup = '<div class="firstadvantage-notion-black-background"></div>'
  + '<div class="pop-up-news white-content-box-firstadvantage-notion"><div class="firstadvantage-popup-close-button">'
  + '<img src="https://d1q08lkutgkcx2.cloudfront.net/image/popup-close.svg"></div>'
  + '<div class="white-content-box-title white-content-box-title-notion"><p>'
  + 'はじめておトクキャンペーン（春トクキャンペーン）'
  + '</p></div><div class="white-content-box-inner-firstadvantage"><div class="white-content-box-body"><div class="debut-description">'
  + '<div class="campaign-archive-description"><div class="campaign-archive-description-img-box">'
  + '<img src="/assets/img/banner_first_advantage_campaign.svg" alt="はじめておトクキャンペーン（春トクキャンペーン）"></div></div>'
  + '<div class="debut-description-period"><div class="debut-description-period-title"><div class="blue-box"><p>'
  + 'キャンペーン期間'
  + '</p></div></div><div class="debut-description-period-desciption"><p>'
  + '2022年3月10日～2023年2月8日※１'
  + '</p></div></div><div class="debut-description-body"><div class="debut-description-body-title"><div class="blue-box"><p>'
  + 'キャンペーン内容'
  + '</p></div></div><div class="debut-description-body-desciption">'
  + '<p>課金開始月から契約終了月まで、月額基本料を下記の通りと致します。※２</p>'
  + '<p>縛りなし 10GB プラン（契約期間なし）1,719 円（1,890 円税込）</p>'
  + '<p>縛りなし 30GB プラン（契約期間なし）2,437 円（2,680 円税込）</p>'
  + '<p>縛りなし 60GB プラン（契約期間なし）3,164 円（3,480 円税込）</p>'
  + '<p>縛りなし 90GB プラン（契約期間なし）3,619 円（3,980 円税込）</p>'
  + '</div></div><div class="debut-description-body"><div class="debut-description-body-title"><div class="blue-box">'
  + '<p>キャンペーン対象条件</p>'
  + '</div></div><div class="debut-description-body-desciption">'
  + '<p>キャンペーン期間中に、</p>'
  + '<p>縛りなし 10GB プラン（契約期間なし）</p>'
  + '<p>縛りなし 30GB プラン（契約期間なし）</p>'
  + '<p>縛りなし 60GB プラン（契約期間なし）</p>'
  + '<p>縛りなし 90GB プラン（契約期間なし）</p>'
  + '<p>をご契約頂いたお客様が対象となります。</p><br>'
  + '<p class="remark-text">・注意事項</p>'
  + '<p class="remark-text">※１：本キャンペーンは、予告なく終了又は変更する場合があります。</p>'
  + '<p class="remark-text">※２：本サービスの初月基本料は、</p>'
  + '<p class="remark-text">縛りなし 10GB プラン（契約期間なし）1,980 円（2,178 円税込）</p>'
  + '<p class="remark-text">縛りなし 30GB プラン（契約期間なし）2,980 円（3,278 円税込）</p>'
  + '<p class="remark-text">縛りなし 60GB プラン（契約期間なし）3,730 円（4,103 円税込）</p>'
  + '<p class="remark-text">縛りなし 90GB プラン（契約期間なし）4,380 円（4,818 円税込）</p>'
  + '<p class="remark-text">の日割計算となりますが、本キャンペーン適用のお客様は、キャンペーン価格の月額基本料の日割計算となります。</p>'
  + '</div></div>'
  + '</div></div></div></div>'

    $("body").append(top_notion_popup);
    hideFirstAdvantageNotionPopup();

    function hideFirstAdvantageNotionPopup(){
      $(".firstadvantage-notion-black-background").hide();
      $(".white-content-box-firstadvantage-notion").hide();
    }
    $(".firstadvantage-notion-black-background").click(function(){
      hideFirstAdvantageNotionPopup();
    })
    $(".firstadvantage-popup-close-button").click(function(){
      hideFirstAdvantageNotionPopup();
    })
  });

  function showFirstAdvantageNotionPopup(){
    $(".firstadvantage-notion-black-background").show();
    $(".white-content-box-firstadvantage-notion").show();
  }
//はじめておトクキャンペーン（春トクキャンペーン） end

//キャッシュバックキャンペーン 第2弾  start
$(document).ready(function() {
  if(!window.location.pathname.includes("/campaign_archive")){
    return;
  }
  var _html = ''
  _html += '<div class="info-content"><div class="info-date">2022年6月10日～2023年2月8日</div><a href="javascript:showCashBack2NotionPopup()" class="campaign-link"><div class="info-title">キャッシュバックキャンペーン 第2弾</div></a></p>';

  console.log(_html)
  $("div.white-content-box-inner div.white-content-box-area").after(_html);

  var top_notion_popup = '<div class="cashback2-notion-black-background"></div>'
  + '<div class="pop-up-news white-content-box-cashback2-notion"><div class="cashback2-popup-close-button">'
  + '<img src="https://d1q08lkutgkcx2.cloudfront.net/image/popup-close.svg"></div><div class="white-content-box-title white-content-box-title-notion"><p>'
  + 'キャッシュバックキャンペーン 第2弾'
  + '</p></div><div class="white-content-box-inner-cashback2"><div class="white-content-box-body"><div class="debut-description">'
  + '<div class="campaign-archive-description"><div class="campaign-archive-description-img-box">'
  + '<img src="/assets/img/banner_cashback_campaign2.svg" alt="キャッシュバックキャンペーン 第2弾"></div></div>'
  + '<div class="debut-description-period"><div class="debut-description-period-title"><div class="blue-box"><p>'
  + 'キャンペーン期間'
  + '</p></div></div><div class="debut-description-period-desciption"><p>'
  + '2022年6月10日～2023年2月8日※１'
  + '</p></div></div>'
  + '<div class="debut-description-body"><div class="debut-description-period-title"><div class="blue-box"><p>'
  + 'キャンペーン内容'
  + '</p></div></div><div class="debut-description-period-desciption">'
  + '<p>下記の「キャンペーン対象条件」を満たしたお客様を対象に 10,000 円をキャッシュバック致します。※２</p>'
  + '</div></div>'
  + '<div class="debut-description-body"><div class="debut-description-body-title"><div class="blue-box"><p>'
  + 'キャンペーン対象条件'
  + '</p></div></div>'
  + '<div class="debut-description-body-desciption">'
  + '<p>・キャンペーン期間中、下記プランを個人名義でご契約されたお客様。</p>'
  + '<p>縛りなし 10GB プラン（契約期間なし）</p>'
  + '<p>縛りなし 30GB プラン（契約期間なし）</p>'
  + '<p>縛りなし 60GB プラン（契約期間なし）</p>'
  + '<p>縛りなし 90GB プラン（契約期間なし）</p>'
  + '<p>・プラン申込と同時に、クラウドバックアップ Home 及びデータ復旧サービスをご契約されたお客様。※3</p>'
  + '<p>・課金開始月を 1 ヶ月目として 12 ヶ月目の末日（以下、「キャッシュバック判定日」といいます）まで縛りなし WiFi の継続利用の確認が取れたお客様。（解約された場合は、キャンペーン対象外となります。）</p>'
  + '<p>・縛りなし WiFi、クラウドバックアップ Home 及びデータ復旧サービスの料金の未払いや滞納が 1 度もないお客様。</p>'
  + '<p>・縛りなし WiFi の課金開始月を 1 ヶ月目として 12 ヶ月目にメールにて送付するアンケートに対して、当該メールにて定める期日内に当該アンケートにご回答頂いたお客様。（申込時にご登録頂いたメールアドレス宛に送付致します。）</p>'
  + '<p>・縛りなし WiFi の課金開始月を 1 ヶ月目として 13 ヶ月目にメールにて送付するキャッシュバック手続きを、当該メールにて定める期間内に不足なく行って頂いたお客様。（申込時にご登録頂いたメールアドレス宛に送付致します。）</p><br>'
  + '<p class="remark-text">・注意事項</p>'
  + '<p class="remark-text">※１：本キャンペーンは、予告なく終了又は変更する場合があります。</p>'
  + '<p class="remark-text">※２：キャッシュバックは「RealPay ギフト」にて選べるギフトコードの URL を送付致します。（ギフトコードは PayPay/Amazon ギフト券/LINEpay 等と引き換え可能です。URLには引き換え期限があります。ギフトコードの URL については理由の如何を問わず再送致しかねます。）また、状況により「Real Pay ギフト」ではなく他の方法にて実施する場合があります。</p>'
  + '<p class="remark-text">※３：クラウドバックアップ Home、データ復旧サービスは、株式会社アクセルが提供するオプションサービスです。</p>'
  + '</p></div></div>'
  + '<br></div></div></div></div></div></div>'

    $("body").append(top_notion_popup);
    hideCashBack2NotionPopup();

    function hideCashBack2NotionPopup(){
      $(".cashback2-notion-black-background").hide();
      $(".white-content-box-cashback2-notion").hide();
    }
    $(".cashback2-notion-black-background").click(function(){
      hideCashBack2NotionPopup();
    })
    $(".cashback2-popup-close-button").click(function(){
      hideCashBack2NotionPopup();
    })
  });

  function showCashBack2NotionPopup(){
    $(".cashback2-notion-black-background").show();
    $(".white-content-box-cashback2-notion").show();
  }
//キャッシュバックキャンペーン 第2弾 end

// オプション解約で安心オプションが選択されていないときのポップアップ表示制御 start
$(function() {
  $('#option_cancel_button').click(function() {
    var optionName = $('.option-cancel-list li').text();
    // 安心オプションが含まれていなかったら
    if (optionName.indexOf("安心オプション") < 0) {
      // ※安心オプションに加入していないお客様が～の非表示
      $('.mypage-popup-data-pop-anshin-text-margin').hide();
      // ポップアップの高さ調整する
      $('.mypage-confirm-dialog').addClass('no-anshin-option')
    }
  });
});
// オプション解約で安心オプションが選択されていないときのポップアップ表示制御 end

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
        if ($tmp.name.length >= 1) {
          $room.addClass(state);
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

//こんど払い終了のご案内 start
$(document).ready(function() {
  //共通要素の一元定義
  var newsTitle = 'コンビニ後払い<br class="sp">サービス終了のご案内' ; //タイトル
  var newsPopup = "CondopayEnd"; //Js表示
  var newsClass = "condopay-end"; //クラス名

    var _html = ''
    + '<div class="under-kv-notion">'
    +   '<div class="under-kv-notion-inner">'
    +     '<p class="under-kv-notion-title">'
    +      '<a href="javascript:show' + newsPopup + 'Popup()">'
    +        '<img alt="ico" src="/assets/img/important-mark.svg" class="important-mark colorbox-manual">'
    +         newsTitle
    +       '</a>'
    +     '</p>'
    +   '</div>'
    + '</div>';


    if (window.location.pathname == "/") {
      $(".top-kv").after(_html);
    }else{
      return;
    }

    var top_notion_popup = ''
    + '<div class="' + newsClass + '-notion-black-background"></div>'
    + '<div class="pop-up-news white-content-box-' + newsClass + '-notion">'
    +   '<div class="' + newsClass + '-popup-close-button">'
    +     '<img src="https://d1q08lkutgkcx2.cloudfront.net/image/popup-close.svg">'
    +   '</div>'
    +   '<div class="white-content-box-title white-content-box-title-notion white-content-box-title-' + newsClass + '-notion">'
    +     '<p>' + newsTitle + '</p>'
    +   '</div>'
    +   '<div class="white-content-box-inner-' + newsClass + '">'
    +     '<div class="white-content-box-body">'
    +       '<p>日頃より縛りなしWiFiをご愛顧いただきまして、誠にありがとうございます。</p>'
    +       '<br>'
    +       '<p>この度、サービス利用料のお支払いにご利用いただいております「コンビニ後払い」について、2023年7月31日をもちまして、コンビニ後払いサービスを終了させていただくこととなりました。ご利用中の方にはご迷惑をおかけして申し訳ございません。お手間ではありますが、支払方法の変更をお願い申し上げます。</p>'
    +       '<br>'
    +       '<p>■対象となるお客様</p>'
    +       '<p>2022年4月14日～2022年10月3日の間に、お支払い方法を「コンビニ後払い」でご契約いただいたお客様。</p>'
    +       '<br>'
    +       '<p>対象となるお客様には、ご登録いただいているメールアドレス宛に、変更方法のご案内をお送りいたします。<br>メールをご確認いただき、支払方法の変更をお願い申し上げます。</p>'
    +       '<br>'
    +       '<p>またこれに伴い、2023年8月1日付で縛りなしWiFi利用規約を改訂いたします。</p>'
    +       '<p>改定個所は利用規約別紙１（料金等の支払い）および（手続きに関する手数料について）となります。改定予定の内容につきましては、下記リンクよりご確認ください。</p>'
    +       '<p>なお、契約日により利用規約の内容が異なります。該当の契約日より改定予定の内容をご確認ください。</p>'
    +       '<br>'
    +       '<p>■改定予定の縛りなしWiFi 利用規約（重要事項説明書）</p>'
    +       '<p>契約時期：2022年3月29日～2022年3月31日のお客様は<a href="/contract_service_20220329_20230801" target="_blank" class="pink-link">こちら</a></p>'
    +       '<p>契約時期：2022年4月1日～2022年5月18日のお客様は<a href="/contract_service_20220401_20230801" target="_blank" class="pink-link">こちら</a></p>'
    +       '<p>契約時期：2022年5月19日～2022年6月9日のお客様は<a href="/contract_service_20220519_20230801" target="_blank" class="pink-link">こちら</a></p>'
    +       '<p>契約時期：2022年6月10日～2022年6月30日のお客様は<a href="/contract_service_20220610_20230801" target="_blank" class="pink-link">こちら</a></p>'
    +       '<p>契約時期：2022年7月1日～2022年8月25日のお客様は<a href="/contract_service_20220701_20230801" target="_blank" class="pink-link">こちら</a></p>'
    +       '<p>契約時期：2022年8月26日～2022年9月11日のお客様は<a href="/contract_service_20220826_20230801" target="_blank" class="pink-link">こちら</a></p>'
    +       '<p>契約時期：2022年9月12日～2022年10月3日のお客様は<a href="/contract_service_20220912_20230801" target="_blank" class="pink-link">こちら</a></p>'
    +       '<br>'
    +       '<p>■改定予定の縛りなしWiFi安心オプション規約</p>'
    +       '<p>契約時期：2022年3月29日～2022年10月3日のお客様は<a href="/contract_device_insurance_20220329_20230801" target="_blank" class="pink-link">こちら</a></p>'
    +       '<br>'
    +       '<br>'
    +       '<p>ご不明な点がございましたらサポート窓口までご連絡いただきますようお願いいたします。</p>'
    +     '</div>'
    +   '</div>'
    + '</div>';

    $("body").append(top_notion_popup);
    hideCondopayEndPopup();

    $("." + newsClass + "-notion-black-background, ." + newsClass + "-popup-close-button").click(function(){
      hideCondopayEndPopup();
    });

    });

    function hideCondopayEndPopup(){
      var newsClass = "condopay-end";

      $("." + newsClass + "-notion-black-background").hide();
      $(".white-content-box-" + newsClass + "-notion").hide();
    }

    function showCondopayEndPopup(){
      var newsClass = "condopay-end";

      $("." + newsClass + "-notion-black-background").show();
      $(".white-content-box-" + newsClass + "-notion").show();
    }
  //こんど払い終了のご案内 end
