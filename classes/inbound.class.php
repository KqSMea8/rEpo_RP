<?
class inbound extends dbClass
{
		//constructor
		function inbound()
		{
			$this->dbClass();
		} 
		
		function  ListInbound($arryDetails)
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


			$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency  from w_order o ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	

			
		function  GetReciveWarehouse($OrderID,$PurchaseID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".$PurchaseID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			   $strSQLQuery = "select o.* from w_order o where 1".$strAddQuery." order by o.OrderID desc";
			
			return $this->query($strSQLQuery, 1);
		}	

		function  GetWarehouseItem($OrderID)
		{
			
			  $strAddQuery .= (!empty($OrderID))?(" and i.OrderID='".$OrderID."'"):("");
		  $strSQLQuery = "select i.*,t.RateDescription from w_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1 ".$strAddQuery." order by i.id asc";
			 return $this->query($strSQLQuery, 1);
		}

		function  GetPurchaseItems($OrderID)
		{
			$strAddQuery .= (!empty($OrderID))?(" and i.OrderID='".$OrderID."'"):("");
			echo  $strSQLQuery = "select i.*,t.RateDescription from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1 ".$strAddQuery." order by i.id asc";
			 return $this->query($strSQLQuery, 1);
		}

		

		function AddInbound($arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			if(empty($Currency)) $Currency =  $Config['Currency'];
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];


			 $strSQLQuery = "insert into w_order(Module, OrderType, OrderDate,  PurchaseID, InvoiceID, CreditID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, Freight, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp,InboundID,RecieveStatus ) values('".$Module."', '".$OrderType."', '".$OrderDate."',  '".$PurchaseID."',  '".$InvoiceID."', '".$CreditID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '".$ClosedDate."', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '".addslashes($Freight)."', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."','".$InbID."','".$ReceiveStatus."')";
			#echo $strSQLQuery; exit;
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();

			if(empty($arryDetails[$ModuleID])){
				$ModuleIDValue = 'REC000'.$OrderID;
				$strSQL = "update w_order set RecieveID='".$ModuleIDValue."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}

			return $OrderID;

		}


		function AddInboundDetail($arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			//if(empty($Currency)) $Currency =  $Config['Currency'];
			//if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];


			  $strSQLQuery = "insert into w_inbound_order(warehouse, RecieveID, transaction_ref,PurchaseID,  transport, packageCount, PackageType, Weight, charge, Currency, Status, Description, apply_to, Price, PaidAs, amount,  CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, RecieveDate,RecieveStatus) values('".$warehouse."', '".$RecieveID."', '".$transaction_ref."',  '".$ReturnOrderID."', '".$transport."', '".$packageCount."', '".$PackageType."', '".$Weight."','".$charge."','".$Currency."','".$ReturnStatus."', '".addslashes(strip_tags($Description))."', '".$apply_to."', '".$Price."', '".$PaidAs."', '".$ammount."',  '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$RecieveDate."','".$ReceiveStatus."')";
			
			$this->query($strSQLQuery, 0);
			$InboundID = $this->lastInsertId();

			

			return $InboundID;

		}
		function  GetInbound($InboundID)
		{
			$strAddQuery .= (!empty($InboundID))?(" and o.InboundID='".$InboundID."'"):("");
			//$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".$PurchaseID."'"):("");
			$strSQLQuery = "select o.* from w_inbound_order o where 1".$strAddQuery." order by o.InboundID desc";
			
			return $this->query($strSQLQuery, 1);
		}

	
             function UpdateInbound($arryDetails){ 
			global $Config;
			extract($arryDetails);	

			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];

			$strSQLQuery = "update w_inbound_order set  warehouse='".$warehouse."', transport='".$transport."', packageCount='".$packageCount."', PackageType='".$PackageType."',   Weight='".$Weight."', charge='".$charge."', Currency='".$Currency."', Comment='".addslashes(strip_tags($Comment))."', Description='".addslashes($Description)."',  apply_to='".addslashes($apply_to)."', Price='".$Price."', PaidAs='".$PaidAs."', amount='".$amount."', 
			,RecieveStatus ='".$ReceiveStatus."' where InboundID='".$InboundID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}


		

