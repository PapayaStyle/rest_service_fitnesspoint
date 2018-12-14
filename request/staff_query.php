<?php
	require 'request.php';
	
	include $_SERVER['DOCUMENT_ROOT']."/manager/db/dao/staffDAO.php";
	
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
		
		$outp .=  '"show": "'.$staff->getShow().'"}';
		
		/*
		{ name: 'Oliver', activity: 'Spinning e Posturale', desc: 'Guinness World Record TRX, spinning man e posturale', image:'./images/spinning.jpg'},
		*/
	}
	
	$outp = '['.$outp.']';
	echo($outp);
		
?>