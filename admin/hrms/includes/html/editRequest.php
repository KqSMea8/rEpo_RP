<SCRIPT LANGUAGE=JAVASCRIPT>


function ValidateForm(frm)
{

	if( ValidateForSimpleBlank(frm.request_subject, "Subject") 
		&& ValidateForSimpleBlank(frm.request_message, "Message")
	){
		ShowHideLoader(1,'S');
		
	}else{
		return false;	
	}
	
}
</SCRIPT>

<a class="back" href="<?=$RedirectUrl?>">Back</a> 
<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>

<div class="had"> <?=$MainModuleName?> <span>&raquo; <?=MOVE_TO_ANNOUNCEMENT?></span></div>


<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		<tr>
		  <td align="center">


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
        <td  align="right"   class="blackbold"  valign="top" width="45%">Posted By Employee  : </td>
        <td   align="left">
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryRequest[0]['EmpID']?>"><?=stripslashes($arryRequest[0]['UserName'])?></a>   
					

	</td>
</tr>

   <tr>
          <td align="right"   class="blackbold" valign="top">Posted Date  :</td>
          <td  align="left" >
		<? if($arryRequest[0]['RequestDate']>0) echo date($Config['DateFormat'], strtotime($arryRequest[0]['RequestDate'])); ?>
		   
		   
		   </td>
        </tr>
  
	<tr>
		<td  align="right"   valign="top" class="blackbold" >Subject : <span class="red">*</span></td>
		<td   align="left"  >
			<input type="text" maxlength="100"  id="request_subject" class="inputbox" name="request_subject" value="<?=stripslashes($arryRequest[0]['Subject'])?>">

	   </td>
	  </tr>

 <tr>
        <td align="right"   class="blackbold" valign="top">Message :<span class="red">*</span></td>
        <td  align="left"  >

            <textarea name="request_message" type="text" class="bigbox" id="request_message"><?=stripslashes($arryRequest[0]['Message'])?></textarea>	

		</td>
      </tr>
	</table>	
  


</td>
	    </tr>
		<tr>
		  <td align="center" valign="top">
		  <input type="hidden" name="RequestID" id="RequestID" value="<?=$_GET['req_id']?>">
	        <input name="Submit" type="submit" class="button" id="SubmitButton" value="Move" />		    
			</td>
		  </tr>
	    </form>
</TABLE>


 <? } ?>

