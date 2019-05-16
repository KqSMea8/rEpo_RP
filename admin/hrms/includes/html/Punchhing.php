
 <script type="text/javascript">

   function changeFunc() {
    var punchTypeDrop = document.getElementById("punchTypeDrop");
    var selectedValue = punchTypeDrop.options[punchTypeDrop.selectedIndex].value;
    SetPunchingType(selectedValue);
   }

  </script>
<link rel="stylesheet" type="text/css" href="../clock/css/digital.css"> 

<script language="JavaScript1.2" type="text/javascript">
function SetPageHead(type){
	if(type=='l'){
		$("#hadtitle").html("Lunch Out");
		$("#punchType").val("Lunch");
	}else if(type=='s'){
		$("#hadtitle").html("Short Break Out");
		$("#punchType").val("Short Break");
	}

}

function SetPunchingType(type){		

	if(type=='l'){
		$("#lunchid").attr('class', 'grey_bt');
		$("#shortid").attr('class', 'white_bt');
		$("#punchingid").attr('class', 'white_bt');
		$("#hadtitle").html("Lunch Out");
		$("#punchType").val("Lunch");
	}else if(type=='s'){
		$("#lunchid").attr('class', 'white_bt');
		$("#shortid").attr('class', 'grey_bt');
		$("#punchingid").attr('class', 'white_bt');
		$("#hadtitle").html("Short Break Out");
		$("#punchType").val("Short Break");
	}else{
		$("#lunchid").attr('class', 'white_bt');
		$("#shortid").attr('class', 'white_bt');
		$("#punchingid").attr('class', 'grey_bt');
		$("#hadtitle").html("Punch Out");
		$("#punchType").val("");
	}
	
	//$("#punch_load").show();
	//$("#punch_form").hide();

	$("#punchID").val("");
	var punchType = document.getElementById("punchType").value;

	if(punchType!=''){
	var SendUrl = "&action=punching_check&EmpID="+escape(document.getElementById("EmpID").value)+"&attID="+escape(document.getElementById("attID").value)+"&punchType="+escape(punchType)+"&r="+Math.random();

	$.ajax({
		type: "GET",
		url: "ajax.php",
		dataType : "JSON",
		data: SendUrl,
		success: function (responseText) {
			
			if(responseText["punchID"]>0){ 
				if(responseText["OutTime"]!='' && responseText["punchType"]=='Lunch'){					$("#punch_form").html('<div class="redmsg" align="center"><br><br>You have already taken your lunch time.</div>');
					
				}else{
					$("#punchID").val(responseText["punchID"]);
					$("#intimeid").html(responseText["InTime"]);
					$("#intimecommentid").html(responseText["InComment"]);
				}
			}else{	
				$("#intimetr").hide();
				$("#intimecommenttr").hide();
				$("#outtimeid").html(punchType+" Time Out : ");
				$("#outtimecommentid").html(" Comment : ");




			}
			
			//$("#punch_form").html(responseText);

			//$("#punch_load").hide();
			//$("#punch_form").show();

		}
	});


 	}else{ //set to default
		$("#intimetr").show();
		$("#intimecommenttr").show();
		$("#outtimeid").html("Out Time  : ");
		$("#outtimecommentid").html("Out Time Comment : ");
	}


}




