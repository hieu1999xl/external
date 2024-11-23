<?php

/**
 * データベースクエリ拡張クラス
 *
 * @author sakairi@liz-inc.co.jp
 *
 */
class Database_Query extends \Fuel\Core\Database_Query {

    /**
     * {@inheritDoc}
     * @see \Fuel\Core\Database_Query::execute()
     */
    public function execute($db = null) {
        Log::application()->debug('SQL_START', [
            $this->compile($db),
        ]);
        $result = parent::execute($db);
        Log::application()->debug('SQL_END');
        return $result;
    }
}
