function isMyPage(){
  return location.pathname.indexOf("mypage") >= 0;
}

/* scroll on load */
var target = window.location.hash,
target = target.replace('#', '');

if(! window.location.pathname.includes("/faq")){
  window.location.hash = "";
}  

$(window).on('load', function () {
  if (window.location.pathname.match(/\/faq/)) return; // FAQは除外する
  if (window.location.href.match(/\/support_contact#/)){ // 問い合わせ(#あり)は特定の位置にジャンプする
    let ostTop = $('#contact-form-box').offset().top - 120;
    $(window).scrollTop(ostTop);
    return;
  } else if (window.location.href.match(/\/support_contact?/)){ // 問い合わせ(#あり)は特定の位置にジャンプする
      
    // URLにアンカーが存在する場合
    if(window.location.href.indexOf('#') !== -1){
      let ostTop = $('#contact-form-box').offset().top - 120;
      $(window).scrollTop(ostTop);            
    }

    var param = location.search;

    if(param.indexOf('anshinkaiyaku=1') !== -1){
      // パラメータにanshinkaiyaku=1があった時だけ実行したい処理
      $("select[name='contact_type']").val("解約・初期契約解除・あんしん解約サポート").change();
    }
    
    return;
  }
  if ($(target && "#" + target).offset()) {
    $('html, body').animate({
      scrollTop: $("#" + target).offset().top - 120
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
});
