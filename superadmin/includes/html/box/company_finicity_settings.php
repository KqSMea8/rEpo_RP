<?php 

	?>


<div class="message" align="center"><? if(!empty($_SESSION['mess_employee'])) {echo $_SESSION['mess_employee']; unset($_SESSION['mess_employee']); }?></div>
<form name="form1" action=""  method="post"  enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Manage Finicity API</td>
</tr>
		<?php $isFinicityActive = $arryCompany[0]['FinicityApi'] ;?>
		<tr>
			<td align="right" class="blackbold">Finicity API:</td>
			<td align="left" width="50%">
			<select class="inputbox" name="FinicityApi" id="FinicityApi">
				<option value="0">Inactive</option>
				<option value="1" <? if($isFinicityActive ==1) echo "selected";?>>Active</option>
			</select>
			
			</td>
		</tr>
<!--<tr>
			<td align="right" class="blackbold">Finicity API Key:</td>
			<td align="left" width="50%">
			<input type="text" id="Fin_API_Key" name="Fin_API_Key" class="textbox" value="<?=$arryCompany[0]['Fin_API_Key']?>"  > 
			
			</td>
		</tr>
<tr>
			<td align="right" class="blackbold">Finicity Partner Id:</td>
			<td align="left" width="50%">
			<input type="text" id="Fin_API_PatID" name="Fin_API_PatID" class="textbox" value="<?=$arryCompany[0]['Fin_API_PatID']?>"  > 
			
			</td>
		</tr>
<tr>
			<td align="right" class="blackbold">Finicity Partner Secret Key:</td>
			<td align="left" width="50%">
			<input type="text" id="Fin_Secret_Key" name="Fin_Secret_Key" class="textbox" value="<?=$arryCompany[0]['Fin_Secret_Key']?>"  > 
			
			</td>
		</tr>-->
<tr>
	<td  align="right"   class="blackbold" >&nbsp; </td>
	<td  align="left">

	<div id="SubmitDiv" style="display:none1">
	<input type="hidden" name="CmpID" id="CmpID" value="<?=$_GET['edit']?>" />

	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Update "   />

	</div>

	</td>
	</tr>

</table>	
  

	
	  
	
	</td>
   </tr>

   

 
   </form>
</table>
