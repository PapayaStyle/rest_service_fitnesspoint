<?php
	require_once 'request.php';
	require_once 'jwt_helper.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/manager/db/dao/userDAO.php';
	
	require_once "utils.php";
	
	$GLOBALS['error'] = '';
	
	if(validateToken()) {
		echo true;
	} else {
		responseError($GLOBALS['error']);
	}
	
	//$secret_key = 'new-fitnesspoint';
	
	//$headers = apache_request_headers();
	
	/*
	$jwt = getHeaderJWT();
	
	if ($jwt) {
		//$jwt = $headers['Authorization'];
		
		
		//$token = JWT::decode($jwt, $secret_key);
		
		$token = decodeToken($jwt);
		
		$expire = $token->exp;
		if(time() > $expire) {
			header("HTTP/1.1 500 Internal Server Error");
			echo '{"status": 404, "message": "Authorization expired"}';
			exit();
		} else {
			$data = explode("-", $token->id);
			
			$id = $data[0];
			$username = $data[1];

			
			$exist = validateUserToken($data);
			
			if($exist == 1)
				echo true;
			else
				echo false;
		}
	} else {
		header("HTTP/1.1 500 Internal Server Error");
		echo '{"status": 404, "message": "Authorization header not found"}';
		exit();
	}
	*/
?>