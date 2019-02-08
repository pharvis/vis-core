<?php

namespace Core\Web\View\Methods;

/**
 * A view method to handle converting of special characters to HTML entities.
 */
class Escape implements IViewMethod{
    
    /**
     * Gets a Closure to convert special characters to HTML entities.
     */
    public function getClosure() : \Closure{
        return function(string $string, string $encoding = 'UTF-8'){
            return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, $encoding, false);
        };
    }
}