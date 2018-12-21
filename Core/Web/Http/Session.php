<?php

namespace Core\Web\Http;

class Session{
    
    protected $collection = [];
    protected $sessionActive = false;
    
    public function start() : Session{
        if(!$this->sessionActive){
            session_start();
            $this->collection = &$_SESSION;
            $this->sessionActive = true;
        }
        return $this;
    }
    
    public function set(string $key, $value) : Session{
        $this->collection[$key] = $value;
        return $this;
    }
    
    public function get(string $key, $default = null){
        if($this->exists($key)){
            return $this->collection[$key];
        }
        return $default;
    }
    
    public function exists(string $key) : bool{
        return array_key_exists($key, $this->collection);
    }
    
    public function remove(string $key) : bool{
        if($this->exists($key)){
            unset($this->collection[$key]);
            return true;
        }
        return false;
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
    
    public function isActive() : bool{
        return $this->sessionActive;
    }

    public function destroy() : bool{
        return session_destroy();
    }
}