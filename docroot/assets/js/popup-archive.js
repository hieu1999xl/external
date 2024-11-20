// アーカイブ内容 start
var campaign_archive_url_array = new Array();
var campaign_archive_url = '';

campaign_archive_url = {
  url_1: "/campaign_archive"
}; // 掲載するURL

// アーカイブ（１）
campaign_archive_date_1 = `2020年3月30日～2020年7月24日
`; // 日付

campaign_archive_title_1 = `
ゼウスWiFi デビューキャンペーン
`; // タイトル

campaign_archive_contents_1 = `
<div class="debut-description">
  <div class="campaign-archive-description">
    <div class="campaign-archive-description-img-box">
      <img src="https://d1q08lkutgkcx2.cloudfront.net/image/debut_campaign_t.png" alt="ゼウスWiFi デビューキャンペーン" width="921" height="297">
    </div>
  </div>
  <div class="debut-description-period">
    <div class="debut-description-period-title">
      <div class="black-box">
        <p>キャンペーン期間</p>
      </div>
    </div>
    <div class="debut-description-period-desciption">
      <p>` + campaign_archive_date_1 + `</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン内容</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>課金開始月を1ヶ月目として、6ヶ月目までの月額基本料を2,980円（3,278円税込）、7ヶ月目以降の月額基本料を3,280円（3,608円税込）といたします。<span class="remark-text">※</span></p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン対象条件</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>キャンペーン期間中、ZEUS WiFi (ベーシックプラン)をご契約いただいたお客様を対象に、ZEUS WiFi (ベーシックプラン) 月額基本料3,480円（3,828円税込）を、課金開始月を1ヶ月目として、6ヶ月目までの月額基本料を2,980円（3,278円税込）、7ヶ月目以降の月額基本料を3,280円（3,608円税込）といたします。<span class="remark-text campaign-archive">※</span></p>
      <br>
      <p class="remark-text campaign-archive">＜注意事項＞</p>
      <br>
      <p class="remark-text campaign-archive">※本サービスの初月基本料は、ZEUS WiFi (ベーシックプラン) 月額基本料3,480円（3,828円税込）の日割計算となりますが、本キャンペーン適用のお客様は、キャンペーン価格の月額基本料2,980円（3,278円税込）の日割計算となります。</p>
    </div>
  </div>
</div>
`; // 内容

// アーカイブ（２）
campaign_archive_date_2 = `2020年3月30日～2020年7月24日
`; // 日付

campaign_archive_title_2 = `
ドバドバ体験キャンペーン
`; // タイトル

campaign_archive_contents_2 = `
<div class="debut-description">
  <div class="campaign-archive-description">
    <div class="campaign-archive-description-img-box"><img alt="ドバドバ体験キャンペーン" src="https://d1q08lkutgkcx2.cloudfront.net/image/taiken_campaign_t.png" width="921" height="297"></div>
  </div>
  <div class="debut-description-period">
    <div class="debut-description-period-title">
      <div class="black-box">
        <p>キャンペーン期間</p>
      </div>
    </div>
    <div class="debut-description-period-desciption">
      <p>` + campaign_archive_date_2 + `</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン内容</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>課金開始日から30日以内に解約をご希望のお客様に対し、解約事務手数料（9,500円（10,450円税込））を無料といたします。<span class="remark-text campaign-archive">※</span></p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン対象条件</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>個人名義のお客様に限るものといたします。</p>
      <p>課金開始日から起算して30日以内に解約の申請（WEBからの解約手続き、コールセンターへの解約連絡など方法は問いません）を行ったお客様。</p><br>
      <p class="remark-text campaign-archive">＜注意事項＞</p><br>
      <p class="remark-text campaign-archive">※本キャンペーンでは、解約事務手数料（9,500円（10,450円税込））を無料といたしますが、以下の料金等は別途ご請求させていただきます。</p>
      <p style="padding-left: 15px;"><span class="remark-text campaign-archive">①契約事務手数料3,000円（3,300円税込）。</span></p>
      <p style="padding-left: 15px;"><span class="remark-text campaign-archive">②月額基本料</span></p>
      <p style="padding-left: 30px;"><span class="remark-text campaign-archive">a) 課金開始日から起算して30日以内の解約申請が課金開始月内の場合、日割り計算(注)で求められた金額。また、オプションを申込したお客様は、オプションサービス利用料も日割り計算で求められた金額。</span></p>
      <p style="padding-left: 30px;"><span class="remark-text campaign-archive">b) 課金開始日から起算して30日以内の解約申請が課金開始月の翌月にかかる場合、課金開始月の日割り計算(注)で求められた金額および課金開始月の翌月1ヶ月分の月額基本料。また、オプションを申込したお客様は、オプションサービス利用料も同様に課金開始月の日割り計算で求められた金額および課金開始月の翌月1ヶ月分の利用料。</span></p>
      <p style="padding-left: 30px;"><span class="remark-text campaign-archive">(注)日割り計算とは、課金開始日を起算日とし、起算日を含む月末までの残り日数分の日割り額。</span></p><br>
      <p><span class="remark-text campaign-archive">※※解約後は端末返却が必要となります。返却期限は解約月の翌月14日以内に必着とし、送料をお客様負担にて当社指定住所へ端末本体/個装箱/付属のUSBケーブル/取扱説明書4点をご返却が必要となります。なお、返却期日を過ぎている場合、返却物に欠品がある場合、返却時に故障が見られる場合は、端末損害金として18,000円（19,800円税込）をご請求させていただきます。</span></p>
      <p><span class="remark-text campaign-archive">※※課金開始日または利用開始日から起算して8日以内に「初期契約解除」の手続きを行った場合には、初期契約解除を適用とし、初期契約解除期間内でも初期契約解除の手続きを行っていない場合には、本キャンペーンが適用されます。</span></p>
    </div>
  </div>
`; // 内容

