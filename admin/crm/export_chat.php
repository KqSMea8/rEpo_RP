<?php  	
include_once("../includes/settings.php");
$refid='';
$refid=cleanMe($_GET['refid']);
if(!empty($refid)){	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://199.227.27.208:8080/api/chathistory");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "refid=".$refid);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		}
		$responce=array();
		if(!empty($server_output)){
		$responce=json_decode($server_output);
		}
		$responce->talkslist;
$filename = "ChatHistory".date('d-m-Y').".xls";
if(!empty($responce->chathistory)){
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "Sender\tMessage\tTime";

	$data = '';
	
		foreach($responce->chathistory as $res){	
	        
	 $line = stripslashes($res->user)."\t".$res->msg."\t".$res->time."\n";
	
			$data .= trim($line)."\n";
		}
	
		$data = str_replace("\r","",$data);	
		print "$header\n$data";
	

}else{
	echo "No record found.";
}
exit;
	function cleanMe($input) {
   $input = mysql_real_escape_string($input);
   $input = htmlspecialchars($input, ENT_IGNORE, 'utf-8');
   $input = strip_tags($input);
   $input = stripslashes($input);
   return $input;
}
?>

