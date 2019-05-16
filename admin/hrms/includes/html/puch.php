<script language="JavaScript1.2" type="text/javascript">

function SetEmpID(){
	ShowHideLoader('1','P');
	location.href = 
}

function validatePunching(){

	if(document.getElementById("EmpID") != null){
		document.getElementById("MainEmpID").value = document.getElementById("EmpID").value;
	}
	
	if(!ValidateForSelect(frm.Department,"Department")){
		return false;
	}
	if(!ValidateForSelect(frm.MainEmpID, "Employee")){
		return false;
	}
	
	ShowHideLoader('1','S');

}



</script>

<div class="had" style="margin-bottom:5px;">Punching <?=$PuchType?></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="borderall">
  <tr>
    <td align="left">

<div id="punch_load" style="display:none;padding:60px;" align="center"><img src="../images/ajaxloader.gif"></div>
<div id="punch_form" style="min-height:200px;">
<TABLE WIDTH=350   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
<form name="formPunch" action=""  method="post" onSubmit="return validatePunching(this);" enctype="multipart/form-data">
		<tr>
		  <td >

		  <table width="100%" border="0" cellpadding="5" cellspacing="1"  align="center">

					

				<tr>
						<td  align="right" width="45%"  class="blackbold" valign="top"> Department  :<span class="red">*</span> </td>
						<td   align="left" >

				<select name="Department" class="inputbox" id="Department" onChange="Javascript:EmpListSend('','1');">
				  <option value="">--- Select ---</option>
				  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
				  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryVacancy[0]['Department']){echo "selected";}?>>
				 <?=stripslashes($arrySubDepartment[$i]['Department'])?>
				  </option>
				  <? } ?>
				</select></td>
					  </tr>

					   <tr>
						<td  align="right"  class="blackbold" valign="top"><div id="EmpTitle">Employee  :<span class="red">*</span></div> </td>
						<td  align="left" >
						<div id="EmpValue"></div> <input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$arryVacancy[0]['HiringManager']?>" /><input type="hidden" name="EmpStatus" id="EmpStatus" value="1" />	
										
						</td>
					  </tr>




<? if($_GET['emp']>0){ ?>




				<tr>
                      <td align="right"  class="blackbold">
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

<? } ?>

                   
                  </table>
		  
		  
		  
		  
		  </td>
	    </tr>
		<?  if($_GET['emp']>0 && $PuchType!='Done'){ // Process ?>
		<tr>
				<td align="center" valign="top">
	<input name="Submit" type="button" class="button" id="SubmitButton" value=" Submit " onClick="Javascript:submitPunching();"/>
	<input type="hidden" name="MainEmpID" id="MainEmpID" value="0" />
	
				  </td>
		  </tr>
		  <? } ?>




	    </form>
</TABLE>	
</div>
	
	</td>
	 
  </tr>
</table>

