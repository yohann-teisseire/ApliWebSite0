<?php

namespace \Library\Models;

use \Library\Entities\Comment;

class CommentManager_PDO extends CommentManager{

	protected function add(Comment $comment){
		$q = $this->dao->prepare('INSERT INTO comments set news = :news, auteur = : auteur, contenu = : contenu, date = NOW()');
		$q->bindValue(':news', $comment->news(), \PDO::PARAM_INT);
		$q->bindValue('auteur', $comment->auteur());
		$q->bindValue('contenu', $comment->contenu());

		$q->execute();

		$comment->setId($this->dao->lastInsertId());

	}

	public function getListOf($news){

		if(!ctype_digit($news)){
			throw new \InvalidArgumentException("L'identifiant passé en paramettre doit etre un nombre entier valide");
			
		}

		$q = $this->dao->prepare('SELECT id, news, auteur, contenu, date FROM comments WHERE news = : news');
		$q->bindValue(':news', $news, \PDO::PARAM_INT);
		$q->execute();
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Comment');

		$comments = $q->fetchAll();

		foreach ($comments as $comment) {
			$comment->setDate(new \DateTime($comment->date()));
		}

		return $comments;
	}
}