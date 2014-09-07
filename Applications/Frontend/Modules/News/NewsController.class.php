<?php

namespace Applications\Frontend\Modules\News;

class NewsController extends Library\BackController{

	public function executeInsertComment(\Library\HttpRequest $request){

		if($request->method() == 'POST'){
			$comment = new \Library\Entities\Comment(array(
				'news' => $request->getData('news'),
				'auteur' => $request->getData('auteur'),
				'contenu' => $request->getData('contenu')
				));
		}else{
			$comment = new \Library\Entities\Comment;
		}

		$formBuilder = new \Library\FormBuilder\CommentFormBuilder($comment);

		$formBuilder->build();

		$formHandler = new \Library\formHandler($form,$this->managers->getManagerOf('Comments'),$request);

		if($formHandler->process()){
			$this->managers->getManagerOf('Comments')->save($comment);
			$this->app->user()->setFlash('Le commentaire a bien été ajouté merci');
			$this->app->httpResponse()->redirect('news-'.$request->getData('news').'.php');
		}

		$this->page->addVar('comment', $comment);
		$this->page->addVar('form', $form->createView());
		$this->page->addVar('title', 'Ajout commentaire');
	}

	public function executeIndex(\Library\HttpRequest $request){
		$nombreNews = $this->app->config()->get('nombre_news');
		$nombreCaracteres = $this->app->config()->get('nombre_caracteres');

		$this->page->addVar('title', 'Liste des'.$nombreNews.'dernieres news');

		$manager = $this->managers->getManagerOf('News');

		$listeNews = $manager->getList(0, $nombreNews);

		foreach ($listeNews as $news) {
			if(strlen($news->contenu()) > $nombreCaracteres){
				$debut = substr($news->contenu(), 0, $nombreCaracteres);

				$debut = substr($debut, 0, strrpos($debut, '')).'...';

				$news->setContenu($debut);
			}
		}

		$this->page->addVar('ListeNews', $listeNews);
	}

	public function executeShow(\Library\HttpRequest $request){
		$news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));

		if(empty($news)){
			$this->app->httpResponse()->redirect404();
		}

		$this->page->addVar('title', $news->titre());
		$this->page->addVar('news', $news);
		$this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($news->id()));
	}
}