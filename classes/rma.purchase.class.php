<?
	
class purchase extends dbClass
{
		//constructor
		function purchase()
		{
			$this->dbClass();
		} 
			
		function  ListPurchase($arryDetails)
		{
			global $Config;
			extract($arryDetails);

			if($module=='Quote'){	
				$ModuleID = "QuoteID"; 
			}else{
				$ModuleID = "PurchaseID"; 
			}

			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($module))?(" and o.Module='".mysql_real_escape_string($module)."'"):("");
                        $strAddQuery .= (!empty($Order_Type))?(" and o.OrderType='".mysql_real_escape_string($Order_Type)."'"):("");

			$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.AssignedEmpID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):(""); 
                        $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");  // Added By bhoodev
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			$strAddQuery .= ($Approved==1)?(" and o.Approved='1' "):("");
			$strAddQuery .= (!empty($AssignedEmpID))?(" and o.AssignedEmpID='".mysql_real_escape_string($AssignedEmpID)."'"):("");

			if($InvoicePaid=='0'){
				$strAddQuery .= " and o.InvoicePaid!='1' ";
			}else if($InvoicePaid=='1'){
				$strAddQuery .= " and o.InvoicePaid='1' ";
			}
			
			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.OrderType like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' or o.SuppCompany like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' ) " ):("");	
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

                        
			  #$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID,  o.SaleID,o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency  from p_order o ".$strAddQuery;
		         
                        $strSQLQuery = "select o.*  from p_order o ".$strAddQuery;
		
			return $this->query($strSQLQuery, 1);		
				
		}	
		

		function  GetPurchase($OrderID,$PurchaseID,$Module)
		{

			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".mysql_real_escape_string($PurchaseID)."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".mysql_real_escape_string($Module)."'"):("");
			$strSQLQuery = "select o.* from p_order o where 1".$strAddQuery." order by o.OrderID desc";
			
			return $this->query($strSQLQuery, 1);
			
		}	

		

		function  GetPurchaseItem($OrderID)
		{
			$strAddQuery ='';
			$strAddQuery .= (!empty($OrderID))?(" and i.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			#$strSQLQuery = "select i.*,t.RateDescription from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                   $strSQLQuery = "select i.*,t.RateDescription,itm.CategoryID,itm.ItemID,c1.valuationType as evaluationType from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on (i.sku=itm.Sku OR i.item_id=itm.ItemID)   left outer join inv_categories c1 on itm.CategoryID = c1.CategoryID
where 1".$strAddQuery." order by i.id asc";
			$strSQLQuery;
                         return $this->query($strSQLQuery, 1);
		}

		function  GetInvoiceOrder($PurchaseID)
		{
			$strSQLQuery = "select OrderID from p_order o where PurchaseID='".mysql_real_escape_string($PurchaseID)."' and Module='Invoice' order by o.OrderID asc";
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);
		}	

		function  GetSuppPurchase($SuppCode,$OrderID,$PurchaseID,$Module)
		{
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".mysql_real_escape_string($SuppCode)."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".mysql_real_escape_string($PurchaseID)."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".mysql_real_escape_string($Module)."'"):("");
			$strSQLQuery = "select o.* from p_order o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
			//echo $strSQLQuery;
		}

		function AddPurchase($arryDetails)
		{ 

			//echo "<pre>"; print_r($arryDetails);die;
			global $Config;
			extract($arryDetails);

			if(empty($Currency)) $Currency =  $Config['Currency'];
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];

                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }
                        
			$strSQLQuery = "insert into p_order(Module, OrderType, OrderDate,  PurchaseID, QuoteID, InvoiceID, CreditID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, Freight, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp, Taxable, SaleID, taxAmnt , tax_auths, TaxRate,CustCode,ReceiptStatus) values('".$Module."', '".$OrderType."', '".$OrderDate."',  '".$PurchaseID."', '".$QuoteID."', '".$InvoiceID."', '".$CreditID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '".$ClosedDate."', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '".addslashes($Freight)."', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."', '".addslashes($Taxable)."', '".addslashes($SaleID)."', '".addslashes($taxAmnt)."', '".addslashes($tax_auths)."', '".addslashes($MainTaxRate)."','".$CustCode."','".$ReceiptStatus."')";
            //echo $strSQLQuery;\
            
			
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
			$totalTaxAmnt = 0;$taxAmnt=0;
			for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['sku'.$i])){
					$arryTax = explode(":",$arryDetails['tax'.$i]);
					
					$id = $arryDetails['id'.$i];

					if($arryTax[1] > 0){
					 $actualAmnt = ($arryDetails['price'.$i]-$arryDetails['discount'.$i])*$arryDetails['qty'.$i];	
					 $taxAmnt = ($actualAmnt*$arryTax[1])/100;
					 $totalTaxAmnt += $taxAmnt;
					}





					if($id>0){
						$sql = "update p_order_item set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."',`Condition`='".addslashes($arryDetails['Condition'.$i])."', description='".addslashes($arryDetails['description'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."', qty='".addslashes($arryDetails['qty'.$i])."', price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."',Taxable='".addslashes($arryDetails['item_taxable'.$i])."' ,DropshipCheck='".addslashes($arryDetails['DropshipCheck'.$i])."' ,DropshipCost='".addslashes($arryDetails['DropshipCost'.$i])."' ,DesComment='".addslashes($arryDetails['DesComment'.$i])."' where id='".$id."'"; 
					}else{
						$sql = "insert into p_order_item(OrderID, item_id, sku, description, on_hand_qty, qty, price, tax_id, tax, amount, Taxable, DropshipCheck, DropshipCost,`Condition`, DesComment) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".$arryTax[0]."', '".$arryTax[1]."', '".addslashes($arryDetails['amount'.$i])."','".addslashes($arryDetails['item_taxable'.$i])."' ,'".addslashes($arryDetails['DropshipCheck'.$i])."' ,'".addslashes($arryDetails['DropshipCost'.$i])."','".addslashes($arryDetails['Condition'.$i])."','".addslashes($arryDetails['DesComment'.$i])."')";


						/*******Notification on changing the Vendor price*********/
						if($Module=='Quote' || $Module=='Order'){
							$sql_supp = "select od.price as OldSuppPrice from p_order o inner join p_order_item od on o.OrderID=od.OrderID where o.SuppCode='".$SuppCode."' and o.Module in ('Order','Quote') and od.sku='".$arryDetails['sku'.$i]."' order by o.OrderID desc limit 0,1";						
							$rs = $this->query($sql_supp);
							if($rs[0]['OldSuppPrice']>0 && $rs[0]['OldSuppPrice']!=$arryDetails['price'.$i]){
								$arryNotification['refID'] = $arryDetails['sku'.$i];
								$arryNotification['refType'] = "Supp_PO_Price";
								$arryNotification['Name'] = $arryDetails['description'.$i];
								$arryNotification['Subject'] = "Vendor PO Price for SKU: [".$arryDetails['sku'.$i].'] has been changed';
								$arryNotification['Message'] = 'PO Price for Item: '.$arryDetails['description'.$i].', [SKU: '.$arryDetails['sku'.$i].'] has been changed from '.$Config['Currency'].' '.$rs[0]['OldSuppPrice'].' to '.$Config['Currency'].' '.$arryDetails['price'.$i].' by Vendor: '.$SuppCompany.' [<a class="fancybox fancybox.iframe" href="suppInfo.php?view='.$SuppCode.'" >'.$SuppCode.'</a>]';
								$objConfigure=new configure();
								$objConfigure->AddNotification($arryNotification);
							}
							
						}

						/***********************************************************/
					}
					$this->query($sql, 0);	

				}
			}



			/*$strSQL = "update p_order set taxAmnt = '".$totalTaxAmnt."' where OrderID='".$order_id."'"; 
			$this->query($strSQL, 0);*/


			return true;

		}
                
               function AddItemForInvoiceEntry($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			if(!empty($DelItem)){
				$strSQLQuery = "delete from p_order_item where id in(".$DelItem.")"; 
				$this->query($strSQLQuery, 0);
			}
			$totalTaxAmnt = 0;$taxAmnt=0;
			for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['sku'.$i])){
					$arryTax = explode(":",$arryDetails['tax'.$i]);
					
					$id = $arryDetails['id'.$i];

					if($arryTax[1] > 0){
					 $actualAmnt = ($arryDetails['price'.$i]-$arryDetails['discount'.$i])*$arryDetails['qty'.$i];	
					 $taxAmnt = ($actualAmnt*$arryTax[1])/100;
					 $totalTaxAmnt += $taxAmnt;
					}
                                        
                                        if(isset($arryDetails['DropshipCheck'.$i])){$DropshipCheck = 1;$serial_value='';}else{$DropshipCheck = 0;$serial_value=trim($arryDetails['serial_value'.$i]);}


					if($id>0){
						$sql = "update p_order_item set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."',`Condition`='".addslashes($arryDetails['Condition'.$i])."', description='".addslashes($arryDetails['description'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."', qty='".addslashes($arryDetails['qty'.$i])."', price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."',Taxable='".addslashes($arryDetails['item_taxable'.$i])."'  where id='".$id."'"; 
					}else{
						$sql = "insert into p_order_item(OrderID, item_id, sku, description, on_hand_qty, qty,qty_received, price, tax_id, tax, amount, Taxable,DropshipCheck,DropshipCost,SerialNumbers,`Condition`) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."','".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".$arryTax[0]."', '".$arryTax[1]."', '".addslashes($arryDetails['amount'.$i])."','".addslashes($arryDetails['item_taxable'.$i])."','1','".addslashes($arryDetails['DropshipCost'.$i])."','".addslashes($serial_value)."','".addslashes($arryDetails['Condition'.$i])."')";


						/*******Notification on changing the Vendor price*********/
						//if($Module=='Quote' || $Module=='Order'){
							$sql_supp = "select od.price as OldSuppPrice from p_order o inner join p_order_item od on o.OrderID=od.OrderID where o.SuppCode='".$SuppCode."' and o.Module in ('Order','Quote') and od.sku='".$arryDetails['sku'.$i]."' order by o.OrderID desc limit 0,1";						
							$rs = $this->query($sql_supp);
							if($rs[0]['OldSuppPrice']>0 && $rs[0]['OldSuppPrice']!=$arryDetails['price'.$i]){
								$arryNotification['refID'] = $arryDetails['sku'.$i];
								$arryNotification['refType'] = "Supp_PO_Price";
								$arryNotification['Name'] = $arryDetails['description'.$i];
								$arryNotification['Subject'] = "Vendor PO Price for SKU: [".$arryDetails['sku'.$i].'] has been changed';
								$arryNotification['Message'] = 'PO Price for Item: '.$arryDetails['description'.$i].', [SKU: '.$arryDetails['sku'.$i].'] has been changed from '.$Config['Currency'].' '.$rs[0]['OldSuppPrice'].' to '.$Config['Currency'].' '.$arryDetails['price'.$i].' by Vendor: '.$SuppCompany.' [<a class="fancybox fancybox.iframe" href="suppInfo.php?view='.$SuppCode.'" >'.$SuppCode.'</a>]';
								$objConfigure=new configure();
								$objConfigure->AddNotification($arryNotification);
							}
							
						//}

						
                                                        
					}
					$this->query($sql, 0);	
                                        
                                        
                                          /********************CODE FOR ADD SERIAL NUMBERS*******************************************/
                                                
                                                    if ($arryDetails['serial_value' . $i] != '') {
                                                            $serial_no = explode(",", $arryDetails['serial_value' . $i]);

                                                            for ($j = 0; $j < sizeof($serial_no); $j++) {
                                                                    $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,UsedSerial,ReceiveOrderID)  values ('" .$wCode. "','" . $serial_no[$j] . "','" .addslashes($arryDetails['sku'.$i]). "','0','" . $order_id . "')";
                                                                    $this->query($strSQLQuery, 0);
                        
                                                            }
                                                    }
                                                
                                                /***********************END CODE**********************************************/

				}
			}



			/*$strSQL = "update p_order set taxAmnt = '".$totalTaxAmnt."' where OrderID='".$order_id."'"; 
			$this->query($strSQL, 0);*/


			return true;

		}


		function UpdatePurchase($arryDetails){ 
			global $Config;
			extract($arryDetails);	

			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];
                        
                      	if(empty($Currency)) $Currency =  $Config['Currency'];

                        
                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }

			$strSQLQuery = "update p_order set  OrderType='".$OrderType."', OrderDate='".$OrderDate."', Approved='".$Approved."', Status='".$Status."',   ClosedDate='".$ClosedDate."', wCode='".$wCode."', DropShip='".$DropShip."', DeliveryDate='".$DeliveryDate."',Comment='".addslashes(strip_tags($Comment))."', SuppCode='".addslashes($SuppCode)."',  SuppCompany='".addslashes($SuppCompany)."', SuppContact='".addslashes($SuppContact)."', Address='".addslashes($Address)."', City='".addslashes($City)."', State='".addslashes($State)."', Country='".addslashes($Country)."', ZipCode='".addslashes($ZipCode)."' , Currency='".addslashes($Currency)."' , SuppCurrency='".addslashes($SuppCurrency)."', Mobile='".addslashes($Mobile)."' ,Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' ,Email='".addslashes($Email)."' ,  wName='".addslashes($wName)."', wContact='".addslashes($wContact)."', wAddress='".addslashes($wAddress)."', wCity='".addslashes($wCity)."', wState='".addslashes($wState)."', wCountry='".addslashes($wCountry)."', wZipCode='".addslashes($wZipCode)."' , wMobile='".addslashes($wMobile)."' ,wLandline='".addslashes($wLandline)."',wEmail='".addslashes($wEmail)."', TotalAmount='".addslashes($TotalAmount)."' ,Freight='".addslashes($Freight)."'	,UpdatedDate = '".$Config['TodayDate']."', PaymentMethod='".addslashes($PaymentMethod)."', ShippingMethod='".addslashes($ShippingMethod)."', PaymentTerm='".addslashes($PaymentTerm)."', AssignedEmpID='".addslashes($EmpID)."', AssignedEmp='".addslashes($EmpName)."',Taxable='".addslashes($Taxable)."' ,SaleID='".addslashes($SaleID)."', taxAmnt ='".addslashes($taxAmnt)."', tax_auths='".addslashes($tax_auths)."', TaxRate='".addslashes($MainTaxRate)."', CustCode = '".$CustCode."', ReceiptStatus = '".$ReceiptStatus."' where OrderID='".mysql_real_escape_string($OrderID)."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}
                
                
                function getReceiveInvoiceID($order_id){
                    
                    $strSQLQuery = "select InvoiceID from p_order  where OrderID = '".$order_id."'";
		    $rows = $this->query($strSQLQuery, 1);
                    return $rows[0]['InvoiceID'];
                }
                
                 

	
		function ReceiveOrder($arryDetails)	{
			
			
			global $Config;
			extract($arryDetails);

			
			if(!empty($ReceiveOrderID)){
				$arryPurchase = $this->GetPurchase($ReceiveOrderID,'','');
				//echo "<pre>";print_r($arryPurchase);exit;
				$arryPurchase[0]["Module"] = "Invoice";
				$arryPurchase[0]["ModuleID"] = "InvoiceID";
				$arryPurchase[0]["PrefixPO"] = "INV";
				$arryPurchase[0]["ReceivedDate"] = $ReceivedDate;
				$arryPurchase[0]["Freight"] = $Freight;
				$arryPurchase[0]["taxAmnt"] = $taxAmnt;
				$arryPurchase[0]["tax_auths"] = $tax_auths;
				$arryPurchase[0]["TotalAmount"] = $TotalAmount;	
				$arryPurchase[0]["InvoicePaid"] = $InvoicePaid;	
				$arryPurchase[0]["InvoiceComment"] = $InvoiceComment;	
				$arryPurchase[0]["EmpID"] = $arryPurchase[0]['AssignedEmpID'];	
				$arryPurchase[0]["EmpName"] = $arryPurchase[0]['AssignedEmp'];	
				$arryPurchase[0]["Status"] = "Invoicing";			
				$arryPurchase[0]["InvoiceID"] = $InvoiceID;				
				$arryPurchase[0]["MainTaxRate"] = $arryPurchase[0]['TaxRate'];	
				$arryPurchase[0]["ReceiptStatus"] = $ReceiptStatus;
				$order_id = $this->AddPurchase($arryPurchase[0]);
                                
                                //GET InvoiceID
                                
                                $ReceiveInvoiceID = $this->getReceiveInvoiceID($order_id);
                                
                                //SET TRANSACTION DATA
                                $arryTransaction['TransactionOrderID'] = $order_id;
                                $arryTransaction['TransactionInvoiceID'] = $ReceiveInvoiceID;
                                $arryTransaction['TransactionDate'] = $ReceivedDate;
                                $arryTransaction['TransactionType'] = 'PO Invoice';
                                $objItem = new items();
                                $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='PO');
                               
				/******** Item Updation for Invoice ************/
				$arryItem = $this->GetPurchaseItem($ReceiveOrderID);
				$NumLine = sizeof($arryItem);
                                
                        
                                
				$totalTaxAmnt = 0;$taxAmnt=0;
				for($i=1;$i<=$NumLine;$i++){
					$Count=$i-1;
					
					if(!empty($arryDetails['id'.$i]) && $arryDetails['qty'.$i]>0){
						$qty_received = $arryDetails['qty'.$i];

						if($arryItem[$Count]["tax"] > 0){
							$actualAmnt = ($arryItem[$Count]["price"]-$arryItem[$Count]["discount"])*$arryDetails['qty'.$i]; 	
							$taxAmnt = ($actualAmnt*$arryItem[$Count]["tax"])/100;
							$totalTaxAmnt += $taxAmnt;
						}


                                                if($arryDetails['DropshipCheck'.$i] == 'Drop Ship'){$DropshipCheck = 1;$serial_value='';}else{$DropshipCheck = 0;$serial_value=trim($arryDetails['serial_value'.$i]);}
                                                
						$sql = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, price, tax_id, tax, amount,Taxable, DropshipCheck, DropshipCost,SerialNumbers,`Condition`) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_received."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."', '".addslashes($arryItem[$Count]["DropshipCheck"])."' ,'".addslashes($arryItem[$Count]["DropshipCost"])."','".addslashes($serial_value)."','".$arryItem[$Count]["Condition"]."')";

						$this->query($sql, 0);	
                                                
                                                
                                                
                                                /***********************UPDATE STOCK QUNT************************************/
                                                        
                                                        
					if($_POST['ReceiptStatus'] !='Parked'){
			$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+" .$qty_received. "  where Sku='" .$arryItem[$Count]["sku"]. "' and ItemID ='".$arryItem[$Count]["item_id"]."'";
		    $this->query($UpdateQtysql, 0);
						
						}
                                               
                                                        
                                               /******************************************************************/         
                                                
                                                /********************CODE FOR ADD SERIAL NUMBERS*******************************************/
                                                
                                                    if ($arryDetails['serial_value' . $i] != '') {
                                                            $serial_no = explode(",", $arryDetails['serial_value' . $i]);

                                                            for ($j = 0; $j < sizeof($serial_no); $j++) {
                                                                    $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,UsedSerial,ReceiveOrderID)  values ('" . $arryPurchase[0]['wCode'] . "','" . $serial_no[$j] . "','" . addslashes($arryItem[$Count]["sku"]) . "','0','" . $order_id . "')";
                                                                    $this->query($strSQLQuery, 0);
                        
                                                            }
                                                    }
                                                
                                                /***********************END CODE**********************************************/

					}
				}

				//echo $order_id; exit;

				/*$strSQL = "update p_order set taxAmnt = '".$totalTaxAmnt."' where OrderID='".$order_id."'"; 
				$this->query($strSQL, 0);*/



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


			}


			return $order_id;
		}
                
                
                function ReceiveOrderInvoiceEntry($arryDetails)	{
			 
                        global $Config;
			extract($arryDetails);
                        
                        if($Config['CronEntry']==1){ //cron entry
				$EntryType = 'one_time';
				$InvoiceID = '';	
			}else{

                            
                            if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];
                            
                            $CreatedBy = $_SESSION['UserName'];
			    $AdminID = $_SESSION['AdminID'];
			    $AdminType = $_SESSION['AdminType'];
                        }

                         if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}
                         
                        if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                        if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                        if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                        if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}
                         
                         if(empty($Currency)) $Currency =  $Config['Currency'];

                     $strSQLQuery = "insert into p_order set Module='Invoice',
                                        PurchaseID = '".$ReferenceNo."',
                                        InvoiceID  = '".$InvoiceID."',
                                            OrderType = '".$OrderType."',
                                            wCode  = '".$wCode."',
                                        Approved  = '1',
                                        Comment  = '".addslashes(strip_tags($Comment))."',
                                        SuppCode  = '".addslashes($SuppCode)."',
                                        SuppCompany  = '".addslashes($SuppCompany)."',  
                                        SuppContact  = '".addslashes($SuppContact)."',   
                                        Address  = '".addslashes($Address)."',   
                                        City  = '".addslashes($City)."',
                                        State  = '".addslashes($State)."',
                                        Country  = '".addslashes($Country)."',
                                        ZipCode  = '".addslashes($ZipCode)."',   
                                        Currency  = '".$Currency."',
                                        SuppCurrency  = '".addslashes($SuppCurrency)."',
                                        Mobile  = '".addslashes($Mobile)."',
                                        Landline  = '".addslashes($Landline)."',
   
                                        Fax  = '".addslashes($Fax)."',
                                        Email  = '".addslashes($Email)."',
                                        wName  = '".addslashes($wName)."',
                                        wContact  = '".addslashes($wContact)."',
                                        wAddress  = '".addslashes($wAddress)."',
                                        wCity  = '".addslashes($wCity)."',
                                        wState  = '".addslashes($wState)."',
                                        wCountry  = '".addslashes($wCountry)."', 
                                        wZipCode  = '".addslashes($wZipCode)."',
                                        wMobile  = '".addslashes($wMobile)."',
                                        wLandline  = '".addslashes($wLandline)."',
                                        wEmail  = '".addslashes($wEmail)."',    
                                        TotalAmount  = '".addslashes($TotalAmount)."',
                                        Freight  = '".addslashes($Freight)."',
					taxAmnt  = '".addslashes($taxAmnt)."',
					tax_auths  = '".addslashes($tax_auths)."',
					TaxRate  = '".addslashes($MainTaxRate)."',
                                        CreatedBy  = '".addslashes($CreatedBy)."',
                                        AdminID  = '".$AdminID."', 
                                        AdminType  = '".$AdminType."',
                                        PostedDate  = '".$Config['TodayDate']."',
                                        UpdatedDate  = '".$Config['TodayDate']."',
                                        ReceivedDate  = '".$ReceivedDate."', 
                  
                                        InvoicePaid  = '".$InvoicePaid."',
                                        InvoiceComment  = '".addslashes(strip_tags($InvoiceComment))."',
                                        PaymentMethod  = '".addslashes($PaymentMethod)."',
                                        ShippingMethod  = '".addslashes($ShippingMethod)."', 

                                        PaymentTerm  = '".addslashes($PaymentTerm)."',
                                        AssignedEmpID  = '".addslashes($EmpID)."',
                                        AssignedEmp  = '".addslashes($EmpName)."',
                                        Taxable  = '".addslashes($Taxable)."',
                                        InvoiceEntry='1',EntryType='".$EntryType."',
                                            EntryInterval='".$EntryInterval."',
                                            EntryMonth='".$EntryMonth."',    
                                            EntryFrom='".$EntryFrom."',
                                            EntryWeekly = '".$EntryWeekly."',    
                                            EntryTo='".$EntryTo."',
                                            EntryDate='".$EntryDate."',
                                            ReceiptStatus='".$ReceiptStatus."'";
                     
                     
                                    $this->query($strSQLQuery, 0);
                                    $OrderID = $this->lastInsertId();

			if(empty($InvoiceID)){
				$InvoiceID = 'INV000'.$OrderID;
				$strSQL = "update p_order set InvoiceID ='".$InvoiceID."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}

			return $OrderID;

		}


		function  GetPurchasedItem($SuppCode,$OrderID,$PurchaseID,$Module)
		{
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".mysql_real_escape_string($SuppCode)."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".mysql_real_escape_string($PurchaseID)."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".mysql_real_escape_string($Module)."'"):("");
			$strSQLQuery = "select o.OrderID,o.PurchaseID,o.OrderDate,o.Currency, i.item_id,i.sku,i.qty,i.Condition,i.description,i.price from p_order o inner join p_order_item i on o.OrderID=i.OrderID where o.Status='Completed' and o.Approved='1' ".$strAddQuery." order by o.OrderID desc ";
			return $this->query($strSQLQuery, 1);
			
		}

		function  ListInvoice($arryDetails)
		{
			global $Config;
			extract($arryDetails);

			$strAddQuery = "where o.Module='Invoice' ";
			$SearchKey   = strtolower(trim($key));
			
			if($_SESSION['vAllRecord']!=1){
			$strAddQuery .= " and (o.AssignedEmpID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') ";				
			}

                        $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");  // Added By bhoodev
			$strAddQuery .= (!empty($po))?(" and o.PurchaseID='".mysql_real_escape_string($po)."'"):("");	
			$strAddQuery .= (!empty($FPostedDate))?(" and o.PostedDate>='".$FPostedDate."'"):("");
			$strAddQuery .= (!empty($TPostedDate))?(" and o.PostedDate<='".$TPostedDate."'"):("");
			$strAddQuery .= (!empty($FOrderDate))?(" and o.OrderDate>='".$FOrderDate."'"):("");
			$strAddQuery .= (!empty($TOrderDate))?(" and o.OrderDate<='".$TOrderDate."'"):("");
                        
			/*if($InvoicePaid=='0'){
				$strAddQuery .= " and o.InvoicePaid!='1' ";
			}else if($InvoicePaid=='1'){
				$strAddQuery .= " and o.InvoicePaid='1' ";
			}*/
                        
                        
                       /* if($InvoicePaid==1){
                            $strAddQuery .= " and o.InvoicePaid = '1' ";
                        }elseif($InvoicePaid == 2){
                            $strAddQuery .= " and o.InvoicePaid = '2' ";
                        }else{
                            $strAddQuery .= " and o.InvoicePaid = ' ' ";
                        }*/


			if($SearchKey=='paid' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
				$strAddQuery .= " and o.InvoicePaid='1'"; 
			}else if($SearchKey=='unpaid' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
				$strAddQuery .= " and o.InvoicePaid!='1' and o.InvoicePaid!='2'";
			}else if($SearchKey=='partially paid' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
				$strAddQuery .= " and o.InvoicePaid='2' ";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.InvoiceID like '%".$SearchKey."%'  or o.PurchaseID like '%".$SearchKey."%'  or o.SuppCompany like '%".$SearchKey."%'  or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' ) " ):("");	
			}


			if($_SESSION['AdminType']=="employee"){			
				$strAddQuery .=  " and (o.SuppCode not in (select  p.SuppCode from permission_vendor p where p.EmpID='".$_SESSION['AdminID']."')  OR o.AdminID='".$_SESSION['AdminID']."')";
			}

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");
			$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");

			#$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID, o.InvoiceID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid,o.InvoiceEntry,o.ExpenseID from p_order o ".$strAddQuery;
		        
                         $strSQLQuery = "select o.* from p_order o ".$strAddQuery;
                         
                         //echo $strSQLQuery;
		                
			return $this->query($strSQLQuery, 1);		
				
		}


		function  ListReturn($arryDetails)
		{
			global $Config;
			extract($arryDetails);
	
			$strAddQuery = "where o.Module='Return' ";
			$SearchKey   = strtolower(trim($key));

			$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.AssignedEmpID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):(""); 

			$strAddQuery .= (!empty($po))?(" and o.PurchaseID='".mysql_real_escape_string($po)."'"):("");
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
		
			  //echo $strSQLQuery;
		
			return $this->query($strSQLQuery, 1);		
				
		}
		
		

		function UpdateInvoice($arryDetails){ 
			global $Config;
			extract($arryDetails);
			if(!empty($OrderID)){
				$strSQLQuery = "update p_order set ReceivedDate='".$ReceivedDate."', PaymentDate='".$PaymentDate."', InvoicePaid='".$InvoicePaid."', InvPaymentMethod='".$InvPaymentMethod."', PaymentRef='".addslashes($PaymentRef)."', InvoiceComment='".addslashes(strip_tags($InvoiceComment))."', UpdatedDate = '".$Config['TodayDate']."'
				where OrderID='".mysql_real_escape_string($OrderID)."'"; 
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}



		function ReturnOrder($arryDetails)	{
			global $Config;
			extract($arryDetails);

			if(!empty($ReturnOrderID)){
				$arryPurchase = $this->GetPurchase($ReturnOrderID,'','');
				$arryPurchase[0]["Module"] = "Return";
				$arryPurchase[0]["ModuleID"] = "ReturnID";
				$arryPurchase[0]["PrefixPO"] = "RTN";
				$arryPurchase[0]["ReceivedDate"] = $ReceivedDate;
				$arryPurchase[0]["Freight"] = $Freight;
				$arryPurchase[0]["taxAmnt"] = $taxAmnt;
				$arryPurchase[0]["tax_auths"] = $tax_auths;
				$arryPurchase[0]["TotalAmount"] = $TotalAmount;	
				$arryPurchase[0]["InvoicePaid"] = $InvoicePaid;	
				$arryPurchase[0]["InvoiceComment"] = $InvoiceComment;	
				$arryPurchase[0]["EmpID"] = $arryPurchase[0]['AssignedEmpID'];	
				$arryPurchase[0]["EmpName"] = $arryPurchase[0]['AssignedEmp'];	
				$arryPurchase[0]["EmpID"] = $arryPurchase[0]['AssignedEmpID'];	
				$arryPurchase[0]["EmpName"] = $arryPurchase[0]['AssignedEmp'];	
				$arryPurchase[0]["MainTaxRate"] = $arryPurchase[0]['TaxRate'];	
				$order_id = $this->AddPurchase($arryPurchase[0]);


				/******** Item Updation for Return ************/
				$arryItem = $this->GetPurchaseItem($ReturnOrderID);
				$NumLine = sizeof($arryItem);
				for($i=1;$i<=$NumLine;$i++){
					$Count=$i-1;
				
					if(!empty($arryDetails['id'.$i]) && $arryDetails['qty'.$i]>0){
						$qty_returned = $arryDetails['qty'.$i];
						$sql = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_returned, price, tax_id, tax, amount, Taxable,`Condition`, DesComment) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_returned."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."','".$arryItem[$Count]["Condition"]."','".$arryItem[$Count]["DesComment"]."')";

						$this->query($sql, 0);	

     
                                                /***********************UPDATE STOCK QUNT************************************/
                                                        
                                                        
	    $UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand-" .$qty_returned . "  where Sku='" .$arryItem[$Count]["sku"]. "' and ItemID ='".$arryItem[$Count]["item_id"]."'";
		    $this->query($UpdateQtysql, 0);
                                               
                                                        
                                               /******************************************************************/         


					}
				}
			}

			return $order_id;
		}
		
		
		/********************************/
		
		
		


		function UpdateReturn($arryDetails){ 
			global $Config;
			extract($arryDetails);
			if(!empty($OrderID)){
				$strSQLQuery = "update p_order set ReceivedDate='".$ReceivedDate."', PaymentDate='".$PaymentDate."', InvoicePaid='".$InvoicePaid."', InvPaymentMethod='".$InvPaymentMethod."', PaymentRef='".addslashes($PaymentRef)."', InvoiceComment='".addslashes(strip_tags($InvoiceComment))."', UpdatedDate = '".$Config['TodayDate']."'
				where OrderID='".mysql_real_escape_string($OrderID)."'"; 
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}
		
		
              /****************************/
		
		

		function  ListCreditNote($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = " where o.Module='Credit' ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($FromDate))?(" and (o.PostedDate>='".$FromDate."' OR o.ClosedDate>='".$FromDate."') "):("");
			$strAddQuery .= (!empty($ToDate))?(" and (o.PostedDate<='".$ToDate."' OR o.ClosedDate<='".$ToDate."') "):("");
                        $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");  // Added By bhoodev
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

			$strAddQuery .= (!empty($sortby) & !empty($asc))?(" order by ".$sortby." ".$asc):(" order by o.PostedDate desc,OrderID desc");
			//$strAddQuery .= (!empty($asc))?($asc):("");

			#$strSQLQuery = "select o.ClosedDate, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.CreditID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency  from p_order o ".$strAddQuery;
		    $strSQLQuery = "select o.* from p_order o ".$strAddQuery;
		        
		        
		
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
			//var_dump($arryItem);
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
                        global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SuppCode))?(" and p.SuppCode='".$SuppCode."'"):("");

			$strSQLQuery = "select p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,o.OrderDate, o.PostedDate, o.SuppCode, o.SuppCompany  from  f_payments p left outer join p_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Purchase') where o.Module='Invoice' and o.ReturnID='' and o.CreditID=''  ".$strAddQuery." order by p.PaymentDate desc,p.PaymentID desc";
				
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
			global $Config;
			$objFunction=new functions();
			$objConfig=new admin();	

			if(!empty($OrderID)){
				$strSQLQuery = "select ReturnID from p_order where OrderID='".$OrderID."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
			
				/******Delete PDF**********/ 
				$PdfFile = "PurchaseRMA-".$arryRow[0]['ReturnID'].'.pdf';
				$objFunction->DeleteFileStorage($Config['P_Rma'],$PdfFile);		
				
				
				$PdfTemplateArray = array('ModuleDepName' => "PurchaseRMA",  'PdfDir' => $Config['P_Rma'], 'TableName' => 'p_order', 'OrderID' => $OrderID, 'ModuleID' => "ReturnID");
				$objConfig->DeleteAllPdfTemplate($PdfTemplateArray);
				/**************************/

				$strSQLQuery = "delete from p_order where OrderID='".mysql_real_escape_string($OrderID)."'"; 
				$this->query($strSQLQuery, 0);

				$strSQLQuery = "delete from p_order_item where OrderID='".mysql_real_escape_string($OrderID)."'"; 
				$this->query($strSQLQuery, 0);	
			}

			return 1;

		}

		function  GetQtyReceived($id)
		{
		
			if($id>0){
				$sql = "select i.qty_received as QtyReceived from p_order_item i where i.ref_id='".$id."' group by i.ref_id";
				$rs = $this->query($sql);
				if(!empty($rs[0]['QtyReceived'])) return $rs[0]['QtyReceived'];
			}
			
		}

		function  GetQtyOrderded($id)
		{
			$sql = "select i.qty as QtyOrderded from p_order_item i where i.id='".$id."'";
			$rs = $this->query($sql);
			if(!empty($rs[0]['QtyOrderded']))  return $rs[0]['QtyOrderded'];
		}

		function  GetQtyReturned($id)
		{
			$sql = "select sum(i.qty_returned) as QtyReturned from p_order_item i where i.ref_id='".$id."' group by i.ref_id";
			$rs = $this->query($sql);
			//echo $sql; 
			if(!empty($rs[0]['QtyReturned']))  return $rs[0]['QtyReturned'];
		}
		
		function  GetQtyRma($id)
		{
			$sql = "select sum(i.qty) as QtyRma from p_order_item i inner join p_order o on i.OrderID=o.OrderID where i.ref_id='".$id."' and o.Module='RMA' group by i.ref_id";
			$rs = $this->query($sql);
			//echo $sql; 
			if(!empty($rs[0]['QtyRma'])) return $rs[0]['QtyRma'];
		}

		
		function  GetQtyInvoiced($id)
		{
			$sql = "select i.qty_received from p_order_item i where i.id='".$id."' ";
			$rs = $this->query($sql);
			//echo $sql; 
			if(!empty($rs[0]['qty_received'])) return $rs[0]['qty_received'];
		}


		function ConvertToPo($OrderID,$PurchaseID)
		{
			if(empty($PurchaseID)){
				$PurchaseID = 'PO000'.$OrderID;
			}
			if(!empty($OrderID)){
				$sql="update p_order set Module='Order',PurchaseID='".$PurchaseID."' where OrderID='".mysql_real_escape_string($OrderID)."'";
				$this->query($sql,0);	
			}

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
			$strSQLQuery = "select OrderID from p_order where Module='RMA' and ReturnID='".trim($ReturnID)."'".$strSQLQuery;

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
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
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
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
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
					
					$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
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



		function sendInvPayEmail($OrderID)
		{
			global $Config;	


			if($OrderID>0){
				$arryPurchase = $this->GetPurchase($OrderID,'','');
				$module = $arryPurchase[0]['Module']; 
				
				$PostedDate = ($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED);

				$ReceivedDate = ($arryPurchase[0]['ReceivedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_SPECIFIED);

				$PaymentDate = ($arryPurchase[0]['PaymentDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))):(NOT_SPECIFIED);


				$PaymentTerm = (!empty($arryPurchase[0]['PaymentTerm']))? (stripslashes($arryPurchase[0]['PaymentTerm'])): (NOT_SPECIFIED);
				$InvPaymentMethod = (!empty($arryPurchase[0]['InvPaymentMethod']))? (stripslashes($arryPurchase[0]['InvPaymentMethod'])): (NOT_SPECIFIED);
				$PaymentRef = (!empty($arryPurchase[0]['PaymentRef']))? (stripslashes($arryPurchase[0]['PaymentRef'])): (NOT_SPECIFIED);


				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."invoice_pay_admin.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[InvoiceID]",$arryPurchase[0]['InvoiceID'],$contents);
				$contents = str_replace("[PurchaseID]",$arryPurchase[0]['PurchaseID'],$contents);
				$contents = str_replace("[PostedDate]",$PostedDate,$contents);
				$contents = str_replace("[ReceivedDate]",$ReceivedDate,$contents);
				$contents = str_replace("[TotalAmount]",$arryPurchase[0]['TotalAmount'],$contents);
				$contents = str_replace("[Currency]",$arryPurchase[0]['Currency'],$contents);
				$contents = str_replace("[PaymentDate]",$PaymentDate,$contents);
				$contents = str_replace("[InvPaymentMethod]",$InvPaymentMethod,$contents);
				$contents = str_replace("[PaymentRef]",$PaymentRef,$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Payment Received for Invoice # ".$arryPurchase[0]['InvoiceID'];
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}



		function sendOrderToSupplier($arrDetails)
		{
			global $Config;	
			extract($arrDetails);

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
				$Message = (!empty($Message))? ($Message): (NOT_SPECIFIED);
				
				#$CreatedBy = ($arryPurchase[0]['AdminType'] == 'admin')? ('Administrator'): ($arryPurchase[0]['CreatedBy']);


				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."purchase_supp.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
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
				$contents = str_replace("[Message]",$Message,$contents);
				$contents = str_replace("[DeliveryDate]",$DeliveryDate,$contents);
				$contents = str_replace("[PaymentTerm]",$PaymentTerm,$contents);
				$contents = str_replace("[PaymentMethod]",$PaymentMethod,$contents);
				$contents = str_replace("[ShippingMethod]",$ShippingMethod,$contents);
				$contents = str_replace("[Supplier]",stripslashes($arryPurchase[0]['SuppCompany']),$contents);

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Purchase ".$module;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $ToEmail.$CCEmail.$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}

	
		function AlterSaleItem($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			$objSale = new sale();
			$arrySale = $objSale->GetSale('',$SaleID,'Order');	
			if($arrySale[0]['OrderID']>0){				
				$arrRate = explode(":",$arrySale[0]['TaxRate']);
				$TaxRate = $arrRate[2];
				if(!empty($DelItemID)){
					$strSQLQuery = "delete from s_order_item where item_id in(".$DelItemID.") and OrderID='".$arrySale[0]['OrderID']."'";
					$this->query($strSQLQuery, 0);
				}
				unset($DelItem);
		/*********************************/
		/*********************************/
		$TotalAmount=0;	 $taxAmnt=0;
		for($i=1;$i<=$NumLine;$i++){					
			if(!empty($arryDetails['sku'.$i])){
						
						
		$sql = "select * from s_order_item where item_id ='".$arryDetails['item_id'.$i]."' and OrderID='".$arrySale[0]['OrderID']."'";
		$arryItemID = $this->query($sql, 1);

		$arryDetails['DropshipCheck'.$i]=1;
		$arryDetails['id'.$i] = $arryItemID[0]['id'];
		$arryDetails['tax'.$i] = $arryItemID[0]['tax_id'].':'.$arryItemID[0]['tax'];
		$arryDetails['discount'.$i] = $arryItemID[0]['discount'];
		$arryDetails['Taxable'.$i] = $arryItemID[0]['Taxable'];
		$arryDetails['item_taxable'.$i] = $arryItemID[0]['Taxable'];
		$arryDetails['req_item'.$i] = $arryItemID[0]['req_item'];
			
		$amount = (($arryDetails['price'.$i]+$arryDetails['DropshipCost'.$i])*$arryDetails['qty'.$i]) - ($arryItemID[0]['discount']*$arryDetails['qty'.$i]);	
		
		if($arrySale[0]['tax_auths']=='Yes' && $arryItemID[0]['Taxable']=='Yes'){
			$tax = ($amount*$TaxRate)/100;		
			$taxAmnt += $tax;
		}

		$arryDetails['amount'.$i] = $amount;	
		$TotalAmount += $amount;

		 }
		}

				
		$objSale->AddUpdateItem($arrySale[0]['OrderID'], $arryDetails); 

		/*****************/
		$sql2 = "select sum(amount) as OtherAmount from s_order_item where DropshipCheck!='1' and OrderID='".$arrySale[0]['OrderID']."'";
		$arryOtherAmount = $this->query($sql2, 1);

		$TotalAmount += $arrySale[0]['Freight'] + $taxAmnt + $arryOtherAmount[0]['OtherAmount'];
		$strSQL = "update s_order set TotalAmount ='".$TotalAmount."',taxAmnt ='".$taxAmnt."' where OrderID='".$arrySale[0]['OrderID']."'"; 
		$this->query($strSQL, 0);

		/*********************************/
		/*********************************/
			}

			return true;
		}



/****************Recurring Function Satrt************************************/  
   function RecurringLineItem(){       
	global $Config;
	$Config['CronEntry']=1;
	$arryDate = explode(" ", $Config['TodayDate']);
	$arryDay = explode("-", $arryDate[0]);

	$Month = (int)$arryDay[1];
	$Day = $arryDay[2];	

	$Din = date("l",strtotime($arryDate[0]));

          #$strSQLQuery = "select o.OrderID from s_order o where o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."' and o.EntryTo>='".$arryDate[0]."' and o.EntryDate='".$arryDay[2]."' and CASE WHEN o.EntryInterval='yearly' THEN o.EntryMonth='".$Month."'  ELSE 1 END = 1 ";

	 $strSQLQuery = "select o.* from p_order o where o.InvoiceEntry = '1' and o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."' and o.EntryTo>='".$arryDate[0]."' ";

          $arrySale = $this->myquery($strSQLQuery, 1);
	 
	  foreach($arrySale as $value){
		$OrderFlag=0;
		switch($value['EntryInterval']){
			case 'biweekly':
				$NumDay = 0;
				if($value['LastRecurringEntry']>0){
					$NumDay = (strtotime($arryDate[0]) - strtotime($value['LastRecurringEntry']))/(24*3600);	
				}			
				
				if($value['EntryWeekly']==$Din && ($NumDay==0 || $NumDay>10)){
					$OrderFlag=1;
				}
				break;
			case 'semi_monthly':
				if($Day=="01" || $Day=="15"){
					$OrderFlag=1;
				}
				break;
			case 'monthly':
				if($value['EntryDate']==$Day){
					$OrderFlag=1;
				}
				break;
			case 'yearly':
				if($value['EntryDate']==$Day && $value['EntryMonth']==$Month){
					$OrderFlag=1;
				}
				break;		
		
		}

		if($OrderFlag==1){
			//echo $value['OrderID'].'<br>';
			
			$NumLine = 0;
			$arryPurchaseItem = $this->GetPurchaseItem($value['OrderID']);
                       
			$NumLine = sizeof($arryPurchaseItem);		
			if($NumLine>0){			
				$order_id = $this->ReceiveOrderInvoiceEntry($value);
				
				$this->AddRecurringInvoiceItem($order_id,$arryPurchaseItem);

				$strSQL = "update p_order set LastRecurringEntry ='".$Config['TodayDate']."' where OrderID='".$value['OrderID']."'";
				$this->myquery($strSQL, 0);

			
			}	
			
			

		}



	
	  }
       	  return true;
   }
   
   
   
 function AddRecurringInvoiceItem($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			foreach($arryDetails as $values){

                            if(!empty($values['sku'])) {			          


                                    $sql = "insert into p_order_item(OrderID, item_id, sku, description, on_hand_qty, qty,qty_received, price, tax_id, tax, amount, Taxable,DropshipCheck,DropshipCost) values('".$order_id."', '".$values['item_id']."', '".addslashes($values['sku'])."', '".addslashes($values['description'])."', '".addslashes($values['on_hand_qty'])."', '".addslashes($values['qty'])."','".addslashes($values['qty'])."', '".addslashes($values['price'])."', '".addslashes($values['tax_id'])."', '".addslashes($values['tax'])."', '".addslashes($values['amount'])."','".addslashes($values['Taxable'])."','1','".addslashes($values['DropshipCost'])."')";

                                    $this->query($sql, 0);	

                                }
                         }
                
                        

			return true;

		}
		
		
		/****************** List Purchase RMA ********************/
		
		function  ListReturnRMA($arryDetails)
				{
					global $Config;
					extract($arryDetails);
			
					/*if(!empty($_GET['Module'])){
						$modulep=$_GET['Module'];
					 $strAddQuery = "where o.Module='".$modulep."'";
					}else{
						$strAddQuery = "where o.Module = 'Return'";
						//$strAddQuery = "where o.Module IN ('Return','Credit')";
					}*/
					
					$strAddQuery = "where o.Module = 'RMA'";
				
					//$strAddQuery = mysql_real_escape_string($_POST['Module']); 
					
					$SearchKey   = strtolower(trim($key));
		
					$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.AssignedEmpID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):(""); 
		
					$strAddQuery .= (!empty($po))?(" and o.PurchaseID='".mysql_real_escape_string($po)."'"):("");
					$strAddQuery .= (!empty($FPostedDate))?(" and o.PostedDate>='".$FPostedDate."'"):("");
					$strAddQuery .= (!empty($TPostedDate))?(" and o.PostedDate<='".$TPostedDate."'"):("");
		
					$strAddQuery .= (!empty($FOrderDate))?(" and p.PostedDate>='".$FOrderDate."'"):("");
					$strAddQuery .= (!empty($TOrderDate))?(" and p.PostedDate<='".$TOrderDate."'"):("");
		
					if($SearchKey=='yes' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
						$strAddQuery .= " and o.InvoicePaid='1'"; 
					}else if($SearchKey=='no' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
						$strAddQuery .= " and o.InvoicePaid!='1'";
					}else if($SearchKey != '' && $sortby == 'o.SuppCompany'){
						$strAddQuery .= " and (o.SuppCompany like '%".$SearchKey."%'  or s.UserName like '%".$SearchKey."%' or s.CompanyName like '%".$SearchKey."%' ) ";
					}else if($sortby != ''){
						$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
					}else{
						$strAddQuery .= (!empty($SearchKey))?(" and (o.InvoiceID like '%".$SearchKey."%'   or o.ReturnID like '%".$SearchKey."%'  or o.PurchaseID like '%".$SearchKey."%'  or o.SuppCompany like '%".$SearchKey."%'  or s.UserName like '%".$SearchKey."%'   or s.CompanyName like '%".$SearchKey."%'  or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' ) " ):("");	
					}
					
					//$strAddQuery .= " and o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.Status='Completed' ";
		
					$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.PostedDate Desc, o.OrderID desc ");
					
				 
					if($Config['GetNumRecords']==1){
						$Columns = " count(o.OrderID) as NumCount ";				
					}else{				
						$Columns = "  o.OrderType, o.OrderDate, o.PostedDate, o.ExpiryDate, o.Status, o.OrderID, o.PurchaseID,o.ReturnID, o.MailSend, o.InvoiceID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid, o.Module ,o.PdfFile, p.PostedDate as InvoiceDate, o.AdminType, o.AdminID, if(o.AdminType='employee',e.UserName,'Administrator') as PostedBy, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName ";
						if($Config['RecordsPerPage']>0){
							$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
						}
				
					}
		
					 $strSQLQuery = "select ".$Columns." from  p_order o left outer join p_supplier s on  o.SuppCode = s.SuppCode left outer join p_order p on (o.InvoiceID=p.InvoiceID and p.Module='Invoice' and p.ReturnID='') left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType='employee')  ".$strAddQuery;
				
				 
					
					return $this->query($strSQLQuery, 1);		
						
				}
		
		/*****************************************************/
		
		
function ReturnOrderRma($arryDetails,$DB='')	{
	
	//echo "<pre>";print_r($arryDetails);die;

			global $Config;
			extract($arryDetails);

			if(!empty($ReturnOrderID)){
				$arryPurchase = $this->GetPurchaserma($ReturnOrderID,'','',$DB);
				//print_r($arryPurchase);exit;
				$arryPurchase[0]["Module"] = 'RMA';
				$arryPurchase[0]["ModuleID"] = "ReturnID";
				$arryPurchase[0]["ReturnID"] = $ReturnID;
				$arryPurchase[0]["PrefixPO"] = "RMA";
				$arryPurchase[0]["ReceivedDate"] = $ReceivedDate;
				$arryPurchase[0]["PostedDate"] = $PostedDate;
				$arryPurchase[0]["ExpiryDate"] = $ExpiryDate;
				$arryPurchase[0]["Freight"] = $Freight;
				$arryPurchase[0]["Restocking"] = $Restocking;
				$arryPurchase[0]["Restocking_fee"] = $Restocking_fee;
				$arryPurchase[0]["taxAmnt"] = $taxAmnt;
				$arryPurchase[0]["tax_auths"] = $tax_auths;
				$arryPurchase[0]["TotalAmount"] = $TotalAmount;	
				$arryPurchase[0]["InvoicePaid"] = $InvoicePaid;	
				$arryPurchase[0]["InvoiceComment"] = $InvoiceComment;	
				$arryPurchase[0]["EmpID"] = $arryPurchase[0]['AssignedEmpID'];	
				$arryPurchase[0]["EmpName"] = $arryPurchase[0]['AssignedEmp'];	
				$arryPurchase[0]["EmpID"] = $arryPurchase[0]['AssignedEmpID'];	
				$arryPurchase[0]["EmpName"] = $arryPurchase[0]['AssignedEmp'];	
				$arryPurchase[0]["MainTaxRate"] = $arryPurchase[0]['TaxRate'];
				 $arryPurchase[0]["EDIRefNo"] = $EDIRefNo;
				$arryPurchase[0]["Status"] = $Status;	
								
				$order_id = $this->AddPurchaseRMA($arryPurchase[0],$DB);
				
				

		$strSQL = "select ReturnID from ".$DB."p_order where OrderID = '".$order_id."' ";
		$arryReturnID = $this->query($strSQL, 1);
		$arryPurchase[0]["ReturnID"] = $arryReturnID[0]['ReturnID'];



				/******** Item Updation for Return ************/
				$arryItem = $this->GetPurchaseItemRMA($ReturnOrderID,$DB);
			   // echo "<pre>";print_r($arryItem);die;
				$NumLine = sizeof($arryItem);
				//echo $NumLine;exit;
				for($i=1;$i<=$NumLine;$i++){
					$Count=$i-1;
				
					if(!empty($arryDetails['id'.$i]) && $arryDetails['qty'.$i]>0){
						$qty_returned = $arryDetails['qty'.$i];
								
					    $Type = $arryDetails['Type'.$i];
					    $Action = $arryDetails['Action'.$i];
					    $Reason = $arryDetails['Reason'.$i];
					    $price =  $arryDetails['price'.$i];
					    $SerialNumbers = $arryDetails['serial_value' . $i];

					  $SQ_REC =  $arryItem[$Count]['qty_received'];
					 //echo $arryItem[$Count]["price"];die;
					    
						$sqlOs = "insert into ".$DB."p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, qty_returned, price, tax_id, tax, amount, Taxable,`Condition`, DesComment, Type, Action, Reason,SerialNumbers,DropshipCheck,DropshipCost,WID,fee) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryItem[$Count]["id"]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$qty_returned."', '0', '0', '".$price."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."','".$arryItem[$Count]["Condition"]."','".$arryItem[$Count]["DesComment"]."', '".$Type."', '".$Action."', '".$Reason."', '".$SerialNumbers."','".$arryItem[$Count]["DropshipCheck"]."', '".$arryItem[$Count]["DropshipCost"]."', '".$arryDetails['WID'.$i]."', '".$arryDetails['restocking_fee'.$i]."')";
                       //echo $sqlOs;exit;
						$this->query($sqlOs, 0);	
				
						
						/*if($Type=="AC"){
							$arryCreditItem[$i]['id']= $arryDetails['id'.$i];
							$arryCreditItem[$i]['OrderID']= $arryItem[$Count]['OrderID'];
							$arryCreditItem[$i]['item_id'] = $arryItem[$Count]['item_id'];
							$arryCreditItem[$i]['ref_id'] = $arryItem[$Count]['ref_id'];
							$arryCreditItem[$i]['sku'] = $arryItem[$Count]['sku'];
							$arryCreditItem[$i]['description']= $arryItem[$Count]['description'];
							$arryCreditItem[$i]['on_hand_qty'] = $arryItem[$Count]['on_hand_qty'];
							$arryCreditItem[$i]['qty'] = $arryItem[$Count]['qty'];
							$arryCreditItem[$i]['qty_received'] = $SQ_REC;
							$arryCreditItem[$i]['qty_returned'] =$arryDetails['qty'.$i];
							$arryCreditItem[$i]['price']= $arryDetails['price'.$i];
							//$arryCreditItem[$i]['tax_id']= $arryItem[$Count]['tax_id'];
							//$arryCreditItem[$i]['tax']= $arryItem[$Count]['tax'];
							$arryCreditItem[$i]['amount']= $arryDetails['amount'.$i];
							//$arryCreditItem[$i]['Taxable']= $arryItem[$Count]['Taxable'];
							$arryCreditItem[$i]['Condition']= $arryItem[$Count]['Condition'];
							$arryCreditItem[$i]['DesComment']= $arryItem[$Count]['DesComment'];
							$arryCreditItem[$i]['Type']= $Type;
							$arryCreditItem[$i]['Action']=  $Action;
							$arryCreditItem[$i]['Reason']= $Reason;
							$SerialNumbers = $arryDetails['serial_value' . $i];
							$TotalCreditItem +=$arryDetails['amount'.$i];
						}
						
						if($Type=="AR"){ 
							
							$arryReplacementItem[$i]['id']= $arryDetails['id'.$i];
							$arryReplacementItem[$i]['OrderID']= $arryItem[$Count]['OrderID'];
							$arryReplacementItem[$i]['item_id'] = $arryItem[$Count]['item_id'];
							$arryReplacementItem[$i]['ref_id'] = $arryItem[$Count]['ref_id'];
							$arryReplacementItem[$i]['sku'] = $arryItem[$Count]['sku'];
							$arryReplacementItem[$i]['description']= $arryItem[$Count]['description'];
							$arryReplacementItem[$i]['on_hand_qty'] = $arryItem[$Count]['on_hand_qty'];
							$arryReplacementItem[$i]['qty'] = $arryItem[$Count]['qty'];
							$arryReplacementItem[$i]['qty_received'] = $SQ_REC;
							$arryReplacementItem[$i]['qty_returned'] =$arryDetails['qty'.$i];
							$arryReplacementItem[$i]['price']= $arryDetails['price'.$i];
							//$arryReplacementItem[$i]['tax_id']= $arryItem[$Count]['tax_id'];
							//$arryReplacementItem[$i]['tax']= $arryItem[$Count]['tax'];
							$arryReplacementItem[$i]['amount']= $arryDetails['amount'.$i];
							//$arryReplacementItem[$i]['Taxable']= $arryItem[$Count]['Taxable'];
							$arryReplacementItem[$i]['Condition']= $arryItem[$Count]['Condition'];
							$arryReplacementItem[$i]['DesComment']= $arryItem[$Count]['DesComment'];
							$arryReplacementItem[$i]['Type']= $Type;
							$arryReplacementItem[$i]['Action']=  $Action;
							$arryReplacementItem[$i]['Reason']= $Reason;
							$SerialNumbers = $arryDetails['serial_value' . $i];
							$TotalReplacementItem +=$arryDetails['amount'.$i];
						}*/
							
     
       					/*****UPDATE STOCK QUNT*****
					$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand-" .$qty_returned . "  where Sku='" .$arryItem[$Count]["sku"]. "' and ItemID ='".$arryItem[$Count]["item_id"]."'";
					$this->query($UpdateQtysql, 0);               
       					/***************************/         


					}
				}
			}

   
			/******* CreditItem  **********
			if(sizeof($arryCreditItem)>0){ //print_r($arryCreditItem);			
				$arryPurchase[0]["TotalAmount"] = $TotalCreditItem;
				//$arryCrItem['serial_value']
				$CreditID = $this->AddPurchaseCreditRMA($arryPurchase[0]);
			    	foreach($arryCreditItem as $arryCrItem){			    
		   	  	   $sqls = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, qty_returned, price, tax_id, tax, amount, Taxable,`Condition`, DesComment, Type, Action, Reason, SerialNumbers) values('".$CreditID."', '".$arryCrItem['item_id']."' , '0', '".$arryCrItem['sku']."', '".$arryCrItem['description']."', '".$arryCrItem['on_hand_qty']."', '".$arryCrItem['qty_returned']."', '0', '0', '".$arryCrItem['price']."', '".$arryCrItem['tax_id']."', '".$arryCrItem['tax']."', '".$arryCrItem['amount']."', '".$arryCrItem['Taxable']."','".$arryCrItem['Condition']."','".$arryCrItem['DesComment']."','".$arryCrItem['Type']."','".$arryCrItem['Action']."','".$arryCrItem['Reason']."','".$SerialNumbers."')";
					//echo $sqls;exit;
		   	  	   $this->query($sqls, 0);
						
				}			   	
				   
			}			
			/******** ReplacementItem *****			
			if(sizeof($arryReplacementItem)>0){ 
				$arryPurchase[0]["TotalAmount"]=$TotalReplacementItem;
				$PurchaseID = $this->AddPurchaseReplacementRMA($arryPurchase[0]);
				foreach($arryReplacementItem as $arryRpItem){
				 	$sqls = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, qty_returned, price, tax_id, tax, amount, Taxable,`Condition`, DesComment, Type, Action, Reason, SerialNumbers) values('".$PurchaseID."', '".$arryRpItem['item_id']."' , '0', '".$arryRpItem['sku']."', '".$arryRpItem['description']."', '".$arryRpItem['on_hand_qty']."', '".$arryRpItem['qty_returned']."', '0', '0', '".$arryRpItem['price']."', '".$arryRpItem['tax_id']."', '".$arryRpItem['tax']."', '".$arryRpItem['amount']."', '".$arryRpItem['Taxable']."','".$arryRpItem['Condition']."','".$arryRpItem['DesComment']."','".$arryRpItem['Type']."','".$arryRpItem['Action']."','".$arryRpItem['Reason']."','".$arryCrItem['serial_value']."')";		       	
				 	$this->query($sqls, 0);			   	  
				}
			}
			/************************/
			
			return $order_id;
		}
			
		
		
	    	function  GetPurchaserma($OrderID,$PurchaseID,$Module,$DB='')
		{
			$strAddQuery ='';
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".mysql_real_escape_string($PurchaseID)."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='RMA'"):("");
			$strSQLQuery = "select o.* from ".$DB."p_order o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
			
		}		

		
		function  ListVendorS()
		{
          $strSQLQuery = "select Distinct SuppCode,SuppCompany from p_order where 1 and Module='Order' and Approved='1' order by SuppCompany ASC";
          #echo $strSQLQuery;exit;
		  return $this->query($strSQLQuery, 1);		
				
		}	

		function getVendorList()
                {
	   
                  $SqlCustomer = "select o.SuppCode,s.CompanyName as SuppCompany, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName from p_order o inner join p_supplier s on o.SuppCode = s.SuppCode where o.Module='Invoice' and o.SuppCode!=''   group by o.SuppCode having VendorName!='' order by SuppCompany ASC ";

                    return $this->query($SqlCustomer, 1);
                }
function GetItemAliasSku($Sku) {
                $strSQLQuery = "select c.valuationType as evaluationType, ia.ItemAliasCode,ia.AliasID,ia.sku,ia.description,i.ItemID from inv_item_alias ia left join inv_items i on ia.item_id = i.ItemID left outer join inv_categories c on c.CategoryID =i.CategoryID where LOWER(ia.ItemAliasCode) = '" . strtolower($Sku) . "'";
return $this->query($strSQLQuery, 1);
}
function GetItemAlia($alasSku) {
                $strSQLQuery = "select c.valuationType as evaluationType, ia.ItemAliasCode,ia.AliasID,ia.sku,ia.description,i.ItemID from inv_item_alias ia left join inv_items i on ia.item_id = i.ItemID left outer join inv_categories c on c.CategoryID =i.CategoryID where LOWER(ia.sku) = '" . strtolower($alasSku) . "'";

        return $this->query($strSQLQuery, 1);
    }

 function IdentifieItemSku($Sku) {
	
    	
       $strSQLQuery = "select p1.*,cat.valuationType as evaluationType from inv_items  p1 left join inv_categories cat on cat.CategoryID=p1.CategoryID ".$custJoin." where p1.Sku = '" . $Sku . "' ";
		
       
     
        return $this->query($strSQLQuery, 1);
    }
		
		function  ListPurchaseRma($arryDetails)
		{
			
			global $Config;
			extract($arryDetails);

			if($module=='Quote'){	
				$ModuleID = "QuoteID"; 
			}else{
				$ModuleID = "PurchaseID"; 
			}
			$strAddQuery = " where o.InvoiceEntry<=1";

			if(!empty($SuppCompany)){
				$strAddQuery .= " and o.SuppCode='".$SuppCompany."'";
			}
			
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($module))?(" and o.Module='".mysql_real_escape_string($module)."'"):("");
                        $strAddQuery .= (!empty($Order_Type))?(" and o.OrderType='".mysql_real_escape_string($Order_Type)."'"):("");

			$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.AssignedEmpID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):(""); 
                        $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");  // Added By bhoodev
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			


			$strAddQuery .= (!empty($Approved))?(" and o.Approved='1' "):("");
			$strAddQuery .= (!empty($AssignedEmpID))?(" and o.AssignedEmpID='".mysql_real_escape_string($AssignedEmpID)."'"):("");

			if($InvoicePaid=='0'){
				$strAddQuery .= " and o.InvoicePaid!='1' ";
			}else if($InvoicePaid=='1'){
				$strAddQuery .= " and o.InvoicePaid='1' ";
			}
			
			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($SearchKey != '' && $sortby == 'o.SuppCompany'){
				$strAddQuery .= " and (o.SuppCompany like '%".$SearchKey."%'  or s.UserName like '%".$SearchKey."%' or s.CompanyName like '%".$SearchKey."%' ) ";
			}else if($sortby == 'vo.sku'){
			
				$checkProduct=$this->IdentifieItemSku($SearchKey);

						//By Chetan 9sep// 
						if(empty($checkProduct))
						{
						$arryAlias = $this->GetItemAliasSku($SearchKey);
							if(count($arryAlias)){
									$mainaliasSku = $SearchKey;
                  $mainSku =$arryAlias[0]['sku'];
							}
						}else{
            $arryAlias = $this->GetItemAlia($SearchKey);
             if(count($arryAlias)){
									$mainaliasSku = $arryAlias[0]['ItemAliasCode'];
                  //$mainSku =$SearchKey;
							}
						$mainSku = $SearchKey;
						}

				$strAddQuery .= (!empty($SearchKey))?(" and (vo.sku like '%".$mainSku."%' or vo.sku like '%".$mainaliasSku."%')"):("");
      }else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.OrderType like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' or o.SuppCode like '%".$SearchKey."%'  or o.SuppCompany like '%".$SearchKey."%' or s.UserName like '%".$SearchKey."%' or s.CompanyName like '%".$SearchKey."%'   or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%'   or vo.sku like '%".$SearchKey."%' or   o.PurchaseID like '%".$SearchKey."%' ) "):("");	
			 
			}

			/*if($Status=='Open'){
				$strAddQuery .= " and o.Approved='1' and o.Status!='Completed' ";
			}else{
				$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			}

			if($ToApprove=='1'){
				$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
			}*/



			if($_SESSION['AdminType']=="employee"){			
				$strAddQuery .=  " and (o.SuppCode not in (select p.SuppCode from permission_vendor p where p.EmpID='".$_SESSION['AdminID']."')  OR o.AdminID='".$_SESSION['AdminID']."')";
			}



			
			

                       
			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";				
			}else{	
				$strAddQuery .= " group by o.OrderID ";	
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.OrderDate desc,o.OrderID desc");

				$Columns = "  o.InvoiceID, o.OrderID, o.PostedDate, o.OrderType, o.SuppCompany, o.TotalAmount,o.PurchaseID, o.Currency, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}else if($Limit>0){
					$strAddQuery .= " limit 0, ".$Limit;
				}				
			}
			
		        
                	   $strSQLQuery = "select ".$Columns." from p_order o left outer join p_supplier s on  o.SuppCode = s.SuppCode left join p_order_item vo ON o.OrderID = vo.OrderID ".$strAddQuery; 
           
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		
				
		}	
		



   		function closeRMAStatus($OrderID)
		{
			
			if(!empty($OrderID)){
				$sql="update p_order set Status='Closed' where OrderID='".$OrderID."'";
				$this->query($sql,0);		
			}

			return true;

		}


		/*******/
		function  GetPurchaseInvoice($OrderID,$InvoiceID,$Module)
		{
            		$strAddQuery ='';
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID='".$InvoiceID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from p_order o where 1".$strAddQuery." order by o.OrderID desc";
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);
			
		}
		/**/	
		
		
				
				function  ListCreditNoteRMA($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = " where o.Module='Credit' ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($FromDate))?(" and (o.PostedDate>='".$FromDate."' OR o.ClosedDate>='".$FromDate."') "):("");
			$strAddQuery .= (!empty($ToDate))?(" and (o.PostedDate<='".$ToDate."' OR o.ClosedDate<='".$ToDate."') "):("");
                        $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");  // Added By bhoodev
			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.InvoiceID like '%".$SearchKey."%' or o.SuppCompany like '%".$SearchKey."%' or o.ReturnID like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' ) " ):("");	
			}

			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");

			$strAddQuery .= (!empty($sortby) & !empty($asc))?(" order by ".$sortby." ".$asc):(" order by o.PostedDate desc,OrderID desc");
			//$strAddQuery .= (!empty($asc))?($asc):("");

			#$strSQLQuery = "select o.ClosedDate, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.CreditID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency  from p_order o ".$strAddQuery;
		        $strSQLQuery = "select o.* from p_order o ".$strAddQuery;
		
			return $this->query($strSQLQuery, 1);		
				
		}	
		
           function  GetPurchaseItemCreditRMA($OrderID)
		{
			$strAddQuery .= (!empty($OrderID))?(" and i.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			#$strSQLQuery = "select i.*,t.RateDescription from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                         $strSQLQuery = "select i.*,t.RateDescription,itm.evaluationType from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on i.item_id=itm.ItemID where 1".$strAddQuery." order by i.id asc";
			//echo $strSQLQuery;
                         return $this->query($strSQLQuery, 1);
		}
		
		
		/************************************* Warehouse Purchase Return Classes *******************************************/

		
function  WarehouseListPurchaseRma($arryDetails)
		{
			global $Config;
			extract($arryDetails);
	
			$strAddQuery = "where o.Module='RMA' ";
			$SearchKey   = strtolower(trim($key));

			$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.AssignedEmpID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):(""); 

			$strAddQuery .= (!empty($po))?(" and o.PurchaseID='".mysql_real_escape_string($po)."'"):("");
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

			$strSQLQuery = "select o.OrderType, o.InvoiceID, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID,o.ReturnID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid  from p_order o ".$strAddQuery;
		
		    //echo $strSQLQuery;
		
			return $this->query($strSQLQuery, 1);		
				
		}
		
		function  WarehouseListPurchasePoRmaList($arryDetails)
		{
			global $Config;
			extract($arryDetails);
 
			if($module=='Quote'){	
				$ModuleID = "QuoteID"; 
			}else{
				$ModuleID = "PurchaseID"; 
			}

			$strAddQuery = " where o.ReturnID !='' and o.Status!='Closed' and o.Status!='Parked' ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($module))?(" and o.Module='".mysql_real_escape_string($module)."'"):("");
                        $strAddQuery .= (!empty($Order_Type))?(" and o.OrderType='".mysql_real_escape_string($Order_Type)."'"):("");

			//$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.AssignedEmpID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):(""); 
                        $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");  // Added By bhoodev
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			$strAddQuery .= ($Approved==1)?(" and o.Approved='1' "):("");
			$strAddQuery .= (!empty($AssignedEmpID))?(" and o.AssignedEmpID='".mysql_real_escape_string($AssignedEmpID)."'"):("");

			if($InvoicePaid=='0'){
				$strAddQuery .= " and o.InvoicePaid!='1' ";
			}else if($InvoicePaid=='1'){
				$strAddQuery .= " and o.InvoicePaid='1' ";
			}
			
			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($SearchKey != '' && $sortby == 'o.SuppCompany'){
				$strAddQuery .= " and (o.SuppCompany like '%".$SearchKey."%'  or s.UserName like '%".$SearchKey."%' or s.CompanyName like '%".$SearchKey."%' ) ";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.InvoiceID like '%".$SearchKey."%' or o.ReturnID like '%".$SearchKey."%' or o.SuppCompany like '%".$SearchKey."%' or s.UserName like '%".$SearchKey."%' or s.CompanyName like '%".$SearchKey."%'   or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%'  ) " ):("");	
			}
 
			if(!empty($Status)){
				if($Status=='Open'){
					$strAddQuery .= " and o.Approved='1' and o.Status!='Completed' ";
				}else{
					$strAddQuery .= " and o.Status='".$Status."'";
				}
			}

			if(!empty($ToApprove)){
				$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
			}

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.PostedDate desc,o.OrderID desc");
			$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");


			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";				
			}else{				
				$Columns = "  o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.ReturnID, o.InvoiceID,  o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency,p.PostedDate as InvoiceDate, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}
                        
			 $strSQLQuery = "select ".$Columns." from p_order o left outer join p_supplier s on o.SuppCode = s.SuppCode left outer join p_order p on (o.InvoiceID=p.InvoiceID and p.Module='Invoice' and p.ReturnID='') ".$strAddQuery;
		       
           
			return $this->query($strSQLQuery, 1);		
				
		}	
		
        function  GetPurchaseReturn($OrderID,$PurchaseID,$Module)
		{
		
			$strAddQuery = '';
			//$strAddQuery .= (!empty($ReturnID))?(" and o.ReturnID='".mysql_real_escape_string($ReturnID)."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".mysql_real_escape_string($PurchaseID)."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
		    $strSQLQuery = "select o.* from p_order o where 1".$strAddQuery." order by o.OrderID desc";
			
			#$strSQLQuery;
			
			return $this->query($strSQLQuery, 1);
			
		}	
		
				

		function  GetPurchaseReturnItem($OrderID)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($OrderID))?(" and i.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			#$strSQLQuery = "select i.*,t.RateDescription from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                         $strSQLQuery = "select i.*,t.RateDescription,itm.evaluationType from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on i.item_id=itm.ItemID where 1".$strAddQuery." order by i.id asc";
			$strSQLQuery;
                         return $this->query($strSQLQuery, 1);
		}
		
       function PurchasingReturnOrder($arryDetails)	{
      
			global $Config;
			extract($arryDetails);

			if(!empty($ReturnOrderID)){
				
				$arryPurchase = $this->GetPurchaseReturn($ReturnOrderID,'','');
				
				$arryPurchase[0]["ReturnID"] = $ReturnID;
				$arryPurchase[0]["Module"] = "RMA";
				$arryPurchase[0]["ModuleID"] = "ReturnID";
				$arryPurchase[0]["PrefixPO"] = "RTN";
				$arryPurchase[0]["ReceivedDate"] = $ReceivedDate;
				$arryPurchase[0]["Freight"] = $Freight;
				$arryPurchase[0]["taxAmnt"] = $taxAmnt;
				$arryPurchase[0]["tax_auths"] = $tax_auths;
				$arryPurchase[0]["TotalAmount"] = $TotalAmount;	
				$arryPurchase[0]["InvoicePaid"] = $InvoicePaid;	
				$arryPurchase[0]["InvoiceComment"] = $InvoiceComment;	
				$arryPurchase[0]["EmpID"] = $arryPurchase[0]['AssignedEmpID'];	
				$arryPurchase[0]["EmpName"] = $arryPurchase[0]['AssignedEmp'];	
				$arryPurchase[0]["EmpID"] = $arryPurchase[0]['AssignedEmpID'];	
				$arryPurchase[0]["EmpName"] = $arryPurchase[0]['AssignedEmp'];	
				$arryPurchase[0]["MainTaxRate"] = $arryPurchase[0]['TaxRate'];
				
				$order_id = $this->AddPurchaseReturn($arryPurchase[0]);
                

				/******** Item Updation for Return ************/
				$arryItem = $this->GetPurchaseReturnItem($ReturnOrderID);
				
				$NumLine = sizeof($arryItem);
				for($i=1;$i<=$NumLine;$i++){
					$Count=$i-1;
				
					if(!empty($arryDetails['id'.$i]) && $arryDetails['qty'.$i]>0){
						$qty_returned = $arryDetails['qty'.$i];
						$sql = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_returned, price, tax_id, tax, amount, Taxable,`Condition`, DesComment) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_returned."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."','".$arryItem[$Count]["Condition"]."','".$arryItem[$Count]["DesComment"]."')";
                       // echo $sql;exit;
						//$this->query($sql, 0);	

     
                                                /***********************UPDATE STOCK QUNT************************************/
                                                        
                                                        
	    $UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand-" .$qty_returned . "  where Sku='" .$arryItem[$Count]["sku"]. "' and ItemID ='".$arryItem[$Count]["item_id"]."'";
		    $this->query($UpdateQtysql, 0);
                                               
                                                        
                                               /******************************************************************/         


					}
				}
			}

			return $order_id;
		}
		
		
    function AddPurchaseReturn($arryDetails)
		{  
			//echo"<pre>";print_r($arryDetails);
			global $Config;
			extract($arryDetails);

			if(empty($Currency)) $Currency =  $Config['Currency'];
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];

                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }
                        
			$strSQLQuery = "insert into p_order(Module, OrderType, OrderDate,  PurchaseID, QuoteID, InvoiceID, CreditID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, Freight, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp, Taxable, SaleID, taxAmnt , tax_auths, TaxRate,CustCode) values('".$Module."', '".$OrderType."', '".$OrderDate."',  '".$PurchaseID."', '".$QuoteID."', '".$InvoiceID."', '".$ReturnID."' '".$CreditID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '".$ClosedDate."', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '".addslashes($Freight)."', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."', '".addslashes($Taxable)."', '".addslashes($SaleID)."', '".addslashes($taxAmnt)."', '".addslashes($tax_auths)."', '".addslashes($MainTaxRate)."','".$CustCode."')";
           //echo $strSQLQuery;
			//exit;
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();

			if(empty($arryDetails[$ModuleID])){
				$ModuleIDValue = $PrefixPO.'000'.$OrderID;
				$strSQL = "update p_order set ".$ModuleID."='".$ModuleIDValue."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}
             
			return $OrderID;

		}
		
	function UpdatePurchasingReturn($arryDetails){ 
			global $Config;
			extract($arryDetails);
			if(!empty($OrderID)){
				$strSQLQuery = "update p_order set ReceivedDate='".$ReceivedDate."', PaymentDate='".$PaymentDate."', InvoicePaid='".$InvoicePaid."', InvPaymentMethod='".$InvPaymentMethod."', PaymentRef='".addslashes($PaymentRef)."', InvoiceComment='".addslashes(strip_tags($InvoiceComment))."', UpdatedDate = '".$Config['TodayDate']."'
				where OrderID='".mysql_real_escape_string($OrderID)."'"; 
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}
		
		/*******************  11/06/2015   *************************/
		

	function UpdateReturnRma($arryDetails){ 
		global $Config;
		extract($arryDetails);
		if(!empty($OrderID)){
			$strSQLQuery = "update p_order set Status='".addslashes($Status)."',InvoiceComment='".addslashes($InvoiceComment)."', PostedDate='".$PostedDate."', ReceivedDate='".$ReceivedDate."', UpdatedDate = '".$Config['TodayDate']."' , ExpiryDate='".addslashes($ExpiryDate)."', TotalAmount = '".addslashes($TotalAmount)."', Freight ='".addslashes($Freight)."', taxAmnt ='".addslashes($taxAmnt)."', Restocking='".addslashes($Restocking)."' , Restocking_fee='".addslashes($Restocking_fee)."'	where OrderID='".$OrderID."'"; 
			
			$this->query($strSQLQuery, 0);

		$arryItem = $this->GetPurchaseItem($OrderID);
		//echo '<pre>';print_r($arryItem);exit;
		$NumLine = sizeof($arryItem);
		for($i=1;$i<=$NumLine;$i++){

			$Count=$i-1;
			$id = $arryDetails['id'.$i];
			if(!empty($id)){
				$qty_returned = $arryDetails['qty'.$i];

				$Type = $arryDetails['Type'.$i];
				$Action = $arryDetails['Action'.$i];
				$Reason = $arryDetails['Reason'.$i];
				$price =  $arryDetails['price'.$i];
				$SerialNumbers = $arryDetails['serial_value' . $i];

				$SQ_REC =  $arryItem[$Count]['qty_received'];
				
				$sql = "update p_order_item set qty='".$qty_returned."', price='".$price."', tax_id='".$arryItem[$Count]["tax_id"]."', tax='".$arryItem[$Count]["tax"]."', amount='".$arryDetails['amount'.$i]."', Taxable='".$arryItem[$Count]["Taxable"]."', `Condition`='".$arryItem[$Count]["Condition"]."',  Type='".$Type."', Action='".$Action."', Reason='".$Reason."',SerialNumbers='".$SerialNumbers."' , fee='".$arryDetails['restocking_fee'.$i]."'  where id='".$id."'";
				//echo $sql.'<br>';
				$this->query($sql, 0);

			}
		}
 

			 


			$objConfigure = new configure();
			$objConfigure->EditUpdateAutoID('p_order','ReturnID',$OrderID,$ReturnID); 

		}

		return 1;
	}


		
function AddPurchaseRMA($arryDetails,$DB='')
		{  
			global $Config;
			extract($arryDetails);
			$IPAddress = GetIPAddress();
			if(empty($Currency)) $Currency =  $Config['Currency'];
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];

                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }
              
			$strSQLQuery = "insert into ".$DB."p_order(Module, OrderType, OrderDate,  PurchaseID, QuoteID, InvoiceID, ReturnID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, Freight, Restocking_fee, Restocking, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, ExpiryDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp, Taxable, SaleID, taxAmnt , tax_auths, TaxRate,CustCode,ConversionRate,IPAddress,freightTxSet, CreatedDate,EDIRefNo,EdiRefInvoiceID ) values('".$Module."', '".$OrderType."', '".$OrderDate."',  '".$PurchaseID."', '".$QuoteID."', '".$InvoiceID."', '".$ReturnID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '".$ClosedDate."', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '".addslashes($Freight)."', '".addslashes($Restocking_fee)."', '".addslashes($Restocking)."', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$PostedDate."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$ExpiryDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."', '".addslashes($Taxable)."', '".addslashes($SaleID)."', '".addslashes($taxAmnt)."', '".addslashes($tax_auths)."', '".addslashes($MainTaxRate)."','".$CustCode."','".$ConversionRate."','".$IPAddress."', '".addslashes($freightTxSet)."', '".$Config['TodayDate']."','".$EDIRefNo."','".addslashes($EdiRefInvoiceID)."')";
          // echo $strSQLQuery;exit;
			
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();

			/*if(empty($arryDetails[$ModuleID])){
				$ModuleIDValue = $PrefixPO.'000'.$OrderID;
				$strSQL = "update p_order set ".$ModuleID."='".$ModuleIDValue."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}*/

			$objConfigure = new configure();
			$objConfigure->UpdateModuleAutoID('p_order',$Module,$OrderID,$ReturnID,$DB);  
             
			return $OrderID;

		}
		
		
