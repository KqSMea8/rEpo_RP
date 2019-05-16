<?php 
class shipment extends dbClass
{
		//constructor
		function shipment()
		{
			$this->dbClass();
		} 


function  ListShipment($arryDetails)
		{
			
			global $Config;
$module = '';
			extract($arryDetails);

	if($module=='Picking'){
			      $ShipmentStatus ='Picked';
			}
			$strAddQuery = "where o.Module='shipment' and s.ShippedID IS NOT NULL ";
			$SearchKey   = strtolower(trim($key));

			$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):(""); 
			if($Config['batchmgmt']==1){ $batch=1; $batchid=$view;}else{  $batch=0; $batchid=0;}

			$strAddQuery .= ($batch==1)?(" and  o.batchId =  '".$batchid."' "):("");
			$strAddQuery .= (!empty($so))?(" and o.SaleID='".$so."'"):("");
			$strAddQuery .= (!empty($FromDateShip))?(" and s.ShipmentDate>='".$FromDateShip."'"):("");
			$strAddQuery .= (!empty($ToDateShip))?(" and s.ShipmentDate<='".$ToDateShip."'"):("");
			$strAddQuery .= (!empty($ShipmentStatus))?(" and s.ShipmentStatus='".$ShipmentStatus."'"):("");

			/*if($SearchKey=='yes' && ($sortby=='o.ReturnPaid' || $sortby=='') ){
				$strAddQuery .= " and o.ReturnPaid='Yes'"; 
			}else if($SearchKey=='no' && ($sortby=='o.ReturnPaid' || $sortby=='') ){
				$strAddQuery .= " and o.ReturnPaid!='Yes'";
			}else*/ if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.ShippedID like '%".$SearchKey."%'  or o.InvoiceID like '%".$SearchKey."%'  or o.SaleID like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or s.RefID like '%".$SearchKey."%'  ) " ):("");	
			}
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");


			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by s.ShipmentDate,o.OrderID desc ");
		

			if($Config['GetNumRecords']==1){
				$Columns = " count(distinct(o.OrderID)) as NumCount ";				
			}else{				
				$Columns = "  distinct(o.OrderID),o.ShippedDate,s.ShipmentDate, o.ShippedID as ShippingID,o.OrderDate, o.InvoiceDate, o.SaleID ,o.InvoiceID, o.CustCode, o.CustomerName, o.TotalAmount, o.CustomerCurrency,o.SalesPersonID,o.SalesPerson,s.RefID, s.OrderID as InvID, s.ShipComment,ShipmentStatus,s.ShippedID , o.AdminType, o.AdminID, if(o.AdminType='employee',em.UserName,'Administrator') as PostedBy,o.SalesPersonType,so.PostToGL,o.VendorSalesPerson ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}else if($Limit>0){
					$strAddQuery .= " limit 0,".$Limit;
				}
		
			}


			  $strSQLQuery = "select  ".$Columns."  from s_order o left  join w_shipment  s  on o.OrderID=s.ShippedID left outer join h_employee em on (o.AdminID=em.EmpID and o.AdminType='employee') left outer join s_order so on (o.InvoiceID = so.InvoiceID and o.InvoiceID !='' and so.Module='Invoice') ".$strAddQuery;
		
			return $this->query($strSQLQuery, 1);		
				
		}


		function  GetNumShippingByYear($Year,$FromDate,$ToDate,$CustCode,$SalesPID,$Status)
		{
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and s.ShipmentDate >='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and s.ShipmentDate <='".$ToDate."'"):("");

			$strSQLQuery = "select count(s.ShipmentID) as TotalShipping  from s_order o left  join w_shipment  s  on o.OrderID=s.ShippedID  where 1 and YEAR(s.ShipmentDate)='".$Year."' ".$strAddQuery." order by s.ShipmentDate desc";
			
			return $this->query($strSQLQuery, 1);		
		}


         function RemoveShipment($OrderID){
			
	$strQuery="SELECT InvoiceID,SaleID,Module from s_order WHERE OrderID='".$OrderID."'";  
	$results=$this->query($strQuery,1);
 

	$strSaleitemQuery="SELECT * from s_order_item WHERE OrderID='".$OrderID."' ";  
	$SalesItem=$this->query($strSaleitemQuery,1);
	$NumLine2 = sizeof($SalesItem);


  

 
 
	if(!empty($results[0]['InvoiceID'])){
		         $strInvQuery="select * from s_order where InvoiceID ='".$results[0]['InvoiceID']."' and Module ='Invoice'";
		         $arrInv=$this->query($strInvQuery,1);

			if(!empty($arrInv[0]['OrderID'])){		
				$strDelInvQuery = "delete from s_order where OrderID='".$arrInv[0]['OrderID']."'";  
				$this->query($strDelInvQuery, 0);	
				$strDelItemQuery = "delete from s_order_item where OrderID='".$arrInv[0]['OrderID']."'"; 
				$this->query($strDelItemQuery, 0);
			}
	}



if(!empty($results[0]['SaleID'])){
$strSaleQuery="SELECT * from s_order WHERE SaleID='".$results[0]['SaleID']."' and Module='Order'";  
			$Sales=$this->query($strSaleQuery,1);

 
if(!empty($Sales[0]['OrderID'])){	
$strSaleItemQuery="SELECT * from s_order_item WHERE OrderID='".$Sales[0]['OrderID']."'";  
			$arryItem=$this->query($strSaleItemQuery,1);
//$arryItem = $objSale->GetSaleItem($ShippedOrderID);
			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				$id = $arryItem[$Count]["id"];
						if(!empty($id) ){
								$qty_shipped = $arryItem[$Count]["qty_shipped"];
								$itemId =    $arryItem[$Count]["item_id"];               

								//Update Item

								$qty_shipped = $qty_shipped-$qty_shipped;
								$sqlupdate = "update s_order_item set qty_shipped= '".$qty_shipped."',qty_invoiced= '".$qty_shipped."',qty_received ='".$qty_shipped."'  where id = '".$id."' and item_id = '".$itemId."'";
								$this->query($sqlupdate, 0);	
							//end code
		}

}
}	


	for($j=1;$j<=$NumLine2;$j++){
	$Cont=$j-1;
	if(!empty($SalesItem[$Cont]["id"]) ){

			$objItem=new items();
			$checkProduct=$objItem->checkItemSku($SalesItem[$Cont]["sku"]);

			//By Chetan 9sep// 
			if(empty($checkProduct))
			{
				$arryAlias = $objItem->checkItemAliasSku($SalesItem[$Cont]["sku"]);
				if(count($arryAlias))
				{
				   $mainSku = $arryAlias[0]["Sku"];			
				}
			}else{

				$mainSku = $SalesItem[$Cont]["sku"];
			}


			$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" .$SalesItem[$Cont]["qty_shipped"] . " where Sku='" . $mainSku . "' and `Condition` ='".$SalesItem[$Cont]["Condition"]."' and WID='".$SalesItem[$Cont]["WID"]."'";
			$this->query($UpdateQtysql, 0);

			$sqlshipped="UPDATE s_order_item SET qty_shipped='',ref_id='0' WHERE id='".$SalesItem[$Cont]["id"]."' and sku ='".$SalesItem[$Cont]["sku"]."'";
			$this->query($sqlshipped,0);


			/*$serial_value=trim($SalesItem[$Cont]["SerialNumbers"]);
			$serial_no = explode(",",$serial_value);

			$resultSr = "'" . implode ( "', '", $serial_no ) . "'";



			$strSerialSQL = "update inv_serial_item set UsedSerial='0'  where serialNumber IN (".$resultSr.") and Sku ='" . addslashes($mainSku) ."' and `Condition` ='".$SalesItem[$Cont]["Condition"]."' and `warehouse` ='".$SalesItem[$Cont]["WID"]."' and LineID>'0' "; 



			$this->query($strSerialSQL, 0);*/

	}






	}
		
$sql="UPDATE s_order SET batchId='' WHERE SaleID='".$results[0]['SaleID']."' and Module ='Order'";
			$this->query($sql,0);

//Remove picking
//$this->RemovePicking($Sales[0]['OrderID']);


}



 			$this->DeleteShipmentPdf($OrderID);


			$strSQLQuery = "delete from s_order where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from s_order_item where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			$strShipQuery = "delete from w_shipment where ShippedID='".$OrderID."'"; 
			$this->query($strShipQuery, 0);

			

			return 1;

		}



	function DeleteShipmentPdf($ShippedID){
		
		if($ShippedID>0){
			global $Config;
			$objFunction=new functions();

 
			$strQuery="SELECT ShipType,sendingLabel,label,LabelChild from w_shipment WHERE ShippedID='".$ShippedID."'";  
			$arryShippInfo=$this->query($strQuery,1);

			
			$LabelFolder = strtolower($arryShippInfo[0]["ShipType"])."/";
   			$LabelPath = "../shipping/upload/".$LabelFolder.$_SESSION['CmpID']."/";
   	
			if($arryShippInfo[0]['label'] !=''){				
				$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$arryShippInfo[0]['label']);
			} 			 
   			 
   			if($arryShippInfo[0]['sendingLabel'] !=''){
   				$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$arryShippInfo[0]['sendingLabel']);
   			}
   	
			if($arryShippInfo[0]['LabelChild'] !='' ){ 
				$LabelChildArry = explode("#",$arryShippInfo[0]['LabelChild']);
				foreach($LabelChildArry as $childlabel){
					if($childlabel !='' ){ 
						$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$childlabel);
					}
				}
			}

		  

		}
	
		return 1;

	}

/*function RemoveShipmentInvoice($arryDetails){

extract($arryDetails);

$strQuery="SELECT InvoiceID from s_order WHERE OrderID='".$del_id."'";
			$results=$this->query($strQuery,1);
$InvoiceID = $results[0]['InvoiceID'];
if($InvoiceID){
			$strInvQuery="SELECT OrderID,InvoiceID from s_order WHERE InvoiceID='".$InvoiceID."' and Module ='Invoice'";
			$arrInv=$this->query($strInvQuery,1);
				if($arrInv[0]['OrderID']>0){
							$strSQLQuery = "delete from s_order_item where OrderID='".$arrInv[0]['OrderID']."'"; 
										$this->query($strSQLQuery, 0);	
							$strSQLQuery = "delete from s_order_item where OrderID='".$arrInv[0]['OrderID']."'"; 
										$this->query($strSQLQuery, 0);

				}
}

}*/

