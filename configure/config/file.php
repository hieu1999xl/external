<?php

/**
 * ファイル関連定義ファイル(mPDF)
 */
return array(
    'estimate' => array(//file.estimate.common.tmp_dir
        'common' => array(
            // 一時保存ディレクトリ（最後に「/」あり）
            'tmp_dir' => TEMP_FILE_DIRECTORY . 'estimate/'
        ),
        'pdf' => array(
            // 出力ファイル名
            'file_name' => 'estimate.pdf',

            // mPDFの設定
            'config' => array(
                'mode' => 'UTF-8',
                'format' => 'A4',
                'dpi' => '200',
                'tempDir' => TEMP_FILE_DIRECTORY . 'estimate/',
                'margin_left' => '10',
                'margin_right' => '10',
                'margin_top' => '10',
                'margin_bottom' => '10',
                'orientation' => 'P', // P:縦書き、L:横書き
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
                'fontDir' => array(
                    APPPATH . 'fonts/'
                ),
                'fontdata' => array(
                    'ipag' => array('R' => 'ipag.ttf'),
                    'ipagp' => array('R' => 'ipagp.ttf'),
                    'ipam' => array('R' => 'ipam.ttf'),
                    'ipamp' => array('R' => 'ipamp.ttf'),
                ),
            ),

            // デフォルトフォント（config.fontdataのキー値より選択）
            'default_font' => 'ipag',

            // 1ページの出力件数
            'page_count' => 50
        )
    ),
    // 請求書設定
    'bill' => array(
        'common' => array(
            // 一時保存ディレクトリ（最後に「/」あり）
            'tempDir' => TEMP_FILE_DIRECTORY . 'bill/',
        ),
        'pdf' => array(
            // 出力ファイル名
            'file_name' => 'bill.pdf',

            // mPDFの設定
            'config' => array(
                'mode' => 'UTF-8',
                'format' => 'A4',
                'dpi' => '200',
                'tempDir' => TEMP_FILE_DIRECTORY . 'tmp/bill/',
                'margin_left' => '10',
                'margin_right' => '10',
                'margin_top' => '10',
                'margin_bottom' => '10',
                'orientation' => 'P', // P:縦書き、L:横書き
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
                'fontDir' => array(
                    APPPATH . 'fonts/'
                ),
                'fontdata' => array(
                    'ipag' => array('R' => 'ipag.ttf'),
                    'ipagp' => array('R' => 'ipagp.ttf'),
                    'ipam' => array('R' => 'ipam.ttf'),
                    'ipamp' => array('R' => 'ipamp.ttf'),
                ),
            ),

            // デフォルトフォント（config.fontdataのキー値より選択）
            'default_font' => 'ipag',

            // 1ページの出力件数
            'page_count' => 50
        )
    ),

    /**
     * 利用明細書ファイル(mPDF)
     */
    'paymenthistory' => array(//file.paymenthistory.common.tmp_dir
        'common' => array(
            // 一時保存ディレクトリ（最後に「/」あり）
            'tmp_dir' => TEMP_FILE_DIRECTORY . 'paymenthistory/'
        ),
        'pdf' => array(
            // 出力ファイル名
            'file_name' => 'paymenthistory.pdf',

            // mPDFの設定
            'config' => array(
                'mode' => 'UTF-8',
                'format' => 'A4',
                'dpi' => '200',
                'tempDir' => TEMP_FILE_DIRECTORY . 'paymenthistory/',
                'margin_left' => '10',
                'margin_right' => '10',
                'margin_top' => '10',
                'margin_bottom' => '10',
                'orientation' => 'P', // P:縦書き、L:横書き
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
                'fontDir' => array(
                    APPPATH . 'fonts/'
                ),
                'fontdata' => array(
                    'ipag' => array('R' => 'ipag.ttf'),
                    'ipagp' => array('R' => 'ipagp.ttf'),
                    'ipam' => array('R' => 'ipam.ttf'),
                    'ipamp' => array('R' => 'ipamp.ttf'),
                ),
            ),
            // デフォルトフォント（config.fontdataのキー値より選択）
            'default_font' => 'ipag',
            // 1ページの出力件数
            'page_count' => 50
        ),
        'csv' => array(
            // 出力ファイル名
            'file_name' => 'データ使用量内訳.csv',
        )
    ),

    /**
     * 利用明細書ファイル(mPDF)
     */
    'paymenthistory_rental' => array(//file.paymenthistory_rental.common.tmp_dir
        'common' => array(
            // 一時保存ディレクトリ（最後に「/」あり）
            'tmp_dir' => TEMP_FILE_DIRECTORY . 'paymenthistory/'
        ),
        'pdf' => array(
            // 出力ファイル名
            'file_name' => 'paymenthistory_rental.pdf',

            // mPDFの設定
            'config' => array(
                'mode' => 'UTF-8',
                'format' => 'A4',
                'dpi' => '200',
                'tempDir' => TEMP_FILE_DIRECTORY . 'paymenthistory/',
                'margin_left' => '10',
                'margin_right' => '10',
                'margin_top' => '10',
                'margin_bottom' => '10',
                'orientation' => 'P', // P:縦書き、L:横書き
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
                'fontDir' => array(
                    APPPATH . 'fonts/'
                ),
                'fontdata' => array(
                    'ipag' => array('R' => 'ipag.ttf'),
                    'ipagp' => array('R' => 'ipagp.ttf'),
                    'ipam' => array('R' => 'ipam.ttf'),
                    'ipamp' => array('R' => 'ipamp.ttf'),
                ),
            ),
            // デフォルトフォント（config.fontdataのキー値より選択）
            'default_font' => 'ipag',
            // 1ページの出力件数
            'page_count' => 50
        ),
        'csv' => array(
            // 出力ファイル名
            'file_name' => 'データ使用量内訳.csv',
        )
    ),

    /**
     * 領収書ファイル(mPDF)
     */
    'receipt' => [
        'common' => ['tmp_dir' => TEMP_FILE_DIRECTORY . 'receipt/'], // 一時保存ディレクトリ（最後に「/」あり）
        'pdf' => [
            'file_name' => 'receipt_:receipt_no.pdf', // 出力ファイル名 ※お客様の利便性を考慮し動的に生成する
            // mPDFの設定
            'config' => [
                'mode' => 'UTF-8',
                'format' => 'A4',
                'dpi' => '200',
                'tempDir' => TEMP_FILE_DIRECTORY . 'receipt/',
                'margin_left' => '10',
                'margin_right' => '10',
                'margin_top' => '10',
                'margin_bottom' => '10',
                'orientation' => 'P',   // P:縦書き、L:横書き
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
                'fontDir' => [APPPATH . 'fonts/'],
                'fontdata' => [
                    'ipag' => ['R' => 'ipag.ttf'],
                    'ipagp' => ['R' => 'ipagp.ttf'],
                    'ipam' => ['R' => 'ipam.ttf'],
                    'ipamp' => ['R' => 'ipamp.ttf'],
                ],
            ],
            'default_font' => 'ipag',   // デフォルトフォント（config.fontdataのキー値より選択）
        ],
    ],

    /**
     * 利用規約法人
     */
    'corpcontractservice' => array(
        'file_name' => '利用規約.pdf',
    ),

    /**
     * 覚書法人
     */
    'memorandum' => array(
        'file_name' => '覚書.pdf',
    ),
);
