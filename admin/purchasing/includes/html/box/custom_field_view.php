<?  if(sizeof($arryCustomField)>0){
	foreach($arryCustomField as $key=>$values){ 
		
		$FieldValue = stripslashes($arryExisting[0][$values['FieldName']]);

	?>	
	<tr>
			<td  align="right"   class="blackbold" > <?=stripslashes($values['FieldTitle'])?>  : </td>
			<td   align="left" >
	<?=(!empty($FieldValue))?($FieldValue):(NOT_SPECIFIED)?>
	
		</td>
		 </tr>
<? } } ?>