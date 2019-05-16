<script language="javascript1.2">
	
function validateTrack(frm){
	if(  ValidateForSimpleBlank(frm.TrackNumber, "Please enter tracking number.")
	){
		return true;	
	}else{
		return false;	
	}
}
</script>
<table cellspacing="0" cellpadding="0" width="100%" align="center">
     <tr>
        <td  align="left" valign="middle" class="heading">Tracking Your Items</td>
      </tr>  
	  
	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav">
		<?=$Nav_Home?> Tracking Your Items</td>
      </tr>
     
	 
	  
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td  valign="top"  class="txt" >
		<?
	if($arrayContents[0]['PageContent'] != ''){
	 	echo  stripslashes($arrayContents[0]['PageContent']); 
	}
	/*else{
		echo '<Div align=center  class=redtxt>'.INACTIVE_PAGE.'</Div>';
	}*/
	
	?>
        </td>
      </tr>
	   <tr>
        <td height="15"></td>
      </tr>
	  
	   <tr>
        <td align="left" valign="top" >
		<form name="TrackForm" action=""  method="post" onSubmit="return validateTrack(this);">
		<strong>Please enter the tracking number to track the delivery status of order: </strong><br><br>
		 <input type="text" name="TrackNumber" id="TrackNumber"  value="<?=$_POST['TrackNumber']?>" class="txtfield_normal" />&nbsp;
		 <input name="SubmitButton" id="SubmitButton" type="submit" value="Get Delivery Status" class="button" />
		</form>
		
		</td>
      </tr>
	    <tr>
        <td height="15"></td>
      </tr>
	    <tr>
        <td  align="left" >
		
<? 
if (!empty($_POST['TrackNumber'])) {	
	if(empty($arryOrder[0]['TrackNumber'])) { ?>
<div class="redbig">Invalid tracking number. Please enter a correct tracking number sent at your email address after order processing.</div>
<? } else{ ?>
	
<table width="50%" border="0" cellspacing="1" cellpadding="3"  class="txt" bgcolor="#A0A0A4">
  <tr>
    <td   width="26%" align="left" bgcolor="#FFFFFF"><strong>Order Number:</strong> </td>
    <td  align="left"  class="blacknormal" bgcolor="#FFFFFF">#<?=$arryOrder[0]['OrderID']?></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#FFFFFF"><strong>Tracking Number:</strong> </td>
    <td  align="left"  bgcolor="#FFFFFF"><?=$arryOrder[0]['TrackNumber']?></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#FFFFFF"><strong>Order Date: </strong></td>
    <td  align="left"  bgcolor="#FFFFFF" ><?=date('d-m-Y',strtotime($arryOrder[0]['OrderDate']))?></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#FFFFFF"><strong>Delivery Status:</strong></td>
    <td  align="left" bgcolor="#FFFFFF"><?=($arryOrder[0]['Status']==1)?("Delivered"):("Pending")?>                     	</td>
  </tr>
  <? if(!empty($arryOrder[0]['TrackMsg'])){ ?>
  <tr>
     <td valign="top" align="left" bgcolor="#FFFFFF" ><strong>Current Status:</strong></td>
    <td  align="left" bgcolor="#FFFFFF">
	<?=nl2br(stripslashes($arryOrder[0]['TrackMsg']))?></td>
  </tr>
  <? } ?>
  <? if(!empty($arryOrder[0]['TrackMsgDate'])){ ?>
  <tr>
    <td valign="top" align="left" bgcolor="#FFFFFF" ><strong>Last Updated:</strong></td>
    <td  align="left" bgcolor="#FFFFFF"><?=date('d-m-Y H:i:s',strtotime($arryOrder[0]['TrackMsgDate']))?></td>
  </tr>
  <? } ?>
</table>		
	  <? } } ?>	
		
		</td>
      </tr>
    </table>
