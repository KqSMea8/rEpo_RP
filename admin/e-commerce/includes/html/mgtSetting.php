<?php
$compDisplayname=$_SESSION['DisplayName'];
$ErpDomain='';
if($arrydomain[0]['ErpDomain']!=''){
	$ErpDomain='http://www.eznetcrm.com/ecom_latest/'.$compDisplayname.'/';
}
$module= $_REQUEST['module'];
?>
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
					<td class="blackbold" width="30%" valign="top" align="right">Magento Site Url
					</td>
					<td width="56%" valign="top" align="left"> <input name="SiteUrl" id="SiteUrl" class="inputbox" value="<?php echo $SiteUrl; ?>" type="text"> </td>
					</tr>
					<tr>
					<td class="blackbold" width="30%" valign="top" align="right">Status
					</td>
					<td width="56%" valign="top" align="left">
					<select name="status" id="status" class="inputbox">
					<option>Select</option>
					<option value="Yes" <?php  if($status=="Yes"){ echo "selected"; }  ?>>Active</option>
					<option value="No"<?php  if($status=="No"){ echo "selected"; }  ?>>Inactive</option>								
					</select>
					</td>
					</tr>
				</table>


				</td>
			</tr>
			<tr>
				<td align="center" height="135" valign="top"><br>
				<input name="Submit" type="submit" class="button" value="Save" />&nbsp;</td>
			</tr>
		</table>
		</form>
		</td>
	</tr>

</table>
