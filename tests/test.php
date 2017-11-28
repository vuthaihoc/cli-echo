<?php

require __DIR__ . '/../src/CliEcho.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// use Vuh\CliEcho\CliEcho;

$types = ['warning', 'info', 'success', 'error'];
// Vuh\CliEcho\CliEcho::enable_flush(true);
try{
	for ($i=0; $i < 10; $i++) { 
		$rd = rand(0, 3);
		$type = $types[$rd];
		Vuh\CliEcho\CliEcho::{$type . "nl"}("Showing message type " . $type . " with CliEcho");
		sleep(3);
	}
}catch(\Exception $ex){
	echo $ex->getMessage();
}