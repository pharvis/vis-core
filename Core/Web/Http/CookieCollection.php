<?php

namespace Core\Web\Http;

use Core\Common\Arr;

final class CookieCollection implements \IteratorAggregate{
    
    private $collection = null;
    
    public function __construct(array $cookies = []){
        $this->collection = new Arr();
        foreach($cookies as $name => $value){
            $this->add(new Cookie($name, $value));
        }
    }

    public function add(Cookie $cookie) : CookieCollection{
        $this->collection->add($cookie);
        return $this;
    }
    
    public function remove(string $name){
        if($this->hasCookie($name)){
            $this->collection->get($name)->setExpires(-1);
        }else{
            $cookie = (new Cookie($name, ''))->setExpires(-1);
            $this->add($cookie);
        }
    }
    
    public function hasCookie(string $name) : bool{
        return $this->collection->exists($name);
    }
    
    /**
     * Gets an instance of ArrayIterator to iterate over the internal array.
     */
    public function getIterator() : \ArrayIterator{
        return $this->collection->getIterator();
    }
}
