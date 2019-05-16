
<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{ ?>

<div class="had">Leave Detail</div>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
 <!--tr>
                      <td  align="right"   class="blackbold" > 
					 Leave Period :
					  </td>
                      <td  align="left" valign="top">
<? if(!empty($LeaveStart) && !empty($LeaveEnd)){ 
	
	$YearStart = date("Y", strtotime($LeaveStart));
	$YearEnd = date("Y", strtotime($LeaveEnd));

	echo date($Config['DateFormat'], strtotime($LeaveStart))." - ".date($Config['DateFormat'], strtotime($LeaveEnd)); ?>

 	<input type="hidden" name="LeaveStart" id="LeaveStart" value="<?=$LeaveStart?>">   
 	<input type="hidden" name="LeaveEnd" id="LeaveEnd" value="<?=$LeaveEnd?>">   

<? }else{
	$HideSibmit=1;
	echo NOT_SPECIFIED;
}
	?>


					  </td>
    </tr--> 		
<tr>
        <td  align="right"   class="blackbold"  valign="top" width="45%"> Employee  : </td>
        <td   align="left" >
		<!--a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryLeave[0]['EmpID']?>"--><?=stripslashes($arryLeave[0]['UserName'])?>  
					<br>[<?=stripslashes($arryLeave[0]['JobTitle']).' - '.stripslashes($arryLeave[0]['Department'])?>]

	</td>
</tr>

	<tr>
		<td  align="right"   class="blackbold">Leave Type :</td>
		<td align="left">
		<?=$arryLeave[0]['LeaveType']?> 
		
		</td>
	  </tr>	

<tr >
	<td  align="right" class="blackbold">Leave Balance :</td>
	<td align="left">
<div id="LeaveBalance"></div>

<input type="hidden" name="EmpID" id="EmpID" value="<?=$arryLeave[0]['EmpID']?>">
<input type="hidden" name="LeaveType" id="LeaveType" value="<?=$arryLeave[0]['LeaveType']?>">
<script>GetLeaveBalance();</script>
		</td>
  </tr>	 

<tr>
          <td align="right"   class="blackbold" valign="top">From Date  :</td>
          <td  align="left" >
		<?  echo date($Config['DateFormat'], strtotime($arryLeave[0]['FromDate']));
			if($arryLeave[0]['FromDateHalf']==1)echo '&nbsp;&nbsp;&nbsp;[Half Day]'; 
		?>
		   </td>
        </tr>
<tr>
          <td align="right"   class="blackbold" valign="top">To Date  :</td>
          <td  align="left" >
		<?  echo date($Config['DateFormat'], strtotime($arryLeave[0]['ToDate']));
			if($arryLeave[0]['ToDateHalf']==1)echo '&nbsp;&nbsp;&nbsp;[Half Day]'; 
		?>
		   </td>
        </tr>
<tr>
          <td align="right"   class="blackbold" valign="top">Days  :</td>
          <td  align="left" >
		<?=$arryLeave[0]['Days']?>
		   </td>
        </tr>

 <tr>
        <td align="right"   class="blackbold" valign="top">Comment :</td>
        <td  align="left"  >
	<?=(!empty($arryLeave[0]['Comment']))?(nl2br(stripslashes($arryLeave[0]['Comment']))):(NOT_SPECIFIED)?>

		</td>
      </tr>

<? if($arryLeave[0]['ApplyDate']>0){?>				
			 
<tr>
		  <td align="right"  class="blackbold">
		 Applied On :
		  </td>
		  <td align="left">
<?=date($Config['DateFormat'], strtotime($arryLeave[0]["ApplyDate"]))?>

		  </td>
		</tr>
<? } ?>




<? if(sizeof($arryApproval)>0){?>
 <tr>
        <td align="right"   class="blackbold" valign="top">Approval Status :</td>
        <td  align="left"  >
<?
foreach($arryApproval as $key=>$values){

if($values['Status'] == "Approved") $stClass = 'green';
else if($values['Status'] == "Rejected") $stClass = 'red';
else $stClass = '';	 

echo '<span class="'.$stClass.'">'.$values['Status'].'</span> by '.$values['UserName'].'<br>';
}
?>


		</td>
      </tr>

<? } ?>








 <tr>
        <td align="right"   class="blackbold" valign="top"><b>Final Status :</b></td>
        <td  align="left"  >
<?
if($arryLeave[0]['Status'] == "Approved") $stClass = 'green';
else if($arryLeave[0]['Status'] == "Rejected") $stClass = 'red';
else $stClass = '';	 

echo '<span class="'.$stClass.'"><b>'.$arryLeave[0]['Status'].'</b></span>';
?>


		</td>
      </tr>






</table>

<? } ?>

