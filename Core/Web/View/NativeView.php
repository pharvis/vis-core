<?php

namespace Core\Web\View;

use Core\Common\Str;
use Core\Common\Arr;
use Core\Web\View\Methods\ViewMethods;

/**
 * Renders a PHP view.
 */
class NativeView implements IView{
    
    protected $basePath = '';
    protected $childOutput = '';
    protected $viewFiles = null;
    protected $layoutView = null;
    protected $parameters = null;
    protected $methods = null;
    
    /**
     * Initializes a new instance of NativeView with an optional 
     * NativeView $layoutView.
     */
    public function __construct(NativeView $layoutView = null){
        $this->layoutView = $layoutView;
        $this->viewFiles = new Arr();
        $this->parameters = new Arr();
        $this->methods = new ViewMethods();
    }
    
    /**
     * Sets the layout view for the current NativeView object.
     */
    public function setLayout(string $viewFile) : void{
        $this->layoutView = new NativeView();
        $this->layoutView->setBasePath($this->basePath);
        $this->layoutView->getViewFiles()->add($viewFile);
    }
    
    /**
     * Sets the base path of the view file.
     */
    public function setBasePath(string $basePath){
        $this->basePath = $basePath;
    }
    
    /**
     * Gets the base path of the view file.
     */
    public function getBasePath() : string{
        return $this->basePath;
    }
    
    /**
     * Gets an Arr object of view file locations.
     */
    public function getViewFiles() : Arr{
        return $this->viewFiles;
    }
    
    /**
     * Gets a ViewMethods object of view methods.
     */
    public function getViewMethods() : ViewMethods{
        return $this->methods;
    }

    /**
     * Gets an Arr object of view parameters.
     */
    public function getParameters() : Arr{
        return $this->parameters;
    }

    /**
     * Renders a child view inside a layout view.
     */
    public function renderBody() : void{
        echo $this->childOutput;
    }

    /**
     * Returns the string output of a rendered view.
     */
    public function render(array $params = []) : string{ 
        $this->parameters->merge($params);
        extract($this->parameters->toArray());
        $output = '';

        foreach($this->viewFiles as $viewFile){
            if(Str::set($viewFile)->subString(0,1) == '~'){
                $viewFile = $this->basePath . (string)Str::set($viewFile)->subString(1);
            }

            if(!is_file($viewFile)){
                continue;
            }

            ob_start();
            include $viewFile;
            $output = ob_get_clean();
            
            if($this->layoutView !== null){ 
                $this->layoutView->setBasePath($this->basePath);
                foreach($this->methods as $name => $viewMethod){
                    $this->layoutView->getViewMethods()->add($name, $viewMethod);
                }
                $this->layoutView->setChildOutput($output); 
                $output =  $this->layoutView->render($this->parameters->toArray());
            }
            return $output;
        }
        throw new ViewFileNotFoundException("The view file was not found. Searched the following locations: " . $this->viewFiles->join('; '), $this->viewFiles->toArray());
    }
    
    public function __call($name, $arguments){ 
        if($this->methods->exists($name)){
            $closure = $this->methods->get($name)->getClosure();
            $method = $closure->bindTo($this);
            return $method(...$arguments);
        }
        throw new \Exception(sprintf("Call to undefined function %s()", $name));
    }
    
    private function setChildOutput(string $childOutput){
        $this->childOutput = $childOutput;
    }
}