<?php
	require 'request.php';
	
	include $_SERVER['DOCUMENT_ROOT']."/db/dao/galleryDAO.php";
	
	$daoG = new GalleryDAO();
	$images = $daoG->getAllToShowByPage("gallery");
	
	$outp = "";
	
	foreach ($images as $img) {
		
		if ($outp != "") {$outp .= ",";}
		
		$outp .=  '{"id": "'.$img->getId().'",';
		$outp .=  '"thumbnail": "'.$img->getThumbnail().'",';
		$outp .=  '"preview": "'.$img->getPreview().'",';
		$outp .=  '"image": "'.$img->getImg().'",';
		$outp .=  '"show": "'.$img->getShowed().'"}';
		
	}
	
	$outp = '['.$outp.']';
	echo($outp);
		
?>