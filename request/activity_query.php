<?php
	require 'request.php';
	
	include $_SERVER['DOCUMENT_ROOT']."/db/dao/activityDAO.php";
	
	//$data = json_decode($_POST['data']);
	//$req = $data->req;
	$req = $_GET['req'];
	
	$daoA = new ActivityDAO();
	
	if($req == 'ALL') {
		$listActivity = $daoA->getAll();
	} else if($req == 'SHOW') {
		$listActivity = $daoA->getAllToShow();
	} else {
		echo '{"status":"KO", "message": "Invalid request parameter"}';
		return false;
	}
	
	$outp = "";
	
	$count = 0;
	
	$strSrc = array('<br />', '"');
	$strRpl = array('\n', '\"');
	
	$desc = "";
	$img = "";
	$firstOut = "";
	foreach ($listActivity as $activity) {
		
		//if($count == 0) {$count++; continue;}

		$nameLink = str_replace(' ', '', strtolower($activity->getName()));
		
		if($activity->getId() == 1) {
			$firstOut .=  '{"id": "'.$activity->getId().'",';
			
			$firstOut .=  '"link": "'.$nameLink.'",';
			
			//$img = str_replace( 'img', 'images', $activity->getImg());
			$firstOut .=  '"image": ".'.$activity->getImg().'",';
			$img = "";
			
			$firstOut .=  '"title": "'.$activity->getName().'",';
			
			$desc = str_replace( $strSrc, $strRpl, $activity->getDes());
			$firstOut .=  '"desc": "'.$desc.'",';
			
			$firstOut .=  '"video": "'.$activity->getUrl().'",';
			
			$firstOut .=  '"show": "'.$activity->getShow().'"}';
			$desc  = "";
		} else {
			if ($outp != "") {$outp .= ",";}
			
			$outp .=  '{"id": "'.$activity->getId().'",';
		
			$outp .=  '"link": "'.$nameLink.'",';
			
			$img = str_replace( 'img', 'images', $activity->getImg());
			$outp .=  '"image": ".'.$img.'",';
			$img = "";
			
			$outp .=  '"title": "'.$activity->getName().'",';
			
			$desc = str_replace( $strSrc, $strRpl, $activity->getDes());
			$outp .=  '"desc": "'.$desc.'",';
			
			$outp .=  '"video": "'.$activity->getUrl().'",';
			
			$outp .=  '"show": "'.$activity->getShow().'"}';
			$desc  = "";
		}
	}
	
	$outp = '['.$firstOut.','.$outp.']';
	echo($outp);
		
?>