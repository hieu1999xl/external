$(function() {
  $(".js-dropdown-content").css("display","none");
  $(".js-dropdown-btn").on('click', function(){
    $(this).toggleClass("open");
    $(this).next().slideToggle(300);
  })
});

// 領収書ダウンロード 宛名入力ポップアップ
let inputReceiptName = '';
let inputHonor = '';
$(function() {
  // ポップアップを開いた際に初期値に戻す
  $(".js-option-popup").on('click', function() {
    $('.popup-receipt-name').addClass('active');
    $('.popup-receipt-confirm').removeClass('active');
    $('.popup-receipt-input').val('');
    $('input[id="onchu"]').prop('checked', true);
    $('#popup-receipt').find($('#corp_company_name-error')).css('display', 'none');
  })
  // 宛名入力欄blur時の制御
  $('.popup-receipt-input').blur(() => {
    const blankSpace = !$('.popup-receipt-input').val() || !$('.popup-receipt-input').val().match(/\S/g);
    const errorMessage = $('#popup-receipt').find($('#corp_company_name-error'));
    // 空白文字のみの場合はinputをリセットする
    if (blankSpace) {
      $('.popup-receipt-input').val('');
    }
    // ボタンの活性制御
    if (errorMessage.css('display') === 'none'
      || ($('.popup-receipt-input').val() && !errorMessage.length)
    ) {
      $('.popup-receipt-button.confirm').prop('disabled', false)
    } else {
      $('.popup-receipt-button.confirm').prop('disabled', true)
    }
  })
});
function receiptNameConfirm(){
  $('.popup-receipt-name').removeClass('active');
  $('.popup-receipt-confirm').addClass('active');
  inputReceiptName = $('.popup-receipt-input').val();
  inputHonor = $('input[name="honor"]:checked').val();
  inputHonorId = $('input[name="honor"]:checked').attr('number');
  $('#inputReceiptName').html(inputReceiptName);
  $('#inputHonor').html(inputHonor);
}
function receiptNameCancel(){
  $('.popup-receipt-name').addClass('active');
  $('.popup-receipt-confirm').removeClass('active');
}
function receiptNameCreate(){
  $('.option-popup-block').removeClass('active');
  // MEMO: 宛名＋敬称（BE側取り込み後に削除する）
  console.log(inputReceiptName + inputHonor);
}
// 領収書IDをポップアップに渡す
function pickupReceiptId(receipt_id){
  $('#selected_receipt_id').val(receipt_id);
}
// 領収書をダウンロードする（選択した領収書ボタンが属するformをsubmitする）
function submitReceiptDownload() {
  var receipt_id = $('#selected_receipt_id').val();
  $('#name_'+receipt_id).val(inputReceiptName);
  $('#honor_'+receipt_id).val(inputHonorId);
  $('#form_'+receipt_id).submit();
  $('.option-popup-block').removeClass('active');
  return false;
}


$(document).ready(function() {
  // 全ての .js-down-btn の元の親要素を記録するための配列
  var originalParents = [];

  // 各 .js-down-btn の元の親要素を記録
  $('.js-down-btn').each(function(index) {
    originalParents[index] = $(this).parent();
  });

  // hidden を持つ親要素があるか確認する関数
  function isElementInHiddenParent(element) {
    return element.parents().filter(function() {
      return $(this).is('[hidden]');
    }).length > 0;
  }

  // レスポンシブレイアウトを処理する関数
  function handleResponsiveLayout() {
    $('.js-down-btn').each(function(index) {
      var $this = $(this);

      // 親要素に hidden 属性があるか確認し、ある場合はスキップ
      if (isElementInHiddenParent($this)) {
        return;
      }

      if (window.matchMedia("(max-width: 767px)").matches) {
        // 画面幅が767px以下の場合
        var leftButton = $this.detach(); // .js-down-btn を取り外す
        $('.js-up-btn').after(leftButton); // .js-up-btn の後に挿入
        leftButton.show(); // leftボタンを表示
      } else {
        // 画面幅が767pxより広い場合
        var leftButton = $this.detach(); // .js-down-btn を取り外す
        originalParents[index].prepend(leftButton); // 元の親要素に戻す
        leftButton.show(); // leftボタンを再表示
      }
    });
  }

  // 初回ロード時にレイアウトを処理
  handleResponsiveLayout();

  // ウィンドウリサイズ時にもレイアウトを処理
  $(window).resize(function() {
    handleResponsiveLayout();
  });
});
