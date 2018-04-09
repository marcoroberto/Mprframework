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
            Throw new Exception('Identity\Login: parameter username is necessary!');
        }
        
        if (empty($inputs->password['validatedValue'])) {
            Throw new Exception('Identity\Login: parameter password is necessary!');
        }
        
        if (empty($inputs->token['validatedValue'])) {
            Throw new Exception('Identity\Login: parameter token is necessary!');
        }
        
    }
}
