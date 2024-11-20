<?php

class Log_NativeMailHandler extends \Monolog\Handler\NativeMailerHandler
{

    /**
     * The sender of the mail
     *
     * @var string
     */
    protected $from;

    /**
     * send()時のfrom参照用にクラス変数に格納
     *
     * @Override
     * {@inheritdoc}
     *
     * @see \Monolog\Handler\NativeMailerHandler::__construct()
     */
    public function __construct($to, $subject, $from, $level = Logger::ERROR, $bubble = true, $maxColumnWidth = 70)
    {
        $this->from = $from;
        parent::__construct($to, $subject, $from, $level, $bubble, $maxColumnWidth);
    }

    /**
     *
     * @Override
     * {@inheritdoc}
     *
     * @see \Monolog\Handler\NativeMailerHandler::send()
     */
    protected function send($content, array $records)
    {
        foreach ($this->to as $to) {
            Helper_Mail::send_mail([
                'from' => $this->from,
                'to' => $to,
                'subject' => $this->subject,
                'body' => $content
            ]);
        }
    }
}