<?php
	require 'request.php';
	
	// retrieve data from angular json
	$post = json_decode($_POST['data']);		
	
	$name = $post->name;
	$mail_from = $post->email;
	$subject = $post->subject;
	$message = $post->message;
	
	$mail_to = "danny.cuttaia@gmail.com";
	
	$headers =  "MIME-Version: 1.0" . "\r\n"; 
	$headers .= "Da: $name  <$mail_from>" . "\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n"; 	
	
	$outp =  '{"name": "'.$name.'",';
	$outp .=  '"mail": "'.$mail_from.'",';
	$outp .=  '"subject": "'.$subject.'",';
	$outp .=  '"message": "'.$message.'"}';
	
	$outp = '{"response": ['.$outp.']}';
	echo $outp;
	
	
?>