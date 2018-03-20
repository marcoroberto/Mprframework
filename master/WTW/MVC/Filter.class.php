<?php
namespace WTW\MVC;

/**
 * Description of Filter
 *
 * @author marco
 */
class Filter {
    protected $key = '';
    protected $callable = '';
    protected $params = array();
    
    private $acceptedKeys = array(
        'AUTHORIZE',
        'ACTION',
        'RESULT',
        'CACHE'
    );
    
    private $acceptedActions = array(
        'actionBefore',
        'actionAfter'
    );
    
    public function __construct($key, $callable = '', $params = array())
    {
        $this->setKey($key);
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
    
    public function run(\WTW\MVC\Controller $objController)
    {
        $res = null;
        
        if (empty($this->key)) {
            throw new \WTW\error\FilterException('Filter:: filter method Filter->run, key can\'t be empty!');
        }
        
        switch ($this->key) {
            case 'AUTHORIZE':
                $res = $this->runAuthorize($objController, $this->params);
                break;
            case 'ACTION':
                break;
            case 'RESULT':
                break;
            case 'CACHE':
                break;
            default:
                throw new \WTW\error\FilterException('Filter:: filter method Filter->run, key ' . $this->key . ' not valid!');
                break;
        }
        echo $this->key;die();
        echo \WTW\Helpers\GlobalHelper::showDebug($objController);
        die();
        
        return $res;
    }
    
    protected function runAuthorize(\WTW\MVC\Controller $objController, array $params)
    {
        
        $logged = \WTW\Identity\Login::hasLogin();
        
        
    }
}
