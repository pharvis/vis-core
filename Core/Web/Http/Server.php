<?php

namespace Core\Web\Http;

use Core\Common\Arr;

/**
 * Encapsulates server and client information. This class cannot be inherited.
 */
final class Server{
    
    private $basePath = '';
    private $collection = null;
    
    /**
     * Initializes a new instance of Server with the application base path and
     * server variables.
     */
    public function __construct(string $basePath){
        $this->basePath = $basePath;
        $this->collection = new Arr($_SERVER);
    }
    
    /**
     * Gets SERVER data from the request using the specified $name. If $name is
     * specified but does not exist then $default is returned. If $name is 
     * not specified then returns an Arr object of all SERVER data.
     */
    public function get(string $name = '', $default = ''){
        if($name){
            return $this->collection->get($name, $default);
        }
        return $this->collection;
    }
    
    /**
     * Gets the application base path.
     */
    public function getBasePath() : string{
        return $this->basePath;
    }
}