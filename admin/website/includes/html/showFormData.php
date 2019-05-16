


<div class="had"><?=$ModuleName?> <span>&raquo; <? 	echo (!empty($_GET['view']))?("View ".$SubHeading) :("Add ".$ModuleName); ?>

</span></div>
<form name="form1" action="" method="post" enctype="multipart/form-data">
<table width="100%" border="0" align="center" cellpadding="0"
	cellspacing="0">
	<tr>
		<td align="center" valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="middle">
				<div align="right"><a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;</div>
				<br>
				<table width="100%" border="0" cellpadding="0" cellspacing="0"
					class="borderall">


					<tr>
						<td align="center" valign="top">
						<table width="100%" border="0" cellpadding="5" cellspacing="1">

						<?php
						echo '<pre>';
						foreach($arryFormField as $formfield){
							
							$arryFormData = $webcmsObj->getFormDataByAddedNoFormIDFieldId($Added_no,$formId,$formfield['FieldId']);
							
							echo $webcmsObj->createFormData($formfield,$arryFormData);
						}
						?>
							



						</table>

						</td>
					</tr>


				</table>
				</td>
			</tr>


		</table>
		</td>
	</tr>
</table>
</form>
