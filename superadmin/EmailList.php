<?php 
	include_once("includes/header.php");
	require_once("../classes/configure.class.php");
    require_once("../classes/dbfunction.class.php");
    require_once("../classes/company.class.php");
	require_once("../classes/emaillist.class.php");
    require_once("../classes/sales.customer.class.php");
    require_once("../classes/vendor.class.php");
	$ModuleName = "emaillist";
	$RedirectUrl = "EmailList.php?curP=".$_GET['curP'];
	$objemaillist = new emaillist();
       $objCompany=new company();
     
    $arryCompany = $objCompany->GetCompany('','');
       //echo "<pre>";print_r($arryCompany);die;
   $objCustomer = new Customer();
    
    $objvendor = new vendor(); 	 		
			       
				
        $emaillisting = $objemaillist->Listemail($_GET);
     // echo "<pre>";print_r($emaillisting);
        $CmpDatabase = $Config['DbMain']."_".$arryCompany[3]['DisplayName'];
				 //$CmpDatabase = $Config['DbMain'];
				 $Config['DbName'] = $CmpDatabase;	
				 $objConfig->dbName = $Config['DbName'];
				 $objConfig->connect();
				
					$_GET['CmpID']= $arryCompany[3]['CmpID'];
					
		if( !empty($_GET['email'])){	
				 
   // for($i=0;$i<sizeof($emaillisting);$i++){  
    	
    	//echo "<pre>";print_r($emaillisting[$i]['Email']);die;
    	
    	if($_GET['type']=='customer'){
    	    		//echo "hello<br>";die;
    		$objemaillist->RemoveCustomer($_GET['email'],$_GET['type']);
    		 $_SESSION['mess_email'] =EMAIL_REMOVED;
			   header("location:".$RedirectUrl);
	      exit;
                  		
    }elseif($_GET['type']=='vendor'){ 
       	
       	 $objemaillist->RemoveVendor($_GET['email'],$_GET['type']);
       	  $_SESSION['mess_email'] =EMAIL_REMOVED;
			   header("location:".$RedirectUrl);
	       exit;
       	 
    }else{ echo "user";die;
    	 $objemaillist->deleteEmail($_GET['email'],$_GET['type']);
    	 $_SESSION['mess_email'] =EMAIL_REMOVED;
			   header("location:".$RedirectUrl);
	      exit;
      }
    //}// end foreach
		}
       $CmpDatabase = $Config['DbMain'];
				$Config['DbName'] = $CmpDatabase;
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				
			
				 
	$num =count($emaillisting);
	$pagerLink=$objPager->getPager($emaillisting,$RecordsPerPage,$_GET['curP']);
	(count($emaillisting)>0)?($emaillisting=$objPager->getPageRecords()):("");

    
	require_once("includes/footer.php"); 

?>


