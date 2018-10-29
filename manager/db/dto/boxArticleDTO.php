<?php

class BoxArticleDTO{
	
	private $id;
	private $title;
	private $desc;
	private $show;
	private $page;
	private $page_title;
	
	public function __construct(){
	}
	
	
	public function getId(){
		return $this->id;
	}
	public function getTitle(){
		return $this->title;
	}
	public function getDesc(){
		return $this->desc;
	}
	public function getShow(){
		return $this->show;
	}
	public function getPage(){
		return $this->page;
	}
	public function getPageTitle(){
		return $this->page_title;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	public function setTitle($title){
		$this->title = $title;
	}
	public function setDesc($desc){
		$this->desc = $desc;
	}
	public function setShow($show){
		$this->show = $show;
	}
	public function setPage($page){
		$this->page = $page;
	}
	public function setPageTitle($page_title){
		$this->page_title = $page_title;
	}
	
}

?>
