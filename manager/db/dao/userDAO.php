<?php

include $_SERVER['DOCUMENT_ROOT']."/manager/db/mapper/userMapper.php";

class UserDAO{

	private $mapper; 
		
	public function __construct(){
		$this->mapper = new UserMapper();
	}
	
	public function checkLogin($username,$password){
		return $this->mapper->selectOne($username,$password);
	}
	
	public function checkUser($id,$username){
		return $this->mapper->checkUser($id,$username);
	}
	
}

?>
