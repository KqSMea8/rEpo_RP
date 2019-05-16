<script language="JavaScript1.2" type="text/javascript">
function submitPunching(){
	var InTime='', OutTime='', InComment='', OutComment='';

	if(document.getElementById("InTime") != null){
		InTime = document.getElementById("InTime").value;;
	}
	if(document.getElementById("OutTime") != null){
		OutTime = document.getElementById("OutTime").value;;
	}
	if(document.getElementById("InComment") != null){
		InComment = document.getElementById("InComment").value;;
	}
	if(document.getElementById("OutComment") != null){
		OutComment = document.getElementById("OutComment").value;;
	}

	$("#punch_load").show();
	$("#punch_form").hide();

	var SendUrl = "&action=punching&EmpID="+document.getElementById("EmpID").value+"&attID="+document.getElementById("attID").value+"&attDate="+document.getElementById("attDate").value+"&InTime="+InTime+"&OutTime="+OutTime+"&InComment="+escape(InComment)+"&OutComment="+escape(OutComment)+"&r="+Math.random();
	

	$.ajax({
		type: "GET",
		url: "ajax.php",
		data: SendUrl,
		success: function (responseText) {
			
			$("#punch_form").html(responseText);

			$("#punch_load").hide();
			$("#punch_form").show();

		}
	});

}



</script>

<div class="had" style="margin-bottom:5px;">Punching <?=$PuchType?></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="borderall">
  <tr>
    <td align="left">

<div id="punch_load" style="display:none;padding:60px;" align="center"><img src="../images/ajaxloader.gif"></div>
<div id="punch_form" style="min-height:200px;">
<TABLE WIDTH=350   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="formPunch" action="" method="post"  enctype="multipart/form-data" >
		<tr>
		  <td >

		  <table width="100%" border="0" cellpadding="5" cellspacing="1"  align="center">
				<tr>
                      <td width="45%" align="right"  class="blackbold">
					 Date :
					  </td>
                      <td align="left">
						<?=date($Config['DateFormat'],strtotime($TodayDate))?>
		 				<input type="hidden" name="attDate" id="attDate" value="<?=$TodayDate?>" />
					  </td>
                    </tr>
					
					<?  if(!empty($arryToday[0]["InTime"])){  // In Time ?>	
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						In Time :
					  </td>
                      <td  align="left" valign="top">
						<?=$arryToday[0]["InTime"]?>
					  </td>
                    </tr>	
					
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						In Time Comment:
					  </td>
                      <td  align="left" valign="top">
	<?=(!empty($arryToday[0]["InComment"]))?(nl2br(stripslashes($arryToday[0]["InComment"]))):(NOT_SPECIFIED)?>

					  </td>
                    </tr>	
					<? } ?>
					
					<?  if(!empty($arryToday[0]["OutTime"])){ // Out Time ?>	
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Out Time :
					  </td>
                      <td  align="left" valign="top">
						<?=$arryToday[0]["OutTime"]?>
					  </td>
                    </tr>	
					
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Out Time Comment:
					  </td>
                      <td  align="left" valign="top">
	<?=(!empty($arryToday[0]["OutComment"]))?(nl2br(stripslashes($arryToday[0]["OutComment"]))):(NOT_SPECIFIED)?>

					  </td>
                    </tr>	
					<? } ?>
					
					
					
					<?  if($PuchType!='Done'){ // Process ?>	
                    <tr>
                      <td  align="right"   class="blackbold"> 
					<?=$PuchType?> Time :

					  </td>
                      <td  align="left" valign="top">
					<? echo $Time = $arryTime[1];  ?>
		 				<input type="hidden" name="<?=$PuchType?>Time" id="<?=$PuchType?>Time" value="<?=$Time?>" />
					  </td>
                    </tr>			  	
                  
			
					 <tr>
						  <td align="right"   class="blackbold" valign="top"><?=$PuchType?> Time Comment  :</td>
						  <td  align="left" >
							<textarea name="<?=$PuchType?>Comment" type="text" class="textarea" id="<?=$PuchType?>Comment" maxlength="200" ></textarea>	
							
							</td>
						</tr>


                   <? } ?>
                   
                  </table>
		  
		  
		  
		  
		  </td>
	    </tr>
		<?  if($PuchType!='Done'){ // Process ?>
		<tr>
				<td align="center" valign="top">
			<? //if($_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>
	<input name="Submit" type="button" class="button" id="SubmitButton" value=" Submit " onClick="Javascript:submitPunching();"/>
	<input type="hidden" name="EmpID" id="EmpID" value="<?=$_SESSION['AdminID']?>" />
	<input type="hidden" name="attID" id="attID" value="<?=$arryToday[0]["attID"]?>" />
	
				  </td>
		  </tr>
		  <? } ?>




	    </form>
</TABLE>	
</div>
	
	</td>
	 
  </tr>
</table>
