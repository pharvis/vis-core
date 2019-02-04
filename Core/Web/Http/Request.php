<?php

namespace Core\Web\Http;

use Core\Common\Arr;

/**
 * Encapsulates HTTP client request information. This class cannot be inherited.
 */
final class Request{
    
    private $server = null;
    private $url = null;
    private $exception = null;
    private $parameter = null;
    private $get = null;
    private $post = null;
    private $cookies = null;
    private $session = null;

    /**
     * Initializes a new instance of Request with server variables.
     */
    public function __construct(Server $server){
        $this->server = $server;
        $this->url = new Url($server);
        $this->parameter = new Arr();
        $this->get = new Arr($_GET);
        $this->post = new Arr($_POST);
        $this->cookies = new CookieCollection($_COOKIE);
        $this->session = new Session();
    }
    
    /**
     * Gets a URL object that represents the clients request URL.
     */
    public function getUrl() : Url{
        return $this->url;
    }
    
    /**
     * Gets the HTTP request method.
     */
    public function getMethod() : string{
        return $this->server->get('REQUEST_METHOD', 'GET');
    }
    
    /**
     * Sets an exception object.
     */
    public function setException(\Exception $exception){
        $this->exception = $exception;
    }
    
    /**
     * Gets an exception object.
     */
    public function getException() : \Exception{
        return $this->exception;
    }
    
    /**
     * Gets an Arr object of parameters.
     */
    public function getParameters() : Arr{
        return $this->parameter;
    }
    
    /**
     * Gets a new instance of Arr with all request data combined. Order of
     * precedence is user parameters, GET and POST.
     */
    public function getCollection() : Arr{
        return new Arr(array_merge($this->parameter->toArray(), $this->get->toArray(), $this->post->toArray()));
    }
    
    /**
     * Gets a Server object containing server variables.
     */
    public function getServer() : Server{
        return $this->server;
    }
    
    /**
     * Gets the HTTP cookie collection object.
     */
    public function getCookies() : CookieCollection{
        return $this->cookies;
    }
    
    /**
     * Gets the Session object.
     */
    public function getSession() : Session{
        return $this->session;
    }
    
    /**
     * Gets GET data from the request using the specified $name. If $name is
     * specified but does not exist then $default is returned. If $name is 
     * not specified then returns an Arr object of all GET data.
     */
    public function getQuery(string $name = '', $default = null){
        if($name){
            return $this->get->get($name, $default);
        }
        return $this->get;
    }
    
    /**
     * Gets POST data from the request using the specified $name. If $name is
     * specified but does not exist then $default is returned. If $name is 
     * not specified then returns an Arr object of all POST data.
     */
    public function getPost(string $name = '', $default = null){
        if($name){
            return $this->post->get($name, $default);
        }
        return $this->post;
    }
    
    /**
     * Gets a boolean value indicating if the request method is a GET.
     */
    public function isGet() : bool{
        return $this->server->get('REQUEST_METHOD') == 'GET' ? true : false;
    }

    /**
     * Gets a boolean value indicating if the request method is a POST.
     */
    public function isPost() : bool{
        return $this->server->get('REQUEST_METHOD') == 'POST' ? true : false;
    }
    
    /**
     * Gets a boolean value indicating if the request method is a PUT.
     */
    public function isPut() : bool{
        return $this->server->get('REQUEST_METHOD') == 'PUT' ? true : false;
    }
    
    /**
     * Gets a boolean value indicating if the request method is a HEAD.
     */
    public function isHead() : bool{
        return $this->server->get('REQUEST_METHOD') == 'HEAD' ? true : false;
    }
    
    /**
     * Gets a boolean value indicating if the request method is a DELETE.
     */
    public function isDelete() : bool{
        return $this->server->get('REQUEST_METHOD') == 'DELETE' ? true : false;
    }
    
    /**
     * Gets a boolean value indicating if the request method is a OPTIONS.
     */
    public function isOptions() : bool{
        return $this->server->get('REQUEST_METHOD') == 'OPTIONS' ? true : false;
    }
    
    /**
     * Gets the HTTP request scheme.
     */
    public function getScheme() : string{
        return $this->server->get('REQUEST_SCHEME');
    }
    
    /**
     * Gets the user agent string of the client.
     */
    public function getUserAgent() : string{
        return $this->server->get('HTTP_USER_AGENT', '');
    }
    
    /**
     * Gets information about the URL of the client's previous request.
     */
    public function getUrlReferrer() : string{
        return $this->server->get('HTTP_REFERER', '');
    }
    
    /**
     * Gets the IP address of the remote client.
     */
    public function getClientAddress() : string{
        return $this->server->get('REMOTE_ADDR', '');
    }
    
    /**
     * Gets the host name of the remote client.
     */
    public function getClientHostName() : string{
        return $this->server->get('REMOTE_HOST', '');
    }
    
    /**
     * Gets the raw request body if it exists.
     */
    public function getBody() : string{
        $body = fopen('php://input', 'r');
        return $body ? $body : '';
    }
}