function RemovePicking($del_id){

	$strInvQuery="Update s_order set PICKID='',PickStatus='' WHERE OrderID='".$del_id."'";
	$this->query($strInvQuery, 0);

	echo $strSaleItemQuery="SELECT SerialNumbers,Sku,id from s_order_item WHERE OrderID='".$del_id."'";  
	$arrysalitem=$this->query($strSaleItemQuery,1);

	foreach($arrysalitem as $values){

	if($values["SerialNumbers"]!='' && !empty($values["SerialNumbers"])){
		$serial_value=trim($values["SerialNumbers"]);
		$serial_no = explode(",",$serial_value);
		$resultSr = "'" . implode ( "', '", $serial_no ) . "'";
		$strSerialSQL = "update inv_serial_item set UsedSerial='0',LineID='0'  where serialNumber IN (".$resultSr.") and  LineID>0 and UsedSerial=1 and Status=1 and LineID='".$values['id']."'"; 
		$this->query($strSerialSQL, 0);
	}

	}






	$strQuery="Update s_order_item set qty_picked='0',qty_shipped='0',qty_invoiced='0',SerialNumbers='' WHERE OrderID='".$del_id."'";
	$this->query($strQuery, 0);

	//$strSQLQuery="Update inv_serial_item set UsedSerial='0',OrderID='0',LineID='0' WHERE OrderID='".$del_id."'";
	//$this->query($strSQLQuery, 0);


}

function UnlinkShipLable($shipID){
	if($shipID>0){
		global $Config;
		#$objFunction=new functions();
		 

		$strQuery="SELECT ShipType,sendingLabel,label,LabelChild from w_shipment WHERE ShipmentID='".$shipID."'";  
		$arryShippInfo=$this->query($strQuery,1);
		 
		$Config['UnlinkShipLable']['ShipType'] = $arryShippInfo[0]["ShipType"];

		$LabelFolder = strtolower($arryShippInfo[0]["ShipType"])."/";
		$LabelPath = "../shipping/upload/".$LabelFolder.$_SESSION['CmpID']."/";

		if($arryShippInfo[0]['label'] !=''){	
			$Config['UnlinkShipLable']['ShipLabel'][] = $arryShippInfo[0]['label'];			
			#$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$arryShippInfo[0]['label']);
		} 			 
		 
		if($arryShippInfo[0]['sendingLabel'] !=''){
			$Config['UnlinkShipLable']['ShipLabel'][] = $arryShippInfo[0]['sendingLabel'];		
			#$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$arryShippInfo[0]['sendingLabel']);
		}

		if($arryShippInfo[0]['LabelChild'] !='' ){ 
			$LabelChildArry = explode("#",$arryShippInfo[0]['LabelChild']);
			foreach($LabelChildArry as $childlabel){
				if($childlabel !='' ){ 
					$Config['UnlinkShipLable']['ShipLabel'][] = $childlabel;	
					#$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$childlabel);
				}
			}
		}

		 
	}
	return true;
}



function UpdateShipment($arryDetails){		
	global $Config;		
    	extract($arryDetails);  

	
	

	if(!empty($tracking_id) && !empty($ShipType)){
		$IPAddress = GetIPAddress(); 

		$this->UnlinkShipLable($shipID);
  
		$strSQLQuery = "update  w_shipment set label ='".$file_name."',trackingId='".$tracking_id."',totalFreight='".$totalFreight."',COD='".$COD."',sendingLabel='".$sendingLabel."',ShipType='".$ShipType."',InsureAmount='".$InsureAmount."',InsureValue='".$InsureValue."'
			,ZipFrom ='".addslashes($_SESSION['Shipping']['ZipFrom'])."'
			,CityFrom ='".addslashes($_SESSION['Shipping']['CityFrom'])."'
			,StateFrom ='".addslashes($_SESSION['Shipping']['StateFrom'])."'
			,CountryFrom ='".addslashes($_SESSION['Shipping']['CountryFrom'])."'
			,ZipTo ='".addslashes($_SESSION['Shipping']['ZipTo'])."'
			,CityTo ='".addslashes($_SESSION['Shipping']['CityTo'])."'
			,StateTo ='".addslashes($_SESSION['Shipping']['StateTo'])."'
			,CountryTo ='".addslashes($_SESSION['Shipping']['CountryTo'])."'
			,ShippingMethod ='".addslashes($_SESSION['Shipping']['ShippingMethod'])."'
			,PackageType ='".addslashes($_SESSION['Shipping']['PackageType'])."'
			,NoOfPackages ='".addslashes($_SESSION['Shipping']['NoOfPackages'])."'
			,Weight ='".addslashes($_SESSION['Shipping']['Weight'])."'
			,WeightUnit ='".addslashes($_SESSION['Shipping']['WeightUnit'])."'
			,DeliveryDate ='".addslashes($_SESSION['Shipping']['DeliveryDate'])."'
			,LineItem ='".addslashes($_SESSION['Shipping']['LineItem'])."'
			,LabelChild ='".addslashes($_SESSION['Shipping']['LabelChild'])."'
			,createdDate ='".$Config['TodayDate']."' 
			, IPAddress = '". $IPAddress."' 

			,CompanyFrom = '".addslashes($_SESSION['Shipping']['CompanyFrom'])."'
			,FirstnameFrom ='".addslashes($_SESSION['Shipping']['FirstnameFrom'])."'
			,LastnameFrom ='".addslashes($_SESSION['Shipping']['LastnameFrom'])."'
			,Contactname ='".addslashes($_SESSION['Shipping']['Contactname'])."'
			,Address1From ='".addslashes($_SESSION['Shipping']['Address1From'])."'
			,Address2From ='".addslashes($_SESSION['Shipping']['Address2From'])."'

			,CompanyTo ='".addslashes($_SESSION['Shipping']['CompanyTo'])."'
			,FirstnameTo ='".addslashes($_SESSION['Shipping']['FirstnameTo'])."'
			,LastnameTo ='".addslashes($_SESSION['Shipping']['LastnameTo'])."'
			,ContactNameTo ='".addslashes($_SESSION['Shipping']['ContactNameTo'])."'
			,Address1To ='".addslashes($_SESSION['Shipping']['Address1To'])."'
			,Address2To ='".addslashes($_SESSION['Shipping']['Address2To'])."'

			,AccountType = '".addslashes($_SESSION['Shipping']['AccountType'])."'
			,AccountNumber = '".addslashes($_SESSION['Shipping']['AccountNumber'])."' 
			,AesNumber = '".addslashes($_SESSION['Shipping']['AesNumber'])."'
			,CustomerPickupCarrier = '".addslashes($_SESSION['Shipping']['CustomerPickupCarrier'])."' 

			where ShipmentID='".$shipID."'"; 
				 
		$this->query($strSQLQuery, 0);




		$this->UpdateInvoiceTracking($OrderID,$tracking_id); //update invoice tracking


	}

	return 1;

}



function UpdateInvoiceTracking($ShipOrderID,$tracking_id){
	if($ShipOrderID>0){
		$strQuery="SELECT InvoiceID from s_order WHERE OrderID='".$ShipOrderID."'";  //ship info
		$arryShipp=$this->query($strQuery,1);
		$InvoiceID = $arryShipp[0]['InvoiceID'];
		if(!empty($InvoiceID)){
			$strSQLQuery = "update  s_order set TrackingNo='".$tracking_id."' where Module='Invoice' and InvoiceID='".$InvoiceID."' "; 	
			$this->query($strSQLQuery, 0);
		}
		 
	}
	return 1;
}

function UpdateMultipleOrderID($ShippedID){
	if($ShippedID>0){		 
		$strSQLQuery = "update  w_shipment set Multiple ='".addslashes($_SESSION['Shipping']['Multiple'])."'
						,MultipleOrderID ='".addslashes($_SESSION['Shipping']['MultipleOrderID'])."' where ShippedID='".$ShippedID."' "; 	
		$this->query($strSQLQuery, 0);		 
		 
	}
	return 1;
}

function AddShipment($arryDetails){
		
		    global $Config;
		    
			extract($arryDetails);

   if(empty($_POST['totalFreight']) || $_POST['totalFreight']<=0){
		    	$totalFreight= $_POST['freigh'];
		    }else{
           $totalFreight= $_POST['totalFreight'];
         }
			
		$IPAddress = GetIPAddress(); 


 

		 	
		     $strSQLQuery = "INSERT INTO w_shipment SET ModuleType = 'Shipment', 
								ShippedID ='".$ShippedID."',
								RefID     ='".$InvoiceID."',
								OrderID   ='".$RefOrderID."',
								ShipmentStatus = '".$ShipStatus."',
								ShipComment = '".addslashes($ShipmentComment)."',
								CreatedBy = '".addslashes($_SESSION['UserName'])."',
								AdminID='".$_SESSION['AdminID']."',
								AdminType='".$_SESSION['AdminType']."',
								ShipmentDate='".$ShippedDate."',
GenrateShipInvoice ='".$GenrateShipInvoice."',
								WID ='".$WID."',
								WarehouseName = '".addslashes($WarehouseName)."',
                WarehouseCode = '".addslashes($WarehouseCode)."',
								ShipmentMethod='".addslashes($ShippingMethod)."',
								ShipCreateDate ='".$Config['TodayDate']."',
							     label = '".$_POST['file_name']."', 
							     trackingId ='".$_POST['tracking_id']."',
							     totalFreight='".$totalFreight."',
							     COD ='".$_POST['COD']."',
							     sendingLabel ='".$_POST['sendingLabel']."',
 							     ShipType ='".$_POST['ShipType']."',
							     createdDate ='".$Config['TodayDate']."' ,IPAddress = '". $IPAddress."' ,InsureAmount = '". $_POST['InsureAmount']."',InsureValue = '". $_POST['InsureValue']."'

  							     ,ZipFrom ='".addslashes($_SESSION['Shipping']['ZipFrom'])."'
							     ,CityFrom ='".addslashes($_SESSION['Shipping']['CityFrom'])."'
							     ,StateFrom ='".addslashes($_SESSION['Shipping']['StateFrom'])."'
							     ,CountryFrom ='".addslashes($_SESSION['Shipping']['CountryFrom'])."'
							     ,ZipTo ='".addslashes($_SESSION['Shipping']['ZipTo'])."'
							     ,CityTo ='".addslashes($_SESSION['Shipping']['CityTo'])."'
							     ,StateTo ='".addslashes($_SESSION['Shipping']['StateTo'])."'
							     ,CountryTo ='".addslashes($_SESSION['Shipping']['CountryTo'])."'
							     ,ShippingMethod ='".addslashes($_SESSION['Shipping']['ShippingMethod'])."'
							,PackageType ='".addslashes($_SESSION['Shipping']['PackageType'])."'
							     ,NoOfPackages ='".addslashes($_SESSION['Shipping']['NoOfPackages'])."'
							     ,Weight ='".addslashes($_SESSION['Shipping']['Weight'])."'
							     ,WeightUnit ='".addslashes($_SESSION['Shipping']['WeightUnit'])."'
								,DeliveryDate ='".addslashes($_SESSION['Shipping']['DeliveryDate'])."'
					        ,LineItem ='".addslashes($_SESSION['Shipping']['LineItem'])."'
						,LabelChild ='".addslashes($_SESSION['Shipping']['LabelChild'])."'
						

,CompanyFrom = '".addslashes($_SESSION['Shipping']['CompanyFrom'])."'
,FirstnameFrom ='".addslashes($_SESSION['Shipping']['FirstnameFrom'])."'
,LastnameFrom ='".addslashes($_SESSION['Shipping']['LastnameFrom'])."'
,Contactname ='".addslashes($_SESSION['Shipping']['Contactname'])."'
,Address1From ='".addslashes($_SESSION['Shipping']['Address1From'])."'
,Address2From ='".addslashes($_SESSION['Shipping']['Address2From'])."'

,CompanyTo ='".addslashes($_SESSION['Shipping']['CompanyTo'])."'
,FirstnameTo ='".addslashes($_SESSION['Shipping']['FirstnameTo'])."'
,LastnameTo ='".addslashes($_SESSION['Shipping']['LastnameTo'])."'
,ContactNameTo ='".addslashes($_SESSION['Shipping']['ContactNameTo'])."'
,Address1To ='".addslashes($_SESSION['Shipping']['Address1To'])."'
,Address2To ='".addslashes($_SESSION['Shipping']['Address2To'])."'

,AccountType = '".addslashes($_SESSION['Shipping']['AccountType'])."'
,AccountNumber = '".addslashes($_SESSION['Shipping']['AccountNumber'])."' 
,CustomerPickupCarrier = '".addslashes($_SESSION['Shipping']['CustomerPickupCarrier'])."' 

";
			#echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$shipment_id = $this->lastInsertId();
			
			

		 return $shipment_id;		
		}

