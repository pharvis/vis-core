<?php

namespace Core\Web\Http;

use Core\Common\Arr;
use Core\Common\Str;

/**
 * Encapsulates HTTP client response information. This class cannot be inherited.
 */
final class Response{
    
    private $server = null;
    private $cookies = null;
    private $output = null;
    private $headers = [];
    private $statusCode = 200;
    private static $statusCodes = array(
        //Informational 1xx
        100 => '100 Continue',
        101 => '101 Switching Protocols',
        //Successful 2xx
        200 => '200 OK',
        201 => '201 Created',
        202 => '202 Accepted',
        203 => '203 Non-Authoritative Information',
        204 => '204 No Content',
        205 => '205 Reset Content',
        206 => '206 Partial Content',
        //Redirection 3xx
        300 => '300 Multiple Choices',
        301 => '301 Moved Permanently',
        302 => '302 Found',
        303 => '303 See Other',
        304 => '304 Not Modified',
        305 => '305 Use Proxy',
        306 => '306 (Unused)',
        307 => '307 Temporary Redirect',
        //Client Error 4xx
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        402 => '402 Payment Required',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        406 => '406 Not Acceptable',
        407 => '407 Proxy Authentication Required',
        408 => '408 Request Timeout',
        409 => '409 Conflict',
        410 => '410 Gone',
        411 => '411 Length Required',
        412 => '412 Precondition Failed',
        413 => '413 Request Entity Too Large',
        414 => '414 Request-URI Too Long',
        415 => '415 Unsupported Media Type',
        416 => '416 Requested Range Not Satisfiable',
        417 => '417 Expectation Failed',
        422 => '422 Unprocessable Entity',
        423 => '423 Locked',
        //Server Error 5xx
        500 => '500 Internal Server Error',
        501 => '501 Not Implemented',
        502 => '502 Bad Gateway',
        503 => '503 Service Unavailable',
        504 => '504 Gateway Timeout',
        505 => '505 HTTP Version Not Supported'
    );

    /**
     * Initializes a new instance of Response with server variables.
     */
    public function __construct(Server $server){
        $this->server = $server; 
        $this->cookies = new CookieCollection();
        $this->headers = new Arr();
        $this->output = new Str();
    }
    
    /**
     * Sets the response content type and encoding. Gets the current Response object.
     */
    public function setContentType(string $contentType, string $encoding = 'UTF8') : Response{
        $this->headers->add('Content-Type', $contentType . '; charset=' . $encoding);
        return $this;
    }
    
    /**
     * Sets the response status code. Gets the current Response object.
     */
    public function setStatusCode(int $statusCode) : Response{
        $this->statusCode = $statusCode;
        return $this;
    }
    
    /**
     * Gets the response headers collection.
     */
    public function getHeaders() : Arr{
        return $this->headers;
    }
    
    /**
     * Gets the response cookie collection.
     */
    public function getCookies() : CookieCollection{
        return $this->cookies;
    }

    /**
     * Appends response data to the current Response object. Gets the current
     * Response object.
     */
    public function write(string $string) : Response{
        $this->output->append($string);
        return $this;
    }
    
    /**
     * Redirects the client to the specified $location.
     */
    public function redirect(string $location) : void{
        header('Location: ' . $location);
        exit;
    }
    
    /**
     * Flushes all response data including headers and cookies to the client.
     */
    public function flush() : void{
        if(!headers_sent()){ 

            if(array_key_exists($this->statusCode, static::$statusCodes)){
                header($this->server->get('SERVER_PROTOCOL', 'HTTP/1.0') . ' ' . static::$statusCodes[$this->statusCode]);
            }
            
            foreach($this->headers as $header => $value){
                header($header . ':'. $value, true);
            }

            foreach($this->cookies as $cookie){
                setcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpires(), $cookie->getPath(), $cookie->getDomain(), $cookie->getSecure(), $cookie->getHttpOnly());
            }
            
            echo $this->output;
        }
        exit;
    }
}