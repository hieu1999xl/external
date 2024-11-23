/* ウェブアクセシビリティ対応 専用 */
$(function() {
  // 共通処理（クリックしたい時）
  $('.js-tabindex').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      $(this).click();
    }
  });
  $(".form-capacity-pull-down-button-right").click(function(){
    if($(".form-capacity-description-body-right").hasClass("hidden")){
      $(this).children(".pull-down-arrow-to-open").show();
      $(this).children(".pull-down-arrow-to-close").hide();
    }else{
      $(this).children(".pull-down-arrow-to-open").hide();
      $(this).children(".pull-down-arrow-to-close").show();
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

  // atoneの申込みボタン
  $('.js-tabindex-atone').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      if ($(this).hasClass('js-noenter')) return;
      atonePurchase();
    }
  });

  // 共通処理（ホバーしたい時）
  $('.js-hover').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      $('.faq-link-main').toggleClass('hover');
    }
  });

  // WIMAX共通ヘッダー：フォーカスした要素に対してEnterを押すとdisplay:blockを追加
  $('.faq-link-main').keydown(function(event) {
    if (event.keyCode === 13) { // 13はEnterキーのキーコード
        $('.faq-link-sub li').css('display', 'block');
    }
  });

  // フォーカスが外れたときの処理
  $('.nav_option, .nav_type01.nav-btn').on('focusin', function() {
      // .faq-link-sub liを非表示にする
      $('.faq-link-sub li').css('display', 'none');
  });

  // マウスでhoverしたときの処理
  $('.faq-link-main').hover(
      function() {
          // マウスがhoverしたときに表示する
          $('.faq-link-sub li').css('display', 'block');
      },
      function() {
          // hoverを外したときに非表示にする
          $('.faq-link-sub li').css('display', 'none');
      }
  );

  // ラジオボタンのチェック
  $('.js-input-radio').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      var target = $(this).find('input');
      target.prop('checked', true);

      /* サブスク/申し込みフォーム */
      // STEP1：デジタルライフサポートのチェックだった場合は金額更新関数を実行する
      if (window.location.pathname.includes('/entry/select')) {
        $(this).hasClass('option-digital-life') && updateSummary();
      }
      // STEP2/3：ご利用様情報の表示制御(個人)
      if (window.location.pathname.includes('/entry/user')
        || window.location.pathname.includes('/entry/confirm')
        || window.location.pathname.includes('/entry/oh_specialplans/user')
        || window.location.pathname.includes('/entry/oh_specialplans/confirm')) {
        // ご利用様情報が「ご契約者様と異なる」場合
        if ($('input#user_info_different:checked').val()) {
          // 住所入力フォームを表示
          $(".mypage-user-info-detail").removeClass("mypage-user-info-detail-hidden");
          // STEP2：「配送先について」エリアを表示
          $(".mypage-address-info").removeClass("not-inputted-items-hidden");
          // STEP3：「配送先住所を変更する」導線を表示
          $(".delivery-address-change").show();
        } else {
        // ご利用様情報が「ご契約者様と同じ」場合
          // 住所入力フォームを非表示
          $(".mypage-user-info-detail").addClass("mypage-user-info-detail-hidden");
          // STEP2：「配送先について」エリアを非表示
          $(".mypage-address-info").addClass("not-inputted-items-hidden");
          // STEP3：「配送先住所を変更する」導線を非表示
          $(".delivery-address-change").hide();
          // 配送先情報の「ご契約者様と同じ」にチェックを付ける
          $("#delivery_info_same").prop("checked",true);
        }
      } 

      // 問い合わせフォーム
      if (window.location.pathname.includes('/support_contact')
        || window.location.pathname.includes('/wimax_support_contact')
        || window.location.pathname.includes('/prepaid_support_contact')
        || window.location.pathname.includes('/entry/overseas/user')
        || window.location.pathname.includes('/entry/overseas/confirm')) {
        var input = $(this).find('input');
        // 個人を選択した時の表示制御
        if (input.val() === 'personal') {
          $(".company-tr").hide();
          $(".personal-tr").show();
          $('.company-tr-2').hide();
          $('.form-table select').val('選択してください');
        // 法人を選択した時の表示制御
        } else if (input.val() === 'company') {
          $(".personal-tr").hide();
          $(".company-tr").show();
          $('.personal-tr-2').hide();
          $('.form-table select').val('選択してください');
        }
      }

      /* WiMAX/申し込みフォーム */
      if (window.location.pathname.includes('/entry/wimax/select') || window.location.pathname.includes('/entry/wimax/confirm')) {
        // 端末選択の制御
        if ($(this).hasClass('plan')) {
          $('.wimax-device-select-box-reset').removeClass('selected');
          var target = $(this).parent('.form-capacity-select-checkbox-area-wimax').prevAll('.wimax-device-select-box-reset');
          var targetTerminal = target.parent('.wimax-device-select');
          // 端末選択時のスタイル反映
          target.addClass('selected');
          // 端末が Speed Wi-Fi 5G X12 だった場合は端末カラー選択を表示する
          if (targetTerminal.hasClass('X12')) {
            $('.x12-detail').show();
          } else {
            $('.x12-detail').hide();
          }
        }
        // 端末カラー選択の制御
        if ($(this).hasClass('x12-detail-gray')) {
          // シャドーブラック端末を表示＋活性化
          $('.x12-black').show();
          $('.x12-black').addClass('selected');
          $('.x12-color-1').addClass('selected');
          // アイスホワイト端末を非表示＋非活性化
          $('.x12-white').hide();
          $('.x12-white').removeClass('selected');
          $('.x12-color-2').removeClass('selected');
        } else if ($(this).hasClass('x12-detail-white')) {
          // アイスホワイト端末を表示＋活性化
          $('.x12-white').show();
          $('.x12-white').addClass('selected');
          $('.x12-color-2').addClass('selected');
          // シャドーブラック端末を非表示＋非活性化
          $('.x12-black').hide();
          $('.x12-black').removeClass('selected');
          $('.x12-color-1').removeClass('selected');
        }
        // 端末代金支払い回数選択の制御
        if ($(this).hasClass('entry-option-payment-common')) {
          var target = $(this).find('.topping-2-select-area-wimax-payment');
          $('.topping-2-select-area-wimax-payment').removeClass('selected');
          target.addClass('selected');
        }
      }
    }
  });

  // 支払い方法選択ページのラジオボタンのチェック
  $('.js-input-radio-payment').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      var target = $(this).find('input');
      target.prop('checked', true).change();
    }
  });

  // Enterキーでポップアップを閉じるときのアクション登録
  $('.alart-popup-close-button').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      // ポップアップを閉じる
      $('.option-popup-block').removeClass('active');
      // 次のフォーカスターゲットを指定する
      var focusmove = $(this).data('focusmove');
      // フォーカスする
      $('.' + focusmove).focus();
      return false;
    }
  });

  //STEP2/3：配送先情報(法人１台）の切り替え　キーボード操作
  $('.js-input-radio').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      var target = $(this).find('input');
      target.prop('checked', true);
      //配送先が異なる　にチェックついてる
      var deliveryFlag = $('input#delivery_info_different').prop('checked');
      
      if (window.location.pathname.includes('/entry/corp/user')
        || window.location.pathname.includes('/entry/corp/confirm')){
        //配送先が異なるにチェックしてたら、入力項目表示
        if(deliveryFlag == true){
          $(".mypage-delivery-info-detail").removeClass("mypage-delivery-info-detail-hidden");
        //配送先が同じにチェックしてたら、入力項目非表示
        }else {
          $(".mypage-delivery-info-detail").addClass("mypage-delivery-info-detail-hidden");
          $(".mypage-delivery-info-detail").addClass("not-inputted-items-hidden");
          $(".js-building-room.delivery-building-room").removeClass("active");
        }
      }    
    }
  });

  //STEP2/3：配送先情報(法人１台）の切り替え　クリック操作
  $('.js-input-radio').click(function() {
    //配送先が異なる　にチェックついてる
    var deliveryFlag = $('input#delivery_info_different').prop('checked');
    if(deliveryFlag){
      $(".js-building-room.delivery-building-room").removeClass("active");
    }
  });

  //STEP2/3：請求先情報(法人１台）の切り替え　キーボード操作
  $('.js-input-radio').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      var target = $(this).find('input');
      target.prop('checked', true);
      //請求先が異なる　にチェックついてる
      var corpInfoFlag = $('input#corp_info_different').prop('checked');

      if (window.location.pathname.includes('/entry/corp/user')
        || window.location.pathname.includes('/entry/corp/confirm')){
        //請求先が異なるにチェックにチェックしてたら、入力項目表示
        if(corpInfoFlag == true) {
          $(".mypage-user-info-detail").removeClass("mypage-user-info-detail-hidden");
          $(".mypage-user-info-detail").removeClass("not-inputted-items-hidden");
          //請求先が同じにチェックにチェックしてたら、入力項目非表示
        }else {
          $(".mypage-user-info-detail").addClass("mypage-user-info-detail-hidden");
          $(".mypage-user-info-detail").addClass("not-inputted-items-hidden");
        }
      } 
    }
  });

  // STEP1/3：プラン選択
  $('.form-capacity-select-area').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      // 初期表示に戻す
      $('.form-capacity-select-area').removeClass('selected');
      // 選択要素内のinputタグを特定し選択状態にする
      var checkBox = $(this).siblings('.form-capacity-select-checkbox-area').find('input');
      checkBox.prop('checked', true);
      $(this).addClass('selected');
      // 金額表示設定の関数を実行する
      updateSummary();
      updateCorpSummary();
    }
  });

  // STEP1/3：プラン選択（プリペイドプラン）
  $('.prepaid-plan').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      // 初期表示に戻す
      $('.prepaid-plan').removeClass('selected');
      // 選択要素内のinputタグを特定し選択状態にする
      var checkBox = $(this).find('input');
      checkBox.prop('checked', true);
      $(this).addClass('selected');
      // 金額表示設定の関数を実行する
      prepaidForm();
    }
  });

  // STEP3：「同意する」のチェックボックス
  $('.js-confirm-box').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      var target = $(this).find('input');
      var entryBtnDraft = $('input#form-entry-button-submit-1'); // 仮申し込み画面：申し込み確定ボタン
      /*「同意する」チェック済みの場合 */
      if (target.prop('checked')) {
        // チェックを外す
        target.prop('checked', false);
        // 支払い情報入力ボタンを非活性にする
        $('div#entry_user_submit').addClass('decoration-button-area-disabled');
        $('input#button-submit').attr('disabled', 'disabled');
        // 仮申し込み画面：エラーメッセージが表示されていない場合申し込み確定ボタンを非活性にする
        if (entryBtnDraft && (!$('.validator-error').length || $('.validator-error').css('display') === 'none')) {
          entryBtnDraft.attr('disabled', 'disabled');
        }
      } else {
      /*「同意する」未チェックの場合 */
        // チェックを付ける
        target.prop('checked', true);
        // 支払い情報入力ボタンを活性にする
        $('div#entry_user_submit').removeClass('decoration-button-area-disabled');
        $('input#button-submit').removeAttr('disabled');
        // 仮申し込み画面：エラーメッセージが表示されていない場合申し込み確定ボタンを活性にする
        if (entryBtnDraft && (!$('.validator-error').length || $('.validator-error').css('display') === 'none')) {
          entryBtnDraft.removeAttr('disabled');
        } 
      }
    }
  });

  if (window.location.pathname.includes('/entry/oh_specialplans/select') || window.location.pathname.includes('/entry/oh_specialplans/confirm')) {
    // ご契約者限定プラン申込フォーム
    $('.js-input-radio-openhouse').keydown(function(event) {
      if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
        var target = $(this).next().find('input');
        target.prop('checked', true).change();
      }
    });
    // 端末安心オプションの内容詳細のドロップダウン
    $('.js-expandFormOptionDetail').keydown(function(event) {
      if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
        expandFormOptionDetail();
      }
    });
    $('.js-expandFormOptionDetail').click(function() {
      expandFormOptionDetail();
    });

    // 端末安心オプションのポップアップ出現時に閉じるボタンをフォーカス
    $('.js-showOptionAlart').keydown(function(event) {
      if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
        $(".alart-popup-close-button.js-tabindex-tanmatsu-popup").focus();
      }
    });
    
    $(".alart-popup-close-button, .custom-check-box-v2.btn-option-close").keyup(function(event) {
      if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
        $(".topping-2-select-area.js-input-radio-openhouse").focus();
      }
    });

    $('.js-tabindex-oh').keydown(function(event) {
      if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
        $(this).click();
      }
    });
  }

  // ラジオボタンのチェックの切り替えでchangeイベントを発火させる
  $('.js-input-radio-change').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      var target = $(this).find('input');
      target.prop('checked', true).change();
      return false;
    }
  });

  // 端末安心オプション　本当に加入しなくて大丈夫ですかポップアップのエンターキー
  $('.js-tabindex-tanmatsu-popup').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      $(this).click();
    }
  });

  // 容量選びのヒントポップアップのフォーカス設定
  $(".price-fix-hint.js-tabindex, .hint_pop .close").keydown(function(event) {
    if(event.keyCode == 13 ) {
      if($(".price-fix-hint,.hint_pop").hasClass("active")){
        // ポップアップを開いた場合の処理
        if (typeof ul_widget == 'function') ul_widget('show');
        $(".price-fix-hint,.hint_pop").removeClass("active");
        // ポップアップの閉じるボタンにフォーカスを当てる
        $(".hint_pop .close, .hint_pop_inner").attr('tabindex', 0);
        $(".hint_pop .close").focus();
      }else{
        // ポップアップを閉じた場合の処理
        if (typeof ul_widget == 'function') ul_widget('hide');
        $(".price-fix-hint,.hint_pop").addClass("active");
        // フォーカスを外す
        $(".hint_pop .close, .hint_pop_inner").removeAttr('tabindex');
        // 追従ボタンにフォーカスを当てる
        $(".price-fix-hint.js-tabindex").focus();
      }
    }
  });

  // slickのタブフォーカスを無効にする
  $(".slider-notabindex li").attr('tabindex', -1);
  // slickのボタンのタブフォーカスとクリックを有効にする
  $(".slick-arrow").attr('tabindex', 0);
  $(".slick-arrow").addClass('js-tabindex');

  $(".free-giga-btn").keydown(function(event) {
    if(event.keyCode == 13 ) {
      $(this).click();
    }
  });

  $("#sp-menu").keydown(function(event) {
    if(event.keyCode == 13 ) {
      $(this).click();
    }
  });

  $(".sp_nav_type04").keydown(function(event) {
    if(event.keyCode == 13 ) {
      $(this).click();
    }
  });

  $("#price_fix").keydown(function(event) {
    if(event.keyCode == 13 ) {
    $(this).click();
  }
  });

  $(".hint_pop .close").keydown(function(event) {
    if(event.keyCode == 13 ) {
    $(this).click();
  }
  });

  // お客様サポート：カスタマーセンター問い合わせモーダルのフォーカス制御
  $('.callcenter-modal-open').keyup(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      $('.callcenter-modal-close').focus();
    }
  });
  $('.callcenter-modal-close').keyup(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      $('.callcenter-modal-open').focus();
    }
  });

  // お知らせ画面：タブ操作によるページネーション移動制御
  if (window.location.pathname.includes('/news')) {
    $(window).load(function(){
      $('.pagination li').each(function() {
        $(this).keydown(function(event) {
          if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
            $(this).click();
          }
        });
      });
    });
  }

  //  ナビ　人気国特設ページのメニューを押したときにXにフォーカスをあてる
  $(".js-tabindex.popular-popup").keydown(function(event) {
    if(event.keyCode == 13 ) { 
      $(".guidance-popup-close-button").focus();
    }
  });

  // ナビ(SP) 開いたときにXにフォーカスをあてる
  $(".sp-nav-btn").keydown(function(event) {
    if(event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      $(".close-btn").focus();
    }
  });

  // ナビ(SP) 閉じたときにメニューにフォーカスをあてる
  $(".close-btn").keydown(function(event) {
    if(event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      $(".sp-nav-btn").focus();
    }
  });

  // 海外レンタル申し込みフォーム（SP）内訳コンテンツ内にフォーカスを当てる
  if (window.location.pathname.includes('/entry/overseas/select')
  && window.matchMedia('(max-width:767px)').matches ) {
    $('.entry-overseas-select .detail-more').attr('tabindex', 0);
  }
});
$(function() {
  // マイページ start ////////////////////////////////////////////////
  // 解約前アンケートのラジオボタンのチェック
  $('.js-simple-radio').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      $(this).prop('checked', true).click();
    }
  });
  // マイページ end ////////////////////////////////////////////////
});
$(function() {
  // 海外レンタルお問い合わせ////////////////////////////////////////////////
  // 個人、法人のラジオボタンのチェック
  $('.js-input-radio-global').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      var target = $(this).find('input');
      target.prop('checked', true);

      // 問い合わせフォーム
      if (window.location.pathname.includes('/global_support_contact')) {
        var input = $(this).find('input');
        // 個人を選択した時の表示制御
        if (input.val() === 'personal') {
          $(".company-tr").hide();
          $(".personal-tr").show();
          $(".invalid-feedback, .validation-contact-text").text("");
          $(".global-contact .contact-input-border").val("");
          $("select[name='contact_type']").val("選択してください");
          $("#contact-submit-button").addClass("disabled");
        // 法人を選択した時の表示制御
        } else if (input.val() === 'company') {
          $(".personal-tr").hide();
          $(".company-tr").show();
          $(".invalid-feedback, .validation-contact-text").text("");
          $(".global-contact .contact-input-border").val("");
          $("select[name='contact_type_company']").val("選択してください");
          $("#contact-submit-button").addClass("disabled");
        }
      }
    }
  });

  // 入力フォームでエンターを押したときに送信されるのを防止
  $(".global-contact .contact-input-border ,input[name='business_type']").keydown(function(event) {
    if( event.keyCode == 13 ) {
      return false;
    }else {
      return true;
    }
  });

  // 送信内容の確認ボタンが活性の時のみクリックする
  $(".js-tabindex-submit").keydown(function(event) {
    if(event.keyCode == 13 ) {
      var flg = $("#contact-submit-button").hasClass("disabled");
      if(!flg) {
        $(this).click();
      }
    }
  });
  // 海外レンタルお問い合わせここまで////////////////////////////////////////////////
});

