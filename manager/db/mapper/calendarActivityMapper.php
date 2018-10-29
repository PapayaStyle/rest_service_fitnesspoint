<?php

require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/system/connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/QueryExtractor.php";
require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/dto/calendarActivityDTO.php";

class CalendarActivityMapper{

	private $conn;
	private $extractor;
	
	public function __construct(){
		$this->conn = new Connect();
		$this->extractor =new QueryExtractor("/mapper/calendarActivityMapper.xml");
	}
	
	public function selectAll(){
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectAll");
		
		if( $stmt = $this->conn -> prepare($query) ){
		
			$stmt->execute();
			$stmt->bind_result($id,$time,$day,$activity);
			
			$dtoList = array();
			
			while( $stmt->fetch() ){
			
				$dto = new CalendarActivityDTO();
				$dto->setId($id);
				$dto->setTime($time);	
				$dto->setDay($day);
				$dto->setActivity($activity);
				
				$dtoList[]=$dto;
			}
			$_SESSION['error'] = $this->conn->error();
			
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		
		return $dtoList;
		
	}
	
	public function insert($time,$day,$activity,$note){
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("insert");
		
		if( $stmt = $this->conn -> prepare($query) ){
		
			$stmt->bind_param("ssis", $time,$day,$activity,$note);

			$stmt->execute() or die($this->conn->error());
			$_SESSION['error'] = $this->conn->error();
			
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
	}
	
	public function truncate(){
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("truncate");
		
		if( $stmt = $this->conn -> prepare($query) ){

			$stmt->execute() or die($this->conn->error());
			$_SESSION['error'] = $this->conn->error();
			
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
	}
	
}
	
?>
