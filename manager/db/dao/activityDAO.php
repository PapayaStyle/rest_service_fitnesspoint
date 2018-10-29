<?php

include $_SERVER['DOCUMENT_ROOT']."/manager/db/mapper/activityMapper.php";

class ActivityDAO{

	private $mapper; 
		
	public function __construct(){
		$this->mapper = new ActivityMapper();
	}
	
	public function getAll(){
		return $this->mapper->selectAll();
	}
	
	public function getAllToShow(){
		return $this->mapper->selectAllToShow();
	}
	
	public function selectOne($id){
		return $this->mapper->selectOne($id);
	}
        
	public function generateSelectOneMenu($listActivity, $selectedVal){
		
		$result = "<select><option value='0'>seleziona...</option>";
		foreach ($listActivity as $activity) {
		   if($activity->getName() == $selectedVal){
			  $result = $result . "<option value='" . ($activity->getId()) . "' selected >" . ($activity->getName()) . "</option>";  
		   }else{
			  $result = $result . "<option value='" . ($activity->getId()) . "' >" . ($activity->getName()) . "</option>";
		   }
		}
		$result = $result . "</select>";
	   
		return $result;
	}
	
	public function update($id, $name, $des, $img, $url, $show){
		return $this->mapper->update($id, $name, $des, $img, $url, $show);
	}
	
	public function updateNoImg($id, $name, $des, $show){
		return $this->mapper->updateNoImg($id, $name, $des, $show);
	}
	
	public function insert($name, $des, $img, $url, $show){
		//echo "\ndao->img: ".$img;
		return $this->mapper->insert($name, $des, $img, $url, $show);
	}
	
	public function delete($id){
		return $this->mapper->deleteById($id);
	}
}

?>