// アーカイブ（3）
campaign_archive_date_3 = `2021年4月7日～2021年5月31日
`; // 日付

campaign_archive_title_3 = `
法人乗り換えキャンペーン
`; // タイトル

campaign_archive_contents_3 = `
<div class="debut-description">
  <div class="campaign-archive-description-img-box"><img alt="法人乗り換えキャンペーン" src="https://d1q08lkutgkcx2.cloudfront.net/image/business_campaign2_t.png" width="921" height="297"></div>
  <div class="debut-description-period">
    <div class="debut-description-period-title">
      <div class="black-box">
        <p>キャンペーン期間</p>
      </div>
    </div>
    <div class="debut-description-period-desciption">
      <p>` + campaign_archive_date_3 + `</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン内容</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>課金開始月を1ヶ月目として、3ヶ月目までの月額基本料を下記といたします。</p><br class="sp">
      <p>スタンダードプラン<br class="sp">
      20GB（契約期間2年）：0円<br>
      スタンダードプラン<br class="sp">
      40GB（契約期間2年）：0円<br>
      スタンダードプラン<br class="sp">
      100GB（契約期間2年）：0円</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン対象条件</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <ul>
        <li>キャンペーン期間中、スタンダードプラン<br class="sp">
        （契約期間2年）を法人名義で<br class="pc">
        5台以上ご契約いただいたお客様。（個人名義または法人名義でも4台以下のご契約は<br class="pc">
        対象外となります。）</li>
        <li>ZEUS WiFiの申し込み時点で他社固定<br class="sp">
        ブロードバンド回線または他社モバイル<br class="pc">
        ブロードバンド回線を契約中のお客様。（他社回線との契約の証明書を当社に<br class="pc">
        お送りいただく必要があります。）</li>
        <li>他社固定ブロードバンド回線または他社モバイルブロードバンド回線の契約名義がZEUS WiFiの契約名義と一致すること。</li>
      </ul>
      <p class="remark-text campaign-archive">＜注意事項＞</p>
      <p class="remark-text campaign-archive">※本キャンペーンは、他キャンペーンとの併用を可能とします</p>
    </div>
  </div>
</div>
`; // 内容

// アーカイブ（4）
campaign_archive_date_4 = `2021年4月7日～2021年6月30日
`; // 日付

campaign_archive_title_4 = `
春のZEUSキャンペーン
`; // タイトル

