<?php
 /**************************************************/
    $ThisPageName = 'viewOrderSource.php'; $EditPage = 1;
    /**************************************************/
	require_once("../includes/header.php");
	 require_once($Prefix."classes/saleSetting.class.php");
		 	$objSaleconfig=new saleconfig();
	$_GET['att'] = 5;
	$_GET['edit'] = (int)$_GET['edit'];
	$RedirectUrl ="viewOrderSource.php";
$ModuleName = "Order Source";
	if(empty($_GET['att'])){
		header("location: viewOrderSource.php?att=1");
		exit;
	}

	$arryAttribute=$objSaleconfig->AllAttributes($_GET['att']);  
	 $ModuleName = $arryAttribute[0]["attribute"];
	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_att'] = $ModuleName.$MSG[103];
		$objSaleconfig->deleteAttribute($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_att'] = $ModuleName.$MSG[104];
		$objSaleconfig->changeAttributeStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	

	if ($_POST) {
		CleanPost(); 
		if (!empty($_POST['value_id'])) {
			$objSaleconfig->updateAttribute($_POST);
			$_SESSION['mess_att'] = $ModuleName.$MSG[102];
		} else {		
			$objSaleconfig->addAttribute($_POST);
			$_SESSION['mess_att'] = $ModuleName.$MSG[101];
		}
	
		 
		header("location:".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;
	if(isset($_GET['edit']) && $_GET['edit'] >0)
	{
		$arryAtt = $objSaleconfig->getAttribute($_GET['edit'],'','');
                $PageHeading = 'Edit '.$ModuleName.' for '.stripslashes($arryAtt[0]['attribute_value']);
		
		$attribute_value = stripslashes($arryAtt[0]['attribute_value']);
		$Status   = $arryAtt[0]['Status'];
	}else{
		$attribute_value='';
	}




	 require_once("../includes/footer.php"); 
 
?>
