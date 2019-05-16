<?php 
	include_once("../includes/header.php");
        require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	$objReport = new report();
        $objBankAccount=new BankAccount();
        
	 $ModuleName = "Profit and Loss Report";
         
         /********************************************************************/
          if($_GET['TransactionDate'] == "All")
                    {
                        $Year = date('Y');
                        $FromDate = $Year.'-01-01';
                        $ToDate = date('Y-m-d');
                        
                    }else if($_GET['TransactionDate'] == "Today")
                    {
                        $FromDate = date('Y-m-d');
                        $ToDate = date('Y-m-d');
                        
                    }else if($_GET['TransactionDate'] == "Last Week")
                    {
                        $previous_week = strtotime("-1 week +1 day");

                        $start_week = strtotime("last sunday midnight",$previous_week);
                        $end_week = strtotime("next saturday",$start_week);

                        $start_week = date("Y-m-d",$start_week);
                        $end_week = date("Y-m-d",$end_week);
                        
                        $FromDate = $start_week;
                        $ToDate = $end_week;
                        
                    }else if($_GET['TransactionDate'] == "Last Month")
                    {
                        $FromDate = date("Y-m-1", strtotime("first day of previous month") );
                        $ToDate = date("Y-m-t", strtotime("last day of previous month") );
                        
                    }else if($_GET['TransactionDate'] == "Last Three Month")
                    {
                        $FromDate = date("Y-m-1",strtotime("-3 Months"));
                        $ToDate = date("Y-m-t",strtotime("-1 Months"));
                        
                    }else if($_GET['TransactionDate'] == "Specific Date")
		     {
                        $SpecificDate =1;
                        if(!empty($_GET['FromDate'])){
                            
                            $FromDate = $_GET['FromDate'];
                            $ToDate = $_GET['ToDate'];
                        }else{
                        
                           $FromDate = date('Y-m-1');
                           $ToDate = date('Y-m-d');
                        }
                    }else{//Monthly
			 $_GET['TransactionDate'] = "Monthly";

			  if(empty($_GET['m'])){
				$_GET['m'] = date('m');                          	
			  }
			  if(empty($_GET['y'])){
				$_GET['y'] = date('Y');                          	
			  }
			   $FromDate = $_GET['y'].'-'.$_GET['m'].'-01';
                           $ToDateTemp = date($_GET['y'].'-'.$_GET['m'].'-d');
			   $ToDate = date("Y-m-t", strtotime($ToDateTemp) );	
		    }
                   

	$FromYear = date("Y",strtotime($FromDate));
	$ToYear = date("Y",strtotime($ToDate));


	$YearFromDate = $FromYear.'-01-01';


          $_SESSION['DateFormat'] =  $Config['DateFormat'];
          $_SESSION['Currency'] = $Config['Currency'];
         $DownloadUrl = "pdfPL.php?TransactionDate=".$_GET['TransactionDate']."&FromDate=".$FromDate."&ToDate=".$ToDate.""; 
         $EmailUrl = "email_pl_report.php?TransactionDate=".$_GET['TransactionDate']."&FromDate=".$FromDate."&ToDate=".$ToDate."";
         $ExportUrl = "export_ProfitLoss.php?TransactionDate=".$_GET['TransactionDate']."&FromDate=".$FromDate."&ToDate=".$ToDate."&export=1"; 
         
         /********************************************************************************/
         $arryAccountType=$objReport->getAccountTypeForProfitLossReportNew();
         $num=$objReport->numRows();   
	/*************************/
 	
	if($FromDate!=$YearFromDate){
		$FromMonth = (int)date("m",strtotime($FromDate));
		$forPeriodHTML = '<br>For The '.$FromMonth.' Periods Ended '.date($Config['DateFormat'], strtotime($ToDate));
	}


	require_once("../includes/footer.php"); 	
?>


