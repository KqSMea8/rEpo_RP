<?
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$objCustomer = new Customer();
	
	//By Chetan18Aug//
        require_once($Prefix."classes/field.class.php"); 
        $objField = new field();	
        $arryHead=$objField->getHead('',107,1);
        //End//

	if(!empty($_POST['CustID'])) { 
		CleanPost();
		if(!empty($_POST['AddID'])) {
			$_SESSION['mess_cust'] = CUST_CONTACT_UPDATED;
			$AddID = $_POST['AddID'];
			$objCustomer->updateCustomerAddress($_POST,$AddID);
			
		}else{

			if(!$objCustomer->isCustAddressExists($_POST['CustID'],'contact')){
				$_POST['PrimaryContact']=1;
			}

			$_SESSION['mess_cust'] = CUST_CONTACT_ADDED;
			if($_POST['tab']=='shipping') $AddType='shipping';
			else $AddType='contact';
			$AddID = $objCustomer->addPopUpCustomerAddress($_POST,$AddType); //By Chetan 18Aug//
		}

		$objCustomer->updateAssignRole($_POST,$AddID);
		
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

		$objCustomer->UpdateCountryStateCity($arryRgn,$AddID);
				
		/**************END COUNTRY NAME*********************/

 

		// $RedirectURL = $_POST['CurrentDivision']."/editCustomer.php?edit=".$_POST['CustID'].'&tab=contacts'; 

		(empty($_POST['CustomerID']))?($_POST['CustomerID']=""):("");	

 
		$RedirectURL ="dashboard.php?edit=".$_POST['CustomerID'].'&tab='.$_POST['tab'];
		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;


	}






	if(!empty($_GET['CustID'])) {
		$arryCustomer = $objCustomer->GetCustomer($_GET['CustID'],'','');
				
		if(empty($arryCustomer[0]['Cid'])){
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
			$arryCustAddress = $objConfigure->GetDefaultArrayValue('s_address_book');
		}

	}

 
	require_once("includes/footer.php");  

?>
