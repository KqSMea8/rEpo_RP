<?
//echo $Config['DateFormat'];
$TodayDate =  $Config['TodayDate']; 
$arryTime = explode(" ",$TodayDate);

$arryTime2 = explode(":",$arryTime[1]);



?>

<!--<SCRIPT LANGUAGE="JavaScript">var clocksize=100;</SCRIPT>
<SCRIPT SRC="http://gheos.net/js/clock.js"></SCRIPT>-->

<!--<div id="clockdiv" style="float:right;">
	<input type="text" class="textbox" style="width:96px;"  maxlength="10" name="DateBox" id="DateBox" value="<?=$arryTime[0]?>" readonly=""> 
	
	<input type="text" class="textbox"   maxlength="2" name="HourBox" id="HourBox" value="<?=$arryTime2[0]?>" readonly=""> : 
	<input type="text" class="textbox"  maxlength="2" name="MinBox" id="MinBox" value="<?=$arryTime2[1]?>" readonly=""> : 
	<input type="text" class="textbox"  maxlength="2" name="SecBox" id="SecBox" value="<?=$arryTime2[2]?>" readonly=""> 
</div>-->



<div class="main-container clearfix">
    <div class="main">
	
      <div class="my-dashboard-nav clearfix">
	  <h4>My Dashboard</h4>

		<?  include("../includes/html/box/clock.php");?>


        <ul class="dashboardul">
		  <? if($ShowEmp==1){ ?>
		  	<li class="asign_leave"><a href="applyLeave.php">Apply For Leave</a></li>
          	<li class="leave_list"><a href="myLeave.php">Leave List</a></li>
			<li class="timesheets"><a href="myTimesheet.php">My Timesheet</a></li>
			<li class="timesheets"><a href="myAttendence.php">My Attendance</a></li>
			<li class="timesheets"><a class="fancybox" href="#punch_form_div" >Punch In/Out</a></li>
		  <? }else{ ?>
		  	<li class="asign_leave"><a href="assignLeave.php">Assign Leave</a></li>
           	<li class="timesheets"><a href="viewEmployee.php">Employees</a></li>
         	<li class="leave_list"><a href="viewLeave.php">Manage Leave</a></li>
			<li class="timesheets"><a href="viewTimesheet.php">Timesheet</a></li>
			<li class="timesheets"><a href="viewAttendence.php">Attendance</a></li>
		  <? } ?>
        </ul>



      </div>
      <div class="my-dashboard clearfix">
        <div class="rows clearfix">
          <div class="first_col">
            <div class="block information">
              <h3>My Information</h3>
			  <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <? if($ShowEmp==1){ ?>
				<tr class="odd">
                  <td>Employee  ID:</td>
                  <td class="darkcolor"><?=$arryEmployee[0]['EmpID']?></td>
                </tr>
                <tr class="even">
                  <td>Name:</td>
                  <td class="darkcolor"><?=stripslashes($arryEmployee[0]['UserName'])?>	</td>
                </tr>
                <tr class="odd">
                  <td>Email:</td>
                  <td class="darkcolor"><?=$arryEmployee[0]['Email']?></td>
                </tr>
                <tr class="even">
                  <td>Designation:</td>
                  <td class="darkcolor"><?=stripslashes($arryEmployee[0]['JobTitle'])?></td>
                </tr>
                <tr class="odd">
                  <td>Department:</td>
                  <td class="darkcolor"><?=$arryEmployee[0]['DepartmentName']?>
<?  if($arryEmployee[0]['DeptHead']>0){echo "&nbsp;&nbsp;<b>[Departmental Head]</b>";}?></td>
                </tr>
                <tr class="even">
                  <td>User Type:</td>
                  <td class="darkcolor"><?=stripslashes($arryEmployee[0]['catName'])?></td>
                </tr>
                <tr class="odd bord_none">
                  <td>Joining Date:</td>
                  <td class="darkcolor">	<? if($arryEmployee[0]['JoiningDate']>0) echo date($Config['DateFormat'], strtotime($arryEmployee[0]['JoiningDate'])); ?></td>
                </tr> 
				 <? }else{ ?>
				 <tr class="odd">
                  <td>User Type:</td>
                  <td class="darkcolor">System Administrator</td>
                </tr>
                <tr class="even">
                  <td>User Name:</td>
                  <td class="darkcolor"><?=stripslashes($arryCompany[0]['DisplayName'])?>	</td>
                </tr>
                <tr class="odd">
                  <td>Email:</td>
                  <td class="darkcolor"><?=$arryCompany[0]['Email']?></td>
                </tr>
				 <tr class="even">
                  <td>Company Name:</td>
                  <td class="darkcolor"><?=stripslashes($arryCompany[0]['CompanyName'])?>	</td>
                </tr>
				 <? } ?>

				 <? if(!empty($LastLoginTime555)){ ?>
				 <tr class="even">
                  <td>Last Login:</td>
                  <td class="darkcolor"><?=date($Config['DateFormat'].' H:i:s', strtotime($LastLoginTime))?>	</td>
                </tr>
				<? } ?>
				 
              </table></div>
			
            </div>
          </div>
          <div class="second_col" style="display:none44">
            <div class="block alerts">
              <h3>Employees By Department</h3>
			<div style="border: 1px solid #E1E1E1;padding:10px;width:360px;background:#fff;"><img src="barD.php" ></div>
            </div>
          </div>
          <div class="third_col" style="display:none55">
            <div class="block status_updates">
              <h3>My Status Updates</h3>
              <div class="bgwhite">
                <form>
                  <label>Post Status Updates</label>
                  <textarea name="" cols="" rows="" ></textarea>
                  <input name="" class="button" type="submit" value="Post" />
                </form>
                <div class="post_view clearfix">
                  <div class="img"><a href="£"><img src="../images/noman.gif" alt="" /></a></div>
                  <div class="view"> <span class="icon"></span>
                    <h6>System Administrator says:</h6>
                    <span class="time">6 months, 1 week ago</span>
                    <div class="welcome">Welcome to WebHR...</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		
		 <? if($ShowEmp==1){ ?>
        <div class="rows clearfix" >
          <div class="first_col" style="display:none55">
            <div class="block reporting">
				
              <h3>Reporting</h3>
			   <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>Report To:</td>
                  <td><span class="reo_name"></span>
			 <? if(!empty($arrySupervisor[0]['UserName'])){ 
		   	  echo $arrySupervisor[0]['UserName']; //. ' ['.$arrySupervisor[0]['Department'].']';  
		    }else{ 
				echo NOT_ASSIGNED;
			} ?></td>
                </tr>
              <? if(!empty($arryEmployee[0]['ReportingMethod'])){ ?>
                <tr class="bord_none">
                  <td>Reporting Method:</td>
                  <td><?=$arryEmployee[0]['ReportingMethod']?> </td>
                </tr>
				<? } ?>
              </table>
			  </div>
			
            </div>
          </div>
          <div class="second_col" style="display:none555">
            <div class="block thingstodo">
			
              <h3>Leave Summary</h3>
	 <div class="bgwhite"  style="width:380px"	>		  
   <table width="100%" border="0" cellspacing="0" cellpadding="0" >
    <tr >
		<td>Type</td>
		<td width="20%">Entitlements</td>
		<td width="20%">Pending</td>
		<td width="20%">Approved</td>
		<td width="16%">Balance</td>
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
  
   <tr >
	<td>Total :</td>
	<td><?=$TotalEntitle?></td>   
	<td><?=$TotalPending?></td>
	<td><?=$TotalApproved?></td>   
	<td><?=$TotalBalance?></td>   
  </tr>
  
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  

  </table>
</div>

			  
            </div>
          </div>
          <div class="third_col" style="display:none555">
            <div class="block today_task">
              <h3>Today’s Taks</h3>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><span class="today_t"></span>No taks today...</td>
                </tr>
                <tr>
                  <td><span class="my_calendar"></span>My Calendar</td>
                </tr>
                <tr class="bord_none">
                  <td><span class="team_calendar"></span>My Team Calendar</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
		<? } ?>
		
		
        <div class="rows clearfix" style="display:none">
          <div class="first_col">
            <div class="block p_l_request">
              <h3>Pending Leave Request</h3>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>John Smith link will come here</td>
                </tr>
                <tr>
                  <td><a href="#">Nicky Silverstone link will come here</a></td>
                </tr>
                <tr>
                  <td>Anthony Nolan link will come here</td>
                </tr>
                <tr>
                  <td>John Smith link will come hereKevin Mathews</td>
                </tr>
                <tr class="bord_none">
                  <td>John Smith link will come here</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="second_col">
            <div class="block p_timesheets">
              <h3>Pending Timesheets</h3>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>John Smith link will come here</td>
                </tr>
                <tr>
                  <td>Nicky Silverstone link will come here</td>
                </tr>
                <tr>
                  <td>Anthony Nolan link will come here</td>
                </tr>
                <tr>
                  <td>John Smith link will come hereKevin Mathews</td>
                </tr>
                <tr class="bord_none">
                  <td>John Smith link will come here</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="third_col">
            <div class="block s_interviews">
              <h3>Scheduled Interviews</h3>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>John Smith link will come here</td>
                </tr>
                <tr>
                  <td>Nicky Silverstone link will come here</td>
                </tr>
                <tr>
                  <td>Anthony Nolan link will come here</td>
                </tr>
                <tr>
                  <td>John Smith link will come hereKevin Mathews</td>
                </tr>
                <tr class="bord_none">
                  <td>John Smith link will come here</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<? 
	if($_SESSION['AdminType'] == "employee") { 
		include("includes/html/box/punch_form.php"); 
	}
