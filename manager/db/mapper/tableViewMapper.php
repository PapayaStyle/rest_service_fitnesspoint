<?php

require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/system/connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/QueryExtractor.php";

require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/dto/tableViewDTO.php";
require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/dto/calendarActivityDTO.php";

class TableViewMapper{

	private $conn;
	private $extractor;
	
	public function __construct(){
		$this->conn = new Connect();
		$this->extractor =new QueryExtractor("/mapper/tableViewMapper.xml");
	}
	
	
	public function selectDistinctTime(){
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectDistinctTime");
		
		if( $stmt = $this->conn -> prepare($query) ){
		
			$stmt->execute();
			$stmt->bind_result($time);
			
			$timeList = array();
			
			while( $stmt->fetch() ){
			
				$timeList[]=$time;
				
			}
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		
		return $timeList;
		
	}
	
	public function selectDistinctActivityData(){
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectDistinctActivityData");
		
		if( $stmt = $this->conn -> prepare($query) ){
		
			$stmt->execute();
			$stmt->bind_result($name,$des,$img);
			
			$dtoList = array();
			
			while( $stmt->fetch() ){
			
				$dto = new TableViewDTO();	
				$dto->setName($name);
				$dto->setDes($des);
				$dto->setImg($img);
				
				$dtoList[]=$dto;
			}
			$_SESSION['error'] = $this->conn->error();
			
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		
		return $dtoList;
		
	}
	
	public function selectFilteredByTimeDay($time,$day){
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectFilteredByTimeDay");
		
		if( $stmt = $this->conn -> prepare($query) ){
		
			$stmt->bind_param("ss", $time,$day);
			
			$stmt->execute();
			
			$stmt->bind_result($id, $name, $note);

			$dtoList = array();
			while( $stmt->fetch() ) {
				/*
				$dto = new ActivityDTO();
				$dto->setId($id);
				$dto->setName($name);
				*/
				$dto = new CalendarActivityDTO();
				$dto->setId($id);
				$dto->setActivity($name);
				$dto->setNote($note);
				
				$dtoList[]=$dto;
			}
			
			$_SESSION['error'] = $this->conn->error();
			
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		
		return $dtoList;
	}
	
	public function selectFilteredByNameDay($name,$day){
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectFilteredByNameDay");
		
		if( $stmt = $this->conn -> prepare($query) ){
		
			$stmt->bind_param("ss", $name,$day);
			
			$stmt->execute();
			$stmt->bind_result($time);
			
			$stmt->fetch();
			
			$_SESSION['error'] = $this->conn->error();			
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		return $time;
		//return $nameList;
		
	}
	
	public function selectAlltOrderedByName(){
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectAllOrderedByName");
		
		if( $stmt = $this->conn -> prepare($query) ){
		
			$stmt->execute();
			$stmt->bind_result($time,$day,$name,$des,$img);
			
			$dtoList = array();
			
			while( $stmt->fetch() ){
			
				$dto = new TableViewDTO();
				$dto->setTime($time);
				$dto->setDay($day);	
				$dto->setName($name);
				$dto->setDes($des);
				$dto->setImg($img);
				
				$dtoList[]=$dto;
			}
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		
		return $dtoList;
		
	}
	
	public function selectAlltOrderedByDay(){
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectAllOrderedByDay");
		
		if( $stmt = $this->conn -> prepare($query) ){
		
			$stmt->execute();
			$stmt->bind_result($time,$day,$name,$des,$img);
			
			$dtoList = array();
			
			while( $stmt->fetch() ){
			
				$dto = new TableViewDTO();
				$dto->setTime($time);
				$dto->setDay($day);	
				$dto->setName($name);
				$dto->setDes($des);
				$dto->setImg($img);
				
				$dtoList[]=$dto;
			}
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		
		return $dtoList;
		
	}
	
	public function selectDetailedActivityList(){
		
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectDetailedActivityList");
		
		if ( $stmt = $this->conn -> prepare($query) ){
		
			$stmt->execute();
			$stmt->bind_result($name, $des, $img, $time, $show);
			
			$dtoList = array();
			
			while( $stmt->fetch() ){
			
				$dto = new TableViewDTO();	
				$dto->setName($name);
				$dto->setDes($des);
				$dto->setImg($img);
				$dto->setTime($time);
				$dto->setShow($show);
				
				$dtoList[]=$dto;
			}
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		
		return $dtoList;
	}
	
	public function selectDetailedActivityListToShow(){
		
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectDetailedActivityListToShow");
		
		if ( $stmt = $this->conn -> prepare($query) ){
		
			$stmt->execute();
			$stmt->bind_result($name,$des,$img,$time);
			
			$dtoList = array();
			
			while( $stmt->fetch() ){
			
				$dto = new TableViewDTO();	
				$dto->setName($name);
				$dto->setDes($des);
				$dto->setImg($img);
				$dto->setTime($time);
				
				$dtoList[]=$dto;
			}
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		
		return $dtoList;
	}
	
}

?>
			