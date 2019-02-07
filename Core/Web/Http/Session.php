<?php

namespace Core\Web\Http;

/**
 * Encapsulates session information related to a HTTP request.
 */
class Session{
    
    protected $collection = [];
    protected $options = [];
    
    /**
     * Initializes a new instance of Session with an array of session $options.
     */
    public function __construct(array $options = []){
        $this->setOptions($options);
    }
    
    /**
     * Sets an array of session $options. Gets the current Session object.
     */
    public function setOptions(array $options) : Session{
        $params = array_merge(session_get_cookie_params(), $options);
        session_set_cookie_params($params['lifetime'], $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        return $this;
    }
    
    /**
     * Gets an array of session $options.
     */
    public function getOptions() : array{
        return session_get_cookie_params();
    }

    /**
     * Starts a session. Gets the current Session object.
     */
    public function start() : Session{
        session_start();
        $this->collection = &$_SESSION;
        return $this;
    }
    
    /**
     * Sets a value in the session using the specified $name and $value.
     * Gets the current Session object. Throws SessionException if the session
     * is not active.
     */
    public function set(string $name, $value) : Session{
        $this->sessionActive();
        $this->collection[$name] = $value;
        return $this;
    }
    
    /**
     * Gets a session value using the specified $name. If $name does not exist 
     * then returns $default. Throws SessionException if the session
     * is not active.
     */
    public function get(string $name, $default = null){
        $this->sessionActive();
        if($this->exists($name)){
            return $this->collection[$name];
        }
        return $default;
    }
    
    /**
     * Gets a boolean value indicating if the session item exists using the
     * the specified $name. Throws SessionException if the session
     * is not active.
     */
    public function exists(string $name) : bool{
        $this->sessionActive();
        return array_key_exists($name, $this->collection);
    }
    
    /**
     * Removes a session item from the session collection. Returns true if the 
     * item exists and has been removed. Returns false if the item does not exist.
     * Throws SessionException if the session is not active.
     */
    public function remove(string $name) : bool{
        $this->sessionActive();
        if($this->exists($name)){
            unset($this->collection[$name]);
            return true;
        }
        return false;
    }
    
    /**
     * Clears all items from the session collection. Throws SessionException 
     * if the session is not active.
     */
    public function clear() : void{
        $this->sessionActive();
        $this->collection = [];
    }
    
    /**
     * Sets the session name. Gets the current Session object. 
     */
    public function setName(string $name) : Session{
        session_name($name);
        return $this;
    }
    
    /**
     * Gets the session name.
     */
    public function getName() : string{
        return session_name();
    }
    
    /**
     * Regenerates the session ID. Gets the current Session object. 
     */
    public function regenerate() : Session{
        session_regenerate_id();
        return $this;
    }
    
    /**
     * Gets the session ID.
     */
    public function getSessionId() : string{
        return session_id(); 
    }
    
    /**
     * Gets the session status.
     */
    public function getStatus() : int{
        return session_status();
    }

    /**
     * Destroys the session and removes the clients session cookie. Throws 
     * SessionException if the session is not active.
     */
    public function destroy() : bool{
        $this->sessionActive();
        
        if (ini_get("session.use_cookies")){
            setcookie(session_name(), '', -1);
        }
        return session_destroy();
    }
    
    private function sessionActive(){
        if(session_status() != PHP_SESSION_ACTIVE){
            throw new \Core\Web\Http\SessionException("Session not active", session_status());
        }
    }
}