<?
require_once("includes/settings.php");
$date = $Config['TodayDate'];
$date = (explode("-",$date));
$date =$date[0];

$SerialHead = '';
require_once("comman_pdf_header.php"); 

	require_once($Prefix."classes/supplier.class.php");
	require_once($Prefix."classes/finance.account.class.php");
	$objSupplier=new supplier();
   $objBankAccount=new BankAccount();
	if (!empty($_GET['code'])) { 
		$arrySupplier = $objSupplier->GetSupplier('',$_GET['code'],'');
	}

/******************* Company Details ***************/
	if($arryCompany[0]['VAT']!=''){
		$VAT = stripslashes($arryCompany[0]['VAT']);
	}else{
		$VAT = NOT_SPECIFIED;
	} 
	
	if($arryCompany[0]['EIN']!=''){
		$EIN = stripslashes($arryCompany[0]['EIN']);
	}else{
		$EIN = NOT_SPECIFIED;
	}
/************************************************/	
/******************* Vendor Details **************/	
	if($arrySupplier[0]['VendorName']!=''){
		$name = $arrySupplier[0]['VendorName'];
	}else{
		$name = NOT_SPECIFIED;
	}

	if($arrySupplier[0]['Address']!=''){
		$address = $arrySupplier[0]['Address'];
	}else{
		$address = NOT_SPECIFIED;
	}
	
	if($arrySupplier[0]['Country']!=''){
		$country = stripslashes($arrySupplier[0]['City']).',<br/>'.stripslashes($arrySupplier[0]['State']).', '.stripslashes($arrySupplier[0]['Country']).'-'.stripslashes($arrySupplier[0]['ZipCode']);
	}else{
		$country = NOT_SPECIFIED;
	}
/******************* *****************************/	
/********************* Amount ********************/	 
$Amount = 0;

