<?php

require_once $_SERVER['DOCUMENT_ROOT']."/db/system/connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/db/QueryExtractor.php";
require_once $_SERVER['DOCUMENT_ROOT']."/db/dto/galleryDTO.php";

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
			$stmt->bind_result($id, $thumbnail, $preview, $img, $showed, $page);
			
			$dtoList = array();
			while( $stmt->fetch() ){
				$dto = new GalleryDTO();	
				$dto->setId($id);
				$dto->setThumbnail($thumbnail);
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
			$stmt->bind_result($id, $thumbnail, $preview, $img, $showed, $page);
			
			$dtoList = array();
			while( $stmt->fetch() ){
				$dto = new GalleryDTO();	
				$dto->setId($id);
				$dto->setThumbnail($thumbnail);
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
			$stmt->bind_result($id, $thumbnail, $preview, $img, $showed, $page);
			
			$dtoList = array();
			while( $stmt->fetch() ){
				$dto = new GalleryDTO();	
				$dto->setId($id);
				$dto->setThumbnail($thumbnail);
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
	
	public function selectById($id) {
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectById");
		
		if( $stmt = $this->conn -> prepare($query) ){
			
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($id, $thumbnail, $preview, $img, $showed, $page);
			
			$dtoList = array();
			while( $stmt->fetch() ){
				$dto = new GalleryDTO();	
				$dto->setId($id);
				$dto->setThumbnail($thumbnail);
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
	
	public function insert($thumbnail, $preview, $img, $showed, $page) {
		$this->conn->start();

		$query = $this->extractor->extractByName("insert");

		if ($stmt = $this->conn->prepare($query)) {
		
			$stmt->bind_param("sssis", $thumbnail, $preview, $img, $showed, $page);

			$stmt->execute() or die($this->conn->error());
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
	}
	
	public function update($id, $showed, $page) {
		$this->conn->start();

		$query = $this->extractor->extractByName("update");

		if ($stmt = $this->conn->prepare($query)) {
		
			$stmt->bind_param("is", $showed, $page, $id);

			$stmt->execute() or die($this->conn->error());
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}		
	}
	
	public function delete($id) {
		$this->conn->start();

		$query = $this->extractor->extractByName("delete");
		
		if ($stmt = $this->conn->prepare($query)) {

			$stmt->bind_param("i", $id);

			$stmt->execute() or die($this->conn->error());
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}		
	}
	
}

?>