function AddShipOrder($arryDetails){
		
		    global $Config;
		    $IPAddress = GetIPAddress();
			extract($arryDetails);
			 	

	 	
			$strSQLQuery = "INSERT INTO s_order SET Module = '".$Module."',
ShippedID='".$ShippedID."',	
																					OrderDate='".$OrderDate."',
																							SaleID ='".$SaleID."',
																							QuoteID = '".$QuoteID."',
																							SalesPersonID = '".$SalesPersonID."',
																							SalesPerson = '".addslashes($SalesPerson)."',
																							SalesPersonType = '".$SalesPersonType."',
																							Approved = '".$Approved."',
																							Status = '".$Status."', 
																							DeliveryDate = '".$DeliveryDate."',
																							Comment = '".addslashes($Comment)."',
																							CustCode='".addslashes($CustCode)."',
																							CustID = '".$CustID."',
																							CustomerCurrency = '".addslashes($CustomerCurrency)."',
																							BillingName = '".addslashes($BillingName)."',
																							CustomerName = '".addslashes($CustomerName)."',
																							CustomerCompany = '".addslashes($CustomerCompany)."',
																							Address = '".addslashes(strip_tags($Address))."',
																							City = '".addslashes($City)."',
																							State = '".addslashes($State)."',
																							Country = '".addslashes($Country)."',
																							ZipCode = '".addslashes($ZipCode)."',
																							Mobile = '".$Mobile."',
																							Landline = '".$Landline."',
																							Fax = '".$Fax."',
																							Email = '".addslashes($Email)."',
																							ShippingName = '".addslashes($ShippingName)."',
																							ShippingCompany = '".addslashes($ShippingCompany)."',
																							ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."',
																							ShippingCity = '".addslashes($ShippingCity)."',
																							ShippingState = '".addslashes($ShippingState)."',
																							ShippingCountry = '".addslashes($ShippingCountry)."',
																							ShippingZipCode = '".addslashes($ShippingZipCode)."', 
																							ShippingMobile = '".$ShippingMobile."',
																							ShippingLandline = '".$ShippingLandline."',
																							ShippingFax = '".$ShippingFax."', 
																							ShippingEmail = '".addslashes($ShippingEmail)."',
																							TotalAmount = '".addslashes($TotalAmount)."',
																							TotalInvoiceAmount = '".addslashes($TotalInvoiceAmount)."',
																							Freight ='".addslashes($Freight)."',
																							ShipFreight ='".addslashes($ShipFreight)."' ,
																							TDiscount ='".addslashes($TDiscount)."',
																							taxAmnt ='".addslashes($taxAmnt)."',
																							CreatedBy = '".addslashes($_SESSION['UserName'])."',
																							AdminID='".$_SESSION['AdminID']."',
																							AdminType='".$_SESSION['AdminType']."',
																							PostedDate='".$Config['TodayDate']."',
CreatedDate='".$Config['TodayDate']."',	
																					    UpdatedDate='".$Config['TodayDate']."',
																							ShippedDate='".$ShippedDate."',
																							wCode ='".$wCode."',
																							wName = '".addslashes($wName)."',
																							InvoiceDate ='".$Config['TodayDate']."',
																							InvoiceComment='".addslashes($InvoiceComment)."',
																							PaymentMethod='".addslashes($PaymentMethod)."',
																							ShippingMethod='".addslashes($ShippingMethod)."',
																							PaymentTerm='".addslashes($PaymentTerm)."',
																							Taxable='".addslashes($Taxable)."',
																							Reseller='".addslashes($Reseller)."' ,
																							ResellerNo='".addslashes($ResellerNo)."' ,
																							tax_auths='".addslashes($tax_auths)."', 
																							Spiff='".addslashes($Spiff)."',
																							SpiffContact='".addslashes($SpiffContact)."',
																							SpiffAmount='".addslashes($SpiffAmount)."',
																							TaxRate='".addslashes($TaxRate)."',
																							CustDisType='".addslashes($CustDisType)."',
																							CustDisAmt='".addslashes($CustDisAmt)."',
																							MDType='".addslashes($MDType)."',
																							MDAmount ='".addslashes($MDAmount)."',
																							MDiscount ='".addslashes($MDiscount)."',
																							ShippingMethodVal='".addslashes($ShippingMethodVal)."',
																							CustomerPO ='".addslashes($CustomerPO)."', 
																							TrackingNo ='".$TrackingNo."', 
																							ShipAccount ='".addslashes($ShipAccount)."',
																							OrderSource='".addslashes($OrderSource)."' ,
																							Fee='".$Fee."' ,
																							OrderPaid='".$OrderPaid."' ,
																							ReturnID = '".$ReturnID."',
																							ReturnDate='".$ReturnDate."',
																							ReturnPaid='".$ReturnPaid."',
																							ReturnComment='".addslashes($ReturnComment)."',
																							IPAddress = '". $IPAddress."',
																							batchId = '". $batchId."',
																							EntryBy = '".$EntryBy."' , 
																							AccountID = '".$AccountID."' ,
                       ConversionRate = '".$ConversionRate."' ,
                       freightTxSet='".addslashes($freightTxSet)."',
                       ActualFreight='".addslashes($ActualFreight)."',
                       ShipAccountNumber='".addslashes($ShipAccountNumber)."',
                       ShippingAccountNumber ='".$ShippingAccountNumber."',
                       ShippingAccountCustomer ='".$ShippingAccountCustomer."',
                       FreightDiscounted ='".$FreightDiscounted."',
                       EdiPoID ='".$EdiPoID."',
                       PONumber='".$PONumber."',


FileName = '" . $FileName . "', CountryId = '". $CountryId."', StateID = '". $StateID."', CityID = '". $CityID."', ShippingCountryID = '". $ShippingCountryID."', ShippingStateID = '". $ShippingStateID."', ShippingCityID = '". $ShippingCityID."',EDIRefNo = '".$EDIRefNo."',EDICompId='".addslashes($EDICompId)."' ,EDICompName='".addslashes($EDICompName)."',VendorSalesPerson = '".$VendorSalesPerson."' ";
			#echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();
			
			/*************
			if(empty($ShippedID)){
				$ShippedID = 'SHIP000'.$OrderID;
			}
			$sql="UPDATE s_order SET ShippedID='".$ShippedID."' WHERE OrderID='".$OrderID."'";
			$this->query($sql,0);
			*/

			$objConfigure = new configure();
			$objConfigure->UpdateModuleAutoID('s_order',$Module,$OrderID,$ShippedID);
	
						

		 return $OrderID;

		
		}




 function ShipOrder($arryDetails)	{



			global $Config;
			extract($arryDetails);
                        $objSale = new sale();
			$arrySale = $objSale->GetSale($ShippedOrderID,'','');

			$arrySale[0]["Module"] = "Shipment";
			$arrySale[0]["ModuleID"] = "ShippedID";
			$arrySale[0]["PrefixSale"] = "SHIP";
			$arrySale[0]["ShippedID"] = $ShippedID;
			$arrySale[0]["ShippedDate"] = $ShippedDate;
			$arrySale[0]["Freight"] = $Freight;
			$arrySale[0]["ActualFreight"] = $ActualFreight;
			$arrySale[0]["TDiscount"] = $TDiscount;
			$arrySale[0]["taxAmnt"] = $taxAmnt;
			$arrySale[0]["TotalAmount"] = $TotalAmount;	
			$arrySale[0]["ShipmentComment"] = $ShipmentComment;	
			$arrySale[0]["batchId"] = $batchId;	
			$arrySale[0]["TrackingNo"] = $_SESSION['tracking_id'];
			$arrySale[0]["ShipAccountNumber"] = $ShipAccountNumber;	

	
			/*$arrySale[0]["EmpID"] = $arrySale[0]['SalesPersonID'];	
			$arrySale[0]["EmpName"] = $arrySale[0]['AssignedEmp'];	
			$arrySale[0]["EmpID"] = $arrySale[0]['SalesPersonID'];	
			$arrySale[0]["EmpName"] = $arrySale[0]['AssignedEmp'];	*/
			$order_id = $this->AddShipOrder($arrySale[0]);
			if($order_id>0){
					$arrySale[0]["ShipStatus"] = $ShipStatus;
					$arrySale[0]["WarehouseCode"] = $WarehouseCode;
					$arrySale[0]["WarehouseName"] = $WarehouseName;	
					$arrySale[0]["WID"] = $WID;
					$arrySale[0]["ShippedID"] = $order_id;
					$arrySale[0]["RefOrderID"] = $ShippedOrderID;
					$arrySale[0]["GenrateShipInvoice"] = $GenrateShipInvoice;                     
					$shipment_id = $this->AddShipment($arrySale[0]);
			}


			/******** Item Updation for Return ************/
			$arryItem = $objSale->GetSaleItem($ShippedOrderID);
			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				$id = $arryDetails['id'.$i];
				if(!empty($id) ){

if($arryDetails['qty'.$i]==''|| empty($arryDetails['qty'.$i])){
$qty_shipped = 0;
}else{

$qty_shipped = $arryDetails['qty'.$i];
}

/*if($arryDetails['serial_value'.$i]!=''){
  $SerialCost =  $this->CheckSerialCost($arryItem[$Count]["sku"],$arryDetails['serial_value'.$i],$arryDetails['Condition'.$i],$arryDetails['WID'.$i]);
$arryDetails['avgCost'.$i] = $SerialCost/$qty_shipped;
}*/


	if($arryDetails['Org_Qty'.$i]>0 && $arryDetails['Org_Qty'.$i]!=''){
						       $arryDetails['avgCost'.$i] = $arryDetails['avgCost'.$i]*$arryDetails['Org_Qty'.$i];
						}  

					//$qty_shipped = $arryDetails['qty'.$i];
//if(isset($arryDetails['DropshipCheck'.$i]) && !empty($arryDetails['DropshipCheck'.$i])){$DropshipCheck = 1;$serial_value='';}else{$DropshipCheck = 0;$SerialNumbers=trim($arryDetails['serial_value'.$i]);}
if(isset($arryDetails['DropshipCheck'.$i]) && !empty($arryDetails['DropshipCheck'.$i])){$DropshipCheck = 1;}else{$DropshipCheck = 0;$SerialNumbers=trim($arryDetails['serial_value'.$i]);}
                        



                
					$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description,DesComment, on_hand_qty, qty, qty_received,qty_invoiced,qty_shipped, price, tax_id, tax, amount, Taxable, req_item,SerialNumbers,`Condition`,avgCost,DropshipCheck,DropshipCost,parent_item_id,Org_Qty,bin) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['avgCost'.$i]."', '".addslashes($arryItem[$Count]["sku"])."', '".addslashes($arryItem[$Count]["description"])."','".addslashes($arryItem[$Count]["DesComment"])."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".addslashes($arryDetails['received_qty'.$i])."', '".addslashes($arryDetails['received_qty'.$i])."','".$qty_shipped."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."', '".addslashes($arryItem[$Count]["req_item"])."','".addslashes($SerialNumbers)."','".addslashes($arryItem[$Count]["Condition"])."','".$arryDetails['avgCost'.$i]."','".addslashes($DropshipCheck)."','".addslashes($arryDetails['DropshipCost'.$i])."','".addslashes($arryDetails['parent_ItemID'.$i])."','".addslashes($arryDetails['Org_Qty'.$i])."','".addslashes($arryDetails['bin'.$i])."')";

					$this->query($sql, 0);	
			


/*************CODE FOR ADD SERIAL NUMBERS 11jan2017******/
 
                                                
 /***********************END CODE**********************************************/

					//Update Item
					$sqlSelect = "select qty_shipped from s_order_item where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qty_shipped = $arrRow[0]['qty_shipped'];
					$qty_shipped = $qty_shipped+$arryDetails['qty'.$i];
					$sqlupdate = "update s_order_item set qty_shipped= '".$qty_shipped."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$this->query($sqlupdate, 0);	
					//end code


				}
			}

