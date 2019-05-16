<?  
	/*****Company Department Not Allowed********/
	if($HideNavigation!=1 && $CurrentDepID>0 && !empty($Config['CmpDepartment']) && substr_count($Config['CmpDepartment'],$CurrentDepID)==0){
		header('location: ../dashboard.php');
		exit;
	}

	/******Sessiion Timeout*********/

	if($arryCompany[0]['SessionTimeout']>0){
		session_cache_expire(20);
		$inactive = $arryCompany[0]['SessionTimeout']; //second
		if(isset($_SESSION['start']) ) {
			$session_life = time() - $_SESSION['start'];
			if($session_life > $inactive){	
				unset($_SESSION['AdminID']);
				if (isset($_SERVER['QUERY_STRING'])){
					$ThisPage .= "?" . htmlentities($_SERVER['QUERY_STRING']);
					$ThisPage = str_replace("&amp;",",",$ThisPage);
				}			
				ValidateAdminSession($ThisPage);
			}
		}
		$_SESSION['start'] = time();
	}
	/*******************************/


	if($_SESSION['AdminType']=="employee" && $ThisPageName!='dashboard.php' && $ThisPageName!='home.php' && ($HideNavigation!='1' || $EditPage==1) && !in_array($ModuleParentID,$AllowedModules)){
	
				$arryPermitted = $objConfig->isModulePermittedUser($ModuleParentID,$_SESSION['UserID']);

				if($arryPermitted[0]['ModifyLabel']==1 || $arryPermitted[0]['FullLabel']==1){
					/*****************/
					/*****************/
					$ModifyLabel = 1; 
					$FullAcessLabel = $arryPermitted[0]['FullLabel']; 
					/*****************/
					/*****************/
				}
				if(empty($arryPermitted[0]['UserID'])) {
					$NotAllowed = 1;
				}
		 }


		if($_SESSION['AdminType']=="employee" && $EditPage==1 && $ModifyLabel!=1){ 
			$NotAllowed =1;
		}


		if($_SESSION['AdminType'] == "admin" && $DefaultModule==1) {
			$NotAllowed =1;
		}

		if($ModuleParentID>0 && $arrayModuleID[0]['ParentStatus']=='0'){
			$NotAllowed =1;
		}

		
		if($NotAllowed == 1){
			echo '<div align="center" class="redmsg" style="padding-top:200px;">'.ERROR_NOT_AUTH.'</div>';
			exit;
		}

		if($_SESSION['AdminType'] == "admin") {
			$ModifyLabel=1;
		}

?>
