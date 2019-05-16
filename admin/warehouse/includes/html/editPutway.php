
<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
</script>


<div class="had">
   Putway
   

</div>
<?php 
if(!empty($_SESSION['mess_Serial'])){?>
<div class="redmsg"> <? echo $_SESSION['mess_Serial']?></div>
<? unset($_SESSION['mess_Serial']);  }?>


<table width="100%"   border=0 align="center" cellpadding="0" cellspacing="0">
 <form name="form1" id="productBasicInfoForm" action=""  method="post" onSubmit="return validateI(this);"  enctype="multipart/form-data">	
  
 
	<tr>
            <td align="right" > Receiving Number <?=$i?>:</td>
	<td align="left" width valign="top">
        <input  name="serial_no[]" id="serial"   onKeyPress=" return isAlphaKey(event);"  value="" type="text" class="inputbox"  maxlength="30" />    
        <span id="MsgSpan_Display<?=$i?>"></span>
	
	</td>
    </tr>

	<tr>
            <td align="right" > Package Count:</td>
	<td align="left" width valign="top">
        <input  name="serial_no" id="serial"    onKeyPress=" return isAlphaKey(event);"  value="" type="text" class="inputbox"  maxlength="30" />    
        <span id="MsgSpan_Display<?=$i?>"></span>
	
	</td>
    </tr>

	<tr>
            <td align="right" > Warehouse :</td>
	<td align="left" width valign="top">
        <input  name="serial_no" id="serial"    onKeyPress=" return isAlphaKey(event);"  value="" type="text" class="inputbox"  maxlength="30" />    
        <span id="MsgSpan_Display<?=$i?>"></span>
	
	</td>
    </tr>
  
    
    
       <tr <?=$Display?>> <input type="hidden" name="tot" id="tot" value="<?=$_GET['total']?>"  />
        <td align="center" colspan="2"><input type="submit" name="submit" id="submit" value="Pick"  class="button"/>
        
        
           
        </td></tr>
 </form>
</table>
