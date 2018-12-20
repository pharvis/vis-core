<?php

namespace Core\Web\Routing;

use Core\Common\Obj;
use Core\Web\Http\Request;
use Core\Web\Http\HttpException;
use Core\Web\Routing\RouteHandler;

class Route{

    protected $urlPattern;
    protected $routeHandler;
    protected $controllerClass;
    
    public function __construct(string $urlPattern, string $routeHandler, string $controllerClass){
        $this->urlPattern = $urlPattern;
        $this->routeHandler =  Obj::create($routeHandler)->get();
        $this->controllerClass = $controllerClass;
    }
    
    public function getControllerClass() : string{
        return $this->controllerClass;
    }

    public function execute(Request $request){
        if($this->routeHandler instanceof RouteHandler){
            return $this->routeHandler->execute($request, $this->urlPattern);
        }
        throw new HttpException(sprintf('RouteHandler class "%s" must inherit from Core\Web\Routing\RouteHandler', get_class($this->routeHandler)));
    }
}