/*$sqlComSelect = "select SUM(avgCost) as TotCost,parent_item_id from s_order_item where  parent_item_id>'0' and OrderID='".$order_id."' group by parent_item_id";
$arrRowCost = $this->query($sqlComSelect, 1);
if(sizeof($arrRowCost)>0){
foreach($arrRowCost as $key=>$valCom){

$updateKit = "update s_order_item set avgCost = avgCost+".$valCom['TotCost']." where  parent_item_id='0' and OrderID='".$order_id."' and item_id='".$valCom['parent_item_id']."'";
					$this->query($updateKit, 0);

}
}*/
if($arrySale[0]["batchId"]>0){

$strOrderUpdate = "update s_order set batchId = '".$arrySale[0]["batchId"]."' where Module = 'Order' and OrderID = '".$ShippedOrderID."'  ";
            $this->query($strOrderUpdate, 1);

}

			return $order_id;
		}

function  GetQtyShipped($id)
		{
			//$sql = "select sum(i.qty_invoiced) as QtyInvoiced,sum(i.qty_shipped) as QtyShipped from s_order_item i where i.OrderID='".$id."' group by i.OrderID";

$sql = "select sum(i.qty) as QtyInvoiced,sum(i.qty_shipped) as QtyShipped from s_order_item i where i.OrderID='".$id."' group by i.OrderID";
			$rs = $this->query($sql);
			$rs = $this->query($sql);
			return $rs;
		}

function  GetShipment($OrderID,$ShippedID,$Module)
		{
			$strAddQuery ='';
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($ShippedID))?(" and o.ShippedID='".$ShippedID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			 $strSQLQuery = "select o.* from s_order o where 1 ".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}

