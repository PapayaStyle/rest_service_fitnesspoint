<?php

include $_SERVER['DOCUMENT_ROOT']."/db/mapper/galleryMapper.php";

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
	
	public function selectByIds($id) {
		return $this->mapper->selectById($id);
	}
	
	public function insert($thumbnail, $preview, $img, $showed, $page)  {
		return $this->mapper->insert($thumbnail, $preview, $img, $showed, $page);
	}
	
	public function update($id, $showed, $page) {
		return $this->mapper->update($ids, $showed, $page);
	}
	
	public function delete($id) {
		return $this->mapper->delete($id);
	}
	
}

?>
