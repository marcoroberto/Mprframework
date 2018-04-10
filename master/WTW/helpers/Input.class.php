<?php

namespace WTW\Helpers;

/**
 * Description of Input
 *
 * @author marco
 */
class Input {
    
    // variable types
    const INPUT_SERVER = 'INPUT_SERVER';
    const INPUT_FILE = 'INPUT_FILE';
    const INPUT_POST = 'INPUT_POST';
    const INPUT_BOTH = 'INPUT_POST_GET';
    const INPUT_GET = 'INPUT_GET';
    const INPUT_COOKIE = 'INPUT_COOKIE';
    const INPUT_ENV = 'INPUT_ENV';
    
    protected $inputSources = array(
        self::INPUT_SERVER,
        self::INPUT_FILE,
        self::INPUT_POST,
        self::INPUT_BOTH,
        self::INPUT_GET,
        self::INPUT_COOKIE,
        self::INPUT_ENV
    );
    
    // sanitize types
    const SANITIZE_STRING = 'FILTER_SANITIZE_STRING';
    const SANITIZE_EMAIL = 'FILTER_SANITIZE_EMAIL';
    const SANITIZE_NUMBER_FLOAT = 'FILTER_SANITIZE_NUMBER_FLOAT';
    const SANITIZE_NUMBER_INT = 'FILTER_SANITIZE_NUMBER_INT';
    const SANITIZE_FULL_SPECIAL_CHARS = 'FILTER_SANITIZE_FULL_SPECIAL_CHARS';
    const SANITIZE_URL = 'FILTER_SANITIZE_URL';
    const SANITIZE_DEFAULT = 'FILTER_SANITIZE_DEFAULT';
    
    protected $sanitizeTypes = array(
        self::SANITIZE_STRING,
        self::SANITIZE_EMAIL,
        self::SANITIZE_NUMBER_FLOAT,
        self::SANITIZE_NUMBER_INT,
        self::SANITIZE_FULL_SPECIAL_CHARS,
        self::SANITIZE_URL,
        self::SANITIZE_DEFAULT
    );
    
    // validate types
    const VALIDATE_STRING = 'FILTER_VALIDATE_STRING';
    const VALIDATE_BOOLEAN = 'FILTER_VALIDATE_BOOLEAN';
    const VALIDATE_EMAIL = 'FILTER_VALIDATE_EMAIL';
    const VALIDADE_FLOAT = 'FILTER_VALIDATE_FLOAT';
    const VALIDATE_INT = 'FILTER_VALIDATE_INT';
    const VALIDADE_IP = 'FILTER_VALIDATE_IP';
    const VALIDATE_MAC = 'FILTER_VALIDATE_MAC';
    const VALIDATE_REGEXP = 'FILTER_VALIDATE_REGEXP';
    const VALIDATE_URL = 'FILTER_VALIDATE_URL';
    const VALIDATE_WHITELIST = 'FILTER_VALIDATE_WHITELIST';
    const VALIDATE_DATE = 'FILTER_VALIDATE_DATE';
    const VALIDATE_DATETIME = 'FILTER_VALIDATE_DATETIME';
    const VALIDATE_TIME = 'FILTER_VALIDATE_TIME';
    const VALIDATE_CALLBACK = 'FILTER_VALIDATE_CALLBACK';
    const VALIDATE_IMAGE = 'FILTER_VALIDATE_IMAGE';
    const VALIDATE_FILE = 'FILTER_VALIDATE_FILE';
    const VALIDATE_SESSION_TOKEN = 'FILTER_VALIDATE_SESSION_TOKEN';
    
    protected $validateTypes = array(
        self::VALIDATE_STRING,
        self::VALIDATE_BOOLEAN,
        self::VALIDATE_EMAIL,
        self::VALIDADE_FLOAT,
        self::VALIDATE_INT,
        self::VALIDADE_IP,
        self::VALIDATE_MAC,
        self::VALIDATE_REGEXP,
        self::VALIDATE_URL,
        self::VALIDATE_WHITELIST,
        self::VALIDATE_DATE,
        self::VALIDATE_DATETIME,
        self::VALIDATE_TIME,
        self::VALIDATE_CALLBACK,
        self::VALIDATE_IMAGE,
        self::VALIDATE_FILE,
        self::VALIDATE_SESSION_TOKEN
    );

