<?php

namespace Core\Web\View\Methods;

/**
 * An interface required to implement view methods.
 */
interface IViewMethod{
    
    /**
     * Gets a Closure that will be bound to a view, which supports view methods. 
     */
    public function getClosure() : \Closure;
}