<?php

namespace Core\Web\Http;

use Core\Configuration\Configuration;

interface IGenericController{

    public function service(Configuration $config, HttpContext $httpContext) : void;
}