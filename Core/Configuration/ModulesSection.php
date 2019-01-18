<?php

namespace Core\Configuration;

use Core\Common\Str;
use Core\Web\Http\HttpException;
use Core\Web\Http\IHttpModule;

class ModulesSection implements IConfigurationSection{
    
    public function execute(Configuration $configuration, \XmlConfigElement $xml){

        $modules = [];
         
        if($xml->hasPath('modules.0.module')){
  
            foreach($xml->modules[0]->module as $module){
               $moduleClass = (string)Str::set($module)->replace('.', '\\');

               $moduleInstance = new $moduleClass();

               if(!$moduleInstance instanceof IHttpModule){
                   throw new HttpException("HttpModule '$moduleClass' must inherit from IHttpModule");
               }
               $modules[] = $moduleInstance;
           }
        }

        $configuration->add('modules', $modules);
    }
}

