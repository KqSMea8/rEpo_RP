<?php
        //include_once("../includes/header.php");
	require_once($Prefix . "classes/filter.class.php");
	
	$objFilter = new filter();
	
	$ModuleName = "Custom View";

	(empty($_GET['parent_type']))?($_GET['parent_type']=""):(""); 


	if(empty($MainModuleID) && !empty($Config['CurrentDepID'])){
		header("Location: home.php");
		exit;
	}



	if (!empty($_POST)) {
		    CleanPost();

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
	   #$RedirectURL = "view".ucfirst($_POST['ModuleType']).".php?module=".$_POST['ModuleType']."&customview=".$LastInsertId;
		    #header("Location:".$RedirectURL);
                 
                  if($Config['CurrentDepID'] == '8' || $_GET['type'] == 'Customer' || $Config['CurrentDepID'] == '3' || $Config['CurrentDepID'] == '2' || $_GET['type'] == 'PoInvoice' ){
                  $RedirectURL = $ThisPageName ."?customview=".$LastInsertId;
                  }else{
                     $RedirectURL = $ThisPageName ."&customview=".$LastInsertId; 
                  }
		  header("Location:".$RedirectURL);
		    exit;
   
    }





	if(!empty($_GET['edit'])){
		$arryTicketfilter = $objFilter->getCustomView($_GET['edit'],$_GET['type']);

		if($arryTicketfilter[0]['cvid']){
			$arryColVal= $objFilter->getColumnsListByCvid($arryTicketfilter[0]['cvid'] );
			$arryQuery = $objFilter->getFileter($arryTicketfilter[0]['cvid'] );

		}

	}else{
		$arryTicketfilter = $objConfigure->GetDefaultArrayValue('c_customview');
		
	}

	



?>


