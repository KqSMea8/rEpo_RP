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

			(!isset($Approved))?($Approved=""):("");
			(!isset($InvoicePaid))?($InvoicePaid=""):("");
			(!isset($Status))?($Status=""):("");
			(!isset($ToApprove))?($ToApprove=""):("");
			(!isset($Limit))?($Limit=""):("");
			(!isset($close_status))?($close_status=""):("");


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
			}else if($SearchKey != '' && $sortby == 'o.SuppCompany'){
				$strAddQuery .= " and (o.SuppCompany like '%".$SearchKey."%' ) ";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.OrderType like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' or o.SuppCompany like '%".$SearchKey."%'   or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%'  or o.TrackingNo like '%".$SearchKey."%' ) " ):("");	
			}

			if($Status=='Open'){
				$strAddQuery .= " and o.Approved='1' and o.Status!='Completed' ";
			}else{
				$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			}
			if($close_status=='0'){
				$strAddQuery .= " and  o.close_status!='1' ";
			}

			if($ToApprove=='1'){
				$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
			}



			if($_SESSION['AdminType']=="employee"){			
				$strAddQuery .=  " and (o.SuppCode not in (select p.SuppCode from permission_vendor p where p.EmpID='".$_SESSION['AdminID']."')  OR o.AdminID='".$_SESSION['AdminID']."')";
			}



			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.OrderDate desc,o.OrderID desc");
			

                       
			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";				
			}else{				
				$Columns = "  o.*, if(o.AdminType='employee',e.UserName,'Administrator') as PostedBy  ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}else if($Limit>0){
					$strAddQuery .= " limit 0, ".$Limit;
				}
				
			}

			  #$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID,  o.SaleID,o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency  from p_order o ".$strAddQuery;
		        
                          //$strSQLQuery = "select ".$Columns." from p_order o left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType='employee') left outer join p_supplier s on  o.SuppCode =  s.SuppCode ".$strAddQuery;
  $strSQLQuery = "select ".$Columns." from p_order o left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType='employee')  ".$strAddQuery;
		
			return $this->query($strSQLQuery, 1);		
				
		}
	
		function  GetSupplier($SuppID,$SuppCode,$Status)
		{
			$strSQLQuery = "select s.*,IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName,  ab.Address, ab.Country,ab.State, ab.City,  ab.ZipCode from p_supplier s left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'contact' and ab.PrimaryContact='1') ";

			#$strSQLQuery .= (!empty($SuppID))?(" where s.SuppID='".$SuppID."'"):(" and s.locationID=".$_SESSION['locationID']);
			$strSQLQuery .= (!empty($SuppID))?(" where s.SuppID='".mysql_real_escape_string($SuppID)."'"):(" where 1");
			$strSQLQuery .= (!empty($SuppCode))?(" and s.SuppCode='".mysql_real_escape_string($SuppCode)."'"):("");
			$strSQLQuery .= ($Status>0)?(" and s.Status='".$Status."'"):("");

			return $this->query($strSQLQuery, 1);
		}	

		function  GetPurchaseDetail($OrderID,$PurchaseID,$InvoiceID,$Module)
		{
			$strAddQuery='';
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".mysql_real_escape_string($PurchaseID)."'"):("");
			$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID='".mysql_real_escape_string($InvoiceID)."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".mysql_real_escape_string($Module)."'"):("");

			 
  $strSQLQuery = "select o.* , s.VAT,s.CST,  IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName, s.SuppID, s.Email as VendorEmail   from p_order o left outer join p_supplier s ON o.SuppCode= s.SuppCode where 1 ".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}

		function  GetPurchase($OrderID,$PurchaseID,$Module)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".mysql_real_escape_string($PurchaseID)."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".mysql_real_escape_string($Module)."'"):("");
/*if($_GET['this']==1){
$strSQLQuery = "select o.* , s.VAT,s.CST from p_order o left outer join p_supplier s ON o.SuppCode = s.SuppCode  where 1 ".$strAddQuery." order by o.OrderID desc";
}else{

	$strSQLQuery = "select o.* from p_order o where 1".$strAddQuery." order by o.OrderID desc";
}*/
			//$strSQLQuery = "select o.* from p_order o where 1".$strAddQuery." order by o.OrderID desc";
$strSQLQuery = "select o.* , s.VAT,s.CST, s.TRN, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName, s.SuppID, s.Email as VendorEmail   from p_order o left outer join p_supplier s ON o.SuppCode = s.SuppCode  where 1 ".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}		

		function  GetPurchaseItem($OrderID)
		{
			$strAddQuery='';
			$strAddQuery .= (!empty($OrderID))?(" and i.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			#$strSQLQuery = "select i.*,t.RateDescription from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                         $strSQLQuery = "select i.*,t.RateDescription,itm.qty_on_hand,itm.weight,itm.wt_Unit, itm.width,itm.ln_Unit, itm.height,itm.wd_Unit, itm.depth,itm.ht_Unit,itm.CategoryID,c.valuationType as evaluationType,w.warehouse_code,w.warehouse_name from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on i.item_id=itm.ItemID left outer join inv_categories c on c.CategoryID =itm.CategoryID left outer join w_warehouse w on i.WID=w.WID where 1".$strAddQuery." order by i.id asc";
			return $this->query($strSQLQuery, 1);
		}

		function  GetInvoiceOrder($PurchaseID)
		{
			$strSQLQuery = "select OrderID from p_order o where PurchaseID='".mysql_real_escape_string($PurchaseID)."' and Module='Invoice' order by o.OrderID asc";
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
		}

		function AddPurchase($arryDetails)
		{  
			global $Config;
			extract($arryDetails);
//EDI Update
$DBName=''; 	if($EdiRefInvoiceID=='' && empty($EdiRefInvoiceID)){
 $EDICompName=$EDISalesCompName; if($EDIPurchaseCompName!='') { $DBName='erp_'.$EDIPurchaseCompName.'.'; $EDICompName=$EDIPurchaseCompName; } if($AdminID==''){ $AdminID=$_SESSION['AdminID']; }
}

if($AdminID==''){ $AdminID=$_SESSION['AdminID']; }
//END EDI Update
			$IPAddress = GetIPAddress();

			if(empty($Currency)) $Currency =  $Config['Currency'];
			if(empty($PostedDate)) $PostedDate = $Config['TodayDate'];
			if(empty($ReceivedDate)) $ReceivedDate = $Config['TodayDate'];

                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }
                       
			if($Currency != $Config['Currency']){  
				if($Module=='Invoice' || $Module=='Credit'){
					$CurrencyDate = $PostedDate;	
				}else{
					$CurrencyDate = $OrderDate;	
				}
				$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP',$CurrencyDate);
			}else{   
				$ConversionRate=1;
			} 
//trackb
if(is_array($TrackingNo)){
$TrackingNo =implode(':',$TrackingNo);
}
if($POReceipt==1){

$PrepaidFreight ='No';

}
			$strSQLQuery = "insert into ".$DBName."p_order(Module, ConversionRate, OrderType, OrderDate,  PurchaseID, QuoteID,ReceiptID, InvoiceID, CreditID, wCode, Approved, Status, DropShip, DeliveryDate, ClosedDate, Comment, SuppCode, SuppCompany, SuppContact, Address, City, State, Country, ZipCode, Currency, SuppCurrency, Mobile, Landline, Fax, Email, wName, wContact, wAddress, wCity, wState, wCountry, wZipCode, wMobile, wLandline, wEmail, TotalAmount, TotalInvoiceAmount, Freight, CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, ReceivedDate, InvoicePaid, InvoiceComment, PaymentMethod, ShippingMethod, PaymentTerm, AssignedEmpID, AssignedEmp, Taxable, SaleID, taxAmnt , tax_auths, TaxRate, CustCode, AccountID, PrepaidFreight, PrepaidVendor, PrepaidAmount, GenrateInvoice, ReceiptStatus, RefInvoiceID, ShippingMethodVal,IPAddress, freightTxSet, TrackingNo, CreditCardVendor, CreatedDate, EDICompId, EDICompName, EDIRefNo, EdiRefInvoiceID, Restocking, Restocking_fee) values('".$Module."', '".$ConversionRate."', '".$OrderType."', '".$OrderDate."',  '".$PurchaseID."', '".$QuoteID."','".$ReceiptID."', '".$InvoiceID."', '".$CreditID."', '".$wCode."', '".$Approved."','".$Status."', '".$DropShip."', '".$DeliveryDate."', '".$ClosedDate."', '".addslashes(strip_tags($Comment))."', '".addslashes($SuppCode)."', '".addslashes($SuppCompany)."', '".addslashes($SuppContact)."', '".addslashes($Address)."' ,  '".addslashes($City)."', '".addslashes($State)."', '".addslashes($Country)."', '".addslashes($ZipCode)."',  '".$Currency."', '".addslashes($SuppCurrency)."', '".addslashes($Mobile)."', '".addslashes($Landline)."', '".addslashes($Fax)."', '".addslashes($Email)."' , '".addslashes($wName)."', '".addslashes($wContact)."', '".addslashes($wAddress)."' ,  '".addslashes($wCity)."', '".addslashes($wState)."', '".addslashes($wCountry)."', '".addslashes($wZipCode)."', '".addslashes($wMobile)."', '".addslashes($wLandline)."',  '".addslashes($wEmail)."', '".addslashes($TotalAmount)."', '".addslashes($TotalAmount)."', '".addslashes($Freight)."', '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$PostedDate."', '".$Config['TodayDate']."', '".$ReceivedDate."', '".$InvoicePaid."', '".addslashes(strip_tags($InvoiceComment))."', '".addslashes($PaymentMethod)."', '".addslashes($ShippingMethod)."', '".addslashes($PaymentTerm)."', '".addslashes($EmpID)."', '".addslashes($EmpName)."', '".addslashes($Taxable)."', '".addslashes($SaleID)."', '".addslashes($taxAmnt)."', '".addslashes($tax_auths)."', '".addslashes($MainTaxRate)."','".$CustCode."', '".addslashes($AccountID)."', '".addslashes($PrepaidFreight)."', '".addslashes($PrepaidVendor)."', '".addslashes($PrepaidAmount)."','".addslashes($GenrateInvoice)."','".$ReceiptStatus."','".$RefInvoiceID."' ,'".addslashes($ShippingMethodVal)."', '".addslashes($IPAddress)."', '".addslashes($freightTxSet)."', '".addslashes($TrackingNo)."', '".addslashes($CreditCardVendor)."' , '".$Config['TodayDate']."', '".addslashes($EDICompId)."', '".addslashes($EDICompName)."', '".addslashes($EDIRefNo)."','".addslashes($EdiRefInvoiceID)."', '".addslashes($Restocking)."','".addslashes($Restocking_fee)."')";
			
			
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();

			/*if(empty($arryDetails[$ModuleID])){
				$ModuleIDValue = $PrefixPO.'000'.$OrderID;
				$strSQL = "update p_order set ".$ModuleID."='".$ModuleIDValue."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}*/
			$objConfigure = new configure();
			$objConfigure->UpdateModuleAutoID('p_order',$Module,$OrderID,$arryDetails[$ModuleID],$DBName);  

 //EDI update Invoice id with edi company s_order Column EdiRefInvoiceID
					if($EdiRefInvoiceID!='' &!empty($EdiRefInvoiceID)){

								$sql= "select InvoiceID,EDIRefNo,EDICompName from ".$DBName."p_order where OrderID='".addslashes($OrderID)."' ";
													$result = $this->query($sql);
					
													if($result[0]['InvoiceID']!='' && $result[0]['EDICompName']!=''){
													
													$DBName = 'erp_'.$result[0]['EDICompName'].'.';
																 $strSQL = "update ".$DBName."s_order set EdiRefInvoiceID='".$result[0]['InvoiceID']."' where InvoiceID='".$EdiRefInvoiceID."'";  
																 $this->query($strSQL, 0);
					
													}


					}
					//End EDI update Invoice id with edi company s_order Column EdiRefInvoiceID


// Add EDI purchase
		if($EDICompId!='' && $EDISalesCompName!='' && $Module=='Order' ){
			$DBName='';
			if($EDISalesCompName!='') {
				$DBName='erp_'.$EDISalesCompName.'.';

			}
$objSale = new sale();
					$sql= "select * from ".$DBName."s_customers where EDICompId='".addslashes($AdminID)."' ";
					$Customerdetail = $this->query($sql);
					
      //$arryDetails['PONumber']=$Customerdetail[0]['PONumber'];
      $arryDetails['CustomerCompany']=$Customerdetail[0]['Company'];
      $arryDetails['CustID']=$Customerdetail[0]['Cid'];
      $arryDetails['CustomerName']=$Customerdetail[0]['Company'];
      $arryDetails['CustCode']=$Customerdetail[0]['CustCode'];
      $arryDetails['Currency']=$Customerdetail[0]['Currency'];
      $arryDetails['Status']='Open';
      //$arryDetails['PaymentMethod']=$Customerdetail[0]['PaymentMethod'];
      //$arryDetails['PaymentTerm']=$Customerdetail[0]['PaymentTerm'];

$Commdetail =array();
     	$sqlCom= "select GROUP_CONCAT(EmpSpId  SEPARATOR ',') as Userids,GROUP_CONCAT(VenSpId  SEPARATOR ',') as VendorIDs from ".$DBName."customer_sales_commission where CustomerId ='".addslashes($Customerdetail['0']['Cid'])."' ";
					$Commdetail = $this->query($sqlCom);
					
					
		
					
					if(sizeof($Commdetail)>0){
						            $objConfig=new admin();
                 if($Commdetail[0]['VendorIDs']!=''){
                    $arryVenID = explode(',', $Commdetail[0]['VendorIDs']);
                    $arryVenID = array_diff($arryVenID, array(0));
           
                     // Combine the array back into a comma-delimited string
                     $Commdetail[0]['VendorIDs'] = implode(',', $arryVenID);

                      $vendorName = $objConfig->getSalesPersonName($Commdetail[0]['VendorIDs'],1,$DBName);
                     
                     
                     $salesPerson = $vendorName;
                     $arryDetails['vendorSalesPersonID']=$Commdetail[0]['VendorIDs'];
                 }
                 if($Commdetail[0]['Userids']!=''){
                  $arryUserids = explode(',', $Commdetail[0]['Userids']);
                    $arryUserids = array_diff($arryUserids, array(0));

                      $Commdetail[0]['Userids'] = implode(',', $arryUserids);
                    $UserName =	$objConfig->getSalesPersonName($Commdetail[0]['Userids'],0,$DBName);
                    $salesPerson = $UserName;
                    $arryDetails['SalesPersonID']=$Commdetail[0]['Userids'];
                 }
                if($Commdetail[0]['VendorIDs']!='' && $Commdetail[0]['Userids']!='')
                {
                    $salesPerson = $UserName.",".$vendorName;
                }
					
					             $arryDetails['SalesPerson']=$salesPerson;
					}
					//Billing Address
          $sqlbilling= "select * from ".$DBName."s_address_book where CustID='".addslashes($Customerdetail[0]['Cid'])."' and AddType = 'billing' ";
					$CustomerBilling = $this->query($sqlbilling);

					$arryDetails['BillingName']=$CustomerBilling[0]['Company'];
					$arryDetails['CustomerName']=$CustomerBilling[0]['Company'];
					$arryDetails['CustomerCompany']=$CustomerBilling[0]['Company'];
					$arryDetails['Address']=stripslashes($CustomerBilling[0]['Address']);
					$arryDetails['City']=$CustomerBilling[0]['CityName'];
					$arryDetails['State']=$CustomerBilling[0]['StateName'];
					$arryDetails['Country']=$CustomerBilling[0]['CountryName'];
          $arryDetails['CityID']=$CustomerBilling[0]['city_id'];
					$arryDetails['StateID']=$CustomerBilling[0]['state_id'];
					$arryDetails['CountryId']=$CustomerBilling[0]['country_id'];
					$arryDetails['ZipCode']=$CustomerBilling[0]['ZipCode'];
					$arryDetails['Mobile']=$CustomerBilling[0]['Mobile'];
					$arryDetails['Landline']=$CustomerBilling[0]['Landline'];
					$arryDetails['Fax']=$CustomerBilling[0]['Fax'];
					$arryDetails['Email']=$CustomerBilling[0]['Email'];

					//Billing end


					//Shipping Address
          $sqlShipping= "select * from ".$DBName."s_address_book where CustID='".addslashes($Customerdetail[0]['Cid'])."' and AddType = 'shipping' ";
					$CustomerShipping= $this->query($sqlShipping);

					$arryDetails['ShippingName']=$CustomerShipping[0]['Company'];
					$arryDetails['ShippingCompany']=$CustomerShipping[0]['Company'];
					$arryDetails['CustomerCompany']=$CustomerShipping[0]['Company'];
					$arryDetails['ShippingAddress']=$CustomerShipping[0]['Address'];
					$arryDetails['ShippingCity']=$CustomerShipping[0]['CityName'];
					$arryDetails['ShippingState']=$CustomerShipping[0]['StateName'];
					$arryDetails['ShippingCountry']=$CustomerShipping[0]['CountryName'];
          $arryDetails['ShippingCityID']=$CustomerShipping[0]['city_id'];
					$arryDetails['ShippingStateID']=$CustomerShipping[0]['state_id'];
					$arryDetails['ShippingCountryID']=$CustomerShipping[0]['country_id'];
					$arryDetails['ShippingZipCode']=$CustomerShipping[0]['ZipCode'];
					$arryDetails['ShippingMobile']=$CustomerShipping[0]['Mobile'];
					$arryDetails['ShippingLandline']=$CustomerShipping[0]['Landline'];
					$arryDetails['ShippingFax']=$CustomerShipping[0]['Fax'];
					$arryDetails['ShippingEmail']=$CustomerShipping[0]['Email'];
					//Shipping end


					$arryDetails['PrefixPO']='PO';
					$arryDetails['AdminID']=$EDICompId;
					$arryDetails['ModuleID']='SaleID';
					
					$order_id = $objSale->AddSale($arryDetails);
					$objSale->sendSalesEmail($order_id);
					$objSale->AddUpdateItem($order_id, $arryDetails);


	 $SElectQury = "select SaleID from ".$DBName."s_order where OrderID='".$order_id."'";
		$arrySal = $this->query($SElectQury, 1);

	$SElectSaleQury = "select PurchaseID from p_order where OrderID='".$OrderID."'";
		$arryPur = $this->query($SElectSaleQury, 1);


			 $strSQL2 = "update p_order set EDIRefNo='EDI/".$EDICompId."/".$_SESSION['AdminID']."/".$order_id."/".$arrySal[0]['SaleID']."',EdiSoID ='".$order_id."' where OrderID='".$OrderID."'"; 
			$this->query($strSQL2, 0);

		 $strSQL = "update ".$DBName."s_order set EDIRefNo='EDI/".$EDICompId."/".$_SESSION['AdminID']."/".$OrderID."/".$arryPur[0]['PurchaseID']."',CustomerPO = '".$arryPur[0]['PurchaseID']."',EDICompId='".addslashes($_SESSION['AdminID'])."',EDICompName='".addslashes($_SESSION['DisplayName'])."',EdiPoID ='".$OrderID."' where OrderID='".$order_id."'";
			$this->query($strSQL, 0);

		}

		// end


			return $OrderID;

		}

		function AddUpdateItem($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);
