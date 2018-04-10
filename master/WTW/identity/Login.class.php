<?php
namespace WTW\Identity;
/**
 * Description of Login
 *
 * @author marco
 */
class Login {
    
    public static function hasLogin()
    {
        return true;
    }
    
    public function checkSigninData($inputs = array())
    {
        if (empty($inputs->username['validatedValue'])) {
            Throw new \Exception('Identity\Login: parameter username is necessary!');
        }
        
        if (empty($inputs->password['validatedValue'])) {
            Throw new \Exception('Identity\Login: parameter password is necessary!');
        }
        
        if (empty($inputs->sess_token['validatedValue'])) {
            Throw new \Exception('Identity\Login: parameter sess_token is necessary!');
        }
        
        if (empty($inputs->form_token['validatedValue'])) {
            Throw new \Exception('Identity\Login: parameter form_token is necessary!');
        }
        
        $tokenPosted = $inputs->form_token['validatedValue'];
        $valid = \WTW\Helpers\GlobalHelper::checkFormToken('signin', $tokenPosted);
        if (!$valid) {
            throw new \Exception('Identity|login: Form token is invalid!');
        }
        
        
    }
}
