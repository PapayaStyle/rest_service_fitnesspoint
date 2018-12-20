<?php
	
	function getHeaderJWT() {
		$headers = apache_request_headers();
		
		if( array_key_exists('Authorization', $headers) ) {
			$jwt = $headers['Authorization'];
			return $jwt;
		} else {
			return false;
		}
	}

	function decodeToken($jwt) {
		$secret_key = 'new-fitnesspoint';
		$token = JWT::decode($jwt, $secret_key);
		
		return $token;
	}

	function validateExpirationToken($token) {			
		$expire = $token->exp;
		if(time() > $expire) {
			return true;
		} else {
			return false;
		}
	}
		
	function validateUserToken($token) {		
		$data = explode("-", $token->id);				
		
		$id = $data[0];
		$username = $data[1];
		
		$dao = new UserDAO();
		$exist = $dao->checkUser($id, $username);
		
		return $exist;
	}
	
	/**
	 * check if token is valid
	 * return validation true or false
	 */
	function validateToken() {
		$jwt = getHeaderJWT();
		
		if ($jwt) {
			$token = decodeToken($jwt);
			
			$isExpired = validateExpirationToken($token);
			if($isExpired) {
				$GLOBALS['error'] = ('Authorization expired');
				return false;
			}
			
			$exist = validateUserToken($token);
			if($exist != 1) {
				$GLOBALS['error'] = ('Invalid Authorization Token');
				return false;
			}
			
			return true;
		} else {
			$GLOBALS['error'] = ('Authorization header not found');
			return false;
		}
		
	}

	/**
	 * upload image to server
	 * return success true or false
	 */
	function uploadFile($file_to_upload, $target_file) {
		//Check if image file is a actual image or fake image
		$uploadOk = 1;

		$check = getimagesize($file_to_upload);
		if(!$check !== false) {
			$uploadOk = 0;
			$GLOBALS['error'] = ('Immagine non valida');
		}
		
		// Check if file already exists
		if (file_exists($target_file)) {
			$uploadOk = 0;
			$GLOBALS['error']  = ('Immagine già presente');
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
				$GLOBALS['error']  = ('Errore Caricamento immagine');
				return false;
			}
		}
	}
	
	/**
	 * resize and upload image to server
	 * return success true or false
	 */
	function resizeImage($pathToImages, $pathToThumbs, $w, $h) {
		$img = imagecreatefromjpeg($pathToImages);
		$width = imagesx($img);
		$height = imagesy($img);
		
		$new_width = imagesx($img);
		$new_height = imagesy($img);
		
		// calculate thumbnail size		
		if( $new_width > $w ){ 
            $new_height = ($w / $new_width) * $new_height; 
            $new_width = $w; 
        } 
        if( $new_height > $h ){ 
            $new_width = ($h / $new_height) * $new_width; 
            $new_height = $h; 
        }

		// create a new temporary image
		$tmp_img = imagecreatetruecolor($new_width, $new_height);

		// copy and resize old image into new image 
		$resized = imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		
		// save thumbnail into a file
		if(imagejpeg($tmp_img, $pathToThumbs)) {
			return true;
		} else {
			$GLOBALS['error']  = ('Errore durante upload e ridimensionamento immagine');
			return false;
		}
	}
	
	function deleteFile($filePath) {
		if (!file_exists($_SERVER['DOCUMENT_ROOT'].$filePath)) {
			$GLOBALS['error']  = ('File non presente sul server');
			return false;
		}
		
		$delete = unlink($_SERVER['DOCUMENT_ROOT'].$filePath);
		if(!$delete) {
			$GLOBALS['error']  = ('Errore durante la cancellazione del file');
			return false;
		}
		
		return true;
	}
	
	function responseError($message) {
		header("HTTP/1.1 500 Internal Server Error");
		$error['status'] = 500;
		$error['statusText'] = "KO";
		$error['message'] = $message;
		
		echo json_encode($error);
		exit();
	}
	
	function responseSuccess($message) {
		echo '{"status":"200", "statusText": "OK", "message": "'.$message.'"}';
	}
	
?>