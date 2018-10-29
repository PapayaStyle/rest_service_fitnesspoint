<?php
	require 'request.php';
	
	include $_SERVER['DOCUMENT_ROOT']."/manager/db/dao/galleryDAO.php";
	
	$daoG = new GalleryDAO();
	$images = $daoG->getAllToShowByPage("gallery");
	
	$outp = "";
	
	foreach ($images as $img) {
		
		if ($outp != "") {$outp .= ",";}
		
		$outp .=  '{"small": "'.$img->getPreview().'",';
		$outp .=  '"medium": "'.$img->getImg().'",';
		$outp .=  '"big": "'.$img->getImg().'"}';
		
	}
	
	$outp = '['.$outp.']';
	echo($outp);
		
?>