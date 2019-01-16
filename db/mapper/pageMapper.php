<?php

require_once $_SERVER['DOCUMENT_ROOT']."/db/system/connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/db/QueryExtractor.php";
require_once $_SERVER['DOCUMENT_ROOT']."/db/dto/pageDTO.php";

class PageMapper {

	private $conn;
	private $extractor;
	
	public function __construct(){
		$this->conn = new Connect();
		$this->extractor =new QueryExtractor("/mapper/pageMapper.xml");
	}
	
	
	public function selectAll() {
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectAll");
		
		if( $stmt = $this->conn -> prepare($query) ){
			
			$stmt->execute();
			$stmt->bind_result($id, $page, $name);
			
			$dtoList = array();
			
			while( $stmt->fetch() ){
			
				$dto = new PageDTO();	
				$dto->setId($id);
				$dto->setPage($page);
				$dto->setName($name);
				
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