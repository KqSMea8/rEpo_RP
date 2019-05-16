<?
	$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/supplier.class.php");
	$objSupplier=new supplier();
	
	 

	


	if(!empty($_POST['SuppID'])) {
		$RedirectURL = "editSupplier.php?edit=".$_POST['SuppID'].'&tab=bank';
		CleanPost(); 
		if(!empty($_POST['BankID'])) {
			$_SESSION['mess_supplier'] = BANK_UPDATED;
			$BankID = $_POST['BankID'];
			$objSupplier->UpdateBank($_POST);			
		}else{
			$_SESSION['mess_supplier'] = BANK_ADDED;
			$BankID = $objSupplier->addBank($_POST);
		}	

		///$objSupplier->UnDefaultBank($BankID,$_POST['SuppID']);

		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;
	}






	if(!empty($_GET['SuppID'])) {
		$arrySupplier = $objSupplier->GetSupplier($_GET['SuppID'],'','');
		
		if(empty($arrySupplier[0]['SuppID'])){
			$ErrorExist=1;
			echo '<div class="redmsg" align="center">'.NOT_EXIST_SUPP.'</div>';
		}
	}else{
		$ErrorExist=1;
		echo '<div class="redmsg" align="center">'.INVALID_REQUEST.'</div>';
	}
	/*************************/

	if(empty($ErrorExist)){ 
		if(!empty($_GET['edit'])) {
			$arryBank = $objSupplier->GetBank($_GET['edit'],$_GET['SuppID'],'');
			
			$PageAction = 'Edit';
			$ButtonAction = 'Update';
		}else{
			$PageAction = 'Add';
			$ButtonAction = 'Submit';
			$arryBank = $objConfigure->GetDefaultArrayValue('p_supplier_bank');
		}

	}

	require_once("../includes/footer.php");  

?>
