<?php

namespace Core\Web\View\Methods;

class Obj extends ViewMethod{
    
    protected $object = null;
    
    public function __construct($object){
        $this->object = $object;
    }
    
    public function execute(){
        return $this->object;
    }
}