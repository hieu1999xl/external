$(function() {
  submitButton();
  $("input[name='name'], input[name='email'], input[name='phone'], input[name='imei'], select[name='contact_type'], select[name='contact_type_company'], select[name='small_contact_type'], textarea[name='contact_content'], input[name='company'], input[name='responsible_person']").on("blur", function() { //追加したい要素のname属性を追加
    var valname = $(this).attr('name'); //name属性を取得
    if (valname == 'name') { //対象のname属性がnameなら
      var fullname = $(this).val(); //対象のvalueを代入

      if (fullname == "") {
        $('.validation-contact-name').text('必須項目です。');
      }else {
        $('.validation-contact-name').text('');
      }
    }else if (valname == 'email') { //対象のname属性がemailなら
      var email = $(this).val();
      var mailrule = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/; //バリデーションの条件を追加
      
      if(email.match(mailrule)){
        $('.validation-contact-email').text('');
      }else if (email == "") {
        $('.validation-contact-email').text('必須項目です。');
      }else {
        $('.validation-contact-email').text('正しいメールアドレスの形式を入力してください。');
      }
    }else if (valname == 'phone') { //対象のname属性がphoneなら
      var phone = $(this).val();
      var phonerule = /^[0-9]+$/;
      
      if (phone == "") {
        $('.validation-contact-phone').text('必須項目です。');
      }else if(!phone.match(phonerule)) {
        $('.validation-contact-phone').text('半角数字を入力してください。');
      }else {
        $('.validation-contact-phone').text('');
      }
    }else if (valname == 'contact_type') { //対象のname属性がcontact_typeなら
      var contact_type = $(this).val();

      if (contact_type == null) {
        $('.validation-contact-contact_type').text('必須項目です。');
      }else {
        $('.validation-contact-contact_type').text('');
      }
    }else if (valname == 'contact_type_company') { //対象のname属性がcontact_type_companyなら
      var contact_type_company = $(this).val();

      if (contact_type_company == null) {
        $('.validation-contact-contact_type_company').text('必須項目です。');
      }else {
        $('.validation-contact-contact_type_company').text('');
      }
    }else if (valname == 'small_contact_type') { //対象のname属性がsmall_contact_typeなら
      var small_contact_type = $(this).val();

      if (small_contact_type == null) {
        $('.validation-contact-small-contact-type').text('必須項目です。');
      }else {
        $('.validation-contact-small-contact-type').text('');
      }
    }else if (valname == 'contact_content') { //対象のname属性がcontact_contentなら
      var contact_content = $(this).val();

      if (contact_content == "") {
        $('.validation-contact-contact_content').text('必須項目です。');
      }else {
        $('.validation-contact-contact_content').text('');
      }
    }else if (valname == 'company') { //対象のname属性がcompanyなら
      var company = $(this).val();

      if (company == "") {
        $('.validation-contact-company').text('必須項目です。');
      }else {
        $('.validation-contact-company').text('');
      }
    }else if (valname == 'responsible_person') { //対象のname属性がresponsible_personなら
      var responsible_person = $(this).val();

      if (responsible_person == "") {
        $('.validation-contact-responsible_person').text('必須項目です。');
      }else {
        $('.validation-contact-responsible_person').text('');
      }
    }else if (valname == 'imei') { //対象のname属性がimeiなら
      var imei = $(this).val();
      var numberRule = /^[0-9]+$/;

      if (!imei.match(numberRule) && imei.length !== 0) {
        $('.validation-contact-imei').text('半角数字を入力してください。');
      }else if (imei.length < 15 && imei.length !== 0) {
        $('.validation-contact-imei').text('15桁未満です。');
      }else {
        $('.validation-contact-imei').text('');
      }
    }
    //以下必要な要素を追加していく

    submitButton();
  });

  $("input[name='business_type']").on('change', function() {
    var business_val = $(this).val();
    clearForm(business_val);
    submitButton();
  });
});

