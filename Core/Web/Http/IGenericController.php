<?php

namespace Core\Web\Http;

use Core\Configuration\Configuration;

/**
 * A generic interface controller which must be implemented to handle 
 * HTTP requests.
 */
interface IGenericController{

    /**
     * Called by the Application class to respond to a HTTP request.
     */
    public function service(Configuration $config, HttpContext $httpContext) : void;
}