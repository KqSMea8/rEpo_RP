<?
/*****Variable Define & Default Array for empty edit********/
/****************************/  

(empty($_GET['From']))?($_GET['From']=""):(""); 
(empty($_GET['To']))?($_GET['To']=""):(""); 
(empty($_GET['id']))?($_GET['id']=""):("");
(empty($_GET['CustID']))?($_GET['CustID']=""):("");
(empty($_GET['CustCode']))?($_GET['CustCode']=""):("");
(empty($_GET["c"]))?($_GET["c"]=""):("");
(empty($_GET["d"]))?($_GET["d"]=""):("");
(empty($_GET["st"]))?($_GET["st"]=""):("");
(empty($_GET["pk"]))?($_GET["pk"]=""):("");
(empty($_GET["s"]))?($_GET["s"]=""):("");
(empty($_GET["link"]))?($_GET["link"]=""):("");
(empty($_GET["cancel_id"]))?($_GET["cancel_id"]=""):("");
(empty($_GET["OrderID"]))?($_GET["OrderID"]=""):("");
(empty($_GET["Department"]))?($_GET["Department"]=""):("");
(empty($_GET["so"]))?($_GET["so"]=""):("");
(empty($_GET["convert"]))?($_GET["convert"]=""):("");
(empty($_GET["TerritoryID"]))?($_GET["TerritoryID"]=""):("");
(empty($_GET["creditnote"]))?($_GET["creditnote"]=""):("");
(empty($_GET["Module"]))?($_GET["Module"]=""):("");
(empty($_GET["formid"]))?($_GET["formid"]=""):("");
(empty($_GET["po"]))?($_GET["po"]=""):("");
(empty($_GET["POID"]))?($_GET["POID"]=""):("");
(empty($_GET["synctype"]))?($_GET["synctype"]=""):("");
(empty($_GET['proc']))?($_GET['proc']=""):("");  

(empty($OrderID))?($OrderID=""):("");
(empty($CustCode))?($CustCode=""):("");
(empty($CheckHide))?($CheckHide=""):("");
(empty($module))?($module=""):("");
(empty($ModuleName))?($ModuleName=""):(""); 
(empty($TotalGenerateInvoice))?($TotalGenerateInvoice=""):("");
(empty($style))?($style=""):("");
(empty($stockStatus))?($stockStatus=""):("");
(empty($PickStatus))?($PickStatus=""):("");
(empty($OrderSourceFlag))?($OrderSourceFlag=""):("");
(empty($TransactionExist))?($TransactionExist=""):("");
(empty($PayPalPaid))?($PayPalPaid=""):("");
(empty($CreditCardFlag))?($CreditCardFlag=""):("");
(empty($PageHeading))?($PageHeading=""):("");
(empty($BoxPrefix))?($BoxPrefix=""):("");
(empty($MandForEcomm))?($MandForEcomm=""):("");
(empty($HideRecurring))?($HideRecurring=""):("");
(empty($shipList))?($shipList=""):("");
(empty($Count))?($Count=""):("");
(empty($InvoiceSpend))?($InvoiceSpend=""):("");
(empty($CardVoided))?($CardVoided=""):("");
(empty($displayStateBlock))?($displayStateBlock=""):("");
(empty($displayCityBlock))?($displayCityBlock=""):("");
(empty($displayCountryBlock))?($displayCountryBlock=""):("");
(empty($displayShipCityBlock))?($displayShipCityBlock=""):("");
(empty($displayShipStateBlock))?($displayShipStateBlock=""):("");
(empty($displayShipCountryBlock))?($displayShipCountryBlock=""):("");
(empty($arryShippingCity))?($arryShippingCity=""):("");
(empty($arryCity))?($arryCity=""):("");
(empty($arryShippingState))?($arryShippingState=""):("");
(empty($arryState))?($arryState=""):("");




(empty($Config['Junk']))?($Config['Junk']=""):("");
(empty($Config['AddGap']))?($Config['AddGap']=""):("");  
    
 #echo $MainModuleID;

if($EditPage==1 && empty($_GET['edit'])){
	switch($MainModuleID) {	

		case '713': 
			$arrySale = $objConfigure->GetDefaultArrayValue('s_order');
			$arrySaleItem  = $objConfigure->GetDefaultArrayValue('s_order_item');
			break;	 	
		 case '717': 
			$arrySale = $objConfigure->GetDefaultArrayValue('s_order');
			$arrySaleItem  = $objConfigure->GetDefaultArrayValue('s_order_item');
			break;
		
				 	
	}
	 
}

/****************************/
/****************************/


?>
