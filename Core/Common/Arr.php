<?php

namespace Core\Common;

class Arr implements \ArrayAccess, \IteratorAggregate, \Countable{
    
    protected $collection = [];
    
    public function __construct(array $collection = []){
        $this->collection = $collection;
    }
    
    public function get(string $key, $default = null){
        if($this->exists($key)){
            return $this->collection[$key];
        }
        return $default;
    }
    
    public function getString(string $key, $default = ''){
        if($this->exists($key)){
            $value = $this->collection[$key];
            if(is_scalar($value)){
                return new Str($value);
            }
        }
        return new Str($default);
    }
    
    public function add(...$args){
        if(count($args) == 1){
            $this->collection[] = $args[0];
        }
        elseif(count($args) == 2){
            $this->collection[$args[0]] = $args[1];
        }
        return $this;
    }
    
    public function addIndex($value){
        $this->collection[] = $value;
        return $this;
    }
    
    public function remove(string $key) : bool{
        if($this->exists($key)){
            unset($this->collection[$key]);
            return true;
        }
        return false;
    }
    
    public function merge($array) : Arr{
        if($array instanceof Arr){
            $array = $array->toArray();
        }
        if(!is_array($array)){
            throw new \InvalidArgumentException(sprintf('Argument 1 passed to %1$s::merge() must be of type array or an instance of %1$s, %2$s given.', get_class($this), gettype($array)));
        }
        $this->collection = array_merge($this->collection, $array);
        return $this;
    }
    
    public function exists(string $key) : bool{
        return array_key_exists($key, $this->collection);
    }
    
    public function contains($value) : bool{
        return in_array($value, $this->collection);
    }

    public function count() : int{
        return count($this->collection);
    }
    
    public function path(string $path = ''){
        $tmp = $this->collection;
        if($path){
            $segments = array_map(function($value){ return trim($value); }, explode('.', trim($path, ' .')));

            foreach($segments as $segment){
                if(is_array($tmp)){
                    $tmp = $tmp[$segment];
                }
            }
        }
        return $tmp;
    }
    
    public function map(callable $function) : Arr{
        $this->collection = array_map($function, $this->collection);
        return $this;
    }
    
    public function each(callable $function){
        foreach($this->collection as $key => $value){
            $function($key, $value);
            $i++;
        }
    }
    
    public function first(){
        return reset($this->collection);
    }
    
    public function last(){
        return end($this->collection);
    }
    
    public function clear(){
        $this->collection = [];
        return $this;
    }

    public function toArray() : array{
        return $this->collection;
    }
    
    public function toObject(){
        return json_decode(json_encode($this->collection));
    }
    
    public function toJson() : string{
        return json_encode($this->collection);
    }
    
    public function serialize() : string{
        return serialize($this->collection);
    }
    
    public function toStringGenerator() : \Generator{
        foreach($this->collection as $item){
            if(is_String($item)){
                yield new Str($item);
            }
        }
    }

    public function offsetExists($offset) : bool{
        if (array_key_exists($offset, $this->collection)){
            return true;
        }
        return false;
    }

    public function offsetGet($offset){
        return $this->collection[$offset];
    }
    
    public function offsetSet($offset, $value){
        $this->collection[$offset] = $value;
    }

    public function offsetUnset($offset){
        unset($this->collection[$offset]);
    }
    
    public function getIterator(){
        return new \ArrayIterator($this->collection);
    }
    
    public static function unserialize(string $string) : Arr{
        return new Arr(unserialize($string));
    }
}