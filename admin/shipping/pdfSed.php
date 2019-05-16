<?
	require_once("../includes/pdf_comman.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/region.class.php");
	$objShipment = new shipment();
	$objSale = new sale();
 	$objRegion = new region();

	if(!empty($_GET['ShippedID'])){	
			 
           	    	$arrySED = $objShipment->listingShipmentDetail($_GET['ShippedID']);

           		$MultipleOrderID =  $arrySED[0]['MultipleOrderID'];
			$Multiple =  $arrySED[0]['Multiple'];

			/************************/
			if($Multiple==1 && !empty($MultipleOrderID)){ //Parent
				//echo $MultipleOrderID;
			}else{ //child or individual
				$ShippedID = $objShipment->GetShipmentParent($_GET['ShippedID']);
				if($ShippedID>0){
					unset($arrySED);
					$_GET['ShippedID'] = $ShippedID;
					$arrySED = $objShipment->listingShipmentDetail($_GET['ShippedID']);
					$MultipleOrderID =  $arrySED[0]['MultipleOrderID'];
					$Multiple =  $arrySED[0]['Multiple'];
				}
			}
			/************************/



           		$arrySale = $objShipment->GetShipment($_GET['ShippedID'],'','Shipment');

           		$OrderID   = $arrySale[0]['OrderID'];
			if($Multiple==1 && !empty($MultipleOrderID)){
				  $OrderID = $OrderID.','.$MultipleOrderID;
			}

           		$arrySaleItem = $objSale->GetSaleItemIN($OrderID);
           		
           		$NumLine = sizeof($arrySaleItem);

			/************/
			$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
			$arryCurrencyDt = $objRegion->getCurrencyByCode($Currency);
			$CurrencyVal = $arryCurrencyDt[0]["name"];
			/************/

			

	}else{
		echo $ErrorMSG = NOT_EXIST_DATA;exit;
	}
ob_start();

//echo "<pre>";print_r($arrySaleItem);die;

(empty($_GET['attachfile']))?($_GET['attachfile']=""):("");
(empty($_GET['editpdftemp']))?($_GET['editpdftemp']=""):("");
(empty($Config['UserName']))?($Config['UserName']=""):("");
(empty($Config['TodayDate']))?($Config['TodayDate']=""):("");
(empty($arrySale[0]['Address2To']))?($arrySale[0]['Address2To']=""):("");

$FromAddress=$ToAddress='';

