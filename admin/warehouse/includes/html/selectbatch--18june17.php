<div class="had"><?=$MainModuleName?>  &raquo; </div>

	<?php if (!empty($errMsg)) {?>
  
    <div  align="center"  class="red" ><?php echo $errMsg;?></div>
    
  <?php } ?>
  
<script language="JavaScript1.2" type="text/javascript">

$(function(){	
	$('#batches').on('change', function() {
		if(this.value!='')
		{
			location.href = "SorderList.php?link=editShipment.php&batchId="+this.value;
		}
	})
})


</script>
<form name="cfform" id="cfform"  method="post" enctype="multipart/form-data">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">



   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall"> 
    <tr>
	 <td colspan="4" align="left" class="head">Select Batch</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" valign="top" width="20%"> Batches : </td>
        <td   align="left" valign="top" width="30%">
	<select name=batches id="batches" class = "inputbox" >
	<option value="">Select Batches</option>
	<?php  if(!empty($arryBatch)){
	for($i=0; $i < count($arryBatch); $i++)
	{?>
	<option value="<?php echo $arryBatch[$i]['batchId']?>"><?php echo $arryBatch[$i]['batchname']?></option>	
	<?php }} 

	 ?>
</select>
        </td>
     
</tr> 
 

 </table>	
    </td>
</tr>
   
</table></form>