function  GetWarehouseShip($ShipmentID,$ShippedID)
		{
			$strAddQuery ='';
			$strAddQuery .= (!empty($ShipmentID))?(" and o.ShipmentID='".$ShipmentID."'"):("");
			$strAddQuery .= (!empty($ShippedID))?(" and o.ShippedID='".$ShippedID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.ModuleType='".$Module."'"):("");
			$strSQLQuery = "select o.* from w_shipment o where 1".$strAddQuery." order by o.ShipmentID desc";
			 return $this->query($strSQLQuery, 1);
		}

function UpdateShip($arryDetails){ 
			global $Config;
			extract($arryDetails);

	$AddSql = '';

	if(!empty($ShipAccountNumber)){
		$AddSql .= " , ShipAccountNumber='".addslashes($ShipAccountNumber)."' ";
	}
 
	$strUpdateQuery = "update s_order set Freight='".$Freight."', ActualFreight='".$ActualFreight."', TotalAmount='".$TotalAmount."',  UpdatedDate = '".$Config['TodayDate']."' ".$AddSql."	where OrderID='".$OrderID."'"; 
	$this->query($strUpdateQuery, 0);


 
	if(!empty($ShipStatus)){
		$strSQLQuery = "update w_shipment set ShipmentStatus='".$ShipStatus."',GenrateShipInvoice='".$GenrateShipInvoice."', ShipComment='".addslashes($ShipmentComment)."',RefID ='".$RefInvoiceID."'
		where ShipmentID='".$shipID."'"; 
		$this->query($strSQLQuery, 0); 
	}

$actualAmnt =0; $taxAmnt=0;$discountAmnt=0;


#echo $strSQLQuery; exit;
			

			return 1;
		}	



/* 13 august */

		
		function itemListing($ItemID){
			if(!empty($ItemID)){
				$strQuery="SELECT * FROM inv_items WHERE ItemID='".$ItemID."'";
				$results=$this->query($strQuery,1);
				return $results;
			}
		}
		

		
		/*function countryCode($CountryName){
			
			$objConfig = new admin();
			$objConfig->dbName ='erp';
			$objConfig->connect();
				
			 $strQuery="SELECT code FROM country WHERE name='".$CountryName."'";
			 $results=$this->query($strQuery,1);

			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
				
			return $results;
			
		}
		
		
		
	function addShipmentDetail($file_name,$freigh,$totalFreight,$tracking_id,$ShippedID){
		    global $Config;
		    if(empty($totalFreight) || $totalFreight<=0){
		    	$totalFreight=$freigh;
		    }
		    
		     $strSQLQuery = "INSERT INTO w_shipment_details SET label = '".$file_name."', trackingId ='".$tracking_id."',totalFreight='".$totalFreight."',createdDate ='".$Config['TodayDate']."',ShippedID='".$ShippedID."'";
			 $this->query($strSQLQuery, 0);
			
		}
		*/
			
	     function listingShipmentDetail($ShippedID){
			if(!empty($ShippedID)){
				 $strSQLQuery = "select *  from w_shipment where ShippedID = '".$ShippedID."'";
				 $results=$this->query($strSQLQuery,1);
				 return $results;
			}
			
		}

	    function GetShipmentParent($ShippedID){
			if(!empty($ShippedID)){
				 $strSQLQuery = "select ShippedID from w_shipment where FIND_IN_SET(".$ShippedID.", MultipleOrderID) and Multiple='1' and MultipleOrderID!='' limit 0,1";
				 $results=$this->query($strSQLQuery,1);
				 if(!empty($results[0]['ShippedID'])) return $results[0]['ShippedID'];
			}
			
		}
	
		function updateApiAccountDetail($arryDetails){
			global $Config;
			extract($arryDetails);
			 $strSqlQuery=" UPDATE w_global_setting SET FedExAccount='".$FedExAccount."',UPSAccount='".$UPSAccount."',DHLAccount='".$DHLAccount."',USPSAccount='".$USPSAccount."',SourceZipcode='".$SourceZipcode."' WHERE id='1'";
			
			$this->query($strSqlQuery,0);
			
		}
		
		
		 function getApiAccountDetail(){
			$strSqlQuery="SELECT * FROM w_global_setting WHERE id='1'";
			$results = $this->query($strSqlQuery,1);
			return $results;
			
		}




		function addProfileShipment($arryDetails){
			global $Config;
			extract($arryDetails);
			$strSQLQuery = "INSERT INTO w_shipment_profile SET Nickname = '".$Nickname."',Company = '".$Company."',ContactName = '".$ContactName."',ServiceType = '".$ServiceType."',Weight = '".$Weight."',wtUnit = '".$wtUnit."',PackagingType = '".$PackagingType."',PackageDiscriptions = '".$PackageDiscriptions."'";
		    //echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			
			
		}
			
		 function ListShipmentProfile(){
			$strSqlQuery="SELECT * FROM w_shipment_profile";
			$results = $this->query($strSqlQuery,1);
			return $results;
			
		}
		
		
		function UpdateProfileShipment($arryDetails,$profileID){
			global $Config;
			extract($arryDetails);
			$strSQLQuery = "UPDATE w_shipment_profile SET Nickname = '".$Nickname."',Company = '".$Company."',ContactName = '".$ContactName."',ServiceType = '".$ServiceType."',Weight = '".$Weight."',wtUnit = '".$wtUnit."',PackagingType = '".$PackagingType."',PackageDiscriptions = '".$PackageDiscriptions."' where profileID='".$profileID."'";
		    //echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			
		}
		
		
         function RemoveProfileShipment($profileID){
			$strSQLQuery = "delete from w_shipment_profile where profileID='".$profileID."'"; 
			$this->query($strSQLQuery, 0);

			return 1;

		}
		
	     function ListShipmentProfileByID($profileID){
		     $strSQLQuery = "select * from w_shipment_profile where profileID='".$profileID."'"; 
			 $results=$this->query($strSQLQuery,1);
			 return $results;
			
		}


	/* shipmonet form */
	
	function addShipmentFrom($arryDetails){
		global $Config;
		extract($arryDetails);
		$strSQLQuery = "INSERT INTO w_shipment_from SET SavedSenders = '".$SavedSenders."',CountryLocation = '".$CountryLocation."',Company = '".$Company."',ContactName = '".$ContactName."',Address1 = '".$Address1."',Address2 = '".$Address2."',ZIP = '".$ZIP."',City = '".$City."',State = '".$State."',PhoneNo = '".$PhoneNo."',ext = '".$ext."'";
		//echo "=>".$strSQLQuery;exit;
		$this->query($strSQLQuery, 0);

	}
	
	
	function UpdateShipmentFrom($arryDetails,$ShippedID){
		global $Config;
		extract($arryDetails);
		
		$strSQLQuery = "UPDATE w_shipment_from SET SavedSenders = '".$SavedSenders."',CountryLocation = '".$CountryLocation."',Company = '".$Company."',ContactName = '".$ContactName."',Address1 = '".$Address1."',Address2 = '".$Address2."',ZIP = '".$ZIP."',City = '".$City."',State = '".$State."',PhoneNo = '".$PhoneNo."',ext = '".$ext."'  where ShippedID='".$ShippedID."'";
		//echo "=>".$strSQLQuery;exit;
		$this->query($strSQLQuery, 0);
			
	}
	
	function RemoveShipmentFrom($ShippedID){
		$strSQLQuery = "delete from w_shipment_from where ShippedID='".$ShippedID."'";
		$this->query($strSQLQuery, 0);

		return 1;

	}
	
	function ListShipmenFromByID($ShippedID){
		$strSQLQuery = "select * from w_shipment_from where ShippedID='".$ShippedID."'";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}
	
	function ListShipmentFrom(){
		$strSqlQuery="SELECT * FROM w_shipment_from ORDER BY ShippedID DESC";
		$results = $this->query($strSqlQuery,1);
		return $results;
			
	}


	function saveToandFromData($arryDetails){

		if(!empty($_POST['SaveinAddressbookFrom'])){
			if($_POST['SaveinAddressbookFrom']=='Yes'){
		    	$strSqlQuery="INSERT INTO w_addressbook SET
			Country = '".$_POST['CountryFrom']."',
			Company='".$_POST['CompanyFrom']."',
			Firstname='".$_POST['FirstnameFrom']."',
			Lastname='".$_POST['LastnameFrom']."',
			ContactName='".$_POST['Contactname']."',
			Address1='".$_POST['Address1From']."',
			Zip='".$_POST['ZipFrom']."',
			Address2='".$_POST['Address2From']."',
			City='".$_POST['CityFrom']."',
			State='".$_POST['StateFrom']."',
			PhoneNo='".$_POST['PhonenoFrom']."',
			Department='".$_POST['DepartmentFrom']."',
			FaxNo='".$_POST['FaxnoFrom']."',
			addType='ShippingFrom'";
			$results = $this->query($strSqlQuery,1);
			
			}
		}
		if(!empty($_POST['SaveinAddressbookTo'])){
			if($_POST['SaveinAddressbookTo']=='Yes'){
		    	$strSqlQuery="INSERT INTO w_addressbook SET
			Country = '".$_POST['CountryTo']."',
			Company='".$_POST['CompanyTo']."',
			Firstname='".$_POST['FirstnameTo']."',
			Lastname='".$_POST['LastnameTo']."',
			ContactName='".$_POST['ContactNameTo']."',
			Address1='".$_POST['Address1To']."',
			Zip='".$_POST['ZipTo']."',
			Address2='".$_POST['Address2To']."',
			City='".$_POST['CityTo']."',
			State='".$_POST['StateTo']."',
			PhoneNo='".$_POST['PhoneNoTo']."',
			Department='".$_POST['DepartmentTo']."',
			FaxNo='".$_POST['FaxNoTo']."',
			addType='ShippingTo'";
			$results = $this->query($strSqlQuery,1);
			
			}
		}

	}


	function ListShipmentAddressBook($Type){
		if(!empty($Type)){
		$strSqlQuery="SELECT * FROM w_addressbook  WHERE addType='".$Type."' ORDER BY adbID DESC";

		}else{

		 $strSqlQuery="SELECT * FROM w_addressbook  WHERE addType='ShippingTo' ORDER BY adbID DESC";
			
		}
		
		$results = $this->query($strSqlQuery,1);
		return $results;
			
	}

	
	function RemoveAddressBook($adbID){
		$strSQLQuery = "delete from w_addressbook where adbID='".$adbID."'";
		$this->query($strSQLQuery, 0);
		return 1;

	}
	
	function GetAddBookByID($adbID){

		$strSQLQuery = "select * from ".$_SESSION['CmpDatabase'].".w_addressbook where adbID='".$adbID."'";
	
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}

	function ListAddBookByID($adbID){
		global $Config;
		$strSQLQuery = "select w.*,c.country_id,c.code as CountryCode from ".$_SESSION['CmpDatabase'].".w_addressbook w inner join ".$Config['DbMain'].".country c on BINARY w.Country = BINARY c.name where w.adbID='".$adbID."'";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}

	function defaultAddressBook($addType){		
		global $Config;
		 $strSQLQuery="select w.*,c.code as CountryCode,s.code as State from ".$_SESSION['CmpDatabase'].".w_addressbook w inner join ".$Config['DbMain'].".country c on BINARY w.Country = BINARY c.name left outer join ".$Config['DbMain'].".state s on (BINARY w.State = BINARY s.name or BINARY w.State = BINARY s.code) where w.addType='".$addType."' and w.defaultAddress='1' order by w.adbID desc limit 0,1";
		$result = $this->query($strSQLQuery,1);
		return $result;
	}

	function GetStateCode($name, $country_id){
		global $Config;
		$strSQLQuery = "select s.code as StateCode from ".$Config['DbMain'].".state s where s.country_id='".$country_id."' and  LCASE(s.name)='".strtolower(trim($name))."' ";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}

	function GetStateCodeByCountry($state_name, $country_name){
		global $Config;
		 $strSQLQuery = "select s.code as StateCode from ".$Config['DbMain'].".state s inner join ".$Config['DbMain'].".country c on s.country_id=c.country_id where LCASE(c.name)='".strtolower(trim($country_name))."' and  LCASE(s.name)='".strtolower(trim($state_name))."' ";
		$results=$this->query($strSQLQuery,1);
		if(!empty($results[0]["StateCode"])) return $results[0]["StateCode"];
			
	}

			function UpdateAddBook($arryDetails,$adbID){
			
		global $Config;
		extract($arryDetails);
		
                $strSqlQuery="UPDATE w_addressbook SET
		Country = '".$Country."',
		Company='".$Company."',
		Firstname='".$Firstname."',
		Lastname='".$Lastname."',
		ContactName='".$ContactName."',
		Address1='".$Address1."',
		Zip='".$Zip."',
		Address2='".$Address2."',
		City='".$City."',
		State='".$State."',
		PhoneNo='".$PhoneNo."',
		Department='".$Department."',
		FaxNo='".$FaxNo."',
		addType='".$addType."',
		defaultAddress='".$defaultAddress."'
		WHERE adbID='".$adbID."'";
        
		$this->query($strSqlQuery,0);
		
	    if($defaultAddress==1){
	    $strSqlQueryDefault="UPDATE w_addressbook SET
		defaultAddress='0'
		WHERE addType='".$addType."' AND adbID !='".$adbID."'";
	
	    $this->query($strSqlQueryDefault,0);
	    	 	
		}
		
		
		
	}
	

	 function addBookShFrom(){
		 $strSQLQuery = "select adbID,ContactName,City from w_addressbook where addType='ShippingFrom'";
		$results=$this->query($strSQLQuery,1);
		return $results;	
	}

    function addBookShTo(){
		$strSQLQuery = "select adbID,ContactName,City from w_addressbook where addType='ShippingTo'";
		$results=$this->query($strSQLQuery,1);
		return $results;	
	}


	function ShipFromC($countryCode){
		global $Config;
		$strSQLQuery = "select * from ".$Config['DbMain'].".fedex_shipment where countryCode='".$countryCode."'";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}
	
	
	
	
	function fedexPackageType($packageType){
		global $Config;
	    $strSQLQuery = "select * from ".$Config['DbMain'].".fedex_package_type where fdxPackID IN (".$packageType.")";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}
	
	
	function fedexServiceType($serviceType){
		global $Config;
		$strSQLQuery = "select * from ".$Config['DbMain'].".fedex_service_type where fedexID IN (".$serviceType.")";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}
		
	
	
	
		
	function fedexPackageTypeAll(){
		global $Config;
	    $strSQLQuery = "select * from ".$Config['DbMain'].".fedex_package_type ";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}
	
	
	function fedexServiceTypeAll(){
		global $Config;
		$strSQLQuery = "select * from ".$Config['DbMain'].".fedex_service_type ";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}

	function dhlServiceTypeAll(){
		global $Config;
		$strSQLQuery = "select * from ".$Config['DbMain'].".dhl_service_type ";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}


	//---------------------------UPS Start-----------------------------------------------------------------------------------------
	
	
	function UpsShipFromC($countryCode)
	{
		global $Config;
	    $strSQLQuery = "select * from  ".$Config['DbMain'].".ups_shipment where countryCode='".$countryCode."'";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}
	
	
	
	function upsPackageType($packageType){
		global $Config;
	    $strSQLQuery = "select * from ".$Config['DbMain'].".ups_package_type where upsPackID IN (".$packageType.")";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}
	
	
	function upsServiceType($serviceType){
		global $Config;
		 $strSQLQuery = "select * from ".$Config['DbMain'].".ups_service_type where sid IN (".$serviceType.")";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}
		
	
	
	
		
	function upsPackageTypeAll(){
		global $Config;
	    $strSQLQuery = "select * from ".$Config['DbMain'].".ups_package_type ";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}
	
	
	function upsServiceTypeAll()
	{	global $Config;
		$strSQLQuery = "select * from ".$Config['DbMain'].".ups_service_type ";
		$results=$this->query($strSQLQuery,1);
		return $results;
			
	}
	
	//---------------------------UPS End---------------------------------------------------------------------------------------------
		
     function defaultAddress(){
        $strSQLQuery = "select w.*,l.ZipCode,l.City,l.State,l.Country, l.Address, l.country_id, l.city_id, l.state_id, l.OtherState, l.OtherCity from w_warehouse w left outer join w_warehouse_location l on l.WID=w.WID where w.WID = '1'  order by w.WID Asc";
        return $this->query($strSQLQuery, 1);
     }
    
     function defaultFedexShippingMethod(){
	global $Config;
        $strSQLQuery = "select service_type,service_value from ".$Config['DbMain'].".fedex_service_type";
        return $this->query($strSQLQuery, 1);
    }
    
    function defaultFedexPack(){
	global $Config;
        $strSQLQuery = "select package_type,package_type_value from ".$Config['DbMain'].".fedex_package_type";
        return $this->query($strSQLQuery, 1);
    }
    
    
     function defaultUPSShippingMethod(){
		global $Config;
        $strSQLQuery = "select service_type,service_value from ".$Config['DbMain'].".ups_service_type";
        return $this->query($strSQLQuery, 1);
    }
    
    function defaultUPSPack(){
	global $Config;
        $strSQLQuery = "select package_type,package_type_value from ".$Config['DbMain'].".ups_package_type";
        return $this->query($strSQLQuery, 1);
    }
    
    
     function defaultUSPSShippingMethod(){
	global $Config;
        $strSQLQuery = "select service_type,service_value from ".$Config['DbMain'].".usps_service_type";
        return $this->query($strSQLQuery, 1);
    }

    function defaultUSPSMailtype(){
	global $Config;
        $strSQLQuery = "select mail_type,mail_type_value from ".$Config['DbMain'].".usps_mail_type";
        return $this->query($strSQLQuery, 1);
    }
    
    function defaultUSPSPackageSize(){
	global $Config;
        $strSQLQuery = "select pack_size_type,pack_size_value from ".$Config['DbMain'].".usps_package_size_type";
        return $this->query($strSQLQuery, 1);
    }

	///// madhurendra 16 may 2016
	
	 function ListShipmentAPIDetail(){
			$strSqlQuery="SELECT * FROM w_shipping_credential";
			$results = $this->query($strSqlQuery,1);
			return $results;
			
		}
		
	 function ListShipmentAPIDetailById($id){
			$strSqlQuery="SELECT * FROM w_shipping_credential where id='".$id."'";
			$results = $this->query($strSqlQuery,1);
			return $results;
			
		}
		
		
	 function UpdateShipmentAPIDetail($arryDetails,$id){
	 	    extract($arryDetails);
			$strSQLQuery = "UPDATE w_shipping_credential SET api_key = '".$api_key."',api_password = '".$api_password."',api_account_number = '".$api_account_number."',api_meter_number = '".$api_meter_number."',SourceZipcode = '".$SourceZipcode."' where id='".$id."'";
			$this->query($strSQLQuery,0);
			
		}

	 function ListShipmentAPIDetailByName($name){
			$strSqlQuery="SELECT * FROM w_shipping_credential where api_name='".$name."'";
			$results = $this->query($strSqlQuery,1);
			return $results;
			
		}

	function CountSaleBatches($batchId){


			 $strSqlQuery="SELECT count(OrderID) as NumCount FROM s_order where batchId='".$batchId."' and Module='Shipment'"; 
			$results = $this->query($strSqlQuery,1);
if($results[0]['NumCount']!=''){
			return $results[0]['NumCount'];
}else{
return 0;
}

	}

function CountInvoiceBatches($batchId){


			$strSqlQuery="SELECT count(OrderID) as NumCount FROM s_order where batchId='".$batchId."' and Module='Shipment' and InvoiceID!=''";
			$results = $this->query($strSqlQuery,1);
			if($results[0]['NumCount']!=''){
			return $results[0]['NumCount'];
}else{
return 0;
}

	}

 /*     * *start code for batchpdf by sachin*** */
//updated by chetan for INVOICEID on 4Apr2017//
    function GetBatchShippment($batchid) {
        $SqlQuery = "SELECT OrderID,InvoiceID FROM `s_order` where `batchId`='".$batchid."' and Module='Invoice' ORDER BY `OrderID` DESC";
        $results = $this->query($SqlQuery, 1);
        return $results;
    }

    /*     * *End code for batchpdf by sachin*** */
/*added by chetan 7June*/    
    function GetShippStatusByBatchIds($batchId)
    {    
        $SqlQuery = "select * from s_order o left join w_shipment s on o.OrderID=s.ShippedID where o.batchId = '".$batchId."' and s.ShipmentStatus <> 'Shipped' ";
        $res = $this->query($SqlQuery, 1);
        return (empty($res)) ?  false  :  true ;
    }
    /*End*/


 
	function DeleteFedexShip($trackingId){
		
		if($trackingId>0){
			global $Config;
			$objFunction=new functions();

			$ApiPath = '../shipping/';
			$strQuery="SELECT ShipType,sendingLabel,label,LabelChild from w_shipment WHERE trackingId='".$trackingId."'";  
			$arryShippInfo=$this->query($strQuery,1);

			
			$LabelFolder = strtolower($arryShippInfo[0]["ShipType"])."/";
   			$LabelPath = "../shipping/upload/".$LabelFolder.$_SESSION['CmpID']."/";
   	
			if($arryShippInfo[0]['label'] !=''){				
				$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$arryShippInfo[0]['label']);
			} 			 
   			 
   			if($arryShippInfo[0]['sendingLabel'] !=''){
   				$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$arryShippInfo[0]['sendingLabel']);
   			}
   	
			if($arryShippInfo[0]['LabelChild'] !='' ){ 
				$LabelChildArry = explode("#",$arryShippInfo[0]['LabelChild']);
				foreach($LabelChildArry as $childlabel){
					if($childlabel !='' ){ 
						$objFunction->DeleteDocStorage($LabelPath, $LabelFolder,$childlabel);
					}
				}
			}

		
			$strSQLQuery = "update  w_shipment set label ='',trackingId='',totalFreight='',COD='',sendingLabel='',ShipType='',LabelChild='' where trackingId='".$trackingId."'";
			$this->query($strSQLQuery, 0);


			/*$strSQLQuery = "update  s_order set TrackingNo='' where Module='Invoice' and TrackingNo='".$trackingId."' "; 	
			$this->query($strSQLQuery, 0);*/

		}
	
		return 1;

	}

 function defaultDHLPack(){
	global $Config;
        $strSQLQuery = "select service_type,service_value from ".$Config['DbMain'].".dhl_packages_type order by sid";
        return $this->query($strSQLQuery, 1);
    }