campaign_archive_contents_4 = `
<div class="debut-description">
  <div class="campaign-archive-description-img-box"><img alt="春のZEUSキャンペーン" src="https://d1q08lkutgkcx2.cloudfront.net/image/spring_campaign_t.png" width="921" height="297"></div>
  <div class="debut-description-period">
    <div class="debut-description-period-title">
      <div class="black-box">
        <p>キャンペーン期間</p>
      </div>
    </div>
    <div class="debut-description-period-desciption">
      <p>` + campaign_archive_date_4 + `</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン内容</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>課金開始月を1ヶ月目として、6ヶ月目までの月額基本料を下記といたします。</p><br class="sp">
      <p>スタンダードプラン<br class="sp">
      20GB(契約期間2年)：891円(980円税込)※<br>
      スタンダードプラン<br class="sp">
      40GB(契約期間2年)：1,528円(1,680円税込)※</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン対象条件</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>キャンペーン期間中、<br class="sp">
      スタンダードプラン20GB(契約期間2年)、<br>
      スタンダードプラン40GB(契約期間2年)をご契約いただいたお客様を対象といたします。</p><br>
      <p class="remark-text campaign-archive">＜注意事項＞</p>
      <p class="remark-text campaign-archive">※本サービスの初月基本料は、<br class="sp">
      スタンダードプラン20GB(契約期間2年)：1,980円(2,178円税込)、<br class="pc">
      スタンダードプラン40GB(契約期間2年)：2,680円(2,948円税込)の日割計算となりますが、<br>
      本キャンペーン適用のお客様は、キャンペーン価格の<br class="sp">
      月額基本料<br class="pc">
      スタンダードプラン20GB(契約期間2年)：891円(980円税込)、<br class="pc">
      スタンダードプラン40GB(契約期間2年)：1,528円(1,680円税込)の日割計算となります。</p>
    </div>
  </div>
</div>
`; // 内容

// アーカイブ（5）
campaign_archive_date_5 = `2021年7月1日～2021年9月30日
`; // 日付

campaign_archive_title_5 = `
ZEUSサマーキャンペーン
`; // タイトル

campaign_archive_contents_5 = `
<div class="debut-description">
  <div class="campaign-archive-description-img-box"><img alt="ZEUSサマーキャンペーン" src="https://d1q08lkutgkcx2.cloudfront.net/image/summer_campaign_t.png" width="921" height="297"></div>
  <div class="debut-description-period">
    <div class="debut-description-period-title">
      <div class="black-box">
        <p>キャンペーン期間</p>
      </div>
    </div>
    <div class="debut-description-period-desciption">
      <p>` + campaign_archive_date_5 + `</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン内容</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>課金開始月を1ヶ月目として、4ヶ月目までの月額基本料を下記といたします。</p><br class="sp">
      <p>スタンダードプラン<br class="sp">
      20GB(契約期間2年)：891円(980円税込)※<br>
      スタンダードプラン<br class="sp">
      40GB(契約期間2年)：1,528円(1,680円税込)※</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン対象条件</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>キャンペーン期間中、<br class="sp">
      スタンダードプラン20GB(契約期間2年)、<br>
      スタンダードプラン40GB(契約期間2年)をご契約いただいたお客様を対象といたします。</p><br>
      <p class="remark-text campaign-archive">＜注意事項＞</p>
      <p class="remark-text campaign-archive">※本サービスの初月基本料は、<br class="sp">
      スタンダードプラン20GB(契約期間2年)：1,980円(2,178円税込)、<br class="pc">
      スタンダードプラン40GB(契約期間2年)：2,680円(2,948円税込)の日割計算となりますが、<br>
      本キャンペーン適用のお客様は、キャンペーン価格の<br class="sp">
      月額基本料<br class="pc">
      スタンダードプラン20GB(契約期間2年)：891円(980円税込)、<br class="pc">
      スタンダードプラン40GB(契約期間2年)：1,528円(1,680円税込)の日割計算となります。</p>
    </div>
  </div>
</div>
`; // 内容

// アーカイブ（6）
campaign_archive_date_6 = `2021年12月7日～2022年1月31日
`; // 日付

campaign_archive_title_6 = `
ZEUS 5,000円キャッシュバックキャンペーン
`; // タイトル

