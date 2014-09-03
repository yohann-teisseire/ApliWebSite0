<?php

namespace Library\Models;

abstract class NewsManager extends \Library\Manager{
	// $debut premiere news
	// $limite nombre de news a selectionner
	abstract public function getList($debut = -1, $limite = -1);

	abstract public function getUnique($id);
}