function dhlSpecialService(){
	global $Config;
        $strSQLQuery = "select * from ".$Config['DbMain'].".dhl_special_service_type order by sid";
        return $this->query($strSQLQuery, 1);
    }


function getCountryNameByCode($code){
        $strSQLQuery = "SELECT name FROM erp.country where code= '".$code."' limit 0,1";
        return $this->query($strSQLQuery, 1);
    }

		function CounchildItem($ItemID,$OrderID){
					$strSQLQuery = "SELECT count(*) as child FROM s_order_item where parent_item_id= '".$ItemID."' and OrderID ='".$OrderID."' ";
					$rs = $this->query($strSQLQuery, 1);
					if(!empty($rs[0]['child'])&& $rs[0]['child']>0){
					  return $rs[0]['child'];
					}else{
					  return 0;
					}
    }


	function isShipmentNumberExists($ShippedID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" AND OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "SELECT OrderID from s_order where Module='Shipment' AND ShippedID = '".trim($ShippedID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}

   function GetShippingStatusImg($code,$type){
	if(!empty($code) && !empty($type)){
		global $Config;
		$strSQLQuery = "select img from  ".$Config['DbMain'].".shipping_status_code where LCASE(code)='".strtolower(trim($code))."' and LCASE(type)='".strtolower(trim($type))."' ";
		$arryRow = $this->query($strSQLQuery, 1);
		return $arryRow[0]['img'];
	}
    }


function CheckSerialCost($Sku,$Serial,$Condition,$WID){


$objItem=new items();		
$checkProduct=$objItem->checkItemSku($Sku);
		//By Chetan 9sep// 
		if(empty($checkProduct))
		{
		$arryAlias = $objItem->checkItemAliasSku($Sku);
			if(count($arryAlias))
			{
					$Mainsku = $arryAlias[0]['sku'];				
			}
		}else{
     $Mainsku = $Sku;
    }
				$serial_no = explode(",",$Serial);
				$resultSr = "'" . implode ( "', '", $serial_no ) . "'";
				 $strSQLQuery = " select SUM(UnitCost) as Cost from inv_serial_item where serialNumber IN (".$resultSr.") and Sku ='".$Mainsku."' and `Condition` = '".$Condition."' and warehouse ='".$WID."' and Status='1'  and UsedSerial='0'"; 
				$arryRow = $this->query($strSQLQuery, 1);
				return $arryRow[0]['Cost'];


}


 function ShipOrderQtyUpdate($arryDetails)	{



			global $Config;
			extract($arryDetails);
for($i=1;$i<=$NumLine;$i++){

	if(!empty($arryDetails['sku'.$i])){

					
      if($arryDetails['DropshipCheck'.$i]==1){
						$DropshipCheck = 1;$serial_value='';
			}else{
						$DropshipCheck = 0;
						$serial_value=trim($arryDetails['serial_value'.$i]);
			}

	if($arryDetails['id'.$i]>0 && !empty($arryDetails['shipID'])){

$Totamount = $arryDetails['price'.$i]*$arryDetails['qty'.$i];

/*if($serial_value!=''){
  $SerialCost =  $this->CheckSerialCost($arryDetails['sku'.$i],$serial_value,$arryDetails['Condition'.$i],$arryDetails['WID'.$i]);
$arryDetails['avgCost'.$i] = $SerialCost/$arryDetails['qty'.$i];
}*/


$id= $arryDetails['id'.$i];

			  $sql = "update s_order_item set avgCost = '".$arryDetails['avgCost'.$i]."',price='".$arryDetails['price'.$i]."',amount ='".$Totamount."', SerialNumbers='".addslashes($serial_value)."',qty_shipped='".$arryDetails['qty'.$i]."',bin='".$arryDetails['bin'.$i]."'  where id='".$arryDetails['id'.$i]."'";   

$this->query($sql, 0);

}


/*********Added By bhoodev based on Condition 6 june 2016*********************/

$objItem=new items();
$checkProduct=$objItem->checkItemSku($arryDetails['sku'.$i]);

		//By Chetan 9sep// 
		if(empty($checkProduct))
		{
		$arryAlias = $objItem->checkItemAliasSku($arryDetails['sku'.$i]);
			if(count($arryAlias))
			{
					$mainSku = $arryAlias[0]['sku'];			
			}
		}else{

$mainSku = $arryDetails['sku'.$i];
}

if ($serial_value != '' ) {
      //$serial_no = explode(",",trim($serial_value));
	$serial_no = explode(",",$serial_value);
				$resultSr = "'" . implode ( "', '", $serial_no ) . "'";

      //for ($j = 0; $j < sizeof($serial_no); $j++) {
             
			//$strSQL = "update inv_serial_item set UsedSerial = '1' where serialNumber='".$serial_no[$j]."' and Sku ='" . addslashes($arryItem[$Count]["sku"]) ."' and `Condition` = '".addslashes($arryItem[$Count]["Condition"])."'"; 
//$strSQL = "update inv_serial_item set UsedSerial = '1' where serialNumber IN(".$resultSr.") and Sku ='" . addslashes($mainSku) ."' and `Condition` = '".$arryDetails['Condition'.$i]."' and warehouse='".$arryDetails['WID'.$i]."' and disassembly='0' and UsedSerial = '0'   "; 
							//$this->query($strSQL, 0);

      //}

}

if($ShipStatus=='Shipped' && (empty($arryDetails['DropshipCheck'.$i]) && $arryDetails['DropshipCheck'.$i]!=1) ){
					if($arryDetails['Condition'.$i]!=''){
						 $sqlCond="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($mainSku) . "' and ItemID='" . addslashes($arryDetails['item_id'.$i]) . "'
						and `condition`='".addslashes($arryDetails['Condition'.$i])."' and WID='".$arryDetails['WID'.$i]."' "; 
						$restbl=$this->query($sqlCond, 1);
						if($restbl[0]['total']>0){
							
							// update in tbl
							$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty'.$i] . ",SaleQty = SaleQty-".$arryDetails['qty'.$i]."  where Sku='" . $mainSku . "' and `Condition` ='".$arryDetails['Condition'.$i]."' and WID='".$arryDetails['WID'.$i]."'";
							$this->query($UpdateQtysql, 0);
						}
					}



//Update Item
					$sqlSelect = "select qty_shipped from s_order_item where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qty_shipped = $arrRow[0]['qty_shipped'];
					$qty_shipped = $qty_shipped+$arryDetails['qty'.$i];
					$sqlupdate = "update s_order_item set qty_shipped= '".$qty_shipped."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					//$this->query($sqlupdate, 0);	
					//end code

}

/*********end By bhoodev based on Condition 6 june 2016*********************/


}


	




}

				


			
}



	function GetCutomerShipment($CustCode,$batchId,$OrderIDs,$NotOrderID){
		if(!empty($CustCode)){
			$strAddQuery = '';
			$strAddQuery .= (!empty($batchId))?(" and o.batchId='".$batchId."'"):("");
			$strAddQuery .= (!empty($OrderIDs))?(" and o.OrderID in (".$OrderIDs.")"):("");
			$strAddQuery .= (!empty($NotOrderID))?(" and o.OrderID not in (".$NotOrderID.")"):("");

			$strSQLQuery = "select o.ShippedDate,s.ShipmentDate, o.ShippedID as ShippingID,o.OrderDate, o.InvoiceDate, o.OrderID, o.SaleID, o.TotalAmount, o.CustomerCurrency,ShipmentStatus from s_order o left join w_shipment s on o.OrderID=s.ShippedID where o.Module='shipment' and PostToGL!='1' and (trackingId ='' and label='') and o.CustCode= '".$CustCode."' ".$strAddQuery." order by o.ShippedDate desc";
			

			return $this->query($strSQLQuery, 1);	
		}
	
	}
	function GetShipmentID($ShippedID){
		if(!empty($ShippedID)){
			$strSQLQuery = "select ShipmentID from w_shipment where ShippedID= '".$ShippedID."' ";			
			$arrRow = $this->query($strSQLQuery, 1);
			return $arrRow[0]['ShipmentID'];
		}
	
	}

	function UpdateFreightShipment($OrderID,$ShipFreight){
		//Run only if label is generated
		if(!empty($OrderID) && !empty($_SESSION['Shipping']['ShipType'])){
			$strSQLQuery = "select Freight, TotalAmount, InvoiceID from s_order where OrderID= '".$OrderID."' ";			
			$arrRow = $this->query($strSQLQuery, 1);
			$Freight = round($arrRow[0]['Freight'],2);
			$ShipFreight = round($ShipFreight,2);
			$InvoiceID = $arrRow[0]['InvoiceID'];
			if($Freight!=$ShipFreight){
				$TotalAmount = ($arrRow[0]['TotalAmount'] - $Freight) + $ShipFreight;
				$sqlupdate = "update s_order set Freight= '".$ShipFreight."', TotalAmount= '".$TotalAmount."' , TotalInvoiceAmount= '".$TotalAmount."' where OrderID = '".$OrderID."' ";
				$this->query($sqlupdate, 0);	
				if(!empty($InvoiceID)){
					$sqlupdate2 = "update s_order set Freight= '".$ShipFreight."', TotalAmount= '".$TotalAmount."', TotalInvoiceAmount= '".$TotalAmount."'  where InvoiceID = '".$InvoiceID."' and Module='Invoice' ";
					$this->query($sqlupdate2, 0);	
				}
	
			}			
			return true;
		}
	
	}


	function UpdateFreightInInvoice($ShipOrderID){
		//Run only if label is generated
		//if(!empty($ShipOrderID)){
		if(!empty($ShipOrderID) && !empty($_SESSION['Shipping']['ShipType'])){
			//Shipment Data
			$strSQLQuery = "select Freight, ActualFreight, InvoiceID from s_order where OrderID= '".$ShipOrderID."' ";			
			$arrShip = $this->query($strSQLQuery, 1);
			$ShipFreight = round($arrShip[0]['Freight'],2);
			$ActualFreight = round($arrShip[0]['ActualFreight'],2);
			$InvoiceID = $arrShip[0]['InvoiceID'];

			if(!empty($InvoiceID)){
				$strSQL = "select OrderID, Freight, InvoiceID, TotalInvoiceAmount from s_order where InvoiceID= '".$InvoiceID."' and Module='Invoice'";		
				$arrInv = $this->query($strSQL, 1);

				 
				if(!empty($arrInv[0]['InvoiceID'])){
					$TotalAmount = ($arrInv[0]['TotalInvoiceAmount'] - $arrInv[0]['Freight']) + $ShipFreight;
					$TotalAmount = round($TotalAmount,2);
					//Update Invoice
					$sqlupdate2 = "update s_order set Freight= '".$ShipFreight."', ActualFreight= '".$ActualFreight."', TotalAmount= '".$TotalAmount."', TotalInvoiceAmount= '".$TotalAmount."',ShipAccountNumber='".$_SESSION['Shipping']['ShipAccountNumber']."'  where InvoiceID = '".$InvoiceID."' and Module='Invoice' ";
					$this->query($sqlupdate2, 0);	


					/*******Generate PDF************/
					$objConfigure = new configure();			
					$PdfArray['ModuleDepName'] = "SalesInvoice";
					$PdfArray['Module'] = "Invoice";
					$PdfArray['ModuleID'] = "InvoiceID";
					$PdfArray['TableName'] =  "s_order";
					$PdfArray['OrderColumn'] =  "OrderID";
					$PdfArray['OrderID'] =  $arrInv[0]['OrderID'];
					$PdfArray['UploadPrefix'] =  "../finance/";
					$objConfigure->GeneratePDF($PdfArray);
					/*******************************/
				}
	
			}			
			return true;
		}
	
	}

function UpdateFreightInEDIPO($ShipOrderID){
		//Run only if label is generated
		//if(!empty($ShipOrderID)){
		if(!empty($ShipOrderID)){
			//Shipment Data
			$strSQLQuery = "select Freight, ActualFreight, InvoiceID,EDICompId,EDIRefNo,EDICompName from s_order where OrderID= '".$ShipOrderID."' ";			
			$arrShip = $this->query($strSQLQuery, 1);
		#	pr($arrShip); exit;
			$ShipFreight = round($arrShip[0]['Freight'],2);
			$ActualFreight = round($arrShip[0]['ActualFreight'],2);
			$InvoiceID = $arrShip[0]['InvoiceID'];
			if($arrShip[0]['EDICompName']!='' && $arrShip[0]['EDICompId']>0){
			$DbName = "erp_".$arrShip[0]['EDICompName'].".";
			$expolearry  =explode("/",$arrShip[0]['EDIRefNo']);
		#	print_r($expolearry);
			$PoID =$expolearry[3];
			$PUrcID =$expolearry[4];
			}

			if($arrShip[0]['EDICompName']!='' && $arrShip[0]['EDICompId']){
				$strSQL = "select OrderID, Freight, InvoiceID, TotalInvoiceAmount from s_order where InvoiceID= '".$InvoiceID."' and Module='Invoice'";		
				$arrInv = $this->query($strSQL, 1);

				 
				if(!empty($arrInv[0]['InvoiceID'])){
					$TotalAmount = ($arrInv[0]['TotalInvoiceAmount'] - $arrInv[0]['Freight']) + $ShipFreight;
					$TotalAmount = round($TotalAmount,2);
					//Update Invoice
					 $sqlupdate2 = "update ".$DbName."p_order set Freight= '".$ShipFreight."',  TotalAmount= '".$TotalAmount."', TotalInvoiceAmount= '".$TotalAmount."'  where OrderID = '".$PoID."' and PurchaseID ='".$PUrcID."' and Module='Order' "; 
					$this->query($sqlupdate2, 0);	

				}
	
			}			
			return true;
		}
	
	}



	
	function UpdatePicking($arryDetails){ 
			global $Config;
			extract($arryDetails);

$PickID = "PICK".$OrderID;
$strUpdateQuery = "update s_order set PickID='".$PickID."',PickStatus = '".$PickStatus."', Freight='".$Freight."', TotalAmount='".$TotalAmount."',  PickDate = '".$PickDate."',  taxAmnt = '".$taxAmnt."'		where OrderID='".$OrderID."'"; 
$this->query($strUpdateQuery, 0);

$strSQLQuery = "delete from w_picking where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);


$sqlAddQuery = "INSERT INTO w_picking SET 
								OrderID   ='".$OrderID."',
								CreatedBy = '".addslashes($_SESSION['UserName'])."',
								AdminID='".$_SESSION['AdminID']."',
								AdminType='".$_SESSION['AdminType']."',
								CreatDate ='".$Config['TodayDate']."'";
$this->query($sqlAddQuery, 0);


}


 function PickOrderQtyUpdate($arryDetails)	{



			global $Config;
			extract($arryDetails);
for($i=1;$i<=$NumLine;$i++){

	if(!empty($arryDetails['sku'.$i])){

					
      if($arryDetails['DropshipCheck'.$i]==1){
						$DropshipCheck = 1;$serial_value='';
			}else{
						$DropshipCheck = 0;
						$serial_value=trim($arryDetails['serial_value'.$i]);
			}

$Sku = $arryDetails['sku'.$i];


	if($arryDetails['id'.$i]>0 && !empty($arryDetails['OrderID'])){

$Totamount = $arryDetails['price'.$i]*$arryDetails['qty'.$i];
$objItem=new items();		
$checkProduct=$objItem->checkItemSku($Sku);
		//By Chetan 9sep// 
		if(empty($checkProduct))
		{
		$arryAlias = $objItem->checkItemAliasSku($Sku);
			if(count($arryAlias))
			{
					$Sku = $arryAlias[0]['sku'];				
			}
		}else{
     $Sku = $Sku;
    }
if($serial_value!=''){
 // $SerialCost =  $this->CheckSerialCost($arryDetails['sku'.$i],$serial_value,$arryDetails['Condition'.$i],$arryDetails['WID'.$i]);


				$serial_no = explode(",",$Serial);
				$resultSr = "'" . implode ( "', '", $serial_no ) . "'";
				  $strSQLQuery = " select SUM(UnitCost) as Cost from inv_serial_item where serialNumber IN (".$resultSr.") and Sku ='".$Sku."' and `Condition` = '".$arryDetails['Condition'.$i]."' and warehouse ='".$arryDetails['WID'.$i]."' and Status='1'  and LineID='".$arryDetails['id'.$i]."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
				$SerialCost =  $arryRow[0]['Cost'];







if($SerialCost>0){
$arryDetails['avgCost'.$i] = $SerialCost/$arryDetails['qty'.$i];
}
}


$id= $arryDetails['id'.$i];


			  $sql = "update s_order_item set avgCost = '".$arryDetails['avgCost'.$i]."',price='".$arryDetails['price'.$i]."',amount ='".$Totamount."', SerialNumbers='".addslashes($serial_value)."',qty_picked='".$arryDetails['qty'.$i]."',bin='".$arryDetails['bin'.$i]."'  where id='".$arryDetails['id'.$i]."'";   

$this->query($sql, 0);

if($serial_value!=''){
 $strSQL = "update inv_serial_item set UsedSerial = '1',OrderID='".$arryDetails['OrderID']."' where serialNumber IN (".$resultSr.") and Sku ='" . addslashes($Sku) ."' and `Condition` = '".$arryDetails['Condition'.$i]."' and warehouse='".$arryDetails['WID'.$i]."' and  LineID='".$arryDetails['id'.$i]."' "; 
														$this->query($strSQL, 0);
}


}


/*********Added By bhoodev based on Condition 6 june 2016*********************/


 //if ($serial_value != '' ) {
                   // $serial_no = explode(",",trim($serial_value));

                    //for ($j = 0; $j < sizeof($serial_no); $j++) {
                           
 

                    //}



//}



					
					$sqlupdate = "update s_order_item set qty_shipped= '".$arryDetails['qty'.$i]."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					
$this->query($sqlupdate, 0);

}


	




}

/*	$sqlComSelect = "select SUM(avgCost) as TotCost,parent_item_id from s_order_item where  parent_item_id>0 and OrderID='".$arryDetails['OrderID']."' group by parent_item_id";
$arrRowCost = $this->query($sqlComSelect, 1);
if(sizeof($arrRowCost)>0){
foreach($arrRowCost as $key=>$valCom){

$updateKit = "update s_order_item set avgCost = avgCost+".$valCom['TotCost']." where  parent_item_id='0' and OrderID='".$arryDetails['OrderID']."' and item_id='".$valCom['parent_item_id']."'";
					$this->query($updateKit, 0);

}		*/	


			
}

 
/**************** madhurendra singh yadav************************/

function AddShipAcoount($arryDetails){
		
		extract($arryDetails);
		
		if($defaultVal==1){
			$strSQLQueryUpdate = "update w_shipping_credential SET defaultVal = '0' where api_name='".addslashes($api_name)."'";

   			$this->query($strSQLQueryUpdate, 0);

		}
   		$strSQLQuery = "INSERT INTO w_shipping_credential SET api_key = '".addslashes($api_key)."',api_password = '".addslashes($api_password)."',api_account_number = '".addslashes($api_account_number)."',api_meter_number = '".addslashes($api_meter_number)."',api_name = '".addslashes($api_name)."',SourceZipcode = '".addslashes($SourceZipcode)."',defaultVal = '".addslashes($defaultVal)."',fixed = '".addslashes($fixed)."',live = '".addslashes($live)."',SuppCode = '".addslashes($SuppCode)."'";

   		$this->query($strSQLQuery, 0);
	   		
   	}
   	
   	
function isShippingAccountExists($AcNumber,$editID){
		
	if(!empty($editID)){
		$str = "and id not in ('".$editID."')";
	}
		if(!empty($AcNumber)){
			$strSQLQuery = "select id,api_account_number from  w_shipping_credential where api_account_number='".addslashes($AcNumber)."' $str";
 			$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['api_account_number'])) {
					return true;
				} else {
					return false;
			}
	   		
   	}
}

