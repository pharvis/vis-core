<?php

namespace Core\Web\Http;

/**
 * A base class for resource not found exceptions.
 */
class ResourceNotFoundException extends \Exception{
    
    protected $uri = '';
    
    /**
     * Initializes a new instance of ResourceNotFoundException with a $message
     * and the request $uri.
     */
    public function __construct(string $message, string $uri) {
        parent::__construct($message);
        $this->uri = $uri;
    }
    
    /**
     * Gets the request uri associated with this exception.
     */
    public function getUri() : string{
        return $this->uri;
    }
}