/*************************************/
if(empty($arrySED[0]['ShipType'])){	
	$arryAddressFrom = $objShipment->defaultAddressBook("ShippingFrom");
 		
	$ToAddress =  '<br>'.$arrySale[0]['ShippingName'].',
	<br>'.$arrySale[0]['ShippingCompany'].',
	<br>'.$arrySale[0]['ShippingAddress'].',
	<br>'.$arrySale[0]['Address2To'].',
	'.$arrySale[0]['ShippingCity'].',	
	'.$arrySale[0]['ShippingState'].' '.$arrySale[0]['ShippingZipCode'].',
	'.$arrySale[0]['ShippingCountry'].'';   

	 if(!empty($arryAddressFrom[0]['adbID'])){
		$FromAddress = '<br>'.$arryAddressFrom[0]['ContactName'].',
		<br>'.$arryAddressFrom[0]['Company'].',
		<br>'.$arryAddressFrom[0]['Address1'].',
		<br>'.$arryAddressFrom[0]['Address2'].',
		'.$arryAddressFrom[0]['City'].',  
		'.$arryAddressFrom[0]['State'].' '.$arryAddressFrom[0]['Zip'].',
		'.$arryAddressFrom[0]['Country'].'  ';	

	}  
	
	$arrySED[0]['CityTo'] = $arrySale[0]['ShippingCity'];
	$arrySED[0]['StateTo'] = $arrySale[0]['ShippingState'];
	$arrySED[0]['CountryTo'] = $arrySale[0]['ShippingCountry'];
	if(!empty($arryAddressFrom[0]['adbID'])){
		$arrySED[0]['ZipFrom'] = $arryAddressFrom[0]['Zip'];
		$arrySED[0]['CityFrom'] = $arryAddressFrom[0]['City'];
		$arrySED[0]['StateFrom'] = $arryAddressFrom[0]['State'];
		$arrySED[0]['CountryFrom'] = $arryAddressFrom[0]['Country'];
	}else{
		$arrySED[0]['ZipFrom'] = '';
		$arrySED[0]['CityFrom'] = '';
		$arrySED[0]['StateFrom'] = '';
		$arrySED[0]['CountryFrom'] = '';
	}
	 

	$ModulePDFID  = $_GET['ShippedID'];
	$ModDepName  = $arrySale[0]['ShippingMethodVal'].'-SED';  

	$ShipType = $arrySale[0]['ShippingMethod'];
	$serValue = $arrySale[0]['ShippingMethodVal'];			
}else{	
	$ToAddress =  '<br>'.$arrySED[0]['ContactNameTo'].',
	<br>'.$arrySED[0]['CompanyTo'].',
	<br>'.$arrySED[0]['Address1To'].',
	<br>'.$arrySED[0]['Address2To'].',
	'.$arrySED[0]['CityTo'].',	
	'.$arrySED[0]['StateTo'].' '.$arrySED[0]['ZipTo'].',
	'.$arrySED[0]['CountryTo'].'';

	$FromAddress = '<br>'.$arrySED[0]['Contactname'].',
	<br>'.$arrySED[0]['CompanyFrom'].',
	<br>'.$arrySED[0]['Address1From'].',
	<br>'.$arrySED[0]['Address2From'].',
	'.$arrySED[0]['CityFrom'].',  
	'.$arrySED[0]['StateFrom'].' '.$arrySED[0]['ZipFrom'].',
	'.$arrySED[0]['CountryFrom'].'  ';

 
	$ModulePDFID  = $arrySED[0]['ShippedID'];
	$ModDepName  = $arrySED[0]['ShippingMethod'].'-SED';


	$ShipType = $arrySED[0]['ShipType'];
	$serValue = $arrySED[0]['ShippingMethod'];
	
}
/*************************************/

$tableName=strtolower($ShipType).'_service_type'; 
if(!empty($ShipType) && !empty($serValue)){
	$strSQLQuery = "select * from ".$Config['DbMain'].".".$tableName." where service_value = '".$serValue."'";
	$arryInter = $objConfig->query($strSQLQuery,1);
}


