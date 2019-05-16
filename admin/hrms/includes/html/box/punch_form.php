<?

	$TodayDate =  $Config['TodayDate']; 
	$arryTime = explode(" ",$Config['TodayDate']);
	$TodayDate = $arryTime[0];

	$arryToday = $objTime->getAttendence('','', $_SESSION['AdminID'],$TodayDate, '','');
	if(empty($arryToday[0]["attID"])){
		$PuchType = "In";
	}else if(empty($arryToday[0]["OutTime"])){
		$PuchType = "Out";
	}else{
		$PuchType = "Done";
	}
?>
<script language="JavaScript1.2" type="text/javascript">
function validate_punching(frm){
	$.fancybox.close();
	ShowHideLoader('1','P');
	return true;
}
</script>
<div id="punch_form_div" style="display:none;">
<TABLE WIDTH=350   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="formPunch" action="" method="post"  enctype="multipart/form-data" onSubmit="return validate_punching(this);">
		<tr>
		  <td >


		   <div class="had2">Punching <?=$PuchType?></div>
		  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" align="center">
				<tr>
                      <td width="45%" align="right"  class="blackbold">
					 Date :
					  </td>
                      <td align="left">
						<?=date($Config['DateFormat'],strtotime($TodayDate))?>
		 				<input type="hidden" name="attDate" value="<?=$TodayDate?>" />
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
		 				<input type="hidden" name="<?=$PuchType?>Time" value="<?=$Time?>" />
					  </td>
                    </tr>			  	
                  
			
					 <tr>
						  <td align="right"   class="blackbold" valign="top"><?=$PuchType?> Time Comment  :</td>
						  <td  align="left" >
							<textarea name="<?=$PuchType?>Comment" type="text" class="textarea" id="<?=$PuchType?>Comment" maxlength="200" onkeypress="return isAlphaKey(event);"></textarea>	
							
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
	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Submit " />
	<input type="hidden" name="EmpID" value="<?=$_SESSION['AdminID']?>" />
	<input type="hidden" name="attID" value="<?=$arryToday[0]["attID"]?>" />
	
				  </td>
		  </tr>
		  <? } ?>




	    </form>
</TABLE>
</div>