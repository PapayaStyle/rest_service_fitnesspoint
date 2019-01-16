<?php

include $_SERVER['DOCUMENT_ROOT']."/db/mapper/staffMapper.php";

class StaffDAO{

	private $mapper; 
		
	public function __construct(){
		$this->mapper = new StaffMapper();
	}
	
	public function getAll(){
		return $this->mapper->selectAll();
	}
	
	public function getAllToShow(){
		return $this->mapper->selectAllToShow();
	}
	
	public function insert($name, $act, $desc, $img, $portrait, $show){
		return $this->mapper->insert($name, $act, $desc, $img, $portrait, $show);
	}
	
	public function update($id, $name, $act, $desc, $img, $portrait, $show){
		return $this->mapper->update($id, $name, $act, $desc, $img, $portrait, $show);
	}
	
	public function deleteById($id){
		return $this->mapper->deleteById($id);
	}
	
}

?>
