<?php

namespace Core\Common;

use ReflectionObject;

/**
 * A convenience class to help create and manipulate objects dynamically using
 * reflection. This class cannot be inherited.
 */
final class Obj{
    
    private $object = null;
    
    /**
     * Initializes a new instance of Obj with the object to be reflected.
     */
    public function __construct(object $object){
        $this->object = $object;
    }
    
    /**
     * Gets a boolean value indicating if the supplied object has the specified 
     * $methodName.
     */
    public function hasMethod(string $methodName) : bool{
        $reflect = new ReflectionObject($this->object);
        return $reflect->hasMethod($methodName);
    }
    
    /**
     * Gets a boolean value indicating if the supplied object has the specified 
     * $propertyName.
     */
    public function hasProperty(string $propertyName) : bool{
        $reflect = new ReflectionObject($this->object);
        return $reflect->hasProperty($propertyName);
    }
    
    /**
     * Gets a boolean value indicating if the supplied object has a constructor.
     */
    public function hasConstructor() : bool{
        $reflect = new ReflectionObject($this->object);
        return $reflect->getConstructor() ? true : false;
    }
    
    /**
     * Invokes a method of the supplied object using the specified $methodName.
     */
    public function invokeMethod(string $methodName, array $args){
        $reflect = new \ReflectionMethod($this->object, $methodName);
        return $reflect->invokeArgs($this->object, $args);
    }

    /**
     * Sets the objects properties using the specified array $properties.
     */
    public function setProperties(array $properties = [], array $modifiers = [\ReflectionProperty::IS_PUBLIC, \ReflectionProperty::IS_PROTECTED]) : Obj{
        $reflect = new ReflectionObject($this->object);
        foreach($properties as $key => $value){
            if($reflect->hasProperty($key)){ 
                $property = $reflect->getProperty($key);
                if(in_array($property->getModifiers(), $modifiers)){
                    $property->setAccessible(true);
                    $property->setValue($this->object, $value);
                }
            }
        }
        return $this;
    }
    
    /**
     * Gets the supplied objects constructor or null if the object has 
     * no constructor.
     */
    public function getConstructor(){
        $reflect = new ReflectionObject($this->object);
        return $reflect->getConstructor();
    }
    
    /**
     * Gets any array of method parameters.
     */
    public function getMethodParameters(string $methodName) : array{
        $reflect = new \ReflectionMethod($this->object, $methodName);
        return $reflect->getParameters();
    }

    /**
     * Gets the object.
     */
    public function get() : object{
        return $this->object;
    }

    /**
     * Gets the namespace the object belongs to.
     */
    public function getNamespace() : string{
        $class = get_class($this->object);
        $parts = explode('\\', $class);
        array_pop($parts);
        return join('\\', $parts);
    }

    /**
     * Creates an object using the specified $className. Returns a new instance
     * of Obj.
     */
    public static function create(string $className, array $args = []) : Obj{
        $reflect = new \ReflectionClass(str_replace('.', '\\', $className));

        if(count($args) > 0){
            return new Obj($reflect->newInstanceArgs($args));
        }else{
            return new Obj($reflect->newInstance());
        }
    }
    
    /**
     * Gets a new Obj instance that encapsulates the object to be reflected.
     */
    public static function from(object $object) : Obj{
        return new Obj($object);
    }
    
    /**
     * Gets a boolean value indicating if the specified class exists.
     */
    public static function exists(string $className) : bool{
        return class_exists(str_replace('.', '\\', $className));
    }
}