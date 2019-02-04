<?php

namespace Core\Web\Http;

use Core\Configuration\Configuration;

/**
 * An exception controller that handles uncaught exceptions. 
 */
class ExceptionController implements IGenericController{
    
    /**
     * Writes exception details to the browser.
     */
    public function service(Configuration $config, HttpContext $httpContext) : void{
        $httpContext->getResponse()->write($httpContext->getRequest()->getException()->getMessage());
    }
}
