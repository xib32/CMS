<?php

class Hash
{
	public static function salt($length)
	{
		return mcrypt_create_iv($length);
	}
	
	public static function make($string, $salt = '')
	{
		return hash('sha256', $string . $salt);
	}
	
	public static function uniqeid()
	{
		return hash('sha256', uniqid());
	}
}