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

///
// 画面横の追従ボタン
///

$(document).ready(function() {

  if(window.location.pathname.includes("/promotion_newservice")){
    return;
  }else{
    document.addEventListener('scroll', function() {
      scrollToggleClass("#hint_wrap", "#price_fix,#kgr-entry-btn", "show");
    });
    
    function scrollToggleClass(rangeTarget, addTarget, classname) {
      if($(rangeTarget).length){
        scroll = $(window).scrollTop();
        startPos = $(rangeTarget).offset().top;
        endPos = startPos + $(rangeTarget).outerHeight();
        if (scroll > startPos && scroll < endPos) {
          $(addTarget).addClass(classname);
        } else {
          $(addTarget).removeClass(classname)
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
  }
});

///
// 画面横の追従ボタン（申込ボタン）
///
$(window).on('load resize', function(){
  let w = $(window).width();
  if(w <= 768){
    document.addEventListener('scroll', function() {
      scrollToggleClassSp("#entry_wrap", "#entry_fix,#kgr-entry-btn", "show");
    });
  }else{
    document.addEventListener('scroll', function() {
      scrollToggleClass("#entry_wrap", "#entry_fix,#kgr-entry-btn", "show");
    });
  }
});

function scrollToggleClassSp(rangeTarget, addTarget, classname) {
  if($(rangeTarget).length){
    scroll = $(window).scrollTop();
    startPos = $(rangeTarget).offset().top -500;
    endPos = startPos + $(rangeTarget).outerHeight();

    if (scroll > startPos && scroll < endPos) {
      $(addTarget).addClass(classname);
    } else {
      $(addTarget).removeClass(classname);
    }
  }
}

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

$(function(){
  $("#entry_fix .price-fix-hint, .hint_pop .close").click(function(){
    if($("#entry_fix .price-fix-hint, .hint_pop").hasClass("active")){
      $("#entry_fix .price-fix-hint, .hint_pop").removeClass("active");
    }else{
      $("#entry_fix, .hint_pop").addClass("active");
    }
  });
  if(window.location.pathname.includes("/promotion_optservice")) {
    $(".close-opt").click(function(){
      closeHintPop();
    });
  }
  if(window.location.pathname.includes("/bulk_prepayment")) {
    $(".close-bulkprepayment").click(function(){
      closeHintPop();
    });
  }
  function closeHintPop() {
    if($("#entry_fix .price-fix-hint, .hint_pop").hasClass("active")){
      $("#entry_fix .price-fix-hint, .hint_pop").removeClass("active");
    } 
  }
});

$(document).ready(function() {
  function elemHover(elem){
    $(elem).removeClass("inactive");
    $(elem).addClass("active");
  };
  function elemUnhover(elem){
    $(elem).removeClass("active");
    $(elem).addClass("inactive");
  };

  $('.sns-circle').hover(
    function() {
      elemHover(this);
    },
    function() {
      elemUnhover(this);
    }
  );

});

// 千葉ロッテマリーンズ キャンペーン
$(function() {
  $("#cb-flow-toggle").click(function(){
    $(this).siblings("div").slideToggle();
    $(".cb-flow").toggleClass("open");
  });
  
  $("#cb-info-toggle").click(function(){
    $(this).siblings("div").slideToggle();
    $(".cb-info").toggleClass("open");
  });

});

// Swiper
$(function() {
  // https://haniwaman.com/swiper/#i-8
  $(function() {
    // In mypage and forms, if Swiper is not defined, return.
    if (typeof Swiper !== "function") {
      return;
    }else{
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

// ハンバーガーメニュー
$(function(){
  $('.sp-nav-btn').on('click', function(){
    $('.hum-nav').toggleClass('open');
    $('body').toggleClass('noscroll');
  });
  $('.close-btn').on('click', function(){
    $('.hum-nav').toggleClass('open');
    $('body').toggleClass('noscroll');
  });
  $('.hum-nav-list a').on('click', function(){
    $('.hum-nav').removeClass('open');
    $('body').removeClass('noscroll');
  });
});
// ハンバーガーメニューここまで
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
// デバイス詳細ドロップダウン
$(function(){
  $('.js-slidedown-device').css('display', 'none');
  $('.js-device-btn').on('click', function(){
    $('.js-device-btn').toggleClass('open');
    $('.js-slidedown-device').slideToggle(300);
  });
});

// ページ内スクロール
$(function(){
  $('a[href^="#"]').click(function(){
    var adjust = -70;
    var speed = 600;
    var href= $(this).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top + adjust;
    $('body,html').animate({scrollTop:position}, speed, 'swing');
    return false;
  });
});

/* ウェブアクセシビリティ対応 */
$(function(){
  $(".free-giga-btn").keydown(function(event) {
    if( event.keyCode == 13 ) {
    $(this).click();
  }
  });
  $(".btn-device.btn-dd-pink").keydown(function(event) {
    if( event.keyCode == 13 ) {
    $(this).click();
  }
  });
  $(".tab").keydown(function(event) {
    if( event.keyCode == 13 ) {
    $(this).click();
  }
  });
  $(".price-fix-box~.price-fix-hint").keydown(function(event) {
    if( event.keyCode == 13 ) {
    $(this).click();
  }
  });
  $(".hint_pop .close").keydown(function(event) {
    if( event.keyCode == 13 ) {
    $(this).click();
  }
  });
  $(".price-fix-entry.price-fix-hint").keydown(function(event) {
    if( event.keyCode == 13 ) {
    $(this).click();
  }
  });
  $(".sp-nav-btn").keydown(function(event) {
    if( event.keyCode == 13 ) {
    $(this).click();
  }
  });
  $(".close-btn").keydown(function(event) {
    if( event.keyCode == 13 ) {
    $(this).click();
  }
  });
});