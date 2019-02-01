<?php

namespace Core\Configuration;

/**
 * Handles the settings element in an XML configuration file.
 */
class SettingsSection implements IConfigurationSection{
    
    private $settings = [];
    
    /**
     * Gets an Arr object of application settings by processing the 
     * settings XML element.
     */
    public function execute(Configuration $config, \XmlConfigElement $xml){
        
        if($xml->hasPath('settings.0.section')){
            $this->loadSettings($xml->settings[0]);
        }

        return new \Core\Common\Arr($this->settings);
    }
    
    private function loadSettings($settings){ 
        
        foreach($settings->section as $section){
            $sectionAttributes = $section->getAttributes();
            
            if(array_key_exists('name', $sectionAttributes)){
                foreach($section->property as $property){
                    $propertyAattributes = $property->getAttributes();
                    if(array_key_exists('name', $propertyAattributes)){
                        $this->settings[$sectionAttributes['name']][$propertyAattributes['name']] = (string)$property;
                    }
                }
            }
        }
        
        $settingsAttributes = $settings->getAttributes();

        if(array_key_exists('include', $settingsAttributes)){
            if(is_file($settingsAttributes['include'])){
                $settingsConfig = new \XmlConfigReader($settingsAttributes['include']);
                $this->loadSettings($settingsConfig->settings[0]);
            }else{
                throw new ConfigurationException(sprintf("Unable to include configuration section. File '%s' not found.", $settingsAttributes['include']));
            }
        }
    }
}