    // types to use on requestVariable
    const TYPE_STRING = 'STRING';
    const TYPE_BOOLEAN = 'BOOLEAN';
    const TYPE_EMAIL = 'EMAIL';
    const TYPE_FLOAT = 'FLOAT';
    const TYPE_INT = 'INT';
    const TYPE_IP = 'IP';
    const TYPE_MAC = 'MAC';
    const TYPE_REGEXP = 'REGEXP';
    const TYPE_URL = 'URL';
    const TYPE_WHITELIST = 'WHITELIST';
    const TYPE_DATE = 'DATE';
    const TYPE_DATETIME = 'DATETIME';
    const TYPE_TIME = 'TIME';
    const TYPE_CALLBACK = 'CALLBACK';
    const TYPE_IMAGE = 'IMAGE';
    const TYPE_FILE = 'FILE';
    const TYPE_ARRAY = 'ARRAY';
    const TYPE_METHOD = 'METHOD';
    const TYPE_SESSION_TOKEN = 'SESSION_TOKEN';
    
    protected $types = array(
        self::TYPE_STRING,
        self::TYPE_BOOLEAN,
        self::TYPE_EMAIL,
        self::TYPE_FLOAT,
        self::TYPE_INT,
        self::TYPE_IP,
        self::TYPE_MAC,
        self::TYPE_REGEXP,
        self::TYPE_URL,
        self::TYPE_WHITELIST,
        self::TYPE_DATE,
        self::TYPE_DATETIME,
        self::TYPE_TIME,
        self::TYPE_CALLBACK,
        self::TYPE_IMAGE,
        self::TYPE_FILE,
        self::TYPE_ARRAY,
        self::TYPE_METHOD,
        self::TYPE_SESSION_TOKEN
    );
    
    protected $variableName;
    protected $requestValue;
    protected $validatedValue;
    protected $isValid;
    protected $isValidMessage;
    protected $requestMethod;
    protected $requestMethodArgs;

    /**
     * 
     * @param string $varName Variable to request
     * @param string $inputSource INPUT_BOTH, INPUT_POST, INPUT_GET, INPUT_SERVER,
     *                           INPUT_ENV, INPUT_FILE, INPUT_COOKIE
     * @param string $datatype  STRING,BOOLEAN,EMAIL,FLOAT,INT,IP,MAC,REGEXP,URL,
     *                          WHITELIST,DATE,DATETIME,TIME,CALLBACK,IMAGE,FILE,ARRAY;
     * @param string FILTER_SANITIZE_STRING,FILTER_SANITIZE_EMAIL,FILTER_SANITIZE_NUMBER_FLOAT,
     *                          FILTER_SANITIZE_NUMBER_INT,FILTER_SANITIZE_FULL_SPECIAL_CHARS,
     *                          FILTER_SANITIZE_URL,FILTER_SANITIZE_DEFAULT
     * @param string $validateRule FILTER_VALIDATE_STRING,FILTER_VALIDATE_BOOLEAN,FILTER_VALIDADE_EMAIL,
     *                          FILTER_VALIDATE_FLOAT,FILTER_VALIDATE_INT,FILTER_VALIDADE_IP,
     *                          FILTER_VALIDADE_MAC',FILTER_VALIDATE_REGEXP,FILTER_VALIDADE_URL,
     *                          FILTER_VALIDADE_WHITELIST,FILTER_VALIDADE_DATE,FILTER_VALIDADE_DATETIME,
     *                          FILTER_VALIDADE_TIME,FILTER_VALIDATE_CALLBACK,FILTER_VALIDATE_IMAGE,
     *                          FILTER_VALIDATE_FILE
     * @param array $aditionalParams 
     *                          for int = array($minValue => null, $maxValue = null);
     *                          for float = array($minValue => null, $maxValue => null);
     *                          for string = array($length => null, $regexp => null);
     *                          for ip = array($validateFlag => null);
     */
    public function __construct(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $datatype = self::TYPE_STRING, 
        $sanitizeRule = null, 
        $validateRule = null, 
        array $aditionalParams = array()
    ) {
        $this->requestVariable($varName, $inputSource, $datatype, $sanitizeRule, $validateRule, $aditionalParams);
    }
    
    protected function setVariableName($value)
    {
        $this->variableName = $value;
    }
    
    public function getVariableName()
    {
        return $this->variableName;
    }
    
    protected function setRequestValue($value)
    {
        $this->requestValue = $value;
    }
    
