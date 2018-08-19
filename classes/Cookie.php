<?php

class Cookie
{
	private function __construct(){}
	private function __clone(){}
	
	public static function exists($name)
	{
		return isset($_COOKIE[$name]);
	}
	
	public static function get($name)
	{
		return $_COOKIE[$name];
	}
	
	public static function put($name, $value, $expire)
	{
		return setcookie($name, $value, time() + $expire, '/', 'localhost', null, true);
	}
	
	public static function delete($name)
	{
		return self::put($name, '', time() - 3600, '/');
	}
	
}