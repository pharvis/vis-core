<?php

namespace Core\Web\Http;

use Core\Common\Arr;

class Session{
    
    protected $collection = null;
    protected $sessionActive = false;
    
    public function __construct(){
        $this->collection = new Arr(); 
    }

    public function start() : Session{
        if(!$this->sessionActive){
            session_start();
            $session = &$_SESSION;
            $this->collection = new Arr($session); 
            $this->sessionActive = true;
        }
        return $this;
    }
    
    public function set($key, $value) : Session{
        $this->collection->add($key, $value);
        return $this;
    }
    
    public function get(string $key, $default = null){
        return $this->collection->get($key, $default);
    }
    
    public function exists($key) : bool{
        return $this->collection->exists($key);
    }
    
    public function remove($key) : bool{
         $this->collection->remove($key);
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