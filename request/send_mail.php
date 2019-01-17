<?php
	require 'request.php';
	require_once "utils.php";
	
	// retrieve data from angular json
	$json = file_get_contents('php://input');		
	$obj = json_decode($json, true);
	
	$name = $obj['name'];
	$from = $obj['email'];
	$subject = $obj['subject'];
	$message = $obj['message'];
	
	// generate boundary
  //$mail_boundary = "=_NextPart_" . md5(uniqid(time()));
  $sender = "postmaster@new-fitnesspoint.it";
  $fifthp = '-f postmaster@new-fitnesspoint.it';
  $to = "danny.cuttaia@gmail.com";
	
	// generate mail headers
	$headers = "From: New Fitness Point <$sender>\r\n";
	$headers .= "Reply-To: $from\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  //$headers .= "Content-Type: multipart/alternative;\r\n\tboundary=\"$mail_boundary\"\r\n";
  //$headers .= "X-Mailer: PHP " . phpversion();
    
  $msg = "<html><head>";
  $msg .= "
    <style>
      body {
        font-size: 14px;    
      }
      
      #contact, #subject, #message {
        margin: 10px 0;
        width: 100%;
      }
      
      #contact .bold, #contact .info {
        display: inline-block;
      }
      
      #subject .bold, #subject .info {
        display: inline-block;
      }
      
      .bold {
        font-weight: bold;
      }
      .info {
        font-style: italic;
      }
      #message .bold {
        margin-bottom: 5px;
      }
    </style>";
  $msg .= "</head>";
  $msg .= "<body>";
  $msg .= "
    <div id=\"contact\">
      <div class=\"bold\">Inviata da:</div>
      <div class=\"info\">$name - <a href=\"mailto:$from\">$from</a></div>
    </div>
    <div id=\"subject\">
      <div class=\"bold\">Oggetto:</div>
      <div class=\"info\">$subject</div>
    </div>
    <div id=\"message\">
      <div class=\"bold\">Messaggio:</div>
      <div>".str_replace("\n", "<br>", $message)."</div>
    </div>
  ";
  $msg .= "</body></html>";
    
	// send email, the last param "-f$sender" set the Return-Path to hosting Linux
  if (mail($to, "Mail dal sito new-fitnesspoint.it", $msg, $headers, $fifthp)) {
    responseSuccess("Recapito e-mail riuscito!");
  } else {
    responseError("Recapito e-Mail fallito!");
  }
	
?>