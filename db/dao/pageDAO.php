<?php

include $_SERVER['DOCUMENT_ROOT']."/db/mapper/pageMapper.php";

class PageDAO{

	private $mapper; 
		
	public function __construct(){
		$this->mapper = new PageMapper();
	}
	
	public function getAll(){
		return $this->mapper->selectAll();
	}
	
}

?>
