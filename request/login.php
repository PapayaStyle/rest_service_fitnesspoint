<?php
	require 'request.php';
	require 'jwt_helper.php';
	
	include $_SERVER['DOCUMENT_ROOT'].'/db/dao/userDAO.php';	
	 
	$json = file_get_contents('php://input');
	$obj = json_decode($json, true);
	
	$username = $obj['username'];
    $password = $obj['password'];
	 
	//$post = json_decode($_POST['data']);
	//$username = $post->username;
	//$password = $post->password;
	
	//$username = $_POST['username'];
	//$password = $_POST['password'];
	//echo '{"username:"'.$username.', "password:"'.$password.'}';
	
	$password = openssl_digest($password, 'sha512');
	
	$dao = new UserDAO();
	
	$dto = $dao->checkLogin($username,$password);
	
	if( null != $dto->getUsername() && !empty($dto->getUsername()) ){
		$secret_key = 'new-fitnesspoint';
		//valid for 1 day
		$valid_for = '86400';
		
		$token = array();
		$token['id'] = $dto->getId()."-".$dto->getUsername();
		$token['exp'] = time() + $valid_for;
		$token_key = JWT::encode($token, $secret_key);
		
		$account =  '{"token": "'.$token_key.'",';
		$account .=  '"username": "'.$dto->getUsername().'"}';
		
		echo($account);
	}else{
		header("HTTP/1.1 500 Internal Server Error");
		$error = '{"status": 404, "message": "Nome utente o password errati!"}';
		
		echo($error);
	}
?>