function UpdateShipAcoount($arryDetails,$id){
		
		extract($arryDetails);
		
	if($defaultVal==1){
			$strSQLQueryUpdate = "update w_shipping_credential SET defaultVal = '0' where api_name='".addslashes($api_name)."'";
   			$this->query($strSQLQueryUpdate, 0);
		}
		
   		$strSQLQuery = "update w_shipping_credential SET api_key = '".addslashes($api_key)."',api_password = '".addslashes($api_password)."',api_account_number = '".addslashes($api_account_number)."',api_meter_number = '".addslashes($api_meter_number)."',api_name = '".addslashes($api_name)."',SourceZipcode = '".addslashes($SourceZipcode)."',defaultVal = '".addslashes($defaultVal)."',fixed = '".addslashes($fixed)."',SuppCode = '".addslashes($SuppCode)."'  where id='".$id."'";

   		$this->query($strSQLQuery, 0);
	   		
   	}
   	
   	
  function DeleteShipAcoount($id){
  	
  	if(!empty($id)){
  		$strSQLQuery = "delete from w_shipping_credential where id='".$id."'";
		$this->query($strSQLQuery, 0);
		return 1;
  	 }

	}
	
	function GetShipAcoountById($id){
		if(!empty($id)){
	    $strSQLQuery = "select * from w_shipping_credential where id='".$id."'";
		$results= $this->query($strSQLQuery, 1);
		return $results;
		}
		
		
	}
	
	
	function ListShipAccount($Type,$SuppCode=''){
		if(!empty($Type)){
		$strAddQuery = (!empty($SuppCode))?(" and SuppCode='".mysql_real_escape_string($SuppCode)."'"):("");
		$strSqlQuery="SELECT * FROM w_shipping_credential  WHERE api_name='".$Type."' ".$strAddQuery."  ORDER BY defaultVal='1' DESC";

		}else{

		 $strSqlQuery="SELECT * FROM w_shipping_credential WHERE LOWER(api_name) = 'fedex' ".$strAddQuery." ORDER BY defaultVal='1' DESC";
			
		}
	
		$results = $this->query($strSqlQuery,1);
		return $results;
			
	}
	
	function ListMultilpleShipAccount($name){
	     if(!empty($name)){
		    $strSqlQuery="SELECT * FROM w_shipping_credential where LOWER(api_name) ='".strtolower($name)."' ORDER BY defaultVal='1' DESC";
			$results = $this->query($strSqlQuery,1);
			return $results;
	        }

		}
		
	function ShipAccountByACNumber($AccountNumber,$name){ 
	 
	      if(!empty($AccountNumber) && !empty($name)){

		     if(strtolower($name)=='ups'){
				$addsql = " and api_meter_number='".$AccountNumber."'"; 
		     }else{
				$addsql = " and api_account_number='".$AccountNumber."'"; 
		     }

		     $strSqlQuery="SELECT * FROM w_shipping_credential where LOWER(api_name)='".strtolower($name)."' ".$addsql;


			$results = $this->query($strSqlQuery,1);
			return $results;
	        }

	}
		
function ShipAccountByDeault($name){
			$strSqlQuery="SELECT * FROM w_shipping_credential where LOWER(api_name) ='".strtolower($name)."' and defaultVal = '1'";
			$results = $this->query($strSqlQuery,1);
			return $results;
			
		}
	
	function GetCustShipAccount($Type,$CustID){
		if(!empty($Type)){
			$strSqlQuery="SELECT * FROM s_customer_shipping  WHERE LOWER(api_name)='".strtolower($Type)."' and CustID= '".$CustID."'  ORDER BY defaultVal='1' DESC";
				 
				$results = $this->query($strSqlQuery,1);
				return $results;
		}
		
			
	}
/**************** madhurendra singh yadav************************/




}?>
