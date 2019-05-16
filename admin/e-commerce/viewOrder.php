<?php 
 	include_once("../includes/header.php");
	require_once($Prefix."classes/orders.class.php");
        require_once($Prefix . "classes/filter.class.php");
$objFilter = new filter();
$_GET['module']='EcomOrder';
         $objOrder=new orders();

         /*------------- Amazon order by Sanjiv ----------------------*/
  		require_once($Prefix."classes/product.class.php");
	    $objProduct=new product();
  	   if($_GET['synctype'] == 'sync_amazon'){
	      $objProduct->runAmazonOrder($objRegion,$Prefix);
	      $objProduct->runReportForFees($Prefix);
				header("location:viewOrder.php?curP=".$_GET['curP']);
        exit;
  	   }
  	   
  	  if($_GET['synctype'] == 'sync_ebay'){
	      require_once($Prefix."classes/item.class.php");
	      $objProduct->EbayImportOrders($objRegion,$Prefix);
				header("location:viewOrder.php?curP=".$_GET['curP']);
        exit;
  	   }
	   
	   
	  if($_GET['synctype'] == 'sync_magento'){
		  //echo  "<pre>";print_r($_SESSION);die;
		  
		  if($_SESSION['CmpDatabase']="erp_DemoVstacks"){
				  require_once($Prefix."classes/mgt.class.php");
				  $objMgt = new mgt();
				  $objMgt->MagentoImportOrders();
				  $_SESSION['mess_order'] = "Magento Order  sync successfully. ";
		     }else{
				 $_SESSION['mess_order'] = "Error: Setting not update for magento.";
			 }
			header("location:viewOrder.php?curP=".$_GET['curP']);
        exit;
  	   }
	   

	if($_GET['customEOID'] >0 ){
  	   		CleanGet();
  	   		//if(empty($_GET['OrderStatus'])) $_GET['OrderStatus'] = 'Active';
	  	   $objProduct->CreateCustomAmazonSaleOrder($_GET['customEOID'],$_GET['CustID'],$_GET['CustomerPO']);
  	   		header("location:viewOrder.php?curP=".$_GET['curP']);
        	exit;
  	   }
	   
	   
       /*------------------- End -------------------------------*/

				$RowColor =isset($_GET['RowColor'])?$_GET['RowColor']:"";
				$Config['RowColor'] = $RowColor;
        $_GET['OrderID'] = $OrderID = isset($_GET['OrderID'])?$_GET['OrderID']:"";
        $_GET['OrderStatus'] = $OrderStatus = isset($_GET['OrderStatus'])?$_GET['OrderStatus']:"";
        $_GET['PaymentStatus'] = $PaymentStatus = isset($_GET['PaymentStatus'])?$_GET['PaymentStatus']:"";
        $_GET['CustomerName'] = $CustomerName = isset($_GET['CustomerName'])?$_GET['CustomerName']:"";
        $_GET['OrderPeriod'] =$OrderPeriod = isset($_GET['OrderPeriod'])?$_GET['OrderPeriod']:"";

/*********************Set Defult ************/

if (!empty($_GET['del_id']) && $_GET['Approve']==1) {
    $objFilter->deleteFilter($_GET['del_id']);
    header("location:viewOrder.php");
    exit;
}


$arryDefult = $objFilter->getDefultView($_GET['module']);

if(!empty($arryDefult[0]['setdefault']) && empty($_GET['customview']) ){ 
    
  $_GET['customview']=  $arryDefult[0]['cvid']; 
    
}elseif($_GET['customview'] != "All" && $_GET['customview'] >0){
    
    $_GET['customview'] = $_GET['customview'];
    
}else{
    
  $_GET["customview"] = 'All';  
}

