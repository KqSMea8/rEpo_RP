<?php
session_start();
$_GET['debug']=1;	
if($_GET['debug']==1){
	ini_set('display_errors',1);
	error_reporting(E_ALL);
}else{
	ini_set('display_errors',0);
	error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED); 		
}

require_once("../../classes/function.class.php");
$objFunction=new functions();
 
/*
$ResponseArray = $objFunction->ListFileByPathObjectStorage("employee");die;
$ResponseArray = $objFunction->ListFileObjectStorage();die;
$ResponseArray = $objFunction->DeleteObjectStorage("employee/clone.png");
$ResponseArray = $objFunction->DeleteContainerObjectStorage(30);
*/

/******common.php**********/
$Config['ObjectStorage'] = 1;
$_SESSION['ObjectStorage'] = $Config['ObjectStorage'];
$_SESSION['CmpID']=25;
$Config['CmpID'] = $_SESSION['CmpID'];
$Config['CandidateDir'] = "candidate/";
$Config['FileUploadDir'] = "../".$Prefix."upload/".$Config['CmpID']."/";

$Config['OsUsername'] = "pramod";
$Config['OsPassword'] = "dMeK12I9I1jj";
$Config['OsTenantId'] = "686913a917184cd88695ffc77d3b48a7";
$Config['OsIdentityUrl'] = 'http://75.112.188.250:5000';
$Config['OsUploadUrl'] = 'http://75.112.188.224:8080/v1/AUTH_'.$Config['OsTenantId'].'/';
/******Page******/
$LastInsertId = 24;
$_POST['OldImage'] = '24_40.png';
$PreviewFile = '24_16.png';
$PreviewTitle = 'Abcs safh asifbsaif';
/*******includes/function.php*************/
function PreviewImage($PreviewArray) { 
	global $Config;
	
	extract($PreviewArray);
	if($Config['ObjectStorage'] == "1"){
		$FullPath = $Config['OsUploadUrl'].$Config['CmpID']."/".$FilePath;
		//$contentFile = file_get_contents($FullPath);
		$headers = get_headers($FullPath, TRUE);
		$arryHead = explode(" ",$headers['0']);
		$RespCode = $arryHead[1];
		if($RespCode=="200"){
	     		$filesize = $headers['Content-Length'];
		}
	}else{
		$FullPath = $Config['FileUploadDir'].$FilePath;
		$filesize = filesize($FullPath);
	}
	 	
	if(!empty($filesize)){
		$Image = '<img src="resizeimage.php?w='.$Width.'&h='.$Height.'&img='.$FullPath.'" border=0 id="ImageV" title="'.$FileTitle.'">';
		if($Link==1){
			$PrevHtml = '<a class="fancybox" title="'.$FileTitle.'" data-fancybox-group="gallery" href="'.$FullPath.'"  >'.$Image.'</a>';	
		}else{
			$PrevHtml = $Image;
		}	
	}else{
		$PrevHtml = '<img src="resizeimage.php?w='.$Width.'&h='.$Height.'&img='.$NoImage.'" border=0 id="ImageV" title="'.$FileTitle.'">';
	}

	return $PrevHtml;
	 
}
/********************

$FilePath = 'http://75.112.188.224:8080/v1/AUTH_686913a917184cd88695ffc77d3b48a7/37/employee/10.jpg';

echo '<a href="dwn.php?file='.$FilePath.'" class="download">Download</a>';
*/

//$headers = get_headers($filename, TRUE);
//$filesize = $headers['Content-Length'];
//header("Content-Length: ".$filesize);


/******PreviewFile**************
if(!empty($PreviewFile)){	 
	$PreviewArray['FilePath'] = $Config['CandidateDir'].$PreviewFile; 
	$PreviewArray['NoImage'] = "images/nouser.gif";
	$PreviewArray['FileTitle'] = $PreviewTitle;
	$PreviewArray['Width'] = "200";
	$PreviewArray['Height'] = "200";
	$PreviewArray['Link'] = "1";
	echo PreviewImage($PreviewArray);
}
die;
*/



if($_FILES['Image']['name'] != ''){

	$FileInfoArray['FileType'] = "Image";
	$FileInfoArray['FileDir'] = $Config['CandidateDir'];
	$FileInfoArray['FileID'] = $LastInsertId;
	$FileInfoArray['OldFile'] = $_POST['OldImage'];
	$FileInfoArray['UpdateStorage'] = '1';
	$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);
	print_r($ResponseArray);die;
	if($ResponseArray['Success']=="1"){  
		#$objCandidate->UpdateImage($ResponseArray['FileName'],$LastInsertId);
 	}else{
		$ErrorMsg = $ResponseArray['ErrorMsg'];
	}
	if(!empty($ErrorMsg)){
		if(!empty($_SESSION['mess_candidate'])) $ErrorPrefix = '<br><br>';
		$_SESSION['mess_candidate'] .= $ErrorPrefix.$ErrorMsg;
	}

	 /*$ImgPath = 'http://75.112.188.224:8080/v1/AUTH_686913a917184cd88695ffc77d3b48a7/30/employee/'.$ResponseArray['FileName'];
echo '<img src="resizeimage.php?w=120&h=120&img='.$ImgPath.'" border=0 id="ImageV">'; 

	echo '<pre>';print_r($ResponseArray);die;*/
 
 
	header("Location:test.php");
	exit;
	 
} 
/**********************/


if(!empty($_SESSION['mess_candidate'])) {
	echo $_SESSION['mess_candidate']; unset($_SESSION['mess_candidate']); 
}

?>
<html>
   <body>
      
      <form action="" method="POST" enctype="multipart/form-data">
	Select Image :
         <input type="file" name="Image" /><br/>
         <input type="submit"/>
      </form>
      
   </body>
</html>