$DBName='';
		if($EDIPurchaseCompName!='') {
			$DBName='erp_'.$EDIPurchaseCompName.'.';

		}
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
						 $sql = "update ".$DBName."p_order_item set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."',`Condition`='".addslashes($arryDetails['Condition'.$i])."', description='".addslashes($arryDetails['description'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."', qty='".addslashes($arryDetails['qty'.$i])."', price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."',Taxable='".addslashes($arryDetails['item_taxable'.$i])."' ,DropshipCheck='".addslashes($arryDetails['DropshipCheck'.$i])."' ,DropshipCost='".addslashes($arryDetails['DropshipCost'.$i])."',DesComment='".addslashes($arryDetails['DesComment'.$i])."',WID='".$arryDetails['WID'.$i]."',bin='".addslashes($arryDetails['bin'.$i])."',binid='".addslashes($arryDetails['binid'.$i])."' where id='".$id."'"; 

					}else{
						$sql = "insert into ".$DBName."p_order_item(OrderID, item_id, sku, description, on_hand_qty, qty, price, tax_id, tax, amount, Taxable, DropshipCheck, DropshipCost,`Condition`,DesComment,WID,bin,binid) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".$arryTax[0]."', '".$arryTax[1]."', '".addslashes($arryDetails['amount'.$i])."','".addslashes($arryDetails['item_taxable'.$i])."' ,'".addslashes($arryDetails['DropshipCheck'.$i])."' ,'".addslashes($arryDetails['DropshipCost'.$i])."','".addslashes($arryDetails['Condition'.$i])."','".addslashes($arryDetails['DesComment'.$i])."','".$arryDetails['WID'.$i]."','".$arryDetails['bin'.$i]."','".$arryDetails['binid'.$i]."')";


						/*******Notification on changing the Vendor price*********/
						if($Module=='Quote' || $Module=='Order'){
							$sql_supp = "select od.price as OldSuppPrice from ".$DBName."p_order o inner join ".$DBName."p_order_item od on o.OrderID=od.OrderID where o.SuppCode='".$SuppCode."' and o.Module in ('Order','Quote') and od.sku='".$arryDetails['sku'.$i]."' order by o.OrderID desc limit 0,1";						
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
			if($OrderType=='OrderType' && $arryDetails['DropshipCheck'.$i]==1 ){
						$sqLInv = "select GROUP_CONCAT(OrderID) as Ids from ".$DBName."s_order where SaleID ='".$SaleID."' and PostToGL ='0' ";
						$rsIn = $this->query($sqLInv);
						// $rsIn[0]['Ids']; 
						$rdrsID = explode(",",$rsIn[0]['Ids']);
						$rdrID = implode("','",$rdrsID);
						$sqlDropUpdate = "update ".$DBName."s_order_item set DropshipCost='".addslashes($arryDetails['price'.$i])."'  where (sku = '".$arryDetails['sku'.$i]."' OR item_id = '".$arryDetails['item_id'.$i]."')  and OrderID IN('$rdrID')"; 
						$this->query($sqlDropUpdate, 0);
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
						
						$qty_left = $arryDetails['qty'.$i] - $arryDetails['oldqty'.$i]; 
						$sql = "update p_order_item set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."',`Condition`='".addslashes($arryDetails['Condition'.$i])."', description='".addslashes($arryDetails['description'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."', qty='".addslashes($arryDetails['qty'.$i])."',qty_received='".addslashes($arryDetails['qty'.$i])."',  price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."',Taxable='".addslashes($arryDetails['item_taxable'.$i])."',SerialNumbers='".addslashes($serial_value)."',WID='".$arryDetails['WID'.$i]."'  where id='".$id."'"; 
						$this->query($sql, 0);	

						/*********Implemented on Post to Gl*******
						if($qty_left!=''){
							$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' and qty_on_hand<0";
							$this->query($UpdateQtysql2, 0);

							$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+" .$qty_left . "  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' ";
							$this->query($UpdateQtysql, 0);		
						}
						/******************/






					}else{
						$sql = "insert into p_order_item(OrderID, item_id, sku, description, on_hand_qty, qty,qty_received, price, tax_id, tax, amount, Taxable,DropshipCheck,DropshipCost,SerialNumbers,`Condition`,WID) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."','".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".$arryTax[0]."', '".$arryTax[1]."', '".addslashes($arryDetails['amount'.$i])."','".addslashes($arryDetails['item_taxable'.$i])."','1','".addslashes($arryDetails['DropshipCost'.$i])."','".addslashes($serial_value)."','".addslashes($arryDetails['Condition'.$i])."','".$arryDetails['WID'.$i]."')";
						
						$this->query($sql, 0);	

						/*********Implemented on Post to Gl*******
						if($arryDetails['qty'.$i]>0){
							$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' and qty_on_hand<0";
							$this->query($UpdateQtysql2, 0);

							$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+" .$arryDetails['qty'.$i] . "  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' ";
							$this->query($UpdateQtysql, 0);		
						}
						/******************/
					/*******Notification on changing the Vendor price*********					
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

			
							/******************/


						
                                                        
					}
					
                                        
                                        
    /********************CODE FOR ADD SERIAL NUMBERS*******************************************/
          
              if ($arryDetails['serial_value' . $i] != '') {
                      $serial_no = explode(",", $arryDetails['serial_value' . $i]);
$wCode =1;
                      for ($j = 0; $j < sizeof($serial_no); $j++) {
                              $strSQLQuery = "insert into inv_serial_item (serialNumber,Sku,UsedSerial,ReceiveOrderID,`Condition`,warehouse)  values ('" . $serial_no[$j] . "','" .addslashes($arryDetails['sku'.$i]). "','0','" . $order_id . "','".$arryDetails['Condition'.$i]."','".$arryDetails['WID'.$i]."')";
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

			//if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];
                        
                      	if(empty($Currency)) $Currency =  $Config['Currency'];
                        
                        if($OrderType == 'Dropship'){ $CustCode=$CustCode;} else{ $CustCode = ''; }
			if($Currency != $Config['Currency']){  
				if($Module=='Invoice' || $Module=='Credit'){
					$CurrencyDate = $PostedDate;	
				}else{
					$CurrencyDate = $OrderDate;	
				}
				$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP',$CurrencyDate);
			}else{   
				$ConversionRate=1;
			}

			 			
			if(isset($PostedDate)){
				if($PostedDate>0) $strAddSql .= ",PostedDate='".$PostedDate."'";
			}

			if(isset($Restocking) && isset($Restocking_fee)){
				$strAddSql .= ",Restocking='".$Restocking."' ,Restocking_fee='".$Restocking_fee."' ";
			}

//trackb
if(is_array($TrackingNo)){
$TrackingNo =implode(':',$TrackingNo);
}
			$strSQLQuery = "update p_order set  OrderType='".$OrderType."', OrderDate='".$OrderDate."', Approved='".$Approved."', Status='".$Status."',   ClosedDate='".$ClosedDate."', wCode='".$wCode."', DropShip='".$DropShip."', DeliveryDate='".$DeliveryDate."',Comment='".addslashes(strip_tags($Comment))."', SuppCode='".addslashes($SuppCode)."',  SuppCompany='".addslashes($SuppCompany)."', SuppContact='".addslashes($SuppContact)."', Address='".addslashes($Address)."', City='".addslashes($City)."', State='".addslashes($State)."', Country='".addslashes($Country)."', ZipCode='".addslashes($ZipCode)."' , Currency='".addslashes($Currency)."' , SuppCurrency='".addslashes($SuppCurrency)."', Mobile='".addslashes($Mobile)."' ,Landline='".addslashes($Landline)."', Fax='".addslashes($Fax)."' ,Email='".addslashes($Email)."' ,  wName='".addslashes($wName)."', wContact='".addslashes($wContact)."', wAddress='".addslashes($wAddress)."', wCity='".addslashes($wCity)."', wState='".addslashes($wState)."', wCountry='".addslashes($wCountry)."', wZipCode='".addslashes($wZipCode)."' , wMobile='".addslashes($wMobile)."' ,wLandline='".addslashes($wLandline)."',wEmail='".addslashes($wEmail)."', TotalAmount='".addslashes($TotalAmount)."' ,Freight='".addslashes($Freight)."'	,UpdatedDate = '".$Config['TodayDate']."', PaymentMethod='".addslashes($PaymentMethod)."', ShippingMethod='".addslashes($ShippingMethod)."', PaymentTerm='".addslashes($PaymentTerm)."', AssignedEmpID='".addslashes($EmpID)."', AssignedEmp='".addslashes($EmpName)."',Taxable='".addslashes($Taxable)."' ,SaleID='".addslashes($SaleID)."', taxAmnt ='".addslashes($taxAmnt)."', tax_auths='".addslashes($tax_auths)."', TaxRate='".addslashes($MainTaxRate)."', CustCode = '".$CustCode."',AccountID ='".addslashes($AccountID)."' ,PrepaidFreight ='".addslashes($PrepaidFreight)."' ,PrepaidVendor ='".addslashes($PrepaidVendor)."' ,PrepaidAmount ='".addslashes($PrepaidAmount)."',ShippingMethodVal ='".addslashes($ShippingMethodVal)."',ConversionRate ='".addslashes($ConversionRate)."',freightTxSet ='".addslashes($freightTxSet)."',TrackingNo ='".addslashes($TrackingNo)."',CreditCardVendor ='".addslashes($CreditCardVendor)."' ".$strAddSql." where OrderID='".mysql_real_escape_string($OrderID)."'"; 

			$this->query($strSQLQuery, 0);
		
			
			$objConfigure = new configure();			
			$objConfigure->EditUpdateAutoID('p_order',$ModuleID,$OrderID,$arryDetails[$ModuleID]);  


/***************************EDI********************************/
$Sql = "Select * from p_order where OrderID ='".mysql_real_escape_string($OrderID)."' ";
			$rows = $this->query($Sql, 1);
			$EDICompId = $rows[0]['EDICompId'];
			$DBName=''; 
			$EDISalesCompName = $rows[0]['EDICompName'];
				if($rows[0]['EDICompName']=='' && empty($rows[0]['EdiRefInvoiceID'])){
  if($rows[0]['EDICompName']!='') { $DBName='erp_'.$rows[0]['EDICompName'].'.'; $EDICompName=$rows[0]['EDICompName']; } if($AdminID==''){ $AdminID=$_SESSION['AdminID']; }
}
			
		

    /************************************************/
    
    // Add EDI purchase
		if($EDICompId!='' && $EDISalesCompName!='' && $Module=='Order' ){
			$DBName='';
			if($EDISalesCompName!='') {
				$DBName='erp_'.$EDISalesCompName.'.';

			}
      $objSale = new sale();
       $sql= "select * from ".$DBName."s_customers where EDICompId='".addslashes($_SESSION['CmpID'])."' ";
      $Customerdetail = $this->query($sql,1);
      
     

      //$arryDetails['PONumber']=$Customerdetail[0]['PONumber'];
      $arryDetails['CustomerCompany']=$Customerdetail[0]['Company'];
      $arryDetails['CustID']=$Customerdetail[0]['Cid'];
      $arryDetails['CustomerName']=$Customerdetail[0]['Company'];
      $arryDetails['CustCode']=$Customerdetail[0]['CustCode'];
      $arryDetails['Currency']=$Customerdetail[0]['Currency'];
      $arryDetails['Status']='Open';
      //$arryDetails['PaymentMethod']=$Customerdetail[0]['PaymentMethod'];
      //$arryDetails['PaymentTerm']=$Customerdetail[0]['PaymentTerm'];

$Commdetail =array();
     	$sqlCom= "select GROUP_CONCAT(EmpSpId  SEPARATOR ',') as Userids,GROUP_CONCAT(VenSpId  SEPARATOR ',') as VendorIDs from ".$DBName."customer_sales_commission where CustomerId ='".addslashes($Customerdetail['0']['Cid'])."' ";
					$Commdetail = $this->query($sqlCom);
					
					
		
					
					if(sizeof($Commdetail)>0){
						            $objConfig=new admin();
                 if($Commdetail[0]['VendorIDs']!=''){
                    $arryVenID = explode(',', $Commdetail[0]['VendorIDs']);
                    $arryVenID = array_diff($arryVenID, array(0));
           
                     // Combine the array back into a comma-delimited string
                     $Commdetail[0]['VendorIDs'] = implode(',', $arryVenID);

                      $vendorName = $objConfig->getSalesPersonName($Commdetail[0]['VendorIDs'],1,$DBName);
                     
                     
                     $salesPerson = $vendorName;
                     $arryDetails['vendorSalesPersonID']=$Commdetail[0]['VendorIDs'];
                 }
                 if($Commdetail[0]['Userids']!=''){
                  $arryUserids = explode(',', $Commdetail[0]['Userids']);
                    $arryUserids = array_diff($arryUserids, array(0));

                      $Commdetail[0]['Userids'] = implode(',', $arryUserids);
                    $UserName =	$objConfig->getSalesPersonName($Commdetail[0]['Userids'],0,$DBName);
                    $salesPerson = $UserName;
                    $arryDetails['SalesPersonID']=$Commdetail[0]['Userids'];
                 }
                if($Commdetail[0]['VendorIDs']!='' && $Commdetail[0]['Userids']!='')
                {
                    $salesPerson = $UserName.",".$vendorName;
                }
					
					             $arryDetails['SalesPerson']=$salesPerson;
					}
					//Billing Address
          $sqlbilling= "select * from ".$DBName."s_address_book where CustID='".addslashes($Customerdetail[0]['Cid'])."' and AddType = 'billing' ";
					$CustomerBilling = $this->query($sqlbilling);

					$arryDetails['BillingName']=$CustomerBilling[0]['Company'];
					$arryDetails['CustomerName']=$CustomerBilling[0]['Company'];
					$arryDetails['CustomerCompany']=$CustomerBilling[0]['Company'];
					$arryDetails['Address']=stripslashes($CustomerBilling[0]['Address']);
					$arryDetails['City']=$CustomerBilling[0]['CityName'];
					$arryDetails['State']=$CustomerBilling[0]['StateName'];
					$arryDetails['Country']=$CustomerBilling[0]['CountryName'];
     $arryDetails['CityID']=$CustomerBilling[0]['city_id'];
					$arryDetails['StateID']=$CustomerBilling[0]['state_id'];
					$arryDetails['CountryId']=$CustomerBilling[0]['country_id'];
					$arryDetails['ZipCode']=$CustomerBilling[0]['ZipCode'];
					$arryDetails['Mobile']=$CustomerBilling[0]['Mobile'];
					$arryDetails['Landline']=$CustomerBilling[0]['Landline'];
					$arryDetails['Fax']=$CustomerBilling[0]['Fax'];
					$arryDetails['Email']=$CustomerBilling[0]['Email'];

					//Billing end


					//Shipping Address
          $sqlShipping= "select * from ".$DBName."s_address_book where CustID='".addslashes($Customerdetail[0]['Cid'])."' and AddType = 'shipping' ";
					$CustomerShipping= $this->query($sqlShipping);

					$arryDetails['ShippingName']=$CustomerShipping[0]['Company'];
					$arryDetails['ShippingCompany']=$CustomerShipping[0]['Company'];
					$arryDetails['CustomerCompany']=$CustomerShipping[0]['Company'];
					$arryDetails['ShippingAddress']=$CustomerShipping[0]['Address'];
					$arryDetails['ShippingCity']=$CustomerShipping[0]['CityName'];
					$arryDetails['ShippingState']=$CustomerShipping[0]['StateName'];
					$arryDetails['ShippingCountry']=$CustomerShipping[0]['CountryName'];
     $arryDetails['ShippingCityID']=$CustomerShipping[0]['city_id'];
					$arryDetails['ShippingStateID']=$CustomerShipping[0]['state_id'];
					$arryDetails['ShippingCountryID']=$CustomerShipping[0]['country_id'];
					$arryDetails['ShippingZipCode']=$CustomerShipping[0]['ZipCode'];
					$arryDetails['ShippingMobile']=$CustomerShipping[0]['Mobile'];
					$arryDetails['ShippingLandline']=$CustomerShipping[0]['Landline'];
					$arryDetails['ShippingFax']=$CustomerShipping[0]['Fax'];
					$arryDetails['ShippingEmail']=$CustomerShipping[0]['Email'];
					$arryDetails['EDISalesCompName']=$rows[0]['EDICompName'];
					$arryDetails['CustomerPO']=$rows[0]['PurchaseID'];
					//Shipping end


					$arryDetails['PrefixPO']='PO';
					$arryDetails['AdminID']=$EDICompId;
					$arryDetails['ModuleID']='SaleID';
					$arryDetails['Module']='Order';
					
					$sqlso = "select  OrderID from ".$DBName."s_order where CustomerPO = '".$rows[0]['PurchaseID']."' ";
					$arrySo = $this->query($sqlso, 1);
					
				
					if(!empty($arrySo[0]['OrderID'])){
					$order_id = $arrySo[0]['OrderID'];
					$arryDetails['OrderID']=$order_id;
					$objSale->UpdateSale($arryDetails);
					//$objSale->sendSalesEmail($order_id);
					
					$strSQLQuery = "delete from ".$DBName."s_order_item where OrderID='".$order_id."'"; 
			 $this->query($strSQLQuery, 0);
			 
					$objSale->AddUpdateItem($order_id, $arryDetails);
					}
    
    }

/*************************END EDI**********************************/

			return 1;
		}
                
                
                function getReceiveInvoiceID($order_id){
                    
                    $strSQLQuery = "select InvoiceID from p_order  where OrderID = '".$order_id."'";
		    $rows = $this->query($strSQLQuery, 1);
                    return $rows[0]['InvoiceID'];
                }
                
                 

	
		function ReceiveOrder($arryDetails){
			global $Config;

			extract($arryDetails);

			if(!empty($ReceiveOrderID)){
				$arryPurchase = $this->GetPurchase($ReceiveOrderID,'','');
				$arryPurchase[0]["Module"] = "Invoice";
				$arryPurchase[0]["ModuleID"] = "InvoiceID";
				$arryPurchase[0]["PrefixPO"] = "INV";
				$arryPurchase[0]["ReceivedDate"] = $ReceivedDate;
				$arryPurchase[0]["Freight"] = $Freight;
				$arryPurchase[0]["taxAmnt"] = $taxAmnt;
				//$arryPurchase[0]["tax_auths"] = $tax_auths;
				$arryPurchase[0]["TotalAmount"] = $TotalAmount;	
				$arryPurchase[0]["InvoicePaid"] = $InvoicePaid;	
				$arryPurchase[0]["InvoiceComment"] = $InvoiceComment;	
				$arryPurchase[0]["EmpID"] = $arryPurchase[0]['AssignedEmpID'];	
				$arryPurchase[0]["EmpName"] = $arryPurchase[0]['AssignedEmp'];	
				$arryPurchase[0]["Status"] = "Invoicing";			
				$arryPurchase[0]["InvoiceID"] = $InvoiceID;				
				$arryPurchase[0]["MainTaxRate"] = $arryPurchase[0]['TaxRate'];	
				$arryPurchase[0]["PrepaidAmount"] = $PrepaidAmount;
				if(!empty($PostedDate))$arryPurchase[0]["PostedDate"] = $PostedDate;	
				if($arryPurchase[0]["EdiRefInvoiceID"] ==''){
          $arryPurchase[0]["EdiRefInvoiceID"] = $EdiRefInvoiceID;
        }
				$order_id = $this->AddPurchase($arryPurchase[0]);
                                
                                //GET InvoiceID
                                
                                $ReceiveInvoiceID = $this->getReceiveInvoiceID($order_id);
                                
                     $Currency = $arryPurchase[0]["Currency"];
if(empty($Currency)) $Currency =  $Config['Currency'];
			
                       
			if($Currency != $Config['Currency']){  		
				$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP',$PostedDate);
				//$NetPrice = round(GetConvertedAmount($ConversionRate, $ItemCost),2);
			}else{   
				$ConversionRate=1;
			}
          
                               
				/******** Item Updation for Invoice ************/
				$arryItem = $this->GetPurchaseItem($ReceiveOrderID);
				$NumLine = sizeof($arryItem);
                                
                        
                                
				$totalTaxAmnt = 0;$taxAmnt=0;
				for($i=1;$i<=$NumLine;$i++){
					$Count=$i-1;
					
					if($arryDetails['qty'.$i]>0){
						$qty_received = $arryDetails['qty'.$i];

					

						/********************By bhoodev 11jan2017*****************************/
						$tot_freight_cost = $arryDetails['freight_cost'.$i]/$qty_received;
						$NetAngCostSr = $arryDetails['price' . $i]+$tot_freight_cost;
						$NetPriceSr = round(GetConvertedAmount($ConversionRate, $NetAngCostSr),2);
						/*************************************************/


						if($arryItem[$Count]["tax"] > 0){
							$actualAmnt = ($arryItem[$Count]["price"]-$arryItem[$Count]["discount"])*$arryDetails['qty'.$i]; 	
							$taxAmnt = ($actualAmnt*$arryItem[$Count]["tax"])/100;
							$totalTaxAmnt += $taxAmnt;
						}

              $arryDetails['id'.$i] ='';

                                                if($arryDetails['DropshipCheck'.$i] == 1){$DropshipCheck = 1;$serial_value='';}else{$DropshipCheck = 0;$serial_value=trim($arryDetails['serial_value'.$i]);}
                                                
						 $sql = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, price, tax_id, tax, amount,Taxable, DropshipCheck, DropshipCost,SerialNumbers,`Condition`,freight_cost,WID,bin,binid) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".addslashes($arryItem[$Count]["sku"])."', '".addslashes($arryItem[$Count]["description"])."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_received."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."', '".addslashes($arryItem[$Count]["DropshipCheck"])."' ,'".addslashes($arryItem[$Count]["DropshipCost"])."','".addslashes($serial_value)."','".addslashes($arryItem[$Count]["Condition"])."', '".$arryDetails['freight_cost'.$i]."','".$arryItem[$Count]["WID"]."','".addslashes($arryItem[$Count]["bin"])."', '".$arryDetails['binid'.$i]."')";

						$this->query($sql, 0);	
              $OrderItemID = $this->lastInsertId();                                  
                       

/*******************By bhoodev 11jan2017*********************/

$objItem=new items();
$checkProduct=$objItem->checkItemSku($arryItem[$Count]["sku"]);

		//By Chetan 9sep// 
		if(empty($checkProduct))
		{
		$arryAlias = $objItem->checkItemAliasSku($arryItem[$Count]["sku"]);
			if(count($arryAlias)){
					$mainSku = $arryAlias[0]['sku'];
			}
		}else{

		$mainSku = $arryItem[$Count]["sku"];
		}




/**************************************************************/



                         
                                                
       /*********Added By karishma based on Condition 6 Jan 2016*********************/
	$FinalPrice = $arryItem[$Count]["price"] + ($arryDetails['freight_cost'.$i]/$arryItem[$Count]["qty"]);
/*if($arryDetails['ReceiptStatus']=="Completed" && $arryDetails['GenrateInvoice']==1 && $DropshipCheck!=1){
					if($arryItem[$Count]["Condition"]!=''){
						 $sql="select count(*) as total,ID from ".$DBName."inv_item_quanity_condition where 
						Sku='" . addslashes($mainSku) . "' and 
						ItemID='" . addslashes($arryItem[$Count]["item_id"]) . "'
						and `condition`='".addslashes($arryItem[$Count]["Condition"])."' and WID='".$arryItem[$Count]["WID"]."' "; 
						$restbl=$this->query($sql, 1);

						if($restbl[0]['total']==0){
							//If not find insert in tbl
							$strSQLQuery = "insert into ".$DBName."inv_item_quanity_condition 
							(ItemID,`condition`,Sku,type,condition_qty,AvgCost,WID)  
							values ('" . addslashes($arryItem[$Count]["item_id"]) . "',
							'" . addslashes($arryItem[$Count]["Condition"]) . "',
							'" . addslashes($mainSku) . "','Recive Order',
							'" . addslashes($qty_received) . "','".$NetPriceSr."','".$arryItem[$Count]["WID"]."')";
							$this->query($strSQLQuery, 0);
$lastRecId = $this->lastInsertId();
						}else{

$lastRecId = $restbl[0]['ID'];
							
$UpdateQtysql = "update ".$DBName."inv_item_quanity_condition set condition_qty = condition_qty+" . $qty_received . ",AvgCost = AvgCost+".$NetPriceSr."  where Sku='".$mainSku."' and `condition` = '".$arryItem[$Count]["Condition"]."' and WID='".$arryItem[$Count]["WID"]."' ";
							$this->query($UpdateQtysql, 0);
						}

 $strSQLQuery2 = "insert into inv_bin_stock (Wcode,Sku,reorderlevel,bin,QTID ) 
	values ('" . addslashes($arryItem[$Count]["WID"]) . "','" . addslashes($mainSku) . "','" . addslashes($reorderlevel) . "' ,'" . addslashes($arryItem[$Count]["binid"]) . "','" . addslashes($lastRecId) . "')";

$this->query($strSQLQuery2, 0);
					}
			}*/

		/*********Implemented on Post to Gl*******/
		if($arryDetails['qty'.$i]>0){
			$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$mainSku. "' and ItemID ='".$arryDetails['item_id'.$i]."' and qty_on_hand<0";
			$this->query($UpdateQtysql2, 0);

			$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+".$arryDetails['qty'.$i]."  where Sku='" .$mainSku. "' and ItemID ='".$arryDetails['item_id'.$i]."' ";
			$this->query($UpdateQtysql, 0);		
		}
		/******************/
		
					
	/*********End By karishma based on Condition*********************/

		
                 
                                                
	/*************CODE FOR ADD SERIAL NUMBERS******/
                                                
/*if ($arryDetails['serial_value' . $i] != '') {
$serial_no = explode(",", $arryDetails['serial_value' . $i]);
//$serial_desc = explode(",", $arryDetails['serialdesc' . $i]);
//$serial_price = explode(",", $arryDetails['serialPrice' . $i]);



for ($j = 0; $j < sizeof($serial_no); $j++) {
		$SerchSql = "select * from inv_serial_item where LCASE(serialNumber)='" . strtolower(trim($serial_no[$j])) . "' and LCASE(Sku) ='".strtolower(trim($arryItem[$Count]["sku"])) ."' and `Condition` ='".$arryItem[$Count]["Condition"]."' and warehouse='".$arryItem[$Count]["WID"]."' and UsedSerial =0 and Status=1 ";

		$arryRow = $this->query($SerchSql, 1);
		if ($arryRow[0]['serialID'] > 0) 
		{
		$numSrId =  1;
		} else {
		$numSrId = 0;
		}

if($numSrId == 0){
$arryPurchase[0]['wCode'] =1;
$def = 1;
	$strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,UsedSerial,ReceiveOrderID,`Condition`,type,UnitCost,description,ReceiptDate)  values ('".$arryItem[$Count]["WID"]."','" . $serial_no[$j] . "','" . addslashes($mainSku) . "','0','" . $ReceiveOrderID . "','".$arryItem[$Count]["Condition"]."','Receive Order','".$NetPriceSr."','".addslashes($serial_desc[$j])."','".$Config['TodayDate']."')";

									$this->query($strSQLQuery, 0);
									$SerialID = $this->lastInsertId();

							
                        
            }
      }

}*/

/*if($def==1){
		if($arryItem[$Count]["valuationType"]=='Serialized Average'){

					$arrySerial = $this->GetSerialNumberByID('',$arryItem[$Count]["sku"],$ReceiveOrderID,'',$arryItem[$Count]["Condition"]);
					$NumItem = count($arrySerial);
					foreach($arrySerial as $SerVal){
						 $SerValPrice += $SerVal['UnitCost'];
					}
					$SerValPrice = $SerValPrice/$NumItem;
					$sqlSerialUpdate = "update inv_serial_item set UnitCost = '".$SerValPrice."' where UsedSerial = 0 and Sku = '".$arryDetails['sku' . $i]."' and `Condition` ='".$arryDetails['Condition' . $i]."'";
					$this->query($sqlSerialUpdate, 0);
					//$serial_price = explode("|", $arryDetails['serialPrice' . $i]);
		}else{


	$sqlSerialUpdate = "update inv_serial_item set UnitCost = '".$SerValPrice."' where UsedSerial = 0 and Sku = '".$arryDetails['sku' . $i]."' and `Condition` ='".$arryDetails['Condition' . $i]."'";
					$this->query($sqlSerialUpdate, 0);


}

}*/




                                                
                                                /***********************END CODE**********************************************/

					}
				}


 //SET TRANSACTION DATA




																
																$arryTransaction['ConversionRate']   = $ConversionRate;
                                $arryTransaction['TransactionOrderID'] = $order_id;
                                $arryTransaction['TransactionInvoiceID'] = $ReceiveInvoiceID;
                                $arryTransaction['TransactionDate'] = $ReceivedDate;
                                $arryTransaction['TransactionType'] = 'PO Invoice';
                                $objItem = new items();
                                $objItem->addItemTransaction($arryTransaction,$arryItem,$type='PO');
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
     /******************Add by bhoodev for reciept warehouse order 27 jan2016*/

function getReceiveReceiptID($order_id){
                    
                    $strSQLQuery = "select ReceiptID from p_order  where OrderID = '".$order_id."'";
		    $rows = $this->query($strSQLQuery, 1);
                    return $rows[0]['ReceiptID'];
                }




function ReceiptOrder($arryDetails)	{
			global $Config;
			extract($arryDetails);

			if(!empty($ReceiveOrderID)){
				$arryPurchase = $this->GetPurchase($ReceiveOrderID,'','');
				$arryPurchase[0]["Module"] = "Receipt";
				$arryPurchase[0]["ModuleID"] = "ReceiptID";
				$arryPurchase[0]["ReceiptID"] = $ReceiptID;
				$arryPurchase[0]["PrefixPO"] = "RECEIPT";
				$arryPurchase[0]["ReceivedDate"] = $ReceivedDate;
				$arryPurchase[0]["Freight"] = $Freight;
				$arryPurchase[0]["taxAmnt"] = $taxAmnt;
				//$arryPurchase[0]["tax_auths"] = $tax_auths;
				$arryPurchase[0]["TotalAmount"] = $TotalAmount;	
				//$arryPurchase[0]["InvoicePaid"] = $InvoicePaid;	
				$arryPurchase[0]["InvoiceComment"] = $InvoiceComment;	
				$arryPurchase[0]["EmpID"] = $arryPurchase[0]['AssignedEmpID'];	
				$arryPurchase[0]["EmpName"] = $arryPurchase[0]['AssignedEmp'];	
				$arryPurchase[0]["ReceiptStatus"] = $ReceiptStatus;			
				$arryPurchase[0]["GenrateInvoice"] = $GenrateInvoice;				
				$arryPurchase[0]["MainTaxRate"] = $arryPurchase[0]['TaxRate'];	
				$arryPurchase[0]["PrepaidAmount"] = $PrepaidAmount;	
				$arryPurchase[0]["POReceipt"] = $POReceipt;	
if($GenrateInvoice ==1 && $ReceiptStatus =='Completed'){
				$arryPurchase[0]["RefInvoiceID"] = $RefInvoiceID;	
}
	if($arryPurchase[0]["EdiRefInvoiceID"]==''){
        $arryPurchase[0]["EdiRefInvoiceID"] = $EdiRefInvoiceID;
        }
				$order_id = $this->AddPurchase($arryPurchase[0]);
                                
                                //GET ReceiptID   
                                $ReceiveReceiptID = $this->getReceiveReceiptID($order_id);



													$Currency = $arryPurchase[0]["Currency"];
														if(empty($Currency)) $Currency =  $Config['Currency'];


																if($Currency != $Config['Currency']){  

																				if($arryPurchase[0]["ConversionRate"]!=''){
																						$ConversionRate =	$arryPurchase[0]["ConversionRate"];
																					}else{
																						$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP',$arryPurchase[0]["OrderDate"]);
																						//$NetPrice = round(GetConvertedAmount($ConversionRate, $ItemCost),2);
																					}
																}else{   
																   $ConversionRate=1;
																}


																//$arryDetails['ConversionRate']   = $ConversionRate;
																$arryTransaction['Currency']  = $arryPurchase[0]["Currency"];
																 $arryTransaction['ConversionRate']  = $ConversionRate; 
                                //SET TRANSACTION DATA
                                $arryTransaction['TransactionOrderID'] = $order_id;
                                $arryTransaction['TransactionInvoiceID'] = $ReceiveReceiptID;
                                $arryTransaction['TransactionDate'] = $ReceivedDate;
                                $arryTransaction['TransactionType'] = 'PO Receipt';
                                $objItem = new items();
                                $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='PO');
                               
				/******** Item Updation for Invoice ************/
				$arryItem = $this->GetPurchaseItem($ReceiveOrderID);
				$NumLine = sizeof($arryItem);
                             
				$totalTaxAmnt = 0;$taxAmnt=0;
				for($i=1;$i<=$NumLine;$i++){
					$Count=$i-1;
					

					$tot_freight_cost = $arryDetails['freight_cost'.$i]/$arryDetails['qty'.$i];
					$NetAngCostSr = $arryDetails['price' . $i]+$tot_freight_cost;
					$NetPriceSr = round(GetConvertedAmount($ConversionRate, $NetAngCostSr),2);

					if(!empty($arryDetails['id'.$i]) && $arryDetails['qty'.$i]>0){
						$qty_received = $arryDetails['qty'.$i];

						if($arryItem[$Count]["tax"] > 0){
							$actualAmnt = ($arryItem[$Count]["price"]-$arryItem[$Count]["discount"])*$arryDetails['qty'.$i]; 	
							$taxAmnt = ($actualAmnt*$arryItem[$Count]["tax"])/100;
							$totalTaxAmnt += $taxAmnt;
						}


                                                if($arryItem[$Count]["DropshipCheck"] == 1){$DropshipCheck = 1;$serial_value='';}else{$DropshipCheck = 0;$serial_value=trim($arryDetails['serial_value'.$i]);}
                                                
						$sql = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, price, tax_id, tax, amount,Taxable, DropshipCheck, DropshipCost,SerialNumbers,`Condition`,freight_cost,WID,bin,binid) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryItem[$Count]["id"]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_received."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."', '".addslashes($arryItem[$Count]["DropshipCheck"])."' ,'".addslashes($arryItem[$Count]["DropshipCost"])."','".addslashes($serial_value)."','".$arryItem[$Count]["Condition"]."', '".$arryDetails['freight_cost'.$i]."','".$arryItem[$Count]["WID"]."','".addslashes($arryItem[$Count]["bin"])."','".$arryItem[$Count]["binid"]."')";

						$this->query($sql, 0);	
             $LineId =$this->lastInsertId();                                  
                                                
        //$strSQL = "update p_order_item set qty_received = '".$qty_received."' where id='".$LineId."'"; 
				//$this->query($strSQL, 0);
                                                
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

					$strSQLQuery = "update p_order set Status='Receiving' where OrderID='".$ReceiveOrderID."'"; 
					$this->query($strSQLQuery, 0);

					$strSQLInv = "update p_order set Status='Receiving' where OrderID='".$order_id."'"; 
					$this->query($strSQLInv, 0);

				}


			}


			return $order_id;
		}


		/* end */           


		function UpdatePOInvoice($arryDetails)	{
			global $Config;
			extract($arryDetails);
			if(!empty($OrderID)){
				$arryInvoice = $this->GetPurchase($OrderID,'','');
				$InvoiceID = $arryInvoice[0]['InvoiceID'];
				$PurchaseID = $arryInvoice[0]['PurchaseID'];
				$Currency = $arryInvoice[0]['Currency'];
			}
			
			if(!empty($PurchaseID)){
				$arryPurchase = $this->GetPurchase('',$PurchaseID,'Order');
				$ReceiveOrderID	 = $arryPurchase[0]['OrderID'];
				
				if($Currency != $Config['Currency']){  
					$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP',$PostedDate);
				}else{   
					$ConversionRate=1;
				}


				$strSQLQuery = "update p_order set 
				PostedDate  = '".$PostedDate."',  ConversionRate  = '".$ConversionRate."',  
				ReceivedDate  = '".$ReceivedDate."',                                 
				InvoiceComment  = '".$InvoiceComment."',
				TotalAmount  = '".$TotalAmount."',
				TotalInvoiceAmount  = '".$TotalAmount."',
				Freight  = '".$Freight."',
				PrepaidAmount  = '".$PrepaidAmount."',
				UpdatedDate  = '".$Config['TodayDate']."'

				where OrderID='".$OrderID."'  ";                        
				$this->query($strSQLQuery, 0);                                                     
                               
				/******** Item Updation for Invoice ************/
				$arryItem = $this->GetPurchaseItem($OrderID);
				$NumLine = sizeof($arryItem);
                                
                        
                                
				$totalTaxAmnt = 0;$taxAmnt=0;
				for($i=1;$i<=$NumLine;$i++){
					$Count=$i-1;
					
					if(!empty($arryDetails['id'.$i])){

					       
						$oldqty = $arryDetails['oldqty'.$i];
						$qty_received = $arryDetails['qty'.$i];
						
						$qty_left = $qty_received - $oldqty; 


						if($arryItem[$Count]["tax"] > 0){
							$actualAmnt = ($arryItem[$Count]["price"]-$arryItem[$Count]["discount"])*$arryDetails['qty'.$i]; 	
							$taxAmnt = ($actualAmnt*$arryItem[$Count]["tax"])/100;
							$totalTaxAmnt += $taxAmnt;
						}


                                                if($arryDetails['DropshipCheck'.$i] == 'Drop Ship'){$DropshipCheck = 1;$serial_value='';}else{$DropshipCheck = 0;$serial_value=trim($arryDetails['serial_value'.$i]);}
                                                
						 $sql = "update p_order_item set on_hand_qty='".$arryItem[$Count]["on_hand_qty"]."', qty='".$arryItem[$Count]["qty"]."', qty_received='".$qty_received."', price='".$arryItem[$Count]["price"]."', tax_id='".$arryItem[$Count]["tax_id"]."', tax='".$arryItem[$Count]["tax"]."', amount='".$arryDetails['amount'.$i]."',Taxable='".$arryItem[$Count]["Taxable"]."', DropshipCheck='".addslashes($arryItem[$Count]["DropshipCheck"])."', DropshipCost='".addslashes($arryItem[$Count]["DropshipCost"])."',SerialNumbers='".addslashes($serial_value)."',`Condition`='".$arryItem[$Count]["Condition"]."', freight_cost='".$arryDetails['freight_cost'.$i]."',`WID`='".$arryItem[$Count]["WID"]."'   where id='".$arryDetails['id'.$i]."'";

						$this->query($sql, 0);	
                                                
                                                
                                                         
      

		/*********Implemented on Post to Gl*******
		if($qty_left!=''){
			$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' and qty_on_hand<0";
			$this->query($UpdateQtysql2, 0);

			$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+" .$qty_left . "  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' ";
			$this->query($UpdateQtysql, 0);		
		}
		/******************/

                    
                                                
                                                /********************CODE FOR ADD SERIAL NUMBERS*******************/
                                                
                                                    if ($arryDetails['serial_value' . $i] != '') {
                                                            $serial_no = explode(",", $arryDetails['serial_value' . $i]);
																														$arryPurchase[0]['wCode'] =1;
                                                            for ($j = 0; $j < sizeof($serial_no); $j++) {
                                                                    $strSQLQuery = "insert into inv_serial_item (serialNumber,Sku,UsedSerial,ReceiveOrderID,`Condition`,warehouse)  values ('" . $serial_no[$j] . "','" . addslashes($arryItem[$Count]["sku"]) . "','0','" . $order_id . "','".$arryItem[$Count]["Condition"]."','".$arryItem[$Count]["WID"]."')";
                                                                    $this->query($strSQLQuery, 0);
                        
                                                            }
                                                    }
                                                
                                                /***********************END CODE***********************/

					

					



					}
				}


				/****************************parwez*/
				$TotalQtyLeft = 1;
				$TotalQtyLeft = $this->GetTotalQtyLeft($PurchaseID);
				if($TotalQtyLeft<=0){
					$strSQLQuery = "update p_order set Status='Completed', ClosedDate='".$Config['TodayDate']."' where OrderID='".$ReceiveOrderID."'"; 
					$this->query($strSQLQuery, 0);

					$strSQLInv = "update p_order set Status='Completed', ClosedDate='".$Config['TodayDate']."' where OrderID='".$OrderID."'"; 
					$this->query($strSQLInv, 0);

				}else{

					$strSQLQuery = "update p_order set Status='Invoicing' where OrderID='".$ReceiveOrderID."'"; 
					$this->query($strSQLQuery, 0);

					$strSQLInv = "update p_order set Status='Invoicing' where OrderID='".$OrderID."'"; 
					$this->query($strSQLInv, 0);

				}


			}



			$objConfigure = new configure();			
			$objConfigure->EditUpdateAutoID('p_order','InvoiceID',$OrderID,$arryDetails["PoInvoiceID"]); 


			return true;
		}


                
                function ReceiveOrderInvoiceEntry($arryDetails)	{
			 
                        global $Config;
			extract($arryDetails);
                        $IPAddress = GetIPAddress();
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
			 if(empty($PostedDate)) $PostedDate = $Config['TodayDate'];

			if($Currency != $Config['Currency']){  
				$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP',$PostedDate);
			}else{   
				$ConversionRate=1;
			}



                     $strSQLQuery = "insert into p_order set Module='Invoice',
                                        PurchaseID = '".$ReferenceNo."',
                                        InvoiceID  = '".$InvoiceID."',
					  ConversionRate  = '".$ConversionRate."',
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
   					VendorInvoiceDate  = '".$VendorInvoiceDate."',
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
					  TotalInvoiceAmount  = '".addslashes($TotalAmount)."',
                                        Freight  = '".addslashes($Freight)."',
					taxAmnt  = '".addslashes($taxAmnt)."',
					tax_auths  = '".addslashes($tax_auths)."',
					TaxRate  = '".addslashes($MainTaxRate)."',
                                        CreatedBy  = '".addslashes($CreatedBy)."',
                                        AdminID  = '".$AdminID."', 
                                        AdminType  = '".$AdminType."',
                                        PostedDate  = '".$PostedDate."',
					 CreatedDate  = '".$Config['TodayDate']."',
                                        UpdatedDate  = '".$Config['TodayDate']."',
                                        ReceivedDate  = '".$ReceivedDate."', 
                  			IPAddress = '". $IPAddress."',
                                        InvoicePaid  = '".$InvoicePaid."',
                                        InvoiceComment  = '".addslashes(strip_tags($InvoiceComment))."',
                                        PaymentMethod  = '".addslashes($PaymentMethod)."',
                                        ShippingMethod  = '".addslashes($ShippingMethod)."', 
					ShippingMethodVal ='".addslashes($ShippingMethodVal)."',
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
					    AccountID='".$AccountID."',
						 CreditCardVendor='".$CreditVendor."',
						freightTxSet='".$freightTxSet."' ";
                     
                    // echo $strSQLQuery;exit;
                                    $this->query($strSQLQuery, 0);
                                    $OrderID = $this->lastInsertId();

			/*if(empty($InvoiceID)){
				$InvoiceID = 'INV000'.$OrderID;
				$strSQL = "update p_order set InvoiceID ='".$InvoiceID."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}*/

			$objConfigure = new configure();
			$objConfigure->UpdateModuleAutoID('p_order','Invoice',$OrderID,$InvoiceID);

			return $OrderID;

		}

 		function UpdateOrderInvoiceEntry($arryDetails)	{
			 
                        global $Config;
			extract($arryDetails);
                                             
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];

			if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}

			if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
			if($EntryInterval == 'yearly'){$EntryWeekly = '';}
			if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
			if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}

			if(empty($Currency)) $Currency =  $Config['Currency'];
			if(empty($PostedDate)) $PostedDate = $Config['TodayDate'];

			if($Currency != $Config['Currency']){  
				$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP',$PostedDate);
			}else{   
				$ConversionRate=1;
			}

			$strSQLQuery = "update p_order set 
				ConversionRate  = '".$ConversionRate."',
				wCode  = '".$wCode."',                                       
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
				VendorInvoiceDate  = '".$VendorInvoiceDate."',
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
				TotalInvoiceAmount  = '".addslashes($TotalAmount)."',
				Freight  = '".addslashes($Freight)."',
				taxAmnt  = '".addslashes($taxAmnt)."',

				tax_auths  = '".addslashes($tax_auths)."',
				TaxRate  = '".addslashes($MainTaxRate)."',                                        
				       
				PostedDate  = '".$PostedDate."',
				UpdatedDate  = '".$Config['TodayDate']."',
				ReceivedDate  = '".$ReceivedDate."', 


				InvoicePaid  = '".$InvoicePaid."',
				InvoiceComment  = '".addslashes(strip_tags($InvoiceComment))."',
				PaymentMethod  = '".addslashes($PaymentMethod)."',
				ShippingMethod  = '".addslashes($ShippingMethod)."', 
				ShippingMethodVal ='".addslashes($ShippingMethodVal)."',

				PaymentTerm  = '".addslashes($PaymentTerm)."',
				AssignedEmpID  = '".addslashes($EmpID)."',
				AssignedEmp  = '".addslashes($EmpName)."',
				Taxable  = '".addslashes($Taxable)."',
				EntryType='".$EntryType."',
				EntryInterval='".$EntryInterval."',
				EntryMonth='".$EntryMonth."',    
				EntryFrom='".$EntryFrom."',

				EntryWeekly = '".$EntryWeekly."',    
				EntryTo='".$EntryTo."',
				EntryDate='".$EntryDate."',
				AccountID='".$AccountID."', CreditCardVendor='".$CreditVendor."',
				freightTxSet='".$freightTxSet."' where OrderID='".$OrderID."'  ";
                     
                  
                                $this->query($strSQLQuery, 0);

			  // if($OrderID==1229){pr($arryDetails) ;exit;}
                                   
			$objConfigure = new configure();			
			$objConfigure->EditUpdateAutoID('p_order','InvoiceID',$OrderID,$arryDetails["PoInvoiceID"]);


			return true;

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
                        
			//$strAddQuery .= ($InvoiceEntry==1)?(" and o.InvoiceEntry>0 "):(" and o.InvoiceEntry=0 ");	
			$strAddQuery .= (!empty($InvoiceEntry))?(" and o.InvoiceEntry>'0' "):("");	

			if($SearchKey=='paid' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
				$strAddQuery .= " and o.InvoicePaid='1'"; 
			}else if($SearchKey=='unpaid' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
				$strAddQuery .= " and o.InvoicePaid!='1' and o.InvoicePaid!='2'";
			}else if($SearchKey=='partially paid' && ($sortby=='o.InvoicePaid' || $sortby=='') ){
				$strAddQuery .= " and o.InvoicePaid='2' ";
			}else if($SearchKey != '' && $sortby == 'o.SuppCompany'){
				$strAddQuery .= " and (o.SuppCompany like '%".$SearchKey."%'  or s.UserName like '%".$SearchKey."%' or s.CompanyName like '%".$SearchKey."%' ) ";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.InvoiceID like '%".$SearchKey."%'  or o.PurchaseID like '%".$SearchKey."%'  or o.SuppCompany like '%".$SearchKey."%'   or s.UserName like '%".$SearchKey."%'   or s.CompanyName like '%".$SearchKey."%'  or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' or o.TrackingNo like '%".$SearchKey."%' ) " ):("");	
			}


			if($_SESSION['AdminType']=="employee"){			
				$strAddQuery .=  " and (o.SuppCode not in (select p.SuppCode from permission_vendor p where p.EmpID='".$_SESSION['AdminID']."')  OR o.AdminID='".$_SESSION['AdminID']."')";
			}

			
			
			if($Config['GetNumRecords']==1){
				$Columns = " count(distinct(o.OrderID)) as NumCount ";				
			}else{	
				$strAddQuery .= " group by o.OrderID ";

				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.PostToGL asc,o.PostedDate desc,o.OrderID desc");
			
				$Columns = "  distinct(o.OrderID),o.*, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName,  e.GlEntryType , if(o.AdminType='employee',em.UserName,'Administrator') as PostedBy, t.TransactionID ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			#$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID, o.InvoiceID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid,o.InvoiceEntry,o.ExpenseID from p_order o ".$strAddQuery;
		        
                        $strSQLQuery = "select ".$Columns." from p_order o left outer join p_supplier s on   o.SuppCode =  s.SuppCode left outer join f_expense e on o.ExpenseID=e.ExpenseID left outer join h_employee em on (o.AdminID=em.EmpID and o.AdminType='employee') left outer join f_transaction t on (o.OrderID = t.TransferOrderID and t.PaymentType='Purchase' and t.TransferOrderID > '0' and t.TransferSuppCode !='') ".$strAddQuery;
		
			return $this->query($strSQLQuery, 1);		
				
		}

		function  ListRecurringPoInvoice($arryDetails)
		{
			global $Config;
			extract($arryDetails);
 			 
			$strAddQuery = " where o.EntryType='recurring' and o.InvoiceID != '' and o.ReturnID = '' and o.Module='Invoice' ";
			$SearchKey   = strtolower(trim($key));

			if($_SESSION['vAllRecord']!=1){
			$strAddQuery .= " and (o.AssignedEmpID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') ";				
			}
					
			$strAddQuery .= (!empty($EntryInterval))?(" and o.EntryInterval='".$EntryInterval."'"):("");
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			
			$strAddQuery .= (!empty($FromDateInv))?(" and o.PostedDate>='".$FromDateInv."'"):("");
			$strAddQuery .= (!empty($ToDateInv))?(" and o.PostedDate<='".$ToDateInv."'"):("");

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
			
			 
			$todate = explode(" ", $Config['TodayDate']);
			if($status == 'Active'){				
				$strAddQuery .=  " and (year(o.EntryTo) = '0' or  o.EntryTo >= '".$todate[0]."') ";
			}else{				 
				$strAddQuery .=  " and (o.EntryTo < '".$todate[0]."' and year(o.EntryTo) > '0' ) ";
			} 

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by p.CompanyName asc, o.SuppCompany asc, o.PostedDate desc,o.OrderID desc");
			 

			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";				
			}else{		
				$Columns = "  o.OrderID, o.InvoiceID, o.PurchaseID, o.SuppCode, o.TotalAmount, o.Currency, o.PostedDate, o.InvoiceEntry, o.ConversionRate, o.EntryType, o.PostToGLDate, o.PostToGL, o.EntryInterval, o.EntryDate, o.EntryMonth, o.EntryWeekly, o.EntryFrom, o.EntryTo, o.SuppCompany, p.CompanyName, o.RecurringAmount, IF(p.SuppType = 'Individual' and p.UserName!='', p.UserName, p.CompanyName) as VendorName  ";
		
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			$strSQLQuery = "select ".$Columns."  from p_order o left outer join p_supplier p on o.SuppCode= p.SuppCode ".$strAddQuery;
		
		  	//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		
				
		}


	function RemovePurchaseRecurring($OrderID){	
		$EntryType = 'one_time';
		$strSQL = "update p_order set EntryType ='".$EntryType."' where OrderID='".$OrderID."'"; 

		$this->query($strSQL, 0);

		return true;

	}

	function UpdatePurchaseRecurring($arryDetails){	
		extract($arryDetails);

		$strAdd='';

		if(isset($RecurringAmount)){
			$strAdd .= " ,RecurringAmount='".$RecurringAmount."' ";
		}

		 $strSQL = "update p_order set EntryType='".$EntryType."',  EntryInterval='".$EntryInterval."',  EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."' ".$strAdd."  where OrderID='".$OrderID."'"; 
		$this->query($strSQL, 0);

		return true;

	}

/****************** Bhoodev *******************************/
function  ListReceipt($arryDetails)
		{
			global $Config;
			extract($arryDetails);

			$strAddQuery = "where o.Module='Receipt' ";
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
                        
			//$strAddQuery .= ($ReceiptEntry==1)?(" and o.ReceiptEntry>0 "):(" and o.ReceiptEntry=0 ");	

 
			if($SearchKey != '' && $sortby == 'o.SuppCompany'){
				$strAddQuery .= " and (o.SuppCompany like '%".$SearchKey."%'  or s.UserName like '%".$SearchKey."%' or s.CompanyName like '%".$SearchKey."%' ) "; 
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.ReceiptID like '%".$SearchKey."%'  or o.PurchaseID like '%".$SearchKey."%'  or o.SuppCompany like '%".$SearchKey."%'  or s.UserName like '%".$SearchKey."%' or s.CompanyName like '%".$SearchKey."%'  or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' or o.ReceiptStatus like '%".$SearchKey."%' ) " ):("");	
			}


			if($_SESSION['AdminType']=="employee"){			
				$strAddQuery .=  " and (o.SuppCode not in (select p.SuppCode from permission_vendor p where p.EmpID='".$_SESSION['AdminID']."')  OR o.AdminID='".$_SESSION['AdminID']."')";
			}

			 
			
			if(!empty($Config['GetNumRecords']) || $Config['GetNumRecords']==1){
				$Columns = " count(distinct(o.OrderID)) as NumCount ";				
			}else{	
				$strAddQuery .=  " group by o.OrderID "; 

				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.ReceivedDate desc, OrderID desc ");
			
				$Columns = "  o.* , if(o.AdminType='employee',em.UserName,'Administrator') as PostedBy, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName  ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			#$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID, o.InvoiceID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid,o.InvoiceEntry,o.ExpenseID from p_order o ".$strAddQuery;
		        
                           $strSQLQuery = "select ".$Columns." from p_order o left outer join p_supplier s on  o.SuppCode =  s.SuppCode left outer join h_employee em on (o.AdminID=em.EmpID and o.AdminType='employee') ".$strAddQuery;
		
			return $this->query($strSQLQuery, 1);		
				
		}
/********************End ********************************/






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

/*************************Bhoodev****************/

function UpdateReceipt($arryDetails){ 
			global $Config;
			extract($arryDetails);
			if(!empty($OrderID)){

$sql = "Select ReceiptStatus from p_order where OrderID='".mysql_real_escape_string($OrderID)."'";

$rs = $this->query($sql, 1);

if($rs[0]['ReceiptStatus'] =='Completed'){  $ReceiptStatus  ='Completed';} else { $ReceiptStatus = $ReceiptStatus;}
$strSQLQuery = "update p_order set ReceivedDate='".$ReceivedDate."', GenrateInvoice='".$GenrateInvoice."',RefInvoiceID='".$RefInvoiceID."', ReceiptStatus='".$ReceiptStatus."', InvoiceComment='".addslashes(strip_tags($InvoiceComment))."', UpdatedDate = '".$Config['TodayDate']."'
				where OrderID='".mysql_real_escape_string($OrderID)."'"; 


				//$strSQLQuery = "update p_order set ReceivedDate='".$ReceivedDate."', PaymentDate='".$PaymentDate."', InvoicePaid='".$InvoicePaid."', InvPaymentMethod='".$InvPaymentMethod."', PaymentRef='".addslashes($PaymentRef)."', InvoiceComment='".addslashes(strip_tags($InvoiceComment))."', UpdatedDate = '".$Config['TodayDate']."'
				//where OrderID='".mysql_real_escape_string($OrderID)."'"; 
				$this->query($strSQLQuery, 0);



			}

			return 1;
		}
/***********END ***************************/

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
						$sql = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_returned, price, tax_id, tax, amount, Taxable,`Condition`,WID) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_returned."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."','".$arryItem[$Count]["Condition"]."','".$arryItem[$Count]['WID']."')";

						$this->query($sql, 0);	

     
/*********Implemented on Post to Gl*******
                                                        
                                                        
	    $UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand-" .$qty_returned . "  where Sku='" .$arryItem[$Count]["sku"]. "' and ItemID ='".$arryItem[$Count]["item_id"]."'";
		    $this->query($UpdateQtysql, 0);
                                               
*******************/       


					}
				}
			}

			return $order_id;
		}


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


		function  ListCreditNote($arryDetails)
		{
			extract($arryDetails);
			global $Config;
			$strAddQuery = " where o.Module='Credit' and OverPaid='0' ";
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

			
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			if(!empty($Status)){
				$strAddQuery .= " and o.Status='".$Status."'";
				$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			}

			$strAddQuery .= (!empty($sortby) & !empty($asc))?(" order by ".$sortby." ".$asc):(" order by o.PostToGL asc,o.PostedDate desc,OrderID desc");
			//$strAddQuery .= (!empty($asc))?($asc):("");

			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";				
			}else{				
				$Columns = "  o.*, if(o.AdminType='employee',e.UserName,'Administrator') as PostedBy ,  IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName  ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}



			#$strSQLQuery = "select o.ClosedDate, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.CreditID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency  from p_order o ".$strAddQuery;
		        $strSQLQuery = "select ".$Columns." from p_order o left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType='employee')  left outer join p_supplier s on  (o.SuppCode =  s.SuppCode and o.SuppCode!='')  ".$strAddQuery;
		
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

			$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName  from p_order o left outer join p_supplier s on   o.SuppCode = s.SuppCode where o.Module='Order' ".$strAddQuery." order by o.OrderDate desc";
				
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
			$TotalQtyLeft=0;
			for($i=0;$i<sizeof($arryItem);$i++){
				$total_received = $this->GetQtyReceived($arryItem[$i]["id"]);
				$ordered_qty = $arryItem[$i]["qty"];
				
				$TotalQtyLeft += ($ordered_qty - $total_received);
			}

			return $TotalQtyLeft;		
		}

