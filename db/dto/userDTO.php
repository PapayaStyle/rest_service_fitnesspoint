<?php

class UserDTO{
	
	private $id;
	private $username;
	
	public function __construct(){
	}
	
	
	public function setId($id){
		$this->id = $id;
	}
	public function setUsername($username){
		$this->username = $username;
	}

	public function getId(){
		return $this->id;
	}
	public function getUsername(){
		return $this->username;
	}
	
}

?>
