<?php
	require 'request.php';
	
	include $_SERVER['DOCUMENT_ROOT']."/manager/db/dao/tableViewDAO.php";

	$daoTW = new TableViewDAO();
	$listTime = $daoTW->getDistinctTime();
	$days = array("LUNEDI", "MARTEDI", "MERCOLEDI", "GIOVEDI", "VENERDI");

	$outp = "";
	
	$subDay = "";
	$subarr = "";
	
	foreach ($listTime as $time) {
		
		if ($outp != "") {$outp .= ",";}
		
		$outp .=  '{"Time":"'.$time.'",';
		
		for ($i = 0; $i < 5; $i++) {
			
			if ($subDay != "") {
				$outp .= ","; 
			}
			$subDay="fill";
				
			switch($i) {
				case 0: 
					$outp .=  '"Monday": [';
					break;
				
				case 1:
					$outp .=  '"Tuesday": [';
					break;
					
				case 2:
					$outp .=  '"Wednesday": [';
					break;
					
				case 3:
					$outp .=  '"Thursday": [';
					break;
					
				case 4:
					$outp .=  '"Friday": [';
					break;
			}
			
			$listActivity = $daoTW->getFilteredByTimeDay($time, $days[$i]);

			foreach ($listActivity as $activity) {
				$nameLink = str_replace(' ', '', strtolower($activity->getActivity()));
				
				if ($subarr != "") {
					$outp .= ","; 
				}
				$subarr="fill";
				
				$outp .=  '{"Id":"'.$activity->getId().'",';
				$outp .=  '"Name":"'.$activity->getActivity().'",';
				$outp .=  '"Note":"'.$activity->getNote().'",';
				$outp .=  '"Link":"'.$nameLink.'"}';
			}
			$outp .=  ']';
			$subarr = "";
		}
		$outp .=  '}';
		$subDay = "";
		
	}

	$outp = '{"courses":['.$outp.']}';
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