	function  GetPOrder($OrderID,$PurchaseID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".$PurchaseID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			 $strSQLQuery = "select o.* from p_order o where 1".$strAddQuery." order by o.OrderID desc";
			
			
			return $this->query($strSQLQuery, 1);
		}	

		function  GetWOrder($OrderID,$PurchaseID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".$PurchaseID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			 $strSQLQuery = "select o.* from w_order o where 1".$strAddQuery." order by o.OrderID desc";
			
			
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
		function ReceiveWarehouseOrder($arryDetails)	{
			global $Config;
			extract($arryDetails);
			/*$sql = "CREATE TEMPORARY TABLE w_order2 ENGINE=MEMORY SELECT * FROM w_order WHERE OrderID=5;
			UPDATE w_order2 SET OrderID='', InvoiceID='55555'; 
			INSERT INTO w_order SELECT * FROM w_order2;
			DROP TABLE w_order2;";
			$this->query($sql, 0);*/

			
            
             //$objPurchase = new purchase();
			 $arryIn = $this->GetPurchase('',$transaction_ref,'Order');
			
			 /*****************************/
			$arryCheckID = $this->isInboundOrder($arryIn[0]['PurchaseID']);
			if(empty($arryCheckID)){
				if($InboundID>0){
					$this->UpdateInbound($arryDetails);
					$IndID = $InboundID;
				}else{
				$IndID=$this->AddInboundDetail($arryDetails);
				}
				$arryIn[0]['InbID'] = $IndID;
                                $arryIn[0]['ReceiveStatus'] = $ReceiveStatus;
                                $order_id = $this->AddInbound($arryIn[0]);
			   

				/********************************/
				$arryItem = $this->GetPurchaseItems($ReturnOrderID);
							
							$NumLine = sizeof($arryItem);
							for($i=1;$i<=$NumLine;$i++){
								$Count=$i-1;
								
								if(!empty($arryDetails['id'.$i])){
									$Qty_order= $arryDetails['ordered_qty'.$i];
									$qty_received = $arryDetails['qty'.$i];
									$qty_pReceived = $arryDetails['total_received'.$i];
									
									$sql = "insert into w_order_item(OrderID,item_id,sku, description, on_hand_qty, qty,qty_received, price, tax_id, tax, amount) values('".$order_id."','".$arryItem[$Count]["item_id"]."' ,'".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$Qty_order."','".$qty_pReceived."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."')";
									$this->query($sql, 0);	

								}
							}

				/********************************/
                   
				$arrayW_item = $this->GetWarehouseItem($order_id);

				$NumLine2 = sizeof($arrayW_item);
					for($j=1;$j<=$NumLine2;$j++){
						$Count2=$j-1;
						
						if($arryDetails['qty'.$j]>0){
						   $refID=$arrayW_item[$Count2]['id'];
							$qty_Wreceived = $arryDetails['qty'.$j];
							 $strSQLQuery = "update w_order_item set ref_id='".$refID."', qty_wRecieved='".$qty_Wreceived."' where id='".$arrayW_item[$Count2]['id']."'"; 
							 $this->query($strSQLQuery, 0);
							
							//$this->query($sql, 0);	
                                        /***************** Stock Update In Item **************/
						 $strSQ = "update inv_items set qty_on_hand=qty_on_hand+".$arryDetails['qty'.$j]." where Sku='".$arrayW_item[$Count2]['sku']."'"; 
				        /*****************************************************/ 
					 $this->query($strSQ, 0);

						}
					}


			 }else{
				$arryPurchase = $this->GetWOrder('',$arryCheckID,'');
				$order_id = $arryPurchase[0]["OrderID"];
				if($order_id>0){

				 $arrayW_item = $this->GetWarehouseItem($order_id);
			
					$NumLine2 = sizeof($arrayW_item);
					for($j=1;$j<=$NumLine2;$j++){
						$Count2=$j-1;
						
						if($arryDetails['qty'.$j]>0){
						   $refID=$arrayW_item[$Count2]['id'];
						   
							$qty_Wreceived = $arrayW_item[0]['qty_wRecieved'] + $arryDetails['qty'.$j];
							/***************************/ 
							 $strSQLQuery = "update w_order_item set ref_id='".$refID."', qty_wRecieved=qty_wRecieved+'".$arryDetails['qty'.$j]."' where id='".$arrayW_item[$Count2]['id']."'"; 
							 $this->query($strSQLQuery, 0);
							 /***************************/ 

							/***************** Stock Update In Item **************/
							 $strSQ = "update inv_items set qty_on_hand=qty_on_hand+'".$arryDetails['qty'.$j]."' where Sku='".$arrayW_item[$Count2]['sku']."'"; 
							 $this->query($strSQ, 0);
							 /***************************/ 
							
							//$this->query($sql, 0);	
            
                                                }
					     }
					}

		                 }
        
		
			//echo $order_id; exit;


			/****************************/
			/*$TotalQtyLeft = 1;
			$TotalQtyLeft = $this->GetTotalQtyLeft($arryPurchase[0]["Module"]);
			if($TotalQtyLeft<=0){
				$strSQLQuery = "update w_order set Status='Completed', ClosedDate='".$Config['TodayDate']."' where OrderID=".$ReceiveOrderID; 
				$this->query($strSQLQuery, 0);

				$strSQLInv = "update w_order set Status='Completed', ClosedDate='".$Config['TodayDate']."' where OrderID=".$order_id; 
				$this->query($strSQLInv, 0);

			}else{

				$strSQLQuery = "update w_order set Status='Invoicing' where OrderID=".$ReceiveOrderID; 
				$this->query($strSQLQuery, 0);

				$strSQLInv = "update w_order set Status='Invoicing' where OrderID=".$order_id; 
				$this->query($strSQLInv, 0);


			}*/

			return $order_id;
		}


		function  GetPurchasedItem($SuppCode,$OrderID,$PurchaseID,$Module)
		{
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".$PurchaseID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.OrderID,o.PurchaseID,o.OrderDate,o.Currency, i.item_id,i.sku,i.qty,i.description,i.price from w_order o inner join p_order_item i on o.OrderID=i.OrderID where o.Status='Completed' and o.Approved='1' ".$strAddQuery." order by o.OrderID desc ";
			return $this->query($strSQLQuery, 1);
		}

		


		function  ListWarehouseRecieve($arryDetails)
		{
			
			extract($arryDetails);
	                  $strAddQuery = "where 1 ";
			//$strAddQuery = "where o.Module='Recieve' ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($po))?(" and o.PurchaseID='".$po."'"):("");
			$strAddQuery .= (!empty($FPostedDate))?(" and o.PostedDate>='".$FPostedDate."'"):("");
			$strAddQuery .= (!empty($TPostedDate))?(" and o.PostedDate<='".$TPostedDate."'"):("");

			$strAddQuery .= (!empty($FOrderDate))?(" and o.OrderDate>='".$FOrderDate."'"):("");
			$strAddQuery .= (!empty($TOrderDate))?(" and o.OrderDate<='".$TOrderDate."'"):("");

			/*if($SearchKey=='yes' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
				$strAddQuery .= " and o.InvoicePaid='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
				$strAddQuery .= " and o.InvoicePaid!='1'";
			}else*/
			if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.InvoiceID like '%".$SearchKey."%'  or o.PurchaseID like '%".$SearchKey."%'  or o.SuppCompany like '%".$SearchKey."%'  or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' ) " ):("");	
			}

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select o.*,wo.InboundID,wo.warehouse,wo.transaction_ref,wo.RecieveDate	  from w_order o left outer join w_inbound_order wo on wo.InboundID = o.InboundID ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}

		




