<?php
namespace WTW\MVC;

/**
 * Description of Controller
 *
 * @author marco
 */
class Controller {
    protected $controller;
    protected $objController;
    protected $action;
    protected $data; // stores data from models
    protected $view; // template associated with the action
    
    protected $authorizedInputs;
    
    public function __construct($controller = '', $action = '')
    {
        $this->setController($controller);
        $this->setAction($action);
    }
    
    public function setController($value)
    {
        if (strlen($value) > 0) {
            $className = $this->parseToMethodName($value);

            $regexp = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';
            $tmp = filter_var($className, FILTER_VALIDATE_REGEXP, array('options'=>array('regexp' => $regexp)));

            if ($tmp === false) {
                throw new \Exception('Controller:: invalid controller name!');
            }
            
            $this->controller = $className;
        } else {
            // controller by default - home page
            $this->controller = CONTROLLER_DEFAULT;
        }
        
    }
    
    public function setAction($value)
    {
        if (strlen($value) > 0) {
            $actionName = $this->parseToMethodName($value);

            $regexp = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';
            $tmp = filter_var($actionName, FILTER_VALIDATE_REGEXP, array('options'=>array('regexp' => $regexp)));

            if ($tmp === false) {
                throw new \Exception('Controller:: invalid controller name!');
            }
            
            $this->action = $actionName;
        } else {
            // controller by default - home page
            $this->action = CONTROLLER_DEFAULT_ACTION;
        }
        
    }
    
    public function getController($controller = '', $action = '')
    {
        return $this->controller;
    }
    
    public function getAction()
    {
        return $this->action;
    }
    
    public function setView($value)
    {
        $this->view = $value;
    }
    
    public function getView()
    {
        return $this->view;
    }
    
    public function setAuthorizedInputs($itens)
    {
        if (!is_null($itens) && is_a($itens, '\WTW\Helpers\inputParameters')) {
            $this->authorizedInputs = $itens;
        }
        
    }
    
    public function getAuthorizedInputs()
    {
        return $this->authorizedInputs;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    protected function setData(\stdClass $obj)
    {
        $this->data = $obj;
    }
    
    public function run(string $controller = '', string $action = '')
    {
        $result = '';
        
        if (!empty($controller)) {
            $this->setController($controller);
        }
        
        if (!empty($action)) {
            $this->setAction($action);
        }
        
        // check for class existance
        $filename = \WTW\Helpers\globalHelper::normalizePath(
                PATH_ROOT . DIRECTORY_SEPARATOR . CONTROLLERS_FOLDER . DIRECTORY_SEPARATOR
        ) . $this->getController() . '.class.php';
        $this->checkControllerFile($filename);

        // checks class / method existance
        $this->checkControllerClass('\\' . $this->controller, $this->action);
        
        // model - gets data
        $objModel = new \WTW\MVC\Model($this->getController(), $this->getAction());
        $data = $objModel->getData();
        if (is_null($data)) {
            $data = new \stdClass();
        }
        $this->setData($data);
        
        // identify view
        $viewName = \WTW\Helpers\globalHelper::normalizePath(
                PATH_ROOT . DIRECTORY_SEPARATOR . VIEW_FOLDER . DIRECTORY_SEPARATOR . $this->getController() . DIRECTORY_SEPARATOR
        )  . $this->getAction() . '.php';
        if ($this->checkViewFile($viewName)) {
            $this->setView($viewName);
        }
        
        // execute action
        $className = '\\' . $this->controller;
        $this->objController = new $className();
        $this->objController->setAuthorizedInputs($this->authorizedInputs);
        $this->exportProperties();
        if (method_exists($this->objController, $this->getAction())) {
            
            // gets existing filters
            $data->filterData = $this->getFilters();
            $this->setData($data);
            
            // applys before filters to action
            $this->applyFilter('before');
            
            // executes the action
            $action = $this->getAction();
            $result = $this->objController->$action();
            
            // applys after filters to action
            $this->applyFilter('after', $result);
            
        } else {
            throw new \WTW\error\ControllerException('Controller:: action ' . $this->getAction() . ' doesn\'t exist!');
        }
        
        return $result;
    }
    
    protected function getFilters() : \WTW\MVC\FilterCollection
    {
        $filters = new \WTW\MVC\FilterCollection();
        
        $action = $this->objController->getAction();
        $filterAction = $action . 'Filters';
        
        if (method_exists($this->objController, $filterAction)) {
            $filters = $this->objController->$filterAction();
        }
        
        return $filters;
    }
    
    protected function applyFilter(string $paramType, $contentAfter = null)
    {
        if (strtolower($paramType) !== 'before' && strtolower($paramType) !== 'after') {
            throw new \WTW\error\ControllerException('Controller:: action ' . $this->getAction() . ' doesn\'t exist!');
        }
        
        // before filters = 'ACTION, CACHE, AUTHORIZE
        if (!empty($this->data->filterData->elements)) {
            foreach ($this->data->filterData->elements as $index => $objFilter) {
                $objFilter->run($this);
            }
            die('befor filter done!');
        }
        die('no filters!');
        
        // after filters = 'ACTION'
        die('apply before filters');
    }
    
    protected function checkControllerFile($filename)
    {
        if (!file_exists($filename)) {
            throw new \WTW\error\ControllerException('Controller:: controller base file ' . $filename . ' doesn\'t exist!');
        }
        
        require_once($filename);
        return true;
        
    }
    
    protected function checkViewFile($filename)
    {
        if (!file_exists($filename)) {
            return false;
        }
        
        return true;
        
    }
    
    protected function checkControllerClass($className, $actionName)
    {
        if (!class_exists($className)) {
            throw new \WTW\error\ControllerException('Controller:: controller class ' . $className . ' not found!');
        }
        
        $obj = new $className();
        if (!method_exists($className, $actionName)) {
            throw new \WTW\error\ControllerException('Controller:: controller method ' . $className . '->' . $actionName . ' not found!');
        }
        
        return true;
        
    }
    
    protected function parseToMethodName($str)
    {
        $res = '';
        $str1 = str_replace('/[^a-zA-Z0-9\']/', '', strtolower($str));
        $words = explode(' ', $str1);
        
        if (!empty($words)) {
            foreach ($words as $word) {
                $res .= ucfirst($word);
            }
        }
        
        return $res;
    }
    
    protected function addAuthorizedItem($obj, $key = null)
    {
        
        if (!is_a($obj, '\WTW\Helpers\inputParam')) {
            throw new Exception('Controllers: type of object must be inputParam!');
        }

        $input = new \WTW\Helpers\inputParameters();
        $input->addItem($obj, $key);
        
        if (is_null($key)) {
            $this->authorizedInputs[] = $input;
        } else {
            if (isset($this->authorizedInputs->$key)) {
                return false;
            }
            
            $this->authorizedInputs->itens[$key] = $input->itens[$key];
            $this->authorizedInputs->validatedItens[$key] = $input->validatedItens[$key];
            
        }
        
    }
    
    public function exportProperties()
    {   
        foreach (get_object_vars($this) as $key => $value) {
            $this->objController->$key = $value;
        }
    }
    
    public function renderView()
    {
        $html = '';
        
        $view = $this->getView();
        
        if (empty($view)) {
            return '';
        }
        
        $objView = new \WTW\MVC\View();
        $objView->setView($view);
        $objView->setData($this->getData());
        $html = $objView->render();
        
        return $html;
    }
}
