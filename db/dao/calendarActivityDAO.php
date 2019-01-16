<?php

include $_SERVER['DOCUMENT_ROOT']."/db/mapper/calendarActivityMapper.php";

class CalendarActivityDAO{

	private $mapper; 
		
	public function __construct(){
		$this->mapper = new CalendarActivityMapper();
	}
	
	public function getAll(){
		return $this->mapper->selectAll();
	}
	
	public function insert($time,$day,$activity,$note){
		$this->mapper->insert($time,$day,$activity,$note);
	}
	
	public function truncate(){
		$this->mapper->truncate();
	}
	
}

?>
