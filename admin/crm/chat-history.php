<?php 	/**************************************************/
	$ThisPageName = 'chatlist.php'; 	$HideNavigation = 1;
	/**************************************************/
	include_once("../includes/header.php");	
	require_once($Prefix."classes/dbfunction.class.php");	
		$refid='';
		$refid=cleanMe($_GET['refid']);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"http://199.227.27.208:8080/api/chathistory");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "refid=".$refid);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));


// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);
$responce=array();
if(!empty($server_output)){
$responce=json_decode($server_output);
}
	function cleanMe($input) {
   $input = mysql_real_escape_string($input);
   $input = htmlspecialchars($input, ENT_IGNORE, 'utf-8');
   $input = strip_tags($input);
   $input = stripslashes($input);
   return $input;
}
	?>
<?php require_once("../includes/footer.php"); 	
?>
