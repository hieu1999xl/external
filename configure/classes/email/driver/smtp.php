<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 * SMTP を利用したメールドライバー拡張クラス
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */


class Email_Driver_Smtp extends Email_Driver_Base
{

    /**
     * Initalted all needed for AWS SES mailing.
     *
     * @throws \AwsException     Failed sending email through SES
     *
     * @return  bool    Success boolean
     */
    protected function _send()
    {
        // AWS SES setting
        $config = Config::get('email.defaults.smtp');

        // SMTP Settings
        $this->mailer->IsSMTP();
        if (!empty($config['username']) and !empty($config['password'])) {
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $config['username'];
            $this->mailer->Password = $config['password'];
        } else {
            $this->mailer->SMTPAuth    = false;
        }
        if (Fuel::$env === Fuel::PRODUCTION) {
            $this->mailer->SMTPDebug = 2;
        }
        $this->mailer->Host = $config['host'];
        $this->mailer->Port = $config['port'];
        $this->mailer->Timeout = $config['timeout'];

        // Attempt to assemble the above components into a MIME message.
        if ($this->mailer->Send()) {
            return true;
        } else {
            $message = $this->mailer->ErrorInfo;
            Log::application()->warn("The email was not sent other readon. Error message: ".$message);
            throw new \Exception($message);
        }
    }
}
