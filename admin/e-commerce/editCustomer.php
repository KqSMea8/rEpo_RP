<?php
	/**************************************************/
	$ThisPageName = 'viewCustomer.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");

	require_once($Prefix."classes/customer.class.php");
	/********Added by karishma for dealer on 6 oct 2016********/
	require_once($Prefix."classes/dealer.class.php");
	/********End by karishma for dealer on 6 oct 2016********/
        
               	   $objCustomer=new Customer();
                        
            
                       $CustId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";	
                       $ListUrl = "viewCustomer.php?curP=".$_GET['curP'];
                       $ListTitle = "Customers";
                       $ModuleTitle = "Edit Customer";
                       $ModuleName = "Customer";
                        if(!empty($CustId)){
                           $arryCustomer = $objCustomer->getCustomerById($CustId);
                        }
                        /********Added by karishma for dealer on 6 oct 2016********/
                        if($_SESSION['companyType']=='dealer'){
				$Categories=$objDealer->getCategories();
			}
			/********End by karishma for dealer on 6 oct 2016********/

	 if(!empty($_GET['del_id'])){
           
                                $_SESSION['mess_cust'] = $ModuleName.REMOVED;
                                $objCustomer->deleteCustomer($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
        
         if(!empty($_GET['active_id'])){
		$_SESSION['mess_cust'] = $ModuleName.STATUS;
		$objCustomer->changeCustomerStatus($_REQUEST['active_id']);
		/********Added by karishma for dealer on 6 oct 2016********/
		if($_SESSION['companyType']=='dealer' && $_REQUEST['custType']=='posdealer'){
		$objCustomer->addCompanyUser($_REQUEST['active_id']);
		}
		/********End by karishma for dealer on 6 oct 2016********/
		header("location:".$ListUrl);
	}
	
		


 	if (is_object($objCustomer)) {	
		 
                    if ($_POST) {

                               if (!empty($CustId)) {
                                       $_SESSION['mess_cust'] = $ModuleName.UPDATED;
                                       $objCustomer->updateCustomer($_POST);
                                        /********Added by karishma for dealer on 6 oct 2016********/
                                       if($_SESSION['companyType']=='dealer'){
						$objDealer->creditDebitWallet($_POST);
					}
					 /********End by karishma for dealer on 6 oct 2016********/
                                       header("location:".$ListUrl);
                               } 

                               exit;

                   }
	 
		 
        }

    $arryCustomerGroups =$objCustomer->getCustomerGroups();
		

 require_once("../includes/footer.php"); 
 
 
 ?>
