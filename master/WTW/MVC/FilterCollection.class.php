<?php
namespace WTW\MVC;

/**
 *
 * @author marco
 */
class FilterCollection implements \WTW\Helpers\Collection {
    public $elements = array();
    
    public function addItem($obj, $key = null)
    {
        if (!is_a($obj, '\WTW\MVC\Filter')) {
            throw new Exception('FilterCollection: type of object must be Filter!');
        }
        
        if (is_null($key)) {
            $this->elements[] = $obj;
        } else {
            if (isset($this->elements[$key])) {
                throw new KeyHasUseException("FilterCollection: Key $key already in use.");
            }
            
            $this->elements[$key] = $obj;            
        }
    }

    public function deleteItem($key)
    {
        if (isset($this->elements[$key])) {
            unset($this->elemetns[$key]);
        } else {
            throw new KeyInvalidException("FilterCollection: Invalid key $key");
        }
    }

    public function getItem($key)
    {
        if (isset($this->elements[$key])) {
            return $this->elements[$key];
        } else {
            throw new KeyInvalidException("FilterCollection: Invalid key $key");
        }
    }
    
    public function itenslength()
    {
        return count($this->elements);
    }
    
    public function itensKeyExists($key)
    {
        return isset($this->elements[$key]);
    }
    
    public function itensToJson()
    {
        if ($this->length() > 0) {
            return json_encode($this->elements);
        } else {
            return null;
        }
    }
    
    public function listItens()
    {
        $result = new \stdClass();
        
        if ($this->elements() > 0) {
            foreach ($this->elements as $key => $item) {
                $result->$key['key'] = $item->key;
                $result->$key['callable'] = $item->callable;
                $result->$key['params'] = $item->params;
            }
            return $result;
        }
        
        return $result;
    }
}