$(function() {
  // ポップアップを表示するボタンのクリックイベント
  $('.ac-popup-open').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      var focusmove;
      focusmove = $(this).data('focusmove');
      $('.alart-popup-close-button').data('focusmove', focusmove);
      
      $('.alart-popup-close-button').focus();
    }
    
  });
});

// 海外レンタルマイページ////////////////////////////////////////////////
$(function() {
  // プラン変更・追加・期間延長のポップアップボタン
  $('.js-tabindex-plan-popup').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      $(this).click();
      var focusmove = $(this).attr('data-focusmove');
      $('.alart-popup-close-button').attr('data-focusmove', focusmove);
    }
  });
  // 同意するボタンのチェックの切り替え
  $('.js-input-agree-change').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      var target = $(this).find('input');
      if (target.prop('checked')) {
        target.prop('checked', false).change();
      }else {
        target.prop('checked', true).change();
      }
      return false;
    }
  });
  // ボタンが非活性のときはエンターでクリックしないように
  $('.js-tabindex-noenter').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      if ($(this).hasClass('decoration-button-area-disabled')) {
        return false;
      }else {
        $(this).click();
      }
    }
  });
  // ポップアップを表示する時の処理
  $('.button-save').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
    $(this).find(".button-body").trigger("click");
    
    // ポップアップを表示する時の処理
      // .my-divクラスを持つ要素に new-class を追加
        $('.dialog-btn-neg').addClass('js-tabindex');
        $('.dialog-btn-red').addClass('js-tabindex');
        $('.dialog-btn-neg').attr('tabindex',0);
        $('.dialog-btn-red').attr('tabindex',0);
      }
  });
});

