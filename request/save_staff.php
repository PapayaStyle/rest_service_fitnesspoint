<?php
	require 'request.php';	
	include $_SERVER['DOCUMENT_ROOT']."/manager/db/dao/staffDAO.php";
	
	$GLOBALS['error'] = '';
	$target_dir = $_SERVER['DOCUMENT_ROOT']."/images/";
	$defaultImage = '/images/default.jpg';
	
	$post = json_decode($_POST['data']);
	
	$id = $post->id;
	$name = $post->name;
	$act = $post->act;
	$desc = preg_replace( '~[\r\n]+~', '<br />', $post->desc);
	$show = $post->show;
	$type = $post->type;
	
	$image = null;
	if ($type == "I")
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
	
	
	$daoStaff = new StaffDAO();
	
	$uploaded = true;
	
	// INSERTì
	if ($type == "I") {
		if($doUpload) {
			$uploaded = uploadFile($file_to_upload, $target_file);
		}
		
		if($uploaded) {
			$daoStaff->insert($name, $act, $desc, $image, $show);
			echo  '{"status":"OK", "message": "Staff successfully inserted"}';
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
			$daoStaff->update($id, $name, $act, $desc, $image, $show);
			echo  '{"status":"OK", "message": "Staff successfully updated"}';
		} else {
			header("HTTP/1.1 500 Internal Server Error");
			echo($GLOBALS['error']);
		}
		
	}
	
	//DELETE
	else if ($type == "D") {
		$daoStaff->deleteById($id);
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