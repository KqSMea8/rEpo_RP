<?	
	require_once("includes/pdf_comman.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
	$objShipment = new shipment();

	if(!empty($_GET['ShippedID'])){		 
           	$arrywarehousePdf = $objShipment->listingShipmentDetail($_GET['ShippedID']);
	}else{
		echo $ErrorMSG = NOT_EXIST_DATA;exit;
	}
ob_start();
//echo '<pre>';print_r($arrywarehousePdf);die;
$html='<table cellpadding="0" cellspacing="0" style="width:100%;border:none;" >
      <tr>
	   <td  style="border-top:none; width:50%;">&nbsp;</td>
	   <td style="border-top:1px solid #000; width:25%;height:30px;vertical-align:top;font-size:13px;">COMPANY NAME &nbsp;&nbsp;&nbsp;&nbsp;'.$arryCompany[0]['CompanyName'].'</td>
	   
  	  </tr>
	   <tr>
	   <td style="border:none; width=50%;">&nbsp;</td>
	   <td style="border-top:1px solid #000; width:50%;height:30px;vertical-align:top;font-size:13px;">COMPANY ADDRESS &nbsp;&nbsp;&nbsp;&nbsp;'.$arryCompany[0]['Address'].'</td>
	  </tr>
	  <tr>
	    <td colspan="2" align="center" ><p>COMMERCIAL INVOICE </p></td>
	  </tr>
	  
      <tr>
       <td colspan="2">
       <table style="width:100%; border-top:1px solid #000; " cellpadding="0" cellspacing="0">
        <tr>
         <td style="width:16%;">INTERNATIONAL AIR WAYBILL NO. </td>
         <td style="width:53%;"><table style="width:100%; border:1px solid #000;" cellpadding="0" cellspacing="0">
          <tr>
            <td><input type="text" name="" value="" height="88px" style="width:80%;"/></td>
          </tr>
            </table>
         </td>
          <td style="width:31%;"><strong>(NOTE: All shipments must be accompanied by a Federal Express International Air Waybill.)</strong></td>
       </tr>
          </table>
          
          </td>
      </tr>
      
	  <tr>
	    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000; width:50%;height:30px;vertical-align:top;font-size:13px;padding-top:5px;">DATE OF EXPORTATION  &nbsp;&nbsp;&nbsp;&nbsp;'.$arrywarehousePdf[0]['ShipmentDate'].'</td>
	    <td style="border-top:1px solid #000;border-bottom:1px solid #000; width:50%;height:30px;vertical-align:top;font-size:13px;padding:5px 0 0 5px;">EXPORT REFERENCES (i.e., order no., invoice no.) '.$arrywarehousePdf[0][RefID].'</td>
	  </tr>
	  <tr>
	    <td style="border-bottom:1px solid #000;border-right:1px solid #000; width:50%; height:90px; font-size:13px;vertical-align:top;padding:5px 0 0 0px;">SHIPPER/EXPORTER (complete name and address)
	    </td>
	    <td style="border-bottom:1px solid #000; width:50%;height:30px;vertical-align:top;font-size:13px;padding:5px 0 0 5px;">CONSIGNEE (complete name and address)</td>
	  </tr>
	  <tr>
	    <td style="border-right:1px solid #000;width:50%;height:30px;vertical-align:top;font-size:13px;padding-top:5px;">COUNTRY OF EXPORT &nbsp;&nbsp;&nbsp;&nbsp;'.$arrywarehousePdf[0][CountryTo].'</td>
	    <td style="padding-left:5px; width:50%;vertical-align:top;font-size:13px;padding-top:5px;">IMPORTER — IF OTHER THAN CONSIGNEE<br>
	    (complete name and address)</td>
	  </tr>
	  <tr>
	    <td style="border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;width:50%;height:30px;vertical-align:top;font-size:13px;padding-top:5px;">COUNTRY  OF MANUFACTURE</td>
	    <td style="border:none">&nbsp;</td>
	  </tr>
	  <tr>
	    <td style="border-right:1px solid #000; width:50%;height:30px;vertical-align:top;font-size:13px;padding-top:5px;">COUNTRY  OF ULTIMATE DESTINATION &nbsp;&nbsp;&nbsp;&nbsp; '.$arrywarehousePdf[0][CountryTo].'</td>	    
	    <td style="border:none">&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="2">
	    <table cellpadding="0" cellspacing="0" style="width:100%; border:none;" >
	      <tr>
	      <td style="width:11.5%; border-top:1px solid #000;padding-top:5px;font-size:12px;vertical-align:top;">MARKS/NOS.</td>
	        <td style="width:8%; border-top:1px solid #000;border-left:1px solid #000;padding-top:5px;font-size:13px;vertical-align:top;text-align:center;">NO. OF <br/>PKGS.</td>
	        <td style="width:13%; border-top:1px solid #000;border-left:1px solid #000;padding-top:5px;font-size:13px;vertical-align:top;text-align:center;">TYPE OF PACKAGING</td>
	        <td style="width:27%; border-top:1px solid #000;border-left:1px solid #000;padding-top:5px;font-size:13px;vertical-align:top;text-align:center;">FULL DESCRIPTION OF GOODS</td>
	        <td style="width:5%; border-top:1px solid #000;border-left:1px solid #000;padding-top:5px;font-size:13px;vertical-align:top;text-align:center;">QTY.</td>
	        <td style="width:9%; border-top:1px solid #000;border-left:1px solid #000;padding-top:5px;font-size:13px;vertical-align:top;text-align:center;">UNIT OF MEA-<br/>SURE</td>
	        <td style="width:8%; border-top:1px solid #000;border-left:1px solid #000;padding-top:5px;font-size:13px;vertical-align:top;text-align:center;">WEIGHT</td>
	        <td style="width:8%; border-top:1px solid #000;border-left:1px solid #000;padding-top:5px;font-size:13px;vertical-align:top;text-align:center;">UNIT VALUE</td>
	        <td style="width:7%; border-top:1px solid #000;border-left:1px solid #000;padding-top:5px;font-size:13px;vertical-align:top;">TOTAL VALUE</td>
	     </tr>
	      <tr>
	        <td style="width:11.5%; border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;height:150px;">&nbsp;</td>
	        <td style="width:8%; border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
	        <td style="width:13%; border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
	        <td style="width:27%; border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
	        <td style="width:5%; border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
	        <td style="width:9%; border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
	        <td style="width:8%; border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
	        <td style="width:8%; border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;">&nbsp;</td>
	        <td style="width:7%; border-top:1px solid #000;border-bottom:1px solid #000;">&nbsp;</td>
	      </tr>
	      <tr>
	        <td style="border:none; width:11.5%;">&nbsp;</td>
	        <td style="border-left:1px solid #000;border-right:1px solid #000; width:8%;text-align:center;">TOTAL NO. OF PKGS.</td>
	        <td style="border:none; width:13%;">&nbsp;</td>
	        <td style="border:none; width:27%;">&nbsp;</td>
	        <td style="border:none; width:5%;">&nbsp; </td>
	        <td style="border:none; width:9%;">&nbsp;</td>
	        <td style="border-left:1px solid #000;border-right:1px solid #000; width:8%;text-align:center;">TOTAL WEIGHT</td>
	        <td style="border:none; width:8%;">&nbsp;</td>
	        <td style="border-left:1px solid #000;border-bottom:1px solid #000; width:7%;text-align:center;">TOTAL INVOICE VALUE</td>
	      </tr>    
    
	      <tr>
	        <td style="border:none; width:11.5%;">&nbsp;</td>
	        <td  style="border:1px solid #000; width:8%;">&nbsp;</td>
	        <td style="border:none;  width:13%;">&nbsp;</td>
	        <td style="border:none; width:27%;">SEE REVERSE SIDE FOR HELP WITH THE ABOVE SECTION</td>
	        <td style="border:none; width:5%;">&nbsp;</td>
	        <td style="border:none; width:9%;">&nbsp;</td>
	        <td style="border:1px solid #000; width:8%;height:50px;">&nbsp;<br/></td>
	        <td style="border:none; width:8%;">&nbsp;<br/></td>
	        <td style="border-left:1px solid #000; width:7%;">&nbsp;</td>
	      </tr>
	      
	      <tr>
	         <td colspan="7" rowspan="4" style="width:60%; border:none;padding-top:15px;">FOR U.S. EXPORT ONLY: THESE COMMODITIES, TECHNOLOGY, OR SOFTWARE WERE EXPORTED FROM THE UNITED STATES IN ACCORDANCE WITH THE EXPORT ADMINISTRATION REGULATIONS. DIVERSION CONTRARY TO UNITED STATES LAW IS PROHIBITED.</td>
	         <td>&nbsp;</td>
	         <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000;padding-top:5px;font-size:13px;vertical-align:top;text-align:center;height:30px;">Check one<br/><input type="checkbox" />F.O.B. <br/><input type="checkbox" />C & F <br/><input type="checkbox" />C.I.F</td>
	      </tr>
	     
      </table>
      </td>
      </tr>
      
    
  <tr>
 
    <td colspan="2" >I DECLARE ALL THE INFORMATION CONTAINED IN THIS INVOICE TO BE TRUE AND CORRECT.</td> </tr>
    <tr><td colspan="2" style="height:60px;padding-top:0px;">SIGNATURE OF SHIPPER/EXPORTER (Type name and title and sign.) &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  DATE </td></tr>
    <tr><td colspan="2"style="border-top:1px solid #000;padding-top:5px;" >M-1054  REV  2/00  LOGOS 116547 WCS </td>
    
    </tr>
  
  
</table>';
	
echo $html;
$content = ob_get_clean();
ob_end_clean(); // close and clean the output buffer.
require_once("includes/htmltopdf/html2pdf.class.php");

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
