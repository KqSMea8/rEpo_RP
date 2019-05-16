<?
/*****Variable Define & Default Array for empty edit********/
/****************************/ 
 
(empty($_GET['EmpID']))?($_GET['EmpID']=""):(""); 
(empty($_GET['att']))?($_GET['att']=""):(""); 
(empty($_GET['From']))?($_GET['From']=""):(""); 
(empty($_GET['To']))?($_GET['To']=""):(""); 
(empty($_GET['id']))?($_GET['id']=""):("");
(empty($_GET['so']))?($_GET['so']=""):("");
(empty($_GET['batch']))?($_GET['batch']=""):("");
(empty($_GET['batchId']))?($_GET['batchId']=""):("");
(empty($_GET['SaleID']))?($_GET['SaleID']=""):("");
(empty($_GET['Pick']))?($_GET['Pick']=""):("");
(empty($_GET['ship']))?($_GET['ship']=""):("");
(empty($style))?($style=""):("");
(empty($OrderID))?($OrderID=""):(""); 
(empty($OrderSourceFlag))?($OrderSourceFlag=""):(""); 
(empty($_GET["module"]))?($_GET["module"]=""):(""); 
(empty($Config['CountryDisplay']))?($Config['CountryDisplay']=""):(""); 
(empty($_GET["warehouse"]))?($_GET["warehouse"]=""):(""); 
(empty($tempnmval['id']))?($tempnmval['id']=""):("");
(empty($_GET["DO"]))?($_GET["DO"]=""):("");
(empty($module))?($module=""):(""); 
(empty($ModuleName))?($ModuleName=""):(""); 
(empty($_GET['po']))?($_GET['po']=""):("");
(empty($_GET['sku']))?($_GET['sku']=""):("");
(empty($_GET['SerialValue']))?($_GET['SerialValue']=""):("");
(empty($_GET['condition']))?($_GET['condition']=""):("");
(empty($_GET['rcpt']))?($_GET['rcpt']=""):("");
(empty($_GET['FromDateShip']))?($_GET['FromDateShip']=""):("");
(empty($_GET['ToDateShip']))?($_GET['ToDateShip']=""):("");
(empty($_GET['type']))?($_GET['type']=""):("");    
(empty($_GET['opt']))?($_GET['opt']=""):("");
(empty($_GET['link']))?($_GET['link']=""):("");
(empty($subtotal))?($subtotal="0"):("");
(empty($Freight))?($Freight="0"):("");
(empty($taxAmnt))?($taxAmnt="0"):("");
(empty($TotalAmount))?($TotalAmount="0"):("");
(empty($Config['Junk']))?($Config['Junk']="0"):("");
(empty($_GET['FromDateRtn']))?($_GET['FromDateRtn']=""):("");
(empty($FromDateRtn))?($FromDateRtn=""):(""); 
(empty($_GET['ToDateShip']))?($_GET['ToDateShip']=""):("");
(empty($ToDateShip))?($ToDateShip=""):(""); 
 




 #echo $MainModuleID;

if($EditPage==1 && empty($_GET['edit'])){
	switch($MainModuleID) {	
		case '320': 
			$arryWarehouse = $objConfigure->GetDefaultArrayValue('w_warehouse');
			//$arrySaleItem  = $objConfigure->GetDefaultArrayValue('s_order_item');
			break;
		case '321':
			$arryBin = $objConfigure->GetDefaultArrayValue('w_binlocation');
			break;	
		 
		case '4000':
			$batcharr = $objConfigure->GetDefaultArrayValue('batchmgmt');
			break;
		
				 	
	}
	 
}
 
/****************************/
/****************************/


?>
