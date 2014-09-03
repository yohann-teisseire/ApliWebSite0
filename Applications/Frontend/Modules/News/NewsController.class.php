<?php

namespace Applications\Frontend\Modules\News;

class NewsController extends Library\BackController{

	public function executeInsertComment(\Library\HttpRequest $request){

		$this->page->addVar('title' 'Ajout d\'un commentaire');

		if($request->postExists('pseudo')){
			$comment = new \Library\Entities\Comment(array(
				'news' => $request->getData('news'),
				'auteur' => $request->getData('pseudo'),
				'contenu' => $request->getData('contenu')
				));

			if($comment->isValid()){
				$this->managers->getManagerOf('Comments')->save($comment);

				$this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');

				$this->app->httpResponse()->redirect('news'.$request->getData('news').'.php');
			}else{
				$this->page->addVar('erreurs', $comment->erreurs());
			}

			$this->page->addVar('comment', $comment);
		}
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