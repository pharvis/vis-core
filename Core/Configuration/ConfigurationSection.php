<?php

namespace Core\Configuration;

abstract class ConfigurationSection{
    
    private $config = null;
    
    public function setConfiguration(Configuration $config){
        $this->config = $config;
    }
    
    public function getConfiguration() : Configuration{
        return $this->config;
    }

    public abstract function execute(\XmlConfigElement $xml);
}