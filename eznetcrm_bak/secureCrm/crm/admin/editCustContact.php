<?
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$objCustomer = new Customer();


	if($_POST['CustomerID']>0) {
		if(!empty($_POST['AddressID'])) {
			$_SESSION['mess_cust'] = CUST_CONTACT_UPDATED;
			$AddID = $_POST['AddressID'];
			$objCustomer->updateCustomerAddress($_POST,$AddID);
			
		}else{

			if(!$objCustomer->isCustAddressExists($_POST['CustomerID'],'contact')){
				$_POST['PrimaryContact']=1;
			}

			$_SESSION['mess_cust'] = CUST_CONTACT_ADDED;
			$AddID = $objCustomer->addCustomerAddress($_POST,$_POST['CustomerID'],'contact');
		}
		

		/*****ADD COUNTRY/STATE/CITY NAME****/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/***********************************/

		$arryCountry = $objRegion->GetCountryName($_POST['Country']);
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

		$objCustomer->UpdateCountryStateCity($arryRgn,$AddID);
				
		/**************END COUNTRY NAME*********************/



		$RedirectURL = $_POST['CurrentDivision']."/editCustomer.php?edit=".$_POST['CustomerID'].'&tab=contacts';

		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;


	}






	if(!empty($_GET['CustID'])) {
		$arryCustomer = $objCustomer->GetCustomer($_GET['CustID'],'','');
				
		if($arryCustomer[0]['Cid']<=0){
			$ErrorExist=1;
			echo '<div class="redmsg" align="center">'.CUSTOMER_NOT_EXIST.'</div>';
		}
	}else{
		$ErrorExist=1;
		echo '<div class="redmsg" align="center">'.INVALID_REQUEST.'</div>';
	}
	/*************************/

	if(empty($ErrorExist)){ 
		if(!empty($_GET['AddID'])) {
			$arryCustAddress = $objCustomer->GetAddressBook($_GET['AddID']);
			
			$PageAction = 'Edit';
			$ButtonAction = 'Update';
		}else{
			$PageAction = 'Add';
			$ButtonAction = 'Submit';
		}

	}

	require_once("includes/footer.php");  

?>
