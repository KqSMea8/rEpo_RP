<?php
require_once("includes/config.php"); 
require_once("includes/function.php");
 
/************/
$RootDir = '/var/www/html/';  
$FromDir = $RootDir.'erp/upload/company/';
$ToFolder = "banner/";
$Base = md5($_GET['pk']); 
/************/
if(!empty($Base) && $Base=='2e5bda28ac98653b0c5ec52b9906845a'){ 

 	$link=mysql_connect ($Config['DbHost'],mydecrypt($Config['DbUser']),mydecrypt($Config['DbPassword']),TRUE);
	if(!$link){die("Could not connect to MySQL");}
	mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());
	
	$q=mysql_query("select CmpID,DisplayName,Image from company order by CmpID asc ",$link) or die (mysql_error()); 
	$Count=0;
	while($row = mysql_fetch_array($q)) {
		
		if($row['CmpID']>0){ 
			$CmpDir = $FromDir.$row['CmpID'].'/slider_image/*';
			/***************/ 
			$ToDir = $RootDir.'upload/'.$row['CmpID']; 
			if(!is_dir($ToDir)) {
				mkdir($ToDir);
				chmod($ToDir,0777);
			}
			$ToDir = $ToDir.'/'.$ToFolder; 
			if (!is_dir($ToDir)) {
				mkdir($ToDir);
				chmod($ToDir,0777);
			}
			/***************/
			//if($row['Image'] !='' && file_exists('upload/company/'.$row['Image']) ){
				$cmd = 'cp '.$CmpDir.' '.$ToDir; //mv
				//echo $cmd; die;		 
				$data = shell_exec($cmd);
				echo '<br>Copied for : '.$row['DisplayName']." : ".$row['CmpID'].'<br>';
				 
				$Count++;
			//}
			
			/***************/ 
		}

		#if($Count==5) die;
	}	
	

	
 


}

exit;
 
?>
 
