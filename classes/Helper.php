<?php

class Helper
{
	private function __construct(){}
	private function __clone(){}
	
	public static function getHeader($title, $header = 'header', $user = null)
	{
		$path = 'includes/layouts/' . $header . '.php';
		
		if(file_exists($path)) {	
		
			return require $path;
			
		}
		return false;
	}
	
	public static function getFooter($footer = 'footer')
	{
		$path = 'includes/layouts/' . $footer . '.php';
		
		if(file_exists($path)) {	
		
			return require $path;
			
		}
		return false;
	}
}