function  GetTotalRcieveQtyLeft($OrderID)
		{
			$strSQLQuery = "select i.id,i.qty from p_order_item i inner join p_order o on i.OrderID=o.OrderID where o.OrderID='".$OrderID."' and o.Module='Order' order by i.id asc";
			$arryItem = $this->query($strSQLQuery, 1);
			$TotalQtyLeft=0;
			for($i=0;$i<sizeof($arryItem);$i++){
				$total_received = $this->GetQtyTotalReceived($arryItem[$i]["id"],$OrderID);
				$ordered_qty = $arryItem[$i]["qty"];
				
				$TotalQtyLeft += ($ordered_qty - $total_received);
			}

			return $TotalQtyLeft;		
		}

		function  InvoiceReport($FromDate,$ToDate,$SuppCode,$InvoicePaid)
		{
			global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and o.PostedDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.PostedDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			$strAddQuery .= (!empty($Config['PostToGL']))?(" and o.PostToGL='".$Config['PostToGL']."'"):("");
			if($InvoicePaid=='0'){
				$strAddQuery .= " and o.InvoicePaid='0' ";
			}else if($InvoicePaid=='1'){
				$strAddQuery .= " and o.InvoicePaid in ('1','2') ";
			}
			


			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";				
			}else{	
				$strAddQuery .= " order by o.PostedDate desc ";			
				$Columns = "  o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.InvoiceID, o.PurchaseID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.InvoicePaid,o.Currency,o.InvoiceEntry,o.ExpenseID, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName   ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}
			 $strSQLQuery = "select ".$Columns." from p_order o left outer join p_supplier s on   o.SuppCode =   s.SuppCode where o.Module='Invoice' ".$strAddQuery;
				
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
				$strAddQuery .= " and o.InvoicePaid='0' ";
			}else if($InvoicePaid=='1'){
				$strAddQuery .= " and o.InvoicePaid in ('1','2') ";
			}

			$strSQLQuery = "select count(o.OrderID) as TotalInvoice  from p_order o where o.Module='Invoice' and YEAR(o.PostedDate)='".$Year."' ".$strAddQuery." order by o.PostedDate desc";
				

			return $this->query($strSQLQuery, 1);		
		}

		function RemovePOItem($OrderID){		

			$strSQLQuery = "delete from p_order_item where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			return 1;

		}

		function RemovePurchase($OrderID){
			global $Config;
			$objFunction=new functions();
			$objConfig=new admin();	
			if(!empty($OrderID)){
					$strSQLQuery = "select Module,PurchaseID,QuoteID,CreditID,EDICompName,EDIRefNo,TotalAmount,SuppCode,SuppCompany,OrderDate from p_order where OrderID='".$OrderID."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
				
					if($arryRow[0]['EDICompName']!=''){
				      $EDIRefNo = explode("/",$arryRow[0]['EDIRefNo']);
				      $db = 'erp_'.$arryRow[0]['EDICompName'].'.';
				      $strSQLQuery = "select OrderID,SaleID,Module,PickID,OrderDate,CustCode,CustID,TotalAmount,CustomerName from ".$db."s_order where SaleID='".$EDIRefNo[4]."' and Module='Order'"; 
				      $arrysaleRow = $this->query($strSQLQuery, 1);
				      
				      if(!empty($arrysaleRow[0]['PickID']) && $arrysaleRow[0]['PickID']!=''){
				      
				         return $arrysaleRow[0]['OrderID'].".".$arryRow[0]['EDICompName'];
				      
				      }else{
				      
				       $strPoQuery = "insert into edi_request(PurchaseID, Amount, ReqDate, SalesID,AdminType,AdminID,Type,SuppCompany,SuppCode,DeleteDate) values('".$arryRow[0]['PurchaseID']."', '".$arryRow[0]["TotalAmount"]."' , '".$arryRow[0]["OrderDate"]."', '','".$_SESSION['AdminType']."','".$_SESSION['AdminID']."','PO', '".mysql_real_escape_string($arryRow[0]["SuppCompany"])."', '".mysql_real_escape_string($arryRow[0]["SuppCode"])."','".$Config['TodayDate']."')";
				      $this->query($strPoQuery, 0);
				       
					           
				           
				         if(!empty($arrysaleRow[0]['OrderID'])){
				            $strSoQuery = "insert into ".$db."edi_request(Amount, ReqDate, SalesID,AdminType,AdminID,Type,CustCode,CustID,DeleteDate,CustomerName) values('".$arrysaleRow[0]["TotalAmount"]."' , '".$arrysaleRow[0]["OrderDate"]."', '".$arrysaleRow[0]["SaleID"]."', '".$_SESSION['AdminType']."','".$_SESSION['AdminID']."','SO','".$arrysaleRow[0]["CustCode"]."','".$arrysaleRow[0]["CustID"]."','".$Config['TodayDate']."','".$arrysaleRow[0]["CustomerName"]."')";
				$this->query($strSoQuery, 0);
				$strDelSoQuery = "delete from ".$db."s_order 		where OrderID='".mysql_real_escape_string($arrysaleRow[0]['OrderID'])."'"; 
					           	$this->query($strDelSoQuery, 0);
					          
					          }
				           
				           
				      }
				
			
				}
				/******Delete PDF**********/
				$ModuleDepName = "Purchase";
				if($arryRow[0]['Module']=="Order"){
					$PurchaseIDCol = 'PurchaseID';					
					$PdfFolder = $Config['P_Order'];
				}else if($arryRow[0]['Module']=="Credit"){
					$PurchaseIDCol = 'CreditID';
					$ModuleDepName = "PurchaseCreditMemo";
					$PdfFolder = $Config['P_Credit'];
				}else{
					$PurchaseIDCol = 'QuoteID';
					$PdfFolder = $Config['P_Quote'];
				}	
				$PurchaseID = $arryRow[0][$PurchaseIDCol];		 
				$PdfFile = $ModuleDepName.'-'.$PurchaseID.'.pdf';
				$objFunction->DeleteFileStorage($PdfFolder,$PdfFile);		
				/**************************/

				$PdfTemplateArray = array('ModuleDepName' => $ModuleDepName,  'PdfDir' => $PdfFolder, 'TableName' => 'p_order', 'OrderID' => $OrderID, 'ModuleID' => $PurchaseIDCol);
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
				$sql = "select sum(i.qty_received) as QtyReceived from p_order_item i where i.ref_id='".$id."' group by i.ref_id";
				$rs = $this->query($sql);
				if(!empty($rs[0]['QtyReceived']))return $rs[0]['QtyReceived'];
			}
			
		}

