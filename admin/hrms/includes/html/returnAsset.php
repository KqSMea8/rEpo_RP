<script language="JavaScript1.2" type="text/javascript">
function validateAsset(frm){

	if(ValidateForSelect(frm.ReturnDate, "Return Date") 
		){
		$("#prv_msg_div").show();
		$("#preview_div").hide();
		return true;
	   }else{
		return false;	
	}
	
	/**********************/

	
		
}
</script>

<div class="had"><?=$ModuleName?></div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php }else { ?>
  <div id="prv_msg_div" style="display:none"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">
  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
		<form name="form1" action=""  method="post" onSubmit="return validateAsset(this);" enctype="multipart/form-data">
		<tr>
		<td  align="center" valign="top" height="170">

		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="">

		<tr>
		<td  align="right"   class="blackbold"> Return Date  :<span class="red">*</span></td>
		<td   align="left" >
		<input id="ReturnDate" name="ReturnDate" readonly="" class="datebox" value=""  type="text" > 
		</td>
		</tr>
		<script type="text/javascript">
			$(function() {
			$('#ReturnDate').datepicker(
			{
				showOn: "both",
				yearRange: '<?=date("Y")-5?>:<?=date("Y")+5?>', 
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true
				

			}
			);
			});
		</script>
     <tr>
		<td  align="center" colspan="2">
			<input type="hidden" name="AssignID" id="AssignID" value="<?=$_GET['AssignID']?>" />
			<input type="hidden" name="AssetID" id="AssetID" value="<?=$_GET['AssetID']?>" />
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />
		</td>
		</tr>
		</table>
		</td>
		</tr>

		
		</form>
   </table>
</div>
  <?php }?>
