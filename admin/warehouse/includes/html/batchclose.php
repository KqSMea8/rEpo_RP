
<script language="JavaScript1.2" type="text/javascript">

$(function(){
	
	$('#email').click(function(){
		
			$('#proceed').show();
			$('#Close').show();
if($('#emailInvoice').val() ==1){
		$('#emailInvoice').val('');
$('.eml').removeClass('activeImg');
}else{
$('#emailInvoice').val(1);
$('.eml').addClass('activeImg');
}

		
	})	
	

$('#print').click(function(){
		
			$('#proceed').show();
$('#Close').show();
if($('#printInvoice').val() ==1){
		$('#printInvoice').val('');
$('.prn').removeClass('activeImg');
}else{
$('#printInvoice').val(1);
$('.prn').addClass('activeImg');
}
		//$('#printInvoice').val(1);

		
	})	

});

</script>
<style>
.activeImg {
    background: linear-gradient(0deg, rgba(2,173,231,0.5), rgba(2,173,231,0.5)), url(images/mba-grid-5px-bg.png) repeat;
}

img.eml, img.prn {
    border: 2px solid rgb(255, 255, 255);
}
.eml.activeImg, .prn.activeImg {
    background: linear-gradient(0deg, rgba(2,173,231,0.5), rgba(2,173,231,0.5)), url(images/mba-grid-5px-bg.png) repeat;
    border: 2px solid #ccc;
}


</style>
<form name="cfform" id="cfform"  method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
  <tr>
    <td align="left">


<table width="100%" border="0" cellpadding="3" cellspacing="0" >

 <tr>
	 <td colspan="4" align="left" class="head">What do you want?</td>
</tr>
<?php if($_GET['email'] != 'success'){?>
 <tr>
        <td  align="left" width="30%" style="float: left; margin-left: 50px;"  class="blackbold" valign="top"> 
	<input name="emailInvoice" type="hidden" class="textbox" id="emailInvoice" value=""/>
<a id="email" ><img  class="eml"  width="100px" height="100px" src="../images/email.jpg"/></a></td>
        <td   align="left" valign="top">
	<input name="printInvoice" type="hidden" class="textbox" id="printInvoice" value=""/>
<a  id="print" ><img width="100px" class="prn" height="100px" src="../images/prnt.jpeg"/></a>
        </td>
     
</tr> 
<?php }else{?>
 <tr>
	 <td colspan="4" align="center" style="color:red"><strong>Shipment Pdf's at email send successfully!</strong></td>
</tr>
<?php }?>
</table>		
<tr>
    <td  align="center">            </td>
</tr>
	</td>
	<tr>
    <td  align="center">
            <input style="display:none" name="proceed" type="submit" class="button" id="proceed" value="Proceed"  />
 						<input style="display:none" name="Close" type="submit" class="button" id="Close" value="Batch Close"  />
            <input type="hidden" name="batchId" id="batchId" value="<?=$_GET['active_id']?>" />
    </td>
</tr>
  </tr>
</table>
</form>

