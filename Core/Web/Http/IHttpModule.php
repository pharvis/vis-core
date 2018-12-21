<?php

namespace Core\Web\Http;

use Core\Web\Http\HttpContext;

interface IHttpModule{
    
    public function load(HttpContext $controller);
    public function unload(HttpContext $controller);
}