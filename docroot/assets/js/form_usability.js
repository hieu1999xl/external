// フォーム入力のユーザビリティ改善用JSファイル

// 全角英数文字を英数半角に自動変換（メールアドレス用）
$(function() {
  $('.alphanumeric').change(function(){
    var txt  = $(this).val();
    var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９＠（．！＃＄％＆‘＊＋–／＝？＾＿｀｛｜｝～）]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
    $(this).val(han);
  });
});

// 入力フォームの文字数制限
function sliceMaxLength(elem, maxLength) {
  elem.value = elem.value.slice(0, maxLength);
}
