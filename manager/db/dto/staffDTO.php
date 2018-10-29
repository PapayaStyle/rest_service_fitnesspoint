<?php

class StaffDTO{
	
	private $id;
	private $name;
	private $activity;
	private $des;
	private $img;
	private $show;
	
	public function __construct(){
	}
	
	
	public function setId($id){
		$this->id = $id;
	}
	public function setName($name){
		$this->name = $name;
	}
	public function setActivity($activity){
		$this->activity = $activity;
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

	public function getId(){
		return $this->id;
	}
	public function getName(){
		return $this->name;
	}
	public function getActivity(){
		return $this->activity;
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
