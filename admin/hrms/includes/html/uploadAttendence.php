<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{

	if(!ValidateForSelect(frm.Year, "Year")){
		return false;	
	}
	if(!ValidateForSelect(frm.Month, "Month")){
		return false;	
	}
	var SelMonth = frm.Year.value + frm.Month.value;
	var CurrMonth = frm.ThisMonth.value;
	
	if(SelMonth > CurrMonth){
		alert("Selected month is greater than current month.");
		return false;	
	}
		
	if( ValidateMandExcel(frm.excel_file,"Please upload attendance sheet in excel format.")
		//&& ValidateMandNumField2(frm.SheetNo,"Row No.",1,99)
		//&& ValidateMandNumField2(frm.RowNo,"Row No.",1,100)
 	){
		
		ShowHideLoader('1','P');
		return true;	
	}else{
		return false;	
	}
	
}
</SCRIPT>
<a href="viewAttendence.php" class="back" >Back</a>

<a href="../down.php?file=hrms/upload/attendance/AttendanceTemplate.xls" class="download" style="float:right">Download Template</a> 


<div class="had"><?=$MainModuleName?> &raquo; <span>
Upload Attendance Sheet
</span>
</div>

<!--br><a href="attTemplate.php" class="download" style="float:right">Sample Data Template</a><br><br-->

<div class="message"><? if(!empty($_SESSION['mess_att'])) {echo $_SESSION['mess_att']; unset($_SESSION['mess_att']); }?></div>

<div align="center" id="ErrorMsg" class="redmsg"><br><?=$ErrorMsg?></div>


<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	
	
		



<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  >

				  <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                   

					 <tr>
                      <td  class="blackbold" valign="top"   align="right">Today's Date :</td>
                      <td  align="left"   class="blacknormal" valign="top">
					  <?=date($Config['DateFormat'],strtotime($Config['TodayDate']))?>

<?  

	$TodayDate =  $Config['TodayDate']; 
	$arryTime = explode(" ",$TodayDate);
	$arryMonth = explode("-",$arryTime[0]);

	$ThisMonth = $arryMonth[0].$arryMonth[1];


	(empty($_POST['Year']))?($_POST['Year']=""):("");
	(empty($_POST['Month']))?($_POST['Month']=""):("");
?>

 <input name="ThisMonth" id="ThisMonth" type="hidden" value="<?=$ThisMonth?>" />

					  </td>
                    </tr>


                    <tr>
                      <td  class="blackbold" valign="top"   align="right" width="45%">Year :<span class="red">*</span></td>
                      <td  align="left"   class="blacknormal" valign="top">
					<?=getYears($_POST['Year'],"Year","textbox")?>
					  
					  </td>
                    </tr>
					 <tr>
                      <td  class="blackbold" valign="top"   align="right">Month :<span class="red">*</span></td>
                      <td  align="left"   class="blacknormal" valign="top">
					<?=getMonths($_POST['Month'],"Month","textbox")?>
					  
					  </td>
                    </tr>

                    <tr>
                    <td  class="blackbold" valign="top"   align="right"> Upload Attendance Sheet :<span class="red">*</span></td>
                    <td  align="left"   class="blacknormal" valign="top" height="80"><input name="excel_file" type="file" class="inputbox"  id="excel_file"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
					<br>
					<?=ATT_SHEET_FORMAT_MSG?>
	                 </td>
					</tr>	

				 <tr style="display:none">
                      <td  class="blackbold" valign="top"   align="right">Select Sheet To Read :<span class="red">*</span></td>
                      <td  align="left"   class="blacknormal" valign="top">

		<? if(empty($_POST['SheetNo'])) $_POST['SheetNo']=1;?>
		<input  name="SheetNo" id="SheetNo" type="text" class="textbox" size="3" maxlength="2" value="<?=$_POST['SheetNo']?>"  onkeypress="return isNumberKey(event);" />

							  
					  </td>
                    </tr>
								  
		<tr style="display:none">
                      <td  class="blackbold" valign="top"   align="right"> Read From Row No.:<span class="red">*</span></td>
                      <td  align="left"   class="blacknormal" valign="top">
		<? if(empty($_POST['RowNo'])) $_POST['RowNo']=3;?>
		<input  name="RowNo" id="RowNo" type="text" class="textbox" size="3" maxlength="3" value="<?=$_POST['RowNo']?>"  onkeypress="return isNumberKey(event);" />
					  
					  </td>
                    </tr>

		<tr>
                      <td  class="blackbold" valign="top"   align="right"> Note :</td>
                      <td  align="left"   class="blacknormal" valign="top">

