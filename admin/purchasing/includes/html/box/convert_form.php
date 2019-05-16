
<script language="JavaScript1.2" type="text/javascript">
function validate_convert_form(frm){

	if(Trim(document.getElementById("PurchaseID")).value!=''){
		if(!ValidateMandRange(document.getElementById("PurchaseID"), "PO Number",3,20)){
			return false;
		}

		var SendUrl = "isRecordExists.php?PurchaseID="+escape(document.getElementById("PurchaseID").value)+"&r="+Math.random();
			
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function CheckExistRequest(){
			if (httpObj.readyState == 4) {
				if(httpObj.responseText==1) {
					alert("PO Number already exists in database. Please enter another.");
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
<div id="convert_form" style="display:none;width:400px;">
	  <form name="formConvert" action="editPO.php?module=Order" method="post"  enctype="multipart/form-data" onSubmit="return validate_convert_form(this);">
 <div class="had2"><?=CONVERT_TO_PO?></div>
<TABLE width="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td   align="left" colspan="2">
			<?=BLANK_ASSIGN_AUTO?>
		</td>
      </tr>			
	  
	  <tr>
		  <td >

		  
		  <table width="100%" border="0" cellpadding="5" cellspacing="1" align="center" bgcolor="#FFFFFF" class="borderall">
				
				

			 <tr>
        <td  align="right"   class="blackbold" width="25%" > <?=$ModuleIDTitle?> # : </td>
        <td   align="left" >
			<?php echo stripslashes($arryPurchase[0][$ModuleID]); ?>
		</td>
      </tr>		 
					 
					 
					 <tr>
						  <td align="right"   class="blackbold" valign="top">PO Number # :</td>
						  <td  align="left" >
							
<input name="PurchaseID" type="text" class="datebox" id="PurchaseID" value="<?=$NextPurchaseModuleID?>"  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_PurchaseID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_PurchaseID','PurchaseID','<?=$_GET['edit']?>');" />
	

							
							</td>
						</tr>
	<tr>
		<td   align="center"></td>
        <td   align="left">
			<span id="MsgSpan_PurchaseID" ></span>
		</td>
      </tr>	
                   



                  </table>
		  
		  
		  
		  
		  </td>
	    </tr>
		
		<tr>
				<td align="center" valign="top">
<?
if($_GET['edit']>0) $ConvertOrderID = $_GET['edit'];
else if($_GET['view']>0) $ConvertOrderID = $_GET['view'];
?>			
	<input name="SubmitConvert" type="submit" class="button" value=" Submit " />
	<input type="hidden" name="ConvertOrderID" id="ConvertOrderID" value="<?=$ConvertOrderID?>" />
				  </td>
		  </tr>

	    
</TABLE>
</form>
</div>
