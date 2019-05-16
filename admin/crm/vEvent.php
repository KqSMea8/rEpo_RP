<?php
 /**************************************************/
    $ThisPageName = 'viewEvent.php';
    /**************************************************/
$FancyBox=1;
	require_once("../includes/header.php");
require_once($Prefix."classes/event.class.php");
require_once($Prefix."classes/region.class.php");
require_once($Prefix."classes/employee.class.php");
	
	
	$ModuleName = "Event";
	//$RedirectURL = "viewEvent.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	if(empty($_GET['tab'])) $_GET['tab']="Information";

	//$EditUrl = "editEvent.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
	//$ActionUrl = $EditUrl.$_GET["tab"];
	
	if($_GET['parent_type']!='' && $_GET['parentID']!=''){
	$BackUrl = "viewEvent.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"];
	$RedirectURL = "viewEvent.php?module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET['curP'];
	$EditUrl = "editEvent.php?edit=".$_GET["edit"]."&module=".$_GET["module"]."&parent_type=".$_GET['parent_type']."&parentID=".$_GET['parentID']."&curP=".$_GET["curP"]; 
	
	$ActionUrl = $EditUrl.$_GET["tab"];
	}else{
	$RedirectURL = "viewEvent.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	//$RedirectURL = "viewEvent.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="Information";

	$EditUrl = "editEvent.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];
   }
	


	$objEvent=new event();
	$objRegion=new region();
	$objEmployee=new employee();

    /*******************/
	if($_SESSION['AdminType']=='admin'){
      $Admin=$_SESSION['AdminType'];
	}else{
    $Admin=$_SESSION['AdminID'];
	}
	/*******************/



	if (!empty($_GET['view'])) {



		$arryEvent = $objEvent->ListEvent($_GET['view'],$_GET['parent_type'],$_GET['parentID'],$_GET['key'],$_GET['sortby'],$_GET['asc']);
		$EventID   = $_GET['view'];
        //$arryEmployee=$objEmployee->GetEmployeeBrief($arryEvent[0]['AssignTo']);

		//$arryCmtUser = $objEvent->GetCommentUser($_GET['view'],'');
		//print_r($arryCmtUser);
	}
	

	require_once("../includes/footer.php"); 
?>
