<?php
	require 'request.php';	
	require_once 'jwt_helper.php';
	require_once "utils.php";
	require_once $_SERVER['DOCUMENT_ROOT'].'/manager/db/dao/userDAO.php';
	require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/dao/newsDAO.php";
	
	$GLOBALS['error'] = '';
	
	if(!validateToken()) {
		header("HTTP/1.1 500 Internal Server Error");
		echo $GLOBALS['error'];
		exit();
	}
	
	$target_dir = $_SERVER['DOCUMENT_ROOT']."/images/";
	$defaultImage = '/images/default.jpg';
	
	$data = $_POST['data'];
	$body = json_decode($data, true);
	
	$id = $body['id'];
	$title = $body['title'];
	$desc = preg_replace( '~[\r\n]+~', '<br />', $body['desc']);
	$url = $body['video'];
	
	/*$date = $post->date;*/
	
	$mil = $body['date'];
	$seconds = $mil / 1000;
	$date = date("Y-m-d H:i:s", $seconds);
	
	$show = $body['show'];
	$type = $body['type'];
	
	$image = null;
	if ($type == "I" && !isset($url))
		$image = $defaultImage;
	else
		$image = $body['img'];
	
	$file_to_upload = null;
	$target_file = null;
	
	$doUpload = isset($_FILES['file']);
	if($doUpload) {
		$file_to_upload = $_FILES['file']['tmp_name'];
		$target_file = $target_dir . basename($_FILES['file']['name']);
		$image =  "/images/".basename($_FILES['file']['name']);
	}
	
	$daoNews = new NewsDAO();
	
	$uploaded = true;
	
	// INSERT
	if ($type == "I") {
		if($doUpload) {
			$uploaded = uploadFile($file_to_upload, $target_file);
			
			if($uploaded) {
				$daoNews->insert($title, $desc, $image, $url, $date, $show);
				responseSuccess("Staff inserito con successo");
			} else {
				responseError($GLOBALS['error']);
			}
		} else {
			$daoNews->insert($title, $desc, $image, $url, $date, $show);
			responseSuccess("Staff inserito con successo");
		}
		
	}
	
	// UPDATE
	else if ($type == "U") {
		if($doUpload) {
			$uploaded = uploadFile($file_to_upload, $target_file);
		}
		
		if($uploaded) {
			$daoNews->update($id, $title, $desc, $image, $url, $date, $show);
			responseSuccess("Staff modificato con successo");
		} else {
			responseError($GLOBALS['error']);
		}
		
	}
	
	//DELETE
	else if ($type == "D") {
		$daoNews->deleteById($id);
		responseSuccess("Staff cancellato con successo");
	}

?>