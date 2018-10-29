<?php

class ActivityDTO{
	
	private $id;
	private $name;
	private $des;
	private $img;
	private $url;
	private $show;
	
	public function __construct(){
	}
	
	
	public function setId($id){
		$this->id = $id;
	}
	public function setName($name){
		$this->name = $name;
	}
	public function setDes($des){
		$this->des = $des;
	}
	public function setImg($img){
		$this->img = $img;
	}
	public function setUrl($url){
		$this->url = $url;
	}
	public function setShow($show){
		$this->show = $show;
	}

	public function getId(){
		return $this->id;
	}
	public function getName(){
		return $this->name;
	}
	public function getDes(){
		return $this->des;
	}
	public function getImg(){
		return $this->img;
	}
	public function getUrl(){
		return $this->url;
	}
	public function getShow(){
		return $this->show;
	}
	
}

?>
