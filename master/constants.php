<?php
define('ENV', 'web');
define('SERVER', 'DEV'); // DEV, UAT, CAT, PROk
define('CHARSET', 'iso-8859-1');

require_once('WTW\helpers\globalHelper.class.php');

$pathThis = \WTW\Helpers\globalHelper::normalizePath(__DIR__);
$pathWebRoot = \WTW\Helpers\globalHelper::normalizePath(realpath(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT')));
$appRelativePath = \WTW\Helpers\globalHelper::getAppPath($pathWebRoot, $pathThis);

define('FILTER_VALIDATE_STRING', '');

if (!defined('PATH_ROOT')) {
    define('PATH_ROOT', $pathThis);
}

if (!defined('PATH_FROM_WEB_ROOT')) {
    define('PATH_FROM_WEB_ROOT', $appRelativePath);
}

if (!defined('PATH_ERRORS')) {
    define('PATH_ERRORS', $pathThis . '/logs/mbf_error_log.err');
}

if (!defined('URL_RELATIVO')) {
    define('URL_RELATIVO', '');
}

define('LIBRARY_FOLDER', 'WTW/');

define('DEBUG_MODE', true);

// e-mail constants
//define('SMTP_SERVER','smtp-em1.towerswatson.com');
define('SMTP_SERVER','localhost');
define('SMTP_SERVER_PORT','25');
define('SMTP_SERVER_USERNAME','');
define('SMTP_SERVER_PASSWORD','');
define('SMTP_SERVER_SECURE','');
define('SMTP_SERVER_AUTH',false);
define('EMAIL_REPLY','marco.roberto@casagr.com');
define('EMAIL_REPLY_NAME','MPR Framework');
define('EMAIL_FROM', 'marco.roberto@casagr.com');
define('EMAIL_FROM_NAME', 'MPR Framework');
define('EMAIL_TO_EMAIL', 'marco.roberto@casagr.com');
define('EMAIL_TO_NAME', 'Marco Roberto');
define('EMAIL_ALLOW_SEND', true);

// controllers
define('CONTROLLER_DEFAULT', 'Home');
define('CONTROLLER_DEFAULT_ACTION', 'main');
define('CONTROLLERS_FOLDER', 'Controllers');
define('MODEL_FOLDER', 'Models');
define('VIEW_FOLDER', 'Views');
define('PATH_VIEWS', PATH_ROOT . DIRECTORY_SEPARATOR . VIEW_FOLDER . DIRECTORY_SEPARATOR);

// identity
define('LOGIN_FORWARD', 'errors/login.php');