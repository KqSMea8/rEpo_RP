<?php  
	ini_set('display_errors',1);
	error_reporting(E_ALL);

	if(!empty($_GET['file'])){
		$TemplateDir = 'template/';
		$zip = new ZipArchive;
	    	$zip->open($TemplateDir.$_GET['file']); 
	    	$zip->extractTo($TemplateDir); 
	    	$zip->close(); 
	}
?>		
			
