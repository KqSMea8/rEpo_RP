<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script>
 $(function() {

     $( "#punchTypeDrop" ).selectmenu({
         change: function( event, ui ) {
             console.log(ui);
             var selected_value = ui.item.value;
            // alert("You selected : "+selected_value);
	    SetPunchingType(selected_value);
         }
     });
});
</script>

<script language="JavaScript1.2" type="text/javascript">


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

	var SendUrl = "&action=punching&EmpID="+escape(document.getElementById("EmpID").value)+"&attID="+escape(document.getElementById("attID").value)+"&attDate="+escape(document.getElementById("attDate").value)+"&InTime="+escape(InTime)+"&OutTime="+escape(OutTime)+"&InComment="+escape(InComment)+"&OutComment="+escape(OutComment)+"&punchType="+escape(punchType)+"&punchID="+escape(punchID)+"&r="+Math.random();
	

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
	?>
	<!--a href="Javascript:void(0);" style="float:none;" class="white_bt" id="lunchid" onclick="Javascript:SetPunchingType('l');">Lunch Out</a--> 
	<? } 

	if($ShortBreakPunch==1 && $TotalShortBreak<$ShortBreakLimit){
		$ShortBtnShown=1;
	?>
	<!--a href="Javascript:void(0);" style="float:none;" class="white_bt" id="shortid" onclick="Javascript:SetPunchingType('s');">Short Break Out</a--> 
	<? } 


	if($LunchBtnShown==1 || $ShortBtnShown==1){
	?>
	<!--a href="Javascript:void(0);" style="float:none;" class="grey_bt" id="punchingid" onclick="Javascript:SetPunchingType('p');">Punch Out</a-->

	<select name="punchTypeDrop" id="punchTypeDrop" class="punchTypeDrop" style="width:210px;" >
		<option value="p" selected  >Punch Out</option>
		<?if($LunchBtnShown==1){?><option value="l">Lunch Out</option><?}?>
		<?if($ShortBtnShown==1){?><option value="s">Short Break Out</option><?}?>		
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
				<input type="hidden" name="attDate" id="attDate" value="<?=$TodayDate55?>" />
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
		 				<input type="hidden" name="<?=$PuchType?>Time" id="<?=$PuchType?>Time" value="<?=$Time55?>" />
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
				<td align="center" valign="top">
			
	<input name="Submit" type="button" class="button" id="SubmitButton" value=" Punch " onClick="Javascript:submitPunching();"/>
	<input type="hidden" name="EmpID" id="EmpID" value="<?=$_SESSION['AdminID']?>" readonly />
	<input type="hidden" name="attID" id="attID" value="<?=$arryToday[0]['attID']?>" readonly/>
	<input type="hidden" name="punchType" id="punchType" value="<?=$arryPendingOut[0]['punchType']?>" readonly/>
	<input type="hidden" name="punchID" id="punchID" value="<?=$arryPendingOut[0]['punchID']?>" readonly/>




				  </td>
		  </tr>

		<tr>
				<td align="center" valign="top">
<? echo $arryTime[1];
$WithingDeptClock=1;
$digitalStyle = 'style="position:relative;cursor:pointer;right:0px"';
$digitalAttrib = 'alt="'.CLICK_TO_PUNCH.'" title="'.CLICK_TO_PUNCH.'" onClick="Javascript:submitPunching();"';
include("../includes/html/box/clock_digital2.php"); 
?>




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
