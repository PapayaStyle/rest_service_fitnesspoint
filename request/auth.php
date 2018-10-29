<?php
	require 'request.php';
	require 'jwt_helper.php';
	
	include $_SERVER['DOCUMENT_ROOT'].'/manager/db/dao/userDAO.php';
	
	$secret_key = 'new-fitnesspoint';
	
	$headers = apache_request_headers();
		
	//print_r($headers);
	
	if (array_key_exists('Authorization', $headers) ) {
		$jwt = $headers['Authorization'];
		
		$token = JWT::decode($jwt, $secret_key);
		
		/*
		echo ' "Token id": "' .$token->id.'",';
		echo ' "Token exp": ' .$token->exp.',';
		*/
		$expire = $token->exp;
		if(time() > $expire) {
			header("HTTP/1.1 500 Internal Server Error");
			$error = '{"status": 404, "message": "Authorization expired"}';
			echo($error);
		} else {
			$data = explode("-", $token->id);
			
			$id = $data[0];
			$username = $data[1];
			
			$dao = new UserDAO();
			$exist = $dao->checkUser($id, $username);
			
			if($exist == 1)
				echo true;
			else
				echo false;
		}
	} else {
		header("HTTP/1.1 500 Internal Server Error");
		$error = '{"status": 404, "message": "Authorization header not found"}';
		echo($error);
	}
		
?>