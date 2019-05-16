<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
 

<script language="JavaScript1.2" type="text/javascript">
function SetPageHead(){
	var punchType = $("#punchTypeDrop").val();
	if(punchType!=''){
		if(punchType=='l'){		 
			$("#hadtitle").html("Lunch Out");		
		}else if(punchType=='s'){		 
			$("#hadtitle").html("Short Break Out");		
		}else{		
			$("#hadtitle").html("Punch Out");		
		}
		 
	}

}

function SetPageHeadBreakIn(BreakType){
	$("#hadtitle").html(BreakType+" In");	
}

function SetPageHeadPunchOut(){
	$("#hadtitle").html("Punch Out");	
}


function submitPunching(){
			
	var Hour = $('#digital-clock .hour')[0].innerHTML;
	var Min = $('#digital-clock .min')[0].innerHTML;
	var Sec = $('#digital-clock .sec')[0].innerHTML;
	var meridiem = $('#digital-clock .meridiem')[0].innerHTML;
	var CurrentTime = Hour+''+Min+''+Sec+':'+meridiem; 
	var punchType = '';	
	if(document.getElementById("punchTypeDrop") != null){
		punchType = $("#punchTypeDrop").val();
	}	
        if(Trim(document.getElementById("PIN")).value==""){		
		$("#msgdiv").html('<div class="redmsg">Please Enter PIN.</div>');		
		return false;
	}
  
	$("#punch_load").show();
	$("#punch_form").hide();
 
	var SendUrl = "&action=pinpunching&PIN="+escape(document.getElementById("PIN").value)+"&CurrentTime="+escape(CurrentTime)+"&punchType="+escape(punchType)+"&r="+Math.random();
 	
	$("#punchTypeDiv").html(""); 
	$("#msgdiv").html("&nbsp;");
	 

	$.ajax({
		type: "GET",
		url: "ajax_punch.php",
		data: SendUrl,
		success: function (responseText) {
			
			var res = responseText.split("#");
			  
			if(res[0] == "dropdown"){
				$("#punchTypeDiv").html(res[1]);
				SetPageHead();
			}else if(res[0] == "breakin"){
				$("#msgdiv").html(res[2]);
				SetPageHeadBreakIn(res[1]);
			}else if(res[0] == "punchout"){
				$("#msgdiv").html(res[1]);
				SetPageHeadPunchOut();
			}else{
				$("#msgdiv").html(responseText);			 
			}

			$("#punch_load").hide();
			$("#punch_form").show();

		}
	});

}



</script>

<div class="had" style="margin-bottom:5px;" id="hadtitle">Punch In</div>

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>
<div id="msgdiv" align="center">&nbsp;</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="borderall">
  <tr>
    <td align="left">

<div id="punch_load" style="display:none;padding:30px;" align="center"><img src="../images/ajaxloader.gif"></div>
<div id="punch_form" style="min-height:240px;">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="formPunch" action="" method="post"  enctype="multipart/form-data" >

     
<tr  >
        
        <td  align="center" height="30">		 
    <input name="PIN" type="text" class="inputbox" id="PIN" value=""  maxlength="40" placeholder="PIN" /onKeyPress="Javascript:ClearAvail('msgdiv'); return isUniqueKey(event);" > 
           </td>
      </tr>
<tr  >
        
        <td  align="center" id="punchTypeDiv">		 
   
           </td>
      </tr>

		<tr>
				<td align="center" valign="top">
<? 
$WithingDeptClock=1;
$digitalStyle = 'style="position:relative;cursor:pointer;right:0px"';
$digitalAttrib = 'alt="'.CLICK_TO_PUNCH.'" title="'.CLICK_TO_PUNCH.'" onClick="Javascript:submitPunching();"';
include("../includes/html/box/clock_digital.php"); 
?>




				  </td>
		  </tr>



		 




	    </form>
</TABLE>	
</div>
	
	</td>
	 
  </tr>
</table>
<? } ?>