		function UpdateWarehouseRecieve($arryDetails){ 
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update w_order set ReceivedDate='".$RecieveDate."', PaymentDate='".$PaymentDate."', InvoicePaid='".$InvoicePaid."', InvPaymentMethod='".$InvPaymentMethod."', PaymentRef='".addslashes($PaymentRef)."', InvoiceComment='".addslashes(strip_tags($InvoiceComment))."', UpdatedDate = '".$Config['TodayDate']."'
			where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			return 1;
		}


	


		function  WarehouseReport($FilterBy,$FromDate,$ToDate,$Year,$SuppCode,$Status)
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

			$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency  from w_order o where o.Module='Order' ".$strAddQuery." order by o.OrderDate desc";
				
			return $this->query($strSQLQuery, 1);		
		}

		function  GetNumPOByYear($Year,$FromDate,$ToDate,$SuppCode,$Status)
		{

			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");

			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");

			$strSQLQuery = "select count(o.OrderID) as TotalOrder  from w_order o where o.Module='Order' and YEAR(o.OrderDate)='".$Year."' ".$strAddQuery." order by o.OrderDate desc";
				
			return $this->query($strSQLQuery, 1);		
		}
	
		function  CountInvoices($PurchaseID)
		{
			$strSQLQuery = "select count(o.OrderID) as TotalInvoice from w_order o where o.Module='Invoice' and PurchaseID='".$PurchaseID."'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['TotalInvoice'];		
		}

		function  GetwTotalQtyLeft($PurchaseID)
		{
		 $strSQLQuery = "select i.id,i.qty from w_order_item i inner join w_order o on i.OrderID=o.OrderID where o.PurchaseID='".$PurchaseID."'  order by i.id asc";
		exit;
			$arryItem = $this->query($strSQLQuery, 1);
			for($i=0;$i<sizeof($arryItem);$i++){
				$total_received = $this->GetQtyReceivedInWarehouse($arryItem[$i]["id"]);
				$ordered_qty = $arryItem[$i]["qty"];
				
				$TotalQtyLeft += ($ordered_qty - $total_received);
			}

			return $TotalQtyLeft;		
		}

		



		




		function RemovePurchase($OrderID){
			/*$strSQLQuery = "select UserID,Image from w_order where OrderID=".$OrderID; 
			$arryRow = $this->query($strSQLQuery, 1);

			$ImgDir = 'upload/purchase/';
		
			if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){							
				unlink($ImgDir.$arryRow[0]['Image']);	
			}*/
		
			$strSQLQuery = "delete from w_order where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from w_order_item where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			$strSQLQuery = "delete from w_inbound_order where PurchaseID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			return 1;

		}

		function  GetQtyReceivedInWarehouse($id)
		{
		
			 $sql = "select sum(qty_wRecieved) as QtyReceived from w_order_item  where ref_id='".$id."' group by ref_id"; 
			
			$rs = $this->query($sql);
			return $rs[0]['QtyReceived'];
		}

		function  GetQtyOrderdedInWarehouse($id)
		{
			$sql = "select qty as QtyOrderded from w_order_item where id='".$id."'";
			$rs = $this->query($sql);
			return $rs[0]['QtyOrderded'];
		}

		function  isInboundOrder($PurchaseID)
		{
			 $sql = "select PurchaseID  from w_order where PurchaseID='".$PurchaseID."'"; 
			$rs = $this->query($sql);
			return $rs[0]['PurchaseID'];
		}

		function  GetQtyReturnedInWarehouse($id)
		{
			$sql = "select sum(qty_received) as QtyPreceived from w_order_item i where ref_id='".$id."' group by id";
			$rs = $this->query($sql);
			return $rs[0]['QtyPreceived'];
		}

		function  GetWQtyRecievedInWarehouse($id,$OrderID)
		{
			$sql = "select sum(qty_WRecieved) as Wqty from w_order_item i where item_id='".$id."' and OrderID = '".$OrderID."' group by item_id";
			$rs = $this->query($sql);
			return $rs[0]['Wqty'];
		}

		
		

		

		function isPurchaseExists($PurchaseID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "select OrderID from w_order where Module='Order' and PurchaseID='".trim($PurchaseID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}			
		

		

		function isRecieveExists($RecieveID,$InboundID)
		{
			$strSQLQuery = (!empty($InboundID))?(" and OrderID != '".$InboundID."'"):("");
			$strSQLQuery = "select PurchaseID from w_order where RecieveID='".trim($RecieveID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['InboundID'])) {
				return true;
			} else {
				return false;
			}
		}	

	



	
}
?>
