<?php

namespace Core\Web\View\Methods;

class ViewMethods implements \IteratorAggregate{
    
    protected $methods = null;
    
    public function __construct(){
        $this->methods = new \Core\Common\Arr();
    }
    
    public function add(string $name, IViewMethod $method) : ViewMethods{
        $this->methods->add($name, $method);
        return $this;
    }
    
    public function get(string $name) : IViewMethod{
        return $this->methods->get($name);
    }
    
    public function exists(string $name) : bool{
        return $this->methods->exists($name);
    }
    
    public function getIterator(){
        return $this->methods->getIterator();
    }
}