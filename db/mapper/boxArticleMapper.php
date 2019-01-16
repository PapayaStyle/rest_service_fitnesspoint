<?php

require_once $_SERVER['DOCUMENT_ROOT']."/db/system/connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/db/QueryExtractor.php";
require_once $_SERVER['DOCUMENT_ROOT']."/db/dto/boxArticleDTO.php";

class BoxArticleMapper {

	private $conn;
	private $extractor;
	
	public function __construct(){
		$this->conn = new Connect();
		$this->extractor =new QueryExtractor("/mapper/boxArticleMapper.xml");
	}
	
	
	public function selectAll() {
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectAll");
		
		if( $stmt = $this->conn -> prepare($query) ){
			
			$stmt->execute();
			$stmt->bind_result($id, $title, $desc, $show, $page, $page_title);
			
			$dtoList = array();
			
			while( $stmt->fetch() ){
			
				$dto = new BoxArticleDTO();	
				$dto->setId($id);
				$dto->setTitle($title);
				$dto->setDesc ($desc);
				$dto->setShow($show);
				$dto->setPage($page);
				$dto->setPageTitle($page_title);
				
				$dtoList[]=$dto;
			}
			$_SESSION['error'] = $this->conn->error();
			
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		
		return $dtoList;
		
	}
	
	public function selectByPage($page) {
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectByPage");
		
		if( $stmt = $this->conn -> prepare($query) ){
			
			$stmt->bind_param("s", $page);
			
			$stmt->execute();
			$stmt->bind_result($id, $title, $desc, $show, $page);
			
			$dtoList = array();
			
			while( $stmt->fetch() ){
			
				$dto = new BoxArticleDTO();	
				$dto->setId($id);
				$dto->setTitle($title);
				$dto->setDesc ($desc);
				$dto->setShow($show);
				$dto->setPage($page);
				
				$dtoList[]=$dto;
			}
			$_SESSION['error'] = $this->conn->error();
			
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		
		return $dtoList;
		
	}
	
	
	public function update($id, $title, $desc, $show, $page) {

		$this->conn->start();

		$query = $this->extractor->extractByName("update");

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->execute();
		
			$stmt->bind_param("ssisi", $title, $desc, $show, $page, $id);

			$stmt->execute() or die($this->conn->error());
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
	}
	
	public function insert($title, $desc, $show, $page) {

		$this->conn->start();

		$query = $this->extractor->extractByName("insert");

		if ($stmt = $this->conn->prepare($query)) {
		
			$stmt->bind_param("ssis", $title, $desc, $show, $page);

			$stmt->execute() or die($this->conn->error());
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
	}
	
	public function deleteById($id) {

		$this->conn->start();

		$query = $this->extractor->extractByName("deleteById");
		

		if ($stmt = $this->conn->prepare($query)) {
		
			$stmt->bind_param("s", $id);

			$stmt->execute() or die($this->conn->error());
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
	}
	
}

?>