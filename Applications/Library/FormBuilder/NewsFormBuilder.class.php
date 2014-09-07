<?php

namespace Library\FormBuilder;

class NewsFormBuilder extends \Library\FormBuilder{

	public function build(){

		$this->form->add(new \Library\StringField(array(
			'label' => 'Auteur',
			'name' => 'auteur',
			'maxlength' => 20,
			'validators' => array(
				new \Library\MaxLengthValidator('20 caracteres maximum', 20),
				new \Library\NotNullValidator('Merci de spécifier auteur de la news'),
				),
			)))

		$this->form->add(new \Library\StringField(array(
			'label' => 'Titre',
			'name' => 'titre',
			'maxlength' => 120,
			'validators' => array(
				new \Library\MaxLengthValidator('120 caracteres maximum', 120),
				new \Library\NotNullValidator('Merci de spécifier le titre de la news'),
				),
			)))

		->add(new \Library\TextField(array(
			'label' => 'Contenu',
			'name' => 'contenu',
			'rows' => 7,
			'cols' => 50,
			'validators' => array(
				new \Library\NotNullValidator('Merci de mettre un contenu à la news'),
				),
			)));
	}
}