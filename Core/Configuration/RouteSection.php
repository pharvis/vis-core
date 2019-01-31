<?php

namespace Core\Configuration;

use Core\Web\Routing\Route;

class RouteSection implements IConfigurationSection{
    
    public function execute(Configuration $configuration, \XmlConfigElement $xml){
        $routes = [];

        if($xml->hasPath('routing.0.route')){
            foreach($xml->routing[0]->route as $route){

                $patterns = $route->urls[0]->urlPattern;

                foreach($patterns as $pattern){
                    $routes[] = new Route(
                        $pattern,
                        'Core.Web.Routing.RouteHandler',
                        $route->class[0]
                    );
                }
            }
        }
        
        $configuration->add('routes', $routes);
    }
}

