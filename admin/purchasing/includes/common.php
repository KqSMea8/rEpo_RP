<?
/*****Variable Define & Default Array for empty edit********/
/****************************/  
(empty($_GET['sku']))?($_GET['sku']=""):(""); 
(empty($_GET['item_id']))?($_GET['item_id']=""):("");
(empty($_GET['condition']))?($_GET['condition']=""):(""); 
(empty($_GET['Module']))?($_GET['Module']=""):(""); 
(empty($_GET['From']))?($_GET['From']=""):(""); 
(empty($_GET['To']))?($_GET['To']=""):(""); 
(empty($_GET['id']))?($_GET['id']=""):(""); 
(empty($tempnmval['id']))?($tempnmval['id']=""):("");
(empty($_GET["pk"]))?($_GET["pk"]=""):(""); 
(empty($_GET["link"]))?($_GET["link"]=""):(""); 
(empty($_GET["OrderID"]))?($_GET["OrderID"]=""):("");
(empty($_GET["Department"]))?($_GET["Department"]=""):(""); 
(empty($_GET["convert"]))?($_GET["convert"]=""):("");
(empty($_GET['TPostedDate']))?($_GET['TPostedDate']=""):("");
(empty($_GET['FPostedDate']))?($_GET['FPostedDate']=""):("");
(empty($_GET['SuppCompany']))?($_GET['SuppCompany']=""):("");
(empty($_GET['SuppCode']))?($_GET['SuppCode']=""):("");
(empty($_GET['SuppID']))?($_GET['SuppID']=""):("");
(empty($OrderID))?($OrderID=""):(""); 
(empty($module))?($module=""):("");
(empty($ModuleName))?($ModuleName=""):("");  
(empty($style))?($style=""):(""); 
(empty($PageHeading))?($PageHeading=""):("");
(empty($BoxPrefix))?($BoxPrefix=""):("");
(empty($MandForEcomm))?($MandForEcomm=""):("");
(empty($HideRecurring))?($HideRecurring=""):(""); 
(empty($Count))?($Count=""):("");
(empty($OrderIsOpen))?($OrderIsOpen=""):("");
 (empty($TaxName))?($TaxName=""):("");
(empty($_GET['po']))?($_GET['po']=""):("");
(empty($Config['Junk']))?($Config['Junk']=""):("");
(empty($_GET['s']))?($_GET['s']=""):("");
(empty($_GET['st']))?($_GET['st']=""):("");
(empty($subtotal))?($subtotal=""):("");
(empty($TotalQtyReceived))?($TotalQtyReceived=""):("");
(empty($TotalToReturn))?($TotalToReturn=""):("");
(empty($SaleID))?($SaleID=""):("");
(empty($NumPoItem))?($NumPoItem=""):("");
 

 #echo $MainModuleID;

if($EditPage==1 && empty($_GET['edit'])){
	switch($MainModuleID) {	

		case '411': 
			$arryPurchase = $objConfigure->GetDefaultArrayValue('p_order');	
			$arryPurchaseItem = $objConfigure->GetDefaultArrayValue('p_order_item');		
			break;
		case '413': 
			$arryPurchase = $objConfigure->GetDefaultArrayValue('p_order');	
			$arryPurchaseItem = $objConfigure->GetDefaultArrayValue('p_order_item');			
			break;
			}
	 
}

/****************************/
/****************************/


?>
