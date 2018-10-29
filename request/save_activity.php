<?php
	require 'request.php';	
	include $_SERVER['DOCUMENT_ROOT']."/manager/db/dao/activityDAO.php";
	
	$GLOBALS['error'] = '';
	$target_dir = $_SERVER['DOCUMENT_ROOT']."/images/";
	$defaultImage = '/images/default.jpg';
	
	$post = json_decode($_POST['data']);
	
	$id = $post->id;
	$title = $post->title;
	$desc = preg_replace( '~[\r\n]+~', '<br />', $post->desc);
	$url = $post->video;
	$show = $post->show;
	$type = $post->type;
	
	if ($type == "I")
		$image = $defaultImage;
	else
		$image =  $post->img;
	
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
			echo  '{"status":"OK", "message": "Activity successfully inserted"}';
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
			
			echo  '{"status":"OK", "message": "Activity successfully updated"}';
		} else {
			header("HTTP/1.1 500 Internal Server Error");
			echo($GLOBALS['error']);
		}
		
	}
	
	//DELETE
	else if ($type == "D") {
		$daoA->delete($id);
		echo  '{"status":"OK", "message": "Activity successfully deleted"}';
	}

?>

<?php	
	function uploadFile($file_to_upload, $target_file) {
		//Check if image file is a actual image or fake image
		$uploadOk = 1;

		$check = getimagesize($file_to_upload);
		if(!$check !== false) {
			$uploadOk = 0;
			$GLOBALS['error'] = ('{"status":"KO", "message": "Invalid image"}');
		}
		
		// Check if file already exists
		if (file_exists($target_file)) {
			$uploadOk = 0;
			$GLOBALS['error']  = ('{"status":"KO", "message": "Image already exist"}');
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
				$GLOBALS['error']  = ('{"status":"KO", "message": "Error uploading"}');
				//echo($error);
				return false;
			}
		}
	}
?>