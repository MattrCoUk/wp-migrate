<?php
require_once('authenticate.php');
	class dbConnect{

		private $mysqli;
		private $quiet;



		public function query($query) {
			$result = $this->mysqli->query($query);
			
			if (! $result) {
				die( ($this->quiet !== TRUE ? "Oops... Error in a query string. <br>Server says: " . $this->mysqli->error . ".<br>Couldn't proceed. Script terminated." : ""));
			}
			else {
				if ($this->quiet !== TRUE) echo ((strlen($query) > 20) ? substr($query,0,25).'... ' : $query) .'ok. ' . ($this->mysqli->info ? $this->mysqli->info . ".<br>" : "<br>");
			}
			return $result;
		}

		

		public function sanitize($input) {
			if ($input == NULL || $input == 'undefined') return NULL;
			return $this->mysqli->real_escape_string($input);
		}


		public function __construct($db, $info=FALSE, $quiet=TRUE) {

			$this->quiet = $quiet;


			$this->mysqli = new mysqli(
				$db['host'],
				$db['user'],
				$db['pass'],
				($info === FALSE ? $db['dbname'] : 'information_schema')
			);

			if (mysqli_connect_error()) {
		    	die( ($this->quiet !== TRUE ? 'Error in connecting to database. <br>Server says: Error ' . mysqli_connect_errno() . '. ' . mysqli_connect_error() . ".<br>Script terminated.": '') );
			}
			else{
				if ($this->quiet !== TRUE) echo 'Connected to database. ' . $this->mysqli->host_info . ".<br>";
			}
		}

		public function __destruct() {
			$this->mysqli->close();
		}
	}

?>