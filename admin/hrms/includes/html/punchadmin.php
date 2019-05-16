<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
<script language="JavaScript1.2" type="text/javascript">

function SetPunchingType(){	
	var type = document.getElementById("punchTypeDrop").value;
	if(type=='l'){
		$("#incommenttr").hide();
    		$("#commenttr").hide();
		$("#intimetr").hide();
		$("#hadtitle").html("Lunch Out");
		$("#punchType").val("Lunch");
	}else if(type=='s'){
		$("#incommenttr").hide();
		$("#commenttr").hide();
		$("#intimetr").hide();
		$("#hadtitle").html("Short Break Out");
		$("#punchType").val("Short Break");
	}else{
		$("#incommenttr").show();
		$("#commenttr").show();
		$("#intimetr").show();
		$("#hadtitle").html("Punch Out");
		$("#punchType").val("");
	}
}


function SetComment(cmt)
{
	if(cmt==''){
		$("#TimeTitle").show();
		$("#TimeVal").show();
		$("#CommentTitle").show();
		$("#CommentVal").show();
		
		var MainTime = $("#MainTime").val();
		$("#InTime").val(MainTime);
	}else{
		$("#TimeTitle").hide();
		$("#TimeVal").hide();
		$("#CommentTitle").hide();
		$("#CommentVal").hide();

		$("#InTime").val('');
	}
	$("#InComment").val(cmt);

}


function SetEmpID(){
	document.getElementById("punch_load").style.display = 'block';
	document.getElementById("punch_form").style.display = 'none';
	
	var dt = '';
	if(document.getElementById("attDate")!=null){
		dt = document.getElementById("attDate").value;
	}
	
	location.href = 'punchadmin.php?emp='+document.getElementById("EmpID").value+'&depID='+document.getElementById("Department").value+'&dt='+dt;
}

function validatePunching(frm){

	if(document.getElementById("EmpID") != null){
		document.getElementById("MainEmpID").value = document.getElementById("EmpID").value;
	}
	
	if(!ValidateForSelect(frm.Department,"Department")){
		return false;
	}
	if(!ValidateForSelect(frm.MainEmpID, "Employee")){
		return false;
	}
	
	var t = $(".TimeCls").val();
	if(t==''){
		alert("Please enter time.");
		return false;
	}

	document.getElementById("punch_load").style.display = 'block';
	document.getElementById("punch_form").style.display = 'none';

}

id="hadtitle"

</script>

<div class="had" style="margin-bottom:5px;" id="hadtitle"><?=$PunchingTitle?></div>


<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="borderall">
  <tr>
    <td align="left" height="300" valign="top">

<? if(!empty($_SESSION['mess_punch'])) {
	echo '<br><br><div class="message" align="center">'.$_SESSION['mess_punch'].'</div>'; unset($_SESSION['mess_punch']); 
}else{ ?>
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
				  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$_GET['depID']){echo "selected";}?>>
				 <?=stripslashes($arrySubDepartment[$i]['Department'])?>
				  </option>
				  <? } ?>
				</select></td>
					  </tr>

					   <tr>
						<td  align="right"  class="blackbold" valign="top"><div id="EmpTitle">Employee  :<span class="red">*</span></div> </td>
						<td  align="left" >
						<div id="EmpValue"></div> <input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$_GET['emp']?>" /><input type="hidden" name="EmpStatus" id="EmpStatus" value="1" />	
										
						</td>
					  </tr>


<? if(!empty($ErrorMSG)){ ?>
<tr>
	 <td></td>
	<td align="left"  class="redmsg" ><?=$ErrorMSG?></td>
</tr>
<? }else if($_GET['emp']>0){ ?>


	<? if(!empty($arryToday[0]["InTime"]) && empty($arryToday[0]["OutTime"]) && empty($arryPendingOut[0]['punchID'])){

		if($LunchPunch==1 && $TotalLunch!=1 && $TotalLunch<=0){
			$LunchBtnShown=1;
		}
		if($ShortBreakPunch==1 && $TotalShortBreak<$ShortBreakLimit){
			$ShortBtnShown=1;
		}

		if($LunchBtnShown==1 || $ShortBtnShown==1){
	?>
	<tr>
	 <td align="right"  class="blackbold">Punch For : </td>
	 <td>
		<select name="punchTypeDrop" id="punchTypeDrop" class="inputbox"  onchange="Javascript:SetPunchingType();">
			<option value="p" selected  >Punch Out</option>
			<?if($LunchBtnShown==1){?><option value="l">Lunch Out</option><?}?>
			<?if($ShortBtnShown==1){?><option value="s">Short Break Out</option><?}?>		
		</select>
	</td>
	</tr>

	<? }
	} 

	?>


	
	<tr>
                      <td align="right"  class="blackbold">
					 Date :
					  </td>
                      <td align="left">
	<!--<?=date($Config['DateFormat'],strtotime($TodayDate))?>
	<input type="hidden" name="attDate" id="attDate" value="<?=$TodayDate?>" />
	-->



<script type="text/javascript">
$(function() {
	$('#attDate').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-2?>:<?=date("Y")?>', 
		maxDate: "+0D", 
		changeMonth: true,
		changeYear: true

		}
	);
	
	$("#attDate").on("change", function () { 
			 SetEmpID();
		}
	);

});
</script>
<input id="attDate" class="datebox" name="attDate" readonly="" size="10" value="<?=$TodayDate?>"  type="text"  > 


					  </td>
                    </tr>


