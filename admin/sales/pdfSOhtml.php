<?php	
 	require_once("../includes/settings.php");
	require_once($Prefix."classes/sales.quote.order.class.php");

	$objSale=new sale();
	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];


	if($module=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixSO = "QT";  $NotExist = NOT_EXIST_QUOTE; 
	}else{
		$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID"; $PrefixSO = "SO";  $NotExist = NOT_EXIST_ORDER;
	}
	$ModuleName = "Sale ".$module;
        $recordpdftemp=array();
	if(!empty($_GET['o'])){
	 	$arrySale = $objSale->GetSale($_GET['o'],'',$module);
		$OrderID   = $arrySale[0]['OrderID'];	
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
		}else{
			$ErrorMSG = $NotExist;
		}
               }else{
		$ErrorMSG = NOT_EXIST_DATA;
	}

	if(!empty($ErrorMSG)) {
		echo $ErrorMSG; exit;
	}

	/*******************************************/
        //echo '<pre>'; print_r($arryCompany);die;
	if(!empty($arrySale[0]['CreatedByEmail'])){
		$arryCompany[0]['Email']=$arrySale[0]['CreatedByEmail'];
	}
	/*******************************************/
	
	
	 $Title = $ModuleName." # ".$arrySale[0][$ModuleID];
         
         
         /***Start Data for Order InFormation***/
         $OrderDate = ($arrySale[0]['OrderDate']>0)?(date($_SESSION['DateFormat'], strtotime($arrySale[0]['OrderDate']))):(NOT_MENTIONED);
        $Approved = ($arrySale[0]['Approved'] == 1)?('Yes'):('No');

	$DeliveryDate = ($arrySale[0]['DeliveryDate']>0)?(date($_SESSION['DateFormat'], strtotime($arrySale[0]['DeliveryDate']))):(NOT_MENTIONED);

	$PaymentTerm = (!empty($arrySale[0]['PaymentTerm']))? (stripslashes($arrySale[0]['PaymentTerm'])): (NOT_MENTIONED);
	$PaymentMethod = (!empty($arrySale[0]['PaymentMethod']))? (stripslashes($arrySale[0]['PaymentMethod'])): (NOT_MENTIONED);
	$ShippingMethod = (!empty($arrySale[0]['ShippingMethod']))? (stripslashes($arrySale[0]['ShippingMethod'])): (NOT_MENTIONED);
	$Comment = (!empty($arrySale[0]['Comment']))? (stripslashes($arrySale[0]['Comment'])): (NOT_MENTIONED);

         /***End Data for Order InFormation***/	               
	if($arryCompany[0]['Image'] !='' && file_exists($Prefix.'upload/company/'.$arryCompany[0]['Image']) ){

		$SiteLogo = $Prefix.'upload/company/'.$arryCompany[0]['Image'];
		$LogoStyle = "style='margin-bottom:10px;'";
		list($LogoWidth, $LogoHeight) = getimagesize($SiteLogo);
		if($LogoWidth>350 || $LogoHeight>150){	
			$SiteLogo = $Prefix.'resizeimage.php?w=150&h=150&img=upload/company/'.$arryCompany[0]['Image'];
			$LogoStyle = '';
		}
	}else if($_SESSION['CmpLogin']==1){
			$SiteLogo = $Prefix.'images/logo_crm.png';		
	}else{
		$SiteLogo = $Prefix.'images/logo.png';
	}

        /**start code for dynamic pdf***/
                require_once("includes/pdf_order_dynamicdata.php");
                require_once("includes/pdf_order_dynamichtmldata.php");
        /**end code for dynamic pdf****/
        
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
 	<tr>';if($CompanyAlign=='right' && $informationAlign=='left'){$html.=$TitleShow;}
        else {$html.=$companyInfoShow;}
        if($CompanyAlign=='right' && $informationAlign=='left'){$html.=$companyInfoShow;}
        else{$html.=$TitleShow;}
 	$html.='</tr>
        <tr>';
        $html.='<td style="vertical-align:top;">';if($CompanyAlign=='right' && $informationAlign=='left'){$html.=$informationdata;
         }else{$html.=$Cmpanyimg;}
         $html.='</td>';
	 
         $html.='<td style="vertical-align:top;">';if($CompanyAlign=='right' && $informationAlign=='left'){$html.=$Cmpanyimg;}
                 else{$html.=$informationdata;}
                 $html.='</td>
 </tr>
 <tr>
 	<td style="width:210px; margin-top:30px; padding:0px; border:1px solid #e3e3e3;">';
        if($BillingAlign=='right' && $ShippingAlign=='left'){$html.=$ShippingAddress;}else{$html.=$BillingAddress;}
 	$html.='</td>
 	<td style="width:320px; height:auto; margin-top:15px; padding:0px; border:1px solid #e3e3e3;">';
 	if($BillingAlign=='right' && $ShippingAlign=='left'){$html.=$BillingAddress;}else{$html.=$ShippingAddress;}
 	$html.='</td>
 </tr>
 
 
  <tr>
 	<td colspan=2  style="width:100%; margin-top:6px; ">';
	 	$html.=$LineItem;
 	$html.='</td>
 </tr>
 <tr>
