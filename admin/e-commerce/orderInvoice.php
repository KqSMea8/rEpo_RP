<?php
          $HideNavigation = 1;

	/**************************************************/
	$ThisPageName = 'viewOrder.php';
	/**************************************************/
 	include_once("../includes/header.php");

	require_once($Prefix."classes/orders.class.php");
	require_once($Prefix."classes/variant.class.php");
	

       	  	 $objOrder=new orders();
	
                $ModuleName = 'Order';
                $ListTitle  = 'Orders';
                $ListUrl    = "viewOrder.php?curP=".$_GET['curP'];
                $Oid = isset($_GET['invoice'])?$_GET['invoice']:"";
                $Cid = isset($_GET['cid'])?$_GET['cid']:"";
                 
            if (!empty($Oid)) 
                { 
                    $arryOrderIfo = $objOrder->getOrdererInfo($Oid);
                    $arryOrderProduct = $objOrder->getOrderedProductById($Oid);
                    $arryShippingStatus = $objOrder->getShippingStatus();
                    
                    
                }
               
                
            /********Connecting to main database*********/
                $Config['DbName'] = $Config['DbMain'];
                $objConfig->dbName = $Config['DbName'];
                $objConfig->connect();
                /*******************************************/        
             $arryCompanyDetail = $objCompany->GetCompanyDetail($_SESSION['CmpID']);

 require_once("../includes/footer.php"); 
 
 
 ?>