?>

<SCRIPT LANGUAGE=JAVASCRIPT>
//StartTimer();
function StartTimer(){

	var CurrentDate = document.getElementById("DateBox").value;
	var today = new Date(CurrentDate);
	var tomorrow = new Date(today.getTime() + (24 * 60 * 60 * 1000));

	var TomYear = tomorrow.getFullYear();
	var TomMonth = parseInt(tomorrow.getMonth())+1;
	var TomDay = tomorrow.getDate();

	if(TomMonth<10){ TomMonth = '0'+TomMonth; }
	if(TomDay<10){ TomDay = '0'+TomDay;}

	var NextDay = TomYear+'-'+TomMonth+'-'+TomDay;
	
	/***********************/

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
	
	/*
	if(Hour > 12){
        Hour = (Hour - 12);
        var ampm = "PM";
    }
    else{
        var ampm = "AM";
    }*/





	if(Second<10){ Second = '0'+Second; }
	if(Minute<10){ Minute = '0'+Minute;}
	if(Hour<10) Hour = '0'+Hour;

	document.getElementById("HourBox").value = Hour;
	document.getElementById("MinBox").value = Minute;
	document.getElementById("SecBox").value = Second;

	//document.getElementById("ampm").value = ampm;

	if(Hour=='00' && Minute=='00' && Second=='00'){
		document.getElementById("DateBox").value = NextDay;
	}

	window.setTimeout(StartTimer,1000);
}
</SCRIPT>