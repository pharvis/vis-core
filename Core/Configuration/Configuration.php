<?php

namespace Core\Configuration;

/**
 * Encapsulates configuration data contained in web.xml. This class cannot be inherited.
 */
final class Configuration{
    
    private $collection = [];
    private $xml = null;

    /**
     * Initializes a new instance of Configuration with an XmlConfigElement object.
     */
    public function __construct(\XmlConfigElement $xml){
        $this->xml = $xml;
    }
    
    /**
     * Adds a configuration section. Throws ConfigurationException if the
     * configuration section name already exists.
     */
    public function add(string $name, ConfigurationSection $section) : Configuration{
        if(!$this->exists($name, $this->collection)){
            $section->setConfiguration($this);
            $this->collection[$name] = $section->execute($this->xml);
        }else{
            throw new ConfigurationException(sprintf("Configuration section '%s' already exists. Section cannot be overriden.", $name), $name);
        }
        return $this;
    }
    
    /**
     * Gets a configuration section by the specified section $name. Returns false
     * if the section does not exist.
     */
    public function get(string $name){
        if($this->exists($name)){
            return $this->collection[$name];
        }
        return false;
    }
    
    /**
     * Gets a boolean value indicating if the configuration section exists.
     */
    public function exists(string $name) : bool{
        return array_key_exists($name, $this->collection);
    }
    
    /**
     * Stops vardump/print_r from displaying configuration data. Only the 
     * configuration section names are returned to indicate which sections
     * have been loaded.
     */
    public function __debugInfo(){
        return array_keys($this->collection);
    }
}