 <? if($_GET['t']>0){
  $arryTrainingDt = $objTraining->GetTraining($_GET['t'],''); ?>
 <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >
	 <tr>
		 <td colspan="4" align="left" class="head">Training Detail
		 
		 <!--a href="vTraining.php?p=1&view=<?=$_GET['t']?>" target="_blank" style="float:right">More Info</a-->
		 </td>
	</tr>   
	  
	  <tr>
		  <td align="left" class="blackbold">Training ID : </td>
		  <td align="left" ><?=$arryTrainingDt[0]["trainingID"]?></td>
		   <td align="left" class="blackbold">Course Name : </td>
		  <td align="left" ><?=stripslashes($arryTrainingDt[0]['CourseName'])?> </td>
   </tr> 
   
   <tr>
		  <td align="left" class="blackbold" width="13%">Coordinator : </td>
		  <td align="left" width="46%" ><a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryTrainingDt[0]['Coordinator']?>" ><?=stripslashes($arryTrainingDt[0]['CoordinatorName'])?></a>	 </td>
		  <td align="left" class="blackbold" width="13%">Company : </td>
		  <td align="left" ><?=stripslashes($arryTrainingDt[0]['Company'])?>	 </td>
		  
   </tr>
	  <tr>
		  <td align="left" class="blackbold">Training Date : </td>
		  <td align="left" > 
	<? if($arryTrainingDt[0]['trainingDate']>0){
	  echo date($Config['DateFormat'], strtotime($arryTrainingDt[0]['trainingDate'])); 
	}else{
		echo NOT_SPECIFIED;
	}
	 ?></td>
		   
		<td align="left" class="blackbold">Training Time : </td>
		  <td align="left" > 
		  <?=(!empty($arryTrainingDt[0]['trainingTime']))?($arryTrainingDt[0]['trainingTime']):(NOT_SPECIFIED)?>
 </td>
   </tr>  
   
 <tr>
		  <td align="left" class="blackbold">Training Location :  </td>
		  <td align="left" ><?=nl2br(stripslashes($arryTrainingDt[0]['Address']))?> </td>
		   <td align="left" class="blackbold">Topic : </td>
		  <td align="left" >
		 <?=(!empty($arryTrainingDt[0]['Topic']))?($arryTrainingDt[0]['Topic']):(NOT_SPECIFIED)?> </td>
   </tr> 

</table>
<? } ?>