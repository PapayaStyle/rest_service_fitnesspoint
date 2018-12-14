<?php
	require 'request.php';	
	//header("Content-Type: multipart/form-data; charset=utf-8;");
	//header("Content-Type': 'application/x-www-form-urlencoded");
	
	include $_SERVER['DOCUMENT_ROOT']."/manager/db/dao/activityDAO.php";
	
	$GLOBALS['error'] = '';
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
	//echo $doUpload;
	if($doUpload) {
		$file_to_upload = $_FILES['file']['tmp_name'];
		$target_file = $target_dir . basename($_FILES['file']['name']);
		$image =  "/images/".basename($_FILES['file']['name']);
		
		//echo $file_to_upload;
		//echo $target_file;
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
			echo  '{"status":"OK", "message": "Attività inserita con successo"}';
		} else {
			header("HTTP/1.1 500 Internal Server Error");
			echo($GLOBALS['error']);
		}
		
	}
	
	// UPDATE
	else if ($type == "U") {
		if($doUpload) {
			$uploaded = uploadFile($file_to_upload, $target_file);
		}
		
		if($uploaded) {
			//check if the image must be updated
			//if(isset($image))
				$daoA->update($id, $title, $desc, $image, $url, $show);
			//else
				//$daoA->updateNoImg($id, $title, $desc, $show);
			
			echo  '{"status":"OK", "message": "Attività modificata con successo"}';
		} else {
			header("HTTP/1.1 500 Internal Server Error");
			echo($GLOBALS['error']);
		}
		
	}
	
	//DELETE
	else if ($type == "D") {
		$daoA->delete($id);
		echo  '{"status":"OK", "message": "Attività cancellata con successo"}';
	}

?>

<?php	
	function uploadFile($file_to_upload, $target_file) {
		//Check if image file is a actual image or fake image
		$uploadOk = 1;

		$check = getimagesize($file_to_upload);
		if(!$check !== false) {
			$uploadOk = 0;
			$GLOBALS['error'] = ('{"status":"KO", "message": "Immagine non valida"}');
		}
		
		// Check if file already exists
		if (file_exists($target_file)) {
			$uploadOk = 0;
			$GLOBALS['error']  = ('{"status":"KO", "message": "Immagina già presente"}');
		}
		
		if ($uploadOk == 0) {
			//header("HTTP/1.1 500 Internal Server Error");
			//echo($error);
			return false;
		} else {
			if (move_uploaded_file($file_to_upload, $target_file)) {
				//echo('{"status":"OK", "message": "OK"}');
				return true;
			} else {
				//header("HTTP/1.1 500 Internal Server Error");
				$GLOBALS['error']  = ('{"status":"KO", "message": "Errore Caricamento immagine"}');
				//echo($error);
				return false;
			}
		}
	}
	
?>