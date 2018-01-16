<?

// Initialize variables
require_once('../requires/GrabController.php');
$grabber = new GrabController();
// Connect to DB
// Get name of script via $argv
// Curl it and put it in and parse xml
// Throw it in the DB (Date, Status, Message)