<?php

namespace Core\Web;

use Core\Common\Obj;
use Core\Common\Str;
use Core\Configuration\Configuration;
use Core\Configuration\ExceptionHandlerSection;
use Core\Configuration\RouteSection;
use Core\Configuration\SettingsSection;
use Core\Web\Http\Server;
use Core\Web\Http\Request;
use Core\Web\Http\Response;
use Core\Web\Http\HttpContext;
use Core\Web\Http\IGenericController;
use Core\Web\Http\HttpException;
use Core\Web\Http\ControllerNotFoundException;

final class Application{
    
    private $config = null;
    private $httpContext = null;

    public function run(string $baseDir, Configuration $config){
        
        $this->config = $config;
        
        $server = new Server($baseDir);
        $request = new Request($server);
        $response = new Response($server);
        $this->httpContext = new HttpContext($request, $response);
        
        $this->config
            ->add('exceptionHandlers', new ExceptionHandlerSection())
            ->add('routes', new RouteSection())
            ->add('settings', new SettingsSection());
        
        $routes = $this->config->get('routes');

        foreach($routes as $route){ 
            if($route->execute($request)){
                $class = (string)Str::set($route->getControllerClass())->replaceTokens(
                    $request->getParameters()
                    ->each(function($v){ return Str::set($v)->toUpperFirst(); })
                    ->toArray()
                )->replace('.', '\\');

                if(Obj::exists($class)){
                    $controller = new $class();
                }else{
                    throw new ControllerNotFoundException("the service controller not found");
                }

                if($controller instanceof IGenericController){
                    $controller->service($this->config, $this->httpContext);
                    $this->httpContext->getResponse()->flush();
                    
                }else{
                    throw new HttpException("$class must be an instance of GenericService");
                }
            }
        }
        throw new ControllerNotFoundException("Unable to dispatch a controller. No routes matched the request uri.");
    }
    
    public function error(\Exception $e){
        $exceptionType = get_class($e);

        foreach($this->config->get('exceptionHandlers') as $handler){
            if($handler->exception == $exceptionType || $handler->exception =='*'){
                
                $class = (string)Str::set($handler->class)->replace('.', '\\');

                $controller = new $class();
                
                if($controller instanceof IGenericController){
                    $this->httpContext->getRequest()->setException($e);
                    $controller->service($this->config, $this->httpContext);
                    $this->httpContext->getResponse()->flush();
                }
            }
        }
    }
}

