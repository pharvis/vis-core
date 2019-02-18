<?php

namespace Core\Web\Routing;

use Core\Web\Http\Request;

/**
 * An interface that defines the required method to process a Route.
 */
interface IRouteHandler{
    
    /**
     * Called by the Application class. 
     */
    public function execute(Request $request, Route $route) : bool;
}