if(!empty($_GET['code'])) { 
	$_GET['SuppCode'] = $_GET['code'];
	$arryPaymentInvoice = $objBankAccount->ListPaidPaymentInvoice($_GET);
 
	if(!empty($arryPaymentInvoice)){	  	 
	  	foreach($arryPaymentInvoice as $key=>$values){	
			 
			$AmountPay = $values['CreditAmnt'];
			if(!empty($values['GLID']) && empty($values['InvoiceID']) && empty($values['CreditID']) ){  
				$AmountPay = $values['DebitAmnt'];
			}  
			$Amount += $AmountPay;
	  	}
	}
}

 
/*******************************************/
$html.='<style>
body{   margin:5px;
		
		line-height: 1.5;
		font-weight:500;
		font-size:14px;
		
	}
	
	p{margin:0px; padding:0px;}

	table, tr, td{
		border:1px solid #ccc;
		border-collapse:collapse;
		vertical-align:top;
		
	}
	input {
		border:none;
		width:90%;
	}
	textarea {
		border:none;
	}
	table {width:100%;
    
    margin: auto;
}

 </style>
 
		    <table  border="1" cellspacing="10" cellpadding="10" style="width=100%;">
		               <tr>
		                     <td style="text-align:center">Attention:
		                     </td>
		              </tr>
		              <tr>
		                    <td><p>Copy A of this form is provided for informational purposes only. Copy A appears in red, similar to the official IRS form.The official printed version of Copy A of this IRS form is <br />
							      scannable, but the online version of it, printed from this website, is not. Do not print and file copy A downloaded from this website; a penalty may be imposed for filing with the IRS information <br />
							      return forms that can t be scanned. See part 0 in the current General Instructions for Certain Information Returns, available at <a href="https://www.irs.gov/uac/about-form-1099"> www.irs.gov/form1099</a>, for more information about penalties.</p>
							      <p>Please note that Copy B and other copies of this form, which appear in black, may be downloaded and printed and used to satisfy the requirement to provide the information to the recipient.</p>
							      <p>To order official IRS information returns, which include a scannable Copy A for filing with the IRS and all other applicable copies of the form, visit<a href="https://www.irs.gov/forms-pubs/order-products"> www.IRS.gov/orderforms</a>. Click on <a href="https://www.google.co.in/search?q=Employer+and+Information+Returns&oq=Employer+and+Information+Returns&aqs=chrome..69i57.935j0j4&sourceid=chrome&ie=UTF-8">Employer and 
							        Information Returns</a>, and we ll mail you the forms you request and their instructions, as well as any publications you may order.</p>
							      <p>Information returns may also be filed electronically using the IRS Filing Information Returns Electronically (FIRE) system (visit <a href="https://www.irs.gov/tax-professionals/e-file-providers-partners/filing-information-returns-electronically-fire">www.IRS.gov/FIRE</a>) or the IRS Affordable Care Act Information 
							        Returns (AIR) program (visit www.IRS.gov/AIR).</p>
							      <p>See IRS Publications 1141, 1167, and 1179 for more information about printing these tax forms.<br />
							      </p>
		      					<p><br />
		   						</p>
		    				</td>
		  			</tr>
		</table>
	 
                  					<br /><br />
     
		<table border="0" cellspacing="0" cellpadding="5px" style="width:100%; margin:auto; text-align: center;">
		  			<tr>
		    				<td>
		      						<input type="checkbox" />
		    						VOID
		    						<input type="checkbox" />
		   							CORRECTED
		   					</td>
		  			</tr>
		</table>
		
		<table border="0" cellspacing="0" cellpadding="5px" style="margin:auto; width:100%; ">
		  			<tr>
		    				<td rowspan="2" style="width:35%; ">PAYER S name,street address, city or town, state or province, country, ZIP or foreign postal code,and telephone no.<br />
		    					
		 <span style="margin:10px;text-align:left; width: 423px; height: 20px;"><b>'.stripslashes($arryCompany[0]['CompanyName']).'</b>
		  <br /><b>'.stripslashes($arryCompany[0]['Address']).', '.stripslashes($arryCompany[0]['City']).',<br/>'.stripslashes($arryCompany[0]['State']).', '.stripslashes($arryCurrentLocation[0]['Country']).'-'.stripslashes($arryCurrentLocation[0]['ZipCode']).' <br/></b></span><br /><br />
		    </td>
		     				<td style="width:20%;"><p>1 Rents</p>
		                      		<p>$
		      					<input type="type" />
		    						</p>
		    				</td>
		     				<td rowspan="2" style="width:20%;"><p>OMB No. 1545-0115</p><br />
		     					 <p style="text-align:center"><b>'.$date.'</b></p><br />
		     					 <p>Form <b>1099-MISC</b><br />
		    					</p>
		   				   </td>
		   				  <td rowspan="2" style="width:20%;">Miscellaneous<br />
		    					Income<br />
		    			 </td>
		          </tr>
		          <tr>
		                <td style="width:20%;"><p>2Royalties</p>
		                    <p>$
		                        <input type="text" />
		                   </p>
		               	</td>
		 		 </tr>
		 		  <tr>
		    				<td  style="width:35%; ">&nbsp;
		    				</td>
		     				<td style="width:20%;">3 Other incom<br />
		                      		$
		      					<input type="type" />
		    						
		    				</td>
				<td  style="width:20%;">4 Federalincome tax withheld<br />
		    					$
		   				   </td>
		   				  <td rowspan="2" style="width:20%;"><p>Copy A<br />
						      For InternalRevenue Service Center<br />
						    </p>
						      <p>File with Form 1098.<br />
						    </p></td>
		          </tr>
		          <tr>
				                       
				   <td style="width:35%;" >
			    <table width="35%" border="1" cellspacing="0" cellpadding="0" >
      <tr>
        <td style="width:50%;">PAYER S federal Identification number<br /><br />
        <span style="margin: 10px; width: 423px; height: 20px;""><b>'.$EIN.'</b></span>	<br /><br />
        </td>
        <td style="width:50%;">RECIPIENT S Identification number<br /><br />
        	  <span style="margin: 10px; width: 423px; height: 20px;""><b>'.$VAT.'</b></span><br /><br />	
         </td>
       
      </tr>
     </table>
     </td>
				  
				    <td style="width:20%;"><p>5 Fishing boat proceeds<br />
				    </p>
				      <p>$
				      <input type="text" />
				    </p></td>
				    <td style="width:20%;"><p>8 Medical and health care paymenl$<br />
				      </p>
				      <p>$
				       <input type="text" />
				    </p></td>
				</tr>
		 		 <tr>
				    <td style="width:35%;">RECIPIENT S name<br />
				    <span  style="margin: 10px; width: 423px; height: 20px;"> <b>'.$name.'</b></span></td>
				    <td style="width:20%;"><p>7 Nonemployee compensation</p>
				      <p>&nbsp;</p>
				      <p>$ <b>'.number_format($Amount,2).'</b>
				    </p></td>
				    <td style="width:20%;"><p>8 Substitute payments in lieu of<br />
				      dividends or interest<br />
				    </p>
				      <p>$
				      <input type="text" />
				    </p></td>
				    <td style="width:20%;" rowspan="4">For Privacy Act<br />
				      and Paperwork Reduction Act Notice,see the<br />
				      2017 General Instructions for Certain lnfonnation<br />
				    Returns.<br /></td>
			</tr> 
			 <tr>
			    <td style="width:35%;">Street address (including apt. no.)<br /><span style="margin: 10px; width: 422px; height: 20px;"><b>'.$address.'</b></span></td>
			    <td style="width:20%;">9 Payer made direct sales of<br />
			      $5,000 or more of consumer products to a buyer<br />
			    (recipient) for resale 110-D<br /><input type="checkbox" /></td>
			    <td style="width:20%;"><p>10 Crop insurance proceeds</p>
			      <p>$
			      <input type="text" />
			    </p></td>
		   </tr>
		    <tr>
			    <td style="width:20%;">City or town,state or province,country,and ZIP or foreign postalcode<br /><span style="margin: 10px; width: 422px; height: 20px;"><b>'.$country.' <br/></b></span></td>
			    <td style="width:20%;">11<br /></td>
			    <td style="width:20%;">12<br /></td>
            </tr>
            <tr>
			    <td style="width:35%;" >
			    <table  border="1" cellspacing="0" cellpadding="0" >
      <tr>
        <td style="width:40%;">Account number (see instructions) <br /><input type="text" /></td>
        <td style="width:30%;">FATCA filing<br />
          requirement<br />
          D<br /><input type="checkbox" /></td>
        <td style="width:30%;">2nd TIN not.<br />
          D<br /><input type="checkbox" /></td>
      </tr>
     </table>
     </td>
			    <td style="width:20%;"><p>13 Excess golden parachute<br />
			      payments<br />
			    </p>
			      <p>$
			      <input type="text" />
			    </p></td>
			    <td style="width:20%;"><p>14 Gross proceeds paid to an<br />
			      attorney<br />
			    </p>
			      <p>$
			      <input type="text" />
			    </p></td>
			</tr>
			 <tr>
			 <td style="width:35%;" >
			    <table width="35%" border="1" cellspacing="0" cellpadding="0" >
      <tr>
        <td style="width:50%;">15a section 409A deferrals <br />$<input type="text" /></td>
        <td style="width:50%;">15b Section 409A income<br />$<input type="text" />
         </td>
       
      </tr>
     </table>
     </td>
			    <td style="width:20%;">16 State tax withheld<br />
        $ <input type="text"></td>
			    <td style="width:20%;">17 State/Payer s state no.<br />
			    <input type="text"></td>
			    
			     <td style="width:20%;">18 State income<p style="display: flex;">$<input type="text"></p>
			    </td>
				    
		   </tr>
		   <tr>
			  <td style="width:35%;" >
			    <table width="35%" border="1" cellspacing="0" cellpadding="0" >
      <tr>
        <td style="width:50%;">Form <b>1099-MISC</b><br /><br />
        </td>
        <td style="width:50%;">Cal.No.14425J<br /><br /><br />
        
         </td>
       
      </tr>
     </table>
     </td>
			    <td style="width:65%;" colspan="3">www.irs.govfform1099misc &nbsp;&nbsp;Department of the Treasury- InternalRevenue Service</td>
			   
			    
		   </tr>
				    	 
    </table>
    <br /><br /><br />	<br /><br /><br />	
    <table  border="none" cellspacing="0" cellpadding="5px" style="width=100%;margin:auto; border:none;">
			  <tr>
			    <td colspan="2" style="width=100%;">Instructions for Recipient</td>
			  </tr>
			  <tr>
			    <td style="width=45%; >Recipient s taxpayer ldentlllcatlon number.For your protection, this form may show<br />
			      only the last four digits of your social security number (SSN), individual taxpayer identification <br />
			      number (ITlN), adoption taxpayer identification number {ATIN), or employer identification number <br />
			      (EIN). However, the iS8Uer has reported your complete Identification number to the IRS.<br />
			      Account number.May show an account or other unique number the payer assigned<br />
			      to distinguish your account.<br />
			      FATCA ftllng requirement.If the FATCA filing requirement box Is checked, the payer is reporting on <br />
			      this Form 1099 to satisfy  its chapter 4 account reporting requirement. You also may have a filing <br />
			      raquirement.See the Instructions for Form 8938.<br />
			      Arnounta ahown may be aubleet to ttell-employment {SE) tax. If your net income from self-employment <br />
			      Is $400 or more, you must file a return and compute your BE tax on Schedule SE (Form 1040).See Pub. <br />
			      334 tor more information. If no income or<br />
			      social security and Medicare taxes were withheld and you are still receiving these<br />
			      payments, see Form 1040-ES (or Form 1040-ES(NR)). Individuals must report these amounts as <br />
			      explained In the box 7 Instructions on this page. Corporations, ftduclarles, or partnerships must <br />
			      report the amounts on the proper line of their tax returns.<br />
			      Fann 1099-MISC incorrect7 If this form is incorracl: or has been issued in error, contact the <br />
			      payer. If you cannot get this form corrected, attach an explanation to your tax return and report <br />
			      your Income correctly.<br />
			      Box 1.Report rmts from real estate on Schedule E (Form 1040). However, report rents on Schedule C <br />
			      (Form 1040) if you provided significant services to the tenant, sold real estate as a business, or <br />
			      rented personal property as a business.<br />
			      Box 2.Report royalties from oil, gas, or mineral properties, copyrights, and patents an Schedule E <br />
			      (Form 1040). However, report payments for a working interest as explained in the box 7 <br />
			      instructions. For royalties on timber, coal,  and iron ore, see Pub. 544.<br />
			      Box 3.Generally, report this amount on the &quot;Other Income line of Form 1040 {or Form<br />
			      1040NR) and identify the payment. The amount shown may be payments received as the beneficiary of a <br />
			      deceased employee, prizes, awards, taxable damages, Indian gaming profits, or other taxable <br />
			      income.See Pub. 525. If it is trade or business Income, report this amount on Schedule Cor  F (Form <br />
			      1040).<br />
			      Box 4.Shows backup withholding or withholding on Indian gaming profits. Generally, a payer must <br />
			      backup withhold if you did not furnish your taxpayer identification number.See Form w-g and Pub. <br />
			      505 for more Information. Report this amount on your Income tax return as tax withheld.<br />
			      Box&amp;.An amount in this box means the fishing boat operator considers you self­<br />
			      employed. Report this amount on Schedule C (Form 1040).See Pub. 334. Box 6.For lndMduals, report on <br />
			      Schedule c (Form 1040).<br /></td>
			    <td style="width=45%;>Box 7.Shows nonemployee compensation. If you are in the trade or business of<br />
			      catching fish, box 7 may show cash you received for the sale of fish. If the amount In this box is <br />
			      SE income, report it on Schedule Cor F (Form 1040), and complete Schedule SE (Form 1040). You <br />
			      received this form instead of Form W-2 because the payer did not consider you an employee and did <br />
			      not withhold income tax or social secur1ty and Medicare tax. If you believe you are an employee and <br />
			      cannot get the<br />
			      payer to correct this form, report the amount from box 7 on Form 1040, line 7 {or Form<br />
			      1040NR, line 8). You must also complete Form 8919 and attach it to your return. If you are not an <br />
			      employee but the amount in this box is not SE income {for example, it is<br />
			      income from a sporadic activity or a hobby), report it on Form 1040, line 21 (or Form<br />
			      1040NR, line 21).<br />
			      Box 8.Shows substitute payments in lieu of dividends or tax-exempt interest received by your broker <br />
			      on your behalf as a result of a loan of your securities. Report on the &quot;Other Income  line of Form <br />
			      1040 (or Form 1040NR).<br />
			      Box 9.If checked, $5,000 or more of sales of consumer products was paid to you on a buy-sell, <br />
			      deposit-commission, or other basis. A dollar amount does not have to be shown.Generally, report any <br />
			      income from yoiJ  sale of these products on Schedule C<br />
			      (Form 1040).<br />
			      Box 10.Report this amount on Schedule F (Form 1040).<br />
			      Box 13.Shows your total compensation of excess golden parachute payments subJect to a20% excise <br />
			      tax. See the Form 1040 (or Form 1040NR) Instructions for where to report.<br />
			      Box 14.Shows gross proceeds paid to an attorney in connection with legal services. Report only the <br />
			      taxable part as Income on your return.<br />
			      Box 15a.May show current year deferrals as a nonemployee under a nonqualifled deferrad compensation <br />
			      (NQDC) plan that is subject to the requirements of section<br />
			      409A, plus any earnings on current and prior year deferrals.<br />
			      Box 15b.Shows Income as a nonemployee under an NQDC plan that does not meet the requirements of <br />
			      section 409A This amount is also included in box 7 as nonemployea compensation. Any amount included <br />
			      in box 15a that is currently taxable is also included in this box. This income is also subject to a <br />
			      substantial additional tax to be reported on Form 1040 (or Form 1040NR). See MTotalTax  In the <br />
			      Form 1040 (or<br />
			      Form 1040NR) instructions.<br />
			      BOXH 18-18. Shows state or local income tax withheld from the payments.<br />
			      Future developments. For the latest Information about developments related to Form<br />
			      1099-MISC and its instructions, such as legislation enacted after they were published, go to <br />
			      www.irs.govlforrn1099misc.<br /></td>
			  </tr>
			
		    	 
