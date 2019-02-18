<?php

namespace Core\Common;

/**
 * A mutable string class, which is used to manipulate a string. This class does
 * not support multi-byte characters such as UTF8. This class cannot be inherited.
 */
final class Str implements \ArrayAccess, \IteratorAggregate, \Countable{
    
    private $string = '';

    /**
     * Initializes a new instance of Str with $string.
     */
    public function __construct(string $string = ''){
        $this->string = $string;
    }
    
    /**
     * Gets the number of characters.
     */
    public function count() : int{
        return strlen($this->string);
    }
    
    /**
     * Appends a string.
     */
    public function append(string $string) : Str{
        $this->string .= $string;
        return $this;
    }
    
    /**
     * Inserts a string at the specified character position.
     */
    public function insert(int $index, string $string) : Str{
        $this->string = substr_replace($this->string, $string, $index, 0);
        return $this;
    }
    
    /**
     * Removes characters beginning at $index position until $length.
     */
    public function remove(int $index, int $length) : Str{
        $this->string = substr_replace($this->string, '', $index, $length);
        return $this;
    }
    
    /**
     * Gets a substring from the current string.
     */
    public function subString(int $start, int $length = 0) : Str{
        if($length > 0){
            $this->string = substr($this->string, $start, $length);
        }else{
            $this->string = substr($this->string, $start);
        }
        return $this;
    }
    
    /**
     * Gets the zero-based index of the first occurrence of $needle.
     */
    public function indexOf(string $needle , int $offset = 0) : int{        
        return stripos($this->string, $needle, $offset);
    }
    
    /**
     * Gets the string before the last occurrence of $needle.
     */
    public function getBeforeLastIndexOf(string $needle) : Str{   
        $pos = strripos($this->string, $needle);
        if($pos > -1){
            $this->string = substr($this->string, 0, $pos);
        }else{
            $this->string = '';
        }
        return $this;
    }
    
    /**
     * Gets the string after the last occurrence of $needle.
     */
    public function getAfterLastIndexOf(string $needle) : Str{   
        $pos = strripos($this->string, $needle);
        if($pos > -1){
            $this->string = substr($this->string, $pos+1);
        }else{
            $this->string = '';
        }
        return $this;
    }

    /**
     * Converts the characters to uppercase.
     */
    public function toUpper() : Str{
        $this->string = strtoupper($this->string);
        return $this;
    }
    
    /**
     * Converts the characters to lowercase.
     */
    public function toLower() : Str{
        $this->string = strtolower($this->string);
        return $this;
    }
    
    /**
     * Converts the first character to uppercase.
     */
    public function toUpperFirst() : Str{ 
        $this->string = ucfirst($this->string);
        return $this;
    }
    
    /**
     * Converts the last character to uppercase.
     */
    public function toUpperLast() : Str{
        $this->string = strrev(ucfirst(strrev($this->string)));
        return $this;
    }
    
    /**
     * Converts the first character to lowercase.
     */
    public function toLowerFirst() : Str{ 
        $this->string = lcfirst($this->string);
        return $this;
    }
    
    /**
     * Converts the last character to lowercase.
     */
    public function toLowerLast() : Str{
        $this->string = strrev(lcfirst(strrev($this->string)));
        return $this;
    }
    
    /**
     * Removes all leading and trailing characters specified in $charmask.
     */
    public function trim(string $charmask = null) : Str{
        $this->string = $this->_trim('trim', $charmask);
        return $this;
    }
    
    /**
     * Removes all leading characters specified in $charmask.
     */
    public function leftTrim(string $charmask = null) : Str{
        $this->string = $this->_trim('ltrim', $charmask);
        return $this;
    }
    
    /**
     * Removes all trailing characters specified in $charmask.
     */
    public function rightTrim(string $charmask = null) : Str{
        $this->string = $this->_trim('rtrim', $charmask);
        return $this;
    }
    
    /**
     * Replaces all occurrences of $replace with $replacement. $replace can be 
     * a string or an array of strings. 
     */
    public function replace($replace, string $replacement) : Str{
        $this->string = str_replace($replace, $replacement, $this->string);
        return $this;
    }
    
    /**
     * Replaces all occurrences of tokens in the string using $tokens.
     */
    public function replaceTokens(array $tokens) : Str{
        foreach($tokens as $key => $string){ 
            $this->string = str_replace('{' . $key . '}', $string, $this->string);
        }
        return $this;
    }

    /**
     * Splits the string using regular expressions and returns an Arr object. 
     */
    public function split(string $pattern, int $limit = null, int $flags = PREG_SPLIT_NO_EMPTY) : Arr{
        return new Arr(preg_split('@'.$pattern.'@', $this->string, $limit, $flags));
    }
    
    /**
     * Gets a boolean value indicating if string is equal to the
     * specified $string.
     */
    public function equals(string $string) : bool{
        if(strcmp($this->string, $string) === 0){
            return true;
        }
        return false;
    }
    
    /**
     * Gets a boolean value indicating if the string starts with the
     * specified $string.
     */
    public function startsWith(string $string) : bool{
        return substr($this->string, 0, strlen($string)) == $string ? true : false;
    }
    
    /**
     * Gets a boolean value indicating if the string ends with the
     * specified $string.
     */
    public function endsWith(string $string) : bool{
        return substr($this->string, strlen($this->string) - strlen($string)) == $string ? true : false;
    }

    /**
     * Gets the underlying string.
     */
    public function toString() : string{
        return $this->__toString();
    }
    
    public function offsetExists($offset) : bool{
        if (array_key_exists($offset, $this->string)){
            return true;
        }
        return false;
    }

    public function offsetGet($offset){
        return $this->string[$offset];
    }
    
    public function offsetSet($offset, $value){
        $this->string[$offset] = $value;
    }

    public function offsetUnset($offset){
        $this->remove($offset, 1);
    }
    
    /**
     * Gets an instance of ArrayIterator to iterate over each character.
     */
    public function getIterator() : \ArrayIterator{
        return new \ArrayIterator(str_split($this->string));
    }
    
    public function newInstance(){
        return new Str($this->string);
    }

    /**
     * Gets the underlying string.
     */
    public function __toString() : string{
        return $this->string;
    }
 
    private function _trim($function, $charmask = null) : string{
        return $function($this->string, ((null == $charmask) ? " \t\n\r\0\x0B" : " \t\n\r\0\x0B" . $charmask));
    }
    
    /**
     * Gets a new Str object initialized with $string
     */
    public static function set(string $string) : Str{
        return new Str($string);
    }
}
