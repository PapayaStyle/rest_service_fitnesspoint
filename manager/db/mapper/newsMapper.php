<?php

require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/system/connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/QueryExtractor.php";
require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/dto/newsDTO.php";

class NewsMapper {

	private $conn;
	private $extractor;
   
	public function __construct() {
		$this->conn = new Connect();
		$this->extractor = new QueryExtractor("/mapper/newsMapper.xml");
	}
   
	public function selectAll() {

		$this->conn->start();

		$query = $this->extractor->extractByName("selectAll");

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->execute();
			$stmt->bind_result($id, $title, $desc, $img, $url, $date, $show);

			$dtoList = array();

			while ($stmt->fetch()) {
				$dto = new NewsDTO();
				$dto->setId($id);
				$dto->setTitle($title);
				$dto->setDesc($desc);
				$dto->setImg($img);
				$dto->setUrl($url);
				$dto->setDat($date);
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
			$stmt->bind_result($id, $title, $desc, $img, $url, $date, $show);

			$dtoList = array();

			while ($stmt->fetch()) {
				$dto = new NewsDTO();
				$dto->setId($id);
				$dto->setTitle($title);
				$dto->setDesc($desc);
				$dto->setImg($img);
				$dto->setUrl($url);
				$dto->setDat($date);
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
   
	public function selectLastNews() {

		$this->conn->start();

		$query = $this->extractor->extractByName("selectLastNews");

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->execute();
			$stmt->bind_result($id, $title, $desc, $img, $url, $date, $show);

			$dtoList = array();

			while ($stmt->fetch()) {
				$dto = new NewsDTO();
				$dto->setId($id);
				$dto->setTitle($title);
				$dto->setDesc($desc);
				$dto->setImg($img);
				$dto->setUrl($url);
				$dto->setDat($date);
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
	
	public function insert($title, $desc, $img, $url, $dat, $show) {

		$this->conn->start();

		$query = $this->extractor->extractByName("insert");

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->bind_param("sssssi", $title, $desc, $img, $url, $dat, $show);

			$stmt->execute() or die($this->conn->error());
			
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}
		$this->conn->close();
	}
	
	public function update($id, $title, $desc, $img, $url, $dat, $show) {

		$this->conn->start();

		$query = $this->extractor->extractByName("update");

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->execute();

			$stmt->bind_param("sssssii", $title, $desc, $img, $url, $dat, $show, $id);

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