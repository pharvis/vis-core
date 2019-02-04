<?php

namespace Core\Web\Routing;

use Core\Web\Http\Request;

class RouteHandler{
    
    public function execute(Request $request, string $urlPattern) : bool{

        $pattern = str_replace('{', '(?P<', str_replace('}', '>[a-zA-Z0-9-_.,:;()]+)', $urlPattern));
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