function submitPunching(){
	
	var CurrentvalTime = document.getElementById('digital-clock').innerHTML; 
    var CurrentTime = CurrentvalTime.replace(" ", ":");


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
	var punchType = document.getElementById("punchType").value;
 	var punchID = document.getElementById("punchID").value;

	$("#punch_load").show();
	$("#punch_form").hide();

	var SendUrl = "&action=punching&EmpID="+escape(document.getElementById("EmpID").value)+"&attID="+escape(document.getElementById("attID").value)+"&attDate="+escape(document.getElementById("attDate").value)+"&InTime="+escape(InTime)+"&OutTime="+escape(OutTime)+"&InComment="+escape(InComment)+"&OutComment="+escape(OutComment)+"&punchType="+escape(punchType)+"&punchID="+escape(punchID)+"&CurrentTime="+escape(CurrentTime)+"&r="+Math.random();
	//alert(SendUrl);

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

<div class="had" style="margin-bottom:5px;" id="hadtitle"><?=$PunchingTitle?></div>

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="borderall">
  <tr>
    <td align="left">

<div id="punch_load" style="display:none;padding:30px;" align="center"><img src="../images/ajaxloader.gif"></div>
<div id="punch_form" style="min-height:150px;">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="formPunch" action="" method="post"  enctype="multipart/form-data" >


<tr >
 <td align="center" height="25">

<? if(!empty($arryToday[0]["InTime"]) && empty($arryToday[0]["OutTime"]) && empty($arryPendingOut[0]['punchID'])){?>

	<? if($LunchPunch==1 && $TotalLunch!=1 && $TotalLunch<=0){
		$LunchBtnShown=1;
		$arryPendingOut[0]['punchType'] = 'Lunch';
		echo '<script>SetPageHead("l");</script>';
		$l_selected = 'selected';
	?>
	<!--a href="Javascript:void(0);" style="float:none;" class="white_bt" id="lunchid" onclick="Javascript:SetPunchingType('l');">Lunch Out</a--> 
	<? } 

	if($ShortBreakPunch==1 && $TotalShortBreak<$ShortBreakLimit){
		$ShortBtnShown=1;
		if($LunchBtnShown!=1){
			$arryPendingOut[0]['punchType'] = 'Short Break';
			echo '<script>SetPageHead("s");</script>';
			$s_selected = 'selected';
		}


	?>
	<!--a href="Javascript:void(0);" style="float:none;" class="white_bt" id="shortid" onclick="Javascript:SetPunchingType('s');">Short Break Out</a--> 
	<? } 


	if($LunchBtnShown==1 || $ShortBtnShown==1){
	?>
	<!--a href="Javascript:void(0);" style="float:none;" class="grey_bt" id="punchingid" onclick="Javascript:SetPunchingType('p');">Punch Out</a-->

	<select name="punchTypeDrop" id="punchTypeDrop" class="punchTypeDrop" style="width:210px;" onchange="changeFunc();" >		
		<?if($LunchBtnShown==1){?><option value="l" <?=$l_selected?>>Lunch Out</option><?}?>
		<?if($ShortBtnShown==1){?><option value="s" <?=$s_selected?>>Short Break Out</option><?}?>
		<option value="p" >Punch Out</option>		
	</select>
	<?}?>


<? } ?>

</td>
</tr>


		<tr>
		  <td >

		  <table width="100%" border="0" cellpadding="5" cellspacing="1"  align="center" <?=$HideUnwanted?>>

			<? if(!empty($shiftName)){?>
			<tr  >
			<td align="right"  class="blackbold">
			<strong>Shift Name :</strong>
			</td>
			<td align="left">
				<strong><?=stripslashes($shiftName)?></strong>			
			</td>
			</tr>
			<? } ?>



			<tr  >
			<td align="right"  class="blackbold">
			<strong>Shift Hrs :</strong>
			</td>
			<td align="left">
				<strong><?=date($Config['NewTimeFormat'],strtotime($WorkingHourStart))?> - <?=date($Config['NewTimeFormat'],strtotime($WorkingHourEnd))?></strong>				
			</td>
			</tr>

			
			
			
			<? if(!empty($LunchTime) ){ ?>
			<tr >
			<td align="right"  class="blackbold">
			<strong>Lunch Time :</strong>
			</td>
			<td align="left">
				<strong><?=$LunchTime?></strong>
			</td>
			</tr>
			<? } ?>


		

			<? if($ShortBreakLimit >0){ ?>
			<tr >
			<td align="right"  class="blackbold">
			<strong>Short Break Limit :</strong>
			</td>
			<td align="left">
				<strong><?=$ShortBreakLimit?> 
				<? if(!empty($ShortBreakTime)) echo ' for '.$ShortBreakTime.' minutes each'; ?>

				</strong>
			</td>
			</tr>
			<? } ?>



			<tr>
			<td align="right"  class="blackbold">
			<strong>Flex Time :</strong>
			</td>
			<td align="left">
				<strong><?=($FlexTime==1)?('Yes'):('No')?></strong>				
			</td>
			</tr>

			<tr  >
			<td width="45%" align="right"  class="blackbold">
			<strong>Date :</strong>
			</td>
			<td align="left">
				<strong><?=date($Config['DateFormat'],strtotime($TodayDate))?></strong>
				<input type="text" name="attDate" id="attDate" value="<?=$TodayDate55?>" />
			</td>
			</tr>
					
					<?  if(!empty($arryToday[0]["InTime"])){  // In Time ?>	
					<tr id="intimetr" class="evenbg">
                      <td  align="right"   class="blackbold" valign="top" > 
						<?=$InTimeHead?> :
					  </td>
                      <td  align="left" valign="top" id="intimeid" class="red">
<? 

echo date($Config['TimeFormat'],strtotime($arryToday[0]["InTime"])); ?>

					
					  </td>
                    </tr>	
					
					<tr id="intimecommenttr" <?=$HideComments?>>
                      <td  align="right"   class="blackbold" valign="top"> 
						<?=$InTimeHead?> Comment:
					  </td>
                      <td  align="left" valign="top" id="intimecommentid">
	<?=(!empty($arryToday[0]["InComment"]))?(nl2br(stripslashes($arryToday[0]["InComment"]))):(NOT_SPECIFIED)?>

					  </td>
                    </tr>	
					<? } ?>
					
					<?  if(!empty($arryToday[0]["OutTime"])){ // Out Time ?>	
					<tr class="evenbg">
                      <td  align="right"   class="blackbold" valign="top"> 
						<?=$OutTimeHead?>  :
					  </td>
                      <td  align="left" valign="top" class="red">
<? echo date($Config['TimeFormat'],strtotime($arryToday[0]["OutTime"])); ?>
						
					  </td>
                    </tr>	
					
					<tr <?=$HideComments?>>
                      <td  align="right"   class="blackbold" valign="top"> 
						<?=$OutTimeHead?> Comment:
					  </td>
                      <td  align="left" valign="top">
	<?=(!empty($arryToday[0]["OutComment"]))?(nl2br(stripslashes($arryToday[0]["OutComment"]))):(NOT_SPECIFIED)?>

					  </td>
                    </tr>
			<tr >
                      <td colspan="2" height="25"> 
					
					  </td>
                   
                    </tr>

	
					<? } ?>
					
					
					
					<?  if($PuchType!='Done'){ // Process ?>	
                    <tr>
                      <td  align="right"   class="blackbold" id="outtimeid"> 
					<?=$PuchType?> Time :

					  </td>
                      <td  align="left" valign="top">
					<? echo $Time = $arryTime[1];  ?>
		 				<input type="text" name="<?=$PuchType?>Time" id="<?=$PuchType?>Time" value="<?=$Time55?>" />
					  </td>
                    </tr>			  	
                  
			
					 <tr>
						  <td align="right"   class="blackbold" valign="top" id="outtimecommentid"><?=$PuchType?>  Comment  :</td>
						  <td  align="left" >
							<textarea name="<?=$PuchType?>Comment" type="text" class="textarea" id="<?=$PuchType?>Comment" maxlength="200" ></textarea>	
							
							</td>
						</tr>


                   <? } ?>
                   
                  </table>
		  
		  
		  
		  
		  </td>
	    </tr>
		<?  if($PuchType!='Done'){ // Process ?>





		<tr <?=$HideUnwanted?>>
				<td align="centehours+":"+minutes+":"+seconds+" "+dnr" valign="top">
			
	<input name="Submit" type="button" class="button" id="SubmitButton" value=" Punch " onClick="Javascript:submitPunching();"/>
	<input type="hidden" name="EmpID" id="EmpID" value="<?=$_SESSION['AdminID']?>" readonly />
	<input type="hidden" name="attID" id="attID" value="<?=$arryToday[0]['attID']?>" readonly/>
	<input type="hidden" name="punchType" id="punchType" value="<?=$arryPendingOut[0]['punchType']?>" readonly/>
	<input type="hidden" name="punchID" id="punchID" value="<?=$arryPendingOut[0]['punchID']?>" readonly/>




				  </td>
		  </tr>
		  
		  <?
		$TodayDate =  $Config['TodayDate']; 
		$arryTime = explode(" ",$TodayDate);
		 $arryTime2 = explode(":",$arryTime[1]);
		//print_r($arryTime2);
		
?>
		  <div id="clockdiv" style="float:right;">
	<input type="hidden" class="textbox"   maxlength="2" name="HourBox" id="HourBox" value="<?=$arryTime2[0]?>" readonly="">  
	<input type="hidden" class="textbox"  maxlength="2" name="MinBox" id="MinBox" value="<?=$arryTime2[1]?>" readonly=""> 
	<input type="hidden" class="textbox"  maxlength="2" name="SecBox" id="SecBox" value="<?=$arryTime2[2]?>" readonly=""> 
</div>
<!--<script>
function digclock()
{
	var d =  new Date();
	//alert(d);
	var t = d.toLocaleTimeString();
	
	document.getElementById('digital-clock').innerHTML = t;
	
}

setInterval(function(){digclock()},1000);

</script>-->


<script>

function showTime(){
	
var Hour = parseInt(document.getElementById("HourBox").value);
var Minute = parseInt(document.getElementById("MinBox").value);
var Second = parseInt(document.getElementById("SecBox").value);

var Digital=new Date()
var hours=Hour;
var minutes=Minute;
var seconds=Digital.getSeconds()
//var CurrentTime = hours+":"+minutes+":"+seconds;
//alert(CurrentTime);
var dn="AM"
if (hours>=12){ 
dn="PM"
hours=hours-12
}
if (hours==0)
hours=12
if(hours<10) 
hours = '0'+hours
if (minutes<=9)
minutes="0"+minutes
if (seconds<=9)
seconds="0"+seconds

//var CurrentTime= hours+":"+minutes+":"+seconds+" "+dn;
//document.Tick.Clock.value=CurrentTime+" "+d

document.getElementById('digital-clock').innerHTML = hours+":"+minutes+":"+seconds+" "+dn;
//setTimeout("show()",1000)
}
setInterval(function(){showTime()},1000);

</script>



		<tr>
				<td align="center" valign="top">
<?php 
$digitalStyle = 'style="position:relative;cursor:pointer;right:0px"';
$digitalAttrib = 'alt="'.CLICK_TO_PUNCH.'" title="'.CLICK_TO_PUNCH.'" onClick="Javascript:submitPunching();"';
//include("../includes/html/box/clock_digital.php"); 
?>

<ul id="digital-clock" class="newclock" <?=$digitalStyle?> <?=$digitalAttrib?>>	
</ul>
<!--<button  id="digital-clock"  class="newclock" <?=$digitalStyle?> <?=$digitalAttrib?>></button>-->

				  </td>
		  </tr>



		  <? } ?>




	    </form>
</TABLE>	
</div>
	
	</td>
	 
  </tr>
</table>
<? } ?>
