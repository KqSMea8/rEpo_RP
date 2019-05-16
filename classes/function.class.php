<?php
//https://docs.aws.amazon.com/AmazonS3/latest/dev/create-bucket-get-location-example.html

//require '/var/www/html/object/vendor/autoload.php';
use Aws\S3\S3Client;

/*
require $_SERVER['DOCUMENT_ROOT'].'/objectStorage/vendor/autoload.php';

use \OpenStack\Bootstrap;
use \OpenStack\Identity\v2\IdentityService;
use \OpenStack\ObjectStore\v1\ObjectStorage;
use \OpenStack\ObjectStore\v1\Resource\Object;
use \OpenStack\ObjectStore\v1\Resource\ACL;
use \OpenStack\Common\Transport;
*/

  
class functions 
{
	
	 /**************************/
	 function CheckUploadedFile($File,$FileType){
		global $Config;

		$arr_t = explode(".",$File["name"]);
		$Extension = strtolower(end($arr_t)); 
		
		switch($FileType){
			case 'Image':
				$AllowedExtension = array("jpg","gif","png");
				break;
			case 'Scan':
				$AllowedExtension = array("pdf","jpg","gif","png");
				break;
			case 'Document':
				$AllowedExtension = array("pdf","doc","docx", "ppt","pptx", "xls","xlsx","rtf","txt");
				break;
			case 'Resume':
				$AllowedExtension = array("pdf","doc","docx","rtf","txt");
				break;
			case 'Video':
				$AllowedExtension = array("swf","flv","mp4");
				break;
			case 'Excel':
				$AllowedExtension = array("xls","csv");
				break;
			case 'Pdf':
				$AllowedExtension = array("pdf");
				break;
			case 'Banner':
				$AllowedExtension = array("jpg","gif","png","swf");
				break;
			case 'Zip':
				$AllowedExtension = array("zip");
				break;
			case 'Flash':
				$AllowedExtension = array("swf","flv");
				break;
		}


		if(!empty($Config['StorageLimitError'])){
			$ErrorMsg = $Config['StorageLimitError'];
		}else if(!in_array($Extension,$AllowedExtension)){
			$ErrorMsg = UPLOAD_ERROR_EXT;
		}else if($File["error"]>0){
			$ErrorMsg = $this->ErrorMessage($File["error"]); 
		}else{
			$ErrorMsg = '';
		}

		$FileArray['ErrorMsg'] = $ErrorMsg;
		$FileArray['Extension'] = $Extension;
		return $FileArray;
	 }

	/**************************/

	function ErrorMessage($code)
	{
		switch ($code) {
			case UPLOAD_ERR_INI_SIZE:
				$message = "The uploaded file exceeds the maximum upload limit.";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$message = "The uploaded file exceeds the maximum file size directive that was specified in the form.";
				break;
			case UPLOAD_ERR_PARTIAL:
				$message = "The uploaded file was only partially uploaded.";
				break;
			case UPLOAD_ERR_NO_FILE:
				$message = "No file was uploaded.";
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$message = "Missing a temporary folder.";
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$message = "Failed to write file to disk.";
				break;
			case UPLOAD_ERR_EXTENSION:
				$message = "File upload stopped by extension.";
				break;

			default:
				$message = "Unknown upload error.";
				break;
		}


		return $message;
	} 

	/**************************/

