<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">
function validateMail(frm){

	if(isEmailOpt(frm.CCEmail)
	){
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';

		return true;	
			
	}else{
		return false;	
	}	

		
}
</script>


		
<? 

if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


?>
<div id="prv_msg_div" style="display:none;margin-top:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">	
<div class="had"><?='Send '.$module?> </div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head"><?=$module?> Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice Number # : </td>
        <td   align="left" ><B><?=stripslashes($arryCasePayment[0]['InvoiceID'])?></B></td>
  </tr>
  <tr>
        <td  align="right"   class="blackbold" width="20%"> Payment Date : </td>
        <td   align="left" ><?=($arryCasePayment[0]['PaymentDate']>0)?(date($Config['DateFormat'], strtotime($arryCasePayment[0]['PaymentDate']))):(NOT_SPECIFIED)?></td>
  </tr>
 <tr>
        <td  align="right"   class="blackbold" >Post to GL Date  : </td>
        <td   align="left" >
<?=($arryCasePayment[0]['PostToGLDate']>0)?(date($Config['DateFormat'], strtotime($arryCasePayment[0]['PostToGLDate']))):(NOT_SPECIFIED)?></td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >SO/Reference Number  : </td>
        <td   align="left">
         
                                            <?php if ($arryCasePayment[0]['InvoiceEntry'] == '1') { ?>
                                                <a href="vInvoice.php?pop=1&amp;view=<?= $arryCasePayment[0]['OrderID'] ?>&IE=<?= $arryCasePayment[0]['InvoiceEntry'] ?>" class="fancybox vSalesPayWidth fancybox.iframe"><?= $arryCasePayment[0]['SaleID'] ?></a> 
            <?php } else { ?>
                                                <a href="../sales/vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so=<?= $arryCasePayment[0]['SaleID'] ?>" class="fancybox vSalesPayWidth fancybox.iframe"><?= $arryCasePayment[0]['SaleID'] ?></a>
            <?php } ?>

                                        
		  
		 </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" >Payment Status  : </td>
        <td   align="left" >
		 <? 
		 
                                
                                if ($arryCasePayment[0]['InvoicePaid'] == 'Paid') {
                                                $StatusCls = 'green';
                                                $InvoicePaid = "Paid";
                                            } else {
                                                $StatusCls = 'red';
                                                $InvoicePaid = "Partially Paid";
                                            }

                                            echo '<span class="' . $StatusCls . '">' . $InvoicePaid . '</span>';
                                           
		
		 ?>

           </td>
      </tr>


	<tr>
			<td  align="right"   class="blackbold" > Customer  : </td>
			<td   align="left" >

<a class="fancybox fancybox.iframe" href="../custInfo.php?CustID=<?= $arryCasePayment[0]['CustID'] ?>" ><?= stripslashes($arryCasePayment[0]['CustomerName']) ?></a></td>
	</tr>

<tr>
			<td align="right"   class="blackbold">Customer Email  : </td>
			<td  align="left" ><?=stripslashes($arryCasePayment[0]['Email'])?></td>
		  </tr>


</table>

</td>
</tr>





<tr>
    <td  align="center" valign="top" >

<form name="formMail" action=""  method="post" onSubmit="return validateMail(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="2" align="left" class="head" >Send Email</td>
		</tr>
   <tr>
        <td  align="right"   class="blackbold" width="15%">To  : </td>
        <td align="left">
         	
		  <?php 
                   
                     $arrayCaseReceiptContactIDInfo=$objSale->GetSalesContactInformationSendCsaseReceipt($arryCasePayment[0]['CustID']);
                  
                    //echo '<pre>'; print_r($contactPOInformation);die;
                    $numm=$objSale->numRows();
                    //echo $num;
                    if((is_array($arrayCaseReceiptContactIDInfo) && $numm>0)){
                        $arryCasePayment[0]['Email']=$arrayCaseReceiptContactIDInfo[0]['Email'];
                    }
                    
                  
                  
                  ?>
            <input type="text" name="ToEmail" id="ToEmail" value="<?=stripslashes($arryCasePayment[0]['Email'])?>" class="disabled_inputbox" readonly>
		 </td>
      </tr>
   <tr>
        <td  align="right"   class="blackbold" >CC  : </td>
        <td   align="left"  >
         	<input type="text" name="CCEmail" id="CCEmail" value="" class="inputbox" maxlength="80">
		  
		 </td>
      </tr>
   <tr>
        <td  align="right"   class="blackbold" valign="top">Message  : </td>
        <td   align="left"  >
         	<textarea name="Message" id="Message" class="bigbox" maxlength="500"></textarea>
		  
		 </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold" ></td>
        <td   align="left"  >
         	<input type="submit" name="butt" id="butt" class="button" value="Send">
		  
		 </td>
      </tr>
		</table>	
    </form>
	
	</td>
   </tr>

  

  
</table>
</div>


<? } ?>
<script type="text/javascript">

var editorName = 'Message';

var editor = new ew_DHTMLEditor(editorName);
//EmailCompose
editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 200, 'EmailCompose');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor(); 


</script>

