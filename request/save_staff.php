<?php
	require 'request.php';		
	require_once 'jwt_helper.php';
	require_once "utils.php";
	require_once $_SERVER['DOCUMENT_ROOT'].'/db/dao/userDAO.php';
	require_once $_SERVER['DOCUMENT_ROOT']."/db/dao/staffDAO.php";
	
	$GLOBALS['error'] = '';
	
	if(!validateToken()) {
		responseError($GLOBALS['error']);
	}
	
	$target_dir = $_SERVER['DOCUMENT_ROOT']."/images/staff/";
	$defaultImage = '/images/default.jpg';
	
	$data = $_POST['data'];
	$body = json_decode($data, true);
	
	$id = $body['id'];
	$name = $body['name'];
	$act = $body['activity'];
	$desc = preg_replace( '~[\r\n]+~', '<br />', $body['desc']);
	$show = $body['show'];
	$type = $body['type'];
	$currentImage = $body['image'];
	$currentPortrait = $body['portrait'];
	
	$image = null;
	$portrait = null;
	if ($type == "I") {
		$image = $defaultImage;
		//$portrait = "";
	} else {
		$image = $body['image'];
		$portrait = $body['portrait'];
	}
	
	$file_to_upload = null;
	$target_file = null;
	
	//$doUpload = isset($_FILES['fileImg']);
	$post_img = $_POST['fileImg'];
	$img_json = json_decode($post_img, true);
	$doUpload = !isEmpty($post_img);
	if($doUpload) {
		$file_to_upload = $img_json['dataURL'];
		$target_file = $target_dir . basename($img_json['name']);
		$image =  "/images/staff/".basename($img_json['name']);
		//echo $file_to_upload;
		//$portrait_file= $target_dir . "portrait_".basename($_FILES['file']['name']);
		//$portrait_dir= "/images/staff/portrait_".basename($_FILES['portrait']['name']);
	}
	
	$post_portrait = $_POST['filePortrait'];
	$portrait_json = json_decode($post_portrait, true);
	$doUploadPortrait = !isEmpty($post_portrait);
	if($doUploadPortrait) {
		$portrait_to_upload = $portrait_json['dataURL'];
		$portrait_file = $target_dir . "portrait_".basename($portrait_json['name']);
		$portrait =  "/images/staff/portrait_".basename($portrait_json['name']);
	}
	
	$daoStaff = new StaffDAO();
	
	$uploaded = true;
	
	// INSERT
	if ($type == "I") {
		$uploaded = checkAndUpload();
		
		// insert data into db
		if($uploaded) {
			$daoStaff->insert($name, $act, $desc, $image, $portrait, $show);
			responseSuccess("Staff inserito con successo");
		} else {
			responseError($GLOBALS['error']);
		}
		
	}
	
	// UPDATE
	else if ($type == "U") {
		$uploaded = checkAndUpload();
		
		if($uploaded) {
			$daoStaff->update($id, $name, $act, $desc, $image, $portrait, $show);
			responseSuccess("Staff modificato con successo");
		} else {
			responseError($GLOBALS['error']);
		}
		
	}
	
	//DELETE
	else if ($type == "D") {
		$daoStaff->deleteById($id);
		if (file_exists($_SERVER['DOCUMENT_ROOT'].$currentImage)) {
			if ( !deleteFile($currentImage) ) { responseError($GLOBALS['error']); }
		}
		
		if (file_exists($_SERVER['DOCUMENT_ROOT'].$currentPortrait)) {
			if ( !deleteFile($currentPortrait) ) { responseError($GLOBALS['error']); }
		}
		responseSuccess("Staff cancellato con successo");
	}

	
	function checkAndUpload() {
		global $doUpload, $target_file, $file_to_upload, $img_json, $currentImage;
		
		if($doUpload) {
			$uploaded = uploadBase64($target_file, $file_to_upload, $img_json['type'], $currentImage);
			if ( !$uploaded ) { 
				return false;
				//responseError($GLOBALS['error']); 
			}
		}
		
		global $doUploadPortrait, $portrait_file, $portrait_to_upload, $portrait_json, $currentPortrait;
		
		if($doUploadPortrait) {
			$uploaded = uploadBase64($portrait_file, $portrait_to_upload, $portrait_json['type'], $currentPortrait);
			if ( !$uploaded ) { 
				return false;
				//responseError($GLOBALS['error']); 
			}
		}
		
		return true;
	}
?>