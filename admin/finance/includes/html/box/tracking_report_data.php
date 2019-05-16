<?
// pr($arryData,1);
$content = '<table '.$table_bg.'>
	<tr align="left"  >';

$content .= '<td width="10%" class="head1">Tracking Number</td>	
	<td width="9%" class="head1">Source</td>
	<td width="8%" class="head1">Ref #</td>
	<td width="8%" class="head1">Invoice #</td>
	<td width="8%" class="head1">SO #</td>		
	<td width="8%" class="head1">PO #</td>
	<td width="10%" class="head1">Customer</td>
	<td width="10%" class="head1">Vendor</td>		
	<td width="8%" class="head1">Ship Date</td>	
	<td class="head1">Shipping Method</td>	
	<td class="head1" width="7%">Freight</td>
	</tr>';
$ShippingPrefix = '../shipping/';
if(is_array($arryData) && $num>0){	 
	$Line=0;	
	foreach($arryData as $key=>$values){			 
		$Line++;		
		$Freight = $values['Freight'];			 		
		$Currency = $values["Currency"];		
		$ConversionRate=1;		
		if($Currency!=$Config['Currency']){
			$ConversionRate = $values['ConversionRate'];			   
		}	
		/**********Conversion & Total**************/ 	       
		$FreightBS = round(GetConvertedAmount($ConversionRate, $Freight),2);		   	 
       		/*************************************/
		$RefID= $InvoiceID=$SaleID=$PO=$ShippedDate=$FreightVal=$ShippingMethodVal='';
		$CustomerName = $VendorName = '';

		$RefID = $values['RefID'];




		if(!empty($ExportFile)){
			if($values['Section']=='VP'){		
				$VendorName = stripslashes($values["VendorName"]);
			}else if($values['Section']=='P'){				
				/*****AP*********/
				$VendorName = stripslashes($values["VendorName"]);
				$SaleID = $values["SaleID"];
				$PO = $values["PurchaseID"];
				if($values["OrderType"]=="Dropship" && $values["wName"]!=''){
					$CustomerName = stripslashes($values["wName"]);
				}
				if($values['Module']=='Order'){
					$ModuleDate = $values['OrderDate'];					
				}else{
					$ModuleDate = $values['InvoiceDate'];
					$InvoiceID = $values['InvoiceID'];				
						 
				}
				
			}else{					 
				/*****AR*********/
				$CustomerName = stripslashes($values["CustomerName"]);
				$PO = $values["PurchaseID"];
				$SaleID = $values["SaleID"];		
				if($values['Module']=='Order'){
					$ModuleDate = $values['OrderDate'];				
				}else{
					$ModuleDate = $values['InvoiceDate'];
					$InvoiceID = $values['InvoiceID'];				
				}
				
			}			
			 
		}else{
			if($values['Section']=='VP'){		
				$VendorName = '<a class="fancybox fancybox.iframe" href="suppInfo.php?view='.$values['SuppCode'].'" >'.stripslashes($values["VendorName"]).'</a>';
			}else if($values['Section']=='P'){
				/******AP********/
				$VendorName = '<a class="fancybox fancybox.iframe" href="suppInfo.php?view='.$values['SuppCode'].'" >'.stripslashes($values["VendorName"]).'</a>';
				$SaleID = $values["SaleID"];
				$PO = $values["PurchaseID"];
				if($values["OrderType"]=="Dropship" && $values["wName"]!=''){
					$CustomerName = stripslashes($values["wName"]);
				}
				if(!empty($PO)){
					$PO = '<a class="fancybox fancybig fancybox.iframe" href="../purchasing/vPO.php?po='.$values['PurchaseID'].'&module=Order&pop=1">'.$values["PurchaseID"].'</a>';
				}			
				if($values['Module']=='Order'){
					$ModuleDate = $values['OrderDate'];					
				}else{
					$ModuleDate = $values['InvoiceDate'];
					$InvoiceID = '<a href="vPoInvoice.php?pop=1&amp;inv='.$values['InvoiceID'].'" class="fancybox fancybig fancybox.iframe">'.$values['InvoiceID'].'</a>';					
				}
								
			}else{
				/*****AR*********/
				$CustomerName = '<a class="fancybox fancybox.iframe" href="../custInfo.php?CustID='.$values['CustID'].'" >'.stripslashes($values["CustomerName"]).'</a>';
				$PO = $values["PurchaseID"];
				$SaleID = $values["SaleID"];
				if(!empty($SaleID)){
					$SaleID = '<a class="fancybox fancybig fancybox.iframe" href="../sales/vSalesQuoteOrder.php?so='.$values['SaleID'].'&module=Order&pop=1">'.$values["SaleID"].'</a>'; 
				}
				if($values['Module']=='Order'){
					$ModuleDate = $values['OrderDate'];					
				}else{
					$ModuleDate = $values['InvoiceDate'];
					$InvoiceID = '<a href="vInvoice.php?pop=1&amp;inv='.$values['InvoiceID'].'" class="fancybox fancybig fancybox.iframe">'.$values['InvoiceID'].'</a>';
				
				}
				/**************/
			}

		}		
		/******************************/

	if($values["ShippedDate"]>0)$ShippedDate = date($Config['DateFormat'], strtotime($values["ShippedDate"]));

	if($Freight>0)$FreightVal = number_format($Freight,2).' '.$Currency;

	$ShippingMethod = stripslashes($values["ShippingMethod"]);
	if(!empty($values['ShippingMethodVal'])){		
		$arryShipMethodName = $objConfigure->GetShipMethodName($values['ShippingMethod'],$values['ShippingMethodVal']);
		$ShippingMethodVal = (!empty($arryShipMethodName[0]['service_type']))?(stripslashes($arryShipMethodName[0]['service_type'])):('');
		$ShippingMethodVal = '<br>['.$ShippingMethodVal.']';
	}
	 
	$TrackingNo ='';$TrackingNoDisplay='';
	if(!empty($values['TrackingNo'])){	
		$ShipType = strtolower(trim($ShippingMethod));
		
		$TrackingNo = stripslashes(trim($values['TrackingNo']));
		$TrackingNo = str_replace(";",":",$TrackingNo); 
		$TrackingNoArray = explode(":",$TrackingNo);
		$TracknoArr = array();



		foreach($TrackingNoArray as $TrackingNoTemp) {
			$TrackingNoVal = $TrackingNoTemp;

			if(!empty($ShipType) && empty($ExportFile)){
				if($ShipType=='fedex'){
					$TrackingNoVal = "<a href='".$ShippingPrefix."tracking.details.php?view=".$TrackingNoTemp."' class='fancybox fancybox.iframe'>".$TrackingNoTemp."</a>";
				}elseif ($ShipType=='ups'){
					$TrackingNoVal = "<a href='".$ShippingPrefix."upstracking.details.php?view=".$TrackingNoTemp."' class='fancybox fancybox.iframe'>".$TrackingNoTemp."</a>";
				}elseif($ShipType=='dhl'){
					$TrackingNoVal = "<a href='".$ShippingPrefix."dhltracking.details.php?view=".$TrackingNoTemp."' class='fancybox fancybox.iframe'>".$TrackingNoTemp."</a>";
				}elseif($ShipType=='usps'){
					$TrackingNoVal = "<a href='".$ShippingPrefix."uspstracking.details.php?view=".$TrackingNoTemp."' class='fancybox fancybox.iframe'>".$TrackingNoTemp."</a>";

				} 
			}
			$TracknoArr[] = $TrackingNoVal;
		}

		
		if(!empty($TracknoArr[0]))
			$TrackingNoDisplay = implode(", ",$TracknoArr);
	

	}

	if($values['Section']=="VP"){
		$Section = "Vendor Payment";
	}else{
		$Section = ($values['Section']=='P')?("Purchase ".$values['Module']):("Sale ".$values['Module']);
	}

  	$content .= '<tr align="left">
		<td>'.$TrackingNoDisplay.'</td>
		<td>'.$Section.'</td>	
		<td>'.$RefID.'</td>	
		<td>'.$InvoiceID.'</td>
		<td>'.$SaleID.'</td>
		<td>'.$PO.'</td>
  		<td>'.$CustomerName.'</td>		
		<td>'.$VendorName.'</td>	
		<td>'.$ShippedDate.'</td>	
		<td><b>'.$ShippingMethod.'</b>'.$ShippingMethodVal.'</td> 
		<td>'.$FreightVal.'</td>	
		</tr>';	
	 
      	} 
	 	 
	 $content .= '<tr align="center" >
		<td  colspan="11"  > </td>
		</tr>';

	}else{
		$content .= '<tr align="center" >
		<td  colspan="11" class="no_record">'.NO_RECORD.'</td>
		</tr>';
	}  		 
	$content .= '</table>';
		 
if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}


?>

