<?php 
 
	$Prefix = "/var/www/html/erp/";
	ini_set("display_errors","0"); error_reporting(0);
	$Config['CronJob'] = '1';

	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php"); 
	require_once($Prefix."classes/company.class.php"); 
	require_once($Prefix."classes/server.class.php");
	$objCompany=new company(); 
	 $objServer = new server();
	/************************/
	$dataBaseMainpath = '/prod-data-erp/database-backup/';	
	 
	$NumMonth=6;
	$arryDate = explode("-",date('Y-m-d'));
	list($year, $month, $day) = $arryDate;
	$TempDate  = mktime(0, 0, 0, $month-$NumMonth , $day, $year);
	$DeleteBefore = date("Y-m-d",$TempDate); 

	$arryCompany=$objCompany->ListCompany('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
 	
 
 
	foreach($arryCompany as $key=>$values){ 
		/*******Delete DB Backup*****************/
		$db = $values['DisplayName'];         
		$file = glob($dataBaseMainpath."$db/*.*");
		$file =  array_reverse($file);
		foreach($file as $key=>$values) { 
			$filedetail = pathinfo($values);
			$FileSize = $objServer->GetFileSize($values);
			$x = array('filename'=>$filedetail['filename'],'extension'=>$filedetail['extension'],'date'=>filemtime($values),'filesize'=>$FileSize);
			array_push($files,$x);
			#$FileDate = date ("Y-m-d",($x['date']));

			/***********/				
			$arrFilename = explode(".",$filedetail['filename']);
			$FileDate = strrev(substr(strrev($arrFilename[0]),0,10));
			/***********/

			if($FileDate < $DeleteBefore){				
				unlink($values);	
			}			
		}  
		 
		/***************************************/
	}
	  
?>


