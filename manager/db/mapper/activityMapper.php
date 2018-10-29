<?php

require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/system/connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/QueryExtractor.php";
require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/dto/activityDTO.php";

class ActivityMapper {

   private $conn;
   private $extractor;

   public function __construct() {
      $this->conn = new Connect();
      $this->extractor = new QueryExtractor("/mapper/activityMapper.xml");
   }

	public function selectAll() {

		$this->conn->start();

		$query = $this->extractor->extractByName("selectAll");

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->execute();
			$stmt->bind_result($id, $name, $des, $img, $url, $show);

			$dtoList = array();

			while ($stmt->fetch()) {
				$dto = new ActivityDTO();
				$dto->setId($id);
				$dto->setName($name);
				$dto->setDes($des);
				$dto->setImg($img);
				$dto->setUrl($url);
				$dto->setShow($show);

				$dtoList[] = $dto;
			}
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}
		$this->conn->close();
		return $dtoList;
	}
   
	public function selectAllToShow() {

		$this->conn->start();

		$query = $this->extractor->extractByName("selectAllToShow");

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->execute();
			$stmt->bind_result($id, $name, $des, $img, $url, $show);

			$dtoList = array();

			while ($stmt->fetch()) {
				$dto = new ActivityDTO();
				$dto->setId($id);
				$dto->setName($name);
				$dto->setDes($des);
				$dto->setImg($img);
				$dto->setUrl($url);
				$dto->setShow($show);

				$dtoList[] = $dto;
			}
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}
		$this->conn->close();
		return $dtoList;
	}

	public function selectOne($id) {

		$this->conn->start();

		$query = $this->extractor->extractByName("selectOne");

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->bind_param("i", $id);

			$stmt->execute();
			$stmt->bind_result($id, $name, $des, $img, $url, $show);

			$stmt->fetch();

			$dto = new ActivityDTO();
			$dto->setId($id);
			$dto->setName($name);
			$dto->setDes($des);
			$dto->setImg($img);
			$dto->setUrl($url);
			$dto->setShow($show);

			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}
		$this->conn->close();
		return $dto;
	}

	public function update($id, $name, $des, $img, $url, $show) {

		$this->conn->start();

		$query = $this->extractor->extractByName("update");

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->execute();

			$stmt->bind_param("ssssii", $name, $des, $img, $url, $show, $id);

			$stmt->execute() or die($this->conn->error());
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}
		$this->conn->close();
	}
	
	public function updateNoImg($id, $name, $des, $show) {

		$this->conn->start();

		$query = $this->extractor->extractByName("updateNoImg");

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->execute();

			$stmt->bind_param("ssii", $name, $des, $show, $id);

			$stmt->execute() or die($this->conn->error());
			
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
	}
	
	public function insert($name, $des, $img, $url, $show) {

		$this->conn->start();

		$query = $this->extractor->extractByName("insert");

		if ($stmt = $this->conn->prepare($query)) {
		
			$stmt->bind_param("ssssi", $name, $des, $img, $url, $show);

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
		
			$stmt->bind_param("i", $id);

			$stmt->execute() or die($this->conn->error());
			
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}
		$this->conn->close();
	}
   
}
?>