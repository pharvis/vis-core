<?php

namespace Core\Configuration;

use Core\Common\Obj;
use Core\Common\Str;
use Core\Web\Http\HttpException;
use Core\Web\Http\IHttpModule;

class ModulesSection implements IConfigurationSection{
    
    public function execute(Configuration $configuration, \SimpleXMLElement $xml){

        $modules = [];
        
        foreach((array)$xml->modules->module as $module){
            $moduleClass = (string)Str::set($module)->replace('.', '\\');

            if(Obj::exists($moduleClass)){
                $moduleInstance = new $moduleClass();

                if(!$moduleInstance instanceof IHttpModule){
                    throw new HttpException("HttpModule '$moduleClass' must inherit from IHttpModule");
                }
                $modules[] = $moduleInstance;
            }else{
                throw new HttpException("HttpModule '$moduleClass' not found");
            }
        }
        $configuration->add('modules', $modules);
        unset($modules);
    }
}

