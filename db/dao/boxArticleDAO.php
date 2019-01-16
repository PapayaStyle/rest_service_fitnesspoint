<?php

include $_SERVER['DOCUMENT_ROOT']."/db/mapper/boxArticleMapper.php";

class BoxArticleDAO{

	private $mapper; 
		
	public function __construct(){
		$this->mapper = new BoxArticleMapper();
	}
	
	public function getAll(){
		return $this->mapper->selectAll();
	}
	
	public function getAllByPage($page){
		return $this->mapper->selectByPage($page);
	}
    
	
	public function update($id, $title, $desc, $show, $page){
		return $this->mapper->update($id, $title, $desc, $show, $page);
	}
	
	public function insert($title, $desc, $show, $page){
		return $this->mapper->insert($title, $desc, $show, $page);
	}
	
	public function delete($id){
		return $this->mapper->deleteById($id);
	}
}

?>
