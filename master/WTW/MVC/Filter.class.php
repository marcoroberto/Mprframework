<?php
namespace WTW\MVC;

/**
 * Description of Filter
 *
 * @author marco
 */
class Filter {
    protected $key = '';
    protected $action = '';
    protected $callable = '';
    protected $params = array();
    
    private $acceptedKeys = array(
        'AUTHORIZE',
        'ACTION',
        'CACHE'
    );
    
    private $acceptedActions = array(
        'actionBefore',
        'actionAfter'
    );
    
    public function __construct($key, $action = '', $callable = '', $params = array())
    {
        $this->setKey($key);
        $this->setAction($action);
        $this->setCallable($callable);
        $this->setParams($params);
    }
    
    protected function setKey($value)
    {
        if (!in_array(strtoupper($value), $this->acceptedKeys)) {
            throw new \WTW\error\ControllerException('Action Filter:: key ' . $value . ' not allowed!');
        }
        
        $this->key = $value;
    }
    
    protected function setAction($value)
    {
        if ($this->__get('key') == 'ACTION') {
            if (!in_array($value, $this->acceptedActions)) {
                throw new \WTW\error\ControllerException('Action Filter:: action ' . $value . ' not allowed!');
            }
        }
        $this->action = $value;
    }
    
    protected function setCallable($value)
    {
        if ($this->key != 'ACTION') {
            $this->callable = '';
            return null;
        }
        
        if (empty($value)) {
            throw new \WTW\error\ControllerException('Action Filter:: callable for ' . $this->__get('action') . ' can\'t be empty!');
        }
        
        // evaluate callable
        $strPos = strpos($value, '::');
        
        if ($strPos > 0) {
            // static method
            $method = new \ReflectionMethod( $value );
            if (!$method->isStatic()) {
                throw new \WTW\error\ControllerException('Action Filter:: callable ' . $value . ' not found!');
            }            
        } else {
            // isolated function
            if (!function_exists($value)) {
                throw new \WTW\error\ControllerException('Action Filter:: callable ' . $value . ' not found!');
            }
        }
        
        $this->callable = $value;
    }
    
    public function setParams($array)
    {
        if (!is_array($array)) {
            return null;
        }
        
        $this->params = $array;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function run($objController)
    {
        echo \WTW\Helpers\GlobalHelper::showDebug($objController);
        die();
    }
}
