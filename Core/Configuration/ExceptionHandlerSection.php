<?php

namespace Core\Configuration;

class ExceptionHandlerSection extends ConfigurationSection{
    
    public function execute(\XmlConfigElement $xml){

        $exceptionHandlers = [];

        if($xml->hasPath('exceptionHandlers.0.handler')){
            foreach($xml->exceptionHandlers[0]->handler as $errorHandler){
                $exceptionHandlers[] = (object)['exception' => (string)$errorHandler->exception[0], 'class' => (string)$errorHandler->class[0]];
            }
        }

        return $exceptionHandlers;
    }
}