function  GetQtyTotalReceived($id,$OrderID)
		{
			if($id>0){
				$sql = "select sum(i.qty_received) as QtyReceived from p_order_item i where i.ref_id='".$id."'  order by i.ref_id";
				$rs = $this->query($sql);
				if(!empty($rs[0]['QtyReceived']))return $rs[0]['QtyReceived'];
			}
			
		}

		function  GetQtyOrderded($id)
		{
			if($id>0){
				$sql = "select i.qty as QtyOrderded from p_order_item i where i.id='".$id."'";
				$rs = $this->query($sql);
				if(!empty($rs[0]['QtyOrderded']))return $rs[0]['QtyOrderded'];
			}
		}

		function  GetQtyReturned($id)
		{
			if($id>0){
				$sql = "select sum(i.qty_returned) as QtyReturned from p_order_item i where i.ref_id='".$id."' group by i.ref_id";
				$rs = $this->query($sql);
				if(!empty($rs[0]['QtyReturned'])) return $rs[0]['QtyReturned'];
			}
		}

		function ConvertToPo55555($OrderID,$PurchaseID)
		{
global $Config;
			if(empty($PurchaseID)){
				$PurchaseID = 'PO000'.$OrderID;
			}
			if(!empty($OrderID)){
				$sql="update p_order set Module='Order',PurchaseID='".$PurchaseID."',OrderDate ='".$Config['TodayDate']."' where OrderID='".mysql_real_escape_string($OrderID)."'";
				$this->query($sql,0);	
			}

			return true;
		}

		function ConvertToPo($OrderID,$PurchaseID)
		{
			global $Config;
			if(!empty($OrderID)){
				$objConfigure = new configure();
				$objFunction=new functions();
				$objConfig=new admin();
	
				if(empty($PurchaseID)){
					$PurchaseID = $objConfigure->GetNextModuleID('p_order','Order'); 				 
				} 
		
				$sql="update p_order set Module='Order', OrderDate ='".$Config['TodayDate']."' where OrderID='".mysql_real_escape_string($OrderID)."'";
				$this->query($sql,0);

				$objConfigure->EditUpdateAutoID('p_order','PurchaseID',$OrderID,$PurchaseID); 	

				/******Delete Quote PDF and Generate Order Pdf**********/ 
				$sqlc = "select QuoteID from p_order where OrderID = '".$OrderID."' ";
				$arryQT =  $this->query($sqlc, 1); 
				$PdfFile = "Purchase".'-'.$arryQT[0]['QuoteID'].'.pdf';
				$objFunction->DeleteFileStorage($Config['P_Quote'],$PdfFile);

				$PdfTemplateArray = array('ModuleDepName' => "Purchase",  'PdfDir' => $Config['P_Quote'], 'TableName' => 'p_order', 'OrderID' => $OrderID, 'ModuleID' => "QuoteID");
				$objConfig->DeleteAllPdfTemplate($PdfTemplateArray);

				/*******Generate PDF************/			
				$PdfArray['ModuleDepName'] = "Purchase";
				$PdfArray['Module'] = "Order";
				$PdfArray['ModuleID'] = "PurchaseID";
				$PdfArray['TableName'] =  "p_order";
				$PdfArray['OrderColumn'] =  "OrderID";
				$PdfArray['OrderID'] =  $OrderID;		 	
				$objConfigure->GeneratePDF($PdfArray);
				$PdfFile = 'Purchase-'.$PurchaseID.'.pdf';	
				$sqlo="UPDATE p_order SET PdfFile='".$PdfFile."' WHERE OrderID='".$OrderID."'";
				$this->query($sqlo,0);		
				/**************************/

				
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
		
		function isSaleExists($SaleID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" AND OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "SELECT OrderID from s_order where Module='Order' AND SaleID='".trim($SaleID)."'".$strSQLQuery;

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
			//echo $strSQLQuery;exit;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}

		function isReceiptIDExists($ReceiptID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "select OrderID from p_order where Module='Receipt' and ReceiptID='".trim($ReceiptID)."'".$strSQLQuery;
			//echo $strSQLQuery;exit;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}

		function GetInvoiceEntryVal($InvoiceID)
		{			
			$strSQLQuery = "select InvoiceEntry from p_order where Module='Invoice' and InvoiceID='".trim($InvoiceID)."'";	$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['InvoiceEntry'];
			
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
					$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID";  $TemplateID=61; 
				}else if($module=='Order'){
					$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; $TemplateID=62; 
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
				//$contents = file_get_contents($htmlPrefix."purchase_auth.htm");

				$objConfigure = new configure();						
				$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
               			$contents = $TemplateContent[0]['Content'];

				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[MODULE]",$module,$contents);
				$contents = str_replace("[ACTION]",$Action,$contents);
				$contents = str_replace("[MODULE_ID_TITLE]",$ModuleIDTitle,$contents);
				$contents = str_replace("[MODULE_ID]",$arryPurchase[0][$ModuleID],$contents);
				$contents = str_replace("[QUOTE_NUMBER]",$arryPurchase[0][$ModuleID],$contents);
				$contents = str_replace("[ORDER_NUMBER]",$arryPurchase[0][$ModuleID],$contents);
				$contents = str_replace("[ORDER_DATE]",$OrderDate,$contents);
				$contents = str_replace("[CREATED_BY]",$CreatedBy,$contents);
				$contents = str_replace("[ORDER_STATUS]",$arryPurchase[0]['Status'],$contents);
				$contents = str_replace("[ORDER_TYPE]",$arryPurchase[0]['OrderType'],$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CC)) $mail->AddAddress($CC);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." :: ".$TemplateContent[0]['subject'];
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $TemplateContent[0]['subject'].'<br>'.$contents; exit;
				if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
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
					$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID";  $TemplateID=63; 
				}else if($module=='Order'){
					$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID"; $TemplateID=64; 
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
				//$contents = file_get_contents($htmlPrefix."purchase_admin.htm");
				$objConfigure = new configure();						
				$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
               			$contents = $TemplateContent[0]['Content'];

				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[MODULE]",$module,$contents);
				$contents = str_replace("[MODULE_ID_TITLE]",$ModuleIDTitle,$contents);
				$contents = str_replace("[MODULE_ID]",$arryPurchase[0][$ModuleID],$contents);
				$contents = str_replace("[QUOTE_NUMBER]",$arryPurchase[0][$ModuleID],$contents);
				$contents = str_replace("[ORDER_NUMBER]",$arryPurchase[0][$ModuleID],$contents);
				$contents = str_replace("[ORDER_DATE]",$OrderDate,$contents);
				$contents = str_replace("[CREATED_BY]",$CreatedBy,$contents);
				$contents = str_replace("[APPROVED]",$Approved,$contents);
				$contents = str_replace("[ORDER_STATUS]",$arryPurchase[0]['Status'],$contents);
				$contents = str_replace("[ORDER_TYPE]",$arryPurchase[0]['OrderType'],$contents);
				$contents = str_replace("[COMMENT]",$Comment,$contents);
				$contents = str_replace("[DELIVERY_DATE]",$DeliveryDate,$contents);
				$contents = str_replace("[PAYMENT_TERM]",$PaymentTerm,$contents);
				$contents = str_replace("[PAYMENT_METHOD]",$PaymentMethod,$contents);
				$contents = str_replace("[SHIPPING_METHOD]",$ShippingMethod,$contents);
				$contents = str_replace("[ASSIGNED_EMP]",$AssignedEmp,$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." :: ".$TemplateContent[0]['subject'];
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $TemplateContent[0]['subject'].'<br>'.$contents; exit;
				if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
					$mail->Send();	
				}

			}

			return 1;
		}





		function sendAssignedEmail($OrderID, $AssignedEmpID)
		{
			
			//NOT IN USE
			global $Config;	


			if($OrderID>0){

				$arryPurchase = $this->GetPurchase($OrderID,'','');
				$module = $arryPurchase[0]['Module'];

				if($module=='Quote'){	
					$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID";   $TemplateID=65;
				}else if($module=='Order'){
					$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID";  $TemplateID=66;
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
					//$contents = file_get_contents($htmlPrefix."purchase_assigned.htm");
					$objConfigure = new configure();
					$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
                    			$contents = $TemplateContent[0]['Content'];
					$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
					$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

					$contents = str_replace("[MODULE]",$module,$contents);
					$contents = str_replace("[ACTION]",$Action,$contents);
					$contents = str_replace("[MODULE_ID_TITLE]",$ModuleIDTitle,$contents);
					$contents = str_replace("[MODULE_ID]",$arryPurchase[0][$ModuleID],$contents);
					$contents = str_replace("[QUOTE_NUMBER]",$arryPurchase[0][$ModuleID],$contents);
				    	$contents = str_replace("[ORDER_NUMBER]",$arryPurchase[0][$ModuleID],$contents);
					$contents = str_replace("[ORDER_DATE]",$OrderDate,$contents);
					$contents = str_replace("[CREATED_BY]",$CreatedBy,$contents);
					$contents = str_replace("[STATUS]",$arryPurchase[0]['Status'],$contents);
					$contents = str_replace("[ORDER_TYPE]",$arryPurchase[0]['OrderType'],$contents);
					$contents = str_replace("[USER_NAME]",$arryEmp[0]['UserName'],$contents);
						
					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($ToEmail);
					if(!empty($CC)) $mail->AddCC($CC);
					
					$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." :: ".$TemplateContent[0]['subject'];
					$mail->IsHTML(true);
					$mail->Body = $contents;  
					//echo $TemplateContent[0]['subject'].'<br>'.$contents; exit;
					if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
						$mail->Send();	 //NOT IN USE
					}
				}



			}

			return 1;
		}



		function sendInvPayEmail($OrderID)
		{
			//NOT IN USE
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
					$mail->Send();	 //NOT IN USE
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
					$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $TemplateID=67; 
				}else if($module=='Order'){
					$ModuleIDTitle = "PO Number"; $ModuleID = "PurchaseID";$TemplateID=68; 
				}else if($module=='Invoice'){
					$ModuleIDTitle = "Invoice ID"; $ModuleID = "InvoiceID";$TemplateID=70; 
				}else if($module=='Credit'){
					$ModuleIDTitle = "Credit Note ID"; $ModuleID = "CreditID"; $module = "Credit Memo";
					$TemplateID=69; 
				}else if($module=='RMA'){
					$ModuleIDTitle = "PO RMA Number"; $ModuleID = "PurchaseID";$TemplateID=78; 
				}			


				if($arryPurchase[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = stripslashes($arryPurchase[0]['CreatedBy']);
				}
				
				$OrderDate = ($arryPurchase[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['OrderDate']))):(NOT_SPECIFIED);
				$PostedDate = ($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED);
				$Approved = ($arryPurchase[0]['Approved'] == 1)?('Yes'):('No');

				$DeliveryDate = ($arryPurchase[0]['DeliveryDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['DeliveryDate']))):(NOT_SPECIFIED);

				$PaymentTerm = (!empty($arryPurchase[0]['PaymentTerm']))? (stripslashes($arryPurchase[0]['PaymentTerm'])): (NOT_SPECIFIED);
				$PaymentMethod = (!empty($arryPurchase[0]['PaymentMethod']))? (stripslashes($arryPurchase[0]['PaymentMethod'])): (NOT_SPECIFIED);
				$ShippingMethod = (!empty($arryPurchase[0]['ShippingMethod']))? (stripslashes($arryPurchase[0]['ShippingMethod'])): (NOT_SPECIFIED);
				$Message = (!empty($Message))? ($Message): (NOT_SPECIFIED);
				
				#$CreatedBy = ($arryPurchase[0]['AdminType'] == 'admin')? ('Administrator'): ($arryPurchase[0]['CreatedBy']);


				 if($arryPurchase[0]['InvoicePaid'] ==1){
					  $InvoiceStatus = 'Paid';  
				 }elseif($arryPurchase[0]['InvoicePaid'] == 2){
					  $InvoiceStatus = 'Partially Paid';   
				 }else{
					  $InvoiceStatus = 'Unpaid';  
				 }


				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				//$contents = file_get_contents($htmlPrefix."purchase_supp.htm");
				$objConfigure = new configure();

				

				$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);

			
                		$contents = $TemplateContent[0]['Content'];
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);

                 /**by sachin **/
				$mailsing=$Config['MailFooter'];
                if(!empty($footerSingnature)){
                  $mailsing=$footerSingnature;
                }
                /**by sachin **/


				$contents = str_replace("[FOOTER_MESSAGE]",$mailsing,$contents);
                

				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[MODULE]",$module,$contents);
				$contents = str_replace("[MODULE_ID_TITLE]",$ModuleIDTitle,$contents);
				$contents = str_replace("[MODULE_ID]",$arryPurchase[0][$ModuleID],$contents);
				$contents = str_replace("[QUOTE_NUMBER]",$arryPurchase[0][$ModuleID],$contents);
				//$contents = str_replace("[ORDER_NUMBER]",$arryPurchase[0][$ModuleID],$contents);
			if($module == 'RMA'){					;
					$contents = str_replace("[ORDER_NUMBER]",$arryPurchase[0]['ReturnID'],$contents);
				}else{
					$contents = str_replace("[ORDER_NUMBER]",$arryPurchase[0][$ModuleID],$contents);
					
				}		
				$contents = str_replace("[INVOICE_NUMBER]",$arryPurchase[0][$ModuleID],$contents);
				$contents = str_replace("[CREDIT_MEMO_NUMBER]",$arryPurchase[0][$ModuleID],$contents);
				$contents = str_replace("[ORDER_DATE]",$OrderDate,$contents);
				$contents = str_replace("[INVOICE_DATE]",$PostedDate,$contents);
				$contents = str_replace("[CREATED_BY]",$CreatedBy,$contents);
				$contents = str_replace("[APPROVED]",$Approved,$contents);
				$contents = str_replace("[ORDER_STATUS]",$arryPurchase[0]['Status'],$contents);
				$contents = str_replace("[INVOICE_STATUS]",$InvoiceStatus,$contents);
				$contents = str_replace("[ORDER_TYPE]",$arryPurchase[0]['OrderType'],$contents);
				$contents = str_replace("[MESSAGE]",$Message,$contents);
				$contents = str_replace("[DELIVERY_DATE]",$DeliveryDate,$contents);
				$contents = str_replace("[PAYMENT_TERM]",$PaymentTerm,$contents);
				$contents = str_replace("[PAYMENT_METHOD]",$PaymentMethod,$contents);
				$contents = str_replace("[SHIPPING_METHOD]",$ShippingMethod,$contents);
				if($module == 'RMA'){$TemplateContent[0]['subject']='Purchase RMA '.$arryPurchase[0]['ReturnID'];}
				$contents = str_replace("[VENDOR_NAME]",stripslashes($arryPurchase[0]['SuppCompany']),$contents);

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
                
                $senderEmail=$Config['AdminEmail'];
             if($_SESSION['AdminType']=='employee'){$senderEmail=$_SESSION['EmpEmail'];  }
                

				$mail->sender($Config['UserName'], $senderEmail);   
				$mail->Subject = $Config['SiteName']." :: ".$TemplateContent[0]['subject'];
				$mail->IsHTML(true);
				$mail->Body = $contents;
				//PR($mail);  die;

				

				if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
					$mail->Send();	
				}

				if($_GET['pk']==1){				 
					echo $ToEmail.'#'.$Config['AdminEmail'].'<br>'.$contents; exit;
				}
				/***********/
				$strSQL = "update p_order set MailSend ='1' where OrderID='" . $OrderID . "'";
				$this->query($strSQL, 0); 
				/***********/
				/**********************************/

				if($DefaultEmailConfig=='1') {
					$objImportEmail=new email();
					//echo $Attachment;die;
					if (!file_exists($output_dir)) {
						mkdir($output_dir, 0777);
					}
        
                                   	if(copy($Attachment,$output_dir.$ConvetFilename)) {
                                           chmod($output_dir.$ConvetFilename, 777);                                         
                                        }
                                        if(!empty($CCEmail)) {
                                            $CCEmaill=$CCEmail;
                                                    
                                        }
                                   $arrayForImportedEmail=array('OwnerEmailId'=>$_SESSION['AdminEmail'],'emaillistID'=>'','Subject'=>$Config['SiteName']." - Purchase ".$module." # ".$arryPurchase[0][$ModuleID],'EmailContent'=>$Message,'Recipient'=>$ToEmail,'Cc'=>$CCEmaill,'Bcc'=>'','FromEmail'=>$OwnerEmailId,'TotalRecipient'=>'','MailType'=>'Sent','Action'=>'SendFromPurchage','ActionMailId'=>'','AdminId'=>$_SESSION['AdminID'],'ImportedDate'=>$_SESSION['TodayDate'],'FromDD'=>$Config["AdminEmail"],'AdminType'=>$_SESSION['AdminType'],'CompID'=>$_SESSION['CmpID'],'From_Email'=>$Config["AdminEmail"],'To_Email'=>$ToEmail,'composedDate'=>'','OrgMailType'=>'Sent','FileName'=>$ConvetFilename);
                                   $objImportEmail->SaveSentEmailForVendorCustomer($arrayForImportedEmail);
                               }

				/**********************************/
 				


			}

			return 1;
		}

	
		function AlterSaleItem($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			$objSale = new sale();
			$arrySale = $objSale->GetSale('',$SaleID,'Order');	

$sqlSl = "select OrderID from s_order where SaleID ='".$SaleID."' and PostToGL!='1' "  ;
		$arrysqlSlOrderID = $this->query($sqlSl, 1);
$OrderIDs =array();
foreach ($arrysqlSlOrderID as $key=>$value){

$OrderIDs[]  = $value['OrderID'];
}

 $Order_IDs = implode(",",$OrderIDs);


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
			

//$strSQLup = "update s_order_item set DropshipCost ='".$arryDetails['price'.$i]."'where item_id =".$arryDetails['item_id'.$i]." and OrderID='".$arrySale[0]['OrderID']."' and DropshipCheck =1"; 

$strSQLup = "update s_order_item set DropshipCost ='".$arryDetails['price'.$i]."', DropshipUsed ='1' where item_id =".$arryDetails['item_id'.$i]." and OrderID IN(".$Order_IDs.") and DropshipCheck ='1'"; 

		$this->query($strSQLup, 0);
		$amount = (($arryDetails['price'.$i]+$arryDetails['DropshipCost'.$i])*$arryDetails['qty'.$i]) - ($arryItemID[0]['discount']*$arryDetails['qty'.$i]);	
		
		if($arrySale[0]['tax_auths']=='Yes' && $arryItemID[0]['Taxable']=='Yes'){
			$tax = ($amount*$TaxRate)/100;		
			$taxAmnt += $tax;
		}

		$arryDetails['amount'.$i] = $amount;	
		$TotalAmount += $amount;

		 }
		}

				
		//$objSale->AddUpdateItem($arrySale[0]['OrderID'], $arryDetails); 

		/*****************/
		/*$sql2 = "select sum(amount) as OtherAmount from s_order_item where DropshipCheck!='1' and OrderID='".$arrySale[0]['OrderID']."'";
		$arryOtherAmount = $this->query($sql2, 1);

		$TotalAmount += $arrySale[0]['Freight'] + $taxAmnt + $arryOtherAmount[0]['OtherAmount'];
		$strSQL = "update s_order set TotalAmount ='".$TotalAmount."',taxAmnt ='".$taxAmnt."' where OrderID='".$arrySale[0]['OrderID']."'"; 
		$this->query($strSQL, 0);*/

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

	/**************/
	$TodayDate = $arryDate[0];
	$Year = $arryDay[0];	
	$YearMonth = $arryDay[0].'-'.$arryDay[1];
	/**************/	

          #$strSQLQuery = "select o.OrderID from s_order o where o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."' and o.EntryTo>='".$arryDate[0]."' and o.EntryDate='".$arryDay[2]."' and CASE WHEN o.EntryInterval='yearly' THEN o.EntryMonth='".$Month."'  ELSE 1 END = 1 ";

	 $strSQLQuery = "select o.* from p_order o where o.InvoiceEntry = '1' and o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."' and CASE WHEN o.EntryTo>0 THEN  o.EntryTo>='".$arryDate[0]."' ELSE 1 END = 1 ";

          $arrySale = $this->myquery($strSQLQuery, 1);
	 
		//pr($arrySale);   exit;

	  foreach($arrySale as $value){

		/**************/
		$ModuleDate = $value['PostedDate'];
		$arryDt = explode("-", $ModuleDate);
		$YearOrder = $arryDt[0]; 
		$YearMonthOrder = $arryDt[0].'-'.$arryDt[1];
		/**************/

		$OrderFlag=0;
		 if($ModuleDate!=$TodayDate){ 
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
				if($value['EntryDate']==$Day && $YearMonthOrder!=$YearMonth){
					$OrderFlag=1;
				}
				break;
			case 'yearly':
				if($value['EntryDate']==$Day && $value['EntryMonth']==$Month && $YearOrder!=$Year){
					$OrderFlag=1;
				}
				break;		
		
		}
		}

		//echo $value['InvoiceID'].'<br>'.$OrderFlag;exit;


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


                                    $sql = "insert into p_order_item(OrderID, item_id, sku, description, on_hand_qty, qty,qty_received, price, tax_id, tax, amount, Taxable,DropshipCheck,DropshipCost,WID) values('".$order_id."', '".$values['item_id']."', '".addslashes($values['sku'])."', '".addslashes($values['description'])."', '".addslashes($values['on_hand_qty'])."', '".addslashes($values['qty'])."','".addslashes($values['qty'])."', '".addslashes($values['price'])."', '".addslashes($values['tax_id'])."', '".addslashes($values['tax'])."', '".addslashes($values['amount'])."','".addslashes($values['Taxable'])."','1','".addslashes($values['DropshipCost'])."','".$values['WID']."')";

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
			
					if(!empty($_GET['Module'])){
						$modulep=$_GET['Module'];
					 $strAddQuery = "where o.Module='".$modulep."' and o.InvoiceID !=''";
					}else{
						$strAddQuery = "where o.Module = 'Return' and o.InvoiceID !=''";
						//$strAddQuery = "where o.Module IN ('Return','Credit')";
					}
					
				
					//$strAddQuery = mysql_real_escape_string($_POST['Module']); 
					
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
						$strAddQuery .= (!empty($SearchKey))?(" and (o.InvoiceID like '%".$SearchKey."%'   or o.ReturnID like '%".$SearchKey."%'  or o.PurchaseID like '%".$SearchKey."%'  or o.SuppCompany like '%".$SearchKey."%'  or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' ) " ):("");	
					}
					
					//$strAddQuery .= " and o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.Status='Completed' ";
		
					$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
					
					$strAddQuery .= (!empty($asc))?($asc):(" desc");
		
					$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID,o.ReturnID,o.InvoiceID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid, o.Module from  p_order o ".$strAddQuery;
				
				   //echo $strSQLQuery;
					
					return $this->query($strSQLQuery, 1);		
						
				}
		
		/*****************************************************/
		
		
