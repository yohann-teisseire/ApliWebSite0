<?php

namespace Application\Backend\Modules\News;

class NewsController extends \Library\BackController{


	public function executeDeleteComment(\Library\HttpRequest $request){

		$this->managers->getManagerOf('Comments')->delete($request->getData('id'));

		$this->app->user()->setFlash('Le commentaire a bien ete supprimé !');

		$this->app->htppResponse()->redirect('.');
	}

	public function executeUpdateComment(\Library\HttpRequest $request){
		$this->page->addVar('title', 'Modification commentaire');

		if($request->method() == 'POST'){
			$comment = new \Library\Entities\Comment(
				array(
					'id' => $request->getData('id'),
					'titre' => $request->postData('titre'),
					'contenu' => $request->postData('contenu')
					)
				);
		}else{
			$comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
		}

		$formBuilder = new \Library\FormBuilder\CommentFormBuilder($comment);
		$formBuilder->build();

		$form = $formBuilder->form();

			
			$formHandler = new \Library\formHandler($form,$this->managers->getManagerOf('Comments'),$request);

			if($formHandler->process()){
				$this->managers->getManagerOf('Comments')->save($comment);

				$this->app->user()->setFlash('Le commentaire a bien ete modifié !');

				$this->app->htppResponse()->redirect('/admin/');
			}
			
			$this->page->addVar('form', $form->createView());
	}

	public function executeIndex(\Library\HttpRequest $request){

		$this->page->addVar('title', 'Gestion des News');

		$manager = $this->managers->getManagerOf('News');

		$this->page->addVar('listeNews', $manager->getList());
		$this->page->addVar('nombresNews', $manager->count());
	}

	public function executeInsert(\Library\HttpRequest $request){

		$this->processForm($request);

		$this->page->addVar('title','Ajout News');
	}

	public function executeUpdate(\Library\HttpRequest $request){

		$this->processForm($request);

		$this->page->addVar('title', 'Modification news');
	}

	public function executeDelete(\Library\HttpRequest $request){
		$this->managers->getManagerOf('News')->delete($request->getData('id'));

		$this->app->user()->setflash('La news a bien été supprimée');

		$this->app->httpResponse()->redirect('.');
	}

	public function processForm(\Library\HttpRequest $request){

		$formHandler = new \Library\formHandler($form,$this->managers->getManagerOf('Comments'),$request);

			if($formHandler->process()){
			$news = new \Library\Entities\News(
				array(
						'auteur' => $request->postData('auteur'),
						'titre' => $request->postData('titre'),
						'contenu' => $request->postData('contenu')
					)
				);

			if($request->postExists('id')){
				$news->setId($request->postData('id'));
			}
		}else{

			if($request->getExists('id')){
				$news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
			}else{
				$news = new \Library\Entities\News;
			}
		}

		$formBuilder = new \Library\FormBuilder\NewsFormBuilder($news);
		$formBuilder->build();

		$form = $formBuilder->form();

		$formHandler = new \Library\formHandler($form,$this->managers->getManagerOf('Comments'),$request);

			if($formHandler->process()){
			$this->managers->getManagerOf('News')->save($news);
			$this->app->user()->setflash($news->isNew() ? 'la news a bien ete ajoutée' : 'La news a bien ete modifiée');
			$this->app->htppResponse()->redirect('/admin/');
		}

		$this->page->addVar('form', $form->createView());
	}
}