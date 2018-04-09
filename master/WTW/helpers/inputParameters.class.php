<?php
namespace WTW\Helpers;

/**
 * Description of inputParameters
 *
 * @author marco
 */
class inputParameters implements Collection {
    public $itens = array();
    public $validatedItens = array();
    
    public function addItem($obj, $key = null)
    {
        if (!is_a($obj, '\WTW\Helpers\inputParam')) {
            throw new Exception('inputParameters: type of object must be inputParam!');
        }
        
        if (is_null($key)) {
            $this->itens[] = $obj;
        } else {
            if (isset($this->itens[$key])) {
                throw new KeyHasUseException("inputParameters: Key $key already in use.");
            }
            
            $this->itens[$key] = $obj;
            
            // validates input and builds corresponding validatedItens
            $obj1 = new \WTW\Helpers\Input(
                    $obj->getVarName(),
                    $obj->getInputSource(),
                    $obj->getInputType(),
                    $obj->getSanitizeFilter(),
                    $obj->getValidateFilter(),
                    $obj->getOptions()
            );
            $this->addValidatedItem($obj1, $obj->getVarName());
            
        }
    }

    public function deleteItem($key)
    {
        if (isset($this->itens[$key])) {
            unset($this->itens[$key]);
        } else {
            throw new KeyInvalidException("inputParamters: Invalid key $key");
        }
    }

    public function getItem($key)
    {
        if (isset($this->itens[$key])) {
            return $this->itens[$key];
        } else {
            throw new KeyInvalidException("inputParamters: Invalid key $key");
        }
    }
    
    public function itenslength()
    {
        return count($this->itens);
    }
    
    public function itensKeyExists($key)
    {
        return isset($this->itens[$key]);
    }
    
    public function itensToJson()
    {
        if ($this->length() > 0) {
            return json_encode($this->itens);
        } else {
            return null;
        }
    }
    
    public function listItens()
    {
        $result = new \stdClass();
        
        if ($this->validatedItenslength() > 0) {
            foreach ($this->itens as $key => $item) {
                $result->$key['variableName'] = $item->getVariableName();
                $result->$key['requestValue'] = $item->getRequestValue();
                $result->$key['validatedValue'] = $item->getValidatedValue();
                $result->$key['isValid'] = $item->getIsValid();
                $result->$key['iSvalidMessage'] = $item->getIsValidMessage();
                $result->$key['requestMethod'] = $item->getRequestMethod();
                $result->$key['requestMethodArgs'] = $item->getRequestMethodArgs();
            }
            return $result;
        }
        
        return $result;
    }
    
    public function addValidatedItem(\WTW\Helpers\input $obj, $key = null)
    {
        if (is_null($key)) {
            $this->validatedItens[] = $obj;
        } else {
            if (isset($this->validatedItens[$key])) {
                throw new KeyHasUseException("inputParameters: Key $key already in use.");
            } else {
                $this->validatedItens[$key] = $obj;
            }
        }
    }

    public function deleteValidatedItem($key)
    {
        if (isset($this->validatedItens[$key])) {
            unset($this->validatedItens[$key]);
        } else {
            throw new KeyInvalidException("inputParamters: Invalid key $key");
        }
    }

    public function getValidatedItem($key)
    {
        if (isset($this->validatedItens[$key])) {
            return $this->validatedItens[$key];
        } else {
            throw new KeyInvalidException("inputParamters: Invalid key $key");
        }
    }
    
    public function validatedItensLength()
    {
        return count($this->validatedItens);
    }
    
    public function validatedItenskeyExists($key)
    {
        return isset($this->validatedItens[$key]);
    }
    
    public function validatedItensToJson()
    {
        if ($this->length() > 0) {
            return json_encode($this->validatedItens);
        } else {
            return null;
        }
    }
    
    public function checkSentParameters()
    {
        $paramsPost = array_keys($_POST);
        $paramsGet = array_keys($_GET);

        // $_GET params
        foreach ($paramsGet as $key) {
            if (!isset($this->itens[$key])) {
                throw new \WTW\error\InputParamsException('inputParamteres: param ' . $key . ' is not in whitelist for $_GET!');
            } else {
                if (!$this->itens[$key]->getInputSource() == 'INPUT_BOTH' && !$this->itens[$key]->getInputSource() == 'INPUT_GET') {
                    throw new \WTW\error\InputParamsException('inputParamteres: param ' . $key . ' is not in whitelist for $_GET!');
                }                
            }
        }
        
        // $_POST params
        foreach ($paramsPost as $key) {
            if (!isset($this->itens[$key])) {
                throw new \WTW\error\InputParamsException('inputParamteres: param ' . $key . ' is not in whitelist for $_POST!');
            } else {
                if (!$this->itens[$key]->getInputSource() == 'INPUT_BOTH' && !$this->itens[$key]->getInputSource() == 'INPUT_POST') {
                    throw new \WTW\error\InputParamsException('inputParamteres: param ' . $key . ' is not in whitelist for $_POST!');
                }
            }
        }
        
    }
    
    // method alias
    public function getValidatedItens() {
        return $this->listValidatedItens();
    }
    
    public function listValidatedItens()
    {
        $result = new \stdClass();
        
        if ($this->validatedItenslength() > 0) {
            foreach ($this->validatedItens as $key => $item) {
                $result->$key['variableName'] = $item->getVariableName();
                $result->$key['requestValue'] = $item->getRequestValue();
                $result->$key['validatedValue'] = $item->getValidatedValue();
                $result->$key['isValid'] = $item->getIsValid();
                $result->$key['iSvalidMessage'] = $item->getIsValidMessage();
                $result->$key['requestMethod'] = $item->getRequestMethod();
                $result->$key['requestMethodArgs'] = $item->getRequestMethodArgs();
            }
            return $result;
        }
        
        return $result;
    
    }
}
