<?php
class Login extends \WTW\MVC\Controller {
    
    public function loginForm() : string
    {
        /*
        $this->addAuthorizedItem(new WTW\Helpers\inputParam(
                'id',
                \WTW\Helpers\Input::INPUT_GET,
                \WTW\Helpers\Input::TYPE_INT,
                \WTW\Helpers\Input::SANITIZE_NUMBER_INT,
                \WTW\Helpers\Input::VALIDATE_INT
            ), 'id'
        );
        */
        (string) $result = $this->renderView();
        return $result;
    }
    
    public function signin()
    {
        (Boolean) $result = false;
        die('__');
        // authorized inputs
        $this->addAuthorizedItem(new WTW\Helpers\inputParam(
                'username',
                \WTW\Helpers\Input::INPUT_POST,
                \WTW\Helpers\Input::TYPE_STRING,
                \WTW\Helpers\Input::SANITIZE_STRING,
                \WTW\Helpers\Input::VALIDATE_STRING
            ), 'username');
        
        
        return $result;
    }
    
}