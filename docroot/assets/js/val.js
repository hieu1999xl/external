(function() {
  try {
    $.validator.messages;
  } catch (error) {
    return;
  }
  //標準エラーメッセージの変更
  $.extend($.validator.messages, {
    email: "正しいメールアドレスの形式で入力して下さい",
    email_conf: "正しいメールアドレスの形式で入力して下さい",
    emailCustom: "正しいメールアドレスの形式で入力して下さい",
    required: "入力必須項目です",
    digits: "数値を入力して下さい",
    minlength: "{0}桁以上で入力して下さい",
    maxlength: "{0}桁以下で入力して下さい",
    zenkaku: "全角で入力して下さい",
    katakana: "全角カナで入力してください。",
    password_chars:
      "使用できない文字が入っています。半角英数字と記号（ !\"#$%&'()*+,-./:;<=>?@[]^_`{|}~ ）が使えます",
    cardHolderName: "半角英数字で入力して下さい",
    cardNo: "数値を入力して下さい",
    cardNoLength: "14桁以上、16桁以内で入力して下さい",
  });

  //追加ルールの定義
  var methods = {
    katakana: function(value, element){
      stvaluer = (value==null)?"":value;
      if(value.match(/^[ァ-ヶー　]+$/)){
        return true;
      }else{
        return false;
      }
    },
    zenkaku: function(value, element) {
      return this.optional(element) || /^[^ -~｡-ﾟ]*$/.test(value);
    },
    password_chars: function(value, element) {
      // ^[0-9a-zA-Z!"#\$%&'\(\)\*\+,-\.\/:;<=>\?@\[\\\]\^_`{\|}~]*$
      return (
        this.optional(element) ||
        /^[0-9a-zA-Z!"#\$%&'\(\)\*\+,-\.\/:;<=>\?@\[\\\]\^_`{\|}~]*$/.test(
          value
        )
      );
    },
    cardHolderName: function(value, element) {
      return this.optional(element) || /^([a-zA-Z0-9 ]+)$/.test(value);
    },
    cardNo: function(value, element) {
      return this.optional(element) || /^([0-9 ]+)$/.test(value);
    },
    cardNoLength: function(value, element) {
      return this.optional(element) || function(){
        var non_space_val = value.replace(/\s+/g, "");
        var flag_lenght = non_space_val.length >=14 && non_space_val.length <=16;
        return flag_lenght;
      }();
    },
    emailCustom: function(value, element){
      if (value != null && (value.includes(".@") || value.includes(".."))) {
        return false;
      }
      return this.optional(element) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/.test(value);
    }
  };

  //メソッドの追加
  $.each(methods, function(key) {
    $.validator.addMethod(key, this);
  });

  function ruleUserRadio(){
    var userInfo = $(
      '#entry-user-form input[name="user_info"]:checked'
    ).val();
    var userInfoEdit = $('#form-entry-edit-user input[name="user_info"]:checked').val();
    var mypageUserInfoEdit = $('#user-edit-form input[name="user_info"]:checked').val();
    return userInfo === "2" || userInfoEdit == "2" || mypageUserInfoEdit == '2';
  }

  function ruleDliveryRadio(){
    var deliveryInfo = $(
      '#entry-user-form input[name="delivery_info"]:checked'
    ).val();

    var deliveryInfoEdit = $('#form-entry-edit-delivery input[name="delivery_info"]:checked').val()
    return deliveryInfo === "2" || deliveryInfoEdit === "2";
  }

  function ruleCorpDliveryRadio(){
    var deliveryInfo = $(
      '#entry-corp-user-form input[name="deliverycorp_info"]:checked'
    ).val();

    var deliveryInfoEdit = $('#form-entry-edit-delivery input[name="deliverycorp_info"]:checked').val()
    return deliveryInfo === "2" || deliveryInfoEdit === "2";
  }

  function ruleCorpContactRadio(){
    var corpContact = $(
      '#entry-corp-user-form input[name="corp_contact_info"]:checked'
    ).val();
    var corpContactEdit = $('#form-entry-edit-corp-contact input[name="corp_contact_info"]:checked').val()
    return corpContact === "2" || corpContactEdit === "2";
  }

  //法人請求書登録 請求書送付先が同じかの確認
  function ruleCorpCheckbox(){
    var corpCheckbox = $(
      '#entry-corp-form input[name="corporate_checkbox"]:checked'
    ).val();
    if("#not-inputted-items-corp-email-address"){
      return true;
    }else{
      return corpCheckbox === "2" || corpCheckbox === "4";
    }
  }
  function ruleCorpContactSelect(){
    var corpIncoiceMethod = $('#corp_payment_method_select').val();
    if(corpIncoiceMethod === "1"){
      return "#credit_contact_invoice_mail";
    }else{
      return "[name=contact_email_address]";
    }
  }
  // 建物名ある場合、部屋番号は必須
  ruleRoomNumber = (name) => {
    return {
      depends: () => {
        return $(`[name="${name}"]`).val().length >= 1 ? true : false;
      }
    }
  }

  //入力項目の検証ルール定義
  var rules = {
    // Plan
    plan_id: {required: true},
    // device_option: {required: true}, // 202301 バリデーション不要の為
    wimax_device_id: {required: true},
    installment_payment: {required: true},
    kk: {required: true},
    // contractor
    last_name: { required: true, zenkaku: true },
    first_name: { required: true, zenkaku: true },
    representative_last_name: { required: true, zenkaku: true },
    representative_first_name: { required: true, zenkaku: true },
    last_name_kana: { required: true, zenkaku: true, katakana: true},
    first_name_kana: { required: true, zenkaku: true, katakana: true },
    representative_last_name_kana: { required: true, zenkaku: true, katakana: true},
    representative_first_name_kana: { required: true, zenkaku: true, katakana: true },
    hp_url: { required: true },
    sex: { required: true },
    birthday_year: { required: true },
    birthday_month: { required: true },
    birthday_day: { required: true },
    email: { required: true, email: true ,emailCustom: true},
    email_conf: { required: true, email: true ,emailCustom: true,equalTo: "[name=email]"},
    email_confirm: { required: true, email: true, emailCustom: true, equalTo: "[name=email]"},
    password: {
      required: true,
      password_chars: true,
      minlength: 8,
      maxlength: 16
    },
    password_confirm: { required: true, equalTo: "[name=password]" },
    "tel1_1": { required: true, digits: true, maxlength: 5, minlength: 2 },
    "tel1_2": { required: true, digits: true, maxlength: 5, minlength: 4 },
    "tel1_3": { required: true, digits: true, maxlength: 5, minlength: 4 },
    "tel_2[0]": { digits: true, maxlength: 5 },
    "tel_2[1]": { digits: true, maxlength: 5 },
    "tel_2[2]": { digits: true, maxlength: 5 },
    "representative_tel1_1": { required: true, digits: true, maxlength: 5, minlength: 2 },
    "representative_tel1_2": { required: true, digits: true, maxlength: 5, minlength: 4 },
    "representative_tel1_3": { required: true, digits: true, maxlength: 5, minlength: 4 },
    "zipcode_1": { required: true, digits: true, minlength: 3 },
    "zipcode_2": { required: true, digits: true, minlength: 4 },
    prefecture: { required: true },
    city: { required: true },
    town: { required: true },
    block: { required: true },
    room_number: { required: ruleRoomNumber },
    // user
    user_last_name: { zenkaku: true },
    user_first_name: { zenkaku: true },
    user_last_name_kana: { zenkaku: true, katakana:true },
    user_first_name_kana: { zenkaku: true, katakana:true },
    "user_tel1_1": { required: true, digits: true, maxlength: 5, minlength: 2 },
    "user_tel1_2": { required: true, digits: true, maxlength: 5, minlength: 4 },
    "user_tel1_3": { required: true, digits: true, maxlength: 5, minlength: 4 },
    "user_tel_2[0]": { digits: true, maxlength: 5 },
    "user_tel_2[1]": { digits: true, maxlength: 5 },
    "user_tel_2[2]": { digits: true, maxlength: 5 },
    "user_zipcode_1": { required: true, digits: true, minlength: 3 },
    "user_zipcode_2": { required: true, digits: true, minlength: 4 },
    user_room_number: { required: ruleRoomNumber },
    // delivery
    delivery_info: { required: true },
    delivery_last_name: { zenkaku: true },
    delivery_first_name: { zenkaku: true },
    delivery_last_name_kana: { zenkaku: true, katakana: true},
    delivery_first_name_kana: { zenkaku: true, katakana: true },
    "delivery_tel1_1": { required: true, digits: true, maxlength: 5, minlength: 2 },
    "delivery_tel1_2": { required: true, digits: true, maxlength: 5, minlength: 4 },
    "delivery_tel1_3": { required: true, digits: true, maxlength: 5, minlength: 4 },
    "delivery_tel_2[0]": { digits: true, maxlength: 5 },
    "delivery_tel_2[1]": { digits: true, maxlength: 5 },
    "delivery_tel_2[2]": { digits: true, maxlength: 5 },
    "delivery_zipcode_1": { digits: true, minlength: 3 },
    "delivery_zipcode_2": { digits: true, minlength: 4 },
    delivery_room_number: { required: ruleRoomNumber },
    HolderName: { required: true, cardHolderName: true },
    CardNo: { required: true, cardNo: true, cardNoLength: true },
    // new name
    cardno: { required: true, cardNo: true, cardNoLength: true },
    holdername: { required: true, cardHolderName: true },
    expire_month: { required: true },
    expire_year: { required: true },
    securitycode: { required: true, minlength: 3, maxlength: 4, digits: true },
    payment_method: { required: true },
    // user info
    user_info : {required: true},
    user_last_name: {required: ruleUserRadio, zenkaku: true},
    user_first_name: {required: ruleUserRadio, zenkaku: true},
    user_last_name_kana: {required: ruleUserRadio, zenkaku: true, katakana: true},
    user_first_name_kana: {required: ruleUserRadio, zenkaku: true, katakana: true},
    "user_tel_1[0]": { required: ruleUserRadio, digits: true, maxlength: 5 },
    "user_tel_1[1]": { required: ruleUserRadio, digits: true, maxlength: 5 },
    "user_tel_1[2]": { required: ruleUserRadio, digits: true, maxlength: 5 },
    "user_tel_2[0]": { digits: true, maxlength: 5 },
    "user_tel_2[1]": { digits: true, maxlength: 5 },
    "user_tel_2[2]": { digits: true, maxlength: 5 },
    "user_zipcode[0]": { required: ruleUserRadio, digits: true, minlength: 3 },
    "user_zipcode[1]": { required: ruleUserRadio, digits: true, minlength: 4 },
    user_prefecture: { required: ruleUserRadio,},
    user_city: { required: ruleUserRadio, },
    user_town: { required: ruleUserRadio,},
    user_block: { required: ruleUserRadio, },

    // Delivery info
    delivery_last_name: {required: ruleDliveryRadio, zenkaku: true},
    delivery_first_name: {required: ruleDliveryRadio, zenkaku: true},
    delivery_last_name_kana: {required: ruleDliveryRadio, zenkaku: true, katakana: true},
    delivery_first_name_kana: {required: ruleDliveryRadio, zenkaku: true, katakana: true},
    "delivery_tel_1[0]": { required: ruleDliveryRadio, digits: true, maxlength: 5 },
    "delivery_tel_1[1]": { required: ruleDliveryRadio, digits: true, maxlength: 5 },
    "delivery_tel_1[2]": { required: ruleDliveryRadio, digits: true, maxlength: 5 },
    "delivery_tel_2[0]": { digits: true, maxlength: 5 },
    "delivery_tel_2[1]": { digits: true, maxlength: 5 },
    "delivery_tel_2[2]": { digits: true, maxlength: 5 },
    "delivery_zipcode[0]": { required: ruleDliveryRadio, digits: true, minlength: 3 },
    "delivery_zipcode[1]": { required: ruleDliveryRadio, digits: true, minlength: 4 },
    delivery_prefecture: { required: ruleDliveryRadio,},
    delivery_city: { required: ruleDliveryRadio, },
    delivery_town: { required: ruleDliveryRadio,},
    delivery_block: { required: ruleDliveryRadio,},
    delivery_address_number: { required: ruleDliveryRadio, },
    delivery_zipcode_1 : { required: ruleDliveryRadio, },
    delivery_zipcode_2 : { required: ruleDliveryRadio, },
    delivery_order_time: { required: true },

    // 法人の情報
    corp_company_name: {required: true, zenkaku: true},
    corp_company_name_kana: {required: true, zenkaku: true, katakana: true},
    corp_last_name: {required: true, zenkaku: true},
    corp_first_name: {required: true, zenkaku: true},
    corp_last_name_kana: {required: true, zenkaku: true, katakana: true},
    corp_first_name_kana: {required: true, zenkaku: true, katakana: true},
    company_hp_url: {required: true},
    responsible_last_name: {required: true, zenkaku: true},
    responsible_first_name: {required: true, zenkaku: true},
    responsible_last_name_kana: {required: true, zenkaku: true, katakana: true},
    responsible_first_name_kana: {required: true, zenkaku: true, katakana: true},
    responsible_tel1_1 : { required: true, digits: true, maxlength: 5, minlength: 2 },
    responsible_tel1_2 : { required: true, digits: true, maxlength: 5, minlength: 4 },
    responsible_tel1_3 : { required: true, digits: true, maxlength: 5, minlength: 4 },
    corp_email: { required: true, email: true, emailCustom: true },
    corp_email_conf: { required: true, email: true, emailCustom: true, equalTo: "[name=corp_email]"},
    corp_password: {
      required: true,
      password_chars: true,
      minlength: 8,
      maxlength: 16
    },
    corp_password_confirm: { required: true, equalTo: "[name=corp_password]" },
    corp_tel1_1 : { required: true, digits: true, maxlength: 5, minlength: 2 },
    corp_tel1_2 : { required: true, digits: true, maxlength: 5, minlength: 4 },
    corp_tel1_3 : { required: true, digits: true, maxlength: 5, minlength: 4 },
    corp_tel2_1 : { required: true, digits: true, maxlength: 5, minlength: 2 },
    corp_tel2_2 : { required: true, digits: true, maxlength: 5, minlength: 4 },
    corp_tel2_3 : { required: true, digits: true, maxlength: 5, minlength: 4 },

    //法人の住所
    add_corp_zipcode1 : { required: true, digits: true, maxlength: 5 },
    add_corp_zipcode2 : { required: true, digits: true, maxlength: 5 },
    add_corp_prefecture: { required: true },
    add_corp_city: { required: true },
    add_corp_town: { required: true },
    add_corp_block : { required: true },

    //法人の配送
    deliverycorp_last_name: {required: ruleCorpDliveryRadio, zenkaku: true},
    deliverycorp_first_name: {required: ruleCorpDliveryRadio, zenkaku: true},
    deliverycorp_last_name_kana: {required: ruleCorpDliveryRadio, zenkaku: true, katakana: true},
    deliverycorp_first_name_kana: {required: ruleCorpDliveryRadio, zenkaku: true, katakana: true},
    deliverycorp_tel1_1: { required: ruleCorpDliveryRadio, digits: true, maxlength: 5, minlength: 2 },
    deliverycorp_tel1_2: { required: ruleCorpDliveryRadio, digits: true, maxlength: 5, minlength: 4 },
    deliverycorp_tel1_3: { required: ruleCorpDliveryRadio, digits: true, maxlength: 5, minlength: 4 },
    deliverycorp_tel2_1: { digits: true, maxlength: 5, minlength: 2 },
    deliverycorp_tel2_2: { digits: true, maxlength: 5, minlength: 4 },
    deliverycorp_tel2_3: { digits: true, maxlength: 5, minlength: 4 },
    deliverycorp_zipcode_1: { required: ruleCorpDliveryRadio, digits: true, maxlength: 5 },
    deliverycorp_zipcode_2: { required: ruleCorpDliveryRadio, digits: true, maxlength: 5 },
    deliverycorp_prefecture: { required: ruleCorpDliveryRadio,},
    deliverycorp_city: { required: ruleCorpDliveryRadio, },
    deliverycorp_town: { required: ruleCorpDliveryRadio,},
    deliverycorp_block : { required: ruleCorpDliveryRadio, },
    deliverycorp_order_time : { required: true },
    deliverycorp_info: { required: true },

    //　請求情報
    invoice_company_name: {required: ruleCorpContactRadio, zenkaku: true},
    invoice_company_name_kana: {required: ruleCorpContactRadio, zenkaku: true, katakana: true},
    invoice_department_name: {required: ruleCorpContactRadio, zenkaku: true},
    invoice_email: { required: ruleCorpContactRadio, email: true, emailCustom: true },
    invoice_email_conf : { required: true, email: true, emailCustom: true, equalTo: "[name=invoice_email]"},
    invoice_last_name: {required: ruleCorpContactRadio, zenkaku: true},
    invoice_first_name: {required: ruleCorpContactRadio, zenkaku: true},
    invoice_last_name_kana: {required: ruleCorpContactRadio, zenkaku: true, katakana: true},
    invoice_first_name_kana: {required: ruleCorpContactRadio, zenkaku: true, katakana: true},
    invoice_tel1_1: { required: ruleCorpContactRadio, digits: true, maxlength: 5, minlength: 2 },
    invoice_tel1_2: { required: ruleCorpContactRadio, digits: true, maxlength: 5, minlength: 4 },
    invoice_tel1_3: { required: ruleCorpContactRadio, digits: true, maxlength: 5, minlength: 4 },
    corp_contact_info: { required: true },

    //法人請求書登録 請求書送付先のチェック
    corporate_checkbox: { required: true },
    payment_due_date_type: {required: true },
    contact_company: { required: ruleCorpCheckbox, zenkaku: true },
    contact_last_name: { required: ruleCorpCheckbox, zenkaku: true },
    contact_first_name: { required: ruleCorpCheckbox, zenkaku: true },
    contact_email_address: { required: ruleCorpCheckbox, email: true ,emailCustom: true },
    contact_email_address_conf: { required: ruleCorpCheckbox, email: true, emailCustom: true, equalTo: ruleCorpContactSelect},

    //　初期契約解除理由回答
    "answer_id": { required: true, digits: true, maxlength: 5 },

    //　お客様情報の変更
    "zipcode1": { required: true, digits: true, minlength: 3 },
    "zipcode2": { required: true, digits: true, minlength: 4 },

    open_house_id:{ digits: true, minlength: 8, maxlength: 8 },
    entry_imei: { required: true, zenkaku: false },

    //　セゾンカード受付番号の入力
    saison_number:{ required: true, minlength: 8, maxlength: 12 },
  };

  // wimax 端末選択ページ 必須チェックを変更
  // if (currentPathIs('/entry/wimax/select') || currentPathIs('/entry/wimax/closed/select')) {
  //   rules.device_option.required = false;
  // }

  //入力項目ごとのエラーメッセージ定義　
  let messages;
  if (currentPathIs('/entry/options')) {
    messages = {
      "tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "user_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "user_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "user_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "delivery_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "delivery_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "delivery_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "invoice_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "invoice_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "invoice_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel2_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel2_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel2_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel2_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel2_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel2_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      password_confirm: {
        equalTo: "確認パスワードが一致しません"
      },
      email_confirm: {
        equalTo: "確認メールアドレスが一致しません"
      },
      corp_password_confirm: {
        equalTo: "確認パスワードが一致しません"
      },
      corp_email_conf: {
        equalTo: "確認メールアドレスが一致しません"
      },
      invoice_email:{
	    equalTo: "確認メールアドレスが一致しません"
      },
      invoice_email_conf: {
        equalTo: "確認メールアドレスが一致しません"
      },
      device_option: "端末あんしんオプションの加入有無を選択してください。",
      tie: "契約期間の縛り有無を選択してください。",
      plan_id: "契約期間の縛り有無を選択してください。"
    };
  } if (currentPathIs('/entry/wimax/select') || currentPathIs('/entry/wimax/closed/select')) {
    messages = {
      "tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "user_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "user_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "user_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "delivery_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "delivery_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "delivery_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "invoice_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "invoice_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "invoice_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel2_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel2_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel2_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel2_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel2_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel2_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      password_confirm: {
        equalTo: "確認パスワードが一致しません"
      },
      email_confirm: {
        equalTo: "確認メールアドレスが一致しません"
      },
      email_conf: {
        equalTo: "確認メールアドレスが一致しません"
      },
      corp_password_confirm: {
        equalTo: "確認パスワードが一致しません"
      },
      corp_email_conf: {
        equalTo: "確認メールアドレスが一致しません"
      },
      invoice_email:{
	    equalTo: "確認メールアドレスが一致しません"
      },
      invoice_email_conf: {
        equalTo: "確認メールアドレスが一致しません"
      },
      contact_email_address_conf: {
        equalTo: "確認メールアドレスが一致しません"
      },
      device_option: "端末あんしんオプションの加入有無を選択してください。",
      tie: "契約期間の縛り有無を選択してください。",
      plan_id: "プランを選択してください。",
      wimax_device_id: "端末を選択してください。",
      installment_payment: "端末代金の支払い方法を選択してください。"
    };
  } else {
    messages = {
      "tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "user_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "user_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "user_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "delivery_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "delivery_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "delivery_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "responsible_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "responsible_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "responsible_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "invoice_tel1_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "invoice_tel1_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "invoice_tel1_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel2_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel2_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "corp_tel2_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel2_1": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel2_2": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      "deliverycorp_tel2_3": {
        minlength: "[2~3桁]-[4桁]-[4桁]の形式で入力してください"
      },
      password_confirm: {
        equalTo: "確認パスワードが一致しません"
      },
      email_confirm: {
        equalTo: "確認メールアドレスが一致しません"
      },
      email_conf: {
        equalTo: "確認メールアドレスが一致しません"
      },
      corp_password_confirm: {
        equalTo: "確認パスワードが一致しません"
      },
      corp_email_conf: {
        equalTo: "確認メールアドレスが一致しません"
      },
      invoice_email:{
	    equalTo: "確認メールアドレスが一致しません"
      },
      invoice_email_conf: {
        equalTo: "確認メールアドレスが一致しません"
      },
      contact_email_address_conf: {
        equalTo: "確認メールアドレスが一致しません"
      },
      device_option: "端末あんしんオプションの加入有無を選択してください。",
      tie: "契約期間の縛り有無を選択してください。",
      plan_id: "プラン・容量を選択してください。"
    };
  }


  $(function() {
    var option = {
      rules: rules,
      messages: messages,
      onfocusout: function(element) {
        var elemName = $(element).attr("name");
        var elemType = $(element).attr("type");
        var currentVal = $(element).val();
        var convertedVal = currentVal;

        // Disable plan select error flag
        $(this).prop("hasPlanError", false);
        if(elemName === "device_option" || elemName === "plan_id" || elemName === "wimax_device_id" || elemName === "installment_payment"){
          return false;
        }
        ref = location.href
        if(currentVal !== undefined && currentVal !== null && !ref.match("/mypage/contract")){
          currentVal = currentVal.replace(/\r|\n|\r\n|\t/g, '');
          if(elemName === 'inquiry'){
            // text area
            convertedVal = hankaku2Zenkaku(hankana2Zenkana(currentVal));
          }else if(elemName.indexOf("kana") > -1){
            convertedVal = hiraToKana(currentVal);
          }else if(elemType !== "text" && elemType !== "email"){
            // No convert
          } else if(
            elemName.indexOf("email") > -1 ||
            elemName.indexOf("tel") > -1  ||
            elemName.indexOf("zipcode") > -1  ||
            elemName.indexOf("holdername") > -1  ||
            elemName.indexOf("cardno") > -1  ||
            elemName.indexOf("securitycode") > -1 ||
            elemName.indexOf("password") > -1 ||
            elemName.indexOf("open_house_id") > -1 ||
            elemName.indexOf("search_user_id") > -1 ||
            elemName.indexOf("entry_imei") > -1 ||
            elemName.indexOf("hp_url") > -1
          ){
            convertedVal = zenkaku2Hankaku(currentVal);
          }else{
            convertedVal = hankaku2Zenkaku(hankana2Zenkana(currentVal));
          }
          $(element).val(convertedVal);
        }

        if(!ref.match("/mypage/contract") && elemName.indexOf("cardno-box") > -1) {
          var cardnoVal1 = $("input[name='cardno-box-1']").val();
          var cardnoVal2 = $("input[name='cardno-box-2']").val();
          var cardnoVal3 = $("input[name='cardno-box-3']").val();
          var cardnoVal4 = $("input[name='cardno-box-4']").val();
          var cardnoVal = cardnoVal1 + cardnoVal2 + cardnoVal3 + cardnoVal4;
          $("input[name='cardno']").val(cardnoVal);
        }

        $(element).valid();
      },
      onkeyup: function(element) {
        // $(element).valid();
        var elemName = $(element).attr("name");
        if (elemName == "CardNo" || elemName == "cardno") {
          var no_val = $(element).val();
          if (no_val.match(/[^0-9 ]/g) !== null){
            $(element).val("");
            return;
          }
          if(no_val.length < 16 && no_val.slice(-1) !== ' ' && no_val.replace(/ /g, '').length % 4 != 0){
            var val_with_space = $(element)
            .val()
            .replace(/\W/gi, "")
            .replace(/(.{4})/g, "$1 ");
          $(element).val(val_with_space);
          }
        }
      },
      errorClass: "validator-error",
      errorPlacement: function(error, element) {
        inputName = element.attr("name");
        var reservedValidationArea = $(element).nextAll(".vaidation-error-area");

        if(reservedValidationArea.length > 0){
          var target = reservedValidationArea;
          target.html("");
          error.appendTo(target);
          return;
        } else {
          error.insertAfter(element);
        }
        if (inputName === "device_option") {
          error.appendTo($("#device-option-error-message"));
        }
        if (inputName === "plan_id") {
          error.appendTo($("#plan-id-error-message"));
          if (currentPathIs('/entry/options')) {
            $('#plan_id-error').text('契約期間の縛り有無を選択してください。');
          }
        }
        if (inputName === "wimax_device_id") {
          error.appendTo($("#plan-id-error-message"));
        }
        if (inputName === "installment_payment") {
          error.appendTo($("#plan-id-error-message"));
        }
        if (inputName === "tie") {
          error.appendTo($("#tie-error-message"));
        }
        if (inputName === 'sex'){
          error.appendTo($("#gender-radio-error"));
        }
        if (inputName === 'user_info'){
          error.appendTo($("#user-info-radio-error"));
        }
        if (inputName === 'delivery_info'){
          error.appendTo($("#delivery-info-radio-error"));
        }
        if (inputName === 'deliverycorp_info'){
          error.appendTo($("#delivery-info-radio-error"));
        }
        if (inputName === 'corp_contact_info'){
          error.appendTo($("#corp-contact-info-radio-error"));
        }
        if (inputName === 'corporate_checkbox'){
          error.appendTo($("#corporate-validator-area-card"));
        }

        if($("#corp_payment_method_select").val() === "3" && inputName === 'corporate_checkbox'){
          error.appendTo($("#corporate-validator-area-card"));
        }else{
          error.appendTo($("#corporate-validator-area-invoice"));
        }

        if (inputName === "open_house_id") {
          error.appendTo($("#vaidation-error-area-ohid"));
        }
        if (inputName === "entry_imei") {
          error.appendTo($("#vaidation-error-area-imei"));
        }
      },
      submitHandler: function(form){
        var preventSubmit = $(form).attr("preventSubumit");
        var forceSubmit = $(form).attr("forceSubumit");

        if(forceSubmit !== "true" && preventSubmit === "true") {
          return false;
        }
        $(".decoration-button-area").addClass("decoration-button-area-disabled");
        $(".decoration-button-area-long").addClass("decoration-button-area-disabled");
        $(".decoration-button-submit").addClass("decoration-button-area-submitted");

        if((window.location.pathname.includes("/entry/user"))&&$("#delivery_info_different2:checked").val()){
          submitUserToDeliveryInfo();
        }
        // oh_specialplans
        if((window.location.pathname.includes("/entry/oh_specialplans/user"))&&$("#delivery_info_different2:checked").val()){
          submitUserToDeliveryInfo();
        }

        $(form).find("input[type='submit']").attr("disabled", "disabled");

        // フォーム送信前にカード情報リセット
        if(window.location.pathname.indexOf("/user/payment/edit") !== -1){
          $("input[name=cardno]").val('');
          $("select[name=expire_year]").val('');
          $("select[name=expire_month]").val('');
          $("input[name=securitycode]").val('');
        }

        if ($(form).attr('id') === "entry-corp-form") {
            doPurchase();
        } else {
            form.submit();
        }

      },
      highlight: function(element, errorClass) {
        $(element).addClass("mypage-input-border-invalid");
        var elemName = $(element).attr("name");
        if(elemName === "plan_id" || elemName === "device_option" || elemName === "tie" || elemName === "wimax_device_id" || elemName === "installment_payment"){
          var speed = 500;
          var target;
          // var t = $("div#device-option-error-message").text();
          if(elemName === "plan_id"){
            target = $("#plan-id-error-message");
            $(this).prop("hasPlanError", true);
          }else if(elemName ===  'wimax_device_id'){
            target = $("#plan-id-error-message");
            $(this).prop("hasPlanError", true);
          }else if(elemName ===  'installment_payment'){
            target = $("#plan-id-error-message");
            $(this).prop("hasPlanError", true);
          }else if(elemName ===  'tie'){
            target = $("#tie-error-message");
            $(this).prop("hasPlanError", true);
          }else{
            target = $("#device-option-error-message");
            if($(this).prop("hasPlanError") === true){
              return false;
            }
          }
          var position = target.offset().top - 120;
          $("html, body").animate({ scrollTop: position }, speed, "swing");
        }
      },
      invalidHandler: function(event, validator) {
        validateUserForm(event.target.id, validator.invalid);

      },
      unhighlight: function(element) {
        $(element).removeClass("mypage-input-border-invalid");
      }
      // https://jqueryvalidation.org/validate/
    };
    var userFormOption = Object.create(option);
    userFormOption.focusInvalid = false;
    $("#entry-plan-form").validate(option);
    $("#entry-options-form").validate(option);
    $("#entry-user-form").validate(userFormOption);
    $("#entry-corp-user-form").validate(userFormOption);
    $("#entry-payment-form").validate(option);
    $("#entry-confirm-form").validate(option);
    $("#entry-corpa-form").validate(option);
    $("#twitter-entry-user-form").validate(option);
    $("#payment-edit-form").validate(option);
    $("#user-edit-form").validate(option);
    $("#password-edit-form").validate(option);
    $(".edit-partial form").validate(option);
    $("#contract-cancel-form").validate(option);
    $("#entry-corp-form").validate(option);

    $("#form-entry-edit-contractor").validate(option);
    $("#form-entry-edit-address").validate(option);
    $("#form-entry-edit-user").validate(option);
    $("#form-entry-edit-corp-contact").validate(option);
    $("#form-entry-edit-delivery").validate(option);
    $("#form-entry-edit-plan").validate(option);
    $("#form-entry-edit-plan-topping1").validate(option);
    $("#form-entry-edit-device-option").validate(option);

    // マイページお支払い方法の変更に適用
    $("#user-payment-edit-form").validate(option);

    // 海外レンタルマイページ 領収書発行の宛名入力フォームに適用
    $("#receipt-name").validate(option);
  });
})();