campaign_archive_contents_6 = `
<div class="debut-description">
  <div class="campaign-archive-description-img-box"><img alt="ZEUS 5,000円キャッシュバックキャンペーン" src="https://d1q08lkutgkcx2.cloudfront.net/image/cb_campaign_t.png" width="921" height="297"></div>
  <div class="debut-description-period">
    <div class="debut-description-period-title">
      <div class="black-box">
        <p>キャンペーン期間</p>
      </div>
    </div>
    <div class="debut-description-period-desciption">
      <p>` + campaign_archive_date_6 + `※１</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン内容</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>下記の「キャンペーン対象条件」を満たしたお客様を対象に 5,000 円キャッシュバック致します。※２</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン対象条件</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>・キャンペーン期間中、<br class="sp">
      下記プランを個人名義でご契約されたお客様。</p>
      <p>スタンダードプラン 20GB（契約期間 2 年）</p>
      <p>スタンダードプラン 40GB（契約期間 2 年）</p>
      <p>スタンダードプラン 100GB（契約期間 2 年）</p>
      <p>フリープラン 20GB（契約期間 2 年）</p>
      <p>フリープラン 40GB（契約期間 2 年）</p>
      <p>フリープラン 100GB（契約期間 2 年）</p>
      <p>・課金開始月を 1 ヶ月目として 10 ヶ月目の末日まで継続利用の確認が取れたお客様。（解約された場合は、キャンペーン対象外となります。）</p>
      <p>・キャッシュバック判定日までにご契約頂いたプランを継続されたお客様。</p>
      <p>・ZEUS WiFi の料金の未払いや滞納がないお客様。</p>
      <p>・2022 年 11 月に、当社より送付するメールから期日内にアンケートにご回答頂いたお客様。（申込時にご登録頂いたメールアドレス宛に送付致します。）</p>
      <p>・2022 年 12 月に、当社より送付するメールから期日内にキャッシュバックのお手続きを行って頂いたお客様。（申込時にご登録頂いたメールアドレス宛に送付致します。）</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン対象外条件</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>・法人契約のお客様。</p>
      <p>・キャッシュバック判定日までに ZEUS WiFi を解約されたお客様</p>
      <p>・キャッシュバック判定日までにご契約頂いたプランの継続確認が取れなかったお客様</p>
      <p>・ZEUS WiFi の料金の未払いや滞納があるお客様</p>
      <p>・当社からのアンケートに未回答のお客様</p>
      <p>・ギフトコードの URL からギフトコードの引き換えを行わなかったお客様</p><br>
      <p class="remark-text campaign-archive">＜注意事項＞</p>
      <p class="remark-text campaign-archive">※１：本キャンペーンは、予告なく終了または変更する場合があります。</p>
      <p class="remark-text campaign-archive">※２：キャッシュバックは「RealPay ギフト」にて選べるギフトコードの URL を送付致します。（ギフトコードは PayPay/Amazon ギフト券/Apple store・iTunes/GooglePlay 等と引き換え可能です。URL には引き換え期限があります。ギフトコードの URL については理由の如何を問わず再送致しかねます。）</p>
    </div>
  </div>
</div>
`; // 内容

// アーカイブ（7）
campaign_archive_date_7 = `2020年9月15日～2022年2月28日
`; // 日付

campaign_archive_title_7 = `
スタンダードプラン 100GB デビューキャンペーン
`; // タイトル

campaign_archive_contents_7 = `
<div class="debut-description">
  <div class="campaign-archive-description-img-box"><img alt="スタンダードプラン 100GB デビューキャンペーン" src="https://d1q08lkutgkcx2.cloudfront.net/image/debut100gb_t.png" width="921" height="297"></div>
  <div class="debut-description-period">
    <div class="debut-description-period-title">
      <div class="black-box">
        <p>キャンペーン期間</p>
      </div>
    </div>
    <div class="debut-description-period-desciption">
      <p>` + campaign_archive_date_7 + `※１</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン内容</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>課金開始月を 1 ヶ月目として、3 ヶ月目までの月額基本料を 2,980 円（3,278 円税込）、4 ヶ月目以降の月額基本料を 3,480 円（3,828 円税込）と致します。※２</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン対象条件</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>キャンペーン期間中、スタンダードプラン 100GB（契約期間：2 年）をご契約頂いたお客様を対象に、スタンダードプラン 100GB 月額基本料 3,880 円（4,268 円税込）を、課金開始月を 1 ヶ月目として、3 ヶ月目までの月額基本料を 2,980 円（3,278 円税込）、4 ヶ月目以降の月額基本料を 3,480 円（3,828 円税込）と致します。※２</p><br>
      <p class="remark-text campaign-archive">・注意事項</p>
      <p class="remark-text campaign-archive">※１：本キャンペーンは、予告なく終了または変更する場合があります。</p>
      <p class="remark-text campaign-archive">※２：本サービスの初月基本料は、スタンダードプラン 100GB 月額基本料 3,880 円（4,268円税込）の日割計算となりますが、本キャンペーン適用のお客様は、キャンペーン価格の月額基本料 2,980 円（3,278 円税込）の日割計算となります。</p>
    </div>
  </div>
</div>
`; // 内容

