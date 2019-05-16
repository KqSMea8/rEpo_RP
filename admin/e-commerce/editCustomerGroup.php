<?php
	/**************************************************/
	$ThisPageName = 'viewCustomerGroup.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");

	require_once($Prefix."classes/customer.class.php");
	
	$objCustomer = new Customer();

                 $customerGroupID = isset($_GET['edit'])?$_GET['edit']:"";	
                  if (!empty($customerGroupID)) {$ModuleTitle = "Edit Customer Group";}else{$ModuleTitle = "Add New Customer Group";}
                        $ModuleName = 'Customer Group';
                        $ListTitle  = 'Customer Group';
                        $ListUrl    = "viewCustomerGroup.php?curP=".$_GET['curP'];
                       
                
                 
			
		 	 
                  if(!empty($_GET['active_id'])){
                        $_SESSION['mess_customer_group'] = $ModuleName.STATUS;
                        $objCustomer->changeCustomerGroupStatus($_REQUEST['active_id']);
                        header("location:".$ListUrl);
			exit;
                 }
	

                if(!empty($_GET['del_id'])){

                               $_SESSION['mess_customer_group'] = $ModuleName.REMOVED;
                               $objCustomer->deleteCustomerGroup($_GET['del_id']);
                               header("location:".$ListUrl);
                               exit;
                }
		

	
		 
		 if ($_POST) {
		
                        if (!empty($customerGroupID)) {
                                $_SESSION['mess_customer_group'] = $ModuleName.UPDATED;
                                $objCustomer->updateCustomerGroup($_POST);
                                header("location:".$ListUrl);
                        } else {		
                                $_SESSION['mess_customer_group'] = $ModuleName.ADDED;
                                $lastShipId = $objCustomer->addCustomerGroup($_POST);	
                                header("location:".$ListUrl);
                        }

                          exit;
			
		}
		

		   $CustomerGroupStatus = "Yes";
		   if (!empty($customerGroupID)) 
                    {
                        $arryCustomerGroup = $objCustomer->getCustomerGroupById($customerGroupID);
				
			if($arryCustomerGroup[0]['Status'] == "No"){
				$CustomerGroupStatus = "No";
			}else{
				$CustomerGroupStatus = "Yes";
			}
                
                    }



		
                              



 require_once("../includes/footer.php"); 
 
 
 ?>