// Converter
function hankana2Zenkana(str) {
  var kanaMap = {
      'ｶﾞ': 'ガ', 'ｷﾞ': 'ギ', 'ｸﾞ': 'グ', 'ｹﾞ': 'ゲ', 'ｺﾞ': 'ゴ',
      'ｻﾞ': 'ザ', 'ｼﾞ': 'ジ', 'ｽﾞ': 'ズ', 'ｾﾞ': 'ゼ', 'ｿﾞ': 'ゾ',
      'ﾀﾞ': 'ダ', 'ﾁﾞ': 'ヂ', 'ﾂﾞ': 'ヅ', 'ﾃﾞ': 'デ', 'ﾄﾞ': 'ド',
      'ﾊﾞ': 'バ', 'ﾋﾞ': 'ビ', 'ﾌﾞ': 'ブ', 'ﾍﾞ': 'ベ', 'ﾎﾞ': 'ボ',
      'ﾊﾟ': 'パ', 'ﾋﾟ': 'ピ', 'ﾌﾟ': 'プ', 'ﾍﾟ': 'ペ', 'ﾎﾟ': 'ポ',
      'ｳﾞ': 'ヴ', 'ﾜﾞ': 'ヷ', 'ｦﾞ': 'ヺ',
      'ｱ': 'ア', 'ｲ': 'イ', 'ｳ': 'ウ', 'ｴ': 'エ', 'ｵ': 'オ',
      'ｶ': 'カ', 'ｷ': 'キ', 'ｸ': 'ク', 'ｹ': 'ケ', 'ｺ': 'コ',
      'ｻ': 'サ', 'ｼ': 'シ', 'ｽ': 'ス', 'ｾ': 'セ', 'ｿ': 'ソ',
      'ﾀ': 'タ', 'ﾁ': 'チ', 'ﾂ': 'ツ', 'ﾃ': 'テ', 'ﾄ': 'ト',
      'ﾅ': 'ナ', 'ﾆ': 'ニ', 'ﾇ': 'ヌ', 'ﾈ': 'ネ', 'ﾉ': 'ノ',
      'ﾊ': 'ハ', 'ﾋ': 'ヒ', 'ﾌ': 'フ', 'ﾍ': 'ヘ', 'ﾎ': 'ホ',
      'ﾏ': 'マ', 'ﾐ': 'ミ', 'ﾑ': 'ム', 'ﾒ': 'メ', 'ﾓ': 'モ',
      'ﾔ': 'ヤ', 'ﾕ': 'ユ', 'ﾖ': 'ヨ',
      'ﾗ': 'ラ', 'ﾘ': 'リ', 'ﾙ': 'ル', 'ﾚ': 'レ', 'ﾛ': 'ロ',
      'ﾜ': 'ワ', 'ｦ': 'ヲ', 'ﾝ': 'ン',
      'ｧ': 'ァ', 'ｨ': 'ィ', 'ｩ': 'ゥ', 'ｪ': 'ェ', 'ｫ': 'ォ',
      'ｯ': 'ッ', 'ｬ': 'ャ', 'ｭ': 'ュ', 'ｮ': 'ョ',
      '｡': '。', '､': '、', 'ｰ': 'ー', '｢': '「', '｣': '」', '･': '・', ' ': '　'
  };

  var reg = new RegExp('(' + Object.keys(kanaMap).join('|') + ')', 'g');
  return str
          .replace(reg, function (match) {
              return kanaMap[match];
          })
          .replace(/ﾞ/g, '゛')
          .replace(/ﾟ/g, '゜');
};

function hankaku2Zenkaku(str) {
  return str.replace(/[A-Za-z0-9]/g, function(s) {
      return String.fromCharCode(s.charCodeAt(0) + 0xFEE0);
  });
}

function zenkaku2Hankaku(str) {
  var regex = /[Ａ-Ｚａ-ｚ０-９！＂＃＄％＆＇（）＊＋，－．／：；＜＝＞？＠［＼］＾＿｀｛｜｝]/g;

  value = str
    .replace(regex, function(s) {
      return String.fromCharCode(s.charCodeAt(0) - 0xfee0);
    })
    .replace(/[‐－―]/g, "-") // ハイフンなど
    .replace(/[～〜]/g, "~") // チルダ
    .replace(/　/g, " ") // スペース
    .replace("＠", "@")
    .replace("。", ".")
    .replace("、", ".");
  return value;
}

function hiraToKana(str) {
  return str.replace(/[\u3041-\u3096]/g, function(match) {
      var chr = match.charCodeAt(0) + 0x60;
      return String.fromCharCode(chr);
  });
}