// mypage nav
$(document).ready(function() {
  // 初期状態でタブインデックスを設定する関数
  function setInitialTabIndexes() {
    if ($(window).width() <= 767) {
      $('.second-half').attr('tabindex', '-1');
      $('.second-half').attr('aria-hidden', 'true');
    } else {
      $('.second-half').removeAttr('tabindex');
    }
  }

  // `tabindex` と `aria-hidden` を更新する関数
  function updateTabIndexes() {
    $('.first-half, .second-half').each(function() {
      // 現在の `tabindex` に応じて `aria-hidden` を更新
      if ($(this).attr('tabindex') === '0') {
        $(this).removeAttr('aria-hidden');
      } else {
        $(this).attr('aria-hidden', 'true');
      }
    });
  }

  // `.mypage-nav-arrow-right` がクリックされた時の処理
  $('.mypage-nav-arrow-right').click(function() {
    if ($(window).width() <= 767) {
      $('.first-half').attr('tabindex', '-1');
      $('.second-half').attr('tabindex', '0');
      updateTabIndexes();
    }
  });

  // `.mypage-nav-arrow-left` がクリックされた時の処理
  $('.mypage-nav-arrow-left').click(function() {
    if ($(window).width() <= 767) {
      $('.second-half').attr('tabindex', '-1');
      $('.first-half').attr('tabindex', '0');
      updateTabIndexes();
    }
  });

  // ウィンドウリサイズ時に `tabindex` を更新
  $(window).resize(function() {
    setInitialTabIndexes(); // タブインデックスをリサイズ時に更新
    updateTabIndexes(); // aria-hidden の更新
  });

  // ページロード時に一度呼び出して、初期状態を設定する
  setInitialTabIndexes();

  //セゾンカード受付番号入力 ポップアップをフォーカス
  $('.js-saison-already-btn').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      $(".js-saison-popup-close").focus();
    }
  });
  //セゾンカード受付番号入力 ポップアップを閉じたときにボタンをフォーカス
  $('.js-saison-popup-close').keydown(function(event) {
    if( event.keyCode == 13 ) { // 13：EnterキーのkeyCode
      $(".js-saison-already-btn").focus();
      $(this).click();
    }
  });
});




