<? //include_once("includes/settings.php");

session_start();
$AllowDownload = 0;

if($_SESSION['SuperAdminID']>0){ 
	$Referer = $_SERVER['HTTP_REFERER'];
	if(!empty($Referer)){
		$Exist = substr_count($Referer, '.php');
		if($Exist>=0){
			$AllowDownload = 1;
		}
	}
 
	$arr_t = explode("/",$_GET['filename']);
	$Extension = strtolower(end($arr_t)); 


	$NotAllowedExtension = array("php","bak","xml","swf","html","htm","js","css","sql","htaccess");
	if(in_array($Extension,$NotAllowedExtension)){
		$AllowDownload = 0;
	}
	
}

 $dataBaseMainpath = '/prod-data-erp/database-backup/';	
if(!empty($_GET['filename'])){ 
	
		$filename = $_GET['filename'];
		$filepath = $dataBaseMainpath.$arr_t[0]."/".$arr_t[1];
		header("Pragma: public");
		header("Expires: 0"); 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 

		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
 
		header("Content-Disposition: attachment; filename=".basename($filepath));


		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($filepath));

		readfile($filepath); 
		exit();
		
}else{
	echo '<div class="message">Error : Invalid Request !</div>';
	exit;
}


?>
