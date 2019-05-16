<script language="JavaScript1.2" type="text/javascript">
function validateAsset(frm){

	if(ValidateForSelect(frm.AssetName, "Asset Name")
	   && ValidateForSelect(frm.EmployeeName, "Employee Name")
		/*&& ValidateForSelect(frm.ExpectedReturnDate, "Expected Date")*/ 
		){
		ShowHideLoader('1','S');
		return true;
	   }else{
		return false;	
	}
	
	/**********************/

	
		
}
</script>
<a href="<?=$RedirectURL?>" class="back">Back</a>
<div class="had"><?=$MainModuleName?> <span>&raquo; Assign Asseet
			
		</span> </div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <?php }else { ?>
  
  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateAsset(this);" enctype="multipart/form-data">

<tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

 

 <tr>
        <td  align="right"   class="blackbold"> Asset : <span class="red">*</span></td>
        <td align="left">
		 <input name="AssetName" type="text" class="disabled" style="width:120px;" id="AssetName" value=""  maxlength="40" readonly />
		<input name="AssetID" id="AssetID" type="hidden" value="">
		<input name="TagID" id="TagID" type="hidden" value="">
		<a class="fancybox fancybox.iframe" href="AssetList.php"><?=$search?></a>
				
	 </td>
      </tr>	 	

      <tr>
        <td  align="right"   class="blackbold"> Employee : <span class="red">*</span></td>
         <td align="left">
		 <input name="EmployeeName" type="text" class="disabled" style="width:120px;" id="EmployeeName" value=""  maxlength="40" readonly />
		 <input name="EmpID" id="EmpID" type="hidden" value="">
		 <a class="fancybox fancybox.iframe" href="AssetEmpList.php" ><?=$search?></a>
	   </td>
      </tr>	 


	<tr>
		<td  align="right"   class="blackbold"> Expected Return Date  :</td>
		<td   align="left" >
		<input id="ExpectedReturnDate" name="ExpectedReturnDate" readonly="" class="datebox" value=""  type="text" > 
		</td>
	</tr>
<script type="text/javascript">
$(function() {
	$('#ExpectedReturnDate').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		minDate : "+0D",

		}
	);
});
</script>
	
</table>
</td>
   </tr>

  <tr>
        <td  align="center">
		<input type="hidden" name="AdminID" id="AdminID" value="<?=$_SESSION['AdminID']?>" />
		<input type="hidden" name="UserName" id="UserName" value="<?=$_SESSION['UserName']?>" />
        <input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />

      </td>
   </tr>
   </form>
   </table>
  <?php }?>
	







