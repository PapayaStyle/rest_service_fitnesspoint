<?php

include $_SERVER['DOCUMENT_ROOT']."/manager/db/mapper/tableViewMapper.php";

class TableVieWDAO{

	private $mapper; 
		
	public function __construct(){
		$this->mapper = new TableViewMapper();
	}
	
	public function getDistinctTime(){
		return $this->mapper->selectDistinctTime();
	}
	
	public function getDistinctActivityData(){
		return $this->mapper->selectDistinctActivityData();
	}
	
	public function getFilteredByTimeDay($time,$day){
		return $this->mapper->selectFilteredByTimeDay($time,$day);
	}
	
	public function getFilteredByNameDay($name,$day){
		return $this->mapper->selectFilteredByNameDay($name,$day);
	}
	
	public function getAlltOrderedByTimeAll(){
		return $this->mapper->selectAlltOrderedByTimeAll();
	}
	
	public function getAlltOrderedByName(){
		return $this->mapper->selectAlltOrderedByName();
	}
	
	public function getAllOrderedByDay(){
		return $this->mapper->selectAlltOrderedByDay();
	}	
	
	public function getDetailedActivityList(){
		return $this->mapper->selectDetailedActivityList();
	}
	
	public function getDetailedActivityListToShow(){
		return $this->mapper->selectDetailedActivityListToShow();
	}
	
}

?>
