<?php

require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/system/connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/QueryExtractor.php";
require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/dto/galleryDTO.php";

class GalleryMapper {

	private $conn;
	private $extractor;
	
	public function __construct(){
		$this->conn = new Connect();
		$this->extractor =new QueryExtractor("/mapper/galleryMapper.xml");
	}
	
	
	public function selectAll() {
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectAll");
		
		if( $stmt = $this->conn -> prepare($query) ){
			
			$stmt->execute();
			$stmt->bind_result($id, $preview, $img, $showed, $page);
			
			$dtoList = array();
			while( $stmt->fetch() ){
				$dto = new GalleryDTO();	
				$dto->setId($id);
				$dto->setPreview($preview);
				$dto->setImg($img);
				$dto->setShowed($showed);
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
	
	public function selectAllByPage($page) {
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectAllByPage");
		
		if( $stmt = $this->conn -> prepare($query) ){
			
			$stmt->bind_param("s", $page);
			
			$stmt->execute();
			$stmt->bind_result($id, $preview, $img, $showed, $page);
			
			$dtoList = array();
			while( $stmt->fetch() ){
				$dto = new GalleryDTO();	
				$dto->setId($id);
				$dto->setPreview($preview);
				$dto->setImg($img);
				$dto->setShowed($showed);
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

	public function selectToShowByPage($page) {
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectToShowByPage");
		
		if ($page == 'home')
			$query = $query." order by DAT_INS desc";
		
		if( $stmt = $this->conn -> prepare($query) ){
			
			$stmt->bind_param("s", $page);
			
			$stmt->execute();
			$stmt->bind_result($id, $preview, $img, $showed, $page);
			
			$dtoList = array();
			while( $stmt->fetch() ){
				$dto = new GalleryDTO();	
				$dto->setId($id);
				$dto->setPreview($preview);
				$dto->setImg($img);
				$dto->setShowed($showed);
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
	
	public function selectByIds($ids) {
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectByIds");
		$query = $query.$ids.")";
		
		if( $stmt = $this->conn -> prepare($query) ){
			
			$stmt->execute();
			$stmt->bind_result($id, $preview, $img, $showed, $page);
			
			$dtoList = array();
			while( $stmt->fetch() ){
				$dto = new GalleryDTO();	
				$dto->setId($id);
				$dto->setPreview($preview);
				$dto->setImg($img);
				$dto->setShowed($showed);
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
	
	public function insert($preview, $img, $showed, $page) {
		$this->conn->start();

		$query = $this->extractor->extractByName("insert");

		if ($stmt = $this->conn->prepare($query)) {
		
			$stmt->bind_param("ssis", $preview, $img, $showed, $page);

			$stmt->execute() or die($this->conn->error());
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
	}
	
	public function update($ids, $showed) {
		$this->conn->start();

		$query = $this->extractor->extractByName("update");
		$query = $query.$ids.")";

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->execute();
		
			$stmt->bind_param("i", $showed);

			$stmt->execute() or die($this->conn->error());
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}		
	}
	
	public function delete($ids) {
		$this->conn->start();

		$query = $this->extractor->extractByName("delete");
		$query = $query.$ids.")";
		
		if ($stmt = $this->conn->prepare($query)) {

			$stmt->execute();

			$stmt->execute() or die($this->conn->error());
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}		
	}
	
}

?>