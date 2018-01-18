<?php

// This is the Database connection information
$dataconnection = array(
	'servername' => '127.0.0.1',
	'username' => 'root',
	'password' => 'root',
	'dbname' => 'blackbag'
);

// Name of the table you would like the app to write to
$dataTable = 'aws_data';

// This deletes entries older than this number. Integer
$deleteEntriesOlderThan = 7;