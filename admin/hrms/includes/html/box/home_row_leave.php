<?php 
	/**************************************************/
	$ThisPageName = 'myLeave.php'; 
	/**************************************************/

	//if($arryCurrentLocation[0]['Advance']==1){
	foreach($arryCurrentLocation[0] as $key=>$values){
		$Config[$key] = $values;
	}


	if($_SESSION['AdminType'] == "employee") { 
		$arryEmployee = $objEmployee->GetEmployee($_SESSION['AdminID'],'');
		$Config['LeaveApplyToMe'] = 1;
		if($arryEmployee[0]['Department']>0 && ($arryEmployee[0]['DeptHead']=='1' || $arryEmployee[0]['OtherHead']=='1')){
			$arryLeave=$objLeave->GetLeaveByDepartment($arryEmployee[0]['Department']);
			$num=sizeof($arryLeave);
		}

	}

	$pagerLink=$objPager->getPager($arryLeave,20,$_GET['curP']);
	(count($arryLeave)>0)?($arryLeave=$objPager->getPageRecords()):("");

?>

<script language="JavaScript1.2" type="text/javascript">

	function ShowListing(){
		ShowHideLoader('1','L');	
		location.href = "viewLeave.php?d="+document.getElementById("Department").value;
	}


	function ValidateSearch(){	
		var FromDate = document.getElementById("FromDate").value;
		var ToDate = document.getElementById("ToDate").value;
		if(ToDate!='' && FromDate!=''){
			if(ToDate < FromDate){
				alert("From Date should not be geater than To Date.");
				document.getElementById("FromDate").focus();
				return false;
			}
		}

		ShowHideLoader('1','F');
		/*document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';*/
		
	}
</script>

<div class="rows clearfix" >

          <div class="first_col" style="width:700px;">
            <div class="block reporting">
				
              <h3>Leave Applied to Me</h3>
			   <div class="bgwhite" style="width:99%;height:270px;overflow-y:auto;">
			   
		 <table width="100%" border="0" cellspacing="0" cellpadding="0">
   
    <tr align="left"  >
       <td >Employee</td>
    <td>Leave Type</td>
       <td>From Date</td>
     <td>To Date</td>
     <td>Days</td>
    <td>Applied On</td>
     <td>Final Status</td>
   
    </tr>
   
    <?php 
  if(is_array($arryLeave) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryLeave as $key=>$values){
	$flag=!$flag;
	$Line++;

	 if($values['Status'] == "Approved"){
		 $stClass = 'green';
	 }else if($values['Status'] == "Rejected"){
		 $stClass = 'red';
	 }else {$stClass = '';}

	$arryApproval = $objLeave->CheckLeaveApproval($values['LeaveID'],$_SESSION['AdminID']);
  ?>
    <tr align="left" >
      <td >
 
	 <a href="leaveApplied.php"><?=stripslashes($values['UserName'])?></a>
	  </td>

     <td><?=$values["LeaveType"]?></td>
      <td> <? if($values["FromDate"]>0) echo date($Config['DateFormat'], strtotime($values["FromDate"])); ?></td>
      <td> <? if($values["ToDate"]>0) echo date($Config['DateFormat'], strtotime($values["ToDate"])); ?></td>
        <td><?=$values["Days"]?></td>
      <td> <? if($values["ApplyDate"]>0) echo date($Config['DateFormat'], strtotime($values["ApplyDate"])); ?></td>
      <td class="<?=$stClass?>"><?=$values["Status"]?></td>
 
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
  </table>

			  </div>
			
            </div>
          </div>
          
</div>

