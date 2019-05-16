<?php
/************/
$RootDir = '/var/www/html/'; 
$CmpID = (int)$_GET['CmpID'];
 
$ToFolder = 'items_secondary/';
$Base = md5($_GET['pk']); 
/************/
if(!empty($Base) && $Base=='91c57dd9675ba5f5c64383beab336196'){ 
	$FromDir = $RootDir.'erp/admin/inventory/upload/items/images/secondary/'.$CmpID.'/*';

	$ToDir = $RootDir.'upload/'.$CmpID;
	if(!is_dir($ToDir)) {
		mkdir($ToDir);
		chmod($ToDir,0777);
	}

	$ToDir = $ToDir.'/'.$ToFolder;

	$cmd = 'mv '.$FromDir.' '.$ToDir;
	
	

	if (!is_dir($ToDir)) {
		mkdir($ToDir);
		chmod($ToDir,0777);
	}
	echo $cmd; 

	if($CmpID>0){ 
		echo '<br><br>Moved Successfully.';
		$data = shell_exec($cmd);
	}
}

exit;
 
?>
 
