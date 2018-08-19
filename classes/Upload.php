<?php

class Upload
{
	private $uploadedFiles = array();
	private $_passed = false;
	private $_errors = array();
	private $_db = null;
	
	
	public function __construct(){
		$this->_db = DB::getInstance();
	}
	private function __clone(){}
	
	public function upload_files($naziv){
		
		if(strpos($naziv,'images/') === false){
			$UploadFolder = 'images/'.$naziv.' '.date('d.m.y');
		}else{
			$UploadFolder = $naziv;
		}
		if (!file_exists($UploadFolder)) {
			mkdir($UploadFolder, 0777, true);
		}
		else{
			$this->addError($UploadFolder, "Folder {$UploadFolder} već postoji!");
		}
		
		foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
			$temp = $_FILES["files"]["tmp_name"][$key];
			$name = $_FILES["files"]["name"][$key];
			
		if(file_exists($UploadFolder."/".$name) == true){
			$this->addError($name,"{$name} datoteka veća postoji");
		}
			if(!move_uploaded_file($temp,$UploadFolder."/".$name)){
			$this->addError($name, "Datoteka {$name} nije postavljena na Server!");				
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