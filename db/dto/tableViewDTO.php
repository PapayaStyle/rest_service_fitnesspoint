<?php

class TableViewDTO{
	
	private $time;
	private $day;
	private $name;
	private $des;
	private $img;
	private $show;
	
	
	public function __construct(){
	}
	
	
	public function setTime($time){
		$this->time = $time;
	}
	public function setDay($day){
		$this->day = $day;
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
	public function setShow($show){
		$this->show = $show;
	}
	
	public function getTime(){
		return $this->time;
	}
	public function getDay(){
		return $this->day;
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
	public function getShow(){
		return $this->show;
	}
	
}

?>
