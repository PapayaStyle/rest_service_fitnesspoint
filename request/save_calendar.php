<?php
	require 'request.php';	
	include $_SERVER['DOCUMENT_ROOT'].'/manager/db/dao/CalendarActivityDAO.php';
	 
	$post = json_decode($_POST['data']);
	
	$rows = $post->rows;
	
	$days = array("LUNEDÌ", "MARTEDÌ", "MERCOLEDÌ", "GIOVEDÌ", "VENERDÌ");
	$dtoList = array();
	 
	//echo "hour \t Mon \t Tue\t Wed \t Thu \t Fri \n";
	
	foreach ($rows as $r=>$row){
		//echo $row->hour ."\t"; // etc.
		$hour = $row->hour;
		
		foreach ($row->monday as $mon){
			//echo $mon->activity."; ";
			$dto = prepareCalendarDto($hour, $days[0], $mon->activity, $mon->note);
			$dtoList[]=$dto;
		}
		//echo "\t";
		
		foreach ($row->tuesday as $tue){
			//echo $tue->activity."; ";
			$dto = prepareCalendarDto($hour, $days[1], $tue->activity, $tue->note);
			$dtoList[]=$dto;
		}
		//echo "\t";
		
		foreach ($row->wednesday as $wed){
			//echo $wed->activity."; ";
			$dto = prepareCalendarDto($hour, $days[2], $wed->activity, $wed->note);
			$dtoList[]=$dto;
		}
		//echo "\t";
		
		foreach ($row->thursday as $thu){
			//echo $thu->activity."; ";
			$dto = prepareCalendarDto($hour, $days[3], $thu->activity, $thu->note);
			$dtoList[]=$dto;
		}
		//echo "\t";
		
		foreach ($row->friday as $fri){
			//echo $fri->activity."; ";
			$dto = prepareCalendarDto($hour, $days[4], $fri->activity, $fri->note);
			$dtoList[]=$dto;
		}
		//echo "\n";
	}
	
	/*
	foreach ($dtoList as $dto){
		echo $dto->getTime(). "\t".$dto->getDay()."\t".$dto->getActivity()."\n";
	}
	*/
	
	try {
		insertAll($dtoList) ;
		echo('{"status":"OK"}');
	} catch(Exception $e) {
		header("HTTP/1.1 500 Internal Server Error");
		$error = '{"status": 404, "message": "Error during request"}';
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