// アーカイブ（8）
campaign_archive_date_8 = `2021年10月1日～2022年2月28日
`; // 日付

campaign_archive_title_8 = `
ZEUS W キャンペーン
`; // タイトル

campaign_archive_contents_8 = `
<div class="debut-description">
  <div class="campaign-archive-description-img-box"><img alt="ZEUS W キャンペーン" src="https://d1q08lkutgkcx2.cloudfront.net/image/w_campaign_t.png" width="921" height="297"></div>
  <div class="debut-description-period">
    <div class="debut-description-period-title">
      <div class="black-box">
        <p>キャンペーン期間</p>
      </div>
    </div>
    <div class="debut-description-period-desciption">
      <p>` + campaign_archive_date_8 + `※１</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン内容</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>①課金開始月を 1 ヶ月目として 3 ヶ月目までの月額基本料を下記と致します。</p>
      <p>スタンダードプラン 20GB（契約期間 2 年）：891 円（980 円税込）※２</p>
      <p>スタンダードプラン 40GB（契約期間 2 年）：1,528 円（1,680 円税込）※２</p>
      <p>②課金開始月を 1 ヶ月目として 12 ヶ月目まで、毎月データ容量をプレゼント致します。</p>
      <p>スタンダードプラン 20GB（契約期間 2 年）：毎月 5GB をプレゼント※３</p>
      <p>スタンダードプラン 40GB（契約期間 2 年）：毎月 10GB をプレゼント※３</p>
      <p>スタンダードプラン 100GB（契約期間 2 年）：毎月 10GB をプレゼント※３</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン対象条件</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>キャンペーン期間中、スタンダードプラン 20GB（契約期間 2 年）、スタンダードプラン40GB（契約期間 2 年）、スタンダードプラン 100GB（契約期間 2 年）をご契約頂いたお客様を対象と致します。</p><br>
      <p class="remark-text campaign-archive">・注意事項</p>
      <p class="remark-text campaign-archive">※１：本キャンペーンは、予告なく終了または変更する場合があります。</p>
      <p class="remark-text campaign-archive">※２：本サービスの初月基本料は、スタンダードプラン 20GB（契約期間 2 年）：1,980 円（2,178 円税込）、スタンダードプラン 40GB（契約期間 2 年）：2,680 円（2,948 円税込）の日割計算となりますが、本キャンペーン適用のお客様は、キャンペーン価格の月額基本料スタンダードプラン 20GB（契約期間 2 年）：891 円（980 円税込）、スタンダードプラン40GB（契約期間 2 年）：1,528 円（1,680 円税込）の日割計算となります。</p>
      <p class="remark-text campaign-archive">※３：<br>
      ・キャンペーン対象プレゼントのデータ容量は、マイページより「GIGA ボーナスボタン」を押して受け取るものとします。<br>
      ・キャンペーン対象プレゼントのデータ容量は翌月への繰越はできないものとします。<br>
      ・料金未納がある場合は、キャンペーン対象プレゼントの適用対象とはなりせん。また、毎月末日までに料金未納が解消されない場合、翌月のプレゼントも適用対象とはなりせん。なお、料金未納が解消した場合、解消月の翌月からプレゼント適用対象とします。<br>
      ・申込時のプランを継続された場合、プレゼントキャンペーン対象となりますが、プラン変更等で申込時とは異なるプランを利用する場合、キャンペーン対象外となり適用されません。</p>
    </div>
  </div>
</div>
`; // 内容


// アーカイブ（9）
campaign_archive_date_9 = `2022年3月1日～2022年4月5日
`; // 日付

campaign_archive_title_9 = `
SALE キャンペーン
`; // タイトル

