<?
require_once("../classes/sales.customer.class.php");
require_once("../classes/supplier.class.php");
$objSupplier=new supplier();
$objCustomer=new Customer(); 

$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();  

$ArryUserEmail = $objCustomerSupplier->UserLoginCmp($_SESSION['UserName'],$_SESSION['CmpID']);	
		
/*****************/		
if(!empty($ArryUserEmail)){ // User Login Check

	$UserType = $ArryUserEmail->user_type;	
	$displayname=$objCompany->GetCompanyDisplayName($ArryUserEmail->comId);	
	if(!empty($displayname[0]['DisplayName'])){
		$arryMain = $objCompany->GetCompanyDetailDisplay($displayname[0]['DisplayName']);
	}
	
	
	$DbName2 = $Config['DbName']."_".$displayname[0]['DisplayName'];
	$Config['DbName2'] = $DbName2;		

	if(!$objConfig->connect_check()){
		$mess = ERROR_NO_DB;
	}else{	
		
		unset($mess);			
		$objConfig->dbName = $Config['DbName2'];
		$objConfig->connect();
	}	

	
	if($ArryUserEmail->id>0 && empty($mess)){ 	
 

		if($UserType=='customer')
		$arryCustomer = $objCustomer->GetCustomer($ArryUserEmail->ref_id,'','');
		elseif($UserType=='customerContact')
		$arryCustomer = $objCustomer->GetContactAddressByEmail($ArryUserEmail->user_name, $ArryUserEmail->ref_id,true);
		elseif($UserType=='vendor')	
		$arryCustomer = $objSupplier->GetSupplier($ArryUserEmail->ref_id,'','');														
		session_regenerate_id(true); 							
		$_SESSION['CompanyUserID'] = $ArryUserEmail->id; 							
		$_SESSION['UserID'] = $ArryUserEmail->ref_id; 	
		$_SESSION['UserType'] = $UserType; 		
		$_SESSION['UserName'] = $ArryUserEmail->user_name;
		$_SESSION['UserEmail'] = $ArryUserEmail->user_name;					
		$_SESSION['UserPassword'] = $ArryUserEmail->password;
		$_SESSION['UserGender'] = $ArryUserEmail->gender;
		$_SESSION['CmpID'] = $ArryUserEmail->comId;	
		$_SESSION['ref_id'] = $ArryUserEmail->ref_id;	 // This Customer_ID
		$_SESSION['UserData'] = $arryCustomer[0];


		$_SESSION['AdminID'] = $arryMain[0]['CmpID']; 
		$_SESSION['CmpID'] = $arryMain[0]['CmpID']; 
		$_SESSION['AdminType'] = $UserType; 
		$_SESSION['DisplayName'] = $arryMain[0]['DisplayName']; 		
		$_SESSION['AdminEmail'] = $arryMain[0]['Email'];				
		$_SESSION['CmpDatabase'] = $DbName2;

			
		if(!empty($ArryUserEmail->permission))
			$_SESSION['permission'] = unserialize($ArryUserEmail->permission);															
		$ValidLogin = 1;


		/*******************/	
		$Config['TodayDate'] = getLocalTime($arryMain[0]['Timezone']);		 
		/******************/

		
	}

}
/********************/  
?>
