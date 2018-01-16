<?

class GrabController()
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

		// Database info
		require_once('../config/database.php');
		$this->databaseInfo = $dataconnection;

		// Set DB table
		$this->dbTable = 'aws_data';

	}

	public function establishDBConnection()
	{


	}

	private function createTable()
	{

	}

}