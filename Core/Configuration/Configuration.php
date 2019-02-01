<?php

namespace Core\Configuration;

/**
 * Encapsulates configuration data contained in web.xml. This class cannot be inherited.
 */
final class Configuration{
    
    private $collection = [];
    private $xml = null;


    public function __construct(\XmlConfigElement $xml){
        $this->xml = $xml;
    }
    
    /**
     * Adds a configuration section 
     */
    public function add(string $name, ConfigurationSection $section) : Configuration{
        if(false === array_key_exists($name, $this->collection)){
            $section->setConfiguration($this);
            $this->collection[$name] = $section->execute($this->xml);
        }else{
            throw new ConfigurationException(sprintf("Configuration section '%s' already exists. Section cannot be overriden.", $name));
        }
        return $this;
    }
    
    public function get(string $name){
        if($this->exists($name)){
            return $this->collection[$name];
        }
        return false;
    }
    
    public function exists(string $name) : bool{
        return array_key_exists($name, $this->collection);
    }
    
    public function __debugInfo(){
        return array_keys($this->collection);
    }
}