// Mypage path finder
function currentMypagePathIs(path) {
  if(path === 'password' && location.pathname.indexOf('password') > -1) {
    return true;
  }

  // pass parameter like 'faq'
  var a = "/mypage/prepaid/" + path;
  var b = "/mypage/prepaid/add-plan/" + path;

  if (location.pathname.indexOf(a) != -1){
    return true;
  }else if(location.pathname.indexOf(b) != -1){
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
    }else if (currentMypagePathIs('contract')){
      navOnCenter();
      $("#mypage-nav-item-2").addClass("mypage-nav-item-active");
    }else if (currentMypagePathIs('payment-history')){
      navOnCenter();
      $("#mypage-nav-item-3").addClass("mypage-nav-item-active");
    }else if (currentMypagePathIs('user') || currentMypagePathIs('password')){
      navOnCenter();
      $("#mypage-nav-item-4").addClass("mypage-nav-item-active");
    }else if (currentMypagePathIs('domestic')){
      navOnLeft();
      $("#mypage-nav-item-5").addClass("mypage-nav-item-active");
    }else if (currentMypagePathIs('overseas')){
      navOnLeft();
      $("#mypage-nav-item-6").addClass("mypage-nav-item-active");
    }else {
      // Do nothing
    }

    // Enable nav move animation with delay
    setTimeout(function(){
      $("div.mypage-nav-prepaid").css("transition", "0.5s");
      $("div.mypage-nav-center-moved").css("transition", "0.5s");
      $("div.mypage-nav-right-moved").css("transition", "0.5s");
    }, 500)
  });

  $("div.mypage-nav-arrow-left").addClass('mypage-nav-arrow-hidden');
  $("div.mypage-nav-arrow-left").removeClass('mypage-nav-arrow-shown');

  $("div.mypage-nav-arrow-left").click(function(){
    if($(".mypage-nav-prepaid").hasClass('mypage-nav-center-moved')) {
      navOnLeft();
    }else if($(".mypage-nav-prepaid").hasClass('mypage-nav-right-moved')) {
      navOnCenter();
    }
  })
  $("div.mypage-nav-arrow-right").click(function(){
    if($(".mypage-nav-prepaid").hasClass('mypage-nav-center-moved')) {
      navOnRight();
    }else {
      navOnCenter();
    }
  })

  const menu = $(".mypage-nav-prepaid");
  let touchStartX = 0;

  function handleSwipe(startX, endX) {
    const threshold = 50;

    if(startX - endX > threshold) {
      if($(".mypage-nav-prepaid").hasClass('mypage-nav-center-moved')) {
        navOnRight();
      }else {
        navOnCenter();
      }
    }else if (endX - startX > threshold) {
      if($(".mypage-nav-prepaid").hasClass('mypage-nav-center-moved')) {
        navOnLeft();
      }else if($(".mypage-nav-prepaid").hasClass('mypage-nav-right-moved')) {
        navOnCenter();
      }
    }
  }
  menu.on("touchstart", function(event){
    touchStartX = event.originalEvent.touches[0].clientX;
  });

  menu.on("touchend", function(event){
    const touchEndX = event.originalEvent.changedTouches[0].clientX;
    handleSwipe(touchStartX, touchEndX);
  });
});

// マイページヘッダースクロール途中で固定
$(function () {
  if ($('#mypage-nav-wrapper').length) {
    const pos = $('#mypage-nav-wrapper').offset().top;
    const height = $('mypage-nav-wrapper').outerHeight();

    $(window).scroll(function () {
      if ($(this).scrollTop() > pos) {
        $('#mypage-nav-wrapper').addClass('fixed');
        $( 'body' ).css( 'padding-top', height);
        } else {
        $('#mypage-nav-wrapper').removeClass('fixed');
        // bodyのpadding-topをなくす
        $( 'body' ).css( 'padding-top', 0);
      }
    });
  }
});

// マイページお客様情報の変更アドレスについてアコーディオン
$(function() {
  $(".mypage-attention-address-btn").click(function(e){
    var targetButton = $(e.target);
    var target = $('.mypage-attention-address');
    if (target.hasClass("hidden")){
      target.removeClass("hidden");
      targetButton.toggleClass("open");
    }else{
      target.addClass("hidden");
      targetButton.toggleClass("open");
    }
  });
});

// マイページパスワード変更のボタンを活性化
$(function() {
  $(".mypage-input-border").on('change keyup', function() {
    if($("input[name='password']").val() == "" || $("input[name='password_confirm']").val() == "") {
      $('.change-password-btn').addClass('decoration-button-area-disabled');
    }else if($("input[name='password']").val().length >= 8 && $("input[name='password']").val() == $("input[name='password_confirm']").val()) {
      $('.change-password-btn').removeClass('decoration-button-area-disabled');
    }else {
      $('.change-password-btn').addClass('decoration-button-area-disabled');
    }
  })
});

