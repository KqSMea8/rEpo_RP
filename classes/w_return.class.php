<?
class wreturn extends dbClass
{
		//constructor
		function wreturn()
		{
			$this->dbClass();
		} 
		
		function  ListPurchase($arryDetails)
		{
			extract($arryDetails);

			if($module=='Quote'){	
				$ModuleID = "QuoteID"; 
			}else{
				$ModuleID = "PurchaseID"; 
			}

			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($module))?(" and o.Module='".$module."'"):("");
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			$strAddQuery .= ($Approved==1)?(" and o.Approved='1' "):("");
			$strAddQuery .= (!empty($AssignedEmpID))?(" and o.AssignedEmpID='".$AssignedEmpID."'"):("");

			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.OrderType like '%".$SearchKey."%' or o.SuppCompany like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' ) " ):("");	
			}

			if($Status=='Open'){
				$strAddQuery .= " and o.Approved='1' and o.Status!='Completed' ";
			}else{
				$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			}

			if($ToApprove=='1'){
				$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
			}

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.OrderDate desc,o.OrderID desc");
			$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");


			$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency  from p_order o ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	

		function  GetPurchase($OrderID,$PurchaseID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".$PurchaseID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
		      $strSQLQuery = "select o.* from p_order o where 1".$strAddQuery." order by o.OrderID desc";
			
			return $this->query($strSQLQuery, 1);
		}		

		function  GetPurchaseItem($OrderID)
		{
			$strAddQuery .= (!empty($OrderID))?(" and i.OrderID='".$OrderID."'"):("");
			$strSQLQuery = "select i.*,t.RateDescription from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
			return $this->query($strSQLQuery, 1);
		}

		function  GetInvoiceOrder($PurchaseID)
		{
			$strSQLQuery = "select OrderID from p_order o where PurchaseID='".$PurchaseID."' and Module='Invoice' order by o.OrderID asc";
			return $this->query($strSQLQuery, 1);
		}	

		function  GetSuppPurchase($SuppCode,$OrderID,$PurchaseID,$Module)
		{
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".$PurchaseID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from p_order o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}

		function AddPurchase($arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			if(empty($Currency)) $Currency =  $Config['Currency'];
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];


			$strSQLQuery = "insert into p_order(Module, OrderType, OrderDate,  PurchaseID, QuoteID, InvoiceID, CreditID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, Freight, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp ) values('".$Module."', '".$OrderType."', '".$OrderDate."',  '".$PurchaseID."', '".$QuoteID."', '".$InvoiceID."', '".$CreditID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '".$ClosedDate."', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '".addslashes($Freight)."', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."')";
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();

			if(empty($arryDetails[$ModuleID])){
				$ModuleIDValue = $PrefixPO.'000'.$OrderID;
				$strSQL = "update p_order set ".$ModuleID."='".$ModuleIDValue."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}

			return $OrderID;

		}

		function AddUpdateItem($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);


			if(!empty($DelItem)){
				$strSQLQuery = "delete from p_order_item where id in(".$DelItem.")"; 
				$this->query($strSQLQuery, 0);
			}
		
			for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['sku'.$i])){
					$arryTax = explode(":",$arryDetails['tax'.$i]);
					
					$id = $arryDetails['id'.$i];
					if($id>0){
						$sql = "update p_order_item set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."', qty='".addslashes($arryDetails['qty'.$i])."', price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."'  where id='".$id."'"; 
					}else{
						$sql = "insert into p_order_item(OrderID, item_id, sku, description, on_hand_qty, qty, price, tax_id, tax, amount) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".$arryTax[0]."', '".$arryTax[1]."', '".addslashes($arryDetails['amount'.$i])."')";
					}
					$this->query($sql, 0);	

				}
			}

			return true;

		}



		function UpdatePurchase($arryDetails){ 
			global $Config;
			extract($arryDetails);	

			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];

			$strSQLQuery = "update p_order set  OrderType='".$OrderType."', OrderDate='".$OrderDate."', Approved='".$Approved."', Status='".$Status."',   ClosedDate='".$ClosedDate."', wCode='".$wCode."', DropShip='".$DropShip."', DeliveryDate='".$DeliveryDate."',Comment='".addslashes(strip_tags($Comment))."', SuppCode='".addslashes($SuppCode)."',  SuppCompany='".addslashes($SuppCompany)."', SuppContact='".addslashes($SuppContact)."', Address='".addslashes($Address)."', City='".addslashes($City)."', State='".addslashes($State)."', Country='".addslashes($Country)."', ZipCode='".addslashes($ZipCode)."' , SuppCurrency='".addslashes($SuppCurrency)."', Mobile='".addslashes($Mobile)."' ,Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' ,Email='".addslashes($Email)."' ,  wName='".addslashes($wName)."', wContact='".addslashes($wContact)."', wAddress='".addslashes($wAddress)."', wCity='".addslashes($wCity)."', wState='".addslashes($wState)."', wCountry='".addslashes($wCountry)."', wZipCode='".addslashes($wZipCode)."' , wMobile='".addslashes($wMobile)."' ,wLandline='".addslashes($wLandline)."',wEmail='".addslashes($wEmail)."', TotalAmount='".addslashes($TotalAmount)."' ,Freight='".addslashes($Freight)."'	,UpdatedDate = '".$Config['TodayDate']."', PaymentMethod='".addslashes($PaymentMethod)."', ShippingMethod='".addslashes($ShippingMethod)."', PaymentTerm='".addslashes($PaymentTerm)."', AssignedEmpID='".addslashes($EmpID)."', AssignedEmp='".addslashes($EmpName)."'
			where OrderID='".$OrderID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

	
		function ReceiveOrder($arryDetails)	{
			global $Config;
			extract($arryDetails);

			/*$sql = "CREATE TEMPORARY TABLE p_order2 ENGINE=MEMORY SELECT * FROM p_order WHERE OrderID=5;
			UPDATE p_order2 SET OrderID='', InvoiceID='55555'; 
			INSERT INTO p_order SELECT * FROM p_order2;
			DROP TABLE p_order2;";
			$this->query($sql, 0);*/



			$arryPurchase = $this->GetPurchase($ReceiveOrderID,'','');
			$arryPurchase[0]["Module"] = "Invoice";
			$arryPurchase[0]["ModuleID"] = "InvoiceID";
			$arryPurchase[0]["PrefixPO"] = "INV";
			$arryPurchase[0]["ReceivedDate"] = $ReceivedDate;
			$arryPurchase[0]["Freight"] = $Freight;
			$arryPurchase[0]["TotalAmount"] = $TotalAmount;	
			$arryPurchase[0]["InvoicePaid"] = $InvoicePaid;	
			$arryPurchase[0]["InvoiceComment"] = $InvoiceComment;	
			$arryPurchase[0]["EmpID"] = $arryPurchase[0]['AssignedEmpID'];	
			$arryPurchase[0]["EmpName"] = $arryPurchase[0]['AssignedEmp'];	
			$arryPurchase[0]["Status"] = "Invoicing";				
			$order_id = $this->AddPurchase($arryPurchase[0]);


			/******** Item Updation for Invoice ************/
			$arryItem = $this->GetPurchaseItem($ReceiveOrderID);
			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				
				if(!empty($arryDetails['id'.$i]) && $arryDetails['qty'.$i]>0){
					$qty_received = $arryDetails['qty'.$i];
					$sql = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, price, tax_id, tax, amount) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_received."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."')";

					$this->query($sql, 0);	

				}
			}

			//echo $order_id; exit;


			/****************************/
			$TotalQtyLeft = 1;
			$TotalQtyLeft = $this->GetTotalQtyLeft($PurchaseID);
			if($TotalQtyLeft<=0){
				$strSQLQuery = "update p_order set Status='Completed', ClosedDate='".$Config['TodayDate']."' where OrderID='".$ReceiveOrderID."'"; 
				$this->query($strSQLQuery, 0);

				$strSQLInv = "update p_order set Status='Completed', ClosedDate='".$Config['TodayDate']."' where OrderID='".$order_id."'"; 
				$this->query($strSQLInv, 0);

			}else{

				$strSQLQuery = "update p_order set Status='Invoicing' where OrderID='".$ReceiveOrderID."'"; 
				$this->query($strSQLQuery, 0);

				$strSQLInv = "update p_order set Status='Invoicing' where OrderID='".$order_id."'"; 
				$this->query($strSQLInv, 0);


			}

			return $order_id;
		}


		function  GetPurchasedItem($SuppCode,$OrderID,$PurchaseID,$Module)
		{
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".$PurchaseID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.OrderID,o.PurchaseID,o.OrderDate,o.Currency, i.item_id,i.sku,i.qty,i.description,i.price from p_order o inner join p_order_item i on o.OrderID=i.OrderID where o.Status='Completed' and o.Approved='1' ".$strAddQuery." order by o.OrderID desc ";
			return $this->query($strSQLQuery, 1);
		}

		function  ListInvoice($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = "where o.Module='Invoice' ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($po))?(" and o.PurchaseID='".$po."'"):("");
			
			$strAddQuery .= (!empty($FPostedDate))?(" and o.PostedDate>='".$FPostedDate."'"):("");
			$strAddQuery .= (!empty($TPostedDate))?(" and o.PostedDate<='".$TPostedDate."'"):("");

			$strAddQuery .= (!empty($FOrderDate))?(" and o.OrderDate>='".$FOrderDate."'"):("");
			$strAddQuery .= (!empty($TOrderDate))?(" and o.OrderDate<='".$TOrderDate."'"):("");
			if($InvoicePaid=='0'){
				$strAddQuery .= " and o.InvoicePaid!='1' ";
			}else if($InvoicePaid=='1'){
				$strAddQuery .= " and o.InvoicePaid='1' ";
			}

			if($SearchKey=='yes' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
				$strAddQuery .= " and o.InvoicePaid='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
				$strAddQuery .= " and o.InvoicePaid!='1'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.InvoiceID like '%".$SearchKey."%'  or o.PurchaseID like '%".$SearchKey."%'  or o.SuppCompany like '%".$SearchKey."%'  or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' ) " ):("");	
			}

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");
			$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");

			$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID, o.InvoiceID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid  from p_order o ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}


		function  ListReturn($arryDetails)
		{
			extract($arryDetails);
	
			$strAddQuery = "where o.Module='Return' ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($po))?(" and o.PurchaseID='".$po."'"):("");
			$strAddQuery .= (!empty($FPostedDate))?(" and o.PostedDate>='".$FPostedDate."'"):("");
			$strAddQuery .= (!empty($TPostedDate))?(" and o.PostedDate<='".$TPostedDate."'"):("");

			$strAddQuery .= (!empty($FOrderDate))?(" and o.OrderDate>='".$FOrderDate."'"):("");
			$strAddQuery .= (!empty($TOrderDate))?(" and o.OrderDate<='".$TOrderDate."'"):("");

			if($SearchKey=='yes' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
				$strAddQuery .= " and o.InvoicePaid='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
				$strAddQuery .= " and o.InvoicePaid!='1'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.InvoiceID like '%".$SearchKey."%'  or o.PurchaseID like '%".$SearchKey."%'  or o.SuppCompany like '%".$SearchKey."%'  or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' ) " ):("");	
			}

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID,o.ReturnID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid  from p_order o ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}

		function UpdateInvoice($arryDetails){ 
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update p_order set ReceivedDate='".$ReceivedDate."', PaymentDate='".$PaymentDate."', InvoicePaid='".$InvoicePaid."', InvPaymentMethod='".$InvPaymentMethod."', PaymentRef='".addslashes($PaymentRef)."', InvoiceComment='".addslashes(strip_tags($InvoiceComment))."', UpdatedDate = '".$Config['TodayDate']."'
			where OrderID='".$OrderID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}



		function ReturnOrder($arryDetails)	{
			global $Config;
			extract($arryDetails);


			$arryPurchase = $this->GetPurchase($ReturnOrderID,'','');
			$arryPurchase[0]["Module"] = "Return";
			$arryPurchase[0]["ModuleID"] = "ReturnID";
			$arryPurchase[0]["PrefixPO"] = "RTN";
			$arryPurchase[0]["ReceivedDate"] = $ReceivedDate;
			$arryPurchase[0]["Freight"] = $Freight;
			$arryPurchase[0]["TotalAmount"] = $TotalAmount;	
			$arryPurchase[0]["InvoicePaid"] = $InvoicePaid;	
			$arryPurchase[0]["InvoiceComment"] = $InvoiceComment;	
			$arryPurchase[0]["EmpID"] = $arryPurchase[0]['AssignedEmpID'];	
			$arryPurchase[0]["EmpName"] = $arryPurchase[0]['AssignedEmp'];	
			$arryPurchase[0]["EmpID"] = $arryPurchase[0]['AssignedEmpID'];	
			$arryPurchase[0]["EmpName"] = $arryPurchase[0]['AssignedEmp'];	
			$order_id = $this->AddPurchase($arryPurchase[0]);


			/******** Item Updation for Return ************/
			$arryItem = $this->GetPurchaseItem($ReturnOrderID);
			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				
				if(!empty($arryDetails['id'.$i]) && $arryDetails['qty'.$i]>0){
					$qty_returned = $arryDetails['qty'.$i];
					$sql = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_returned, price, tax_id, tax, amount) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_returned."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."')";

					$this->query($sql, 0);	

				}
			}


			return $order_id;
		}


		function UpdateReturn($arryDetails){ 
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update p_order set ReceivedDate='".$ReceivedDate."', PaymentDate='".$PaymentDate."', InvoicePaid='".$InvoicePaid."', InvPaymentMethod='".$InvPaymentMethod."', PaymentRef='".addslashes($PaymentRef)."', InvoiceComment='".addslashes(strip_tags($InvoiceComment))."', UpdatedDate = '".$Config['TodayDate']."'
			where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			return 1;
		}


		function  ListCreditNote($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = " where o.Module='Credit' ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($FromDate))?(" and (o.PostedDate>='".$FromDate."' OR o.ClosedDate>='".$FromDate."') "):("");
			$strAddQuery .= (!empty($ToDate))?(" and (o.PostedDate<='".$ToDate."' OR o.ClosedDate<='".$ToDate."') "):("");

			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.CreditID like '%".$SearchKey."%' or o.SuppCompany like '%".$SearchKey."%'  or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' ) " ):("");	
			}

			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.PostedDate ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select o.ClosedDate, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.CreditID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency  from p_order o ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	


		function  PurchaseReport($FilterBy,$FromDate,$ToDate,$Year,$SuppCode,$Status)
		{

			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.OrderDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");

			$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency  from p_order o where o.Module='Order' ".$strAddQuery." order by o.OrderDate desc";
				
			return $this->query($strSQLQuery, 1);		
		}

		function  GetNumPOByYear($Year,$FromDate,$ToDate,$SuppCode,$Status)
		{

			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");

			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");

			$strSQLQuery = "select count(o.OrderID) as TotalOrder  from p_order o where o.Module='Order' and YEAR(o.OrderDate)='".$Year."' ".$strAddQuery." order by o.OrderDate desc";
				
			return $this->query($strSQLQuery, 1);		
		}
	
		function  CountInvoices($PurchaseID)
		{
			$strSQLQuery = "select count(o.OrderID) as TotalInvoice from p_order o where o.Module='Invoice' and PurchaseID='".$PurchaseID."'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['TotalInvoice'];		
		}

		function  GetTotalQtyLeft($PurchaseID)
		{
			$strSQLQuery = "select i.id,i.qty from p_order_item i inner join p_order o on i.OrderID=o.OrderID where o.PurchaseID='".$PurchaseID."' and o.Module='Order' order by i.id asc";
			$arryItem = $this->query($strSQLQuery, 1);
			for($i=0;$i<sizeof($arryItem);$i++){
				$total_received = $this->GetQtyReceived($arryItem[$i]["id"]);
				$ordered_qty = $arryItem[$i]["qty"];
				
				$TotalQtyLeft += ($ordered_qty - $total_received);
			}

			return $TotalQtyLeft;		
		}

		function  InvoiceReport($FromDate,$ToDate,$SuppCode,$InvoicePaid)
		{

			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and o.PostedDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.PostedDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			if($InvoicePaid=='0'){
				$strAddQuery .= " and o.InvoicePaid!='1' ";
			}else if($InvoicePaid=='1'){
				$strAddQuery .= " and o.InvoicePaid='1' ";
			}

			$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.InvoiceID, o.PurchaseID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.InvoicePaid,o.Currency  from p_order o where o.Module='Invoice' ".$strAddQuery." order by o.PostedDate desc";
				
			return $this->query($strSQLQuery, 1);		
		}



		function  PaymentReport($FromDate,$ToDate,$SuppCode)
		{

			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and o.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");

			$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.PaymentDate, o.InvPaymentMethod, o.PaymentRef, o.OrderID, o.InvoiceID, o.PurchaseID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.InvoicePaid,o.Currency  from p_order o where o.Module='Invoice' and o.InvoicePaid='1'  ".$strAddQuery." order by o.PostedDate desc";
				
			return $this->query($strSQLQuery, 1);		
		}



		function  GetNumInvByYear($Year,$FromDate,$ToDate,$SuppCode,$InvoicePaid)
		{

			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and o.PostedDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.PostedDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			if($InvoicePaid=='0'){
				$strAddQuery .= " and o.InvoicePaid!='1' ";
			}else if($InvoicePaid=='1'){
				$strAddQuery .= " and o.InvoicePaid='1' ";
			}

			$strSQLQuery = "select count(o.OrderID) as TotalInvoice  from p_order o where o.Module='Invoice' and YEAR(o.PostedDate)='".$Year."' ".$strAddQuery." order by o.PostedDate desc";
				

			return $this->query($strSQLQuery, 1);		
		}



		function RemovePurchase($OrderID){
			/*$strSQLQuery = "select UserID,Image from p_order where OrderID='".$OrderID."'"; 
			$arryRow = $this->query($strSQLQuery, 1);

			$ImgDir = 'upload/purchase/';
		
			if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){							
				unlink($ImgDir.$arryRow[0]['Image']);	
			}*/
		
			$strSQLQuery = "delete from p_order where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from p_order_item where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			return 1;

		}

		function  GetQtyReceived($id)
		{
			$sql = "select sum(i.qty_received) as QtyReceived from p_order_item i where i.ref_id='".$id."' group by i.ref_id";
			$rs = $this->query($sql);
			return $rs[0]['QtyReceived'];
		}

		function  GetQtyOrderded($id)
		{
			$sql = "select i.qty as QtyOrderded from p_order_item i where i.id='".$id."'";
			$rs = $this->query($sql);
			return $rs[0]['QtyOrderded'];
		}

		function  GetQtyReturned($id)
		{
			$sql = "select sum(i.qty_returned) as QtyReturned from p_order_item i where i.ref_id='".$id."' group by i.ref_id";
			$rs = $this->query($sql);
			return $rs[0]['QtyReturned'];
		}

		function ConvertToPo($OrderID,$PurchaseID)
		{
			if(empty($PurchaseID)){
				$PurchaseID = 'PO000'.$OrderID;
			}

			$sql="update p_order set Module='Order',PurchaseID='".$PurchaseID."' where OrderID='".$OrderID."'";
			$this->query($sql,0);				

			return true;
		}
		
		function isEmailExists($Email,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "select OrderID from p_order where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}

		function isQuoteExists($QuoteID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "select OrderID from p_order where Module='Quote' and QuoteID='".trim($QuoteID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}	

		function isPurchaseExists($PurchaseID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "select OrderID from p_order where Module='Order' and PurchaseID='".trim($PurchaseID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}			
		

		function isInvoiceExists($InvoiceID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "select OrderID from p_order where Module='Invoice' and InvoiceID='".trim($InvoiceID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}	

		function isReturnExists($ReturnID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "select OrderID from p_order where Module='Return' and ReturnID='".trim($ReturnID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}	

		function isCreditIDExists($CreditID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "select OrderID from p_order where Module='Credit' and CreditID='".trim($CreditID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}


		function AuthorizePurchase($OrderID,$Authorize,$Complete)
		{
			global $Config;	


			if($OrderID>0){
				
			
				if($Authorize==1){
					$Action = 'Approved';
					$sql="update p_order set Approved='1' where OrderID='".$OrderID."'";
					$this->query($sql,0);	

				}else if($Authorize==2){
					$Action = 'Cancelled';
					$sql="update p_order set Approved='0' where OrderID='".$OrderID."'";
					$this->query($sql,0);	

					$sql_st="update p_order set Status='".$Action."' where OrderID='".$OrderID."'";
					$this->query($sql_st,0);	
				}else if($Authorize==3){
					$Action = 'Rejected';
					$sql="update p_order set Approved='0' where OrderID='".$OrderID."'";
					$this->query($sql,0);	

					$sql_st="update p_order set Status='".$Action."' where OrderID='".$OrderID."'";
					$this->query($sql_st,0);	
				}else if($Complete==1){
					$Action = 'Completed';
					$sql_st="update p_order set Status='".$Action."' where OrderID='".$OrderID."'";
					$this->query($sql_st,0);	
				}





				$arryPurchase = $this->GetPurchase($OrderID,'','');
				$module = $arryPurchase[0]['Module'];

				if($module=='Quote'){	
					$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; 
				}else if($module=='Order'){
					$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID";
				}

				if($arryPurchase[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
					$ToEmail = $Config['AdminEmail'];
				}else{
					$CreatedBy = stripslashes($arryPurchase[0]['CreatedBy']);

					$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$arryPurchase[0]['AdminID']."'";
					$arryEmp = $this->query($strSQLQuery, 1);

					$ToEmail = $arryEmp[0]['Email'];
					$CC = $Config['AdminEmail'];
				}
				
				$OrderDate = ($arryPurchase[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))):(NOT_SPECIFIED);				


				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."purchase_auth.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[Module]",$module,$contents);
				$contents = str_replace("[Action]",$Action,$contents);
				$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
				$contents = str_replace("[ModuleID]",$arryPurchase[0][$ModuleID],$contents);
				$contents = str_replace("[OrderDate]",$OrderDate,$contents);
				$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
				$contents = str_replace("[Status]",$arryPurchase[0]['Status'],$contents);
				$contents = str_replace("[OrderType]",$arryPurchase[0]['OrderType'],$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CC)) $mail->AddAddress($CC);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Purchase ".$module." has been ".$Action;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $ToEmail.$CC.$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}


		function sendPurchaseEmail($OrderID)
		{
			global $Config;	


			if($OrderID>0){
				$arryPurchase = $this->GetPurchase($OrderID,'','');
				$module = $arryPurchase[0]['Module'];

				if($module=='Quote'){	
					$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; 
				}else if($module=='Order'){
					$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID";
				}

				if($arryPurchase[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = stripslashes($arryPurchase[0]['CreatedBy']);
				}
				
				$OrderDate = ($arryPurchase[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))):(NOT_SPECIFIED);
				$Approved = ($arryPurchase[0]['Approved'] == 1)?('Yes'):('No');

				$DeliveryDate = ($arryPurchase[0]['DeliveryDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['DeliveryDate']))):(NOT_SPECIFIED);

				$PaymentTerm = (!empty($arryPurchase[0]['PaymentTerm']))? (stripslashes($arryPurchase[0]['PaymentTerm'])): (NOT_SPECIFIED);
				$PaymentMethod = (!empty($arryPurchase[0]['PaymentMethod']))? (stripslashes($arryPurchase[0]['PaymentMethod'])): (NOT_SPECIFIED);
				$ShippingMethod = (!empty($arryPurchase[0]['ShippingMethod']))? (stripslashes($arryPurchase[0]['ShippingMethod'])): (NOT_SPECIFIED);
				$Comment = (!empty($arryPurchase[0]['Comment']))? (stripslashes($arryPurchase[0]['Comment'])): (NOT_SPECIFIED);
				$AssignedEmp = (!empty($arryPurchase[0]['AssignedEmp']))? (stripslashes($arryPurchase[0]['AssignedEmp'])): (NOT_SPECIFIED);
				#$CreatedBy = ($arryPurchase[0]['AdminType'] == 'admin')? ('Administrator'): ($arryPurchase[0]['CreatedBy']);


				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."purchase_admin.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[Module]",$module,$contents);
				$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
				$contents = str_replace("[ModuleID]",$arryPurchase[0][$ModuleID],$contents);
				$contents = str_replace("[OrderDate]",$OrderDate,$contents);
				$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
				$contents = str_replace("[Approved]",$Approved,$contents);
				$contents = str_replace("[Status]",$arryPurchase[0]['Status'],$contents);
				$contents = str_replace("[OrderType]",$arryPurchase[0]['OrderType'],$contents);
				$contents = str_replace("[Comment]",$Comment,$contents);
				$contents = str_replace("[DeliveryDate]",$DeliveryDate,$contents);
				$contents = str_replace("[PaymentTerm]",$PaymentTerm,$contents);
				$contents = str_replace("[PaymentMethod]",$PaymentMethod,$contents);
				$contents = str_replace("[ShippingMethod]",$ShippingMethod,$contents);
				$contents = str_replace("[AssignedEmp]",$AssignedEmp,$contents);

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Purchase - New ".$module;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}





		function sendAssignedEmail($OrderID, $AssignedEmpID)
		{
			global $Config;	


			if($OrderID>0){

				$arryPurchase = $this->GetPurchase($OrderID,'','');
				$module = $arryPurchase[0]['Module'];

				if($module=='Quote'){	
					$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; 
				}else if($module=='Order'){
					$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID";
				}


				$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignedEmpID."'";
				$arryEmp = $this->query($strSQLQuery, 1);

				$ToEmail = $arryEmp[0]['Email'];
				$CC = $Config['AdminEmail'];

				if($arryPurchase[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = stripslashes($arryPurchase[0]['CreatedBy']);
				}
				
				$OrderDate = ($arryPurchase[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))):(NOT_SPECIFIED);				


				/**********************/
				if(!empty($ToEmail)){
					$htmlPrefix = $Config['EmailTemplateFolder'];				
					$contents = file_get_contents($htmlPrefix."purchase_assigned.htm");
					
					$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
					$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

					$contents = str_replace("[Module]",$module,$contents);
					$contents = str_replace("[Action]",$Action,$contents);
					$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
					$contents = str_replace("[ModuleID]",$arryPurchase[0][$ModuleID],$contents);
					$contents = str_replace("[OrderDate]",$OrderDate,$contents);
					$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
					$contents = str_replace("[Status]",$arryPurchase[0]['Status'],$contents);
					$contents = str_replace("[OrderType]",$arryPurchase[0]['OrderType'],$contents);
					$contents = str_replace("[UserName]",$arryEmp[0]['UserName'],$contents);
						
					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($ToEmail);
					if(!empty($CC)) $mail->AddCC($CC);
					$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - Purchase ".$module." has been assigned";
					$mail->IsHTML(true);
					$mail->Body = $contents;  
					//echo $ToEmail.$CC.$contents; exit;
					if($Config['Online'] == '1'){
						$mail->Send();	
					}
				}



			}

			return 1;
		}










	
}
?>
