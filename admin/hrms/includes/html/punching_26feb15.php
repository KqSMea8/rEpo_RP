<script language="JavaScript1.2" type="text/javascript">
function SetPunchingType(type){	
	if(type=='l'){
		$("#lunchid").attr('class', 'grey_bt');
		$("#shortid").attr('class', 'white_bt');
		$("#punchingid").attr('class', 'white_bt');
		$("#hadtitle").html("Lunch Punching");
		$("#punchType").val("Lunch");
	}else if(type=='s'){
		$("#lunchid").attr('class', 'white_bt');
		$("#shortid").attr('class', 'grey_bt');
		$("#punchingid").attr('class', 'white_bt');
		$("#hadtitle").html("Short Break Punching");
		$("#punchType").val("Short Break");
	}else{
		$("#lunchid").attr('class', 'white_bt');
		$("#shortid").attr('class', 'white_bt');
		$("#punchingid").attr('class', 'grey_bt');
		$("#hadtitle").html("Punching Out");
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

<div id="punch_load" style="display:none;padding:60px;" align="center"><img src="../images/ajaxloader.gif"></div>
<div id="punch_form" style="min-height:150px;">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="formPunch" action="" method="post"  enctype="multipart/form-data" >

<? if(!empty($arryToday[0]["InTime"]) && empty($arryToday[0]["OutTime"]) && empty($arryPendingOut[0]['punchID'])){?>
<tr >
 <td align="left">

	<? if($LunchPunch==1 && $TotalLunch!=1 && $TotalLunch<=0){?>
	<a href="Javascript:void(0);" class="white_bt" id="lunchid" onclick="Javascript:SetPunchingType('l');">Lunch</a> 
	<? } 

	if($ShortBreakPunch==1 && $TotalShortBreak<$ShortBreakLimit){
	?>
	<a href="Javascript:void(0);" class="white_bt" id="shortid" onclick="Javascript:SetPunchingType('s');">Short Break</a> 
	<? } ?>
	<a href="Javascript:void(0);" class="grey_bt" id="punchingid" onclick="Javascript:SetPunchingType('p');">Punching Out</a>

</td>
</tr>
<? } ?>

		<tr>
		  <td >

		  <table width="100%" border="0" cellpadding="5" cellspacing="1"  align="center">

			<tr  >
			<td align="right"  class="blackbold">
			<strong>Working Hour :</strong>
			</td>
			<td align="left">
				<strong><?=date($Config['TimeFormat'],strtotime($WorkingHourStart))?> - <?=date($Config['TimeFormat'],strtotime($WorkingHourEnd))?></strong>				
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
				<input type="hidden" name="attDate" id="attDate" value="<?=$TodayDate?>" />
			</td>
			</tr>
					
					<?  if(!empty($arryToday[0]["InTime"])){  // In Time ?>	
					<tr id="intimetr">
                      <td  align="right"   class="blackbold" valign="top" > 
						<?=$InTimeHead?> :
					  </td>
                      <td  align="left" valign="top" id="intimeid">
						<?=$arryToday[0]["InTime"]?>
					  </td>
                    </tr>	
					
					<tr id="intimecommenttr">
                      <td  align="right"   class="blackbold" valign="top"> 
						<?=$InTimeHead?> Comment:
					  </td>
                      <td  align="left" valign="top" id="intimecommentid">
	<?=(!empty($arryToday[0]["InComment"]))?(nl2br(stripslashes($arryToday[0]["InComment"]))):(NOT_SPECIFIED)?>

					  </td>
                    </tr>	
					<? } ?>
					
					<?  if(!empty($arryToday[0]["OutTime"])){ // Out Time ?>	
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						<?=$OutTimeHead?>  :
					  </td>
                      <td  align="left" valign="top">
						<?=$arryToday[0]["OutTime"]?>
					  </td>
                    </tr>	
					
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						<?=$OutTimeHead?> Comment:
					  </td>
                      <td  align="left" valign="top">
	<?=(!empty($arryToday[0]["OutComment"]))?(nl2br(stripslashes($arryToday[0]["OutComment"]))):(NOT_SPECIFIED)?>

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
		 				<input type="hidden" name="<?=$PuchType?>Time" id="<?=$PuchType?>Time" value="<?=$Time?>" />
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
		<tr>
				<td align="center" valign="top">
			<? //if($_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>
	<input name="Submit" type="button" class="button" id="SubmitButton" value=" Submit " onClick="Javascript:submitPunching();"/>
	<input type="hidden" name="EmpID" id="EmpID" value="<?=$_SESSION['AdminID']?>" readonly />
	<input type="hidden" name="attID" id="attID" value="<?=$arryToday[0]['attID']?>" readonly/>
	<input type="hidden" name="punchType" id="punchType" value="<?=$arryPendingOut[0]['punchType']?>" readonly/>
	<input type="hidden" name="punchID" id="punchID" value="<?=$arryPendingOut[0]['punchID']?>" readonly/>


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
