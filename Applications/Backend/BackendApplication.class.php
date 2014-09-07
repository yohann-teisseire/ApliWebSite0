<?php 
namespace  Applications\Backend;

class BackendApplication extends \Library\Application{

	public function __construct(){
		parent::__construct();

		$this->name = 'Backend';
	}

	public function run(){

		if($this->user->isAuthenficated()){
			$controller = $this->getController(); 
		}else{
			$controller = new Module\Connexion\ConnexionController($this, 'Connexion' , 'index');
		}

		$controller->execute();

		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}