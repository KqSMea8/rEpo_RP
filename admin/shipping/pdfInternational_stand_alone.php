<?	require_once("../includes/pdf_comman.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
	$objShipment = new shipment();  

	if(!empty($_GET['ShippedID'])){	
		require_once("includes/common.php");

		$arryencode = $objConfig->getStandaloneShipmentByID($_GET['Module'], $_GET['ShippedID']);
		$arrFromAddress = json_decode($arryencode[0]['FromAddress'],true);
		$arrToAddress = json_decode($arryencode[0]['ToAddress'],true);
		$arrOtherDetails = json_decode($arryencode[0]['OtherDetails'],true);
		$shipperCountry = $objShipment->getCountryNameByCode($arrFromAddress['CountryFrom']);
		$recipientCountry = $objShipment->getCountryNameByCode($arrToAddress['CountryTo']);
	}else{
		echo $ErrorMSG = "This data no longer exist in the database.";exit;
	}
 
ob_start();

/***********Stand Alone Data***********/
//From Address//
$arrayStandalone[0]['Contactname'] = $arrFromAddress['Contactname'];
$arrayStandalone[0]['CompanyFrom'] = $arrFromAddress['CompanyFrom'];
$arrayStandalone[0]['Address1From'] = $arrFromAddress['Address1From'];
$arrayStandalone[0]['Address2From'] = $arrFromAddress['Address2From'];
$arrayStandalone[0]['CityFrom'] = $arrFromAddress['CityFrom'];
$arrayStandalone[0]['StateFrom'] = $arrFromAddress['StateFrom'];
$arrayStandalone[0]['ZipFrom'] = $arrFromAddress['ZipFrom'];

//To Address //
$arrayStandalone[0]['ContactNameTo'] = $arrToAddress['ContactNameTo'];
$arrayStandalone[0]['CompanyTo'] = $arrToAddress['CompanyTo'];
$arrayStandalone[0]['Address1To'] = $arrToAddress['Address1To'];
$arrayStandalone[0]['Address2To'] = $arrToAddress['Address2To'];
$arrayStandalone[0]['CityTo'] = $arrToAddress['CityTo'];
$arrayStandalone[0]['StateTo'] = $arrToAddress['StateTo'];
$arrayStandalone[0]['ZipTo'] = $arrToAddress['ZipTo'];

//Other Details//
$arrayStandalone[0]['trackingId'] = $arryencode[0]['TrackingID'];
$arrayStandalone[0]['ShipmentDate'] = $arryencode[0]['CreatedDate'];
$arrayStandalone[0]['RefID'] = $arryencode[0]['RefID'];
$arrayStandalone[0]['ShippedID'] = $arryencode[0]['RefID'];
$arrayStandalone[0]['ShippingMethod'] = $arryencode[0]['ShippingMethod'];
$arrayStandalone[0]['ShipType'] = $arryencode[0]['ShippingCarrier'];
$arrayStandalone[0]['ShippingMethod'] = $arryencode[0]['ShippingMethod'];
$arrayStandalone[0]['ShipType'] = $arryencode[0]['ShippingCarrier'];
/*************************************/


/******Sales Purchase and its item ****/
/*************************************/


/*************************************/
if(empty($arrayStandalone[0]['ShipType'])){	
	$arryAddressFrom = $objShipment->defaultAddressBook("ShippingFrom");
 		
 	
	(empty($satandaloneRma[0]['Address2To']))?($satandaloneRma[0]['Address2To']=""):("");

	$ToAddress =  '<br>'.$satandaloneRma[0]['ShippingName'].',
	<br>'.$satandaloneRma[0]['ShippingCompany'].',
	<br>'.$satandaloneRma[0]['ShippingAddress'].',
	<br>'.$satandaloneRma[0]['Address2To'].',
	'.$satandaloneRma[0]['ShippingCity'].',	
	'.$satandaloneRma[0]['ShippingState'].' '.$satandaloneRma[0]['ShippingZipCode'].',
	'.$satandaloneRma[0]['ShippingCountry'].'';   

	$FromAddress = '<br>'.$arryAddressFrom[0]['ContactName'].',
	<br>'.$arryAddressFrom[0]['Company'].',
	<br>'.$arryAddressFrom[0]['Address1'].',
	<br>'.$arryAddressFrom[0]['Address2'].',
	'.$arryAddressFrom[0]['City'].',  
	'.$arryAddressFrom[0]['State'].' '.$arryAddressFrom[0]['Zip'].',
	'.$arryAddressFrom[0]['Country'].'  ';	  

	$ModulePDFID  = $_GET['ShippedID'];
	$ModDepName  = $satandaloneRma[0]['ShippingMethodVal'];      			
}else{	

	(empty($arrayStandalone[0]['Address2To']))?($arrayStandalone[0]['Address2To']=""):("");
	(empty($arrayStandalone[0]['CountryTo']))?($arrayStandalone[0]['CountryTo']=""):("");

	$ToAddress =  '<br>'.$arrayStandalone[0]['ContactNameTo'].',
	<br>'.$arrayStandalone[0]['CompanyTo'].',
	<br>'.$arrayStandalone[0]['Address1To'].',
	<br>'.$arrayStandalone[0]['Address2To'].',
	'.$arrayStandalone[0]['CityTo'].',	
	'.$arrayStandalone[0]['StateTo'].' '.$arrayStandalone[0]['ZipTo'].',
	'.$arrayStandalone[0]['CountryTo'].'';

	$FromAddress = '<br>'.$arrayStandalone[0]['Contactname'].',
	<br>'.$arrayStandalone[0]['CompanyFrom'].',
	<br>'.$arrayStandalone[0]['Address1From'].',
	<br>'.$arrayStandalone[0]['Address2From'].',
	'.$arrayStandalone[0]['CityFrom'].',  
	'.$arrayStandalone[0]['StateFrom'].' '.$arrayStandalone[0]['ZipFrom'].',
	'.$shipperCountry[0]['name'].'  ';

	$ModulePDFID  = $arrayStandalone[0]['ShippedID'];
	$ModDepName  = $arrayStandalone[0]['ShippingMethod'];
	
}

/*************************************/

$html='<table cellpadding="0" cellspacing="0" style="width:100%; border:1px solid #000;" >
      
	  <tr>
	    <td colspan="2" align="center" border="1" height="40">COMMERCIAL INVOICE</td>
	  </tr>
      <tr>
       <td colspan="2"><table style="width:100%; border:1px solid #000;" cellpadding="0" cellspacing="0">
        <tr>
         <td style="width:32%;">INTERNATIONAL AIR WAYBILL NO. </td>
         <td style="width:37%;"><table style="width:100%; border:1px solid #000;" cellpadding="0" cellspacing="0">
          <tr>
            <td>'.$arrayStandalone[0]['trackingId'].'</td>
          </tr>
            </table>
         </td>
          <td style="width:31%;">(NOTE: All shipments must be accompanied by a Federal Express International Air Waybill.)</td>
       </tr>
          </table>
          </td>
      </tr>
	  <tr>
	    <td style="border:1px solid #000; width:50%;">DATE OF EXPORTATION  &nbsp;&nbsp;&nbsp;&nbsp; '.$arrayStandalone[0]["ShipmentDate"].'</td>
	    <td style="border:1px solid #000; width:50%;">EXPORT REFERENCES (”i.e., order no., invoice no.) '.$arrayStandalone[0]["RefID"].'</td>
	  </tr>
	  <tr>
	    <td style="border:1px solid #000; width:50%;vertical-align:top;">SHIPPER/EXPORTER (complete name and address)  
 		'.$FromAddress.'
	    </td>
	    <td style="border:1px solid #000; width:50%; vertical-align:top;">CONSIGNEE (complete name and address)
		'.$ToAddress.'
    
	    </td>
	  </tr>
	  <tr>
	    <td style="border:1px solid #000; width:50%;"><p>COUNTRY OF EXPORT &nbsp;&nbsp;&nbsp;&nbsp; '.$recipientCountry[0]['name'].'</p>
	    </td>
	    <td style="border:1px solid #000; width:50%;">IMPORTER — IF OTHER THAN CONSIGNEE<br>
	    (complete name and address)</td>
	  </tr>
	  <tr>
	    <td style="border:1px solid #000; width:50%;"><p>COUNTRY  OF MANUFACTURE &nbsp;&nbsp;'.$shipperCountry[0]['name'].'</p>
	    </td>
	    <td style="border:none">&nbsp;</td>
	  </tr>
	  <tr>
	    <td style="border:1px solid #000; width:50%;">COUNTRY  OF ULTIMATE DESTINATION &nbsp;&nbsp;&nbsp;&nbsp; '.$recipientCountry[0]['name'].'</td>	    
	    <td style="border:none">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="2"><table cellpadding="0" cellspacing="0" style="width:100%; border:1px solid #000;" >
	      <tr>
	      <td style="width:12%; border:1px solid #000;">MARKS/NOS.</td>
	        <td style="width;9%; border:1px solid #000;">NO. OF PKGS.</td>
	        <td style="width:11%; border:1px solid #000;">TYPE OF PACKAGING</td>
	        <td style="width:17%; border:1px solid #000;">FULL DESCRIPTION OF GOODS</td>
	        <td style="width:6%; border:1px solid #000;">QTY.</td>
	        <td style="width:11%; border:1px solid #000;">UNIT OF MEA-SURE</td>
	        <td style="width:10%; border:1px solid #000;">WEIGHT</td>
	        <td style="width:10%; border:1px solid #000;">UNIT VALUE</td>
	        <td style="width:10%; border:1px solid #000;">TOTAL VALUE</td>
	  </tr>';
		$Total=0;


	  for($Count=0;$Count<$NumLine;$Count++){
	  	 
	
 	$subtotal=($satandaloneRmaItem[$Count][$qty_column]*$satandaloneRmaItem[$Count]["price"]);

  	
		if($subtotal>0){
			$Total +=$subtotal;


			$html .='<tr>
			<td height="50" style="width:12%; border:1px solid #000;">&nbsp;'.$satandaloneRmaItem[$Count]["sku"].'
			 </td>
			<td style="width:9%; border:1px solid #000;">&nbsp;</td>
			<td style="width:11%; border:1px solid #000;">&nbsp;</td>
			<td style="width:17%; border:1px solid #000;">&nbsp;'.$satandaloneRmaItem[$Count]["description"].'</td>
			<td style="width:6%; border:1px solid #000;">&nbsp;'.$satandaloneRmaItem[$Count][$qty_column].'</td>
			<td style="width:11%; border:1px solid #000;">&nbsp;</td>
			<td style="width:10%; border:1px solid #000;">&nbsp;</td>
			<td style="width:10%; border:1px solid #000;">&nbsp; '. number_format($satandaloneRmaItem[$Count]["price"],2).'</td>
			<td style="width:10%; border:1px solid #000;">&nbsp;'. number_format($subtotal,2).'</td>
			</tr>';
		}

	  }
	  
	  
      $html .='<tr>
        <td style="border:none; width:11%;">&nbsp;</td>
        <td style="border:1px solid #000; width:9%;">TOTAL NO. OF PKGS.<br /></td>
        <td style="border:none; width:10%;">&nbsp;</td>
        <td style="border:none; width:17%;">&nbsp;</td>
        <td style="border:none; width:6%;">&nbsp; </td>
        <td style="border:none; width:10%;">&nbsp;</td>
        <td style="border:1px solid #000; width:9%;">TOTAL WEIGHT</td>
        <td style="border:none; width:9%;">&nbsp;</td>
        <td style="border:1px solid #000; width:10%;">TOTAL INVOICE VALUE</td>
        
      </tr>    
    
      <tr>
        <td>&nbsp;</td>
        <td  style="border:1px solid #000; width:10%;">&nbsp;</td>
        <td style="border:none; width:9%;">&nbsp;</td>
        <td style="border:none; width:17%;">SEE REVERSE SIDE FOR HELP WITH THE ABOVE SECTION</td>
        <td style="border:none; width:6%;">&nbsp;</td>
        <td style="border:none; width:10%;">&nbsp;</td>
        <td style="border:1px solid #000; width:"9">&nbsp;</td>
        <td style="border:none; width:8%;">&nbsp;</td>
        <td style="border-left:1px solid #000; width:7%;">&nbsp;'. number_format($Total,2).'</td>
        
      </tr>
      <tr>
         <td colspan="7" rowspan="3" style="width:60%; border:1px solid #000;"><p>FOR U.S. EXPORT ONLY: THESE COMMODITIES, TECHNOLOGY, OR SOFTWARE WERE EXPORTED FROM THE UNITED STATES IN ACCORDANCE WITH THE EXPORT ADMINISTRATION REGULATIONS. DIVERSION CONTRARY TO UNITED STATES LAW IS PROHIBITED.</p>
          <p>I DECLARE ALL THE INFORMATION CONTAINED IN THIS INVOICE TO BE TRUE AND CORRECT</p>
          <p>SIGNATURE OF SHIPPER/EXPORTER (Type name and title and sign.) </p></td>
          <td>&nbsp;</td>
         <td style="border:1px solid #000; text-align:top;">Check one<br/><input type="checkbox" checked="checked"/>F.O.B. <br/><input type="checkbox" />C & F <br/><input type="checkbox" />C.I.F</td>
      </tr>
      
      </table>
      </td>
      </tr>
      
  <tr>
    <td colspan="2" style="border:none"> <p>M-1054  REV  2/00  LOGOS 116547 WCS</p></td>
  </tr>
  
  
</table>';
	
 (empty($_GET['attachfile']))?($_GET['attachfile']=""):("");
(empty($_GET['editpdftemp']))?($_GET['editpdftemp']=""):("");


echo $html;
$content = ob_get_clean();
ob_end_clean(); // close and clean the output buffer.
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
