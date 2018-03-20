<?php

class Home extends \WTW\MVC\Controller {
    
    public function Main() : string
    {
        (string) $result = '';
        
        $this->addAuthorizedItem(new WTW\Helpers\inputParam(
                'id',
                \WTW\Helpers\Input::INPUT_GET,
                \WTW\Helpers\Input::TYPE_INT,
                \WTW\Helpers\Input::SANITIZE_NUMBER_INT,
                \WTW\Helpers\Input::VALIDATE_INT
            ), 'id'
        );
        
        $result = $this->renderView();
        
        return $result;
    }
    
    public function Xpto() : string
    {
        (string) $result = '';
        
        // test manual model
        
        
        // test manual view
        $path = \WTW\Helpers\globalHelper::normalizePath(PATH_VIEWS . 'home/xpto.php');
        $result = $this->renderView($path);

        return $result;
    }
    
    public function Xpto1Filters() : \WTW\MVC\FilterCollection
    {
        $obj = new \WTW\MVC\FilterCollection();
        $obj->addItem(new \WTW\MVC\Filter('AUTHORIZE'));
        
        $params = array('obj' => $this->data);
        $obj->addItem(new \WTW\MVC\Filter('ACTION', '\WTW\Helpers\globalHelper::testFilterBefore', $params));
        
        $obj->addItem(new \WTW\MVC\Filter('RESULT', '\WTW\Helpers\globalHelper::testFilterAfter', $params));
        
        $obj->addItem(new \WTW\MVC\Filter('CACHE', '20'));
        
        return $obj;
    }
    public function Xpto1() : string
    {
        (string) $result = '';
        
        $result = $this->renderView();
        return $result;
    }
}
