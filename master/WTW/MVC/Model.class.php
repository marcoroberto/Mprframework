<?php
namespace WTW\MVC;

/**
 * Description of Model
 *
 * @author marco
 */
class Model {
    protected $controller;
    protected $action;
    protected $path;
    protected $data;
    
    public function __construct($controller, $action)
    {
        $this->setController($controller);
        $this->setAction($action);
        $this->setPath();
        
        if ($this->checkModel()) {
            require_once($this->getPath());
            $className = '\\WTW\\MVC\\Model' . $this->getController();
            if (class_exists($className)) {
                $obj = new $className();
                $methodName = $this->getAction();
                if (method_exists($obj, $methodName)) {
                    $obj->$methodName();
                    $this->setData($obj->data);
                }
            }
            
            return $this->getData();
        }
    }
    
    protected function setController($value)
    {
        $this->controller = $value;
    }
    
    public function getController()
    {
        return $this->controller;
    }
    
    protected function setAction($value)
    {
        $this->action = $value;
    }
    
    protected function setPath()
    {
        $this->path = \WTW\Helpers\globalHelper::normalizePath(
                PATH_ROOT . DIRECTORY_SEPARATOR . MODEL_FOLDER . DIRECTORY_SEPARATOR
        ) . $this->getController() . '.class.php';
        
    }
    
    public function getPath()
    {
        return $this->path;
    }
    
    public function getAction()
    {
        return $this->action;
    }
    
    protected function setData($obj)
    {
        if (is_object($obj)) {
            $this->data = $obj;
        } else {
            $this->data = new \stdClass();
        }
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    protected function checkModel()
    {
        if (file_exists($this->getPath())) {
            return true;
        }
        
        return false;
    }
}