function ReturnOrderRma($arryDetails)	{
			global $Config;
			extract($arryDetails);

			if(!empty($ReturnOrderID)){
				$arryPurchase = $this->GetPurchase($ReturnOrderID,'','');
				//print_r($arryPurchase);exit;
				$arryPurchase[0]["Module"] = $Module;
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
						$sql = "insert into p_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_returned, price, tax_id, tax, amount, Taxable,`Condition`, PurchaseComment, WID) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryItem[$Count]["ref_id"]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_returned."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."','".$arryItem[$Count]["Condition"]."','".$arryItem[$Count]["PurchaseComment"]."','".$arryItem[$Count]["WID"]."')";

						$this->query($sql, 0);	

     
/*********Implemented on Post to Gl*******
                                                        
                                                        
	    $UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand-" .$qty_returned . "  where Sku='" .$arryItem[$Count]["sku"]. "' and ItemID ='".$arryItem[$Count]["item_id"]."'";
		    $this->query($UpdateQtysql, 0);
                                               
******************/         


					}
				}
			}

			return $order_id;
		}
			
		
		
	    function  GetPurchaserma($OrderID,$PurchaseID,$Module)
		{

			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".mysql_real_escape_string($OrderID)."'"):("");
			$strAddQuery .= (!empty($PurchaseID))?(" and o.PurchaseID='".mysql_real_escape_string($PurchaseID)."'"):("");
			$strAddQuery .= (empty($Module))?(" and o.Module IN ('Return','Credit')"):("");
			$strSQLQuery = "select o.* from p_order o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
			
		}		

		
				function  ListVendorS()
		{
          $strSQLQuery = "select SuppCompany from p_order where 1 and Module='Order' and Approved='1' order by SuppCompany ASC";
          #echo $strSQLQuery;exit;
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

		if(!empty($SuppCompany)){
				$strAddQuery = " where o.SuppCompany='".$SuppCompany."'";
			}else{
				$strAddQuery = " where 1";
			}
			
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
				$strAddQuery .= (!empty($SearchKey))?(" and (o.OrderType like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' or o.SuppCompany like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.Currency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' or vo.sku like '%".$SearchKey."%') "):("");	
			 
			}

			if($Status=='Open'){
				$strAddQuery .= " and o.Approved='1' and o.Status!='Completed' ";
			}else{
				$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			}

			if($ToApprove=='1'){
				$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
			}



			if($_SESSION['AdminType']=="employee"){			
				$strAddQuery .=  " and (o.SuppCode not in (select  p.SuppCode from permission_vendor p where p.EmpID='".$_SESSION['AdminID']."')  OR o.AdminID='".$_SESSION['AdminID']."')";
			}



			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.OrderDate desc,o.OrderID desc");
			$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");

                       
			  #$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID,  o.SaleID,o.SuppCode, o.SuppCompany, o.TotalAmount, o.Status,o.Approved,o.Currency  from p_order o ".$strAddQuery;
		        
                $strSQLQuery = "select Distinct o.*  from p_order o left join p_order_item vo ON o.OrderID = vo.OrderID ".$strAddQuery;
                // echo $strSQLQuery;
		
			return $this->query($strSQLQuery, 1);		
				
		}	
		
		/*******/
		function  GetPurchaseInvoice($OrderID,$InvoiceID,$Module)
		{
            
			$strAddQuery = (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID='".$InvoiceID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from p_order o where 1".$strAddQuery." order by o.OrderID desc";
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);
			
		}
		/**/	
		
		/**********************************************/
		function UpdateReturnRma($arryDetails){ 
					global $Config;
					extract($arryDetails);
					if(!empty($OrderID)){
						$strSQLQuery = "update p_order set ReceivedDate='".$ReceivedDate."',Module='".$Module."', PaymentDate='".$PaymentDate."', InvoicePaid='".$InvoicePaid."', InvPaymentMethod='".$InvPaymentMethod."', PaymentRef='".addslashes($PaymentRef)."', InvoiceComment='".addslashes(strip_tags($InvoiceComment))."', UpdatedDate = '".$Config['TodayDate']."'
						where OrderID='".mysql_real_escape_string($OrderID)."'"; 
						$this->query($strSQLQuery, 0);
					}
		
					return 1;
				}
		/***************************************/
				
				function  ListCreditNoteRMA($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = " where o.Module='Credit' and o.InvoiceID !=''";
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
                         $strSQLQuery = "select i.*,t.RateDescription,c.valuationType as evaluationType from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on i.item_id=itm.ItemID left outer join inv_categories c on c.CategoryID =itm.CategoryID where 1".$strAddQuery." order by i.id asc";



			//echo $strSQLQuery;
                         return $this->query($strSQLQuery, 1);
		}

		 /*start function by sachin*/
                function GetPurchageContactId($code){
                    if(!empty($code)){
                    $sql="select SuppID from p_supplier where SuppCode='".$code."'";
                    //echo $sql;die;
                    return $this->query($sql, 1);
                    }
                }
                
                function GetPurchageContactInformation($code){
                     if(!empty($code)){
                        $sql="SELECT * FROM `p_address_book` WHERE `SuppID` = '".$code."' && `AddType`='contact' && PoDelivery='1'";
                        return $this->query($sql, 1);
                     }
                    
                }
                
                function GetVenderCreditContactInformation($code){
                     if(!empty($code)){
                        $sql="SELECT * FROM `p_address_book` WHERE `SuppID` = '".$code."' && `AddType`='contact' &&  CreditDelivery='1'";
                        return $this->query($sql, 1);
                     }
                    
                }

		 function GetVenderContactInformationInv($code){
                     if(!empty($code)){
                        $sql="SELECT * FROM `p_address_book` WHERE `SuppID` = '".$code."' && `AddType`='contact' &&  InvoiceDelivery='1'";
                        return $this->query($sql, 1);
                     }
                    
                }
                
                 function GetVenderPaymentHistoryInformation($code){
                     if(!empty($code)){
                        $sql="SELECT * FROM `p_address_book` WHERE `SuppID` = '".$code."' && `AddType`='contact' &&  PaymentInfo='1'";
                        return $this->query($sql, 1);
                     }
                    
                }
                /*End function by sachin */

		/*********Next Prevoius by Chetan 13Apr ***********/
	function NextPrevRow($OrderID,$Next,$module) {
		global $Config;
		if($OrderID>0){			 
			$strAddQuery = '';
			$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.AssignedEmpID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):(""); 
		
			if($Next==1){
				$operator = "<"; $asc = 'desc';
			}else{
				$operator = ">"; $asc = 'asc';
			}

			$strSQLQuery = "select o.OrderID  from p_order o where o.OrderID ".$operator."'" . $OrderID . "' and o.Module= '".$module."' ". $strAddQuery. " order by o.OrderID ".$asc." limit 0,1";
			$arrRow = $this->query($strSQLQuery, 1);
			return $arrRow;
		}
	}

