<?php

class CalendarActivityDTO{
	
	private $id;
	private $time;
	private $day;
	private $activity;
	private $note;
	
	public function __construct(){
	}
	
	
	public function setId($id){
		$this->id = $id;
	}
	public function setTime($time){
		$this->time = $time;
	}
	public function setDay($day){
		$this->day = $day;
	}
	public function setActivity($activity){
		$this->activity = $activity;
	}
	public function setNote($note){
		$this->note = $note;
	}
	
	public function getId(){
		return $this->id;
	}
	public function getTime(){
		return $this->time;
	}
	public function getDay(){
		return $this->day;
	}
	public function getActivity(){
		return $this->activity;
	}
	public function getNote(){
		return $this->note;
	}
	
}