    public function getRequestValue()
    {
        return $this->requestValue;
    }
    
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }
    
    public function getRequestMethodArgs()
    {
        return $this->requestMethodArgs;
    }
    
    protected function setIsValid($value)
    {
        if (is_bool($value)) {
            $this->isValid = $value;
        }
    }
    
    public function getIsValid()
    {
        return $this->isValid;
    }
    
    protected function setIsValidMessage($value)
    {
        $this->isValidMessage = $value;
    }
    
    public function getIsValidMessage()
    {
        return $this->isValidMessage;
    }
    
    protected function setValidatedValue($value)
    {
        $this->validatedValue = $value;
    }
    
    public function getValidatedValue()
    {
        return $this->validatedValue;
    }
    
    protected function requestVariable(
            $varName, 
            $inputSource = self::INPUT_BOTH,
            $datatype = self::TYPE_STRING, 
            $sanitizeRule = null, 
            $validateRule = null, 
            array $aditionalParams = array()
    ) {
        $return = null;
        
        // validate parameters sent to the method
        $this->validateRequestParams(
                $varName, 
                $inputSource, 
                $datatype, 
                $sanitizeRule, 
                $validateRule, 
                $aditionalParams
        );
        
        $this->setVariableName($varName);
        
        // decide which method should be considered to request the variable value
        $this->setRequestMethod($datatype);
        
        // method name to deal with specific datatype
        $methodName = $this->requestMethod;
        
        // validate mehtod parameters
        $valid = $this->checkMethodArgs($methodName, $varName, $inputSource, $sanitizeRule, $validateRule, $aditionalParams);
        if (!$valid['valid']) {
            $ex = new \Exception($valid['message']);
            throw $ex;
        }
        
        // executes method
        call_user_func_array(array($this, $this->requestMethod), $this->requestMethodArgs);
        
        return $return;
    }
    
    protected function validateRequestParams(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $datatype = self::TYPE_STRING, 
        $sanitizeRule = null, 
        $validateRule = null, 
        array $aditonalParams = array()
    ) {
        // validate options sent
        if (empty($varName)) {
            $ex = new \Exception(__NAMESPACE__ . get_class($this) . ':: must suply a variable name!');
            throw $ex;
        }
        
        // validate inputSource
        if (!in_array($inputSource, $this->inputSources)) {
            $ex = new \Exception(__NAMESPACE__ . get_class($this) . ':: invalid source!');
            throw $ex;
        }
        
        // validate datatype
        if (!empty($datatype)) {
            if (!in_array($datatype, $this->types)) {
                $ex = new \Exception(__NAMESPACE__ . get_class($this) . ':: invalid datatype!');
                throw $ex;
            }
        }
        
        // validate sanitize rule
        if (!empty($sanitizeRule)) {
            if (!in_array($sanitizeRule, $this->sanitizeTypes)) {
                $ex = new \Exception(__NAMESPACE__ . get_class($this) . ':: invalid sanitize type!');
                throw $ex;                
            }
        }
        
        // validate validation rule
        if (!empty($validateRule)) {
            if (!in_array($validateRule, $this->validateTypes)) {
                $ex = new \Exception(__NAMESPACE__ . get_class($this) . ':: invalid validation type!');
                throw $ex;                
            }
        }
        
    }
    
    protected function setRequestMethod($value)
    {
        $methodName = 'request' . $this->parseToMethodName($value);
        
        if (!method_exists($this, $methodName)) {
            $ex = new \Exception(__NAMESPACE__ . get_class($this) . ':: request method ' . $methodName . ' not found!');
            throw $ex;            
        }
        
        $this->requestMethod = $methodName;
    }
    
    protected function checkMethodArgs(
            $methodName, 
            $varName, 
            $inputSource, 
            $sanitizeRule, 
            $validateRule, 
            $aditionalParams
    ) {
        $res = array(
            'valid' => false,
            'message' => __NAMESPACE__ . get_class($this) . ':: method ' . $methodName . ' not found!'
        );
        
        if (method_exists($this, $methodName)) {
            $res = array(
                'valid' => true,
                'message' => ''
            );
            
            $mirror = new \ReflectionMethod($this, $methodName);
            $params = $mirror->getParameters();
            
            // no aditional parameters needed, it's ok
            if (empty($params)) {
                $res = array(
                    'valid' => true,
                    'message' => ''
                );
                return $res;
            }

            // check aditional paramters needed
            foreach ($params as $param) {
                $paramName = $param->getName();
                $paramIsOptional = $param->isOptional();
                $paramPosition = $param->getPosition();
                
                if ($paramPosition == 0) {
                    $this->requestMethodArgs[] = $varName;
                    continue;
                }
                
                if ($paramPosition == 1) {
                    $this->requestMethodArgs[] = $inputSource;
                    continue;
                }
                
                if ($paramPosition == 2) {
                    $this->requestMethodArgs[] = $sanitizeRule;
                    continue;
                }
                
                if ($paramPosition == 3) {
                    $this->requestMethodArgs[] = $validateRule;
                    continue;
                }
                
                if (!$paramIsOptional) {
                    if (!isset($aditionalParams[$paramName]) || empty($aditionalParams[$paramName])) {
                        $res = array(
                            'valid' => false,
                            'message' => __NAMESPACE__ . get_class($this) . ':: method ' . $methodName . ' requires parameter ' . $paramName . '!'
                        );
                        return $res;
                    }
                    
                    $this->requestMethodArgs[] = $aditionalParams[$paramName];
                } else {
                    if (isset($aditionalParams[$paramName]) && !empty($aditionalParams[$paramName])) {
                        $this->requestMethodArgs[] = $aditionalParams[$paramName];
                    }
                }
                
            }
        }
        
        return $res;
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
    
    public function requestInt(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_NUMBER_INT, 
        $validateRule = self::VALIDATE_INT,
        $minValue = null,
        $maxValue = null
    ) {        
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = FILTER_SANITIZE_NUMBER_INT;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        if (is_null($validateRule)) {
            $validateRule = FILTER_VALIDATE_INT;
        } else {
            $validateRule = constant($validateRule);
        }
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
                        
            if (!is_null($tmp)) {
                // validates
                $tmp1 = filter_var($tmp, $validateRule);

                if ($tmp1 === false ) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid Int in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = intval($tmp);
            }
        }
        
        // min value
        if (!empty($minValue)) {
            if ($valuePosted < $minValue) {
                $this->setIsValid(false);
                $this->setIsValidMessage('Min value for ' . $this->getVariableName() . ' is ' . $minValue . '. Can\'t accept lower value!');
            }
        }
        
        // max value
        if (!empty($maxValue)) {
            if ($valuePosted > $maxValue) {
                $this->setIsValid(false);
                $this->setIsValidMessage('Maximum value for ' . $this->getVariableName() . ' is ' . $maxValue . '. Can\'t accept higher value!');
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getIsValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }
    
    public function requestString(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_INT, 
        $validateRule = self::VALIDATE_INT,
        $length = null,
        $regexp = null
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = FILTER_SANITIZE_STRING;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        if (is_null($validateRule)) {
            $validateRule = '';
        } else {
            $validateRule = constant($validateRule);
        }
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
                        
            if (!is_null($tmp)) {
                // validates
                if (empty($validateRule)) {
                    $tmp1 = true;
                } else {
                    $tmp1 = filter_var($tmp, $validateRule);
                }

                if ($tmp1 === false ) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid String in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        // length
        if (!is_null($length) && intval($length) > 0) {
            $tmp = strlen($valuePosted);
            if ($tmp > $length) {
                $this->setIsValid(false);
                $this->setIsValidMessage('Length for ' . $this->getVariableName() . ' can\'t exceed ' . $length . ' characters!');                
            }
        }
        
        // regexp
        if (!empty($regexp)) {
            $tmp = preg_match('/' . $regexp . '/', $valuePosted);
            if ($tmp === 0 || $tmp === false) {
                $this->setIsValid(false);
                $this->setIsValidMessage('Regexp for ' . $this->getVariableName() . ' doesn\'t match with string given!');
            }
        }
                
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }
    
    public function requestBoolean(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = null, 
        $validateRule = self::VALIDATE_BOOLEAN
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = null;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        if (is_null($validateRule)) {
            $validateRule = null;
        } else {
            $validateRule = constant($validateRule);
        }
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, FILTER_DEFAULT);
            
            if (!is_null($tmp)) {
                
                // validates
                if (empty($validateRule)) {
                    $tmp1 = true;
                } else {
                    $tmp1 = filter_var($tmp, $validateRule);
                }

                if ($tmp1) {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');

                    $valuePosted = boolval($tmp);
                }
                
            }
        }
        
        if (is_null($valuePosted)) {
            $this->setIsValid(true);
            $this->setIsValidMessage('');
            $valuePosted = false;
        } else {
            $this->setRequestValue($valuePosted);
        }
        
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }
    
    public function requestEmail(
        $varName, 
        $inputSource = self::INPUT_BOTH
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        $sanitizeRule = FILTER_SANITIZE_EMAIL;
        $validateRule = FILTER_VALIDATE_EMAIL;
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
                        
            if (!is_null($tmp)) {
                // validates
                if (empty($validateRule)) {
                    $tmp1 = filter_var($tmp, FILTER_VALIDATE_EMAIL);
                } else {
                    $tmp1 = filter_var($tmp, $validateRule);
                }

                if ($tmp1 === false ) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid Email in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }

    public function requestFloat(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_NUMBER_FLOAT, 
        $validateRule = self::VALIDATE_FLOAT,
        $minValue = null,
        $maxValue = null
    ) {        
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = FILTER_SANITIZE_NUMBER_FLOAT;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        if (is_null($validateRule)) {
            $validateRule = FILTER_VALIDATE_FLOAT;
        } else {
            $validateRule = constant($validateRule);
        }
        
        $flagAllowFraction = FILTER_FLAG_ALLOW_FRACTION;
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule, $flagAllowFraction);
            $chars = array(',','€','$','£',' ');
            $replaces = array('.','','','','');
            $tmp = str_replace($chars, $replaces, $tmp);
            
            if (!is_null($tmp)) {
                // validates
                $tmp1 = filter_var($tmp, $validateRule);

                if ($tmp1 === false ) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid Float in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = floatval($tmp);
            }
        }
        
        // min value
        if (!empty($minValue) && $this->getIsValid()) {
            if ($valuePosted < $minValue) {
                $this->setIsValid(false);
                $this->setIsValidMessage('Min value for ' . $this->getVariableName() . ' is ' . $minValue . '. Can\'t accept lower value!');
            }
        }
        
        // max value
        if (!empty($maxValue) && $this->getIsValid()) {
            if ($valuePosted > $maxValue) {
                $this->setIsValid(false);
                $this->setIsValidMessage('Maximum value for ' . $this->getVariableName() . ' is ' . $maxValue . '. Can\'t accept higher value!');
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getIsValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }
    
    public function requestIp(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_STRING, 
        $validateRule = self::VALIDATE_IP,
        $validateFlag = FILTER_FLAG_IPV4
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = FILTER_SANITIZE_STRING;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        if (is_null($validateRule)) {
            $validateRule = '';
        } else {
            $validateRule = constant($validateRule);
        }

        $acceptedFlags = array(
            FILTER_FLAG_IPV4, FILTER_FLAG_IPV6
        );
        if (!in_array($validateFlag, $acceptedFlags)) {
            $validateFlag = null;
        }
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
                        
            if (!is_null($tmp)) {
                // validates
                if (empty($validateRule)) {
                    $tmp1 = true;
                } else {
                    $tmp1 = filter_var($tmp, $validateRule, $validateFlag);
                }

                if ($tmp1 === false ) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid IP in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }
    
    public function requestMac(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_STRING, 
        $validateRule = self::VALIDATE_MAC
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = FILTER_SANITIZE_STRING;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        if (is_null($validateRule)) {
            $validateRule = '';
        } else {
            $validateRule = constant($validateRule);
        }

        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
                        
            if (!is_null($tmp)) {
                // validates
                if (empty($validateRule)) {
                    $tmp1 = true;
                } else {
                    $tmp1 = filter_var($tmp, $validateRule);
                }

                if ($tmp1 === false ) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid IP in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }

    public function requestRegexp(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_DEFAULT, 
        $validateRule = self::VALIDATE_REGEXP,
        $regexp = null
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = FILTER_SANITIZE_STRING;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        if (is_null($validateRule)) {
            $validateRule = '';
        } else {
            $validateRule = constant($validateRule);
        }
        
        if (is_null($regexp)) {
            $this->setIsValid(false);
            $this->setIsValidMessage('Invalid Regexp to validated the input ' . $this->getVariableName() . '!');
            $this->setRequestValue($valuePosted);
            $this->setValidatedValue(null);
        }
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
                        
            if (!is_null($tmp)) {
                // validates
                if (empty($validateRule)) {
                    $tmp1 = true;
                } else {
                    $tmp1 = filter_var($tmp, $validateRule, array('options'=>array('regexp' => $regexp)));
                }

                if ($tmp1 === false ) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid String in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }
    
    public function requestUrl(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_URL,
        $validateRule = self::VALIDATE_URL,
        $validateFlag = null
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = FILTER_SANITIZE_URL;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        if (is_null($validateRule)) {
            $validateRule = '';
        } else {
            $validateRule = constant($validateRule);
        }

        $acceptedFlags = array(
            FILTER_FLAG_SCHEME_REQUIRED, 
            FILTER_FLAG_HOST_REQUIRED, 
            FILTER_FLAG_PATH_REQUIRED, 
            FILTER_FLAG_QUERY_REQUIRED
        );
        if (!in_array($validateFlag, $acceptedFlags)) {
            $validateFlag = null;
        }
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
                        
            if (!is_null($tmp)) {
                // validates
                if (empty($validateRule)) {
                    $tmp1 = true;
                } else {
                    $tmp1 = filter_var($tmp, $validateRule, $validateFlag);
                }

                if ($tmp1 === false ) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid URL in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }
    
    public function requestWhitelist(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_STRING,
        $validateRule = null,
        $whitelist = array()
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = FILTER_SANITIZE_STRING;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        if (empty($whitelist)) {
            $this->setIsValid(false);
            $this->setIsValidMessage('Invalid Whitelist to validate input ' . $this->getVariableName() . '!');
            $this->setRequestValue($valuePosted);
            $this->setValidatedValue(null);
        } else {
            $finalWhiTeList = array();
            foreach ($whitelist as $value) {
                $finalWhiTeList[] = strtolower($value);
            }
        }
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
                        
            if (!is_null($tmp)) {
                if (!in_array(strtolower($tmp), $finalWhiTeList)) {
                    $tmp1 = false;
                } else {
                    $tmp1 = true;
                }

                if ($tmp1 === false ) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid value in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }

    public function requestDate(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_STRING, 
        $validateRule = self::VALIDATE_REGEXP
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = FILTER_SANITIZE_STRING;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        $validateRule = FILTER_VALIDATE_REGEXP;
        $regexp = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
            
            if (!is_null($tmp)) {
                // validates
                $tmp1 = filter_var($tmp, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexp)));
                
                // test if valid date
                if ($tmp1) {
                    $d = \DateTime::createFromFormat('Y-m-d', $tmp1);
                    $tmp1 = $d && $d->format('Y-m-d') === $tmp;
                }

                if ($tmp1 === false) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid date in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }

    public function requestDateTime(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_STRING, 
        $validateRule = self::VALIDATE_REGEXP
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = FILTER_SANITIZE_STRING;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        $validateRule = FILTER_VALIDATE_REGEXP;
        $regexp = '/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/';
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
            
            if (!is_null($tmp)) {
                // validates
                $tmp1 = filter_var($tmp, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexp)));
                
                // test if valid date
                if ($tmp1) {
                    $d = \DateTime::createFromFormat('Y-m-d H:i:s', $tmp);
                    $tmp1 = $d && $d->format('Y-m-d H:i:s') === $tmp;
                }

                if ($tmp1 === false) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid date time in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }
    
    public function requestTime(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_STRING, 
        $validateRule = self::VALIDATE_REGEXP
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = FILTER_SANITIZE_STRING;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        $validateRule = FILTER_VALIDATE_REGEXP;
        $regexp = '/^(\d{2}):(\d{2}):(\d{2})$/';
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
            
            if (!is_null($tmp)) {
                // validates
                $tmp1 = filter_var($tmp, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexp)));
                
                // test if valid date
                if ($tmp1) {
                    $d = \DateTime::createFromFormat('H:i:s', $tmp);
                    $tmp1 = $d && $d->format('H:i:s') === $tmp;
                }

                if ($tmp1 === false) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid time in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }
    
    public function requestCallback(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_STRING,
        $validateRule = null,
        $callable,
        $args = array()
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        $sanitizeRule = FILTER_SANITIZE_STRING;
        
        if (!is_array($args)) {
            $this->setIsValid(false);
            $this->setIsValidMessage('Invalid Arguments for callback in input ' . $this->getVariableName() . '!');
            $this->setRequestValue($tmp);
            $this->setValidatedValue(null);
            return $valuePosted;
        }
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
            
            if (!is_null($tmp)) {
                // validates
                array_unshift($args, $tmp); // addds request value to the begn of the array
                $tmp1 = call_user_func_array($callable, $args);
                
                if ($tmp1 === false) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid value in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }

    public function requestImage(
        $varName, 
        $inputSource = self::INPUT_FILE,
        $sanitizeRule = self::SANITIZE_INT, 
        $validateRule = self::VALIDATE_INT,
        $format = array('image/gif','image/png','image_jpeg','image/pjpeg'),
        $maxSize = 1.5
    ) {
        $inputs = array();

        $inputSource = self::INPUT_FILE;
        
        $valuePosted = array();
        
        // must filter files accepted
        if (!is_array($format) || empty($format)) {
            $this->setIsValid(false);
            $this->setRequestValue('');
            $this->setValidatedValue(null);
            $this->setIsValidMessage('');
            return null;
        }
        
        //echo \WTW\Helpers\globalHelper::showDebug($_FILES);die();
        if (isset($_FILES[$varName]) && !empty($_FILES[$varName])) {
            foreach ($_FILES[$varName]['name'] as $key => $fileName) {
                $skipeFile = 0;
                
                if ($fileName != '') {
                    $file['name'] = $fileName;
                    $file['type'] = $_FILES[$varName]['type'][$key];
                    $file['tmp_name'] = $_FILES[$varName]['tmp_name'][$key];
                    $file['error'] = $_FILES[$varName]['error'][$key];
                    $file['size'] = \WTW\Helpers\globalHelper::fileSizeUnits($_FILES[$varName]['size'][$key], 'MB');
                    $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime-type extension
                    $file['mime'] = finfo_file($finfo, $file['tmp_name']);
                    finfo_close($finfo);

                    $valuePosted[] = $file;

                    if ($skipeFile == 0 && intval($file['error']) > 0) {
                        $skipeFile = 1;
                    }

                    if ($skipeFile == 0 && !in_array($file['mime'], $format)) {
                        $skipeFile = 1;
                    }

                    // validate file size
                    if (!empty($maxSize) && floatval($maxSize) > 0) {
                        if ($skipeFile == 0 && $file['size'] > floatval($maxSize)) {
                            $skipeFile = 1;
                        }
                    }

                    if (!$skipeFile) {
                        $valuePosted[] = $file;
                    }
                }
            }
        }
        
        if (!empty($valuePosted)) {
            $this->setValidatedValue($valuePosted);
            $this->setRequestValue($valuePosted);
            $this->setIsValid(true);
            $this->setIsValidMessage('');
            return $this->getValidatedValue();
        } else {
            $this->setValidatedValue(null);
            $this->setRequestValue($valuePosted);
            $this->setIsValid(false);
            $this->setIsValidMessage('');
            return $this->getValidatedValue();            
        }
    }
    
    public function requestFile(
        $varName, 
        $inputSource = self::INPUT_FILE,
        $sanitizeRule = self::SANITIZE_INT, 
        $validateRule = self::VALIDATE_INT,
        $format = array(
            'application/msword',
            'application/powerpoint',
            'application/vnd.ms-powerpoint',
            'application/x-mspowerpoint',
            'application/x-visio',
            'application/excel',
            'application/x-excel',
            'application/vnd.ms-excel',
            'application/x-msexcel',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.oasis.opendocument.text',
            'application/vnd.oasis.opendocument.spreadsheet',
            'application/vnd.oasis.opendocument.presentation',
            'application/pdf'
        ),
        $maxSize = 1.5
    ) {
        $inputs = array();

        $inputSource = self::INPUT_FILE;
        
        $valuePosted = array();
        
        // must filter files accepted
        if (!is_array($format) || empty($format)) {
            $this->setIsValid(false);
            $this->setRequestValue('');
            $this->setValidatedValue(null);
            $this->setIsValidMessage('');
            return null;
        }
        
        //echo \WTW\Helpers\globalHelper::showDebug($_FILES);die();
        if (isset($_FILES[$varName]) && !empty($_FILES[$varName])) {
            foreach ($_FILES[$varName]['name'] as $key => $fileName) {
                $skipeFile = 0;
                
                if ($fileName != '') {
                    $file['name'] = $fileName;
                    $file['type'] = $_FILES[$varName]['type'][$key];
                    $file['tmp_name'] = $_FILES[$varName]['tmp_name'][$key];
                    $file['error'] = $_FILES[$varName]['error'][$key];
                    $file['size'] = \WTW\Helpers\globalHelper::fileSizeUnits($_FILES[$varName]['size'][$key], 'MB');
                    $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime-type extension
                    $file['mime'] = finfo_file($finfo, $file['tmp_name']);
                    finfo_close($finfo);

                    if ($skipeFile == 0 && intval($file['error']) > 0) {
                        $skipeFile = 1;
                    }
                    
                    if ($skipeFile == 0 && !in_array($file['mime'], $format)) {
                        $skipeFile = 1;
                    }
                    
                    // validate file size
                    if (!empty($maxSize) && floatval($maxSize) > 0) {
                        if ($skipeFile == 0 && $file['size'] > floatval($maxSize)) {
                            $skipeFile = 1;
                        }
                    }
                    
                    if ($skipeFile == 0) {
                        $valuePosted[] = $file;
                    }
                }
            }
        }
        
        if (!empty($valuePosted)) {
            $this->setValidatedValue($valuePosted);
            $this->setRequestValue($valuePosted);
            $this->setIsValid(true);
            $this->setIsValidMessage('');
            return $this->getValidatedValue();
        } else {
            $this->setValidatedValue(null);
            $this->setRequestValue($valuePosted);
            $this->setIsValid(false);
            $this->setIsValidMessage('');
            return $this->getValidatedValue();            
        }
    }
    
    public function requestArray(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = null, 
        $validateRule = null,
        $length = null
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            if (!is_null($tmp)) {

                if (!is_array($tmp)) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid array in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        // length
        if (!is_null($length) && intval($length) > 0) {
            if (count($tmp) > $length) {
                $this->setIsValid(false);
                $this->setIsValidMessage('Length for ' . $this->getVariableName() . ' can\'t exceed ' . $length . ' characters!');                
            }
        }
                
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }

    public function requestMethod(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_STRING, 
        $validateRule = self::VALIDATE_REGEXP
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule) || $sanitizeRule === '') {
            $sanitizeRule = FILTER_SANITIZE_STRING;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        $regexp = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';
        
        foreach ($inputs as $input) {
            // gets sanitized value
            
            $tmp = filter_input($input, $varName, $sanitizeRule);
                        
            if (!is_null($tmp)) {
                // validates
                if (empty($validateRule)) {
                    $tmp1 = true;
                } else {
                    $tmp1 = filter_var($tmp, $validateRule, array('options'=>array('regexp' => $regexp)));
                }

                if ($tmp1 === false ) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid Method name ' . $tmp . ' in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
        
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($this->parseToMethodName($valuePosted));
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
    }
    
    public function requestSession_token(
        $varName, 
        $inputSource = self::INPUT_BOTH,
        $sanitizeRule = self::SANITIZE_STRING, 
        $validateRule = self::VALIDATE_REGEXP
    ) {
        $inputs = array();
        
        switch ($inputSource) {
            case 'INPUT_POST_GET':
                $inputs[] = INPUT_GET;
                $inputs[] = INPUT_POST;
                break;
            default:
                $inputs[] = constant($inputSource);
                break;
        }
        
        $valuePosted = null;
        
        if (is_null($sanitizeRule)) {
            $sanitizeRule = FILTER_SANITIZE_STRING;
        } else {
            $sanitizeRule = constant($sanitizeRule);
        }
        
        if (is_null($validateRule)) {
            $validateRule = '';
        } else {
            $validateRule = $validateRule;
        }
        
        foreach ($inputs as $input) {
            // gets sanitized value
            $tmp = filter_input($input, $varName, $sanitizeRule);
                        
            if (!is_null($tmp)) {
                // validates
                if (empty($validateRule)) {
                    $tmp1 = true;
                } else {
                    if (strcmp($_SESSION['session_token'], $tmp) == 0) {
                        $tmp1 = true;
                    } else {
                        $tmp1 = false;
                    }
                }

                if ($tmp1 === false ) {
                    $this->setIsValid(false);
                    $this->setIsValidMessage('Invalid Session Token in input ' . $this->getVariableName() . '!');
                } else {
                    $this->setIsValid(true);
                    $this->setIsValidMessage('');
                }
                
                $valuePosted = $tmp;
            }
        }
                        
        $this->setRequestValue($valuePosted);
        if ($this->getisValid()) {
            $this->setValidatedValue($valuePosted);
        } else {
            $this->setValidatedValue(null);
        }
        return $valuePosted;
                
    }
}
