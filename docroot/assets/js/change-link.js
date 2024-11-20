// STGから本番にリンクしないように制御 start
$(function(){
  // ドメインの取得
  var host = location.hostname;
  
  // ドメインがSTG（stg.zeus-wifi.jp）、ローカルの場合に以下を実行する
  if (host == '192.168.33.111' || host == 'stg.zeus-wifi.jp') {
    $("a").each(function() {
      var replace = null;
      var url = '';
      // hrefの形かチェック
      if (url = $(this).attr('href')){
        // aタグのzeus-wifi.jpをstg.zeus-wifi.jpに、wimax-zeuswifi.jpをtest.wimax-zeuswifi.jpに、zeuswifi-global.jpをtest.zeuswifi-global.jpに、zeuswifi-charge.jpをtest.zeuswifi-charge.jpに一括置換する
        var replace = $(this).attr('href')
        .replace("https://zeus-wifi.jp", "https://stg.zeus-wifi.jp")
        .replace("https://wimax-zeuswifi.jp", "https://test.wimax-zeuswifi.jp")
        .replace("https://zeuswifi-global.jp", "https://test.zeuswifi-global.jp")
        .replace("https://zeuswifi-charge.jp", "https://test.zeuswifi-charge.jp")
        $(this).attr('href',replace);
      }
    });
  }
});
// STGから本番にリンクしないように制御 end