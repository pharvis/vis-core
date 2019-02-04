<?php

namespace Core\Web\Http;

/**
 * Represents an HTTP request and response.
 */
final class HttpContext{
    
    private $request = null;
    private $response = null;

    /**
     * Initializes a new instance of HttpContext with a Request and Response
     * object.
     */
    public function __construct(Request $request, Response $response){
        $this->request = $request;
        $this->response = $response;
    }
    
    /**
     * Gets the HTTP request object.
     */
    public function getRequest() : Request{
        return $this->request;
    }
    
    /**
     * Gets the HTTP response object.
     */
    public function getResponse() : Response{
        return $this->response;
    }
}