
<?php
	$HideNavigation = 1;
	require_once("includes/header.php");
        require_once("../classes/company.class.php");
        require_once("../classes/cmp.class.php");
         
        $objCompany=new company();
        $objCmp=new cmp();
        
        $CmpId=$_GET['CmpId'];
        if(!empty($CmpId))
        {
        $compDetail=$objCmp->getCompanyById($CmpId);
        
         if(!empty($compDetail[0]['Email']))
          {
	 if ($_POST) {
		
		if (empty($_POST['Email'])) {
			$_SESSION['mess_conf'] = ENTER_EMAIL;
		} else{
			$Email = mysql_real_escape_string($_POST['Email']); 

			$ArryUserEmail = $objConfig->CheckUserEmail($Email); 
                        
                   
			$CmpID = mysql_real_escape_string($ArryUserEmail[0]['CmpID']); 
	                

			if(empty($mess) && $CmpID>0){  // Admin 
                            
                              $status=$objCmp->IsActive($CmpID);
                              if($status[0]['status']==0)
                              {
                                 $objCmp->SendActivationMail($CmpID);
                                 $_SESSION['mess_conf']='Activation email has been send successfully.';
                                  
                              }else {
                                  
                                  $_SESSION['mess_conf']='This email is already activated.';
                              }
                              

					
			}else{
				$_SESSION['mess_conf'] = INVALID_EMAIL; 
			}

		}


		header("location: resendActivationEmail.php?CmpId=".$CmpId);
		exit;
		
	}
        
        } 
        else 
          {
             header("location: viewCompany.php");
	     exit; 
        }
        
        }else {
            
             header("location: viewCompany.php");
		exit; 
        }

	require_once("includes/footer.php"); 
 ?>
