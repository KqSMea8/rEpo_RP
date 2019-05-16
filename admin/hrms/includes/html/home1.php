
<div class="had">Welcome <?=$_SESSION['UserName']?> !</div>
<?

//echo '<img src="bar.php">'; 
//echo 'Employees By Department : <br><img src="bar2.php">'; 
?>

<? if($ShowEmp==1){ ?>

<a href="applyLeave.php">Apply For Leave</a><br />


<table width="300" border="0" cellpadding="5" cellspacing="0" class="borderall" >
<tr>
  <td colspan="2" ><strong>My Information:</strong></td>
</tr>
	  
<tr>
  <td  align="right"   class="blackbold" width="38%"  >Employee  ID  :</td>
  <td   align="left" ><?=$arryEmployee[0]['EmpID']?>  </td>
</tr>
<tr>
        <td  align="right"   class="blackbold"> Name   : </td>
        <td   align="left" >
			<?=stripslashes($arryEmployee[0]['UserName'])?>		</td>
      </tr>
	  <tr>
        <td  align="right"   class="blackbold" >Email Address : </td>
        <td   align="left" ><?=$arryEmployee[0]['Email']?>		</td>
      </tr> 
	  
	<tr>
        <td  align="right"   class="blackbold"> Designation   : </td>
        <td   align="left" >
			<?=stripslashes($arryEmployee[0]['JobTitle'])?>		</td>
      </tr>

  <tr>
        <td  align="right"   class="blackbold"> Department  : </td>
        <td   align="left" >
<?=$arryEmployee[0]['DepartmentName']?>
<?  if($arryEmployee[0]['DeptHead']>0){echo "&nbsp;&nbsp;<b>[Departmental Head]</b>";}?></td>
      </tr>
	
	<tr>
        <td  align="right"   class="blackbold">Employee Category   : </td>
        <td   align="left" >
			<?=stripslashes($arryEmployee[0]['catName'])?>		</td>
      </tr>
	
	  <tr>
        <td align="right"   class="blackbold">Joining Date  :</td>
        <td  align="left" >		
		<? if($arryEmployee[0]['JoiningDate']>0) echo date($Config['DateFormat'], strtotime($arryEmployee[0]['JoiningDate'])); ?>

	</td>
      </tr>
	    
		  
</table>

<br />

<table width="300" border="0" cellpadding="5" cellspacing="0" class="borderall" >
<tr>
  <td colspan="2" ><strong>Reporting:</strong></td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="38%" >Report To : </td>
        <td   align="left" >
		   <? if(!empty($arrySupervisor[0]['UserName'])){ 
		   	  echo $arrySupervisor[0]['UserName']. ' ['.$arrySupervisor[0]['Department'].']';  
		    }else{ 
				echo "Not assigned.";
			} ?>	</td>
      </tr>	  
<tr>
        <td  align="right"   class="blackbold" >Reporting Method : 	</td>
        <td   align="left" ><?=$arryEmployee[0]['ReportingMethod']?>		</td>
   </tr>	  
</table>


 <? 
	$arryLeave = $objCommon->GetAttributeByValue('','LeaveType');
  ?>

<br />
<strong>Leave Summary:</strong>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
       <td class="head1" >Leave Type</td>
       <td width="20%"  class="head1">Entitlements</td>
       <td width="20%"  class="head1" >Pending</td>
     <td width="20%"  class="head1" >Approved/Taken</td>
    <td width="16%"  class="head1" >Balance</td>
    </tr>
   
    <?php 
  if(is_array($arryLeave)){
	$flag=true;
	$Line=0;
	$TotalEntitle=0; $TotalPending=0; $TotalApproved=0; $TotalBalance=0;
	foreach($arryLeave as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	$EntitleDays = $objLeave->getLeaveEntitle($_GET['emp'],$values["attribute_value"]);
 	$PendingLeave = $objLeave->getLeaveByStatus($_GET['emp'],"'Pending'",$values["attribute_value"]);
  	$ApprovedLeave = $objLeave->getLeaveByStatus($_GET['emp'],"'Approved','Taken'",$values["attribute_value"]);
	$Balance = 0;
	//if($EntitleDays>0){
		$Balance = $EntitleDays - $ApprovedLeave;
		//if($Balance<=0) $Balance = 0;
	//}
?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td ><?=$values["attribute_value"]?></td>
      <td ><?=$EntitleDays?></td>
      <td ><?=$PendingLeave?></td>
      <td><?=$ApprovedLeave?></td>
      <td ><?=$Balance?></td>
    </tr>
    <?php 
	$TotalEntitle += $EntitleDays;
	$TotalPending += $PendingLeave;
	$TotalApproved += $ApprovedLeave;
	$TotalBalance += $Balance;
	} // foreach end //?>
  
  
  
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
 <tr >
	<td>Total :</td>
	<td><?=$TotalEntitle?></td>   
	<td><?=$TotalPending?></td>
	<td><?=$TotalApproved?></td>   
	<td><?=$TotalBalance?></td>   
  </tr>
  </table>


<? } ?> 




<?

$TodayDate = '2012-04-15 23:59:55';
$arryTime = explode(" ",$TodayDate);

$arryTime2 = explode(":",$arryTime[1]);
?>

<!--
<br><br>

<input type="text" class="textbox" size="10"  maxlength="10" name="DateBox" id="DateBox" value="<?=$arryTime[0]?>" readonly=""> : 

<br><br>

<input type="text" class="textbox" size="5"  maxlength="2" name="HourBox" id="HourBox" value="<?=$arryTime2[0]?>" readonly=""> : 
<input type="text" class="textbox" size="5" maxlength="2" name="MinBox" id="MinBox" value="<?=$arryTime2[1]?>" readonly=""> : 
<input type="text" class="textbox" size="5" maxlength="2" name="SecBox" id="SecBox" value="<?=$arryTime2[2]?>" readonly=""> 
-->
<div align="center" style="padding-top:30px;"><img src="../images/erp.jpg" /></div>

<SCRIPT LANGUAGE=JAVASCRIPT>
//StartTimer();
function StartTimer(){
	/*
	var CurrentDate = document.getElementById("DateBox").value;
	var dateString = CurrentDate; //"2013-10-25";
	var myDate = new Date(dateString);
	myDate.setDate(myDate.getDate() + 1);

	alert(myDate.getFullYear()+'-'+myDate.getMonth()+'-'+myDate.getDate());
	*/
	var Hour = parseInt(document.getElementById("HourBox").value);
	var Minute = parseInt(document.getElementById("MinBox").value);
	var Second = parseInt(document.getElementById("SecBox").value);
	
	if(Second!='' && !isNaN(Second)){
		var Second = parseInt(Second) + 1;
	}else{
		var Second = 1;
	}

	if(Second>59){
		Minute = parseInt(Minute) + 1;
		Second = 0;
	}

	if(Minute>59){
		Hour = parseInt(Hour) + 1;
		Minute = 0;
	}

	if(Hour>23){
		Hour = 0;
	}
	

	if(Second<10){ Second = '0'+Second; }
	if(Minute<10){ Minute = '0'+Minute;}
	if(Hour<10) Hour = '0'+Hour;

	document.getElementById("HourBox").value = Hour;
	document.getElementById("MinBox").value = Minute;
	document.getElementById("SecBox").value = Second;


	window.setTimeout(StartTimer,1000);
}
</SCRIPT>