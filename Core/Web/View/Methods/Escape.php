<?php

namespace Core\Web\View\Methods;

class Escape implements IViewMethod{
    
    public function execute() : \Closure{
        return function(string $string){
            return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', false);
        };
    }
}