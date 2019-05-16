<?	
	require_once("../includes/pdf_comman.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
		require_once($Prefix."classes/sales.quote.order.class.php");
	$objShipment = new shipment();
	$objSale = new sale();
	if(!empty($_GET['ShippedID'])){	
			 
           	    $arrywarehousePdf = $objShipment->listingShipmentDetail($_GET['ShippedID']);
           	
           		$arrySale = $objShipment->GetShipment($_GET['ShippedID'],'','Shipment');
           		$OrderID   = $arrySale[0]['OrderID'];
           		$arrySaleItem = $objSale->GetSaleItem($OrderID);
           		
           		$NumLine = sizeof($arrySaleItem);
	}else{
		echo $ErrorMSG = NOT_EXIST_DATA;exit;
	}
ob_start();
//echo '<pre>';print_r($arrywarehousePdf);die;
$html='<table cellpadding="0" cellspacing="0" style="width:100%; border:1px solid #000;" >
      <tr>
	   <td  style="border:none; width=50%;" >&nbsp;</td>
	   <td style="border:1px solid #000; width:25%;">COMPANY NAME &nbsp;&nbsp;&nbsp;&nbsp; '.$arryCompany[0]['CompanyName'].'</td>
	   
  	  </tr>
	   <tr>
	   <td style="border:none; width=50%;">&nbsp;</td>
	   <td style="border:1px solid #000; width:50%;">COMPANY ADDRESS &nbsp;&nbsp;&nbsp;&nbsp; '.$arryCompany[0]['Address'].'</td>
	  </tr>
	  <tr>
	    <td colspan="2" align="center" border="1"><p>COMMERCIAL INVOICE </p></td>
	  </tr>
      <tr>
       <td colspan="2"><table style="width:100%; border:1px solid #000;" cellpadding="0" cellspacing="0">
        <tr>
         <td style="width:32%;">INTERNATIONAL AIR WAYBILL NO. </td>
         <td style="width:37%;"><table style="width:100%; border:1px solid #000;" cellpadding="0" cellspacing="0">
          <tr>
            <td>'.$arrywarehousePdf[0]['trackingId'].'</td>
          </tr>
            </table>
         </td>
          <td style="width:31%;">(NOTE: All shipments must be accompanied by a Federal Express International Air Waybill.)</td>
       </tr>
          </table>
          </td>
      </tr>
	  <tr>
	    <td style="border:1px solid #000; width:50%;">DATE OF EXPORTATION  &nbsp;&nbsp;&nbsp;&nbsp; '.$arrywarehousePdf[0][ShipmentDate].'</td>
	    <td style="border:1px solid #000; width:50%;">EXPORT REFERENCES (”i.e., order no., invoice no.) '.$arrywarehousePdf[0][RefID].'</td>
	  </tr>
	  <tr>
	    <td style="border:1px solid #000; width:50%;vertical-align:top;">SHIPPER/EXPORTER (complete name and address)  
<br>'.$arrywarehousePdf[0]['CityFrom'].',  
'.$arrywarehousePdf[0]['StateFrom'].' 
'.$arrywarehousePdf[0]['ZipFrom'].', 
'.$arrywarehousePdf[0]['CountryFrom'].'   
	  

	    </td>
	    <td style="border:1px solid #000; width:50%; vertical-align:top;">CONSIGNEE (complete name and address)
<br>'.$arrywarehousePdf[0]['CityTo'].',	
'.$arrywarehousePdf[0]['StateTo'].'    
'.$arrywarehousePdf[0]['ZipTo'].', 
'.$arrywarehousePdf[0]['CountryTo'].'
    
	    </td>
	  </tr>
	  <tr>
	    <td style="border:1px solid #000; width:50%;"><p>COUNTRY OF EXPORT &nbsp;&nbsp;&nbsp;&nbsp; '.$arrywarehousePdf[0][CountryTo].'</p>
	    </td>
	    <td style="border:1px solid #000; width:50%;">IMPORTER — IF OTHER THAN CONSIGNEE<br>
	    (complete name and address)</td>
	  </tr>
	  <tr>
	    <td style="border:1px solid #000; width:50%;"><p>COUNTRY  OF MANUFACTURE</p>
	    </td>
	    <td style="border:none">&nbsp;</td>
	  </tr>
	  <tr>
	    <td style="border:1px solid #000; width:50%;">COUNTRY  OF ULTIMATE DESTINATION &nbsp;&nbsp;&nbsp;&nbsp; '.$arrywarehousePdf[0][CountryTo].'</td>	    
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
	  for($Count=0;$Count<$NumLine;$Count++){
	  	
	  	$subtotal=($arrySaleItem[$Count]["qty_shipped"]*$arrySaleItem[$Count]["price"]);
	  	
	  	$Total +=$subtotal;
      	$html .='<tr>
        <td style="width:12%; border:1px solid #000;">&nbsp;'.$arrySaleItem[$Count]["sku"].'
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td style="width:9%; border:1px solid #000;">&nbsp;</td>
        <td style="width:11%; border:1px solid #000;">&nbsp;</td>
        <td style="width:17%; border:1px solid #000;">&nbsp;'.$arrySaleItem[$Count]["description"].'</td>
        <td style="width:6%; border:1px solid #000;">&nbsp;'.$arrySaleItem[$Count]["qty_shipped"].'</td>
        <td style="width:11%; border:1px solid #000;">&nbsp;</td>
        <td style="width:10%; border:1px solid #000;">&nbsp;</td>
        <td style="width:10%; border:1px solid #000;">&nbsp; '. number_format($arrySaleItem[$Count]["price"],2).'</td>
        <td style="width:10%; border:1px solid #000;">&nbsp;'. number_format($subtotal,2).'</td>
      </tr>';
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
	
echo $html;
$content = ob_get_clean();
ob_end_clean(); // close and clean the output buffer.
require_once("../includes/htmltopdf/html2pdf.class.php");

try { 
	$ModulePDFID  = $arrywarehousePdf[0]['ShippedID'];
	$ModDepName  = $arrywarehousePdf[0]['ShippingMethod'];

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
