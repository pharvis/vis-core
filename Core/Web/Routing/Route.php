<?php

namespace Core\Web\Routing;

use Core\Web\Http\Request;
use Core\Web\Routing\IRouteHandler;

/**
 * Handles a route defined in web.xml using a RouteHandler.
 */
class Route{

    protected $urlPattern = '';
    protected $controllerClass = '';
    protected $routeHandler = null;
    
    /**
     * Initializes a new instance of Route with a $urlPattern, $controllerClass 
     * and an instance of IRouteHandler.
     */
    public function __construct(string $urlPattern, string $controllerClass, IRouteHandler $routeHandler){
        $this->urlPattern = $urlPattern;
        $this->controllerClass = $controllerClass;
        $this->routeHandler =  $routeHandler;
    }
    
    /**
     * Gets the URL pattern associated with the current Route instance.
     */
    public function getUrlPattern() : string{
        return $this->urlPattern;
    }

    /**
     * Sets the controller class associated with the current Route instance.
     */
    public function setControllerClass(string $controllerClass){
        $this->controllerClass = $controllerClass;
    }
    
    /**
     * Gets the controller class associated with the current Route instance.
     */
    public function getControllerClass() : string{
        return $this->controllerClass;
    }

    /**
     * Executes the associated RouteHandler, which returns a boolean value
     * indicating if the route matched the requested URI.
     */
    public function execute(Request $request) : bool{
        return $this->routeHandler->execute($request, $this);
    }
}