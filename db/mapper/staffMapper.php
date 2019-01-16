<?php

require_once $_SERVER['DOCUMENT_ROOT']."/db/system/connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/db/QueryExtractor.php";
require_once $_SERVER['DOCUMENT_ROOT']."/db/dto/staffDTO.php";

class StaffMapper {

   private $conn;
   private $extractor;
   
   public function __construct() {
      $this->conn = new Connect();
      $this->extractor = new QueryExtractor("/mapper/staffMapper.xml");
   }
   
   public function selectAll() {

      $this->conn->start();

      $query = $this->extractor->extractByName("selectAll");

      if ($stmt = $this->conn->prepare($query)) {

         $stmt->execute();
         $stmt->bind_result($id, $name, $activity, $des, $img, $portrait, $show);

         $dtoList = array();

         while ($stmt->fetch()) {

            $dto = new StaffDTO();
            $dto->setId($id);
            $dto->setName($name);
			$dto->setActivity($activity);
            $dto->setDes($des);
            $dto->setImg($img);
			$dto->setPortrait($portrait);
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
         $stmt->bind_result($id, $name, $activity, $des, $img, $portrait, $show);

         $dtoList = array();

         while ($stmt->fetch()) {

            $dto = new StaffDTO();
            $dto->setId($id);
            $dto->setName($name);
			$dto->setActivity($activity);
            $dto->setDes($des);
            $dto->setImg($img);
			$dto->setPortrait($portrait);
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
   
	public function insert($name, $act, $desc, $img, $portrait, $show) {
		$this->conn->start();

		$query = $this->extractor->extractByName("insert");

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->bind_param("sssssi", $name, $act, $desc, $img, $portrait, $show);

			$stmt->execute() or die($this->conn->error());
			
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}
		$this->conn->close();
	}
	
	public function update($id, $name, $act, $desc, $img, $portrait, $show) {
		$this->conn->start();

		$query = $this->extractor->extractByName("update");

		if ($stmt = $this->conn->prepare($query)) {

			$stmt->execute();

			$stmt->bind_param("sssssii", $name, $act, $desc, $img, $portrait, $show, $id);

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