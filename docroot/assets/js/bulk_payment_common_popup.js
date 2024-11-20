$(function(){
  // ekeyを取得
  var ekey = "{{ekey}}";
  var top_notion_popup_over = `
  <div class="bulk-notion-black-background bulk-notion-black-background-special"></div>
  <div class="white-content-box-bulk-notion-special">
    <div class="white-content-box-bulk-notion-special-inner">
      <div class="bulk-special-body">    
        <p>ZEUS WiFi特別プランは、<br class="sp">2024/4/30をもって新規受付を終了しました。</p>
        <p>新たにZEUS WiFi CHARGE オートチャージプランを提供開始しましたので、ぜひご検討ください。</p>
        <p>これより先は<br class="sp"><a class="bulk-popup-close-button pink-link">ZEUS WiFi CHARGE オートチャージプラン</a>のWEBサイトにリンクします。<br>
        20秒後に自動転送します。<br>
        自動で転送されない場合は、下記のボタンを押してください。</p>
        <div class="entry-button-container">
          <div class="row login-decoration-row row-first">
            <div class="form-next-button bulk-popup-close-button">
              <span class="text-step-body">
              ZEUS WiFi CHARGE<br>
              オートチャージプランを見る</span>
            </div>
        </div>
        <h2>オートチャージプランとは？</h2>
        <img src="https://d1q08lkutgkcx2.cloudfront.net/image/prepaid-sub-mail-recommend.png" alt="支払い方法が選べる 毎月大容量のギガ使える">
        <p class="auto-charge-point">クレジットカード以外の<br class="sp">お支払い方法が選べます！</p>
        <div class="entry-button-container">
          <div class="row login-decoration-row row-first">
            <div class="form-next-button bulk-popup-close-button">
              <span class="text-step-body">
              ZEUS WiFi CHARGE<br>
              オートチャージプランを見る</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  `;
  $("body").append(top_notion_popup_over);

  //パラメータ引継ぎの処理
  var host = location.hostname;
  var url = location.href;

  //?でURLを分割して、ekeyをuser_key=xxxxxxに書き換える
  urlparam = url.split("?");
  ekey = urlparam[1];

  //ekeyにuser_key=が含まれていればリダイレクトする
  if(ekey.indexOf("user_key=")>-1){
   //ローカル、STG用
   if (host == '192.168.33.111' || host == 'stg.zeus-wifi.jp') {
     redirect_url = 'https://test.zeuswifi-charge.jp/sub/?' + ekey;
   //本番用
   } else {
     redirect_url = 'https://zeuswifi-charge.jp/sub/?' + ekey;
   }
  }

  //ボタン・リンク押したらリダイレクトさせる
  $(".bulk-popup-close-button").click(function(){
    location.href = redirect_url;
  });

  // 20秒でリダイレクト
  var time = 1000 * 20;
  setTimeout(function () {
    window.location = redirect_url;
  }, time);
});