// 申し込みcancelページ
$(document).ready(function() {
  if (window.location.pathname.includes('/rental/entry_cancel')) {
    // 初期状態でボタンを無効にする
    $('.js-user-close').addClass('disabled').attr('tabindex', '-1').prop('disabled', true);

    // チェックボックスとパスワード入力の監視
    function toggleSubmitButton() {
      var isCheckboxChecked = $('#cancel-contract-checkbox').is(':checked');
      var isPasswordFilled = $('#leave-password').val().trim().length >= 8; // パスワードは8文字以上

      if (isCheckboxChecked && isPasswordFilled) {
        $('.js-user-close').removeClass('disabled').attr('tabindex', '0').prop('disabled', false);
      } else {
        $('.js-user-close').addClass('disabled').attr('tabindex', '-1').prop('disabled', true);  // 修正
      }
    }

    // ボタンが有効なときにエンターキーまたはクリックで動作
    $('.js-user-close').on('keydown click', function(e) {
      if ($(this).hasClass('disabled')) return;
    });

    // イベントリスナーを設定
    $('#cancel-contract-checkbox').change(toggleSubmitButton);
    $('#leave-password').on('input', toggleSubmitButton);

    // ページロード時に一度呼び出して、初期状態を設定する
    toggleSubmitButton();
  }
});

