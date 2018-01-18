<?php

class ViewController
{

	public $awsMessages;

	public $databaseInfo;

	public $dbTable;

	public $db;

	function __construct()
	{

		// AWS Messages
		$this->awsMessages = array(
			"Service is operating normally",
			"Informational message",
			"Service degradation",
			"Service disruption"
		);

		// For view, define Docroot
		if(!defined("DOCROOT")) define("DOCROOT", getcwd());

		// Database info
		require_once(DOCROOT . '/config/settings.php');

		$this->databaseInfo = $dataconnection;

		// Set DB table
		$this->dbTable = $dataTable;

		// Start DB connection
		$this->db = $this->establishDBConnection();

	}

	function view($channel = null, $offset = 0, $startDate = null, $endDate = null)
	{

		$query = $this->buildQuery($channel, $offset, $startDate, $endDate);

		$result = $this->db->query($query);

		$sendResults = new stdClass();

		$sendResults->results = array();

		if(is_null($result)) {

			$sendResults->count = 0;

			$sendResults->results[] = array(
				'title' => 'No Results',
				'status_style' => 'is-info'
			);

		} else {

			$sendResults->count = $result->num_rows;

			while($row = $result->fetch_assoc()) {
				$row['status_message'] = $this->awsMessages[$row['status']];

				switch ($row['status']) {
					case 0:
						$row['status_style'] = 'is-success';
						break;
					case 1:
						$row['status_style'] = 'is-info';
						break;
					case 2:
						$row['status_style'] = 'is-warning';
						break;
					case 3:
						$row['status_style'] = 'is-danger';
						break;
					
					default:
						$row['status_style'] = '';
						break;
				}
				$sendResults->results[] = $row;
			}

		}
		return json_encode($sendResults);

	}

	private function buildQuery($channel, $offset, $startDate, $endDate)
	{

		$query = 'SELECT * FROM ' . $this->dbTable . ' ';

		if(!is_null($channel)) {

			$query .= "WHERE `channel` = '" . $channel . "' ";
		
		}

		$query .= 'ORDER BY date DESC LIMIT 500';

		if(!is_null($offset) && (int) $offset > 0) {

			$query .= ' OFFSET ' . $offset;
			
		}

		return $query;

	}

	function establishDBConnection()
	{

		$conn = new mysqli($this->databaseInfo['servername'], $this->databaseInfo['username'], $this->databaseInfo['password'], $this->databaseInfo['dbname']);

		if($conn->connect_error || is_null($conn)) {
			
			die('Error establishing MySQL connection: ' . $conn->connect_error);

		}

		return $conn;

	}

}