// マイページお客様情報変更の建物名にfocusがあたったら部屋番号を表示
$(function(){
  if($('input[name="building"]').val() != '' && $('input[name="room_number"]').val() != '') {
    $(".mypage-building-room").show();
  }
  $(".mypage-building").on('focus', function(){
    $(".mypage-building-room").show();
  });
  $(".mypage-building").on('input', function(){
    if($(this).val() !== '') {
      $(".mypage-building-room").show();
    }
  });
  $(".mypage-building").on('blur', function(){
    if($(this).val() == '') {
      $(".mypage-building-room").hide();
    }
  });
});
// プリペイドデータチャージ購入ページアクセス権限あり用バリデーションstart ////////////////////////////////////////////////////////////////////////////////////////////////
$(function () {
  const $attentionInput = $('.leave-checkbox-box-data-charge:input[type="checkbox"]');
  const $passwordInput = $('.cancel-input-data-charge:input[type="password"]');
  $(".button-prepaid-data-charge").on('click', () => {
    // アンケートエリアの入力チェック
    questionValid(1, 10);
    questionValid(2, null);
    questionValid(3, null);
    questionValid(4, 23);
    questionValid(4, 31);
    questionValid(4, 36);
    questionValid(4, 45);
    questionValid(4, 52);
    questionValid(4, 60);

    // 注意事項の入力チェック
    if ($('.leave-checkbox-box-data-charge:input[type="checkbox"]:checked').length) {
      removeErrorMessege(null, null, '#attention-check-data-charge .validator-error-data-charge');
      $attentionInput.css('outline', 'none');
    } else {
      if (!$('#attention-check-data-charge .validator-error-data-charge').length) {
        $('#attention-check-data-charge').append('<p class="validator-error-data-charge">選択してください</p>');
        $attentionInput.css('outline', '2px solid #ff0000');
      }
    }

    // パスワードのエラーメッセージが表示されていない場合
    if ($('#password-input .validator-error').css('display') === 'none') {
      $passwordInput.css('outline', 'none');
    }
    // パスワードの入力値が空＋エラーメッセージが表示されていない場合
    if (!$passwordInput.val()) {
      if (!$('#password-input .validator-error').length && !$('#password-input .validator-error-data-charge').length) {
        $('#password-input').append('<p class="validator-error-data-charge password">入力必須項目です</p>');
        $passwordInput.css('outline', '2px solid #ff0000');
      }
    }
  });

  // パスワードの入力チェック（フォーカスが外れた場合）
  $(".cancel-input-data-charge").on('blur', () => {
    removeErrorMessege(null, null, '#password-input .validator-error-data-charge');
    if ($('#password-input .validator-error').css('display') === 'none'
      || !$('#password-input .validator-error').length
    ) {
      $passwordInput.css('outline', 'none');
    } else {
      $passwordInput.css('outline', '2px solid #ff0000');
    }
  });
});

const removeErrorMessege = (id, target, unique) => {
  if (target) {
    // textareaのエラーメッセージリセット
    $(`.data-charge-question-${id} :input[name="leave-answer-text[${id}][${target}]"] + .validator-error-data-charge`).remove();
    $(`.data-charge-question-${id} :input[name="leave-answer-text[${id}][${target}]"]`).css('outline', 'none');
  } else if (unique) {
    // アンケート以外のエラーメッセージリセット
    $(unique).remove();
  } else {
    // 該当エリアのバリデーションエラーメッセージを削除＋フォームのバリデーションスタイルをリセット
    $(`#data-charge-question_text_${id} .validator-error-data-charge`).remove();
    $(`.data-charge-question-${id} :input[type="checkbox"]`).css('outline', 'none');
    $(`.data-charge-question-${id} :input[type="radio"]`).css('outline', 'none');
  }
};

const questionValid = (id, target) => {
  // 非表示の場合はreturn
  if($(`.data-charge-question-${id}`).css('display') === 'none') return

  const $typeCheckbox = `.data-charge-question-${id} :input#leave-survey-answer-checkbox-${id}-${target}[type="checkbox"]`;
  const $typeRadio = `.data-charge-question-${id} :input#leave-survey-answer-checkbox-${id}-${target}[type="radio"]`;
  const $typeTextarea = `.data-charge-question-${id} :input[name="leave-answer-text[${id}][${target}]"]`;
  // チェックあり && チェクボックスに隣接するtextereaが空の場合
  if (($($typeCheckbox).prop('checked') || $($typeRadio).prop('checked')) && !$($typeTextarea).val()) {
    if (!$(`.data-charge-question-${id} :input[name="leave-answer-text[${id}][${target}]"] + .validator-error-data-charge`).length) {
      $($typeTextarea).after('<p class="validator-error-data-charge text">入力必須項目です</p>');
      $($typeTextarea).css('outline', '2px solid #ff0000');
    }
  } else {
    removeErrorMessege(`${id}`, `${target}`, null);
  }
  // 該当エリアのアンケートのcheckboxにチェックが入っている場合
  if ($(`.data-charge-question-${id} :input:checked`).length) {
    removeErrorMessege(`${id}`, null, null)
  } else {
    if (!$(`#data-charge-question_text_${id} .validator-error-data-charge`).length) {
      $(`#data-charge-question_text_${id}`).append('<p class="validator-error-data-charge">選択してください</p>');
      $(`.data-charge-question-${id} :input[type="checkbox"]`).css('outline', '2px solid #ff0000');
      $(`.data-charge-question-${id} :input[type="radio"]`).css('outline', '2px solid #ff0000');
    }
  }
}
// プリペイドデータチャージ購入ページアクセス権限あり用バリデーションend ////////////////////////////////////////////////////////////////////////////////////////////////

$(function() {
  $('.mypage-prepaid-main .cancel-option-text:first-child').insertAfter('.mypage-prepaid-main .cancel-option-text:last-child');
});

document.addEventListener('DOMContentLoaded', () => {
  const tableContainers = document.querySelectorAll('#mypage-nav-wrapper');

  for (const tableContainer of tableContainers) {
    const scrollHint = document.createElement('div');
    scrollHint.className = 'scroll-hint scroll-hint--show';
    scrollHint.innerText = '➡';
    tableContainer.appendChild(scrollHint);

    const showScrollHint = () => {
      if (tableContainer.scrollWidth > tableContainer.clientWidth) {
        scrollHint.classList.add('scroll-hint--show');
      } else {
        scrollHint.classList.remove('scroll-hint--show');
      }
    };
    showScrollHint();

    tableContainer.addEventListener('scroll', () => {
      scrollHint.classList.remove('scroll-hint--show');
    });
  }
});