function GetRceiptStatus($PurchaseID){
	$strSQLQuery = "select o.ReceiptStatus as RecStatus,OrderID as RID  from p_order o where o.Module ='Receipt' and o.PurchaseID ='".$PurchaseID."'";
return $arrRow = $this->query($strSQLQuery, 1);



}

    function GetSerialNumberByID($id,$Sku,$adjustment_no,$disassembly,$Condition) {

        extract($arryDetails);

        $strAddQuery .= (!empty($id)) ? (" where s.serialID='" . $id."'") : (" where 1 and UsedSerial =0 ");
        $strAddQuery .= (!empty($selectIDs)) ? (" and s.serialID in ('" . $selectIDs . "')") : (" ");
        $strAddQuery .= (!empty($adjustment_no))?(" and s.adjustment_no='".$adjustment_no."'"):(" ");
        $strAddQuery .= (!empty($disassembly))?(" and s.disassembly='".$disassembly."'"):(" ");
 $strAddQuery .= (!empty($Condition))?(" and s.`Condition`='".$Condition."'"):(" ");
        $strAddQuery .= (!empty($Sku)) ? (" and s.Sku='" . $Sku . "'") : (" ");
        $strAddQuery .= " order by s.Sku Desc";
        

         $strSQLQuery = "SELECT s.*, w.warehouse_name ,w.warehouse_code  FROM inv_serial_item s left outer join w_warehouse w on s.warehouse = w.WID " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }
	function UpdateUploadDocuments($document,$OrderID){
		if(!empty($OrderID) && !empty($document)){
			    $strSQLQuery = "update p_order set UploadDocuments='".$document."' where OrderID='".$OrderID."'";
				return $this->query($strSQLQuery, 0);
		}
	}
	function poCloseStatusUpdate($orderId)	
  	{
		  
		$strSQLQuery = "update p_order set close_status ='1' where OrderID='".$orderId."' LIMIT 1";
		$result =  $this->query($strSQLQuery, 1);
		if(mysql_affected_rows() > 0){
			return 1;		
   		 }	
	}


	function CreateCloneOrder($order_id,$Module){    
		global $Config;
		$IPAddress = GetIPAddress();
		/*****************/
		if($order_id>0){
			$arryPurchaseItem = $this->GetPurchaseItem($order_id);
			/*****************/ 	
			$ArrayFieldName = $this->GetFieldName('p_order');
			foreach($ArrayFieldName as $key=>$values){
				if($values['Key'] != 'PRI' && $values['Field']!='AutoID'){
					$FeildAndValuesArray[] = "`".$values['Field']."`";
				} 	 
			}
			$FeildAndValues = implode(", ",$FeildAndValuesArray);
			/*****************/ 		
			$strSQLQuery = "insert into p_order (".$FeildAndValues.") select ".$FeildAndValues."  FROM p_order
			where OrderID = '".$order_id."'";	
			$this->query($strSQLQuery, 0);			
			$OrderID = $this->lastInsertId();
			if($OrderID>0){
				if($Module=="Invoice"){
					$strAdd = " ";
				}else{
					$strAdd = " , Status='Draft' ,OrderDate ='" .$Config['TodayDate']."' ";
				}  		
			    	$strSQL = "update p_order set  PurchaseID = '', QuoteID = '',CreditID='', InvoiceID='', ReturnID='', SaleID='' , RecurringAmount='' , ReceiptID='', EntryType = 'one_time', ClosedDate = '', LastRecurringEntry ='', DeliveryDate='', PostedDate='".$Config['TodayDate']."', CreatedDate='".$Config['TodayDate']."', UpdatedDate='".$Config['TodayDate']."',  InvoicePaid='0', PostToGL='0', PostToGLDate='', ReceivedDate='', IPAddress='".$IPAddress."', Parent='".$order_id."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PdfFile='' ".$strAdd." where OrderID='" .$OrderID. "'";	
				$this->query($strSQL, 0); 
				$objConfigure = new configure();
				$objConfigure->UpdateModuleAutoID('p_order',$Module,$OrderID,'');			
				/*****************/
				$ArrayFieldName2 = $this->GetFieldName('p_order_item');	
				foreach($ArrayFieldName2 as $key=>$values){
					if($values['Key'] != 'PRI' && $values['Field']!='OrderID'){
						$FeildAndValuesArray2[] = "`".$values['Field']."`";
					} 	 
				}
				$FeildAndValues2 = implode(", ",$FeildAndValuesArray2);
				/*****************/ 				
				foreach($arryPurchaseItem as $key=>$values){
					 $strSQLQuery = "insert into p_order_item (".$FeildAndValues2.") SELECT ".$FeildAndValues2." FROM p_order_item WHERE OrderID = '".$order_id."' and id = '".$values['id']."'";
					$this->query($strSQLQuery, 0);
					$id = $this->lastInsertId();
					if(!empty($id)){

						if($Module=="Invoice"){
							$stqty = " ,qty ='' ";
						}else{
							$stqty = " , qty_received='' ";
						}
					
					
						$strSQL = "update p_order_item set OrderID ='" .$OrderID."',qty_returned='', SaleQty='' ".$stqty."  where id='" .$id. "'";
						$this->query($strSQL, 0);
					}
				}
				/*****************/					
				$arrySale = $this->GetPurchase($OrderID,'','');
				if($Module=='Quote'){	
					$ModuleID = "QuoteID"; 
				}else if($Module=='Order'){
					$ModuleID = "PurchaseID";
				}else if($Module=='Credit'){
					$ModuleID = "CreditID"; 					
				}else if($Module=='Invoice'){
					$ModuleID = "InvoiceID"; 					
				}
				/*****************/	

				return $arrySale[0][$ModuleID];
			}
		}
		
	 }


	function CreateCloneGlInvoice($order_id,$Module){    
		global $Config;
		$IPAddress = GetIPAddress();
		/*****************/
		if($order_id>0){
			if($Module=="Invoice"){
				$arryOrder = $this->GetPurchase($order_id,'','');
				$InvoiceEntry = $arryOrder[0]['InvoiceEntry'];
				$expense_id = $arryOrder[0]['ExpenseID'];
			}
			//pr($arryOrder);exit; 			
			/*****************/ 	
			$ArrayFieldName = $this->GetFieldName('p_order');
			foreach($ArrayFieldName as $key=>$values){
				if($values['Key'] != 'PRI' && $values['Field']!='AutoID'){
					$FeildAndValuesArray[] = "`".$values['Field']."`";
				} 	 
			}
			$FeildAndValues = implode(", ",$FeildAndValuesArray);
			/*****************/ 		
			$strSQLQuery = "insert into p_order (".$FeildAndValues.") select ".$FeildAndValues."  FROM p_order
			where OrderID = '".$order_id."'";	
			$this->query($strSQLQuery, 0);			
			$OrderID = $this->lastInsertId();
			if($OrderID>0 && $expense_id>0){					
				if($InvoiceEntry==2 || $InvoiceEntry==3){ 
					/*****************/
					$ArrayFieldName3 = $this->GetFieldName('f_expense');
					foreach($ArrayFieldName3 as $key=>$values){
						if($values['Key'] != 'PRI'){ 
							$FeildAndValuesArray3[] = "`".$values['Field']."`";
						} 	 
					}
					$FeildAndValues3 = implode(", ",$FeildAndValuesArray3);
					/*****************/
					$strSQLExpense = "insert into f_expense (".$FeildAndValues3.") select ".$FeildAndValues3."  FROM f_expense where ExpenseID = '".$expense_id."'";		
					$this->query($strSQLExpense, 0);			
					$ExpenseID = $this->lastInsertId();
					$strAdd = " ,ExpenseID='".$ExpenseID."' ";
				
					/*****************/
					$strSQL = "update p_order set   QuoteID = '',CreditID='', InvoiceID='', ReturnID='', SaleID='', ReceiptID='', RecurringAmount='', EntryType = 'one_time', ClosedDate = '', LastRecurringEntry ='', DeliveryDate='', PostedDate='".$Config['TodayDate']."', CreatedDate='".$Config['TodayDate']."' , UpdatedDate='".$Config['TodayDate']."', InvoicePaid='0', PostToGL='0', PostToGLDate='', ReceivedDate='', IPAddress='".$IPAddress."', Parent='".$order_id."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PdfFile='' ".$strAdd." where OrderID='" .$OrderID. "'";	
					$this->query($strSQL, 0); 
					$objConfigure = new configure();
					$objConfigure->UpdateModuleAutoID('p_order',$Module,$OrderID,'');			
					/*****************/
					$arryPurchase = $this->GetPurchase($OrderID,'','');	
					$InvoiceID = $arryPurchase[0]["InvoiceID"];
					/*****************/
					$strSQL = "update f_expense set  OrderID='".$OrderID."', InvoiceID='".$InvoiceID."', PaymentDate ='" .$Config['TodayDate']."'  where ExpenseID='" .$ExpenseID. "'";	
					$this->query($strSQL, 0);
 
					$strSQLInc = "select GlEntryType  from f_expense  where ExpenseID = '".$ExpenseID."'";
		        		$arryExpense=$this->query($strSQLInc,1);					 
					if($arryExpense[0]['GlEntryType'] == "Multiple"){
						/*****************/	
						$ArrayFieldName4 = $this->GetFieldName('f_multi_account_payment');
						foreach($ArrayFieldName4 as $key=>$values){
							if($values['Key'] != 'PRI'){ 
								$FeildAndValuesArray4[] = "`".$values['Field']."`";
							} 	 
						}
						$FeildAndValues4 = implode(", ",$FeildAndValuesArray4);	
						/*****************/
						$sqlM = "select * FROM f_multi_account_payment where ExpenseID = '".$expense_id."'";
						$arryMultiple = $this->query($sqlM, 1);
						/*****************/ 				
						foreach($arryMultiple as $key=>$values){
							 $strSQLQuery = "insert into f_multi_account_payment (".$FeildAndValues4.") SELECT ".$FeildAndValues4." FROM f_multi_account_payment WHERE ExpenseID = '".$expense_id."' and ID = '".$values['ID']."'";
							$this->query($strSQLQuery, 0);
							$ID = $this->lastInsertId();
							if(!empty($ID)){					
								$strSQL = "update f_multi_account_payment set ExpenseID ='" .$ExpenseID."'  where ID='" .$ID. "'";
								$this->query($strSQL, 0);
							}
						}
						/*****************/	
 
					}
					/*****************/

				}
				return $InvoiceID;
			}
		}
		
	 }