campaign_archive_contents_9 = `
<div class="debut-description">
  <div class="campaign-archive-description-img-box"><img alt="SALE キャンペーン" src="https://d1q08lkutgkcx2.cloudfront.net/image/sale_campaign_t.png" width="921" height="297"></div>
  <div class="debut-description-period">
    <div class="debut-description-period-title">
      <div class="black-box">
        <p>キャンペーン期間</p>
      </div>
    </div>
    <div class="debut-description-period-desciption">
      <p>` + campaign_archive_date_9 + `※１</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン内容</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>①課金開始月を 1 ヶ月目として 3 ヶ月目までの月額基本料を下記と致します。</p>
      <p>スタンダードプラン 20GB（契約期間 2 年）：891 円（980 円税込）※２</p>
      <p>スタンダードプラン 40GB（契約期間 2 年）：1,528 円（1,680 円税込）※２</p>
      <p>②課金開始月を 1 ヶ月目として 10 ヶ月目までの月額基本料を下記と致します。</p>
      <p>スタンダードプラン 100GB（契約期間 2 年）：1,800 円（1,980 円税込）※２</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン対象条件</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>キャンペーン期間中、スタンダードプラン 20GB（契約期間 2 年）、スタンダードプラン40GB（契約期間 2 年）、スタンダードプラン 100GB（契約期間 2 年）をご契約頂いたお客様を対象と致します。</p><br>
      <p class="remark-text campaign-archive">・注意事項</p>
      <p class="remark-text campaign-archive">※１：本キャンペーンは、予告なく終了または変更する場合があります。</p>
      <p class="remark-text campaign-archive">※２：本サービスの初月基本料は、スタンダードプラン 20GB（契約期間 2 年）：1,980 円（2,178 円税込）、スタンダードプラン 40GB（契約期間 2 年）：2,680 円（2,948 円税込）の日割計算となりますが、本キャンペーン適用のお客様は、キャンペーン価格の月額基本料スタンダードプラン 20GB（契約期間 2 年）：891 円（980 円税込）、スタンダードプラン40GB（契約期間 2 年）：1,528 円（1,680 円税込）、スタンダードプラン100GB（契約期間 2 年）：1,800 円（1,980 円税込）の日割計算となります。</p>
    </div>
  </div>
</div>
`; // 内容


// アーカイブ（10）
campaign_archive_date_10 = `2022年4月6日～2022年7月25日
`; // 日付

campaign_archive_title_10 = `
SALE キャンペーン 第2弾
`; // タイトル

campaign_archive_contents_10 = `
<div class="debut-description">
  <div class="campaign-archive-description-img-box"><img alt="SALE キャンペーン第2弾" src="https://d1q08lkutgkcx2.cloudfront.net/image/sale_campaign_t.png" width="921" height="297"></div>
  <div class="debut-description-period">
    <div class="debut-description-period-title">
      <div class="black-box">
        <p>キャンペーン期間</p>
      </div>
    </div>
    <div class="debut-description-period-desciption">
      <p>` + campaign_archive_date_10 + `※１</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン内容</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>①課金開始月を 1 ヶ月目として 6 ヶ月目までの月額基本料を下記と致します。</p>
      <p>スタンダードプラン 20GB（契約期間 2 年）：891 円（980 円税込）※２</p>
      <p>スタンダードプラン 40GB（契約期間 2 年）：1,528 円（1,680 円税込）※２</p>
      <p>②課金開始月を 1 ヶ月目として 10 ヶ月目までの月額基本料を下記と致します。</p>
      <p>スタンダードプラン 100GB（契約期間 2 年）：1,800 円（1,980 円税込）※２</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン対象条件</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>キャンペーン期間中、スタンダードプラン 20GB（契約期間 2 年）、スタンダードプラン40GB（契約期間 2 年）、スタンダードプラン 100GB（契約期間 2 年）をご契約頂いたお客様を対象と致します。</p><br>
      <p class="remark-text campaign-archive">・注意事項</p>
      <p class="remark-text campaign-archive">※１：本キャンペーンは、予告なく終了または変更する場合があります。</p>
      <p class="remark-text campaign-archive">※２：本サービスの初月基本料は、スタンダードプラン 20GB（契約期間 2 年）：1,980 円（2,178 円税込）、スタンダードプラン 40GB（契約期間 2 年）：2,680 円（2,948 円税込）の日割計算となりますが、本キャンペーン適用のお客様は、キャンペーン価格の月額基本料スタンダードプラン 20GB（契約期間 2 年）：891 円（980 円税込）、スタンダードプラン40GB（契約期間 2 年）：1,528 円（1,680 円税込）、スタンダードプラン100GB（契約期間 2 年）：1,800 円（1,980 円税込）の日割計算となります。</p>
    </div>
  </div>
</div>
`; // 内容

