<?php

namespace Core\Web\Http;

use Core\Configuration\Configuration;

abstract class HttpController implements IGenericController{
    
    private $config = null;
    private $httpContext = null;
    
    public function getConfiguration() : Configuration{
        return $this->config;
    }
    
    public function getHttpContext() : HttpContext{
        return $this->httpContext;
    }

    public function get(){}

    public function post(){}
    
    public function put(){}
    
    public function delete(){}
    
    public function options(){}
    
    public function head(){}
    
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