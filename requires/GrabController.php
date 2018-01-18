<?php

class GrabController
{
	
	public $awsMessages;

	public $databaseInfo;

	public $dbTable;

	public $db;

	public $deleteEntriesOlderThan;

	function __construct()
	{

		// AWS Messages
		$this->awsMessages = array(
			"Service is operating normally",
			"Informational message",
			"Service degradation",
			"Service disruption"
		);

		// Database info
		require_once(DOCROOT . '/config/settings.php');

		$this->databaseInfo = $dataconnection;

		// Set DB table
		$this->dbTable = $dataTable;

		// Set delete older than
		$this->deleteEntriesOlderThan = (int) $deleteEntriesOlderThan;

		// Start DB connection
		$this->db = $this->establishDBConnection();

		if (!$this->primaryTableExists()) {

			$this->createTable();

		}

	}

	function parse($url)
	{

		$data = $this->getURL($url);

		if($data == 'ERROR: URL is not valid') return $data;

		$this->storeData($data);

		return "All done";

	}

	function getURL($url)
	{

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);

		$retValue = curl_exec($ch);

		if(curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200 || !$retValue) {

			return 'ERROR: URL is not valid';

		}

		curl_close($ch);
		
		return $retValue;

	}

	function storeData($data)
	{

		$sXML = new SimpleXMLElement($data);

		$count = count($sXML->channel->item);
		
		if($count > 0) {
			
			foreach ($sXML->channel->item as $item) {
			
				$date = new DateTime($item->pubDate);
				$now = new DateTime();

				$sendData = array(
					'channel' => (string) $sXML->channel->title[0],
					'date' => date('Y-m-d H:m:s', strtotime($date->format('Y-M-d H:m:s'))),
					'status' => $this->getStatus($item->title),
					'title' => addslashes((string) $item->title),
					'description' => addslashes((string) $item->description),
					'created_at' => date('Y-m-d H:m:s', strtotime($now->format('Y-M-d H:m:s')))
				);

				$this->writeData($sendData);
			
			}

		} else {

			$date = new DateTime($sXML->channel->pubDate);
			$now = new DateTime();

			$sendData = array(
				'channel' => (string) $sXML->channel->title[0],
				'date' => date('Y-m-d H:m:s', strtotime($date->format('Y-M-d H:m:s'))),
				'status' => 0,
				'created_at' => date('Y-m-d H:m:s', strtotime($now->format('Y-M-d H:m:s')))
			);

			$this->writeData($sendData);

		}

	}

	function establishDBConnection()
	{

		$conn = new mysqli($this->databaseInfo['servername'], $this->databaseInfo['username'], $this->databaseInfo['password'], $this->databaseInfo['dbname']);

		if($conn->connect_error || is_null($conn)) {
			
			die('Error establishing MySQL connection: ' . $conn->connect_error);

		}

		return $conn;

	}

	function primaryTableExists()
	{

		$query = $this->db->query('select 1 from `' . $this->dbTable . '` LIMIT 1');

		if($query === FALSE) return FALSE;

		return TRUE;

	}

	function writeData($data)
	{

		if(isset($data['title']) || isset($data['description'])) {

			$sql = "INSERT INTO " . $this->dbTable . 
				   " (channel, date, status, title, description, created_at)
				   VALUES('" . $data['channel'] . "','" . $data['date'] . "'," . $data['status'] . ",'" . $data['title'] . "','" . $data['description'] . "','" . $data['created_at'] . "')";

		} else {

			$sql = "INSERT INTO " . $this->dbTable . 
				   " (channel, date, status, created_at)
				   VALUES('" . $data['channel'] . "','" . $data['date'] . "'," . $data['status'] . ",'" . $data['created_at'] . "')";

		}

		if($this->db->query($sql) !== TRUE) {

			die('Oops! Write error! ' . $this->db->error);

		}

		return TRUE;

	}

	function createTable()
	{

		$sql = "CREATE TABLE " . $this->dbTable . " (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		channel VARCHAR(100) NOT NULL,
		date DATETIME NOT NULL,
		status INT(4) NOT NULL,
		title VARCHAR(200),
		description VARCHAR(2000),
		created_at DATETIME NOT NULL
		)";

		if($this->db->query($sql) === TRUE) {

			echo('Initial table created') . PHP_EOL;
		
		} else {
		
			die('Error querying to create initial table');
		
		}

		return TRUE;

	}

	function getStatus($string) {

		foreach ($this->awsMessages as $aKey => $aValue) {
			
			if(stripos($string, $aValue)) {

				return $aKey;

			}

		}

		return 0;

	}

	function deleteOldEntries()
	{

		$query = 'DELETE FROM ' . $this->dbTable . ' WHERE DATE(date) < (curdate() - INTERVAL ' . $this->deleteEntriesOlderThan . ' DAY)';

		if($this->db->query($query) === TRUE) {

			echo "Deleted old entries." . PHP_EOL;

		}
	}

}

?>