<?php
	/**************************************************/
	$ThisPageName = 'viewTax.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");

	require_once($Prefix."classes/cartsettings.class.php");
        require_once($Prefix."classes/customer.class.php");
	
	$objcartsettings=new Cartsettings();

                 $TaxId = isset($_GET['edit'])?$_GET['edit']:"";	
                  if (!empty($TaxId)) {$ModuleTitle = "Edit Tax";}else{$ModuleTitle = "Add Tax";}
                        $ModuleName = 'Tax';
                        $ListTitle  = 'Tax';
                        $ListUrl    = "viewTax.php?curP=".$_GET['curP'];
                      
                        
                    $arryTaxClasses =$objcartsettings->getClasses();
                    

			
		 	 
              if(!empty($_GET['active_id'])){
		$_SESSION['mess_tax'] = $ModuleName.STATUS;
		$objcartsettings->changeTaxStatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
		exit;
	 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_tax'] = $ModuleName.REMOVED;
                                $objcartsettings->deleteTax($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		

		 
		 if ($_POST) {
		
                                            if (!empty($TaxId)) {
                                                    $_SESSION['mess_tax'] = $ModuleName.UPDATED;
                                                    $objcartsettings->updateTax($_POST);
                                                    header("location:".$ListUrl);
						    exit;
                                            } else {		
                                                    $_SESSION['mess_tax'] = $ModuleName.ADDED;
                                                    $lastShipId = $objcartsettings->addTax($_POST);	
                                                   header("location:".$ListUrl);
						   exit;
                                            }
			
		}
		
$TaxStatus = "Yes";
$arrayUserLevelID=array();
	if (!empty($TaxId)) 
                    {
                        $arryTax = $objcartsettings->getTaxById($TaxId);
                         $UserLevelID = $arryTax[0]['UserLevel'];
                         $UserLevelID = explode(",",$UserLevelID);
                        foreach($UserLevelID as $useLevel)
                        {
                            $arrayUserLevelID[] = $useLevel;
                        }
			if($arryTax[0]['Status'] == "No"){
			$TaxStatus = "No";
			}else{
				$TaxStatus = "Yes";
			}
		   $Userlevel =  $arryTax[0]['UserLevel'];
		if(!empty($Userlevel)){
                   $UserlevelExp = explode(",",$Userlevel);
                   $SimpleUser = $UserlevelExp[0];
                   $Wholesalers = $UserlevelExp[1];
		}		

                    }
	
		
		
                
                           
                
                              

    $objCustomer = new Customer();
    $arryCustomerGroups =$objCustomer->getCustomerGroups();

 require_once("../includes/footer.php"); 
 
 
 ?>
