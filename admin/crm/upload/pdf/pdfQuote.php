<?php	#if($_SERVER['HTTP_REFERER'] == '') { echo exit(); }

require_once("../includes/settings.php");
CleanGet();
	if($AttachFlag!=1){
		require_once($Prefix."classes/quote.class.php");		
		
	}
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$objQuote=new quote(); $objLead=new lead(); $objCustomer=new Customer(); 
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];
	$ModuleIDTitle = "Quote Number"; $ModuleID = "quoteid"; $PrefixSO = "QT";  $NotExist = NOT_EXIST_QUOTE; 
	$ModuleName = "Quote ";
	if(!empty($_GET['o'])){
	 	$arryQuote = $objQuote->GetQuote($_GET['o'],'','');
		if($arryQuote[0]['OpportunityID']>0){
			$arryOpp = $objLead->GetOpportunity($arryQuote[0]['OpportunityID'],'');
		}
		$OpportunityName = (!empty($arryOpp[0]['OpportunityName']))?(stripslashes($arryOpp[0]['OpportunityName'])):(stripslashes($arryQuote[0]['opportunityName']));
		if($arryQuote[0]['CustID']>0){
			$arryCustomer = $objCustomer->GetCustomer($arryQuote[0]['CustID'],'','');
		}
		$CustomerName = (!empty($arryCustomer[0]['FullName']))?(stripslashes($arryCustomer[0]['FullName'])):(stripslashes($arryQuote[0]['CustomerName']));



         	$arryQuoteAdd = $objQuote->GetQuoteAddress($arryQuote[0]['quoteid'],'');

		$OrderID   = $arryQuote[0]['quoteid'];	
		if($OrderID>0){
			$arryQuoteItem = $objQuote->GetQuoteItem($OrderID);

			
			$NumLine = sizeof($arryQuoteItem);
		}else{
			$ErrorMSG = NOT_EXIST_RETURN;
		}
	}else{
		$ErrorMSG = NOT_EXIST_DATA;
	}

	if(!empty($ErrorMSG)) {
		echo $ErrorMSG; exit;
	}

	/*******************************************/
	if(!empty($arryQuote[0]['CreatedByEmail'])){
		$arryCompany[0]['Email']=$arryQuote[0]['CreatedByEmail'];
	}
       
        //print_r($Config[]).'<br>';
       // echo '==============Quote==========================';
       // echo $NumLine;

        
	/*******************************************/
//	$pdf = new Creport('a4','portrait');
//	$pdf->selectFont($Prefix.'fonts/Helvetica.afm');
//	$pdf->ezSetMargins(20,20,50,50);

	#FooterTextBox($pdf);

	//TitlePage($arry, $pdf);
	//TargetPropertySummary($arry,$arryLocation,$arryCounty,$GEOMETRY,$ZipCovered,$StateCovered,$pdf);

	 $Title = $ModuleName." # ".$arryQuote[0][$ModuleID];
	// HeaderTextBox($pdf,$Title,$arryCompany);

	/*******************************************/
	/***************start html to pdf****************************/
	//require_once("includes/pdf_order.php");
	$Address = str_replace("\n"," ",stripslashes($arryQuoteAdd[0]['bill_street']));
	

	$ShippingAddress = str_replace("\n"," ",stripslashes($arryQuoteAdd[0]['ship_street']));
        $SiteLogo =$Config['Url'].'resizeimage.php?w=120&h=120&bg=f1f1f1&img=upload/company/'.$arryCompany[0]['Image'];
        $SiteLogo = !empty($SiteLogo)?$SiteLogo:$Config['Url'].'/upload/company/logo.png';
 $html='
 <style>
