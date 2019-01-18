<?php

namespace Core\Configuration;

class ExceptionHandlerSection implements IConfigurationSection{
    
    public function execute(Configuration $configuration, \XmlConfigElement $xml){

        $exceptionHandlers = [];

        if($xml->hasPath('exceptionHandlers.0.handler')){
            foreach($xml->exceptionHandlers[0]->handler as $errorHandler){
                $exceptionHandlers[] = (object)['exception' => (string)$errorHandler->exception[0], 'class' => (string)$errorHandler->class[0]];
            }
        }

        $configuration->add('exceptionHandlers', $exceptionHandlers);
    }
}