$html='<table cellpadding="0" cellspacing="0" style="width:100%;height:auto; font-size:10px;">
		    <tr>
		    <td style="width:100%;top:5px; text-align:center; height:8; "> U.S. DEPARTMENT OF COMMERCE – Economics and Statistics Administration – U.S. CENSUS BUREAU – BUREAU OF EXPORT ADMINISTRATION
		    </td>
		    </tr>
		    
		     <tr>
		    <td style="width:100%;top:5px; text-align:center; height:8; "></td>
		    </tr>
		    
		     <tr>
		    <td style="width:80%;top:5px; height:8;text-align:center; ">FORM<b>7525-V</b>(7-18-2003) <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SHIPPER’S  EXPORT DECLARATION </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OMB No. 0607-0152</td>
		    </tr>
		    
		   
		   <tr><td height="70" cellpadding="0" cellspacing="0">
		       
		        <table  style="width:100%; height:70;border-top:1px solid #000;border-bottom:1px solid #000;" cellpadding="0" cellspacing="0">
		        <tr>
		                <td style="width:50%; height:70;border-right:1px solid #000;border-top:1px solid #000;">
		                <table style="width:100%;" cellpadding="0" cellspacing="0">
		                <tr>
		                <td colspan="2" style="width:50%; height:35; font-size:10px;">
		                <b>1a.</b>U.S. PRINCIPAL PARTY IN INTEREST (USPPI)(Complete name and address)
		                '.$FromAddress.'
		                </td>
		                
		                </tr>
		                 <tr>
		                <td style="width:80%; height:35; font-size:10px;">'.$arrySED[0]['CityFrom'].','.$arrySED[0]['StateFrom'].' ,'.$arrySED[0]['CountryFrom'].'
		                </td>
	                    <td style="width:20%; height:35; border-left:1px solid #000;border-top:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0">ZIP CODE<br/>&nbsp;&nbsp;'.$arrySED[0]['ZipFrom'].'
		                </td>
		                </tr> </table>
		                </td>
		                <td style="width:50%; height:70;">
		                 <table style="width:100%; height:70;" cellpadding="0" cellspacing="0">
		                <tr>
		                <td colspan="2" style="50% vertical-align:top; height:50; font-size:10px;border-left:1px solid #000;" cellpadding="0" cellspacing="0"></td>
		                </tr>
		                 <tr>
		                <td style="width:50%; height:60; border-top:2px solid #000;border-right:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0"><b>2.</b> DATE OF EXPORTATION <br/>&nbsp;&nbsp;&nbsp;'.$arrySED[0]['ShipmentDate'].'
		                </td>
		                <td style="width:50%; height:60; border-top:2px solid #000;border-left:1px solid #000;  vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0"><b>3.</b>TRANSPORTATION REFERENCE NO <br/>&nbsp;&nbsp;&nbsp;
          '.$arrySED[0]['RefID'].' 
		                </td>
		                </tr> </table>
		                </td>
		     </tr>
		    
		          </table>
		       
		 </td></tr>
		 <tr><td height="435" cellpadding="0" cellspacing="0">
			  <table  style="width:100%;" cellpadding="0" cellspacing="0">
					  <tr>
					          <td style="width:60%; height:435;border-right:2px solid #000;border-bottom:1px solid #000;">
					          <table style="width:100%;" cellpadding="0" cellspacing="0">
											                <tr>
											                <td style="width:50%; height:40; valign:top; font-size:10px;border-right:2px solid #000;border-bottom:1px solid #000;"><b>b.</b> USPPIS EIN (IRS) OR ID NO.<br><br>
											                </td>
											                <td style="width:50%; height:40; valign:top; font-size:10px;border-bottom:1px solid #000;"><b>c.</b> PARTIES TO TRANSACTION<br/>&nbsp;&nbsp;<input type="checkbox" />&nbsp;&nbsp;Related &nbsp;&nbsp;<input type="checkbox" />&nbsp;&nbsp;Non-related
											                </td>
											                </tr>
											                <tr>
											                <td style="width:50%; height:62; font-size:10px;"><br/><b>4a.</b> ULTIMATE CONSIGNEE (Complete name and address) 
											             
		  													'.$ToAddress .'
											                </td>
											               
											                </tr>
											                
											                 <tr>
											                <td colspan="2" style="text-align:left; border-top:1px dotted #000; height:40; font-size:10px;">
											                <b>b.</b> INTERMEDIATE CONSIGNEE (Name:&nbsp;'.$arryCompany[0]['CompanyName'].',Address:&nbsp;'.$arryCompany[0]['Address'].')<br><br>Same as Ultimate Consignee
											                </td></tr>
											                 <tr>
											                <td colspan="2" style="text-align:left; border-top:1px solid #000; vertical-align:top; height:40; font-size:10px;">
											               <b>5a.</b>FORWARDING AGENT (Name:&nbsp;'.$arryCompany[0]['CompanyName'].',Address:&nbsp;'.$arryCompany[0]['Address'].')<br/>FEDEX<br/>
											                </td></tr>
											                <tr>
											                <td colspan="2" style="text-align:left; height:40; border-top:1px dotted #000; vertical-align:top; font-size:10px;">
											               <b>5b.</b> FORWARDING AGENT S EIN (IRS) NO.<br/>
											                </td></tr>
											                <tr>
											                <td style="width:50%; height:40; vertical-align: top; border-top:1px solid #000; text-align:left; font-size:10px;" cellpadding="0" cellspacing="0"><b>8.</b> LOADING PIER (Ocean only)
											                </td>
											                <td style="width:50%; height:40; vertical-align:top; border-top:1px solid #000;border-left:1px solid #000;  font-size:10px;" cellpadding="0" cellspacing="0"> <b>9.</b> METHOD OF TRANSPORTATION (Specify) <br> '.$arryInter[0]['service_type'].'
											                </td>
											                </tr>
											                <tr>
											                <td style="width:50%; height:40; vertical-align:top; border-top:1px solid #000; font-size:10px;"><b>10.</b> EXPORTING CARRIER <br>'.$ShipType.'
											                </td>
											                <td style="width:50%; height:40; vertical-align:top; border-top:1px solid #000;border-left:1px solid #000;font-size:10px;"><b>11.</b> PORT OF EXPORT<br/>'.$arrySED[0]['StateTo'].'
											                </td>
											                </tr>
											                <tr>
											                <td style="width:50%; height:50; vertical-align:top; border-top:1px solid #000; font-size:10px;"><b>12.</b> PORT OF UNLOADING (Ocean and Air only)
											                </td>
											                <td style="width:50%; height:50; vertical-align:top; border-top:1px solid #000;border-left:1px solid #000;   font-size:10px;"><b>13.</b> CONTAINERIZED (Ocean only)<br/>&nbsp;&nbsp;&nbsp;<input type="checkbox" />&nbsp;Yes&nbsp;&nbsp;&nbsp; <input type="checkbox" checked="checked"/>&nbsp;No
											                </td>
											                </tr>
									</table>
					          </td>
					           <td style="width:40%; height:435;" cellpadding="0" cellspacing="0">
					           <table style="width:100%;margin-top:227px;" cellpadding="0" cellspacing="0">
							     <tr><td colspan="7" height="40">&nbsp;</td></tr>
							     <tr><td style="width:50%; border-top:2px solid #000; vertical-align:top; height:35; font-size:7px;"><b>6.</b> POINT (STATE) OF ORIGIN OR FTZ LOCATION ID <br/>'.$arrySED[0]['StateTo'].'</td>
							     <td style="width:50%; border-top:2px solid #000;border-top:2px solid #000;border-left:1px solid #000; height:35; vertical-align:top; font-size:7px;">7. COUNTRY OF ULTIMATE DESTINATION <br/>'.$arrySED[0]['CountryTo'].'</td>
							     </tr>
							     <tr><td style="width:50%; border-top:2px solid #000;height:35; vertical-align:top; font-size:7px;"><b>14.</b> CARRIER IDENTIFICATION CODE <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							     <td style="width:50%; border-top:2px solid #000;border-left:1px solid #000; height:35; vertical-align:top; font-size:7px;">15. SHIPMENT REFERENCE NO. <br/>'.$arrySED[0]['trackingId'].'</td>
							     </tr>
							     <tr><td style="width:50%; border-top:1px solid #000; height:35; vertical-align:top; font-size:7px;"><b>16.</b> IN BOND NUMBER</td>
							     <td style="width:50%; border-top:1px solid #000;border-left:1px solid #000; height:35; vertical-align:top; font-size:7px;">17. HAZARDOUS MATERIALS<br/>&nbsp;&nbsp;&nbsp;<input type="checkbox" />&nbsp;Yes &nbsp;&nbsp;&nbsp;<input type="checkbox" checked="checked"/>&nbsp;No</td>
							     </tr>
							     <tr><td style="width:50%; border-top:1px solid #000; height:35; vertical-align:top; font-size:7px;"><b>18.</b> IN BOND NUMBER TYPE <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							     <td style="width:50%; border-top:1px solid #000;border-left:1px solid #000; height:35; vertical-align:top; font-size:7px;"><b>19.</b> ROUTED EXPORT TRANSACTION<br/>&nbsp;&nbsp;&nbsp;<input type="checkbox" />&nbsp;Yes &nbsp;&nbsp;&nbsp;<input type="checkbox" checked="checked"/>&nbsp;No</td>
							     </tr>
							     </table>
					           </td>
					          
					          </tr>
		 </table>
		 </td>
		
		 </tr>
		 <tr>
    <td  style="border-top:1px solid #000;border-bottom:1px solid #000; font-size:10px;"><b>20.</b> SCHEDULE B DESCRIPTION OF COMMODITIES (Use columns 22-24)</td>
  </tr>
    
  <tr><td cellpadding="0" cellspacing="0"><table  background="red" style="width:100%;" cellpadding="0" cellspacing="0"><tr>
		    <td style="width:5%;text-align:center; font-size:10px;">D/F or M (21)</td>
		    <td style="width:20%; border-left:1px solid #000;text-align:center; font-size:10px;">SCHEDULE B NUMBER (22) </td>
		    <td style="width:15%; border-left:1px solid #000;text-align:center; font-size:10px;">QUANTITY–SCHEDULE B UNIT(S) (23)</td>
		    <td style="width:25%; border-left:1px solid #000;text-align:center; font-size:10px;">SHIPPING WEIGHT (Kilogr ms) (24) </td>
		    <td style="width:25%; border-left:1px solid #000;text-align:center; font-size:10px;">VIN/PRODUCT NUMBER/ VEHICLE TITLE NUMBER (25)</td>
		    <td style="width:10%; border-left:1px solid #000;text-align:center; font-size:10px;"> VALUE ('.$CurrencyVal.', omit cents) (Selling price or cost if not sold) (26)</td>
		  </tr>';
	   $Total=0;
	  for($Count=0;$Count<$NumLine;$Count++){
	  		$subtotal=($arrySaleItem[$Count]["qty_shipped"]*$arrySaleItem[$Count]["price"]);
	  	
		if($subtotal>0){
			$Total +=$subtotal;

		$html .='<tr>
        <td style="width:5%; text-align:center; font-size:10px;border-top:1px solid #000;border-bottom:1px solid #000;">&nbsp;</td>
        <td style="width:20%; border-top:1px solid #000;border-bottom:1px solid #000;text-align:center; font-size:10px;">'.$arrySaleItem[$Count]['sku'].'</td>
        <td style="width:15%;  border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;text-align:center; font-size:10px;">'.$arrySaleItem[$Count]['qty_shipped'].'</td>
        <td style="width:25%; border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000; font-size:10px;"></td>
        <td style="width:25%; border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;text-align:center; font-size:10px;">'.$arrySaleItem[$Count]['sku'].'</td>
        <td style="width:10%; border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;text-align:center; font-size:10px;">'.$subtotal.'</td>
      </tr>';
	
	    }
	  }

      
		$html .='</table>
      
		  </td></tr>
		  
		  <tr>
		  <td style="height:190;" cellpadding="0" cellspacing="0">
		  <table  style="width:100% border-top:1px solid #000;" cellpadding="0" cellspacing="0">

		                <tr>
		                <td style="width:60%;" cellpadding="0" cellspacing="0">
		                <table style="width:100%; border-right:2px solid #000;border-top:1px solid #000;border-bottom:2px solid #000;" cellpadding="0" cellspacing="0">
		                
		                <tr><td cellpadding="0" cellspacing="0"><table style="width:100%; " cellpadding="0" cellspacing="0">
		                <tr><td style="width:70%; border-bottom:2px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0"><b>27.</b> LICENSE NO./LICENSE EXCEPTION SYMBOL/AUTHORIZATION <br>NLR</td><td style="width:30%; border-bottom:2px solid #000;border-left:1px solid #000;"><b>28.</b> ECCN (When required)</td>
		                </tr>
		                <tr><td style="width:70%; border-top:1px solid #000;border-bottom:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0"><b>29.</b> Duly authorized officer or employee <br> '.$Config['UserName'].'</td><td style="width:30%; border-top:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;">The USPPI authorizes the forwarder named above to act as forwarding agent for export control and customs purposes.</td>
		                </tr>
		                </table></td>
		                </tr>
		               
		                <tr>
 <td  style="width:100%; font-size:10px;" cellpadding="0" cellspacing="0">30. I certify that all statements made and all information contained herein are true and correct and that I have read
