<?php
	require 'request.php';	
	require_once 'jwt_helper.php';
	require_once "utils.php";
	require_once $_SERVER['DOCUMENT_ROOT'].'/manager/db/dao/userDAO.php';
	require_once $_SERVER['DOCUMENT_ROOT']."/manager/db/dao/activityDAO.php";
	
	$GLOBALS['error'] = '';
	
	if(!validateToken()) {
		responseError($GLOBALS['error']);
	}
	
	$target_dir = $_SERVER['DOCUMENT_ROOT']."/imgUploaded/";
	$defaultImage = '/images/default.jpg';
	
	//print_r(json_decode($_POST['data'], true));
	//print_r($_FILES['file']);
	
	$data = $_POST['data'];
	$body = json_decode($data, true);
	
	
	$id = $body['id'];
	$title = $body['title'];
	$desc = preg_replace( '~[\r\n]+~', '<br />', $body['desc']);
	$url = $body['video'];
	$show = $body['show'];
	$type = $body['type'];
	
	if ($type == "I")
		$image = $defaultImage;
	else
		$image =  $body['image'];
	
	$file_to_upload = null;
	$target_file = null;
	
	$doUpload = isset($_FILES['file']);
	if($doUpload) {
		$file_to_upload = $_FILES['file']['tmp_name'];
		$target_file = $target_dir . basename($_FILES['file']['name']);
		$image =  "/images/".basename($_FILES['file']['name']);
	}
	
	$daoA = new ActivityDAO();
	
	$uploaded = true;
	
	// INSERT
	if ($type == "I") {
		if($doUpload) {
			$uploaded = uploadFile($file_to_upload, $target_file);
		}
		
		if($uploaded) {
			$daoA->insert($title, $desc, $image, $url, $show);
			responseSuccess("Attività inserita con successo");
		} else {
			responseError($GLOBALS['error']);
		}
		
	}
	
	// UPDATE
	else if ($type == "U") {
		if($doUpload) {
			$uploaded = uploadFile($file_to_upload, $target_file);
		}
		
		if($uploaded) {
			$daoA->update($id, $title, $desc, $image, $url, $show);
			responseSuccess("Attività modificata con successo");
		} else {
			responseError($GLOBALS['error']);
		}
		
	}
	
	//DELETE
	else if ($type == "D") {
		$daoA->delete($id);
		responseSuccess("Attività cancellata con successo");
	}

?>