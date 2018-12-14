<?php
	require 'request.php';	
	include $_SERVER['DOCUMENT_ROOT']."/manager/db/dao/newsDAO.php";
	
	$GLOBALS['error'] = '';
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
	
	//echo "id: ".$id."\ntitle: ".$title."\ndesc: ".$desc."\nurl: ".$url."\nimage: ".$image."\ndate: ".$date."\n";
	
	$daoNews = new NewsDAO();
	
	$uploaded = true;
	
	// INSERT
	if ($type == "I") {
		if($doUpload) {
			$uploaded = uploadFile($file_to_upload, $target_file);
			
			if($uploaded) {
				$daoNews->insert($title, $desc, $image, $url, $date, $show);
				echo  '{"status":"OK", "message": "Staff inserito con successo"}';
			} else {
				header("HTTP/1.1 500 Internal Server Error");
				echo($GLOBALS['error']);
			}
		} else {
			$daoNews->insert($title, $desc, $image, $url, $date, $show);
			echo  '{"status":"OK", "message": "Staff inserito con successo"}';
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
			$daoNews->update($id, $title, $desc, $image, $url, $date, $show);
			
			echo  '{"status":"OK", "message": "Staff modificato con successo"}';
		} else {
			header("HTTP/1.1 500 Internal Server Error");
			echo($GLOBALS['error']);
		}
		
	}
	
	//DELETE
	else if ($type == "D") {
		$daoNews->deleteById($id);
		echo  '{"status":"OK", "message": "Staff cancellato con successo"}';
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