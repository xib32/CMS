<?php

class Token
{
	private static $_token_name = 'CSRF';
	
	private function __construct(){}
	private function __clone(){}
	
	public static function generate()
	{
		return Session::put(self::$_token_name, md5(uniqid()));
	}
	
	public static function check($token)
	{
		if(
			Session::exists(self::$_token_name) 
			&& 
			$token === Session::get(self::$_token_name)
		) {
			Session::delete(self::$_token_name);
			return true;
		}
		
		return false;
	}
}