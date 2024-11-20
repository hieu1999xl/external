// アンケート start ////////////////////////////////////////////////////////////////////////////////////////////////
$(function () {
  const $attentionInput = $('.leave-checkbox-box-data-charge:input[type="checkbox"]');
  const $passwordInput = $('.cancel-input-data-charge:input[type="password"]');
  $(".mypage-cancel-button").on('click', () => {
    // アンケートエリアの入力チェック
    questionValid(1, 10);
    questionValid(1, 70);
    questionValid(2, null);
    if(!window.location.pathname.includes("/initial_contract_cancellation_application")){
      questionValid(3, null);
    }
    questionValid(4, 23);
    questionValid(4, 31);
    questionValid(4, 33);
    questionValid(4, 36);
    questionValid(4, 38);
    questionValid(4, 45);
    questionValid(4, 50);
    questionValid(4, 52);
    questionValid(4, 57);
    questionValid(4, 60);
    questionValid(4, 62);
    questionValid(4, 83);
    questionValid(4, 93);
    questionValid(4, 98);
    questionValid(4, 110);
    questionValid(4, 117);
    questionValid(4, 120);

    if(window.location.pathname.includes("/initial_contract_cancellation_application") && $('.validator-error-data-charge').length === 0){
      $("#button-submit").prop('disabled', false);
    }

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

        // 取得した値のid属性がついた要素の位置を取得
        const offsetTop = $('#data-charge-question_text_1').offset().top;

        // 取得した箇所に移動
        $("html, body").animate({ scrollTop: offsetTop }, 200);
      }
  } else {
    removeErrorMessege(`${id}`, `${target}`, null);
  }
  // 該当エリアのアンケートのcheckboxにチェックが入っている場合
  if ($(`.data-charge-question-${id} :input:checked`).length) {
    removeErrorMessege(`${id}`, null, null);
  } else {
    if (!$(`#data-charge-question_text_${id} .validator-error-data-charge`).length) {
      $(`#data-charge-question_text_${id}`).append('<p class="validator-error-data-charge">選択してください</p>');
      $(`.data-charge-question-${id} :input[type="checkbox"]`).css('outline', '2px solid #ff0000');
      $(`.data-charge-question-${id} :input[type="radio"]`).css('outline', '2px solid #ff0000');

      // 取得した値のid属性がついた要素の位置を取得
      const offsetTop = $('#data-charge-question_text_1').offset().top;

      // 取得した箇所に移動
      $("html, body").animate({ scrollTop: offsetTop }, 200);
    }
  }
}
// アンケート end ////////////////////////////////////////////////////////////////////////////////////////////////