function clearForm(business_val) {
  if(business_val == 'personal') {
    $(".invalid-feedback, .validation-contact-text").text("");
    $(".global-contact .contact-input-border").val("");
    $("select[name='contact_type']").val("選択してください");
    $(".contact-caution-area").hide();
  }else if (business_val == 'company') {
    $(".invalid-feedback, .validation-contact-text").text("");
    $(".global-contact .contact-input-border").val("");
    $("select[name='contact_type_company']").val("選択してください");
    $(".contact-caution-area").hide();
  }
}

function submitButton() {
  // 送信ボタンを活性化
  var error = [];
  var count = 0;
  $(".validation-contact-text").each(function() {
    error.push($(this).text());
  });
  for (let i = 0; i < error.length; i++) {
    if(error[i] !== "") {
      count++;
    }
  }

  var flag_name = false;
  var flag_contact_type = false;
  
  var flag_company = false;
  var flag_responsible_person = false;
  var flag_contact_type_company = false;
  
  var flag_email = false;
  var flag_phone = false;
  var flag_contact_content = false;

  var name_val = $("input[name='name']").val();
  if(name_val == "") {
    flag_name = false;
  }else {
    flag_name = true;
  }

  var contact_type_val = $("select[name='contact_type']").val();
  if(contact_type_val == null) {
    flag_contact_type = false;
  }else {
    flag_contact_type = true;
  }

  var contact_type_company_val = $("select[name='contact_type_company']").val();
  if(contact_type_company_val == null) {
    flag_contact_type_company = false;
  }else {
    flag_contact_type_company = true;
  }

  var company_val = $("input[name='company']").val();
  if(company_val == "") {
    flag_company = false;
  }else {
    flag_company = true;
  }
  var responsible_person_val = $("input[name='responsible_person']").val();
  if(responsible_person_val == "") {
    flag_responsible_person = false;
  }else {
    flag_responsible_person = true;
  }

  var email_val = $("input[name='email']").val();
  if(email_val == "") {
    flag_email = false;
  }else {
    flag_email = true;
  }
  var phone_val = $("input[name='phone']").val();
  if(phone_val == "") {
    flag_phone = false;
  }else {
    flag_phone = true;
  }
  var contact_content_val = $("textarea[name='contact_content']").val();
  if(contact_content_val == "") {
    flag_contact_content = false;
  }else {
    flag_contact_content = true;
  }

  var biz_type = $("input[name='business_type']:checked").val();

  // WiMAXとプリペイドのお問い合わせにはカテゴリ詳細がないので分岐
  if(window.location.pathname.includes('/wimax_support_contact') || window.location.pathname.includes('/prepaid_support_contact')){
    var flag_small_contact_type = true;
  }else {
    var flag_small_contact_type = false;

    var small_contact_type_val = $("select[name='small_contact_type']:visible").val();
    if(small_contact_type_val == null) {
      flag_small_contact_type = false;
    }else {
      flag_small_contact_type = true;
    }
  }

  if(biz_type == 'personal') {
    if(count == 0 && flag_name && flag_email && flag_phone && flag_contact_type && flag_small_contact_type && flag_contact_content) {
      $("#contact-submit-button").removeClass("disabled");
    }else {
      $("#contact-submit-button").addClass("disabled");
    }
  }else if(biz_type == 'company') {
    if(window.location.pathname.includes('/global_support_contact')){
      if(count == 0 && flag_company && flag_responsible_person && flag_contact_type && flag_small_contact_type && flag_email && flag_phone && flag_contact_content) {
        $("#contact-submit-button").removeClass("disabled");
      }else {
        $("#contact-submit-button").addClass("disabled");
      }
    }else {
      if(count == 0 && flag_company && flag_responsible_person && flag_contact_type_company && flag_small_contact_type && flag_email && flag_phone && flag_contact_content) {
        $("#contact-submit-button").removeClass("disabled");
      }else {
        $("#contact-submit-button").addClass("disabled");
      }
    }
  }
}
