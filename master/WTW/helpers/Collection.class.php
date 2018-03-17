<?php
namespace WTW\Helpers;

/**
 *
 * @author marco
 */
interface Collection {
    public function addItem($obj, $key = null);

    public function deleteItem($key);
    
    public function getItem($key);
    
    public function itensLength();
    
    public function itensKeyExists($key);
    
    public function itensToJson();
    
    public function listItens();
    
}
