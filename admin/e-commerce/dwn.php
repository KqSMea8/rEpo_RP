<? session_start();

$AllowDownload = 0;

if($_SESSION['AdminID']>0){
	 
	if(!empty($_SERVER['HTTP_REFERER'])){
		$Exist = substr_count($_SERVER['HTTP_REFERER'], '.php');
		if($Exist>=0){
			$AllowDownload = 1;
		}
	}

	$arr_t = explode(".",$_GET['file']);
	$Extension = strtolower(end($arr_t)); 


	$NotAllowedExtension = array("php","bak","xml","swf","html","htm","js","css","htaccess");
	if(in_array($Extension,$NotAllowedExtension)){
		$AllowDownload = 0;
	}
	

}


if(!empty($_GET['file']) && $AllowDownload == 1){
		 $filename = $_GET['file'];
		header("Pragma: public");
		header("Expires: 0"); 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 

		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		header("Content-Disposition: attachment; filename=".basename($filename).";");


		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($filename));

		readfile("$filename"); 
		exit();
		
}else{
	echo '<div class="message">Error : Invalid Request !</div>';
	exit;
}


?>
