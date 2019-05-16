<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){
	
		if(document.getElementById("EmpID") != null){
			document.getElementById("emp").value = document.getElementById("EmpID").value;
		}
	
		if(document.getElementById("Department").value==""){
			alert("Please Select Department.");
			document.getElementById("Department").focus();
			return false;
		}
	
		if(document.getElementById("emp").value==""){
			alert("Please Select Employee.");
			document.getElementById("emp").focus();
			return false;
		}
		if(document.getElementById("y").value==""){
			alert("Please Select Year.");
			document.getElementById("y").focus();
			return false;
		}
		if(document.getElementById("m").value==""){
			alert("Please Select Month.");
			document.getElementById("m").focus();
			return false;
		}

		var YearMonth = document.getElementById("y").value+document.getElementById("m").value;
		if(YearMonth >= document.getElementById("TodayDt").value){
			alert("Select year and month should be less than current month.");
			return false;
		}


		ShowHideLoader(1,'L');
	}	
</script>

  <div><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had">View Generated Salary &raquo; <span>
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit Generated ") :(" Generate ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>

<?	if($ShowList!=1){ ?>  
<div>
<table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0">
 <form action="" method="get" name="form3" onSubmit="return ValidateSearch();">
	<tr>
		<td align="left" >
		<select name="Department" class="inputbox" id="Department" onChange="Javascript:EmpListSend('','');">
		  <option value="">--- Select Department ---</option>
		  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
		  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$_GET['Department']){echo "selected";}?>>
		  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
		
		<td>
		<div id="EmpTitle"></div>
		<div id="EmpValue"></div> 	
		</td>
		
		 <td><?=getYears($_GET['y'],"y","textbox")?></td>
			  
          <td><?=getMonths($_GET['m'],"m","textbox")?></td>
		 <td>
		 <input name="s" type="submit" class="search_button" value="Go"  />
		 <input type="hidden" name="TodayDt" id="TodayDt" value="<?=date("Ym", strtotime($Config['TodayDate']))?>" >

		<input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$_GET['emp']?>" />	
		<input type="hidden" name="emp" id="emp" value="<?=$_GET['emp']?>">
		<input type="hidden" name="EmpStatus" id="EmpStatus" value="1" />	
		
<script language="javascript">
EmpListSend('','');
</script>

		 </td> 
		
	</tr>
	</form>		

</table>
</div>					
<? } ?>  


<div id="prv_msg_div" style="display:none"><br><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	

	<? if(!empty($ErrorMsg)){ ?> 
		  <div align="center" id="ErrorMsg" class="redmsg">
			 <br><?=$ErrorMsg?>
		  </div>
	<? } ?>  

	<? include("includes/html/box/salary_gen_form.php"); ?>
</div>
		
		
	   

