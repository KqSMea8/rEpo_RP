<?php 

	$HideNavigation = 1;
	/**************************************************/
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
        require_once("../classes/server.class.php");
	$ModuleName = "Company";
	$objCompany=new company();
        $objServer = new server();
        $database = $_GET['file'];
        $RedirectURL =  "databaseBackup.php";
	$DeleteBefore='';


        if(!empty($_POST['DATABASE'])){   
		cleanPost();
		$DeleteBefore = $_POST['DeleteBefore'];
		$KeepNumRecord =  $_POST['KeepNumRecord'];

		$file = array();
		$files = array();
		
		foreach ($_POST['database'] as $database){ 
			unset($file);
			unset($files);
			$db = $database;          
			$file = glob($dataBaseMainpath."$db/*.*");
			$file =  array_reverse($file);		
			//print_r($file);
			$Count=0;
			foreach($file as $key=>$values) {
				$Count++;
				$filedetail = pathinfo($values);
				$FileSize = $objServer->GetFileSize($values);

				$x = array('filename'=>$filedetail['filename'],'extension'=>$filedetail['extension'],'date'=>filemtime($values),'filesize'=>$FileSize);
				 
				array_push($files,$x);
				#$FileDate = date ("Y-m-d",($x['date']));

				/***********/				
				$arrFilename = explode(".",$filedetail['filename']);
				$FileDate = strrev(substr(strrev($arrFilename[0]),0,10));
				/***********/

				$Total = count($files);

				if($KeepNumRecord > 0){
					if($Count>$KeepNumRecord){
						$DeleteFlag = 1;
					}else{
						$DeleteFlag = 0;
					}
				}else{
					$DeleteFlag = 1;
				}

				if($FileDate < $DeleteBefore && $DeleteFlag==1){
					unlink($values);
					//echo $values.'<br>';
				}
			}
			
		}
		
		$_SESSION['mess_Database'] = DATABASE_BACKUP_REMOVED;
		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;
       }

	$RecordsPerPage=100;
	/*******Get Company Records**************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryCompany=$objCompany->ListCompany('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	/***********Count Records****************/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objCompany->ListCompany('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
	/****************************************/


	require_once("includes/footer.php"); 	 
?>


