<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/warehousing.class.php"); 	
	$objCommon = new common();       
 
	(empty($_GET['sby']))?($_GET['sby']=""):("");
	(empty($_GET['rtype']))?($_GET['rtype']=""):("");

        if(empty($_GET['t'])){ $_GET['t'] = date('Y-m-d');}
        if(empty($_GET['f'])){ $_GET['f'] = date('Y-m-01');}
        
	/*************************/
	$arryData=$objCommon->TrackingReport($_GET);
	$num=$objCommon->numRows();	 
	/*************************/
		
	require_once("../includes/footer.php"); 	
?>


