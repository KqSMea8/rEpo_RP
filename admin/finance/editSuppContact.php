<?
	$HideNavigation = 1;
	include_once("../includes/header.php");
	require_once($Prefix."classes/supplier.class.php");
	$objSupplier=new supplier();

	if(empty($_GET['AddID'])) $_GET['AddID']="";  


	if(!empty($_POST['SupplierID'])) {  CleanPost();
		if(!empty($_POST['AddressID'])) {
			$_SESSION['mess_supplier'] = SUPP_CONTACT_UPDATED;
			$AddID = $_POST['AddressID'];
			$objSupplier->updateSupplierAddress($_POST,$AddID);
			
		}else{
			if(!$objSupplier->isSuppAddressExists($_POST['SupplierID'],'contact')){
				$_POST['PrimaryContact']=1;
			}


			$_SESSION['mess_supplier'] = SUPP_CONTACT_ADDED;
			$AddID = $objSupplier->addSupplierAddress($_POST,$_POST['SupplierID'],'contact');
		}
		
		//$objSupplier->updateAssignRole($_POST,$AddID); //Not Required

		/*****ADD COUNTRY/STATE/CITY NAME****/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/***********************************/
		$arryCountry = $objRegion->GetCountryName($_POST['country_id']);
		$arryRgn['Country']= stripslashes($arryCountry[0]["name"]);
		if(!empty($_POST['main_state_id'])) {
			$arryState = $objRegion->getStateName($_POST['main_state_id']);
			$arryRgn['State']= stripslashes($arryState[0]["name"]);
		}else if(!empty($_POST['OtherState'])){
			 $arryRgn['State']=$_POST['OtherState'];
		}

		if(!empty($_POST['main_city_id'])) {
			$arryCity = $objRegion->getCityName($_POST['main_city_id']);
			$arryRgn['City']= stripslashes($arryCity[0]["name"]);
		}else if(!empty($_POST['OtherCity'])){
			 $arryRgn['City']=$_POST['OtherCity'];
		}
		/***********************************/
		$Config['DbName'] = $_SESSION['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();

		$objSupplier->UpdateAddCountryStateCity($arryRgn,$AddID);
				
		/**************END COUNTRY NAME*********************/



		$RedirectURL = "editSupplier.php?edit=".$_POST['SupplierID'].'&tab=contacts';

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
		if(!empty($_GET['AddID'])) {
			$arrySuppAddress = $objSupplier->GetAddressBook($_GET['AddID']);
			
			$PageAction = 'Edit';
			$ButtonAction = 'Update';
		}else{
			$PageAction = 'Add';
			$ButtonAction = 'Submit';
			$arrySuppAddress = $objConfigure->GetDefaultArrayValue('p_address_book');
		}

	}

	require_once("../includes/footer.php");  

?>
