<?php
	require 'request.php';
	
	include $_SERVER['DOCUMENT_ROOT']."/db/dao/staffDAO.php";
	
	//$data = json_decode($_POST['data']);
	//$req = $data->req;
	$req = $_GET['req'];
	
	$daoS = new StaffDAO();
	
	if($req == 'ALL') {
		$listStaff = $daoS->getAll();
	} else if($req == 'SHOW') {
		$listStaff = $daoS->getAllToShow();
	} else {
		echo '{"status":"KO", "message": "Invalid request parameter"}';
		return false;
	}
	
	$outp = "";
	
	$strSrc = array('<br />', '"');
	$strRpl = array('\n', '\"');
	
	$desc = "";
	$img = "";
	foreach ($listStaff as $staff) {
		
		if ($outp != "") {$outp .= ",";}
		
		$outp .=  '{"id": "'.$staff->getId().'",';
		$outp .=  '"name": "'.$staff->getName().'",';
		
		$outp .=  '"activity": "'.$staff->getActivity().'",';
		
		$desc = str_replace( $strSrc, $strRpl, $staff->getDes());
		$outp .=  '"desc": "'.$desc.'",';
		$desc  = "";
		
		$img = str_replace( 'img', 'images', $staff->getImg());
		$outp .=  '"image": "'.$img.'",';
		$img = "";
		
		$portrait = str_replace( 'img', 'images', $staff->getPortrait());
		$outp .=  '"portrait": "'.$portrait.'",';
		$portrait = "";
		
		$outp .=  '"show": "'.$staff->getShow().'"}';
		
	}
	
	$outp = '['.$outp.']';
	echo($outp);
		
?>