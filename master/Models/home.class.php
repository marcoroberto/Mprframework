<?php
/**
 * Description of main
 *
 * @author marco
 */
namespace WTW\MVC;

class ModelHome {
    public $data;
    
    public function main()
    {
        $obj = new \stdClass();
        $obj->name = 'Joaquim Ortigão';
        $obj->birth = '1975-05-06';
        $obj->salary = '160000';
        
        $this->data = $obj;
    }
    
    public function Xpto1()
    {
        $obj = new \stdClass();
        $obj->name = 'Joaquim Ortigão';
        $obj->birth = '1975-05-06';
        $obj->salary = '160000';
        $obj->action = 'xpto1';
        
        $this->data = $obj;
    }
    
}
