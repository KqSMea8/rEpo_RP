<script language="JavaScript1.2" type="text/javascript">
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
	location.href = 'punch.php?emp='+document.getElementById("EmpID").value+'&depID='+document.getElementById("Department").value;
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
	
	document.getElementById("punch_load").style.display = 'block';
	document.getElementById("punch_form").style.display = 'none';

}



</script>

<div class="had" style="margin-bottom:5px;">Punching <?=$PuchType?></div>


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




<? if($_GET['emp']>0){ ?>




				<tr>
                      <td align="right"  class="blackbold">
					 Date :
					  </td>
                      <td align="left">
	<!--<?=date($Config['DateFormat'],strtotime($TodayDate))?>
	<input type="hidden" name="attDate" id="attDate" value="<?=$TodayDate?>" />
	-->

<?

$attDate = date("Y-m-d", strtotime($Config['TodayDate'])); 
$dt = $attDate;


?>

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


});
</script>
<input id="attDate" class="datebox" name="attDate" readonly="" size="10" value="<?=$dt?>"  type="text" > 


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
					<? } ?>
					<?  if(!empty($arryToday[0]["InComment"])){ ?>	
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						In Time Comment :
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
					<? } ?>
					<?  if(!empty($arryToday[0]["OutComment"])){ ?>	
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Out Time Comment :
					  </td>
                      <td  align="left" valign="top">
	<?=(!empty($arryToday[0]["OutComment"]))?(nl2br(stripslashes($arryToday[0]["OutComment"]))):(NOT_SPECIFIED)?>

					  </td>
                    </tr>	
					<? } ?>


					

					
					
<?  if($PuchType!='Done'){ // Process ?>
					
       
		
		<? if($PuchType == "In"){ ?>
		<tr>
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
	<? $Time = substr($arryTime[1],0,5);  
	   $FieldName = $PuchType.'Time';				  
	 ?>

	<script>
	  $(function() {
		$('#<?=$FieldName?>').timepicker({ 
			'timeFormat': 'H:i',
			'step': '1'
			});
	  });
	</script>

	<input name="<?=$FieldName?>" type="text" class="disabled" size="4" maxlength="5" id="<?=$FieldName?>" value="<?=$Time?>"  autocomplete="off"/>

	<input name="MainTime" type="hidden" size="4" maxlength="5" id="MainTime" value="<?=$Time?>"  autocomplete="off"/>

</div>



					  </td>
                    </tr>			  	
                  
			
					 <tr>
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
		<?  if($_GET['emp']>0 && $PuchType!='Done'){ // Process ?>
		<tr>
				<td align="center" valign="top">
	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Submit "/>
	<input type="hidden" name="MainEmpID" id="MainEmpID" value="0" />
	<input type="hidden" name="attID" id="attID" value="<?=$arryToday[0]["attID"]?>" />
	
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

