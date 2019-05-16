<? session_start();

include("../../includes/config.php");
include("../includes/common.php");

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
		$FilePath = $_GET['file'];
		
		if(!empty($_GET['del_file'])){
			$FullPath = $FilePath;
			$filesize = filesize($FullPath);
		}else if($_SESSION['ObjectStorage'] == "1"){	
			$FullPath = $Config['OsUploadUrl'].$Config['OsDir']."/".$FilePath;
			$headers = get_headers($FullPath, TRUE);
			if(strpos($headers[0],'404') === false){
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
		

		if($_SESSION['AdminID']>0 && $_GET['del_file']==$_SESSION['AdminID']){
			unlink($FullPath);
		}

		exit();
		
}else{
	echo '<div class="message">Error : Invalid Request !</div>';
	exit;
}


?>
