<?php

namespace \Library\Models;

use \Library\Entities\Comment;

abstract class CommentManager extends \Library\Manager{

	abstract protected function add(Comment $comment);

	public function save(Comment $comment){
		if($comment->isValid()){
			$comment->isNew() ? $this->add($comment) : $this->modify($comment);
		}else{
			throw new \RunTimeException("Le commentaire doit etre validé pour etre enregistré");
			
		}
	}

	abstract public function getListOf($news);

	abstract protected function modify(Comment $comment);

	abstract public function delete($id);

	abstract public function get($id);
}