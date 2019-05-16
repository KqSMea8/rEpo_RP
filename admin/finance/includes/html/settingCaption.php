<?
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
  <td   align="left" > <input type="text" name="caption" id="caption" value="" class="inputbox" maxlength="30">
   
</td>
</tr>
<tr>
        <td  align="right"   class="blackbold"> </td>
        <td   align="left" > 
<input type="submit" name="CaptionSave" id="CaptionSave" value="Save" class="button" >

<input type="hidden" name="setting_key" id="setting_key" value="" readonly>
<input type="hidden" name="Line" id="Line" value="<?=$_GET['id']?>" readonly>



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
        var setting_key = document.getElementById("setting_key").value ;
	var caption = Trim(document.getElementById("caption")).value;
	if(caption ==''){
		$(".redmsg").html('Please Enter Caption.');
		return false;
	}

	var SendUrl = "ajax.php?action=settingCaption&caption="+escape(caption)+"&setting_key="+escape(setting_key)+"&r="+Math.random();
	$(".redmsg").html('Saving.....');
	httpObj.open("GET", SendUrl, true);
	httpObj.onreadystatechange = function RecieveSaveCaption(){
		if (httpObj.readyState == 4) {
			if(httpObj.responseText==1) {
				$(".redmsg").html('Saved');
				alert('Saved successfully.');  
				window.parent.document.getElementById("caption"+Line).value = caption;
				window.parent.document.getElementById("caption_span"+Line).innerHTML = caption;
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




function SaveCaptionOld(){	
       

	var caption = document.getElementById("caption").value ;
        var setting_key = document.getElementById("setting_key").value ;
	// alert(setting_key);return false;
         //alert(caption);return false;
	var SendUrl = "&action=caption="+escape(caption)+"&setting_key="+escape(setting_key)+"&r="+Math.random();
   	$.ajax({
	type: "GET",
	url: "ajax.php",
	data: SendUrl,
	   
		success: function (html){
                   if(html=='false')
                      {	 
			alert('Please enter correct code');
			parent.jQuery.fancybox.close();
			ShowHideLoader('1','P');
		      }
		}
		

   	});
	return false;		  

}

function setval(Line){
	document.getElementById("caption").value = window.parent.document.getElementById("caption"+Line).value;
	document.getElementById("setting_key").value = window.parent.document.getElementById("setting_key"+Line).value;
}
setval(<?=$_GET['id']?>);
</script>

<? } ?>






