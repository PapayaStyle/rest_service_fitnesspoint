<?php
	require 'request.php';
	
	include $_SERVER['DOCUMENT_ROOT']."/db/dao/tableViewDAO.php";

	$daoTW = new TableViewDAO();
	$listTime = $daoTW->getDistinctTime();
	$days = array("LUNEDI", "MARTEDI", "MERCOLEDI", "GIOVEDI", "VENERDI");

	$outp = "";
	
	$subDay = "";
	$subarr = "";
	
	foreach ($listTime as $time) {
		
		if ($outp != "") {$outp .= ",";}
		
		$outp .=  '{"time":"'.$time.'",';
		
		for ($i = 0; $i < 5; $i++) {
			
			if ($subDay != "") {
				$outp .= ","; 
			}
			$subDay="fill";
				
			switch($i) {
				case 0: 
					$outp .=  '"monday": [';
					break;
				
				case 1:
					$outp .=  '"tuesday": [';
					break;
					
				case 2:
					$outp .=  '"wednesday": [';
					break;
					
				case 3:
					$outp .=  '"thursday": [';
					break;
					
				case 4:
					$outp .=  '"friday": [';
					break;
			}
			
			$listActivity = $daoTW->getFilteredByTimeDay($time, $days[$i]);

			foreach ($listActivity as $activity) {
				$nameLink = str_replace(' ', '', strtolower($activity->getActivity()));
				
				if ($subarr != "") {
					$outp .= ","; 
				}
				$subarr="fill";
				
				$outp .=  '{"id":"'.$activity->getId().'",';
				$outp .=  '"name":"'.$activity->getActivity().'",';
				$outp .=  '"note":"'.$activity->getNote().'",';
				$outp .=  '"link":"'.$nameLink.'"}';
			}
			$outp .=  ']';
			$subarr = "";
		}
		$outp .=  '}';
		$subDay = "";
		
	}

	//$outp = '{"courses":['.$outp.']}';
	$outp = '['.$outp.']';
	echo($outp);

	/*
    { time: '10:00', 
      monday: [{activity: 'Ginnastica Dolce'}], 
      tuesday: '',
      wednesday: [{activity: 'Pilates'}], 
      thursday: '',
      fryday: [{activity: 'Pilates'}] }
	  ...
	  */
?>
