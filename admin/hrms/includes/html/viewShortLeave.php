<script language="JavaScript1.2" type="text/javascript">

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
<div class="message"><? if(!empty($_SESSION['mess_sl'])) {echo $_SESSION['mess_sl']; unset($_SESSION['mess_sl']); }?></div>


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
		 <td><?=getYears($_GET['y'],"y","textbox")?></td>
			  
          <td><?=getMonths($_GET['m'],"m","textbox")?></td>
		 <td>
		 <input name="s2" type="submit" class="search_button" value="Go"  />
		 
		  <input type="hidden" name="emp" id="emp2" value="<?=$_GET["emp"]?>" />
		 <input type="hidden" name="depID" id="depID2"  value="<?=$_GET["depID"]?>" />


		 </td> 
		</tr>
	 </table>




			
		</td>
		</tr>
		</form>
		


	

	</table>  
	  
	
	  
 <? if($num>0){ ?>

		<div id="print_export" >
		
		<!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_overtime.php?<?=$QueryString?>';" -->
		<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>



		</div>  

<? } ?>
<br>


        

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<? if($ShowList==1){ ?>



 <br>
 <div class="cb"></div>



<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable"  >
   
    <tr align="left"  >
      <td class="head1" >Employee</td>
       <td width="20%" class="head1" >Date</td>
       <td width="8%"  class="head1" >In Time</td>
      <td  width="10%" class="head1" >Out Time</td>
      <td width="12%" class="head1" >Duration</td>
    
	  </td>
    </tr>
   
    <?php 
  if(is_array($arryShortLeave) && $num>0){
	$flag=true;
	$Line=0; $TotalDuration = 0; $TotalShortLeave = 0; $TotalShortLeave=0;
	$BreakTime='';
$NewEmpID=0;
	foreach($arryShortLeave as $key=>$values){
	$flag=!$flag;
	$Line++;
	$Duration = 0;
	$incolor = ''; $outcolor ='';
	$bgclass = (!$flag)?("oddbg"):("evenbg");

	/*if(!empty($values["InTime"]) && !empty($values["OutTime"])){
		$Duration = strtotime($values["OutTime"]) - strtotime($values["InTime"]);
		$TotalDuration += $Duration;
		if($Duration<0) $Duration=0;
		$Duration = time_diff($Duration);
		
	}*/

	//$BreakTime //Not Used


	$Duration = ConvertToSecond($values["TimeDuration"]) - $BreakTime;
	if($Duration>0){$TotalDuration += $Duration; $Duration = time_diff($Duration);}


  ?>


	<? if($NewEmpID != $values['EmpID']){ ?>

		<? if($TotalShortLeave>0 && $Line>1){?>
		 <tr class="evenbg">
		  <td  colspan="8" align="right" >
			 <strong>Total Short Leaves : <?=$TotalShortLeave?></strong>
		  </td>
		</tr>
		<? $TotalShortLeave=0; } ?>

		 <tr class="evenbg">
		  <td  colspan="8" >
		 
		  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><strong><?=$values["EmpCode"]?></strong></a> 
		<? echo '<br><strong>'.$values['UserName'].'<br>'.stripslashes($values['JobTitle']).' - '.stripslashes($values['Department']).'</strong>'; ?>
	
		  </td>
		</tr>
		<? } ?>

    <tr align="left" class="<?=$bgclass?>">
       <td>
	   </td>     
      <td><?=date($Config['DateFormat'].", l",strtotime($values["attDate"]))?></td>
     <td><? if(!empty($values["InTime"])) echo date($Config['TimeFormat'],strtotime($values["InTime"])); ?></td>
      <td><? if(!empty($values["OutTime"])) echo date($Config['TimeFormat'],strtotime($values["OutTime"]));?></td>
      <td><?=($Duration!=0)?($Duration):('')?>


</td>
  
    </tr>
	

    <?php 
	$TotalShortLeave ++;
	
	$NewEmpID = $values['EmpID'];
  } // foreach end //?>
  
	<? if($TotalShortLeave>0){?>
	 <tr class="evenbg">
	  <td  colspan="8" align="right" >
	   <strong>Total Short Leaves : <?=$TotalShortLeave?></strong>
	  </td>
	</tr>
	<? } ?>




    <?php }else{?>
    <tr >
      <td  colspan="7" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
 <tr >  <td  colspan="7" align="left" id="td_pager">
 
 <? if($_GET['emp']>0 && $TotalDuration>0){ ?>
	<!--div align="right"><strong> Total ShortLeave Hours : <?=GetHourMinute($TotalShortLeave)?>&nbsp;&nbsp;&nbsp;&nbsp;  </strong></div-->
<? }else{ ?>
Total Record(s) : &nbsp;<?php echo $num;?>     <!-- <?php if(count($arryShortLeave)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink; }?>
-->
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


<? //include("includes/html/box/att_detail.php"); ?>
