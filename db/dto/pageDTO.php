<?php

class PageDTO{
	
	private $id;
	private $page;
	private $name;
	
	public function __construct(){
	}
	

	public function getId(){
		return $this->id;
	}
	public function getPage(){
		return $this->page;
	}
	public function getName(){
		return $this->name;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	public function setPage($page){
		$this->page = $page;
	}
	public function setName($name){
		$this->name = $name;
	}
	
}

?>
