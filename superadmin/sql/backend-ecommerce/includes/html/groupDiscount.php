
<div class="had"><?= $ModuleName; ?></div>
<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<tr>
		<td align="center" valign="top">
		<form name="form1" action="" method="post"
			enctype="multipart/form-data">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" class="message"><?php if ($_SESSION['mess_cart'] != "") { ?><?= $_SESSION['mess_cart'];
				unset($_SESSION['mess_cart']); ?><?php } ?></td>
			</tr>
			<tr>
				<td align="center" valign="middle">

				<table width="100%" border="0" cellpadding="0" cellspacing="0"
					class="borderall">

					<tr>
						<td align="center" valign="top">
						<table width="100%" border="0" cellpadding="5" cellspacing="1">
						
						
							<?php
							
							$GroupDiscount= json_decode($arrygroupdiscount[0]['GroupDiscount'], true);
							
							$grouphtml='<table><tr><td colspan="2">';
							for($count=0;$count< count($listAllCustomerGroups); $count++){
								
								$flatchecked= ($GroupDiscount[$listAllCustomerGroups[$count]['GroupID']]['type'] == 'flat') ? 'checked' : '';
								$percentchecked= ($GroupDiscount[$listAllCustomerGroups[$count]['GroupID']]['type'] == 'percent') ? 'checked' : '';
								$val=$GroupDiscount[$listAllCustomerGroups[$count]['GroupID']]['val'];
								$grouphtml .='	<tr>
	                          <td height="30" align="right"  class="blackbold" >'.$listAllCustomerGroups[$count]['GroupName'].' (Discount) :</td>
	                          <td align="left">
	                          <input name="groupdiscount['.$listAllCustomerGroups[$count]['GroupID'].'][type]" type="radio" value="flat" '.$flatchecked.' >Flat
	                          <input name="groupdiscount['.$listAllCustomerGroups[$count]['GroupID'].'][type]" type="radio" value="percent" '.$percentchecked.' >Percent
	                          </td>
	                          <td align="left"><input name="groupdiscount['.$listAllCustomerGroups[$count]['GroupID'].'][val]" id="val'.$listAllCustomerGroups[$count]['GroupID'].'" type="text" value="'.$val.'" onkeypress="return isNumberKey(event,\'val'.$listAllCustomerGroups[$count]['GroupID'].'\')" class="inputbox" size="10" maxlength="10">
	                          </td>
	                        </tr>
								
							';
							}
							$grouphtml .='</td></tr></table>';
							echo $grouphtml;
							?>
							
						</table>
						</td>
					</tr>
				</table>


				</td>
			</tr>
			<tr>
				<td align="center" height="135" valign="top"><br>
				<? if ($_GET['edit'] > 0) $ButtonTitle = 'Update'; else $ButtonTitle = 'Save'; ?>
				 <input name="Submit" 	type="submit" class="button" value=" <?= $ButtonTitle ?> " />&nbsp;</td>
			</tr>

		</table>
		</form>
		</td>
	</tr>

</table>
<script>
	function isNumberKey(evt,inputfield)
	{
		 
	   var charCode = (evt.which) ? evt.which : event.keyCode
		
	           if (charCode == 46)
	           {
	               var inputValue = $("#"+inputfield).val()
	               if (inputValue.indexOf('.') < 1)
	               {
	                   return true;
	               }
	               return false;
	           }       
	   if (charCode > 31 && (charCode < 48 || charCode > 57))
	      return false;

	   return true;
	}


</script>
