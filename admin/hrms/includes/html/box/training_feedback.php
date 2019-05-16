<div id="feedback_form_div" style="display:none; width:500px; height:250px;">
<TABLE WIDTH=500   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="formOffer" action="" method="post"  enctype="multipart/form-data"  >
		<tr>
		  <td >
		   <div class="had2">Participant Feedback</div>

			<div id="feedback_load" style="display:none;padding-top:50px;" align="center"><img src="../images/ajaxloader.gif"></div>
			<div id="feedback_form"></div>
		
		  
		  </td>
	    </tr>
		
		<tr>
				<td align="center" >
	<input name="SubmitFd" type="button" class="button" id="SubmitFd" value=" Submit " onClick="Javascript:submitFeedback();"/>

	<input type="hidden" name="trainingID" id="trainingID" value="<?=$_GET['t']?>" />
	<input type="hidden" name="partID" id="partID" value="" />
	<input type="hidden" name="Feedback" id="Feedback" value="" />
	
	
				  </td>
		  </tr>
		
	    </form>
</TABLE>
</div>

<script language="JavaScript1.2" type="text/javascript">
function SetFeedbackForm(partID){
	$("#partID").val(partID);
	$("#Feedback").val('');

	$("#feedback_load").show();
	$("#feedback_form").hide();
	$("#SubmitFd").hide();

	var SendUrl = "&action=training_feedback&partID="+document.getElementById("partID").value+"&r="+Math.random(); 

	$.ajax({
		type: "GET",
		url: "ajax.php",
		data: SendUrl,
		success: function (responseText) {
			$("#feedback_form").html(responseText);
			if(document.getElementById("numParticipant").value ==1){
				$("#SubmitFd").show();
			}
			$("#feedback_load").hide();
			$("#feedback_form").show();
			
		}
	});

}



function validateFeedback(){
		
		if(document.getElementById("AjaxFeedback") != null){
			document.getElementById("Feedback").value = document.getElementById("AjaxFeedback").value;
		}

		
		if(!ValidateForSimpleBlank(document.getElementById("Feedback"), "Feedback")){
			return false;	
		}else{
			$.fancybox.close();
			ShowHideLoader('1','P');
			document.formOffer.submit();
			return true;	
		}

}



function submitFeedback(){

	if(document.getElementById("AjaxFeedback").value==""){
		alert("Please Enter Feedback");
	}else{

		$("#feedback_load").show();
		$("#feedback_form").hide();
		$("#SubmitFd").hide();
		
		var partID = document.getElementById("partID").value;
		var Feedback = document.getElementById("AjaxFeedback").value;

		var SendUrl = "&action=training_feedback&partID="+partID+"&Feedback="+escape(Feedback)+"&r="+Math.random(); 

		$.ajax({
			type: "GET",
			url: "ajax.php",
			data: SendUrl,
			success: function (responseText) {
				$("#feedback_form").html(responseText);
				$("#FeedDiv"+partID).html(nl2br(Feedback,''));

				$("#feedback_load").hide();
				$("#feedback_form").show();


			}
		});


	}


}
</script>
