<?php

namespace Core\Web\Http;

use Core\Common\Arr;

/**
 * Represents an HTTP cookie collection. This class cannot be inherited.
 */
final class CookieCollection implements \IteratorAggregate{
    
    private $collection = null;
    
    /**
     * Initializes a new instance of CookieCollection with an array of cookies.
     */
    public function __construct(array $cookies = []){
        $this->collection = new Arr();
        foreach($cookies as $name => $value){
            $this->add(new Cookie($name, $value));
        }
    }

    /**
     * Adds a Cookie instance to the collection. Gets the current 
     * cookie collection instance.
     */
    public function add(Cookie $cookie) : CookieCollection{
        $this->collection->add($cookie);
        return $this;
    }
    
    /**
     * Removes a Cookie from the collection using the specified cookie $name.
     * Gets the current cookie collection instance.
     */
    public function remove(string $name) : CookieCollection{
        if($this->hasCookie($name)){
            $this->collection->get($name)->setExpires(-1);
        }else{
            $cookie = (new Cookie($name, ''))->setExpires(-1);
            $this->add($cookie);
        }
        return $this;
    }
    
    /**
     * Gets a boolean value indicating if the cookie collection contains the
     * specified cookie $name.
     */
    public function hasCookie(string $name) : bool{
        return $this->collection->exists($name);
    }
    
    /**
     * Gets an instance of ArrayIterator to iterate over the internal cookie
     * collection.
     */
    public function getIterator() : \ArrayIterator{
        return $this->collection->getIterator();
    }
}
