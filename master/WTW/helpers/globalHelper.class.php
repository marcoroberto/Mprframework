<?php
namespace WTW\Helpers;
/**
 * Description of globalHelper
 *
 * @author marco361
 */
class globalHelper {
    public static function autoloadClasses($className)
    {
        $className1 = preg_replace('/\\\/', '/', $className);
        $fileName = URL_RELATIVO . $className1 . '.class.php';

        if (is_readable($fileName)) {
            require_once($fileName);
        }
    }
    
    public static function showDebug($var, $previousStr='', $afterStr='', $pre=1)
    {
        $res = "";
        
        $res .= $previousStr;
        if ($pre==1) {$res .= "<pre>";}
        
        if (is_object($var) || is_array($var)) {
            $res .= print_r($var,1);
        } else {
            $res .= $var;
        }
        
        if ($pre==1) {$res .= "</pre>";}
        $res .= $afterStr;
        
        return ($res);        
    }

    public static function normalizePath($value)
    {
        $result = $value;

        if (!empty($value)) {
            // replace \ with /
            $result = str_replace('\\\\', '/', $value);
            $result = str_replace("\\", "/", $result);
            $result = str_replace('/../', '', $result);
            $result = str_replace('../', '', $result);

            // realpath
            $path = realpath($result);

            if (!is_readable($result)) {
                throw new \Exception('Path ' . $result . ' is not a valid path or is not accessible!');
            }

            // make sure the last char is /
            $lastChar = substr($result, -1);
            if ($lastChar !== '/') {
                $result .= '/';
            }

        }

        return $result;
    }
    
    public static function sendEmail(
        $paramTo = array(),
        $paramCc = array(),
        $paramBcc = array(),
        $paramSubject = '',
        $paramMessage = '',
        $paramAltBody = '',
        $paramAttach = array(),
        $paramIsHtml = true
    )
    {
        $res = true;
        
        $objMail = new \PHPMailer\PHPMailer\PHPMailer(); // debug off
        $objMail->CharSet = 'UTF-8';
        $objMail->SMTPDebug = false;
        $objMail->isSMTP();
        
        $objMail->Host = SMTP_SERVER;  // Specify main and backup SMTP servers
        $objMail->Encoding = 'base64';        
        $objMail->SMTPAuth = SMTP_SERVER_AUTH;                   // Enable SMTP authentication
        $objMail->Username = SMTP_SERVER_USERNAME;               // SMTP username
        $objMail->Password = SMTP_SERVER_PASSWORD;               // SMTP password
        $objMail->SMTPSecure = SMTP_SERVER_SECURE;               // Enable TLS encryption, `ssl` also accepted
        $objMail->Port = SMTP_SERVER_PORT;                       // TCP port to connect to

        //Recipients
        $objMail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME);
        
        // Destination
        $toSend = false;
        if (!empty($paramTo)) {
            foreach ($paramTo as $key => $to) {
                if (isset($to['email'])) {
                    if (self::validateEmail($to['email'])) {
                        $toName = (isset($to['name'])) ? $to['name'] : '';
                        $objMail->addAddress($to['email'], $toName);
                        $toSend = true;
                    }
                }
            }
        } else {
            if (defined('EMAIL_TO_EMAIL') && EMAIL_TO_EMAIL!='') {
                $objMail->addAddress(EMAIL_TO_EMAIL, EMAIL_TO_NAME);     // Add a recipient
                $toSend = true;
            }
        }
        if ($toSend === false) {
            throw new \Exception('Error sending email: no valid destination email!');
        }
        
        // reply to
        $objMail->addReplyTo(EMAIL_REPLY, EMAIL_REPLY_NAME);
        
        // CC
        if (is_array($paramCc) && !empty($paramCc)) {
            foreach ($paramCc as $key => $cc) {
                if (isset($cc['email'])) {
                    if (self::validateEmail($cc['email'])) {
                        $toName = (isset($cc['name'])) ? $cc['name'] : '';
                        $objMail->addCC($cc['email'], $toName);
                    }
                }                
            }
        }
        
        // BCC
        if (is_array($paramBcc) && !empty($paramBcc)) {
            foreach ($paramBcc as $key => $bcc) {
                if (isset($bcc['email'])) {
                    if (self::validateEmail($bcc['email'])) {
                        $toName = (isset($bcc['name'])) ? $bcc['name'] : '';
                        $objMail->addBCC($bcc['email'], $toName);
                    }
                }                
            }
        }

        //Attachments
        if (is_array($paramAttach) && !empty($paramAttach)) {
            foreach ($paramAttach as $file) {
                if (file_exists($file)) {
                    $objMail->addAttachment($file);
                }
            }
        }

        //Content
        $objMail->isHTML($paramIsHtml);                          // Set email format to HTML
        $objMail->Subject = $paramSubject;
        if ($paramIsHtml) {
            $objMail->MsgHTML($paramMessage);
        } else {
            $objMail->Body = $paramMessage;
        }
        $objMail->AltBody = $paramAltBody;
        
