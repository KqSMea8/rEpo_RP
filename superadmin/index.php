<?php 	$LoginPage=1;
	
	 die;

	if(substr_count($_SERVER['HTTP_HOST'],"www.")!=1){
		$url_red =  'http://www.eznetcrm.com/erp/sa/';
		Header( "HTTP/1.1 301 Moved Permanently" );
		header("Location: ".$url_red);
		exit;
	}

	require_once("includes/header.php");

	$objConfig = new admin();
	$mess='';
	$ValidLogin = 0;
	if(empty($_SESSION['login_attempt'])) $_SESSION['login_attempt']='';

	if (!empty($_POST['LoginEmail'])) {
		CleanPost();
		if (empty($_POST['LoginEmail'])) {
			$mess = ENTER_EMAIL;
		}elseif (empty($_POST['LoginPassword'])) {
			$mess = ENTER_PASSWORD;
		} else{
			$ArryAdmin = $objConfig->ValidateAdmin($_POST['LoginEmail'], $_POST['LoginPassword']);
			
			if(md5($_POST['LoginPassword']) != @$ArryAdmin[0]['Password']){
				$mess = INVALID_EMAIL_PASSWORD;
			}else{

				if($ArryAdmin[0]['AdminID']>0){
					$objConfig->RemoveBlock(1);
					session_regenerate_id(true); 
					$_SESSION['SuperAdminID'] = $ArryAdmin[0]['AdminID']; 
					$_SESSION['AdminID'] = $ArryAdmin[0]['AdminID']; 
					$_SESSION['UserName'] = $ArryAdmin[0]['Name'];
					$_SESSION['AdminEmail'] = $ArryAdmin[0]['AdminEmail'];					
					$_SESSION['AdminPassword'] = $ArryAdmin[0]['Password'];			
					$_SESSION['AdminType'] = "admin";
					$ValidLogin = 1;
					if(!empty($_POST['ContinueUrl'])){
								$_POST['ContinueUrl'] = str_replace(",","&",$_POST['ContinueUrl']);

					
						echo '<script>location.href="'.$_POST['ContinueUrl'].'";</script>';
						exit;
					}else{
						echo '<script>location.href="dashboard.php";</script>';
						exit;
					}
				}
				
				
			}

			/***************************/				
			if($ValidLogin != 1){	
				$objUser = new Suser();			
				$ArryUser= $objUser->ValidateUser($_POST['LoginEmail'], $_POST['LoginPassword']);

				if(!empty($ArryUser[0]['Uid']))
				{
					$objConfig->RemoveBlock(1);
					session_regenerate_id(true); 	     
					$_SESSION['AdminType']="user";
					$_SESSION['SuperAdminID'] = $ArryUser[0]['Uid']; 
					$_SESSION['AdminID'] = $ArryUser[0]['Uid'];
					$_SESSION['UserName'] = $ArryUser[0]['FirstName'].' '.$ArryUser[0]['LastName'];
					$_SESSION['AdminEmail'] = $ArryUser[0]['uEmail'];					
					$_SESSION['AdminPassword'] = $ArryUser[0]['upassword'];			
	       		
					echo '<script>location.href="dashboard.php";</script>';
					exit;
				
				}
			}
			/**************************/

			$mess = INVALID_EMAIL_PASSWORD;
			$_SESSION['login_attempt']++;
			if($_SESSION['login_attempt']>=5){
				$objConfig->AddBlockLogin(1);
			}
		


			
		}

	}else{
		unset($_SESSION);
		session_destroy();	
		ob_end_flush();		
	}


	/********************/
	
	if(empty($ErrorMsg)){
		if($objConfig->CheckBlockLogin(1)){
			$ErrorMsg = BLOCKED_MSG;
			unset($_SESSION['login_attempt']);
		}
	}


	require_once("includes/footer.php");
 ?>
