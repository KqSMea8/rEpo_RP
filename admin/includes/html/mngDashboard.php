<script language="JavaScript1.2" type="text/javascript">

function SelectAllRecord()
{	
	for(i=1; i<=document.form1.numModule.value; i++){
		document.getElementById("IconID"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.numModule.value; i++){
		document.getElementById("IconID"+i).checked=false;
	}
}


function ShowListing(){
	ShowHideLoader('1','L');	
	location.href = "mngDashboard.php?d="+document.getElementById("Department").value;
}

function validateForm(frm){
	ShowHideLoader('1','S');	
	return true;
}
</script>

<div class="had">Manage Dashboard Icon</div>

<div class="message"><? if(!empty($_SESSION['mess_dash'])) {echo $_SESSION['mess_dash']; unset($_SESSION['mess_dash']); }?></div>


<table width="100%"   border="0" cellpadding="0" cellspacing="0" >
<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">
	<tr>
	  <td align="center" >
	  
	  <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
	<tr>
        <td colspan="2" height="5">
		
		</td>
  </tr>   
<tr>
        <td  align="right"   class="blackbold" width="12%"> Division  : </td>
        <td   align="left" >
<select name="Department" class="inputbox" id="Department" onChange="Javascript:ShowListing();">
  <option value="">--- Select ---</option>
  <? for($i=0;$i<sizeof($arryDepartment);$i++) {?>
  <option value="<?=$arryDepartment[$i]['depID']?>" <?=($_GET["d"]==$arryDepartment[$i]['depID'])?("selected"):("")?> >
  <?=$arryDepartment[$i]['Department']?>
  </option>
  <? } ?>
</select>

	</td>
</tr>

<tr>
        <td colspan="2" align="right" height="5">
<?   if($numModule>1){ 	?>
	<a href="javascript:SelectAllRecord();">Select All</a> | <a href="javascript:SelectNoneRecords();" >Select None</a>
<? } ?>		
		
		</td>
  </tr>
<? if($_GET["d"]>0){ ?>			
<tr>
        <td  align="right"   class="blackbold" valign="top" > Show Icon  : </td>
        <td   align="left" >			 
 <?  if($numModule>0){ ?>
<table width="100%"  border="0" cellspacing=3 cellpadding=5 >
   <? 
  	$flag=true;
	$Line=0;
  	foreach($arryDashboardIcon as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	
	if ($Line % 3 == 0) {
		echo "</tr><tr>";
	}

	$Line++;
	
	$checked=($values['Display']==1)?("checked"):("");



		if($values['IframeFancy']=="i"){
			$Iframe = "fancybox fancybox.iframe";
		}else if($values['IframeFancy']=="f"){
			$Iframe = "fancybox";
		}else{
			$Iframe = "";
		}

  ?>
     <td valign="top" width="33%"><input type="checkbox" name="IconID[]" id="IconID<?=$Line?>" value="<?=$values['IconID']?>" <?=$checked?>/>&nbsp;
	 <? if($values['Default']=="0" && $values['IframeFancy']!="f"){ ?>
	 <a class="<?=$Iframe?>" href="<?=$Department."/".$values['Link']?>" target="_blank"><?=stripslashes($values['Module'])?></a>
     <? }else{ ?>
	<?=stripslashes($values['Module'])?>
	 <? } ?>
	 </td>

    <?php } // foreach end //?>
  

	
  </table>

    <?php }else{ echo NO_MODULE; } ?>



	</td>
  </tr>
<? } ?>



	   
	  </table></td>
	</tr>

<? if($numModule>0){  ?>
	<tr>
	  <td align="center"  height="50">

	<input name="Submit" type="submit" id="SubmitButton" class="button" value="Submit" />
		<input type="hidden" name="numModule" id="numModule" value="<?=$numModule?>" />  
					   
			  </td>
		</tr>		
<? } ?>

	</form>
</table>

	 