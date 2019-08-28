<html>
<body>
<?php 
  require 'config.php';
	//save file
	$content = $_GET['infoGeo'];
	$file = "geo.txt"; // cannot be an online resource
  
	$Saved_File = fopen($file,'w');
	fwrite($Saved_File, $content);
	fclose($Saved_File);
	echo "Đang lưu geo .....";

	//get list geo micro
	$text = file_get_contents("https://microleaves.com/api/v1/backconnect/".$user."/geo/?api_token=".$token);

	// change data -> geo
	$text2 = str_replace('error', 'geo', $text);
  $text2 = str_replace('null', '[""]', $text2);
	// get data 
	$a = file_get_contents('geo.txt');
	foreach(preg_split("/((\r?\n)|(\r\n?))/", $a) as $line){
    	$b = explode(':', $line);
    	if ( ! isset($b[1])) {
   			$b[1] = null;
		}
		if ( ! isset($b[2])) {
   			$b[2] = null;
		}
    	$port = $b[1];
    	$geo = $b[2];
    	// get geo hien tai
    	$geo_current = get_string_between($text2, $port.':'.$port.':', '"');
    	//change geo 
    	$text3 = str_replace($port.':'.$port.':'.$geo_current, $port.':'.$port.':'.$geo, $text2);
    	$text2 = $text3;
	} 
  echo $text3;
	// ham tach string
  	function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
	}
	// PUT geo micro
	$curl = curl_init();
	curl_setopt_array($curl, array(
  	CURLOPT_URL => "https://microleaves.com/api/v1/backconnect/".$user."/geo/?api_token=".$token,
  	CURLOPT_RETURNTRANSFER => true,
  	CURLOPT_ENCODING => "",
  	CURLOPT_MAXREDIRS => 10,
  	CURLOPT_TIMEOUT => 30,
  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  	CURLOPT_CUSTOMREQUEST => "PUT",
  	CURLOPT_POSTFIELDS => $text3,
  	CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Postman-Token: 4f34ecf7-35d2-456f-b7c4-83de304bb23a",
    "cache-control: no-cache"
  	),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
  		echo "Lỗi change geo. Liên hệ Support" . $err;
	} else {
  		 echo "Lưu thành công..!!";
	}
 ?>
	<script language="javascript">
alert('Thành công');
    	window.history.back();
</script>
</body>
 </html>