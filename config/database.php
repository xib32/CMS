<?php

return [

	/*
    |--------------------------------------------------------------------------
    | Database Default Driver
    |--------------------------------------------------------------------------
    |
    | Here you can change database driver.
    |
    */
	'driver' => 'mysql',
	
	/*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */
	'fetch' => PDO::FETCH_OBJ,
	
	/*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    |
    */
	'mysql' => [
		'host' => '127.0.0.1',
		'user' => 'root',
		'pass' => '',
		'db' => 'cms',
		'charset' => 'utf8'
	],
	'sqlite' => [
	
	],
	'pgsql' => [
	
	]
];