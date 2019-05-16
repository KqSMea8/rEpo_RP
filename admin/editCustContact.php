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
        
	(empty($_GET['CustID']))?($_GET['CustID']=""):("");	
	(empty($_GET['AddID']))?($_GET['AddID']=""):("");	

        //sanjiv
        require_once($Prefix."classes/admin.class.php");
        require_once($Prefix."classes/customer.supplier.class.php");
        $objCustomerSupplier= new CustomerSupplier();
        $objAdmin = new Admin();
        //end sanjiv
        
	if(!empty($_POST['CustID'])) {
		
		CleanPost();
		unset($_POST['UsedState']);
	/*************Added by Sanjiv**********************/
		if($_GET['tab']=='contacts'){
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();


			if(!empty($_POST['Email'])){
								
				$dt['ref_id'] = $_POST['AddID'];
				$dt['user_type'] = 'customerContact';
				$dt['CmpID'] = $_SESSION['CmpID'];
				$dt['Email'] = $_POST['Email'];	
				 
				if($objConfig->isUserEmailDuplicate($dt)){	
					$_SESSION['mess_cust'] = 'Error! This email is already in use.';
					$RedirectURL = $_POST['CurrentDivision']."/editCustomer.php?edit=".$_POST['CustID'].'&tab=contacts';
					echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
					exit;
				}								
			}











		   if(!empty($_POST['ContactAcc'])){
				
			if(!empty($_POST['permission'])){
				$permission=serialize($_POST['permission']);
				$data['permission']=$permission;
				/********* By Sanjiv for MultiStore 22 Dec 2015******/
				$data['is_exclusive']=$_POST['is_exclusive'];
				/*****End By Sanjiv for MultiStore 22 Dec 2015**********/
			}
				
			if(!empty($_POST['company_userid'])) {
				$where=array('id'=>$_POST['company_userid']);
				if(!empty($_POST['ContactPassword'])) $data['password']=md5($_POST['ContactPassword']);
				$objCustomerSupplier->update('company_user',$data,$where);
			}else{
				$data['name']  = $_POST['FirstName'].' '.$_POST['LastName'];
				$data['user_name']  = $_POST['Email'];
				$data['ref_id'] = $_POST['CustID'];
				$data['comid']  = $_SESSION['CmpID'];
				$data['user_type']  = 'customerContact';
				$data['Email'] = $_POST['Email'];
				$data['password']  = (!empty($_POST['ContactPassword']))?$_POST['ContactPassword']:rand(111111, 999999);
				$Cust = $objCustomerSupplier->AddUserNewLoginDetail($data,$objAdmin);
				if($Cust['res']==2){
					$_SESSION['mess_cust'] = 'Error! This email is already in use for Login.';
					$RedirectURL = $_POST['CurrentDivision']."/editCustomer.php?edit=".$_POST['CustID'].'&tab=contacts';
					echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
					exit;
				}
			}
				
		}
		
			if(!empty($_POST['company_userid']) && empty(($_POST['ContactAcc']))) { 
				$objCustomerSupplier->deleteUserNewLoginDetail($_POST['company_userid']);
			}
		
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			unset($_POST['ContactAcc']);unset($_POST['company_userid']);
			unset($_POST['ContactPassword']);unset($_POST['permission']);
			unset($_POST['is_exclusive']);
		}
	/***************End of code sanjiv****************/
		
		if(!empty($_POST['AddID'])) {			 
			$_SESSION['mess_cust'] = ($_GET['tab']=='shipping')?CUST_ADDRESS_UPDATED:CUST_CONTACT_UPDATED;
			$AddID = $_POST['AddID'];
			$objCustomer->updateCustomerAddress($_POST,$AddID);
			
		}else{
			if($_GET['tab']=='contacts'){
				if(!$objCustomer->isCustAddressExists($_POST['CustID'],'contact')){
					$_POST['PrimaryContact']=1;
				}
				$AddType = 'contact';
			}else{
				$AddType = $_GET['tab'];
			}

			$_SESSION['mess_cust'] = ($_GET['tab']=='shipping')?CUST_ADDRESS_ADDED:CUST_CONTACT_ADDED;
			 
			$AddID = $objCustomer->addPopUpCustomerAddress($_POST,$AddType); //By Chetan 18Aug//
			
		}

		if($AddID && !empty($Cust['data']->id)){
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();

			$objCustomerSupplier->UpdateUserRefID($AddID,$Cust['data']->id);
		
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
		}
		

		//$objCustomer->updateAssignRole($_POST,$AddID);
		
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
		
//echo $_POST['CurrentDivision']; exit;
 
		 $RedirectURL = $_POST['CurrentDivision']."/editCustomer.php?edit=".$_POST['CustID'].'&tab='.$_GET['tab']; 

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
			$arryCustAddress = $objConfigure->GetDefaultArrayValue('s_address_book');
		}

	}

	require_once("includes/footer.php");  

?>
