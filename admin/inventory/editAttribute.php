<?php
 /**************************************************/
    $ThisPageName = 'viewAttribute.php'; $EditPage = 1;
    /**************************************************/
	require_once("../includes/header.php");
	 require_once($Prefix."classes/inv.class.php");
		 	$objCommon=new common();

	$RedirectUrl ="viewAttribute.php?att=".$_GET['att'];

	$_GET['att'] = (int)$_GET['att'];

	if(empty($_GET['att'])){
		header("location: viewAttribute.php?att=1");
		exit;
	}

	$arryAttribute=$objCommon->AllAttributes($_GET['att']);  
	$ModuleName = $arryAttribute[0]["attribute"];
	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_att'] = $ModuleName.$MSG[103];
		$objCommon->deleteAttribute($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_att'] = $ModuleName.$MSG[104];
		$objCommon->changeAttributeStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	

	if ($_POST) {
		CleanPost();
		if (!empty($_POST['value_id'])) {
			$objCommon->updateAttribute($_POST);
			$_SESSION['mess_att'] = $ModuleName.$MSG[102];
			$lastInsertId=$_POST['value_id'];

		} else {		
			$lastInsertId=$objCommon->addAttribute($_POST);
			$_SESSION['mess_att'] = $ModuleName.$MSG[101];
			
			
		
		}
		// for Company to Company Sync by karishma || 2 Dec 2015
		$attributeArray=array('2'=>'procurement','3'=>'valuation type','13'=>'adjustment reason','5'=>'manage generation',
			'7'=>'manage extended','8'=>'manage manufacture','9'=>'reorder method','11'=>'manage unit','1'=>'item type');
		if (array_key_exists($_POST['attribute_id'], $attributeArray)) {
			if ($_SESSION['DefaultInventoryCompany'] == '1' ) {
				$Companys = $objCompany->SelectAutomaticSyncCompany();
				for($count=0;$count<count($Companys);$count++){
					$CmpID=$Companys[$count]['CmpID'];
					$objCompany->syncInventoryCompany($CmpID,$lastInsertId,'setting',$attributeArray[$_POST['attribute_id']]);

				}
			}
		}
		 
		// end
	
		$RedirectUrl ="viewAttribute.php?att=".$_POST['attribute_id'];
		header("location:".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;
	if(isset($_GET['edit']) && $_GET['edit'] >0)
	{
		$arryAtt = $objCommon->getAttribute($_GET['edit'],'','');
		
		$attribute_value = stripslashes($arryAtt[0]['attribute_value']);
		$Status   = $arryAtt[0]['Status'];
	}




	 require_once("../includes/footer.php"); 
 
?>
