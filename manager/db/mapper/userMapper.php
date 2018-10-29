<?php

require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/system/connection.php";
require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/QueryExtractor.php";
require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/dto/userDTO.php";

class UserMapper{

	private $conn;
	private $extractor;
	
	public function __construct(){
		$this->conn = new Connect();
		$this->extractor =new QueryExtractor("/mapper/userMapper.xml");
	}
	
	
	public function selectOne($username,$password){
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("selectOne");
		
		if( $stmt = $this->conn -> prepare($query) ){
		
			$stmt->bind_param("ss", $username,$password);
			
			$stmt->execute();
			$stmt->bind_result($id,$user);
			
			$stmt->fetch();
			$dto = new UserDTO();
			//while( $stmt->fetch() ){
				$dto->setId($id);
				$dto->setUsername($user);
			//}
			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		
		return $dto;
	}
	
	public function checkUser($id, $username){
	
		$this->conn->start();
		
		$query = $this->extractor->extractByName("checkUser");
		
		if( $stmt = $this->conn -> prepare($query) ){
			
			$stmt->bind_param("is", $id, $username);
			
			$stmt->execute();
			$stmt->bind_result($count);
			
			$stmt->fetch();

			$_SESSION['error'] = $this->conn->error();
		} else {
			$_SESSION['error'] = $this->conn->error();
		}

		$this->conn->close();
		
		return $count;
	}
	
}

?>