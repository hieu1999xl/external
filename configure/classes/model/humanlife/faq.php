<?php

/**
 * FAQテーブルのモデルクラス
 */
class Model_HumanLife_Faq extends Model_CrudAbstract {

    /**
     * 公開中のFAQを取得する
     *
     * @param $faqpage
     * @return array
     */
    public function get_published_faq_list($faqpage) {
        $sql =
<<<SQL
SELECT
    f.* 
FROM
    faq AS f
        LEFT JOIN
            faq_category AS fc
        ON  f.faq_category_id = fc.faq_category_id 
WHERE
    f.status = :f_status
AND fc.status = :fc_status 
SQL;

        switch ($faqpage)
        {
            case 1:
                $sql .= <<<SQL
AND f.is_shown_on_homepage = :flag_on 
AND fc.is_shown_on_homepage = :flag_on 
SQL;
                break;
            case 2:
                $sql .= <<<SQL
AND f.is_shown_on_faqpage = :flag_on 
AND fc.is_shown_on_faqpage = :flag_on 
SQL;
                break;
            case 3:
                $sql .= <<<SQL
AND f.is_shown_on_mypage = :flag_on 
AND fc.is_shown_on_mypage = :flag_on 
SQL;
                break;
            case 4:
                $sql .= <<<SQL
AND f.is_shown_on_promotion = :flag_on 
AND fc.is_shown_on_promotion = :flag_on 
SQL;
                break;
            case 5:
                $sql .= <<<SQL
AND f.is_shown_on_overseas = :flag_on 
AND f.faq_category_id = 6 
SQL;
                break;
            case 6:
                $sql .= <<<SQL
AND f.is_shown_on_openhouse = :flag_on 
AND fc.is_shown_on_openhouse = :flag_on 
ORDER BY
    fc.position_openhouse ASC,
    f.position_openhouse ASC
SQL;
                break;
            case 7:
                $sql .= <<<SQL
AND f.is_shown_on_wimax = :flag_on 
AND fc.is_shown_on_wimax = :flag_on 
ORDER BY 
    fc.position_wimax ASC,
    f.position_wimax ASC
SQL;
                break;
            default:
                return array();
        }
        if ($faqpage != 6 && $faqpage != 7) {
            $sql .= <<<SQL
ORDER BY 
    fc.position ASC,
    f.position ASC
SQL;
        }
        $params = [
            'f_status' => FAQ_STATUS_VALUE_LIST[0],
            'f_is_shown_on_mypage' => true,
            'fc_status'=> FAQ_CATEGORY_STATUS_VALUE_LIST[0],
            'flag_on' => FLG_ON,
        ];
        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }

    public function get_mypage_faq_list() {
        $sql = <<<SQL
SELECT
    f.* 
FROM
    faq AS f
        LEFT JOIN
            faq_category AS fc
        ON  f.faq_category_id = fc.faq_category_id 
WHERE
    f.status = :f_status 
AND f.is_shown_on_mypage = :f_is_shown_on_mypage 
AND fc.status = :fc_status 
ORDER BY 
    fc.position ASC,
    f.position ASC
SQL;

        $params = [
            'f_status' => FAQ_STATUS_VALUE_LIST[0],
            'f_is_shown_on_mypage' => true,
            'fc_status'=> FAQ_CATEGORY_STATUS_VALUE_LIST[0],

        ];

        parent::pre_find($query);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }
}
