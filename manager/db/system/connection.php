<?php

class Connect{

	/*
	private $server = "mysql.hostinger.it";
	private $username = "u593330658_dbfp";
	private $password = "c.fitnesspoint";
	private $dbname = "u593330658_dbfp";
	*/
	private $server = "localhost";
	private $username = "root";
	private $password = "";
	private $dbname = "db_fitnesspoint";
	private $conn;
	
	public function __construct(){
	}
	
	public function start(){
		// Create connection
		$this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);
		$this->conn->set_charset("utf8");
		
		// Check connection
		if ($this->conn->connect_error) {
			 die("Connection failed: " . $this->conn->connect_error);
		} 
		//echo "Connected successfully";
		
	}

	public function close(){
		$this->conn->close();
	}

	public function prepare($query){
		return $this->conn->prepare($query);
	}
	
	public function error(){
		return $this->conn->error;
	}

        public function errorNo(){
		return $this->conn->errno;
	}
	
}
	
?>
