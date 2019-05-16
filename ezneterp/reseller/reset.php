<?php  
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'Reset Password '; $EditPage = 1;
/**************************************************************/
IsCrmSession();
$FancyBox = 0;
include ('includes/header.php');

	//require_once("../../classes/company.class.php");
       	require_once($Prefix."classes/rsl.class.php");

	$objReseller=new rs();
	//$objCompany=new company();
        
	if($_POST) { 

		if (empty($_POST['Email'])) {
			$_SESSION['mess_reset'] = ENTER_EMAIL;
		} else{
			$Email = mysql_real_escape_string($_POST['Email']); 

			$ArryUserEmail = $objReseller->CheckResellerEmail($Email); 

			$CmpID = mysql_real_escape_string($ArryUserEmail[0]['RsID']); 
	                

			if(empty($mess) && $CmpID>0){  // Admin 
                            
                              $status=$objReseller->IsActive($CmpID);
                              if($status[0]['status']==0)
                              {
                                 $objReseller->SendActivationMail($CmpID);
                                 $_SESSION['mess_reset']='Email sent, Please check your email';
                                  
                              }else {
                                  
                                  $_SESSION['mess_reset']='You are already activated';
                              }
                              

					
			}else{
				$_SESSION['mess_reset'] = INVALID_EMAIL; 
			}

		}

		
	}

include ('includes/footer.php');
 ?>
