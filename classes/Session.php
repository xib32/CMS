<?php

class Session
{
	private function __construct(){}
	private function __clone(){}
	
	public static function all()
	{
		return $_SESSION;
	}
	
	public static function put($key, $value)
	{
		return $_SESSION[$key] = $value;
 	}
	
	public static function get($key)
	{
		if(self::exists($key)) {
			return $_SESSION[$key];
		}
		return false;
 	}
	
	public static function exists($key)
	{
		return isset($_SESSION[$key]);
 	}
	
	public static function delete($key)
	{
		if(self::exists($key)) {
			unset($_SESSION[$key]);
			return true;
		}
		return false;
 	}
	
	public static function flash($type, $string = '')
	{
		if(self::exists($type)) {
			$msg = $_SESSION[$type];
			self::delete($type);
			return $msg;
		} else {
			self::put($type, $string);
		}
		
		return false;
 	}
}