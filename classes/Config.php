<?php

class Config
{
	private function __construct(){}
	private function __clone(){}
	
	public static function get($file = null)
	{
		if($file) {
			$path = 'config/' . $file . '.php';
			if(file_exists($path)) {
				$items = require 'config/' . $file . '.php';
				return $items;
			}
		}
		return false;
	}
}