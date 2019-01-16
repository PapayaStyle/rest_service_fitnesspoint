<?php
	require 'request.php';	
	require_once 'jwt_helper.php';
	require_once "utils.php";
	require_once $_SERVER['DOCUMENT_ROOT'].'/db/dao/userDAO.php';
	require_once $_SERVER['DOCUMENT_ROOT']."/db/dao/galleryDAO.php";
	
	$GLOBALS['error'] = '';
	
	if(!validateToken()) {
		responseError($GLOBALS['error']);
	}
	
	$daoGallery = new galleryDAO();
	
	$target_dir = "/galleries/";
	$target_preview_dir = "/galleries/previews/";
	$target_thumbnail_dir = "/galleries/thumbs/";
	
	$data = $_POST['data'];
	$body = json_decode($data, true);
	
	$type = $body['type'];
	
	if($type == "I") {
		
		$tempImg = $_FILES['file']['tmp_name'];
		
		$nameImg = "img_".basename($_FILES['file']['name']);
		$namePreview = "preview_".basename($_FILES['file']['name']);
		$nameThumbnail = "thumbnail_".basename($_FILES['file']['name']);
	
		$uploadImg = $_SERVER['DOCUMENT_ROOT'].$target_dir.$nameImg;
		$uploadPreview = $_SERVER['DOCUMENT_ROOT'].$target_preview_dir.$namePreview;
		$uploadThumbnail = $_SERVER['DOCUMENT_ROOT'].$target_thumbnail_dir.$nameThumbnail;
		
		// upload image
		$uploaded = uploadFile($tempImg, $uploadImg);
		if(!$uploaded) {
			responseError($GLOBALS['error']);
		}
		
		// resize and upload preview image
		$resizePreview = resizeImage($uploadImg, $uploadPreview, 800, 440);
		if(!$resizePreview) {
			responseError($GLOBALS['error']);
		}
		
		// resize adn upload thumbnail image
		$resizeThumbnail = resizeImage($uploadImg, $uploadThumbnail, 193, 100);
		if(!$resizeThumbnail) {
			responseError($GLOBALS['error']);
		}
		
		// insert into db
		$daoGallery->insert($target_thumbnail_dir.$nameThumbnail, $target_preview_dir.$namePreview, $target_dir.$nameImg, 1, "gallery");
		responseSuccess("Immagine caricata con successo");
		
	} elseif ($type == "D") {
		
		$id = $body['id'];
		$thumbnail = $body['thumbnail'];
		$preview = $body['preview'];
		$image = $body['image'];
		
		// delete image from server
		if ( !deleteFile($thumbnail) ) { responseError($GLOBALS['error']); }
		
		if ( !deleteFile($preview) ) { responseError($GLOBALS['error']); }
		
		if ( !deleteFile($image) ) { responseError($GLOBALS['error']); }
		
		// delete image from db
		$daoGallery->delete($id);
		responseSuccess("Immagine eliminata");
	}
	
?>