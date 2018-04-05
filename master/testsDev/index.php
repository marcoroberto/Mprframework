<?php
ini_set("date.timezone", "Europe/Lisbon");
ini_set("display_errors", '1');
session_start();
session_regenerate_id();

try {
    // librarys to include
    /*
    define('PATH_ROOT', 'C:/inetpub/wwwroot/framework/framework');
    define('PATH_FROM_WEB_ROOT', 'framework/framework/');
    define('PATH_ERRORS', 'C:/inetpub/wwwroot/framework/framework/logs/mbf_error_log.err');
     * 
     */
    define('URL_RELATIVO', '../');
    
    require_once('../vendor/autoload.php');
    require_once('../constants.php');
    spl_autoload_register('WTW\helpers\globalHelper::autoloadClasses');
    WTW\error\mbfErrorHandler::setDebugMode(DEBUG_MODE);
    set_error_handler('WTW\error\mbfErrorHandler::errHandlerPHP');
    
    // test email sending with phpmailer
    //\WTW\Helpers\tests::sendEmail('mroberto@teladigtal.pt', 'Marco Roberto');
    
    // request variables from query string or post
    $var = new WTW\Helpers\Input(
            'id',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_INT,
            WTW\Helpers\Input::SANITIZE_NUMBER_INT,
            WTW\Helpers\Input::VALIDATE_INT,
            array(
                'minValue' => 1,
                'maxValue' => 10
            )
    );

    $var1 = new WTW\Helpers\Input(
            'string',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_STRING,
            WTW\Helpers\Input::SANITIZE_STRING,
            null,
            array(
                'length' => 50,
                'regexp' => '^[A-Za-z ]*$'
            )
    );

    $var2 = new WTW\Helpers\Input(
            'boolean',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_BOOLEAN,
            null,
            WTW\Helpers\Input::VALIDATE_BOOLEAN
    );
    
    $email = new WTW\Helpers\Input(
            'email',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_EMAIL
    );
    
    $float = new WTW\Helpers\Input(
            'float',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_FLOAT,
            null,
            null,
            array(
                'minValue' => 120,
                'maxValue' => 130
            )
    );
    
    $ip = new WTW\Helpers\Input(
            'ip',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_IP,
            WTW\Helpers\Input::SANITIZE_STRING,
            WTW\Helpers\Input::VALIDADE_IP,
            array(
                'validateFlag' => FILTER_FLAG_IPV4
            )
    );
    
    $mac = new WTW\Helpers\Input(
            'mac',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_MAC,
            WTW\Helpers\Input::SANITIZE_STRING,
            WTW\Helpers\Input::VALIDATE_MAC
    );
    
    $regexp = new WTW\Helpers\Input(
            'regexp',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_REGEXP,
            WTW\Helpers\Input::SANITIZE_STRING,
            WTW\Helpers\Input::VALIDATE_REGEXP,
            array(
                'regexp' => '/^[A-Za-z]+$/'
            )
    );
    
    $url = new WTW\Helpers\Input(
            'url',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_URL,
            WTW\Helpers\Input::SANITIZE_URL,
            WTW\Helpers\Input::VALIDATE_URL,
            array(
                'validateFlag' => FILTER_FLAG_HOST_REQUIRED
            )
    );
    
    $whitelist = new WTW\Helpers\Input(
            'whitelist',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_WHITELIST,
            WTW\Helpers\Input::SANITIZE_STRING,
            null,
            array(
                'whitelist' => array('diogo', 'marco', 'sofia')
            )
    );
    
    $date = new WTW\Helpers\Input(
            'date',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_DATE
    );
    
    $datetime = new WTW\Helpers\Input(
            'datetime',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_DATETIME
    );
    
    $time = new WTW\Helpers\Input(
            'time',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_TIME
    );
    
    $callback = new WTW\Helpers\Input(
            'callback',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_CALLBACK,
            WTW\Helpers\Input::SANITIZE_STRING,
            null,
            array(
                'callable' => array('\WTW\Helpers\globalHelper', 'validateTest'),
                'args' => array('1')
            )
    );

    $image = new WTW\Helpers\Input(
            'imgs',
            WTW\Helpers\Input::INPUT_POST,
            WTW\Helpers\Input::TYPE_IMAGE
    );

    $files = new WTW\Helpers\Input(
            'files',
            WTW\Helpers\Input::INPUT_POST,
            WTW\Helpers\Input::TYPE_FILE
    );
    
    $data = new WTW\Helpers\Input(
            'data',
            WTW\Helpers\Input::INPUT_BOTH,
            WTW\Helpers\Input::TYPE_ARRAY,
            null,
            null,
            array('length' => 2)
    );
    
    $obj = $data;
    echo '<br><br>';
    echo 'var (int)=' . $var->getValidatedValue() . '<br>';
    echo 'var1 (string)=' . $var1->getValidatedValue() . '<br>';
    echo 'var2 (boolean)=' . $var2->getValidatedValue() . '<br>';
    echo 'email (email)=' . $email->getValidatedValue() . '<br>';
    echo 'ip (ip)=' . $ip->getValidatedValue() . '<br>';
    echo 'mac (mac)=' . $mac->getValidatedValue() . '<br>';
    echo 'regexp (regexp)=' . $regexp->getValidatedValue() . '<br>';
    echo 'url (url)=' . $url->getValidatedValue() . '<br>';
    echo 'whitelist (whitelist)=' . $whitelist->getValidatedValue() . '<br>';
    echo 'date (date)=' . $date->getValidatedValue() . '<br>';
    echo 'datetime (datetime)=' . $datetime->getValidatedValue() . '<br>';
    echo 'time (time)=' . $time->getValidatedValue() . '<br>';
    echo 'callback (callback)=' . $time->getValidatedValue() . '<br>';
    echo 'image (image)=' . \WTW\Helpers\globalHelper::showDebug($image->getValidatedValue()) . '<br>';
    echo 'files (files)=' . \WTW\Helpers\globalHelper::showDebug($files->getValidatedValue()) . '<br>';
    echo 'data (data)=' . \WTW\Helpers\globalHelper::showDebug($data->getValidatedValue()) . '<br>';
    
    echo '<br>';
    echo 'Var Name = ' . $obj->getVariableName() . ':<br>';
    echo 'Validated = ';
    var_dump($obj->getValidatedValue());
    echo '<br>';
    echo 'Posted = ';
    var_dump($obj->getRequestValue());
    echo '<br>';
    var_dump($obj->getIsValidMessage());
    echo '<br>';
    echo '<br>';
    /*
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    die();
    */
    //echo bcdiv(12, 0);
    echo '___done!___';
} catch (Exception $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
} catch (ArgumentCountError $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
} catch (DivisionByZeroError $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
} catch (KeyHasUseException $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
} catch (KeyInvalidException $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
}