
<script language="JavaScript1.2" type="text/javascript">
/*
function validatermaaction()
			{	
				   if( document.form1.rma.value == "" )
				 {
					 alert( "Please Select Warehouse Name!" );
					 document.form1.rma.focus() ;
					 return false;
				 }					
              return true;
}       
*/
</script>
<form name="form1" action=""  method="post" onSubmit="return validatermaaction(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

   <tr>
    <td  align="center" valign="top" >
	
		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
			<tr>
				 <td colspan="2" align="left" class="head">RMA Action Details</td>
			</tr>

			<tr>
				<td width="43%"  align="right"   class="blackbold"> Warehouse Name  :<span class="red">*</span> </td>
				<td   align="left" >
				
<select name="rma" class="inputbox" id="rma">

				<option value="">Select Warehouse Name</option>
				<?php 

foreach($warehouse_listted as $warehouse_data): ?>
			
				<option value="<?php echo $warehouse_data['WID']; ?>" <? if($warehouse_data['WID'] == $arryBin[0]['name_id']){ echo "selected"; } ?>><?php echo $warehouse_data['warehouse_name']; ?></option>
						<?php endforeach; ?>
			
				</select>
				</td>
			</tr>

			<?php /*?><tr>
				<td  align="right"   class="blackbold"> WID  :<span class="red">*</span> </td>
				<td   align="left" >
				<input name="binlocation" type="text" class="inputbox" id="binlocation" value="<?php echo stripslashes($arryBin[0]['w_id']); ?>"  maxlength="50" />   </td>
		       </tr>  
   <?php */?>
		     <tr>
				<td  align="right"   class="blackbold"> RMA Action  :<span class="red">*</span> </td>
				<td   align="left" >
				<input name="rmaaction" type="text" class="inputbox" id="rmaaction" value="<?php  echo stripslashes($arryBin[0]['action']); ?>" readonly maxlength="50" />    </td>
		       </tr>     
		</table>  
	</td>
   </tr>

   <tr>
	<td align="left" valign="top">&nbsp;</td>
   </tr>
   <tr>
    	<td  align="center">
	
		<div id="SubmitDiv" style="display:none1">
	
			<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
			<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />	
			<input type="hidden" name="binid" id="binid" value="<?=$_GET['edit']?>" />

		</div>

	</td>
   </tr>
   
</table>
</form>
<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
	//ShowPermission();
</SCRIPT>
