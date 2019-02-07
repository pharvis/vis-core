<?php

namespace Core\Web\View;

/**
 * Defines the methods that are required for a view.
 */
interface IView{
    
    /**
     * Gets the string output of a view. Accepts an array of parameters to be used in the view.
     */
    public function render(array $params = []) : string;
}