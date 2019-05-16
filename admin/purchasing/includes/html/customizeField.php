<SCRIPT LANGUAGE=JAVASCRIPT>

function ShowListing(){
	ShowHideLoader('1','L');	
	location.href = "customizeField.php?m="+document.getElementById("Module").value;
}

var ModuleName = '<?=$ModuleName?>';
function ValidateForm(frm)
{
	ShowHideLoader('1','S');	
	
}

</SCRIPT>
<div class="had"><?=$MainModuleName?></div>


<TABLE width="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		
<tr>
  <td><br><br>
		<table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >
			<tr>
					<td  align="left"   class="blackbold" width="50" > Module  :<span class="red">*</span> </td>
					<td   align="left" >
			<select name="Module" class="textbox" id="Module" onChange="Javascript:ShowListing();">
			  <option value="">--- Select ---</option>
			  <? for($i=0;$i<sizeof($arryCustModule);$i++) {?>
			  <option value="<?=$arryCustModule[$i]['Module']?>" <?=($_GET["m"]==$arryCustModule[$i]['Module'])?("selected"):("")?> >
			  <?=$arryCustModule[$i]['Module']?>
			  </option>
			  <? } ?>
			</select>
				</td>
				</tr>
			</table>

	</td>
</tr>
<tr>
  <td> <div class="message" align="center"><? if(!empty($_SESSION['mess_cust'])) {echo $_SESSION['mess_cust']; unset($_SESSION['mess_cust']); }?></div>

  </td>
</tr>
<? if($NumField>0){ ?>
<tr>
  <td align="left" >
  <B>Edit Label : </B>
   </td>
</tr>
  <tr>
  <td align="center" >
  <table width="100%"  border="0" cellpadding="5" cellspacing="0" class="borderall">
	
<?	$Line=0;
	foreach($arryCustomField as $key=>$values){
		if($_SESSION['locationID']==1){
			$FieldID = $values['FieldID'];
			$FieldTitle = stripslashes($values['FieldTitle']);
			$Status = $values['Status'];
		}else{
			$arryFieldValue = $objConfigure->CustomValueByParent($_SESSION['locationID'],$values['FieldID']);
			$FieldID = $arryFieldValue[0]['FieldID'];
			$FieldTitle = stripslashes($arryFieldValue[0]['FieldTitle']);
			$Status = $arryFieldValue[0]['Status'];
		}
		
		$Line++;

?>			
	 <tr>
		  <td align="right"   class="blackbold" width="40%"> 
		  <?=$values['FieldInfo']?> : </td>
		  <td  align="left" >
		  <input  name="FieldTitle<?=$Line?>" id="FieldTitle<?=$Line?>" value="<?=$FieldTitle?>" type="text" class="inputbox" maxlength="30" onkeypress="return isCharKey(event);" />
			&nbsp;&nbsp;<input name="Status<?=$Line?>" type="checkbox" value="1" <?=($Status==1)?"checked":""?> /> Active
		  <input  name="FieldID<?=$Line?>" id="FieldID<?=$Line?>" value="<?=$FieldID?>" type="hidden" readonly />
		  <input  name="MainFieldID<?=$Line?>" id="MainFieldID<?=$Line?>" value="<?=$values['FieldID']?>" type="hidden" readonly />

		  </td>
		</tr>
<?		
	}	  
?>	
  

  </table>
  
  
  </td>
	    </tr>


	

		<tr>
				<td align="center" >

	<input type="hidden" name="NumField" id="NumField" value="<?=$NumField?>">   
				<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Update " />
			  
				  </td>
		  </tr>

	<? } ?>	
	

	    </form>
</TABLE>
