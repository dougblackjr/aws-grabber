<?php

// Initialize variables
define("DOCROOT", getcwd());
require_once(DOCROOT . '/requires/ViewController.php');

$viewer = new ViewController();

echo $viewer->view();