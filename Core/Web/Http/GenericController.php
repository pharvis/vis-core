<?php

namespace Core\Web\Http;

use Core\Configuration\ConfigurationManager;

abstract class GenericController{
    
    private $configManager = null;
    
    public function __construct(ConfigurationManager $configManager){
        $this->configManager = $configManager;
    }
    
    public function getConfigurationManager() : ConfigurationManager{
        return $this->configManager;
    }
    
    public abstract function service(HttpContext $httpContext) : void;
    
}