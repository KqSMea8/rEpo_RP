 <script language="javascript">
  	$(document).ready(function() {
		$("#Department").change(function(){
			$("#preview_div").hide();
			$(".print_button").hide();
			$(".export_button").hide();
			
		});
	});
</script>


<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(frm){
	document.getElementById("emp").value='';
	if(document.getElementById("EmpID") != null){
		document.getElementById("emp").value = document.getElementById("EmpID").value;
	}
	
	ShowHideLoader('1','P');
	return true;	
	
	/*
	if(ValidateForSelect(frm.Department, "Department") 
		&& ValidateForSelect(frm.emp, "Employee") 
	){
			ShowHideLoader('1','P');
			return true;	
	}else{
		return false;	
	}*/
	
	
}
</script>
<div class="had"><?=$MainModuleName?></div>



<div id="ListingRecords">


<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">

 <tr>
	  <td  valign="top">
	 
	
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch(this);">
	 <table  border="0" cellpadding="3" cellspacing="0"  id="search_table" style="margin:0" >

		<tr>
		 <td>Department :</td>
		<td align="left" >
		<select name="Department" class="textbox" id="Department" onChange="Javascript:EmpListSend('1','');">
		  <option value="">--- All ---</option>
		  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
		  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$_GET['Department']){echo "selected";}?>>
		  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
		 <td>&nbsp;</td> 
		<td>
		<div id="EmpTitle">Employee :</div>
		<div id="EmpValue"></div> 	
		</td>

		 <!--td>&nbsp;</td> 
			 
          <td>Leave Type :</td>
          <td>            
               <select name="ltype" class="textbox" id="ltype">
					<option value="">--- All ---</option>
					<? for($i=0;$i<sizeof($arryLeaveType);$i++) {?>
						<option value="<?=$arryLeaveType[$i]['attribute_value']?>" <?  if($arryLeaveType[$i]['attribute_value']==$_GET['ltype']){echo "selected";}?>>
						<?=$arryLeaveType[$i]['attribute_value']?>
						</option>
					<? } ?>
				</select>        
			   </td-->
		 <td>
		 
		 <input name="s" type="submit" class="search_button" value="Go"  />
		<input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$_GET['emp']?>" />	
		<input type="hidden" name="emp" id="emp" value="<?=$_GET['emp']?>">
		 
		 </td> 
		  
        </tr>
</table>
 	</form>

