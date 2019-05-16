<?php	
		$CronFlag=0;
		$CronFlag = $objConfig->CheckCronEntrySetting('EmailStatement');	
 
		/************************/
		if(!empty($CronFlag)){		
			$objConfig->UpdateLastCronEntrySetting('EmailStatement');
			$arryStatement = $objReport->statementReportList('',''); 
	 	 	$CountLine=0;
	 	 	$CustID ='';
 
	 	 	//pr($arryStatement);die;
			foreach($arryStatement as $key=>$value){ 

			 	if($CustID == '' || $CustID != $value['CustID']){ 
			 
				$Module = $value['Module'];
				$InvoiceEntry = $value['InvoiceEntry'];
				$InvoiceID = $value['InvoiceID'];
				$CreditID = $value['CreditID'];	
				$CustID = $value['CustID'];
				
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
					if(!empty($value['PdfFile'])) $fileexist=1;
				}else{
					$fileexist = file_exists($PdfDir.$PdfFile);
				}
				
				if($fileexist != 1){
							 $cmd="/usr/bin/php /var/www/html/erp/admin/pdfCommon.php ".$OrderID." ".$ModuleDepName." ".$Module." ".$Config['AdminID']." ".$Config['DbName']; 
							$command = exec("( $cmd  > /dev/null &);" . "echo $$;",$output);
							
						}
					 
					$CountLine++; 

					$objReport->statementEmail('',$CustID,'',''); 
					}	
				}

			//echo 'Success';die;
			
		}
		
	
?>		
