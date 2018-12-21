<?php

namespace Core\Configuration;

class ConfigurationManager{
    
    private $configuration = null;
    
    public function __construct(\SimpleXMLElement $xml){
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
    
    public function __debuginfo(){
        return [$this->configuration];
    }
}
