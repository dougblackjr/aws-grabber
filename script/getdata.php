<?php

// Initialize variables
$rootDir = realpath(dirname(__FILE__) . '/..');
define("DOCROOT", $rootDir);
require_once(DOCROOT . '/requires/GrabController.php');

$grabber = new GrabController();


// If there are no arguments, we'll read from file
if(!isset($argv[1]) && file_exists(DOCROOT . '/config/feeds.md')) {
	// Read from file, throw it in an array
	$file = fopen(DOCROOT . '/config/feeds.md', 'r');
	if(filesize(DOCROOT . '/config/feeds.md') > 0) {
		$filecontents = fread($file, filesize(DOCROOT . '/config/feeds.md'));
	} else {
		echo "No feeds in file. Either add feeds to feeds.md, or use the CLI!" . PHP_EOL;
		die();
	}
	fclose($file);

	$feeds = explode("\n", $filecontents);

	echo "I see " . count($feeds) . " feeds to grab." . PHP_EOL;

	foreach ($feeds as $feed) {
		// Parse feed

		$response = $grabber->parse($feed);

		echo $response . PHP_EOL;
	}
	
} else {
	// Get names of script via $argv
	foreach ($argv as $key => $value) {
		
		// Skip the first one
		if ($key == 0) continue;
		
		// Parse
		$response = $grabber->parse($value);

		echo $response . PHP_EOL;

	}
}

echo "Grabber has completed! Now, hire Doug Black!" . PHP_EOL;

// END OF FILE