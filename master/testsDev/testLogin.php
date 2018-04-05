<?php
ini_set("date.timezone", "Europe/Lisbon");
ini_set("display_errors", '1');
session_start();
session_regenerate_id();

require_once('../constants.php');
die('test login END!');
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
    
    die('testes de login');
} catch (Exception $e) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($e);
}
    
