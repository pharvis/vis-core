<?php

namespace Core\Web\Http;

/**
 * Represents an HTTP cookie. This class cannot be inherited.
 */
final class Cookie{
    
    private $name = '';
    private $value = '';
    private $expires = 0;
    private $path = '/';
    private $domain = '';
    private $secure = false;
    private $httpOnly = true;

    /**
     * Initializes a new instance of Cookie with a cookie $name and $value.
     */
    public function __construct(string $name, string $value){
        $this->name = $name;
        $this->value = $value;
    }
    
    /**
     * Gets the cookie name.
     */
    public function getName() : string{
        return $this->name;
    }
    
    /**
     * Gets the cookie value.
     */
    public function getValue() : string{
        return $this->value;
    }
    
    /**
     * Sets the cookie expiration time in seconds. Gets the current 
     * cookie instance.
     */
    public function setExpires(int $seconds) : Cookie{
        $this->expires = $seconds;
        return $this;
    }
    
    /**
     * Gets the cookie expiration time in seconds.
     */
    public function getExpires() : int{
        return $this->expires;
    }
    
    /**
     * Sets the cookie path. Gets the current cookie instance.
     */
    public function setPath(string $path) : Cookie{
        $this->path = $path;
        return $this;
    }
    
    /**
     * Gets the cookie path.
     */
    public function getPath() : string{
        return $this->path;
    }
    
    /**
     * Sets the cookie domain. Gets the current cookie instance.
     */
    public function setDomain(string $domain) : Cookie{
        $this->domain = $domain;
        return $this;
    }
    
    /**
     * Gets the domain path.
     */
    public function getDomain() : string{
        return $this->domain;
    }
    
    /**
     * Sets a boolean value indicating if the cookie should be secure. Gets the current cookie instance.
     */
    public function setSecure(bool $secure) : Cookie{
        $this->secure = $secure;
        return $this;
    }
    
    /**
     * Gets a boolean value indicating if the cookie is secure.
     */
    public function getSecure() : bool{
        return $this->secure;
    }
    
    /**
     * Sets a boolean value indicating if the cookie should be HTTP only. Gets the current cookie instance.
     */
    public function setHttpOnly(bool $httpOnly) : Cookie{
        $this->httpOnly = $httpOnly;
        return $this;
    }
    
    /**
     * Gets a boolean value indicating if the cookie is HTTP only.
     */
    public function getHttpOnly() : bool{
        return $this->httpOnly;
    }
}