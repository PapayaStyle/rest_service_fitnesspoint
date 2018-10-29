<?php
	require 'request.php';	
	include $_SERVER['DOCUMENT_ROOT']."/manager/db/dao/newsDAO.php";
	
	$GLOBALS['error'] = '';
	$target_dir = $_SERVER['DOCUMENT_ROOT']."/images/";
	$defaultImage = '/images/default.jpg';
	
	$post = json_decode($_POST['data']);
	
	$id = $post->id;
	$title = $post->title;
	$desc = preg_replace( '~[\r\n]+~', '<br />', $post->desc);
	$url = $post->video;
	
	/*$date = $post->date;*/
	
	$mil = $post->date;
	$seconds = $mil / 1000;
	$date = date("Y-m-d H:i:s", $seconds);
	
	$show = $post->show;
	$type = $post->type;
	
	$image = null;
	if ($type == "I" && !isset($url))
		$image = $defaultImage;
	else
		$image = $post->img;
	
	$file_to_upload = null;
	$target_file = null;
	
	$doUpload = isset($_FILES['file']);
	if($doUpload) {
		$file_to_upload = $_FILES['file']['tmp_name'];
		$target_file = $target_dir . basename($_FILES['file']['name']);
		$image =  "/images/".basename($_FILES['file']['name']);
	}
	
	echo "id: ".$id."\ntitle: ".$title."\ndesc: ".$desc."\nurl: ".$url."\nimage: ".$image."\ndate: ".$date."\n";
	
	$daoNews = new NewsDAO();
	
	$uploaded = true;
	
	// INSERT
	if ($type == "I") {
		if($doUpload) {
			$uploaded = uploadFile($file_to_upload, $target_file);
			
			if($uploaded) {
				$daoNews->insert($title, $desc, $image, $url, $date, $show);
				echo  '{"status":"OK", "message": "Staff successfully inserted"}';
			} else {
				header("HTTP/1.1 500 Internal Server Error");
				echo($GLOBALS['error']);
			}
		} else {
			$daoNews->insert($title, $desc, $image, $url, $date, $show);
			echo  '{"status":"OK", "message": "Staff successfully inserted"}';
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
			
			echo  '{"status":"OK", "message": "Staff successfully updated"}';
		} else {
			header("HTTP/1.1 500 Internal Server Error");
			echo($GLOBALS['error']);
		}
		
	}
	
	//DELETE
	else if ($type == "D") {
		$daoNews->deleteById($id);
		echo  '{"status":"OK", "message": "Staff successfully deleted"}';
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