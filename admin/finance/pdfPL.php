<?	require_once("../includes/pdf_comman.php");
	if($AttachFlag!=1){
		require_once($Prefix."classes/finance.report.class.php");
                require_once($Prefix."classes/finance.account.class.php");
                $objBankAccount=new BankAccount();

	      $objReport = new report();
	}
	
      
      
	 
        $ModuleName = "Profit and Loss Report";
        $arryAccountType=$objReport->getAccountTypeForProfitLossReport();
        $NumLine = sizeof($arryAccountType);
	/*******************************************/
	/*******************************************/
	$pdf = new Creport('a4','portrait');
	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
	$pdf->ezSetMargins(20,20,50,50);

	#FooterTextBox($pdf);

	//TitlePage($arry, $pdf);
	//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);

        if($_GET['TransactionDate'] == "All"){
               $dateRange =  "All Dates";
            } else if($_GET['TransactionDate'] == "Today"){
                 $dateRange = date($_SESSION['DateFormat'], strtotime($_GET['FromDate']));
           } else {
              //echo "=>".$_GET['FromDate'];exit;
             $dateRange = date($_SESSION['DateFormat'], strtotime($_GET['FromDate']))." - ".date($_SESSION['DateFormat'], strtotime($_GET['ToDate']));
            }
            
	 $Title = $ModuleName."   [".$dateRange."]";
	 HeaderTextBox($pdf,$Title,$arryCompany);

	/*******************************************/
	/*******************************************/

	require_once("includes/pdf_pl.php");

 
	//$pdf->ezStream();exit;

	// or write to a file
	$file_path = 'upload/pdf/Profit-n-Loss-Report-'.date('Y-m-d').".pdf";
	$pdfcode = $pdf->output();
	$fp=fopen($file_path,'wb');
	fwrite($fp,$pdfcode);
	fclose($fp);

	if($AttachFlag!=1){
		header("location:dwn.php?file=".$file_path."&del_file=".$_SESSION['AdminID']);
		exit;
	}

?>
