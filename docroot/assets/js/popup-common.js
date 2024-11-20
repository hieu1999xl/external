//【削除・コメントアウト禁止】初期設定 start /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var news_url_array = new Array(); // 格納する親配列（URL）を用意
var news_url_1 = ''; // 格納する最初の子配列（URL）を用意
var news_title_1; // 最初の知らせ（タイトル）を用意する
var news_contents_1; // 最初の知らせ（内容）を用意する

// 〇 問い合わせ先を分岐
if(window.location.pathname == "/entry/overseas/select" || window.location.hostname == "zeuswifi-global.jp" || window.location.hostname == "test.zeuswifi-global.jp") { //海外レンタルの場合
  var centerName = 'ZEUS WiFi for GLOBAL';
  var centerLink = 'https://zeus-wifi.jp/global_support_contact';
}else if(window.location.pathname == "/entry/wimax/select" || window.location.hostname == "wimax-zeuswifi.jp" || window.location.hostname == "test.wimax-zeuswifi.jp") { //ZEUS WiMAXの場合
  var centerName = 'ZEUS WiMAX';
  var centerLink = 'https://zeus-wifi.jp/wimax_support_contact';
}else if(window.location.pathname == "/entry/prepaid/select" || window.location.pathname == "/entry/prepaid/sub/select" || window.location.hostname == "zeuswifi-charge.jp" || window.location.hostname == "test.zeuswifi-charge.jp" || window.location.pathname == "/prepaid_support_contact") { //ZEUS WiFi CHARGEの場合（オートチャージ含む）
  var centerName = 'ZEUS WiFi CHARGE';
  var centerLink = 'https://zeus-wifi.jp/prepaid_support_contact';
}else{
  var centerName = 'ZEUS WiFi';
  var centerLink = 'https://zeus-wifi.jp/support/callcenter';
}

// 〇 [重要]アイコンの切り替え
if(window.location.hostname == "wimax-zeuswifi.jp" || window.location.hostname == "test.wimax-zeuswifi.jp") { //ZEUS WiMAXの場合
  var centerimgLink = 'https://d1q08lkutgkcx2.cloudfront.net/image/important-mark-wimax.svg';
}else if(window.location.hostname == "zeuswifi-global.jp" || window.location.hostname == "test.zeuswifi-global.jp"){ //海外レンタルの場合
  var centerimgLink = 'https://d1q08lkutgkcx2.cloudfront.net/image/important-mark-global.svg';
}else if(window.location.hostname == "zeuswifi-charge.jp" || window.location.hostname == "test.zeuswifi-charge.jp"){ //ZEUS WiFi CHARGEの場合
  var centerimgLink = 'https://d1q08lkutgkcx2.cloudfront.net/image/important-mark.svg';
}else{
  var centerimgLink = 'https://d1q08lkutgkcx2.cloudfront.net/image/important-mark.svg';
}
//【削除・コメントアウト禁止】初期設定 end /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//【不要な時はコメントアウト】お知らせ（１）start ////////////////////////////////////////////////////////////////（サンプルとして使うので不要なときはコメントアウトしてください）
// // タイトルを入れてください
// var news_title_1 = `
// 通信障害のお知らせ
// `;

// // 内容を入れてください
// var news_contents_1 = `
// <div id="news-contents-detail">
//   <p>平素は、${centerName}をご利用いただき誠にありがとうございます。</p>
//   <br />
//   <p>以下の通り、一部のお客様において通信できない状況となっており、現在調査を行っております。</p>
//   <p>発生日時：2024年10月22日（火）　AM3:00頃</p>
//   <p>原因：調査中</p>
//   <p>復旧見込み：確認中</p>
//   <br />
//   <p>お客様には、大変ご迷惑をお掛けしておりますことをお詫び申し上げます。</p>
//   <p>復旧の見込みについては、改めて当HPにてお知らせ致します。</p>
//   <br />
//   <p>${centerName}カスタマーセンター</p>
//   <p><a href="${centerLink}" target="_blank" class="pink-link">お問い合わせフォーム</a></p>
//   <p>（受付時間：平日 10:00～18:00　※土日祝、年末年始、メンテナンス日は除く）</p>
// </div>
// `;

