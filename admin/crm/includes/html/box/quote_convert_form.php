
<script language="JavaScript1.2" type="text/javascript">
function validate_convert_form(frm){

	if(Trim(document.getElementById("SaleID")).value!=''){
		if(!ValidateMandRange(document.getElementById("SaleID"), "Sales Order Number",3,20)){
			return false;
		}

		var SendUrl = "isRecordExists.php?SaleID="+escape(document.getElementById("SaleID").value)+"&r="+Math.random();
			
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function CheckExistRequest(){
			if (httpObj.readyState == 4) {
				if(httpObj.responseText==1) {
					alert("Sales Order Number already exists in database. Please enter another.");
					return false;
				} else if(httpObj.responseText==0) {
					$.fancybox.close();
					ShowHideLoader('1','P');
					document.formConvert.submit();
				}else {
					alert("Error occur : " + httpObj.responseText);
					return false;
				}
			}
		};
		httpObj.send(null);

		return false;

	}else{
		$.fancybox.close();
		ShowHideLoader('1','P');
		return true;
	}

}
</script>
<div id="convert_form" style="display:none;width:500px;">
	  <form name="formConvert" action="" method="post"  enctype="multipart/form-data" onSubmit="return validate_convert_form(this);">
 <div class="had2"><?=CONVERT_TO_SALE_ORDER?></div>
<TABLE width="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td   align="left" colspan="2">
			<?=BLANK_ASSIGN_AUTO?>
		</td>
      </tr>			
	  
	  <tr>
		  <td>

		  
		  <table width="100%" border="0" cellpadding="5" cellspacing="1" align="center" bgcolor="#FFFFFF" class="borderall">
				
				

			 <tr>
        <td  align="right"   class="blackbold" width="30%" > Quote Number # : </td>
        <td   align="left">
			<?php echo stripslashes($arryQuote[0]['quoteid']); ?>
		</td>
      </tr>		 
					 
					 
					 <tr>
						  <td align="right"   class="blackbold" valign="top">Sales Order Number # :</td>
						  <td  align="left">
                            <input name="SaleID" type="text" class="datebox" id="SaleID" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_SaleID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_SaleID','SaleID','');" />
							</td>
						</tr>
					<tr>
						<td   align="center"></td>
						<td   align="left">
							<span id="MsgSpan_SaleID" ></span>
						</td>
					  </tr>	
                   



                  </table>
		  
		  
		  
		  
		  </td>
	    </tr>
		
		<tr>
				<td align="center" valign="top">
					<input name="SubmitConvert" type="submit" class="button" value="Submit" />
					<?php
					  if(!empty($_GET['edit'])){
					  
					    $idd = $_GET['edit'];
					  }else{
						$idd = $_GET['view'];
					  }
					?>
					<input type="hidden" name="ConvertOrderID" id="ConvertOrderID" value="<?=$idd?>" />
				  </td>
		  </tr>

	    
</TABLE>
</form>
</div>
