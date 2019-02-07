<?php

namespace Core\Web\Http;

/**
 * Encapsulates information about the requested URL.
 */
class Url {
    
    private $httpScheme = '';
    private $host = '';
    private $rawUri = '';
    private $uri = '';
    private $url = '';
    private $baseUrl = '';

    /**
     * Initializes a new instance of Response with server variables.
     */
    public function __construct(Server $server){
        $this->httpScheme = $server->get('REQUEST_SCHEME');
        $this->host = $server->get('HTTP_HOST');
        $this->rawUri = $server->get('REQUEST_URI');
        
        if($this->rawUri && strpos($this->rawUri, '?') > -1){
            $this->uri = substr($this->rawUri, 0, strpos($this->rawUri, '?'));
        }else{
            $this->uri = $this->rawUri;
        }

        $port = $server->get('SERVER_PORT') != 80 ? ':' . $server->get('SERVER_PORT') : '';
        $this->baseUrl = $this->httpScheme . '://' . $this->host . $port;
        $this->url = $this->httpScheme . '://' . $this->host . $port . '/' . $this->rawUri;
    }
    
    /**
     * Gets the HTTP scheme.
     */
    public function getHttpScheme() : string{
        return $this->httpScheme;
    }
    
    /**
     * Gets the host name.
     */
    public function getHost() : string{
        return $this->host;
    }
    
    /**
     * Gets the raw request uri including query parameters.
     */
    public function getRawUri() : string{
        return $this->rawUri;
    }
    
    /**
     * Gets the request uri excluding query parameters.
     */
    public function getUri() : string{
        return $this->uri;
    }
    
    /**
     * Gets the base url excluding the uri.
     */
    public function getBaseUrl() : string{
        return $this->baseUrl;
    }
    
    public function __toString(){
        return $this->url;
    }
}