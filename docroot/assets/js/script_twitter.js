function currentPathIs(path) {
  // pass parameter like 'faq'
  var a = "/" + path;
  var b = "/" + path + "/";

  return [a, b, path].indexOf(location.pathname) >= 0;
}

/* Page link scroll */
function scrollToHash(target, headerSelector) {
  if(headerSelector === undefined) {
    headerSelector="header.service-header";
  }
  var speed = 1000;
  var headerHeight = $(headerSelector).height();
  var position = target.offset().top - headerHeight - 20;
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
      } else if (selected_value == "2") {
        $("#payment-method-creditcard").css("display", "none");
        $("#payment-method-account-transfer").css("display", "");
      } else if (selected_value == "3") {  // 請求書
        $("#payment-method-creditcard").css("display", "none");
        $("#payment-method-invoice").css("display", "");
        $("#payment-method-account-transfer").css("display", "");
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
    } else if (selected_value == "2") {
       $(".mypage-user-info-detail").removeClass("mypage-user-info-detail-hidden");
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
    toggleDeliveryInfoDetail();
    $('input[name="delivery_info"]').change(function() {
      toggleDeliveryInfoDetail();
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
  /* Page link scroll */
  function scrollToHash(target) {
    var speed = 1000;
    var headerHeight = $("header").height();
    var position = target.offset().top - headerHeight - 20;
    $("html, body").animate({ scrollTop: position }, speed, "swing");
    return false;
  }

  $(function() {
    if (!currentPathIs('faq')){
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
      toggleFaqOpenShut(target);
      // scroll
      $("body,html")
        .stop()
        .scrollTop(0);
      var target = $(selector);
      scrollToHash(target);
    }
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
      var _day = elems[0];
      var _size = elems[1];
      var _html =
        _day + ' <span class="overseas-table-th-large">' + _size + "</span>";
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
        autoplay: {
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
    "email_confirm": "*メールアドレス(確認用)を入力してください。",

    // address
    "zipcode_1": "*郵便番号を入力してください。",
    "zipcode_2": "*郵便番号を入力してください。",
    "prefecture": "*都道府県を選択してください。",
    "city": "*市区郡を入力してください。",
    "town": "*町名を入力してください。",
    "block": "*番地を入力してください。",

    // user
    "user_last_name": "*氏名を入力してください。",
    "user_first_name": "*氏名を入力してください。",
    "user_last_name_kana": "*氏名(カナ)を入力してください。",
    "user_first_name_kana": "*氏名(カナ)を入力してください。",
    "user_tel1_1": "*電話番号を入力してください。",
    "user_tel1_2": "*電話番号を入力してください。",
    "user_tel1_3": "*電話番号を入力してください。",
    "user_zipcode_1": "*郵便番号を入力してください。",
    "user_zipcode_2": "*郵便番号を入力してください。",
    "user_prefecture": "*都道府県を選択してください。",
    "user_city": "*市区郡を入力してください。",
    "user_town": "*町名を入力してください。",
    "user_block": "*番地を入力してください。",

    // delivery
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
    "delivery_order_time": "*配送時間を選択してください。",

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
  }else if(klass.indexOf("form-item-address") > -1){
    targetItemList = counter["form-item-address"];
  }else if(klass.indexOf("form-item-user") > -1){
    targetItemList = counter["form-item-user"];
  }else if(klass.indexOf("form-item-delivery") > -1){
    targetItemList = counter["form-item-delivery"]
  }else if(klass.indexOf("form-item-corp-info") > -1){
    targetItemList = counter["form-item-corp-info"];
  }else if(klass.indexOf("form-item-corp-address") > -1){
    targetItemList = counter["form-item-corp-address"]
  }else if(klass.indexOf("form-item-delivery-corp") > -1){
    targetItemList = counter["form-item-delivery-corp"]
  }else if(klass.indexOf("form-item-corp-contact") > -1){
    targetItemList = counter["form-item-corp-contact"]
  }else if(klass.indexOf("form-item-password") > -1){
    targetItemList = counter["form-item-password"]
  }else{
    return;
  }//
  targetItemList.push(name)
};

// Validates user form
// Called from val.js
function validateUserForm(formId, invalidItems) {
  names = Object.keys(invalidItems);

  if(formId !== "entry-user-form" && formId !== "entry-payment-form" && formId !== "entry-corp-user-form"){
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
    "form-item-address": [],
    "form-item-user": [],
    "form-item-delivery": [],
    "form-item-password": [],
    "form-item-corp-info" : [],
    "form-item-corp-address":[],
    "form-item-delivery-corp":[],
    "form-item-corp-contact" :[],
  };
  names.forEach(function(name){
    if(name.indexOf("user_") == 0){
      failedItemCounter["form-item-user"].push(name);
    }else if(name.indexOf("delivery_") == 0){
      failedItemCounter["form-item-delivery"].push(name);
    }else if(name.indexOf("invoice_") == 0 || name == 'corp_contact_info'){  // 請求先情報選択も請求先情報の配列に受け入れる ←TODO:corp_contact_infoの物理名を修正
      failedItemCounter["form-item-corp-contact"].push(name);
    }else if(name.indexOf("corp_") == 0 && name != 'corp_contact_info'){     // 請求先情報選択はご契約法人情報の配列から除く ←TODO:corp_contact_infoの物理名を修正
      failedItemCounter["form-item-corp-info"].push(name);
    }else if(name.indexOf("add_") == 0){
      failedItemCounter["form-item-corp-address"].push(name);
    }else if(name.indexOf("deliverycorp_") == 0){
      failedItemCounter["form-item-delivery-corp"].push(name);
    }else if(name.indexOf("password") == 0){
      failedItemCounter["form-item-password"].push(name);
    }else if(["zipcode_1", "zipcode_2", "prefecture", "city", "town", "block"].indexOf(name) > -1){
      failedItemCounter["form-item-address"].push(name);
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
  ["last_name", "first_name", "last_name_kana", "first_name_kana", "sex", "birthday_year", "birthday_month", "birthday_day", "tel1_1", "tel1_2", "tel1_3", "email", "email_confirm"].forEach(function(v){
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

  // Alert address
  var alertLines = []
  var invalidItems = [];
  ["zipcode_1", "zipcode_2", "prefecture", "city", "town", "block"].forEach(function(v){
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
  ["user_last_name","user_first_name","user_last_name_kana","user_first_name_kana","user_tel1_1","user_tel1_2","user_tel1_3","user_zipcode_1","user_zipcode_2","user_prefecture","user_city","user_town","user_block"].forEach(function(v){
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

  // Alert delivery
  var alertLines = []
  var invalidItems = [];
  ["delivery_last_name","delivery_first_name","delivery_last_name_kana","delivery_first_name_kana","delivery_tel1_1","delivery_tel1_2","delivery_tel1_3","delivery_zipcode_1","delivery_zipcode_2","delivery_prefecture","delivery_city","delivery_town","delivery_block","delivery_order_time"].forEach(function(v){
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
 ["corp_contact_info","invoice_company_name","invoice_company_name_kana","invoice_department_name","invoice_last_name","invoice_first_name","invoice_last_name_kana","invoice_first_name_kana","invoice_email","invoice_email_conf","invoice_tel1_1","invoice_tel1_2","invoice_tel1_3"].forEach(function(v){
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
  if(failedItemCounter["form-item-user"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-user\")' class='not-inputed-link'><p><u>*ご利用者様情報</u></p></a>");
    invalidSections.push("#not-inputted-items-user");
  }
  if(failedItemCounter["form-item-corp-address"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-corp-address\")' class='not-inputed-link'><p><u>*ご契約者様住所</u></p></a>");
    invalidSections.push("#not-inputted-items-corp-address");
  }

  if(failedItemCounter["form-item-delivery"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-delivery\")' class='not-inputed-link'><p><u>*配送先情報</u></p></a>");
    invalidSections.push("#not-inputted-items-delivery");
  }
 if(failedItemCounter["form-item-delivery-corp"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-delivery-corp\")' class='not-inputed-link'><p><u>*配送先情報</u></p></a>");
    invalidSections.push("#not-inputted-items-delivery-corp");
  }
  if(failedItemCounter["form-item-corp-contact"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-corp-contact\")' class='not-inputed-link'><p><u>*請求先情報</u></p></a>");
    invalidSections.push("#not-inputted-items-corp-contact");
  }
  if(failedItemCounter["form-item-password"].length > 0){
    popupLines.push("<a href='javascript:userFormAlertClick(\"#not-inputted-items-password\")' class='not-inputed-link'><p><u>*ログインパスワード</u></p></a>");
    invalidSections.push("#not-inputted-items-password");
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
  $(".edit-partial-contractor").hide();
  $(".edit-partial-address").hide();
  $(".edit-partial-user").hide();
  $(".edit-partial-delivery").hide();
  $(".edit-partial-corp-contact").hide();
  $(".form-black-background").hide();
  $(".mypage-confirm-hidden-form").hide();
}

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
  $('#form-entry-edit-device-option').submit(function(){

    var valDeviceOption = $("input[name='device_option']:checked").val();
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