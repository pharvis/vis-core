<?php

namespace Core\Common;

final class Str{
    
    private $string = '';

    public function __construct(string $string = ''){
        $this->string = $string;
    }
    
    public function length(){
        return strlen($this->string);
    }
    
    public function append(string $string){
        $this->string .= $string;
        return $this;
    }
    
    public function subString(int $start, int $length = null){
        $this->string = substr($this->string, $start, $length);
        return $this;
    }
    
    public function indexOf(string $needle , $offset = 0){        
        return stripos($this->string, $needle, $offset);
    }

    public function toUpper(){
        $this->string = strtoupper($this->string);
        return $this;
    }
    
    public function toLower(){
        $this->string = strtolower($this->string);
        return $this;
    }
    
    public function toUpperFirst(){ 
        $this->string = ucfirst($this->string);
        return $this;
    }
    
    public function toUpperLast(){
        $this->string = substr($this->string, 0, strlen($this->string) -1) . substr($this->string, 0, 1);
        return $this;
    }
    
    public function trim(string $charmask = null){
        $this->string = $this->_trim('trim', $charmask);
        return $this;
    }
    
    public function leftTrim(string $charmask = null){
        $this->string = $this->_trim('ltrim', $charmask);
        return $this;
    }
    
    public function rightTrim(string $charmask = null){
        $this->string = $this->_trim('rtrim', $charmask);
        return $this;
    }
    
    public function replace($replace, string $replacement){
        $this->string = str_replace($replace, $replacement, $this->string);
        return $this;
    }
    
    public function replaceTokens(array $replace){
        foreach($replace as $key => $string){ 
            $this->string = str_replace('{' . $key . '}', $string, $this->string);
        }
        return $this;
    }

    public function split(string $pattern, int $limit = null, int $flags = PREG_SPLIT_NO_EMPTY){
        return new Arr(preg_split('@'.$pattern.'@', $this->string, $limit, $flags));
    }
    
    public function equals(string $string) : bool{
        if(strcmp($this->string, $string) === 0){
            return true;
        }
        return false;
    }
    
    public function startsWith(string $string){
        $len = strlen($string);
        return substr($this->string, 0, $len) == $string ? true : false;
    }

    public function toString(){
        return $this->__toString();
    }
    
    public function __toString(){
        return $this->string;
    }
    
    private function _trim($function, $charmask = null){
        return $function($this->string, ((null == $charmask) ? " \t\n\r\0\x0B" : " \t\n\r\0\x0B" . $charmask));
    }
    
    public static function set(string $string){
        return new Str($string);
    }
}
