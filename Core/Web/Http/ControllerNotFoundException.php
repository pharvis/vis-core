<?php

namespace Core\Web\Http;

/**
 * An exception class, which is thrown when a controller class does not exist.
 */
class ControllerNotFoundException extends ResourceNotFoundException{
    
    protected $class = '';
    
    /**
     * Initializes a new instance of ControllerNotFoundException with a $message,
     * the controller $class name and the request $uri.
     */
    public function __construct(string $message, string $class, string $uri) {
        parent::__construct($message, $uri);
        $this->class = $class;
    }
    
    /**
     * Gets the controller class name associated with this exception.
     */
    public function getClass() : string{
        return $this->class;
    }
}