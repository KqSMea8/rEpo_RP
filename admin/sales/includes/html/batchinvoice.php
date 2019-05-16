

	<?php if (!empty($errMsg)) {?>
  
    <div  align="center"  class="red" ><?php echo $errMsg;?></div>
    
  <?php } ?>
  
<script language="JavaScript1.2" type="text/javascript">

$(function(){	
	$('#batches').on('change', function() {
		if(this.value!='')
		{

var SaleID= $('#SaleID').val();  
var edit= $('#edit').val();                         
window.open('../warehouse/editShipment.php?batchId='+this.value+'&SaleID='+SaleID+'&edit='+edit+'','_blank')
			//location.href = "SorderList.php?link=editShipment.php&batchId="+this.value;
parent.jQuery.fancybox.close();
		//ShowHideLoader('1','P');
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
<?php  if(!empty($arryBatch)){ ?>
	<select name=batches id="batches" class = "inputbox" >
	<option value="">Select Batches</option>
	
<?php	for($i=0; $i < count($arryBatch); $i++)
	{?>
	<option value="<?php echo $arryBatch[$i]['batchId']?>"><?php echo $arryBatch[$i]['batchname']?></option>	
	<?php } ?>

	 ?>
</select>
<? } else{

echo "No batch for select.";

}?>

<input name="so" id="so" type="hidden" value="<?php echo $_GET['so'] ?>">
		<input name="edit" id="edit" type="hidden" value="<?php echo $_GET['edit'] ?>">



        </td>
     
</tr> 
 

 </table>	
    </td>
</tr>
   
</table></form>
