<?php

namespace Library\Models;

abstract class NewsManager extends \Library\Manager{
	// $debut premiere news
	// $limite nombre de news a selectionner
	abstract public function getList($debut = -1, $limite = -1);

	abstract public function getUnique($id);

	abstract public function count();

	abstract protected function modify(News $news);

	abstract public function delete($id);

	abstract protected function add(News $news);

	public function save(News $news){
		if($news->isValid()){
			$news->isNew() ? $this->add($news) : $this->modify($news);
		}else{
			throw new \RunTimeException("La news doit etre validée pour etre enregistrée");
			
		}
	}
}