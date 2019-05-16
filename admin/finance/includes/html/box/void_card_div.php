
<script language="JavaScript1.2" type="text/javascript">
function validate_void_form(frm){
	$("#msgdiv").html("&nbsp;");
	var CardVoidAmount = parseFloat(document.getElementById("CardVoidAmount").value)
	var OriginalVoidAmount = parseFloat(document.getElementById("OriginalVoidAmount").value);

	if(Trim(document.getElementById("CardVoidAmount")).value==""){		
		$("#msgdiv").html('Please Enter Amount.');		
		return false;
	}else if(CardVoidAmount > OriginalVoidAmount){		
		$("#msgdiv").html('Void Amount should not exceed '+OriginalVoidAmount+'.');			
		return false;
	}else{
		
		$.fancybox.close();
		ShowHideLoader('1','P');
		return true;
	}

}
</script>
<div id="void_card_div" style="display:none;width:400px;">
	  <form name="formConvert" action="<?=$VoidCardUrl?>" method="post"  enctype="multipart/form-data" onSubmit="return validate_void_form(this);">

<TABLE width="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
 <tr>

		  <td height="20" class="ui-dialog-titlebar had">
	 Void Credit Card   

		 </td >

	  </tr>
	 <tr>
		  <td height="20">
		<div id="msgdiv" class="redmsg" align="center"> </div>
		 </td >
	  </tr>
	  <tr>		  <td >

		  
		  <table width="100%" border="0" cellpadding="5" cellspacing="1" align="center" bgcolor="#FFFFFF" class="borderall">
				
			 	 
					 
					 
					 <tr>
						  <td align="right"   class="blackbold" valign="top">Void Amount :</td>
						  <td  align="left" >
							
<input name="CardVoidAmount" type="text" class="datebox" id="CardVoidAmount" value="<?=$AmountToRefund?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('msgdiv'); Javascript: return isDecimalKey(event);"  />
	
<?=$arryInvoice[0]['CustomerCurrency']?>
							
							</td>
						</tr>
	 	
                   



                  </table>
		  
		  
		  
		  
		  </td>
	    </tr>
		

		<tr>
				<td align="center" valign="top">
 			
	<input name="SubmitVoid" type="submit" class="button" value=" Submit " />
	<input type="hidden" name="OriginalVoidAmount" id="OriginalVoidAmount" value="<?=$AmountToRefund?>" />
				  </td>
		  </tr>

	     <tr>
		  <td height="20">
		 
		 </td >
	  </tr>
</TABLE>
</form>
</div>
