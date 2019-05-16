<?php 
	$HideNavigation = 1;
	require_once("../includes/header.php");
	require_once($Prefix . "classes/finance.class.php");
	require_once($Prefix."classes/finance.report.class.php");
	require_once($Prefix."classes/finance.transaction.class.php");
	$objReport = new report();
	$objCommon = new common();
	$objTransaction=new transaction();
 	$BatchID   = $_GET['BatchID'];
 	$Config['DateFormat'] = 'm/d/Y';
 
	if(!empty($BatchID)){
		$arryBatch = $objCommon->GetCheckInBatch($BatchID);
 
		if(empty($arryBatch[0]['TransactionID'])){
			$ErrorMsg = INVALID_REQUEST;
		}else{
			$CountBatch=0;
			echo '<table width="700" border="0" cellpadding="0" cellspacing="0"><tr>	
			 <td align="left" valign="top" width="50">&nbsp;</td>
		 	 <td align="left" valign="top" ><input type="button" class="print_button" name="Print" id="Print"   value="Print" onclick="Javascript:window.print();"></td>
			</tr>';
			foreach($arryBatch as $keybatch=>$valuesbatch){// Start Batch
				$CountBatch++;
				unset($arryTransaction);
				unset($arryVendorData);
				unset($arryTransactionData);
				/*****************/
				$TransactionID = $valuesbatch['TransactionID'];
				$_GET['TransactionID'] = $TransactionID;
				$_GET['PaymentType'] = 'Purchase';
				$arryTransaction = $objReport->getPaymentTransaction($_GET);
				
				$CheckFormat = $arryTransaction[0]['CheckFormat'];
				$CheckNumber = $arryTransaction[0]['CheckNumber'];
				$PaymentDate = $arryTransaction[0]['PaymentDate'];		
				/*****************/
				$arryTemplate = $objReport->GetCheckTemplate();	
				$arryTransactionData = $objTransaction->ListSessionTransaction('AP',$TransactionID ,''); 			
				$Count=0;
				//echo '<pre>';print_r($arryTransactionData);exit;
				foreach($arryTransactionData as $key=>$values){
					$SuppCode = $values['SuppCode'];							
					foreach($values as $k=>$val){  
						$arryVendorData[$SuppCode][$Count][$k] = $val;			
					}
					$Count++;
				}
				/*****************/
$ToolbalShown='';
$NumChunkBreak='';
$VendorAddress='';
?>
 

 


	

<?
$BoxStyle = !empty($arryTemplate[0]['BoxStyle'])?($arryTemplate[0]['BoxStyle']):('padding-top:1px;padding-bottom:1px;');

foreach($arryVendorData as $keyven=>$valuesven){ //Vendor	
	$CheckAmount=0;
	$VendorName = '';
	foreach($valuesven as $key2=>$values2){  //Vendor Amount	
		if(empty($VendorName))$VendorName = $values2['VendorName'];	 
		$CheckAmount += $values2["Amount"];
	}

	unset($arrChunk);
	$arrChunk = array_chunk($valuesven,10);//10 is chunk

	


	 if($CheckFormat=='Check, Stub, Stub'){ 
		include("includes/html/box/check.php");	
		for($i=0;$i<sizeof($arrChunk);$i++){		
			include("includes/html/box/stub.php");	
		}
		for($i=0;$i<sizeof($arrChunk);$i++){		
			include("includes/html/box/stub.php");	
		}		 
	 }else if($CheckFormat=='Stub, Check, Stub'){
		for($i=0;$i<sizeof($arrChunk);$i++){		
			include("includes/html/box/stub.php");	
		}
		include("includes/html/box/check.php");	
		for($i=0;$i<sizeof($arrChunk);$i++){		
			include("includes/html/box/stub.php");	
		}
	 }else if($CheckFormat=='Stub, Stub, Check'){
		for($i=0;$i<sizeof($arrChunk);$i++){		
			include("includes/html/box/stub.php");	
		}
		for($i=0;$i<sizeof($arrChunk);$i++){		
			include("includes/html/box/stub.php");	
		}
		include("includes/html/box/check.php");	
	 }
}




?>



	

<?


				
				/*****************/
			} // End Batch
			echo '</table>';
			 	
		 }
		
	}else{
		$ErrorMsg = INVALID_REQUEST;
	}        

	
 	require_once("../includes/footer.php"); 	
?>



