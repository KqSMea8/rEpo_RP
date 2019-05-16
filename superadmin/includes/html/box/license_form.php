<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	if( ValidateForTextareaMand(frm.DomainName, "Domain Name / IP Address",5,50)
	&& ValidateForTextareaMand(frm.LicenseKey,"License Key",50,250)		
	&& ValidateForSelect(frm.ExpiryDate, "Expiry Date")
	&& ValidateMandNumField(frm.MaxUser, "Allowed Number Of Users")
	){  

		if(document.getElementById("LicenseID").value>0){
			ShowHideLoader(1,'S');
			return true;	
		}else{
			var Url = "isRecordExists.php?Multiple=1&DomainName="+escape(document.getElementById("DomainName").value)+"&editID="+document.getElementById("LicenseID").value+"&LicenseKey="+escape(document.getElementById("LicenseKey").value);

			SendMultipleExistRequest(Url,"DomainName", "Domain Name / IP Address","LicenseKey", "License Key");
			return false;	
		}
			
	}else{
		return false;	
	}	
	
}


function GenerateKey(){
	if( ValidateForTextareaMand(document.getElementById("DomainName"), "Domain Name / IP Address",5,50)
	){  
		var Params = "&action=generateLicense&DomainName="+escape(document.getElementById("DomainName").value)+"&r="+Math.random(); 
		document.getElementById("LicenseKey").value = "Generating.....";	
		$.ajax({
		type: "GET",
		async:false,
		url: "ajax.php",
		data: Params,
		success: function (responseText) {
			document.getElementById("LicenseKey").value = responseText;	
		}
		});	

	}
}


</script>

<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	<br><br><br>

<table width="80%" border="0" cellpadding="5" cellspacing="10" class="borderall">

<tr>
        <td  align="right"   class="blackbold" width="45%" valign="top"> Domain Name / IP Address  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="DomainName" type="text" <?=$BoxReadOnly?> class="inputbox <?=$DisabledClass?>" id="DomainName" value="<?php echo stripslashes($arryLicense[0]['DomainName']); ?>"  maxlength="50" onKeyPress="Javascript:ClearAvail('MsgSpan_Domain');" onBlur="Javascript:CheckAvailField('MsgSpan_Domain','DomainName','<?=$_GET['edit']?>');"/>           

<? if(empty($_GET['edit'])) { ?>
<span id="MsgSpan_Domain"></span>
<br>Without http://
<? } ?>


 </td>
      </tr>


 <tr>
          <td align="right"   class="blackbold" valign="top">License Key  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="LicenseKey" type="text" readonly class="disabled" id="LicenseKey" maxlength="250" style="height:80px;width:350px;"><?=stripslashes($arryLicense[0]['LicenseKey'])?></textarea>



		 </td>
        </tr>	
<? if(empty($_GET['edit'])) { ?>	  
 <tr>
          <td align="right"   class="blackbold" ></td>
          <td  align="left" valign="top">

<a href="Javascript:void(0);" onclick="Javascript:GenerateKey();" class="grey_bt" style="float:left;">Generate Key</a>

		 </td>
        </tr>	
<? } ?>


<tr>
	<td align="right"   class="blackbold" valign="top" >Allowed Number Of Users  :<span class="red">*</span></td>
	<td  align="left"  >
	<input name="MaxUser" type="text" class="textbox" size="7" id="MaxUser" value="<?=stripslashes($arryLicense[0]['MaxUser'])?>" maxlength="10" onkeypress="return isNumberKey(event);"/>	
	
 
 
 </td>
  </tr>



<tr>
        <td  align="right"   > Expiry Date :<span class="red">*</span>  </td>
        <td   align="left" >
<? if($arryLicense[0]['ExpiryDate']>0)$ExpiryDate = $arryLicense[0]['ExpiryDate'];?>		
<script>
$(function() {
$( "#ExpiryDate" ).datepicker({ 
		showOn: "both",
	yearRange: '<?=date("Y")-1?>:<?=date("Y")+20?>', 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});

	$("#expNone").on("click", function () { 
		$("#ExpiryDate").val("");
	}
	);	

});
</script>
<input id="ExpiryDate" name="ExpiryDate" readonly="" class="datebox" value="<?=$ExpiryDate?>"  type="text" >         

&nbsp;&nbsp;&nbsp;&nbsp;<!--a href="Javascript:void(0);" id="expNone">None</a-->


</td>
      </tr>
	  
	  

<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = 'checked'; $InActiveChecked='';
			 if($_GET['edit'] > 0){
				 if($arryLicense[0]['Status'] == 1) {$ActiveChecked = 'checked'; $InActiveChecked ='';}
				 if($arryLicense[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = 'checked';}
			}
		  ?>
          <label><input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive</label> </td>
      </tr>
	
</table>	
  

	
	  
	
	</td>
   </tr>

   <tr>
	<td align="left" valign="top">&nbsp;
	
</td>
   </tr>

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="LicenseID" id="LicenseID" value="<?=$_GET['edit']?>" />


</div>

</td>
   </tr>
   </form>
</table>