table#mainTable{
 	width:635px;
 	margin-left:35px;
 	margin-top:30px;
        font-family:Arial, Helvetica, sans-serif; 
        color:#000000; 
        font-size:12px;
        font-weight:500;
        img border:none;
 }
 </style>
 <table id="mainTable" >
 	<tr>
 		<td style="width:50%;margin:0px; padding:0px;" >
 			<h1  style="font-size:22px; margin-top:6px;">'.$Config['SiteName'].'</h1>
                             
 			       <span style="font-size:22px; font-size:12px; display:block;">'.stripslashes($arryCurrentLocation[0]['Address']).", ".stripslashes($arryCurrentLocation[0]['City']).",<br>".stripslashes($arryCurrentLocation[0]['State']).", ".stripslashes($arryCurrentLocation[0]['Country'])."-".stripslashes($arryCurrentLocation[0]['ZipCode']).'</span><br/>
                               
 		</td>
 		<td style="width:50%;font-size:20px; font-weight:bold; color:#003c64; margin-top:6px;text-align:right" >'.$Title.'</td>
 	</tr>

        <tr>
	 <td>
               <h4><img src="'.$SiteLogo.'"></h4>
	 </td>
	 
	 <td>
	 	<table style="width:289px; cellpadding:0; cellspacing:0;">
	 	<tr>
	 		<td style="width:110px;border:none; padding:5px 10px;">Date</td>
	 		<td style="width:159px;border:1px solid #cacaca; padding:5px 10px; border-bottom:none;">'.$arryQuote[0]["PostedDate"].'</td>
	 	</tr>
	 	 <tr>
            <td style="border:none; padding:5px 10px;">Valid Until</td>
            <td style="border:1px solid #cacaca; padding:5px 10px; border-bottom:none;">'.$arryQuote[0]["validtill"].'</td>
          </tr>
          <tr>
            <td style="border:none; padding:5px 10px;">Quote#</td>
            <td style="border:1px solid #cacaca; padding:5px 10px; border-bottom:none;">'.$arryQuote[0]["quoteid"].'</td>
          </tr>
          <tr>
            <td style="border:none; padding:5px 10px;">Customer ID</td>
            <td style="border:1px solid #cacaca; padding:5px 10px; ">'.$arryQuote[0]["CustID"].'</td>
          </tr>
	 	</table>
	 </td>
 </tr>
 
 
 <tr>
 	<td style="width:210px; margin-top:30px; padding:0px; border:1px solid #e3e3e3;">
        <table>
                <tr>
                <td style="width:270px;font-size:12px; background:#004269; color:#fff; padding:5px 10px;">Billing Address</td>
                </tr>  
                <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;">'.$arryQuote[0]["CustomerName"].'</td>
                </tr>  
                <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;">'.$arryQuote[0]["CustomerCompany"].'</td>
                </tr>  
                <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;">'.$Address.'</td>
                </tr>  
                
                <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;"> '.stripslashes($arryQuoteAdd[0]["bill_city"]).'</td>
                </tr>  
                 <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;"> '.stripslashes($arryQuoteAdd[0]["bill_state"]).'</td>
                </tr>
                <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;"> '.stripslashes($arryQuoteAdd[0]['bill_country']).'</td>
                </tr> 
                <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;"> '.stripslashes($arryQuoteAdd[0]['bill_code']).'</td>
                </tr> 

      </table>
 		
 		
 	</td>
 	<td style="width:320px; height:auto; margin-top:15px; padding:0px; border:1px solid #e3e3e3;">
 	  <table>
                <tr>
                <td style="width:315px;font-size:12px; background:#004269; color:#fff; padding:5px 10px;">Shipping Address</td>
                </tr>  
                <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;">'.$arryQuote[0]["ShippingName"].'</td>
                </tr>  
                <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;"> '.$arryQuote[0]["ShippingCompany"].'</td>
                </tr>  
                
                <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;">'.$ShippingAddress.'</td>
                </tr>  
                
                <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;"> '.stripslashes($arryQuoteAdd[0]["ship_city"]).'</td>
                </tr>  
                 <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;"> '.stripslashes($arryQuoteAdd[0]["ship_state"]).'</td>
                </tr>
                <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;"> '.stripslashes($arryQuoteAdd[0]['ship_country']).'</td>
                </tr> 
                <tr>
                <td style="font-size:12px; line-height:22px; margin:8px 0 8px 10px; text-align:left;"> '.stripslashes($arryQuoteAdd[0]['ship_code']).'</td>
                </tr> 

      </table>
 	
 	</td>
 </tr>
 
 
  <tr>
 	<td colspan=2  style="width:100%; margin-top:6px; ">
	 	<table style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse;" >
	 		<tr style=" background:#004269;">
	 			<td  style="width:10%;border:1px solid #e3e3e3;color:#fff;text-align:center;">SKU</td>
                                <td  style="width:30%; border:1px solid #e3e3e3;color:#fff; text-align:center;">Description</td>
                                <td  style="width:15%; border:1px solid #e3e3e3;color:#fff;text-align:center;">Qty Ordered</td>
                                <td  style="width:10%; border:1px solid #e3e3e3;color:#fff;text-align:center;">Unit Price</td>
                                <td  style="width:10%; border:1px solid #e3e3e3;color:#fff;text-align:center;">Discount</td>
                                <td  style="width:10%; border:1px solid #e3e3e3;color:#fff;text-align:center;">Taxable</td>
                                <td style="width:15%; border:1px solid #e3e3e3; color:#fff; text-align:center;">Amount</td>
	 		</tr>';	


                        if (is_array($arryQuoteItem) && $NumLine> 0) {
                            $flag = true;
                            $Line = 0;
                            $subtotal=0;
                             $total_received = 0;
                            foreach ($arryQuoteItem as $key => $values) {
                                $flag = !$flag;
                                $Line++;
                                if( ($Line % 2) !='1') {$even='background:#ececec';}else{ $even='';}
                                
                                $TaxRate = $Rate.number_format($values["tax"],2);
		if(empty($values['Taxable'])) $values['Taxable']='No';
               
		
	    $description = stripslashes($values["description"]);
	    if(!empty($values["DesComment"]))  $description .= "\n<b>Comments: </b>".stripslashes($values["DesComment"]);
			$subtotal += $values["amount"];
                        $discount += $values["discount"];
			$TotalQtyReceived += $total_received;
			
                $CustDisAmt = $arryQuote[0]['CustomerCurrency']." ".number_format($arryQuote[0]['CustDisAmt'],2);
		//$subtotal = $arryQuote[0]['CustomerCurrency']." ".number_format($subtotal,2);
		$Freight = $arryQuote[0]['9acf9a']." ".number_format($arryQuote[0]['Freight'],2);
		$taxAmnt = $arryQuote[0]['CustomerCurrency']." ".number_format($arryQuote[0]['taxAmnt'],2,'.','');
		$TotalAmount = $arryQuote[0]['CustomerCurrency']." ".number_format($arryQuote[0]['TotalAmount'],2);

		$TotalTxt .=  "Sub Total : ".$subtotal;
		$TotalTxt .= "\nTax : ".$taxAmnt;
               if($arryQuote[0]['MDType']) $TotalTxt .="\n".$arryQuote[0]['MDType'].":".$CustDisAmt;
		$TotalTxt .= "\nFreight : ".$Freight;
		$TotalTxt .= "\nGrand Total : ".$TotalAmount;
	 		$html.='<tr style='.$even.'>
	 			<td style="width:10%; text-align:center;" >'.stripslashes($values['sku']).'</td>
	 			<td style="width:30%; text-align:center;" >'.stripslashes($values['description']).'</td>
                                <td style="width:15%; text-align:center;" >'.stripslashes($values['qty']).'</td>
	 			<td style="width:10%; text-align:center;" >'.stripslashes($values['price']).'</td>
                                <td style="width:10%; text-align:center;" >'.stripslashes($values['discount']).'</td>
	 			<td style="width:10%; text-align:center;" >'.stripslashes($values['Taxable']).'</td>
	 			<td style="width:15%; text-align:center;" >'.stripslashes($values['amount']).'</td>
	 		</tr>';	
                         
                                 } }

	 		$html.='
	 	</table>
 	</td>
 </tr>
  
 
 
 
 
 
