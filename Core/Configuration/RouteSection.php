<?php

namespace Core\Configuration;

use Core\Common\Obj;
use Core\Web\Routing\Route;

/**
 * Handles the routes element in an XML configuration file.
 */
class RouteSection implements IConfigurationSection{
    
    /**
     * Gets an array of Route objects by processing the routes XML element.
     */
    public function execute(Configuration $config, \XmlConfigElement $xml){
        
        $routes = [];

        if($xml->hasPath('routing.0.route')){
            foreach($xml->routing[0]->route as $route){

                $patterns = $route->urls[0]->urlPattern;

                foreach($patterns as $pattern){
                    $routes[] = new Route(
                        $pattern,
                        $route->class[0],
                        Obj::create('Core.Web.Routing.RouteHandler')->get()    
                    );
                }
            }
        }
        
        return $routes;
    }
}

