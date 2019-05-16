<div id="select_training" style="display:none; width:800px; height:550px;">
<div class="had2">&nbsp;Select Training</div>
	<div id="training_load" style="display:none;padding-top:200px;" align="center"><img src="../images/ajaxloader.gif"></div>
	<div id="training_search" style="float:right;padding-bottom:10px;">
		<form name="frmTrainingSrch" action="" method="post" onSubmit="return ShowTrainingList(this);">
		<input type="text" name="TrainingKeyword" id="TrainingKeyword" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
		</form>
	</div>
	<div id="training_list" style="width:800px; height:470px; overflow:auto">
	</div>
</div>


<script language="JavaScript1.2" type="text/javascript">
function SetTraining(){
	/*
	document.getElementById("training_list").style.display = 'none';
	document.getElementById("training_search").style.display = 'none';
	document.getElementById("training_load").style.display = 'block';
	*/
	$("#training_list").hide();
	$("#training_search").hide();
	$("#training_load").show();
}



function ShowTrainingList(){
	SetTraining();
	var SendUrl = "&action=training_list&k="+escape(document.getElementById("TrainingKeyword").value)+"&r="+Math.random(); 

	$.ajax({
		type: "GET",
		url: "ajax.php",
		data: SendUrl,
		success: function (responseText) {
			$("#training_list").html(responseText);
			$("#training_list").show();
			$("#training_search").show();
			$("#training_load").hide();

			return false;
		}
	});

	return false;
}



function ShowTrainingList5555(){
	SetTraining();

	var SendUrl = "ajax.php?action=training_list&k="+escape(document.getElementById("TrainingKeyword").value)+"&r="+Math.random(); 
	httpObj.open("GET", SendUrl, true);
	httpObj.onreadystatechange = function TrainingListRecieve(){
		if (httpObj.readyState == 4) {
			/*document.getElementById("training_list").innerHTML = httpObj.responseText;
			document.getElementById("training_list").style.display = 'block';
			document.getElementById("training_search").style.display = 'block';
			document.getElementById("training_load").style.display = 'none';*/

			$("#training_list").html(httpObj.responseText);
			$("#training_list").show();
			$("#training_search").show();
			$("#training_load").hide();

			return false;
		}

	};

	httpObj.send(null);

	return false;

}

</script>
