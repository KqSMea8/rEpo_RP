<HTML>
<HEAD>
<TITLE><?=$Config['SiteName']?> :: Order Delivery Status</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="<?=$Config['AdminCSS']?>" rel="stylesheet" type="text/css">
</HEAD>
<BODY BGCOLOR=#FFFFFF style="margin:10px;">
<script language="javascript" src="../includes/global.js"></script>

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
	if( ValidateForTextareaOpt(frm.TrackMsg,"Current Status Message",5,250)
	){
		return true;
	}else{
		return false;	
	}
}



</SCRIPT>
<form name="form1" action="" method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="3" cellpadding="3"  class="blacknormal">
 
  <tr>
    <td colspan="2" align="center" class="message"><strong><?=$mess?></strong></td>
    </tr>
  <tr>
    <td   width="24%" align="left"><strong>Order Number:</strong> </td>
    <td  align="left"  class="blacknormal" >#<?=$arryOrder[0]['OrderID']?></td>
  </tr>
  <? if(!empty($arryOrder[0]['TrackNumber'])){?>
  <tr>
    <td align="left"><strong>Tracking Number:</strong> </td>
    <td  align="left"  ><?=$arryOrder[0]['TrackNumber']?></td>
  </tr>
  <? } ?>
  <tr>
    <td align="left"><strong>Order Date: </strong></td>
    <td  align="left"   ><?=date('d-m-Y',strtotime($arryOrder[0]['OrderDate']))?></td>
  </tr>
  <tr>
    <td align="left"><strong>Delivery Status:</strong></td>
    <td  align="left">
					
                            <select name="Status" id="Status" class="inputbox" style="width:100">
                             <option value="1" <?=($arryOrder[0]['Status']==1)?(" selected"):("")?>>Delivered</option>
                              <option value="0" <?=($arryOrder[0]['Status']==0)?(" selected"):("")?>>Pending</option>
                            </select>	</td>
  </tr>
  <tr>
     <td valign="top" align="left" ><strong>Current Status Message:</strong></td>
    <td  align="left">
	<textarea name="TrackMsg" id="TrackMsg" class="inputbox" cols="60" rows="4"><?=stripslashes($arryOrder[0]['TrackMsg'])?></textarea>(Maximum characters allowed: 250)</td>
  </tr>
  <tr>
    <td valign="top" align="left" >&nbsp;</td>
    <td  align="left">
	
	 <input name="Submit" type="submit" class="Button" value="Update" />
			 
			  <input type="Button" name="Close" value="Close" class="Button" onClick="Javascript:window.close();" />
			  
			   <input type="hidden" name="OrderID" id="OrderID"  value="<?=$_GET['OrderID']?>" />
			    <input type="hidden" name="TrackNumber" id="TrackNumber"  value="<?=$TrackNumber?>" />	</td>
  </tr>
</table>
</form>

</body>
</html>
