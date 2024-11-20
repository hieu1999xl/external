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


$(document).ready(function() {
  /*header*/

  //WiMAX FAQ device category collapse
  function toggleFaqCategoryDevice(elem) {
    $("div.white-content-box-faq-device").removeClass("active");
    $("div.white-content-box-faq-device").addClass("inactive");
    var section = $(elem).attr("section");
    var _selector = "." + section;
    $(_selector).removeClass("inactive");
    $(_selector).addClass("active");
    $(".faq-category-box-device").removeClass("faq-category-box-selected");
    $(elem).addClass("faq-category-box-selected");
    $("div.faq-category-box").removeClass("faq-category-box-selected");
    $("div.faq-category-1").addClass("faq-category-box-selected");
    $("div.white-content-box-faq-v2").removeClass("active");
    $("div.white-content-box-faq-v2").addClass("inactive");
    $("div.faq-category-box-1").removeClass("inactive");
    $("div.faq-category-box-1").addClass("active");
  }

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
    var _selector_class = "." + section;
    $(_selector_class).removeClass("inactive");
    $(_selector_class).addClass("active");
    console.log(elem);
    $(".faq-category-box").removeClass("faq-category-box-selected");
    $(elem).addClass("faq-category-box-selected");

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
    $("div.top-faq-v2-categories div.faq-category-box-device").click(function() {
      toggleFaqCategoryDevice(this);
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

// New mypage


$(function(){
	$(".tab_content dt").on("click", function() {
	    toggleFaqOpenShut(this);
	});
});

function toggleFaqOpenShut(elem) {
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
    $('a[href^="#"]').click(function(){
        var href= $(this).attr("href");
        if(href == "#areacover"){
          var headerHight = 120;
        }else if(href == "#areacover" || window.matchMedia('(max-width:767px)').matches){
          var headerHight = 80;
        }else{
          var headerHight = 50;
        }
        var target = $(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top; //ヘッダの高さ分位置をずらす
        $("html, body").animate({scrollTop:position-headerHight}, 550, "swing");
        return false;
    });
});
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

    if (scroll > startPos && scroll < endPos - 300) {
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

//オプションポップアップ start
//初期契約解除
$(document).ready(function() {

  var top_notion_popup = '<div class="support-notion-black-background"></div><div class="pop-up-news white-content-box-support-notion"><div class="support-popup-close-button"><img src="https://d1q08lkutgkcx2.cloudfront.net/image/popup-close.svg" alt="閉じる" width="18" height="18"></div><div class="white-content-box-title white-content-box-title-notion white-content-box-title-support"><p>初期契約解除制度<br class="sp">について</p></div><div class="white-content-box-inner-support"><div class="white-content-box-body"><p>初期契約解除制度とは、契約書面受領日または<br class="sp">利用開始日から起算して8日以内に、マイページの<br class="pc">「ご契約情報」内「<a href="/mypage/contractshow" target="_blank" class="pink-link">初期契約解除申請フォーム</a>」より申告を行っていただくことで、<br>契約事務手数料3,000円（3,300円税込）のお支払いのみで契約の解除ができる制度です。<br>初期契約解除の申請は、端末の受け取り後に行ってください。<br>※「5Gギガ放題フリープラン（契約期間なし）」での契約、または法人契約の場合は、初期契約解除制度が対象外となります。<br>※初期契約解除に伴い、端末売買契約も解除となり、端末一式の返却が必要となります。</p><br><p>初期契約解除受理には、初期契約解除申出日から起算して8日以内に、当社指定住所へ端末一式<br>（本体/UIMカード/USB ケーブル/保証書/個装箱）すべての返却が必要となります。<br>なお、端末返却時の送料はお客様負担となり、着払いでの受け取りはできかねますので、あらかじめご了承ください。<br>返却期日を過ぎている場合や、返却物に欠品がある場合、返却時に故障が見られる場合は、端末損害金として<br class="pc">19,800円（21,780円税込）を請求させていただくことがございます。</p><br><p>マイページからの申請が難しい場合は、下記の必要事項を書面に記載し、端末返却時に同梱してお送りください。<br>【書面に記載する必要事項】<br>1：届出日<br>2：契約者番号（ZEUS WiMAX端末お届け時に同梱している「ご契約内容確認書類」よりご確認ください）<br>3：契約者名<br>4：電話番号<br>5：住所<br>6：初期契約解除理由</p></div></div></div>';

  $("body").append(top_notion_popup);
  hideSupportPopup();

  function hideSupportPopup(){
    $(".support-notion-black-background").hide();
    $(".white-content-box-support-notion").hide();
  }
  $(".support-notion-black-background").click(function(){
    hideSupportPopup();
  })
  $(".support-popup-close-button").click(function(){
    hideSupportPopup();
  });
});

function showSupportPopup(){
  $(".support-notion-black-background").show();
  $(".white-content-box-support-notion").show();
}

//オプションポップアップ end

//セットページモーダル start

$(document).ready(function() {
  $('.hint-modal-open').on('click', function() {
    $('.hint-modal-container').css('opacity', 1).addClass('active');
    $(".modal-bg").css("opacity", 1).addClass('active');
    $('.hint-modal-close').addClass('active');
  });
  
  $('.advice-modal-open').on('click', function() {
    $('.advice-modal-container').css('opacity', 1).addClass('active');
    $('.modal-bg').css('opacity', 1).addClass('active');
    $('.advice-modal-close').addClass('active');
  });
  
  $('.hint-modal-close').on('click', function() {
    $('.hint-modal-container').css('opacity', 0).removeClass('active');
    $('.modal-bg').css('opacity', 0).removeClass('active');
    $('.hint-modal-close').removeClass('active');
  });
  
  $('.modal-bg').on('click', function() {
    $('.hint-modal-container').css('opacity', 0).removeClass('active');
    $('.modal-bg').css('opacity', 0).removeClass('active');
    $('.hint-modal-close').removeClass('active');
  });
  
  $('.advice-modal-close').on('click', function() {
    $('.advice-modal-container').css('opacity', 0).removeClass('active');
    $('.modal-bg').css('opacity', 0).removeClass('active');
    $('.advice-modal-close').removeClass('active');
  });

  $('.modal-bg').on('click', function() {
    $('.advice-modal-container').css('opacity', 0).removeClass('active');
    $('.modal-bg').css('opacity', 0).removeClass('active');
    $('.advice-modal-close').removeClass('active');
  });
});

//セットページモーダル end

//auスマートバリュー割引 start
$(document).ready(function() {

  var top_notion_popup = '<div class="special2-1-notion-black-background"></div><div class="pop-up-news white-content-box-special2-1-notion"><div class="special2-1-popup-close-button"><img src="https://d1q08lkutgkcx2.cloudfront.net/image/popup-close.svg" alt="閉じるボタン" width="18" height="18"></div><div class="white-content-box-title white-content-box-title-notion white-content-box-title-special2-1"><p>auスマートバリューでの<br class="sp">スマホ代割引について</p></div><div class="white-content-box-inner-special2-1"><div class="white-content-box-body"><p>ZEUS WiMAXとauの対象プランをお申し込みでauの月額料金を割引いたします。<br> なお、スマートバリューの申込については、別途KDDIにてお申し込みが必要です。</p><br><p>商品到着後に電話またはauショップにてお申し込み手続きが必要になります。</p><br><p>■お電話でのお申し込みの場合<br>以下の番号から割引のお申し込み手続きができます。</p><br><p>＜スマートバリュー（auスマホ）＞</p><p>　au携帯電話から：<a href="tel:157">157</a><br>　au以外の携帯電話・一般電話から：<a href="tel:00777111">0077-7-111</a></p></div></div></div>';

  $("body").append(top_notion_popup);
  hideSpecial2_1Popup();

  function hideSpecial2_1Popup(){
    $(".special2-1-notion-black-background").hide();
    $(".white-content-box-special2-1-notion").hide();
  }
  $(".special2-1-notion-black-background").click(function(){
    hideSpecial2_1Popup();
  })
  $(".special2-1-popup-close-button").click(function(){
    hideSpecial2_1Popup();
  });
});

function showSpecial2_1Popup(){
  $(".special2-1-notion-black-background").show();
  $(".white-content-box-special2-1-notion").show();
}
//auスマートバリュー割引 end

//uq割引 start
$(document).ready(function() {

  var top_notion_popup = '<div class="special2-2-notion-black-background"></div><div class="pop-up-news white-content-box-special2-2-notion"><div class="special2-2-popup-close-button"><img src="https://d1q08lkutgkcx2.cloudfront.net/image/popup-close.svg" alt="閉じる" width="18" height="18"></div><div class="white-content-box-title white-content-box-title-notion white-content-box-title-special2-2"><p>UQ mobileでの<br class="sp">スマホ代割引について</p></div><div class="white-content-box-inner-special2-2"><div class="white-content-box-body"><p>ZEUS WiMAXとUQ mobileの対象プランをお申し込みでUQ mobileの月額料金を割引いたします。</p><br><p>商品到着後に電話またはauショップにてお申し込み手続きが必要になります。</p><br><p>■お電話でのお申し込みの場合<br>以下の番号から割引のお申し込み手続きができます。</p><p>　<a href="tel:0120929818">0120-929-818</a></p></div></div></div>';

  $("body").append(top_notion_popup);
  hideSpecial2_2Popup();

  function hideSpecial2_2Popup(){
    $(".special2-2-notion-black-background").hide();
    $(".white-content-box-special2-2-notion").hide();
  }
  $(".special2-2-notion-black-background").click(function(){
    hideSpecial2_2Popup();
  })
  $(".special2-2-popup-close-button").click(function(){
    hideSpecial2_2Popup();
  });
});

function showSpecial2_2Popup(){
  $(".special2-2-notion-black-background").show();
  $(".white-content-box-special2-2-notion").show();
}
//auスマートバリュー割引 end

//オプション表示 トグルボタン
$(document).ready(function() {
    $(".option-info1,.option-info2,.info-special1").hide();
    $("#option1").click(function(){
      $(".option-info1").slideToggle();
      $("#option1").children("a").toggleClass("open");
    });

    $("#option2").click(function(){
      $(".option-info2").slideToggle();
      $("#option2").children("a").toggleClass("open");
    });

    $("#special1").click(function(){
      $(".info-special1").slideToggle();
      $("#special1").children("a").toggleClass("open");
    });
});

// WiMAX トラブルシューティング
$(function(){

  var TS_click = $("#trouble_shooting_A p");
  var TS_Q_div = $("#trouble_shooting_Q div");
  var TS_A_div = $("#trouble_shooting_A div");

  $(TS_click).click(function(){
    var TS_click_id = $(this).attr("id");

    $(TS_Q_div).hide();
    $(TS_A_div).hide();
    $("#return_box_area").fadeIn(1000);

    switch (TS_click_id){
      // 通信できない 場合
      case "NO_A1_1_1":
        $("#NO_Q2_1").fadeIn(1000);
        $("#NO_A2_1").fadeIn(1000);
        break;
      case "NO_A2_1_1":
        $("#NO_Q2_2").fadeIn(1000);
        $("#NO_A2_2").fadeIn(1000);
        break;
      case "NO_A2_1_2":
        $("#NO_Q2_1").show();
        $("#NO_S2_1_2").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A2_2_1":
        $("#NO_Q3_1").fadeIn(1000);
        $("#NO_A3_1").fadeIn(1000);
        break;
      case "NO_A2_2_2":
        $("#NO_Q4_1").fadeIn(1000);
        $("#NO_A4_1").fadeIn(1000);
        break;
      case "NO_A3_1_1":
        $("#NO_Q3_1").show();
        $("#NO_S3_1_1").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A3_1_2":
        $("#NO_Q3_2").fadeIn(1000);
        $("#NO_A3_2").fadeIn(1000);
        break;
      case "NO_A3_2_1":
        $("#NO_Q3_3").fadeIn(1000);
        $("#NO_A3_3").fadeIn(1000);
        break;
      case "NO_A3_2_2":
        $("#NO_Q3_2").show();
        $("#NO_S3_2_2").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A3_2_3":
        $("#NO_Q3_2_3_1").fadeIn(1000);
        $("#NO_A3_2_3_1").fadeIn(1000);
        break;
      case "NO_A3_2_3_1_1":
        $("#NO_Q3_2_3_2").fadeIn(1000);
        $("#NO_A3_2_3_2").fadeIn(1000);
        break;
      case "NO_A3_2_3_1_2":
        $("#NO_Q3_2_3_1").show();
        $("#NO_S3_2_3_1").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A3_2_3_2_1":
        $("#NO_Q3_2_3_2").show();
        $("#NO_S3_2_3_2_1").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A3_2_3_2_2":
        $("#NO_Q3_2_3_2").show();
        $("#NO_S3_2_3_2_2").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A3_3_1":
        $("#NO_Q3_4").fadeIn(1000);
        $("#NO_A3_4").fadeIn(1000);
        break;
      case "NO_A3_3_2":
        $("#NO_Q3_3_2_1").fadeIn(1000);
        $("#NO_A3_3_2_1").fadeIn(1000);
        break;
      case "NO_A3_3_2_1_1":
        $("#NO_Q3_3_2_2").fadeIn(1000);
        $("#NO_A3_3_2_2").fadeIn(1000);
        break;
      case "NO_A3_3_2_1_2":
        $("#NO_Q3_3_2_1").show();
        $("#NO_S3_3_2_1_2").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A3_3_2_2_1":
        $("#NO_Q3_3_2_3").fadeIn(1000);
        $("#NO_A3_3_2_3").fadeIn(1000);
        break;
      case "NO_A3_3_2_2_2":
        $("#NO_Q3_3_2_3").show();
        $("#NO_S3_3_2_2_2").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A3_3_2_3_1":
        $("#NO_Q3_4").fadeIn(1000);
        $("#NO_A3_4").fadeIn(1000);
        break;
      case "NO_A3_3_2_3_2":
        $("#NO_Q3_3_2_3").show();
        $("#NO_S3_3_2_3_2").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A3_4_1":
        $("#NO_Q3_4").show();
        $("#NO_S3_4_1").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A3_4_2":
        $("#NO_Q4_1").fadeIn(1000);
        $("#NO_A4_1").fadeIn(1000);
        break;

      // 遅い・途切れる 場合
      case "NO_A1_1_2":
        $("#SLOW_Q2_1").fadeIn(1000);
        $("#SLOW_A2_1").fadeIn(1000);
        break;
      case "SLOW_A2_1_1":
        $("#SLOW_Q2_2").fadeIn(1000);
        $("#SLOW_A2_2").fadeIn(1000);
        break;
      case "SLOW_A2_1_2":
        $("#SLOW_Q2_1").show();
        $("#SLOW_S2_1_2").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "SLOW_A2_2_1":
        $("#SLOW_Q3_1").fadeIn(1000);
        $("#SLOW_A3_1").fadeIn(1000);
        break;
      case "SLOW_A2_2_2":
        $("#SLOW_Q4_1").fadeIn(1000);
        $("#SLOW_A4_1").fadeIn(1000);
        break;
      case "SLOW_A3_1_1":
        $("#SLOW_Q3_1").show();
        $("#SLOW_S3_1_1").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "SLOW_A3_1_2":
        $("#SLOW_Q4_1").fadeIn(1000);
        $("#SLOW_A4_1").fadeIn(1000);
        break;
      case "SLOW_A4_1_1":
        $("#SLOW_Q4_1").show();
        $("#SLOW_S4_1_1").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "SLOW_A4_1_2":
        $("#NO_Q4_1").fadeIn(1000);
        $("#NO_A4_1").fadeIn(1000);
        break;

      // 共有
      case "NO_A4_1_1":
        $("#NO_Q4_1").show();
        $("#NO_S4_1_1").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A4_1_2":
        $("#NO_Q4_1").show();
        $("#NO_S4_1_2").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A4_1_3":
        $("#NO_Q5_1").fadeIn(1000);
        $("#NO_A5_1").fadeIn(1000);
        break;
      case "NO_A5_1_1":
        $("#NO_Q5_1").show();
        $("#NO_S5_1_1").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
      case "NO_A5_1_2":
        $("#NO_Q5_1").show();
        $("#NO_S5_1_2").fadeIn(1000);
        $("#trouble-shooting-text").hide();
        break;
    }
  });
});

  //スライドショー
  $(function(){
    //wimaxTOPか配下ページから来たら動かす
    var urlHash = location.hash;
    if(window.location.pathname === "/wimax_campaign" || window.location.pathname === "/wimax_campaign/" + urlHash || window.location.href == "https://wimax-zeuswifi.jp/" || window.location.href == "https://wimax-zeuswifi.jp/wimax_campaign/"){
      //クリック時のずれを調整
    $(window).on('load', function(){
      if(window.matchMedia('(min-width:767px)').matches && ((window.location.pathname === "/wimax_campaign") || (window.location.pathname === "/wimax_campaign/" + urlHash))){
        var target = $(":header.wimax-menu");
        if ($(target).length) {
          var position = target.offset().top - headerHeight;
        }
        $("html, body").animate({scrollTop:position }, 550, "swing");
      }
    });
      
      //スライドアニメーション
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
// https://wimax-zeuswifi.jp/のみ お知らせ表示 start
$(function(){
  if(window.location.hostname == "wimax-zeuswifi.jp"){
    var _html = ''
    _html += '<section id="news"><div class="inner"><div class="section-heading"><h2>お知らせ</h2><h3>NEWS</h3></div><div class="news-area">';
    $.getJSON( "https://zeus-wifi.jp/api/v1/news_wimax", function(results) {
      const obj = JSON.parse(results);
      console.log(obj);
      $.each(obj, function(i, item) {
        var title = item.title;
        var content = item.content;
        var date = item.date;
        var category_names = item.category_names;
        var category_span = '';

        if (category_names) {
          $.each(category_names['name'], function(index, val) {
            if (val === "ニュース") {
              val = "NEWS";
            }
            category_span = category_span + "<span>" + val + "</span>";
          });
        }

        _html += "<dl><dt>" + date + category_span + "</dt><dd><strong>" + title + "</strong><br>" +  content + "</dt></dl>";
        console.log(_html);
      });
      _html += '</div></div></section>';
      console.log(_html);
      $("section #special2-footer").before(_html);
    })

  }else{
    return;
  }

});
// https://wimax-zeuswifi.jp/のみ お知らせ表示 end

//wimaxご契約者限定プラン URL設定
function paramGetEntry(){
  var param = location.search;
  document.location.href = "/entry/wimax/select" + param;
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
$(function(){
    if(getParam("res")==401){
        $("#error-popup").show();
    }
    $(".popup-black-background,.pop-btn").click(function(){
        $("#error-popup").hide();
    })
});