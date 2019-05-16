<?
$arryRightM = $objConfigure->getRightMenuByModuleId($_GET['ModuleID']);
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>

<div class="had" style="margin-bottom:5px;">Rename Caption</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
  <tr>
    <td align="center" class="redmsg" height="20">
</td>
	</tr>
  <tr>
    <td align="left">


<form name="Caption" id="Caption" action="" method="get" onSubmit="return SaveCaption();">
<table width="100%" border="0" cellpadding="3" cellspacing="0" >

	  
<tr>
  <td  align="right"   class="blackbold" width="45%"> Caption  :</td>
  <td   align="left" > <input type="text" name="caption" id="caption" value="<?=$arryRightM[0]['Module']?>" class="inputbox" maxlength="30">
   
</td>
</tr>
<tr>
        <td  align="right"   class="blackbold"> </td>
        <td   align="left" > 
<input type="submit" name="CaptionSave" id="CaptionSave" value="Save" class="button" >

<input type="hidden" name="Line" id="Line" value="<?=$_GET['Line']?>" readonly>
<input type="hidden" name="ModuleID" id="ModuleID" value="<?=$_GET['ModuleID']?>" readonly>



	</td>
</tr>

</table>		
</form>	
	
	</td>
	
  </tr>
  <tr>
    <td align="center"  height="20">
</td>
	</tr>
</table>

<script language="JavaScript1.2" type="text/javascript">

function SaveCaption(){	
	var Line = document.getElementById("Line").value ;	
        var ModuleID = document.getElementById("ModuleID").value ;
	var caption = Trim(document.getElementById("caption")).value;
	if(caption ==''){
		$(".redmsg").html('Please Enter Caption.');
		return false;
	}

	var SendUrl = "ajax.php?action=settingRightMenu&caption="+escape(caption)+"&ModuleID="+escape(ModuleID)+"&r="+Math.random();
	$(".redmsg").html('Saving.....');
	httpObj.open("GET", SendUrl, true);
	httpObj.onreadystatechange = function RecieveSaveCaption(){
		if (httpObj.readyState == 4) {
			if(httpObj.responseText==1) {
				$(".redmsg").html('Saved');
				alert('Saved successfully.');  
				 
				window.parent.document.getElementById("caption"+Line).innerHTML = caption;
				parent.jQuery.fancybox.close();				
				return false;			
			}else {
				alert("Error occur : " + httpObj.responseText);
				return false;
			}
		}
	};
	httpObj.send(null);
	return false;
}

</script>

<? } ?>