	function ValidatePostData($arryData)
	{
		global $Config;	
		$Prefix='';
		if(!empty($Config['DeptFolder'])){
			$Prefix = '../';
		}
		 $message = '';	
		 $errorimg = '<img src="'.$Prefix.'images/error.png">&nbsp;';	
		 foreach($arryData as $key => $values) {
			$FieldValue = $_POST[$values['name']];	
			$FieldLabel = $values['label'];	
			$Length = strlen($FieldValue);
			if(empty($values['opt'])){  //Blank Validation
				 if(empty($FieldValue)){					 
					if(!empty($values['select'])){
						$message .= "<br>".$errorimg."Please Select ".$FieldLabel." !";	
					}else{
				 		$message .= "<br>".$errorimg."Please Enter ".$FieldLabel." !";	
					}
				 }	
			}
			/********************/
			if(!empty($FieldValue)){
				$charDigit = 'characters';
				if(!empty($values['type'])){
					$charDigit = ($values['type']=='number')?("digits"):("characters");
				}


				if(!empty($values['min']) && !empty($values['max'])){
					if($Length<$values['min'] || $Length>$values['max']){
						$message .= "<br>".$errorimg."".$FieldLabel." should be ".$values['min']." to ".$values['max']."  ".$charDigit." long !";
					}
				}else if(!empty($values['min'])){
					if($Length<$values['min']){
						$message .= "<br>".$errorimg."".$FieldLabel." should be minimum of ".$values['min']." ".$charDigit." long !";
					}
				}else if(!empty($values['max'])){
					if($Length>$values['max']){
						$message .= "<br>".$errorimg."".$FieldLabel." should be maximum of ".$values['max']."  ".$charDigit." long !";
					}
				}



				/********************/
				if(!empty($values['type'])){
					switch($values['type']) {
						case 'unique':			
							if (!preg_match("/^[A-Za-z0-9]*$/",$FieldValue))
				{
								$message .= "<br>".$errorimg."Please Enter Valid ".$FieldLabel." !";	
							}
							break;

						case 'alphanum':			
							if (!preg_match("/^[A-Za-z0-9\_\-\.\ ]*$/",$FieldValue))
				{
								$message .= "<br>".$errorimg."Please Enter Valid ".$FieldLabel." !";	
							}
							break;

						case 'email':			
							if (!preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/",$FieldValue))
				{
								$message .= "<br>".$errorimg."Please Enter Valid ".$FieldLabel." Address !";	
							}
							break;

						case 'number':
							if(is_numeric(trim($FieldValue)) == false){
								$message .= "<br>".$errorimg."Please Enter Numeric Value For ".$FieldLabel." !";
							}
							break;




					}
				}
				/********************/
			}
		

		 }
		
		return $message;
	} 

	/**************************/
	function CheckUploadedFileMul($FileName,$FileType){
		global $Config;

		$arr_t = $FileName;
		
                $Extension = strtolower(GetExtension($arr_t));
		
		
		switch($FileType){
			case 'Image':
				$AllowedExtension = array("jpg","gif","png");
				break;
			case 'Scan':
				$AllowedExtension = array("pdf","jpg","gif","png");
				break;
			case 'Document':
				$AllowedExtension = array("pdf","doc","docx", "ppt","pptx", "xls","xlsx","rtf","txt");
				break;
			case 'Resume':
				$AllowedExtension = array("pdf","doc","docx","rtf","txt");
				break;
			case 'Video':
				$AllowedExtension = array("swf","flv","mp4");
				break;
			case 'Excel':
				$AllowedExtension = array("xls","csv");
				break;
			case 'Pdf':
				$AllowedExtension = array("pdf");
				break;
			case 'Banner':
				$AllowedExtension = array("jpg","gif","png","swf");
				break;
			case 'Zip':
				$AllowedExtension = array("zip");
				break;
			case 'Flash':
				$AllowedExtension = array("swf","flv");
				break;
		}


		if(!empty($Config['StorageLimitError'])){
			$ErrorMsg = $Config['StorageLimitError'];
		}else if(!in_array($Extension,$AllowedExtension)){
			$ErrorMsg = UPLOAD_ERROR_EXT;
		}else if($File["error"]>0){
			$ErrorMsg = $this->ErrorMessage($File["error"]); 
		}else{
			$ErrorMsg = '';
		}

		$FileArray['ErrorMsg'] = $ErrorMsg;
		$FileArray['Extension'] = $Extension;
		return $FileArray;
	 }
	
	/**************************/

	function UploadFile($FileNameArray, $FileInfoArray){ //move_uploaded_file
		global $Config;
		
		if($Config['ObjectStorage']=="1"){
			return $this->UploadObjStorage($FileNameArray, $FileInfoArray);
			#return $this->UploadObjectStorage($FileNameArray, $FileInfoArray);
		}else{

		$objConfigure = new configure();
		
		$FileName = $FileNameArray["name"]; 
		$FileTmpName = $FileNameArray["tmp_name"];  
		$OldFile = $FileInfoArray['OldFile'];
		$FileArray = $this->CheckUploadedFile($FileNameArray, $FileInfoArray["FileType"]);
		$OldFileSize='0';
		if(empty($FileArray['ErrorMsg'])){
			$FileExtension = $FileArray['Extension']; 
			$uploadFileName = $FileInfoArray['FileID']."_".rand(1,99).".".$FileExtension;			
			//Create Directory	
			$CmpDir = $Config['RootUploadDir'].$Config['CmpID']."/";		
			$MainDir = $CmpDir.$FileInfoArray['FileDir'];	
			
			if(!is_dir($CmpDir)) {
				mkdir($CmpDir);	chmod($CmpDir,0777);
			}							
			if(!is_dir($MainDir)) {
				mkdir($MainDir);
				chmod($MainDir,0777);
			}
			
			$FileDestination = $MainDir.$uploadFileName;
		

			if(@move_uploaded_file($FileTmpName, $FileDestination)){
				 
				if(!empty($OldFile) && file_exists($MainDir.$OldFile)){
					$OldFileSize = filesize($MainDir.$OldFile)/1024; //KB 			 
					unlink($MainDir.$OldFile);
				}

				if($FileInfoArray['UpdateStorage']==1){
					$objConfigure->UpdateStorage($FileDestination,$OldFileSize,0);
				}

				$ResponseArray['FileName'] = $uploadFileName;
				$ResponseArray['Success'] = 1;
			}
		}else{ 
			$ResponseArray['ErrorMsg'] = $FileArray['ErrorMsg'];
			$ResponseArray['Success'] = 0;
		}
		return $ResponseArray;

		}
	}
	
	/**************************/
	function MakeDirFTP($Conn,$Dir){
		$ErrorMsg='';
		if(ftp_chdir($Conn, $Dir)){
			$Success = 1;
		}else{
			if(ftp_mkdir($Conn, $Dir)){
				ftp_chmod($Conn, 0777, $Dir);
				if(ftp_chdir($Conn, $Dir)){
					$Success = 1;
				}
		  	}else{
		    		$ErrorMsg = "Directory :".$Dir." not created.";
				$Success = 0; 
		  	}
		}
		$ResponseArray['ErrorMsg'] = $ErrorMsg;
		$ResponseArray['Success'] = $Success;
		return $ResponseArray;
	}
	/**************************/
	function UploadFileFTP($FileNameArray, $FileInfoArray){ //move_uploaded_file
		//https://www.w3schools.com/php/php_ref_ftp.asp
		global $Config;
		$objConfigure = new configure();
		$ErrorMsg='';
		/*******ftp**********/
		$FtpOK = 0;
		$Host = '75.112.188.111';  
		$Username = 'devftp';  
		$Password = 'Htpl!#70Znt0'; 
		$Port = '';  
		$SSL = 1;
		$UploadDir = 'upload/';
		if($SSL=="1"){ 
			if(!empty($Port)) $Conn = ftp_ssl_connect($Host,$Port);
			else $Conn = ftp_ssl_connect($Host);
		}else{  
			if(!empty($Port)) $Conn = ftp_connect($Host,$Port);
			else $Conn = ftp_connect($Host);
		}		 
		if(!$Conn){
			$ErrorMsg = "Could not connect to host :".$Host;
		}else{
			$LoginResponse = ftp_login($Conn, $Username, $Password);
			if(!$LoginResponse){
				$ErrorMsg = "Could not login to host :".$Host." with username :".$Username;
			}else{				 
				$DirCh = ftp_chdir($Conn, $UploadDir); 
				if(!$DirCh){
					$ErrorMsg = "Could not change to directory:".$UploadDir." on host :".$Host;
				}else{
					 $FtpOK = 1;
				}
			}
		}		
		/*****************/

		$FileName = $FileNameArray["name"]; 
		$FileTmpName = $FileNameArray["tmp_name"]; 
		$OldFile = $FileInfoArray['OldFile'];
		$FileArray = $this->CheckUploadedFile($FileNameArray, $FileInfoArray["FileType"]);

		$OldFileSize='0';

		if(empty($FileArray['ErrorMsg'])){
			$FileExtension = $FileArray['Extension']; 
			$uploadFileName = $FileInfoArray['FileID']."_".rand(1,99).".".$FileExtension;		
			/*******ftp**********/
			if($FtpOK=="1"){
				ini_set('display_errors',1);
				error_reporting(E_ALL);
				
				

				$CmpDir = $_SESSION['CmpID'];		
				$ResDirArray = $this->MakeDirFTP($Conn,$CmpDir);
				$ErrorMsg = $ResDirArray['ErrorMsg'];				 
				if(empty($ErrorMsg)){
					$MainDir = $FileInfoArray['FileDir'];	
					$ResDArray = $this->MakeDirFTP($Conn,$MainDir);
					$ErrorMsg = $ResDArray['ErrorMsg'];
					if(empty($ErrorMsg)){					

						$uploaded = ftp_put($Conn, $uploadFileName, $FileTmpName , FTP_BINARY);
						if(!$uploaded){
							$ErrorMsg = "Permission denied to upload file on host :".$Host;
						}else{
							/**********
							if(!empty($OldFile) && file_exists($OldFile)){
								$OldFileSize = filesize($OldFile)/1024; //KB 			 
								unlink($OldFile);
								//ftp_delete($Conn, $OldFile); 
							}

							if($FileInfoArray['UpdateStorage']==1){
								$objConfigure->UpdateStorage($FileDestination,$OldFileSize,0);
							}
							/**********/
							$ResponseArray['FileName'] = $uploadFileName;
							$ResponseArray['Success'] = 1;


						}
					}	
				}
				 
			}

			ftp_close($Conn);
			if(!empty($ErrorMsg)){
				$ResponseArray['ErrorMsg'] = $ErrorMsg;
				$ResponseArray['Success'] = 0;				 
			}
			 
		}else{ 
			$ResponseArray['ErrorMsg'] = $FileArray['ErrorMsg'];
			$ResponseArray['Success'] = 0;
		}
		return $ResponseArray;
	}

	/**************************/

	function UploadFileSFTP($FileNameArray, $FileInfoArray){ //SFTP
		global $Config;

		$ftpServer = "75.112.188.151";
		$ftpPort = '33433';
		$ftpUsername = 'configmgmt';
		$ftpPassword = 'Hp3V6jvzL5Ayd';
		 
		try{ 
		    echo "Started";
		    $sftp = new SFTPConnection($ftpServer, $ftpPort);			
		    $sftp->login($ftpUsername, $ftpPassword);		  
		    $sftp->uploadFile("/var/www/html/test/img/".$file_name, "/home/madhurendra/testupload/".$file_name);
		    echo "Uploaded";
		}catch (Exception $e){
		    echo "error";
		    echo $e->getMessage();
		}

		die;
		 
	}
	
	/*********Bluemix Object Storage *************/
	/*********************************************/
	function InitObjectStorage($ost=0){
		global $Config;
		$CmpID = $Config['CmpID'];
		 
		$idService = new IdentityService($Config['OsIdentityUrl']);
		$acl = ACL::makePublic();
		$Token = $idService->authenticateAsUser($Config['OsUsername'], $Config['OsPassword'], $Config['OsTenantId']); 				 
		$catalog = $idService->serviceCatalog();
		$storageList = $idService->serviceCatalog('object-store'); 
		$objectStorageUrl = $storageList[0]['endpoints'][0]['publicURL'];
		
		if(!empty($Token)){
			$objectStore = new \OpenStack\ObjectStore\v1\ObjectStorage($Token, $objectStorageUrl);
			
			if($ost==1) return $objectStore;

			if(!$objectStore->hasContainer($CmpID)){  		 
				$objectStore->createContainer($CmpID);
				$objectStore->changeContainerACL($CmpID,$acl);
			} 
			$container = $objectStore->container($CmpID);	
			 
			return $container;
		}else{
			echo 'No Token generated for Object Storage.'; die;
		}
	}


	function UploadObjectStorage($FileNameArray, $FileInfoArray){
		global $Config;
		$objConfigure = new configure();
		 


		$FileName = $FileNameArray["name"]; 
		$FileTmpName = $FileNameArray["tmp_name"];  
		$OldFile = $FileInfoArray['OldFile'];
		$Folder = $FileInfoArray['FileDir'];
		$FileArray = $this->CheckUploadedFile($FileNameArray, $FileInfoArray["FileType"]);
		$ErrorMsg=''; $OldFileSize='0';
 
		if(empty($Config['CmpID'])){
			$ErrorMsg = 'Please provide container name to upload file.';
		}else if(empty($FileArray['ErrorMsg'])){
			$FileExtension = $FileArray['Extension']; 
			$uploadFileName = $FileInfoArray['FileID']."_".rand(1,99).".".$FileExtension;		
			$container = $this->InitObjectStorage();
			  
			$content = file_get_contents($FileTmpName);
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($finfo,$FileTmpName);        
			$localObject = new Object($Folder.$uploadFileName,$content,$mime);
		 

			if($container->save($localObject)){				
				$arryInfoNew = $container->proxyObject($Folder.$uploadFileName);
				$NewFileSize = $arryInfoNew->contentLength(); //Byte
				
				if(!empty($OldFile)){
					$contentOld = file_get_contents($Config['OsUploadUrl'].$Config['CmpID']."/".$Folder.$OldFile);
					if(!empty($contentOld)){
					$arryInfoOld = $container->proxyObject($Folder.$OldFile);
					$OldFileSize = $arryInfoOld->contentLength(); //Byte
					$container->delete($Folder.$OldFile);
					}
				}
						
				$UploadFileSize = ($NewFileSize - $OldFileSize)/1024;
				
				 
				if($FileInfoArray['UpdateStorage']==1 && $Config['CmpID']>0 && $UploadFileSize>0){
					$objConfigure->UpdateFileStorage($Config['CmpID'],$UploadFileSize);   
				}

				$ResponseArray['FileName'] = $uploadFileName;			 
				$ResponseArray['Success'] = 1; 			 
			}else{				 
				$ErrorMsg = "File Uploading Failed.";				 
			}  
			 
		}else{ 
			$ErrorMsg = $FileArray['ErrorMsg'];			 
		}		 

		$ResponseArray['ErrorMsg'] = $ErrorMsg;
 
		return $ResponseArray;
	}


	function DeleteFileStorage($Folder, $FileName){
		global $Config;	
		$objConfigure=new configure();			

		$FilePath = $Folder.$FileName;		
		$ErrorMsg='';		 

		if(!empty($Folder) && !empty($FileName)){
			
			if($Config['ObjectStorage']=="1"){
				SetOsDir();

				/* Old Object Storage 	 	
				$container = $this->InitObjectStorage(); 
				$arryInfo = $container->proxyObject($FilePath);
				$RemoveFileSize = $arryInfo->contentLength(); //Byte
			        $RemoveFileSize = ($RemoveFileSize / 1024); //KB  
				if($container->delete($FilePath)){		 	 
					$ResponseArray['Success'] = 1; 			
					$objConfigure->RemoveFileStorage($Config['CmpID'],$RemoveFileSize);  		}else{
					$ErrorMsg = "Deletion Failed"; 
				}*/

				$Connection = new S3Client([
					'region'  => $Config['OsRegion'],
					'version'  => $Config['OsVersion'],
					'endpoint' => $Config['OsEndpoint'],
					'use_path_style_endpoint' => $Config['use_path_style_endpoint'],
					'credentials' => [
						'key'    => $Config['OsKey'],
						'secret' => $Config['OsSecret']
					],
				]);

 

				/*$header = get_headers($Config['OsUploadUrl'].$Config['OsDir']."/".$FilePath, TRUE);
				$arryHead = explode(" ",$header['0']);
				$RespCode = $arryHead[1];
				if($RespCode=="200"){*/
				if($Connection->doesObjectExist($Config['OsDir'], $FilePath)){	
					$arryInfo = $Connection->getObject(['Bucket' => $Config['OsDir'],'Key' =>$FilePath]);
					$RemoveFileSize = $arryInfo['ContentLength']; //Byte 

					$RemoveFileSize = ($RemoveFileSize / 1024); //KB
					if($Connection->deleteObject(['Bucket'=>$Config['OsDir'],'Key'=>$FilePath])){		 	 
						$ResponseArray['Success'] = 1; 			
						$objConfigure->RemoveFileStorage($Config['CmpID'],$RemoveFileSize);  		 
					}else{
						$ErrorMsg = "Deletion Failed"; 
					}
				} 
	 
				$ResponseArray['ErrorMsg'] = $ErrorMsg;	 

			}else{
				$FilePath = $Config['RootUploadDir'].$Config['CmpID']."/".$FilePath;
				 
				$objConfigure->UpdateStorage($FilePath,0,1);
				unlink($FilePath);
				$ResponseArray['Success'] = 1; 	
			}
		}
		return $ResponseArray;
	}
	 

	function DeleteDocStorage($Path, $Folder, $FileName){
		global $Config;			 
		$FilePath = $Folder.$FileName;					 

		$ErrorMsg='';
		if(!empty($Folder) && !empty($FileName)){
			
			if($Config['ObjectStorage']=="1"){
				SetOsDir();
				$Connection = new S3Client([
					'region'  => $Config['OsRegion'],
					'version'  => $Config['OsVersion'],
					'endpoint' => $Config['OsEndpoint'],
					'use_path_style_endpoint' => $Config['use_path_style_endpoint'],
					'credentials' => [
						'key'    => $Config['OsKey'],
						'secret' => $Config['OsSecret']
					],
				]); 

				if($Connection->doesObjectExist($Config['OsDir'], $FilePath)){	
					 
					if($Connection->deleteObject(['Bucket'=>$Config['OsDir'],'Key'=>$FilePath])){		 	 
						$ResponseArray['Success'] = 1; 			
						 
					}else{
						$ErrorMsg = "Deletion Failed"; 
					}
				} 
	 
				$ResponseArray['ErrorMsg'] = $ErrorMsg;	 

			}else{
				$FilePath = $Path.$FileName;
 				unlink($FilePath);
				$ResponseArray['Success'] = 1; 	
			}
		}
		return $ResponseArray;
	}


	function ListFileObjectStorage(){		
		$container = $this->InitObjectStorage(); 
		$arrFiles = $container->objects("1000","");
		foreach($arrFiles as $FileObj){
			$ResponseArray['FileName'] = $FileObj->name();
			echo '<br>'.$FileObj->name()." # ".$FileObj->contentLength();
		}
	 	die;
	 	echo '<pre>';print_r($arrFiles);die;
		$ResponseArray['ErrorMsg'] = $ErrorMsg;	 
		return $ResponseArray;
	}

	function ListFileByPathObjectStorage($Dir){		
		$container = $this->InitObjectStorage(); 
		$arrFiles = $container->objectsByPath($Dir);
		foreach($arrFiles as $FileObj){
			//echo '<pre>';print_r($FileObj);die;
			$ResponseArray['FileName'] = $FileObj->name();
			echo '<br>'.$FileObj->name()." # ".$FileObj->contentLength();
		}
	 	 die;
	 	echo '<pre>';print_r($arrFiles);die;
		$ResponseArray['ErrorMsg'] = $ErrorMsg;	 
		return $ResponseArray;
	}
	 
	function DeleteContainerObjectStorage($CmpID){
		 
		$container = $this->InitObjectStorage(); 
		$arrFiles = $container->objects("1000","");
		foreach($arrFiles as $FileObj){
			$FileName=$FileObj->name();
			$container->delete($FileName) ;			
		}
		$objectStore = $this->InitObjectStorage(1); 
		echo $objectStore->deleteContainer($CmpID); 
	 	die;
	 	 
		$ResponseArray['ErrorMsg'] = $ErrorMsg;	 
		return $ResponseArray;
	}

 
	
	/************Object Storage New****************/
	/*********************************************/
	
	function InitObjStorage(){
		global $Config;		 
 		
		try {
			$Connection = new S3Client([
				'region'=>$Config['OsRegion'],
				'version'     => $Config['OsVersion'],
				'endpoint' => $Config['OsEndpoint'],
				'use_path_style_endpoint' => $Config['use_path_style_endpoint'],
				'credentials' => [
					'key'    => $Config['OsKey'],
					'secret' => $Config['OsSecret']
				],
			]);
			SetOsDir();
			$info = $Connection->doesBucketExist($Config['OsDir']);
			if(empty($info)) {
				$Connection->createBucket(['Bucket' => $Config['OsDir'],'ACL' => 'public-read']); 
				$info=1;
			} 
			
			if($info==1){
				return $Connection;				
			}else{
				exit("Bucket creation error on server."); 
			}
		}catch(Exception $e) {
			exit("Bucket creation failed on server as this Bucket might have been created by another user."); 
			#exit($e->getMessage());
		} 
		
	
	}

	function UploadObjStorage($FileNameArray, $FileInfoArray){	

		global $Config;
		$objConfigure = new configure();	

                $FileName = $FileNameArray["name"]; 
		$FileTmpName = $FileNameArray['tmp_name'];  
		$OldFile = $FileInfoArray['OldFile'];
		$Folder = $FileInfoArray['FileDir'];
		$FileArray = $this->CheckUploadedFile($FileNameArray, $FileInfoArray["FileType"]);	
		$ErrorMsg=''; $OldFileSize='0'; $Success ='0';
		
		if(empty($Config['CmpID'])){
			$ErrorMsg = 'Please provide bucket name to upload file.';  
		}else if(empty($FileArray['ErrorMsg'])){
			$FileExtension = $FileArray['Extension']; 
			$uploadFileName = $FileInfoArray['FileID']."_".rand(1,99).".".$FileExtension;
			
			$Connection = $this->InitObjStorage(); 
			
			$content = file_get_contents($FileTmpName);
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$ContentType = finfo_file($finfo,$FileTmpName); 
			 
			$FullUploadPath = $Folder.$uploadFileName; 
 
			$arrayImageUpload = array('Bucket'=> $Config['OsDir'] ,'Key'=> $FullUploadPath ,'SourceFile'=> $FileTmpName,'ACL'=> 'public-read', 'ContentType'=> $ContentType
			);
			if($result = $Connection->putObject($arrayImageUpload)){
				//echo $result['ObjectURL'].'<br>'.$FullUploadPath.'<br>'; 
				    				
				$arryInfoNew = $Connection->getObject(['Bucket' => $Config['OsDir'],'Key' =>$FullUploadPath]);

				$NewFileSize = $arryInfoNew['ContentLength']; //Byte
				
				if(!empty($OldFile)){ 	
					$OldFilePath =  $Folder.$OldFile;

				 
					/*$headersold = get_headers($Config['OsUploadUrl'].$Config['OsDir']."/".$OldFilePath, TRUE);
					$arryHead = explode(" ",$headersold['0']);
					$RespCode = $arryHead[1];
					if($RespCode=="200"){ */	     	  	
					if($Connection->doesObjectExist($Config['OsDir'], $OldFilePath)){
						$arryInfoOld = $Connection->getObject(['Bucket' => $Config['OsDir'],'Key' =>$OldFilePath]);
						$OldFileSize = $arryInfoOld['ContentLength']; //Byte
						if(!empty($OldFileSize)){
							$Connection->deleteObject(['Bucket' => $Config['OsDir'],'Key' =>$OldFilePath]);
						}
					}					
					 
				}
					
				 
				$UploadFileSize = ($NewFileSize - $OldFileSize)/1024;				
				 	
				if($FileInfoArray['UpdateStorage']==1 && $Config['CmpID']>0 && $UploadFileSize>0){
					$objConfigure->UpdateFileStorage($Config['CmpID'],$UploadFileSize);   
				}

				$ResponseArray['FileName'] = $uploadFileName;			 
				$Success = 1; 	 		 
			}else{				 
				$ErrorMsg = "File Uploading Failed.";				 
			}  
			 
		}else{ 
			$ErrorMsg = $FileArray['ErrorMsg'];			 
		}
		 
		$ResponseArray['Success'] = $Success;
		$ResponseArray['ErrorMsg'] = $ErrorMsg;
 
		return $ResponseArray;
	}


	function MoveObjStorage($SourceFile , $Folder, $FileName){
		global $Config; 
		$ErrorMsg=''; 
		if(empty($Config['CmpID'])){
			$ErrorMsg = 'Please provide bucket name to upload file.';  
		}else{ 			
			$Connection = $this->InitObjStorage(); 		
			 
			$content = file_get_contents($SourceFile.$FileName);
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$ContentType = finfo_file($finfo,$SourceFile.$FileName); 

			$arrayImageUpload = array('Bucket'=> $Config['OsDir'] ,'Key'=>  $Folder.$FileName ,'SourceFile'=> $SourceFile.$FileName ,'ACL'=> 'public-read', 'ContentType'=> $ContentType
			); 

			#if(!$Connection->doesObjectExist($Config['OsDir'], $Folder.$FileName)){ //temp
				if($result = $Connection->putObject($arrayImageUpload)){
					$ResponseArray['Success'] = 1; 		 
				}else{				 
					$ErrorMsg = 'File Move Failed.';  					 
				} 
			#}else{	$ErrorMsg = 'File Already Exists.';  	}   
		}
		$ResponseArray['ErrorMsg'] = $ErrorMsg; 
		return $ResponseArray;
	}


	
	function DeleteBucketObjStorage($CmpID){
		global $Config;  
		$ErrorMsg=''; 
		if(empty($CmpID)){
			$ErrorMsg = 'Please provide bucket name to delete.';  
		}else{ 	
			$PrefixOsDir ='';
			if(strlen($CmpID)=='1'){
				$PrefixOsDir='00';
			}else if(strlen($CmpID)=='2'){
				$PrefixOsDir='0';
			} 
			$bucket = $PrefixOsDir.$CmpID;

			$Connection = new S3Client([
				'region'=>$Config['OsRegion'],
				'version' => $Config['OsVersion'],
				'endpoint' => $Config['OsEndpoint'],
				'use_path_style_endpoint' => $Config['use_path_style_endpoint'],
				'credentials' => [
					'key'    => $Config['OsKey'],
					'secret' => $Config['OsSecret']
				],
			]);		
			
			$info = $Connection->doesBucketExist($bucket);
			if(!empty($info) ) {
				$result = $Connection->listObjects(array('Bucket' => $bucket));
				foreach ($result['Contents'] as $object) {
					if(!empty($object['Key'])){
						$Connection->deleteObject([
						'Bucket'       => $bucket,
						'Key'          => $object['Key'],		
						]);
					}	
				}

				$Connection->deleteBucket(['Bucket' => $bucket]);
				$ResponseArray['Success'] = 1; 	
			}else{
				$ErrorMsg = "Bucket does not exsist on server."; 
			}
		}
		$ResponseArray['ErrorMsg'] = $ErrorMsg; 
		return $ResponseArray;
	}

}

?>
