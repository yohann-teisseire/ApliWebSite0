<?php

namespace Library\FormBuilder;

class CommentFormBuilder extends \Library\FormBuilder{

	public function build(){

		$this->form->add(new \Library\StringField(array(
			'label' => 'Auteur',
			'name' => 'auteur',
			'maxlength' => 50,
			'validators' => array(
				new \Library\MaxLengthValidator('50 caracteres maximum', 50),
				new \Library\NotNullValidator('Merci de spécifier auteur du commentaire'),
				),
			)))
		->add(new \Library\TextField(array(
			'label' => 'Contenu',
			'name' => 'contennu',
			'rows' => 7,
			'cols' => 50,
			'validators' => array(
				new \Library\NotNullValidator('Merci de mettre un commentaire'),
				),
			)));
	}
}