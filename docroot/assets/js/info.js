// 取り下げ済の記事をリダイレクトさせる
$(document).ready(function() {
  //国葬による配送遅延　→　TOP
  if(window.location.hostname.includes("stg.zeus-wifi.jp/news/detail/42")){
    window.location.href = "/";
  }else if(window.location.hostname.includes("zeus-wifi.jp/news/detail/45")){
    window.location.href = "/";
  }
});