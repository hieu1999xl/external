<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * PHPMailerを利用したメールドライバー拡張基底クラス
 * TODO HTMLメールにはヘルパークラス含めて未対応
 *
 * @package    Fuel
 * @version    1.8
 * @author     sakairi@liz-inc.co.jp
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

use PHPMailer\PHPMailer\PHPMailer;

abstract class Email_Driver_Base extends \Email_Driver
{
    /**
     * @var PHPMailer\PHPMailer\PHPMailer
     */
    protected  $mailer = null;

    /**
     * @var string
     */
    protected $char_set;

    /**
     * Driver constructor
     *
     * @param	array	$config		driver config
     */
    public function __construct(array $config)
    {
        $this->mailer = new PHPMailer();
        $this->mailer->isHTML(false); // TODO HTMLメールには非対応
        // 文字化け対策で文字コードと変換方式は固定で設定する
        $this->mailer->CharSet =  PHPMailer::CHARSET_UTF8;
        $this->mailer->Encoding =  PHPMailer::ENCODING_BASE64;
        // メールソフトの情報を表示するヘッダーをマスキングする
        $this->mailer->XMailer  =  ' ';
        parent::__construct($config);
    }

    /**
     * Sets the body
     *
     * @param  string  $body  The message body
     *
     * @return  $this
     */
    public function body($body)
    {
        // TODO HTMLメールには非対応
        $this->mailer->Body = (string) $body;

        return $this;
    }

    /**
     * Sets the alt body
     *
     * @param   string  $alt_body  The message alt body
     *
     * @return  $this
     */
    public function alt_body($alt_body)
    {
        $this->mailer->AltBody = (string) $alt_body;

        return $this;
    }

    /**
     * Sets the message subject
     *
     * @param   string  $subject     The message subject
     *
     * @return  $this
     */
    public function subject($subject)
    {
        $this->mailer->Subject = $subject;

        return $this;
    }

    /**
     * Sets the from address and name
     *
     * @param   string      $email  The from email address
     * @param   bool|string $name   The optional from name
     *
     * @return  $this
     */
    public function from($email, $name = false)
    {
        $email = (string) $email;
        $name = (is_string($name)) ? $name : "";

        $this->mailer->setFrom($email, $name);

        return $this;
    }

    /**
     * Add to the to recipients list.
     *
     * @param   string|array    $email  Email address or list of email addresses, array(email => name, email)
     * @param   string|bool     $name   Recipient name, false, null or empty for no name
     *
     * @return  $this
     */
    public function to($email, $name = false)
    {
        return $this->_to('addAddress', $email, $name);
    }

    /**
     * Add to the cc recipients list.
     *
     * @param string|array    $email
     * @param string|bool     $name
     */
    public function cc($email, $name = false)
    {
        return $this->_to('addCC', $email, $name);
    }

    /**
     * Add to the bcc recipients list.
     *
     * @param string|array    $email
     * @param string|bool     $name
     */
    public function bcc($email, $name = false)
    {
        return $this->_to('addBCC', $email, $name);
    }

    /**
     * Add to the 'reply to' list.
     *
     * @param   string|array    $email  Email address or list of email addresses, array(email => name, email)
     * @param   string|bool     $name   The name, false, null or empty for no name
     *
     * @return  $this
     */
    public function reply_to($email, $name = false)
    {
        return $this->_to('addReplyTo', $email, $name);
    }

    /**
     * Add to the 'PHPMailer to' list.
     *
     * @param   string            $method PHPMailer method name to call
     * @param   string|array    $email  Email address or list of email addresses, array(email => name, email)
     * @param   string|bool     $name   The name, false, null or empty for no name
     *
     * @return  $this
     */
    private function _to($method, $email, $name = false)
    {
        if ( ! is_array($email))
        {
            $email = (string) $email;
            $name = (is_string($name)) ? $name : "";

            $this->mailer->$method($email, $name);
        } else {
            foreach ($email as $_email => $name)
            {
                if (is_numeric($_email))
                {
                    $email = (string) $name;
                    $name = "";
                } else {
                    $email = (string) $_email;
                    $name = (string) $name;
                }

                $this->mailer->$method($email, $name);
            }
        }

        return $this;
    }

    /**
     * Attaches a file to the email. This method will search for the file in the attachment paths set (config/email.php) in the attach_paths array
     *
     * @param   string  $file   The file to attach
     * @param   bool    $inline Whether to include the file inline
     * @param   string  $cid    The content identifier. Used when attaching inline images
     * @param   string  $mime   The file's mime-type
     * @param   string  $name   The attachment's name
     *
     * @throws \InvalidAttachmentsException Could not read attachment or attachment is empty
     *
     * @return  $this
     */
    public function attach($file, $inline = false, $cid = null, $mime = null, $name = null)
    {
        if (Helper_File::is_exist_file($file) === false)
        {
            throw new \InvalidAttachmentsException('Could not read attachment or attachment is empty: '. $file);
        }

        $attachment_name = is_null($name) ? "" : $name;
        $type = is_null($mime) ? "" : $mime;
        $disposition = ($inline) ? 'inline' : 'attachment';

        $this->mailer->addAttachment($file, $attachment_name, PHPMailer::ENCODING_BASE64, $type, $disposition);

        return $this;
    }

    /**
     * Initiates the sending process.
     *
     * @param   bool    Whether to validate the addresses, falls back to config setting
     *
     * @return  bool
     */
    public function send($validate = null)
    {
        $this->_send();

        return true;
    }

}
