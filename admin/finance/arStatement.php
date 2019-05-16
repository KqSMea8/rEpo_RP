<?php 
	
	include_once("../includes/header.php");
	require_once($Prefix . "classes/sales.quote.order.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/email.class.php");
	$objCustomer=new Customer();
	$objImportEmail = new email();
	$objReport = new report();
	$objBankAccount = new BankAccount();
	$objSale = new sale();
	$RedirectURL = "arStatement.php";
	
	/************/
	$ModuleDepName = $ModuleName = $module1 = '';
	(empty($_GET['c']))?($_GET['c']=""):("");	

	$TemplateID = 77;
	$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
	if($TemplateContent[0]['Status'] != 1) {
		$ErrorMSG = str_replace("[MODULE]", 'Statement', EMAIL_TEMPLATE_INACTIVE);
	}	
	/************/


	if(!empty($_POST['Send_Mail'])){
		unset($_SESSION['Email_Not_Exist']); 
		unset($_SESSION['EmailSentList']);

		$i=0;
		foreach($_POST['Cid'] as $values){	
			$ID=explode('#',$values);	
			$OrderID = $ID[0]; 
			$CustID =  $ID[1];
			if($CustID>0 && $OrderID>0){
				$arryCustOrder[$CustID][] = $OrderID;
			}
		}
		 
		 
		
 		foreach($arryCustOrder as $custid => $orders) {		
       			if(!empty($custid)){
				if($_POST['AttachPdf']==1){
					$CountLine=0;
	
					foreach($orders as $OrderID){
						
						$arryInvoice = $objSale->GetSale($OrderID, '', '');
						$Module = $arryInvoice[0]['Module'];
						$InvoiceEntry = $arryInvoice[0]['InvoiceEntry'];
						$InvoiceID = $arryInvoice[0]['InvoiceID'];
						$CreditID = $arryInvoice[0]['CreditID'];	
						
						if($Module=='Invoice'){
							$PdfDir = $Config['FilePreviewDir'].$Config['S_Invoice'];
							if($InvoiceEntry == "2" || $InvoiceEntry == "3"){
								$ModuleDepName = "SalesInvoiceGl";
							}else{
								$ModuleDepName = "SalesInvoice";
							}
							$PdfFile = $ModuleDepName.'-'.$InvoiceID.'.pdf';
						}else if($Module=='Credit'){
							$PdfDir = $Config['FilePreviewDir'].$Config['S_Credit'];
							$ModuleDepName = "SalesCreditMemo";
							$PdfFile = $ModuleDepName.'-'.$CreditID.'.pdf';
						}
						$fileexist=0;
						if($Config['ObjectStorage'] == "1"){
							if(!empty($arryInvoice[0]['PdfFile'])) $fileexist=1;
						}else{
							$fileexist = file_exists($PdfDir.$PdfFile);
						}
					

						if($fileexist != 1){
							 $cmd="/usr/bin/php /var/www/html/erp/admin/pdfCommon.php ".$OrderID." ".$ModuleDepName." ".$Module." ".$_SESSION['CmpID']." ".$_SESSION['CmpDatabase']; 
							//$cmd="/usr/bin/php /var/www/html/erp/mail.php"; 
							$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);
							
						}

					 
						$CountLine++; 
						
					}
					sleep($CountLine*2);
       	           
		       		}	
							 
		           	$objReport->statementEmail($Statement[$i],$custid,$orders,$_POST['CC']); 
		           
       			}
		
		}
       		 
		
		if(!empty($_SESSION['Email_Not_Exist'][0])){
			$RedImg = "<img src='../images/delete.png'>";
			$NotSend = implode("<br>".$RedImg, $_SESSION['Email_Not_Exist']);
			if(!empty($NotSend)){
				$NotSend  = '<br><br><div class="blackmsg" >'.STMT_SEND_FAILED.' <div class="borderblue red" style="width:300px;padding:5px;">'.$RedImg.$NotSend.'</div></div>';
			}
		}




		if(!empty($_SESSION['EmailSentList'][0])){
			$CheckImg = "<img src='../images/check.png'>";
			$SendList = implode("<br>".$CheckImg, $_SESSION['EmailSentList']);
			if(!empty($SendList)){
				$SendList  = '<div class="blackmsg" >'.STMT_SEND_CUST.'</div>
<div class="borderblue green" style="width:300px;padding:5px;">'.$CheckImg.$SendList.'</div>';
			}
		}
		 
		$_SESSION['mess_Statement'] = $SendList.$NotSend;

		 
		echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
		exit;
       }
  
       

	/*************************/
	$arryCustomer=$objBankAccount->getCustomerList();
      


 	$arryStatement = $objReport->statementReportList($_GET['c'],'');
	$num = $objReport->numRows();
       
        

	require_once("../includes/footer.php"); 	
?>