        // test smtp connectivity
        if (defined("EMAIL_ALLOW_SEND") && EMAIL_ALLOW_SEND) {
            // test smtp connectivity
            $timeout = 30; // your own timeout value
            $connection_type = 'tcp'; // may be ssl, sslv2, sslv3 or tls
            $host = SMTP_SERVER;
            $port = SMTP_SERVER_PORT;
            set_error_handler('WTW\error\mbfErrorHandler::suspendErrors');
            $errno = 0;
            $errstr = '';
            $fp = stream_socket_client("{$connection_type}://{$host}:{$port}", $errno, $errstr, $timeout);
            restore_error_handler();
            if (!$fp) {
                $objError = new \Exception('Error sending email: error connectiong to smtp ' . SMTP_SERVER . '!');
                \WTW\error\mbfErrorHandler::writeToLog($objError);
            } else {
                if ($objMail->send()) {
                    $res = true;
                } else {
                    $res = false;
                    throw new \Exception('Error sending email: error trying to send email!');
                }
            }
        }
        return $res;
    }
    
/**
     * This validator checks if the $value is a valid email address.
     * @param string $value The data value to be validated.
     * @param array $arrOptions The validator options:
     * <ul>
     * <li><b>label</b>: (string) the value label.</li>
     * <li><b>allowName</b>: (boolean) whether to allow name in the email address
     * (e.g. "John Smith <john.smith@example.com>"). Defaults to <b>false</b>.</li>
     * <li><b>checkDNS</b>: (boolean)  whether to check whether the email's domain exists and has either an A or MX record.
     * Be aware that this check may fail due to temporary DNS problems, even if the email address is actually valid.
     * Defaults to <b>false</b>.</li>
     * <li><b>enableIDN</b>: (boolean) whether the validation process should take into account IDN (internationalized domain names).
     * Defaults to <b>false</b> meaning that validation of emails containing IDN will always fail.
     * Note that in order to use IDN validation you have to install and enable the intl PHP extension, or an exception would be thrown.</li>
     * <li><b>pattern</b>: (string) the regular expression used to validate the $value. Defaults to <b>null</b> meaning
     * the internal pattern will be used
     * </li>
     * <li><b>fullPattern</b>: (string) the regular expression used to validate email addresses with the name part.
     * This property is used only when [[allowName]] is <b>true</b>.</li>
     * <li><b>message</b>: (string) The user-defined error message.</li>
     * </ul>
     * @return array Return an associative array with the following elements:
     * <ul>
     * <li><b>valid</b>: (boolean) this will be <b>true</b> whether $value is a valid email address, otherwise will be <b>false</b></li>
     * <li><b>message</b>: (string) the user-defined error message. Only take in attention if the [[valid]] is <b>false</b></li>
     * <ul>
     * @see http://www.regular-expressions.info/email.html
     * @throws Exception Throw an exception if the option [[enableIDN]] is sets to <b>enableIDN</b> and intl extension is not installed or enabled.
     */
    public static function validateEmail($value, $arrOptions=array())
    {
        $arrMergedOptions = array_merge(
            array(
                'label' => '',
                'allowName' => false,
                'checkDNS' => false,
                'enableIDN' => false,
                'pattern' => null,
                'fullPattern' => null,
                'message' => null
            ),
            $arrOptions
        );

        if ($arrMergedOptions['enableIDN'] && !function_exists('idn_to_ascii')) {
            throw new Exception('In order to use IDN validation intl extension must be installed and enabled.');
        }

        if ($arrMergedOptions['pattern'] === null) {
            $arrMergedOptions['pattern'] = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
        }

        if ($arrMergedOptions['fullPattern'] === null) {
            $arrMergedOptions['fullPattern'] = '';
        }

        if ($arrMergedOptions['message'] === null) {
            $arrMergedOptions['message'] = '{label} is not a valid email address.';
        }
        $arrMergedOptions['message'] = str_replace('{label}', $arrMergedOptions['label'], $arrMergedOptions['message']);

        $valid = false;
        $matches = array();
        // make sure string length is limited to avoid DOS attacks
        if (!is_string($value) || strlen($value) >= 320) {
            $valid = false;
        } elseif (!preg_match('/^(.*<?)(.*)@(.*)(>?)$/', $value, $matches)) {
            $valid = false;
        } else {
            $domain = $matches[3];
            if ($arrMergedOptions['enableIDN']) {
                $value = $matches[1] . idn_to_ascii($matches[2]) . '@' . idn_to_ascii($domain) . $matches[4];
            }
            $valid = preg_match($arrMergedOptions['pattern'], $value) || $arrMergedOptions['allowName'] && preg_match($arrMergedOptions['fullPattern'], $value);
            if ($valid && $arrMergedOptions['checkDNS']) {
                $valid = checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A');
            }
        }
        return array(
            'valid' => $valid,
            'message' => $arrMergedOptions['message']
        );
    }

    public static function fileSizeUnits($bytes, $format = 'MB')
    {
        $res = 0;
        switch (strtoupper($format)) {
            case 'GB':
                $res = $bytes / 1073741824;
                break;
            case 'MB';
                $res = $bytes / 1048576;
                break;
            case 'KB':
                $res = $bytes / 1024;
                break;
            case 'BYTES':
                $res = $bytes;
                break;
            default:
                $res = 0;
                break;
        }
        return $res;
    }
    
    public static function validateTest($args = array())
    {
        return true;
    }
    
    public static function testFilterBefore($params = array())
    {
        echo showDebug($params['obj']);
    }

    public static function testFilterAfter($params = array())
    {
        echo showDebug($params['obj']);
    }
    
}
