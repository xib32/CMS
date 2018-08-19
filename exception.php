<?php

function check($num)
{
	if($num > 1) {
		throw new Exception('Broj ne smije biti veći od 1.');
	}
	
	return true;
}

try {
	
	check(1);
	echo 'Radi';
	
} catch(Exception $e) {
	
	echo $e->getMessage();
	
}