<script language="javascript">
EmpListSend('1','');
</script>




 <? if($_GET['emp']>0){ ?>
 <br><br>
	  <div id="print_export">
	<!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_leave_report.php?<?=$QueryString?>';" -->
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	</div> 
	<div class="cb"></div>
	<? } ?>

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div" >
<? if($_GET['emp']>0 && $HideSibmit!=1){ ?>
<br>
<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td class="head1" >Leave Type</td>
       <td width="20%"  class="head1">Entitlements (Days)</td>
       <td width="20%"  class="head1" >Pending Approval (Days)</td>
     <td width="20%"  class="head1" >Approved/Taken (Days)</td>
    <td width="20%"  class="head1" >Leave Balance (Days)</td>
    </tr>
   
    <?php 
  if(is_array($arryLeave)){

	$flag=true;
	$Line=0;
	$TotalEntitle=0; $TotalPending=0; $TotalApproved=0; $TotalBalance=0;
	foreach($arryLeave as $key=>$values){
	$flag=!$flag;
	$Line++;
	
	if($arryEmp[0]['LeaveAccrual']==1){ 
		$EntitleDays = 	$arryFinalLeave[$values["attribute_value"]];
		
	}else{
		$EntitleDays = $objLeave->getLeaveEntitle($_GET['emp'],$values["attribute_value"]);
	}



 	$PendingLeave = $objLeave->getLeaveByStatus($_GET['emp'],"'Pending'",$values["attribute_value"]);
  	$ApprovedLeave = $objLeave->getLeaveByStatus($_GET['emp'],"'Approved','Taken'",$values["attribute_value"]);
	$Balance = 0;
	//if($EntitleDays>0){
		$Balance = $EntitleDays - $ApprovedLeave;
		//if($Balance<=0) $Balance = 0;
	//}
?>
    <tr align="left">
      <td><?=$values["attribute_value"]?></td>
      <td><?=$EntitleDays?></td>
      <td><?=$PendingLeave?></td>
      <td><?=$ApprovedLeave?></td>
      <td><?=$Balance?></td>
    </tr>
    <?php 
	$TotalEntitle += $EntitleDays;
	$TotalPending += $PendingLeave;
	$TotalApproved += $ApprovedLeave;
	$TotalBalance += $Balance;
	} // foreach end //?>
  
  
  
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="5" class="no_record" ><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
 <tr id="td_pager">
	<td>Total :</td>
	<td><?=$TotalEntitle?></td>   
	<td><?=$TotalPending?></td>
	<td><?=$TotalApproved?></td>   
	<td><?=$TotalBalance?></td>   
  </tr>
  </table>



<div class="report_chart" >
	<h2><?=$MainModuleName?></h2>
	
	<select name="event" id="event" class="chartselect" onchange="Javascript:showChart(this);" >
	<option value="bChart:pChart">Bar Chart</option>
	<option value="pChart:bChart">Pie Chart</option>
	</select>
	
	<div class="cb3"></div>
	<? echo '<img  id="bChart"  src="barLeave.php?e='.$TotalEntitle.'&p='.$TotalPending.'&a='.$TotalApproved.'&b='.$TotalBalance.'">'; 
	echo '<img  id="pChart" style="display:none" src="pieLeave.php?e='.$TotalEntitle.'&p='.$TotalPending.'&a='.$TotalApproved.'&b='.$TotalBalance.'">'; ?>


</div>





<? }else if($Show==1){ ?>
 <br>
	  <div id="print_export">
	<!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_leave_report.php?<?=$QueryString?>';" -->
<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
	</div> 
	<div class="cb"></div>
	 <br>
<table <?=$table_bg?>>
   
    <tr align="left"  >
		<td class="head1" >Employee</td>
		<td width="18%"  class="head1">Entitlements (Days)</td>
		<td width="20%"  class="head1" >Pending Approval (Days)</td>
		<td width="20%"  class="head1" >Approved/Taken (Days)</td>
		<td width="18%"  class="head1" >Leave Balance (Days)</td>
    </tr>
   
    <?php 
  if(is_array($arryEmployee) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryEmployee as $key=>$values){
	$flag=!$flag;
	$Line++;


	/**************************/
	if($values['LeaveAccrual']==1){ 
		unset($arryEmp);
		$arryEmp=$objEmployee->GetEmployeeBrief($values['EmpID']);
		$arryFinalLeave = $objLeave->getAccrualLeave($arryEmp);
		//echo '<pre>';print_r($arryFinalLeave);exit;
		$LeaveEntitle = 0; $LeaveBalance = 0;
		foreach($arryFinalLeave as $key=>$valuessub){
			$EntitleDays = 	$valuessub;
			$ApprovedLeave = $objLeave->getLeaveByStatus($valuessub['EmpID'],"'Approved','Taken'",$key);
			$Balance = 0;

			$Balance = $EntitleDays - $ApprovedLeave;

			$LeaveEntitle += $EntitleDays;
			$LeaveBalance += $Balance;

		}				
		$EntitleDays = $LeaveEntitle;
	}else{
		$EntitleDays = $objLeave->getLeaveEntitle($values['EmpID'],'');
	}
	/**************************/





 	$PendingLeave = $objLeave->getLeaveByStatus($values['EmpID'],"'Pending'",'');
  	$ApprovedLeave = $objLeave->getLeaveByStatus($values['EmpID'],"'Approved','Taken'",'');
	$Balance = 0;
	//if($EntitleDays>0){
		$Balance = $EntitleDays - $ApprovedLeave;
		//if($Balance<=0) $Balance = 0;
	//}
  ?>
    <tr align="left"  >
 	<td>

		 <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$values['EmpID']?>" ><?=$values['UserName']?></a> [<?=$values["EmpCode"]?>] 
		<? echo '<br>'.stripslashes($values['JobTitle']).' - '.stripslashes($values['Department']).''; 
		?>

	</td>
	<td><?=$EntitleDays?></td>
	<td><?=$PendingLeave?></td>
	<td><?=$ApprovedLeave?></td>
	<td><?=$Balance?></td>
     
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryEmployee)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>




<? } ?>
  </div>
  

  
</form>


</td>
</tr>
</table>

</div>
