<?php

	/* * *********************************************** */
	include_once("../includes/FieldArray.php");
	/* * *********************************************** */
	include_once("../includes/header.php");
	require_once($Prefix . "classes/filter.class.php");
	require_once($Prefix . "classes/user.class.php");
	require_once($Prefix . "classes/hrms.class.php");
	require_once($Prefix . "classes/function.class.php");

	$objFunction = new functions();
	$objCommon = new common();
	$objFilter = new filter();
	$objUser = new user();

	$ModuleName = "Custom View";



	if ($_POST) {


		if(!empty($_POST['cvid'])){
			$objFilter->updateCustomView($_POST);
			$LastInsertId =$_POST['cvid'];
			$objFilter->updateColumnView($_POST);
			$objFilter->UpdateRule($_POST);
		}else{
			$LastInsertId = $objFilter->addCustomView($_POST);   
			if($LastInsertId>0){
			$_POST['cid']=$LastInsertId;
			$objFilter->addColumnView($_POST);
			$objFilter->addRule($_POST);

			}      

	          }
	   $RedirectURL = "view".ucfirst($_POST['ModuleType']).".php?module=".$_POST['ModuleType']."&customview=".$LastInsertId;
		    header("Location:".$RedirectURL);
		    
   
    }





	if(!empty($_GET['edit'])){
		$arryTicketfilter = $objFilter->getCustomView($_GET['edit'],$_GET['type']);

		if($arryTicketfilter[0]['cvid']){
			$arryColVal= $objFilter->getColumnsListByCvid($arryTicketfilter[0]['cvid'] );
			$arryQuery = $objFilter->getFileter($arryTicketfilter[0]['cvid'] );

		}

	}


require_once("../includes/footer.php");
?>


