<?php
ini_set("date.timezone", "Europe/Lisbon");
ini_set("display_errors", '1');
session_start();
session_regenerate_id();

try {
    // librarys to include
    require_once('vendor/autoload.php');
    require_once('constants.php');
    spl_autoload_register('WTW\helpers\globalHelper::autoloadClasses');
    \WTW\error\mbfErrorHandler::setDebugMode(DEBUG_MODE);
    set_error_handler('\WTW\error\mbfErrorHandler::errHandlerPHP');
    
    // controller / action parameters
    $inputs = new \WTW\Helpers\inputParameters();
    $inputs->addItem(new \WTW\Helpers\inputParam(
            'controller',
            \WTW\Helpers\Input::INPUT_GET,
            \WTW\Helpers\Input::TYPE_METHOD
        ), 'controller'
    );
    $inputs->addItem(new \WTW\Helpers\inputParam(
            'action',
            \WTW\Helpers\Input::INPUT_GET,
            \WTW\Helpers\Input::TYPE_METHOD
        ), 'action'
    );
    
    // list of validate inputs
    $valideInputs = $inputs->listValidatedItens();
    
    // call the controller
    $controller = new \WTW\MVC\Controller(
            $valideInputs->controller['validatedValue'],
            $valideInputs->action['validatedValue']
    );
    $controller->setAuthorizedInputs($inputs);
    $content = $controller->run();
    
    $inputsAfter = $controller->getAuthorizedInputs();
    
    // only authorized parameters
    $inputsAfter->checkSentParameters();

    echo $content;
    
    
} catch (Exception $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
} catch (ArgumentCountError $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
} catch (DivisionByZeroError $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
} catch (\WTW\error\KeyHasUseException $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
} catch (\WTW\error\KeyInvalidException $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
} catch (\WTW\Error\InputParamsException $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
} catch (\WTW\Error\ControllerException $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
} catch (\WTW\Error\FilterException $ex) {
    \WTW\error\mbfErrorHandler::errHandlerTryCatch($ex);
}