function  GetPurchaseItemRMA($OrderID,$DB='')
		{
			$strAddQuery ='';
			$strAddQuery .= (!empty($OrderID))?(" and i.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			#$strSQLQuery = "select i.*,t.RateDescription from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
            $strSQLQuery = "select i.*,t.RateDescription,itm.evaluationType,w.warehouse_name,w.warehouse_code from ".$DB."p_order_item i left outer join ".$DB."inv_tax_rates t on i.tax_id=t.RateId left outer join ".$DB."inv_items itm on (i.sku=itm.Sku or i.item_id=itm.ItemID) left outer join ".$DB."w_warehouse w on i.WID=w.WID where 1".$strAddQuery." order by i.id asc";
			$strSQLQuery;
            return $this->query($strSQLQuery, 1);
		}
		
		
		/************************ 15/06/2015 **************************/

	function AddCreditPOFromRMA($OrderID,$DB=''){			
		$arryPurchase = $this->GetPurchaserma($OrderID,'','',$DB);	
		$arryItem = $this->GetPurchaseItemRMA($OrderID,$DB);
		$NumLine = sizeof($arryItem);
			
		$ReStocking=0; 
		for($i=1;$i<=$NumLine;$i++){
			$Count=$i-1;		
			if(!empty($arryItem[$Count]['id']) && $arryItem[$Count]['qty']>0){				
				$Type = $arryItem[$Count]['Type'];						
				if($Type=="AC"){
					$arryCreditItem[$i]['item_id'] = $arryItem[$Count]['item_id'];
					$arryCreditItem[$i]['sku'] = $arryItem[$Count]['sku'];
					$arryCreditItem[$i]['description']= $arryItem[$Count]['description'];
					$arryCreditItem[$i]['on_hand_qty'] = $arryItem[$Count]['on_hand_qty'];
					$arryCreditItem[$i]['qty'] = $arryItem[$Count]['qty'];	
					$arryCreditItem[$i]['price']= $arryItem[$Count]['price'];
					$arryCreditItem[$i]['amount']= $arryItem[$Count]['amount'];
					$arryCreditItem[$i]['Condition']= $arryItem[$Count]['Condition'];
					$arryCreditItem[$i]['DesComment']= $arryItem[$Count]['DesComment'];
					$arryCreditItem[$i]['SerialNumbers']= $arryItem[$Count]['SerialNumbers'];
					$arryCreditItem[$i]['fee']=$arryItem[$Count]['fee'];	
		
					$ReStocking+= $arryItem[$Count]['fee'];	
					$TotalCreditItem +=$arryItem[$Count]['amount'];
				}else if($Type=="AR"){ 
					$arryReplacementItem[$i]['item_id'] = $arryItem[$Count]['item_id'];
					$arryReplacementItem[$i]['sku'] = $arryItem[$Count]['sku'];
					$arryReplacementItem[$i]['description']= $arryItem[$Count]['description'];
					$arryReplacementItem[$i]['on_hand_qty'] = $arryItem[$Count]['on_hand_qty'];
					$arryReplacementItem[$i]['qty'] = $arryItem[$Count]['qty'];
					$arryReplacementItem[$i]['price']= $arryItem[$Count]['price'];
					$arryReplacementItem[$i]['amount']= $arryItem[$Count]['amount'];				$arryReplacementItem[$i]['Condition']= $arryItem[$Count]['Condition'];
					$arryReplacementItem[$i]['DesComment']= $arryItem[$Count]['DesComment'];
					$arryReplacementItem[$i]['SerialNumbers']= $arryItem[$Count]['SerialNumbers'];
					$TotalReplacementItem +=$arryItem[$Count]['amount'];
				}

		  	}
		}
   
		/******** Credit  ******/
		if(sizeof($arryCreditItem)>0){	
			$arryPurchase[0]['Restocking_fee'] = $ReStocking;		
			$arryPurchase[0]["TotalAmount"] = $TotalCreditItem;
			$CreditID = $this->AddPurchaseCreditRMA($arryPurchase[0],$DB);
		    	foreach($arryCreditItem as $arryCrItem){		    
		   	  	   $sqlCrd = "insert into ".$DB."p_order_item(OrderID, item_id, sku, description, on_hand_qty, qty, price, amount, `Condition`, DesComment, SerialNumbers, fee) values('".$CreditID."', '".$arryCrItem['item_id']."', '".addslashes($arryCrItem['sku'])."', '".addslashes($arryCrItem['description'])."', '".$arryCrItem['on_hand_qty']."', '".$arryCrItem['qty']."', '".$arryCrItem['price']."',  '".$arryCrItem['amount']."', '".addslashes($arryCrItem['Condition'])."','".addslashes($arryCrItem['DesComment'])."','".addslashes($arryCrItem['SerialNumbers'])."','".addslashes($arryCrItem['fee'])."')";					
		   	  	   $this->query($sqlCrd, 0);						
		    	}
			$_SESSION["PR_CreditID"] = $CreditID;	   
		}
		/******** Replacement  ********/		
		if(sizeof($arryReplacementItem)>0){ 
			$arryPurchase[0]["TotalAmount"]=$TotalReplacementItem;
			$PurchaseID = $this->AddPurchaseReplacementRMA($arryPurchase[0]);
			foreach($arryReplacementItem as $arryRpItem){				
				 $sqlPO = "insert into ".$DB."p_order_item(OrderID, item_id, sku, description, on_hand_qty, qty,  price,  amount, `Condition`, DesComment, SerialNumbers) values('".$PurchaseID."', '".$arryRpItem['item_id']."' , '".addslashes($arryRpItem['sku'])."', '".addslashes($arryRpItem['description'])."', '".$arryRpItem['on_hand_qty']."', '".$arryRpItem['qty']."', '".$arryRpItem['price']."', '".$arryRpItem['amount']."', '".addslashes($arryRpItem['Condition'])."','".addslashes($arryRpItem['DesComment'])."', '".addslashes($arryRpItem['SerialNumbers'])."')";		       	
				 $this->query($sqlPO, 0);	
	   	  
		    	}				
	
		}	

		return 1;

	}


    function AddPurchaseCreditRMA($arryDetails,$DB='')
		{  
			global $Config;
			extract($arryDetails);
			$IPAddress = GetIPAddress();


			if(empty($Currency)) $Currency =  $Config['Currency'];			
			$Status = 'Open';
			$Approved = '0';
			$Taxable = '';
             		$taxAmnt = 0;
			$MainTaxRate = '';
                             
			/*if($Currency != $Config['Currency']){  
				$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP');
			}else{   
				$ConversionRate=1;
			}*/

			/************Approved***********/
			$objConfigure = new configure();
			$AutomaticApprove = $objConfigure->getSettingVariable('PO_APPROVE',$DB); 
			$Approved = $AutomaticApprove;
			/*******************************/

			if($Restocking==1 && $Restocking_fee>0){
				$TotalAmount = $TotalAmount - $Restocking_fee;
			}else{
				$Restocking=$Restocking_fee=0;
			}

			$strSQLQuery = "insert into ".$DB."p_order(Module, OrderType, OrderDate,  PurchaseID, QuoteID, InvoiceID, CreditID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, Freight, Restocking_fee, Restocking, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, ExpiryDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp, Taxable, SaleID, taxAmnt , tax_auths, TaxRate,CustCode,ReturnID,ConversionRate, IPAddress, CreatedDate,EDIRefNo,EdiRefInvoiceID ) values('Credit', '".$OrderType."', '".$OrderDate."',  '".$PurchaseID."', '".$QuoteID."', '".$InvoiceID."', '".$CreditID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '0', '".addslashes($Restocking_fee)."', '".addslashes($Restocking)."', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$ExpiryDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."', '".addslashes($Taxable)."', '".addslashes($SaleID)."', '".addslashes($taxAmnt)."', '".addslashes($tax_auths)."', '".addslashes($MainTaxRate)."','".$CustCode."','".$ReturnID."', '".$ConversionRate."', '".$IPAddress."', '".$Config['TodayDate']."','".$EDIRefNo."','".addslashes($EdiRefInvoiceID)."' )";
            //echo $strSQLQuery;exit;
			
		$this->query($strSQLQuery, 0);
		$OrderID = $this->lastInsertId();			
 

		$objConfigure = new configure();
		$objConfigure->UpdateModuleAutoID('p_order','Credit',$OrderID,'',$DB); 




		/*********CreditLimit Updation***********/
		$strSQl = "select PaymentTerm from ".$DB."p_supplier WHERE SuppCode='".$SuppCode."'";
		$arrSupp = $this->query($strSQl, 1);			
		if(!empty($arrSupp[0]['PaymentTerm'])){
			$arryTerm = explode("-",$arrSupp[0]['PaymentTerm']);
			$TermDays = (int)trim($arryTerm[1]);
			if($TermDays > 0){
				$sql="UPDATE ".$DB."p_supplier SET CreditLimit=CreditLimit-".$TotalAmount." WHERE SuppCode='".$SuppCode."' and CreditLimit>0";
				$this->query($sql,0);
				$sql2="UPDATE ".$DB."p_supplier SET CreditLimit='0' WHERE SuppCode='".$SuppCode."' and CreditLimit<0";
				$this->query($sql2,0);
			}
		}
		/*****************************************/
	 	 

			
			return $OrderID;

		}
		
      function AddPurchaseReplacementRMA($arryDetails,$DB='')
		{  
			//echo "<pre>";print_r($arryDetails);
			global $Config;
			extract($arryDetails);
			$IPAddress = GetIPAddress();

			if(empty($Currency)) $Currency =  $Config['Currency'];
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];
			
			$Status = 'Draft';
			$Approved = 'No';
			$Taxable = '';
			$taxAmnt = 0;
			$MainTaxRate = '';

			/*if($Currency != $Config['Currency']){  
				$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP');
			}else{   
				$ConversionRate=1;
			}*/


                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }
            $Remodule = "Order";  
            $OrderDateRep = $Config['TodayDate'];
			$strSQLQuery = "insert into ".$DB."p_order(Module, OrderType, OrderDate,  PurchaseID, QuoteID, InvoiceID, CreditID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, Freight, Restocking_fee, Restocking, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, ExpiryDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp, Taxable, SaleID, taxAmnt , tax_auths, TaxRate,CustCode,ReturnID,ConversionRate, IPAddress, CreatedDate,EDIRefNo,EdiRefInvoiceID) values('".$Remodule."', '".$OrderType."', '".$OrderDateRep."',  '".$PurchaseID."', '".$QuoteID."', '".$InvoiceID."', '".$CreditID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '".$ClosedDate."', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '0', '".addslashes($Restocking_fee)."', '".addslashes($Restocking)."', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$ExpiryDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."', '".addslashes($Taxable)."', '".addslashes($SaleID)."', '".addslashes($taxAmnt)."', '".addslashes($tax_auths)."', '".addslashes($MainTaxRate)."','".$CustCode."','".$ReturnID."','".$ConversionRate."' ,'".$IPAddress."', '".$Config['TodayDate']."','".$EDIRefNo."','".addslashes($EdiRefInvoiceID)."')";
            //echo $strSQLQuery;exit;
			
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();
			
			/*$PurchaseID = 'PO000'.$OrderID;				
			$strSQL = "update p_order set PurchaseID='".$PurchaseID."' where OrderID='".$OrderID."'"; 
			$this->query($strSQL, 0);*/

			$objConfigure = new configure();
			$objConfigure->UpdateModuleAutoID('p_order','Order',$OrderID,'',$DB); 


             
			return $OrderID;

		}
		
		
