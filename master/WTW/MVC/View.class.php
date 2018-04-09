<?php
namespace WTW\MVC;

/**
 * Description of View
 *
 * @author marco
 */
class View {
    protected $data;
    protected $view;
    
    public function setView(string $value)
    {
        $this->view = $value;
    }
    
    public function getView()
    {
        return $this->view;
    }
    
    public function setData(\stdClass $obj)
    {
        $this->data = $obj;
    }
    
    public function getData()
    {
        return $this->data;
    }

    protected function checkViewFile($filename)
    {
        if (!file_exists($filename)) {
            return false;
        }
        
        return true;
        
    }
    
    public function render(string $pathView = '')
    {
        $content = '';
        
        if (!empty($pathView)) {
            
        }
        
        $file = $this->getView();
        if (empty($file)) {
            return '';
        }
        
        if( !is_readable($file) ){
            throw new Exception("View $file not found!");
        }
        
        $data = $this->getData();
        //echo \WTW\Helpers\globalHelper::showDebug($data);die();
        ob_start();
        include($file);
        $content = ob_get_clean();
        
        return $content;
    }    
}
