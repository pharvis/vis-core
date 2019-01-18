<?php

namespace Core\Web\Http;

use Core\Common\Arr;

final class Request{
    
    private $server = null;
    private $url = null;
    private $exception = null;
    private $parameter = null;
    private $get = null;
    private $post = null;
    private $session = null;

    public function __construct(Server $server){
        $this->server = $server;
        $this->url = new Url($server);
        $this->parameter = new Arr();
        $this->get = new Arr($_GET);
        $this->post = new Arr($_POST);
        $this->session = new Session();
    }
    
    public function getUrl() : Url{
        return $this->url;
    }
    
    public function getMethod(){
        return $this->server->get('REQUEST_METHOD', 'GET');
    }
    
    public function setException(\Exception $exception){
        $this->exception = $exception;
    }
    
    public function getException() : \Exception{
        return $this->exception;
    }
    
    public function addParameter(string $name, string $value){
        $this->parameter->add($name, $value);
    }
    
    public function getParameters() : Arr{
        return $this->parameter;
    }
    
    public function getCollection() : Arr{
        return new Arr(array_merge($this->parameter->toArray(), $this->get->toArray(), $this->post->toArray()));
    }
    
    public function getServer() : Server{
        return $this->server;
    }
    
    public function getSession() : Session{
        return $this->session;
    }
    
    public function getPost(string $name = '', $default = null){
        if($name){
            return $this->post->get($name, $default);
        }
        return $this->post;
    }
    
    public function isPost() : bool{
        return $this->server->get('REQUEST_METHOD') == 'POST' ? true : false;
    }
}