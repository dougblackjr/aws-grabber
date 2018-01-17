<?php

// Initialize variables
define("DOCROOT", getcwd());
require_once(DOCROOT . '/requires/GrabController.php');

$grabber = new GrabController();

// Get name of script via $argv
foreach ($argv as $key => $value) {
	
	// Skip the first one
	if ($key == 0) continue;
	
	// Parse
	$response = $grabber->parse($value);

	echo $response . PHP_EOL;

}
// Curl it and put it in and parse xml
// Throw it in the DB (Date, Status, Message)