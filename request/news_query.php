<?php
	require 'request.php';
	include $_SERVER['DOCUMENT_ROOT']."/db/dao/newsDAO.php";
	
	//$data = json_decode($_GET['data']);
	//$req = $data->req;
	$req = $_GET['req'];
	
	$daoN = new NewsDAO();
	
	if($req == 'ALL') {
		$listNews = $daoN->getAll();
	} else if($req == 'SHOW') {
		$listNews = $daoN->getAllToShow();
	} else if($req == 'LAST') {
		$listNews = $daoN->getLastNews();
	} else {
		echo '{"status":"KO", "message": "Invalid request parameter"}';
		return false;
	}
	
	
	$outp = "";
	
	$strSrc = array('<br />', '"');
	$strRpl = array('\n', '\"');
	
	$desc = "";
	$img = "";
	foreach ($listNews as $news) {
		
		if ($outp != "") {$outp .= ",";}
		
		$outp .=  '{"id": "'.$news->getId().'",';
		$outp .=  '"title": "'.$news->getTitle().'",';
		
		$desc = str_replace( $strSrc, $strRpl, $news->getDesc());
		$outp .=  '"desc": "'.$desc.'",';
		$desc  = "";
		
		//$img = str_replace( 'img', 'images', $news->getImg());
		$outp .=  '"image": "'.$news->getImg().'",';
		$img = "";
		
		$outp .=  '"video": "'.$news->getUrl().'",';
		
		$outp .=  '"show": "'.$news->getShow().'",';
		
		$outp .=  '"date": "'.$news->getDat().'"}';
		
	}
	
	$outp = '['.$outp.']';
	echo($outp);
		
?>