// アーカイブ（11）
campaign_archive_date_11 = `2022年7月26日～2023年1月25日
`; // 日付

campaign_archive_title_11 = `
神コスパキャンペーン
`; // タイトル

campaign_archive_contents_11 = `
<div class="debut-description">
  <div class="campaign-archive-description-img-box"><img alt="神コスパキャンペーン" src="https://d1q08lkutgkcx2.cloudfront.net/image/kami_campaign.png" width="921" height="297"></div>
  <div class="debut-description-period">
    <div class="debut-description-period-title">
      <div class="black-box">
        <p>キャンペーン期間</p>
      </div>
    </div>
    <div class="debut-description-period-desciption">
      <p>` + campaign_archive_date_11 + `※１</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン内容</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>・スタンダードプラン 20GB（契約期間2年）<br>
      課金開始月を1ヶ月目として、5ヶ月目までの月額基本料を891円（980円税込）と致します。※２</p>
      <p>・スタンダードプラン 40GB（契約期間2年）<br>
      課金開始月を1ヶ月目として、5ヶ月目までの月額基本料を1,346円（1,480円税込）と致します。※２</p>
      <p>・スタンダードプラン 100GB（契約期間2年）<br>
      課金開始月を1ヶ月目として、10ヶ月目までの月額基本料を1,800円（1,980円税込）、11ヶ月目以降の月額基本料を3,480（3,828円税込）と致します。※２</p>
    </div>
  </div>
  <div class="debut-description-body">
    <div class="debut-description-body-title">
      <div class="black-box">
        <p>キャンペーン対象条件</p>
      </div>
    </div>
    <div class="debut-description-body-desciption">
      <p>キャンペーン期間中に、<br>
      ・スタンダードプラン 20GB（契約期間2年）<br>
      ・スタンダードプラン 40GB（契約期間2年）<br>
      ・スタンダードプラン 100GB（契約期間2年）<br>
      をご契約頂いたお客様が対象となります。</p><br>
      <p class="remark-text campaign-archive">・注意事項</p>
      <p class="remark-text campaign-archive">※１：本キャンペーンは、予告なく終了又は変更する場合があります。</p>
      <p class="remark-text campaign-archive">※２：本サービスの初月基本料は、スタンダードプラン20GB（契約期間2年）：1,980円（2,178円税込）、スタンダードプラン40GB（契約期間2年）：2,680円（2,948円税込）、スタンダードプラン100GB月額基本料3,880円（4,268円税込）の日割計算となりますが、本キャンペーン適用のお客様は、キャンペーン価格の月額基本料の日割計算となります。</p>
    </div>
  </div>
</div>
`; // 内容

var campaign_archive_date_array = [
    campaign_archive_date_1,
    campaign_archive_date_2,
    campaign_archive_date_3,
    campaign_archive_date_4,
    campaign_archive_date_5,
    campaign_archive_date_6,
    campaign_archive_date_7,
    campaign_archive_date_8,
    campaign_archive_date_9,
    campaign_archive_date_10,
    campaign_archive_date_11
  ]; // 日付を配列に追加

var campaign_archive_title_array = [
    campaign_archive_title_1,
    campaign_archive_title_2,
    campaign_archive_title_3,
    campaign_archive_title_4,
    campaign_archive_title_5,
    campaign_archive_title_6,
    campaign_archive_title_7,
    campaign_archive_title_8,
    campaign_archive_title_9,
    campaign_archive_title_10,
    campaign_archive_title_11
  ]; // タイトルを配列に追加

