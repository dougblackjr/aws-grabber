<?php

// Initialize variables
define("DOCROOT", getcwd());
require_once(DOCROOT . '/requires/ViewController.php');

$viewer = new ViewController();

// Get data
$channel = isset($_GET['channel']) ? $_GET['channel'] : null;
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

echo $viewer->view($channel, $offset);