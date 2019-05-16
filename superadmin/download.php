<? session_start();
include("../includes/common.php");
$AllowDownload = 0;

if($_SESSION['SuperAdminID']>0){
	$Referer = $_SERVER['HTTP_REFERER'];
	if(!empty($Referer)){
		$Exist = substr_count($Referer, '.php');
		if($Exist>=0){
			$AllowDownload = 1;
		}
	}else{
		$mess = 'r';
	}

	$arr_t = explode(".",$_GET['file']);
	$Extension = strtolower(end($arr_t)); 


	$NotAllowedExtension = array("php","bak","xml","swf","html","htm","js","css","htaccess");
	if(in_array($Extension,$NotAllowedExtension)){
		$AllowDownload = 0; $mess = 'x';
	}
	
}


echo $mess;

if(!empty($_GET['file']) && !empty($_GET['folder']) &&  $AllowDownload == 1){

		 
		$FilePath = $_GET['folder'].$_GET['file'];

		if($_SESSION['ObjectStorage'] == "1"){	
			$FullPath = $Config['OsUploadUrl'].$Config['OsDir']."/".$FilePath;
			
			//$contentFile = file_get_contents($FullPath);
			$headers = get_headers($FullPath, TRUE);
			$arryHead = explode(" ",$headers['0']);
			$RespCode = $arryHead[1];
			if($RespCode=="200"){
		     		$filesize = $headers['Content-Length'];
			}			 
		}else{	
			$FullPath = $Config['RootUploadDir'].$Config['CmpID']."/".$FilePath;
			$filesize = filesize($FullPath);
		}

		 
		if(empty($filesize)){
			echo '<div class="message">Error : Invalid File !</div>';
			exit;
		}

		 
		header("Pragma: public");
		header("Expires: 0"); 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 

		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		header("Content-Disposition: attachment; filename=".basename($FullPath).";");


		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".$filesize);

		readfile("$FullPath"); 
		exit();
		
}else{
	echo '<div class="message">Error : Invalid Request !</div>';
	exit;
}


?>
