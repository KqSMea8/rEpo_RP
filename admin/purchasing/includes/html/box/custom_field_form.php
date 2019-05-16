<?  if(sizeof($arryCustomField)>0){
	foreach($arryCustomField as $key=>$values){ ?>	
	<tr>
			<td  align="right"   class="blackbold" > <?=stripslashes($values['FieldTitle'])?>  : </td>
			<td   align="left" >
	<input name="<?=$values['FieldName']?>" id="<?=$values['FieldName']?>" type="text" class="inputbox"  value="<?php echo stripslashes($arryExisting[0][$values['FieldName']]); ?>"  maxlength="30" />
		</td>
		 </tr>
<? } } ?>