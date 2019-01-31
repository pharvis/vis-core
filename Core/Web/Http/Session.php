<?php

namespace Core\Web\Http;

class Session{
    
    protected $collection = [];
    protected $options = [];
    
    public function __construct(array $options = []){
        $this->setOptions($options);
    }
    
    public function setOptions(array $options) : Session{
        $params = array_merge(session_get_cookie_params(), $options);
        session_set_cookie_params($params['lifetime'], $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        return $this;
    }
    
    public function getOptions() : array{
        return session_get_cookie_params();
    }

    public function start() : Session{
        session_start();
        $this->collection = &$_SESSION;
        return $this;
    }
    
    public function set(string $key, $value) : Session{
        $this->sessionActive();
        $this->collection[$key] = $value;
        return $this;
    }
    
    public function get(string $key, $default = null){
        $this->sessionActive();
        if($this->exists($key)){
            return $this->collection[$key];
        }
        return $default;
    }
    
    public function exists(string $key) : bool{
        $this->sessionActive();
        return array_key_exists($key, $this->collection);
    }
    
    public function remove(string $key) : bool{
        $this->sessionActive();
        if($this->exists($key)){
            unset($this->collection[$key]);
            return true;
        }
        return false;
    }
    
    public function clear() : void{
        $this->sessionActive();
        $this->collection = [];
    }
    
    public function setName(string $name) : Session{
        session_name($name);
        return $this;
    }
    
    public function getName() : string{
        return session_name();
    }
    
    public function regenerate() : Session{
        session_regenerate_id();
        return $this;
    }
    
    public function getSessionId() : string{
        return session_id(); 
    }
    
    public function getStatus() : int{
        return session_status();
    }

    public function destroy() : bool{
        $this->sessionActive();
        
        if (ini_get("session.use_cookies")){
            setcookie(session_name(), '', -1);
        }
        return session_destroy();
    }
    
    private function sessionActive(){
        if(session_status() != PHP_SESSION_ACTIVE){
            throw new \Core\Web\Http\SessionException("Session not active");
        }
    }
}