function  GetPurchaseQtyReturned($id)
		{
			$sql = "select sum(i.qty_returned) as QtyReturned from p_order_item i where i.ref_id='".$id."' group by i.ref_id";
			$rs = $this->query($sql);
			$sql;
			return $rs[0]['QtyReturned'];
		}
		
function  PurchaseGetQtyReceived($id)
		{
		
			if($id>0){
				$sql = "select sum(i.qty_received) as QtyReceived from p_order_item i where i.ref_id='".$id."' group by i.ref_id";
				$rs = $this->query($sql);
				//echo $sql;
			}
			return $rs[0]['QtyReceived'];
		}
		
		/***/
		
		 function  GetPurchaseFinanacerma($OrderID,$PurchaseID,$Module)
		{

			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".mysql_real_escape_string($PurchaseID)."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".mysql_real_escape_string($Module)."'"):("");
			$strSQLQuery = "select o.* from p_order o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
			
		}	
		
		/************** Add class in 29 june ***********/
		
	function AddPurchaseReplacementRmaOrder($arryDetails)
			{  
				global $Config;
				extract($arryDetails);
	
				if(empty($Currency)) $Currency =  $Config['Currency'];
				if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];
	
	                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }
	                    
				$strSQLQuery = "insert into p_order(Module, OrderType, OrderDate,  PurchaseID, QuoteID, InvoiceID, CreditID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, Freight, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp, Taxable, SaleID, taxAmnt , tax_auths, TaxRate,CustCode) values('Order', '".$OrderType."', '".$OrderDate."',  '".$PurchaseID."', '".$QuoteID."', '".$InvoiceID."', '".$CreditID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '".$ClosedDate."', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '".addslashes($Freight)."', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."', '".addslashes($Taxable)."', '".addslashes($SaleID)."', '".addslashes($taxAmnt)."', '".addslashes($tax_auths)."', '".addslashes($MainTaxRate)."','".$CustCode."')";
	            //echo $strSQLQuery;
				
				$this->query($strSQLQuery, 0);
				$OrderID = $this->lastInsertId();
	
				if(empty($arryDetails[$ModuleID])){
					$ModuleIDValue = $PrefixPO.'000'.$OrderID;
					$strSQL = "update p_order set ".$ModuleID."='".$ModuleIDValue."' where OrderID='".$OrderID."'"; 
					$this->query($strSQL, 0);
				}
	             
				return $OrderID;
	
			}

                        function listRmaAction(){
				 $strSQLQuery = "SELECT * FROM w_rma_action_value"; 
				$results=$this->query($strSQLQuery,1);
				return $results;
			}
			
			
			function listRmaReason(){
				 $strSQLQuery = "SELECT * FROM w_attribute_value WHERE attribute_id='7'"; 
				 $results=$this->query($strSQLQuery,1);
				return $results;
			}
			
			/************************* For Purchasing RMA *****************************/
			
                  
			function  selectSerialNumberForItembyID($OrderID,$item_id,$sku){
global $Config;
$condition = $Config['Cond'];
$strAddQuery = (!empty($Config['Cond']))?(" and `Condition`='".$condition."'"):("");
			      $strSQLQuery = "select SerialNumbers from p_order_item where OrderID='".$OrderID."' and (item_id='".$item_id."' or sku='".$sku."')  ".$strAddQuery."";
			     return $this->query($strSQLQuery, 1);
		 }
		 
		 
		 
           /************************ For warehouse Serial Numbers RMA ******************************/
			
                  
			function  WselectSerialNumberForItemByID($OrderID,$item_id,$sku){
			     $strSQLQuery = "select SerialNumbers from p_order_item where OrderID='".$OrderID."' and item_id='".$item_id."' and sku='".$sku."'";
			     return $this->query($strSQLQuery, 1);
		 }
		 
		 
		 /********** Add function in 7 Jan *********/
		 
		 
      function AddCreditPurchaseRMA($arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			if(empty($Currency)) $Currency =  $Config['Currency'];
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];

                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }
            $Status = "Open"; 
            $Module = "RMA";        
			$strSQLQuery = "insert into p_order(Module, OrderType, OrderDate,  PurchaseID, QuoteID, InvoiceID, ReturnID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, Freight, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, ExpiryDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp, Taxable, SaleID, taxAmnt , tax_auths, TaxRate,CustCode) values('".$Module."', '".$OrderType."', '".$OrderDate."',  '".$PurchaseID."', '".$QuoteID."', '".$InvoiceID."', '".$ReturnID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '".$ClosedDate."', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '".addslashes($Freight)."', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$ExpiryDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."', '".addslashes($Taxable)."', '".addslashes($SaleID)."', '".addslashes($taxAmnt)."', '".addslashes($tax_auths)."', '".addslashes($MainTaxRate)."','".$CustCode."')";
           //echo $strSQLQuery;exit;
			
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();

			if(empty($arryDetails[$ModuleID])){
				$ModuleIDValue = $PrefixPO.'000'.$OrderID;
				$strSQL = "update p_order set ".$ModuleID."='".$ModuleIDValue."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}
             
			return $OrderID;

		}
		
		
     function AddReplacementPurchaseRMA($arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			if(empty($Currency)) $Currency =  $Config['Currency'];
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];

                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }
            $Status = "Open";
            $Module = "RMA";       
			$strSQLQuery = "insert into p_order(Module, OrderType, OrderDate,  PurchaseID, QuoteID, InvoiceID, ReturnID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, Freight, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, ExpiryDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp, Taxable, SaleID, taxAmnt , tax_auths, TaxRate,CustCode) values('".$Module."', '".$OrderType."', '".$OrderDate."',  '".$PurchaseID."', '".$QuoteID."', '".$InvoiceID."', '".$ReturnID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '".$ClosedDate."', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '".addslashes($Freight)."', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$ExpiryDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."', '".addslashes($Taxable)."', '".addslashes($SaleID)."', '".addslashes($taxAmnt)."', '".addslashes($tax_auths)."', '".addslashes($MainTaxRate)."','".$CustCode."')";
           //echo $strSQLQuery;exit;
			
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();

			if(empty($arryDetails[$ModuleID])){
				$ModuleIDValue = $PrefixPO.'000'.$OrderID;
				$strSQL = "update p_order set ".$ModuleID."='".$ModuleIDValue."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}
             
			return $OrderID;

		}
		
	

	function GetRmaType($Type){         
		 switch ($Type){
		    case "AC":
		       $RmaType = "Advanced Credit";
		       break;
		    
		    case "AR":
		       $RmaType = "Advanced Replacement";
		       break;
		    
		    case "C":
		       $RmaType = "Credit";
		       break;
		    
		     case "R":
		       $RmaType = "Replacement";
		       break;
		 }
		return $RmaType;
	}



	 function SendRmaMail($OrderID){ 		     	
	     	global $Config;	     		
	     	if($OrderID>0){   
		
			 $strSQLQuery = "select  o.OrderType, o.OrderDate, o.PostedDate, o.ExpiryDate, o.Status, o.OrderID, o.PurchaseID,o.ReturnID,o.InvoiceID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid, o.Module ,p.PostedDate as InvoiceDate,s.Email,s.UserName from  p_order o left outer join p_order p on (o.InvoiceID=p.InvoiceID and p.Module='Invoice' and p.ReturnID='') inner join p_supplier s on o.SuppCode = s.SuppCode where o.OrderID='".$OrderID."' ";	   
    			$arryPurchase=$this->query($strSQLQuery,1);            
     			$ToEmail = $arryPurchase[0]['Email'];
			if(!empty($ToEmail)){	
				$InvoiceDate = ($arryPurchase[0]['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['InvoiceDate']))):(NOT_SPECIFIED);
				$RmaDate = ($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED);

				$ExpiryDate = ($arryPurchase[0]['ExpiryDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['ExpiryDate']))):(NOT_SPECIFIED);				
					
			$htmlPrefix = $Config['EmailTemplateFolder'];
			 $objConfigure = new configure();
			$TemplateContent = $objConfigure->GetTemplateContent(72, 1);
       			$contents = $TemplateContent[0]['Content'];			
			//$contents = file_get_contents($htmlPrefix."VendorEmail.html");
			
			$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
			//echo $CompanyUrl;exit;
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

			$contents = str_replace("[RMA_DATE]",$RmaDate,$contents);
			$contents = str_replace("[INVOICE_DATE]",$InvoiceDate,$contents);
			$contents = str_replace("[INVOICE_NUMBER]",$arryPurchase[0]['InvoiceID'],$contents);
			$contents = str_replace("[RMA_NUMBER]",$arryPurchase[0]['ReturnID'],$contents);
			$contents = str_replace("[EXPIRY_DATE]",$ExpiryDate,$contents);
			$contents = str_replace("[VENDOR_NAME]",$arryPurchase[0]['UserName'],$contents);
			$contents = str_replace("[VENDOR]",$arryPurchase[0]['SuppCompany'],$contents);
			$contents = str_replace("[AMOUNT]",$arryPurchase[0]['TotalAmount'],$contents);
			$contents = str_replace("[CURRENCY]",$arryPurchase[0]['Currency'],$contents);
			$contents = str_replace("[RMA_STATUS]",$arryPurchase[0]['Status'],$contents);
			
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($ToEmail);	
						 
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." :: ".$TemplateContent[0]['subject'];
			$mail->IsHTML(true);
			$mail->Body = $contents;  
			//echo $ToEmail.$contents; exit;
			if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
				$mail->Send();	
			}
		  }
				  
		}
    	}

	function AutoCloseExpiry(){
		$sqlSelect = "select OrderID from p_order  where Module='RMA' and ExpiryDate>0 and Status != 'Closed' and ExpiryDate < now()";	   
		$results=$this->query($sqlSelect,1); 
		//echo '<pre>';print_r($results);exit;
		foreach($results as $ResVal){
	
			$ReturnOrderID = $ResVal['OrderID'];
	
			$strSQL = " update p_order set Status = 'Closed' where Module='RMA' and OrderID='".$ReturnOrderID."'";		  
		    	$this->query($strSQL,0);

			$this->SendRmaMail($ReturnOrderID);
		}
	
  	}
  	
  	/***** By Ravi Solanki ******/
  	
function getSerialDetails($sku,$condition,$allserials,$WID=1){

 //$allserials = implode('","',$allserials);
$allserials = "'".implode ( "', '", $allserials )."'";

   $strSQL="SELECT `serialNumber`,`Sku`,`UsedSerial`,`Condition`,`UnitCost` from inv_serial_item where 1 and Sku='".$sku."' AND `Condition`='".$condition."' AND UsedSerial='0' and warehouse='".$WID."'";


$arryserial = $this->query($strSQL, 1);
		return  $arryserial;
	/*$where=' Where 1=1 ';
	$where1 ='';
	if(!empty($allserials)){
	$i=0;
		foreach($allserials as $serial){
		if($i!=0){
		$where1 .=' || ';
		}
			$where1 .="( serialNumber='".$serial."' AND Sku='".$sku."' AND `Condition`='".$condition."' AND UsedSerial=0 )";
			$i++;
		
		}
	
	}else{
$where1 .=" serialNumber='".$serial."' AND Sku='".$sku."' AND `Condition`='".$condition."' AND UsedSerial=0 ";

}
	$where .=' AND ('.$where1.')';
	  $strSQL="Select * from inv_serial_item $where";

	 	$arryserial = $this->query($strSQL, 1);
		return  $arryserial;*/
	
	}
	
	
	
function updateRMASerialQTY($post){	
	$responce=array();	
  $objItem=new items();
	for($i=1;$i<=$post['NumLine'];$i++){

/************************************/
$checkProduct=$objItem->checkItemSku($post['sku'.$i]);

		//By Chetan 9sep// 
		if(empty($checkProduct))
		{
		$arryAlias = $objItem->checkItemAliasSku($post['sku'.$i]);
			if(count($arryAlias))
			{

					$post['sku'.$i] = $arryAlias[0]['sku'];
					$post['item_id'.$i] = $arryAlias[0]['ItemID'];
			}
		}else{

$post['sku'.$i] = $post['sku'.$i];
}



/***********************************/



if(empty($post['WID'.$i])){ $post['WID'.$i]=1;}
		//$allselectedserial = explode(',',$post['serial_value'.$i]);
		$allserials = explode(',',$post['serial_value'.$i]);
		//print_r($allserials);die;
		foreach($allserials as $serial){
				if(1!=1){
					$responce['errors']['items'][$post['sku'.$i]][]=$serial;
				}else{
				
					$sqlUpdate="Update inv_serial_item set UsedSerial=1 Where serialNumber='".$serial."' AND Sku='".$post['sku'.$i]."' AND `Condition`='".$post['Condition'.$i]."' and warehouse ='".$post['WID'.$i]."'";
					$this->query($sqlUpdate, 0);
					 
					$sqlUpdate="Update inv_item_quanity_condition SET condition_qty=condition_qty-1 WHERE Sku='".$post['sku'.$i]."'  AND `condition`='".$post['Condition'.$i]."' and WID = '".$post['WID'.$i]."'";
					 $this->query($sqlUpdate, 0);
				}
		}
		
		
	
	}
		return $responce;
	
	}
	
	
function getInvoiceOrderIDByRMA($orderid=0){
	
	$sql="SELECT invoiceorder.OrderID FROM `p_order` as rmorder INNER JOIN p_order as invoiceorder ON invoiceorder.InvoiceID=rmorder.InvoiceID AND invoiceorder.Module='Invoice' WHERE 1 AND rmorder.`OrderID`='".$orderid."'";
		$arryItems = $this->query($sql, 1);
		
return !empty($arryItems[0]['OrderID'])?$arryItems[0]['OrderID']:0;
	
	
	}
	
function getOrderIDByMode($orderid=0,$mode){
			$sql="SELECT invoiceorder.OrderID FROM `p_order` as rmorder INNER JOIN p_order as invoiceorder ON invoiceorder.InvoiceID=rmorder.InvoiceID AND invoiceorder.Module='".$mode."' WHERE 1 AND rmorder.`OrderID`='".$orderid."'";
			$orders = $this->query($sql, 1);
			return $orders;
	}
	
function GetOrderItembyOrderIDAndSKU($orderid,$sku,$condition=''){
	
		if(empty($orderid) || empty($sku)){		
		return false;
		}

		$where=' 1=1 ';
		
		if(!is_array($orderid)){
			$where .=" AND OrderID = '".$orderid."' AND sku='".$sku."'";
		}else{
		$where .=" AND OrderID IN(".implode(',',$orderid).") AND sku='".$sku."'";
		
		}
		if(!empty($condition)){
		$where .=" AND `Condition`='".$condition."'";
		
		}
		  $strSQL = "select * from p_order_item where $where";  
		$arryItems = $this->query($strSQL, 1);
		return  $arryItems;
	
	}
function setRowColorPurchase($OrderID,$RowColor) 
{
	   $sql = "update p_order set RowColor='".$RowColor."' where OrderID in ( $OrderID)"; 
         $this->query($sql, 0);
        return true;
}



	function  GetInvoice($InvoiceID,$DB='')
		{
			 $strSQLQuery = "select OrderID from ".$DB."p_order o where InvoiceID='".mysql_real_escape_string($InvoiceID)."' and Module='Invoice' order by o.OrderID asc";
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);
		}	
		
}

?>
