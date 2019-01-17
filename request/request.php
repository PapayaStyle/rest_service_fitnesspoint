<?php
	header("Access-Control-Allow-Origin: *");
	header("Accept: application/json, text/plain, multipart/form-data, */*");
	header("Content-Type: application/json; charset=UTF-8");
	//header("Access-Control-Allow-Headers: Authorization");
	
  header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT,DELETE");
  header("Access-Control-Allow-Headers: Authorization, Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
	
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
  }
?>