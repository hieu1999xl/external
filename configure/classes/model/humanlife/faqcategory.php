<?php

/**
 * FAQカテゴリテーブルのモデルクラス
 */
class Model_HumanLife_FaqCategory extends Model_CrudAbstract {

    /**
     * 公開中FAQカテゴリを取得する
     *
     * @return array
     */
    public function get_published_faq_category_list($page) {
        $sql =
            <<<SQL
SELECT
    *
FROM
    faq_category AS fc 
WHERE
    fc.status = :status 
SQL;
        switch ($page)
        {
            case 1:
                $sql .= <<<SQL
AND fc.is_shown_on_homepage = :flag_on 
SQL;
                break;
            case 2:
                $sql .= <<<SQL
AND fc.is_shown_on_faqpage = :flag_on 
SQL;
                break;
            case 3:
                $sql .= <<<SQL
AND fc.is_shown_on_mypage = :flag_on 
SQL;
                break;
            case 4:
                $sql .= <<<SQL
AND fc.is_shown_on_promotion = :flag_on 
SQL;
                break;
            case 6:
                $sql .= <<<SQL
AND fc.is_shown_on_openhouse = :flag_on 
ORDER BY
    fc.position_openhouse ASC
SQL;
                break;
            default:
                break;
        }
        if ($page != 6) {
            $sql .= <<<SQL
ORDER BY
    fc.position ASC
SQL;
        }
        $params = [
            'status'    => FAQ_CATEGORY_STATUS_VALUE_LIST[0],
            'flag_on'   => FLG_ON,
        ];

        parent::pre_find($sql);
        $result = DB::query($sql)->parameters($params)->execute()->as_array();
        return parent::post_find($result);
    }


}