</table>
<br /><br />	
<br /><br />
<br /><br />
<br /><br />
<table  border="none" cellspacing="0" cellpadding="5px" style="margin:auto; border:none;width=100%;">
  <tr>
    <td colspan="2" style="width=100%;">Instructions for Payer<br /></td>
  </tr>
  <br /><br />
  <tr>
    <td style="width=45%;"> To complete Form 1099-MISC, use:<br />
      • the 2017 General Instructions for Certain Information<br />
      Returns, and<br />
      • the 2017 Instructions for Form 1099-MISC.<br />
      To complete corrected Forms 1099-MISC, see the<br />
      2017 General Instructions for Certain Information<br />
      Returns.<br />
      To order these instructions and additional forms, go to www.irs.gov/form1099misc.<br />
      Caution: Because paper forms are scanned during processing, you cannot file Forms 1096, 1097, 1098,<br />
      1099, 3921, 3922, or 5498 that you print from the IRS<br />
      website.<br />
      Due dates. Furnish Copy B of this form to the recipient by January 31, 2018. The due date is <br />
      extended to February 15, 2018, if you are reporting payments in box<br />
      8 or 14.<br /><br /></td>
    <td style="width=45%;">File Copy A of this form with the IRS by<br />
      January 31, 2018, if you are reporting payments in<br />
      box 7. Otherwise, file by February 28,2018, if you file on paper, or by April 2, 2018, if you file <br />
      electronically. To<br />
      file electronically, you must have software that generates a file according to the specifications <br />
      in Pub.<br />
      1220. The IRS does not provide a fill-in form option.<br />
      Need help? If you have questions  about reporting on Form 1099-MISC, call the information reporting <br />
      customer  service site toll free at 1-866-455-7438 or<br />
      304-263-8700 (not toll free). Persons with a hearing or speech disability  with access to TIY!fDD <br />
    equipment can call 304-579-4827 (not toll free).<br /></td>
  </tr>
</table>
';
  
	
		?>
<?php 
    echo $html;

	$ModDepName = 'Pdf-1099-Vendor';
	$ModulePDFID = $_GET['code'];

	$content = ob_get_clean();
    ob_end_clean(); 
require_once("includes/htmltopdf/html2pdf.class.php");
try { 
    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    if ($_GET['editpdftemp'] == '1') {
        $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf');
    }

    if ($_GET['attachfile'] == '1') {
        chmod($savefileUrl, 0777);
        $html2pdf->Output($savefileUrl . $ModDepName . '-' . $ModulePDFID . '.pdf', 'F');  
    }
    $html2pdf->Output($ModDepName . '-' . $ModulePDFID . '.pdf', '');   
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}


