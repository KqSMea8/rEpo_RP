<?
/**************/
if(!isset($_SESSION['SecurityValidated'])) $_SESSION['SecurityValidated']='';
$EnableSecurity = 0;
 $ToolColor= '#000000';
 if(!empty($arryCompany[0]['AllowSecurity'])){	
	$CompanySecurityAllow = $arryCompany[0]['AllowSecurity'];
	
	/*****Optional AllowSecurityUser**********/
	$SecuritySuperArray = explode(",",$CompanySecurityAllow);	
	if($arryCompany[0]['SecurityLevel'] == "2"){ 
		if($_SESSION['AdminType'] == "admin"){ 
			$CompanySecurityAllow = $arryCompany[0]['AllowSecurityUser'];
		}else{
			$CompanySecurityAllow = $ArryEmployeeBasic[0]['AllowSecurityUser'];
		}
		$SecurityUserArray = explode(",",$CompanySecurityAllow);
		foreach($SecuritySuperArray as $valsecurity){
			if(in_array($valsecurity,$SecurityUserArray)){
				$arrySecTemp[] = $valsecurity;
			}
		}
		$CompanySecurityAllow = implode(",",$arrySecTemp);
	}
	/*********************/


	/*****Trim Security question for admin********
	if($_SESSION['AdminType'] != "employee"){
		$SecArray = explode(",",$CompanySecurityAllow);
		 
		if($SecArray[0]==1){			
			    unset($SecArray[0]);			
		}
		$CompanySecurityAllow = implode(",",$SecArray);
	}
	/*************/
	
	$SecurityArray = explode(",",$CompanySecurityAllow);	
	$NumSecurity =   sizeof($SecurityArray);

	if(!empty($SecurityArray[0]) || !empty($SecuritySuperArray[0])){
			
		$SecurityPageUrl = "security".$SecurityArray[0].'.php';
		$allowpages=array('index.php', 'logout.php', 'chPassword.php');
  
		if($SecurityPage!='1' && !in_array($ThisPageName,$allowpages)){
 
			/******UserSecurity Check***********/
			if($arryCompany[0]['SecurityLevel'] == "1"){
				$EnableSecurity = 1;
			}else if($_SESSION['AdminType'] == "admin" && $arryCompany[0]['SecurityLevel'] == "2"  && $arryCompany[0]['UserSecurity'] == "1"){
			 	$EnableSecurity = 1;
			}else if($_SESSION['AdminType'] == "employee" && $arryCompany[0]['SecurityLevel'] == "2"  && $ArryEmployeeBasic[0]['UserSecurity'] == "1"){
				$EnableSecurity = 1;
			}
 
			/**********************************/
			if(!empty($EnableSecurity)){
				$enableDisable = "disable"; $TwoStepStatus = 'On'; $ToolColor= '#006400';

				if($_SESSION['SecurityValidated']==$CompanySecurityAllow){ 
					//validated sucessfully
					$SecurityValidated=1;	
				}else if(!empty($SecurityArray[0])){
					unset($_SESSION['SecurityValidated']);	
					header("location: ".$MainPrefix.$SecurityPageUrl);
					exit;					 
				}

			}else{
				$enableDisable = "enable"; $TwoStepStatus = 'Off'; $ToolColor= '#D40503';
			}
			$EnableSecurityTitle = '2-Step Authentication';//ucfirst($enableDisable).
			$TwoStepStatus = '2-Step Authentication is '.$TwoStepStatus;

		}
	}
}
/****************/


?>
