/**
 * FAQ カテゴリー別・絞り込み検索
 */
(function ($) {
  $(function () {
    const faqSearch = {
      cfg: {
        min_letter: 2, // 最低文字数
        suggest_max_pc: 10, // サジェスト件数（PC）
        suggest_max_sp: 5, // サジェスト件数（モバイル）
        suggest_content: 'all', // all=アンサーも対象
        separate: /[ |　]/, //複数ワードのセパレータ
        first_display: true, // 初回のQA一覧表示
        $faq: $('.js-faq'), // 対象ブロック
        $faq_btns: $('.js-faq .js-faq-btn'), // カテゴリー選択ボタン
        $faq_sections: $('.js-faq .js-faq-section'), // カテゴリー別コンテンツグループ
        $faq_input: $('.js-faq .js-faq-search-form-input'), // 検索ワード入力
        $faq_submit: $('.js-faq .js-faq-search-form-submit'), // 検索ボタン
        $faq_message: $('.js-faq .js-faq-message'), // 入力エラーメッセージ
        $faq_search_word: $('.js-faq .js-faq-search-word'), // 検索ワード（結果）
        $faq_suggest: $('.js-faq .js-faq-suggest'), // サジェストブロック
        $faq_result_header: $('#js-faq-result-header'), // 結果ブロックヘッダー
        $faq_count_num: $('.js-faq .js-faq-count .num'), // 検索結果件数
        $faq_clear_word: $('.js-faq .js-faq-clear-word'), // 検索ワード入力削除
        $serviceHeader: $('header.service-header'), // ページヘッダー
        cn: {
          complete: 'js-faq-complete', // 完了時に結果ブロックにクラス付加
          result: 'js-faq-result', // 検索結果時に結果ブロックにクラス付加
          category: 'js-faq-category', // カテゴリー選択時に結果ブロックにクラス付加
          noResult: 'js-faq-no-result', // 結果なしのときにクラス付加
          active: 'active', // QAコンテンツ
          hidden: 'hidden', // QAブロック
          visible: 'visible', // セクション
          show: 'show', // エラー・回答
        },
        elem: {
          catTitle: '.js-faq-cat-title', // カテゴリータイトル
          resultTitle: '.js-faq-result-title', // 検索結果タイトル
          body: '.js-faq-body', // QAブロック
          q: '.js-faq-body-q', // 質問
          a: '.js-faq-body-a', // 回答
        },
        temp: {
          hash: '',
        }
      },
      // テキスト抽出
      _prettyText: function (text) {
        text = text.replace(/[\s|\r|\n]/g, '');
        text = text.replace(/^[A|Q]/, '');
        return text;
      },
      // Answerを閉じる
      _closeAnswer: function () {
        const cfg = faqSearch.cfg;
        const $faq_body = $(cfg.elem.catTitle, cfg.$faq_sections).nextAll(cfg.elem.body);
        $faq_body.each(function () {
          $(cfg.elem.q, this).removeClass(cfg.cn.active);
          $(cfg.elem.a, this).hide();
        });
      },
      // 初期化
      init: function () {
        const cfg = faqSearch.cfg;
        cfg.$faq.removeClass(cfg.cn.result);
        cfg.$faq.removeClass(cfg.cn.category);
        if (cfg.first_display) {
          cfg.$faq_sections.addClass(cfg.cn.visible);
        } else {
          cfg.$faq_sections.removeClass(cfg.cn.visible);
        }
        $(cfg.elem.body, cfg.$faq_sections).removeClass(cfg.cn.hidden);
      },
      // 指定の項目へ遷移
      specify: function () {
        const cfg = faqSearch.cfg;
        let hash = window.location.hash.split('.')[1];
        let specify = $(`#${hash}`).closest(cfg.$faq_sections).attr('id');
        if (specify) {
          cfg.$faq_sections.removeClass(cfg.cn.visible);
          cfg.$faq.addClass(cfg.cn.category);
          $(`#${specify}`).addClass(cfg.cn.visible);
          cfg.$faq.removeClass(cfg.cn.result);
        }
        // ページ内
        $('a', cfg.$faq_sections).on('click', function () {
          const href = $(this).attr('href');
          if (!href.match(/(^#|#faq\-)/)) {
            return;
          }
          window.location.hash = '';
          hash = href.split('.')[1];
          faqSearch._closeAnswer();
          cfg.$faq_sections.removeClass(cfg.cn.visible);
          cfg.$faq.addClass(cfg.cn.category);
          specify = $(`#${hash}`).closest(cfg.$faq_sections).attr('id');
          $(cfg.elem.catTitle, cfg.$faq_sections).removeClass(cfg.cn.hidden);
          $(cfg.elem.body, cfg.$faq_sections).removeClass(cfg.cn.hidden);
          cfg.$faq.addClass(cfg.cn.category);
          $(`#${specify}`).addClass(cfg.cn.visible);
          cfg.$faq.removeClass(cfg.cn.result);
          cfg.$faq_input.val('');
        });
      },
      // カテゴリー選択
      category: function () {
        const cfg = faqSearch.cfg;
        cfg.$faq_btns.each(function () {
          $('a', this).on('click', function (e) {
            cfg.$faq.removeClass(cfg.cn.complete);
            cfg.$faq.removeClass(cfg.cn.result);
            cfg.$faq.addClass(cfg.cn.category);
            cfg.$faq_input.val('');
            cfg.$faq_sections.removeClass(cfg.cn.visible);
            $(cfg.elem.catTitle, cfg.$faq_sections).removeClass(cfg.cn.hidden);
            $(cfg.elem.body, cfg.$faq_sections).removeClass(cfg.cn.hidden);
            faqSearch._closeAnswer();
            const $section = $(this);
            setTimeout(function () {
              $($section.attr('href')).addClass(cfg.cn.visible);
              cfg.$faq.addClass(cfg.cn.complete);
            }, 200);
            e.preventDefault();
            return false;
          });
        });
      },
      // 絞り込み検索
      search: function () {
        const cfg = faqSearch.cfg;
        let search_word;
        let set_suggest = false;
        // 入力
        cfg.$faq_input.on('input focus', function (e) {
          cfg.$faq_message.text('').removeClass(cfg.cn.show);
          let suggest_max = document.documentElement.clientWidth < 768 ? cfg.suggest_max_sp : cfg.suggest_max_pc;
          let suggest = [];
          search_word = cfg.$faq_input.val();
          cfg.$faq_suggest.html('').removeClass(cfg.cn.active);
          if (search_word.length < cfg.min_letter) {
            return;
          }
          // サジェスト
          let word_count = 0;
          const icon = '<svg class="icon icon-search"><use href="#svg-icon-search"></use></svg>';
          cfg.$faq_sections.each(function () {
            $(cfg.elem.body, this).each(function () {
              let faq_q = faqSearch._prettyText($(cfg.elem.q, this)[0].textContent);
              const faq_qa = cfg.suggest_content == 'all' ? faq_q + faqSearch._prettyText($(cfg.elem.a, this)[0].textContent) : faq_q;
              let search_words = search_word.split(cfg.separate);
              search_words = search_words.filter(Boolean);
              if (word_count < suggest_max + 5) {
                search_words.forEach(function (word) {
                  if (faq_qa.indexOf(word) >= 0) {
                    faq_q = faq_q.replace(new RegExp(word, 'g'), `<strong>${word}</strong>`);
                  } else {
                    faq_q = ''; // andの場合
                    return;
                  }
                });
                if (faq_q) {
                  suggest.push(`<li>${icon}<div class="text">${faq_q}</div></li>`);
                  word_count++;
                }
              }
            });
          });
          set_suggest = false;
          suggest = Array.from(new Set(suggest)); // 重複するタイトルは除外
          suggest = suggest.slice(0, suggest_max);
          if (suggest.length > 0) {
            cfg.$faq_suggest.html('<ul>' + suggest.join('') + '</ul>');
            if (!set_suggest) {
              setTimeout(function () {
                cfg.$faq_suggest.addClass(cfg.cn.active);
              }, 400);
            }
          }
        });
        cfg.$faq_input.on('blur', function () {
          $('li', cfg.$faq_suggest).on('click', function () {
            set_suggest = true;
            search_word = $(this).text();
            cfg.$faq_input.val(search_word);
            cfg.$faq_suggest.html('');
          });
          setTimeout(function () {
            cfg.$faq_suggest.removeClass(cfg.cn.active);
          }, 200);
        });
        // クリア
        cfg.$faq_clear_word.on('click', function () {
          cfg.$faq_input.val('');
          cfg.$faq_input.focus();
        });
        // 実行
        const submit = function (e) {
          cfg.$faq_suggest.removeClass(cfg.cn.active);
          cfg.$faq.removeClass(cfg.cn.complete);
          cfg.$faq.removeClass(cfg.cn.category);
          cfg.$faq_message.text('').removeClass(cfg.cn.show);
          let result_flag = false;
          search_word = cfg.$faq_input.val();
          const search_results = [];
          faqSearch._closeAnswer();
          if (search_word.length < cfg.min_letter) {
            cfg.$faq_message.text(`${cfg.min_letter}文字以上入力してください`).addClass(cfg.cn.show);
            cfg.$faq.addClass(cfg.cn.complete);
            return false;
          }
          $(cfg.elem.resultTitle, cfg.$faq).removeClass(cfg.cn.hidden);
          cfg.$faq_sections.removeClass(cfg.cn.visible);
          const _faq_q = [];
          let suggest_flag = false;
          cfg.$faq_sections.each(function () {
            $(cfg.elem.body, this).each(function () {
              $(this).addClass(cfg.cn.hidden);
              const faq_q = faqSearch._prettyText($(cfg.elem.q, this)[0].textContent);
              const faq_a = faqSearch._prettyText($(cfg.elem.a, this)[0].textContent);
              // サジェクトからの結果
              if (set_suggest) {
                if (!suggest_flag && faq_q == search_word) {
                  suggest_flag = true;
                  result_flag = true;
                  cfg.$faq_search_word.removeClass(cfg.cn.hidden);
                  $(this).removeClass(cfg.cn.hidden);
                  $(cfg.elem.q, this).addClass(cfg.cn.active);
                  $(cfg.elem.a, this).show();
                  search_results.push(this);
                }
              } else {
                const search_words = search_word.split(cfg.separate);
                let res_q = true;
                let res_a = true;
                search_words.forEach(function (word) {
                  if (faq_q.indexOf(word) < 0) {
                    res_q = false;
                  }
                  if (faq_a.indexOf(word) < 0) {
                    res_a = false;
                  }
                });
                if (res_q || res_a) {
                  result_flag = true;
                  if (!_faq_q.includes(faq_q)) { // 重複するタイトルは除外
                    $(this).removeClass(cfg.cn.hidden);
                    search_results.push(this);
                  }
                  _faq_q.push(faq_q);
                }
              }
            });
            if (result_flag) { // 結果アリ
              cfg.$faq.removeClass(cfg.cn.noResult);
              $(cfg.elem.catTitle, this).addClass(cfg.cn.hidden);
              if (suggest_flag) {
                $(cfg.elem.resultTitle, cfg.$faq).addClass(cfg.cn.hidden);
              }
              const $section = $(this);
              setTimeout(function () {
                $section.addClass(cfg.cn.visible);
              }, 200);
            } else { // 結果ナシ
              cfg.$faq.addClass(cfg.cn.noResult);
            }
          });
          cfg.$faq_search_word.text(search_word);
          cfg.$faq_count_num.text(search_results.length);
          cfg.$faq.addClass(cfg.cn.result);
          $('html,body').animate({ scrollTop: cfg.$faq_result_header.position().top - cfg.$serviceHeader.height() });
          setTimeout(function () {
            cfg.$faq.addClass(cfg.cn.complete);
          }, 200);
          return false;
        };
        cfg.$faq_submit.on('click', submit);
        cfg.$faq_suggest.on('click', submit);
      },
      run: function () {
        this.init();
        this.specify();
        this.category();
        this.search();
      },
    };
    faqSearch.run();
  });
})(jQuery);
