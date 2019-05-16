<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
<script language="JavaScript1.2" type="text/javascript">
function ReplaceTime(field_id){
	var field_val = document.getElementById(field_id).value;
	field_val = parseInt(field_val.replace(":", "")); 

	return field_val; 
}

function validatePunching(frm){	
	var InTime = ReplaceTime("InTime");
	var OutTime = ReplaceTime("OutTime");

	if(InTime>0 && OutTime>0){
		if(OutTime < InTime){
			alert("Out Time should not be less than In Time.");
			frm.OutTime.focus();
			return false;
		}
	}


	document.getElementById("punch_load").style.display = 'block';
	document.getElementById("punch_form").style.display = 'none';
	document.getElementById("userinfo").style.display = 'none';

}


</script>

<div class="had">Edit Punch</div>

<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="borderall" id="userinfo">
 
<? if(!empty($arryEmployee[0]['EmpID'])){ ?>
<tr>
	<td>

	<strong><?=$arryEmployee[0]["EmpCode"]?></strong>
	<? echo '<br>'.$arryEmployee[0]['UserName'].'<br>'.stripslashes($arryEmployee[0]['JobTitle']).' - '.stripslashes($arryEmployee[0]['Department']); ?>

	</td>
</tr>
<? } ?>


<? if(!empty($arryAttendence[0]['attDate'])){ ?>
<tr>
	<td>

	<strong><?=date($Config['DateFormat'].", l",strtotime($arryAttendence[0]["attDate"]))?></strong>


	</td>
</tr>
<? } ?>

</table>
<br>
<div id="punch_load" style="display:none;padding:60px;" align="center"><img src="../images/ajaxloader.gif"></div>
<div id="punch_form" style="min-height:200px;">
<TABLE WIDTH=400   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 class="borderall">
<form name="formPunch" action=""  method="post" onSubmit="return validatePunching(this);" enctype="multipart/form-data">
<tr>
              <td  align="left"   class="head" colspan="2">Punch In/Out</td>
            
</tr>

<tr>
              <td  align="right"   class="blackbold" width="40%"> In Time : </td>
              <td  align="left" valign="top">

<? $Time=''; if($arryAttendence[0]['InTime']>0)$Time = $arryAttendence[0]['InTime'];
   $FieldName = 'InTime';				  
 ?>
<script>
 /* $(function() {
	$('#<?=$FieldName?>').timepicker({ 
		'timeFormat': 'H:i:s',
		'step': '1'
		});
  });*/
</script>
<input name="<?=$FieldName?>" type="text" class="textbox TimeCls" size="4" maxlength="10" id="<?=$FieldName?>" value="<?=$Time?>"  autocomplete="off"/>
<?=TIME_FORMAT?>
 </td>
</tr>

<tr>
              <td  align="right"   class="blackbold"> Out Time : </td>
              <td  align="left" valign="top">

<? $Time='';if($arryAttendence[0]['OutTime']>0)$Time = $arryAttendence[0]['OutTime'];
   $FieldName = 'OutTime';				  
 ?>
<script>
 /* $(function() {
	$('#<?=$FieldName?>').timepicker({ 
		'timeFormat': 'H:i:s',
		'step': '1'
		});


  });*/
</script>
<input name="<?=$FieldName?>" type="text" class="textbox TimeCls" size="4" maxlength="10" id="<?=$FieldName?>" value="<?=$Time?>"  autocomplete="off"/>

<a href="Javascript:void(0);" onclick="Javascript:ClearBox('<?=$FieldName?>');">Clear</a>

 </td>
</tr>


<? $Line=0;
foreach($arryBreak as $key=>$values){
$Line++;

	if(empty($values['punchID'])) $values['punchID']='';
 
 ?>
<tr>
              <td  align="left"   class="head" colspan="2">
<?=$values["punchType"]?> In/Out

<input name="punchID[]" type="hidden" value="<?=$values['punchID']?>"  readonly >
<input name="punchType[]" type="hidden" value="<?=$values['punchType']?>"  readonly >
</td>
            
</tr>
<tr>
              <td  align="right"   class="blackbold" > Out Time : </td>
              <td  align="left" valign="top">

<? $Time=''; if(ConvertToSecond(!empty($values['InTime'])))$Time = $values['InTime'];
   $FieldName = 'BreakIn'.$Line;

				  
 ?>
<script>
 /* $(function() {
	$('#<?=$FieldName?>').timepicker({ 
		'timeFormat': 'H:i:s',
		'step': '1'
		});
  });*/
</script>
<input name="BreakIn[]" type="text" class="textbox TimeCls" size="4" maxlength="10" id="<?=$FieldName?>" value="<?=$Time?>"  autocomplete="off"/>

<a href="Javascript:void(0);" onclick="Javascript:ClearBox('<?=$FieldName?>');">Clear</a>

 </td>
</tr>

<tr>
              <td  align="right"   class="blackbold"> In Time : </td>
              <td  align="left" valign="top">

<? $Time='';if(ConvertToSecond(!empty($values['OutTime'])))$Time = $values['OutTime'];
   $FieldName = 'BreakOut'.$Line;				  
 ?>
<script>
 /* $(function() {
	$('#<?=$FieldName?>').timepicker({ 
		'timeFormat': 'H:i:s',
		'step': '1'
		});
  });*/
</script>
<input name="BreakOut[]" type="text" class="textbox TimeCls" size="4" maxlength="10" id="<?=$FieldName?>" value="<?=$Time?>"  autocomplete="off"/>

<a href="Javascript:void(0);" onclick="Javascript:ClearBox('<?=$FieldName?>');">Clear</a>

 </td>
</tr>




<? } ?>

<tr>
				<td  align="left" valign="top"> </td>
				<td align="left" valign="top" >
	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Update "/>
	<input type="hidden" name="attID" id="attID" value="<?=$arryAttendence[0]["attID"]?>" />
<input type="hidden" name="attDate" id="attDate" value="<?=$arryAttendence[0]["attDate"]?>" />
<input type="hidden" name="MainEmpID" id="MainEmpID" value="<?=$arryAttendence[0]["EmpID"]?>" />
<input type="hidden" name="Department" id="Department" value="<?=$arryEmployee[0]["depID"]?>" />

				  </td>
		  </tr>


</form>
</TABLE>
</div>








</div>

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

