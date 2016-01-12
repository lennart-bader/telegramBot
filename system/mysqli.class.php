<?php
class MySql {
		private $server;
		private $user;
		private $password;
		private $database;
		

		private $connection;
		private $db_connection;

		private $resource;

		private $error;

// =============================================================================
// KONSTRUKTOR & DESTRUKTOR
// =============================================================================

		public function __construct($server = dbserver, $user = dbusername, $password = dbpassword, $database = dbdatabase)
		{
			$this->setServer($server);
			$this->setUser($user);
			$this->setPassword($password);
			$this->setDatabase($database);
			$this->connect();
			

			$this->error = '';
		}
		public function __destruct()
		{
			$this->disconnect();
		}

// =============================================================================
// GET-FUNKTIONEN
// =============================================================================

		public function getServer()       { return $this->server; }
		public function getUser()         { return $this->user; }
		public function getPassword()     { return $this->password; }
		public function getDatabase()     { return $this->database; }
		public function getConnection()   { return $this->connection; }
		public function getDBConnection() { return $this->db_connection; }
		public function getMySQLVersion() 
			{ 
				$version = mysqli_get_client_version();
				
				$mv=floor($version / 10000);
				
				
				$version=$version - $mv*10000;
				$sv=floor($version / 100);
				
				$bv=$version-$sv*100;
				
				
				return $mv.".".$sv.".".$bv; 
				
				//return mysqli_get_client_version();
			}

// =============================================================================
// SET-FUNKTIONEN
// =============================================================================

		public function setServer($server)
		{
			if(is_string($server))
				$this->server = $server;
			else
				$this->error .= 'Der MySQL-Server ist ung&uumlltig. ';
		}
		public function setUser($user)
		{
			if(is_string($user))
				$this->user = $user;
			else
				$this->error .= 'Der MySQL-Username ist ung&uumlltig.';
		}
		public function setPassword($password)
		{
			if(is_string($password))
				$this->password = $password;
			else
				$this->error .= 'Das MySQL-Passwort ist ung&uumlltig. ';
		}
		public function setDatabase($database)
		{
			if(is_string($database))
				$this->database = $database;
			else
				$this->error .= 'Die MySQL-Datenbank ist ung&uumlltig. ';
		}

// =============================================================================
// connect
// =============================================================================

		/**
		* @return void
		* @desc Zur Datenbank verbinden
		* @access public
		*/
		public function connect()
		{
		    $this->connection = mysqli_connect($this->server, $this->user, $this->password, $this->database) or die("Fehler: " . mysqli_connect_error());
			mysqli_set_charset($this->connection, 'utf8');
			if(!$this->connection)
			{
				die($this->error.'Verbindungsaufbau zum Server fehlgeschlagen. MySQL-Error #'.mysqli_connect_errno().': '.mysqli_connect_error().'. ');
			}
		}

// =============================================================================
// disconnect
// =============================================================================

		public function disconnect()
		{
			if (!isset($this->connection)) {
				return;
			}
			$disconnect = @mysqli_close($this->connection);
			unset($this->connection);
			if(!$disconnect)
				$this->error .= 'Schließen der MySQL-Verbindung fehlgeschlagen. MySQL-Error #'.mysqli_connect_errno().': '.mysqli_connect_error().'. ';
		}

// =============================================================================
// query
// =============================================================================

		public function query($sql_query)
		{
			$this->resource	= null;
			$this->error = null;
			//$GLOBALS['sql_query']++;
			
			$this->resource = mysqli_query($this->connection, $sql_query);
			if(!$this->resource)
				$this->error.=('Beim ausf&uuml;hren der Query trat ein Fehler auf. MySQL-Error #'.mysqli_errno($this->connection).': '.mysqli_error($this->connection).'.<br />Datenbank-Abfrage: ' . $sql_query);
		}
		
// =============================================================================
// affected_rows
// =============================================================================

		public function affected_rows()
		{
			return mysqli_affected_rows($this->connection);
		}
		
		public function affectedRows()
		{
			return mysqli_affected_rows($this->connection);
		}
		
// =============================================================================
// escape_string
// =============================================================================

		public function escape_string($string)
		{
			return mysqli_real_escape_string($this->connection,$string);
		}

		
// =============================================================================
// escape
// =============================================================================

		public function escape($string)
		{
			return mysqli_real_escape_string($this->connection,$string);
		}


// =============================================================================
// fetchArray
// =============================================================================

		public function fetchArray()
		{
			$data = mysqli_fetch_array($this->resource);
			if($data)
				return $data;
			else
				$this->error .= 'Beim auslesen der Resource trat ein Fehler auf (Array). MySQL-Error #'.mysqli_errno($this->connection).': '.mysqli_error($this->connection).'. ';
		}
		
		
// =============================================================================
// InsertID
// =============================================================================

		public function insertID()
		{
			$data = @mysqli_insert_id($this->connection);
			if($data)
				return $data;
			else
				$this->error .= 'Beim Bearbeiten der Abfrage trat ein Fehler auf. MySQL-Error #'.mysqli_errno($this->connection).': '.mysqli_error($this->connection).'. ';
		}
		
// =============================================================================
// fetchAssoc
// =============================================================================

		public function fetchAssoc()
		{
			$data = @mysqli_fetch_assoc($this->resource);
			if($data)
				return $data;
			else
				$this->error .= 'Beim auslesen der Resource trat ein Fehler aus. MySQL-Error #'.mysqli_errno($this->connection).': '.mysqli_error($this->connection).'. ';
		}

// =============================================================================
// numRows
// =============================================================================

		public function numRows()
		{
			$data = @mysqli_num_rows($this->resource);
			if($data)
				return $data;
			else
				return 0;
		}

// =============================================================================
// error
// =============================================================================

		public function error()
		{
			return $this->error;
		}
		
// =============================================================================
// Ressource
// =============================================================================

		public function GetResource()
		{
			return $this->resource;
		}
	}
?>
