<?
if($_GET["view"]>0){
	$TableWidth = '100%';
}else{
	$TableWidth = '350';
}
?>

<table width="<?=$TableWidth?>" border="0" cellpadding="5" cellspacing="0" class="borderall" style="margin:0">
  
	<tr>
        <td  align="right" class="blackbold" width="45%"> Training ID : </td>
        <td   align="left"><?=stripslashes($arryTraining[0]['trainingID'])?></td>
      </tr>


	<tr>
        <td  align="right" class="blackbold" > Course Name  : </td>
        <td   align="left"><?php echo stripslashes($arryTraining[0]['CourseName']); ?></td>
      </tr>

	   <tr>
        <td  align="right" class="blackbold"> Company  : </td>
        <td   align="left"><?php echo stripslashes($arryTraining[0]['Company']); ?></td>
      </tr>
	 
	   <tr>
        <td  align="right"> Training Date :  </td>
        <td   align="left">
	<? if($arryTraining[0]['trainingDate']>0){
	  echo date($Config['DateFormat'], strtotime($arryTraining[0]['trainingDate'])); 
	}else{
		echo NOT_SPECIFIED;
	}
	 ?>
		
		</td>
      </tr> 

	  
 <tr>
        <td  align="right"  class="blackbold" > Training Time : </td>
        <td   align="left">
	<?=(!empty($arryTraining[0]['trainingTime']))?($arryTraining[0]['trainingTime']):(NOT_SPECIFIED)?>
		
		
		</td>
      </tr>

 <tr>
        <td align="right" class="blackbold" >Coordinator  :</td>
        <td   align="left">
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryTraining[0]['Coordinator']?>" ><?=stripslashes($arryTraining[0]['CoordinatorName'])?></a>	 
	
		
		</td>
      </tr>	

        <tr>
          <td align="right"   class="blackbold" valign="top">Training Location  :</td>
          <td  align="left" ><?=nl2br(stripslashes($arryTraining[0]['Address']))?> </td>
        </tr>
         
	  <tr>
        <td align="right"   class="blackbold" >Cost  :</td>
        <td  align="left"  >
	<?
	if($arryTraining[0]['Cost']>0){
		echo number_format($arryTraining[0]['Cost']).' '.$Config['Currency'];
	 }else{
		 echo NOT_SPECIFIED;
	 }
	?>
			</td>
      </tr> 
  <tr>
        <td align="right"   class="blackbold" >Topic  :</td>
        <td  align="left"  >
	<?=(!empty($arryTraining[0]['Topic']))?($arryTraining[0]['Topic']):(NOT_SPECIFIED)?>
	</td>
      </tr> 

  <tr>
          <td align="right"   class="blackbold" valign="top">Description  :</td>
            <td  align="left" >
		<?=(!empty($arryTraining[0]['detail']))?(nl2br(stripslashes($arryTraining[0]['detail']))):(NOT_SPECIFIED)?>
		 </td>
        </tr>


<tr>
    <td align="right" valign="top"   class="blackbold" >  Document   :</td>
    <td  align="left" valign="top" >
	
	
	<? 
       if($arryTraining[0]['document'] !='' && IsFileExist($Config['TrainingDir'],$arryTraining[0]['document']) ){  ?>
	<div id="documentDiv">
	<?=$arryTraining[0]['document']?>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="../download.php?file=<?=$arryTraining[0]['document']?>&folder=<?=$Config['TrainingDir']?>" title="<?=$arryTraining[0]['document']?>" class="download">Download</a>
	</div>
	
<?	}else{ echo NOT_UPLOADED; } ?>		
	
	</td>
  </tr>


	  
	
	
	<tr>
                      <td align="right"  class="blackbold">Status : </td>
                      <td align="left" >

<? if($arryTraining[0]['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }
		 echo $status;
		 ?>
                                                 </td>
                    </tr>
	
</table>	
