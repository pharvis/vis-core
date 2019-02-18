<?php

namespace Core\Web\Routing;

use Core\Web\Http\Request;

/**
 * A RouteHandler class provides the logic to determine if a route matched the
 * request uri.
 */
class RouteHandler implements IRouteHandler{
    
    /**
     * Gets a boolean value indicating if the request URI matched a route pattern.
     * This method is called internally by the application class.
     */
    public function execute(Request $request, Route $route) : bool{

        $pattern = str_replace('{', '(?P<', str_replace('}', '>[a-zA-Z0-9-_.,:;()]+)', $route->getUrlPattern()));
        $matches = [];

        if(preg_match('#^'.$pattern.'$#', $request->getUrl()->getUri(), $matches)){
            foreach($matches as $key => $value){
                if(!is_int($key)){
                    $request->getParameters()->add($key, $value);
                }
            }
            return true;
        }
        return false;
    }
}