// // 掲載するURLを入れてください（海外レンタルやWiMAXの場合の例 → url_6: "zeuswifi-global.jp/", url_7: "zeuswifi-global.jp/faq/"）
// var news_url = {domain_1: "test.zeuswifi-charge.jp", domain_2: "zeuswifi-charge.jp", url_1: "/", url_2: "/sub/"};
// news_url_array[0] = news_url;
//【不要な時はコメントアウト】お知らせ（１）end /////////////////////////////////////////////////////////////////（サンプルとして使うので不要なときはコメントアウトしてください）

//【不要な時はコメントアウト】お知らせ（２）start ////////////////////////////////////////////////////////////（お知らせ（２）までサンプルとして使うので不要なときはコメントアウトしてください）
// // タイトルを入れてください
// var news_title_2 = `
// 通信障害のお知らせ
// `;

// // 内容を入れてください
// var news_contents_2 = `
// <div id="news-contents-detail">
//   <p>平素は、${centerName}をご利用いただき誠にありがとうございます。</p>
//   <br />
//   <p>以下の通り、一部のお客様において通信できない状況となっており、現在調査を行っております。</p>
//   <p>発生日時：2024年10月22日（火）　AM3:00頃</p>
//   <p>原因：調査中</p>
//   <p>復旧見込み：確認中</p>
//   <br />
//   <p>お客様には、大変ご迷惑をお掛けしておりますことをお詫び申し上げます。</p>
//   <p>復旧の見込みについては、改めて当HPにてお知らせ致します。</p>
//   <br />
//   <p>${centerName}カスタマーセンター</p>
//   <p><a href="${centerLink}" target="_blank" class="pink-link">お問い合わせフォーム</a></p>
//   <p>（受付時間：平日 10:00～18:00　※土日祝、年末年始、メンテナンス日は除く）</p>
// </div>
// `;

// // 掲載するURLを入れてください 海外レンタルやWiMAXの場合の例 → url_6: "zeuswifi-global.jp/", url_7: "zeuswifi-global.jp/faq/"
// var news_url_2 = {domain_1: "stg.zeus-wifi.jp", domain_2: "zeus-wifi.jp", domain_3: "192.168.33.111", url_1: "/support_contact", url_2: "/support_contact/", url_3: "/prepaid_support_contact", url_4: "/prepaid_support_contact/"};
// news_url_array[1] = news_url_2;
//【不要な時はコメントアウト】お知らせ（２）end //////////////////////////////////////////////////////////////（お知らせ（２）までサンプルとして使うので不要なときはコメントアウトしてください）