<tr>
<td colspan=2  >
        <table style="width:100%" >
                <tr>

        <td style="float:left; width:366px; border:1px solid #e3e3e3;" >
               <table>
                <tr>
                <td style="width:330px;font-size:12px; background:#004269; color:#fff; padding:5px 10px;">Special Notes and Instructions</td>
                </tr>  
                <tr>
                <td style="margin:10px 0 0 10px; font-size:11px; line-height:22px; margin:8px 0 8px 10px; text-align:left;">Subject : '.stripslashes($arryQuote[0]["subject"]).'</td>
                </tr>  
                <tr>
                <td style="margin:10px 0 0 10px; font-size:11px; line-height:22px; margin:8px 0 8px 10px; text-align:left;"> Opportunity : '.stripslashes($arryQuote[0]["validtill"]).'</td>
                </tr>  
                <tr>
                <td style="margin:10px 0 0 10px; font-size:11px; line-height:22px; margin:8px 0 8px 10px; text-align:left;">Quote Stage:'.stripslashes($arryQuote[0]["quotestage"]).'</td>
                </tr>  
                <tr>
                <td style="margin:10px 0 0 10px; font-size:11px; line-height:22px; margin:8px 0 8px 10px; text-align:left;"> Valid till:'.stripslashes($arryQuote[0]["validtill"]).'</td>
                </tr>  
                 <tr>
                <td style="margin:10px 0 0 10px; font-size:11px; line-height:22px; margin:8px 0 8px 10px; text-align:left;"> PaymentType: '.stripslashes($arryQuote[0]["PaymentMethod"]).'</td>
                </tr>  

      </table>
              <p style=" margin:10px 0 0 10px; font-size:11px;">Once signed, please Fax mail or e-mail it to the provided address.</p><br><br><br><br><br>
        </td>
	 			
