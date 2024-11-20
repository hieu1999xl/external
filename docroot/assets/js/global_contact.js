function isMyPage(){
  return location.pathname.indexOf("mypage") >= 0;
}

/* scroll on load */
var target = window.location.hash,
target = target.replace('#', '');

if(!window.location.pathname.includes("/faq/")){
  window.location.hash = "";
}

$(window).on('load', function() {
  if (target) {
    $('html, body').animate({
      scrollTop: $("#" + target).offset().top - 76
    }, 700, 'swing', function () {});
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
  $('.header-logout').hover(
    function() {
      elemHover(this);
    },
    function() {
      elemUnhover(this);
    }
  );
  $('.decoration-button').hover(
    function() {
      elemHover(this);
    },
    function() {
      elemUnhover(this);
    }
  );
  $('.sns-circle').hover(
    function() {
      elemHover(this);
    },
    function() {
      elemUnhover(this);
    }
  );
  $('.header-menu').hover(
    function() {
      var currentPage = location.pathname.replace("/", "").replace("/", "");
      if(currentPage.length > 0 && this.id.includes(currentPage)){
        return;
      }
      elemHover(this);
    },
    function() {
      elemUnhover(this);
    }
  );
  $('.sub-dir-nav-box').hover(
    function() {
      elemHover(this);
    },
    function() {
      elemUnhover(this);
    }
  );
  $('.top-special-contents-icon').hover(
    function() {
      elemHover(this);
    },
    function() {
      elemUnhover(this);
    }
  );
  $('.overseas-step-icon-box-image').hover(
    function() {
      elemHover(this);
    },
    function() {
      elemUnhover(this);
    }
  );
  $('.complete-mypage-icon').hover(
    function() {
      elemHover(this);
    },
    function() {
      elemUnhover(this);
    }
  );
  $('.top-detail-button').hover(
    function() {
      elemHover(this);
    },
    function() {
      elemUnhover(this);
    }
  );
  $('.mypage-nav-item').hover(
    function() {
      if(this.className.indexOf('mypage-nav-item-active') > -1){
        return;
      }
      elemHover(this);
    },
    function() {
      if(this.className.indexOf('mypage-nav-item-active') > -1){
        return;
      }
      elemUnhover(this);
    }
  );

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

  // 人気国特別ページ start
  $(document).ready(function() {
    var top_notion_popup = `
      <div class="guidance-notion-black-background"></div>
      <div class="pop-up-news white-content-box-guidance-notion global-contact">
        <div class="guidance-popup-close-button js-tabindex" tabindex="0">
          <img src="https://d1q08lkutgkcx2.cloudfront.net/image/popup-close.svg" alt="閉じる" width="18" height="18">
        </div>
        <div class="white-content-box-title white-content-box-title-notion white-content-box-title-guidance-notion">
          <p>人気国特設ページ</p>
        </div>
        <div class="white-content-box-inner-guidance popular-country-list">
          <div class="white-content-box-body">
            <div class="modal-box-popular">
              <ul>
                <li><a href="https://zeuswifi-global.jp/korea/ "target="blank"><img src="https://zeuswifi-global.jp/img/korea/kor.svg">韓国レンタル Wi-Fi</a></li>
                <li><a href="https://zeuswifi-global.jp/thailand/ "target="blank"><img src="https://zeuswifi-global.jp/img/tai.svg">タイレンタル Wi-Fi</a></li>
                <li><a href="https://zeuswifi-global.jp/taiwan/ "target="blank"><img src="https://zeuswifi-global.jp/img/twn.svg">台湾レンタル Wi-Fi</a></li>
                <li><a href="https://zeuswifi-global.jp/america/ "target="blank"><img src="https://zeuswifi-global.jp/img/usa.svg">アメリカレンタル Wi-Fi</a></li>
                <li><a href="https://zeuswifi-global.jp/hawaii/ "target="blank"><img src="https://zeuswifi-global.jp/img/hwi.svg">ハワイレンタル Wi-Fi</a></li>
              </ul>
              <ul>
                <li><a href="https://zeuswifi-global.jp/vietnam/ "target="blank"><img src="https://zeuswifi-global.jp/img/vnm.svg">ベトナムレンタル Wi-Fi</a></li>
                <li><a href="https://zeuswifi-global.jp/singapore/ "target="blank"><img src="https://zeuswifi-global.jp/img/sgp.svg">シンガポールレンタル Wi-Fi</a></li>
                <li><a href="https://zeuswifi-global.jp/philippines/ "target="blank"><img src="https://zeuswifi-global.jp/img/phl.svg">フィリピンレンタル Wi-Fi</a></li>
                <li><a href="https://zeuswifi-global.jp/australia/ "target="blank"><img src="https://zeuswifi-global.jp/img/aus.svg">オーストラリアレンタル Wi-Fi</a></li>
                <li><a href="https://zeuswifi-global.jp/china/ "target="blank"><img src="https://zeuswifi-global.jp/img/chn.svg">中国レンタル Wi-Fi</a></li>
              </ul>
              <ul>
                <li><a href="https://zeuswifi-global.jp/hongkong/ "target="blank"><img src="https://zeuswifi-global.jp/img/hkg.svg">香港レンタル Wi-Fi</a></li>
                <li><a href="https://zeuswifi-global.jp/spain/ "target="blank"><img src="https://zeuswifi-global.jp/img/esp.svg">スペインレンタル Wi-Fi</a></li>
                <li><a href="https://zeuswifi-global.jp/macau/ "target="blank"><img src="https://zeuswifi-global.jp/img/mac.svg">マカオレンタル Wi-Fi</a></li>
                <li><a href="https://zeuswifi-global.jp/guam/ "target="blank"><img src="https://zeuswifi-global.jp/img/gum.svg">グアムレンタル Wi-Fi</a></li>
                <li><a href="https://zeuswifi-global.jp/france/ "target="blank"><img src="https://zeuswifi-global.jp/img/fra.svg">フランスレンタル Wi-Fi</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      `;
    $("body").append(top_notion_popup);
    hideGuidancePopup();

    $('.popular-button a').on('click', function(){
      showGuidancePopup();
    });

    // ナビ 人気国特設ページのXを押したときに人気国特設ページのメニューにフォーカスをあてる
    $(".guidance-popup-close-button.js-tabindex").keydown(function(event) {
      if(event.keyCode == 13 ) { 
        hideGuidancePopup();
        $(".js-tabindex.popular-popup").focus();
      }
    });

    $(document).on("click", ".guidance-notion-black-background,.guidance-popup-close-button", function(){
      hideGuidancePopup();
    });
  });
  function hideGuidancePopup(){
    $(".guidance-notion-black-background").hide();
    $(".white-content-box-guidance-notion").hide();
  }
  function showGuidancePopup(){
    $(".guidance-notion-black-background").show();
    $(".white-content-box-guidance-notion").show();
  }
  $(function() {
    $(".-sp .ft-popular-list-col").hide();
    $(".ft_popular-list.-sp p").on('click', function(){
      $(this).next().slideToggle();
      $(".ft_popular-list.-sp p").toggleClass("open")
    });
  });
});