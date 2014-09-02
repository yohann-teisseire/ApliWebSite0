<?php

namespace Library;

abstract class Application{

	protected $httpRequest;
	protected $httpResponse;
	protected $name;
	protected $user;
	protected $config;

	public function __construct(){
		$this->httpRequest = new HttpRequest($this);
		$this->httpResponse = new HttpResponse($this);
		$this->name = '';
		$this->user = new User($this);
		$this->config = new Config($this);
	}

	public function getController(){
		$router = new \Library\Router;

		$xml = new \DOMDocument;
		$xml->load(__DIR__'/../Application'. $this->name.'/Config/routes.xml');

		$routes = $xml->getElementsByTagName('route');

		foreach ($routes as $route) {
			$vars = array();

			if($route->hasAttribute('vars')){
				$vars = explode(',', $route->getAttribute('vars'));
			}

			$router->addRoute(new route($route->getAttribute('url'),$route->getAttribute('module'), $route->getAttribute('action'),$vars));
		}

		try{
			$matchedRoute = $router->getRoute($this->httpRequest->requestURI());
		}
		catch (\RuntimeException $e){
			if($e->getCode() == \Library\Router::NO_ROUTE){
				$this->httpResponse->redirect404();
			}
		}

		$_GET = array_merge($_GET, $matchedRoute->vars());

		$controllerClass = 'Application\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';

		return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());


	}

	abstract public function run();

	public function httpRequest(){
		return $this->httpRequest;
	}

	public function httpResponse(){
		return $this->httpResponse;
	}

	public function name(){
		return $this->name;
	}
	
}