if (!empty($_GET["customview"]) && $_GET["customview"]!='All' ) {
    $arryfilter = $objFilter->getCustomView($_GET["customview"], $_GET['module']);

    $arryColVal = $objFilter->getColumnsListByCvid($_GET["customview"], $_GET['module']);


    $arryQuery = $objFilter->getFileter($_GET["customview"]);
//added by bhoodev
 foreach ($arryColVal as $key => $Col) { 
$columnname .= 'l.'.$Col['colvalue'].',';
}

    if (!empty($arryColVal)) {
	$colRul = $colValue='';

        foreach ($arryColVal as $colVal) {
            $colValue .= $colVal['colvalue'] . ",";
        }
        $colValue = rtrim($colValue, ",");

        foreach ($arryQuery as $colRul) {
            
             //CODE EDIT FOR DECODE
            
                   // if($colRul['columnname'] == 'AnnualRevenue')
                     // {
                          //$colRul['columnname'] = "DECODE(l.AnnualRevenue,'". $Config['EncryptKey']."')";


                      //}

                     // else{
                           
                          $colRul['columnname'] = 'o.'.$colRul['columnname'];

                      //}
            
             //END CODE DECODE

            if ($colRul['comparator'] == 'e') {
                //if ($colRul['columnname'] == 'l.AssignTo'  || $colRul['columnname'] == 'l.JoiningDate') {
                    //$comparator = 'like';
                    //$colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                //} else {
                    $comparator = '=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                //}
            }

            if ($colRul['comparator'] == 'n') {

               // $comparator = '!=';
                //if ($colRul['columnname'] == 'AssignTo') {
                    //$comparator = 'not like';
                    //$colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '%" . mysql_real_escape_string($colRul['value']) . "%'   ";
                //} else {
                    $comparator = '!=';
                    $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
                //}
               
            }





            if ($colRul['comparator'] == 'l') {
                $comparator = '<';

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'g') {
                $comparator = '>';

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " '" . mysql_real_escape_string($colRul['value']) . "'   ";
            }
            if ($colRul['comparator'] == 'in') {
                $comparator = 'in';

                $arrVal = explode(",", $colRul['value']);

                $FinalVal = '';
                foreach ($arrVal as $tempVal) {
                    $FinalVal .= "'" . trim($tempVal) . "',";
                }
                $FinalVal = rtrim($FinalVal, ",");
                $setValue = trim($FinalVal);

                $colRule .= $colRul['column_condition'] . " " . $colRul['columnname'] . " " . $comparator . " (" . $setValue . " ) ";
            }
        }
        $colRule = rtrim($colRule, "  and");


      
    }
}





        
          

$Config['RecordsPerPage'] = $RecordsPerPage;
//By rajan 23Dec//
$Config['Col'] = $columnname;
//$Config['tab']  = ($_GET['tab']!='') ? $_GET['tab'] :'';
//$Config['rows'] = ($_GET['rows']!='') ? $_GET['rows'] :''; //By chetan 25dec//
$Config['rule'] = $colRule;
$arrayOrders = $objOrder->ListOrders($_GET);
//End//
$Config['GetNumRecords'] = 1;
$arryCount=$objOrder->ListOrders($_GET);
$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);


          //$num=$objOrder->numRows();
          
           $ModuleName = 'Order';
           $ListTitle  = 'Orders';
           $ListUrl    = "viewOrder.php?curP=".$_GET['curP'];
          
          //Delete Order
           if(!empty($_GET['del_id']) && $_GET['Approve']!=1){
                $_SESSION['mess_order'] = $ModuleName.REMOVED;
                $objOrder->deleteOrder($_GET['del_id']);
                header("location:".$ListUrl);
                exit;
	}


/***********************/
          
           $ModuleName = 'Order';
           $ListTitle  = 'Orders';
           $ListUrl    = "viewOrder.php?curP=".$_GET['curP'];
          
          //Delete Order
           if(!empty($_GET['del_id'])){
                $_SESSION['mess_order'] = $ModuleName.REMOVED;
                $objOrder->deleteOrder($_GET['del_id']);
                header("location:".$ListUrl);
                exit;
	}


/***********************/
if($_POST) {
	CleanPost();
    if(sizeof($_POST['OrderID'] > 0)) {
        $OrderColor = implode(",", $_POST['OrderID']);	 

//print_r($_POST); exit;
 if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
		if($_POST['RowColor']=='None') $_POST['RowColor']='';
           	$_SESSION['mess_order'] = ROW_HIGHLIGHTED;
		$objOrder->setRowColorEorder($OrderColor,$_POST['RowColor']);
        }      
        header("location:" . $RedirectUrl);
        exit;
    }
}
         
       require_once("../includes/footer.php");
  
?>
