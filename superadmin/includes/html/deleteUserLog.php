<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	if( ValidateForSelect(frm.DeleteBefore, "Delete Log Before Date")
	){  
 		document.getElementById("cmpInfo").style.display = 'none';
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
			
	}else{
		return false;	
	}	
	
}

</script>
<div class="had">Delete User Log</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


<? if($CmpID>0){?>
<tr>
  <td  valign="top" align="left">

<table width="80%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="background:#fff" id="cmpInfo">
  <tr>
        <td  align="right"   class="blackbold" width="30%" > Company Name  : </td>
        <td   align="left" >
<strong><?php echo stripslashes($arryCompany[0]['CompanyName']); ?></strong>
           </td>
      
        <td  align="right"   class="blackbold"  > Company ID  :</td>
        <td   align="left" >
<?php echo stripslashes($arryCompany[0]['CmpID']); ?>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Display Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>
           </td>
     
	 <td  align="right">Email : </td>
 <td  align="left">
<?php echo $arryCompany[0]['Email']; ?>
</td>
</tr>
</table>

</td>
</tr>


<? if(!empty($ErrorMsg)){?>
	<tr>
	  <td height="50" align="center" class="redmsg">
<?=$ErrorMsg?>
</td>
</tr>
<? }else{?>

<tr>
	  <td  valign="top">
	  
	

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Processing..............</div>
<div id="preview_div">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >


<table width="81%" border="0" cellpadding="5" cellspacing="10" class="borderall" style="background:#fff">


<tr>
        <td  align="right"  width="40%" > Delete Log Before :<span class="red">*</span>  </td>
        <td   align="left" >
		
<script>
$(function() {
$( "#DeleteBefore" ).datepicker({ 
		showOn: "both",
	yearRange: '<?=date("Y")-10?>:<?=date("Y")?>', 
        maxDate: "-1M", 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});

	$("#expNone").on("click", function () { 
		$("#DeleteBefore").val("");
	}
	);	

});
</script>
<input id="DeleteBefore" name="DeleteBefore" readonly="" class="datebox" value=""  type="text" >         




</td>
      </tr>
	  
	  
	 <tr>
          <td align="right"   class="blackbold" valign="top">Keep Last Records for Users  :</td>
          <td  align="left" >
           
<select name="KeepNumRecord" id="KeepNumRecord" class="textbox" style="width:100px;" >
	<?
	for($i=0;$i<=100;$i=$i+10){
		$sel = ($i==10)?('selected'):('');	
		echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
	} 
	?>
</select> 


		 </td>
        </tr>	
	
</table>	
  

	
	  
	
	</td>
   </tr>



   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	

      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" Confirm Delete "  />


<input type="hidden" name="LicenseID" id="LicenseID" value="<?=$_GET['edit']?>" />


</div>

</td>
   </tr>
   </form>
</table>




  </div> 

</td>
</tr>

<? } } ?>


</table>
