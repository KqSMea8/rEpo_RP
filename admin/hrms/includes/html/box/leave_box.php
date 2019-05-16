 <? if($_GET['emp']>0){ 
	// Leave Calculation	
	$LeaveEntitled = $objLeave->getLeaveEntitle($_GET['emp'],'');
	$LeaveTakenTotal = $objLeave->getLeaveByStatus($_GET['emp'],"'Approved','Taken'",'');
	$LeaveTakenMonth = $objLeave->getLeaveByMonth($_GET['emp'],$_GET['y'],$_GET['m'],"'Approved','Taken'",'');
	$LeaveBalance = 0;
	$LeaveBalance = $LeaveEntitled - $LeaveTakenTotal;
	
	$NumDayMonth = date('t', strtotime($_GET['y'].'-'.$_GET['m'].'-01'));

	/*****************/
	$arryComp = $objLeave->getActiveComp($_GET['emp'],$_GET['y'],$_GET['m']);
	$TotalComp = sizeof($arryComp);
	if($TotalComp>0){
		$LeaveTakenMonth = $LeaveTakenMonth - $TotalComp;
		foreach($arryComp as $key=>$values){
			$CompIDs .= $values['CompID'].',';
		}
		$CompIDs = rtrim($CompIDs,",");
	}
	/*****************/
	$LeaveMonth = $LeaveTakenMonth;
	$ShortLeave = $objLeave->getShortLeave($_GET['emp'],$_GET['y'],$_GET['m']);

	$ShortLeaveExtra=0; 
	if($ShortLeave>0 && $arryCurrentLocation[0]['SL_Deduct']==1){
		$ShortLeaveExtra = $ShortLeave - $arryCurrentLocation[0]['MaxShortLeave'];
		if($ShortLeaveExtra>0){
			$ShortLeaveExtra = $ShortLeaveExtra/2;
			$LeaveTakenMonth = $LeaveTakenMonth + $ShortLeaveExtra;
		}
	}
	/*****************/
	if($LeaveTakenMonth<=0) $LeaveTakenMonth=0;
  ?>
 <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >
	 <tr>
		 <td colspan="4" align="left" class="head">Leave Detail</td>
	</tr>   
	  
	   <tr>
		  <td align="left" class="blackbold" width="16%">Leave Entitled : </td>
		  <td align="left" width="42%"  >
		  <?=$LeaveEntitled?>		   </td>
		  <td align="left" class="blackbold" width="16%">Working Days : </td>
		  <td width="26%" align="left" ><?=$NumDayMonth?></td>
   </tr>
	   <tr>
		  <td align="left" class="blackbold">Leave Balance : </td>
		  <td align="left" ><?=$LeaveBalance?></td>
		   <td align="left" class="blackbold">Leave :</td>
		  <td align="left" ><?=$LeaveMonth?></td>
		</tr>
	   <tr>
	     <td align="left" class="blackbold">Total Leave Taken :</td>
	     <td align="left" ><?=$LeaveTakenTotal?></td>		 
	     <td align="left" class="blackbold"> Exempt :</td>
	     <td align="left" ><?=!empty($arryEmployeeDt[0]['LeaveExempt'])?('Yes'):('No')?></td>	
   </tr>
  <? if(!empty($ShortLeave)){ ?>
  <tr>
	     <td align="left" class="blackbold">Short Leave :</td>
	     <td align="left" ><?=$ShortLeave?></td>
	     <td align="left" class="blackbold">Total Leave :</td>
	     <td align="left" ><?=$LeaveTakenMonth?></td>
		
   </tr>
  <? } ?>
  <? if(!empty($arrySalary[0]['payID'])){ ?>
  <tr>
	     <td align="left" class="blackbold"></td>
	     <td align="left" ></td>
	     <td align="left" class="blackbold">Leave Deducted :</td>
	     <td align="left" ><?=($arrySalary[0]['LeaveDeducted']>0)?($arrySalary[0]['LeaveDeducted']):('0')?></td>
		
   </tr>
  <? } ?>
	  </table>
<? } ?>
