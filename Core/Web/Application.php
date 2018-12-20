<?php

namespace Core\Web;

use Core\Common\Obj;
use Core\Common\Str;
use Core\Configuration\ConfigurationManager;
use Core\Web\Http\Server;
use Core\Web\Http\Request;
use Core\Web\Http\Response;
use Core\Web\Http\HttpContext;
use Core\Web\Http\GenericController;
use Core\Web\Http\HttpException;
use Core\Web\Http\ControllerNotFoundException;

final class Application{
    
    private $configManager = null;
    private $httpContext = null;

    public function run(string $baseDir, ConfigurationManager $configManager){
        
        $this->configManager = $configManager;
        $server = new Server($baseDir);
        $request = new Request($server);
        $response = new Response($server);
        $this->httpContext = new HttpContext($request, $response);
        $routes = $this->configManager->getConfiguration()->get('routes');
 
        foreach($routes as $route){ 
            if($route->execute($request)){
                $class = (string)Str::set($route->getControllerClass())->replaceTokens(
                    $request->getParameters()
                    ->map(function($v){ return (string)Str::set($v)->toUpperFirst(); })
                    ->toArray()
                )->replace('.', '\\');

                if(Obj::exists($class)){ 
                    $controller = new $class($this->configManager);
                }else{
                    throw new ControllerNotFoundException("the service controller not found");
                }

                if($controller instanceof GenericController){
                    $controller->service($this->httpContext);
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

        foreach($this->configManager->getConfiguration()->get('exceptionHandlers') as $handler){
            if($handler->exception == $exceptionType || $handler->exception =='*'){
                
                $class = (string)Str::set($handler->class)->replace('.', '\\');

                $controller = new $class($this->configManager);
                
                if($controller instanceof GenericController){
                    $this->httpContext->getRequest()->setException($e);
                    $controller->service($this->httpContext);
                    $this->httpContext->getResponse()->flush();
                }
            }
        }
    }
}
