<?php

use Monolog\Logger;

/**
 * ログハンドラークラス
 * 常に同一ファイルに出力するようにする為に拡張
 *
 * @author kunita
 *
 */
class Log_Handler extends \Monolog\Handler\RotatingFileHandler {

    public function __construct($filename, $maxFiles = 0, $level = Logger::DEBUG, $bubble = true) {
        parent::__construct($filename, $maxFiles, $level, $bubble);
        $this->nextRotation = $this->getRotateDatetime();

    }

    /**
     * ログファイルのローテート
     * 同一ファイルに吐くようにするため、ローテートを回避する様に日付をセット
     *
     * {@inheritdoc}
     *
     * @see \Monolog\Handler\RotatingFileHandler::rotate()
     */
    protected function rotate() {
        // update filename
        $this->url = $this->getTimedFilename();
        $this->nextRotation = $this->getRotateDatetime();

        // skip GC of old logs if files are unlimited
        if (0 === $this->maxFiles) {
            return;
        }

        $fileInfo = pathinfo($this->filename);
        $glob = $fileInfo['dirname'] . '/' . $fileInfo['filename'] . '-*';
        if (!empty($fileInfo['extension'])) {
            $glob .= '.' . $fileInfo['extension'];
        }
        $logFiles = glob($glob);
        if ($this->maxFiles >= count($logFiles)) {
            // no files to remove
            return;
        }

        // Sorting the files by name to remove the older ones
        usort($logFiles, function ($a, $b) {
            return strcmp($b, $a);
        });

        foreach (array_slice($logFiles, $this->maxFiles) as $file) {
            if (is_writable($file)) {
                unlink($file);
            }
        }

    }

    /**
     * ローテートの日付を返す
     *
     * @return DateTime
     */
    protected function getRotateDatetime() {
        $datetime = new DateTime();
        $time = $datetime->getTimestamp();
        $year = date('Y', $time);
        $month = date('n', $time);
        if ($month !== 12) {
            $month = $month + 1;
        } else {
            $year = $year + 1;
            $month = 1;
        }
        $date = date('d', $time);
        $datetime->setDate($year, $month, $date);
        $datetime->setTime(0, 0, 0);
        return $datetime;

    }

    /**
     * 常に同一ファイルに出力される様に対応(タイムスタンプの付与を除外)
     * override
     *
     * {@inheritdoc}
     *
     * @see \Monolog\Handler\RotatingFileHandler::getTimedFilename()
     */
    protected function getTimedFilename() {
        $fileInfo = pathinfo($this->filename);
        $timedFilename = $fileInfo['dirname'] . '/' . $fileInfo['filename'];
        if (!empty($fileInfo['extension'])) {
            $timedFilename .= '.' . $fileInfo['extension'];
        }
        return $timedFilename;

    }
}