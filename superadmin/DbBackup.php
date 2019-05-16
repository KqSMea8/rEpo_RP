<?php 
$Base = md5($_GET['base']); 
 
if($Base=='ac2be2874d5f920e24fdcfe48eab166d'){
	 
		include_once("includes/settings.php");
		require_once("../classes/company.class.php");
		$objCompany=new company();

		$filepath = '/prod-data-erp/database-backup/';	
		$user = mydecrypt($Config['DbUser']);
	 	$password = mydecrypt($Config['DbPassword']);

		$arryCompany=$objCompany->ListCompany('',$_GET['key'],$_GET['sortby'],$_GET['asc']);

		$CmpDatabase[$Config['DbMain']] = $Config['DbMain'];
		foreach($arryCompany as $key=>$values){
			$CmpDatabase[$values['DisplayName']] = $Config['DbMain']."_".$values['DisplayName']; 
		}

		foreach($CmpDatabase as $folder=>$database){
			 /**********************/
			// echo $folder.'#'.$database.'<br>'; exit;
			 /**********************/

			$filename = $database.'_'.date('Y-m-d').'.sql.gz';
				
			$MainDir = $filepath.$folder.'/';						
			if (!is_dir($MainDir)) {
				mkdir($MainDir);
				chmod($MainDir,0777);
			}

 // echo 'mysqldump -h localhost -u '.$user.' -p'.$password.' '.$database.' | gzip > '.$MainDir.$filename;exit;
			$data = shell_exec('mysqldump -h localhost -u '.$user.' -p'.$password.' '.$database.' | gzip > '.$MainDir.$filename);
			
			
		}
		echo 'Done Successfully';
}
  
?>