and understand the instructions for preparation of this document, set forth in the <b>"Correct Way to Fill Out
the Shipper’s Export Declaration."</b> I understand that civil and criminal penalties, including forfeiture and
sale, may be imposed for making false or fraudulent statements herein, failing to provide the requested
information or for violation of U.S. laws on exportation (13 U.S.C. Sec. 305; 22 U.S.C. Sec. 401; 18 U.S.C. Sec.
1001; 50 U.S.C. App. 2410). '.$Config['TodayDate'].'
</td>
		                </tr>  

		                
		                
		                <tr><td cellpadding="0" cellspacing="0"><table style="width:100%; " cellpadding="0" cellspacing="0">
		                <tr><td style="width:50%; border-top:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0">Signature</td><td style="width:50%; border-top:1px solid #000;border-left:1px solid #000;"> <b>Confidential–</b> Shipper’s Export Declarations (or any successor
						document) wherever located, shall be exempt from public disclosure unless
						the Secretary determines that such exemption would be contrary to the
						national interest (Title 13, Chapter 9, Section 301 (g)).
						</td>
		                </tr>
		                <tr><td style="width:50%; border-top:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0">Title</td><td style="width:50%; border-top:1px solid #000;border-left:1px solid #000;">Export shipments are subject to inspection by U.S. Customs Service and/or Office of Export Enforcement</td>
		                </tr>
		                <tr><td style="width:50%; border-top:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0">Date</td><td style="width:50%; border-top:1px solid #000;border-left:1px solid #000;"><b>31.</b>AUTHENTICATION (When required)</td>
		                </tr>
		                <tr><td style="width:50%; border-top:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0">Telephone No. (Include area code)</td><td style="width:50%; border-top:1px solid #000;border-left:1px solid #000;">E-mail address. <br>'.$_SESSION['AdminEmail'].'</td>
		                </tr>
		                </table></td></tr>
		                </table>
		                </td>
		                </tr>
		                
		             
		    </table>
		  
		  </td>
		  </tr>
   <tr>
     <td style="width:100%;top:5px; text-align:center; height:8; "> This form may be printed by private parties provided it conforms to the official form. For sale by the Superintendent of Documents, Government
Printing Office, Washington, DC 20402, and local Customs District Directors. The <b>"Correct Way to Fill Out the Shipper’s Export
Declaration"</b> is available from the U.S. Census Bureau, Washington, DC 20233.
		    </td>
	</tr>	    
</table>';
 
echo $html;
 
 

$content = ob_get_clean();
@ob_end_clean(); // close and clean the output buffer.
require_once("../includes/htmltopdf/html2pdf.class.php");

try { 
 
 
	$html2pdf = new HTML2PDF('P', 'A4', 'fr');
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
 
	if ($_GET['editpdftemp'] == '1') {
		$html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf');
	//            $html2pdf->stream('Sales-'.$nn.'.pdf');
    	}


    /*     * code for download link * */
    if ($_GET['attachfile'] == '1') {
        chmod($savefileUrl, 0777);
        $html2pdf->Output($savefileUrl . $ModDepName . '-' . $ModulePDFID . '.pdf', 'F');    // Save file to dir
    }
    $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf', 'D');        // Download File
    /*     * code for download link * */
} catch (HTML2PDF_exception $e) { 
    echo $e;
    exit;
}
?>