<td colspan=2>';
    $html.='<table style="width:100%" >
                            <tr>

                                <td style="float:left; width:366px; border:1px solid #e3e3e3;" >';
                                    $html.=$specialNotes;
                                       
                                $html.='</td>

                                <td style="float:right; width:47%;  vertical-align: text-top;" align="right">';
                                
                                $html.=$TotalDataShow;
                                
                                $html.='</td>
                            </tr>	
                        </table>';
$html.='</td>
 </tr>
 
 
 
 <tr>
 <td colspan=2 style="width:100%; margin-top:10px; text-align:center">
 	<p style="text-align:center; font-size:'.$specialFieldFontSize.'px; color:'.$specialFieldColor.';">Adobe information is not an invoice and only an estimate of services/goods. described adobe.
 	Adobe information is not an invoice and only an estimate of services/goods. described adobe
 	Adobe information is not an invoice and only an estimate of services/goods. described adobe.</p>
 </td>
 </tr>
 
<tr>
 <td colspan=2 style="margin-top:10px; width:100%; text-align:center">
 	<p style="font-size:'.$specialFieldFontSize.'px; color:'.$specialFieldColor.';">Please confirm your acceptance of this quote by signing this document.</p>
 </td>
 </tr>
 
 
 <tr>
 	<td colspan=2 >
 		<table style="width:100%" >
 			<tr>
 				<td style="width:33%; font-size:'.$specialFieldFontSize.'px; color:'.$specialFieldColor.';">Name</td>
 				<td style="width:33%; font-size:'.$specialFieldFontSize.'px; color:'.$specialFieldColor.';">Signature</td>
 				<td style="width:33%; font-size:'.$specialFieldFontSize.'px; color:'.$specialFieldColor.';">Date</td>
 				
 			</tr>
 		</table>
 	</td>
 </tr>
 
 
  <tr>
 	<td colspan=2 style="width:100%; margin:10px 0;text-align:center;"  >
 		<h3 style="font-size:'.$thanksFontSize.'px; text-align:center; font-weight:bold; color:'.$specialFieldColor.';">Thank you for your business!</h3>
 	</td>
 </tr>
 
 </table>';

 echo $html;
//$html='<h1>.testtstststtsts.</h1>';
//echo $html;
    $content = ob_get_clean();
ob_end_clean(); // close and clean the output buffer.
    // convert in PDF
    require_once("../includes/htmltopdf/html2pdf.class.php");
   
    try
    { //echo $content;

        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        /**code for Dynamic pdf name download link **/
     // $nn=date('F-Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01'));
    /**code for Dynamic pdf name download link **/
        $nn=$arrySale[0][$ModuleID];
  
         /**code for PDf Priview **/
        if($_GET['editpdftemp']=='1'){
            $html2pdf->Output('Sales-'.$nn.'.pdf');
//            $html2pdf->stream('Sales-'.$nn.'.pdf');
        }
           

         /**code for download link **/
        if($_GET['attachfile']=='1'){
        chmod('upload/pdf', 0777);
        $html2pdf->Output('upload/pdf/Sales-'.$nn.'.pdf','F');    // Save file to dir
        }
        $html2pdf->Output('Sales-'.$nn.'.pdf','D');        // Download File
        /**code for download link **/

    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
?>

