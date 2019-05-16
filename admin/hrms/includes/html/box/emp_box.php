 <?  if($_GET['emp']>0){
  $arryEmployeeDt = $objEmployee->GetEmployee($_GET['emp'],''); ?>
 <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >
	 <tr>
		 <td colspan="4" align="left" class="head">Employee Profile</td>
	</tr>   
	  
	   <tr>
		  <td align="left" class="blackbold" width="16%">Employee Name : </td>
		  <td align="left" width="42%" >
		  <? if($HideNavigation==1){ echo stripslashes($arryEmployeeDt[0]['UserName']);} else {?>
		  <a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryEmployeeDt[0]['EmpID']?>" ><?=stripslashes($arryEmployeeDt[0]['UserName'])?></a>
		  <? } ?>
		  </td>
		  <td align="left" class="blackbold" width="16%">Employee Code :</td>
		  <td align="left" ><?=stripslashes($arryEmployeeDt[0]['EmpCode'])?></td>
		  
   </tr>
	   <tr>
		  <td align="left" class="blackbold">Designation : </td>
		  <td align="left" ><?=stripslashes($arryEmployeeDt[0]['JobTitle'])?></td>
		   <td align="left" class="blackbold">Department : </td>
		  <td align="left" ><?=stripslashes($arryEmployeeDt[0]['DepartmentName'])?> </td>
   </tr>

  
    <tr>
		  <td align="left" class="blackbold">Category : </td>
		  <td align="left" >
		  <?=(!empty($arryEmployeeDt[0]['catName']))?($arryEmployeeDt[0]['catName']):(NOT_SPECIFIED)?>
		 </td>
		   <? if($arryCurrentLocation[0]['country_id']!=106 && !empty($arryEmployeeDt[0]['SSN'])){ ?>
		   <td align="left" class="blackbold">SS Number :  </td>
		  <td align="left" >

	<?  
	    if(!empty($arryEmployeeDt[0]['SSN'])){
		 $SSNLength = strlen($arryEmployeeDt[0]['SSN']);
		if($SSNLength>5){
			echo 'xxx-xx-'.substr($arryEmployeeDt[0]['SSN'],5,$SSNLength);
		}else{
			echo $arryEmployee[0]['SSN'];
		}
	    }

	?>


	</td> 
		  <? }  ?>
   </tr>	
 
</table>
<? } ?>