<td style="margin:0px; padding:20px; width:39%;" >
<table style="width:100; border:none; cellpadding:0; cellspacing:0;margin:0px; padding:0px;">
  <tr>
    <td width="83" style="padding:5px 10px;">Subtotal</td>
    <td width="82" style="padding:5px 10px;">$  <span style="text-align:right;">'.$subtotal.'</span> </td>
  </tr>
  <tr>
    <td style="padding:5px 10px;">Tax</td>
    <td style="border:1px solid #cacaca; border-bottom:none;padding:5px 10px;"><span style="text-align:right;">'.$TaxRate.'</span></td>
  </tr>
  <tr>
    <td style="padding:5px 10px;">Freight</td>
    <td style="border:1px solid #cacaca;">% <span style="text-align:right;">'.$Freight.'</span></td>
  </tr>
  
  <tr>
    <td style="padding:5px 10px;">GrandTotal</td>
    <td style="padding:5px 10px;">$ <span style="text-align:right;">'.$TotalAmount.'</span></td>
  </tr>
</table>
	 			</td>
	 		</tr>	
	 	</table>
 	</td>
 </tr>
 
 
 
 <tr>
 <td colspan=2 style="width:100%; margin-top:10px; text-align:center">
 	<p style="text-align:center;"></p>
 </td>
 </tr>
 
<tr>
 <td colspan=2 style="margin-top:10px; width:100%; text-align:center">
 	<p>Please confirm your acceptance of this quote by signing this document.</p>
 </td>
 </tr>
 
 <tr>
 <td colspan=2 style="width:100%; margin-top:10px; text-align:center">
 	<p style="text-align:center;"></p>
 </td>
 </tr>
<tr>
 <td colspan=2 style="width:100%; margin-top:10px; text-align:center">
 	<p style="text-align:center;"></p>
 </td>
 </tr>
 <tr>
 	<td colspan=2 >
 		<table style="width:100%" >
 			<tr>
 				<td style="width:33%" >Name</td>
 				<td style="width:33%">Signature</td>
 				<td style="width:33%">Date</td>
 				
 			</tr>
 		</table>
 	</td>
 </tr>
 
 
  <tr>
 	<td colspan=2 style="width:100%; margin:10px 0;text-align:center;"  >
 		<h3 style="font-size:13px; text-align:center; font-weight:bold;">Thank you for your business!</h3>
 	</td>
 </tr>
 
 </table>';

 //echo $html;
//$html='<h1>.testtstststtsts.</h1>';
echo $html;
    $content = ob_get_clean();
ob_end_clean(); // close and clean the output buffer.
    // convert in PDF
    require_once("../includes/htmltopdf/html2pdf.class.php");
   
    try
    { //echo $content;

        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
 	$nn = $arryQuote[0][$ModuleID];
        
        //echo $_GET['attachfile'];d