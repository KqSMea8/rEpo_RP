<script language="JavaScript1.2" type="text/javascript">
	function ShowDateField(){	
		 if(document.getElementById("fby").value=='Date'){
			document.getElementById("fromDiv").style.display = 'block';
			document.getElementById("toDiv").style.display = 'block';
			document.getElementById("y").style.display = 'none';	
			document.getElementById("m").style.display = 'none';
		 }else{
			document.getElementById("fromDiv").style.display = 'none';
			document.getElementById("toDiv").style.display = 'none';
			document.getElementById("y").style.display = 'block';	
			document.getElementById("m").style.display = 'block';
		 }
	}


	function SetEmpID(){	
		document.getElementById("preview_div").style.display = 'none';
	}
	function ValidateForm(){
		document.getElementById("emp2").value = '';
		/*
		if(document.getElementById("Department").value==""){
			alert("Please Select Department.");
			document.getElementById("Department").focus();
			return false;
		}*/

		document.getElementById("depID2").value = document.getElementById("Department").value;

		if(document.getElementById("EmpID") != null){
			if(document.getElementById("Department").value>0){
				document.getElementById("emp2").value = document.getElementById("EmpID").value;
			}
		}
		
		if(document.getElementById("fby").value=='Date'){

			if(document.getElementById("f").value==""){
				alert("Please Select From Date.");
				document.getElementById("f").focus();
				return false;
			}
			if(document.getElementById("t").value==""){
				alert("Please Select To Date.");
				document.getElementById("t").focus();
				return false;
			}


		}else{

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

		}
		ShowHideLoader('1','F');


		
		
	}


	function SubmitEmp(frm){	
		//document.getElementById("prv_msg_div").style.display = 'block';
		//document.getElementById("preview_div").style.display = 'none';
		//document.topForm.submit();
		document.getElementById("emp1").value = document.getElementById("emp").value;
		document.getElementById("emp2").value = document.getElementById("emp").value;
	}	
	
	function ValidateSearch(){	

		if(document.getElementById("Department").value==""){
			alert("Please Select Department.");
			document.getElementById("Department").focus();
			return false;
		}

		document.getElementById("depID1").value = document.getElementById("Department").value;
	
		if(document.getElementById("EmpID") != null){
			document.getElementById("emp1").value = document.getElementById("EmpID").value;
		}


		if(document.getElementById("dt").value==""){
			alert("Please Select Date.");
			return false;
		}
		ShowHideLoader('1','F');
		/*
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';*/
		
	}
	
	function ValidateSearch2(){


		if(document.getElementById("Department").value==""){
			alert("Please Select Department.");
			document.getElementById("Department").focus();
			return false;
		}

		document.getElementById("depID2").value = document.getElementById("Department").value;

		if(document.getElementById("EmpID") != null){
			document.getElementById("emp2").value = document.getElementById("EmpID").value;
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
		ShowHideLoader('1','F');
		/*
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';*/

	}	
</script>




<div class="had"><?=$MainModuleName?></div>



<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0">




 <tr>
	  <td  valign="top">

	  
	<table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0">
	<form action="" method="get" name="topForm" onSubmit="return ValidateForm();">
	<tr>
		<td  colspan="2"  valign="top">
		 
	 <table border="0" cellpadding="3" cellspacing="0" >
	<tr>
		<td width="70" align="right">Department :  </td>
		<td >
		<select name="Department" class="textbox" id="Department" onChange="Javascript:EmpListSend('1','1');">
			  <option value="">--- All ---</option>
			  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
			  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$_GET['depID']){echo "selected";}?>>
			  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
			  </option>
			  <? } ?>
			</select>

		</td>
	
	
		<td width="70" align="right"><div id="EmpTitle">Employee  :</div></td>
		<td >
		 <div id="EmpValue"></div> 	
		<input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$_GET['emp']?>" />	
		<input type="hidden" name="EmpStatus" id="EmpStatus" value="1" />	

		<script language="javascript">
		EmpListSend('1','1');
		</script>	
		
		</td>

		 <td>&nbsp;</td>

		<td>
		
		Filter By : <select name="fby" class="textbox" id="fby" style="width:100px;" onChange="Javascript:ShowDateField();">	  
	
		 <option value="Month" <?  if($_GET['fby']=='Month'){echo "selected";}?>>Month</option>
		<option value="Date" <?  if($_GET['fby']=='Date'){echo "selected";}?>>Date Range</option>
					
		</select> 
		</td>
	   	<td>&nbsp;</td>

		<td>
		 <? if($_GET['f']>0) $FromDate = $_GET['f'];  ?>				
