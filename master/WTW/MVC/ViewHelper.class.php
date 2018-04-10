<?php
namespace WTW\MVC;

/**
 * Description of ViewHelper
 *
 * @author marco
 */
class ViewHelper {
    //put your code here
    public static function generateFormToken($formKey)
    {
        (String) $html = '';
        $token = \WTW\Helpers\globalHelper::generateFormToken($formKey);
        
        $html .= '<input type="hidden" name="sess_token" value="' . $_SESSION['session_token'] . '">' . PHP_EOL;
        $html .= '<input type="hidden" name="form_token" value="' . $token . '">' . PHP_EOL;
        
        return $html;
    }
}
