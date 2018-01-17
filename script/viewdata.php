<?php

// Initialize variables
chdir('..');
define("DOCROOT", getcwd());
require_once(DOCROOT . '/requires/ViewController.php');

$viewer = new ViewController();

// Get data
$channel = isset($_GET['channel']) ? filter_var($_GET['channel'], FILTER_SANITIZE_STRING) : null;
$offset = isset($_GET['offset']) ? (!filter_var($_GET['offset'], FILTER_SANITIZE_NUMBER_INT) === FALSE ? filter_var($_GET['offset'], FILTER_SANITIZE_NUMBER_INT) : 0) : 0;

echo $viewer->view($channel, $offset);