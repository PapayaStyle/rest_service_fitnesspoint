<?php

class NewsDTO{
	
	private $id;
	private $title;
	private $desc;
	private $img;
	private $url;
	private $dat;
	private $show;
	
	public function __construct(){
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
	public function setImg($img){
		$this->img = $img;
	}
	public function setUrl($url){
		$this->url = $url;
	}
	public function setDat($dat){
		$this->dat = $dat;
	}
	public function setShow($show){
		$this->show = $show;
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
	public function getImg(){
		return $this->img;
	}
	public function getUrl(){
		return $this->url;
	}
	public function getDat(){
		return $this->dat;
	}
	public function getShow(){
		return $this->show;
	}
	
}

?>
