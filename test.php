<?php
	require 'config.php';
	$json_string = file_get_contents("https://microleaves.com/api/v1/backconnect/".$user."/geo/?api_token=".$token);
	// Dạng Mảng
	$json = json_decode($json_string, true);
	var_dump($json["advanced_geo"][0]);
	

?>