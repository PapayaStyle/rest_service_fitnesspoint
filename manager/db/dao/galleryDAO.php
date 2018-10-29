<?php

include $_SERVER['DOCUMENT_ROOT']."/manager/db/mapper/galleryMapper.php";

class GalleryDAO{

	private $mapper; 
		
	public function __construct(){
		$this->mapper = new GalleryMapper();
	}
	
	public function getAll() {
		return $this->mapper->selectAll();
	}
	
	public function getAllByPage($page) {
		return $this->mapper->selectAllByPage($page);
	}
	
	public function getAllToShowByPage($page) {
		return $this->mapper->selectToShowByPage($page);
	}
	
	public function selectByIds($ids) {
		return $this->mapper->selectByIds($ids);
	}
	
	public function insert($preview, $img, $showed, $page)  {
		return $this->mapper->insert($preview, $img, $showed, $page);
	}
	
	public function update($ids, $showed) {
		return $this->mapper->update($ids, $showed);
	}
	
	public function delete($ids) {
		return $this->mapper->delete($ids);
	}
	
}

?>
