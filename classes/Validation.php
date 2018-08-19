<?php

class Validation
{
	private $_passed = false;
	private $_errors = array();
	private $_db = null;
	
	
	public function __construct()
	{
		$this->_db = DB::getInstance();
		 
	}
	
	public function check($fields = array())
	{
	
		foreach ($fields as $field => $rules) {
			foreach ($rules as $rule => $rule_value) {
				
				$value = escape(trim(Input::get($field)));
				$char_num = strlen($value);
				if(empty($value) && $rule === 'required') {
					$this->addError($field, "Polje {$field} je obavezno!");
					Session::flash('danger', 'Validation failed!');
				} else if(!empty($value)) {					
					switch($rule) {	
						case 'min':
							if($char_num < $rule_value) {
								$this->addError($field, "Polje {$field} mora imati minimum {$rule_value} znakova.");
								Session::flash('danger', 'Validation failed!');
							}
						break;
						case 'max':
							if($char_num > $rule_value) {
								$this->addError($field, "Polje {$field} može imati maksimum {$rule_value} znakova.");
								Session::flash('danger', 'Validation failed!');
							}
						break;
						case 'unique':
							$check = $this->_db->get($field, $rule_value,array($field, '=', $value));
							if($check->count()) {
								$this->addError($field, "{$field} već postoji.");
								Session::flash('danger', 'Validation failed!');
							}
						break;
						case 'matches':
							if($value != Input::get($rule_value)) {
								$this->addError($field, "Polja {$field} i {$rule_value} moraju biti identična.");
								Session::flash('danger', 'Validation failed!');
							}
						break;
					}
				}
				
			}
		}
		
		if($_FILES["files"]["tmp_name"][0]!=""){			
			$extension = array("jpeg","jpg","png","gif","PNG","JPEG","JPG","GIF");
			$totalBytes = 10485760;//10MB file size is allowed
			$MB=1048576;
			$UploadFolder = "images";
			foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
				$temp = $_FILES["files"]["tmp_name"][$key];
				$name = $_FILES["files"]["name"][$key];					
				if($_FILES["files"]["size"][$key] > $totalBytes)
				{
					$this->addError( $name.'datoteka veća od '.$totalBytes/$MB.'MB');
					Session::flash('danger', 'Validation failed!');
				}								
				$ext = pathinfo($name, PATHINFO_EXTENSION);								
				if(!in_array($ext, $extension)){
					$this->addError( 'images','Datoteka'.$name.' je krivog tipa, dozvoljene datoteke: jpeg,jpg,png,gif');
					Session::flash('danger', 'Validation failed!');
				}							
			}
		}
		if(empty($this->_errors)) {
			$this->_passed = true;
		}
		
		return $this;
	}
	
	private function addError($field, $error)
	{
		$this->_errors[$field] = $error; 
	}
	
	public function hasError($field)
	{
		if(isset($this->_errors[$field])) {
			return $this->_errors[$field];
		}
		
		return false;
	}
	
	public function errors()
	{
		return $this->_errors;
	}
	
	public function passed()
	{
		return $this->_passed;
	}
}