<?php

namespace Library;

abstract class Field{

	protected $errorMessage;
	protected $label;
	protected $name;
	protected $value;
	protected $validators = array;

	public function __construct(array $options = array()){
		if(!empty($options)){
			$this->hydrate($options)
		}
	}

	abstract public function buildWidget();

	public function hydrate($options){

		foreach ($options as $type => $value) {
			$method = 'set'.ucfirst($type);
			if(is_callable(array($this, $method))){
				$this->method($value);
			}
		}

		return true;
	}

	public function isValid(){
		foreach ($this->validators as $validator) {
			if(!$validator->isValid($this->value)){
				$this->errorMessage = $validator->errorMessage();
				return false;
			}
		}
	}

	public function label(){
		return $this->label;
	}
	public function name(){
		return $this->name;
	}
	public function value(){
		return $this->value;
	}

	public function validators(){
		return $this->validators;
	}

	public function setLabel($label){
		if(is_string($label)){
			$this->label = $label;
		}
	}

	public function setName($name){
		if(is_string($name)){
			$this->name = $name;
		}
	}

	public function setValue($value){
		if(is_string($value)){
			$this->value = $value;
		}
	}

	public function setValidators(array $validators){
		foreach ($validators as $validator) {
			if($validator instanceof Validator && !in_array($validator, $this->validators)){
				$this->validator[] = $validator;
			}
		}
	}
}