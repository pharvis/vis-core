<?php

namespace Core\Web\View;

use Core\Common\Str;
use Core\Common\Arr;

class NativeView implements IView{
    
    protected $basePath = '';
    protected $viewFiles = null;
    protected $childOutput = '';
    protected $layoutView = null;
    protected $methods = null;
    protected $parameters = null;
    
    public function __construct(NativeView $layoutView = null){
        $this->layoutView = $layoutView;
        $this->viewFiles = new Arr();
        $this->methods = new Arr();
        $this->parameters = new Arr();
    }
    
    public function setLayout($viewFile){
        $this->layoutView = new NativeView();
        $this->layoutView->setBasePath($this->basePath);
        $this->layoutView->getViewFiles()->add($viewFile);
    }
    
    public function setBasePath(string $basePath){
        $this->basePath = $basePath;
    }
    
    public function getBasePath() : string{
        return $this->basePath;
    }
    
    public function getViewFiles() : Arr{
        return $this->viewFiles;
    }
    
    public function addMethod(string $name, Methods\ViewMethod $method){
        $this->methods->add($name, $method);
        return $this;
    }
    
    public function addMethods(array $methods){
        $this->methods->merge($methods);
        return $this;
    }
    
    public function addParameter(string $name, $value){
        $this->parameters->add($name, $value);
    }

    public function renderBody(){
        echo $this->childOutput;
    }

    public function render(array $params = []){
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
                $this->layoutView->addMethods($this->methods->toArray());
                $this->layoutView->setChildOutput($output); 
                $output =  $this->layoutView->render($params);
            }
            return $output;
        }
        
        throw new ViewFileNotFoundException("The view was not found: searched tried " . print_R($this->viewFiles, true));
    }
    
    public function __call($name, $arguments){ 
        if($this->methods->exists($name)){
            $class = $this->methods->get($name);
            $class->addMethods($this->methods); 
            return $class->execute(...$arguments);
        }
        throw new \Exception("Method not found $name");
    }
    
    private function setChildOutput(string $childOutput){
        $this->childOutput = $childOutput;
    }
}