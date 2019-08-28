<html>
	<body>
	<?php
	// save file 
	require 'config.php';
	$content = $_GET['infoIP'];
	$file = "ip.txt"; // cannot be an online resource
	$Saved_File = fopen($file,'w');
	fwrite($Saved_File, $content);
	fclose($Saved_File);
	echo "Đang lưu ip .....";
	// IP
		$json_string = file_get_contents("https://microleaves.com/api/v1/backconnect/".$user."/authorized-ips/?api_token=".$token);
	$json_string = str_replace('data', 'ips', $json_string);
	// Dạng Mảng
	$json = json_decode($json_string, true);
	array_push($json["ips"],$content);
	$data = json_encode($json);	
	echo $data;
	// PUT IP Micro
	$curl = curl_init();
	curl_setopt_array($curl, array(
  	CURLOPT_URL => "https://microleaves.com/api/v1/backconnect/".$user."/authorized-ips/?api_token=".$token,
  	CURLOPT_RETURNTRANSFER => true,
  	CURLOPT_ENCODING => "",
  	CURLOPT_MAXREDIRS => 10,
  	CURLOPT_TIMEOUT => 30,
  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  	CURLOPT_CUSTOMREQUEST => "PUT",
  	CURLOPT_POSTFIELDS => $data,
  	CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Postman-Token: 4f34ecf7-35d2-456f-b7c4-83de304bb23a",
    "cache-control: no-cache"
  	),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	?>
<script language="javascript">
	alert('Thành công');
    	window.history.back();
</script>
	</body>
</html>