// クリックしたらビフォアーが回転
$(document).ready(function() {
  // .yellow-link をクリックしたときのイベント
  $('.yellow-link').click(function() {
    // 親要素である .mypage-attention-address-btn に open クラスをトグルする
    $(this).closest('.mypage-attention-address-btn').toggleClass('open');
  });
});

// 海外レンタルマイページここまで////////////////////////////////////////////////

$(document).ready(function () {
  // フォーカスがcountry js-tabindexに当たった時の処理
  $('.country.focus-decoration.js-tabindex').keydown(function (e) {
      // Enterキー（キーコード13）を検出
      if (e.key === "Enter" || e.keyCode === 13) {
          // 内部のラジオボタンをクリックしてチェックを入れる
          $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
      }
  });
});

if (window.location.pathname.includes('/mypage/prepaid/add-plan/overseas/change') || window.location.pathname.includes('/mypage/prepaid/add-plan/overseas/extension')) {
  $(document).ready(function () {
    // チェックボックスの状態が変更されたときの処理
    $('input[type="checkbox"][name="extension-country"]').on('change', function () {
      // チェックが入ったチェックボックスを除く、同じ name 属性を持つ他のチェックボックスを探す
      if ($(this).is(':checked')) {
        $('input[type="checkbox"][name="extension-country"]').not(this).prop('checked', false);
      }
    });

    // チェックボックスにフォーカスが当たったときの処理
    $('input[type="checkbox"][name="extension-country"]').on('focus', function () {
      // 現在のチェックボックスの親の<th>を取得し、そこにスタイルを適用
      $(this).closest('tr').find('.focus-decoration').addClass('focused-before');
    });
  
    // チェックボックスからフォーカスが外れたときの処理
    $('input[type="checkbox"][name="extension-country"]').on('blur', function () {
      // フォーカスが外れたチェックボックスの親の<th>からスタイルを削除
      $(this).closest('tr').find('.focus-decoration').removeClass('focused-before');
    });
  });
};