var campaign_archive_contents_array = [
    campaign_archive_contents_1,
    campaign_archive_contents_2,
    campaign_archive_contents_3,
    campaign_archive_contents_4,
    campaign_archive_contents_5,
    campaign_archive_contents_6,
    campaign_archive_contents_7,
    campaign_archive_contents_8,
    campaign_archive_contents_9,
    campaign_archive_contents_10,
    campaign_archive_contents_11
  ]; // 内容を配列に追加

  campaign_archive_url_array[0] = campaign_archive_url;
  campaign_archive_url_array[1] = campaign_archive_url;
  campaign_archive_url_array[2] = campaign_archive_url;
  campaign_archive_url_array[3] = campaign_archive_url;
  campaign_archive_url_array[4] = campaign_archive_url;
  campaign_archive_url_array[5] = campaign_archive_url;
  campaign_archive_url_array[6] = campaign_archive_url;
  campaign_archive_url_array[7] = campaign_archive_url;
  campaign_archive_url_array[8] = campaign_archive_url;
  campaign_archive_url_array[9] = campaign_archive_url;
  campaign_archive_url_array[10] = campaign_archive_url;
  //掲載ページ指定

  // アーカイブ内容 end




// 以下は変更不要 start ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function() {
  // 作成した連想配列をループで回す
  $.each(campaign_archive_url_array, function(url_index, campaign_archive_url_value) {
    // ポップアップテンプレート
    $.each(campaign_archive_contents_array, function(index, campaign_archive_contents_value) {
      if(url_index == index){

        var top_notion_popup_normal = `
          <div class="news-notion-black-background news-notion-black-background`+index+`" data-focus="js-tabindex-`+index+`"></div>
          <div class="pop-up-news white-content-box-news-notion white-content-box-news-notion`+index+`">
            <div class="news-popup-close-button news-popup-close-button`+index+`" data-focus="js-tabindex-`+index+`">
              <img src="https://d1q08lkutgkcx2.cloudfront.net/image/popup-close.svg" width="17" height="17" alt="閉じる">
            </div>
            <div class="white-content-box-title white-content-box-title-notion white-content-box-title-news-notion">
              <p class="news-title-area`+index+`"></p>
            </div>
            <div class="white-content-box-inner-news">
              <div class="white-content-box-body">
              ` + campaign_archive_contents_value + `
              </div>
            </div>
          </div>
        `;

        var campaign_archive_url_value_value = Object.values(campaign_archive_url_value);
        var campaign_archive_url_index = $.inArray(window.location.pathname, campaign_archive_url_value_value);
  
        if(campaign_archive_url_index !== -1){
          $("body").append(top_notion_popup_normal);
        }

        return false;
      }
    })
    // バナーテンプレート

    //タイトルの配列をだす
    $.each(campaign_archive_title_array, function(index, campaign_archive_title_value) {
      if(url_index == index){
        var _html_normal;
        //日付の配列をだす
        $.each(campaign_archive_date_array, function(data_index, campaign_archive_date_value) {
          if(url_index == data_index){
          _html_normal = `
            <div class="info-content">
              <div class="info-date">` + campaign_archive_date_value + `</div>
            <a href="javascript:showNewsPopup(`+index+`)" class="pink-link js-tabindex-`+index+`"><div class="info-title"> ` + campaign_archive_title_value + `</div></a></p>
            `;
          }
      })

        var campaign_archive_url_value_value = Object.values(campaign_archive_url_value);
        var campaign_archive_url_index = $.inArray(window.location.pathname, campaign_archive_url_value_value);

        if(campaign_archive_url_index !== -1){
          $(".popup-html").after(_html_normal); // ポップアップバナー設置箇所に.popup-htmlを付与必要
        }

        $(".news-title-area" + index).html(campaign_archive_title_value);
      }

    })
  })

  hideNewsPopup();

  $(".news-popup-close-button").keydown(function(event) {
    if( event.keyCode == 13 ) {
      $(this).click();
    }
  });

  $(".info-content a").keydown(function(event) {
    if( event.keyCode == 13 ) {
      $('.news-popup-close-button').attr('tabindex', 0);
    }
  });

  $(".news-notion-black-background,.news-popup-close-button").click(function(){
    $('.news-popup-close-button').removeAttr('tabindex');
    var focus = $(this).data('focus');
    hideNewsPopup(focus);
  });
});

function showNewsPopup(index){
  $(".news-notion-black-background" + index).show();
  $(".white-content-box-news-notion" + index).show();
  $(".news-popup-close-button" + index).focus();
}

function hideNewsPopup(focus){
  $(".news-notion-black-background").hide();
  $(".white-content-box-news-notion").hide();

  $("." + focus).focus();
}
// 以下は変更不要 end //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
