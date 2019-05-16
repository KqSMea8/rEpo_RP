<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'reportProfitLoss.php';
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.report.class.php");
        require_once($Prefix."classes/finance.account.class.php");


	$objBankAccount=new BankAccount();
        
	$objReport = new report();

	$module = "Send a Report by Email";
	$ModuleName = "Balance Sheet Report";

	$RedirectURL = "reportBalanceSheet.php";


        if($_GET['TransactionDate'] == "All")
                    {
                        $FromDate = '2014-01-01';
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
                        
                    }else{
                        
                        if(!empty($_GET['FromDate'])){
                            
                            $FromDate = $_GET['FromDate'];
                            $ToDate = $_GET['ToDate'];
                        }else{
                        
                           $FromDate = date('Y-m-1');
                           $ToDate = date('Y-m-d');
                        }
                    }
                   
          $_SESSION['DateFormat'] =  $Config['DateFormat'];
          $_SESSION['Currency'] = $Config['Currency'];
       
	
	if(!empty($_POST["ToEmail"])){
		
		$AttachFlag = 1;
		include_once("pdfBL.php");
		$_POST['Attachment'] = getcwd()."/".$file_path;
		/***********/	
                
		$objReport->sendBLReport($_POST);
		$_SESSION['mess_report_email'] = REPORT_EMAIL;	
		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;				
	}


	  

	require_once("../includes/footer.php"); 	 
?>


