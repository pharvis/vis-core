<?php

namespace Core\Web\Http;

use Core\Configuration\Configuration;

class ExceptionController implements IGenericController{
    
    public function service(Configuration $config, HttpContext $httpContext) : void{
        $httpContext->getResponse()->write($httpContext->getRequest()->getException()->getMessage());
    }
}
