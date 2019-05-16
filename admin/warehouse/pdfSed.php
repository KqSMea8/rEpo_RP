<?
	require_once("../includes/pdf_comman.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$objShipment = new shipment();
	$objSale = new sale();
	if(!empty($_GET['ShippedID'])){	
			 
           	    	$arrySED = $objShipment->listingShipmentDetail($_GET['ShippedID']);
           	
           		$arrySale = $objShipment->GetShipment($_GET['ShippedID'],'','Shipment');
           		$OrderID   = $arrySale[0]['OrderID'];
           		$arrySaleItem = $objSale->GetSaleItem($OrderID);
           		
           		$NumLine = sizeof($arrySaleItem);
	}else{
		echo $ErrorMSG = NOT_EXIST_DATA;exit;
	}
ob_start();

#echo "<pre>";print_r($arrySED);die;
 
$html='<table cellpadding="0" cellspacing="0" style="width:100%; border:1px solid #000; height:auto; font-size:10px;" >
		  <tr>
		    <td style="width:100%; border:1px solid #000; top:5px; text-align:center; height:8; ">FEDEX EEI DATA</td>
		  </tr>
		   <tr><td height="70" style="border:1px solid #000;" cellpadding="0" cellspacing="0">
		       
		        <table border="1"  style="width:100%; height:70;" cellpadding="0" cellspacing="0">
		        <tr>
		                <td style="width:50%; height:70;">
		                <table style="width:100%;" cellpadding="0" cellspacing="0">
		                <tr>
		                <td colspan="2" style="width:50%; height:35; font-size:10px;">U.S. PRINCIPAL PARTY IN INTEREST (USPPI) (Company Name:&nbsp;'.$arryCompany[0]['CompanyName'].',Address:&nbsp;'.$arryCompany[0]['Address'].') 
		                </td>
		                
		                </tr>
		                 <tr>
		                <td style="width:50%; height:35; font-size:10px;">'.$arrySED[0]['CityFrom'].','.$arrySED[0]['StateFrom'].' ,'.$arrySED[0]['CountryFrom'].'
		                </td>
	                    <td style="width:50%; height:35; border:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0">ZIP CODE<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$arrySED[0]['ZipFrom'].'
		                </td>
		                </tr> </table>
		                </td>
		                <td style="width:50%; height:70;">
		                 <table style="width:100%; height:70;" cellpadding="0" cellspacing="0">
		                <tr>
		                <td colspan="2" style="50% vertical-align:top; height:20; font-size:10px;" cellpadding="0" cellspacing="0">Shipper Number: '.$arrySED[0]['ShippedID'].' 
		                </td>
		                </tr>
		                       <tr>
		                <td style="width:50%; height:50; border:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0">2. DATE OF EXPORTATION <br/>&nbsp;&nbsp;&nbsp;'.$arrySED[0]['ShipmentDate'].'
		                </td>
		                <td style="width:50%; height:50; border:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0">3. TRANSPORTATION REFERENCE NO <br/>&nbsp;&nbsp;&nbsp;
          '.$arrySED[0]['RefID'].' 
		                </td>
		                </tr> </table>
		                </td>
		     </tr>
		    
		          </table>
		       
		 </td></tr>
		 <tr><td height="435" style="border:1px solid #000;" cellpadding="0" cellspacing="0">
			  <table border="1" style="width:100%;" cellpadding="0" cellspacing="0">
					  <tr>
					          <td style="width:60%; height:435;">
					          <table style="width:100%;" cellpadding="0" cellspacing="0">
											                <tr>
											                <td style="width:50%; height:40; valign:top; font-size:10px;">b. USPPIS EIN (IRS) OR ID NO.<br><br>
											                </td>
											                <td style="width:50%; height:40; valign:top; font-size:10px;">c. PARTIES TO TRANSACTION<br/>&nbsp;&nbsp;<input type="checkbox" />&nbsp;&nbsp;Related &nbsp;&nbsp;<input type="checkbox" />&nbsp;&nbsp;Non-related
											                </td>
											                </tr>
											                <tr>
											                <td style="width:50%; height:62; font-size:10px;"><br/>4a. ULTIMATE CONSIGNEE ('.$arryCompany[0]['CompanyName'].') 
		   <br/><br/><br/><br/>213 '.$arryCompany[0]['Address'].' 
											                </td>
											                <td style="width:50%; height:62; font-size:10px;">ULTIMATE CONSIGNEE TYPE: D 
											                </td>
											                </tr>
											                <tr>
											                <td colspan="2" style="text-align:left; height:40;">
											                '.$arrySED[0]['CityTo'].' ,'.$arrySED[0]['StateTo'].' ,'.$arrySED[0]['CountryTo'].' 
											                </td></tr>
											                 <tr>
											                <td colspan="2" style="text-align:left; border-top:1px dotted #000; height:40; font-size:10px;">
											                b. INTERMEDIATE CONSIGNEE (Name:&nbsp;'.$arryCompany[0]['CompanyName'].',Address:&nbsp;'.$arryCompany[0]['Address'].')<br><br>Same as Ultimate Consignee
											                </td></tr>
											                 <tr>
											                <td colspan="2" style="text-align:left; border-top:1px solid #000; vertical-align:top; height:40; font-size:10px;">
											                5a. FORWARDING AGENT (Name:&nbsp;'.$arryCompany[0]['CompanyName'].',Address:&nbsp;'.$arryCompany[0]['Address'].')<br/>FEDEX<br/>
											                </td></tr>
											                <tr>
											                <td colspan="2" style="text-align:left; height:40; border-top:1px dotted #000; vertical-align:top; font-size:10px;">
											                5b. FORWARDING AGENT S EIN (IRS) NO.<br/>
											                </td></tr>
											                <tr>
											                <td style="width:50%; height:40; vertical-align: top; border:1px solid #000; text-align:left; font-size:10px;" cellpadding="0" cellspacing="0">8. LOADING PIER (Ocean only)
											                </td>
											                <td style="width:50%; height:40; vertical-align:top; border:1px solid #000; font-size:10px;" cellpadding="0" cellspacing="0">9. METHOD OF TRANSPORTATION (Specify) <br/><br/> '.$arrySED[0]['ShippingMethod'].'
											                </td>
											                </tr>
											                <tr>
											                <td style="width:50%; height:40; vertical-align:top; border:1px solid #000; font-size:10px;">10. EXPORTING CARRIER <br/><br/>United Parcel Service
											                </td>
											                <td style="width:50%; height:40; vertical-align:top; border:1px solid #000; font-size:10px;">11. PORT OF EXPORT
											                </td>
											                </tr>
											                <tr>
											                <td style="width:50%; height:50; vertical-align:top; border:1px solid #000; font-size:10px;">12. PORT OF UNLOADING (Ocean and Air only)
											                </td>
											                <td style="width:50%; height:50; vertical-align:top; border:1px solid #000; font-size:10px;">13. CONTAINERIZED (Ocean only)<br/>&nbsp;&nbsp;&nbsp;<input type="checkbox" />&nbsp;Yes&nbsp;&nbsp;&nbsp; <input type="checkbox" />&nbsp;No
											                </td>
											                </tr>
									</table>
					          </td>
					           <td style="width:40%; height:435;" cellpadding="0" cellspacing="0">
					           <table style="width:100%;margin-top:227px;" cellpadding="0" cellspacing="0">
							     <tr><td colspan="7" height="40">&nbsp;</td></tr>
							     <tr><td style="width:50%; border:1px solid #000; vertical-align:top; height:40; font-size:10px;">6. POINT (STATE) OF ORIGIN OR FTZ LOCATION ID <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
							     <td style="width:50%; border:1px solid #000; height:40; vertical-align:top; font-size:10px;">7. COUNTRY OF ULTIMATE DESTINATION <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
							     </tr>
							     <tr><td style="width:50%; border:1px solid #000; height:40; vertical-align:top; font-size:10px;">14. CARRIER IDENTIFICATION CODE <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							     <td style="width:50%; border:1px solid #000; height:40; vertical-align:top; font-size:10px;">15. SHIPMENT REFERENCE NO.  <br/>&nbsp;&nbsp;&nbsp;&nbsp;'.$arrySED[0]['RefID'].'</td>
							     </tr>
							     <tr><td style="width:50%; border:1px solid #000; height:40; vertical-align:top; font-size:10px;">16. IN BOND NUMBER</td>
							     <td style="width:50%; border:1px solid #000; height:40; vertical-align:top; font-size:10px;">17. HAZARDOUS MATERIALS<br/>&nbsp;&nbsp;&nbsp;<input type="checkbox" />&nbsp;Yes &nbsp;&nbsp;&nbsp;<input type="checkbox" />&nbsp;No</td>
							     </tr>
							     <tr><td style="width:50%; border:1px solid #000; height:40; vertical-align:top; font-size:10px;">18. IN BOND NUMBER TYPE <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							     <td style="width:50%; border:1px solid #000; height:40; vertical-align:top; font-size:10px;">19. ROUTED EXPORT TRANSACTION<br/>&nbsp;&nbsp;&nbsp;<input type="checkbox" />&nbsp;Yes &nbsp;&nbsp;&nbsp;<input type="checkbox" />&nbsp;No</td>
							     </tr>
							     </table>
					           </td>
					          
					          </tr>
		 </table>
		 </td>
		
		 </tr>
		 <tr>
    <td colspan="2" style="border:1px solid #000; font-size:10px;">20. SCHEDULE B DESCRIPTION OF COMMODITIES (Use columns 22-24)</td>
  </tr>
  <tr><td cellpadding="0" cellspacing="0"><table border="1" background="red" style="width:100%;" cellpadding="0" cellspacing="0"><tr>
		    <td style="width:5%; border:1px solid #000;text-align:center; font-size:10px;">D<br/>D<br/>T<br/>C</td>
		    <td style="width:10%; border:1px solid #000;text-align:center; font-size:10px;">Export<br/>Information<br/>Code</td>
		    <td style="width:5%; border:1px solid #000;text-align:center; font-size:10px;">D/F<br/>(21)</td>
		    <td style="width:20%; border:1px solid #000;text-align:center; font-size:10px;">SCHEDULE B NUMBER<br/>(22)</td>
		    <td style="width:17%; border:1px solid #000;text-align:center; font-size:10px;">QUANTITY -<br/>SCHEDULE B UNIT(S)/2nd UOM<br/>(23)</td>
		    <td style="width:12%; border:1px solid #000;text-align:center; font-size:10px;">SHIPPING WEIGHT<br/>IN KILOS<br/>(24)</td>
		    <td style="width:17%; border:1px solid #000;text-align:center; font-size:10px;">VIN/PRODUCT NUMBER/ <br/> VEHICLE TITLE NUMBER <br/> (25)</td>
		    <td style="width:14%; border:1px solid #000;text-align:center; font-size:10px;">VALUE IN U.S. DOLLARS <br/> (26)</td>
		  </tr>
		  <tr>
        <td style="width:5%; border:1px solid #000;text-align:center; font-size:10px;">&nbsp;</td>
        <td style="width:10%; border:1px solid #000;text-align:center; font-size:10px;"></td>
        <td style="width:5%; border:1px solid #000;text-align:center; font-size:10px;"></td>
        <td style="width:20%; border:1px solid #000;text-align:center; font-size:10px;"></td>
        <td style="width:17%; border:1px solid #000;text-align:center; font-size:10px;">'.$arrySED[0]['NoOfPackages'].'</td>
        <td style="width:12%; border:1px solid #000;text-align:center; font-size:10px;">'.$arrySED[0]['Weight'].'</td>
        <td style="width:17%; border:1px solid #000;text-align:center; font-size:10px;">&nbsp;</td>
        <td style="width:14%; border:1px solid #000;text-align:center; font-size:10px;">'.$arrySED[0]['totalFreight'].'</td>
      </tr>
		  </table>
		  </td></tr>
		  <tr>
		  <td style="height:190; border:1px solid #000;" cellpadding="0" cellspacing="0">
		  <table  style="width:100% border:1px solid #000;" cellpadding="0" cellspacing="0">
		        <tr>
		                <td style="width:60%;" cellpadding="0" cellspacing="0">
		                <table style="width:100%; border:1px solid #000;" cellpadding="0" cellspacing="0">
		                <tr>
		                <td  style="border:1px solid #000; width:100%; font-size:10px;" cellpadding="0" cellspacing="0">27. I certify that all statements made and all information contained herein are true and correct and that I have read and understand  the instructions for preparation of this document, set forth in the &quot;Foreign Trade Regulations (15CRF30).&quot; I understand that civil and  criminal penalties, including forfeiture and sale, may be imposed for making false or fraudulent statements herein, failing to provide  the requested informations or for violation of U.S. laws on exportation (13 U.S.C. Sec. 305; 22 U.S.C. Sec. 401; 18 U.S.C. Sec.  1001; 50 U.S.C. App. 2410).</td>
		                </tr>
		                <tr><td cellpadding="0" cellspacing="0"><table style="width:100%; " cellpadding="0" cellspacing="0">
		                <tr><td style="width:50%; border:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0">Signature</td><td style="width:50%; border:1px solid #000;">Confidential - For use solely for official purposes authorized  by the Secretary of Commerce (13 U.S.C., 301 (g)).</td>
		                </tr>
		                <tr><td style="width:50%; border:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0">Title</td><td style="width:50%; border:1px solid #000;">Export shipments are subject to inspection by U.S. Customs  and Border Protection and/or Office of Export Enforcement.</td>
		                </tr>
		                <tr><td style="width:50%; border:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0">Date</td><td style="width:50%; border:1px solid #000;">The USPPI authorizes the forwarder named above to act as a  forwarding agent for export control and customs purposes.</td>
		                </tr>
		                <tr><td style="width:50%; border:1px solid #000; vertical-align:top; font-size:10px;" cellpadding="0" cellspacing="0">Telephone No. (Include area code)</td><td style="width:50%; border:1px solid #000;">E-mail address.</td>
		                </tr>
		                </table></td></tr>
		                </table>
		                </td>
		                </tr>
		                </table>
		  
		  </td>
		  </tr>
 
</table>';
  
echo $html;
$content = ob_get_clean();
ob_end_clean(); // close and clean the output buffer.
require_once("../includes/htmltopdf/html2pdf.class.php");

try { 
	$ModulePDFID  = $arrySED[0]['ShippedID'];
	$ModDepName  = $arrySED[0]['ShippingMethod'].'-SED';

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
