 <script language="javascript">
  	$(document).ready(function() {
		$("#Department").change(function(){
			$("#preview_div").hide();
		});

	});

</script>


<SCRIPT LANGUAGE=JAVASCRIPT>
function SetEmpID(){	

	if(document.getElementById("preview_div") != null){
		document.getElementById("preview_div").style.display = 'none';
	}

	if(document.getElementById("ErrorMsg") != null){
		document.getElementById("ErrorMsg").style.display = 'none';
	}

	if(document.getElementById("EmpID") != null){
		document.getElementById("emp").value = document.getElementById("EmpID").value;
	}

	if(document.getElementById("Department").value==""){
		alert("Please Select Department.");
	}else if(document.getElementById("emp").value==""){
		alert("Please Select Employee.");
	}else{
	
		if(document.getElementById("prv_msg_div") != null){
			document.getElementById("prv_msg_div").style.display = 'block';
		}
	
		location.href = 'editAppraisal.php?emp='+document.getElementById("emp").value;
		
	}
}
</SCRIPT>
  <div><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had"><?=$MainModuleName?> &raquo; <span>
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>

<div>

		 
		 <? if($_GET['edit'] >0){ ?>
			<input type="hidden" name="emp" id="emp" value="<?=$arryAppraisal[0]['EmpID']?>">
		 <? }else{ ?>
		 <table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0">   
     	
		<tr>
        <td  align="right"   class="blackbold"> Department  :</td>
        <td   align="left" >
			<select name="Department" class="inputbox" id="Department" onChange="Javascript:EmpListSend('','1');">
			  <option value="">--- Select ---</option>
			  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
			  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryEmployeeDetail[0]['depID']){echo "selected";}?>>
			  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
			  </option>
			  <? } ?>
			</select>		</td>
     	
        <td  align="right"  class="blackbold" ><div id="EmpTitle">Employee  :</div> </td>
        <td  align="left" >
		<div id="EmpValue"></div> 	
		 <input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$_GET['emp']?>" />	
		  <input type="hidden" name="emp" id="emp" value="<?=$_GET['emp']?>">
		<input type="hidden" name="EmpStatus" id="EmpStatus" value="1" />	
		</td>
		
		  </tr>
		</table> 
		<script language="javascript">
		EmpListSend('','1');
		</script>
		
	<? } ?>
			 	
					
</div>					

<? if(!empty($ErrorMsg)){ ?> 
	  <div align="center" id="ErrorMsg" class="redmsg">
	  <br><?=$ErrorMsg?>
	  </div>
<? } ?>  

<div id="prv_msg_div" style="display:none"><br><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	
	<? include("includes/html/box/appraisal_form.php");
	   $HideInSalaryForm = 1;
	   include("includes/html/box/salary_form.php");
	?>

</div>


<script>
$(function() {
	$('#SalaryFormDiv').hide();
});
</script>
		
		
	   

