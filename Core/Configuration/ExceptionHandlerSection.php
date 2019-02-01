<?php

namespace Core\Configuration;

/**
 * Handles the exceptionHandlers element in an XML configuration file.
 */
class ExceptionHandlerSection implements IConfigurationSection{
    
    /**
     * Gets an array of Exception handler classes by processing the 
     * exceptionHandlers XML element.
     */
    public function execute(Configuration $config, \XmlConfigElement $xml){

        $exceptionHandlers = [];

        if($xml->hasPath('exceptionHandlers.0.handler')){
            foreach($xml->exceptionHandlers[0]->handler as $errorHandler){
                $exceptionHandlers[] = (object)['exception' => (string)$errorHandler->exception[0], 'class' => (string)$errorHandler->class[0]];
            }
        }

        return $exceptionHandlers;
    }
}

