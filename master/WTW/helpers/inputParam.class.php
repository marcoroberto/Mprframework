<?php
namespace WTW\Helpers;

/**
 * Description of inputParam
 *
 * @author marco
 */
class inputParam {
    private $varName = '';
    private $inputSource = '';
    private $inputType = '';
    private $sanitizeFilter = '';
    private $validateFilter = '';
    private $options = array();
    
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
        self::VALIDATE_FILE
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
        self::TYPE_METHOD
    );
    
    public function __construct(
            $varName,
            $inputSource,
            $inputType,
            $sanitizeFilter = null,
            $validateFilter = null,
            $options = array()
    ) {
        
        if (!is_string($varName) || !strlen($varName) > 0) {
            throw new Exception('inputParam: variable name can\'t be empty!');
        }
        
        if (!is_string($inputSource) || !strlen($inputSource) > 0) {
            throw new Exception('inputParam: variable name can\'t be empty!');
        }
        
        if (!is_string($inputType) || !strlen($inputType) > 0) {
            throw new Exception('inputParam: input type can\'t be empty!');
        }
        
        if (!is_null($inputSource) && !in_array(strtoupper($inputSource), $this->inputSources)) {
            throw new Exception('inputParam: input source ' . $inputType . ' not recognized!');
        }
        
        if (!is_null($inputType) && !in_array(strtoupper($inputType), $this->types)) {
            throw new Exception('inputParam: input type ' . $inputType . ' not recognized!');
        }
        
        if (!is_null($sanitizeFilter) && !in_array(strtoupper($sanitizeFilter), $this->sanitizeTypes)) {
            throw new Exception('inputParam: sanitize filter ' . $sanitizeFilter . ' not recognized!');
        }
        
        if (!is_null($validateFilter) && !in_array(strtoupper($validateFilter), $this->validateTypes)) {
            throw new Exception('inputParam: validate filter ' . $validateFilter . ' not recognized!');
        }
        
        if (!is_null($options) && !is_array($options)) {
            throw new Exception('inputParam: options must be an array or a null value!');
        }
        
        $this->setVarName($varName);
        $this->setInputSource($inputSource);
        $this->setInputType($inputType);
        $this->setSanitizeFilter($sanitizeFilter);
        $this->setValidateFllter($validateFilter);
    }
    
    protected function setVarName($value)
    {
        $this->varName = $value;
    }
    
    protected function setInputSource($value)
    {
        $this->inputSource = strtoupper($value);
    }
    
    protected function setInputType($value)
    {
        $this->inputType = strtoupper($value);
    }
    
    protected function setSanitizeFilter($value)
    {
        $this->sanitizeFilter = strtoupper($value);
    }
    
    protected function setValidateFllter($value)
    {
        $this->validateFilter = strtoupper($value);
    }
    
    protected function setOptions($arr)
    {
        $this->options = $arr;
    }
    
    public function getVarName()
    {
        return $this->varName;
    }
    
    public function getInputSource()
    {
        return $this->inputSource;
    }
    
    public function getInputType()
    {
        return $this->inputType;
    }
    
    public function getSanitizeFilter()
    {
        return $this->sanitizeFilter;
    }
    
    public function getValidateFilter()
    {
        return $this->validateFilter;
    }
    
    public function getOptions()
    {
        return $this->options;
    }
}
