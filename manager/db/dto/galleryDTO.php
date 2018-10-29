<?php

class GalleryDTO{
	
	private $id;
	private $preview;
	private $img;
	private $showed;
	private $page;
	
	public function __construct(){
	}
	

	public function getId(){
		return $this->id;
	}
	public function getPreview(){
		return $this->preview;
	}
	public function getImg(){
		return $this->img;
	}
	public function getShowed(){
		return $this->showed;
	}
	public function getPage(){
		return $this->page;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	public function setPreview($preview){
		$this->preview = $preview;
	}
	public function setImg($img){
		$this->img = $img;
	}
	public function setShowed($showed){
		$this->showed = $showed;
	}
	public function setPage($page){
		$this->page = $page;
	}
	
}

?>