<script type="text/javascript">
$(function() {
	$('#f').datepicker(
		{
		showOn: "both",dateFormat: '<?=$Config["DateFormatJS"]?>', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
		maxDate: "+0D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<div id="fromDiv" style="display:none">
 <input id="f" name="f" readonly="" class="datebox" value="<?=$FromDate?>"  type="text" placeholder="From Date" > 
</div>

	</td> 

	   <td>&nbsp;</td>

		 <td>

		 <? if($_GET['t']>0) $ToDate = $_GET['t'];  ?>				
<script type="text/javascript">
$(function() {
	$('#t').datepicker(
		{
		showOn: "both", dateFormat: '<?=$Config["DateFormatJS"]?>', 
		yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
		maxDate: "+0D", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<div id="toDiv" style="display:none">
<input id="t" name="t" readonly="" class="datebox" value="<?=$ToDate?>"  type="text" placeholder="To Date">
</div>



</td> 




		 <td><?=getYears($_GET['y'],"y","textbox")?></td>
			  
          	 <td><?=getMonths($_GET['m'],"m","textbox")?></td>


		 <td>
		 <input name="s2" type="submit" class="search_button" value="Go"  />
		 
		  <input type="hidden" name="emp" id="emp2" value="<?=$_GET["emp"]?>" />
		 <input type="hidden" name="depID" id="depID2"  value="<?=$_GET["depID"]?>" />
	<script>
	  ShowDateField();
	  </script>

		 </td> 
		</tr>
	 </table>




			
		</td>
		</tr>
		</form>
		


	

	</table>  
	  
	
<br>
<div class="message"><? if(!empty($_SESSION['mess_att'])) {echo $_SESSION['mess_att']; unset($_SESSION['mess_att']); }?></div>


<div id="print_export" style="clear:both">

<?if($ModifyLabel==1){?>
<a class="add fancybox fancybox.iframe" href="punchadmin.php?emp=<?=$_GET['emp']?>&depID=<?=$_GET['depID']?>" >Punch In/Out</a>


<br><br>
<a href="uploadAttendence.php" class="add" >Upload Attendance Sheet</a>
<? }?>	
 <? if($num>0){ ?>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_att.php?<?=$QueryString?>';" />
		<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>

<? } ?>

</div>  
 <div class="cb"></div>

<br>


        

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<? if($ShowList==1){ ?>

 <? if($num>0 && $DeleteLabel==1){ ?>
 <br>
 <div class="cb"></div>
<input type="submit" name="DeleteButton" class="button" style="float:right;margin-bottom:5px;" value="Delete" onclick="javascript: return ValidateMultiple('attendance record','delete','NumField','attID');">
<? } ?>

<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable"  >
   
    <tr align="left"  >
	<td class="head1" >Employee</td>
	<td width="20%" class="head1" >Date</td>
	<td width="8%"  class="head1" >In Time</td>
	<td width="10%"  class="head1">In Time Comment</td>
	<td  width="10%" class="head1" >Out Time</td>
	<td width="10%" class="head1" >Out Time Comment</td>
	<td width="12%" class="head1" >Duration</td>
	<td width="4%" align="center" class="head1 head1_action" >Breaks</td>
	<?if($ModifyLabel==1){?><td width="4%"  align="center" class="head1 head1_action" >Edit
	  </td><?}?>
      <td width="4%"  align="center" class="head1 head1_action" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','attID','<?=sizeof($arryAttendence)?>');" />
	  </td>
	
    </tr>
   
    <?php 
$TotalDuration = 0;
  if(is_array($arryAttendence) && $num>0){
	$flag=true;
	$Line=0; $NewEmpID='';
	foreach($arryAttendence as $key=>$values){
	$flag=!$flag;
	$Line++;
	$Duration = 0;
	$BreakTime = 0;
	$incolor = ''; $outcolor ='';	
	$bgclass = (!$flag)?("oddbg"):("evenbg");

	/****************/
	$LunchPaid = $LunchPaidMain; 
	$ShortBreakPaid = $ShortBreakPaidMain;
	if(!empty($values['shiftName'])){
		$LunchPaid = $values['LunchPaid']; 
		$ShortBreakPaid = $values['ShortBreakPaid'];
	}
	$BreakType = '';unset($arryBreakTime);
	if($LunchPaid!=1) $BreakType .= "'Lunch',";
	if($ShortBreakPaid!=1) $BreakType .= "'Short Break',";
	$BreakType =rtrim($BreakType,",");
	if(!empty($BreakType)){
		$arryBreakTime=$objTime->getBreakTime($values['attID'],$BreakType);
		foreach($arryBreakTime as $keytime=>$valuestime){		
			$BreakTime += ConvertToSecond($valuestime['TimeDuration']);
		}
		
	}
	/****************/

	/*
	if(!empty($values["InTime"]) && !empty($values["OutTime"])){
		$Duration = strtotime($values["OutTime"]) - strtotime($values["InTime"]);
		$TotalDuration += $Duration;
		if($Duration<0) $Duration=0;
		$Duration = time_diff($Duration);
		
	}*/


	//$TimeDuration = getDurationFormat($values["TimeDuration"]);
	


	$Duration = ConvertToSecond($values["TimeDuration"]) - $BreakTime;
	if($Duration>0){$TotalDuration += $Duration; $Duration = time_diff($Duration);}
	
	


  ?>


		<? if($NewEmpID != $values['EmpID']){ ?>
		 <tr class="evenbg">
		  <td  colspan="10" >
		 
		  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><strong><?=$values["EmpCode"]?></strong></a> 
		<? echo '<br><strong>'.$values['UserName'].'<br>'.stripslashes($values['JobTitle']).' - '.stripslashes($values['Department']).'</strong>'; 

		
?>
	
		  </td>
		</tr>
		<? } ?>

    <tr align="left" class="<?=$bgclass?>">
       <td>
	   </td>     
      <td><?=date($Config['DateFormat'].", l",strtotime($values["attDate"]))?></td>
       <td><? if(!empty($values["InTime"])) echo date($Config['TimeFormat'],strtotime($values["InTime"])); ?></td>

      <td bgcolor="<?=$incolor?>"><?=stripslashes($values["InComment"])?></td>
        <td><? if(!empty($values["OutTime"])) echo date($Config['TimeFormat'],strtotime($values["OutTime"]));?></td>
      <td bgcolor="<?=$outcolor?>"><?=stripslashes($values["OutComment"])?></td>
      <td>
<?=($Duration>0)?($Duration):('')?>

</td>
	<td align="center" class="head1_inner">

<a class="fancybox fancybig fancybox.iframe" href="vAttBreak.php?att=<?=$values['attID']?>&emp=<?=$values['EmpID']?>" ><?=$view?></a>


</td>
<?if($ModifyLabel==1){?>
 <td align="center" class="head1_inner">
	<a class="fancybox fancybig fancybox.iframe" href="editPunch.php?att=<?=$values['attID']?>" ><?=$edit?></a>
 </td>
<? } ?>

      <td align="center" class="head1_inner"><!--a href="<?=$RedirectUrl?>&del_id=<?=$values['attID']?>" onclick="return confirmDialog(this, 'Attendance Record')"><?=$delete?></a--> 
	  <input type="checkbox" name="attID[]" id="attID<?=$Line?>" value="<?=$values['attID']?>" />
	  
	  </td>


    </tr>
	

    <?php 
	  $NewEmpID = $values['EmpID'];
  } // foreach end //?>
  
    <?php }else{?>
    <tr >
      <td  colspan="10" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
 <tr >  <td  colspan="10" align="left"  >
 
 <? if($_GET['emp']>0 && $TotalDuration>0){ ?>
	<div align="right"><strong> Total Duration : <?=TotalTimeDiff($TotalDuration)?>&nbsp;&nbsp;&nbsp;&nbsp;  </strong></div>
<? }else{ ?>
Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryAttendence)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink; }?>
<? } ?>
 
</td>
  </tr>
  </table>
  <? } ?>
  </div>
  

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?=$_GET['curP']?>">

  <input type="hidden" name="NumField" id="NumField" value="<?=$Line?>">


</form>

</td>
</tr>
</table>

</div>

<script language="JavaScript1.2" type="text/javascript">

    $(document).ready(function() {
        $(".fancybig").fancybox({
            'width': 900
        });

    });

</script>

<? //include("includes/html/box/att_detail.php"); ?>