function ReceivePurchaseQtyOrder($OrderID){

global $Config;
		$arryPurchase = $this->GetPurchase($OrderID,'','');
		$Currency = $arryPurchase[0]["Currency"];
		if(empty($Currency)) $Currency =  $Config['Currency'];

                       
			if($Currency != $Config['Currency']){  		
				$ConversionRate = CurrencyConvertor(1,$Currency,$Config['Currency'],'AP',$PostedDate);
				//$NetPrice = round(GetConvertedAmount($ConversionRate, $ItemCost),2);
			}else{   
				$ConversionRate=1;
			}
          
                               
				/******** Item Updation for Invoice ************/
				$arryItem = $this->GetPurchaseItem($OrderID);

				$NumLine = sizeof($arryItem);

        $totalTaxAmnt = 0;$taxAmnt=0;
				for($i=1;$i<=$NumLine;$i++){
					$Count=$i-1;
					
					if(($arryItem[$Count]["qty_received"]>0 && !empty($arryItem[$Count]["qty_received"])) && $arryPurchase[0]['OrderType']!='Dropship'){
						$qty_received = $arryItem[$Count]["qty_received"];
            $mainSku = $this->CheckMainSkuItem($arryItem[$Count]["sku"]);

						/********************By bhoodev 11jan2017*****************************/
						$tot_freight_cost = $arryItem[$Count]["freight_cost"]/$qty_received;
						$NetAngCostSr = $arryItem[$Count]["price"]+$tot_freight_cost;
						$NetPriceSr = round(GetConvertedAmount($ConversionRate, $NetAngCostSr),2);
						$FinalPrice = $arryItem[$Count]["price"] + ($arryItem[$Count]["freight_cost"]/$arryItem[$Count]["qty"]);
						/*************************************************/

				if($arryItem[$Count]["Condition"]!=''){
						 $sql="select count(*) as total,ID from ".$DBName."inv_item_quanity_condition where 
						Sku='" . addslashes($mainSku) . "' and 
						ItemID='" . addslashes($arryItem[$Count]["item_id"]) . "'
						and `condition`='".addslashes($arryItem[$Count]["Condition"])."' and WID='".$arryItem[$Count]["WID"]."' "; 
						$restbl=$this->query($sql, 1);

						if($restbl[0]['total']==0){
							//If not find insert in tbl
									$strSQLQuery = "insert into ".$DBName."inv_item_quanity_condition 
									(ItemID,`condition`,Sku,type,condition_qty,AvgCost,WID)  
									values ('" . addslashes($arryItem[$Count]["item_id"]) . "',
									'" . addslashes($arryItem[$Count]["Condition"]) . "',
									'" . addslashes($mainSku) . "','Recive Order',
									'" . addslashes($qty_received) . "','".$NetPriceSr."','".$arryItem[$Count]["WID"]."')";
									$this->query($strSQLQuery, 0);
									$lastRecId = $this->lastInsertId();
						}else{

								$lastRecId = $restbl[0]['ID'];
								 $UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+".$qty_received .",AvgCost = AvgCost+".$NetPriceSr."  where Sku='".$mainSku."' and `condition` = '".$arryItem[$Count]["Condition"]."' and WID='".$arryItem[$Count]["WID"]."' ";
								$this->query($UpdateQtysql, 0);
						}


$qty_receivedSql  = "update p_order_item set qty_received = qty_received+".$qty_received ."  where id='".$arryItem[$Count]["ref_id"]."'  ";
								$this->query($qty_receivedSql, 0);
					$strSQLQuery2 = "insert into inv_bin_stock (Wcode,Sku,reorderlevel,bin,QTID ) 
					values ('" . addslashes($arryItem[$Count]["WID"]) . "','" . addslashes($mainSku) . "','" . addslashes($reorderlevel) . "' ,'" . addslashes($arryItem[$Count]["binid"]) . "','" . addslashes($lastRecId) . "')";

					$this->query($strSQLQuery2, 0);
					}

if ($arryItem[$Count]["SerialNumbers"] != '') {
$serial_no = explode(",", $arryItem[$Count]["SerialNumbers"]);
//$serial_desc = explode(",", $arryDetails['serialdesc' . $i]);
//$serial_price = explode(",", $arryDetails['serialPrice' . $i]);

 $query = 'INSERT INTO inv_serial_item (warehouse,serialNumber,Sku,UsedSerial,ReceiveOrderID,`Condition`,type,UnitCost,description,ReceiptDate)  VALUES ';
    $query_parts = array();
    for ($j = 0; $j < sizeof($serial_no); $j++) {
        $query_parts[] = "('".$arryItem[$Count]["WID"]."','" . $serial_no[$j] . "','" . addslashes($mainSku) . "','0','" . $OrderID . "','".$arryItem[$Count]["Condition"]."','Receive Order','".$NetPriceSr."','".addslashes($serial_desc[$j])."','".$Config['TodayDate']."')";
    }
    
$query .= implode(',', $query_parts);
$hh = $this->query($query, 0);

/*for ($j = 0; $j < sizeof($serial_no); $j++) {
		$SerchSql = "select * from inv_serial_item where LCASE(serialNumber)='" . strtolower(trim($serial_no[$j])) . "' and LCASE(Sku) ='".strtolower(trim($arryItem[$Count]["sku"])) ."' and `Condition` ='".$arryItem[$Count]["Condition"]."' and warehouse='".$arryItem[$Count]["WID"]."' and UsedSerial ='0' and Status='1' ";

		$arryRow = $this->query($SerchSql, 1);
		if ($arryRow[0]['serialID'] > 0) {$numSrId =  1;} else {$numSrId = 0;	}

if($numSrId == 0){
					$arryPurchase[0]['wCode'] =1;
					$def = 1;
					$strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,UsedSerial,ReceiveOrderID,`Condition`,type,UnitCost,description,ReceiptDate)  values ('".$arryItem[$Count]["WID"]."','" . $serial_no[$j] . "','" . addslashes($mainSku) . "','0','" . $OrderID . "','".$arryItem[$Count]["Condition"]."','Receive Order','".$NetPriceSr."','".addslashes($serial_desc[$j])."','".$Config['TodayDate']."')";

					$this->query($strSQLQuery, 0);
					$SerialID = $this->lastInsertId();

							
            }
      }*/

}


      }
  }

 


}

	function CheckMainSkuItem($sku){

		$objItem=new items();
		$checkProduct=$objItem->checkItemSku($sku);

		//By Chetan 9sep// 
		if(empty($checkProduct))
		{
		$arryAlias = $objItem->checkItemAliasSku($sku);
			if(count($arryAlias)){
					$mainSku = $arryAlias[0]['sku'];
			}
		}else{

		$mainSku = $sku;
		}

		return $mainSku;
	}

	function OpenRma(){

		$strAddQuery = "where o.Module = 'RMA' and o.Status= 'Completed'";
		$strSQLQuery = "select o.OrderType, o.OrderDate, o.PostedDate, o.ExpiryDate, o.Status, o.OrderID, o.PurchaseID,o.ReturnID,o.InvoiceID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid, o.Module ,p.PostedDate as InvoiceDate, o.AdminType, o.AdminID, if(o.AdminType='employee',e.UserName,'Administrator') as PostedBy, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorNa from  p_order o left outer join p_supplier s on   o.SuppCode =  s.SuppCode left outer join p_order p on (o.InvoiceID=p.InvoiceID and p.Module='Invoice' and p.ReturnID='') left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType='employee')  ".$strAddQuery;
		return $this->query($strSQLQuery, 1);	

	}


	function UpdatePoStatusByReceipt($ReceiptOrderID){
		if(!empty($ReceiptOrderID)){			
			$arryPurchase = $this->GetPurchase($OrderID,'','');
			$PurchaseID = $arryPurchase[0]['PurchaseID'];
			if(!empty($PurchaseID)){
				 $strSQLQuery = "select OrderID  from p_order where   Module='Receipt'  and PurchaseID='".$PurchaseID."' and OrderID != '".$ReceiptOrderID."' limit 0,1";
			 	$arryRecipt = $this->query($strSQLQuery,1);

				if(!empty($arryRecipt[0]["OrderID"])){
					$PoStatus = 'Receiving';
				}else{
					$PoStatus = 'Ready to Receive';
				}

				$strSQLQue = "update p_order set Status='".$PoStatus."' where PurchaseID='".$PurchaseID."' and Module='Order' "; 
				$this->query($strSQLQue, 0);
				 
			}
		}	
	}

