<?php

namespace Core\Configuration;

class ConfigurationManager{
    
    private $xml = null;
    private $configuration = null;
    
    public function __construct(\XmlConfigElement $xml){
        $this->xml = $xml;
        $this->configuration = new Configuration();
    }
    
    public function getConfiguration(){
        return $this->configuration;
    }
    
    public function executeSection(IConfigurationSection $section){
        $section->execute($this->configuration, $this->xml);
        return $this;
    }
}
