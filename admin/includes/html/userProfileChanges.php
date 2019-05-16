<SCRIPT LANGUAGE=JAVASCRIPT>
function SetClose(){
	parent.jQuery.fancybox.close();
}

</SCRIPT>

<TABLE WIDTH="100%" BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0>

	<tr>
		<td valign="top" align="left">

		<table width="50%" border="0" cellpadding="5" cellspacing="0"
			class="borderall" style="margin: 0; background: #fff">
			<tr>
				<td align="right" class="blackbold" width="30%">User Name :</td>
				<td align="left"><strong><?=$arryEmployeeChange[0]["UserName"];?></strong>


				</td>
			</tr>
			<tr>
				<td align="right">Email :</td>
				<td align="left"><?=$arryEmployeeChange[0]["Email"];?></td>
			</tr>

		</table>


		<table width="100%" border="0" align="center" cellpadding="0"
			cellspacing="0">
			<tr>
				<td>
				<table <?= $table_bg ?>>
					<tr align="left">
						<td width="10%" height="20" class="head1" align="center">Column
						Name</td>
						<td width="15%" height="20" class="head1" align="center">Old Value</td>
						<td width="15%" height="20" class="head1" align="center">New Value</td>
					</tr>
					<?php




					foreach ($arryEmployeeChange as $key => $values) {
						//echo "<pre>";print_r($values);
						//echo count($values);
						$ColName=explode("#", $values['ColName']);
						$ColOldValue=explode("#", $values['ColOldValue']);
						$ColNewValue=explode("#", $values['ColNewValue']);

						$record=count($ColName);
							

							
						for ($i = 0; $i <= count($ColName); $i++) {

							//$arryRgn['Country']= stripslashes($arryCountry[0]["name"]);

							if(!empty($ColNewValue[$i])){
								?>
					<tr align="left" bgcolor="<?= $bgcolor ?>">
						<td height="26" align="center"><?= $ColName[$i];?></td>
						<td height="26" align="center"><?= $ColOldValue[$i]; ?></td>
						<td height="26" align="center"><?= $ColNewValue[$i]; ?></td>


					</tr>
					<?php } } } ?>

				</table>
				</td>
			</tr>
		</table>