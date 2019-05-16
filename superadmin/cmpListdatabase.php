<?php 

	$HideNavigation = 1;
	/**************************************************/
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
	$ModuleName = "Company";
	$objCompany=new company();
	
	(empty($_GET['file']))?($_GET['file']=""):("");


      $database = $_GET['file'];
      $RedirectURL =  "databaseBackup.php?databaseName=".$database;


	$DbUser = mydecrypt($Config['DbUser']);
	$DbPassword = mydecrypt($Config['DbPassword']);


	 if(!empty($_POST['DATABASE'])){   
		CleanPost();
		 
		foreach ($_POST['database'] as $database){ 	
			     $password = '';
			     $db = $Config['DbMain']."_".$database; 
			     $filename = $database.'_'.date('Y-m-d').'.sql.gz';
			     $folder = $database;
			     $filepath = $dataBaseMainpath;

				$MainDir = $filepath.$folder.'/';						
				if (!is_dir($MainDir)) {
					mkdir($MainDir);
					chmod($MainDir,0777);
				}
				
			   # echo 'mysqldump -h localhost -u '.$DbUser.' -p'.$DbPassword.' '.$db.' | gzip > '.$MainDir.$filename;exit;
			    $data = shell_exec('mysqldump -h localhost -u '.$DbUser.' -p'.$DbPassword.' '.$db.' | gzip > '.$MainDir.$filename);
		}
		 $RedirectURL =  "databaseBackup.php?databaseName=".$database;
             	$_SESSION['mess_Database'] = DATABASE_BACKUP_SUCCESSFULL;
	        echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
     		exit;
     }
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


