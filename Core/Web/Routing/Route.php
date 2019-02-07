<?php

namespace Core\Web\Routing;

use Core\Web\Http\Request;
use Core\Web\Routing\RouteHandler;

/**
 * Handles a route defined in web.xml using a RouteHandler.
 */
class Route{

    protected $urlPattern = '';
    protected $controllerClass = '';
    protected $routeHandler = null;
    
    /**
     * Initializes a new instance of Route a $urlPattern, $routeHandler and the
     * controller class associated with the route.
     */
    public function __construct(string $urlPattern, string $controllerClass, RouteHandler $routeHandler){
        $this->urlPattern = $urlPattern;
        $this->controllerClass = $controllerClass;
        $this->routeHandler =  $routeHandler;
    }

    /**
     * Gets the controller class associated with the current Route instance.
     */
    public function getControllerClass() : string{
        return $this->controllerClass;
    }

    /**
     * Executes the associated RouteHandler, which returns a boolean value
     * indicating if the route matched the requested uri.
     */
    public function execute(Request $request) : bool{
        return $this->routeHandler->execute($request, $this->urlPattern);
    }
}