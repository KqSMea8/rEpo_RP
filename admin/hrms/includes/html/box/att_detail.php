<div id="punch_form_div" style="display:none; width:350px;min-height:230px;">
<div class="had2">Attendence Detail</div>
<div id="record_pop" align="center"></div>

</div>

<script language="JavaScript1.2" type="text/javascript">
function AttendenceDetail(attID){
		if(attID>0){
			document.getElementById("record_pop").innerHTML = '<img src="images/loading.gif">';
			var SendUrl = "ajax.php?action=att_detail&attID="+attID+"&r="+Math.random(); 
			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function ListAttendenceDetail(){
				if (httpObj.readyState == 4) {
					document.getElementById("record_pop").innerHTML = httpObj.responseText;
				}

			};

			httpObj.send(null);
		}else{
			document.getElementById("record_pop").innerHTML = "No record";
		}

}
</script>	