<?php
namespace WTW\error;

/**
 * Description of mbfErrorHandler
 *
 * @author marco361
 */
class mbfErrorHandler {
    const ERROR_LOG_FILE = 'mbf_error_log.err';
    const ENV = 'web';
    
    const ERROR_INPUT = 'INPUT';
            
    protected static $debugMode = false;
    protected static $errorFilePath;
    protected static $env;
    
    protected static function setENV($value = '') {
        if ($value == '') {
            if (defined('ENV')) {
                self::$env = strtolower(ENV);
            } else {
                self::$env = strtolower(self::ENV);
            }
        } else {
            self::$env =  strtolower('web');
        }
    }
    
    public static function setDebugMode($value)
    {
        if (is_bool($value)) {
            self::$debugMode = $value;
        }
    }
    
    public function getDebugMode()
    {
        return self::$debugMode;
    }
    
    public static function errHandlerPHP($errno , $errstr , $errfile, $errline, $errcontext)
    {
        // build the error message to pass it to errHandlerTryCatch
        $message = 'ERROR ' . $errno . ': ' . $errstr . ' on ' . $errfile . ' line ' . $errline;
        $ex = new \Exception($message, true);
        $ex->originalContext = $errcontext;
        self::errHandlerTryCatch($ex);        
    }
    
    public static function errHandlerTryCatch($objError, $fromPHP = false)
    {
        self::setENV();
        
        // writes the error the error log file
        self::writeToLog($objError);
                
        // line separator for screen presenting purposes
        $phpEol = PHP_EOL;
        if (self::$env === 'web') {
            $phpEol = '<br>' . PHP_EOL;
        }
        
        // send warning email
        if (defined('SERVER') && SERVER === 'PRO') {
            self::sendErrorByEmail($objError);
        }

        // show on screen, for development
        if (self::$debugMode) {
            echo $objError->getMessage() . $phpEol;
            if ($fromPHP) {
                echo '--originalContext: (set_error_handler)' . $phpEol;
                echo \WTW\Helpers\globalHelper::showDebug($objError->originalContext);
            } else {
                echo '--getTrace: (try catch block)' . $phpEol;
                echo \WTW\Helpers\globalHelper::showDebug($objError->getTrace());
            }
            die();
        }
        
    }
    
    public static function writeToLog($objError)
    {
        if (!defined('PATH_ERRORS')) {
            self::$errorFilePath = __DIR__ . DIRECTORY_SEPARATOR . self::ERROR_LOG_FILE;
        } else {
            self::$errorFilePath = PATH_ERRORS;
        }
        
        // checks if path exists
        $dir = dirname(self::$errorFilePath);
        if (!file_exists($dir)) {
            die('Log file folder error: folder ' . $dir . ' doesn\'t exists!');
        }
        
        // checks if file exists
        if (!file_exists(self::$errorFilePath)) {
            // trys to create the file
            if (file_put_contents(self::$errorFilePath, '') === false) {
                die('Log file error: can\'t create file ' . self::$errorFilePath . ', check permissions!');
            }
        }
        
        // adds the message to the error log file
        $objDate = new \DateTime();
        $varDateTime = $objDate->format('Y-m-d H:i:s');
        $message = $varDateTime . '____________' . PHP_EOL . $objError->getMessage();
        if (file_put_contents(self::$errorFilePath, $message . PHP_EOL . PHP_EOL, FILE_APPEND) === false) {
            die('Log file error: can\'t write on file ' . self::$errorFilePath . ', check permissions!');
        }
        
    }
    
    protected static function sendErrorByEmail($objError)
    {
        if (!is_a($objError, 'Exception')) {
            die('Log error: wrong type of type passed to sendErrorByEmail, should be Exception!');
        }
        
        $message = $objError->getMessage();
        if (isset($objError->originalContext)) {
            $message .= '--originalContext: (set_error_handler)' . PHP_EOL;
            $message .= \WTW\Helpers\globalHelper::showDebug($objError->originalContext);            
        } else {
            $message .= '--getTrace: (try catch block)' . PHP_EOL;
            $message .= \WTW\Helpers\globalHelper::showDebug($objError->getTrace());            
        }
        
        \WTW\Helpers\globalHelper::sendEmail(array(), array(), array(), 'MBF Error found.', $message);
    }
    
    public static function suspendErrors($errno , $errstr , $errfile, $errline, $errcontext)
    {
        return '';
    }
}
