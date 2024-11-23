<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 * AWS の SES を利用したメールドライバー拡張クラス
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

class Email_Driver_SES extends Email_Driver_Base
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
        $config = Config::get('ses');
        $client_param = [
            'credentials' => array(
                'key'       => $config['access_key'],
                'secret'    => $config['secret_key'],
            ),
            'region'    => $config['region'],
            'version'    => $config['version']
        ];

        $ses_client = SesClient::factory($client_param);

        // Attempt to assemble the above components into a MIME message.
        if (!$this->mailer->preSend()) {
            throw new \Exception($this->mailer->ErrorInfo);
        } else {
            // Create a new variable that contains the MIME message.
            $message = $this->mailer->getSentMIMEMessage();
        }

        try {
            $result = $ses_client->sendRawEmail([
                'RawMessage' => [
                    'Data' => $message
                ]
            ]);
            Log::application()->info("Email sent! Message ID: " . $result['MessageId']);
            return true;
        } catch (AwsException $e) {
            // output error message if fails
            Log::application()->warn("The email was not sent. Error message: ".$e->getAwsErrorMessage());
            throw $e;
        } catch (Exception $e){
            Log::application()->warn("The email was not sent other readon. Error message: ".$e->getMessage());
            throw $e;
        }
    }
}
