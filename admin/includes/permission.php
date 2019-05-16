<?  
	$Config['FullPermission'] = $Config['vAllRecord'] = '';
	(empty($_SESSION['vAllRecord']))?($_SESSION['vAllRecord']=""):("");

	(empty($FullAcessLabel))?($FullAcessLabel=""):("");

	/****************************/	
	if($_SESSION['AdminType'] == "admin"){
		$Config['vAllRecord'] = 1;
		$_SESSION['vAllRecord'] = 1;

		$Config['FullPermission'] = 1;
	}else{
		if($HideNavigation=='1'){
			$Config['vAllRecord'] = 1;		
		}else{
			$_SESSION['vAllRecord'] = '';	
		}

		if($_SESSION['AdminType'] == "employee" && $Config['CurrentDepID']>0) { 
			$arrayDeptModules = $objConfig->getMainModulesUser('',0,$Config['CurrentDepID']);
			//echo sizeof($arryMainMenu) .'=='. sizeof($arrayDeptModules);
			
		}



	}
 
	/*****Company Department Not Allowed********/
	if($HideNavigation!=1 && $CurrentDepID>0 && !empty($Config['CmpDepartment']) && substr_count($Config['CmpDepartment'],$CurrentDepID)==0){ 
		header('location: ../dashboard.php');
		exit;
	}

	/******Sessiion Timeout*********/

	if($arryCompany[0]['SessionTimeout']>0){
		session_cache_expire(20);
		$_SESSION['SessionTimeout'] = $arryCompany[0]['SessionTimeout'];
		$inactive = $arryCompany[0]['SessionTimeout']; //second
		if(isset($_SESSION['start']) ) {
			$session_life = time() - $_SESSION['start'];
			if($session_life > $inactive){	//deactivate this code, working from header popup
				/*unset($_SESSION['AdminID']);
				if (isset($_SERVER['QUERY_STRING'])){
					$ThisPage .= "?" . htmlentities($_SERVER['QUERY_STRING']);
					$ThisPage = str_replace("&amp;",",",$ThisPage);
				}			
				ValidateAdminSession($ThisPage);*/
			}
		}
		$_SESSION['start'] = time();
	}else{
		$_SESSION['SessionTimeout'] = 7200;
	}
	/*******************************/


	if($_SESSION['AdminType']=="employee" && $ThisPageName!='dashboard.php' && $ThisPageName!='home.php' && $ThisPageName!='workspace.php'  && $SecurityPage!='1' && ($HideNavigation!='1'  || $EditPage==1) && !in_array($ModuleParentID,$AllowedModules)){
	

				if(!empty($RoleGroupUserId)){
					$arryPermitted = $objConfig->isModulePermittedRoleGroup($MainModuleID,$RoleGroupUserId);
 
					$permittedID=(!empty($arryPermitted[0]['GroupID']))?($arryPermitted[0]['GroupID']):('');
				}else{
					$arryPermitted = $objConfig->isModulePermittedUser($MainModuleID,$_SESSION['UserID']);
					$permittedID=(!empty($arryPermitted[0]['UserID']))?($arryPermitted[0]['UserID']):('');
 
				}
		 

				if(!empty($arryPermitted[0]['FullLabel'])){
					/*****************/					
					$ModifyLabel = 1; 
					$ApproveLabel = 1;
					$DeleteLabel = 1;
					$AssignLabel=1;	
					$ViewAllLabel=1;	

					$FullAcessLabel = $arryPermitted[0]['FullLabel']; 
					
					 
					$Config['vAllRecord'] = 1;
					$_SESSION['vAllRecord'] = 1;
					 					
					/*****************/				
				}else{
					/*****************/

					$ApproveLabel=(!empty($arryPermitted[0]['ApproveLabel']))?($arryPermitted[0]['ApproveLabel']):('');
					$ModifyLabel=(!empty($arryPermitted[0]['EditLabel']))?($arryPermitted[0]['EditLabel']):('');
					$DeleteLabel=(!empty($arryPermitted[0]['DeleteLabel']))?($arryPermitted[0]['DeleteLabel']):('');
					$AssignLabel=(!empty($arryPermitted[0]['AssignLabel']))?($arryPermitted[0]['AssignLabel']):('');
					$ViewAllLabel=(!empty($arryPermitted[0]['ViewAllLabel']))?($arryPermitted[0]['ViewAllLabel']):('');

 
 
 
					if($ViewAllLabel==1){
						$Config['vAllRecord'] = 1;
						$_SESSION['vAllRecord'] = 1;
					}


					if($EditPage == 1){
						if($_GET['edit'] !=''){					
							if($arryPermitted[0]['EditLabel'] !=1){
								$NotAllowed = 1;
							}
						}elseif($_GET['del_id'] !=''){							
						    	if($arryPermitted[0]['DeleteLabel'] !=1){
								$NotAllowed = 1;
							}
						}elseif($_GET['active_id'] !=''){						
						    	if($arryPermitted[0]['ApproveLabel'] !=1){
								$NotAllowed = 1;
							}
						}else{						
						    if($arryPermitted[0]['AddLabel'] !=1){
								$NotAllowed = 1;
						    }
					   	}
						
					   } 
					/*****************/					
				}




				if(empty($permittedID)) {
					$NotAllowed = 1;
				}
		 }


		/*if($_SESSION['AdminType']=="employee" && $EditPage==1 && $ModifyLabel!=1){ 
			$NotAllowed =1;
		}*/


		if($_SESSION['AdminType'] == "admin" && $DefaultModule==1) {
			if($ModuleParentID!='195') $NotAllowed =1;
		}else if($DefaultModule==1){
			$ModifyLabel = 1;
		}


		if(!empty($arrayModuleID[0]['ModuleID'])){
			if($ModuleParentID>0 && $arrayModuleID[0]['ParentStatus']=='0'){  
				$NotAllowed =1;
			}
			if($ThisPageName=='CreateFolder.php'){
						$NotAllowed = 0;
			}


			if($arrayModuleID[0]['RestrictedParent']=='1'){
				echo '<div align="center" class="redmsg" style="padding-top:200px;">'.ERROR_RESTRICTED_MODULE.'</div>';
				exit;
			}
		}



		



		if($NotAllowed == 1){  
			echo '<div align="center" class="redmsg" style="padding-top:200px;">'.ERROR_NOT_AUTH.'</div>';
			exit;
		}

		if($_SESSION['AdminType'] == "admin") {
			$ModifyLabel=1;	
			$ApproveLabel=1;
			$DeleteLabel=1;	
			$AssignLabel=1;	
			$ViewAllLabel=1;	
		}


//echo $Config['vAllRecord'].' : '.$_SESSION['vAllRecord']; 
?>