<?
echo '<table width="100%" border="0" cellpadding="0" cellspacing="1" class="borderall" >';

if($numShift>0){
	echo '<tr><td colspan="2">'.ATT_SHIFT_NOTE.'</td></tr>';	
}else{
	
	$Duration =  strtotime($arryGlobal[0]['WorkingHourEnd']) - strtotime($arryGlobal[0]['WorkingHourStart']);
	$FinalDuration = time_diff($Duration);

  echo '<tr><td  align="right"  class="blackbold">
	Working Hour Start :
	</td>
     <td>'.$arryGlobal[0]['WorkingHourStart'].'</td>
    </tr>
    <tr> <td  align="right"   class="blackbold"> 
	Working Hour End :
	</td>
        <td  align="left" valign="top">
	'.$arryGlobal[0]['WorkingHourEnd'].'
	</td>
    </tr>
    <tr><td  align="right"   class="blackbold">Duration : </td>
	<td  align="left" valign="top">'.$FinalDuration.'
	 </td>
    </tr>
   <tr><td  align="right" class="blackbold">Short Leave for Late Coming : </td>
	  <td  align="left" valign="top">'.$arryGlobal[0]['SL_Coming'].'</td>	 
	</tr>
   <tr><td  align="right" class="blackbold">Short Leave for Early Leaving : </td>
	  <td  align="left" valign="top">'.$arryGlobal[0]['SL_Leaving'].'</td>	 
   </tr>	

	';

	

}


$ConvertToHalf = ($arryGlobal[0]['SL_Deduct'] == 1)?(CONVERT_TO_HALF):('');
$Overtime = ($arryGlobal[0]['Overtime'] == 1)?('Yes'):('No');

echo '<tr><td width="50%" align="right" class="blackbold">Minimum Hours for Half Day : </td>
	  <td  align="left" valign="top">'.$arryGlobal[0]['HalfDayHour'].'</td>	 
        </tr>
	<tr><td  align="right" class="blackbold">Minimum Hours for Full Day : </td>
	  <td  align="left" valign="top">'.$arryGlobal[0]['FullDayHour'].'</td>	 
        </tr>
	<tr><td  align="right" class="blackbold">Max Leave Per Month : </td>
	  <td  align="left" valign="top">'.$arryGlobal[0]['MaxLeaveMonth'].'</td>	 
        </tr>
	<tr><td  align="right" class="blackbold">Max Short Leave Per Month : </td>
	  <td  align="left" valign="top">'.$arryGlobal[0]['MaxShortLeave'].'</td>	 
        </tr>
	<tr><td  align="right" class="blackbold" valign="top">For Short Leave :</td>
	  <td  align="left" valign="top">'.$ConvertToHalf.'</td>	 
        </tr>
	<tr><td  align="right" class="blackbold">Label for Leave in attendence sheet : </td>
	  <td  align="left" valign="top">'.$arryGlobal[0]['LableLeave'].'</td>	 
        </tr>
	<tr><td  align="right" class="blackbold">Overtime Activated: </td>
	  <td  align="left" valign="top">'.$Overtime.'</td>	 
        </tr>
	<tr><td  align="right" class="blackbold">Overtime Rate : </td>
	  <td  align="left" valign="top">'.$arryGlobal[0]['OvertimeRate'].'</td>	 
        </tr>
	';

echo '</table>';

?>
					  
			</td>
                    </tr>



                  
                  </table></td>
                </tr>
				 <tr><td align="center">
	 <input name="Submit" type="submit" class="button" value="Upload" />
				  
				  </td></tr> 
				
              </form>
          </table>





</div>
		
<? if($numShift>0){
	include("includes/html/box/work_shift.php");
   }
 ?>
	   

