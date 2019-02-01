<?php

namespace Core\Configuration;

/**
 * Thrown when a configuration section is being added but already exists.
 */
class ConfigurationException extends \Exception{
    
    protected $section = '';
    
    /**
     * Initializes a new instance of ConfigurationException with an error message
     * and section name.
     */
    public function __construct(string $message, string $section){
        parent::__construct($message);
        $this->section = $section;
    }
    
    /**
     * Gets the section name.
     */
    public function getSection() : string{
        return $this->section;
    }
}