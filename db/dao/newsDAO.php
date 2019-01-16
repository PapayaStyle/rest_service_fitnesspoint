<?php

include $_SERVER['DOCUMENT_ROOT']."/db/mapper/newsMapper.php";

class NewsDAO{

	private $mapper; 
		
	public function __construct(){
		$this->mapper = new NewsMapper();
	}
	
	public function getAll(){
		return $this->mapper->selectAll();
	}
	
	public function getAllToShow(){
		return $this->mapper->selectAllToShow();
	}
	
	public function getLastNews(){
		return $this->mapper->selectLastNews();
	}
	
	public function insert($title, $desc, $img, $url, $dat, $show){
		return $this->mapper->insert($title, $desc, $img, $url, $dat, $show);
	}
	
	public function update($id, $title, $desc, $img, $url, $dat, $show){
		return $this->mapper->update($id, $title, $desc, $img, $url, $dat, $show);
	}
	
	public function deleteById($id){
		return $this->mapper->deleteById($id);
	}
	
}

?>
