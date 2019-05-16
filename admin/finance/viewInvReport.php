<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/purchasing.class.php");
	$objCommon=new common();
	$objPurchase = new purchase();
	$objSupplier=new supplier();
	/*************************/

	(empty($_GET['s']))?($_GET['s']=""):("");
	(empty($_GET['p']))?($_GET['p']=""):("");
	(empty($_GET['SearchBy']))?($_GET['SearchBy']=""):("");


	if(!empty($_GET['SearchBy'])){
		if($_GET['SearchBy'] == "T"){
			$_GET['f'] = date('Y-m-d');
			$_GET['t'] = date('Y-m-d');
		}else if($_GET['SearchBy'] == "Y"){
			$Yesterday = strtotime("-1 day");
			$_GET['f'] = date("Y-m-d",$Yesterday);
			$_GET['t'] = date("Y-m-d",$Yesterday);
		}else if($_GET['SearchBy'] == "TW"){
                        $this_week = strtotime("0 week +1 day");

                        $start_week = strtotime("last sunday midnight",$this_week);
                        $end_week = strtotime("next saturday",$start_week);

                        $start_week = date("Y-m-d",$start_week);
                        $end_week = date("Y-m-d",$end_week);
                        
                        $_GET['f'] = $start_week;
                        $_GET['t'] = $end_week;
		}else if($_GET['SearchBy'] == "LW"){
                        $previous_week = strtotime("-1 week +1 day");

                        $start_week = strtotime("last sunday midnight",$previous_week);
                        $end_week = strtotime("next saturday",$start_week);

                        $start_week = date("Y-m-d",$start_week);
                        $end_week = date("Y-m-d",$end_week);
                        
                        $_GET['f'] = $start_week;
                        $_GET['t'] = $end_week;

                }else if($_GET['SearchBy'] == "TM"){
                        $_GET['f'] = date("Y-m-1", strtotime("first day of this month") );
                        $_GET['t'] = date("Y-m-t", strtotime("last day of this month") );  
   
                }else if($_GET['SearchBy'] == "LM"){
                        $_GET['f'] = date("Y-m-1", strtotime("first day of previous month") );
                        $_GET['t'] = date("Y-m-t", strtotime("last day of previous month") );
                        
                }else if($_GET['SearchBy'] == "TY"){
                        $_GET['f'] = date("Y-01-01");
                        $_GET['t'] = date("Y-12-31");                         
		}else if($_GET['SearchBy'] == "LY"){
			$LastYear = date("Y")-1;
                        $_GET['f'] = $LastYear."-01-01";
                        $_GET['t'] = $LastYear."-12-31";                         
                }
	}




	if(!empty($_GET['f']) && !empty($_GET['t'])){
		/*************************/	
		$Config['RecordsPerPage'] = $RecordsPerPage;
		$arryInvoice=$objPurchase->InvoiceReport($_GET['f'],$_GET['t'],$_GET['s'],$_GET['p']);

		/*******Count Records**********/	
		$Config['GetNumRecords'] = 1;
		$arryCount=$objPurchase->InvoiceReport($_GET['f'],$_GET['t'],$_GET['s'],$_GET['p']);
		$num=$arryCount[0]['NumCount'];	

		$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
	

	}
	/*************************/
	$arrySupplier = $objSupplier->GetSupplierBrief('');

	require_once("../includes/footer.php"); 	
?>


