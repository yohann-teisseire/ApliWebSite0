<?php

namespace Library;

abstract class BackController extends ApplicationComponent{

	protected $action = '';
	protected $module = '';
	protected $page = null;
	protected $view = '';
	protected $managers = null;

	public function  __construct(Application $app, $module, $action){
		parent::__construct($app);

		$this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());

		$this->page = new Page($app);

		$this->setModule($module);
		$this->setAction($action);
		$this->setView($view);
	}

	public function execute(){
		$method = 'execute'.ucfirst($this->action);

		if(!is_callable(array($this,$method))){
			throw new \RuntimeException('L\'action"'.$this->action.'"n\'est pas définie dans ce module');
		}

		$this->method($this->app->httpRequest());
	}

	public function page(){
		return $this->page;
	}

	public function setModule($module){
		if(!is_string($module) || empty($module)){
			throw new \InvalidArgumentException("Le module doit etre une chaine de caractere valide");	
		}
		$this->module = $module;
	}

	public function setAction($action){
		if(!is_string($action) || empty($action)){
			throw new \InvalidArgumentException("Le module doit etre une chaine de caractere valide");	
		}
		$this->action = $action;
	}

	public function setView($view){
		if(!is_string($view) || empty($view)){
			throw new \InvalidArgumentException("La vue doit etre une chaine de caractere valide");	
		}
		$this->view = $view;
		$this->page->setContentFile(__DIR__.'/../Applications/'.$this->app->name().'/Modules/'.$this->module.'/Views'.$this->view.'.php');
	}


}