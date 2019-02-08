<?php

namespace Core\Common;

/**
 * A mutable array class, which is used to create and manipulate arrays.
 */
class Arr implements \ArrayAccess, \IteratorAggregate, \Countable{
    
    protected $collection = [];
    
    /**
     * Initializes a new instance of Arr with an array.
     */
    public function __construct(array $collection = []){
        $this->collection = $collection;
    }
    
    /**
     * Gets an element using the specified $key. If $key does not exist then
     * $default is returned.
     */
    public function get(string $key, $default = null){
        if($this->exists($key)){
            return $this->collection[$key];
        }
        return $default;
    }
    
    /**
     * Gets a new Str object using the specified $key if the element value is of
     * type scalar. If $key does not exist then $default is returned as a new
     * Str object.
     */
    public function getString(string $key, string $default = '') : Str{
        if($this->exists($key)){
            $value = $this->collection[$key];
            if(is_scalar($value)){
                return new Str($value);
            }
        }
        return new Str($default);
    }
    
    /**
     * The add() method is a variadic method, which can accept one or two arguments.
     * If a single argument is supplied then it is used as the value of an element.
     * If two arguments are supplied, then the first argument is used as the element
     * key while the second argument is used as the element value.
     */
    public function add(...$args) : Arr{
        if(count($args) == 1){
            $this->collection[] = $args[0];
        }
        elseif(count($args) == 2){
            $this->collection[$args[0]] = $args[1];
        }
        return $this;
    }

    /**
     * Removes an array element using the specified $key.
     */
    public function remove(string $key) : bool{
        if($this->exists($key)){
            unset($this->collection[$key]);
            return true;
        }
        return false;
    }
    
    /**
     * Merges an $array with the current Arr object. $array can be either a PHP array
     * or an instance of Arr.
     */
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
    
    /**
     * Gets a boolean value indicating if an array element exists using the
     * specified $key.
     */
    public function exists(string $key) : bool{
        return array_key_exists($key, $this->collection);
    }
    
    /**
     * Gets a boolean value indicating if the current Arr object contains $value.
     */
    public function contains($value) : bool{
        return in_array($value, $this->collection);
    }

    /**
     * Gets a count of all elements in the current Arr object.
     */
    public function count() : int{
        return count($this->collection);
    }
    
    /**
     * Queries the array using a path notation to return a value.
     */
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
    
    /**
     * Applies a callable function to each element in the array. This method
     * modifies the internal array.
     */
    public function map(callable $function) : Arr{
        $this->collection = array_map($function, $this->collection);
        return $this;
    }
    
    /**
     * Applies a callable function to each element in the array. This method
     * returns a new instance of Arr.
     */
    public function each(callable $function) : Arr{
        $array = [];
        foreach($this->collection as $key => $value){
            $array[$key] = $function($value);
        }
        return new Arr($array);
    }
    
    /**
     * Gets the first element from the array.
     */
    public function first(){
        return reset($this->collection);
    }
    
    /**
     * Gets the last element from the array.
     */
    public function last(){
        return end($this->collection);
    }
    
    /**
     * Removes all elements from the array.
     */
    public function clear() : Arr{
        $this->collection = [];
        return $this;
    }

    /**
     * Gets the native PHP array.
     */
    public function toArray() : array{
        return $this->collection;
    }
    
    /**
     * Gets the native PHP array as an object of type stdClass.
     */
    public function toObject() : object{
        return object($this->collection);
    }
    
    /**
     * Gets the array as a JSON encoded string.
     */
    public function toJson() : string{
        return json_encode($this->collection);
    }
    
    /**
     * Gets a new Str object where each element in this array is joined 
     * using $char.
     */
    public function join(string $char) : Str{
        return new Str(join($char, $this->collection));
    }
    
    /**
     * Gets the array as a PHP serialized string.
     */
    public function serialize() : string{
        return serialize($this->collection);
    }
    
    /**
     * Gets a generator which yields elements of type scalar as new Str object.
     */
    public function toStringGenerator() : \Generator{
        foreach($this->collection as $item){
            if(is_scalar($item)){
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
    
    /**
     * Gets an instance of ArrayIterator to iterate over the internal array.
     */
    public function getIterator() : \ArrayIterator{
        return new \ArrayIterator($this->collection);
    }
    
    public static function unserialize(string $string) : Arr{
        return new Arr(unserialize($string));
    }
}