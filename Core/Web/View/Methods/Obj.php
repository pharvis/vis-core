<?php

namespace Core\Web\View\Methods;

/**
 * A view method that can inject an object into a view.
 */
class Obj implements IViewMethod{
    
    protected $object = null;
    
    /**
     * Initializes a new instance of Obj with an $object.
     */
    public function __construct(object $object){
        $this->object = $object;
    }
    
    /**
     * Gets a Closure that returns the $object.
     */
    public function getClosure() : \Closure{ 
        $parent = $this;
        return function() use($parent){
            return $parent->object;
        };
    }
}