<?  if(!empty($arryToday[0]["InTime"])){  // In Time ?>	
					<tr id="intimetr">
                      <td  align="right"   class="blackbold" valign="top"> 
						<?=$InTimeHead?> :
					  </td>
                      <td  align="left" valign="top">
					  <? if(!empty($arryToday[0]["InTime"])) echo date($Config['TimeFormat'],strtotime($arryToday[0]["InTime"])); ?>
						
					  </td>
                    </tr>	
					<? } ?>
					<?  if(!empty($arryToday[0]["InComment"])){ ?>	
					<tr id="incommenttr">
                      <td  align="right"   class="blackbold" valign="top"> 
						<?=$InTimeHead?> Comment :
					  </td>
                      <td  align="left" valign="top">
	<?=(!empty($arryToday[0]["InComment"]))?(nl2br(stripslashes($arryToday[0]["InComment"]))):(NOT_SPECIFIED)?>

					  </td>
                    </tr>					
					<? } ?>
					
					<?  if(!empty($arryToday[0]["OutTime"])){ // Out Time ?>	
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						<?=$OutTimeHead?> :
					  </td>
                      <td  align="left" valign="top">
					  <? if(!empty($arryToday[0]["OutTime"])) echo date($Config['TimeFormat'],strtotime($arryToday[0]["OutTime"])); ?>
						
					  </td>
                    </tr>
					<? } ?>
					<?  if(!empty($arryToday[0]["OutComment"])){ ?>	
					<tr id="outcommenttr">
                      <td  align="right"   class="blackbold" valign="top"> 
						<?=$OutTimeHead?> Comment :
					  </td>
                      <td  align="left" valign="top">
	<?=(!empty($arryToday[0]["OutComment"]))?(nl2br(stripslashes($arryToday[0]["OutComment"]))):(NOT_SPECIFIED)?>

					  </td>
                    </tr>	
					<? } ?>


					

					
					
<?  if($PuchType!='Done'){ // Process ?>
					
       
		
		<? if($PuchType == "In"){ ?>
		<tr <?=$HideForBreak?>>
			<td  align="right"   class="blackbold" valign="top"> 
			Punching Type :
			</td>
			<td  align="left" valign="top">

		<input type="radio" name="PunchingType" id="PunchingType1" value="1" onclick="Javascript:SetComment('');" checked/>
		Attendance<br>
		<input type="radio" name="PunchingType" id="PunchingType2" value="2" onclick="Javascript:SetComment('OD');"/>
		Out Duty<br>
		<input type="radio" name="PunchingType" id="PunchingType3" value="3" onclick="Javascript:SetComment('L');"/>
		Leave<br>
		  
			</td>
        <tr>
		<? } ?>




                    <tr>
                      <td  align="right"   class="blackbold"> 
					<div id="TimeTitle"><?=$PuchType?> Time :</div>

					  </td>
                      <td  align="left" valign="top">

<div id="TimeVal">
	<? $Time = $arryTime[1]; //substr($arryTime[1],0,5);  
	   $FieldName = $PuchType.'Time';				  
	 ?>

	<script>
	/*  $(function() {
		$('#<?=$FieldName?>').timepicker({ 
			'timeFormat': 'H:i:s',
			'step': '1'
			});
	  });*/
	</script>

	<input name="<?=$FieldName?>" type="text" class="textbox TimeCls" size="4" maxlength="10" id="<?=$FieldName?>" value="<?=$Time?>"  autocomplete="off"/>

	<input name="MainTime" type="hidden" size="4" maxlength="10" id="MainTime" value="<?=$Time?>"  autocomplete="off"/>
<?=TIME_FORMAT?>
</div>



					  </td>
                    </tr>			  	
                  
			
					 <tr id="commenttr" <?=$HideForBreak?>>
						  <td align="right"   class="blackbold" valign="top"><div id="CommentTitle"><?=$PuchType?> Time Comment  :</div></td>
						  <td  align="left" >
						 <div id="CommentVal">
							<textarea name="<?=$PuchType?>Comment" type="text" class="textarea" id="<?=$PuchType?>Comment" maxlength="200" ></textarea>	
						</div>
							
							</td>
						</tr>

                   <? } ?>

<? } ?>

                   
                  </table>
		  
		  
		  
		  
		  </td>
	    </tr>
		<?  if($_GET['emp']>0 && $PuchType!='Done' && empty($ErrorMSG)){ // Process ?>
		<tr>
				<td align="center" valign="top">

<?
$attIDVal = !empty($arryToday[0]['attID'])?($arryToday[0]['attID']):('');
$punchTypeVal = !empty($arryPendingOut[0]['punchType'])?($arryPendingOut[0]['punchType']):('');  
$punchIDVal = !empty($arryPendingOut[0]['punchID'])?($arryPendingOut[0]['punchID']):(''); 
?>


	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Submit "/>
	<input type="hidden" name="MainEmpID" id="MainEmpID" value="0" />
	<input type="hidden" name="attID" id="attID" value="<?=$attIDVal?>" />
	<input type="hidden" name="punchType" id="punchType" value="<?=$punchTypeVal?>" readonly/>
	<input type="hidden" name="punchID" id="punchID" value="<?=$punchIDVal?>" readonly/>	



				  </td>
		  </tr>
		  <? } ?>




	    </form>
</TABLE>	
</div>
	<? } ?>

	</td>
	 
  </tr>
</table>
<script language="javascript">
EmpListSend('','1');
</script>


<script language="JavaScript1.2" type="text/javascript">
jQuery(function($){
   $(".TimeCls").mask("99:99:99");   

   $(".TimeCls").on("blur", function () { 
		var t = $(this).val();
		if(t !='' ){
			var timeArry = t.split(":");
			if(timeArry[0]>23 || timeArry[1]>59 || timeArry[2]>59){
				$(this).val('');
			}
		}
   });



});


</script>
