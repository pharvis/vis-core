<?php

namespace Core\Web\Http;

final class Cookie{
    
    private $name = '';
    private $value = '';
    private $expires = 0;
    private $path = '/';
    private $domain = '';
    private $secure = false;
    private $httpOnly = true;

    public function __construct(string $name, string $value){
        $this->name = $name;
        $this->value = $value;
    }
    
    public function getName() : string{
        return $this->name;
    }
    
    public function getValue(){
        return $this->value;
    }
    
    public function setExpires(int $seconds) : Cookie{
        $this->expires = $seconds;
        return $this;
    }
    
    public function getExpires() : int{
        return $this->expires;
    }
    
    public function setPath(string $path) : Cookie{
        $this->path = $path;
        return $this;
    }
    
    public function getPath() : string{
        return $this->path;
    }
    
    public function setDomain(string $domain) : Cookie{
        $this->domain = $domain;
        return $this;
    }
    
    public function getDomain() : string{
        return $this->domain;
    }
    
    public function setSecure(bool $secure) : Cookie{
        $this->secure = $secure;
        return $this;
    }
    
    public function getSecure() : bool{
        return $this->secure;
    }
    
    public function setHttpOnly(bool $httpOnly) : Cookie{
        $this->httpOnly = $httpOnly;
        return $this;
    }
    
    public function getHttpOnly() : bool{
        return $this->httpOnly;
    }
}