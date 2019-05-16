<?php
	/**************************************************/
	$ThisPageName = 'viewTaxClass.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");

	require_once($Prefix."classes/cartsettings.class.php");
	
	$objcartsettings=new Cartsettings();

                 $TaxClassId = isset($_GET['edit'])?$_GET['edit']:"";	
                  if (!empty($TaxClassId)) {$ModuleTitle = "Edit Tax Class";}else{$ModuleTitle = "Add Tax Class";}
                        $ModuleName = 'Tax Class';
                        $ListTitle  = 'Tax Classes';
                        $ListUrl    = "viewTaxClass.php?curP=".$_GET['curP'];
                      

			
		 	 
                if(!empty($_GET['active_id'])){
		$_SESSION['mess_taxclass'] = $ModuleName.STATUS;
		$objcartsettings->changeTaxClassStatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
		exit;
	 }
	

	 if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_taxclass'] = $ModuleName.REMOVED;
                                $objcartsettings->deleteTaxClass($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	}
		
		 
		 if ($_POST) {
		
                                            if (!empty($TaxClassId)) {
                                                    $_SESSION['mess_taxclass'] = $ModuleName.UPDATED;
                                                    $objcartsettings->updateTaxClass($_POST);
                                                    header("location:".$ListUrl);
						    exit;
                                            } else {		
                                                    $_SESSION['mess_taxclass'] = $ModuleName.ADDED;
                                                    $lastShipId = $objcartsettings->addTaxClass($_POST);	
                                                   header("location:".$ListUrl);
						   exit;
                                            }

			
		}
		

	$TaxClassStatus = "Yes";
		   if (!empty($TaxClassId)) 
                    {
                        $arryTaxClass = $objcartsettings->getTaxClassById($TaxClassId);
			if($arryTaxClass[0]['Status'] == "No"){
			$TaxClassStatus = "No";
			}else{
				$TaxClassStatus = "Yes";
			}
                    }
		
		
                
                              




 require_once("../includes/footer.php"); 
 
 
 ?>
