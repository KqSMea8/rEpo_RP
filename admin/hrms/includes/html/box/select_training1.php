<div id="select_training" style="display:none; width:800px; height:500px;">
<div class="had2">&nbsp;Select Training</div>
<div id="training_load" style="display:none;" align="center"><br><br><br><img src="../images/ajaxloader.gif"></div>
<div id="training_list" style="width:800px; height:470px; overflow:auto">
<table <?=$table_bg?>>
   
    <tr align="left"  >
     <td width="8%" class="head1" align="center">Select</td>
      <td width="10%" class="head1" >Training ID</td>
      <td width="20%"  class="head1" >Course Name</td>
      <td width="20%" class="head1" >Company</td>
      <td class="head1" >Coordinator</td>
      <td width="17%" class="head1"  align="center">Training Date</td>
    </tr>
   
    <?php 
  if(is_array($arryTrainingAll) && $numTraining>0){
  	$flag=true;
	$Line=0;
  	foreach($arryTrainingAll as $key=>$values){
	$flag=!$flag;
	$bgcolor=($_GET['t']==$values["trainingID"])?("#f2f2f2"):("#ffffff");
	$Line++;

  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <td height="20" align="center"><a href="viewParticipant.php?t=<?=$values["trainingID"]?>" onclick="Javascript:SelectTraining();" class="red_bt">Select</a></td>
       <td><?=$values["trainingID"]?></td>
     <td><?=stripslashes($values["CourseName"])?></td>
      <td><?=stripslashes($values["Company"])?></td>
	 <td>
	<?=stripslashes($values['CoordinatorName'])?>
	  
	  </td>
	 
	 <td align="center">  
	 <? if($values['trainingDate']>0){
	  echo date($Config['DateFormat'], strtotime($values['trainingDate'])); 
	} 
	 ?>
     </td> 
	
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_TRAINING?></td>
    </tr>
    <?php } ?>
  
	
  </table>
</div>
  

</div>


<script language="JavaScript1.2" type="text/javascript">
function SelectTraining(){
	document.getElementById("training_list").style.display = 'none';
	document.getElementById("training_load").style.display = 'block';
	document.getElementById("select_training").style.height = '200px';
}

function ShowTrainingList(){

}


</script>
