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
<div class="had"><?=$module?> </div>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

<tr>
    <td  align="center" valign="top" >

<form name="formMail" action=""  method="post" onSubmit="return validateMail(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="2" align="left" class="head" >Send Email</td>
		</tr>
   <tr>
        <td  align="right"   class="blackbold" width="20%">To  : </td>
        <td   align="left"  >
         	<input type="text" name="ToEmail" id="ToEmail" style="width: 250px;" value="" class="inputbox" maxlength="80">
		  
		 </td>
      </tr>
   <tr>
        <td  align="right"   class="blackbold">CC  : </td>
        <td   align="left"  >
         	<input type="text" name="CCEmail" id="CCEmail" style="width: 250px;" value="" class="inputbox" maxlength="80">
		  
		 </td>
      </tr>
      <tr>
        <td  align="right"   class="blackbold">Subject  : </td>
        <td   align="left">
            
         	<input type="text" name="SubjectEmail" id="SubjectEmail" style="width: 250px;" value="Balance Sheet Report- <?php if($_GET['TransactionDate'] == "All"){?> All Dates <?php } else if($_GET['TransactionDate'] == "Today"){?> <?=date($Config['DateFormat'], strtotime($FromDate));?> <?php } else {?><?=date($Config['DateFormat'], strtotime($FromDate));?> - <?=date($Config['DateFormat'], strtotime($ToDate));?> <?php }?>" class="inputbox" maxlength="80">
		  
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


