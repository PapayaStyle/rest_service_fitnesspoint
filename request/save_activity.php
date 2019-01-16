<?php
	require 'request.php';	
	require_once 'jwt_helper.php';
	require_once "utils.php";
	require_once $_SERVER['DOCUMENT_ROOT'].'/db/dao/userDAO.php';
	require_once $_SERVER['DOCUMENT_ROOT']."/db/dao/activityDAO.php";
	
	$GLOBALS['error'] = '';
	
	if(!validateToken()) {
		responseError($GLOBALS['error']);
	}
	
	$target_dir = $_SERVER['DOCUMENT_ROOT']."/images/activity/";
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
	$currentImage = $body['image'];
	
	if ($type == "I")
		$image = $defaultImage;
	else
		$image =  $body['image'];
	
	$file_to_upload = null;
	$target_file = null;
	
	//$doUpload = isset($_FILES['file']);
	$post_file = $_POST['file'];
	$file_json = json_decode($post_file, true);
	$doUpload = !isEmpty($post_file);
	if($doUpload) {
		$file_to_upload = $file_json['dataURL'];
		$target_file = $target_dir . basename($file_json['name']);
		$image =  "/images/activity/".basename($file_json['name']);
		
		//$file_to_upload = $_FILES['file']['tmp_name'];
		//$target_file = $target_dir . basename($_FILES['file']['name']);
		//$image =  "/images/activity/".basename($_FILES['file']['name']);
		
		//$tmp_dir = $target_dir."tmp_".basename($_FILES['file']['name']);
		//$tmp = "/images/activity/tmp_".basename($_FILES['file']['name']);
	}
	
	$daoA = new ActivityDAO();
	
	$uploaded = true;
	
	// INSERT
	if ($type == "I") {
		if($doUpload) {
			//$uploaded = resizeAndUpload($currentImage, $file_to_upload, $tmp, $tmp_dir, $target_file, 500, 350);
			$uploaded = uploadBase64($target_file, $file_to_upload, $file_json['type'], $currentImage);
			if ( !$uploaded ) { 
				responseError($GLOBALS['error']); 
			}
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
			//$uploaded = resizeAndUpload($currentImage, $file_to_upload, $tmp, $tmp_dir, $target_file, 500, 350);
			$uploaded = uploadBase64($target_file, $file_to_upload, $file_json['type'], $currentImage);
			if ( !$uploaded ) { 
				responseError($GLOBALS['error']); 
			}
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
		// delete old image
		if (file_exists($_SERVER['DOCUMENT_ROOT'].$currentImage)) {
			if ( !deleteFile($currentImage) ) { responseError($GLOBALS['error']); }
		}
		responseSuccess("Attività cancellata con successo");
	}

?>