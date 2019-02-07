<?php

namespace Core\Web\View\Methods;

class Obj implements IViewMethod{
    
    protected $object = null;
    
    public function __construct(object $object){
        $this->object = $object;
    }
    
     public function execute() : \Closure{
        return function(){
            return $this->object;
        };
    }
}