//端末画像 クリックで画像パスを切り替える
$(function() {
  var thumbnail;
  $(".thumbnail").click(function(){
    thumbnail = $(this).children('img').attr('src');
    sizemini = $(this).children('img').attr('class');
    if(sizemini == 'size-mini') {
      $(".product-main").html('<img class="fade-in size-sm" src="' + thumbnail + '">');
    }else {
      $(".product-main").html('<img class="fade-in" src="' + thumbnail + '">');
    }
  });
});

// 端末スペックドロップダウン
$(function(){
  $(".spec-content").css("display","none");
  $(".btn-spec").on('click', function(){
    $(this).toggleClass("open");
    $(this).next().slideToggle(300);
  });
});

// backtotop
$(function(){
var pagetop = $('#page_top');
// ボタン非表示
pagetop.hide();

// 100px スクロールしたらボタン表示
$(window).scroll(function () {
  if ($(this).scrollTop() > 1000 && $('.footer-menu').offset().top - 1000 > $(this).scrollTop()) {
    pagetop.fadeIn();
  } else {
    pagetop.fadeOut();
  }
});
  pagetop.click(function () {
    $('body, html').animate({ scrollTop: 0 }, 500);
    return false;
  });
});

// 追従メニューよくあるご質問
$(function(){
  var footerMenu = $('#entry_fix');

  // 100px スクロールしたらボタン表示
  $(window).scroll(function () {
    if ($(this).scrollTop() > 1000 && $('.footer-menu').offset().top - 1000 > $(this).scrollTop()) {
      footerMenu.addClass('show');
    } else {
      footerMenu.removeClass('show');
    }
  });
});