//added by nisha for row color functionality
function setRowColorPurchase($OrderID,$RowColor) 
{
	   $sql = "update p_order set RowColor='".$RowColor."' where OrderID in ( $OrderID)"; 
         $this->query($sql, 0);
        return true;
}

function getCountReceiptPO($PurchaseID){

 $strSQLQuery = "select COUNT(*) as total  from p_order where   Module='Receipt'  and PurchaseID='".$PurchaseID."'";
$arryRecipt = $this->query($strSQLQuery,1);
if(is_array($arryRecipt)){

return $arryRecipt[0]['total'];
}else{
return 0;
}

}

function allowEDIdata($order_id,$Module,$db='',$invid=0){    
		global $Config;
		$IPAddress = GetIPAddress();
		/*****************/
		if($order_id>0){
			$arryPurchaseItem = $this->GetPurchaseItem($order_id);
			#pr($arryPurchaseItem); exit;
			/*****************/ 	
			$ArrayFieldName = $this->GetFieldName('p_order');
			foreach($ArrayFieldName as $key=>$values){
				if($values['Key'] != 'PRI' && $values['Field']!='AutoID'){
					$FeildAndValuesArray[] = "`".$values['Field']."`";
				} 	 
			}
			$FeildAndValues = implode(", ",$FeildAndValuesArray);
			/*****************/ 		
			 $strSQLQuery = "insert into p_order (".$FeildAndValues.") select ".$FeildAndValues."  FROM p_order
			where OrderID = '".$order_id."'";	
			$this->query($strSQLQuery, 0);	
					
			$OrderID = $this->lastInsertId();
			if($OrderID>0){
				if($Module=="Invoice"){
					$strAdd = " ,Module='Invoice' ";
				}else if($Module=="Receipt"){
				
					$strAdd = " ,Module='Receipt',ReceivedDate='".$Config['TodayDate']."',GenrateInvoice=1  ";
				}else{
					//$strAdd = " , Status='Draft' ,OrderDate ='" .$Config['TodayDate']."' ";
				}  		
			    	 $strSQL = "update p_order set ReceiptStatus='Completed',PostedDate='".$Config['TodayDate']."', CreatedDate='".$Config['TodayDate']."', UpdatedDate='".$Config['TodayDate']."', PostToGL='0', IPAddress='".$IPAddress."', Parent='".$order_id."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."'  ".$strAdd." where OrderID='" .$OrderID. "'";	
				$this->query($strSQL, 0); 
				$objConfigure = new configure();
				$objConfigure->UpdateModuleAutoID('p_order',$Module,$OrderID,'');			
				/*****************/
				$ArrayFieldName2 = $this->GetFieldName('p_order_item');	
				foreach($ArrayFieldName2 as $key=>$values){
					if($values['Key'] != 'PRI' && $values['Field']!='OrderID'){
						$FeildAndValuesArray2[] = "`".$values['Field']."`";
					} 	 
				}
				$FeildAndValues2 = implode(", ",$FeildAndValuesArray2);
				/*****************/ 				
				foreach($arryPurchaseItem as $key=>$values){
					 $strSQLQuery = "insert into p_order_item (".$FeildAndValues2.") SELECT ".$FeildAndValues2." FROM p_order_item WHERE OrderID = '".$order_id."' and id = '".$values['id']."'";
					$this->query($strSQLQuery, 0);
					$id = $this->lastInsertId();
					if(!empty($id)){


	if(!empty($invid)){
				 $strqury ="select SerialNumbers from ".$db."s_order_item where OrderID='".$invid."' and Sku ='".$values['sku']."'";
				$arrySaleData = $this->query($strqury,1);
				if($arrySaleData[0]['SerialNumbers']!=''){
				    $SerialNumbers = $arrySaleData[0]['SerialNumbers'];
				}
				}
				



						if($Module=="Invoice"){
							$stqty = " ,ref_id='".$values['id']."',qty_received='".$values['qty']."',SerialNumbers ='".$SerialNumbers."' ";
						}else if($Module=="Receipt"){
						
			
							$stqty = " , qty_received='".$values['qty']."',ref_id='".$values['id']."',SerialNumbers ='".$SerialNumbers."' ";
						}else{
							$stqty = " , qty_received='' ";
						}
					
					
						 $strSQL = "update p_order_item set OrderID ='" .$OrderID."',qty_returned='', SaleQty='' ".$stqty."  where id='" .$id. "'"; 
						$this->query($strSQL, 0);
					}
				}
				/*****************/					
				$arrySale = $this->GetPurchase($OrderID,'','');
				if($Module=='Quote'){	
					$ModuleID = "QuoteID"; 
				}else if($Module=='Order'){
					$ModuleID = "PurchaseID";
				}else if($Module=='Credit'){
					$ModuleID = "CreditID"; 					
				}else if($Module=='Invoice'){
					$ModuleID = "InvoiceID"; 
					
					$strSQLin = "update p_order set InvoiceID ='" .$arrySale[0][$ModuleID]."' where OrderID='" .$order_id. "'";
					$this->query($strSQLin, 0);
										
				}else if($Module=='Receipt'){
				 $this->ReceivePurchaseQtyOrder($OrderID);
					$ModuleID = "ReceiptID"; 					
				}
				/*****************/	

				//return $arrySale[0][$ModuleID];
				return $OrderID;
			}
		}
		
	 }
function RequestCancellationSO($reqID){

$ArryData =explode(".",$reqID);
if($ArryData[1]!=''){
  $Db ='erp_'.$ArryData[1].'.';
}

if(!empty($ArryData[0])&&$ArryData[1]!=''){
$strSQLin = "update ".$Db."s_order set CanReqest ='1' where OrderID='" .$ArryData[0]. "'";
					$this->query($strSQLin, 0);
					}

}

}
?>
