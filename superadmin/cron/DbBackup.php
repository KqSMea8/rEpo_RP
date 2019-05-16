<?php 

	/**********/
	$StartTime = microtime(true);
	//echo "\nStart Time : ".$StartTime." \nProcessing.........\n\n";	die;
	/**********/

	 	//$Prefix = '../../';
		$Prefix = "/var/www/html/erp/";
		ini_set("display_errors","0"); error_reporting(0);
		$Config['CronJob'] = '1';

		require_once($Prefix."includes/config.php");
		require_once($Prefix."includes/function.php");
		require_once($Prefix."classes/dbClass.php");
		require_once($Prefix."classes/admin.class.php");	
		require_once($Prefix."classes/company.class.php");
		$objConfig=new admin();	
		$objCompany=new company();
	
		$CronFlag = $objConfig->CheckDbCronSetting();
		//$CronFlag=1;
		/************************/
		if($CronFlag){			
			$objConfig->UpdateLastRecurringEntry(1);
		


			$filepath = '/prod-data-erp/database-backup/';	
			$user = mydecrypt($Config['DbUser']);
		 	$password = mydecrypt($Config['DbPassword']);

			$arryCompany=$objCompany->ListCompany('',$_GET['key'],$_GET['sortby'],$_GET['asc']);

			$CmpDatabase[$Config['DbMain']] = $Config['DbMain'];
			foreach($arryCompany as $key=>$values){
				$CmpDatabase[$values['DisplayName']] = $Config['DbMain']."_".$values['DisplayName']; 
			}
	 		$Line=0;

			foreach($CmpDatabase as $folder=>$database){
				 /**********************/
				 //echo $folder.'#'.$database.'<br>'; exit;
				 /**********************/

				$filename = $database.'_'.date('Y-m-d').'.sql.gz';
				
				$MainDir = $filepath.$folder.'/';						
				if (!is_dir($MainDir)) {
					mkdir($MainDir);
					chmod($MainDir,0777);
				}

	  //echo 'mysqldump -h '.$Config['DbHost'].' -u '.$user.' -p'.$password.' '.$database.' | gzip > '.$MainDir.$filename;exit;
				$data = shell_exec('mysqldump -h '.$Config['DbHost'].' -u '.$user.' -p'.$password.' '.$database.' | gzip > '.$MainDir.$filename);
			
				$Line++;
		
				//echo '<br>'.$filename; if($Line==2){	break;	}
			}
			//echo 'Done Successfully';

		}

		/**********/
		//print_r($ArrayDb);
		//sleep(2);
		$EndTime = microtime(true);
		$ExecutionTime = $EndTime - $StartTime;
		//echo "\nEnd Time : ".$EndTime;
		echo "\nProcess Spent : ".time_diff(round($ExecutionTime))."\n";die;
		/**********/

		/*******************************************
		$FromName = 'ERP Database Cron';
		$FromEmail = 'source005@gmail.com';
		$To = 'parwez005@gmail.com';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: ".$FromName. "<".$FromEmail.">\r\n" .
		"Reply-To: ".$FromEmail. "\r\n" .
		"X-Mailer: PHP/" . phpversion();	
		$Subject = 'ERP Database Cron : ';
		$contents = 'ERP Database Cron';
		$pp = mail($To, $Subject, $contents, $headers);	
		exit;
		/*******************************************/
	  
?>


