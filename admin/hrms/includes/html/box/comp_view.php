


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
        <td  align="right"   class="blackbold"  valign="top" width="45%"> Employee  : </td>
        <td   align="left" >
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryComp[0]['EmpID']?>"><?=stripslashes($arryComp[0]['UserName'])?></a>   
					<br>[<?=stripslashes($arryComp[0]['JobTitle']).' - '.stripslashes($arryComp[0]['Department'])?>]

	</td>
</tr>

     <tr>
          <td align="right"   class="blackbold" valign="top">Working Date  :</td>
          <td  align="left" >
		<?  echo date($Config['DateFormat'].", l", strtotime($arryComp[0]['WorkingDate']));
		?>
		   </td>
        </tr>

  <tr>
		  <td  class="blackbold" valign="top"   align="right" >Working Hours :</td>
		  <td  align="left"   class="blacknormal" valign="top">
<?=$arryComp[0]['Hours']?>
		  
		  </td>
		</tr>
 <tr>
        <td align="right"   class="blackbold" valign="top">Comment :</td>
        <td  align="left"  >
	<?=(!empty($arryComp[0]['Comment']))?(nl2br(stripslashes($arryComp[0]['Comment']))):(NOT_SPECIFIED)?>

		</td>
      </tr>

   <tr>
          <td align="right"   class="blackbold" valign="top">Apply Date  :</td>
          <td  align="left" >
		<? if($arryComp[0]['ApplyDate']>0) echo date($Config['DateFormat'], strtotime($arryComp[0]['ApplyDate'])); ?>
		   
		   
		   </td>
        </tr>

<tr>
        <td  align="right" class="blackbold" >Supervisor Approval  : </td>
        <td   align="left" >
	<? 
		 if($arryComp[0]['SupApproval'] == '1'){
			 $SupApprovalCls = 'green'; $SupApprovedStatus = 'Yes';
		 }else{
			 $SupApprovalCls = 'red'; $SupApprovedStatus = 'Pending';
		 }

		echo '<span class="'.$SupApprovalCls.'">'.$SupApprovedStatus.'</span>';
		?>	

       </td>
</tr>

<tr>
        <td  align="right" class="blackbold" >Approved  : </td>
        <td   align="left" >
	<? 
		 if($arryComp[0]['Approved'] == '1'){
			 $ApprovedCls = 'green'; $ApprovedStatus = 'Yes';
		 }else{
			 $ApprovedCls = 'red'; $ApprovedStatus = 'No';
		 }

		echo '<span class="'.$ApprovedCls.'">'.$ApprovedStatus.'</span>';
		?>	

       </td>
</tr>

<tr>
        <td  align="right" class="blackbold" >Status  : </td>
        <td   align="left">

	<? 
		 if($arryComp[0]['Compensated'] == '1'){
			 $StatusCls = 'green'; 
		 }else if($arryComp[0]['Approved'] == '2'){
			 $StatusCls = 'red';
		 }else{
			 $StatusCls = '';
		 }

		echo '<span class="'.$StatusCls.'">'.$arryComp[0]['Status'].'</span>';
		?>

       </td>
      </tr>

 
	
</table>	
  



