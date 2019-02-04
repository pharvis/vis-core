<?php

namespace Core\Web\Http;

use Core\Configuration\Configuration;

/**
 * An abstract base controller to handle standard HTTP requests.
 */
abstract class HttpController implements IGenericController{
    
    private $config = null;
    private $httpContext = null;
    
    /**
     * Gets the application configuration object.
     */
    public function getConfiguration() : Configuration{
        return $this->config;
    }
    
    /**
     * Gets the HttpContext object.
     */
    public function getHttpContext() : HttpContext{
        return $this->httpContext;
    }

    /**
     * Called by the service() method to handle a GET request.
     */
    public function get(){}

    /**
     * Called by the service() method to handle a POST request.
     */
    public function post(){}
    
    /**
     * Called by the service() method to handle a PUT request.
     */
    public function put(){}
    
    /**
     * Called by the service() method to handle a DELETE request.
     */
    public function delete(){}
    
    /**
     * Called by the service() method to handle a OPTIONS request.
     */
    public function options(){}
    
    /**
     * Called by the service() method to handle a HEAD request.
     */
    public function head(){}
    
    /**
     * The service() method handles standard HTTP requests by dispatching them 
     * to the handler methods for each HTTP request type.
     */
    public function service(Configuration $config, HttpContext $httpContext) : void{
        
        $this->config = $config;
        $this->httpContext = $httpContext;

        switch($httpContext->getRequest()->getMethod()){
            case 'GET':
                $this->get();
                break;
            
            case 'POST':
                $this->post();
                break;
            
            case 'PUT':
                $this->put();
                break;
            
            case 'DELETE':
                $this->delete();
                break;
            
            case 'OPTIONS':
                $this->options();
                break;
            
            case 'HEAD':
                $this->head();
                break;
        }
    }
}