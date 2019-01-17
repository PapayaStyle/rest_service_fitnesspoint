<?php
	require 'request.php';	
	require_once 'jwt_helper.php';
	require_once "utils.php";
	require_once $_SERVER['DOCUMENT_ROOT'].'/db/dao/userDAO.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/db/dao/CalendarActivityDAO.php';
	
	$GLOBALS['error'] = '';
	
	if(!validateToken()) {
		responseError($GLOBALS['error']);
	}	
	 
	$json = file_get_contents('php://input');
	//$putdata = fopen("php://input", "r");
	$obj = json_decode($json, true);
	//$post = json_decode($_POST['data']);	
	
	$rows = $obj['rows'];
	
	$days = array("LUNEDÌ", "MARTEDÌ", "MERCOLEDÌ", "GIOVEDÌ", "VENERDÌ");
	$dtoList = array();
	 
	//echo "hour \t Mon \t Tue\t Wed \t Thu \t Fri \n";
	
	foreach ($rows as $r=>$row){
		//echo $row['hour'] ."\t"; // etc.
		$hour = $row['hour'];
		
		foreach ($row['monday'] as $mon){
			//echo $mon['activity']."; ";
			$dto = prepareCalendarDto($hour, $days[0], $mon['activity'], $mon['note']);
			$dtoList[]=$dto;
		}
		//echo "\t";
		
		foreach ($row['tuesday'] as $tue){
			//echo $tue['activity']."; ";
			$dto = prepareCalendarDto($hour, $days[1], $tue['activity'], $tue['note']);
			$dtoList[]=$dto;
		}
		//echo "\t";
		
		foreach ($row['wednesday'] as $wed){
			//echo $wed['activity']."; ";
			$dto = prepareCalendarDto($hour, $days[2], $wed['activity'], $wed['note']);
			$dtoList[]=$dto;
		}
		//echo "\t";
		
		foreach ($row['thursday'] as $thu){
			//echo $thu['activity']."; ";
			$dto = prepareCalendarDto($hour, $days[3], $thu['activity'], $thu['note']);
			$dtoList[]=$dto;
		}
		//echo "\t";
		
		foreach ($row['friday'] as $fri){
			//echo $fri['activity']."; ";
			$dto = prepareCalendarDto($hour, $days[4], $fri['activity'], $fri['note']);
			$dtoList[]=$dto;
		}
		//echo "\n";
	}
	
	try {
		insertAll($dtoList);
		responseSuccess("Calendario inserito con successo");
	} catch(Exception $e) {
		responseError($GLOBALS['error']);
	}
	
	function prepareCalendarDto($time, $day, $activity, $note) {
		$dto = new CalendarActivityDTO();
		$dto->setTime($time);	
		$dto->setDay($day);
		$dto->setActivity($activity);
		$dto->setNote($note);
		
		return $dto;
	}
	
	function insertAll($dtoList) {
		$daoCA = new CalendarActivityDAO();
		
		if(isset($dtoList)){
			$daoCA->truncate();
		}
		
		foreach ($dtoList as $dto) {
			$daoCA->insert( $dto->getTime(), $dto->getDay(), $dto->getActivity(), $dto->getNote());
    }
	}
	
?>