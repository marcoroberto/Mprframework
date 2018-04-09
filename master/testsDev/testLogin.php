<?php
ini_set("date.timezone", "Europe/Lisbon");
ini_set("display_errors", '1');
session_start();
session_regenerate_id();

try {    
    define('URL_RELATIVO', '../');
    require_once('../constants.php');
    require_once('../vendor/autoload.php');
    require_once('../constants.php');
    spl_autoload_register('WTW\helpers\globalHelper::autoloadClasses');
    WTW\error\mbfErrorHandler::setDebugMode(DEBUG_MODE);
    set_error_handler('WTW\error\mbfErrorHandler::errHandlerPHP');
    
    // authorized inputs collection
    $inputs = new \WTW\Helpers\inputParameters();
    $inputs->addItem(new \WTW\Helpers\inputParam(
            'controller',
            \WTW\Helpers\Input::INPUT_BOTH,
            \WTW\Helpers\Input::TYPE_METHOD
        ), 'controller'
    );
    $inputs->addItem(new \WTW\Helpers\inputParam(
            'action',
            \WTW\Helpers\Input::INPUT_BOTH,
            \WTW\Helpers\Input::TYPE_METHOD
        ), 'action'
    );
    
    // list of validate inputs
    $valideInputs = $inputs->listValidatedItens();
    
    // call the controller
    (string) $cont = 'Login';
    (string) $act = 'LoginForm';
    
    if (!empty($valideInputs->controller['validatedValue'])) {
        $cont = $valideInputs->controller['validatedValue'];
    }
    if (!empty($valideInputs->action['validatedValue'])) {
        $act = $valideInputs->action['validatedValue'];
    }
    
    $controller = new \WTW\MVC\Controller(
            $cont,
            $act
    );
    $controller->setAuthorizedInputs($inputs);
    $content = $controller->run();    
    $inputsAfter = $controller->getAuthorizedInputs();
    
    // only authorized parameters
    $inputsAfter->checkSentParameters();
    
    echo $content;
    die();
} catch (Exception $e) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($e);
}
    