//【不要な時はコメントアウト】上記の内容を反映する start ///////////////////////////////（変更するのを忘れないように！！！）
// if(news_title_1 !== 'undefined'){
//   var news_title_array = [news_title_1, news_title_2]; // タイトルを配列に追加 バナーを二か所以上掲載する場合の例 → [news_title_1,news_title_2,news_title_3,news_title_4];
//   var news_contents_array = [news_contents_1, news_contents_2]; // 内容を配列に追加 バナーを二か所以上掲載する場合の例 → [news_contents_1,news_contents_2,news_contents_3,news_contents_4];
// }
//【不要な時はコメントアウト】上記の内容を反映する end /////////////////////////////////（変更するのを忘れないように！！！）



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//【削除・コメントアウト禁止】ここは変更不要 start ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function() {
  // 作成した連想配列をループで回す

  $.each(news_url_array, function(url_index, news_url_value) {

    var news_url_value_value = Object.values(news_url_value);
    var news_hostname = $.inArray(window.location.hostname, news_url_value_value);

    if(news_hostname !== -1){

      // ポップアップテンプレート
      $.each(news_contents_array, function(index, news_contents_value) {
        if(url_index == index){

          var top_notion_popup_normal = `
            <div class="news-notion-black-background news-notion-black-background`+index+`"></div>
            <div class="pop-up-news white-content-box-news-notion white-content-box-news-notion`+index+`">
              <div class="news-popup-close-button" tabindex="0">
                <img src="https://d1q08lkutgkcx2.cloudfront.net/image/popup-close.svg" alt="閉じるボタン" width="18" height="18">
              </div>
              <div class="white-content-box-title white-content-box-title-notion white-content-box-title-news-notion">
                <p class="news-title-area`+index+`"></p>
              </div>
              <div class="white-content-box-inner-news">
                <div class="white-content-box-body">
                ` + news_contents_value + `
                </div>
              </div>
            </div>
          `;

          var news_url_index = $.inArray(window.location.pathname, news_url_value_value);

          if(news_url_index !== -1){
            $("body").append(top_notion_popup_normal);
          }

          return false;
        }
      })
      // バナーテンプレート
      $.each(news_title_array, function(index, news_title_value) {
        if(url_index == index){

          var _html_normal = `
            <div class="under-kv-notion">
              <div class="under-kv-notion-inner">
                <p class="under-kv-notion-title">
                  <a href="javascript:showNewsPopup(`+index+`)">
                    <img class="important-mark" alt="重要なお知らせ" width="300" height="139" src="${centerimgLink}">
                    ` + news_title_value + `
                  </a>
                </p>
              </div>
            </div>
          `;

          var news_url_index = $.inArray(window.location.pathname, news_url_value_value);

          if(news_url_index !== -1){
            $(".popup-html").after(_html_normal); // ポップアップバナー設置箇所の前の要素に.popup-htmlを付与必要
          }

          $(".news-title-area" + index).html(news_title_value);
        }
      })
    }
  })

  hideNewsPopup();

  $(".news-popup-close-button").keydown(function(event) {
    if( event.keyCode == 13 ) {
      $(".news-popup-close-button").click();
    }
  });

  $(".news-notion-black-background,.news-popup-close-button").click(function(){
    hideNewsPopup();
    $(".under-kv-notion-title a").focus();
  });

  // ブランド固有のスタイルの表示設定
  if(window.location.pathname == "/entry/overseas/select" || window.location.hostname == "zeuswifi-global.jp" || window.location.hostname == "test.zeuswifi-global.jp") { //海外レンタルの場合
    $('.global-only').css('display', 'block');
  }else if(window.location.pathname == "/entry/wimax/select" || window.location.hostname == "wimax-zeuswifi.jp" || window.location.hostname == "test.wimax-zeuswifi.jp") { //ZEUS WiMAXの場合
    $('.wimax-only').css('display', 'block');
  } else if(window.location.pathname == "/entry/prepaid/sub/select" || window.location.pathname == "/sub/") { //ZEUS WiFi CHARGE（オートチャージ）の場合
    $('.charge-sub-only').css('display', 'block');
  }else if(window.location.pathname == "/entry/prepaid/select" || window.location.hostname == "zeuswifi-charge.jp" || window.location.hostname == "test.zeuswifi-charge.jp") { //ZEUS WiFi CHARGEの場合
    $('.charge-only').css('display', 'block');
  }else{
    $('.subsc-only').css('display', 'block');
  }
});

function showNewsPopup(index){
  $(".news-notion-black-background" + index).show();
  $(".white-content-box-news-notion" + index).show();
  $(".news-popup-close-button").focus();
}

function hideNewsPopup(){
  $(".news-notion-black-background").hide();
  $(".white-content-box-news-notion").hide();  
}


//【削除・コメントアウト禁止】ここは変更不要 end //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////